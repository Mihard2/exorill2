<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OSF_Scripts {
	/**
	 * OSF_Scripts constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_scripts' ), 999 );
		add_action( 'customize_preview_init', array( $this, 'init_preview_js' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'init_panel_customize_js' ) );

		add_action( 'after_switch_theme', array( $this, 'set_style_theme_mods' ) );
		add_action( 'customize_save_after', array( $this, 'set_style_theme_mods' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_frontend_scripts' ), 100 );

		add_action( 'wp_footer', array( $this, 'megamenu_css' ) );
		add_action( 'admin_head', array( $this, 'fix_svg_thumb_display' ) );
	}

	/**
	 * Assign styles to individual theme mod.
	 *
	 * @return void
	 */
	public function set_style_theme_mods() {
		set_theme_mod( 'osf_theme_custom_style', osf_theme_custom_css() );
		set_theme_mod( 'osf_theme_google_fonts', osf_get_fonts_url() );
	}

	public function add_frontend_scripts() {

//        wp_register_script('otf-counter', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/counter.js', array('jquery'), '1.0.0', true);
		wp_register_script( 'otf-countdown', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/countdown.js', array( 'jquery' ), false, true );
//        wp_enqueue_script( 'bootstrap-js', trailingslashit( STROLLIK_CORE_PLUGIN_URL). '/assets/js/bootstrap.min.js', array('jquery'), false, true );


		if ( get_theme_support( 'opal-customize-css' ) ) {
			$dev_mode = get_theme_mod( 'osf_dev_mode', false );
			// Custom Css
			if ( $dev_mode ) {
				$google_fonts_url = osf_get_fonts_url();
			} else {
				$google_fonts_url = get_theme_mod( 'osf_theme_google_fonts', false );
			}
			if ( $google_fonts_url ) {
				wp_enqueue_style( 'otf-fonts', $google_fonts_url, array(), null );
			}

			if ( is_customize_preview() || $dev_mode ) {
				wp_add_inline_style( 'strollik-style', osf_theme_custom_css() );
			} else {
				$cssCustom = get_theme_mod( 'osf_theme_custom_style', false );
				if ( ! $cssCustom ) {
					$cssCustom = osf_theme_custom_css();
					set_theme_mod( 'osf_theme_custom_style', $cssCustom );
				}
				wp_add_inline_style( 'strollik-style', $cssCustom );
			}

			if ( is_customize_preview() ) {
				add_action( 'wp_footer', array( $this, 'customizer_inline_css' ) );
			}
			wp_add_inline_style( 'strollik-style', apply_filters( 'osf_theme_custom_inline_css', '' ) );
		}

//		wp_enqueue_script( 'imagesLoaded', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/imagesloaded.pkgd.min.js', array( 'jquery' ), '3.0.6' );
//		wp_enqueue_script( 'isotope', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/isotope.pkgd.min.js', array( 'jquery' ), '3.0.6' );

		// Owl Carousel
		wp_enqueue_script( 'owl-carousel', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/owl.carousel.js', array( 'jquery' ), '2.2.1' );
		wp_enqueue_script( 'otf-carousel', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/carousel.js', array( 'owl-carousel' ) );


	}

	public function customizer_inline_css() {
		echo '<div id="osf-style-inline-css-customizer" class="d-none">';
		osf_customize_partial_css();
		echo '</div>';
	}


	public function init_panel_customize_js() {
		wp_enqueue_script(
			'otf-admin-customize',
			STROLLIK_CORE_PLUGIN_URL . 'assets/js/customizer/customize.js',
			array( 'jquery' ),
			null,
			true
		);
	}


	/**
	 * @return void
	 */
	public function init_preview_js() {
		wp_enqueue_style( 'otf-theme-preview', STROLLIK_CORE_PLUGIN_URL . 'assets/css/customize-preview.css' );
		wp_enqueue_script( 'otf-theme-preview', STROLLIK_CORE_PLUGIN_URL . 'assets/js/customizer/preview.js', array(
			'jquery',
			'customize-preview'
		), STROLLIK_CORE_VERSION, true );
		wp_localize_script( 'otf-theme-preview', 'otfCustomizerButtons', apply_filters( 'osf_customizer_buttons', array() ) );
	}

	/**
	 * @return void
	 */
	public function add_admin_scripts( $hook ) {
		global $post;
		if ( $hook === 'widgets.php' ) {
			wp_enqueue_script(
				'otf-admin-color',
				STROLLIK_CORE_PLUGIN_URL . 'assets/3rd-party/alpha-color-picker/alpha-color-picker.js',
				array( 'jquery' ),
				null,
				true
			);
		}

		wp_enqueue_script(
			'otf-admin-select2',
			STROLLIK_CORE_PLUGIN_URL . 'assets/3rd-party/select2/select2.js',
			array( 'jquery' ),
			null,
			true
		);

		//fontpicker
		wp_enqueue_style( 'fonticonpicker-bootstrap', STROLLIK_CORE_PLUGIN_URL . 'assets/3rd-party/fontpicker/jquery.fonticonpicker.bootstrap.min.css' );
		wp_enqueue_style( 'font-awesome', STROLLIK_CORE_PLUGIN_URL . 'assets/3rd-party/fontpicker/font-awesome.min.css' );
		wp_enqueue_script( 'fonticonpicker', STROLLIK_CORE_PLUGIN_URL . 'assets/3rd-party/fontpicker/jquery.fonticonpicker.min.js', array( 'jquery' ) );
		wp_enqueue_style( 'fonticonpicker', STROLLIK_CORE_PLUGIN_URL . 'assets/3rd-party/fontpicker/jquery.fonticonpicker.min.css' );
		wp_enqueue_script( 'font-picker', STROLLIK_CORE_PLUGIN_URL . 'assets/js/fontpicker.js', array( 'jquery' ) );
		wp_enqueue_style( 'opal-icon', get_theme_file_uri( 'assets/css/opal-icons.css' ) );


		wp_enqueue_style( 'otf-admin-style',
			STROLLIK_CORE_PLUGIN_URL . 'assets/css/admin.css' );

		if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
			wp_enqueue_script( 'otf-admin-page', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/admin-page.js' );
		}

	}


	public function megamenu_css() {
		global $megamenu_css;
		if ( $megamenu_css ) {
			echo '<script>';
			echo <<<JS
    jQuery('head').append('<style id="otf-megamenu-render-css" type="text/css">{$megamenu_css}</style>');
JS;
			echo '</script>';
		}
	}

	public function fix_svg_thumb_display() {
		echo '<style type="text/css">
    .media-icon img[src$=".svg"] { 
      width: 100% !important; 
      height: auto !important; 
    }
    </style>
  ';
	}
}

new OSF_Scripts();