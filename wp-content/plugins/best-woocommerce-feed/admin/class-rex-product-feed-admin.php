<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin
 * @author     RexTheme <info@rextheme.com>
 */

/**
 * Class Rex_Product_Feed_Admin
 */
class Rex_Product_Feed_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;


    /**
     * The ID of this plugin.
     *
     * @since    3.0
     * @access   private
     * @var      string    $plugin_basename    The ID of this plugin.
     */
    private $plugin_basename;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;


    /**
     * Metabox instance of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $metabox    The current metabox of this plugin.
     */
    private $cpt;


    /**
     * Admin notices
     *
     * @since    2.5
     * @access   private
     * @var      object    $notices
     */
    private $notices;

    /**
     * Metabox instance of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $metabox    The current metabox of this plugin.
     */
    private $metabox;


    /**
     * Cron Handler
     *
     * @since    1.3.2
     * @access   private
     * @var      object    $cron    The current cron of this plugin.
     */
    private $cron;


    /**
     * Google merchant page
     *
     * @since    1.3.2
     * @access   private
     * @var      string
     */
    private $google_screen_hook_suffix = null;


    /**
     * Category Mapping page
     *
     * @since    1.3.2
     * @access   private
     * @var      string
     */
    private $category_mapping_screen_hook_suffix = null;


    /**
     * Dashboard
     *
     * @since    1.3.2
     * @access   private
     * @var      string
     */
    private $dashboard_screen_hook_suffix = null;


    /**
     * WPFM pro
     *
     * @since    3.0
     * @access   private
     * @var      string
     */
    private $wpfm_pro_submenu = null;


    /**
     * WPFM Support menu
     *
     * @since    3.0
     * @access   private
     * @var      string
     */
    private $wpfm_support_menu = null;



    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->plugin_basename      = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
        $this->version     = $version;
        $this->cpt         = new Rex_Product_CPT;
        $this->metabox     = new Rex_Product_Metabox;
        $this->cron        = new Rex_Product_Feed_Cron_Handler();

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Rex_Product_Feed_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rex_Product_Feed_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $screen = get_current_screen();
        if( ($hook === 'edit.php' ) ){
            return;
        }

        if ( $screen->post_type === 'product-feed' || in_array($screen->id, apply_filters('wpfm_page_hooks', array($this->category_mapping_screen_hook_suffix, $this->dashboard_screen_hook_suffix, $this->google_screen_hook_suffix, 'product-feed_page_wpfm-license')))) {
            wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
            wp_enqueue_style( 'wpfm-vendor', plugin_dir_url( __FILE__ ) . 'css/vendor.min.css', array(), $this->version, 'all' );
            wp_enqueue_style( 'style-css', plugin_dir_url( __FILE__ ) . 'css/style.min.css', array(), $this->version, 'all' );
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Rex_Product_Feed_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Rex_Product_Feed_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $db_version = get_option('rex_wpfm_db_version');
        if($db_version < 3) {
            wp_enqueue_script( 'rex-wpfm-global-js', plugin_dir_url( __FILE__ ) . 'js/rex-product-feed-global-admin.js', array( 'jquery'), $this->version, false );
            wp_localize_script( 'rex-wpfm-global-js', 'rex_wpfm_ajax',
                array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'ajax_nonce' => wp_create_nonce('rex-wpfm-ajax'),
                )
            );
        }

        $screen = get_current_screen();
        if( ($hook === 'edit.php' ) ){
            return;
        }

        if ( $screen->post_type === 'product-feed' || in_array($screen->id, apply_filters('wpfm_page_hooks', array($this->dashboard_screen_hook_suffix, $this->google_screen_hook_suffix, 'product-feed_page_wpfm-license')))) {
            wp_enqueue_script( 'jquery-ui-autocomplete' );
            wp_enqueue_script(
                'jquery-stop-watch',
                plugin_dir_url( __FILE__ ) . 'js/jquery.stopwatch.js',
                array( 'jquery' ),
                $this->version,
                true
            );
            wp_enqueue_script(
                'jquery-nice-select',
                plugin_dir_url( __FILE__ ) . 'js/jquery.nice-select.min.js',
                array( 'jquery' ),
                $this->version,
                true
            );
            wp_enqueue_script(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'js/rex-product-feed-admin.js',
                array( 'jquery' ),
                $this->version,
                true
            );

        }

        if ($screen->id == $this->category_mapping_screen_hook_suffix) {
            wp_enqueue_script( 'category-map', plugin_dir_url( __FILE__ ) . 'js/category-mapper.js', array( 'jquery', 'jquery-ui-autocomplete' ), $this->version, true );
        }
    }

    /**
     * Remove a previously enqueued script by libraries
     * for the admin area.
     *
     * @since    1.0.0
     */
    public function dequeue_scripts($hook) {
        $screen = get_current_screen();
        if ( $screen->post_type != 'product-feed' ) {
            wp_dequeue_script( 'wpfm-cmb2-scripts' );
            wp_dequeue_script( 'wpfm-cmb2-conditionals' );
        }

        if ( $screen->post_type == 'product-feed' ) {
            wp_dequeue_script( 'cmb2-scripts' );
            wp_dequeue_script( 'cmb2-conditionals' );
        }
    }


    /**
     * Admin Notices
     *
     * @since    1.2.7
     */
    public function rex_wpfm_admin_notices() {

        $show_notice = get_option('rex_bwfm_notification_status');

        $activation_time = get_option('rex_bwfm_first_installation');

        $current_time = time();
        $notice_start = 1209600;
        $interval   = ($current_time - $activation_time) > $notice_start ? true : false;

        if ($interval AND $show_notice !='no') {?>
            <div class="notice notice-info bwfm-review-notice" style="position: relative; border-left-color: #00b4ff;">
                <div class="wpfm-logo">
                    <img src="<?php echo WPFM_PLUGIN_DIR_URL.'admin/icon/wpfm-logo.jpg'?>">
                </div>

                <div class="wpfm-notice-content">
                    <h2 class="wpfm-notice-title"><?php echo __('Leave a review?', 'rex-product-feed'); ?></h2>
                    <p><?php echo __( 'Hey, I noticed you are using WC product feed manager for over two weeks – that’s awesome! Could you please do me a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.', 'rex-product-feed' ) ?><br>~ Lincoln </p>
                    <ul>
                        <li style="display: inline;">
                            <span class="dashicons dashicons-external" style="font-size: 1.4em; padding-left: 10px"></span>
                            <a href="https://wordpress.org/support/plugin/best-woocommerce-feed/reviews/#new-post" target="_blank" class="" style="font-weight: bold; padding-left: 10px;"><?php echo __('Ok, you deserve it','rex-product-feed')?></a>
                        </li>
                        <li style="display: inline;">
                            <span class="dashicons dashicons-calendar" style="font-size: 1.4em; padding-left: 10px"></span>
                            <a href="#" class="stop-bwfm-notice" style="font-weight: bold; padding-left: 10px;"><?php echo __( 'Nope, maybe later.', 'rex-product-feed' ) ?></a>
                        </li>
                        <li style="display: inline;">
                            <span class="dashicons dashicons-smiley" style="font-size: 1.4em; padding-left: 10px"></span>
                            <a href="#" class="stop-bwfm-notice" style="font-weight: bold; padding-left: 10px;"><?php echo __( 'I already did.', 'rex-product-feed' ) ?></a>
                        </li>
                    </ul>
                    <button type="button" class="notice-dismiss bwfm-dismiss-notice"><span class="screen-reader-text"><?php echo __( 'Dismiss this notice.', 'rex-product-feed' ) ?></span></button>
                </div>
            </div>
        <?php }
    }



    /**
     * Register CPT for the Plugin
     *
     * @since    1.0.0
     */
    public function register_cpt() {
        $this->cpt->register();
    }

    /**
     * Remove Bulk Edit for Feed
     *
     * @since    1.0.0
     */
    public function remove_bulk_edit( $actions ){
        unset( $actions['edit'] );
        return $actions;
    }

    /**
     * Remove Quick Edit for Feed
     *
     * @since    1.0.0
     */
    public function remove_quick_edit( $actions ){
        // Abort if the post type is not "books"
        if ( ! is_post_type_archive( 'product-feed' ) ) {
            return $actions;
        }

        // Remove the Quick Edit link
        if ( isset( $actions['inline hide-if-no-js'] ) ) {
            unset( $actions['inline hide-if-no-js'] );
        }

        // Return the set of links without Quick Edit
        return $actions;
    }

    /**
     * Register All the Metaboxes for the admin area.
     *
     * @since    1.0.0
     */
    public function register_metaboxes() {
        $this->metabox->register();
    }


    /**
     * Register Plugin Admin Pages
     *
     * @since    1.0.0
     */
    public function load_admin_pages() {

        add_menu_page( __( 'Product Feed', 'rex-product-feed' ), __( 'Product Feed', 'rex-product-feed' ), 'manage_woocommerce', 'product-feed', null, WPFM_PLUGIN_DIR_URL . 'admin/icon/icon.png', 20 );
        $this->category_mapping_screen_hook_suffix = add_submenu_page('product-feed', __('Category Mapping', 'rex-product-feed'), __('Category Mapping', 'rex-product-feed'), 'manage_woocommerce', 'category_mapping',  __CLASS__ .'::category_mapping');
        $this->google_screen_hook_suffix =  add_submenu_page('product-feed', __('Google Merchant Settings', 'rex-product-feed'), __('Google Merchant Settings', 'rex-product-feed'), 'manage_woocommerce', 'merchant_settings',  __CLASS__ .'::merchant_settings');
        $this->dashboard_screen_hook_suffix = add_submenu_page('product-feed', __('Settings', 'rex-product-feed'), __('Settings', 'rex-product-feed'), 'manage_woocommerce', 'wpfm_dashboard',  __CLASS__ .'::user_dashboard');
        $this->wpfm_support_menu = add_submenu_page('product-feed', '', __('Support', 'rex-product-feed'), 'manage_woocommerce', 'wpfm_support',  __CLASS__ .'::wpfm_support');
        $is_premium = apply_filters('wpfm_is_premium_activate', false);
        if(!$is_premium) $this->wpfm_pro_submenu = add_submenu_page('product-feed', '', '<span class="dashicons dashicons-star-filled" style="font-size: 17px; color: #2BBBAC;"></span> ' . __( 'Go Pro', 'rex-product-feed' ), 'manage_woocommerce', 'go_wpfm_pro', __CLASS__ .'::wpfm_redirect_to_pro');
        do_action('wpfm_pro_license_page');
        /**
         * WPFM action links
         */
        add_filter('plugin_action_links_' . $this->plugin_basename, array( $this, 'wpfm_plugin_action_links' ));
    }

    /**
     *
     */
    public static function category_mapping(){
        require plugin_dir_path(__FILE__) . '/partials/category_mapping.php';
    }



    public static function user_dashboard(){
        require plugin_dir_path(__FILE__) . '/partials/on_boarding.php';
    }


    /**
     *
     */
    public static function merchant_settings(){
        require plugin_dir_path(__FILE__) . '/partials/merchant_settings.php';
    }


    public static function wpfm_redirect_to_pro() {
        wp_redirect('https://rextheme.com/best-woocommerce-product-feed/#upgrade-pro');
    }


    /**
     * WPFM redirect to support link
     */
    public static function wpfm_support() {
        $support_link = apply_filters('wpfm_support_link', 'https://wordpress.org/support/plugin/best-woocommerce-feed');
        wp_redirect($support_link);
    }


    /**
     * WPFM action links
     * @param $links
     * @return array
     */
    public  function wpfm_plugin_action_links($links) {
        $is_premium = apply_filters('wpfm_is_premium_activate', false);
        $dashboard_link = sprintf( '<a href="%1$s">%2$s</a>', admin_url('admin.php?page=wpfm_dashboard' ), __( 'Dashboard', 'rex-product-feed' ) );
        array_unshift( $links, $dashboard_link );
        if(!$is_premium) $links['wpfm_go_pro'] = sprintf( '<a href="%1$s" target="_blank" class="wpfm-plugins-gopro" style="color: #2BBBAC; font-weight: bold; ">%2$s</a>', 'https://rextheme.com/best-woocommerce-product-feed/#upgrade-pro' , __( 'Go Pro', 'rex-product-feed' ) );
        return $links;
    }


    /**
     * Plugin row meta.
     * Adds row meta links to the plugin list table
     * @param $plugin_meta
     * @param $plugin_file
     * @return array
     */
    public function wpfm_plugin_row_meta($plugin_meta, $plugin_file) {
        if ( WPFM_PLUGIN_BASE === $plugin_file ) {
            $row_meta = [
                'docs' => '<a href="https://rextheme.com/docs/woocommerce-product-feed/" aria-label="' . esc_attr( __( 'View WPFM Documentation', 'rex-product-feed' ) ) . '" target="_blank">' . __( 'Docs & FAQs', 'rex-product-feed' ) . '</a>',
//                'video' => '<a href="https://www.youtube.com/watch?v=WYRgnMFQGH8&list=PLelDqLncNWcVoPA7T4eyyfzTF0i_Scbnq" aria-label="' . esc_attr( __( 'View WPFM Video Tutorials', 'rex-product-feed' ) ) . '" target="_blank">' . __( 'Video Tutorials', 'rex-product-feed' ) . '</a>',
            ];
            $plugin_meta = array_merge( $plugin_meta, $row_meta );
        }

        return $plugin_meta;
    }


    public function register_weekly_cron() {
        if( ! wp_next_scheduled( 'rex_feed_weekly_update' ) ) {
            wp_schedule_event( time(), 'weekly', 'rex_feed_weekly_update' );
        }
    }


    /**
     *  Feed Cron handler
     *  @since    1.3.2
     */
    public function activate_schedule_update() {
        $this->cron->rex_feed_cron_handler();
    }


    /**
     * Weekly cron handler
     */
    public function activate_weekly_update() {
        $this->cron->rex_feed_weekly_cron_handler();
    }


    /**
     * Available merchants filter
     * @param $array
     * @return array
     */
    public function wpfm_available_merchants_status($array){
        $free_merchants = array(
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
                'name'  => 'Google AD'
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
            'ebay'         => array(
                'free'  => true,
                'status'    => 1,
                'name'  => 'eBay'
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
        );
        $array = array_merge($free_merchants, $array);
        $pro_merchants = array(
            'ebay_mip'     => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'eBay (MIP)'
            ),
            'ebay_seller'     => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'eBay Seller Center'
            ),
            'bol'       => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'Bol.com'
            ),
            'wish'       => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'Wish.com'
            ),
            'fruugo'       => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'Fruugo'
            ),
            'leguide'       => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'Leguide'
            ),
            'connexity'       => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'Connexity'
            ),
            'drm'     => array(
                'free'  => false,
                'status'    => 0,
                'name'  => 'Google Remarketing (DRM)'
            )

        );
        foreach ($pro_merchants as $key=>$merchant) {
            if(array_key_exists($key, $array)) {
                unset($key, $merchant);
            }else {
                $array[$key] = $merchant;
            }
        }
        return $array;
    }



    /*
     * Admin Footer Styles
     */
    function rex_admin_footer_style() {
        echo '<style>

                .wpfm-bf-wrapper {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    max-width: 1510px;
                    margin: 0 auto;
                }
                .wpfm-bf-wrapper .wpfm-logo,
                .wpfm-bf-wrapper .wpfm-bf-button{
                    flex: 0 0 25%;
                    margin: 10px;
                }
                .wpfm-bf-wrapper .wpfm-bf-text{
                    flex: 0 0 40%;
                }
                .wpfm-bf-text p,
                .wpfm-bf-text h3{
                    color: #fff;
                    
                }
                .wpfm-bf-text p{
                    font-size: 18px;
                    margin: 0;
                }
                
                .wpfm-bf-text h3{
                    font-size: 32px;
                    font-weight: 700;
                    margin: 15px 0;
                    line-height: 1.1;
                }
                .wpfm-bf-button p {
                    font-size: 18px;
                    color: #fff;
                    margin-bottom: 25px;
                } 
                .wpfm-bf-button a {
                    background-color: #fff;
                    padding: 10px 20px;
                    color: #00b4ff;
                    font-size: 30px;
                    border-radius: 4px;
                    margin: 15px 0;
                    text-decoration: none;
                }
                p.wpfm-bf-coupon {
                    margin-top: 25px;
                }
                
                
                .wpfm-black-friday-notice {
                    position: relative;
                    padding: 0;
                    margin: 0!important;
                    border: none;
                    background: transparent;
                    box-shadow: none;
                }
                .wpfm-black-friday-notice img{
                    display: block;
                    max-width: 100%;
                }
                .wpfm-black-friday-notice .notice-dismiss {
                    top: 8px;
                    right: 10px;
                    padding: 0;
                }
                .wpfm-black-friday-notice .notice-dismiss:before {
                    color: #fff;
                    font-size: 22px;
                }
                @media  (max-width: 1199px) {
                    .wpfm-bf-wrapper {
                        flex-direction: column;
                        text-align: center;
                        padding-top: 20px;
                    }
                  .wpfm-bf-wrapper .wpfm-logo,
                    .wpfm-bf-wrapper .wpfm-bf-button{
                        flex: 0 0 100%;
                    }
                    .wpfm-bf-wrapper .wpfm-bf-text{
                        flex: 0 0 100%;
                    }
                }
                .wpfm-db-update-loader {
                  display: none;
                  width: 20px;
                  height: 20px;
                }
                .blink span {
                  font-size: 35px;
                  animation-name: blink;
                  animation-duration: 1.4s;
                  animation-iteration-count: infinite;
                  animation-fill-mode: both;
                }
                
                .blink span:first-child {
                  margin-left: 5px;
                }
                
                .blink span:nth-child(2) {
                  animation-delay: .2s;
                }
                
                .blink span:nth-child(3) {
                  animation-delay: .4s;
                }
                
                @keyframes blink {
                  0% {
                    opacity: .2;
                  }
                  20% {
                    opacity: 1;
                  }
                  100% {
                    opacity: .2;
                  }
                }
                #woocommerce-product-data ul.wc-tabs li.wpfm_wc_custom_tabs a:before { 
                    font-family: WooCommerce; 
                    content: \'\e006\'; 
                 }
                 #wpfm_product_meta strong{
                    color: #1FB3FB;
                    padding: 10px;
                 }
                .bwfm-review-notice {
                  display: flex;
                  flex-flow: row wrap;
                  align-items: center;
                  padding: 20px; }
                  .bwfm-review-notice .wpfm-logo {
                    width: 80px; }
                    .bwfm-review-notice .wpfm-logo img {
                      display: block; }
                  .bwfm-review-notice .wpfm-notice-content {
                    width: calc(100% - 110px);
                    padding-left: 30px; }
                    .bwfm-review-notice .wpfm-notice-content .wpfm-notice-title {
                      font-size: 24px;
                      color: #222; }
        </style>';
    }


    /**
     * render cmb2 analytics param fields
     * @param $field
     * @param $value
     * @param $object_id
     * @param $object_type
     * @param $field_type
     */
    public function cmb2_render_analytics_params_callback($field, $value, $object_id, $object_type, $field_type) {
        $value = wp_parse_args( $value, array(
            'utm_source'    => '',
            'utm_medium'    => '',
            'utm_campaign'  => '',
            'utm_term'      => '',
            'utm_content'   => '',
        ) );
        ?>

        <div class="alignleft"><p><label for="<?php echo $field_type->_id( '_utm_source' ); ?>"><?php echo __( 'Referrer', 'rex-product-feed' ); ?></label></p>
            <?php echo $field_type->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type->_name( '[utm_source]' ),
                'id'    => $field_type->_id( '_utm_source' ),
                'type'  => 'text',
                'value' => $value['utm_source'],
            ) ); ?>
            <p class="cmb2-metabox-description"><?php echo __('The referrer: (e.g. google, newsletter)', 'rex-product-feed'); ?></p>
        </div>

        <div class="alignleft"><p><label for="<?php echo $field_type->_id( '_utm_medium' ); ?>"><?php echo __( 'Medium', 'rex-product-feed' ); ?></label></p>
            <?php echo $field_type->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type->_name( '[utm_medium]' ),
                'id'    => $field_type->_id( '_utm_medium' ),
                'type'  => 'text',
                'value' => $value['utm_medium'],
            ) ); ?>
            <p class="cmb2-metabox-description"><?php echo __('Marketing medium: (e.g. cpc, banner, email)', 'rex-product-feed'); ?></p>
        </div>


        <div class="alignleft"><p><label for="<?php echo $field_type->_id( '_utm_campaign' ); ?>"><?php echo __( 'Campaign', 'rex-product-feed' ); ?></label></p>
            <?php echo $field_type->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type->_name( '[utm_campaign]' ),
                'id'    => $field_type->_id( '_utm_campaign' ),
                'type'  => 'text',
                'value' => $value['utm_campaign'],
            ) ); ?>
            <p class="cmb2-metabox-description"><?php echo __('Product, promo code, or slogan (e.g. spring_sale)', 'rex-product-feed'); ?></p>
        </div>

        <div class="alignleft"><p><label for="<?php echo $field_type->_id( '_utm_term' ); ?>"><?php echo __( 'Campaign term', 'rex-product-feed' ); ?></label></p>
            <?php echo $field_type->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type->_name( '[utm_term]' ),
                'id'    => $field_type->_id( '_utm_term' ),
                'type'  => 'text',
                'value' => $value['utm_term'],
            ) ); ?>
            <p class="cmb2-metabox-description"><?php echo __('Identify the paid keywords', 'rex-product-feed'); ?></p>
        </div>


        <div class="alignleft"><p><label for="<?php echo $field_type->_id( '_utm_content' ); ?>"><?php echo __( 'Campaign content', 'rex-product-feed' ); ?></label></p>
            <?php echo $field_type->input( array(
                'class' => 'cmb_text_small',
                'name'  => $field_type->_name( '[utm_content]' ),
                'id'    => $field_type->_id( '_utm_content' ),
                'type'  => 'text',
                'value' => $value['utm_content'],
            ) ); ?>
            <p class="cmb2-metabox-description"><?php echo __('Use to differentiate ads', 'rex-product-feed'); ?></p>
        </div>

        <p class="clear">
            <?php echo $field_type->_desc(true);?>
        </p>

        <?php
    }


    /**
     * Add Pixel to WC pages
     * @throws Exception
     */
    public function wpfm_enable_facebook_pixel() {
        global $product;
        $currency = get_woocommerce_currency();
        $wpfm_fb_pixel_enabled = get_option('wpfm_fb_pixel_enabled', 'no');
        $viewContent = "";
        if($wpfm_fb_pixel_enabled == 'yes') {
            $wpfm_fb_pixel_data = get_option('wpfm_fb_pixel_value');
            if(isset($wpfm_fb_pixel_data)) {
                if(is_product()){
                    $product_id = $product->get_id();
                    $price = $product->get_price();
                    $product_title = $product->get_name();
                    $cats = '';
                    $terms = wp_get_post_terms( $product_id, 'product_cat' , array( 'orderby' => 'term_id' ));

                    if ( empty( $terms ) || is_wp_error( $terms ) ){
                        $cats = '';
                    }else {
                        foreach ( $terms as $term ) {
                            $cats .= $term->name . ',';
                        }
                        $cats = rtrim($cats, ",");
                        $cats = str_replace("&amp;","&", $cats);
                    }

                    if($product->is_type('variable')) {
                        $variation_id = $this->wpfm_find_matching_product_variation( $product, $_GET );
                        $total_get = count($_GET);
                        if($total_get>0 && $variation_id > 0) {
                            $product_id = $variation_id;
                            $variable_product = wc_get_product($variation_id);
                            $content_type = 'product';
                            if(is_object($variable_product)) {
                                $formatted_price = wc_format_decimal( $variable_product->get_price(), wc_get_price_decimals());
                            }else {
                                $prices  = $product->get_variation_prices();
                                $lowest  = reset( $prices['price'] );
                                $formatted_price = wc_format_decimal( $lowest, wc_get_price_decimals());
                            }
                        }
                        else {
                            $variation_ids = $product->get_visible_children();
                            $prices  = $product->get_variation_prices();
                            $lowest  = reset( $prices['price'] );
                            $formatted_price = wc_format_decimal( $lowest, wc_get_price_decimals());
                            $product_ids = '';
                            foreach ($variation_ids as $variation) {
                                $product_ids .= "'" .$variation. "'" . ',';
                            }
                            $product_id = rtrim($product_ids, ",");
                            $content_type = 'product_group';
                        }
                    }
                    else {
                        $formatted_price = wc_format_decimal( $price, wc_get_price_decimals() );
                        $content_type = 'product';
                    }
                    $viewContent = "fbq(\"track\",\"ViewContent\",{content_category:\"$cats\", content_name:\"$product_title\", content_type:\"$content_type\", content_ids:[\"$product_id\"],value:\"$formatted_price\",currency:\"$currency\"});";
                    ?>

                <?php }
                elseif (is_product_category()) {
                    global $wp_query;
                    $product_ids = wp_list_pluck( $wp_query->posts, "ID" );
                    $term = get_queried_object();

                    $product_id = '';

                    foreach ($product_ids as $id) {
                        $product = wc_get_product($id);
                        if ( ! is_object( $product ) ) {
                            continue;
                        }

                        if ( ! $product->is_visible() ) {
                            continue;
                        }

                        if($product->is_type('simple')){
                            $product_id .= $id.',';;
                        }elseif ($product->is_type('variable')) {
                            $variations = $product->get_visible_children();
                            foreach ($variations as $variation) {
                                $product_id .= $variation. ',';
                            }
                        }
                    }
                    $product_id = rtrim($product_id, ",");
                    $category_name = $term->name;
                    $category_path = $this->get_the_term_path($term->term_id, 'product_cat', ' > ');
                    $viewContent = "fbq(\"trackCustom\",\"ViewCategory\",{content_category:\"$category_path\", content_name:\"$category_name\", content_type:\"product\", content_ids:\"[$product_id]\"});";
                }
                elseif (is_search()) {
                    $term = get_queried_object();
                    $search_term = sanitize_text_field($_GET['s']);
                    global $wp_query;
                    $product_ids = wp_list_pluck( $wp_query->posts, "ID" );

                    $product_id = '';

                    foreach ($product_ids as $id) {
                        $product = wc_get_product($id);
                        if ( ! is_object( $product ) ) {
                            continue;
                        }

                        if ( ! $product->is_visible() ) {
                            continue;
                        }

                        if($product->is_type('simple')){
                            $product_id .= $id.',';;
                        }elseif ($product->is_type('variable')) {
                            $variations = $product->get_visible_children();
                            foreach ($variations as $variation) {
                                $product_id .= $variation. ',';
                            }
                        }
                    }
                    $product_id = rtrim($product_id, ",");
                    $viewContent = "fbq(\"trackCustom\",\"Search\",{search_string:\"$search_term\", content_type:\"product\", content_ids:\"[$product_id]\"});";
                }
                elseif (is_cart() || is_checkout()) {
                    if ( is_checkout() && !empty( is_wc_endpoint_url('order-received') ) ) {
                        $order_key = sanitize_text_field($_GET['key']);
                        if(!empty($order_key)) {
                            $order_id = wc_get_order_id_by_order_key($order_key);
                            $order = wc_get_order($order_id);
                            $order_items = $order->get_items();
                            $order_real = 0;
                            $contents = "";
                            if (!is_wp_error($order_items)) {
                                foreach ($order_items as $item_id => $order_item) {
                                    $prod_id = $order_item->get_product_id();
                                    $prod_quantity = $order_item->get_quantity();
                                    $order_subtotal = $order_item->get_subtotal();
                                    $order_subtotal_tax = $order_item->get_subtotal_tax();
                                    $order_real += number_format(($order_subtotal + $order_subtotal_tax), 2);
                                    $contents .= "{'id': '$prod_id', 'quantity': $prod_quantity},";
                                }
                            }
                            $contents = rtrim($contents, ",");
                            $viewContent = "fbq(\"trackCustom\",\"Purchase\",{content_type:\"product\", value:\"$order_real\", currency:\"$currency\", contents:\"[$contents]\"});";
                        }
                    }else {
                        $cart_real = 0;
                        $contents = "";
                        foreach( WC()->cart->get_cart() as $cart_item ){
                            $product_id = $cart_item['product_id'];
                            if ($cart_item['variation_id'] > 0) {
                                $product_id = $cart_item['variation_id'];
                            }$contents .= "'" .$product_id. "'" . ',';
                            $line_total = $cart_item['line_total'];
                            $line_tax = $cart_item['line_tax'];
                            $cart_real += number_format(($line_total + $line_tax), 2);
                        }
                        $contents = rtrim($contents, ",");
                        if(is_cart()) {
                            $viewContent = "fbq(\"trackCustom\",\"AddToCart\",{ content_type:\"product\", value:\"$cart_real\", currency:\"$currency\", content_ids:\"[$contents]\"});";
                        }elseif (is_checkout()) {
                            $viewContent = "fbq(\"trackCustom\",\"InitiateCheckout\",{content_type:\"product\", value:\"$cart_real\", currency:\"$currency\", content_ids:\"[$contents]\"});";
                        }
                    }
                }
            }

            ?>
            <!-- Facebook pixel code - added by RexTheme.com -->
            <script type="text/javascript">
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                    n.queue=[];t=b.createElement(e);t.async=!0;
                    t.src=v;s=b.getElementsByTagName(e)[0];
                    s.parentNode.insertBefore(t,s)}(window, document,'script',
                    'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '<?php print"$wpfm_fb_pixel_data";?>');
                fbq('track', 'PageView');
                <?php
                if(strlen($viewContent) > 2){
                    print"$viewContent";
                }
                ?>
            </script>
            <noscript>
                <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo  "$wpfm_fb_pixel_data";?>&ev=PageView&noscript=1"/>
            </noscript>
            <!-- End Facebook Pixel Code -->
        <?php }
    }


    /**
     * @param $id
     * @param $taxonomy
     * @param string $sep
     * @param bool $is_visited
     * @return array|string|WP_Error|WP_Term|null
     */
    protected function get_the_term_path( $id, $taxonomy, $sep = '', $is_visited =  false) {
        $term = get_term( $id, $taxonomy );
        if ( is_wp_error( $term ) )
            return $term;
        $name = $term->name;
        if($is_visited) {
            $path = '';
        }else {
            $path = 'Home';
        }
        if($term->parent && ( $term->parent != $term->term_id )) {
            $path .= $this->get_the_term_path($term->parent, $taxonomy, $sep, true);
        }
        $path .= $sep.$name;
        return $path;
    }


    /**
     * Find matching product variation
     *
     * @param WC_Product $product
     * @param array $attributes
     * @return int Matching variation ID or 0.
     * @throws Exception
     */
    protected function wpfm_find_matching_product_variation( $product, $attributes ) {
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

}
