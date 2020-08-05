<?php

/**
 * Class Rex_Product_Feed_Notices
 */

class Rex_Product_Feed_Notices {


    /**
     * Array of notices - name => callback.
     *
     * @var array
     */
    private static $core_notices = array(
        'database_update'           => 'rex_wpfm_db_update_notice',
        'database_update_running'   => 'rex_wpfm_db_update_running_notice',
    );


    /**
     * Get notices
     *
     * @return array
     */
    public static function get_notices() {
        return self::$core_notices;
    }


    /**
     * WPFM get screen ids
     * @return array
     */
    public static function wpfm_get_screen_ids() {

        $wpfm_screen_id = sanitize_title( __( 'Product Feed', 'rex-product-feed' ) );
        $screen_ids = array(
            $wpfm_screen_id,
            'edit-' . $wpfm_screen_id,
            $wpfm_screen_id . '_page_category_mapping',
            $wpfm_screen_id . '_page_merchant_settings',
            $wpfm_screen_id . '_page_wpfm_dashboard',
        );;

        $show_on_screens = array_merge($screen_ids, array(
            'dashboard',
            'plugins',
        ));
        return $show_on_screens;
    }

    /*
    * Database update notice
    */
    public static function rex_wpfm_db_update_notice() {
        $show_on_screens = self::wpfm_get_screen_ids();
        $screen          = get_current_screen();
        $screen_id       = $screen ? $screen->id : '';


        // Notices should only show on WPFM screens, the main dashboard, and on the plugins screen.
        if ( ! in_array( $screen_id, $show_on_screens, true ) ) {
            return;
        }

        $db_version = get_option('rex_wpfm_db_version');
        if( get_transient( 'rex-wpfm-database-update' ) ){
            require_once plugin_dir_path( __FILE__ ) . 'partials/database-update-notice.php';

        }
        if(!$db_version){
            require_once plugin_dir_path( __FILE__ ) . 'partials/database-update-notice.php';
        }
    }

    /**
     * Database running update notice
     */
    public static function rex_wpfm_db_update_running_notice() {

        $show_on_screens = self::wpfm_get_screen_ids();
        $screen          = get_current_screen();
        $screen_id       = $screen ? $screen->id : '';
        if ( ! in_array( $screen_id, $show_on_screens, true ) ) {
            return;
        }
        if( get_transient( 'rex-wpfm-database-update-running' ) ){
            require_once plugin_dir_path( __FILE__ ) . 'partials/database-update-running-notice.php';
        }
    }


    /**
     * Black friday notice
     */
    public static function wpfm_black_friday_notice() {
        $wpfm_bf_notice = get_option('wpfm_bf_notice', array(
            'show_notice' => 'yes',
            'updated_at' => time(),
        ));
        $time = time();
        if(is_string($wpfm_bf_notice)) $wpfm_bf_notice = json_decode($wpfm_bf_notice, true);
        if($wpfm_bf_notice['show_notice'] === 'yes') {
            require_once plugin_dir_path( __FILE__ ) . 'partials/wpmf-black-friday-notice.php';
        } elseif ($wpfm_bf_notice['show_notice'] === 'no') {
            $date_now = date("Y-m-d", $time);
            if($date_now == '2019-11-29' || $date_now == '2019-11-28') {
                require_once plugin_dir_path( __FILE__ ) . 'partials/wpmf-black-friday-notice.php';
            }
        }
    }

}
