<?php


/**
 * The file that generates xml feed for Google.
 *
 * A class definition that includes functions used for generating xml feed.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed_Google
 * @subpackage Rex_Product_Feed_Google/includes
 * @author     RexTheme <info@rextheme.com>
 */

use LukeSnowden\GoogleShoppingFeed\Containers\GoogleShopping;

class Rex_Product_Feed_Google_merchant_promotion {

    /**
     * The Product/Feed Config.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    config    Feed config.
     */
    protected $config;

    /**
     * The Product/Feed ID.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    id    Feed id.
     */
    protected $id;

    /**
     * Feed Title.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    title    Feed title
     */
    protected $title;

    /**
     * Feed Description.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    desc    Feed description.
     */
    protected $desc;

    /**
     * Feed Link.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    link    Feed link.
     */
    protected $link;

    /**
     * The feed Merchant.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $merchant    Contains merchant name of the feed.
     */
    protected $merchant;

    /**
     * The feed format.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $feed_format    Contains format of the feed.
     */
    protected $feed_format;


    /**
     * The Feed.
     * @since    1.0.0
     * @access   protected
     * @var Rex_Product_Feed_Abstract_Generator    $feed    Feed as text.
     */
    protected $feed;


    /**
     * The feed rules containing all attributes and their value mappings for the feed.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $feed_rules    Contains attributes and value mappings for the feed.
     */
    protected $feed_rules;


    public function make_feed($config) {

        $this->config   = $config;
        $this->id       =   $config['info']['post_id'];
        $this->title    =   $config['info']['title'];
        $this->desc     =   $config['info']['desc'];
        $this->link     =   esc_url( home_url('/') );
        $this->merchant = $config['merchant'];
        $this->feed_format = $config['feed_format'];
        $this->setup_feed_rules($config['feed_config']);

        GoogleShopping::$container = null;
        GoogleShopping::title($this->title);
        GoogleShopping::link($this->link);
        GoogleShopping::description($this->desc);
        $item = GoogleShopping::createItem();


        $atts = array();
        foreach ($this->feed_rules as $values) {
            if(isset($values['attr'])) {
                $atts[$values['attr']] = $values['st_value'];
            }

            if(isset($values['cust_attr'])) {
                $atts[$values['attr']] = $values['st_value'];
            }

        }

        foreach ($atts as $key => $value) {
            $item->$key($value);
        }

        if ($this->feed_format == 'xml') {
            $this->feed = GoogleShopping::asRss();
        } elseif ($this->feed_format == 'text') {
            $this->feed = GoogleShopping::asTxt();
        } elseif ($this->feed_format == 'csv') {
            $this->feed = GoogleShopping::asCsv();
        }else {
            $this->feed = GoogleShopping::asRss();
        }

        return $this->save_feed($this->feed_format);

    }


    /**
     * Setup the rules
     * @param $info
     */
    protected function setup_feed_rules( $info ){
        $feed_rules       = array();
        parse_str( $info, $feed_rules );
        $feed_rules       = $feed_rules['fc'];
        $this->feed_rules = $feed_rules;
        update_post_meta( $this->id, 'rex_feed_feed_config', $this->feed_rules );
    }



    /**
     * Save the feed as XML file.
     *
     * @return bool
     */
    protected function save_feed($format){

        $path  = wp_upload_dir();
        $path  = $path['basedir'] . '/rex-feed';


        if ( !file_exists($path) ) {
            wp_mkdir_p($path);
        }


        if($format == 'xml'){
            $file = trailingslashit($path) . "feed-{$this->id}.xml";
            return file_put_contents($file, $this->feed) ? 'true' : 'false';
        }
        elseif ($format == 'text'){
            $file = trailingslashit($path) . "feed-{$this->id}.txt";
            return file_put_contents($file, $this->feed) ? 'true' : 'false';
        }
        elseif ($format == 'csv'){
            $file = trailingslashit($path) . "feed-{$this->id}.csv";
            if(file_exists($file)){
                unlink($file);
            }
            $file = fopen($file,"a+");

            $list = $this->feed;
            foreach ($list as $line)
            {
                fputcsv($file,$line);
            }
            fclose($file);
            return 'true';
        }
        else{
            $file = trailingslashit($path) . "feed-{$this->id}.xml";
            return file_put_contents($file, $this->feed) ? 'true' : 'false';
        }
    }
}