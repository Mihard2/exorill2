<?php


/**
 * Class for retriving product data based on user selected feed configuration.
 *
 * Get the product data based on feed config selected by user.
 *
 * @package    Rex_Product_Data_Retriever
 * @subpackage Rex_Product_Feed/admin
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Product_Data_Retriever {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    protected $feed_rules;


    /**
     * @var string $feed_id The id of the feed
     */
    protected $analytics_params;

    /**
     * Contains all available meta keys for products.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    protected $product_meta_keys;

    /**
     * The data of product retrived by feed_rules.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $data    The current version of this plugin.
     */
    protected $data;


    /**
     * Metabox instance of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $metabox    The current metabox of this plugin.
     */
    protected $product;

    /**
     * Variant atts for feed.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $metabox    The current metabox of this plugin.
     */
    protected $variant_atts = array( 'color', 'pattern', 'material', 'age_group', 'gender', 'size', 'size_type', 'size_system' );

    /**
     * Additional images of current product.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $metabox    The current metabox of this plugin.
     */
    protected $additional_images = array();


    /**
     * Append variation
     *
     * @since    3.2
     * @access   private
     * @var      object    $append_variation
     */
    protected $append_variation;


    /**
     * check if debug is enabled
     *
     * @var Rex_Product_Data_Retriever $enable_log
     */
    protected $is_logging_enabled;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( WC_Product $product, $feed_rules, $wpml = null, $append_variation = 'no', $product_meta_keys, $analytics_params = null ) {

        $this->is_logging_enabled = is_wpfm_logging_enabled();

        $this->product           = $product;
        $this->analytics_params = $analytics_params;

        if($this->is_logging_enabled) {
            $log = wc_get_logger();
            $log->info('*************************', array('source' => 'WPFM',));
            $log->info(__( 'Start product processing.', 'rex-product-feed' ), array('source' => 'WPFM',));
            $log->info('Product ID: '.$this->product->get_id(), array('source' => 'WPFM',));
            $log->info('Product Name: '.$this->product->get_title(), array('source' => 'WPFM',));
        }

        $this->feed_rules        = $feed_rules;
        $this->product_meta_keys = $product_meta_keys;

        $this->append_variation = $append_variation;
        $this->set_all_value();

        if($this->is_logging_enabled) {
            $log->info(__( 'End product processing.', 'rex-product-feed' ), array('source' => 'WPFM',));
            $log->info('*************************', array('source' => 'WPFM',));
        }
    }



    /**
     * Setup Testing feed rules for every attributes.
     * Just to check if this class return proper values.
     *
     * @since    1.0.2
     */
    public function set_test_feed_rules() {
        $this->feed_rules = array();

        foreach ($this->product_meta_keys as $key_cat => $attrs) {
            foreach ($attrs as $key => $attr) {
                $this->feed_rules[] = array(
                    'attr'     => $key,
                    'cust_attr'=> $key,
                    'type'     => 'meta',
                    'meta_key' => $key,
                    'st_value' => '',
                    'prefix'   => '',
                    'suffix'   => '',
                    'escape'   => 'default',
                    'limit'    => 0,
                );
            }
        }

    }


    public function get_random_key() {
        return md5(uniqid(rand(), true));
    }

    /**
     * Retrive and setup all data for every feed rules.
     *
     * @since    1.0.0
     */
    public function set_all_value() {
        $this->data = array();
        foreach ( $this->feed_rules as $key => $rule ) {

            if(array_key_exists('attr', $rule)) {
                if($rule['attr']) {
                    if($rule['attr'] === 'attributes') {
                        $this->data[ $rule['attr']][] = array(
                            'name' => str_replace( 'bwf_attr_pa_', '', $rule['meta_key']),
                            'value' => $this->set_val( $rule )
                        );
                    }else {
                        $this->data[ $rule['attr'] ] = $this->set_val( $rule );
                    }
                }
            }elseif (array_key_exists('cust_attr', $rule)) {
                if($rule['cust_attr']) {
                    $this->data[$rule['cust_attr']] = $this->set_val( $rule );
                }
            }else {
                $this->data[ $rule['attr'] ] = $this->set_val( $rule );
            }

        }
    }


    /**
     * Set value for a single feed rule.
     *
     * @since    1.0.0
     */
    public function set_val( $rule ) {
        $val = '';
        if ( 'static' === $rule['type'] ) {
            $val = $rule['st_value'];
        }
        elseif ( 'meta' === $rule['type'] && $this->is_primary_attr( $rule['meta_key'] ) ) {

            $val = $this->set_pr_att( $rule['meta_key'] , $rule['escape'] );
        }
        elseif ( 'meta' === $rule['type'] && $this->is_image_attr( $rule['meta_key'] ) ) {

            $val = $this->set_image_att( $rule['meta_key']  );
        }
        elseif ( 'meta' === $rule['type'] && $this->is_product_attr( $rule['meta_key'] ) ) {
            $val = $this->set_product_att( $rule['meta_key']  );
        }
        elseif ( 'meta' === $rule['type'] && $this->is_product_dynamic_attr( $rule['meta_key'] ) ) {
            $val = $this->set_product_dynamic_att( $rule['meta_key']  );
        }
        elseif ( 'meta' === $rule['type'] && $this->is_product_custom_attr( $rule['meta_key'] ) ) {
            $val = $this->set_product_custom_att( $rule['meta_key']  );
        }
        elseif ( 'meta' === $rule['type'] && $this->is_product_category_mapper_attr( $rule['meta_key'] ) ) {
            $val = $this->set_cat_mapper_att( $rule['meta_key']  );
        }

        // maybe add prefix/suffix
        $val = $this->maybe_add_prefix_suffix($val, $rule);
        // maybe escape
        $val = $this->maybe_escape($val, $rule['escape']);
        // maybe limit
        $val = $this->maybe_limit($val, $rule['limit']);

        return $val;

    }

    /**
     * Return all data.
     *
     * @since    1.0.0
     */
    public function get_all_data() {
        return $this->data;
    }

    /**
     * Set a primary attribute.
     *
     * @since    1.0.0
     */
    protected function set_pr_att( $key, $rule = 'default' ) {
        switch ( $key ) {
            case 'id':
                return $this->product->get_id(); break;

            case 'sku':
                return $this->product->get_sku(); break;

            case 'parent_sku':
                $pr_id = $this->product->get_id();
                if($this->product->is_type('variation')) {
                    $pr_id = $this->product->get_parent_id();
                }
                return get_post_meta($pr_id, '_sku', true); break;

            case 'title':
                if($this->append_variation === 'no') {
                    if($this->product->is_type('variation')) {
                        $pr_id = $this->product->get_parent_id();
                        return get_the_title($pr_id);
                    }
                    return $this->product->get_name();
                }
                else {
                    if ($this->is_children()) {
                        $_product = wc_get_product( $this->product );
                        $_variations = $_product->get_attributes();
                        if(count($_variations) > 2) {
                            $_title = $this->product->get_title() . " - ";
                            $title_arr = array();
                            foreach($_variations as $key => $value){
                                $title_arr[] = ucfirst($value);
                            }
                            $_title = $_title . implode(', ', $title_arr);
                            return $_title;
                        }else {
                            return $this->product->get_name();
                        }
                    }else {
                        return $this->product->get_name();
                    }
                }
                break;

            case 'yoast_title':
                return $this->get_yoast_seo_title(); break;

            case 'price':
                if ($this->product->is_type( 'grouped' ))
                    return number_format((float)$this->get_grouped_price($this->product, 'regular'), 2, '.', '');
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_composite_regular_price(), wc_get_price_decimals());
                }elseif ($this->product->is_type( 'variable' )) {
                    $default_attributes = $this->get_default_attributes( $this->product );
                    if($default_attributes) {
                        $variation_id = $this->find_matching_product_variation( $this->product, $default_attributes );
                        if($variation_id) {
                            $_variation_product = wc_get_product($variation_id);
                            return wc_format_decimal( $_variation_product->get_regular_price(), wc_get_price_decimals());
                        }
                        return wc_format_decimal( $this->product->get_variation_regular_price(), wc_get_price_decimals());
                    }
                    return wc_format_decimal( $this->product->get_variation_regular_price(), wc_get_price_decimals());
                }
                return wc_format_decimal( $this->product->get_regular_price(), wc_get_price_decimals());
                break;

            case 'current_price':
                if (!defined('WAD_INITIALIZED') ) {
                    if ($this->product->is_type( 'grouped' ))
                        return number_format((float)$this->get_grouped_price($this->product, 'price'), 2, '.', '');
                    elseif ($this->product->is_type( 'composite' )) {
                        $_pr  = new WC_Product_Composite($this->product->get_id());
                        return  wc_format_decimal( $_pr->get_composite_price(), wc_get_price_decimals());
                    }elseif ($this->product->is_type( 'variable' )) {
                        $default_attributes = $this->get_default_attributes( $this->product );
                        if($default_attributes) {
                            $variation_id = $this->find_matching_product_variation( $this->product, $default_attributes );
                            if($variation_id) {
                                $_variation_product = wc_get_product($variation_id);
                                return wc_format_decimal( $_variation_product->get_price(), wc_get_price_decimals());
                            }
                            return wc_format_decimal( $this->product->get_variation_price(), wc_get_price_decimals());
                        }
                        return wc_format_decimal( $this->product->get_variation_price(), wc_get_price_decimals());
                    }
                    return  wc_format_decimal( $this->product->get_price(), wc_get_price_decimals());
                }
                else {
                    global $wad_discounts;

                    $all_discounts = wad_get_active_discounts(true);
                    foreach ($all_discounts as $discount_type => $discounts) {
                        $wad_discounts[$discount_type] = array();
                        foreach ($discounts as $discount_id) {
                            $wad_discounts[$discount_type][$discount_id] = new WAD_Discount($discount_id);
                        }
                    }
                    if ($this->product->is_type( 'grouped' ))
                        $sale_price = number_format((float)$this->get_grouped_price($this->product, 'sale'), 2, '.', '') ;
                    elseif ($this->product->is_type( 'composite' )) {
                        $_pr  = new WC_Product_Composite($this->product->get_id());
                        return  wc_format_decimal( $_pr->get_composite_price(), wc_get_price_decimals());
                    }elseif ($this->product->is_type( 'variable' )) {
                        $default_attributes = $this->get_default_attributes( $this->product );
                        if($default_attributes) {
                            $variation_id = $this->find_matching_product_variation( $this->product, $default_attributes );
                            if($variation_id) {
                                $_variation_product = wc_get_product($variation_id);
                                $sale_price = number_format( (float)$_variation_product->get_price(), 2, '.', '');
                            }else {
                                $sale_price = number_format( (float)$this->product->get_variation_price(), 2, '.', '');
                            }

                        }else {
                            $sale_price = number_format( (float)$this->product->get_variation_price(), 2, '.', '');
                        }
                    }
                    else
                        $sale_price = number_format((float)$this->product->get_price(), 2, '.', '');

                    $_pid = wad_get_product_id_to_use($this->product);
                    $_product = wc_get_product($_pid);
                    if( $_product->is_type( 'variation' ) ) {
                        $_pid = $_product->get_parent_id();
                    }
                    foreach ($wad_discounts["product"] as $discount_id => $discount_obj) {
                        $o_discount = get_post_meta($discount_id, 'o-discount', true);
                        $pr_list_id = $o_discount['products-list'];
                        $product_list = new WAD_Products_List($pr_list_id);
                        $raw_args = get_post_meta($pr_list_id, "o-list", true);
                        $args = $product_list->get_args($raw_args);
                        $args['fields'] = 'ids';
                        $products = get_posts( $args );

                        if ($discount_obj->is_applicable($_pid) && in_array($_pid, $products)) {
                            $to_widthdraw = 0;
                            if (in_array($discount_obj->settings["action"], array("percentage-off-pprice", "percentage-off-osubtotal")))
                                $to_widthdraw = floatval (floatval($sale_price)) * floatval ($discount_obj->settings["percentage-or-fixed-amount"]) / 100;
                            //Fixed discount
                            else if (in_array($discount_obj->settings["action"], array("fixed-amount-off-pprice", "fixed-amount-off-osubtotal"))) {
                                $to_widthdraw = $discount_obj->settings["percentage-or-fixed-amount"];
                            } else if ($discount_obj->settings["action"] == "fixed-pprice")
                                $to_widthdraw = floatval(floatval($sale_price)) - floatval($discount_obj->settings["percentage-or-fixed-amount"]);
                            $decimals = wc_get_price_decimals();
                            $discount = round( $to_widthdraw, $decimals );
                            $sale_price = floatval($sale_price) - $discount;

                            return  wc_format_decimal( $sale_price, wc_get_price_decimals());;
                        }
                    }
                    return  wc_format_decimal( $sale_price, wc_get_price_decimals());;
                }
                break;

            case 'sale_price':

                if (!defined('WAD_INITIALIZED') ) {
                    if ($this->product->is_type( 'grouped' ))
                        $sale_price = number_format((float)$this->get_grouped_price($this->product, 'sale'), 2, '.', '');
                    elseif ($this->product->is_type( 'composite' )) {
                        $sale_price =  wc_format_decimal( $this->product->get_sale_price(), wc_get_price_decimals());
                    }elseif ($this->product->is_type( 'variable' )) {
                        $default_attributes = $this->get_default_attributes( $this->product );
                        if($default_attributes) {
                            $variation_id = $this->find_matching_product_variation( $this->product, $default_attributes );
                            if($variation_id) {
                                $_variation_product = wc_get_product($variation_id);
                                $sale_price = wc_format_decimal( $_variation_product->get_sale_price(), wc_get_price_decimals());
                            }else {
                                $sale_price = wc_format_decimal( $this->product->get_variation_sale_price(), wc_get_price_decimals());
                            }
                        }else {
                            $sale_price = wc_format_decimal( $this->product->get_variation_sale_price(), wc_get_price_decimals());
                        }
                    }else {
                        $sale_price = wc_format_decimal( $this->product->get_sale_price(), wc_get_price_decimals());
                    }
                    if($sale_price > 0)
                        return $sale_price;
                    return '';
                }
                else {
                    global $wad_discounts;

                    $all_discounts = wad_get_active_discounts(true);
                    foreach ($all_discounts as $discount_type => $discounts) {
                        $wad_discounts[$discount_type] = array();
                        foreach ($discounts as $discount_id) {
                            $wad_discounts[$discount_type][$discount_id] = new WAD_Discount($discount_id);
                        }
                    }

                    if ($this->product->is_type( 'grouped' ))
                        $sale_price = number_format((float)$this->get_grouped_price($this->product, 'sale'), 2, '.', '') ;
                    elseif ($this->product->is_type( 'variable' )) {
                        $default_attributes = $this->get_default_attributes( $this->product );
                        if($default_attributes) {
                            $variation_id = $this->find_matching_product_variation( $this->product, $default_attributes );
                            if($variation_id) {
                                $_variation_product = wc_get_product($variation_id);
                                $sale_price = number_format( (float)$_variation_product->get_sale_price(), 2, '.', '');
                            }else {
                                $sale_price = number_format( (float)$this->product->get_variation_sale_price(), 2, '.', '');
                            }
                        }else {
                            $sale_price = number_format( (float)$this->product->get_variation_sale_price(), 2, '.', '');
                        }
                    }
                    elseif ($this->product->is_type( 'composite' )) {
                        $_pr  = new WC_Product_Composite($this->product->get_id());
                        return  wc_format_decimal( $_pr->get_sale_price(), wc_get_price_decimals());
                    }
                    else
                        $sale_price = number_format((float)$this->product->get_sale_price(), 2, '.', '');


                    $_pid = wad_get_product_id_to_use($this->product);
                    $_product = wc_get_product($_pid);
                    if( $_product->is_type( 'variation' ) ) {
                        $_pid = $_product->get_parent_id();
                    }
                    foreach ($wad_discounts["product"] as $discount_id => $discount_obj) {
                        $o_discount = get_post_meta($discount_id, 'o-discount', true);
                        $pr_list_id = $o_discount['products-list'];
                        $product_list = new WAD_Products_List($pr_list_id);
                        $raw_args = get_post_meta($pr_list_id, "o-list", true);
                        $args = $product_list->get_args($raw_args);
                        $args['fields'] = 'ids';
                        $products = get_posts( $args );
                        if ($discount_obj->is_applicable($_pid) && in_array($_pid, $products)) {
                            $to_widthdraw = 0;
                            if (in_array($discount_obj->settings["action"], array("percentage-off-pprice", "percentage-off-osubtotal")))
                                $to_widthdraw = floatval (floatval($sale_price)) * floatval ($discount_obj->settings["percentage-or-fixed-amount"]) / 100;
                            //Fixed discount
                            else if (in_array($discount_obj->settings["action"], array("fixed-amount-off-pprice", "fixed-amount-off-osubtotal"))) {
                                $to_widthdraw = $discount_obj->settings["percentage-or-fixed-amount"];
                            } else if ($discount_obj->settings["action"] == "fixed-pprice")
                                $to_widthdraw = floatval(floatval($sale_price)) - floatval($discount_obj->settings["percentage-or-fixed-amount"]);
                            $decimals = wc_get_price_decimals();
                            $discount = round( $to_widthdraw, $decimals );
                            $sale_price = floatval($sale_price) - $discount;
                            return  wc_format_decimal( $sale_price, wc_get_price_decimals());;
                        }
                    }
                    $sale_price = wc_format_decimal( $sale_price, wc_get_price_decimals());
                    if($sale_price > 0)
                        return $sale_price;
                    return '';
                }
                break;

            case 'price_with_tax':
                if ($this->product->is_type( 'grouped' ))
                    return wc_get_price_including_tax( $this->product, array( 'price' => $this->get_grouped_price($this->product, 'regular') ) );
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_composite_regular_price(), wc_get_price_decimals());
                }
                return  wc_format_decimal( wc_get_price_including_tax( $this->product, array( 'price' => $this->product->get_regular_price() ) ), wc_get_price_decimals());
                break;

            case 'current_price_with_tax':
                if ($this->product->is_type( 'grouped' ))
                    return wc_get_price_including_tax( $this->product, array( 'price' => $this->get_grouped_price($this->product, 'price') ) );
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_composite_price(), wc_get_price_decimals());
                }
                return wc_format_decimal( wc_get_price_including_tax( $this->product, array( 'price' => $this->product->get_price() ) ), wc_get_price_decimals());
                break;

            case 'sale_price_with_tax':
                if ($this->product->is_type( 'grouped' ))
                    return wc_get_price_including_tax( $this->product, array( 'price' => $this->get_grouped_price($this->product, 'sale') ) );
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_sale_price(), wc_get_price_decimals());
                }
                $sale_price = $this->product->get_sale_price();
                if($sale_price > 0) {
                    return wc_format_decimal( wc_get_price_including_tax( $this->product, array( 'price' => $this->product->get_sale_price() ) ), wc_get_price_decimals());
                }
                return '';
                break;

            case 'price_excl_tax':

                if ($this->product->is_type( 'grouped' ))
                    return wc_get_price_excluding_tax( $this->product, array( 'price' => $this->get_grouped_price($this->product, 'regular') ) );
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_composite_regular_price(), wc_get_price_decimals());
                }
                return  wc_format_decimal( wc_get_price_excluding_tax( $this->product, array( 'price' => $this->product->get_regular_price() ) ), wc_get_price_decimals());
                break;

            case 'current_price_excl_tax':
                if ($this->product->is_type( 'grouped' ))
                    return wc_get_price_excluding_tax( $this->product, array( 'price' => $this->get_grouped_price($this->product, 'price') ) );
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_composite_price(), wc_get_price_decimals());
                }
                return wc_format_decimal( wc_get_price_excluding_tax( $this->product, array( 'price' => $this->product->get_price() ) ), wc_get_price_decimals());
                break;

            case 'sale_price_excl_tax':
                if ($this->product->is_type( 'grouped' ))
                    return wc_get_price_excluding_tax( $this->product, array( 'price' => $this->get_grouped_price($this->product, 'sale') ) );
                elseif ($this->product->is_type( 'composite' )) {
                    $_pr  = new WC_Product_Composite($this->product->get_id());
                    return  wc_format_decimal( $_pr->get_sale_price(), wc_get_price_decimals());
                }
                $sale_price = $this->product->get_sale_price();
                if($sale_price > 0) {
                    return wc_format_decimal( wc_get_price_excluding_tax( $this->product, array( 'price' => $this->product->get_sale_price() ) ), wc_get_price_decimals());
                }
                return '';


            case 'description':
                if(($this->is_children())):
                    $_product = wc_get_product( $this->product->get_parent_id() );
                    $_product_desc =  $this->remove_short_codes($_product->get_description());
                    return $_product_desc;
                else:
                    return $this->remove_short_codes($this->product->get_description());
                endif;
                break;

            case 'short_description':
                if(($this->is_children())):
                    $_product = wc_get_product( $this->product->get_parent_id() );
                    $_product_desc = $this->remove_short_codes($_product->get_short_description());
                    return $_product_desc;
                else:
                    return $this->remove_short_codes($this->product->get_short_description()) ;
                endif;
                break;

            case 'yoast_meta_desc':
                return $this->get_yoast_meta_description(); break;

            case 'product_cats':
                return $this->get_product_cats(); break;

            case 'product_cats_path':
                return $this->get_product_cats_with_seperator(); break;

            case 'product_cats_path_pipe':
                return $this->get_product_cats_with_seperator('', ' | ', ''); break;

            case 'yoast_primary_cats_path':
                return $this->get_yoast_product_cats_with_seperator(); break;

            case 'yoast_primary_cats_pipe':
                return $this->get_yoast_product_cats_with_seperator('', ' | ', ''); break;

            case 'product_subcategory':
                return $this->get_product_subcategory(); break;

            case 'product_tags':
                return $this->get_product_tags(); break;

            case 'yoast_primary_cat':
                return $this->get_yoast_primary_cat(); break;

            case 'spartoo_product_cats':
                return $this->get_spartoo_product_cats(); break;

            case 'sooqr_cats':
                return $this->get_product_cats_for_sooqr(); break;

            case 'link':

                if($this->analytics_params) {
                    if ( ! empty( $this->analytics_params['utm_source'] ) &&
                        ! empty( $this->analytics_params['utm_medium'] ) &&
                        ! empty( $this->analytics_params['utm_campaign'] )
                    ) {
                        if($rule === 'decode_url') {
                            return add_query_arg( array_filter( $this->analytics_params ), urldecode($this->product->get_permalink())); break;
                        }
                        return $this->safeCharEncodeURL(add_query_arg( array_filter( $this->analytics_params ), urldecode($this->product->get_permalink()) )); break;
                    }
                    if($rule === 'decode_url') {
                        return urldecode($this->product->get_permalink()); break;
                    }
                    return $this->safeCharEncodeURL(urldecode($this->product->get_permalink())); break;
                }
                if($rule === 'decode_url') {
                    return urldecode($this->product->get_permalink()); break;
                }
                return $this->safeCharEncodeURL(urldecode($this->product->get_permalink())); break;

            case 'condition':
                return $this->get_condition(); break;

            case 'item_group_id':
                return $this->get_item_group_id(); break;

            case 'availability':
                return $this->get_availability(); break;

            case 'quantity':
                return $this->product->get_stock_quantity(); break;

            case 'weight':
                return $this->product->get_weight(); break;

            case 'width':
                return $this->product->get_width(); break;

            case 'height':
                return $this->product->get_height(); break;

            case 'length':
                return $this->product->get_length(); break;

            case 'shipping_class':
                return $this->product->get_shipping_class(); break;

            case 'shipping_cost':
                return $this->get_shipping_cost(); break;

            case 'type':
                return $this->product->get_type(); break;

            case 'in_stock':
                return $this->get_stock(); break;

            case 'rating_average':
                return $this->product->get_average_rating(); break;

            case 'rating_total':
                return $this->product->get_rating_count(); break;

            case 'sale_price_dates_from':
                return date( get_option( 'date_format' ), $this->product->get_date_on_sale_from() ); break;

            case 'sale_price_dates_to':
                return date( get_option( 'date_format' ), $this->product->get_date_on_sale_to() ); break;

            case 'sale_price_effective_date':


                $sale_price_dates_to        = ( $date = get_post_meta( $this->product->get_id(), '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
                $sale_price_dates_from      = ( $date = get_post_meta( $this->product->get_id(), '_sale_price_dates_from', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';

                if ( ! empty( $sale_price_dates_to ) && ! empty( $sale_price_dates_from ) ) {
                    $from   = date( "c", strtotime( $sale_price_dates_from ) );
                    $to     = date( "c", strtotime( $sale_price_dates_to ) );


                    return $from . '/' . $to;
                }else {
                    return '';
                }

            case 'identifier_exists':
                return $this->calculate_identifier_exists($this->data);

            default: return ''; break;
        }
    }


    /**
     * Set a Image attribute.
     *
     * @since    1.0.0
     */
    protected function set_image_att( $key ) {
        switch ( $key ) {
            case 'featured_image':
                return wp_get_attachment_url(  $this->product->get_image_id() ); break;
            default: return $this->get_additional_image( $key ); break;
        }
    }

    /**
     * Set a Product attribute.
     *
     * @since    1.0.0
     */
    protected function set_product_att( $key ) {
        if ( 'WC_Product_Variation' != get_class($this->product) ) {
            return;
        }
        $key = str_replace( 'bwf_attr_pa_', '', $key);
        $value = $this->product->get_attribute( $key );
        if ( ! empty( $value ) ) {
            $value = trim( $value );
        }
        return $value;
    }

    /**
     * Set a Product Dynamic attribute.
     *
     * @since    1.0.0
     */
    protected function set_product_dynamic_att( $key ) {

        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            $attr_name = $this->get_product_dynamic_tags($this->product->get_parent_id(), $key);
        } else{

            $attr_name = $this->get_product_dynamic_tags($this->product->get_id(), $key);
        }
        if($attr_name){
            return $attr_name;
        }
        return '';
    }

    /**
     * Set a Product Custom attribute.
     *
     * @since    1.0.0
     */
    protected function set_product_custom_att( $key ) {

        $new_key = str_replace('custom_attributes_', '', $key);
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            if($new_key === '_wpfm_product_brand') {
                $meta_value = get_post_meta($this->product->get_parent_id(), $new_key, true);
            }else {
                $meta_value = get_post_meta($this->product->get_id(), $new_key, true);


                // need to check if these attributes value is assigned to the mother product
                if(!$meta_value) {
                    $list = $this->get_product_attributes($this->product->get_parent_id());
                    if(array_key_exists($new_key, $list)) {
                        $meta_value = str_replace('|', ',', $list[$new_key]);
                    }
                }
            }
        } else{
            $meta_value = get_post_meta($this->product->get_id(), $new_key, true);
            if(!$meta_value) {
                $list = $this->get_product_attributes($this->product->get_id());
                if(array_key_exists($new_key, $list)) {
                    $meta_value = str_replace('|', ',', $list[$new_key]);
                }
            }
        }

        if($meta_value){
            return $meta_value;
        }
        return '';
    }


    /**
     * get all the product attributes
     * @param $id
     * @return array
     */
    protected function get_product_attributes($id) {
        global $wpdb;
        $list = [];
        $sql = "SELECT meta_key as name, meta_value as value FROM {$wpdb->prefix}postmeta  as postmeta
                            INNER JOIN {$wpdb->prefix}posts AS posts
                            ON postmeta.post_id = posts.id
                            WHERE posts.post_type LIKE '%product%'
                            AND postmeta.meta_key = '_product_attributes'
                            AND postmeta.post_id = %d";
        $data = $wpdb->get_results($wpdb->prepare($sql, $id));
        if(count($data)) {
            foreach ($data as $key => $value) {
                $value_display = str_replace("_", " ",$value->name);
                if (!preg_match("/_product_attributes/i", $value->name)) {
                    $list[$value->name] = ucfirst($value_display);
                }else {
                    $product_attributes = unserialize($value->value);
                    if (!empty($product_attributes)) {
                        foreach ($product_attributes as $k => $arr_value) {
                            $value_display = str_replace("_", " ", $arr_value['value']);
                            $list[$k] = ucfirst($value_display);
                        }
                    }
                }
            }
        }
        return $list;
    }


    /**
     * Set Product Category Map
     *
     * @since    3.0
     */
    protected function set_cat_mapper_att( $key ) {
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            $cat_lists = get_the_terms( $this->product->get_parent_id(), 'product_cat' );
        } else{
            $cat_lists = get_the_terms( $this->product->get_id(), 'product_cat' );
        }

        $wpfm_category_map = get_option('rex-wpfm-category-mapping');
        if($wpfm_category_map) {
            $map = $wpfm_category_map[$key];
            $map_config = $map['map-config'];
            if($cat_lists) {
                foreach ( $cat_lists as $term ) {
                    $map_key = array_search($term->term_id, array_column($map_config, 'map-key'));
                    if($map_key) {
                        $map_array = $map_config[$map_key];
                        $map_value = $map_array['map-value'];
                        preg_match("~^(\d+)~", $map_value, $m);
                        if(count($m) > 1) {
                            if($m[1]) {
                                return utf8_decode(urldecode($m[1]));
                            }
                        }else {

                        }
                        return $map_value;
                    }
                }
            }
        }
        return '';
    }


    /**
     * Get yoast seo title
     * @return string
     */
    public function get_yoast_seo_title() {
        $title = '';
        if ($this->product->get_type() == 'variation') {
            $product_id = $this->product->get_parent_id();
        }else {
            $product_id = $this->product->get_id();
        }
        if ( function_exists( 'wpseo_replace_vars' ) ) {
            $wpseo_title = get_post_meta($product_id, '_yoast_wpseo_title', true);
            if($wpseo_title) {
                $product_title_pattern = $wpseo_title;
            }else {
                $wpseo_titles = get_option('wpseo_titles');
                $product_title_pattern = $wpseo_titles['title-product'];
            }
            $title = wpseo_replace_vars($product_title_pattern, get_post($product_id));
        }
        if ( ! empty( $title ) ) {
            return $title;
        }
        else {
            return $this->product->get_title();
        }
    }


    /**
     * Get yoast meta descriptions
     * @return string
     */
    public function get_yoast_meta_description() {
        $description = '';
        if ($this->product->get_type() == 'variation') {
            $product_id = $this->product->get_parent_id();
        }else {
            $product_id = $this->product->get_id();
        }
        if ( function_exists( 'wpseo_replace_vars' ) ) {
            $wpseo_meta_description = get_post_meta($product_id, '_yoast_wpseo_metadesc', true);
            if($wpseo_meta_description) {
                $product_meta_desc_pattern = $wpseo_meta_description;
            }else {
                $wpseo_titles = get_option('wpseo_titles');
                $product_meta_desc_pattern = $wpseo_titles['metadesc-product'];
            }
            $description = wpseo_replace_vars($product_meta_desc_pattern, get_post($product_id));
        }

        if ( ! empty( $description ) ) {
            return $description;
        }
        else {
            return $this->product->get_description();
        }
    }


    /**
     * Get additional image url by key.
     *
     * @since    1.0.0
     */
    protected function get_additional_image( $key ) {

        if ( empty( $this->additional_images ) ) {
            $this->set_additional_images();
        }


        if ( array_key_exists( $key, $this->additional_images ) ) {
            return $this->additional_images[$key];
        }

        return '';

    }

    /**
     * Retrieve a product's categories as a list with specified format.
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     */
    protected function get_product_cats( $before = '', $sep = ', ', $after = '' ) {
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            return $this->get_the_term_list( $this->product->get_parent_id(), 'product_cat', $before, $sep, $after );
        }else {
            return $this->get_the_term_list( $this->product->get_id(), 'product_cat', $before, $sep, $after );
        }

    }


    /**
     * @param string $before
     * @param string $sep
     * @param string $after
     * @return array
     */
    protected function get_spartoo_product_cats( $before = '', $sep = ', ', $after = '' ) {
        $term_array = array();
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            $terms = get_the_terms( $this->product->get_parent_id(), 'product_cat' );
        }else {
            $terms = get_the_terms( $this->product->get_id(), 'product_cat' );
        }

        $count = 0;
        if($terms) $count = count($terms);
        if($count > 1) {
            foreach ($terms as $term) {
                $term_array[] = $term->name;
            }
        }
        return $term_array;
    }


    /**
     * Retrieve a product's categories as a list with specified format.
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     */
    protected function get_product_cats_with_seperator( $before = '', $sep = ' > ', $after = '' ) {
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            return $this->get_the_term_list_with_path( $this->product->get_parent_id(), 'product_cat', $before, $sep, $after );
        }else {
            return $this->get_the_term_list_with_path( $this->product->get_id(), 'product_cat', $before, $sep, $after );
        }
    }


    /**
     * Retrieve a product's categories as a list with specified format.
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string
     */
    protected function get_yoast_product_cats_with_seperator( $before = '', $sep = ' > ', $after = '' ) {
        $pr_id = $this->product->get_id();
        if($this->product->is_type('variation')) {
            $pr_id = $this->product->get_parent_id();
        }
        $primary_cat_id=get_post_meta($pr_id,'_yoast_wpseo_primary_product_cat',true);
        $term_name = [];
        if($primary_cat_id){
            $product_cat = get_term($primary_cat_id, 'product_cat');
            if(isset($product_cat->name)) {
                $term_name[] = $product_cat->name;
                $term_name_arr = $this->get_cat_names_array($pr_id, 'product_cat',$primary_cat_id, $term_name);
                if(is_array($term_name_arr)) {
                    return implode($sep, $term_name_arr);
                }
                return $this->get_product_cats('', ' > ', '');
            }
        }
        return $this->get_product_cats('', ' > ', '');
    }



    /**
     * Retrieve a product's sub categories as a list with specified format.
     *
     * @param string $sep Optional. Separate items using this.
     * @return string|false
     */
    protected function get_product_subcategory( $sep = ' > ') {
        $parent = 0;
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            $terms = get_the_terms( $this->product->get_parent_id(), 'product_cat' );
            if ( empty( $terms ) || is_wp_error( $terms ) ){
                return '';
            }
            $term_names = array();
            foreach($terms as $term) {
                if($term->parent) {
                    $term_names[] = $term->name;
                }
            }
            ksort($term_names);
            return '' . join( $sep, $term_names ) . '';
        }else {
            $terms = get_the_terms( $this->product->get_id(), 'product_cat' );
            if ( empty( $terms ) || is_wp_error( $terms ) ){
                return '';
            }
            $term_names = array();
            foreach($terms as $term) {
                if($term->parent) {
                    $term_names[] = $term->name;
                }
            }
            ksort($term_names);
            return '' . join( $sep, $term_names ) . '';
        }

    }

    /**
     * Retrieve a product's tags as a list with specified format.
     *
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     */
    protected function get_product_tags( $before = '', $sep = ', ', $after = '' ) {

        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            return $this->get_the_term_list( $this->product->get_parent_id(), 'product_tag', $before, $sep, $after );
        }else {
            return $this->get_the_term_list( $this->product->get_id(), 'product_tag', $before, $sep, $after );
        }
    }


    /**
     * get yoast primary category
     * @return string
     */
    public function get_yoast_primary_cat() {
        $pr_id = $this->product->get_id();
        if($this->product->is_type('variation')) {
            $pr_id = $this->product->get_parent_id();
        }
        $primary_cat_id=get_post_meta($pr_id,'_yoast_wpseo_primary_product_cat',true);
        if($primary_cat_id){
            $product_cat = get_term($primary_cat_id, 'product_cat');
            if(isset($product_cat->name))
                return $product_cat->name;
        }
        return $this->get_product_cats();
    }


    /**
     * @param string $before
     * @param string $sep
     * @param string $after
     * @return array
     */
    public function get_product_cats_for_sooqr($before = '', $sep = ' > ', $after = '') {
        $categories = [];
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            $term_list = wp_get_post_terms($this->product->get_parent_id(), 'product_cat');
            foreach ($term_list as $term) {
                if($term->parent) {
                    $categories['subcategories'][] = $term->name;
                }else {
                    $categories['categories'][] = $term->name;
                }
            }
            return $categories;
        }else {
            $term_list = wp_get_post_terms($this->product->get_id(), 'product_cat');
            foreach ($term_list as $term) {
                if($term->parent) {
                    $categories['subcategories'][] = $term->name;
                }else {
                    $categories['categories'][] = $term->name;
                }
            }
            return $categories;
        }
    }



    /**
     * Retrieve a product's dynamic attributes as a list with specified format.
     *
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     * @return string|false
     */
    protected function get_product_dynamic_tags( $id, $key, $before = '', $sep = ', ', $after = '' ) {
        return $this->get_the_term_list($id, $key, $before, $sep, $after );
    }

    /**
     * Retrieve a product's terms as a list with specified format.
     *
     *
     * @param int $id Product ID.
     * @param string $taxonomy Taxonomy name.
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     */
    protected function get_the_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {
        $terms = wp_get_post_terms( $id, $taxonomy , array( 'orderby' => 'term_id' ));
        if ( empty( $terms ) || is_wp_error( $terms ) ){
            return '';
        }

        $term_names = array();

        foreach ( $terms as $term ) {
            $term_names[] = $term->name;
        }

        ksort($term_names);

        return $before . join( $sep, $term_names ) . $after;
    }



    /**
     *
     * @param $id
     * @param $taxonomy
     * @param string $before
     * @param string $sep
     * @param string $after
     * @return string
     */
    protected function get_the_term_list_with_path( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {
        $terms = wp_get_post_terms( $id, $taxonomy , array( 'hide_empty' => false, 'parent' => 0, 'orderby' => 'term_id' ));
        if ( empty( $terms ) || is_wp_error( $terms ) ){
            return '';
        }
        $output = array();
        foreach ($terms as $term) {
            $term_names = [];
            $term_names[] = $term->name;

            $term_name_arr = $this->get_cat_names_array($id, $taxonomy, $term->term_id, $term_names);
            if(is_array($term_name_arr)) {
                $output[] = implode($sep, $this->get_cat_names_array($id, $taxonomy, $term->term_id, $term_names));
            }
        }

        return implode(' , ', $output);
    }


    protected function get_cat_names_array($id, $taxonomy, $parent, $term_name_array) {
        $terms = wp_get_post_terms( $id, $taxonomy , array( 'hide_empty' => false, 'parent' => $parent,'orderby' => 'term_id' ));
        if ( empty( $terms ) || is_wp_error( $terms ) ){
            return $term_name_array;
        }
        $term_name_array[] = $terms[0]->name;
        $term_name_array = $this->get_cat_names_array($id, $taxonomy, $terms[0]->term_id, $term_name_array);
        return $term_name_array;
    }



    /**
     * @param $id
     * @param $taxonomy
     * @param string $before
     * @param string $sep
     * @param string $after
     * @since 5.35
     */
    protected function get_the_term_list_with_separator( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {

    }


    /**
     * get product default attributes
     *
     * @param $product
     * @return mixed
     */
    protected function get_default_attributes($product) {
        if( method_exists( $product, 'get_default_attributes' ) ) {
            return $product->get_default_attributes();
        } else {
            return $product->get_variation_default_attributes();
        }
    }


    /**
     * Get matching variation
     *
     * @param $product
     * @param $attributes
     * @return int Matching variation ID or 0.
     * @throws Exception
     */
    protected function find_matching_product_variation( $product, $attributes ) {
        foreach( $attributes as $key => $value ) {
            if( strpos( $key, 'attribute_' ) === 0 ) {
                continue;
            }
            unset( $attributes[ $key ] );
            $attributes[ sprintf( 'attribute_%s', $key ) ] = $value;
        }
        if( class_exists('WC_Data_Store') ) {
            $data_store = WC_Data_Store::load( 'product' );
            return $data_store->find_matching_product_variation( $product, $attributes );
        } else {
            return $product->get_matching_variation( $attributes );
        }
    }


    /**
     * Set additional images url.
     *
     * @since    1.0.0
     */
    protected function set_additional_images() {

        $_product = $this->product;
        if($this->product->is_type('variation')) {
            $_product = wc_get_product($this->product->get_parent_id());
        }

        $img_ids = $_product->get_gallery_image_ids();

        $images = array();
        if ( ! empty( $img_ids ) ) {
            foreach ($img_ids as $key => $img_id) {
                $img_key = 'image_' . ($key+1);
                $images[$img_key] = wp_get_attachment_url($img_id);
            }
            // set images to the property
            $this->additional_images = $images;
        }

    }

    /**
     * Helper to check if a attribute is a Primary Attribute.
     *
     * @since    1.0.0
     */
    protected function is_primary_attr( $key ) {
        return array_key_exists( $key, $this->product_meta_keys['Primary Attributes'] );
    }

    /**
     * Helper to check if a attribute is a Image Attribute.
     *
     * @since    1.0.0
     */
    protected function is_image_attr( $key ) {
        return array_key_exists( $key, $this->product_meta_keys['Image Attributes'] );
    }

    /**
     * Helper to check if a attribute is a Product Attribute.
     *
     * @since    1.0.0
     */
    protected function is_product_attr( $key ) {
        return array_key_exists( $key, $this->product_meta_keys['Product Attributes'] );
    }


    /**
     * Helper to check if a attribute is a Product dynamic Attribute.
     *
     * @since    1.0.0
     */
    protected function is_product_dynamic_attr( $key ) {
        return array_key_exists( $key, $this->product_meta_keys['Product Dynamic Attributes'] );
    }


    /**
     * Helper to check if a attribute is a Product Custom Attribute.
     *
     * @since    1.0.0
     */
    protected function is_product_custom_attr( $key ) {
        return array_key_exists( $key, $this->product_meta_keys['Product Custom Attributes'] );
    }

    /**
     * Helper to check if a attribute is a Category Mapper.
     *
     * @since    1.0.0
     */
    protected function is_product_category_mapper_attr( $key ) {

        return array_key_exists( $key, $this->product_meta_keys['Category Map'] );
    }


    /**
     * Helper to get condition of a product.
     *
     * @since    1.0.0
     */
    protected function get_condition( ) {
        return 'New';
    }


    /**
     * Helper to get parent product id of a product.
     *
     * @return int
     */
    protected function get_item_group_id() {
        $id = $this->product->get_id();
        if($this->product->is_type('variation')) {
            $id = $this->product->get_parent_id();
        }
        return $id;
    }





    /**
     * Get grouped price
     *
     * @since    2.0.3
     */
    public function get_grouped_price($product, $type) {
        $groupProductIds = $product->get_children();
        $sum = 0;
        if(!empty($groupProductIds)){

            foreach($groupProductIds as $id){
                $product = wc_get_product($id);
                $regularPrice=$product->get_regular_price();
                $currentPrice=$product->get_price();
                if($type == "regular"){
                    $sum += $regularPrice;
                }else{
                    $sum += $currentPrice;
                }
            }
        }

        return $sum;
    }



    /**
     * Helper to get availability of a product
     *
     * @since    1.0.0
     */
    protected function get_availability( ) {
        if ( $this->product->is_in_stock() == TRUE ) {
            return 'in_stock';
        } else {
            return 'out_of_stock';
        }
    }


    /**
     * @return string
     */
    protected function get_stock( ) {
        if ( $this->product->is_in_stock() == TRUE ) {
            return 'Y';
        } else {
            return 'N';
        }
    }

    /**
     * Add neccessary prefix/suffix to a value.
     *
     * @since    1.0.0
     */
    protected function maybe_add_prefix_suffix($val, $rule) {
        $prefix =  $rule['prefix'];
        $suffix =  $rule['suffix'];

        if ( !empty( $prefix ) ) {
            $val = $val ? $prefix . $val : '';
        }

        if ( !empty( $suffix ) ) {
            $val = $val ? $val . $suffix : '';
        }

        return $val;
    }

    /**
     * Escape a value with specific escape method.
     *
     * @since    1.0.0
     */
    protected function maybe_escape($val, $escape) {
        switch ($escape){
            case 'strip_tags':
                return strip_tags($val);
            case 'utf_8_encode':
                return utf8_encode($val);
            case 'htmlentities':
                return htmlentities($val);
            case 'integer':
                return intval($val);
            case 'price':
                return intval($val);
            case 'remove_space':
                return preg_replace('/\s+/', '', $val);;
            case 'remove_shortcodes':
                return strip_shortcodes( $val );
            case 'remove_special':
                return filter_var($val, FILTER_SANITIZE_STRING);;
            case 'cdata':
                return $val ? "<![CDATA [$val]]>" : $val;
            case 'remove_underscore':
                return str_replace('_', ' ', $val);
            default:
                return $val;
                break;

        }
    }


    /**
     * Limit the output chars to specified length.
     *
     * @since    1.0.0
     */
    protected function maybe_limit($val, $limit) {
        $limit = (int) $limit;
        if ( $limit > 0) {
            return substr($val, 0, $limit);
        }
        return $val;
    }

    /**
     * Setup variation data if current product is a variable product.
     *
     * @since    1.0.0
     */
    protected function maybe_set_variation_data() {

        if ( 'WC_Product_Variation' != get_class($this->product) ) {
            return;
        }

        $variant_atts = $this->product->get_variation_attributes();

        foreach ($variant_atts as $key => $value) {
            $key = str_replace( 'attribute_pa_', '', $key);

            if( in_array($key, $this->variant_atts) ){
                $this->data[$key] = $value;
            }
        }

    }


    /**
     * Remove shortcode
     * from content
     *
     * @param $content
     * @return string
     * @since    2.0.3
     */

    public function remove_short_codes($content) {
        if(empty($content)){
            return "";
        }
        $content = $this->remove_invalid_xml($content);
        return strip_shortcodes($content);
    }



    /**
     * Removes invalid XML
     *
     * @param string $value
     * @return string
     */
    public function remove_invalid_xml($value) {

        $ret = "";
        $current = "";
        if (empty($value)) {
            return $ret;
        }

        $length = strlen($value);
        for ($i=0; $i < $length; $i++) {
            $current = ord($value{$i});
            if (($current == 0x9) ||
                ($current == 0xA) ||
                ($current == 0xD) ||
                (($current >= 0x20) && ($current <= 0xD7FF)) ||
                (($current >= 0xE000) && ($current <= 0xFFFD)) ||
                (($current >= 0x10000) && ($current <= 0x10FFFF)))
            {
                $ret .= chr($current);
            }
            else
            {
                $ret .= " ";
            }
        }
        return $ret;

    }





    /**
     * calculate the value of identifier_exists
     *
     * @return string
     * @since    1.2.5
     */

    public function calculate_identifier_exists ($data) {

        $identifier_exists = "no";

        if (array_key_exists("brand", $data) AND ($data['brand'] != "")){
            if ((array_key_exists("gtin", $data)) AND ($data['gtin'] != "")){
                $identifier_exists = "yes";
            } elseif ((array_key_exists("mpn", $data)) AND ($data['mpn'] != "")){
                $identifier_exists = "yes";
            } else {
                $identifier_exists = "no";
            }
        } else {
            if ((array_key_exists("gtin", $data)) AND ($data['gtin'] != "")){
                $identifier_exists = "no";
            } elseif ((array_key_exists("mpn", $data)) AND ($data['mpn'] != "")){
                $identifier_exists = "no";
            } else {
                $identifier_exists = "no";
            }
        }

        return $identifier_exists;
    }


    /**
     * Returns the product shipping cost.
     *
     * @return string
     */
    public function get_shipping_cost() {

        return '';
    }


    /**
     * Check if this product is child product or not
     *
     * @return bool
     * @since    1.0.0
     */
    protected function is_children(){
        return $this->product->get_parent_id() ? true: false;
    }



    function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }




    public function get_args($raw_args = false) {
        if(!$raw_args)
            $raw_args=  $this->args;

        $args = array(
            "post_type"=>array("product", "product_variation")
        );
        if(isset($raw_args["type"])&&$raw_args["type"]=="by-id")
        {
            $args['post__in'] = explode(",",$raw_args["ids"]);
        }
        else
        {
            //Tax queries
            if (isset($raw_args["tax_query"]["queries"])) {
                $args["tax_query"] = array();
                $args["tax_query"]["relation"] = $raw_args["tax_query"]["relation"];
                foreach ($raw_args["tax_query"]["queries"] as $query) {
                    array_push($args["tax_query"], $query);
                }
            }

            //Metas
            if (isset($raw_args["meta_query"]["queries"])) {
                $args["meta_query"] = array();
                $args["meta_query"]["relation"] = $raw_args["meta_query"]["relation"];
                foreach ($raw_args["meta_query"]["queries"] as $query) {
                    //Some operators expect an array as value
                    $array_operators = array('IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN');
                    if (in_array($query["compare"], $array_operators))
                        $query["value"] = explode(",", $query["value"]);
                    array_push($args["meta_query"], $query);
                }
            }

            //Other parameters
            $other_parameters = array("author__in", "post__not_in");
            foreach ($other_parameters as $parameter) {
                if (!isset($raw_args[$parameter]))
                    continue;
                if ($parameter == "post__not_in")
                    $args[$parameter] = explode(",", $raw_args[$parameter]);
                else if ($parameter == "author__in" && $raw_args[$parameter] == array(""))
                    continue;
                else
                    $args[$parameter] = $raw_args[$parameter];
            }
        }

        $args["nopaging"]=true;

        return $args;
    }



    /**
     * @param string $string
     * @return string
     */
    private function safeCharEncodeURL($string)
    {
        return str_replace(
            array('%', '[', ']', '{', '}', '|', ' ', '"', '<', '>', '#', '\\', '^', '~', '`'),
            array('%25', '%5b', '%5d', '%7b', '%7d', '%7c', '%20', '%22', '%3c', '%3e', '%23', '%5c', '%5e', '%7e', '%60'),
            $string);
    }


}