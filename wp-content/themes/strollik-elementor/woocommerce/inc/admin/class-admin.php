<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require get_theme_file_path( 'inc/admin/tgm/class-tgm-plugin-activation.php' );

/**
 * Class Strollik_Theme_Admin
 */
class Strollik_Theme_Admin {
	public static $instance;
	private       $include_screens_path;
	private       $plugins_required = [];
	private       $plugins          = [];
	private       $tabs_menu        = [];


	public function __construct() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$this->include_screens_path = trailingslashit( get_template_directory() ) . 'inc/admin/screens/';


		add_filter( 'opal_theme_customize_layout_content', array( $this, 'layout_content' ) );
		add_filter( 'pt-ocdi/plugin_page_setup', array( $this, 'custom_menu_import' ) );
		add_filter( 'pt-ocdi/plugin_page_title', array( $this, 'render_page_demos' ), 1 );
		add_filter( 'tgmpa_notice_action_links', array( $this, 'edit_tgmpa_notice_action_links' ) );

		add_action( 'admin_menu', array( $this, 'create_admin_menus' ), 9 );
		add_action( 'admin_menu', array( $this, 'edit_admin_menus' ), 999 );

//		add_action( 'cmb2_admin_init', array( $this, 'add_license_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_settings_page' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'dashboard_scrips' ) );

		// TGM Plugins
		add_filter( 'tgmpa_admin_menu_args', array( $this, 'edit_menu_title_plugin' ) );
	}


	public function edit_menu_title_plugin( $args ) {
		$count = $this->get_plugins_count();
		if ( $count > 0 ) {
			$args['menu_title'] = __( 'Install Plugins', 'strollik' ) . ' <span class="update-plugins"><span class="update-count">' . $count . '</span></span>';
		}

		return $args;
	}

	public function dashboard_scrips( $hook ) {
		$listPage = [
			'toplevel_page_opal-theme',
			'opal-theme_page_opal-theme-tutorials',
			'opal-theme_page_opal-theme-changelog',
			'opal-theme_page_opal-settings',
			'opal-theme_page_pt-one-click-demo-import',
			'opal-theme_page_opal-theme-plugins',
		];
		if ( in_array( get_current_screen()->base, $listPage ) ) {
			remove_all_actions( 'admin_notices' );
			wp_enqueue_style( 'dashboard_css', get_template_directory_uri() . '/inc/admin/css/admin.css' );
		}
		if ( $hook === 'opal-theme_page_opal-theme-tutorials' ) {
			wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/inc/admin/css/magnific-popup.css' );
			wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/inc/admin/js/jquery.magnific-popup.min.js', array( 'jquery' ), false, true );
			wp_add_inline_script( 'magnific-popup', $this->tutorial_script_inline() );
		}

	}

	private function tutorial_script_inline() {
		return <<<JS
		
	jQuery(document).ready(function() {
		jQuery('.opal-popup-tutorial').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	});
    
JS;

	}


	public function add_settings_page() {
		/**
		 * Registers main options page menu item and form.
		 */
		$args = array(
			'id'           => 'api_key',
			'title'        => __( 'Settings', 'strollik' ),
			'object_types' => array( 'options-page' ),
			'option_key'   => 'opal-settings',
			'tab_group'    => 'opal_settings',
			'tab_title'    => __( 'API Key', 'strollik' ),
			'parent_slug'  => 'opal-theme', // Make options page a submenu item of the themes menu.
		);
		// 'tab_group' property is supported in > 2.4.0.
		if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
			$args['display_cb'] = array( $this, 'options_display_with_tabs' );
		}
		$main_options = new_cmb2_box( $args );
		$main_options->add_field( array(
			'name'        => __( 'Google API key', 'strollik' ),
			'description' => sprintf( __( 'Please go to <a href="%s" target="_blank">Google developers page</a> to get API key.', 'strollik' ), 'https://developers.google.com/maps/documentation/javascript/get-api-key' ),
			'id'          => 'api_key',
			'type'        => 'text',
		) );
	}

	/**
	 * A CMB2 options-page display callback override which adds tab navigation among
	 * CMB2 options pages which share this same display callback.
	 *
	 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
	 */
	public function options_display_with_tabs( $cmb_options ) {
		$this->get_tab_menu( 'settings' );
		$tabs = $this->options_page_tabs( $cmb_options );
		?>
        <div class="wrap cmb2-options-page option-<?php echo esc_attr( $cmb_options->option_key ); ?>">
			<?php if ( get_admin_page_title() ) : ?>
                <h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
			<?php endif; ?>
            <h2 class="nav-tab-wrapper">
				<?php foreach ( $tabs as $option_key => $tab_title ) : ?>
                    <a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>"
                       href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
				<?php endforeach; ?>
            </h2>
            <form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST"
                  id="<?php echo esc_attr( $cmb_options->cmb->cmb_id ); ?>" enctype="multipart/form-data"
                  encoding="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
				<?php $cmb_options->options_page_metabox(); ?>
				<?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
            </form>
        </div>
		<?php
	}

	/**
	 * Gets navigation tabs array for CMB2 options pages which share the given
	 * display_cb param.
	 *
	 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
	 *
	 * @return array Array of tab information.
	 */
	public function options_page_tabs( $cmb_options ) {
		$tab_group = $cmb_options->cmb->prop( 'tab_group' );
		$tabs      = array();
		foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
			if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
				$tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
					? $cmb->prop( 'tab_title' )
					: $cmb->prop( 'title' );
			}
		}

		return $tabs;
	}

	public function add_license_page() {
		/**
		 * Registers options page menu item and form.
		 */
		$cmb = new_cmb2_box( array(
			'id'           => 'opal-theme-license',
			'title'        => esc_html__( 'License', 'strollik' ),
			'object_types' => array( 'options-page' ),
			'option_key'   => 'opal-theme-license',
			'parent_slug'  => 'opal-theme',
		) );
		$cmb->add_field( array(
			'name'    => esc_html__( 'User Name Envato', 'strollik' ),
			'id'      => 'username',
			'type'    => 'text',
			'default' => '',
		) );

		$cmb->add_field( array(
			'name'    => esc_html__( 'Purchase Code', 'strollik' ),
			'id'      => 'purchased_code',
			'type'    => 'text',
			'default' => '',
		) );
	}


	public function edit_tgmpa_notice_action_links( $action_links ) {
		$current_screen = get_current_screen();

		if ( 'opal-theme-plugins' == $current_screen->id ) {
			$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="#opal-install-plugins">' . esc_attr__( 'Manage Plugins Below', 'strollik' ) . '</a>';
		} else {
			$link_template = '<a id="manage-plugins" class="button-primary" style="margin-top:1em;" href="' . esc_url( self_admin_url( 'admin.php?page=opal-theme-plugins' ) ) . '#opal-install-plugins">' . esc_attr__( 'Go Manage Plugins', 'strollik' ) . '</a>';
		}

		$action_links = array( 'install' => $link_template, 'dismiss' => $action_links['dismiss'] );

		return $action_links;
	}

	public function render_page_demos( $content ) {
		ob_start();
		$this->get_tab_menu( 'demos' );
		$content .= ob_get_clean();

		return $content;
	}

	public function create_admin_menus() {
		global $pagenow;
		$this->set_plugins_required();
		$this->setup_tab_menus();
		add_menu_page(
			'Opal Theme',
			'Opal Theme',
			'import',
			'opal-theme',
			array( $this, 'welcome_screen' ),
			get_theme_file_uri( 'inc/admin/images/menu-icon-red.png' ),
			2
		);
        if(isset($this->tabs_menu['tutorials'])){
	        add_submenu_page( 'opal-theme',
		        'Tutorials',
		        'Tutorials',
		        'manage_options',
		        'opal-theme-tutorials',
		        array( $this, 'tutorials_screen' )
	        );
        }


		add_submenu_page( 'opal-theme',
			'Changelog',
			'Changelog',
			'manage_options',
			'opal-theme-changelog',
			array( $this, 'changelog_screen' )
		);
//
		// Redirect to Opal welcome page after activating theme.
		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) && $_GET['activated'] == 'true' ) {
			// Redirect
			wp_redirect( admin_url( 'admin.php?page=opal-theme' ) );
		}
	}

	public function edit_admin_menus() {
		global $submenu;

		if ( current_user_can( 'edit_theme_options' ) ) {
			$submenu['opal-theme'][0][0] = esc_attr__( 'Welcome', 'strollik' );
		}
	}

	/**
	 * @param $args array
	 */
	public function custom_menu_import( $args ) {
		$args['parent_slug'] = 'opal-theme';
		$args['menu_title']  = __( 'Import Demos', 'strollik' );

		if ( $this->get_plugins_require_count() > 0 ) {
			foreach ( $args as $key => $value ) {
				$args[ $key ] = false;
			}
		}

		return $args;
	}

	public function welcome_screen() {
		require_once $this->include_screens_path . 'welcome.php';
	}

	public function tutorials_screen() {
		require_once $this->include_screens_path . 'tutorials.php';
	}

	public function changelog_screen() {
		require_once $this->include_screens_path . 'changelog.php';
	}

	public function layout_content() {
		return is_front_page();
	}

	private function setup_tab_menus() {
		$this->tabs_menu['welcome']   = [
			'name' => __( 'Dashboard', 'strollik' ),
			'path' => 'admin.php?page=opal-theme',
		];
		if ( TGM_Plugin_Activation::$instance->is_tgmpa_complete() !== true ) {
			$this->tabs_menu['plugins'] = [
				'name' => __( 'Plugins', 'strollik' ),
				'path' => 'admin.php?page=opal-theme-plugins',
			];
		}

		if ( $this->get_plugins_require_count() <= 0 ) {
			$this->tabs_menu['demos'] = [
				'name' => __( 'Demo Importer', 'strollik' ),
				'path'  => 'admin.php?page=pt-one-click-demo-import',
			];
		}

		$this->tabs_menu['settings']  = [
			'name' => __( 'Settings', 'strollik' ),
			'path'  => 'admin.php?page=opal-settings',
		];

		$this->tabs_menu['tutorials'] = [
			'name' => __( 'Tutorials', 'strollik' ),
			'path'  => 'admin.php?page=opal-theme-tutorials',
		];
		unset($this->tabs_menu['tutorials']);

		$this->tabs_menu['changelog'] = [
			'name' => 'Changelog',
			'path'  => 'admin.php?page=opal-theme-changelog',
		];
	}

	/**
	 * Renders the admin screens header with title, logo and tabs.
	 *
	 * @since   5.0.0
	 *
	 * @access  public
	 *
	 * @param string $screen The current screen.
	 *
	 * @return void
	 */
	public function get_tab_menu( $screen = 'welcome' ) {
		$my_theme = wp_get_theme();
		?>

        <div class="opal-dashboard-wrapper">
            <div class="wrapper-bg"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="inner theme-infomation">
                            <a class="pull-right" href="https://www.wpopal.com/" title="WpOpal" target="_blank">
                                <img src="<?php echo esc_url( get_theme_file_uri( 'inc/admin/images/opal-logo.png' ) ); ?>"
                                     title="wp opal">
                            </a>
                            <h1 class="theme-title"><?php esc_attr_e( 'Welcome to', 'strollik' ); ?>

								<?php echo esc_html( $my_theme->get( 'Name' ) ); ?> !
                            </h1>
                            <span class="theme-version"><?php echo esc_attr__( 'Version', 'strollik' ) . ' ' . $my_theme->get( 'Version' ); ?></span>
                        </div>
                        <ul class="opal-tabs">
                            <?php foreach ($this->tabs_menu as $key => $tab){  ?>
                                <li class="opal-nav-item">
                                    <a href="<?php echo esc_url_raw( ( $key === $screen ) ? '#' : admin_url( $tab['path'] ) ); ?>"
                                       class="<?php echo ( $key === $screen ) ? 'active' : ''; ?> opal-nav-link"><?php echo esc_html( $tab['name'] ); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}


	private function set_plugins_required() {
		$tgm = TGM_Plugin_Activation::get_instance();
		foreach ( $tgm->plugins as $slug => $plugin ) {
			if ( $plugin['required'] && ! $tgm->is_plugin_active( $slug ) ) {
				$this->plugins_required[] = $plugin;
			}

			if ( ! $tgm->is_plugin_active( $slug ) || $tgm->does_plugin_have_update( $slug ) ) {
				$this->plugins[] = $plugin;
			}
		}
	}

	public function get_plugins_required() {
		return $this->plugins_required;
	}

	public function get_plugins_require_count() {
		return count( $this->plugins_required );
	}

	public function get_plugins_count() {
		return count( $this->plugins );
	}

	public static function getInstance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Strollik_Theme_Admin ) ) {
			self::$instance = new Strollik_Theme_Admin();
		}

		return self::$instance;
	}
}

Strollik_Theme_Admin::getInstance();