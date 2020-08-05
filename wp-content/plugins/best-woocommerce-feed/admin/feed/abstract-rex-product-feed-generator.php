<?php

/**
 * Abstract Rex Product Feed Generator
 *
 * A abstract class definition that includes functions used for generating xml feed.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 * The XML Feed Generator.
 *
 * This is used to generate xml feed based on given settings.
 *
 * @since      1.0.0
 * @package    Rex_Product_Feed_Abstract_Generator
 * @author     RexTheme <info@rextheme.com>
 */
abstract class Rex_Product_Feed_Abstract_Generator {

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
     * The feed rules containing all attributes and their value mappings for the feed.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $feed_rules    Contains attributes and value mappings for the feed.
     */
    protected $feed_rules;


    /**
     * The feed filter rules containing all condition and values for the feed.
     *
     * @since    1.1.10
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $feed_rules_filter    Contains condition and value for the feed.
     */
    protected $feed_rules_filter;

    /**
     * The Product Query args to retrieve specific products for making the Feed.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $products_args    Contains products query args for feed.
     */
    protected $products_args;

    /**
     * Array contains all products.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $products    Contains all products to make feed.
     */
    protected $products;

    /**
     * Array contains all variable products for creating feed with variations.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $products    Contains all products to make feed.
     */
    protected $variable_products;


    /**
     * Array contains all variable products for creating feed with variations.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    $products    Contains all products to make feed.
     */
    protected $grouped_products;



    /**
     * The Feed.
     * @since    1.0.0
     * @access   protected
     * @var Rex_Product_Feed_Abstract_Generator    $feed    Feed as text.
     */
    protected $feed;


    /**
     * Allowed Product
     *
     * @since    1.1.10
     * @access   private
     * @var      bool    $allowed
     */
    protected $allowed;



    /**
     * Post per page
     *
     * @since    1.0.0
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $posts_per_page
     */
    protected $posts_per_page;


    /**
     * Product Scope
     *
     * @since    1.1.10
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $product_scope
     */
    protected $product_scope;



    /**
     * Product Offset
     *
     * @since    1.3.0
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $offset
     */
    protected $offset;


    /**
     * Product Current Batch
     *
     * @since    1.3.0
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $batch
     */
    protected $batch;


    /**
     * Product Total Batch
     *
     * @since    1.3.0
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $tbatch
     */
    protected $tbatch;


    /**
     * Bypass functionality from child
     *
     * @since    2.0.0
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $bypass
     */
    protected $bypass;


    /**
     * Variable Product include/exclude
     *
     * @since    2.0.1
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $variable_product
     */
    protected $variable_product;

    /**
     * Product variations include/exclude
     *
     * @since    2.0.1
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $variations
     */
    protected $variations;


    /**
     * parent product include/exclude
     *
     * @since    2.0.3
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $parent_product
     */
    protected $parent_product;


    /**
     * Append variation
     * product name
     *
     * @since    3.2
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $append_variation
     */
    protected $append_variation;


    /**
     * wpml enable
     *
     * @since    2.2.2
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $wpml_language
     */
    protected $wpml_language;


    /**
     * enable logging
     *
     * @var Rex_Product_Feed_Abstract_Generator $is_logging_enabled
     */
    protected $is_logging_enabled;


    /**
     *
     * @var Rex_Product_Feed_Abstract_Generator $exclude_hidden_products
     */
    protected $exclude_hidden_products;


    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     * @param $config
     * @param $bypass
     * @since    1.0.0
     */
    public function __construct( $config, $bypass = false, $product_ids = array())
    {
        $this->products = [];
        $this->variable_products= [];
        $this->grouped_products = [];

        $this->config = $config;

        $this->is_logging_enabled = is_wpfm_logging_enabled();

        $this->bypass = $bypass;
        if ($this->bypass){
            if(!empty($product_ids)) {
                $this->id       =   $config['info']['post_id'];
                $this->title    =   $config['info']['title'];
                $this->desc     =   $config['info']['desc'];
                $this->batch    =   (int) $config['info']['batch'];
                $this->tbatch    =   (int) $config['info']['total_batch'];
                $this->append_variation   = $config['append_variations'];
                $this->feed_rules = $config['feed_config'];
                $this->feed_rules_filter = $config['feed_filter'];
                $this->variations   = $config['include_variations'];
                $this->variable_product   = $config['variable_product'];
                $this->parent_product   = $config['parent_product'];
                $this->append_variation   = $config['append_variations'];
                $this->exclude_hidden_products   = $config['exclude_hidden_products'];
                $this->wpml_language   = $config['wpml_language'];
                $this->product_scope   = $config['product_scope'];
                $this->products= $product_ids;

            }
            else {

                /**
                 * legacy code
                 * will be removed on
                 * future major release
                 */
                $this->setup_feed_data($config['info']);
                $this->feed_rules = $config['feed_config'];
                $this->product_scope = $config['product_scope'];
                $this->feed_rules_filter = $config['feed_filter'];
                $this->variations   = $config['include_variations'];
                $this->variable_product   = $config['variable_product'];
                $this->parent_product   = $config['parent_product'];
                $this->append_variation   = $config['append_variations'];
                $this->wpml_language   = $config['wpml_language'];
                $this->exclude_hidden_products   = $config['exclude_hidden_products'];
                $this->prepare_products_args($config['products']);
                $this->setup_products();
            }
        }
        else {
            $this->setup_feed_data($config['info']);
            $this->setup_feed_rules($config['feed_config']);
            $this->setup_feed_filter_rules($config['feed_config']);
            $this->setup_feed_meta($config['feed_config']);
            $this->prepare_products_args($config['products']);
            $this->setup_products();
        }

        $this->merchant = $config['merchant'];
        $this->feed_format = $config['feed_format'];

        /**
         * log for feed
         */
        if($this->is_logging_enabled) {
            $log = wc_get_logger();
            if($this->bypass) {
                if($this->batch == 1) {
                    $log->info(__( 'Start feed processing job by cron', 'rex-product-feed' ), array('source' => 'WPFM',));
                    $log->info('Feed ID: '.$config['info']['post_id'], array('source' => 'WPFM',));
                    $log->info('Feed Name: '.$config['info']['title'], array('source' => 'WPFM',));
                    $log->info('Merchant Type: '.$this->merchant, array('source' => 'WPFM',));
                }
                $log->info('Total Batches: '.$this->batch, array('source' => 'WPFM',));
                $log->info('Current Batch: '.$this->tbatch, array('source' => 'WPFM',));
            }
            else {
                if($this->batch == 1) {
                    $log->info(__( 'Start feed processing job.', 'rex-product-feed' ), array('source' => 'WPFM',));
                    $log->info('Feed ID: '.$config['info']['post_id'], array('source' => 'WPFM',));
                    $log->info('Feed Name: '.$config['info']['title'], array('source' => 'WPFM',));
                    $log->info('Merchant Type: '.$this->merchant, array('source' => 'WPFM',));
                }
                $log->info('Total Batches: '.$this->batch, array('source' => 'WPFM',));
                $log->info('Current Batch: '.$this->tbatch, array('source' => 'WPFM',));
            }
        }

        if($this->tbatch == $this->batch) {
            update_post_meta($this->id, 'updated', date("Y-m-d g:i:s"));
        }

    }


    /**
     * Prepare the Products Query args for retrieving  products.
     * @param $args
     */
    protected function prepare_products_args( $args ) {

        $this->product_scope = $args['products_scope'];
        $post_types = array(
            'product'
        );
        if($this->variations) {
            $post_types[] =  'product_variation';
        }

        if($this->product_scope == 'filter') {
            foreach ($this->feed_rules_filter as $filter) {
                $if = $filter['if'];

                if($if == 'product_cats') {
                    unset($post_types[1]);
                }

                if($if == 'product_tags') {
                    unset($post_types[1]);
                }
            }
        }

        $this->products_args = array(
            'post_type'              => $post_types,
            'fields'                 => 'ids',
            'post_status'            => 'publish',
            'posts_per_page'         => $this->posts_per_page,
            'offset'                 => $this->offset,
            'orderby'                => 'ID',
            'order'                  => 'ASC',
            'update_post_term_cache' => true,
            'update_post_meta_cache' => true,
            'cache_results'          => false,
            'suppress_filters'       => false,
        );

        if ( $args['products_scope'] === 'product_cat' || $args['products_scope'] === 'product_tag') {
            $this->products_args['post_type'] = 'product';
            $terms = $args['products_scope'] === 'product_tag' ? 'tags' : 'cats';
            if(is_array($args[$terms])) {
                foreach ($args[$terms] as $term) {
                    $this->products_args['tax_query'][] = array(
                        'taxonomy' => $args['products_scope'],
                        'field'    => 'slug',
                        'terms'    => $term,
                    );
                }
                $this->products_args['tax_query']['relation'] = 'OR';

                if($this->batch == 1) {
                    wp_set_object_terms($this->id, $args[$terms], $args['products_scope']);
                }
            }
        }
    }

    /**
     * Setup the Feed Related info
     * @param $info
     */
    protected function setup_feed_data( $info ){

        $this->tbatch   =   $info['total_batch'];
        $this->posts_per_page = $info['per_batch'];
        $this->id       =   $info['post_id'];
        $this->title    =   $info['title'];
        $this->desc     =   $info['desc'];
        $this->offset   =   $info['offset'];
        $this->batch    =   (int) $info['batch'];
        $this->link     =   esc_url( home_url('/') );
    }

    /**
     * Setup the rules
     * @param $info
     */
    protected function setup_feed_rules( $info ){
        $feed_rules       = array();
        parse_str( $info, $feed_rules );
        $this->product_scope = $feed_rules['rex_feed_products'];
        if($this->batch == 1) {
            if(array_key_exists('rex_feed_analytics_params_options', $feed_rules)) {
                $analytics_on = $feed_rules['rex_feed_analytics_params_options'];
                if($analytics_on) {
                    update_post_meta($this->id, 'rex_feed_analytics_params_options', $analytics_on);
                    if($analytics_on == 'on') {
                        $analytics_params = $feed_rules['rex_feed_analytics_params'];
                        update_post_meta($this->id, 'rex_feed_analytics_params', $analytics_params);
                    }
                }
            }
        }

        if ( function_exists('icl_object_id') ) {
            $this->wpml_language = array_key_exists('rex_feed_wpml_language', $feed_rules) ?
                $feed_rules['rex_feed_wpml_language'] :
                get_post_meta($this->id, 'rex_feed_wpml_language', true);
            update_post_meta( $this->id, 'rex_feed_wpml_language', ICL_LANGUAGE_CODE );
        }
        else {
            $this->wpml_language = false;
        }

        $feed_rules       = $feed_rules['fc'];
        $this->feed_rules = $feed_rules;

        // save the feed_rules into feed post_meta.
        if($this->batch == 1) {
            update_post_meta($this->id, 'rex_feed_feed_config', $this->feed_rules);
        }
    }


    /**
     * Setup the feed meta values
     *
     * @param $config
     */
    protected function setup_feed_meta( $config ){
        $feed_rules       = array();
        parse_str( $config, $feed_rules );
        $include_variable_product   = $feed_rules['rex_feed_variable_product'];
        $include_variations         = $feed_rules['rex_feed_variations'];
        $include_parent             = $feed_rules['rex_feed_parent_product'];
        $include_variations_name    = $feed_rules['rex_feed_variation_product_name'];
        $exclude_hidden_products    = $feed_rules['rex_feed_hidden_products'];

        if ($include_variable_product == 'yes') {
            $this->variable_product = true;
        }else {
            $this->variable_product = false;
        }

        if ($include_variations == 'yes') {
            $this->variations = true;
        }else {
            $this->variations = false;
        }

        if ($include_parent == 'yes') {
            $this->parent_product = true;
        }else {
            $this->parent_product = false;
        }

        if ($include_variations_name == 'yes') {
            $this->append_variation = 'yes';
        }else {
            $this->append_variation = 'no';
        }

        if ($exclude_hidden_products == 'yes') {
            $this->exclude_hidden_products = true;
        }else {
            $this->exclude_hidden_products = false;
        }
    }


    /**
     * Include Product Variations
     * @param $info
     * @return bool
     */
    protected function include_product_variations( $info ){
        $feed_rules       = array();
        parse_str( $info, $feed_rules );
        $include_variations       = $feed_rules['rex_feed_variations'];
        if ($include_variations == 'yes') {
            return true;
        }
        return false;
    }


    /**
     * Append product variation
     * name
     * @param $info
     * @return bool
     */
    protected function append_variation_product_name( $info ){
        $feed_rules       = array();
        parse_str( $info, $feed_rules );
        $include_variations       = $feed_rules['rex_feed_variation_product_name'];
        if ($include_variations === 'yes') {
            return true;
        }
        return false;
    }


    /**
     * Include Product Variations
     * @param $info
     * @return bool
     */
    protected function include_parent_product( $info ){
        $feed_rules       = array();
        parse_str( $info, $feed_rules );
        $include_parent       = $feed_rules['rex_feed_parent_product'];
        if ($include_parent === 'yes') {
            return true;
        }
        return false;
    }


    /**
     * Setup the rules for filter
     * @param $info
     */
    protected function setup_feed_filter_rules( $info ){

        if($this->product_scope === 'filter') {
            $feed_rules_filter       = array();
            parse_str( $info, $feed_rules_filter );
            $feed_rules_filter          = $feed_rules_filter['ff'];
            $this->feed_rules_filter    = $feed_rules_filter;
            // save the feed_rules_filter into feed post_meta.
            if($this->batch == 1) {
                update_post_meta($this->id, 'rex_feed_feed_config_filter', $this->feed_rules_filter);
            }
        }

    }


    /**
     * Get the products to generate feed
     */
    protected function setup_products() {

        if ( function_exists('icl_object_id') ) {
            global $sitepress;
            $sitepress->switch_lang($this->wpml_language);
        }
        if($this->product_scope === 'filter') {

            $filter_args = Rex_Product_Filter::createFilterQueryParams($this->feed_rules_filter);
            add_filter( 'posts_where', array($this, 'wpfm_post_title_filter'), 10, 2 );
            foreach ($filter_args['args'] as $key => $value) {
                $this->products_args[$key] = $value;
            }
            if(array_key_exists('meta_query', $this->products_args)) {
                $this->products_args['meta_query']['relation'] = 'OR';
            }

            if(array_key_exists('tax_query', $this->products_args)) {
                $this->products_args['tax_query']['relation'] = 'AND';
            }

        }

        $result = new WP_Query($this->products_args);
        $this->products = $result->get_posts();

        if(is_array($this->products)) {
            $this->products = array_unique($this->products);
            if($this->batch == 1) {
                update_post_meta($this->id, 'rex_feed_product_ids', $this->products);
            }else {
                if(get_post_meta($this->id, 'rex_feed_product_ids', true)) {
                    $prev_product_ids = get_post_meta($this->id, 'rex_feed_product_ids', true);
                    $product_ids = array_merge($prev_product_ids, $this->products);
                    update_post_meta($this->id, 'rex_feed_product_ids', $product_ids);
                }else {
                    update_post_meta($this->id, 'rex_feed_product_ids', $this->products);
                }
            }
            remove_filter( 'posts_where', array($this, 'wpfm_post_title_filter'), 10, 2 );
        }
    }


    /**
     * product serach by title
     * @param $where
     * @param $wp_query
     * @return string
     */
    function wpfm_post_title_filter($where, $wp_query) {
        global $wpdb;
        if($wp_query->get('title_contain')) {
            $title_contain = $wp_query->get('title_contain');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'AND' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_title LIKE \'%' . $wpdb->esc_like( $title ) . '%\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('title_dn_contain')) {
            $title_dn_contain = $wp_query->get('title_dn_contain');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'AND' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_title NOT LIKE \'%' . $wpdb->esc_like( $title ) . '%\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('title_equal_to')) {
            $title_dn_contain = $wp_query->get('title_equal_to');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'AND' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_title = \'' . $wpdb->esc_like( $title ) . '\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('title_nequal_to')) {
            $title_dn_contain = $wp_query->get('title_nequal_to');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'AND' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_title <> \'' . $wpdb->esc_like( $title ) . '\'';
            };
            $where .= ' )';

        }


        if($wp_query->get('description_contain')) {
            $title_contain = $wp_query->get('title_contain');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_content LIKE \'%' . $wpdb->esc_like( $title ) . '%\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('description_dn_contain')) {
            $title_dn_contain = $wp_query->get('title_dn_contain');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_content NOT LIKE \'%' . $wpdb->esc_like( $title ) . '%\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('description_equal_to')) {
            $title_dn_contain = $wp_query->get('title_equal_to');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_content = \'' . $wpdb->esc_like( $title ) . '\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('description_nequal_to')) {
            $title_dn_contain = $wp_query->get('title_nequal_to');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_content <> \'' . $wpdb->esc_like( $title ) . '\'';
            };
            $where .= ' )';

        }


        if($wp_query->get('sdescription_contain')) {
            $title_contain = $wp_query->get('title_contain');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_excerpt LIKE \'%' . $wpdb->esc_like( $title ) . '%\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('sdescription_dn_contain')) {
            $title_dn_contain = $wp_query->get('title_dn_contain');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_excerpt NOT LIKE \'%' . $wpdb->esc_like( $title ) . '%\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('sdescription_equal_to')) {
            $title_dn_contain = $wp_query->get('title_equal_to');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_excerpt = \'' . $wpdb->esc_like( $title ) . '\'';
            };
            $where .= ' )';
        }
        if($wp_query->get('sdescription_nequal_to')) {
            $title_dn_contain = $wp_query->get('title_nequal_to');
            $i = 0;
            $where .= ' AND (';
            foreach ($title_dn_contain as $title) {
                $i = $i + 1;
                $op = ($i > 1)? 'OR' : '';
                $where .= ' '. $op. ' '. $wpdb->posts . '.post_excerpt <> \'' . $wpdb->esc_like( $title ) . '\'';
            };
            $where .= ' )';

        }

        if($wp_query->get('post__greater_than')) {
            $post_greater_than_id = $wp_query->get('post__greater_than');
            $where .= ' AND (ID > '. $post_greater_than_id . ')';
        }
        if($wp_query->get('post__greater_than_equal')) {
            $post_greater_than_equal_id = $wp_query->get('post__greater_than_equal');
            $where .= ' AND (ID >= '. $post_greater_than_equal_id . ')';
        }
        if($wp_query->get('post__less_than')) {
            $post_less_than_id = $wp_query->get('post__less_than');
            $where .= ' AND (ID < '. $post_less_than_id . ')';
        }
        if($wp_query->get('post__less_than_equal')) {
            $post_less_than_equal_id = $wp_query->get('post__less_than_equal');
            $where .= ' AND (ID <= '. $post_less_than_equal_id . ')';
        }

        return $where;
    }




    /**
     * Setup the variable products from products array.
     */
    protected function setup_group_products() {

        $this->grouped_products = array();

        // Loop through all products and separate the variable products.
        foreach( $this->products as $product_id ) {
            if( $this->is_grouped_product( $product_id ) ){
                $this->grouped_products[] = $product_id;
            }
        }

        // remove variable products from products array
        if ( !empty( $this->grouped_products ) ) {
            $this->products = array_diff( $this->products, $this->grouped_products );
        }

        // remove all variable product if product variations is exclude
        if (!$this->parent_product) {
            $this->grouped_products = array();
        }
    }



    /**
     * Setup the variable products from products array.
     */
    protected function is_variable_product( $product_id = false ) {

        if ( false === $product_id ) {
            return false;
        }

        $product = wc_get_product( $product_id );

        if( $product->is_type( 'variable' ) ){
            return true;
        }

        return false;
    }





    /**
     * Check if simple product
     * or not
     * @param bool $product_id
     * @return bool
     */
    protected function is_simple_product( $product_id = false ) {

        if ( false === $product_id ) {
            return false;
        }
        $product = wc_get_product( $product_id );
        if( $product->is_type( 'simple' ) ){
            return true;
        }
        return false;
    }


    /**
     * Check if this is child product
     * @param bool $product_id
     * @return bool
     */
    protected function is_variation_product( $product_id = false ) {

        if ( false === $product_id ) {
            return false;
        }

        $product = wc_get_product( $product_id );
        $type = get_post_type($product_id);
        if($type) {
            if($type === 'product_variation') {
                $parent_post_status = get_post_status($product->get_parent_id());
                if($parent_post_status === 'publish') {
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }




    /**
     * Setup the variable products from products array.
     */
    protected function is_grouped_product( $product_id = false ) {

        if ( false === $product_id ) {
            return false;
        }

        $product = wc_get_product( $product_id );

        if( $product->is_type( 'grouped' ) ){
            return true;
        }

        return false;
    }


    /**
     * Get product data
     * @param WC_Product $product
     * @return string
     */
    protected function get_product_data( WC_Product $product, $product_meta_keys ){
        $include_analytics_params = get_post_meta($this->id, 'rex_feed_analytics_params_options', true);

        if($include_analytics_params == 'on') {
            $analytics_params = get_post_meta($this->id, 'rex_feed_analytics_params', true);
        }else {
            $analytics_params = null;
        }

        if ( function_exists('icl_object_id') ) {
            global $sitepress;
            $wpml = get_post_meta($this->id, 'rex_feed_wpml_language', true) ? get_post_meta($this->id, 'rex_feed_wpml_language', true)  : $sitepress->get_default_language();
            if($wpml) {
                $sitepress->switch_lang($wpml);
                $data = new Rex_Product_Data_Retriever( $product, $this->feed_rules, null, $this->append_variation, $product_meta_keys, $analytics_params);
            }
        }else{
            $data = new Rex_Product_Data_Retriever( $product, $this->feed_rules, null, $this->append_variation, $product_meta_keys, $analytics_params);
        }
        return $data->get_all_data();
    }


    /**
     * Save the feed as XML file.
     *
     * @return bool
     */
    protected function save_feed($format){

        $path  = wp_upload_dir();
        $baseurl = $path['baseurl'];
        $path  = $path['basedir'] . '/rex-feed';


        // make directory if not exist
        if ( !file_exists($path) ) {
            wp_mkdir_p($path);
        }
        if($this->is_logging_enabled) {
            $log = wc_get_logger();
            if($this->batch == $this->tbatch) {
                $log->info(__( 'Completed feed generation job.', 'rex-product-feed' ), array('source' => 'WPFM',));
                $log->info('**************************************************', array('source' => 'WPFM',));
            }
        }


        if($format == 'xml'){
            $file = trailingslashit($path) . "feed-{$this->id}.xml";
            update_post_meta($this->id, 'rex_feed_xml_file', $baseurl . '/rex-feed' . "/feed-{$this->id}.xml");
            update_post_meta($this->id, 'rex_feed_merchant', $this->merchant);
            if( file_exists($file) ) {
                if($this->batch == 1) {
                    return file_put_contents($file, $this->feed) ? 'true' : 'false';
                }else {

                    $feed = $this->merge_feeds($file);
                    if ($feed)
                        return file_put_contents($file, $feed) ? 'true' : 'false';
                    return file_put_contents($file, $this->feed) ? 'true' : 'false';
                }
            }else{
                return file_put_contents($file, $this->feed) ? 'true' : 'false';
            }
        }
        elseif ($format == 'text'){
            $file = trailingslashit($path) . "feed-{$this->id}.txt";
            update_post_meta($this->id, 'rex_feed_xml_file', $baseurl . '/rex-feed' . "/feed-{$this->id}.xml");
            update_post_meta($this->id, 'rex_feed_merchant', $this->merchant);
            if( file_exists($file) ) {
                if($this->batch == 1) {
                    return file_put_contents($file, $this->feed) ? 'true' : 'false';
                }else {
                    $feed = preg_replace('/^.+\n/', '', $this->feed);
                    if($feed)
                        return file_put_contents($file, $feed, FILE_APPEND) ? 'true' : 'false';
                    return 'true';
                }
            }else{
                return file_put_contents($file, $this->feed) ? 'true' : 'false';
            }
        }
        elseif ($format == 'csv'){
            $file = trailingslashit($path) . "feed-{$this->id}.csv";
            update_post_meta($this->id, 'rex_feed_xml_file', $baseurl . '/rex-feed' . "/feed-{$this->id}.csv");
            update_post_meta($this->id, 'rex_feed_merchant', $this->merchant);
            if($this->batch == 1) {
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
            else {

                $file = fopen($file,"a+");

                $list = $this->feed;
                array_shift($list);
                foreach ($list as $line)
                {
                    fputcsv($file,$line);
                }
                fclose($file);
                return 'true';
            }
        }
        else{
            $file = trailingslashit($path) . "feed-{$this->id}.xml";
            update_post_meta($this->id, 'rex_feed_xml_file', $baseurl . '/rex-feed' . "/feed-{$this->id}.xml");
            update_post_meta($this->id, 'rex_feed_merchant', $this->merchant);
            if( file_exists($file) ) {
                if($this->batch == 1) {
                    return file_put_contents($file, $this->feed) ? 'true' : 'false';
                }else {
                    $feed = $this->merge_feeds($file);
                    return file_put_contents($file, $feed) ? 'true' : 'false';
                }
            }else{
                return file_put_contents($file, $this->feed) ? 'true' : 'false';
            }
        }
    }


    /**
     * Responsible for merge batch feeds.
     * @return string
     **/

    protected function merge_feeds($prev_feed){

        $xml_str = simplexml_load_file($prev_feed)->asXML();
        $orgdoc = new DOMDocument;
        $orgdoc->loadXML($xml_str);

        if($this->merchant === 'google' || $this->merchant === 'facebook' || $this->merchant === 'pinterest'|| $this->merchant === 'ciao' ||
            $this->merchant === 'daisycon'  || $this->merchant === 'instagram'|| $this->merchant === 'liveintent' || $this->merchant === 'rss' ||
            $this->merchant === 'google_shopping_actions' || $this->merchant === 'google_express' || $this->merchant === 'doofinder' || $this->merchant === 'emarts' || $this->merchant === 'epoq'
        ) {
            $parent = $orgdoc->getElementsByTagName('channel')->item(0);
        }elseif ($this->merchant === 'ebay_mip') {
            $parent = $orgdoc->getElementsByTagName('productRequest')->item(0);
        }elseif ($this->merchant === 'ceneo') {
            $parent = $orgdoc->getElementsByTagName('offers')->item(0);
        }elseif ($this->merchant === 'heureka') {
            $parent = $orgdoc->getElementsByTagName('SHOP')->item(0);
        }elseif ($this->merchant === 'marktplaats') {
            $parent = $orgdoc->getElementsByTagName('admarkt:ads');
        }elseif ($this->merchant === 'yandex') {
            $parent = $orgdoc->getElementsByTagName('offers')->item(0);
        }elseif ($this->merchant === 'zbozi') {
            $parent = $orgdoc->getElementsByTagName('SHOP')->item(0);
        }elseif ($this->merchant === 'skroutz') {
            $parent = $orgdoc->getElementsByTagName('mywebstore')->item(0);
        }elseif ($this->merchant === 'google_review') {
            $parent = $orgdoc->getElementsByTagName('reviews')->item(0);
        }elseif ($this->merchant === 'vivino') {
            $parent = $orgdoc->getElementsByTagName('vivino-product-list')->item(0);
        }elseif ($this->merchant === 'trovaprezzi') {
            $parent = $orgdoc->getElementsByTagName('Products')->item(0);
        }elseif ($this->merchant === 'datatrics') {
            $parent = $orgdoc->getElementsByTagName('items')->item(0);
        }elseif ($this->merchant === 'domodi') {
            $parent = $orgdoc->getElementsByTagName('SHOP')->item(0);
        }elseif ($this->merchant === 'drezzy') {
            $parent = $orgdoc->getElementsByTagName('items')->item(0);
        }elseif ($this->merchant === 'homebook') {
            $parent = $orgdoc->getElementsByTagName('offers')->item(0);
        }elseif ($this->merchant === 'homedeco') {
            $parent = $orgdoc->getElementsByTagName('items')->item(0);
        }elseif ($this->merchant === 'glami') {
            $parent = $orgdoc->getElementsByTagName('SHOP')->item(0);
        }elseif ($this->merchant === 'fashiola') {
            $parent = $orgdoc->getElementsByTagName('items')->item(0);
        }elseif ($this->merchant === 'emag') {
            $parent = $orgdoc->getElementsByTagName('shop')->item(0);
        }elseif ($this->merchant === 'grupo_zap') {
            $parent = $orgdoc->getElementsByTagName('Listings')->item(0);
        }elseif ($this->merchant === 'lyst') {
            $parent = $orgdoc->getElementsByTagName('channel')->item(0);
        }elseif ($this->merchant === 'listupp') {
            $parent = $orgdoc->getElementsByTagName('items')->item(0);
        }elseif ($this->merchant === 'hertie') {
            $parent = $orgdoc->getElementsByTagName('Artikel')->item(0);
        }
        else {
            $parent = $orgdoc->getElementsByTagName('products')->item(0);
        }

        if(!$parent)
            return $parent;

        // Create a new document
        $newdoc = new DOMDocument;
        $newdoc->loadXML($this->feed);

        // The node we want to import to a new document

        if($this->merchant === 'google' || $this->merchant === 'facebook' || $this->merchant === 'pinterest'|| $this->merchant === 'ciao' ||
            $this->merchant === 'daisycon'  || $this->merchant === 'instagram'|| $this->merchant === 'liveintent' || $this->merchant === 'rss' ||
            $this->merchant === 'google_shopping_actions' || $this->merchant === 'google_express' || $this->merchant === 'doofinder' || $this->merchant === 'emarts' || $this->merchant === 'epoq'
        ) {
            $node = $newdoc->getElementsByTagName("item");
        }
        elseif ($this->merchant === 'ebay_mip') {
            if($newdoc->getElementsByTagName("product")) {
                $node = $newdoc->getElementsByTagName("product");
            }
            else {
                $node = $newdoc->getElementsByTagName("productVariationGroup");
            }
        }
        elseif ($this->merchant === 'ceneo') {
            $node = $newdoc->getElementsByTagName("o");
        }elseif ($this->merchant === 'heureka') {
            $node = $newdoc->getElementsByTagName("SHOPITEM");
        }elseif ($this->merchant === 'marktplaats') {
            $node = $newdoc->getElementsByTagName("admarkt:ad");
        }elseif ($this->merchant === 'trovaprezzi') {
            $node = $newdoc->getElementsByTagName("Offer");
        }elseif ($this->merchant === 'yandex') {
            $node = $newdoc->getElementsByTagName("offer");
        }elseif ($this->merchant === 'zbozi') {
            $node = $newdoc->getElementsByTagName("SHOPITEM");
        }elseif ($this->merchant === 'skroutz') {
            $node = $newdoc->getElementsByTagName("product");
        }elseif ($this->merchant === 'google_review') {
            $node = $newdoc->getElementsByTagName("feed");
        }elseif ($this->merchant === 'datatrics') {
            $node = $newdoc->getElementsByTagName("item");
        }elseif ($this->merchant === 'domodi') {
            $node = $newdoc->getElementsByTagName("SHOPITEM");
        }elseif ($this->merchant === 'drezzy') {
            $node = $newdoc->getElementsByTagName("item");
        }elseif ($this->merchant === 'homebook') {
            $node = $newdoc->getElementsByTagName("offer");
        }elseif ($this->merchant === 'homedeco') {
            $node = $newdoc->getElementsByTagName("item");
        }elseif ($this->merchant === 'glami') {
            $node = $newdoc->getElementsByTagName("SHOPITEM");
        }elseif ($this->merchant === 'fashiola') {
            $node = $newdoc->getElementsByTagName("item");
        }elseif ($this->merchant === 'emag') {
            $node = $newdoc->getElementsByTagName("product");
        }elseif ($this->merchant === 'grupo_zap') {
            $node = $newdoc->getElementsByTagName("Listing");
        }elseif ($this->merchant === 'lyst') {
            $node = $newdoc->getElementsByTagName("item");
        }elseif ($this->merchant === 'listupp') {
            $node = $newdoc->getElementsByTagName("item");
        }elseif ($this->merchant === 'hertie') {
            $node = $newdoc->getElementsByTagName("Katalog");
        }else {
            $node = $newdoc->getElementsByTagName("product");
        }

        for ($i = 0; $i < $node->length; $i ++) {
            $item = $node->item($i);
            if ($item != NULL) {
                $item = $orgdoc->importNode($item, true);
                $parent->appendChild($item);
            }
        }
        return $orgdoc->saveXML();
    }


    function cleanString($string)
    {
        // allow only letters
        $res = preg_replace("/[^a-zA-Z]/", "", $string);

        // trim what's left to 8 chars
        $res = substr($res, 0, 8);

        // make lowercase
        $res = strtolower($res);

        // return
        return $res;
    }


    /**
     * Responsible for creating the feed.
     * @return string
     **/
    abstract public function make_feed();

}
