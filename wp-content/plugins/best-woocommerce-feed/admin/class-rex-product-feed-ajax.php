<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Metabox
 * @subpackage Rex_Product_Feed/admin
 */


class Rex_Product_Feed_Ajax {

    /**
     * The Product/Feed Config.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Abstract_Generator    config    Feed config.
     */
    protected $config;


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
     * Product Scope
     *
     * @since    1.1.10
     * @access   private
     * @var      Rex_Product_Feed_Abstract_Generator    $product_scope
     */
    protected $product_scope;

    /**
     * Hook in ajax handlers.
     *
     * @since    1.0.0
     */
    public static function init() {

        $validations = array(
            'logged_in' => true,
            'user_can'  => 'manage_options',
        );

        wp_ajax_helper()->handle( 'my-handle' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'get_product_number' ) )
            ->with_validation( $validations );


        wp_ajax_helper()->handle( 'generate-feed' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'generate_feed' ) )
            ->with_validation( $validations );


        wp_ajax_helper()->handle( 'generate-promotion-feed' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'generate_promotion_feed' ) )
            ->with_validation( $validations );


        wp_ajax_helper()->handle( 'save-feed' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'save_feed' ) )
            ->with_validation( $validations );

        wp_ajax_helper()->handle( 'merchant-change' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'show_feed_template' ) )
            ->with_validation( $validations );


        /**
         * product taxonomies ajax
         */
        wp_ajax_helper()->handle( 'fetch-product-taxonomies' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'fetch_product_taxonomies' ) )
            ->with_validation( $validations );


        /**
         * Stop Admin Notices
         */
        wp_ajax_helper()->handle( 'stop-notices' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'stop_notices' ) )
            ->with_validation( $validations );

        /**
         * Google Category Mapping
         */
        wp_ajax_helper()->handle( 'category-mapping' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'category_mapping' ) )
            ->with_validation( $validations );

        wp_ajax_helper()->handle( 'category-mapping-update' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'category_mapping_update' ) )
            ->with_validation( $validations );

        wp_ajax_helper()->handle( 'category-mapping-delete' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'category_mapping_delete' ) )
            ->with_validation( $validations );


        /**
         * Google merchant settings
         */
        wp_ajax_helper()->handle( 'google-merchant-settings' )
            ->with_callback( array( 'Rex_Google_Merchant_Settings_Api', 'save_settings' ) )
            ->with_validation( $validations );


        /**
         * Send to Google
         * Merchant Center
         */
        wp_ajax_helper()->handle( 'send-to-google' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'send_to_google' ) )
            ->with_validation( $validations );


        /**
         * Add custom field
         * to product
         */
        wp_ajax_helper()->handle( 'rex-product-change-merchant-status' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'rex_product_change_merchant_status' ) )
            ->with_validation( $validations );


        /**
         * Database Update
         */
        wp_ajax_helper()->handle( 'rex-wpfm-database-update' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'rex_wpfm_database_update' ) )
            ->with_validation( $validations );


        /**
         * Database Update
         */
        wp_ajax_helper()->handle( 'rex-wpfm-fetch-google-category' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'fetch_google_category' ) )
            ->with_validation( $validations );



        /**
        * update batch
        */
        wp_ajax_helper()->handle( 'rex-product-update-batch-size' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'update_batch_size' ) )
            ->with_validation( $validations );


        /**
        * clear batch
        */
        wp_ajax_helper()->handle( 'rex-product-clear-batch' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'clear_batch' ) )
            ->with_validation( $validations );


        /**
        * Show log
        */
        wp_ajax_helper()->handle( 'rex-product-feed-show-log' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'show_wpfm_log' ) )
            ->with_validation( $validations );


        /**
        * Show black friday notices
        */
        wp_ajax_helper()->handle( 'wpfm_bf_notice_dismiss' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'wpfm_bf_notice_dismiss' ) )
            ->with_validation( $validations );


        wp_ajax_helper()->handle( 'wpfm-enable-fb-pixel' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'wpfm_enable_fb_pixel' ) )
            ->with_validation( $validations );


        wp_ajax_helper()->handle( 'save-fb-pixel-value' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'save_fb_pixel_value' ) )
            ->with_validation( $validations );


        wp_ajax_helper()->handle( 'rex-enable-log' )
            ->with_callback( array( 'Rex_Product_Feed_Ajax', 'wpfm_enable_log' ) )
            ->with_validation( $validations );

    }


    /**
     * Get total number of products
     *
     * @since    2.0.0
     */
    public static function get_product_number($payload) {
        $is_premium = apply_filters('wpfm_is_premium', false);
        $products = apply_filters('wpfm_get_total_number_of_products',
            array('products'  => 50)
        );
        $per_page = get_option('rex-wpfm-product-per-batch', 50);
        $posts_per_page = $is_premium ? (int)$per_page : ((int)$per_page >= 50 ? 50 : (int)$per_page);

        $info = array(
            'products' => $products['products'],
            'per_batch' => $posts_per_page,
            'total_batch' => ceil($products['products']/(int)$posts_per_page)
        );

        return $info;
    }


    /**
     * Generate feed
     * @param $config
     * @return string
     */
    public static function generate_feed( $config ){
        try {
            $merchant = Rex_Product_Feed_Factory::build( $config );
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $merchant->make_feed();
    }


    /**
     * Generate google promotion feed
     * @param $config
     * @return string
     */
    public static function generate_promotion_feed($config) {
        $merchant = new Rex_Product_Feed_Google_merchant_promotion();
        return $merchant->make_feed($config);
    }


    /**
     * Show feed template
     * @param $merchant
     * @return false|string
     * @throws Exception
     */
    public static function show_feed_template( $merchant ){
        $feed_rules    = get_post_meta( $merchant['post_id'], 'rex_feed_feed_config', true );
        if ( $merchant['merchant'] != get_post_meta( $merchant['post_id'], 'rex_feed_merchant', true ) ) {
            $feed_rules = false;
        }
        $feed_template = Rex_Feed_Template_Factory::build( $merchant['merchant'], $feed_rules );
        ob_start();
        if( in_array($merchant['merchant'], apply_filters('wpfm_has_custom_feed_config', array()))) {
            do_action('wpfm_custom_metabox_display_'. $merchant['merchant'], $merchant['merchant'], $feed_template);
        }else {
            include plugin_dir_path( __FILE__ ) . 'partials/feed-config-metabox-display.php';
        }
        return ob_get_clean();
    }


    public static function fetch_product_taxonomies($payload) {
        $val = sanitize_text_field($payload['val']);
        $post_id = sanitize_text_field($payload['postID']);
        $box = wpfm_cmb2_get_metabox('rex_feed_products', $post_id, 'product-feed');

        if($val === 'product_cat') {
            $box->add_field( array(
                'name'           => 'Product Category',
                'desc'           => 'Select Category',
                'id'             => 'rex_feed_cats',
                'taxonomy'       => 'product_cat',
                'type'           => 'taxonomy_multicheck_inline',
            ));
            $field = $box->get_field('rex_feed_cats');
            ob_start();
            $field->render_field();
            $content = ob_get_clean();
            ob_end_clean();


            $terms = wp_get_post_terms($post_id, 'product_cat');
            $values = [];
            $content = str_replace( 'checked="checked"', ' ', $content );
            if($terms) {
                foreach( $terms as $term ) {
                    $values[] = $term->slug;
                    if ( strpos( $content, 'value="' . $term->slug . '"' ) !== false ) {
                        $content = str_replace( 'value="' . $term->slug . '"', 'value="' . $term->slug . '"' . ' checked="checked"', $content );
                    }
                }
            }

            wp_send_json_success(
                array(
                    'hasContent' => true,
                    'html' => $content,
                    'hash' => $field->hash_id(),
                    'js_data' =>$field->js_data()
                )
            );
        }elseif ($val === 'product_tag') {
            $box->add_field( array(
                'name'           => 'Product Tags',
                'desc'           => 'Select Tags',
                'id'             => 'rex_feed_tags',
                'taxonomy'       => 'product_tag',
                'type'           => 'taxonomy_multicheck_inline',
            ));
            $field = $box->get_field('rex_feed_tags');

            ob_start();
            $field->render_field();
            $content = ob_get_clean();
            ob_end_clean();

            $terms = wp_get_post_terms($post_id, 'product_tag');
            $values = [];
            $content = str_replace( 'checked="checked"', ' ', $content );
            if($terms) {
                foreach( $terms as $term ) {
                    $values[] = $term->slug;
                    if ( strpos( $content, 'value="' . $term->slug . '"' ) !== false ) {
                        $content = str_replace( 'value="' . $term->slug . '"', 'value="' . $term->slug . '"' . ' checked="checked"', $content );
                    }
                }
            }

            wp_send_json_success(
                array(
                    'hasContent' => true,
                    'html' => $content,
                    'hash' => $field->hash_id(),
                    'js_data' =>$field->js_data()
                )
            );
        }

        wp_send_json_success(
            array(
                'hasContent' => false,
            )
        );
    }


    public static function rex_feed_tags_render_row_cb( $field_args, $field ) {
        $classes     = $field->row_classes();
        $id          = $field->args( 'id' );
        $label       = $field->args( 'name' );
        $name        = $field->args( '_name' );
        $value       = $field->escaped_value();
        $description = $field->args( 'description' );
        ?>
        <div class="custom-field-row <?php echo $classes; ?>">
<!--            --><?php //echo sprintf(
//                "\t" . '<li> <label for="%s"> <input%s/> <span></span> %s </label></li>' . "\n",
//                $a['id'],
//                $this->concat_attrs( $a, array( 'label' ) ),
//                $a['label']
//            )?>
        </div>
        <?php
    }


    /**
     * Save Category Map
     * @param $payload
     * @return string
     */
    public static function category_mapping($payload){
        $map_name = $payload['map_name'];
        $map_name_hash = md5(sanitize_title($map_name).time());
        $cat_map_array       = array();
        parse_str( $payload['cat_map'], $cat_map_array );
        $config_array = array();
        $map_array = array();
        if($cat_map_array) {
            foreach ($cat_map_array as $key=>$value) {
                $cat_id = preg_replace('/[^0-9]/', '', $key);
                $product_cat = get_term_by('id', $cat_id, 'product_cat');
                $category_name = '';
                if($product_cat) {
                    $category_name = $product_cat->name;
                }
                array_push($config_array, array('map-key' => $cat_id, 'map-value' => $value, 'cat-name' => $category_name));
            }
        }

        $map_array['map-name'] = $map_name;
        $map_array['map-config'] = $config_array;
        $category_map = get_option('rex-wpfm-category-mapping') ? get_option('rex-wpfm-category-mapping') : array();
        $category_map[$map_name_hash] = $map_array;
        update_option('rex-wpfm-category-mapping', $category_map);
        return 'success';
    }


    /**
     * generate category mapping
     * @param $payload
     * @return string
     */
    public static function category_mapping_update($payload){
        $map_key = $payload['map_key'];
        $map_name = $payload['map_name'];
        $cat_map_array       = array();
        parse_str( $payload['cat_map'], $cat_map_array );
        $config_array = array();
        $map_array = array();
        if($cat_map_array) {
            foreach ($cat_map_array as $key=>$value) {
                $cat_id = preg_replace('/[^0-9]/', '', $key);
                $product_cat = get_term_by('id', $cat_id, 'product_cat');
                $category_name = '';
                if($product_cat) {
                    $category_name = $product_cat->name;
                }
                array_push($config_array, array('map-key' => $cat_id, 'map-value' => $value, 'cat-name' => $category_name));
            }
        }

        $map_array['map-name'] = $map_name;
        $map_array['map-config'] = $config_array;
        $category_map = get_option('rex-wpfm-category-mapping') ? get_option('rex-wpfm-category-mapping') : array();
        $category_map[$map_key] = $map_array;
        update_option('rex-wpfm-category-mapping', $category_map);
        return 'success';
    }


    /**
     * Delete Category Mapping
     * @param $payload
     * @return string
     */
    public static function category_mapping_delete($payload){
        $map_key = $payload['map_key'];
        $category_map = get_option('rex-wpfm-category-mapping');
        unset($category_map[$map_key]);
        update_option('rex-wpfm-category-mapping', $category_map);
        return 'Success';
    }


    /**
     * Stop admin notices
     * @param $payload
     * @return string
     */
    function stop_notices($payload) {
        update_option('rex_bwfm_notification_status', 'no');
        return 'success';
    }





    /**
     * Change merchant status
     * @param $payload
     * @return string
     */
    public static function rex_product_change_merchant_status($payload) {
        $merchants = get_option('rex_wpfm_merchant_status');
        if(!$merchants) {
            $latest_merchants = $payload;
        }else {
            $latest_merchants = array_merge($merchants, $payload);
        }
        update_option('rex_wpfm_merchant_status', $latest_merchants);
        return 'success';
    }


    /**
     * Send feed to Google
     * @param $payload
     * @return array
     */
    public static function send_to_google($payload) {

        $feed_id = $payload['feed_id'];
        $rex_google_merchant = new Rex_Google_Merchant_Settings_Api();
        if ($rex_google_merchant->is_authenticate()) {
            $feed_url = get_post_meta( $feed_id, 'rex_feed_xml_file', true );
            $feed_title = get_the_title($feed_id);
            $client = $rex_google_merchant::get_client();
            $client_id = $rex_google_merchant::$client_id;
            $client_secret = $rex_google_merchant::$client_secret;
            $merchant_id = $rex_google_merchant::$merchant_id;


            $access_token = $rex_google_merchant->get_access_token();
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setScopes( 'https://www.googleapis.com/auth/content' );
            $client->setAccessToken($access_token);

            /*
             * Initialize service and datafeed
             */
            $service = new Google_Service_ShoppingContent($client);
            $datafeed = new Google_Service_ShoppingContent_Datafeed();
            $target = new Google_Service_ShoppingContent_DatafeedTarget();



            $name = $feed_title;
            $filename = $name.uniqid();

            $target->setLanguage($payload['language']);
            $target->setCountry($payload['country']);
            $target->setIncludedDestinations(array('Shopping'));

            $datafeed->setName($name);
            $datafeed->setContentType('products');
            $datafeed->setAttributeLanguage($payload['language']);
            $datafeed->setTargets([$target]);

//            $datafeed->setContentLanguage($payload['language']);
//            $datafeed->setIntendedDestinations(array('Shopping'));
//            $datafeed->setTargetCountry($payload['country']);
            if (!$rex_google_merchant->feed_exists($feed_id)){
                $datafeed->setFileName($filename);
            }else {
                $datafeed->setFileName(get_post_meta($feed_id, 'rex_feed_google_data_feed_file_name', true));
            }


            /*
             * Initialize Schedule
             */
            $fetch_schedule = new Google_Service_ShoppingContent_DatafeedFetchSchedule();
            if($payload['schedule'] === 'monthly') {
                $fetch_schedule->setDayOfMonth($payload['']);
            }
            if($payload['schedule'] === 'weekly') {
                $fetch_schedule->setWeekday($payload['day']);
            }
            $fetch_schedule->setHour($payload['hour']);
            $fetch_schedule->setFetchUrl($feed_url);

            /*
             * initialize feed format
             */
            $format = new Google_Service_ShoppingContent_DatafeedFormat();
            $format->setFileEncoding('utf-8');
            $datafeed->setFormat($format);
            $datafeed->setFetchSchedule($fetch_schedule);

            try {
                if ($rex_google_merchant->feed_exists($feed_id)){
                    $datafeedID = get_post_meta($feed_id, 'rex_feed_google_data_feed_id', true);
                    $datafeed->setId($datafeedID);
                    $service->datafeeds->update($merchant_id, $datafeedID, $datafeed);
                }else {
                    $datafeed = $service->datafeeds->insert($merchant_id, $datafeed);
                    $datafeedID = $datafeed->getId();
                    $datafeedFileName = $datafeed->getFileName();
                    update_post_meta($feed_id, 'rex_feed_google_data_feed_id',$datafeedID );
                    update_post_meta($feed_id, 'rex_feed_google_data_feed_file_name',$datafeedFileName );

                }
                $service->datafeeds->fetchnow($merchant_id, $datafeedID);
            }
            catch(Exception $e) {
                if(is_wpfm_logging_enabled()) {
                    $log = wc_get_logger();
                    $log->info($e->getMessage(), array('source' => 'WPFM-google'));
                }

                $error = json_decode($e->getMessage());
                $reason = $error->error->errors;
                return array(
                    'success' => false,
                    'message' => $error->error->message,
                    'reason'  => $reason[0]->reason
                );
            }
        }

        update_post_meta($feed_id, 'rex_feed_google_schedule',$payload['schedule'] );
        update_post_meta($feed_id, 'rex_feed_google_schedule_time',$payload['hour'] );
        update_post_meta($feed_id, 'rex_feed_google_schedule_month',$payload['month'] );
        update_post_meta($feed_id, 'rex_feed_google_schedule_week_day',$payload['day'] );
        update_post_meta($feed_id, 'rex_feed_google_target_country',$payload['country'] );
        update_post_meta($feed_id, 'rex_feed_google_target_language',$payload['language'] );
        return array('success' => true);
    }


    /**
     * WPFM database update
     */
    public static function rex_wpfm_database_update() {
        check_ajax_referer('rex-wpfm-ajax', 'security');
        require_once WPFM_PLUGIN_DIR_PATH . 'includes/class-rex-product-feed-activator.php';
        set_transient( 'rex-wpfm-database-update-running', true, 3153600000 );
        global $rex_product_feed_database_update;
        $db_updates_callbacks = Rex_Product_Feed_Activator::get_db_update_callbacks();
        $rex_product_feed_database_update->push_to_queue( $db_updates_callbacks);
        $rex_product_feed_database_update->save()->dispatch();
        Rex_Product_Feed_Activator::update_db_version('2.2.5');
        wp_send_json_success('success');
        wp_die();
    }


    /**
     * Fetch google category
     * @param $payload
     * @return string
     */
    public static function fetch_google_category($payload) {
        $file =  dirname(__FILE__) . '/partials/google_category_list.txt';
        $matches = array();
        $handle = @fopen($file, "r");
        while (!feof($handle)) {
            $cat = fgets($handle);
            $matches[] = $cat;
        }
        fclose($handle);
        return json_encode($matches, JSON_PRETTY_PRINT);
    }


    /**
     * Clear current batch
     * @param $payload
     */
    public static function clear_batch($payload) {
        delete_option('rex_wpfm_feed_queue');
        $args = array(
            'posts_per_page' => -1,
            'post_type'      => 'product-feed',
            'post_status'    => 'publish',
            'fields'         => 'ids',
        );

        $feeds = get_posts($args);
        foreach($feeds as $feedID) {
            update_post_meta($feedID, 'rex_feed_status', 'completed');
        }

        /**
         * https://stackoverflow.com/questions/55952451/wordpress-stop-process-for-wp-background-processing
         */
        global $wpdb;
        $sql = "SELECT `option_name` AS `name`, `option_value` AS `value`
            FROM  $wpdb->options
            WHERE `option_name` LIKE %s
            ORDER BY `option_name`";

        $wild = '%';
        $find = 'wp_rex_product_feed_background_process_cron';
        $like = $wild . $wpdb->esc_like( $find ) . $wild;
        $results = $wpdb->get_results( $wpdb->prepare($sql,$like) );

        foreach ( $results as $result ){
            delete_option($result->name);
        }

        $WP_Background_Process = new Rex_Product_Feed_Background_Process();
        $cancel_process = $WP_Background_Process->cancel_process();
        wp_send_json_success('success');
        wp_die();
    }

    /**
     * Update batch size
     * @param $payload
     */
    public static function update_batch_size($payload) {
        update_option('rex-wpfm-product-per-batch', $payload);
        wp_send_json_success('success');
        wp_die();
    }


    /**
     * WPFM log
     * @param $payload
     */
    public static function show_wpfm_log($payload) {

        $key = $payload['logKey'];
        $log_content = esc_html( file_get_contents( WC_LOG_DIR . $key ));
        $upload_dir = wp_upload_dir();
        $url = $upload_dir['baseurl'];

        return array(
            'success' => true,
            'content' => $log_content,
            'file_url' => $url . '/wc-logs/'. $key
        );

    }


    /**
     * Black friday notice dismiss
     * @param $payload
     * @return array
     */
    public static function wpfm_bf_notice_dismiss($payload) {

        $current_time = time();
        $date_now = date("Y-m-d", $current_time);
        if( $date_now == '2019-11-29' || $date_now == '2019-11-28') {
            $wpfm_bf_notice = array(
                'show_notice' => 'never',
                'updated_at' => time(),
            );
        }else {
            $wpfm_bf_notice = array(
                'show_notice' => 'no',
                'updated_at' => time(),
            );
        }
        update_option('wpfm_bf_notice', json_encode($wpfm_bf_notice));
        return array(
            'success' => true,
        );
    }


    /**
     * @param $payload
     * @return array
     */
    public static function wpfm_enable_fb_pixel($payload) {
        if($payload['wpfm_fb_pixel_enabled'] == 'yes') {
            update_option('wpfm_fb_pixel_enabled', 'yes');
            return array(
                'success' => true,
                'data'  => 'enabled'
            );
        }else if ($payload['wpfm_fb_pixel_enabled'] == 'no') {
            update_option('wpfm_fb_pixel_enabled', 'no');
            return array(
                'success' => true,
                'data'  => 'disabled'
            );
        }
    }


    /**
     * @param $payload
     * @return array
     */
    public static function save_fb_pixel_value($payload) {
        update_option('wpfm_fb_pixel_value', $payload);
        return array(
            'success' => true,
        );
    }


    /**
     * Enable logging
     * @param $payload
     * @return array
     */
    public static function wpfm_enable_log($payload) {
        if($payload['wpfm_enable_log'] == 'yes') {
            update_option('wpfm_enable_log', 'yes');
            return array(
                'success' => true,
                'data'  => 'enabled'
            );
        }else if ($payload['wpfm_enable_log'] == 'no') {
            update_option('wpfm_enable_log', 'no');
            return array(
                'success' => true,
                'data'  => 'disabled'
            );
        }
    }
}
