<?php

namespace RexTheme\RexYandexShoppingFeed;

use SimpleXMLElement;
use RexTheme\RexYandexShoppingFeed\Item;
use Gregwar\Cache\Cache;

class Feed
{

    /**
     * Define Google Namespace url
     * @var string
     */
    protected $namespace;

    /**
     * [$version description]
     * @var string
     */
    protected $version;

    /**
     * Stores the list of items for the feed
     * @var Item[]
     */
    protected $items = array();

    /**
     * Stores the list of items for the feed
     * @var Item[]
     */
    protected $items_row = array();

    /**
     * [$channelCreated description]
     * @var boolean
     */
    protected $wrapper;

    /**
     * [$channelCreated description]
     * @var boolean
     */
    protected $channelName;


    /**
     * [$channelCreated description]
     * @var boolean
     */
    protected $itemlName;

    /**
     * [$channelCreated description]
     * @var boolean
     */
    protected $channelCreated = false;

    /**
     * The base for the feed
     * @var SimpleXMLElement
     */
    protected $feed = null;

    /**
     * [$title description]
     * @var string
     */
    protected $title = '';


    /**
     * @var string
     */
    protected $company = '';

    /**
     * [$cacheDir description]
     * @var string
     */
    protected $cacheDir = 'cache';

    /**
     * [$description description]
     * @var string
     */
    protected $description = '';

    /**
     * [$link description]
     * @var string
     */
    protected $link = '';


    /**
     * [$datetime]
     * @var string
     */
    protected $datetime = '';


    protected $rss = 'rss';


    protected $stand_alone = false;

    /**
     * Feed constructor
     */
    public function __construct($wrapper = false, $itemlName = 'item', $namespace = null, $version = '', $rss = 'rss', $stand_alone = false, $wrapperel = '')
    {
        $this->namespace   = $namespace;
        $this->version     = $version;
        $this->wrapper     = $wrapper;
        $this->channelName = $wrapperel;
        $this->itemlName   = $itemlName;
        $this->rss         = $rss;
        $date = "date='" . date("Y-m-d h:i")."'";
        $this->feed = new SimpleXMLElement("<$rss $date ></$rss>");

    }

    /**
     * @param string $title
     */
    public function title($title)
    {
        $this->title = (string)$title;
    }


    /**
     * @param string $title
     */
    public function company($company)
    {
        $this->company = (string)$company;
    }

    /**
     * @param string $description
     */
    public function description($description)
    {
        $this->description = (string)$description;
    }

    /**
     * @param string $link
     */
    public function link($link)
    {
        $this->link = (string)$link;
    }


    /**
     * @param string $link
     */
    public function datetime($datetime)
    {
        $this->datetime = (string)$datetime;
    }

    /**
     * [channel description]
     */
    private function channel()
    {

        if (! $this->channelCreated ) {
            $channel = $this->feed->addChild('shop');
            $channel->addChild('name', htmlspecialchars($this->title));
            $channel->addChild('company', htmlspecialchars($this->company));
            $channel->addChild('url', htmlspecialchars($this->link));
            $channel->addChild('description', htmlspecialchars($this->description));
            $currencies = $this->feed->shop->addChild('currencies');
            $currency = $currencies->addChild('currency');
            $currency->addAttribute('id', get_option('woocommerce_currency'));
            $currency->addAttribute('rate', '1');
            $pr_categories = get_terms( 'product_cat', array(
                'taxonomy'   => "product_cat",
            ));

            $count = count($pr_categories);
            if ($count > 0){
                $categories = $this->feed->shop->addChild('categories');
                foreach ($pr_categories as $product_category){
                    $category = $categories->addChild('category', htmlspecialchars($product_category->name));
                    $category->addAttribute('id', $product_category->term_id);
                    if ($product_category->parent > 0){
                        $category->addAttribute('parentId', $product_category->parent);

                    }
                }
            }

            $this->feed->addChild('offers');
            $this->channelCreated = true;
        }
    }

    /**
     * @return Item
     */
    public function createItem()
    {

        $this->channel();
        $item = new Item($this->namespace);
        $index = 'index_' . md5(microtime());
        $this->items[$index] = $item;
        $item->setIndex($index);
        return $item;
    }

    /**
     * @param int $index
     */
    public function removeItemByIndex($index)
    {
        unset($this->items[$index]);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function standardiseSizeVarient($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function standardiseColourVarient($value)
    {
        return $value;
    }

    /**
     * @param string $group
     * @return bool|string
     */
    public function isVariant($group)
    {
        if (preg_match("#^\s*colou?rs?\s*$#is", trim($group))) {
            return 'color';
        }
        if (preg_match("#^\s*sizes?\s*$#is", trim($group))) {
            return 'size';
        }
        if (preg_match("#^\s*materials?\s*$#is", trim($group))) {
            return 'material';
        }
        return false;
    }

    /**
     * Adds items to feed
     */
    private function addItemsToFeed()
    {
        if($this->feed->shop) {
            $this->feed->shop->addChild('offers');
        }
        foreach ($this->items as $item) {
            $feedItemNode = $this->feed->shop->offers->addChild($this->itemlName);
            foreach ($item->nodes() as $itemNode) {
                if($itemNode->get('name') === 'id') {
                    $feedItemNode->addAttribute($itemNode->get('name'), $itemNode->get('value'));
                }elseif ($itemNode->get('name') === 'available') {
                    $feedItemNode->addAttribute('available', $itemNode->get('value') === 'in stock'? 'true' : 'false');
                }elseif ($itemNode->get('name') === 'bid') {
                    $feedItemNode->addAttribute($itemNode->get('name'), $itemNode->get('value') );
                }elseif ($itemNode->get('name') === 'cbid') {
                    $feedItemNode->addAttribute($itemNode->get('name'), $itemNode->get('value'));
                }elseif ($itemNode->get('name') === 'type') {
                    $feedItemNode->addAttribute($itemNode->get('name'), $itemNode->get('value'));
                }
                else {
                    if (is_array($itemNode)) {
                        foreach ($itemNode as $node) {
                            $feedItemNode->addChild(str_replace(' ', '_', $node->get('name')), $node->get('value'), $node->get('_namespace'));
                        }
                    } else {
                        if(is_array($itemNode->get('value'))) {
                            foreach ($itemNode->get('value') as $val) {
                                $feedItemNode->addChild($itemNode->get('name'), $val);
                            }
                        }else {
                            $itemNode->attachNodeTo($feedItemNode);
                        }
                    }
                }

            }
        }
    }

    private function addItemsToFeedText() {
        $str = '';
        if(count($this->items)){
            $this->items_row[] = array_keys(end($this->items)->nodes());
            foreach ($this->items as $item) {
                $row = array();
                foreach ($item->nodes() as $itemNode) {
                    if (is_array($itemNode)) {
                        foreach ($itemNode as $node) {
                            $row[] = str_replace(array("\r\n", "\n", "\r"), ' ', $node->get('value'));
                        }
                    } else {
                        $row[] = str_replace(array("\r\n", "\n", "\r"), ' ', $itemNode->get('value'));
                    }
                }
                $this->items_row[] = $row;
            }
            foreach ($this->items_row as $fields) {
                $str .= implode("\t", $fields) . "\n";
            }
        }
        return $str;
    }

    private function addItemsToFeedCSV(){

        if(count($this->items)){

            $this->items_row[] = array_keys(end($this->items)->nodes());
            foreach ($this->items as $item) {
                $row = array();
                foreach ($item->nodes() as $itemNode) {
                    if (is_array($itemNode)) {
                        foreach ($itemNode as $node) {
                            $row[] = str_replace(array("\r\n", "\n", "\r"), ' ', $node->get('value'));
                        }
                    } else {
                        $row[] = str_replace(array("\r\n", "\n", "\r"), ' ', $itemNode->get('value'));
                    }
                }
                $this->items_row[] = $row;
            }
            
            $str = '';
            foreach ($this->items_row as $fields) {
                $str .= implode("\t", $fields) . "\n";
            }
        }

        return $this->items_row;
    }

    /**
     * Retrieve Google product categories from internet and cache the result
     * @return array
     */
    public function categories()
    {
        $cache = new Cache;
        $cache->setCacheDirectory($this->cacheDir);
        $data = $cache->getOrCreate('google-feed-taxonomy.txt', array( 'max-age' => '86400' ), function () {
            return file_get_contents("http://www.google.com/basepages/producttype/taxonomy.en-GB.txt");
        });
        return explode("\n", trim($data));
    }

    /**
     * Build an HTML select containing Google taxonomy categories
     * @param string $selected
     * @return string
     */
    public function categoriesAsSelect($selected = '')
    {
        $categories = $this->categories();
        unset($categories[0]);
        $select = '<select name="google_category">';
        $select .= '<option value="">Please select a Google Category</option>';
        foreach ($categories as $category) {
            $select .= '<option ' . ($category == $selected ? 'selected' : '') . ' name="' . $category . '">' . $category . '</option>';
        }
        $select .= '</select>';
        return $select;
    }

    /**
     * Generate RSS feed
     * @param bool $output
     * @param string/bool $merchant
     * @return string
     */
    public function asRss($output = false)
    {
        if (ob_get_contents()) ob_end_clean();
        $this->addItemsToFeed();

//        $data = html_entity_decode($this->feed->asXml());
        $data = $this->feed->asXml();
        if ($output) {
            header('Content-Type: application/xml; charset=utf-8');
            die($data);
        }

        return $data;
    }

    /**
     * Generate Txt feed
     * @param bool $output
     * @return string
     */
    public function asTxt($output = false)
    {
        if (ob_get_contents()) ob_end_clean();
        $this->addItemsToFeedText();
        $data = html_entity_decode($this->feed->asXml());
        if ($output) {
            die($data);
        }
        return $data;
    }

    /**
     * Generate CSV feed
     * @param bool $output
     * @return string
     */
    public function asCsv($output = false)
    {

        ob_end_clean();
        $data = $this->addItemsToFeedCSV();
        if ($output) {
            die($data);
        }
        return $data;
    }


    /**
     * Remove last inserted item
     */
    public function removeLastItem()
    {
        array_pop($this->items);
    }
}
