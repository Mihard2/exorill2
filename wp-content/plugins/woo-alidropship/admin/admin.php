<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_ALIDROPSHIP_Admin_Admin {
	protected $settings;
	protected $characters_array;

	function __construct() {
		$this->settings = VI_WOO_ALIDROPSHIP_DATA::get_instance();

		add_filter(
			'plugin_action_links_woo-alidropship/woo-alidropship.php', array(
				$this,
				'settings_link'
			)
		);

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'vi_wad_print_scripts', array( $this, 'dismiss_notice' ) );
	}

	/**
	 * Link to Settings
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=woo-alidropship" title="' . __( 'Settings', 'woo-alidropship' ) . '">' . __( 'Settings', 'woo-alidropship' ) . '</a>';

		array_unshift( $links, $settings_link );

		return $links;
	}


	/**
	 * Function init when run plugin+
	 */
	function init() {
		/*Register post type*/
		load_plugin_textdomain( 'woo-alidropship' );
		$this->load_plugin_textdomain();
		if ( class_exists( 'VillaTheme_Support' ) ) {
			new VillaTheme_Support(
				array(
					'support'   => 'https://wordpress.org/support/plugin/woo-alidropship/',
					'docs'      => 'http://docs.villatheme.com/?item=woo-alidropship',
					'review'    => 'https://wordpress.org/support/plugin/woo-alidropship/reviews/?rate=5#rate-response',
					'pro_url'   => '',
					'css'       => VI_WOO_ALIDROPSHIP_CSS,
					'image'     => VI_WOO_ALIDROPSHIP_IMAGES,
					'slug'      => 'woo-alidropship',
					'menu_slug' => 'woo-alidropship',
					'version'   => VI_WOO_ALIDROPSHIP_VERSION
				)
			);
		}
	}


	/**
	 * load Language translate
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woo-alidropship' );
		// Admin Locale
		if ( is_admin() ) {
			load_textdomain( 'woo-alidropship', VI_WOO_ALIDROPSHIP_LANGUAGES . "woo-alidropship-$locale.mo" );
		}

		// Global + Frontend Locale
		load_textdomain( 'woo-alidropship', VI_WOO_ALIDROPSHIP_LANGUAGES . "woo-alidropship-$locale.mo" );
		load_plugin_textdomain( 'woo-alidropship', false, VI_WOO_ALIDROPSHIP_LANGUAGES );
	}


	public function admin_notices() {
		if ( isset( $_GET['wad_dismiss_notice'] ) && $_GET['wad_dismiss_notice'] == 0 ) {
			update_user_meta( get_current_user_id(), 'vi_wad_show_notice', VI_WOO_ALIDROPSHIP_VERSION );
		}

		$notice_checked = get_user_meta( get_current_user_id(), 'vi_wad_show_notice', true );
		if ( version_compare( VI_WOO_ALIDROPSHIP_VERSION, $notice_checked, '<=' ) ) {
			return;
		}

		if ( VI_WOO_ALIDROPSHIP_VERSION !== '1.0.0.1' ) {
			return;
		}

		?>
        <div class="notice notice-info " style="position: relative;padding-right: 38px">
            <p><?php _e( 'WooCommerce AliExpress Dropshipping Extension is published in Chrome Web Store. You can install the latest version <a target="_blank" href="https://chrome.google.com/webstore/detail/woocommerce-aliexpress-dr/egamhjcccjiflajhhinondgonlldjgba">Here</a>', 'woo-alidropship' ); ?>

            </p>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=woo-alidropship&wad_dismiss_notice=0' ) ) ?>"
               class="notice-dismiss" style="text-decoration: none;">
                <span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'woo-alidropship' ) ?></span>
            </a>
        </div>
		<?php
	}

	public function dismiss_notice() {
		update_user_meta( get_current_user_id(), 'vi_wad_show_notice', VI_WOO_ALIDROPSHIP_VERSION );
	}
}
