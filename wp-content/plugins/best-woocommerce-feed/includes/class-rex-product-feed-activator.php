<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/includes
 * @author     RexTheme <info@rextheme.com>
 */


class Rex_Product_Feed_Activator {

    /**
     * DB updates and callbacks that need to be run per version.
     *
     * @var array
     */
    private static $db_updates = array(
        '3.0' => array(
            'wpfm_update_category_mapping',
        ),
    );

	/**
	 * on Plugin activation
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        /*
         * Schedule Feed Update
         * @since 1.3.3
         */
        if (! wp_next_scheduled ( 'rex_feed_schedule_update' )) {
            wp_schedule_event(time(), 'hourly', 'rex_feed_schedule_update');
        }

        if( ! wp_next_scheduled( 'rex_feed_weekly_update' ) ) {
            wp_schedule_event( time(), 'weekly', 'rex_feed_weekly_update' );
        }


        /*
         * add merchant status
         */
        $merchants = apply_filters('wpfm_merchant_status', array(
            'custom'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Custom'
            ),
            'google'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Google'
            ),
            'google_Ad'    => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Google Dynamic Display Ads'
            ),
            'facebook'     => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Facebook'
            ),
            'amazon'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Amazon'
            ),
            'adroll'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'AdRoll'
            ),
            'nextag'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Nextag'
            ),
            'pricegrabber' => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Pricegrabber'
            ),
            'bing'         => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Bing'
            ),
            'kelkoo'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Kelkoo'
            ),
            'become'       => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Become'
            ),
            'shopzilla'    => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'ShopZilla'
            ),
            'shopping'     => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'Shopping'
            )
        ));
        if (!get_option('rex_wpfm_merchant_status')) {
            add_option('rex_wpfm_merchant_status', $merchants);
        }

        /*
         * Redirect to getting started page
         */
        add_option('rex_wpfm_plugin_do_activation_redirect', true);
	    update_option('rex_bwfm_first_installation', time());
	    update_option('rex_bwfm_notification_status', 'yes');

	    self::update_notice();

	}


    /**
     * Does a database update required
     *
     * @since  2.2.5
     * @return boolean
     */
	public static function needs_database_update() {
        $current_db_version         = get_option('rex_wpfm_db_version', null);
        return is_null( $current_db_version );
    }


    /**
     * Get list of DB update callbacks.
     *
     * @since  2.4
     * @return array
     */
    public static function get_db_update_callbacks() {
        return self::$db_updates;
    }


    /**
     * Update DB version to current.
     *
     * @param string|null $version New WoCommerce Product Feed Manager version or null.
     */
    public static function update_db_version( $version = null ) {
        delete_transient('rex-wpfm-database-update');
        delete_option( 'rex_wpfm_db_version' );
        add_option( 'rex_wpfm_db_version', $version );
    }


    /**
     * If we need to update, include a message with the update button.
     */
    public static function update_notice() {
        if ( self::needs_database_update() ) {
            set_transient( 'rex-wpfm-database-update', true, 3153600000 ); /* never expire unless user force it */
        }
    }
}
