<?php

namespace RexTheme\GrupozapShopping\Grupozap;
use Gregwar\Cache\Cache;
use RexTheme\RexShoppingFeed\Item;
use SimpleXMLElement;

class Feed {

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
    public function __construct()
    {
        $this->itemlName = 'Listing';
        $this->channelName = 'Listings';
        $rss = 'ListingDataFeed';
        $xmlns = 'xmlns="http://www.vivareal.com/schemas/1.0/VRSync"';
        $xsi = 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
        $schemaLocation = 'xsi:schemaLocation="http://www.vivareal.com/schemas/1.0/VRSync http://xml.vivareal.com/vrsync.xsd"';
        $this->feed = new SimpleXMLElement("<$rss $xmlns $xsi $schemaLocation ></$rss>");
        $this->feed->addChild('Header');
        $this->feed->Header->addChild('Provider', 'RexTheme');
        $this->feed->Header->addChild('Email', 'support@rextheme.com');
        $this->feed->addChild($this->channelName);
    }


    /**
     * [channel description]
     */
    private function channel()
    {
        if (! $this->wrapper) {
            $this->channelCreated = true;
            return;
        }
        if (! $this->channelCreated ) {
            $channel = $this->channelName ? $this->feed->addChild($this->channelName) : $this->feed;
            ! $this->title       ?: $channel->addChild('title', $this->title);
            ! $this->link        ?: $channel->addChild('link', $this->link);
            ! $this->description ?: $channel->addChild('description', $this->description);
            ! $this->datetime ?: $channel->addChild('datetime', $this->datetime);
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
        foreach ($this->items as $item) {
            /** @var SimpleXMLElement $feedItemNode */
            $feedItemNode = $this->feed->{$this->channelName}->addChild($this->itemlName);
            foreach ($item->nodes() as $itemNode) {
                if (is_array($itemNode)) {
                    foreach ($itemNode as $node) {
                        $feedItemNode->addChild(str_replace(' ', '_', $node->get('name')), $node->get('value'), $node->get('_namespace'));
                    }
                } else {
                    $itemNode->attachNodeTo($feedItemNode);
                }
            }
        }
    }


    /**
     * add items to text feed
     *
     * @return string
     */
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

    /**
     * add items to csv feed
     *
     * @return Item[]
     */
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
     * add items to json feed
     *
     * @return Item[]
     */
    private function addItemsToFeedJSON(){

        if(count($this->items)){
            $this->items_row[] = array_keys(end($this->items)->nodes());
            foreach ($this->items as $item) {
                $row = array();
                foreach ($item->nodes() as $itemNode) {
//                    if($itemNode->get)
                }
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
        $str = $this->addItemsToFeedText();
        return $str;
    }

    /**
     * Generate CSV feed
     * @param bool $output
     * @return string
     */
    public function asCsv($output = false)
    {

        if (ob_get_contents()) ob_end_clean();
        $data = $this->addItemsToFeedCSV();
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
    public function asJSON($output = false)
    {

        if (ob_get_contents()) ob_end_clean();
        $data = $this->addItemsToFeedJSON();
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
