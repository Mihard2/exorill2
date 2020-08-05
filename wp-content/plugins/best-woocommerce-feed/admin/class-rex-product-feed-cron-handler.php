<?php

/**
 * The Rex_Product_Feed_Cron_Handler class file that
 * handle the schedule feed update
 *
 * @link       https://rextheme.com
 * @since      2.0.0
 *
 * @package    Rex_Product_Feed_Cron_Handler
 * @subpackage Rex_Product_Feed/admin
 */

class Rex_Product_Feed_Cron_Handler {


    /**
     * Feed ids
     *
     * @since    2.0.0
     * @access   protected
     * @var      string    $feed_ids
     */
    protected $feed_ids;


    /**
     * Feed Schedule
     *
     * @since    2.0.0
     * @access   protected
     * @var      string    $schedule
     */
    protected $schedule;


    /**
     * Background Processor
     *
     * @since    2.0.0
     * @access   protected
     * @var      string    $background_process
     */
    protected $background_process;

    protected $batch_array;

    /**
     * Initialize the class and set its properties.
     *
     * @since    2.0.0
     */
    public function __construct() {
        $this->batch_array = array();
        $this->background_process = new Rex_Product_Feed_Background_Process();
    }


    /**
     * Initialize Cron
     *
     * @since    2.0.0
     */
    public function rex_feed_cron_handler() {
        $hour = date('H');
        $schedule = 'hourly';
        if($hour == 07){
            $schedule = 'daily';
        }
        $this->feed_ids = $this->get_feeds($schedule);
        $this->rex_feed_init_batch();
        $this->rex_feed_create_batch();
    }


    /**
     * weekly cron
     */
    public function rex_feed_weekly_cron_handler() {
        $this->feed_ids = $this->get_feeds('weekly');
        $this->rex_feed_init_batch();
        $this->rex_feed_create_batch();
    }


    /**
     * Get all feeds
     *
     * @param string $schedule
     * @return int[]|WP_Post[]
     */
    public function get_feeds( $schedule = 'hourly' ) {
        $meta_query = array();
        $meta_query[] = array(
            'key'      => 'rex_feed_schedule',
            'value'    => 'hourly',
        );
        if($schedule === 'daily') {
            $meta_query[] = array(
                'key'      => 'rex_feed_schedule',
                'value'    => 'daily',
            );
            $meta_query['relation'] = 'OR';
        }
        if($schedule === 'weekly') {
            $meta_query[] = array(
                'key'      => 'rex_feed_schedule',
                'value'    => 'weekly',
            );
            $meta_query['relation'] = 'OR';
        }

        $args = array(
            'post_type'      => 'product-feed',
            'post_status'    => array('publish'),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query'     => $meta_query,
        );
        $query = new WP_Query( $args );
        return $query->get_posts();
    }


    /**
     * init batch object
     *
     * @return string
     */
    private function rex_feed_init_batch() {
        if ($this->feed_ids) {
            foreach ($this->feed_ids as $feed_id) {
                $product_ids = get_post_meta($feed_id, 'rex_feed_product_ids', true);
                if(is_array($product_ids)) {
                    $per_page = get_option('rex-wpfm-product-per-batch', 50);
                    $product_id_chunks = array_chunk($product_ids, $per_page);
                    $total_batches = count($product_id_chunks);
                    $i = 0;
                    foreach ($product_id_chunks as $product_id_chunk) {
                        $i = $i+1;
                        $merchant = get_post_meta($feed_id, 'rex_feed_merchant', true);
                        $feed_config = get_post_meta($feed_id, 'rex_feed_feed_config', true);
                        $feed_filter = get_post_meta($feed_id, 'rex_feed_feed_config_filter', true);
                        $feed_products = get_post_meta($feed_id, 'rex_feed_products', true);
                        $include_variations = get_post_meta($feed_id, 'rex_feed_variations', true) === 'yes' ? true : false;
                        $variable_product = get_post_meta($feed_id, 'rex_feed_variable_product', true) === 'yes' ? true : false;
                        $parent_product = get_post_meta($feed_id, 'rex_feed_parent_product', true) === 'yes' ? true : false;
                        $exclude_hidden_products = get_post_meta($feed_id, 'rex_feed_hidden_products', true) === 'yes' ? true : false;
                        $append_variations = get_post_meta($feed_id, 'rex_feed_variation_product_name', true) === 'yes' ? true : false;
                        $wpml = get_post_meta($feed_id, 'rex_feed_wpml_language', true) ? get_post_meta($feed_id, 'rex_feed_wpml_language', true) : '';
                        $feed_format = get_post_meta($feed_id, 'rex_feed_feed_format', true) ?
                            get_post_meta($feed_id, 'rex_feed_feed_format', true) : 'xml';

                        $payload = array(
                            'merchant' => $merchant,
                            'feed_format' => $feed_format,
                            'feed_config'    => $feed_config,
                            'append_variations' => $append_variations,
                            'info'      => array(
                                'post_id'   => $feed_id,
                                'title'     => get_the_title($feed_id),
                                'desc'      => get_the_title($feed_id),
                                'total_batch' => $total_batches,
                                'batch'     => $i,
                            ),
                            'feed_filter'    => $feed_filter,
                            'include_variations' => $include_variations,
                            'variable_product' => $variable_product,
                            'parent_product' => $parent_product,
                            'product_scope' => $feed_products,
                            'exclude_hidden_products' => $exclude_hidden_products,
                            'wpml_language' => $wpml,
                        );
                        try {
                            
                            $merchant = Rex_Product_Feed_Factory::build( $payload, true, $product_id_chunk );
                        } catch (Exception $e) {
                            return $e->getMessage();
                        }
                        $this->batch_array[$feed_id][] = $merchant;
                    }
                }
                else {
                    $product_no = apply_filters('wpfm_get_total_number_of_products',
                        array('products'  => 50)
                    );
                    $is_premium = apply_filters('wpfm_is_premium', false);
                    $per_page = get_option('rex-wpfm-product-per-batch', 50);
                    $per_batch = $is_premium ? (int)$per_page : ((int)$per_page >= 50 ? 50 : (int)$per_page);
                    $total_batches = ceil($product_no['products']/(int) $per_batch);
                    $offset = 0;
                    $batch = 1;
                    for ($i = 1; $i<=$total_batches; $i++) {
                        $cats_array = $tags_array = array();
                        $merchant = get_post_meta($feed_id, 'rex_feed_merchant', true);
                        $feed_config = get_post_meta($feed_id, 'rex_feed_feed_config', true);
                        $feed_filter = get_post_meta($feed_id, 'rex_feed_feed_config_filter', true);
                        $feed_products = get_post_meta($feed_id, 'rex_feed_products', true);
                        $include_variations = get_post_meta($feed_id, 'rex_feed_variations', true) === 'yes' ? true : false;
                        $parent_product = get_post_meta($feed_id, 'rex_feed_variable_product', true) === 'yes' ? true : false;
                        $variable_product = get_post_meta($feed_id, 'rex_feed_parent_product', true) === 'yes' ? true : false;
                        $append_variations = get_post_meta($feed_id, 'rex_feed_variation_product_name', true) === 'yes' ? true : false;
                        $wpml = get_post_meta($feed_id, 'rex_feed_wpml_language', true) ? get_post_meta($feed_id, 'rex_feed_wpml_language', true) : '';
                        if ( $feed_products !== 'all' && $feed_products !== 'filter') {
                            $terms = $feed_products === 'product_tag' ? 'tags' : 'cats';

                            if ( function_exists('icl_object_id') ) {
                                if($terms == 'tags' ) {
                                    $tags = wp_get_post_terms($feed_id, 'product_tag');
                                    if($tags) {
                                        foreach($tags as $tag) {
                                            global $wpdb;
                                            $translated_term = icl_object_id( $tag->term_id, 'product_tag', true, $wpml );
                                            $term_slug = $wpdb->get_row("SELECT * FROM $wpdb->terms WHERE term_id = $translated_term");
                                            if($term_slug) {
                                                $tags_array[] = $term_slug->slug;
                                            }
                                        }
                                    }
                                }elseif ($terms == 'cats'){
                                    $cats = wp_get_post_terms($feed_id, 'product_cat');
                                    if($cats) {
                                        foreach($cats as $cat) {
                                            global $wpdb;
                                            $translated_term = icl_object_id( $cat->term_id, 'product_cat', true, $wpml );
                                            $term_slug = $wpdb->get_row("SELECT * FROM $wpdb->terms WHERE term_id = $translated_term");
                                            if($term_slug) {
                                                $cats_array[] = $term_slug->slug;
                                            }

                                        }
                                    }
                                }

                            }else {
                                if($terms == 'tags' ) {
                                    $tags = wp_get_post_terms($feed_id, 'product_tag');
                                    if($tags) {
                                        foreach($tags as $tag) {
                                            $tags_array[] = $tag->slug;
                                        }
                                    }
                                }elseif ($terms == 'cats'){
                                    $cats = wp_get_post_terms($feed_id, 'product_cat');
                                    if($cats) {
                                        foreach($cats as $cat) {
                                            $cats_array[] = $cat->slug;
                                        }
                                    }
                                }
                            }
                        }
                        $feed_format = get_post_meta($feed_id, 'rex_feed_feed_format', true) ?
                            get_post_meta($feed_id, 'rex_feed_feed_format', true) : 'xml';
                        $payload = array(
                            'merchant' => $merchant,
                            'feed_format' => $feed_format,
                            'info'      => array(
                                'post_id'   => $feed_id,
                                'title'     => get_the_title($feed_id),
                                'desc'      => get_the_title($feed_id),
                                'offset'    => $offset,
                                'batch'     => $batch,
                                'total_batch' => $total_batches,
                                'per_batch' => $per_batch
                            ),
                            'products'   => array(
                                'products_scope'    => $feed_products,
                                'cats'              => $cats_array,
                                'tags'              => $tags_array,
                            ),
                            'feed_config'    => $feed_config,
                            'feed_filter'    => $feed_filter,
                            'include_variations' => $include_variations,
                            'append_variations' => $append_variations,
                            'variable_product' => $variable_product,
                            'parent_product' => $parent_product,
                            'product_scope' => $feed_products,
                            'wpml_language' => $wpml,
                        );
                        try {
                            $merchant = Rex_Product_Feed_Factory::build( $payload, true );
                        }
                        catch (Exception $e) {
                            return $e->getMessage();
                        }
                        $batch++;
                        $offset = (int)$offset + (int) $per_batch;
                        $this->batch_array[$feed_id][] = $merchant;
                    }
                }
            }
        }
    }


    /*
     * create the background process
     */
    private function rex_feed_create_batch() {
        if($this->batch_array) {
            foreach ($this->batch_array as $feed_id => $batches) {
                if(!(Rex_Product_Feed_Controller::check_feed_id_in_queue($feed_id))){
                    Rex_Product_Feed_Controller::add_id_to_feed_queue($feed_id);
                    Rex_Product_Feed_Controller::update_feed_status($feed_id, 'processing');
                }
                foreach ($batches as $merchant) {
                    $this->background_process->push_to_queue($merchant);
                }
            }
        }
        $this->background_process->save()->dispatch();
    }
}


