<?php
/**
 * Plugin Name: Dropshipping and Fulfillment for AliExpress and WooCommerce
 * Plugin URI: https://villatheme.com/extensions/woo-alidropship/
 * Description: Transfer data from AliExpress products to WooCommerce effortlessly and fulfill WooCommerce order to AliExpress automatically.
 * Version: 1.0.2.1
 * Author: VillaTheme(villatheme.com)
 * Author URI: http://villatheme.com
 * Text Domain: woo-alidropship
 * Copyright 2019 VillaTheme.com. All rights reserved.
 * Tested up to: 5.4
 * WC tested up to: 4.2
 **/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'VI_WOO_ALIDROPSHIP_VERSION', '1.0.2.1' );
/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce-alidropship/woocommerce-alidropship.php' ) ) {
	return;
}
define( 'VI_WOO_ALIDROPSHIP_DIR', plugin_dir_path( __FILE__ ) );
define( 'VI_WOO_ALIDROPSHIP_INCLUDES', VI_WOO_ALIDROPSHIP_DIR . "includes" . DIRECTORY_SEPARATOR );
if ( is_file( VI_WOO_ALIDROPSHIP_INCLUDES . "class-vi-wad-ali-orders-info-table.php" ) ) {
	require_once VI_WOO_ALIDROPSHIP_INCLUDES . "class-vi-wad-ali-orders-info-table.php";
}
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	$init_file = VI_WOO_ALIDROPSHIP_INCLUDES . "define.php";
	require_once $init_file;
}

/**
 * Class VI_WOO_ALIDROPSHIP
 */
class VI_WOO_ALIDROPSHIP {
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'install' ) );
		add_action( 'admin_notices', array( $this, 'global_note' ) );
	}

	function global_note() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			?>
            <div id="message" class="error">
                <p><?php _e( 'Please install and activate WooCommerce to use Dropshipping and Fulfillment for AliExpress and WooCommerce plugin.', 'woo-alidropship' ); ?></p>
            </div>
			<?php
		}
	}


	/**
	 * When active plugin Function will be call
	 */
	public function install() {
		global $wp_version;
		if ( version_compare( $wp_version, "2.9", "<" ) ) {
			deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
			wp_die( "This plugin requires WordPress version 2.9 or higher." );
		}
		Vi_Wad_Ali_Orders_Info_Table::create_table();
		$check_active = get_option( 'wooaliexpressdropship_params' );
		if ( ! $check_active ) {
			update_option( 'wooaliexpressdropship_params', array( 'secret_key' => md5( time() ) ) );
			add_action( 'activated_plugin', array( $this, 'after_activated' ) );
		} else {
			/*Fix: Can not add to cart if variable product was imported as simple product because it has only 1 variation when "Ignore ship from" is enabled*/
			$args  = array(
				'post_type'      => 'product',
				'post_status'    => array( 'publish', 'pending', 'draft', 'private' ),
				'posts_per_page' => - 1,
				'meta_key'       => '_vi_wad_aliexpress_product_id',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_type',
						'field'    => 'slug',
						'terms'    => 'simple',
					),
				)
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$woo_id = get_the_ID();
					$id     = VI_WOO_ALIDROPSHIP_DATA::product_get_id_by_woo_id( $woo_id );
					if ( $id ) {
						$variations = get_post_meta( $id, '_vi_wad_variations', true );
						if ( is_array( $variations ) && count( $variations ) === 1 ) {
							if ( ! empty( $variations[0]['skuId'] ) ) {
								update_post_meta( $woo_id, '_vi_wad_aliexpress_variation_id', $variations[0]['skuId'] );
							}
							if ( ! empty( $variations[0]['skuAttr'] ) ) {
								update_post_meta( $woo_id, '_vi_wad_aliexpress_variation_attr', $variations[0]['skuAttr'] );
							}
						}
					}
				}
			}
			wp_reset_postdata();
		}
	}

	public function after_activated( $plugin ) {
		if ( $plugin == plugin_basename( __FILE__ ) ) {
			$url = admin_url( '?vi_wad_setup_wizard=true' );
			$url = add_query_arg( '_wpnonce', wp_create_nonce( 'vi_wad_setup' ), $url );
			exit( wp_redirect( $url ) );
		}
	}
}

new VI_WOO_ALIDROPSHIP();