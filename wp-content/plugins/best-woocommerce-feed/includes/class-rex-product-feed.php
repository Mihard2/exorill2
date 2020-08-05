<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/includes
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Product_Feed {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Rex_Product_Feed_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'rex-product-feed';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Rex_Product_Feed_Loader. Orchestrates the hooks of the plugin.
     * - Rex_Product_Feed_i18n. Defines internationalization functionality.
     * - Rex_Product_Feed_Admin. Defines all hooks for the admin area.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * Get Composer Autoloader.
         */
        $autoload_file_array = apply_filters('wpfm_autoload_file_array', array(plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php'));

        foreach ( $autoload_file_array as $file ) {
            require_once $file;
        }


        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rex-product-feed-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rex-product-feed-i18n.php';


        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rex-product-feed-public.php';

        $this->loader = new Rex_Product_Feed_Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Rex_Product_Feed_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Rex_Product_Feed_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        global $rex_product_feed_database_update;
        $rex_product_feed_database_update = new Rex_Product_Feed_Database_Update();

        $plugin_admin = new Rex_Product_Feed_Admin( $this->get_plugin_name(), $this->get_version() );
        $plugin_admin = new Rex_Product_Feed_Admin( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_print_footer_scripts', $plugin_admin, 'dequeue_scripts', 5 );
        $this->loader->add_action( 'init', $plugin_admin, 'register_cpt' );
        $this->loader->add_action( 'admin_notices', $plugin_admin, 'rex_wpfm_admin_notices' );
        $this->loader->add_action( 'wpfm_cmb2_admin_init', $plugin_admin, 'register_metaboxes' );

        $this->loader->add_action( 'admin_init', 'Rex_Product_Feed_Ajax', 'init' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'load_admin_pages');
        $this->loader->add_action( 'admin_footer', $plugin_admin, 'rex_admin_footer_style');


        // remove bulk edit and quick edit for our feed cpt.
        $this->loader->add_filter( 'bulk_actions-edit-product-feed', $plugin_admin, 'remove_bulk_edit' );
        $this->loader->add_filter( 'post_row_actions', $plugin_admin, 'remove_quick_edit' );
        $this->loader->add_filter( 'plugin_row_meta', $plugin_admin, 'wpfm_plugin_row_meta', 10, 2 );

        /**
         * new merchant status
         */
        $this->loader->add_filter( 'wpfm_available_merchants_status', $plugin_admin, 'wpfm_available_merchants_status', 10, 1 );

        /*
         * Custom ajax
         * for data base update
         */
        $this->loader->add_action('wp_ajax_rex_wpfm_database_update', 'Rex_Product_Feed_Ajax', 'rex_wpfm_database_update');

        /*
         * register rex feed schedule
         */
        $this->loader->add_action( 'admin_init', $plugin_admin, 'register_weekly_cron');
        $this->loader->add_action( 'rex_feed_weekly_update', $plugin_admin, 'activate_weekly_update' );
        $this->loader->add_action( 'rex_feed_schedule_update', $plugin_admin, 'activate_schedule_update' );


        $this->loader->add_filter( 'cmb2_render_analytics_params', $plugin_admin, 'cmb2_render_analytics_params_callback', 10, 5 );

        $this->loader->add_action( 'wp_footer', $plugin_admin, 'wpfm_enable_facebook_pixel' );

    }


    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new Rex_Product_Feed_Public( $this->get_plugin_name(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_ajax_wpfm_add_to_cart', $plugin_public, 'wpfm_add_to_cart' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfm_add_to_cart', $plugin_public, 'wpfm_add_to_cart' );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();

    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Rex_Product_Feed_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
