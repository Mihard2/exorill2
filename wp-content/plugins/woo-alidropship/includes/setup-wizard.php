<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Vi_Wad_Setup_Wizard' ) ) {
	class Vi_Wad_Setup_Wizard {
		protected $settings;
		protected $data;
		protected $current_url;
		protected $plugins;

		function __construct() {
			$this->settings = VI_WOO_ALIDROPSHIP_DATA::get_instance();
			$this->plugins_init();
			add_action( 'admin_head', array( $this, 'setup_wizard' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
			add_action( 'vi_wad_print_scripts', array( $this, 'print_script' ) );
		}

		protected function plugins_init() {
			return $this->plugins = array(
				array(
					'slug' => 'product-variations-swatches-for-woocommerce',
					'name' => 'Product Variations Swatches for WooCommerce',
					'desc' => __( 'Product Variations Swatches for WooCommerce is a professional plugin that allows you to show and select attributes for variation products. The plugin displays variation select options of the products under colors, buttons, images, variation images, radio so it helps the customers observe the products they need more visually, save time to find the wanted products than dropdown type for variations of a variable product.', 'woo-alidropship' ),
					'img'  => 'https://ps.w.org/product-variations-swatches-for-woocommerce/assets/icon-128x128.png'
				),
				array(
					'slug' => 'woo-abandoned-cart-recovery',
					'name' => 'Abandoned Cart Recovery for WooCommerce',
					'desc' => __( 'Helps you to recovery unfinished order in your store. When a customer adds a product to cart but does not complete check out. After a scheduled time, the cart will be marked as “abandoned”. The plugin will start to send cart recovery email or facebook message to the customer, remind him/her to complete the order.', 'woo-alidropship' ),
					'img'  => 'https://ps.w.org/woo-abandoned-cart-recovery/assets/icon-128x128.jpg'
				),
				array(
					'slug' => 'woo-photo-reviews',
					'name' => 'Photo Reviews for WooCommerce',
					'desc' => __( 'An ultimate review plugin for WooCommerce which helps you send review reminder emails, allows customers to post reviews include product pictures and send thank you emails with WooCommerce coupons to customers.', 'woo-alidropship' ),
					'img'  => 'https://ps.w.org/woo-photo-reviews/assets/icon-128x128.jpg'
				),
				array(
					'slug' => 'woo-orders-tracking',
					'name' => 'Order Tracking for WooCommerce',
					'desc' => __( 'Allows you to bulk add tracking code to WooCommerce orders. Then the plugin will send tracking email with tracking URLs to customers. The plugin also helps you to add tracking code and carriers name to your PayPal transactions. This option will save you tons of time and avoid mistake when adding tracking code to PayPal.', 'woo-alidropship' ),
					'img'  => 'https://ps.w.org/woo-orders-tracking/assets/icon-128x128.jpg'
				),
			);
		}

		public function scripts() {
			if ( isset( $_GET['vi_wad_setup_wizard'], $_GET['_wpnonce'] ) && $_GET['vi_wad_setup_wizard'] && wp_verify_nonce( $_GET['_wpnonce'], 'vi_wad_setup' ) ) {
				wp_enqueue_style( 'woo-alidropship-input', VI_WOO_ALIDROPSHIP_CSS . 'input.min.css' );
				wp_enqueue_style( 'woo-alidropship-label', VI_WOO_ALIDROPSHIP_CSS . 'label.min.css' );
				wp_enqueue_style( 'woo-alidropship-image', VI_WOO_ALIDROPSHIP_CSS . 'image.min.css' );
				wp_enqueue_style( 'woo-alidropship-transition', VI_WOO_ALIDROPSHIP_CSS . 'transition.min.css' );
				wp_enqueue_style( 'woo-alidropship-form', VI_WOO_ALIDROPSHIP_CSS . 'form.min.css' );
				wp_enqueue_style( 'woo-alidropship-icon', VI_WOO_ALIDROPSHIP_CSS . 'icon.min.css' );
				wp_enqueue_style( 'woo-alidropship-dropdown', VI_WOO_ALIDROPSHIP_CSS . 'dropdown.min.css' );
				wp_enqueue_style( 'woo-alidropship-checkbox', VI_WOO_ALIDROPSHIP_CSS . 'checkbox.min.css' );
				wp_enqueue_style( 'woo-alidropship-segment', VI_WOO_ALIDROPSHIP_CSS . 'segment.min.css' );
				wp_enqueue_style( 'woo-alidropship-button', VI_WOO_ALIDROPSHIP_CSS . 'button.min.css' );
				wp_enqueue_style( 'woo-alidropship-table', VI_WOO_ALIDROPSHIP_CSS . 'table.min.css' );
				wp_enqueue_style( 'select2', VI_WOO_ALIDROPSHIP_CSS . 'select2.min.css' );
				wp_enqueue_script( 'woo-alidropship-dropdown', VI_WOO_ALIDROPSHIP_JS . 'dropdown.js', array( 'jquery' ) );
				wp_enqueue_script( 'woo-alidropship-checkbox', VI_WOO_ALIDROPSHIP_JS . 'checkbox.js', array( 'jquery' ) );
				wp_enqueue_script( 'select2-v4', VI_WOO_ALIDROPSHIP_JS . 'select2.js', array( 'jquery' ), '4.0.3' );
				wp_enqueue_style( 'woo-alidropship-admin-style', VI_WOO_ALIDROPSHIP_CSS . 'admin.css' );
				if ( isset( $_GET['step'] ) && $_GET['step'] == 2 ) {
					wp_enqueue_script( 'woo-alidropship-admin', VI_WOO_ALIDROPSHIP_JS . 'setup-wizard.js', array( 'jquery' ) );
				}
			}
		}

		public function setup_wizard() {
			if ( isset( $_POST['submit'] ) && $_POST['submit'] == 'vi_wad_install_recommend_plugins' ) {
				$wc_install = new WC_Install();
				if ( is_array( $this->plugins ) && ! empty( $this->plugins ) ) {
					foreach ( $this->plugins as $plugin ) {
						$slug_name = $this->set_name( $plugin['slug'] );
						if ( ! empty( $_POST[ $slug_name ] ) ) {
							$wc_install::background_installer(
								$plugin['slug'],
								array(
									'name'      => $plugin['name'],
									'repo-slug' => $plugin['slug'],
								)
							);
						}
					}
				}
				wp_safe_redirect( admin_url( 'admin.php?page=woo-alidropship' ) );
				exit;
			}

			if ( isset( $_GET['vi_wad_setup_wizard'], $_GET['_wpnonce'] ) && $_GET['vi_wad_setup_wizard'] && wp_verify_nonce( $_GET['_wpnonce'], 'vi_wad_setup' ) ) {
				$step = isset( $_GET['step'] ) ? sanitize_text_field( $_GET['step'] ) : 1;
				$func = 'set_up_step_' . $step;

				if ( method_exists( $this, $func ) ) {
					$this->current_url = remove_query_arg( 'step', esc_url_raw( $_SERVER['REQUEST_URI'] ) );
					?>
                    <div id="vi-wad-setup-wizard">
                        <div class="vi-wad-logo">
                            <img src="<?php echo esc_url( VI_WOO_ALIDROPSHIP_IMAGES . 'icon-256x256.png' ) ?>"
                                 width="80"/>
                        </div>
                        <h1><?php esc_html_e( 'Dropshipping and Fulfillment for AliExpress and WooCommerce Setup Wizard' ); ?></h1>
                        <div class="vi-wad-wrapper vi-ui segment">
							<?php
							$this->$func();
							?>
                        </div>
                        <div class="vi-wad-skip-btn">
                            <a href="<?php echo esc_url( admin_url( 'admin.php?page=woo-alidropship' ) ) ?>"><?php esc_html_e( 'Skip', 'woo-alidropship' ); ?></a>
                        </div>
                    </div>
					<?php
					do_action( 'vi_wad_print_scripts' );
				}
				exit;
			}
		}

		public function set_up_step_1() {
			$key = $this->settings->get_params( 'secret_key' ) ? $this->settings->get_params( 'secret_key' ) : '';
			?>
            <h2><?php esc_html_e( 'Extension configuration', 'woo-alidropship' ); ?></h2>
            <div class="vi-wad-step-1">
                <table class="vi-ui table">
                    <tr>
                        <td><?php esc_html_e( 'Install Chrome Extension', 'woo-alidropship' ); ?></td>
                        <td>
                            <a href="https://chrome.google.com/webstore/detail/woocommerce-aliexpress-dr/egamhjcccjiflajhhinondgonlldjgba"
                               target="_blank">
								<?php esc_html_e( 'Dropshipping and Fulfillment for AliExpress and WooCommerce Extension', 'woo-alidropship' ); ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Copy domain to extension', 'woo-alidropship' ); ?></td>
                        <td><?php echo esc_url( site_url() ); ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Copy secret key to extension', 'woo-alidropship' ); ?></td>
                        <td><?php echo esc_html( $key ) ?></td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Example', 'woo-alidropship' ); ?></td>
                        <td>
                            <div class="vi-wad-settings-container vi-ui segment">
                                <div class="vi-wad-settings-title">
                                    <span>WooCommerce AliExpress Dropshipping Extension</span>
                                </div>
                                <table class="vi-wad-settings-container-main form-table">
                                    <tbody>
                                    <tr>
                                        <th>Domain</th>
                                        <td>
                                            <input type="text" class="vi-wad-params-domain"
                                                   readonly value="<?php echo esc_url( site_url() ) ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Secret key</th>
                                        <td>
                                            <input type="text" class="vi-wad-params-secret-key"
                                                   readonly value="<?php echo esc_html( $key ) ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Shipping method</th>
                                        <td>
                                            <select class="vi-wad-params-shipping-company"
                                                    disabled="disabled">
                                                <option value="EMS_ZX_ZX_US">ePacket</option>
                                            </select>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php esc_html_e( 'Video guide', 'woo-alidropship' ); ?></td>
                        <td>
                            <iframe width="100%" height="300" src="https://www.youtube.com/embed/AZxnEFfEGfo"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="vi-wad-btn-group">
                <a href="<?php echo esc_url( $this->current_url . '&step=2' ) ?>" class="vi-ui button primary">
					<?php esc_html_e( 'Next', 'woo-alidropship' ); ?>
                </a>
            </div>
			<?php
		}

		public function set_up_step_2() {
			?>
            <h2><?php esc_html_e( 'Plugin configuration', 'woo-alidropship' ); ?></h2>
            <form method="post" action="" class="vi-ui form setup-wizard">
                <div class="vi-wad-step-2">
					<?php wp_nonce_field( 'wooaliexpressdropship_save_settings', '_wooaliexpressdropship_nonce' ) ?>
                    <input type="hidden" name="vi_wad_setup_redirect"
                           value="<?php echo esc_url( $this->current_url . '&step=3' ) ?>">
                    <input type="hidden" name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'secret_key' ) ?>"
                           value="<?php echo $this->settings->get_params( 'secret_key' ) ?>">
                    <input type="hidden" name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'enable' ) ?>"
                           value="<?php echo $this->settings->get_params( 'enable' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_status' ) ?>"
                           value="<?php echo $this->settings->get_params( 'product_status' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'catalog_visibility' ) ?>"
                           value="<?php echo $this->settings->get_params( 'catalog_visibility' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_gallery' ) ?>"
                           value="<?php echo $this->settings->get_params( 'product_gallery' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_description' ) ?>"
                           value="<?php echo $this->settings->get_params( 'product_description' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'import_product_currency' ) ?>"
                           value="<?php echo $this->settings->get_params( 'import_product_currency' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'fulfill_default_carrier' ) ?>"
                           value="<?php echo $this->settings->get_params( 'fulfill_default_carrier' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'fulfill_order_note' ) ?>"
                           value="<?php echo $this->settings->get_params( 'fulfill_order_note' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'order_status_for_fulfill' ) ?>"
                           value="<?php echo $this->settings->get_params( 'order_status_for_fulfill' ) ?>">
                    <input type="hidden"
                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'order_status_after_sync' ) ?>"
                           value="<?php echo $this->settings->get_params( 'order_status_after_sync' ) ?>">
                    <input type="hidden" name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'manage_stock' ) ?>"
                           value="<?php echo $this->settings->get_params( 'manage_stock' ) ?>">

                    <table class="vi-ui table">
                        <tr>
                            <td>
                                <label for="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_categories', true ) ?>"><?php esc_html_e( 'Default categories', 'woocommerce-advanced-category-information' ); ?></label>
                            </td>
                            <td>

                                <select name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_categories', false, true ) ?>"
                                        class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_categories', true ) ?> search-category"
                                        id="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'product_categories', true ) ?>"
                                        multiple="multiple">
									<?php

									if ( is_array( $this->settings->get_params( 'product_categories' ) ) && count( $this->settings->get_params( 'product_categories' ) ) ) {
										$categories = $this->settings->get_params( 'product_categories' );
										foreach ( $categories as $category_id ) {
											$category = get_term( $category_id );
											if ( $category ) {
												?>
                                                <option value="<?php echo $category_id ?>"
                                                        selected><?php echo $category->name; ?></option>
												<?php
											}
										}
									}
									?>
                                </select>
                                <p><?php esc_html_e( 'Imported products will be added to these categories.', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td><?php esc_html_e( 'Import products currency exchange rate', 'woo-alidropship' ) ?></td>
                            <td>
                                <input type="text"
                                       id="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'import_currency_rate', true ) ?>"
                                       value="<?php echo $this->settings->get_params( 'import_currency_rate' ) ?>"
                                       name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'import_currency_rate' ) ?>"/>
                                <p><?php esc_html_e( 'This is exchange rate to convert from USD to your store currency.', 'woo-alidropship' ) ?></p>
                                <p><?php esc_html_e( 'E.g: Your Woocommerce store currency is VND, exchange rate is: 1 USD = 21 000 VND', 'woo-alidropship' ) ?></p>
                                <p><?php esc_html_e( '=> set "Import products currency exchange rate" 21 000', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table class="optiontable form-table price-rule">
                                    <tbody class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_rule_container', true ) ?>">
                                    <tr>
                                        <th><?php esc_html_e( 'Price From', 'woo-alidropship' ) ?></th>
                                        <th><?php esc_html_e( 'Actions', 'woo-alidropship' ) ?></th>
                                        <th><?php esc_html_e( 'Sale price', 'woo-alidropship' ) ?>
                                            <div class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'description', true ) ?>">
												<?php esc_html_e( '(Set -1 to not use sale price)', 'woo-alidropship' ) ?>
                                            </div>
                                        </th>
                                        <th><?php esc_html_e( 'Regular price', 'woo-alidropship' ) ?></th>
                                    </tr>
									<?php
									$price_from      = $this->settings->get_params( 'price_from' );
									$plus_value      = $this->settings->get_params( 'plus_value' );
									$plus_sale_value = $this->settings->get_params( 'plus_sale_value' );
									$plus_value_type = $this->settings->get_params( 'plus_value_type' );
									$currency        = get_woocommerce_currency();
									if ( is_array( $price_from ) && count( $price_from ) > 0 ) {
										for ( $i = 0; $i < count( $price_from ); $i ++ ) {
											switch ( $plus_value_type[ $i ] ) {
												case 'fixed':
													$value_label_left  = '+';
													$value_label_right = '$';
													break;
												case 'percent':
													$value_label_left  = '+';
													$value_label_right = '%';
													break;
												default:
													$value_label_left  = '=';
													$value_label_right = '$';
											}
											?>
                                            <tr class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_rule_row', true ) ?>">
                                                <td>
                                                    <div class="equal width fields">
                                                        <div class="field">
                                                            <div class="vi-ui right labeled input fluid">
                                                                <label for="amount" class="vi-ui label">$</label>
                                                                <input
                                                                        type="number"
                                                                        min="<?php echo isset( $price_from[ $i - 1 ] ) ? ( $price_from[ $i - 1 ] + 1 ) : 0 ?>"
                                                                        max="<?php echo $i > 0 ? ( isset( $price_from[ $i + 1 ] ) ? ( ( $price_from[ $i + 1 ] - 1 ) ) : '' ) : 0 ?>"
                                                                        value="<?php echo $i > 0 ? $price_from[ $i ] : 0; ?>"
                                                                        name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_from', false, true ); ?>"
                                                                        class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_from', true ); ?>">
                                                            </div>
                                                        </div>
                                                        <span class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_from_to_separator', true ); ?>">-</span>
                                                        <div class="field">
                                                            <div class="vi-ui right labeled input fluid">
                                                                <label for="amount" class="vi-ui label">$</label>
                                                                <input
                                                                        type="text" disabled
                                                                        value="<?php echo isset( $price_from[ $i + 1 ] ) ? ( $price_from[ $i + 1 ] ) : '' ?>"
                                                                        name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_to', false, true ); ?>"
                                                                        class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_to', true ); ?>">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </td>
                                                <td>
                                                    <select name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value_type', false, true ); ?>"
                                                            class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value_type', true ); ?>">
                                                        <option value="fixed" <?php selected( $plus_value_type[ $i ], 'fixed' ) ?>><?php esc_html_e( 'Increase by Fixed amount($)', 'woo-alidropship' ) ?></option>
                                                        <option value="percent" <?php selected( $plus_value_type[ $i ], 'percent' ) ?>><?php esc_html_e( 'Increase by Percentage(%)', 'woo-alidropship' ) ?></option>
                                                        <option value="set_to" <?php selected( $plus_value_type[ $i ], 'set_to' ) ?>><?php esc_html_e( 'Set to', 'woo-alidropship' ) ?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="vi-ui right labeled input fluid">
                                                        <label for="amount"
                                                               class="vi-ui label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-left', true ); ?>"><?php esc_html_e( $value_label_left ) ?></label>
                                                        <input type="number" min="-1" step="any"
                                                               value="<?php echo $plus_sale_value[ $i ]; ?>"
                                                               name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_sale_value', false, true ); ?>"
                                                               class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_sale_value', true ); ?>">
                                                        <div class="vi-ui basic label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-right', true ); ?>"><?php esc_html_e( $value_label_right ) ?></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="vi-ui right labeled input fluid">
                                                        <label for="amount"
                                                               class="vi-ui label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-left', true ); ?>"><?php esc_html_e( $value_label_left ) ?></label>
                                                        <input type="number" min="0" step="any"
                                                               value="<?php echo $plus_value[ $i ]; ?>"
                                                               name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value', false, true ); ?>"
                                                               class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value', true ); ?>">
                                                        <div class="vi-ui basic label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-right', true ); ?>"><?php esc_html_e( $value_label_right ) ?></div>
                                                    </div>
                                                </td>

                                            </tr>
											<?php
										}
									} else {
										?>
                                        <tr class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_rule_row', true ) ?>">
                                            <td>
                                                <div class="vi-ui right labeled input fluid">
                                                    <label for="amount" class="vi-ui label">$</label>
                                                    <input type="number"
                                                           min="0"
                                                           max="0"
                                                           value="0"
                                                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_from', false, true ); ?>"
                                                           class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_from', true ); ?>">
                                                </div>
                                            </td>
                                            <td>
                                                <select name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value_type', false, true ); ?>"
                                                        class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value_type', true ); ?>">
                                                    <option value="fixed"><?php esc_html_e( 'Increase by Fixed amount($)', 'woo-alidropship' ) ?></option>
                                                    <option value="percent"><?php esc_html_e( 'Increase by Percentage(%)', 'woo-alidropship' ) ?></option>
                                                    <option value="set_to"><?php esc_html_e( 'Set to', 'woo-alidropship' ) ?></option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="vi-ui right labeled input fluid">
                                                    <label for="amount"
                                                           class="vi-ui label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-left', true ); ?>">+</label>
                                                    <input type="number" min="-1" step="any"
                                                           value=""
                                                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_sale_value', false, true ); ?>"
                                                           class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_sale_value', true ); ?>">
                                                    <div class="vi-ui basic label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-right', true ); ?>">
                                                        $
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="vi-ui right labeled input fluid">
                                                    <label for="amount"
                                                           class="vi-ui label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-left', true ); ?>">+</label>
                                                    <input type="number" min="0" step="any"
                                                           value=""
                                                           name="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value', false, true ); ?>"
                                                           class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'plus_value', true ); ?>">
                                                    <div class="vi-ui basic label <?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'value-label-right', true ); ?>">
                                                        $
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
										<?php
									}
									?>
                                    </tbody>
                                </table>
                                <span class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_rule_add', true ) ?> vi-ui button positive"><?php esc_html_e( 'Add', 'woo-alidropship' ) ?></span>
                                <span class="<?php VI_WOO_ALIDROPSHIP_Admin_Settings::set_params( 'price_rule_remove', true ) ?> vi-ui button negative"><?php esc_html_e( 'Remove last level', 'woo-alidropship' ) ?></span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="vi-wad-btn-group">
                    <a href="<?php echo esc_url( $this->current_url . '&step=1' ) ?>" class="vi-ui button">
						<?php esc_html_e( 'Back', 'woo-alidropship' ); ?>
                    </a>
                    <button type="submit"
                            name="<?php esc_attr_e( VI_WOO_ALIDROPSHIP_DATA::set( 'save-settings', true ) ) ?>"
                            class="vi-ui button primary"
                            value="vi_wad_wizard_submit"><?php esc_html_e( 'Next', 'woo-alidropship' ); ?></button>
                </div>
            </form>
			<?php
		}

		public function set_up_step_3() {
			$plugins = $this->plugins;
			?>
            <form method="post" style="margin-bottom: 0">
                <div class="vi-wad-step-3">
                    <h2><?php esc_html_e( 'Plugins recommend', 'woo-alidropship' ) ?></h2>
                    <div class="">
                        <table cellspacing="0" id="status" class="vi-ui table">
                            <tbody>
							<?php
							foreach ( $plugins as $plugin ) {
								?>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" checked class="vi-wad-select-plugin"
                                               name="<?php echo $this->set_name( $plugin['slug'] ) ?>">
                                    </td>
                                    <td>
                                        <img src="<?php echo $plugin['img'] ?>" width="60" height="60">
                                    </td>
                                    <td>
                                        <div class="vi-wad-plugin-name">
                                            <span style="font-weight: 700"> <?php echo $plugin['name'] ?></span>
                                        </div>
                                        <div style="text-align: justify"><?php echo $plugin['desc'] ?></div>
                                    </td>
                                </tr>
								<?php
							}
							?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="vi-wad-btn-group">
                    <a href="<?php echo esc_url( $this->current_url . '&step=2' ) ?>" class="vi-ui button">
						<?php esc_html_e( 'Back', 'woo-alidropship' ); ?>
                    </a>
                    <button type="submit" class="vi-ui button primary vi-wad-finish" name="submit"
                            value="vi_wad_install_recommend_plugins">
						<?php esc_html_e( 'Install & Return to Dashboard', 'woo-alidropship' ); ?>
                    </button>
                </div>
            </form>
			<?php
		}


		public function set_name( $slug ) {
			return esc_attr( 'vi_install_' . str_replace( '-', '_', $slug ) );
		}


		public function print_script() {
			?>
            <script type="text/javascript">
                'use strict';
                jQuery(document).ready(function ($) {
                    $('.vi-wad-select-plugin').on('change', function () {
                        let checkedCount = $('.vi-wad-select-plugin:checked').length;
                        if (checkedCount === 0) {
                            $('.vi-wad-finish').text('<?php esc_html_e( 'Return to Dashboard', 'woo-alidropship' );?>');
                        } else {
                            $('.vi-wad-finish').text(<?php echo json_encode( __( 'Install & Return to Dashboard', 'woo-alidropship' ) )?>);
                        }
                    });

                    $('.vi-wad-finish').on('click', function () {
                        $(this).addClass('loading');
                    });
                });
            </script>
			<?php
		}
	}
}

new Vi_Wad_Setup_Wizard();