<?php

/**
 * The file that generates xml feed for any merchant with custom configuration.
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

use RexTheme\RexShoppingFeed\Containers\RexShopping;

class Rex_Product_Feed_Other extends Rex_Product_Feed_Abstract_Generator {

    private $feed_merchants = array(
        "123i" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'Carga',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => 'Imoveis',
            'wrapper'   => true,
            'datetime'   => false,
        ),
        "adcrowd" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'rss',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '2.0',
            'wrapper_el'   => 'channel',
            'wrapper'   => true,
            'datetime'   => false,
        ),
        "adform" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "adtraction" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'feed',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "beslist" => array(
            'container'  => true,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => true,
            'version' => '1.0',
            'wrapper_el'   => '',
            'wrapper'   => true,
            'datetime'   => true,
        ),
        "bloomville" => array(
            'container'  => true,
            'item_wrapper'  => 'CourseTemplate',
            'items_wrapper' => 'CourseTemplates',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "cdiscount" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "clubic" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "custom" => array(
            'container'  => true,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => true,
            'version' => '1.0',
            'wrapper_el'   => '',
            'wrapper'   => true,
            'datetime'   => true,
        ),
        "drm" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "datatrics" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "deltaprojects" => array(
            'container'  => true,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "domodi" => array(
            'container'  => true,
            'item_wrapper'  => 'SHOPITEM',
            'items_wrapper' => 'SHOP',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "drezzy" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "ebay_mip" => array(
            'container'  => true,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => true,
            'version' => '1.0',
            'wrapper_el'   => '',
            'wrapper'   => true,
            'datetime'   => true,
        ),
        "emag" => array(
            'container'  => true,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'shop',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "eytsy" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "fashiola" => array(
            'container'  => true,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "glami" => array(
            'container'  => true,
            'item_wrapper'  => 'SHOPITEM',
            'items_wrapper' => 'SHOP',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "heureka" => array(
            'container'  => false,
            'item_wrapper'  => 'SHOPITEM',
            'items_wrapper' => 'SHOP',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "homebook" => array(
            'container'  => false,
            'item_wrapper'  => 'offer',
            'items_wrapper' => 'offers',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "homedeco" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "hertie" => array(
            'container'  => false,
            'item_wrapper'  => 'Artikel',
            'items_wrapper' => 'Katalog',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "incurvy" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'produkte',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "indeed" => array(
            'container'  => false,
            'item_wrapper'  => 'job',
            'items_wrapper' => 'source',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),

        "jobbird" => array(
            'container'  => false,
            'item_wrapper'  => 'job',
            'items_wrapper' => 'jobs',
            'version'       => '1.0',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,

        ),
        "joblift" => array(
            'container'  => false,
            'item_wrapper'  => 'job',
            'items_wrapper' => 'feed',
            'version'       => '1',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "job_board_io" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "kieskeurig" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "kauftipp" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "kuantokusta" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "kleding" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "kelkoo" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "kelkoonl" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "lyst" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'channel',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "listupp" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "ladenzeile" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "mydeal" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "prisjkat" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "pricefalls" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "pricerunner" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "nextag" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "rakuten" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "rakuten_advertising" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "rss" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "shopalike" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "skroutz" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'mywebstore',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => 'products',
            'wrapper'   => true,
            'datetime'   => false,
        ),
        "trovaprezzi" => array(
            'container'  => false,
            'item_wrapper'  => 'Offer',
            'items_wrapper' => 'Products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "vidaXL" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'products',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "vivino" => array(
            'container'  => false,
            'item_wrapper'  => 'product',
            'items_wrapper' => 'vivino-product-list',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "winesearcher" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "whiskymarketplace" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'items',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "webgains" => array(
            'container'  => false,
            'item_wrapper'  => 'item',
            'items_wrapper' => 'feed',
            'namespace' => null,
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
        "zbozi" => array(
            'container'  => false,
            'item_wrapper'  => 'SHOPITEM',
            'items_wrapper' => 'SHOP',
            'namespace' => 'http://www.zbozi.cz/ns/offer/1.0',
            'namespace_prefix' => '',
            'stand_alone'   => false,
            'version' => '',
            'wrapper_el'   => '',
            'wrapper'   => false,
            'datetime'   => false,
        ),
    );


    /**
     * Check if the merchants is valid or not
     * @param $feed_merchants
     * @return bool
     */
    public function is_valid_merchant(){
        return array_key_exists($this->merchant, $this->feed_merchants)? true : false;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function get_version() {
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['version'] : '';
    }


    /**
     * @return string
     */
    public function get_item_wrapper(){
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['item_wrapper'] : 'product';
    }


    /**
     * @return string
     */
    public function get_items_wrapper(){
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['items_wrapper'] : 'products';
    }

    /**
     * @return |null
     */
    public function get_namespace() {
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['namespace'] : null;
    }


    /**
     * @return bool
     */
    public function get_stand_alone() {
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['stand_alone'] : false;
    }

    /**
     * @return string
     */
    public function get_wrapper_el() {
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['wrapper_el'] : '';
    }

    /**
     * @return bool
     */
    public function get_wrapper() {
        return $this->is_valid_merchant()? $this->feed_merchants[$this->merchant]['wrapper'] : true;
    }


    /**
     * check if date is true/false
     *
     * @return bool
     */
    public function is_datetime() {
        return $this->feed_merchants[$this->merchant]['datetime'];
    }


    /**
     * Get namespace prefix
     *
     * @return string
     */
    public function get_namespace_prefix() {
        return $this->feed_merchants[$this->merchant]['namespace_prefix'];
    }

    /**
     * Create Feed
     *
     * @return boolean
     * @author
     **/
    public function make_feed() {
        RexShopping::$container = null;
        RexShopping::init($this->get_wrapper(), $this->get_item_wrapper(), $this->get_namespace(),  $this->get_version(), $this->get_items_wrapper(), $this->get_stand_alone(), $this->get_wrapper_el(), $this->get_namespace_prefix() );
        RexShopping::title($this->title);
        RexShopping::link($this->link);
        RexShopping::description($this->desc);

        if($this->is_datetime()) {
            RexShopping::datetime(date("Y-m-d h:i:s"));
        }

        // Generate feed for both simple and variable products.
        $this->generate_product_feed();
        $this->feed = $this->returnFinalProduct();

        if ($this->batch >= $this->tbatch ) {
            $this->save_feed($this->feed_format);
            return array(
                'msg' => 'finish'
            );
        }else {
            return $this->save_feed($this->feed_format);
        }
    }

    /**
     * Generate feed
     */
    protected function generate_product_feed(){
        $product_meta_keys = Rex_Feed_Attributes::get_attributes();
        $simple_products = [];
        $variation_products = [];
        $variable_parent = [];
        $group_products = [];
        $total_products = get_post_meta($this->id, 'rex_feed_total_products', true) ? get_post_meta($this->id, 'rex_feed_total_products', true) : array(
            'total' => 0,
            'simple' => 0,
            'variable' => 0,
            'variable_parent' => 0,
            'group' => 0,
        );

        if($this->batch == 1) {
            $total_products = array(
                'total' => 0,
                'simple' => 0,
                'variable' => 0,
                'variable_parent' => 0,
                'group' => 0,
            );
        }

        foreach( $this->products as $productId ) {
            $product = wc_get_product( $productId );

            if ( ! is_object( $product ) ) {
                continue;
            }

            if ( $this->exclude_hidden_products ) {
                if ( !$product->is_visible() ) {
                    continue;
                }
            }

            if ( $product->is_type( 'variable' ) && $product->has_child() ) {
                if($this->variable_product) {
                    $variable_parent[] = $productId;
                    $variable_product = new WC_Product_Variable($productId);
                    $atts = $this->get_product_data( $variable_product, $product_meta_keys );
                    $item = RexShopping::createItem();
                    foreach ($atts as $key => $value) {
                        $item->$key($value); // invoke $key as method of $item object.
                    }
                }

                if($this->product_scope === 'product_cat' || $this->product_scope === 'product_tag' || $this->product_scope === 'filter') {
                    if ( $this->exclude_hidden_products ) {
                        $variations = $product->get_visible_children();
                    }else {
                        $variations = $product->get_children();
                    }

                    if($variations) {
                        foreach ($variations as $variation) {
                            if($this->variations) {
                                $variation_products[] = $variation;
                                $item = RexShopping::createItem();
                                $variation_product = wc_get_product( $variation );
                                $atts = $this->get_product_data( $variation_product, $product_meta_keys );
                                foreach ($atts as $key => $value) {
                                    $item->$key($value); // invoke $key as method of $item object.
                                }
                            }
                        }
                    }
                }
            }

            if ( $product->is_type( 'simple' ) || $product->is_type( 'composite' ) || $product->is_type( 'bundle' )) {
                $simple_products[] = $productId;
                $atts = $this->get_product_data( $product, $product_meta_keys );
                $item = RexShopping::createItem();
                foreach ($atts as $key => $value) {
                    $item->$key($value); // invoke $key as method of $item object.
                }
            }

            if( $this->product_scope === 'all' ) {
                if ($product->get_type() == 'variation') {
                    $variation_products[] = $productId;
                    $item = RexShopping::createItem();
                    $atts = $this->get_product_data($product, $product_meta_keys);
                    foreach ($atts as $key => $value) {
                        $item->$key($value); // invoke $key as method of $item object.
                    }
                }
            }

            if( $product->is_type( 'grouped' ) ){
                if($this->parent_product) {
                    $group_products[] = $productId;
                    $item = RexShopping::createItem();
                    $atts = $this->get_product_data( $product, $product_meta_keys );
                    // add all attributes for each product.
                    foreach ($atts as $key => $value) {
                        $item->$key($value); // invoke $key as method of $item object.
                    }
                }
            }
        }

        $total_products = array(
            'total' => (int) $total_products['total'] + (int) count($simple_products) + (int) count($variation_products) + (int) count($group_products) + (int) count($variable_parent),
            'simple' => (int) $total_products['simple'] + (int) count($simple_products),
            'variable' => (int) $total_products['variable'] + (int) count($variation_products),
            'variable_parent' => (int) $total_products['variable_parent'] + (int) count($variable_parent),
            'group' => (int) $total_products['group'] + (int) count($group_products),
        );
        update_post_meta( $this->id, 'rex_feed_total_products', $total_products );
    }


    /**
     * Return Feed
     *
     * @return array|bool|string
     */
    public function returnFinalProduct(){

        if ($this->feed_format == 'xml') {
            return RexShopping::asRss();
        } elseif ($this->feed_format == 'text') {
            return RexShopping::asTxt();
        } elseif ($this->feed_format == 'csv') {
            return RexShopping::asCsv();
        }
        return RexShopping::asRss();
    }

}
