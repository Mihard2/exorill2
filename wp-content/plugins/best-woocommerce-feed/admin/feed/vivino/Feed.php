<?php

namespace RexTheme\RexShoppingVivinoFeed;

use SimpleXMLElement;


class VivinoFeed  extends \RexTheme\RexShoppingFeed\Feed
{
    protected $attributes;

    protected function init_atts() {
        $this->attributes = array(
            'products' => array(
                'price' => 'Price',
                'product-name' => 'Product name',
                'inventory-count' => 'Inventory count',
                'link' => 'Link',
                'bottles-size' => 'Bottles size',
                'bottles-quantity' => 'Bottles quantity',
                'price-discounted-from' => 'price-discounted-from',
                'price-discounted-until' => 'price-discounted-until',
            ),
            'extras' => array(
                'wine-name' => 'Wine name',
                'acidity' => 'acidity',
                'ageing' => 'ageing',
                'alcohol' => 'alcohol',
                'appellation' => 'appellation',
                'certified-biodynamic' => 'certified-biodynamic',
                'certified-organic' => 'certified-organic',
                'closure' => 'closure',
                'color' => 'color',
                'contains-added-sulfites' => 'contains-added-sulfites',
                'contains-egg-allergens' => 'contains-egg-allergens',
                'contains-milk-allergens' => 'contains-milk-allergens',
                'country' => 'country',
                'decant-for' => 'decant-for',
                'description' => 'description',
                'drinking-temperature' => 'drinking-temperature',
                'drinking-years-from' => 'drinking-years-from',
                'drinking-years-to' => 'drinking-years-to',
                'importer-address' => 'importer-address',
                'kosher' => 'kosher',
                'meshuval' => 'meshuval',
                'non-alcoholic' => 'non-alcoholic',
                'ph' => 'ph',
                'producer' => 'producer',
                'producer-address' => 'producer-address',
                'product-id' => 'product-id',
                'production-size' => 'production-size',
                'residual-sugar' => 'residual-sugar',
                'sweetness' => 'sweetness',
                'varietal' => 'varietal',
                'vegan-friendly' => 'vegan-friendly',
                'vintage' => 'vintage',
                'winemaker' => 'winemaker',
            ),
        );
    }

    /**
     * Adds items to feed
     */
    protected function addItemsToFeed()
    {
        $this->init_atts();
        foreach ($this->items as $item) {

            /** @var SimpleXMLElement $feedItemNode */
            if ( $this->channelName && !empty($this->channelName) ) {
                $feedItemNode = $this->feed->{$this->channelName}->addChild($this->itemlName);
            }else{
                $feedItemNode = $this->feed->addChild($this->itemlName);
            }
            $i=0;
            $bottle_quantity = 1;
            $bottle_size = '750 ml';
            $drinking_years_from = '';
            $drinking_years_to = '';
            foreach ($item->nodes() as $itemNode) {
                if (is_array($itemNode)) {
                    foreach ($itemNode as $node) {
                        $feedItemNode->addChild(str_replace(' ', '_', $node->get('name')), $node->get('value'), $node->get('_namespace'));
                    }
                } else {
                    if(array_key_exists($itemNode->get('name'), $this->attributes['products'])) {
                        if($itemNode->get('name') === 'bottles-size' || $itemNode->get('name') === 'bottles-quantity') {
                            if ($itemNode->get('name') === 'bottles-quantity') {
                                $bottle_size_node = $feedItemNode->addChild('bottles', $itemNode->get('value'));;
                            }
                            else {
                                $bottle_size = $itemNode->get('value');
                                $bottle_size_node->addAttribute('size', $bottle_size);
                            }
                        }else {
                            $itemNode->attachNodeTo($feedItemNode);
                        }
                    }


                    if(array_key_exists($itemNode->get('name'), $this->attributes['extras'])) {
                        if( !empty($feedItemNode->extras)) {
                            $extrasNode = $feedItemNode->extras;
                        }
                        else {
                            $extrasNode = $feedItemNode->addChild('extras');
                        }

                        if ($itemNode->get('name') === 'drinking-years-from' || $itemNode->get('name') === 'drinking-years-to') {
                            if ($itemNode->get('name') === 'drinking-years-from') {
                                $drinking_years_from = $itemNode->get('value');
                            }
                            else {
                                $drinking_years_to = $itemNode->get('value');
                            }
                            if(!isset($extrasNode->{'drinking-years'})) {
                                $bottle_size_node = $extrasNode->addChild('drinking-years');
                                $bottle_size_node->addAttribute('from', $drinking_years_from);
                            }
                            else {
                                $bottle_size_node = $extrasNode->{'drinking-years'};
                                $bottle_size_node->addAttribute('to', $drinking_years_to);
                            }
                        }
                        elseif ($itemNode->get('name') === 'drinking-temperature') {
                            $drinkingTempNode = $extrasNode->addChild('drinking-temperature', $itemNode->get('value'));
                            $drinkingTempNode->addAttribute('scale', 'celsius');

                        }
                        elseif ($itemNode->get('name') === 'production-size') {
                            $drinkingTempNode = $extrasNode->addChild('production-size', $itemNode->get('value'));
                            $drinkingTempNode->addAttribute('unit', 'bottles');

                        }
                        elseif ($itemNode->get('name') === 'residual-sugar' || $itemNode->get('name') === 'acidity') {
                            $drinkingTempNode = $extrasNode->addChild($itemNode->get('name'), $itemNode->get('value'));
                            $drinkingTempNode->addAttribute('unit', 'g/l');

                        }
                        elseif ($itemNode->get('name') === 'decant-for') {
                            $drinkingTempNode = $extrasNode->addChild($itemNode->get('name'), $itemNode->get('value'));
                            $drinkingTempNode->addAttribute('unit', 'hours');

                        }
                        else {
                            $itemNode->attachNodeTo($extrasNode);
                        }
                    }
                }


            }
        }
    }



    /**
     * Generate CSV feed
     *
     * @param bool $batch
     * @param bool $output
     * @return array|\RexTheme\RexShoppingFeed\Item[]|string
     */
    public function asRss($output = false)
    {

        if (ob_get_contents()) ob_end_clean();
        $this->addItemsToFeed();
        $data = $this->feed->asXml();
        if ($output) {
            header('Content-Type: application/xml; charset=utf-8');
            die($data);
        }

        return $data;
    }
}
