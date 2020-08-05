<?php

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Addons {
	public function __construct() {
		$this->include_addons();
		add_action( 'elementor/init', array( $this, 'add_category' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'override_widgets' ) );

		add_action( 'wp', [ $this, 'regeister_scripts_frontend' ] );

		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts_frontend' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'add_scripts_editor' ] );

		add_action( 'widgets_init', array( $this, 'register_wp_widgets' ) );

		add_action( 'wp_ajax_osf_ajax_loadmore_post', array( $this, 'ajax_get_more_post' ) );
		add_action( 'wp_ajax_nopriv_osf_ajax_loadmore_post', array( $this, 'ajax_get_more_post' ) );

		// Elementor Fix Noitice
		add_action('elementor/editor/before_enqueue_scripts', array($this, 'elementor_fix_notice'));
	}

	public function elementor_fix_notice() {
		if (function_exists('WC')) {
			remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
			remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
			remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
		}
	}

	private function include_addons(){
		$files = glob(trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/vendors/elementor/addons/*.php');
		foreach ($files as $file){
			if(file_exists($file)){
				require_once $file;
			}
		}
	}

	public function register_wp_widgets() {
		require_once 'widgets/wp_template.php';
		register_widget( 'Opal_WP_Template' );
	}

	function regeister_scripts_frontend() {
		wp_register_style( 'magnific-popup', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/css/magnific-popup.css' );
		wp_register_style( 'tooltipster-bundle', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/css/tooltipster.bundle.min.css', array(), STROLLIK_CORE_VERSION, 'all' );

		wp_register_script( 'magnific-popup', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/jquery.magnific-popup.min.js', array( 'jquery' ), false, true );
		wp_register_script( 'spritespin', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/spritespin.js' );


        wp_register_script('tweenmax', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/TweenMax.min.js', array('jquery'), STROLLIK_CORE_VERSION, true);
        wp_register_script('parallaxmouse', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/jquery-parallax.js', array('jquery'), STROLLIK_CORE_VERSION, true);
        wp_register_script('tilt', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/universal-tilt.min.js', array('jquery'), STROLLIK_CORE_VERSION, true);
        wp_register_script('waypoints', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.waypoints.js', array('jquery'), STROLLIK_CORE_VERSION, true);

		wp_register_script( 'smartmenus', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/jquery.smartmenus.min.js', array( 'jquery' ), STROLLIK_CORE_VERSION, true );
		wp_register_script( 'tooltipster-bundle-js', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/js/libs/tooltipster.bundle.min.js', array(), STROLLIK_CORE_VERSION, true );

		wp_register_script('wavify', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/wavify.js', array( 'jquery' ), STROLLIK_CORE_VERSION, true);
		wp_register_script('jquery-wavify', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/jquery.wavify.js', array( 'jquery' ), STROLLIK_CORE_VERSION, true);

		wp_register_script('fullpage', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/fullpage.min.js', array( 'jquery' ), STROLLIK_CORE_VERSION, true);

		wp_register_script('pushmenu', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/mlpushmenu.js', array(), STROLLIK_CORE_VERSION, true);
		wp_register_script('pushmenu-classie', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/classie.js', array(), STROLLIK_CORE_VERSION, true);
		wp_register_script('modernizr', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/modernizr.custom.js', array(), STROLLIK_CORE_VERSION, false);
        wp_enqueue_style( 'strollik-core-update', trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/css/strollik-core-update.css' );
    }

    public function add_scripts_editor() {
        wp_enqueue_script('opal-elementor-admin-editor', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/elementor/admin-editor.js', [], false, true);
    }


    public function enqueue_scripts_frontend() {
        wp_enqueue_script('opal-elementor-frontend', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/elementor/frontend.js', ['jquery'], false, true);
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function override_widgets($widgets_manager) {
        require_once 'override/image-box.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Image_Box());

        require_once 'override/icon-box.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Icon_Box());

        require_once 'override/icon-list.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Icon_List());

        require_once 'override/progress.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Progress());

        require_once 'override/toggle.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Widget_Toggle());

        require_once 'override/counter.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Counter());

        require_once 'override/heading.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Heading());

        require_once 'override/text-editor.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Text_Editor());


        require_once 'override/divider.php';
    }

    public function add_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'opal-addons',
            array(
                'title' => __('Opal Addons', 'strollik-core'),
                'icon'  => 'fa fa-plug',
            ),
            1);
    }

    /**
     * @param $widgets_manager Elementor\Widgets_Manager
     */
    public function include_widgets($widgets_manager) {

        require 'abstract/carousel.php';

        require 'widgets/posts-grid.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Post_Grid());

        require 'widgets/testimonial.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Testimonials());

        require 'widgets/template.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Template());

        require 'widgets/tabs.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Tabs());

        require 'widgets/nav-menu.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Nav_Menu());

        require 'widgets/brand.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Brand());

        require 'widgets/countdown.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Countdown());

        require 'widgets/flip-box.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Flip_Box());

        require 'widgets/team.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Team());

        require 'widgets/team-box.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Team_Box());

        require 'widgets/box-overview.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Box_Overview());

        require 'widgets/video.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Video_Popup());

        require 'widgets/google-map.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Google_Map());

        require 'widgets/site-logo.php';
        $widgets_manager->register_widget_type(new OSF_Element_Site_Logo());

        require 'widgets/search-form.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Search_Form());

        require 'widgets/price-table.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Price_Table());

        require 'widgets/text-carousel.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Text_Carousel());

        require 'widgets/social-share.php';
        $widgets_manager->register_widget_type(new OSF_Element_Social_Share());

        require 'widgets/metadata.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Metadata());

        require 'widgets/account.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Account());

        require_once 'widgets/call-to-action.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_CallToAction());

        require_once 'widgets/instagram.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Instagram());


        require_once 'widgets/header-group.php';
        $widgets_manager->register_widget_type(new OSF_Elementor_Header_Group());

        require_once 'widgets/image-layers.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Image_Layers_Widget());

        require_once 'widgets/image-hotspots.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Image_Hotspots_Widget());

        require_once 'widgets/rotate-image.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Rotate_Image());

        require_once 'widgets/table.php';
        $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Table_Widget());

	    require_once 'widgets/wavify.php';
	    $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Wavify());

        if (osf_is_revslider_activated()) {
            require_once 'widgets/rev-slider.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_RevSlider());
        }

        if (osf_is_contactform7_activated()) {
            require 'widgets/button-contact-form.php';
            $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Button_Contact_Form());

            require 'widgets/contactform7.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_ContactForm7());
        }

        if (osf_is_mailchimp_activated()) {
            require_once 'widgets/button-mailchimp.php';
            $widgets_manager->register_widget_type(new Elementor\OSF_Elementor_Button_Mailchimp());

            require_once 'widgets/mailchimp.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_Mailchimp());
        }

        if (osf_is_woocommerce_activated()) {
            require_once 'widgets/products.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_Products());

            require_once 'widgets/single-product.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_Single_Product());

            require_once 'widgets/single-product-2.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_Single_Product_2());

	        require_once 'widgets/wishlist.php';
	        $widgets_manager->register_widget_type(new OSF_Elementor_Wishlist());

            require_once 'widgets/cart.php';
            $widgets_manager->register_widget_type(new OSF_Elementor_Cart());

			require_once 'widgets/add-to-cart.php';
			$widgets_manager->register_widget_type( new \Elementor\OSF_Elementor_Add_To_Cart_Button() );

			require_once 'widgets/product-review.php';
			$widgets_manager->register_widget_type( new OSF_Elementor_Product_Review() );
		}
	}

	public function ajax_get_more_post() {
		$response            = [];
		$query_args          = $_POST['data'];
		$query_args['paged'] = $_POST['paged'] + 1;
		$posts               = new WP_Query( $query_args );

		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();
				ob_start();
				$item_classes = '__all ';
				$item_cats    = get_the_terms( get_the_ID(), 'portfolio_cat' );
				foreach ( (array) $item_cats as $item_cat ) {
					if ( ! empty( $item_cats ) && ! is_wp_error( $item_cats ) ) {
						$item_classes .= $item_cat->slug . ' ';
					}
				}
				echo '<div class="column-item portfolio-entries masonry-item ' . esc_attr( $item_classes ) . '">';
				get_template_part( 'template-parts/portfolio/content' );
				echo '</div>';
				$response['posts'][] = ob_get_clean();
			}
			$response['disable']  = false;
			$response['settings'] = $query_args;
			$response['paged']    = $query_args['paged'];
			if ( $query_args['paged'] == $posts->max_num_pages ) {
				$response['disable'] = true;
			}
		}

		wp_send_json( $response );
	}

}

new OSF_Elementor_Addons();

