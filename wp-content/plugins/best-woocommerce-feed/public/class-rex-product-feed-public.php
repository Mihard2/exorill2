<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed_Pro
 * @subpackage Rex_Product_Feed_Pro/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rex_Product_Feed_Pro
 * @subpackage Rex_Product_Feed_Pro/public
 * @author     RexTheme <#>
 */
class Rex_Product_Feed_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Rex_Product_Feed_Pro_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Rex_Product_Feed_Pro_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        $wpfm_fb_pixel_enabled = get_option('wpfm_enable_fb_pixel', 'no');
        if($wpfm_fb_pixel_enabled == 'yes') {
            $wpfm_fb_pixel_data = get_option('wpfm_fb_pixel_value');
            if(!empty($wpfm_fb_pixel_data)) {
                wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rex-product-feed-addtocart.js', array( 'jquery' ), $this->version, false );
                wp_localize_script( $this->plugin_name, 'wpfm_frontent_ajax', array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'ajax_nonce' => wp_create_nonce('wpfm_add_to_cart_nonce'),
                ));
            }
        }
	}


	public function wpfm_add_to_cart() {
        check_ajax_referer('wpfm_add_to_cart_nonce', 'security');
        $currency = get_woocommerce_currency();
        $product_id = sanitize_text_field($_POST['product_id']);
        $product = wc_get_product( $product_id );
        if ( ! is_object( $product ) ) {
            die();
        }
        $price = $product->get_price();
        $formatted_price = wc_format_decimal( $price, wc_get_price_decimals() );
        $product_title = $product->get_name();
        $product_type = $product->get_type();
        $cats = $this->get_the_term_list($product_id, 'product_cat');
        $response = array (
            'product_id'		=> $product_id,
            'product_name' 		=> $product_title,
            'product_type' 		=> $product_type,
            'product_price'		=> $formatted_price,
            'currency'	=> $currency,
            'cats'		=> $cats
        );
        echo json_encode($response);
        wp_die();
    }


    /**
     * @param $id
     * @param $taxonomy
     * @param string $before
     * @param string $sep
     * @param string $after
     * @return string
     */
    protected function get_the_term_list( $id, $taxonomy, $before = '', $sep = ' > ', $after = '' ) {
        $terms = wp_get_post_terms( $id, $taxonomy , array( 'orderby' => 'term_id' ));
        if ( empty( $terms ) || is_wp_error( $terms ) ){
            return '';
        }
        $term_names = array();
        foreach ( $terms as $term ) {
            $term_names[] = $term->name;
        }
        ksort($term_names);
        return $before . join( $sep, $term_names ) . $after;
    }

}
