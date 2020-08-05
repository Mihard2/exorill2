<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class VI_WOO_ALIDROPSHIP_Admin_System
 */
class VI_WOO_ALIDROPSHIP_Admin_Recommend {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'menu_page' ), 30 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	public static function admin_notices_html( $button, $message ) {
		?>
        <div class="villatheme-dashboard updated" style="border-left: 4px solid #ffba00">
            <div class="villatheme-content">
                <form action="" method="get">
                    <p><?php _e( $message ) ?></p>
                    <p>
						<?php echo wp_kses_post( $button ) ?>
                        <a href="<?php echo esc_url( add_query_arg( array(
							'wad_dismiss_nonce' => wp_create_nonce( 'wad_dismiss_nonce' ),
						) ) ) ?>" target="_self"
                           class="button notice-dismiss vi-button-dismiss"><?php esc_html_e( 'Dismiss', 'woo-alidropship' ) ?></a>
                    </p>
                </form>
            </div>
        </div>
		<?php
	}

	public function admin_notices() {
		global $pagenow;
		$action      = isset( $_REQUEST['action'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['action'] ) ) : '';
		$_plugin     = isset( $_REQUEST['plugin'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['plugin'] ) ) : '';
		$plugin_slug = 'product-variations-swatches-for-woocommerce';
		$plugin      = "{$plugin_slug}/{$plugin_slug}.php";
		$plugins     = get_plugins();
		if ( ! isset( $plugins[ $plugin ] ) ) {
			if ( ! ( $pagenow === 'update.php' && $action === 'install-plugin' && $_plugin === $plugin_slug ) ) {
				$button  = '<a href="' . esc_url( wp_nonce_url( self_admin_url( "update.php?action=install-plugin&plugin={$plugin_slug}" ), "install-plugin_{$plugin_slug}" ) ) . '" target="_self" class="button button-primary">' . esc_html__( 'Install now', 'woo-alidropship' ) . '</a>';
				$message = __( 'Need a variations swatches plugin that works perfectly with Dropshipping and Fulfillment for AliExpress and WooCommerce? <strong>Product Variations Swatches for WooCommerce</strong> is what you need.', 'woo-alidropship' );
				self::admin_notices_html( $button, $message );
			}
		} elseif ( ! is_plugin_active( $plugin ) ) {
			$button  = '<a href="' . esc_url( wp_nonce_url( add_query_arg( array(
					'action' => 'activate',
					'plugin' => $plugin
				), admin_url( 'plugins.php' ) ), "activate-plugin_{$plugin}" ) ) . '" target="_self" class="button button-primary">' . esc_html__( 'Activate now', 'woo-alidropship' ) . '</a>';
			$message = __( '<strong>Product Variations Swatches for WooCommerce</strong> is currently deactivated, this prevents variable products imported with Dropshipping and Fulfillment for AliExpress and WooCommerce from displaying beautifully.', 'woo-alidropship' );
			self::admin_notices_html( $button, $message );
		}
	}

	public function admin_enqueue_scripts() {
		global $pagenow;
		$page = isset( $_REQUEST['page'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['page'] ) ) : '';
		if ( $pagenow === 'admin.php' && $page === 'woo-ali-recommend' ) {
			wp_enqueue_style( 'vi-woo-alidropship-form', VI_WOO_ALIDROPSHIP_CSS . 'form.min.css' );
			wp_enqueue_style( 'vi-woo-alidropship-table', VI_WOO_ALIDROPSHIP_CSS . 'table.min.css' );
			wp_enqueue_style( 'vi-woo-alidropship-icon', VI_WOO_ALIDROPSHIP_CSS . 'icon.min.css' );
			wp_enqueue_style( 'vi-woo-alidropship-segment', VI_WOO_ALIDROPSHIP_CSS . 'segment.min.css' );
			wp_enqueue_style( 'vi-woo-alidropship-button', VI_WOO_ALIDROPSHIP_CSS . 'button.min.css' );
		} else {
			$wad_dismiss_nonce = isset( $_REQUEST['wad_dismiss_nonce'] ) ? wp_unslash( sanitize_text_field( $_REQUEST['wad_dismiss_nonce'] ) ) : '';
			if ( wp_verify_nonce( $wad_dismiss_nonce, 'wad_dismiss_nonce' ) ) {
				update_option( 'wad_install_recommended_plugins_dismiss', time() );
			} elseif ( ! get_option( 'wad_install_recommended_plugins_dismiss' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notices' ), 1 );
			}
		}
	}

	public function page_callback() {
		$plugins = array(
			array(
				'slug' => 'product-variations-swatches-for-woocommerce',
				'name' => 'Product Variations Swatches for WooCommerce',
				'desc' => __( 'Product Variations Swatches for WooCommerce is a professional plugin that allows you to show and select attributes for variation products. The plugin displays variation select options of the products under colors, buttons, images, variation images, radio so it helps the customers observe the products they need more visually, save time to find the wanted products than dropdown type for variations of a variable product.', 'woo-alidropship' )
			),
			array(
				'slug' => 'woo-abandoned-cart-recovery',
				'name' => 'Abandoned Cart Recovery for WooCommerce',
				'desc' => __( 'Helps you to recovery unfinished order in your store. When a customer adds a product to cart but does not complete check out. After a scheduled time, the cart will be marked as “abandoned”. The plugin will start to send cart recovery email or facebook message to the customer, remind him/her to complete the order.', 'woo-alidropship' )
			),
			array(
				'slug' => 'woo-photo-reviews',
				'name' => 'Photo Reviews for WooCommerce',
				'desc' => __( 'An ultimate review plugin for WooCommerce which helps you send review reminder emails, allows customers to post reviews include product pictures and send thank you emails with WooCommerce coupons to customers.', 'woo-alidropship' )
			),
			array(
				'slug' => 'woo-orders-tracking',
				'name' => 'Order Tracking for WooCommerce',
				'desc' => __( 'Allows you to bulk add tracking code to WooCommerce orders. Then the plugin will send tracking email with tracking URLs to customers. The plugin also helps you to add tracking code and carriers name to your PayPal transactions. This option will save you tons of time and avoid mistake when adding tracking code to PayPal.', 'woo-alidropship' )
			),
		);

		?>
        <style>
            .fist-col {
                min-width: 300px;
            }

            .vi-wad-plugin-name {
                font-weight: 600;
            }
        </style>
        <div class="">
            <h2><?php esc_html_e( 'Recommended plugins', 'woo-alidropship' ) ?></h2>
            <table cellspacing="0" id="status" class="vi-ui celled table">
                <thead>
                <tr>
                    <th><?php esc_html_e( 'Plugins', 'woo-alidropship' ); ?></th>
                    <th><?php esc_html_e( 'Description', 'woo-alidropship' ); ?></th>
                </tr>
                </thead>
                <tbody>
				<?php
				$installed_plugins = get_plugins();
				foreach ( $plugins as $plugin ) {
					$plugin_id = "{$plugin['slug']}/{$plugin['slug']}.php";
					?>
                    <tr>
                        <td class="fist-col">
                            <div class="vi-wad-plugin-name">
								<?php echo $plugin['name'] ?>
                            </div>
                            <div>
								<?php
								if ( ! isset( $installed_plugins[ $plugin_id ] ) ) {
									?>
                                    <a href="<?php echo esc_url( wp_nonce_url( self_admin_url( "update.php?action=install-plugin&plugin={$plugin['slug']}" ), "install-plugin_{$plugin['slug']}" ) ) ?>"
                                       target="_blank"><?php esc_html_e( 'Install', 'woo-alidropship' ); ?></a>
									<?php
								} elseif ( ! is_plugin_active( $plugin_id ) ) {
									?>
                                    <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array(
										'action' => 'activate',
										'plugin' => $plugin_id
									), admin_url( 'plugins.php' ) ), "activate-plugin_{$plugin_id}" ) ) ?>"
                                       target="_blank"><?php esc_html_e( 'Activate', 'woo-alidropship' ); ?></a>
									<?php
								} else {
									esc_html_e( 'This plugin is currently in used', 'woo-alidropship' );
								}
								?>
                            </div>
                        </td>
                        <td><?php echo $plugin['desc'] ?></td>
                    </tr>
					<?php
				}
				?>
                </tbody>
            </table>
        </div>
		<?php
	}

	/**
	 * Register a custom menu page.
	 */
	public function menu_page() {
		add_submenu_page(
			'woo-alidropship',
			esc_html__( 'Recommended plugins for Dropshipping and Fulfillment for AliExpress and WooCommerce', 'woo-alidropship' ),
			esc_html__( 'Recommended plugins', 'woo-alidropship' ),
			'manage_options',
			'woo-ali-recommend',
			array( $this, 'page_callback' )
		);

	}
}
