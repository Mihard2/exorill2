<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class VI_WOO_ALIDROPSHIP_Admin_Settings
 */
class VI_WOO_ALIDROPSHIP_Admin_Settings {
	private $settings;
	private $orders_tracking_active;
	public static $process;
	public static $process_image;
	public static $download_description;

	public function __construct() {
		$this->settings               = VI_WOO_ALIDROPSHIP_DATA::get_instance();
		$this->orders_tracking_active = false;
		add_action( 'init', array( $this, 'background_process' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'save_settings' ) );
		add_action( 'admin_init', array( $this, 'cancel_overriding' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'wp_ajax_wad_search_cate', array( $this, 'search_cate' ) );
		add_action( 'wp_ajax_wad_search_tags', array( $this, 'search_tags' ) );
		add_action( 'wp_ajax_vi_wad_import', array( $this, 'import' ) );
		add_action( 'wp_ajax_vi_wad_remove', array( $this, 'remove' ) );
		add_action( 'wp_ajax_vi_wad_trash_product', array( $this, 'trash' ) );
		add_action( 'wp_ajax_vi_wad_restore_product', array( $this, 'restore' ) );
		add_action( 'wp_ajax_vi_wad_delete_product', array( $this, 'delete' ) );
		add_action( 'wp_ajax_vi_wad_override', array( $this, 'override' ) );
		add_action( 'wp_ajax_vi_wad_override_product', array( $this, 'override_product' ) );
		add_action( 'wp_ajax_vi_wad_switch_product_attributes_values', array(
			$this,
			'switch_product_attributes_values'
		) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 999999 );
		add_action( 'admin_head', array( $this, 'menu_product_count' ), 999 );
		add_filter( 'set-screen-option', array( $this, 'save_screen_options' ), 10, 3 );
		add_action( 'edit_form_top', array( $this, 'link_to_imported_page' ) );
		/*Edit order*/
	}

	public function admin_notices() {
		$errors              = array();
		$permalink_structure = get_option( 'permalink_structure' );
		if ( ! $permalink_structure ) {
			$errors[] = __( 'You are using Permalink structure as Plain. Please go to <a href="' . admin_url( 'options-permalink.php' ) . '" target="_blank">Permalink Settings</a> to change it.', 'woo-alidropship' );
		}
		if ( ! is_ssl() ) {
			$errors[] = __( 'Your site is not using HTTPS. For more details, please read <a target="_blank" href="https://make.wordpress.org/support/user-manual/web-publishing/https-for-wordpress/">HTTPS for WordPress</a>', 'woo-alidropship' );
		}
		if ( count( $errors ) ) {
			?>
            <div class="error">
                <h3><?php echo _n( 'Dropshipping and Fulfillment for AliExpress and WooCommerce: you can not import products or fulfil AliExpress orders unless below issue is resolved', 'Dropshipping and Fulfillment for AliExpress and WooCommerce: you can not import products or fulfil AliExpress orders unless below issues are resolved', count( $errors ), 'woo-alidropship' ); ?></h3>
				<?php
				foreach ( $errors as $error ) {
					?>
                    <p><?php echo $error; ?></p>
					<?php
				}
				?>
            </div>
			<?php
		}
	}

	public function cancel_overriding() {
		$page = isset( $_REQUEST['page'] ) ? wp_unslash( $_REQUEST['page'] ) : '';
		if ( $page === 'woo-alidropship-imported-list' ) {
			$overridden_product = isset( $_REQUEST['overridden_product'] ) ? wp_unslash( $_REQUEST['overridden_product'] ) : '';
			$cancel_overriding  = isset( $_REQUEST['cancel_overriding'] ) ? wp_unslash( $_REQUEST['cancel_overriding'] ) : '';
			$_wpnonce           = isset( $_REQUEST['_wpnonce'] ) ? wp_unslash( $_REQUEST['_wpnonce'] ) : '';
			if ( $overridden_product && $cancel_overriding && wp_verify_nonce( $_wpnonce, 'cancel_overriding_nonce' ) ) {
				$product = get_post( $cancel_overriding );
				if ( $product && $product->post_status === 'override' && $product->post_parent == $overridden_product ) {
					wp_update_post( array(
						'ID'          => $cancel_overriding,
						'post_parent' => '',
						'post_status' => 'draft',
					) );
				}
				wp_safe_redirect( remove_query_arg( array( 'cancel_overriding', '_wpnonce', 'overridden_product' ) ) );
				exit();
			}
		}
	}

	public function switch_product_attributes_values() {
		$key        = isset( $_POST['product_index'] ) ? absint( sanitize_text_field( $_POST['product_index'] ) ) : '';
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		if ( $key > - 1 && $product_id ) {
			$currency                    = 'USD';
			$woocommerce_currency        = get_woocommerce_currency();
			$woocommerce_currency_symbol = get_woocommerce_currency_symbol();
			$manage_stock                = $this->get_params( 'manage_stock' );
			$use_different_currency      = false;
			$decimals                    = wc_get_price_decimals();
			$variations                  = get_post_meta( $product_id, '_vi_wad_variations', true );
			if ( is_array( $variations ) && count( $variations ) ) {
				foreach ( $variations as $variation_k => $variation ) {
					if ( isset( $variation['attributes_sub'] ) && is_array( $variation['attributes_sub'] ) && count( $variation['attributes_sub'] ) === count( $variation['attributes'] ) ) {
						$temp                                         = $variation['attributes'];
						$variations[ $variation_k ]['attributes']     = $variation['attributes_sub'];
						$variations[ $variation_k ]['attributes_sub'] = $temp;
					}
					if ( ! empty( $variation['sku'] ) ) {
						$temp                                  = $variation['sku'];
						$variations[ $variation_k ]['sku']     = $variation['sku_sub'];
						$variations[ $variation_k ]['sku_sub'] = $temp;
					}
				}
				update_post_meta( $product_id, '_vi_wad_variations', $variations );
			} else {
				wp_send_json(
					array(
						'status' => 'error',
						'data'   => esc_html__( 'Can not find replacement for product attributes values. Please remove this product and import it again with the latest version of this plugin and Chrome Extension', 'woo-alidropship' )
					)
				);
			}
			$attributes = get_post_meta( $product_id, '_vi_wad_attributes', true );
			if ( is_array( $attributes ) && count( $attributes ) ) {
				foreach ( $attributes as $attribute_k => $attribute ) {
					if ( ! empty( $attribute['values_sub'] ) ) {
						$temp                                     = $attribute['values'];
						$attributes[ $attribute_k ]['values']     = $attribute['values_sub'];
						$attributes[ $attribute_k ]['values_sub'] = $temp;
					}
				}
				update_post_meta( $product_id, '_vi_wad_attributes', $attributes );
			} else {
				wp_send_json(
					array(
						'status' => 'error',
						'data'   => esc_html__( 'Can not find replacement for product attributes values. Please remove this product and import it again with the latest version of this plugin and Chrome Extension', 'woo-alidropship' )
					)
				);
			}
			$list_attributes = get_post_meta( $product_id, '_vi_wad_list_attributes', true );
			if ( is_array( $list_attributes ) && count( $list_attributes ) ) {
				foreach ( $list_attributes as $list_attribute_k => $list_attribute ) {
					if ( ! empty( $list_attribute['name_sub'] ) ) {
						$temp                                             = $list_attribute['name'];
						$list_attributes[ $list_attribute_k ]['name']     = $list_attribute['name_sub'];
						$list_attributes[ $list_attribute_k ]['name_sub'] = $temp;
					}
				}
				update_post_meta( $product_id, '_vi_wad_list_attributes', $list_attributes );
			}
			$parent = array();
			if ( is_array( $attributes ) && count( $attributes ) ) {
				foreach ( $attributes as $attribute_k => $attribute_v ) {
					$parent[ $attribute_k ] = $attribute_v['slug'];
				}
			}
			if ( $decimals < 1 ) {
				$decimals = 1;
			} else {
				$decimals = pow( 10, ( - 1 * $decimals ) );
			}
			if ( strtolower( $woocommerce_currency ) != strtolower( $currency ) ) {
				$use_different_currency = true;
			}
			ob_start();
			$this->variation_html( $key, $parent, $attributes, $manage_stock, $variations, $use_different_currency, $currency, $product_id, $woocommerce_currency_symbol, $decimals, false );
			$return = ob_get_clean();
			wp_send_json(
				array(
					'status' => 'success',
					'data'   => $return
				)
			);
		} else {
			wp_send_json(
				array(
					'status' => 'error',
					'data'   => esc_html__( 'Can not find replacement for product attributes values. Please remove this product and import it again with the latest version of this plugin and Chrome Extension', 'woo-alidropship' )
				)
			);
		}
	}

	public function override_product() {
		vi_wad_set_time_limit();
		$override_product_url = isset( $_POST['override_product_url'] ) ? sanitize_text_field( stripslashes( $_POST['override_product_url'] ) ) : '';
		$step                 = isset( $_POST['step'] ) ? sanitize_text_field( stripslashes( $_POST['step'] ) ) : '';
		$response             = array(
			'status'  => 'error',
			'message' => '',
			'image'   => '',
			'title'   => '',
			'data'    => '',
		);
		$cookies              = get_option( 'vi_woo_alidropship_cookies_for_importing', array() );
		if ( $cookies ) {
			if ( ! is_array( $cookies ) ) {
				$cookies = array(
					'xman_f' => $cookies,
				);
			}
		} else {
			$cookies = array();
		}

		if ( $step == 'check' ) {
			$get_data = VI_WOO_ALIDROPSHIP_DATA::get_data( $override_product_url, array(
				'cookies' => $cookies
			) );
			if ( $get_data['status'] == 'success' ) {
				$data = $get_data['data'];
				if ( count( $data ) ) {
					$product_sku = $data['sku'];
					if ( $product_sku ) {
						$response['title'] = $data['name'];
						$response['data']  = json_encode( $data );
						$response['image'] = ( is_array( $data['gallery'] ) && count( $data['gallery'] ) ) ? $data['gallery'][0] : wc_placeholder_img_src();
						$exist_product_id  = VI_WOO_ALIDROPSHIP_DATA::product_get_id_by_aliexpresss_id( $product_sku, array(
							'publish',
							'override'
						) );
						if ( $exist_product_id ) {
							$response['status']  = 'exist';
							$response['message'] = esc_html__( 'This product has already been imported', 'woo-alidropship' );
						} else {
							$response['status'] = 'success';
						}
					} else {
						$response['message'] = esc_html__( 'Not found', 'woo-alidropship' );
					}
				} else {
					$response['message'] = esc_html__( 'Not found', 'woo-alidropship' );
				}
			} else {
				$response['message'] = esc_html__( 'Not found', 'woo-alidropship' );
			}
		} else {
			$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
			$post       = get_post( $product_id );
			if ( $post ) {
				$data = isset( $_POST['override_product_data'] ) ? sanitize_text_field( stripslashes( $_POST['override_product_data'] ) ) : '';
				if ( ! $data ) {
					$data = VI_WOO_ALIDROPSHIP_DATA::get_data( $override_product_url, array(
						'cookies' => $cookies
					) );
				} else {
					$data = vi_wad_json_decode( $data );
				}
				if ( count( $data ) ) {
					$sku              = isset( $data['sku'] ) ? sanitize_text_field( $data['sku'] ) : '';
					$exist_product_id = VI_WOO_ALIDROPSHIP_DATA::product_get_id_by_aliexpresss_id( $sku, array( 'draft', ) );
					if ( ! $exist_product_id ) {
						$title               = isset( $data['name'] ) ? sanitize_text_field( $data['name'] ) : '';
						$description_url     = isset( $data['description_url'] ) ? ( stripslashes( $data['description_url'] ) ) : '';
						$description         = isset( $data['short_description'] ) ? wp_kses_post( stripslashes( $data['short_description'] ) ) : '';
						$specsModule         = isset( $data['specsModule'] ) ? stripslashes_deep( $data['specsModule'] ) : array();
						$gallery             = isset( $data['gallery'] ) ? stripslashes_deep( $data['gallery'] ) : array();
						$variation_images    = isset( $data['variation_images'] ) ? stripslashes_deep( $data['variation_images'] ) : array();
						$variations          = isset( $data['variations'] ) ? stripslashes_deep( $data['variations'] ) : array();
						$attributes          = isset( $data['attributes'] ) ? stripslashes_deep( $data['attributes'] ) : array();
						$list_attributes     = isset( $data['list_attributes'] ) ? stripslashes_deep( $data['list_attributes'] ) : array();
						$store_info          = isset( $data['store_info'] ) ? stripslashes_deep( $data['store_info'] ) : array();
						$description_setting = $this->get_params( 'product_description' );
						if ( $description_setting == 'none' || $description_setting == 'description' ) {
							$description = '';
						} elseif ( count( $specsModule ) ) {
							ob_start();
							?>
                            <div class="">
                                <ul class="product-specs-list util-clearfix">
									<?php
									foreach ( $specsModule as $specs ) {
										?>
                                        <li class="product-prop line-limit-length"><span
                                                    class="property-title"><?php echo $specs['attrName'] ?>
                                                :&nbsp;</span><span
                                                    class="property-desc line-limit-length"><?php echo $specs['attrValue'] ?></span>
                                        </li>
										<?php
									}
									?>
                                </ul>
                            </div>
							<?php
							$description = ob_get_clean();
						}
						$str_replace = $this->settings->get_params( 'string_replace' );
						if ( isset( $str_replace['to_string'] ) && is_array( $str_replace['to_string'] ) && $str_replace_count = count( $str_replace['to_string'] ) ) {
							for ( $i = 0; $i < $str_replace_count; $i ++ ) {
								if ( $str_replace['sensitive'][ $i ] ) {
									$description = str_replace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $description );
									$title       = str_replace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $title );
								} else {
									$description = str_ireplace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $description );
									$title       = str_ireplace( $str_replace['from_string'][ $i ], $str_replace['to_string'][ $i ], $title );
								}
							}

						}
						$post_id = wp_insert_post( array(
							'post_title'   => $title,
							'post_type'    => 'vi_wad_draft_product',
							'post_status'  => 'override',
							'post_excerpt' => '',
							'post_content' => $description,
							'post_parent'  => $product_id,
						) );
						if ( is_wp_error( $post_id ) ) {
							$response['message'] = $post_id->get_error_message();
							wp_send_json( $response );
						} else {
							if ( $description_url ) {
								self::$download_description->push_to_queue( array(
									'product_id'          => $post_id,
									'description'         => $description,
									'description_url'     => $description_url,
									'product_description' => $description_setting,
								) )->save()->dispatch();
							}

							update_post_meta( $post_id, '_vi_wad_sku', $sku );
							update_post_meta( $post_id, '_vi_wad_attributes', $attributes );
							update_post_meta( $post_id, '_vi_wad_list_attributes', $list_attributes );

							$aff_url = $sku ? VI_WOO_ALIDROPSHIP_DATA::get_aff_url( $sku ) : '';
							$aff_url = is_array( $aff_url ) ? current( $aff_url ) : $aff_url;
							update_post_meta( $post_id, '_vi_wad_aff_url', $aff_url );

							$gallery = array_unique( array_filter( $gallery ) );
							if ( count( $gallery ) ) {
								update_post_meta( $post_id, '_vi_wad_gallery', $gallery );
							}
							update_post_meta( $post_id, '_vi_wad_variation_images', $variation_images );
							if ( is_array( $store_info ) && count( $store_info ) ) {
								update_post_meta( $post_id, '_vi_wad_store_info', $store_info );
							}
							if ( count( $variations ) ) {
								$variations_news = array();
								foreach ( $variations as $key => $variation ) {
									$variations_new                   = array();
									$variations_new['image']          = $variation['image'];
									$variations_new['sku']            = VI_WOO_ALIDROPSHIP_DATA::process_variation_sku( $sku, $variation['variation_ids'] );
									$variations_new['sku_sub']        = VI_WOO_ALIDROPSHIP_DATA::process_variation_sku( $sku, $variation['variation_ids_sub'] );
									$variations_new['skuId']          = $variation['skuId'];
									$variations_new['skuAttr']        = $variation['skuAttr'];
									$variations_new['regular_price']  = isset( $variation['skuVal']['skuCalPrice'] ) ? $variation['skuVal']['skuCalPrice'] : '';
									$variations_new['sale_price']     = isset( $variation['skuVal']['actSkuCalPrice'] ) ? $variation['skuVal']['actSkuCalPrice'] : '';
									$variations_new['stock']          = isset( $variation['skuVal']['availQuantity'] ) ? absint( $variation['skuVal']['availQuantity'] ) : 0;
									$variations_new['attributes']     = isset( $variation['variation_ids'] ) ? $variation['variation_ids'] : array();
									$variations_new['attributes_sub'] = isset( $variation['variation_ids_sub'] ) ? $variation['variation_ids_sub'] : array();
									$variations_news[]                = $variations_new;
								}
								update_post_meta( $post_id, '_vi_wad_variations', $variations_news );
							}
							$response['status'] = 'success';
							$response['data']   = '<span>' . sprintf( __( 'This product is being overridden by: %s. Please go to %s to complete the process.', 'woo-alidropship' ), '<strong>' . $title . '</strong>', '<a target="_blank" href="' . admin_url( 'admin.php?page=woo-alidropship-import-list&vi_wad_search=' . urlencode( $title ) ) . '">Import list</a>' ) . '</span>';
						}
					} else {
						wp_update_post( array(
								'ID'          => $exist_product_id,
								'post_status' => 'override',
								'post_parent' => $product_id,
							)
						);
						$title              = get_the_title( $exist_product_id );
						$response['status'] = 'success';
						$response['data']   = '<span>' . sprintf( __( 'This product is being overridden by: %s. Please go to %s to complete the process.', 'woo-alidropship' ), '<strong>' . $title . '</strong>', '<a target="_blank" href="' . admin_url( 'admin.php?page=woo-alidropship-import-list&vi_wad_search=' . urlencode( $title ) ) . '">Import list</a>' ) . '</span>';
					}
				}
			}
		}
		wp_send_json( $response );
	}

	public function get_params( $name = '' ) {
		return $this->settings->get_params( $name );
	}

	public function trash() {
		vi_wad_set_time_limit();
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		$response   = array(
			'status'  => 'success',
			'message' => '',
		);
		if ( $product_id ) {
			$reslut = wp_trash_post( $product_id );
			if ( ! $reslut ) {
				$response['status']  = 'error';
				$response['message'] = esc_html__( 'Can not trash product', 'woo-alidropship' );
			}
		}
		wp_send_json( $response );
	}

	public function restore() {
		vi_wad_set_time_limit();
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		$response   = array(
			'status'  => 'success',
			'message' => '',
		);
		if ( $product_id ) {
			$post = get_post( $product_id );
			wp_publish_post( $post );
		}
		wp_send_json( $response );
	}

	public function delete() {
		vi_wad_set_time_limit();
		$product_id         = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		$woo_product_id     = isset( $_POST['woo_product_id'] ) ? sanitize_text_field( $_POST['woo_product_id'] ) : '';
		$delete_woo_product = isset( $_POST['delete_woo_product'] ) ? sanitize_text_field( $_POST['delete_woo_product'] ) : '';

		$response = array(
			'status'  => 'success',
			'message' => '',
		);
		if ( $product_id ) {
			if ( get_post( $product_id ) ) {
				$delete = wp_delete_post( $product_id, true );
				if ( false === $delete ) {
					$response['status']  = 'error';
					$response['message'] = esc_html__( 'Can not delete product', 'woo-alidropship' );
				}
			}

			if ( $woo_product_id && 1 == $delete_woo_product && get_post( $woo_product_id ) ) {
				$delete = wp_delete_post( $woo_product_id, true );
				if ( false === $delete ) {
					$response['status']  = 'error';
					$response['message'] = esc_html__( 'Can not delete product', 'woo-alidropship' );
				}
			}
		}
		wp_send_json( $response );
	}

	/**
	 * @param $status
	 * @param $option
	 * @param $value
	 *
	 * @return mixed
	 */
	public function save_screen_options( $status, $option, $value ) {
		if ( in_array( $option, array( 'vi_wad_per_page', 'vi_wad_per_page_imported' ) ) ) {
			return $value;
		}

		return $status;
	}

	public function screen_options_page() {
		add_screen_option( 'per_page', array(
			'label'   => esc_html__( 'Number of items per page', 'wp-admin' ),
			'default' => 5,
			'option'  => 'vi_wad_per_page'
		) );
	}

	public function screen_options_page_imported() {
		add_screen_option( 'per_page', array(
			'label'   => esc_html__( 'Number of items per page', 'wp-admin' ),
			'default' => 5,
			'option'  => 'vi_wad_per_page_imported'
		) );
	}

	/**
	 * Adds the order processing count to the menu.
	 */
	public function menu_product_count() {
		global $submenu;
		if ( isset( $submenu['woo-alidropship'] ) ) {
			// Add count if user has access.
			if ( apply_filters( 'woo_aliexpress_dropship_product_count_in_menu', true ) && current_user_can( 'manage_options' ) ) {
				$count          = wp_count_posts( 'vi_wad_draft_product' );
				$product_count  = $count->draft + $count->override;
				$product_count1 = $count->publish;
				foreach ( $submenu['woo-alidropship'] as $key => $menu_item ) {
					if ( 0 === strpos( $menu_item[0], _x( 'Import List', 'Admin menu name', 'woo-alidropship' ) ) ) {
						$submenu['woo-alidropship'][ $key ][0] .= ' <span class="update-plugins count-' . esc_attr( $product_count ) . '"><span class="' . self::set( 'import-list-count' ) . '">' . number_format_i18n( $product_count ) . '</span></span>'; // WPCS: override ok.
						break;
					}
				}
				foreach ( $submenu['woo-alidropship'] as $key => $menu_item ) {
					if ( 0 === strpos( $menu_item[0], _x( 'Imported', 'Admin menu name', 'woo-alidropship' ) ) ) {
						$submenu['woo-alidropship'][ $key ][0] .= ' <span class="update-plugins count-' . esc_attr( $product_count1 ) . '"><span class="' . self::set( 'imported-list-count' ) . '">' . number_format_i18n( $product_count1 ) . '</span></span>'; // WPCS: override ok.
						break;
					}
				}
			}
		}
	}

	private static function set( $name, $set_name = false ) {
		return VI_WOO_ALIDROPSHIP_DATA::set( $name, $set_name );
	}

	public function background_process() {
		self::$process              = new Vi_WAD_Background_Import_Product();
		self::$process_image        = new Vi_WAD_Background_Download_Images();
		self::$download_description = new Vi_WAD_Background_Download_Description();
		if ( ! empty( $_REQUEST['vi_wad_cancel_import_product'] ) ) {
			self::$process->kill_process();
			wp_safe_redirect( @remove_query_arg( 'vi_wad_cancel_import_product' ) );
			exit;
		}
		if ( ! empty( $_REQUEST['vi_wad_cancel_download_product_image'] ) ) {
			self::$process_image->kill_process();
			wp_safe_redirect( @remove_query_arg( 'vi_wad_cancel_download_product_image' ) );
			exit;
		}
		if ( ! empty( $_REQUEST['vi_wad_cancel_download_product_description'] ) ) {
			self::$download_description->kill_process();
			wp_safe_redirect( @remove_query_arg( 'vi_wad_cancel_download_product_description' ) );
			exit;
		}
	}

	public function search_tags() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$keyword    = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		$categories = get_terms(
			array(
				'taxonomy'   => 'product_tag',
				'orderby'    => 'name',
				'order'      => 'ASC',
				'search'     => $keyword,
				'hide_empty' => false
			)
		);
		$items      = array();
		$items[]    = array( 'id' => $keyword, 'text' => $keyword );
		if ( count( $categories ) ) {
			foreach ( $categories as $category ) {
				$item    = array(
					'id'   => $category->name,
					'text' => $category->name
				);
				$items[] = $item;
			}
		}
		wp_send_json( $items );
	}

	public function search_cate() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$keyword    = filter_input( INPUT_GET, 'keyword', FILTER_SANITIZE_STRING );
		$categories = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'orderby'    => 'name',
				'order'      => 'ASC',
				'search'     => $keyword,
				'hide_empty' => false
			)
		);
		$items      = array();
		if ( count( $categories ) ) {
			foreach ( $categories as $category ) {
				$item    = array(
					'id'   => $category->term_id,
					'text' => $category->name
				);
				$items[] = $item;
			}
		}
		wp_send_json( $items );
	}

	public function admin_enqueue_scripts() {
		$page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
		global $pagenow;
		if ( $pagenow !== 'admin.php' ) {
			return;
		}
		if ( $page === 'woo-alidropship' ) {
			self::enqueue_semantic();
			wp_enqueue_style( 'woo-alidropship-admin-style', VI_WOO_ALIDROPSHIP_CSS . 'admin.css' );
			wp_enqueue_script( 'woo-alidropship-admin', VI_WOO_ALIDROPSHIP_JS . 'admin.js', array( 'jquery' ) );
		} elseif ( $page === 'woo-alidropship-import-list' ) {
			self::enqueue_semantic();
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_style( 'woo-alidropship-admin-style', VI_WOO_ALIDROPSHIP_CSS . 'import-list.css' );
			wp_enqueue_script( 'woo-alidropship-import-list', VI_WOO_ALIDROPSHIP_JS . 'import-list.js', array( 'jquery' ) );
			wp_localize_script( 'woo-alidropship-import-list', 'vi_wad_import_list_params', array(
				'url'                         => admin_url( 'admin-ajax.php' ),
				'decimals'                    => wc_get_price_decimals(),
				'i18n_empty_variation_error'  => esc_attr__( 'Please select at least 1 variation to import.', 'woo-alidropship' ),
				'i18n_empty_price_error'      => esc_attr__( 'Regular price can not be empty.', 'woo-alidropship' ),
				'i18n_sale_price_error'       => esc_attr__( 'Sale price must be smaller than regular price.', 'woo-alidropship' ),
				'i18n_not_found_error'        => esc_attr__( 'No product found.', 'woo-alidropship' ),
				'i18n_import_all_confirm'     => esc_attr__( 'Import all products on this page to your WooCommerce store?', 'woo-alidropship' ),
				'i18n_remove_product_confirm' => esc_attr__( 'Remove this product from import list?', 'woo-alidropship' ),
			) );
			add_action( 'admin_footer', array( $this, 'admin_footer' ) );
			add_action( 'admin_footer', array( $this, 'override_product_options' ) );
		} elseif ( $page === 'woo-alidropship-imported-list' ) {
			self::enqueue_semantic();
			wp_enqueue_style( 'woo-alidropship-admin-imported-style', VI_WOO_ALIDROPSHIP_CSS . 'imported-list.css' );
			wp_enqueue_script( 'woo-alidropship-imported-list', VI_WOO_ALIDROPSHIP_JS . 'imported-list.js', array( 'jquery' ) );
			wp_localize_script( 'woo-alidropship-imported-list', 'vi_wad_imported_list_params', array(
					'url'      => admin_url( 'admin-ajax.php' ),
					'check'    => esc_attr__( 'Check', 'woo-alidropship' ),
					'override' => esc_attr__( 'Override', 'woo-alidropship' ),
				)
			);
			add_action( 'admin_footer', array( $this, 'delete_product_options' ) );
		}
	}

	public static function enqueue_semantic() {
		/*Stylesheet*/
		wp_enqueue_style( 'woo-alidropship-message', VI_WOO_ALIDROPSHIP_CSS . 'message.min.css' );
		wp_enqueue_style( 'woo-alidropship-input', VI_WOO_ALIDROPSHIP_CSS . 'input.min.css' );
		wp_enqueue_style( 'woo-alidropship-label', VI_WOO_ALIDROPSHIP_CSS . 'label.min.css' );
		wp_enqueue_style( 'woo-alidropship-image', VI_WOO_ALIDROPSHIP_CSS . 'image.min.css' );
		wp_enqueue_style( 'woo-alidropship-transition', VI_WOO_ALIDROPSHIP_CSS . 'transition.min.css' );
		wp_enqueue_style( 'woo-alidropship-form', VI_WOO_ALIDROPSHIP_CSS . 'form.min.css' );
		wp_enqueue_style( 'woo-alidropship-icon', VI_WOO_ALIDROPSHIP_CSS . 'icon.min.css' );
		wp_enqueue_style( 'woo-alidropship-dropdown', VI_WOO_ALIDROPSHIP_CSS . 'dropdown.min.css' );
		wp_enqueue_style( 'woo-alidropship-checkbox', VI_WOO_ALIDROPSHIP_CSS . 'checkbox.min.css' );
		wp_enqueue_style( 'woo-alidropship-segment', VI_WOO_ALIDROPSHIP_CSS . 'segment.min.css' );
		wp_enqueue_style( 'woo-alidropship-menu', VI_WOO_ALIDROPSHIP_CSS . 'menu.min.css' );
		wp_enqueue_style( 'woo-alidropship-tab', VI_WOO_ALIDROPSHIP_CSS . 'tab.css' );
		wp_enqueue_style( 'woo-alidropship-table', VI_WOO_ALIDROPSHIP_CSS . 'table.min.css' );
		wp_enqueue_style( 'woo-alidropship-button', VI_WOO_ALIDROPSHIP_CSS . 'button.min.css' );
		wp_enqueue_style( 'woo-alidropship-grid', VI_WOO_ALIDROPSHIP_CSS . 'grid.min.css' );
		wp_enqueue_style( 'woo-alidropship-accordion', VI_WOO_ALIDROPSHIP_CSS . 'accordion.min.css' );
		wp_enqueue_script( 'woo-alidropship-transition', VI_WOO_ALIDROPSHIP_JS . 'transition.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'woo-alidropship-dropdown', VI_WOO_ALIDROPSHIP_JS . 'dropdown.js', array( 'jquery' ) );
		wp_enqueue_script( 'woo-alidropship-checkbox', VI_WOO_ALIDROPSHIP_JS . 'checkbox.js', array( 'jquery' ) );
		wp_enqueue_script( 'woo-alidropship-tab', VI_WOO_ALIDROPSHIP_JS . 'tab.js', array( 'jquery' ) );
		wp_enqueue_script( 'woo-alidropship-accordion', VI_WOO_ALIDROPSHIP_JS . 'accordion.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'woo-alidropship-address', VI_WOO_ALIDROPSHIP_JS . 'jquery.address-1.6.min.js', array( 'jquery' ) );
		wp_enqueue_style( 'select2', VI_WOO_ALIDROPSHIP_CSS . 'select2.min.css' );
		if ( woocommerce_version_check( '3.0.0' ) ) {
			wp_enqueue_script( 'select2' );
		} else {
			wp_enqueue_script( 'select2-v4', VI_WOO_ALIDROPSHIP_JS . 'select2.js', array( 'jquery' ), '4.0.3' );
		}
	}

	public function save_settings() {
		if ( is_plugin_active( 'woo-orders-tracking/woo-orders-tracking.php' ) || is_plugin_active( 'woocommerce-orders-tracking/woocommerce-orders-tracking.php' ) ) {
			$this->orders_tracking_active = true;
		}
		global $wooaliexpressdropship_settings;
		if ( isset( $_POST['vi_wad_save_settings'] ) && isset( $_POST['_wooaliexpressdropship_nonce'] ) && wp_verify_nonce( $_POST['_wooaliexpressdropship_nonce'], 'wooaliexpressdropship_save_settings' ) ) {
			if ( empty( $_POST['wad_secret_key'] ) ) {
				wp_die( 'Secret key cannot be empty.' );
			}
			$args = $this->settings->get_params();
			foreach ( $args as $key => $arg ) {
				if ( isset( $_POST[ 'wad_' . $key ] ) ) {
					if ( is_array( $_POST[ 'wad_' . $key ] ) ) {
						$args[ $key ] = isset( $_POST[ 'wad_' . $key ] ) ? ( stripslashes_deep( $_POST[ 'wad_' . $key ] ) ) : '';
					} else if ( in_array( $key, array( 'fulfill_order_note' ) ) ) {
						$args[ $key ] = stripslashes( wp_kses_post( $_POST[ 'wad_' . $key ] ) );
					} else {
						$args[ $key ] = sanitize_text_field( $_POST[ 'wad_' . $key ] );
					}
				} else {
					if ( is_array( $arg ) ) {
						$args[ $key ] = array();
					} else {
						$args[ $key ] = '';
					}
				}
			}

			if ( ! empty( $args['string_replace']['from_string'] ) && is_array( $args['string_replace']['from_string'] ) ) {
				$strings          = $args['string_replace']['from_string'];
				$strings_replaces = array(
					'from_string' => array(),
					'to_string'   => array(),
					'sensitive'   => array(),
				);
				$count            = count( $strings );
				for ( $i = 0; $i < $count; $i ++ ) {
					if ( $strings[ $i ] !== '' ) {
						$strings_replaces['from_string'][] = $args['string_replace']['from_string'][ $i ];
						$strings_replaces['to_string'][]   = $args['string_replace']['to_string'][ $i ];
						$strings_replaces['sensitive'][]   = $args['string_replace']['sensitive'][ $i ];
					}
				}
				$args['string_replace'] = $strings_replaces;
			}
			$args['carrier_name_replaces'] = isset( $_POST['vi-wad-carrier_name_replaces'] ) ? self::stripslashes_deep( $_POST['vi-wad-carrier_name_replaces'] ) : array(
				'from_string' => array(),
				'to_string'   => array(),
				'sensitive'   => array(),
			);

			if ( ! empty( $args['carrier_name_replaces']['from_string'] ) && is_array( $args['carrier_name_replaces']['from_string'] ) ) {
				$strings_replaces = array(
					'from_string' => array(),
					'to_string'   => array(),
					'sensitive'   => array(),
				);
				$count            = count( $args['carrier_name_replaces']['from_string'] );
				for ( $i = 0; $i < $count; $i ++ ) {
					if ( $args['carrier_name_replaces']['from_string'][ $i ] !== '' ) {
						$strings_replaces['from_string'][] = $args['carrier_name_replaces']['from_string'][ $i ];
						$strings_replaces['to_string'][]   = $args['carrier_name_replaces']['to_string'][ $i ];
						$strings_replaces['sensitive'][]   = $args['carrier_name_replaces']['sensitive'][ $i ];
					}
				}
				$args['carrier_name_replaces'] = $strings_replaces;
			}
			$args['carrier_url_replaces'] = isset( $_POST['vi-wad-carrier_url_replaces'] ) ? self::stripslashes_deep( $_POST['vi-wad-carrier_url_replaces'] ) : array(
				'from_string' => array(),
				'to_string'   => array(),
				'sensitive'   => array(),
			);
			if ( ! empty( $args['carrier_url_replaces']['from_string'] ) && is_array( $args['carrier_url_replaces']['from_string'] ) ) {
				$strings_replaces = array(
					'from_string' => array(),
					'to_string'   => array(),
				);
				$count            = count( $args['carrier_url_replaces']['from_string'] );
				for ( $i = 0; $i < $count; $i ++ ) {
					if ( $args['carrier_url_replaces']['from_string'][ $i ] !== '' && $args['carrier_url_replaces']['to_string'][ $i ] !== '' ) {
						$strings_replaces['from_string'][] = $args['carrier_url_replaces']['from_string'][ $i ];
						$strings_replaces['to_string'][]   = esc_url_raw( $args['carrier_url_replaces']['to_string'][ $i ] );
					}
				}
				$args['carrier_url_replaces'] = $strings_replaces;
			}
			update_option( 'wooaliexpressdropship_params', $args );
			$wooaliexpressdropship_settings = $args;
			$this->settings                 = VI_WOO_ALIDROPSHIP_DATA::get_instance( true );
			if ( isset( $_POST['vi_wad_setup_redirect'] ) ) {
				$url_redirect = esc_url_raw( $_POST['vi_wad_setup_redirect'] );
				wp_safe_redirect( $url_redirect );
				exit;
			}
		}
	}

	private static function stripslashes_deep( $value ) {
		if ( is_array( $value ) ) {
			$value = array_map( 'stripslashes_deep', $value );
		} else {
			$value = wp_kses_post( stripslashes( $value ) );
		}

		return $value;
	}

	/**
	 *
	 */
	public function page_callback() {
		$carriers = array(
			'EMS_ZX_ZX_US'     => 'ePacket',
			'CAINIAO_STANDARD' => 'AliExpress Standard Shipping',
			'CAINIAO_PREMIUM'  => 'AliExpress Premium Shipping',
			'EMS'              => 'EMS',
			'FEDEX_IE'         => 'Fedex IE',
			'DHL'              => 'DHL',
			'UPSE'             => 'UPS Expedited',
			'UPS'              => 'UPS Express Saver',
			'FEDEX'            => 'Fedex IP',
			'TNT'              => 'TNT',
			'E_EMS'            => 'e-EMS',
			'Other'            => 'Seller\'s Shipping Method',
		);
		?>
        <div class="wrap woo-alidropship">
            <h2><?php esc_attr_e( 'Dropshipping and Fulfillment for AliExpress and WooCommerce Settings', 'woo-alidropship' ) ?></h2>
			<?php
			if ( VI_WOO_ALIDROPSHIP_DATA::get_disable_wp_cron() ) {
				?>
                <div class="vi-ui message negative">
                    <span><?php _e( '<strong>DISABLE_WP_CRON</strong> is set to true, product images may not be downloaded properly. Please try option <strong>"Disable background process"</strong>', 'woo-alidropship' ) ?></span>
                </div>
				<?php
			}
			?>
            <form method="post" action="" class="vi-ui form">
				<?php $this->set_nonce() ?>

                <div class="vi-ui attached tabular menu">
                    <div class="item active" data-tab="general">
						<?php esc_html_e( 'General', 'woo-alidropship' ) ?>
                    </div>
                    <div class="item" data-tab="products">
						<?php esc_html_e( 'Products', 'woo-alidropship' ) ?>
                    </div>
                    <div class="item" data-tab="price">
						<?php esc_html_e( 'Product Price', 'woo-alidropship' ) ?>
                    </div>
                    <div class="item" data-tab="fulfill">
						<?php esc_html_e( 'Fulfill', 'woo-alidropship' ) ?>
                    </div>
					<?php
					if ( $this->orders_tracking_active ) {
						?>
                        <div class="item" data-tab="tracking_carrier">
							<?php esc_html_e( 'Tracking Carrier', 'woo-alidropship' ) ?>
                        </div>
						<?php
					}
					?>
                </div>
                <div class="vi-ui bottom attached tab segment active" data-tab="general">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'enable', true ) ?>">
									<?php esc_html_e( 'Enable', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'enable', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'enable' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'enable' ) ?>"/>
                                    <label></label>
                                </div>
                                <p><?php esc_html_e( 'You need to enable this to let WooCommerce AliExpress Dropshipping Extension connect to your store', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'secret_key', true ) ?>"><?php esc_html_e( 'Secret key', 'woo-alidropship' ) ?></label>
                            </th>
                            <td class="vi-wad relative">
                                <div class="vi-ui left labeled input fluid">
                                    <label class="vi-ui label">
                                        <div class="vi-wad-buttons-group">
                                            <span class="vi-wad-copy-secretkey"
                                                  title="<?php esc_attr_e( 'Copy Secret key', 'woo-alidropship' ) ?>">
                                                <i class="dashicons dashicons-admin-page"></i>
                                            </span>
                                            <span class="vi-wad-generate-secretkey"
                                                  title="<?php esc_attr_e( 'Generate new key', 'woo-alidropship' ) ?>">
                                                <i class="dashicons dashicons-image-rotate"></i>
                                            </span>
                                        </div>
                                    </label>
                                    <input type="text" name="<?php self::set_params( 'secret_key' ) ?>"
                                           value="<?php echo $this->get_params( 'secret_key' ) ?>"
                                           id="<?php self::set_params( 'secret_key', true ) ?>"
                                           class="<?php self::set_params( 'secret_key', true ) ?>">
                                </div>
                                <p><?php esc_html_e( 'Enter this key when using extension to connect the extension with your store. This cannot be empty.', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                            </th>
                            <td>
                                <p>
                                    <a href="https://downloads.villatheme.com/?download=alidropship-extension"
                                       target="_blank">
										<?php esc_html_e( 'Add WooCommerce AliExpress Dropshipping Extension', 'woo-alidropship' ); ?>
                                    </a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center">
                                <iframe width="560" height="315"
                                        src="https://www.youtube-nocookie.com/embed/AZxnEFfEGfo" frameborder="0"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="vi-ui bottom attached tab segment " data-tab="products">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'product_status', true ) ?>"><?php esc_html_e( 'Product status', 'woo-alidropship' ) ?></label>
                            </th>
                            <td>
                                <select name="<?php self::set_params( 'product_status' ) ?>"
                                        id="<?php self::set_params( 'product_status', true ) ?>"
                                        class="<?php self::set_params( 'product_status', true ) ?> vi-ui fluid dropdown">
                                    <option value="publish" <?php selected( $this->get_params( 'product_status' ), 'publish' ) ?>><?php esc_html_e( 'Publish', 'woo-alidropship' ) ?></option>
                                    <option value="pending" <?php selected( $this->get_params( 'product_status' ), 'pending' ) ?>><?php esc_html_e( 'Pending', 'woo-alidropship' ) ?></option>
                                    <option value="draft" <?php selected( $this->get_params( 'product_status' ), 'draft' ) ?>><?php esc_html_e( 'Draft', 'woo-alidropship' ) ?></option>
                                </select>
                                <p><?php esc_html_e( 'Imported products status will be set to this value.', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'simple_if_one_variation', true ) ?>">
									<?php esc_html_e( 'Import as simple product', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'simple_if_one_variation', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'simple_if_one_variation' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'simple_if_one_variation' ) ?>"/>
                                    <label><?php esc_html_e( 'If a product has only 1 variation or you select only 1 variation to import, that product will be imported as simple product. Variation sku and attributes will not be used.', 'woo-alidropship' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'catalog_visibility', true ) ?>"><?php esc_html_e( 'Catalog visibility', 'woo-alidropship' ) ?></label>
                            </th>
                            <td>
                                <select name="<?php self::set_params( 'catalog_visibility' ) ?>"
                                        id="<?php self::set_params( 'catalog_visibility', true ) ?>"
                                        class="<?php self::set_params( 'catalog_visibility', true ) ?> vi-ui fluid dropdown">
                                    <option value="visible" <?php selected( $this->get_params( 'catalog_visibility' ), 'visible' ) ?>><?php esc_html_e( 'Shop and search results', 'woo-alidropship' ) ?></option>
                                    <option value="catalog" <?php selected( $this->get_params( 'catalog_visibility' ), 'catalog' ) ?>><?php esc_html_e( 'Shop only', 'woo-alidropship' ) ?></option>
                                    <option value="search" <?php selected( $this->get_params( 'catalog_visibility' ), 'search' ) ?>><?php esc_html_e( 'Search results only', 'woo-alidropship' ) ?></option>
                                    <option value="hidden" <?php selected( $this->get_params( 'catalog_visibility' ), 'hidden' ) ?>><?php esc_html_e( 'Hidden', 'woo-alidropship' ) ?></option>
                                </select>
                                <p><?php esc_html_e( 'This setting determines which shop pages products will be listed on.', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'product_description', true ) ?>"><?php esc_html_e( 'Product description', 'woo-alidropship' ) ?></label>
                            </th>
                            <td>
                                <select name="<?php self::set_params( 'product_description' ) ?>"
                                        id="<?php self::set_params( 'product_description', true ) ?>"
                                        class="<?php self::set_params( 'product_description', true ) ?> vi-ui fluid dropdown">
                                    <option value="none" <?php selected( $this->get_params( 'product_description' ), 'none' ) ?>><?php esc_html_e( 'None', 'woo-alidropship' ) ?></option>
                                    <option value="item_specifics" <?php selected( $this->get_params( 'product_description' ), 'item_specifics' ) ?>><?php esc_html_e( 'Item specifics', 'woo-alidropship' ) ?></option>
                                    <option value="description" <?php selected( $this->get_params( 'product_description' ), 'description' ) ?>><?php esc_html_e( 'Product Description', 'woo-alidropship' ) ?></option>
                                    <option value="item_specifics_and_description" <?php selected( $this->get_params( 'product_description' ), 'item_specifics_and_description' ) ?>><?php esc_html_e( 'Item specifics & Product Description', 'woo-alidropship' ) ?></option>
                                </select>
                                <p><?php esc_html_e( 'Default product description when adding product to import list', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'product_gallery', true ) ?>">
									<?php esc_html_e( 'Default select product images', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'product_gallery', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'product_gallery' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'product_gallery' ) ?>"/>
                                    <label><?php esc_html_e( 'First image will be selected as product image and other images(except images from product description) are selected in gallery when adding product to import list', 'woo-alidropship' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'disable_background_process', true ) ?>">
									<?php esc_html_e( 'Disable background process', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'disable_background_process', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'disable_background_process' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'disable_background_process' ) ?>"/>
                                    <label><?php esc_html_e( 'When importing products, instead of letting their images download in the background, main product image will be downloaded directly, gallery and variation images(if any) will be added to Failed images page so that you can go there to download them manually.', 'woo-alidropship' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'product_categories', true ) ?>"><?php esc_html_e( 'Default categories', 'woocommerce-advanced-category-information' ); ?></label>
                            </th>
                            <td>
                                <select name="<?php self::set_params( 'product_categories', false, true ) ?>"
                                        class="<?php self::set_params( 'product_categories', true ) ?> search-category"
                                        id="<?php self::set_params( 'product_categories', true ) ?>"
                                        multiple="multiple">
									<?php
									$categories = $this->get_params( 'product_categories' );
									if ( is_array( $categories ) && count( $categories ) ) {
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
                            <th>
                                <label for="<?php self::set_params( 'product_tags', true ) ?>"><?php esc_html_e( 'Default product tags', 'woocommerce-advanced-category-information' ); ?></label>
                            </th>
                            <td>
                                <select name="<?php self::set_params( 'product_tags', false, true ) ?>"
                                        class="<?php self::set_params( 'product_tags', true ) ?> search-tags"
                                        id="<?php self::set_params( 'product_tags', true ) ?>"
                                        multiple="multiple">
									<?php
									$product_tags = $this->get_params( 'product_tags' );
									if ( is_array( $product_tags ) && count( $product_tags ) ) {
										foreach ( $product_tags as $product_tag_id ) {
											?>
                                            <option value="<?php echo $product_tag_id ?>"
                                                    selected><?php echo $product_tag_id; ?></option>
											<?php
										}
									}
									?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'variation_visible', true ) ?>">
									<?php esc_html_e( 'Product variations is visible on product page', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'variation_visible', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'variation_visible' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'variation_visible' ) ?>"/>
                                    <label><?php esc_html_e( 'Enable to make variations of imported products visible on product page', 'woo-alidropship' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'manage_stock', true ) ?>">
									<?php esc_html_e( 'Manage stock', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'manage_stock', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'manage_stock' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'manage_stock' ) ?>"/>
                                    <label><?php esc_html_e( 'Enable manage stock and import product inventory.', 'woo-alidropship' ) ?></label>
                                </div>
                                <p class="description"><?php esc_html_e( 'If this option is disabled, products stock status will be set "Instock" and product inventory will not be imported', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'ignore_ship_from', true ) ?>">
									<?php esc_html_e( 'Ignore import ship from', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                                <div class="vi-ui toggle checkbox">
                                    <input id="<?php self::set_params( 'ignore_ship_from', true ) ?>"
                                           type="checkbox" <?php checked( $this->get_params( 'ignore_ship_from' ), 1 ) ?>
                                           tabindex="0" class="hidden" value="1"
                                           name="<?php self::set_params( 'ignore_ship_from' ) ?>"/>
                                    <label><?php esc_html_e( 'Enable to only import product variations with ship from China', 'woo-alidropship' ) ?></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="vi-ui segment string-replace">
                                    <div class="vi-ui blue small message">
                                        <div class="header">
											<?php esc_html_e( 'Find and Replace', 'woo-alidropship' ); ?>
                                        </div>
                                        <ul class="list">
                                            <li><?php esc_html_e( 'Search for strings in product title and description and replace found strings with respective values.', 'woo-alidropship' ); ?></li>
                                        </ul>
                                    </div>
                                    <table class="vi-ui table">
                                        <thead>
                                        <tr>
                                            <th><?php esc_html_e( 'Search', 'woo-alidropship' ); ?></th>
                                            <th><?php esc_html_e( 'Case Sensitive', 'woo-alidropship' ); ?></th>
                                            <th><?php esc_html_e( 'Replace with', 'woo-alidropship' ); ?></th>
                                            <th><?php esc_html_e( 'Remove', 'woo-alidropship' ); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
										<?php
										$string_replace       = $this->get_params( 'string_replace' );
										$string_replace_count = 1;
										if ( ! empty( $string_replace['from_string'] ) && ! empty( $string_replace['to_string'] ) && is_array( $string_replace['from_string'] ) ) {
											$string_replace_count = count( $string_replace['from_string'] );
										}
										for ( $i = 0; $i < $string_replace_count; $i ++ ) {
											$checked = $case_sensitive = '';
											if ( ! empty( $string_replace['sensitive'][ $i ] ) ) {
												$checked        = 'checked';
												$case_sensitive = 1;
											}
											?>
                                            <tr class="clone-source">
                                                <td>
                                                    <input type="text"
                                                           value="<?php echo esc_attr( isset( $string_replace['from_string'][ $i ] ) ? $string_replace['from_string'][ $i ] : '' ) ?>"
                                                           name="<?php self::set_params( 'string_replace[from_string][]' ) ?>">
                                                </td>
                                                <td>
                                                    <div class="<?php self::set_params( 'string-replace-sensitive-container', true ) ?>">
                                                        <input type="checkbox"
                                                               value="1" <?php echo $checked ?>
                                                               class="<?php self::set_params( 'string-replace-sensitive', true ) ?>">
                                                        <input type="hidden"
                                                               class="<?php self::set_params( 'string-replace-sensitive-value', true ) ?>"
                                                               value="<?php echo esc_attr( $case_sensitive ) ?>"
                                                               name="<?php self::set_params( 'string_replace[sensitive][]' ) ?>">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           placeholder="<?php esc_html_e( 'Leave blank to delete matches', 'woo-alidropship' ); ?>"
                                                           value="<?php echo esc_attr( isset( $string_replace['to_string'][ $i ] ) ? $string_replace['to_string'][ $i ] : '' ) ?>"
                                                           name="<?php self::set_params( 'string_replace[to_string][]' ) ?>">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                            class="vi-ui button negative delete-string-replace-rule">
                                                        <i class="dashicons dashicons-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
											<?php
										}
										?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th colspan="4">
                                                <button type="button"
                                                        class="vi-ui button positive add-string-replace-rule">
													<?php esc_html_e( 'Add', 'woo-alidropship' ); ?>
                                                </button>
                                            </th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="price">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <td colspan="2">
                                <div class="vi-ui yellow small message">
                                    <div class="header">
										<?php esc_html_e( 'Important', 'woo-alidropship' ); ?>
                                    </div>
                                    <ul class="list">
                                        <li><?php esc_html_e( 'Products are imported in USD, the price of imported products will be converted after applying the price rule below', 'woo-alidropship' ); ?></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Exchange rate', 'woo-alidropship' ) ?></th>
                            <td>
                                <input type="text" <?php checked( $this->get_params( 'import_currency_rate' ), 1 ) ?>
                                       id="<?php self::set_params( 'import_currency_rate', true ) ?>"
                                       value="<?php echo $this->get_params( 'import_currency_rate' ) ?>"
                                       name="<?php self::set_params( 'import_currency_rate' ) ?>"/>
                                <p><?php esc_html_e( 'This is exchange rate to convert product price from USD to your store currency when adding products to import list.', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <p><?php esc_html_e( 'E.g: Your Woocommerce store currency is VND, exchange rate is: 1 USD = 23 000 VND', 'woo-alidropship' ) ?></p>
                                <p><?php esc_html_e( '=> set "Exchange rate" 23 000', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="hidden" class="<?php self::set_params( 'woocommerce_decimal', true ) ?>"
                           value="<?php echo wc_get_price_decimals() ?>">
                    <table class="form-table price-rule">
                        <tbody class="<?php self::set_params( 'price_rule_container', true ) ?>">
                        <tr>
                            <th><?php esc_html_e( 'Price From', 'woo-alidropship' ) ?></th>
                            <th><?php esc_html_e( 'Actions', 'woo-alidropship' ) ?></th>
                            <th><?php esc_html_e( 'Sale price', 'woo-alidropship' ) ?>
                                <div class="<?php self::set_params( 'description', true ) ?>">
									<?php esc_html_e( '(Set -1 to not use sale price)', 'woo-alidropship' ) ?>
                                </div>
                            </th>
                            <th><?php esc_html_e( 'Regular price', 'woo-alidropship' ) ?></th>
                        </tr>
						<?php
						$price_from      = $this->get_params( 'price_from' );
						$plus_value      = $this->get_params( 'plus_value' );
						$plus_sale_value = $this->get_params( 'plus_sale_value' );
						$plus_value_type = $this->get_params( 'plus_value_type' );
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
                                <tr class="<?php self::set_params( 'price_rule_row', true ) ?>">
                                    <td>
                                        <div class="equal width fields">
                                            <div class="field">
                                                <div class="vi-ui left labeled input fluid">
                                                    <label for="amount" class="vi-ui label">$</label>
                                                    <input
                                                            type="number"
                                                            min="<?php echo isset( $price_from[ $i - 1 ] ) ? ( $price_from[ $i - 1 ] + 1 ) : 0 ?>"
                                                            max="<?php echo $i > 0 ? ( isset( $price_from[ $i + 1 ] ) ? ( ( $price_from[ $i + 1 ] - 1 ) ) : '' ) : 0 ?>"
                                                            value="<?php echo $i > 0 ? $price_from[ $i ] : 0; ?>"
                                                            name="<?php self::set_params( 'price_from', false, true ); ?>"
                                                            class="<?php self::set_params( 'price_from', true ); ?>">
                                                </div>
                                            </div>
                                            <span class="<?php self::set_params( 'price_from_to_separator', true ); ?>">-</span>
                                            <div class="field">
                                                <div class="vi-ui left labeled input fluid">
                                                    <label for="amount" class="vi-ui label">$</label>
                                                    <input
                                                            type="text" disabled
                                                            value="<?php echo isset( $price_from[ $i + 1 ] ) ? ( $price_from[ $i + 1 ] ) : '' ?>"
                                                            name="<?php self::set_params( 'price_to', false, true ); ?>"
                                                            class="<?php self::set_params( 'price_to', true ); ?>">
                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <select name="<?php self::set_params( 'plus_value_type', false, true ); ?>"
                                                class="<?php self::set_params( 'plus_value_type', true ); ?>">
                                            <option value="fixed" <?php selected( $plus_value_type[ $i ], 'fixed' ) ?>><?php esc_html_e( 'Increase by Fixed amount($)', 'woo-alidropship' ) ?></option>
                                            <option value="percent" <?php selected( $plus_value_type[ $i ], 'percent' ) ?>><?php esc_html_e( 'Increase by Percentage(%)', 'woo-alidropship' ) ?></option>
                                            <option value="set_to" <?php selected( $plus_value_type[ $i ], 'set_to' ) ?>><?php esc_html_e( 'Set to', 'woo-alidropship' ) ?></option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="vi-ui right labeled input fluid">
                                            <label for="amount"
                                                   class="vi-ui label <?php self::set_params( 'value-label-left', true ); ?>"><?php echo esc_html( $value_label_left ) ?></label>
                                            <input type="number" min="-1" step="any"
                                                   value="<?php echo $plus_sale_value[ $i ]; ?>"
                                                   name="<?php self::set_params( 'plus_sale_value', false, true ); ?>"
                                                   class="<?php self::set_params( 'plus_sale_value', true ); ?>">
                                            <div class="vi-ui basic label <?php self::set_params( 'value-label-right', true ); ?>"><?php echo esc_html( $value_label_right ) ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="vi-ui right labeled input fluid">
                                            <label for="amount"
                                                   class="vi-ui label <?php self::set_params( 'value-label-left', true ); ?>"><?php echo esc_html( $value_label_left ) ?></label>
                                            <input type="number" min="0" step="any"
                                                   value="<?php echo $plus_value[ $i ]; ?>"
                                                   name="<?php self::set_params( 'plus_value', false, true ); ?>"
                                                   class="<?php self::set_params( 'plus_value', true ); ?>">
                                            <div class="vi-ui basic label <?php self::set_params( 'value-label-right', true ); ?>"><?php echo esc_html( $value_label_right ) ?></div>
                                        </div>
                                    </td>

                                </tr>
								<?php
							}
						} else {
							?>
                            <tr class="<?php self::set_params( 'price_rule_row', true ) ?>">
                                <td>
                                    <div class="vi-ui left labeled input fluid">
                                        <label for="amount" class="vi-ui label">$</label>
                                        <input type="number"
                                               min="0"
                                               max="0"
                                               value="0"
                                               name="<?php self::set_params( 'price_from', false, true ); ?>"
                                               class="<?php self::set_params( 'price_from', true ); ?>">
                                    </div>
                                </td>
                                <td>
                                    <select name="<?php self::set_params( 'plus_value_type', false, true ); ?>"
                                            class="<?php self::set_params( 'plus_value_type', true ); ?>">
                                        <option value="fixed"><?php esc_html_e( 'Increase by Fixed amount($)', 'woo-alidropship' ) ?></option>
                                        <option value="percent"><?php esc_html_e( 'Increase by Percentage(%)', 'woo-alidropship' ) ?></option>
                                        <option value="set_to"><?php esc_html_e( 'Set to', 'woo-alidropship' ) ?></option>
                                    </select>
                                </td>
                                <td>
                                    <div class="vi-ui left labeled input fluid">
                                        <label for="amount"
                                               class="vi-ui label <?php self::set_params( 'value-label-left', true ); ?>">+</label>
                                        <input type="number" min="-1" step="any"
                                               value=""
                                               name="<?php self::set_params( 'plus_sale_value', false, true ); ?>"
                                               class="<?php self::set_params( 'plus_sale_value', true ); ?>">
                                        <div class="vi-ui basic label <?php self::set_params( 'value-label-right', true ); ?>">
                                            $
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="vi-ui right labeled input fluid">
                                        <label for="amount"
                                               class="vi-ui label <?php self::set_params( 'value-label-left', true ); ?>">+</label>
                                        <input type="number" min="0" step="any"
                                               value=""
                                               name="<?php self::set_params( 'plus_value', false, true ); ?>"
                                               class="<?php self::set_params( 'plus_value', true ); ?>">
                                        <div class="vi-ui basic label <?php self::set_params( 'value-label-right', true ); ?>">
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
                    <span class="<?php self::set_params( 'price_rule_add', true ) ?> vi-ui button positive"><?php esc_html_e( 'Add', 'woo-alidropship' ) ?></span>
                    <span class="<?php self::set_params( 'price_rule_remove', true ) ?> vi-ui button negative"><?php esc_html_e( 'Remove last level', 'woo-alidropship' ) ?></span>
                </div>
                <div class="vi-ui bottom attached tab segment" data-tab="fulfill">
                    <table class="form-table">
                        <tbody>

                        <tr>
                            <th><?php esc_html_e( 'Carrier company', 'woo-alidropship' ) ?></th>
                            <td>
                                <select class="vi-ui fluid dropdown"
                                        name="<?php self::set_params( 'fulfill_default_carrier' ) ?>">
									<?php
									$saved = $this->get_params( 'fulfill_default_carrier' );
									foreach ( $carriers as $key => $value ) {
										echo "<option value='$key' " . selected( $saved, $key ) . ">$value</option>";
									}
									?>
                                </select>
                                <p><?php esc_html_e( 'Default carrier company', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="<?php self::set_params( 'fulfill_order_note', true ) ?>">
									<?php esc_html_e( 'AliExpress Order note', 'woo-alidropship' ) ?>
                                </label>
                            </th>
                            <td>
                               <textarea type="text" id="<?php self::set_params( 'fulfill_order_note', true ) ?>"
                                         name="<?php self::set_params( 'fulfill_order_note' ) ?>"><?php echo wp_kses_post( $this->get_params( 'fulfill_order_note' ) ) ?></textarea>
                                <p><?php esc_html_e( 'Add this note to AliExpress order when fulfilling with Chrome extension', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Show action', 'woo-alidropship' ) ?></th>
                            <td>
                                <select class="vi-wad-order-status-for-fulfill vi-ui fluid dropdown" multiple="multiple"
                                        name="<?php self::set_params( 'order_status_for_fulfill', false, true ) ?>">
									<?php
									$saved = $this->get_params( 'order_status_for_fulfill' );
									foreach ( wc_get_order_statuses() as $key => $value ) {
										$selected = '';
										if ( is_array( $saved ) ) {
											$selected = in_array( $key, $saved ) ? 'selected' : '';
										}
										echo "<option value='$key' {$selected}>$value</option>";
									}
									?>
                                </select>
                                <p><?php esc_html_e( 'Only show action buttons for orders with status among these', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><?php esc_html_e( 'Change order status', 'woo-alidropship' ) ?></th>
                            <td>
								<?php
								$saved = $this->get_params( 'order_status_after_sync' );
								?>
                                <select class="vi-wad-order-status-after-sync vi-ui fluid dropdown"
                                        name="<?php self::set_params( 'order_status_after_sync', false, false ) ?>">
                                    <option><?php esc_html_e( 'No change', 'woo-alidropship' ); ?></option>
									<?php
									foreach ( wc_get_order_statuses() as $key => $value ) {
										$selected = $key == $saved ? 'selected' : '';
										echo "<option value='$key' {$selected}>$value</option>";
									}
									?>
                                </select>
                                <p><?php esc_html_e( 'Automatically change order status after order id & tracking number of an order are synced successfully', 'woo-alidropship' ) ?></p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
				<?php
				if ( $this->orders_tracking_active ) {
					?>
                    <div class="vi-ui bottom attached tab segment" data-tab="tracking_carrier">
                        <div class="vi-ui positive tiny message">
                            <div class="header">
								<?php esc_html_e( 'Search and Replace', 'woo-alidropship' ); ?>
                            </div>
                            <ul class="list">
                                <li><?php _e( 'This feature is used for <strong>Orders Tracking for WooCommerce</strong> plugin when syncing tracking info.', 'woo-alidropship' ); ?></li>
                                <li><?php _e( 'When syncing orders with AliExpress, if Orders Tracking for WooCommerce plugin is active, it will automatically search for carrier URL in the existing carriers of this plugin (The <strong>Search and Replace</strong> function runs right before this step). If found, it will save tracking info with that carrier; otherwise, a new <strong>Custom carrier</strong> will be created.', 'woo-alidropship' ); ?></li>
                                <li><?php _e( 'Skip if carrier is <strong>AliExpress Standard Shipping</strong>', 'woo-alidropship' ); ?></li>
                            </ul>
                        </div>
                        <div class="vi-ui segment string-replace-url">
                            <div class="vi-ui blue tiny message">
                                <div class="header">
									<?php esc_html_e( 'Replace carrier URL', 'woo-alidropship' ); ?>
                                </div>
                                <ul class="list">
                                    <li><?php esc_html_e( 'Replace carrier URL with respective URL below if DOMAIN of original carrier URL contains search strings(case-insensitive).', 'woo-alidropship' ); ?></li>
                                    <li><?php esc_html_e( 'Search will take place with priority from top to bottom and will STOP after first match.', 'woo-alidropship' ); ?></li>
                                </ul>
                            </div>
                            <table class="vi-ui table">
                                <thead>
                                <tr>
                                    <th><?php esc_html_e( 'Search', 'woo-alidropship' ); ?></th>
                                    <th><?php esc_html_e( 'Replace carrier URL with', 'woo-alidropship' ); ?></th>
                                    <th style="width: 1%"><?php esc_html_e( 'Remove', 'woo-alidropship' ); ?></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								$carrier_url_replaces       = $this->settings->get_params( 'carrier_url_replaces' );
								$carrier_url_replaces_count = 1;
								if ( ! empty( $carrier_url_replaces['from_string'] ) && ! empty( $carrier_url_replaces['to_string'] ) && is_array( $carrier_url_replaces['from_string'] ) ) {
									$carrier_url_replaces_count = count( $carrier_url_replaces['from_string'] );
								}
								for ( $i = 0; $i < $carrier_url_replaces_count; $i ++ ) {
									?>
                                    <tr class="clone-source">
                                        <td>
                                            <input type="text"
                                                   value="<?php echo esc_attr( isset( $carrier_url_replaces['from_string'][ $i ] ) ? $carrier_url_replaces['from_string'][ $i ] : '' ) ?>"
                                                   name="<?php echo esc_attr( self::set( 'carrier_url_replaces[from_string][]' ) ) ?>">
                                        </td>
                                        <td>
                                            <input type="text"
                                                   placeholder="<?php esc_html_e( 'URL of a replacement carrier', 'woo-alidropship' ); ?>"
                                                   value="<?php echo esc_attr( isset( $carrier_url_replaces['to_string'][ $i ] ) ? $carrier_url_replaces['to_string'][ $i ] : '' ) ?>"
                                                   name="<?php echo esc_attr( self::set( 'carrier_url_replaces[to_string][]' ) ) ?>">
                                        </td>
                                        <td>
                                            <button type="button"
                                                    class="vi-ui button negative delete-string-replace-rule">
                                                <i class="dashicons dashicons-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
									<?php
								}
								?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4">
                                        <button type="button"
                                                class="vi-ui button positive add-string-replace-rule-url">
											<?php esc_html_e( 'Add', 'woo-alidropship' ); ?>
                                        </button>
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="vi-ui segment string-replace-name">
                            <div class="vi-ui blue tiny message">
                                <div class="header">
									<?php esc_html_e( 'Search and replace strings in Carrier name', 'woo-alidropship' ); ?>
                                </div>
                                <ul class="list">
                                    <li><?php esc_html_e( 'Search for strings in Carrier name and replace found strings with respective values.', 'woo-alidropship' ); ?></li>
                                    <li><?php _e( 'This only works when new <strong>Custom carrier</strong> is created', 'woo-alidropship' ); ?></li>
                                </ul>
                            </div>
                            <table class="vi-ui table">
                                <thead>
                                <tr>
                                    <th><?php esc_html_e( 'Search', 'woo-alidropship' ); ?></th>
                                    <th><?php esc_html_e( 'Case Sensitive', 'woo-alidropship' ); ?></th>
                                    <th><?php esc_html_e( 'Replace', 'woo-alidropship' ); ?></th>
                                    <th style="width: 1%"><?php esc_html_e( 'Remove', 'woo-alidropship' ); ?></th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								$carrier_name_replaces       = $this->settings->get_params( 'carrier_name_replaces' );
								$carrier_name_replaces_count = 1;
								if ( ! empty( $carrier_name_replaces['from_string'] ) && ! empty( $carrier_name_replaces['to_string'] ) && is_array( $carrier_name_replaces['from_string'] ) ) {
									$carrier_name_replaces_count = count( $carrier_name_replaces['from_string'] );
								}
								for ( $i = 0; $i < $carrier_name_replaces_count; $i ++ ) {
									$checked = $case_sensitive = '';
									if ( ! empty( $carrier_name_replaces['sensitive'][ $i ] ) ) {
										$checked        = 'checked';
										$case_sensitive = 1;
									}
									?>
                                    <tr class="clone-source">
                                        <td>
                                            <input type="text"
                                                   value="<?php echo esc_attr( isset( $carrier_name_replaces['from_string'][ $i ] ) ? $carrier_name_replaces['from_string'][ $i ] : '' ) ?>"
                                                   name="<?php echo esc_attr( self::set( 'carrier_name_replaces[from_string][]' ) ) ?>">
                                        </td>
                                        <td>
                                            <div class="<?php echo esc_attr( self::set( 'string-replace-sensitive-container' ) ) ?>">
                                                <input type="checkbox"
                                                       value="1" <?php esc_attr_e( $checked ) ?>
                                                       class="<?php echo esc_attr( self::set( 'string-replace-sensitive' ) ) ?>">
                                                <input type="hidden"
                                                       class="<?php echo esc_attr( self::set( 'string-replace-sensitive-value' ) ) ?>"
                                                       value="<?php echo esc_attr( $case_sensitive ) ?>"
                                                       name="<?php echo esc_attr( self::set( 'carrier_name_replaces[sensitive][]' ) ) ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   placeholder="<?php esc_html_e( 'Leave blank to delete matches', 'woo-alidropship' ); ?>"
                                                   value="<?php echo esc_attr( isset( $carrier_name_replaces['to_string'][ $i ] ) ? $carrier_name_replaces['to_string'][ $i ] : '' ) ?>"
                                                   name="<?php echo esc_attr( self::set( 'carrier_name_replaces[to_string][]' ) ) ?>">
                                        </td>
                                        <td>
                                            <button type="button"
                                                    class="vi-ui button negative delete-string-replace-rule">
                                                <i class="dashicons dashicons-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
									<?php
								}
								?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4">
                                        <button type="button"
                                                class="vi-ui button positive add-string-replace-rule-name">
											<?php esc_html_e( 'Add', 'woo-alidropship' ); ?>
                                        </button>
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
					<?php
				}
				?>

                <p>
                    <button type="submit"
                            class="vi-ui button primary <?php echo esc_attr( self::set( 'save-settings' ) ) ?>"
                            name="<?php echo esc_attr( self::set( 'save-settings', true ) ) ?>">
						<?php esc_html_e( 'Save', 'woo-alidropship' ) ?></button>
                </p>
            </form>
			<?php do_action( 'villatheme_support_woo-alidropship' ) ?>
        </div>
		<?php
	}

	/**
	 *
	 */
	protected function set_nonce() {
		wp_nonce_field( 'wooaliexpressdropship_save_settings', '_wooaliexpressdropship_nonce' );
	}

	public static function set_params( $name = '', $class = false, $multiple = false ) {
		if ( $name ) {
			if ( $class ) {
				echo 'vi-wad-' . str_replace( '_', '-', $name );
			} else {
				if ( $multiple ) {
					echo 'wad_' . $name . '[]';
				} else {
					echo 'wad_' . $name;
				}
			}
		}
	}

	/**
	 * Register a custom menu page.
	 */
	public function admin_menu() {
		add_menu_page(
			esc_html__( 'Dropshipping and Fulfillment for AliExpress and WooCommerce Settings', 'woo-alidropship' ),
			esc_html__( 'Dropship & Fulfil', 'woo-alidropship' ),
			'manage_options',
			'woo-alidropship',
			array( $this, 'page_callback' ),
			VI_WOO_ALIDROPSHIP_IMAGES . 'icon.png',
			2
		);
		$import_list = add_submenu_page( 'woo-alidropship', esc_html__( 'Import List - Dropshipping and Fulfillment for AliExpress and WooCommerce', 'woo-alidropship' ), esc_html__( 'Import List', 'woo-alidropship' ), 'manage_options', 'woo-alidropship-import-list', array(
			$this,
			'import_list_callback'
		) );
		add_action( "load-$import_list", array( $this, 'screen_options_page' ) );
		$imported_list = add_submenu_page( 'woo-alidropship', esc_html__( 'Imported Products - Dropshipping and Fulfillment for AliExpress and WooCommerce', 'woo-alidropship' ), esc_html__( 'Imported', 'woo-alidropship' ), 'manage_options', 'woo-alidropship-imported-list', array(
			$this,
			'imported_list_callback'
		) );
		add_action( "load-$imported_list", array( $this, 'screen_options_page_imported' ) );
	}

	public function remove() {
		vi_wad_set_time_limit();
		$product_id = isset( $_POST['product_id'] ) ? sanitize_text_field( $_POST['product_id'] ) : '';
		if ( $product_id ) {
			if ( wp_delete_post( $product_id, true ) ) {
				wp_send_json( array(
					'status'  => 'success',
					'message' => esc_html__( 'Removed', 'woo-alidropship' ),
				) );
			} else {
				wp_send_json( array(
					'status'  => 'error',
					'message' => esc_html__( 'Error', 'woo-alidropship' ),
				) );
			}
		} else {
			wp_send_json( array(
				'status'  => 'error',
				'message' => esc_html__( 'Not found', 'woo-alidropship' ),
			) );
		}
	}

	public function override() {
		vi_wad_set_time_limit();
		parse_str( $_POST['data'], $form_data );
		$data                = isset( $form_data['vi_wad_product'] ) ? $form_data['vi_wad_product'] : array();
		$selected            = isset( $_POST['selected'] ) ? stripslashes_deep( $_POST['selected'] ) : array();
		$is_simple           = isset( $_POST['is_simple'] ) ? sanitize_text_field( $_POST['is_simple'] ) : '';
		$override_product_id = isset( $_POST['override_product_id'] ) ? sanitize_text_field( $_POST['override_product_id'] ) : '';
		$replace_title       = isset( $_POST['replace_title'] ) ? sanitize_text_field( $_POST['replace_title'] ) : '';
		$replace_images      = isset( $_POST['replace_images'] ) ? sanitize_text_field( $_POST['replace_images'] ) : '';
		$replace_description = isset( $_POST['replace_description'] ) ? sanitize_text_field( $_POST['replace_description'] ) : '';
		if ( $override_product_id ) {
			$product_data                        = array_values( $data )[0];
			$product_data['override_product_id'] = $override_product_id;
			$product_draft_id                    = array_keys( $data )[0];
			$check_orders                        = isset( $_POST['check_orders'] ) ? sanitize_text_field( $_POST['check_orders'] ) : '';
			$found_items                         = isset( $_POST['found_items'] ) ? stripslashes_deep( $_POST['found_items'] ) : array();
			$replace_items                       = isset( $_POST['replace_items'] ) ? stripslashes_deep( $_POST['replace_items'] ) : array();
			$woo_product_id                      = get_post_meta( $override_product_id, '_vi_wad_woo_id', true );
			if ( ! count( $selected[ $product_draft_id ] ) ) {
				wp_send_json( array(
					'status'  => 'error',
					'message' => esc_html__( 'Please select at least 1 variation to import this product.', 'woo-alidropship' ),
				) );
			}
			if ( ! $product_draft_id || VI_WOO_ALIDROPSHIP_DATA::sku_exists( $product_data['sku'] ) ) {
				wp_send_json( array(
					'status'  => 'error',
					'message' => esc_html__( 'Sku exists.', 'woo-alidropship' ),
				) );
			}
			if ( VI_WOO_ALIDROPSHIP_DATA::product_get_id_by_aliexpresss_id( get_post_meta( $product_draft_id, '_vi_wad_sku', true ), array( 'publish' ) ) ) {
				wp_send_json( array(
					'status'  => 'error',
					'message' => esc_html__( 'This product has already been imported', 'woo-alidropship' ),
				) );
			}
			$woo_product = wc_get_product( $woo_product_id );
			if ( $woo_product ) {
				if ( 1 != $check_orders ) {
					if ( 1 == $is_simple ) {
						$variation = $product_data['variations'][0];
						ob_start();
						?>
                        <select class="vi-ui fluid dropdown <?php echo esc_attr( self::set( 'override-with' ) ) ?>">
                            <option value="none"><?php esc_html_e( 'Do not replace', 'woo-alidropship' ) ?></option>
                            <option value="<?php echo esc_attr( $variation['skuId'] ) ?>"><?php esc_html_e( 'Replace with new product', 'woo-alidropship' ) ?></option>
                        </select>
						<?php
						$variations_html = ob_get_clean();
					} else {
						$variations = array();
						foreach ( $selected[ $product_draft_id ] as $variation_k ) {
							if ( isset( $product_data['variations'][ $variation_k ] ) ) {
								$variations[] = $product_data['variations'][ $variation_k ];
							}
						}
						ob_start();
						?>
                        <select class="vi-ui fluid dropdown <?php echo esc_attr( self::set( 'override-with' ) ) ?>">
                            <option value="none"><?php esc_html_e( 'Do not replace', 'woo-alidropship' ) ?></option>
							<?php
							foreach ( $variations as $variation ) {
								?>
                                <option value="<?php echo esc_attr( $variation['skuId'] ) ?>"><?php echo implode( ',', array_values( $variation['attributes'] ) ) ?></option>
								<?php
							}
							?>
                        </select>
						<?php
						$variations_html = ob_get_clean();
					}

					$replace_order_html = '';

					if ( $woo_product->is_type( 'variable' ) ) {
						$woo_product_children = $woo_product->get_children();
						if ( count( $woo_product_children ) ) {
							foreach ( $woo_product_children as $woo_product_child ) {
								$found_item = $this->query_order_item_meta( array( 'order_item_type' => 'line_item' ), array(
									'meta_key'   => '_variation_id',
									'meta_value' => $woo_product_child
								) );
								if ( count( $found_item ) ) {
									$found_items[ $woo_product_child ] = $found_item;
									$woo_product_child_obj             = wc_get_product( $woo_product_child );
									ob_start();
									?>
                                    <div class="<?php echo esc_attr( self::set( 'override-order-container' ) ) ?>"
                                         data-replace_item_id="<?php esc_attr_e( $woo_product_child ) ?>">
                                        <div class="<?php echo esc_attr( self::set( 'override-from' ) ) ?>">
											<?php
											if ( $woo_product_child_obj ) {
												if ( $woo_product_child_obj->get_image_id() ) {
													$image_src = wp_get_attachment_thumb_url( $woo_product_child_obj->get_image_id() );

												} elseif ( $woo_product->get_image_id() ) {
													$image_src = wp_get_attachment_thumb_url( $woo_product->get_image_id() );
												} else {
													$image_src = wc_placeholder_img_src();
												}
												if ( $image_src ) {
													?>
                                                    <div class="<?php echo esc_attr( self::set( 'override-from-image' ) ) ?>">
                                                        <img src="<?php echo esc_url( $image_src ) ?>" width="30px"
                                                             height="30px">
                                                    </div>
													<?php
												}

											}
											?>
                                            <div class="<?php echo esc_attr( self::set( 'override-from-title' ) ) ?>">
												<?php
												echo implode( ',', $woo_product_child_obj->get_attributes() );
												?>
                                            </div>
                                        </div>
                                        <div class="<?php echo esc_attr( self::set( 'override-with-attributes' ) ) ?>">
											<?php
											echo $variations_html;
											?>
                                        </div>
                                    </div>
									<?php
									$replace_order_html .= ob_get_clean();
								}
							}
						}
					} else {
						$found_item = $this->query_order_item_meta( array( 'order_item_type' => 'line_item' ), array(
							'meta_key'   => '_product_id',
							'meta_value' => $woo_product_id,
						) );
						if ( count( $found_item ) ) {
							$found_items[ $woo_product_id ] = $found_item;
							ob_start();
							?>
                            <div class="<?php echo esc_attr( self::set( 'override-order-container' ) ) ?>"
                                 data-replace_item_id="<?php esc_attr_e( $woo_product_id ) ?>">
                                <div class="<?php echo esc_attr( self::set( 'override-from' ) ) ?>">
									<?php

									if ( $woo_product->get_image_id() ) {
										$image_src = wp_get_attachment_thumb_url( $woo_product->get_image_id() );

									} elseif ( $woo_product->get_image_id() ) {
										$image_src = wp_get_attachment_thumb_url( $woo_product->get_image_id() );
									} else {
										$image_src = wc_placeholder_img_src();
									}
									if ( $image_src ) {
										?>
                                        <div class="<?php echo esc_attr( self::set( 'override-from-image' ) ) ?>">
                                            <img src="<?php echo esc_url( $image_src ) ?>" width="30px"
                                                 height="30px">
                                        </div>
										<?php
									}
									?>
                                    <div class="<?php echo esc_attr( self::set( 'override-from-title' ) ) ?>">
										<?php
										echo $woo_product->get_title();
										?>
                                    </div>
                                </div>
                                <div class="<?php echo esc_attr( self::set( 'override-with-attributes' ) ) ?>">
									<?php
									echo $variations_html;
									?>
                                </div>
                            </div>
							<?php
							$replace_order_html .= ob_get_clean();
						}
					}
					if ( count( $found_items ) ) {
						wp_send_json( array(
							'status'             => 'checked',
							'message'            => '',
							'found_items'        => $found_items,
							'replace_order_html' => $replace_order_html,
						) );
					}
				}
			}

			$variations            = array();
			$variations_attributes = array();
			foreach ( $selected[ $product_draft_id ] as $variation_k ) {
				if ( isset( $product_data['variations'][ $variation_k ] ) ) {
					$variations[]         = $product_data['variations'][ $variation_k ];
					$variations_attribute = isset( $product_data['variations'][ $variation_k ]['attributes'] ) ? $product_data['variations'][ $variation_k ]['attributes'] : array();
					if ( is_array( $variations_attribute ) && count( $variations_attribute ) ) {
						foreach ( $variations_attribute as $variations_attribute_k => $variations_attribute_v ) {
							if ( ! isset( $variations_attributes[ $variations_attribute_k ] ) ) {
								$variations_attributes[ $variations_attribute_k ] = array( $variations_attribute_v );
							} elseif ( ! in_array( $variations_attribute_v, $variations_attributes[ $variations_attribute_k ] ) ) {
								$variations_attributes[ $variations_attribute_k ][] = $variations_attribute_v;
							}
						}
					}
				}
			}

			if ( count( $variations ) ) {
				if ( $woo_product ) {
					if ( 1 != $replace_title ) {
						$product_data['title'] = $woo_product->get_title();
					}
					if ( 1 != $replace_images ) {
						$product_data['old_product_image']   = get_post_meta( $woo_product_id, '_thumbnail_id', true );
						$product_data['old_product_gallery'] = get_post_meta( $woo_product_id, '_product_image_gallery', true );
					}
					if ( 1 != $replace_description ) {
						$product_data['short_description'] = $woo_product->get_short_description();
						$product_data['description']       = $woo_product->get_description();
					}
				}
				$var_default = isset( $product_data['vi_wad_variation_default'] ) ? $product_data['vi_wad_variation_default'] : '';
				if ( $var_default !== '' ) {
					$product_data['variation_default'] = $variations[ $var_default ]['attributes'];
				}
				$product_data['gallery'] = array_values( array_filter( $product_data['gallery'] ) );
				if ( $product_data['image'] ) {
					$product_image_key = array_search( $product_data['image'], $product_data['gallery'] );
					if ( $product_image_key !== false ) {
						unset( $product_data['gallery'][ $product_image_key ] );
						$product_data['gallery'] = array_values( $product_data['gallery'] );
					}
				}
				$variation_images = get_post_meta( $product_draft_id, '_vi_wad_variation_images', true );
				$attributes       = get_post_meta( $product_draft_id, '_vi_wad_attributes', true );
				if ( is_array( $attributes ) && count( $attributes ) ) {
					foreach ( $attributes as $attributes_k => $attributes_v ) {
						if ( ! empty( $variations_attributes[ $attributes_v['slug'] ] ) ) {
							$attributes[ $attributes_k ]['values'] = array_intersect( $attributes[ $attributes_k ]['values'], $variations_attributes[ $attributes_v['slug'] ] );
						}
					}
				}
				$product_data['variation_images'] = $variation_images;
				$product_data['attributes']       = $attributes;
				$product_data['variations']       = $variations;
				$product_data['parent_id']        = $product_draft_id;
				$product_data['replace_items']    = $replace_items;
				$product_data['replace_title']    = $replace_title;
				$product_data['found_items']      = $found_items;
				$product_data['ali_product_id']   = get_post_meta( $product_draft_id, '_vi_wad_sku', true );
				$this->import_product_to_override( $product_data );
			} else {
				wp_send_json( array(
					'status'  => 'error',
					'message' => esc_html__( 'Please select at least 1 variation to import this product.', 'woo-alidropship' ),
				) );
			}
		} else {
			wp_send_json( array(
				'status'  => 'error',
				'message' => esc_html__( 'Product is deleted from your store', 'woo-alidropship' ),
			) );
		}
	}

	/**
	 * @param array $args1 $key=>$value are key and value of woocommerce_order_items table
	 * @param array $args2 $key=>$value are key and value of woocommerce_order_itemmeta table
	 *
	 * @return array|null|object
	 */
	protected function query_order_item_meta( $args1 = array(), $args2 = array() ) {
		global $wpdb;
		$sql  = "SELECT * FROM {$wpdb->prefix}woocommerce_order_items as woocommerce_order_items JOIN {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta WHERE woocommerce_order_items.order_item_id=woocommerce_order_itemmeta.order_item_id";
		$args = array();
		if ( count( $args1 ) ) {
			foreach ( $args1 as $key => $value ) {
				if ( is_array( $value ) ) {
					$sql .= " AND woocommerce_order_items.{$key} IN (" . implode( ', ', array_fill( 0, count( $value ), '%s' ) ) . ")";
					foreach ( $value as $v ) {
						$args[] = $v;
					}
				} else {
					$sql    .= " AND woocommerce_order_items.{$key}='%s'";
					$args[] = $value;
				}
			}
		}
		if ( count( $args2 ) ) {
			foreach ( $args2 as $key => $value ) {
				if ( is_array( $value ) ) {
					$sql .= " AND woocommerce_order_itemmeta.{$key} IN (" . implode( ', ', array_fill( 0, count( $value ), '%s' ) ) . ")";
					foreach ( $value as $v ) {
						$args[] = $v;
					}
				} else {
					$sql    .= " AND woocommerce_order_itemmeta.{$key}='%s'";
					$args[] = $value;
				}
			}
		}
		$query      = $wpdb->prepare( $sql, $args );
		$line_items = $wpdb->get_results( $query, ARRAY_A );

		return $line_items;
	}

	/**
	 * @param $product_data
	 *
	 * @return int|WP_Error
	 * @throws Exception
	 */
	public function import_product( $product_data ) {
		vi_wad_set_time_limit();
		$ali_product_id             = $product_data['ali_product_id'];
		$parent_id                  = $product_data['parent_id'];
		$image                      = $product_data['image'];
		$categories                 = isset( $product_data['categories'] ) ? $product_data['categories'] : array();
		$title                      = $product_data['title'];
		$sku                        = $product_data['sku'];
		$status                     = $product_data['status'];
		$tags                       = isset( $product_data['tags'] ) ? $product_data['tags'] : array();
		$description                = $product_data['description'];
		$variations                 = $product_data['variations'];
		$gallery                    = $product_data['gallery'];
		$attributes                 = $product_data['attributes'];
		$catalog_visibility         = $product_data['catalog_visibility'];
		$default_attr               = isset( $product_data['variation_default'] ) ? $product_data['variation_default'] : '';
		$aff_url                    = isset( $product_data['aff_url'] ) ? $product_data['aff_url'] : '';
		$disable_background_process = $this->settings->get_params( 'disable_background_process' );
		if ( is_array( $attributes ) && count( $attributes ) && ( count( $variations ) > 1 || ! $this->settings->get_params( 'simple_if_one_variation' ) ) ) {
			$attr_data = array();
			$position  = 0;
			foreach ( $attributes as $key => $attr ) {
				$attr_data[ strtolower( $attr['slug'] ) ] = array(
					'name'         => VI_WOO_ALIDROPSHIP_DATA::get_attribute_name_by_slug( $attr['slug'] ),
					'value'        => implode( ' | ', $attr['values'] ),
					'position'     => isset( $attr['position'] ) ? $attr['position'] : $position,
					'is_visible'   => $this->get_params( 'variation_visible' ) ? 1 : '',
					'is_variation' => 1,
					'is_taxonomy'  => '',
				);
				$position ++;
			}
			/*Create data for product*/
			$data = array( // Set up the basic post data to insert for our product
				'post_excerpt' => '',
				'post_content' => $description,
				'post_title'   => $title,
				'post_status'  => $status,
				'post_type'    => 'product',
				'meta_input'   => array(
					'_sku'                => wc_product_generate_unique_sku( 0, $sku ),
					'_product_attributes' => $attr_data,
					'_visibility'         => 'visible',
					'_default_attributes' => $default_attr,
					'_vi_wad_aff_url'     => $aff_url,
				)
			);

			$product_id = wp_insert_post( $data ); // Insert the post returning the new post id

			if ( ! is_wp_error( $product_id ) ) {
				if ( $parent_id ) {
					$update_data = array(
						'ID'          => $parent_id,
						'post_status' => 'publish'
					);
					wp_update_post( $update_data );
					update_post_meta( $parent_id, '_vi_wad_woo_id', $product_id );
				}

				update_post_meta( $product_id, '_vi_wad_aliexpress_product_id', $ali_product_id );
				// Set it to a variable product type
				wp_set_object_terms( $product_id, 'variable', 'product_type' );
				/*download image gallery*/
				$dispatch = false;
				if ( isset( $product_data['old_product_image'] ) ) {
					if ( $product_data['old_product_image'] ) {
						update_post_meta( $product_id, '_thumbnail_id', $product_data['old_product_image'] );
					}
					if ( isset( $product_data['old_product_gallery'] ) && $product_data['old_product_gallery'] ) {
						update_post_meta( $product_id, '_product_image_gallery', $product_data['old_product_gallery'] );
					}
				} else {
					if ( $image ) {
						$thumb_id = VI_WOO_ALIDROPSHIP_DATA::download_image($image_id, $image,$product_id );
						if ( ! is_wp_error( $thumb_id ) ) {
							update_post_meta( $product_id, '_thumbnail_id', $thumb_id );
						}
					}
					if ( is_array( $gallery ) && count( $gallery ) ) {
						if ( $disable_background_process ) {
							foreach ( $gallery as $image_url ) {
								$image_data = array(
									'woo_product_id' => $product_id,
									'parent_id'      => $parent_id,
									'src'            => $image_url,
									'product_ids'    => array(),
									'set_gallery'    => 1,
								);
								Vi_Wad_Error_Images_Table::insert( $product_id, implode( ',', $image_data['product_ids'] ), $image_data['src'], intval( $image_data['set_gallery'] ) );
							}
						} else {
							$dispatch = true;
							foreach ( $gallery as $image_url ) {
								$image_data = array(
									'woo_product_id' => $product_id,
									'parent_id'      => $parent_id,
									'src'            => $image_url,
									'product_ids'    => array(),
									'set_gallery'    => 1,
								);
								self::$process_image->push_to_queue( $image_data );
							}
						}
					}
				}

				/*Set product tag*/
				if ( is_array( $tags ) && count( $tags ) ) {
					wp_set_post_terms( $product_id, $tags, 'product_tag', true );
				}
				/*Set product categories*/
				if ( is_array( $categories ) && count( $categories ) ) {
					wp_set_post_terms( $product_id, $categories, 'product_cat', true );
				}
				/*Create product variation*/
				$this->import_product_variation( $product_id, $product_data, $dispatch, $disable_background_process );
				vi_wad_set_catalog_visibility( $product_id, $catalog_visibility );
			}
		} else {
			/*Create data for product*/
			$sale_price    = isset( $variations[0]['sale_price'] ) ? floatval( $variations[0]['sale_price'] ) : '';
			$regular_price = isset( $variations[0]['regular_price'] ) ? floatval( $variations[0]['regular_price'] ) : '';
			$data          = array( // Set up the basic post data to insert for our product
				'post_excerpt' => '',
				'post_content' => $description,
				'post_title'   => $title,
				'post_status'  => $status,
				'post_type'    => 'product',
				'meta_input'   => array(
					'_sku'            => wc_product_generate_unique_sku( 0, $sku ),
					'_visibility'     => 'visible',
					'_regular_price'  => $regular_price,
					'_price'          => $regular_price,
					'_manage_stock'   => 'yes',
					'_stock_status'   => 'instock',
					'_stock'          => isset( $variations[0]['stock'] ) ? absint( $variations[0]['stock'] ) : 0,
					'_vi_wad_aff_url' => $aff_url,
				)
			);
			if ( $sale_price ) {
				$data['meta_input']['_sale_price'] = $sale_price;
				$data['meta_input']['_price']      = $sale_price;
			}
			$product_id = wp_insert_post( $data ); // Insert the post returning the new post id

			if ( ! is_wp_error( $product_id ) ) {
				if ( $parent_id ) {
					$update_data = array(
						'ID'          => $parent_id,
						'post_status' => 'publish'
					);
					wp_update_post( $update_data );
					update_post_meta( $parent_id, '_vi_wad_woo_id', $product_id );
				}
				// Set it to a variable product type
				wp_set_object_terms( $product_id, 'simple', 'product_type' );
				/*download image gallery*/
				if ( isset( $product_data['old_product_image'] ) ) {
					if ( $product_data['old_product_image'] ) {
						update_post_meta( $product_id, '_thumbnail_id', $product_data['old_product_image'] );
					}
					if ( isset( $product_data['old_product_gallery'] ) && $product_data['old_product_gallery'] ) {
						update_post_meta( $product_id, '_product_image_gallery', $product_data['old_product_gallery'] );
					}
				} else {
					if ( $image ) {
						$thumb_id = VI_WOO_ALIDROPSHIP_DATA::download_image($image_id, $image ,$product_id);
						if ( ! is_wp_error( $thumb_id ) ) {
							update_post_meta( $product_id, '_thumbnail_id', $thumb_id );
						}
					}
					if ( is_array( $gallery ) && count( $gallery ) ) {
						if ( $disable_background_process ) {
							foreach ( $gallery as $image_url ) {
								$image_data = array(
									'woo_product_id' => $product_id,
									'parent_id'      => $parent_id,
									'src'            => $image_url,
									'product_ids'    => array(),
									'set_gallery'    => 1,
								);
								Vi_Wad_Error_Images_Table::insert( $product_id, implode( ',', $image_data['product_ids'] ), $image_data['src'], intval( $image_data['set_gallery'] ) );
							}
						} else {
							foreach ( $gallery as $image_url ) {
								$image_data = array(
									'woo_product_id' => $product_id,
									'parent_id'      => $parent_id,
									'src'            => $image_url,
									'product_ids'    => array(),
									'set_gallery'    => 1,
								);
								self::$process_image->push_to_queue( $image_data );
							}
							self::$process_image->save()->dispatch();
						}
					}
				}

				/*Set product tag*/
				if ( is_array( $tags ) && count( $tags ) ) {
					wp_set_post_terms( $product_id, $tags, 'product_tag', true );
				}
				/*Set product categories*/
				if ( is_array( $categories ) && count( $categories ) ) {
					wp_set_post_terms( $product_id, $categories, 'product_cat', true );
				}
				update_post_meta( $product_id, '_vi_wad_aliexpress_product_id', $ali_product_id );
				if ( ! empty( $variations[0]['skuId'] ) ) {
					update_post_meta( $product_id, '_vi_wad_aliexpress_variation_id', $variations[0]['skuId'] );
				}
				if ( ! empty( $variations[0]['skuAttr'] ) ) {
					update_post_meta( $product_id, '_vi_wad_aliexpress_variation_attr', $variations[0]['skuAttr'] );
				}
				$found_items   = isset( $product_data['found_items'] ) ? $product_data['found_items'] : array();
				$replace_items = isset( $product_data['replace_items'] ) ? $product_data['replace_items'] : array();
				$replace_title = isset( $product_data['replace_title'] ) ? $product_data['replace_title'] : '';
				$replaces      = array_keys( $replace_items, $variations[0]['skuId'] );

				if ( count( $replaces ) ) {
					foreach ( $replaces as $old_variation_id ) {
						$order_item_data = isset( $found_items[ $old_variation_id ] ) ? $found_items[ $old_variation_id ] : array();
						if ( count( $order_item_data ) ) {
							foreach ( $order_item_data as $order_item_data_k => $order_item_data_v ) {
								$order_id      = $order_item_data_v['order_id'];
								$order_item_id = $order_item_data_v['order_item_id'];
								if ( 1 == $replace_title ) {
									wc_update_order_item( $order_item_id, array( 'order_item_name' => $title ) );
								}
								if ( $order_item_data_v['meta_key'] == '_variation_id' ) {
									$old_variation = wc_get_product( $old_variation_id );
									if ( $old_variation ) {
										$_product_id = wc_get_order_item_meta( $order_item_id, '_product_id', true );
										$note        = sprintf( esc_html__( 'Product #%s is replaced with product #%s.', 'woo-alidropship' ), $_product_id, $product_id );
										$this->add_order_note( $order_id, $note );
										$old_attributes = $old_variation->get_attributes();
										if ( count( $old_attributes ) ) {
											foreach ( $old_attributes as $old_attribute_k => $old_attribute_v ) {
												wc_delete_order_item_meta( $order_item_id, $old_attribute_k );
											}
										}
									}
									wc_delete_order_item_meta( $order_item_id, '_variation_id' );
								} else {
									$note = sprintf( esc_html__( 'Product #%s is replaced with product #%s.', 'woo-alidropship' ), $old_variation_id, $product_id );
									$this->add_order_note( $order_id, $note );
								}
								wc_update_order_item_meta( $order_item_id, '_product_id', $product_id );
							}
						}
					}
				}
				vi_wad_set_catalog_visibility( $product_id, $catalog_visibility );
				$product = wc_get_product( $product_id );
				if ( $product ) {
					$product->save();
				}
			}
		}

		return $product_id;
	}

	public function import_product_to_override( $product_data ) {
		$override_product_id = $product_data['override_product_id'];
		$woo_product_id      = get_post_meta( $override_product_id, '_vi_wad_woo_id', true );
		$product_id          = $this->import_product( $product_data );
		$response            = array(
			'status'     => 'error',
			'message'    => '',
			'product_id' => '',
		);
		if ( ! is_wp_error( $product_id ) ) {
			if ( $override_product_id ) {
				wp_delete_post( $override_product_id );
				wp_delete_post( $woo_product_id );
			}
			$response['status']     = 'success';
			$response['product_id'] = $product_id;
		} else {
			$response['message'] = $product_id->get_error_messages();
		}
		wp_send_json( $response );
	}

	public function import_product_variation( $product_id, $product_data, $dispatch, $disable_background_process ) {
		$product = wc_get_product( $product_id );
		if ( $product ) {
			if ( is_array( $product_data['variations'] ) && count( $product_data['variations'] ) ) {
				$found_items   = isset( $product_data['found_items'] ) ? $product_data['found_items'] : array();
				$replace_items = isset( $product_data['replace_items'] ) ? $product_data['replace_items'] : array();
				$replace_title = isset( $product_data['replace_title'] ) ? $product_data['replace_title'] : '';
				$variation_ids = [];
				if ( count( $product_data['variation_images'] ) ) {
					foreach ( $product_data['variation_images'] as $key => $val ) {
						$variation_ids[ $key ] = array();
					}
				}

				$manage_stock = $this->settings->get_params( 'manage_stock' );
				$manage_stock = $manage_stock ? 'yes' : 'no';

				foreach ( $product_data['variations'] as $product_variation ) {
					$stock_quantity = isset( $product_variation['stock'] ) ? absint( $product_variation['stock'] ) : 0;
					$variation      = new WC_Product_Variation();
					$variation->set_parent_id( $product_id );
					$variation->set_attributes( $product_variation['attributes'] );
					/*Set metabox for variation . Check field name at woocommerce/includes/class-wc-ajax.php*/
					$fields = array(
						'sku'            => wc_product_generate_unique_sku( 0, $product_variation['sku'] ),
						'regular_price'  => $product_variation['regular_price'],
						'price'          => $product_variation['regular_price'],
						'manage_stock'   => $manage_stock,
						'stock_status'   => 'instock',
						'stock_quantity' => $stock_quantity,
					);
					if ( isset( $product_variation['sale_price'] ) && $product_variation['sale_price'] && $product_variation['sale_price'] < $product_variation['regular_price'] ) {
						$fields['sale_price'] = $product_variation['sale_price'];
						$fields['price']      = $product_variation['sale_price'];
					}
					foreach ( $fields as $field => $value ) {
						$variation->{"set_$field"}( wc_clean( $value ) );
					}
					do_action( 'product_variation_linked', $variation->save() );
					$variation_id = $variation->get_id();
					$replaces     = array_keys( $replace_items, $product_variation['skuId'] );
					if ( count( $replaces ) ) {
						foreach ( $replaces as $old_variation_id ) {
							$order_item_data = isset( $found_items[ $old_variation_id ] ) ? $found_items[ $old_variation_id ] : array();
							if ( count( $order_item_data ) ) {
								foreach ( $order_item_data as $order_item_data_k => $order_item_data_v ) {
									$order_id      = $order_item_data_v['order_id'];
									$order_item_id = $order_item_data_v['order_item_id'];
									if ( 1 == $replace_title ) {
										wc_update_order_item( $order_item_id, array( 'order_item_name' => $replace_title ) );
									}
									if ( $order_item_data_v['meta_key'] == '_variation_id' ) {
										$old_variation = wc_get_product( $old_variation_id );
										if ( $old_variation ) {
											$_product_id = wc_get_order_item_meta( $order_item_id, '_product_id', true );
											$note        = sprintf( esc_html__( 'Product #%s is replaced with product #%s. Variation #%s is replaced with variation #%s.', 'woo-alidropship' ), $_product_id, $product_id, $old_variation_id, $variation_id );
											$this->add_order_note( $order_id, $note );
											$old_attributes = $old_variation->get_attributes();
											if ( count( $old_attributes ) ) {
												foreach ( $old_attributes as $old_attribute_k => $old_attribute_v ) {
													wc_delete_order_item_meta( $order_item_id, $old_attribute_k );
												}
											}
										}

									} else {
										$note = sprintf( esc_html__( 'Product #%s is replaced with product #%s.', 'woo-alidropship' ), $old_variation_id, $product_id );
										$this->add_order_note( $order_id, $note );
										foreach ( $product_variation['attributes'] as $new_attribute_k => $new_attribute_v ) {
											wc_update_order_item_meta( $order_item_id, $new_attribute_k, $new_attribute_v );
										}
									}
									foreach ( $product_variation['attributes'] as $new_attribute_k => $new_attribute_v ) {
										wc_update_order_item_meta( $order_item_id, $new_attribute_k, $new_attribute_v );
									}
									wc_update_order_item_meta( $order_item_id, '_product_id', $product_id );
									wc_update_order_item_meta( $order_item_id, '_variation_id', $variation_id );
								}
							}
						}
					}
					update_post_meta( $variation_id, '_vi_wad_aliexpress_variation_id', $product_variation['skuId'] );
					update_post_meta( $variation_id, '_vi_wad_aliexpress_variation_attr', $product_variation['skuAttr'] );
					if ( $product_variation['image'] ) {
						$pos = array_search( $product_variation['image'], $product_data['variation_images'] );
						if ( $pos !== false ) {
							$variation_ids[ $pos ][] = $variation_id;
						}
					}
				}
				if ( count( $variation_ids ) ) {
					if ( $disable_background_process ) {
						foreach ( $variation_ids as $key => $values ) {
							if ( count( $values ) && ! empty( $product_data['variation_images'][ $key ] ) ) {
								$image_data = array(
									'woo_product_id' => $product_id,
									'parent_id'      => '',
									'src'            => $product_data['variation_images'][ $key ],
									'product_ids'    => $values,
									'set_gallery'    => 0,
								);
								Vi_Wad_Error_Images_Table::insert( $product_id, implode( ',', $image_data['product_ids'] ), $image_data['src'], intval( $image_data['set_gallery'] ) );
							}
						}
					} else {
						foreach ( $variation_ids as $key => $values ) {
							if ( count( $values ) && ! empty( $product_data['variation_images'][ $key ] ) ) {
								$dispatch   = true;
								$image_data = array(
									'woo_product_id' => $product_id,
									'parent_id'      => '',
									'src'            => $product_data['variation_images'][ $key ],
									'product_ids'    => $values,
									'set_gallery'    => 0,
								);
								self::$process_image->push_to_queue( $image_data );
							}
						}
					}
				}
			}

			$data_store = $product->get_data_store();
			$data_store->sort_all_product_variations( $product->get_id() );
		}
		if ( $dispatch ) {
			self::$process_image->save()->dispatch();
		}
	}

	public function add_order_note( $order_id, $note ) {
		$commentdata = apply_filters(
			'woocommerce_new_order_note_data',
			array(
				'comment_post_ID'      => $order_id,
				'comment_author'       => '',
				'comment_author_email' => __( 'WooCommerce', 'woocommerce' ),
				'comment_author_url'   => '',
				'comment_content'      => $note,
				'comment_agent'        => 'WooCommerce',
				'comment_type'         => 'order_note',
				'comment_parent'       => 0,
				'comment_approved'     => 1,
			),
			array(
				'order_id'         => $order_id,
				'is_customer_note' => 0,
			)
		);
		wp_insert_comment( $commentdata );
	}

	public function import() {
		parse_str( $_POST['data'], $form_data );
		$data     = isset( $form_data['vi_wad_product'] ) ? stripslashes_deep( $form_data['vi_wad_product'] ) : array();
		$selected = isset( $_POST['selected'] ) ? stripslashes_deep( $_POST['selected'] ) : array();
		$response = array(
			'status'         => 'error',
			'message'        => '',
			'woo_product_id' => '',
			'button_html'    => '',
		);
//		sleep( 1 );
//		$woo_product_id=17759;
//		$response['status']='success';
//		$response['button_html']=self::get_button_view_edit_html( $woo_product_id );
//		wp_send_json( $response );
		if ( count( $data ) === 0 ) {
			$response['message'] = esc_html__( 'Please select product to import', 'woo-alidropship' );
		} else {
			$product_data     = array_values( $data )[0];
			$product_draft_id = array_keys( $data )[0];
			if ( ! count( $selected[ $product_draft_id ] ) ) {
				$response['message'] = esc_html__( 'Please select at least 1 variation to import this product.', 'woo-alidropship' );
				wp_send_json( $response );
			}
			if ( ! $product_draft_id || VI_WOO_ALIDROPSHIP_DATA::sku_exists( $product_data['sku'] ) ) {
				$response['message'] = esc_html__( 'Sku exists.', 'woo-alidropship' );
				wp_send_json( $response );
			}
			if ( VI_WOO_ALIDROPSHIP_DATA::product_get_id_by_aliexpresss_id( get_post_meta( $product_draft_id, '_vi_wad_sku', true ), array( 'publish' ) ) ) {
				wp_send_json( array(
					'status'  => 'error',
					'message' => esc_html__( 'This product has already been imported', 'woo-alidropship' ),
				) );
			}
			$variations            = array();
			$variations_attributes = array();
			foreach ( $selected[ $product_draft_id ] as $variation_k ) {
				if ( isset( $product_data['variations'][ $variation_k ] ) ) {
					$variations[]         = $product_data['variations'][ $variation_k ];
					$variations_attribute = isset( $product_data['variations'][ $variation_k ]['attributes'] ) ? $product_data['variations'][ $variation_k ]['attributes'] : array();
					if ( is_array( $variations_attribute ) && count( $variations_attribute ) ) {
						foreach ( $variations_attribute as $variations_attribute_k => $variations_attribute_v ) {
							if ( ! isset( $variations_attributes[ $variations_attribute_k ] ) ) {
								$variations_attributes[ $variations_attribute_k ] = array( $variations_attribute_v );
							} elseif ( ! in_array( $variations_attribute_v, $variations_attributes[ $variations_attribute_k ] ) ) {
								$variations_attributes[ $variations_attribute_k ][] = $variations_attribute_v;
							}
						}
					}
				}
			}

			if ( count( $variations ) ) {
				$var_default = isset( $product_data['vi_wad_variation_default'] ) ? $product_data['vi_wad_variation_default'] : '';
				if ( $var_default !== '' ) {
					$product_data['variation_default'] = $product_data['variations'][ $var_default ]['attributes'];
				}
				$product_data['gallery'] = array_values( array_filter( $product_data['gallery'] ) );
				if ( $product_data['image'] ) {
					$product_image_key = array_search( $product_data['image'], $product_data['gallery'] );
					if ( $product_image_key !== false ) {
						unset( $product_data['gallery'][ $product_image_key ] );
						$product_data['gallery'] = array_values( $product_data['gallery'] );
					}
				}
				$variation_images = get_post_meta( $product_draft_id, '_vi_wad_variation_images', true );
				$attributes       = get_post_meta( $product_draft_id, '_vi_wad_attributes', true );
				if ( is_array( $attributes ) && count( $attributes ) ) {
					foreach ( $attributes as $attributes_k => $attributes_v ) {
						if ( ! empty( $variations_attributes[ $attributes_v['slug'] ] ) ) {
							$attributes[ $attributes_k ]['values'] = array_intersect( $attributes[ $attributes_k ]['values'], $variations_attributes[ $attributes_v['slug'] ] );
						}
					}
				}
				$product_data['variation_images'] = $variation_images;
				$product_data['attributes']       = $attributes;
				$product_data['variations']       = $variations;
				$product_data['parent_id']        = $product_draft_id;
				$product_data['ali_product_id']   = get_post_meta( $product_draft_id, '_vi_wad_sku', true );
				$product_data['aff_url']          = get_post_meta( $product_draft_id, '_vi_wad_aff_url', true );
				$woo_product_id                   = $this->import_product( $product_data );

				if ( ! is_wp_error( $woo_product_id ) ) {
					$response['status']         = 'success';
					$response['message']        = esc_html__( 'Import successfully', 'woo-alidropship' );
					$response['woo_product_id'] = $woo_product_id;

					$response['button_html'] = self::get_button_view_edit_html( $woo_product_id );
				} else {
					$response['message'] = $woo_product_id->get_error_messages();
				}
			} else {
				$response['message'] = esc_html__( 'Please select at least 1 variation to import this product.', 'woo-alidropship' );
			}
		}
		wp_send_json( $response );
	}

	public static function get_button_view_edit_html( $woo_product_id ) {
		ob_start();
		?>
        <a href="<?php echo esc_attr( get_post_permalink( $woo_product_id ) ) ?>"
           target="_blank" class="button"
           rel="nofollow"><?php esc_html_e( 'View product', 'woo-alidropship' ); ?></a>
        <a href="<?php echo esc_url( admin_url( "post.php?post={$woo_product_id}&action=edit" ) ) ?>"
           target="_blank" class="button button-primary"
           rel="nofollow"><?php esc_html_e( 'Edit product', 'woo-alidropship' ) ?></a>
		<?php
		return ob_get_clean();
	}

	public function imported_list_callback() {
		$user     = get_current_user_id();
		$screen   = get_current_screen();
		$option   = $screen->get_option( 'per_page', 'option' );
		$per_page = get_user_meta( $user, $option, true );

		if ( empty ( $per_page ) || $per_page < 1 ) {
			$per_page = $screen->get_option( 'per_page', 'default' );
		}

		$paged  = isset( $_GET['paged'] ) ? sanitize_text_field( $_GET['paged'] ) : 1;
		$status = ! empty( $_GET['post_status'] ) ? sanitize_text_field( $_GET['post_status'] ) : 'publish';
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'All imported products', 'woo-alidropship' ) ?></h2>
			<?php
			$args = array(
				'post_type'      => 'vi_wad_draft_product',
				'post_status'    => $status,
				'order'          => 'DESC',
				'meta_key'       => '_vi_wad_woo_id',
				'orderby'        => 'meta_value_num',
				'posts_per_page' => - 1,
			);

			$product_ids = array();

			$keyword = isset( $_GET['vi_wad_search'] ) ? sanitize_text_field( $_GET['vi_wad_search'] ) : '';
			if ( $keyword ) {
				$woo_args      = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'order'          => 'DESC',
					'posts_per_page' => - 1,
				);
				$woo_args['s'] = $keyword;
				$the_query     = new WP_Query( $woo_args );
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$product_ids [] = get_the_ID();
				}
				wp_reset_postdata();
				if ( ! count( $product_ids ) ) {
					$args['s'] = $keyword;
				} else {
					$args['meta_value'] = $product_ids;
				}
			}

			$the_query  = new WP_Query( $args );
			$count      = $the_query->post_count;
			$total_page = ceil( $count / $per_page );

			$paged = $total_page >= intval( $paged ) ? $paged : 1;

			wp_reset_postdata();
			$args['posts_per_page'] = $per_page;
			$args['paged']          = $paged;
			$the_query              = new WP_Query( $args );
			ob_start();
			?>
            <form method="get" class="<?php echo esc_attr( self::set( 'imported-products-' . $status ) ) ?>">
                <input type="hidden" name="page" value="woo-alidropship-imported-list">
                <input type="hidden" name="post_status" value="<?php echo esc_attr( $status ) ?>">
                <div class="tablenav top">
                    <div class="subsubsub">
                        <ul>
                            <li class="<?php echo esc_attr( self::set( 'imported-products-count-publish-container' ) ) ?>">
                                <a href="<?php echo esc_attr( admin_url( 'admin.php?page=woo-alidropship-imported-list' ) ) ?>">
									<?php esc_html_e( 'Publish', 'woo-alidropship' ); ?></a>
                                (<span class="<?php echo esc_attr( self::set( 'imported-products-count-publish' ) ) ?>"><?php echo esc_html( $this->count_posts( 'publish' ) ) ?></span>)
                            </li>
                            |
                            <li class="<?php echo esc_attr( self::set( 'imported-products-count-trash-container' ) ) ?>">
                                <a href="<?php echo esc_attr( admin_url( 'admin.php?page=woo-alidropship-imported-list&post_status=trash' ) ) ?>">
									<?php esc_html_e( 'Trash', 'woo-alidropship' ); ?></a>
                                (<span class="<?php echo esc_attr( self::set( 'imported-products-count-trash' ) ) ?>"><?php echo esc_html( $this->count_posts( 'trash' ) ) ?></span>)
                            </li>
                        </ul>
                    </div>
                    <div class="tablenav-pages">
                        <div class="pagination-links">
							<?php
							if ( $paged > 2 ) {
								?>
                                <a class="prev-page button" href="<?php echo esc_url( add_query_arg(
									array(
										'page'          => 'woo-alidropship-imported-list',
										'paged'         => 1,
										'vi_wad_search' => $keyword,
										'post_status'   => $status,
									), admin_url( 'admin.php' )
								) ) ?>"><span
                                            class="screen-reader-text"><?php esc_html_e( 'First Page', 'woo-alidropship' ) ?></span><span
                                            aria-hidden="true">«</span></a>
								<?php
							} else {
								?>
                                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
								<?php
							}
							/*Previous button*/
							if ( $per_page * $paged > $per_page ) {
								$p_paged = $paged - 1;
							} else {
								$p_paged = 0;
							}
							if ( $p_paged ) {
								$p_url = add_query_arg(
									array(
										'page'          => 'woo-alidropship-imported-list',
										'paged'         => $p_paged,
										'vi_wad_search' => $keyword,
										'post_status'   => $status,
									), admin_url( 'admin.php' )
								);
								?>
                                <a class="prev-page button" href="<?php echo esc_url( $p_url ) ?>"><span
                                            class="screen-reader-text"><?php esc_html_e( 'Previous Page', 'woo-alidropship' ) ?></span><span
                                            aria-hidden="true">‹</span></a>
								<?php
							} else {
								?>
                                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
								<?php
							}
							?>
                            <span class="screen-reader-text"><?php esc_html_e( 'Current Page', 'woo-alidropship' ) ?></span>
                            <span id="table-paging" class="paging-input">
                                    <span class="tablenav-paging-text">
                                        <input class="current-page" type="text" name="paged" size="1"
                                               value="<?php echo esc_html( $paged ) ?>"><span
                                                class="tablenav-paging-text"><?php esc_html_e( ' of ', 'woo-alidropship' ) ?>
                                            <span
                                                    class="total-pages"><?php echo esc_html( $total_page ) ?></span>
                                        </span>
                                    </span>
                                </span>
							<?php /*Next button*/
							if ( $per_page * $paged < $count ) {
								$n_paged = $paged + 1;
							} else {
								$n_paged = 0;
							}
							if ( $n_paged ) {
								$n_url = add_query_arg(
									array(
										'page'          => 'woo-alidropship-imported-list',
										'paged'         => $n_paged,
										'vi_wad_search' => $keyword,
										'post_status'   => $status,
									), admin_url( 'admin.php' )
								); ?>
                                <a class="next-page button" href="<?php echo esc_url( $n_url ) ?>"><span
                                            class="screen-reader-text"><?php esc_html_e( 'Next Page', 'woo-alidropship' ) ?></span><span
                                            aria-hidden="true">›</span></a>
								<?php
							} else {
								?>
                                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
								<?php
							}
							if ( $total_page > $paged + 1 ) {
								?>
                                <a class="next-page button" href="<?php echo esc_url( add_query_arg(
									array(
										'page'          => 'woo-alidropship-imported-list',
										'paged'         => $total_page,
										'vi_wad_search' => $keyword,
										'post_status'   => $status,
									), admin_url( 'admin.php' )
								) ) ?>"><span
                                            class="screen-reader-text"><?php esc_html_e( 'Last Page', 'woo-alidropship' ) ?></span><span
                                            aria-hidden="true">»</span></a>
								<?php
							} else {
								?>
                                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
								<?php
							}
							?>
                        </div>
                    </div>
                    <p class="search-box">
                        <input type="text" class="text short" name="vi_wad_search"
                               placeholder="<?php esc_attr_e( 'Search imported product', 'woo-alidropship' ) ?>"
                               value="<?php echo esc_attr( $keyword ) ?>">
                        <input type="submit" name="submit" class="button"
                               value="<?php echo esc_attr( 'Search product', 'woo-alidropship' ) ?>">
                    </p>
                </div>
            </form>
			<?php
			$pagination_html = ob_get_clean();
			echo $pagination_html;

			if ( $the_query->have_posts() ) {
				$key = 0;
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$product_id         = get_the_ID();
					$product            = get_post( $product_id );
					$woo_product_id     = get_post_meta( $product_id, '_vi_wad_woo_id', true );
					$title              = $product->post_title;
					$woo_product        = wc_get_product( $woo_product_id );
					$woo_product_status = '';
					$woo_product_name   = $title;
					$sku                = get_post_meta( $product_id, '_vi_wad_sku', true );
					$woo_sku            = $sku;
					if ( $woo_product ) {
						$woo_sku            = $woo_product->get_sku();
						$woo_product_status = $woo_product->get_status();
						$woo_product_name   = $woo_product->get_name();
					}
					$gallery    = get_post_meta( $product_id, '_vi_wad_gallery', true );
					$store_info = get_post_meta( $product_id, '_vi_wad_store_info', true );
					$image      = wp_get_attachment_thumb_url( get_post_meta( $product_id, '_vi_wad_product_image', true ) );
					if ( ! $image ) {
						$image = ( is_array( $gallery ) && count( $gallery ) ) ? array_shift( $gallery ) : '';
					}
					$variations         = get_post_meta( $product_id, '_vi_wad_variations', true );
					$overriding_product = $this->get_overriding_product( $product_id );
					$accordion_active   = '';
					if ( $overriding_product ) {
						$accordion_active = 'active';
					}
					$aff_url = get_post_meta( $product_id, '_vi_wad_aff_url', true );
					$href    = $aff_url ? 'https://www.aliexpress.com?aliProduct=' . base64_encode( $aff_url ) : "https://www.aliexpress.com/item/{$sku}.html";
					?>
                    <div class="vi-ui styled fluid accordion  <?php echo esc_attr( self::set( 'accordion' ) ); ?>"
                         id="<?php echo esc_attr( self::set( 'product-item-id-' . $product_id ) ) ?>">
                        <div class="title <?php esc_attr_e( $accordion_active ) ?>">
                            <i class="dropdown icon <?php echo esc_attr( self::set( 'accordion-title-icon' ) ); ?>"></i>
                            <div class="<?php echo esc_attr( self::set( 'accordion-product-image-title-container' ) ) ?>">
                                <div class="<?php echo esc_attr( self::set( 'accordion-product-image-title' ) ) ?>">
                                    <img src="<?php echo esc_url( $image ? $image : wc_placeholder_img_src() ) ?>"
                                         class="<?php echo esc_attr( self::set( 'accordion-product-image' ) ) ?>">
                                    <div class="<?php echo esc_attr( self::set( 'accordion-product-title-container' ) ) ?>">
                                        <div class="<?php echo esc_attr( self::set( 'accordion-product-title' ) ) ?>"
                                             title="<?php esc_attr_e( $title ) ?>"><?php echo esc_html( $title ) ?></div>
										<?php
										if ( ! empty( $store_info['name'] ) ) {
											$store_name = $store_info['name'];
											if ( ! empty( $store_info['url'] ) ) {
												$store_name = '<a class="' . esc_attr__( self::set( 'accordion-store-url' ) ) . '" href="' . esc_attr__( $store_info['url'] ) . '" target="_blank">' . $store_name . '</a>';
											}
											?>
                                            <div>
												<?php
												esc_html_e( 'Store: ', 'woo-alidropship' );
												echo $store_name;
												?>
                                            </div>
											<?php
										}
										?>
                                    </div>
                                </div>
                                <div class="<?php echo esc_attr( self::set( 'button-view-and-edit' ) ) ?>">
                                    <a href="<?php echo( esc_attr( $href ) ) ?>"
                                       target="_blank" class="button"
                                       rel="nofollow"><?php esc_html_e( 'View on AliExpress', 'woo-alidropship' ) ?></a>
									<?php
									if ( $woo_product ) {
										if ( $woo_product_status !== 'trash' ) {
											echo self::get_button_view_edit_html( $woo_product_id );
										} else {
											if ( $status !== 'trash' ) {
												?>
                                                <span class="vi-ui black button <?php echo esc_attr( self::set( 'button-trash' ) ) ?>"
                                                      title="<?php esc_attr_e( 'This product is trashed from your WooCommerce store.', 'woo-alidropship' ) ?>"
                                                      data-product_title="<?php echo esc_attr( $title ) ?>"
                                                      data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                      data-woo_product_id=""><?php esc_html_e( 'Trash', 'woo-alidropship' ) ?>
                                                </span>
                                                <span class="vi-ui button negative <?php echo esc_attr( self::set( 'button-delete' ) ) ?>"
                                                      title="<?php esc_attr_e( 'Delete this product permanently', 'woo-alidropship' ) ?>"
                                                      data-product_title="<?php echo esc_attr( $title ) ?>"
                                                      data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                      data-woo_product_id="<?php echo esc_attr( $woo_product ? $woo_product_id : '' ) ?>"><?php esc_html_e( 'Delete', 'woo-alidropship' ) ?>
                                                </span>
												<?php
											} else {
												?>
                                                <span class="vi-ui button positive <?php echo esc_attr( self::set( 'button-restore' ) ) ?>"
                                                      title="<?php esc_attr_e( 'Restore this product', 'woo-alidropship' ) ?>"
                                                      data-product_title="<?php echo esc_attr( $title ) ?>"
                                                      data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                      data-woo_product_id="<?php echo esc_attr( $woo_product ? $woo_product_id : '' ) ?>"><?php esc_html_e( 'Restore', 'woo-alidropship' ) ?></span>
                                                <span class="vi-ui button negative <?php echo esc_attr( self::set( 'button-delete' ) ) ?>"
                                                      title="<?php esc_attr_e( 'Delete this product permanently', 'woo-alidropship' ) ?>"
                                                      data-product_title="<?php echo esc_attr( $title ) ?>"
                                                      data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                      data-woo_product_id="<?php echo esc_attr( $woo_product ? $woo_product_id : '' ) ?>"><?php esc_html_e( 'Delete', 'woo-alidropship' ) ?></span>
												<?php
											}
										}
									} else {
										if ( $status !== 'trash' ) {
											?>
                                            <span class="vi-ui black button <?php echo esc_attr( self::set( 'button-trash' ) ) ?>"
                                                  title="<?php esc_attr_e( 'This product is deleted from your WooCommerce store.', 'woo-alidropship' ) ?>"
                                                  data-product_title="<?php echo esc_attr( $title ) ?>"
                                                  data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                  data-woo_product_id=""><?php esc_html_e( 'Trash', 'woo-alidropship' ) ?>
                                            </span>
                                            <span class="vi-ui button negative <?php echo esc_attr( self::set( 'button-delete' ) ) ?>"
                                                  title="<?php esc_attr_e( 'Delete this product permanently', 'woo-alidropship' ) ?>"
                                                  data-product_title="<?php echo esc_attr( $title ) ?>"
                                                  data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                  data-woo_product_id="<?php echo esc_attr( $woo_product ? $woo_product_id : '' ) ?>"><?php esc_html_e( 'Delete', 'woo-alidropship' ) ?>
                                            </span>
											<?php
										} else {
											?>
                                            <span class="vi-ui button negative <?php echo esc_attr( self::set( 'button-delete' ) ) ?>"
                                                  title="<?php esc_attr_e( 'Delete this product permanently', 'woo-alidropship' ) ?>"
                                                  data-product_title="<?php echo esc_attr( $title ) ?>"
                                                  data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                  data-woo_product_id="<?php echo esc_attr( $woo_product ? $woo_product_id : '' ) ?>"><?php esc_html_e( 'Delete', 'woo-alidropship' ) ?>
                                            </span>
											<?php
										}
									}
									?>
                                </div>
                            </div>
                        </div>
                        <div class="content <?php esc_attr_e( $accordion_active ) ?>">
							<?php
							if ( $overriding_product ) {
								$overriding_product_title = get_the_title( $overriding_product );
								?>
                                <div class="vi-ui message">
                                    <span><?php printf( __( 'This product is being overridden by: %s. Please go to %s to complete the process.', 'woo-alidropship' ), '<strong>' . $overriding_product_title . '</strong>', '<a target="_blank" href="' . admin_url( 'admin.php?page=woo-alidropship-import-list&vi_wad_search=' . urlencode( $overriding_product_title ) ) . '">Import list</a>' ) ?></span>
                                </div>
								<?php
							}
							?>
                            <form class="vi-ui form <?php echo esc_attr( self::set( 'product-container' ) ) ?>"
                                  method="post">
                                <div class="field">
                                    <div class="fields">
                                        <div class="three wide field">
                                            <div class="<?php echo esc_attr( self::set( 'product-image' ) ) ?>">
                                                <img style="width: 100%"
                                                     src="<?php echo esc_url( $image ? $image : wc_placeholder_img_src() ) ?>"
                                                     class="<?php echo esc_attr( self::set( 'import-data-image' ) ) ?>">
                                                <input type="hidden"
                                                       name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][image]' ) ?>"
                                                       value="<?php echo esc_attr( $image ? $image : wc_placeholder_img_src() ) ?>">
                                            </div>
                                        </div>
                                        <div class="thirteen wide field">
                                            <div class="field">
                                                <label><?php esc_html_e( 'WooCommerce product title' ) ?></label>
                                                <input type="text" value="<?php echo esc_attr( $woo_product_name ) ?>"
                                                       readonly
                                                       name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][title]' ) ?>"
                                                       class="<?php echo esc_attr( self::set( 'import-data-title' ) ) ?>">
                                            </div>
                                            <div class="field">
                                                <div class="equal width fields">
                                                    <div class="field">
                                                        <label><?php esc_html_e( 'Sku', 'woo-alidropship' ) ?></label>
                                                        <input type="text" value="<?php echo esc_attr( $woo_sku ) ?>"
                                                               readonly
                                                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][sku]' ) ?>"
                                                               class="<?php echo esc_attr( self::set( 'import-data-sku' ) ) ?>">
                                                    </div>
                                                    <div class="field">
                                                        <label><?php esc_html_e( 'Cost', 'woo-alidropship' ) ?></label>
                                                        <div class="<?php echo esc_attr( self::set( 'price-field' ) ) ?>">
															<?php
															if ( count( $variations ) == 1 ) {
																$variation_sale_price    = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variations[0]['sale_price']);
																$variation_regular_price = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variations[0]['regular_price']);
																$price                   = $variation_sale_price ? $variation_sale_price : $variation_regular_price;
																echo wc_price( $price, array(
																	'currency'     => 'USD',
																	'price_format' => '%1$s&nbsp;%2$s'
																) );
															} else {
																$min_price = 0;
																$max_price = 0;
																foreach ( $variations as $variation_k => $variation_v ) {
																	$variation_sale_price    = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variation_v['sale_price']);
																	$variation_regular_price = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variation_v['regular_price']);
																	$price                   = $variation_sale_price ? $variation_sale_price : $variation_regular_price;
																	if ( ! $min_price ) {
																		$min_price = $price;
																	}
																	if ( $price < $min_price ) {
																		$min_price = $price;
																	}
																	if ( $price > $max_price ) {
																		$max_price = $price;
																	}
																}
																if ( $min_price && $min_price != $max_price ) {
																	echo wc_price( $min_price ) . ' - ' . wc_price( $max_price );
																} elseif ( $max_price ) {
																	echo wc_price( $max_price );
																}
															}
															?>
                                                        </div>
                                                    </div>
													<?php
													if ( $woo_product && $woo_product_status !== 'trash' ) {
														?>
                                                        <div class="field">
                                                            <label><?php esc_html_e( 'WooCommerce Price', 'woo-alidropship' ) ?></label>
                                                            <div class="<?php echo esc_attr( self::set( 'price-field' ) ) ?>">
																<?php
																echo $woo_product->get_price_html();
																?>
                                                            </div>
                                                        </div>
														<?php
													}
													?>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="equal width fields">
                                                    <div class="field">
                                                        <div class="<?php echo esc_attr( self::set( 'button-override-container' ) ) ?>">
															<?php
															if ( $status !== 'trash' ) {
																if ( $woo_product && $woo_product_status !== 'trash' ) {
																	?>
                                                                    <span class="vi-ui button negative <?php echo esc_attr( self::set( 'button-delete' ) ) ?>"
                                                                          title="<?php esc_attr_e( 'Delete this product permanently', 'woo-alidropship' ) ?>"
                                                                          data-product_title="<?php echo esc_attr( $title ) ?>"
                                                                          data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                                          data-woo_product_id="<?php echo esc_attr( $woo_product ? $woo_product_id : '' ) ?>"><?php esc_html_e( 'Delete', 'woo-alidropship' ) ?></span>
																	<?php
																	if ( ! $overriding_product ) {
																		?>
                                                                        <span class="vi-ui button positive <?php echo esc_attr( self::set( 'button-override' ) ) ?>"
                                                                              title="<?php esc_attr_e( 'Override this product', 'woo-alidropship' ) ?>"
                                                                              data-product_title="<?php echo esc_attr( $title ) ?>"
                                                                              data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                                                              data-woo_product_id="<?php echo esc_attr( $woo_product_id ) ?>"><?php esc_html_e( 'Override', 'woo-alidropship' ) ?></span>
																		<?php
																	} else {
																		?>
                                                                        <a title="<?php esc_attr_e( 'Go to import list to complete overriding', 'woo-alidropship' ) ?>"
                                                                           class="vi-ui button positive <?php echo esc_attr( self::set( 'button-complete-overriding' ) ) ?>"
                                                                           target="_blank"
                                                                           href="<?php echo esc_url( admin_url( 'admin.php?page=woo-alidropship-import-list&vi_wad_search=' . urlencode( get_the_title( $overriding_product ) ) ) ) ?>"><?php esc_html_e( 'Complete overriding', 'woo-alidropship' ) ?></a>
                                                                        <a title="<?php esc_attr_e( 'Cancel overriding this product', 'woo-alidropship' ) ?>"
                                                                           class="vi-ui button <?php echo esc_attr( self::set( 'button-complete-overriding' ) ) ?>"
                                                                           target="_self"
                                                                           href="<?php echo esc_url( add_query_arg( array(
																			   'overridden_product' => $product_id,
																			   'cancel_overriding'  => $overriding_product,
																			   '_wpnonce'           => wp_create_nonce( 'cancel_overriding_nonce' )
																		   ) ) ) ?>"><?php esc_html_e( 'Cancel overriding', 'woo-alidropship' ) ?></a>
																		<?php
																	}
																}
															}
															?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
					<?php
					$key ++;
				}
				echo $pagination_html;
			}
			wp_reset_postdata();
			?>
        </div>
		<?php
	}

	public function count_posts( $status ) {
		$args_publish = array(
			'post_type'      => 'vi_wad_draft_product',
			'post_status'    => $status,
			'order'          => 'DESC',
			'meta_key'       => '_vi_wad_woo_id',
			'orderby'        => 'meta_value_num',
			'posts_per_page' => - 1,
		);
		$the_query    = new WP_Query( $args_publish );
		$total        = isset( $the_query->post_count ) ? $the_query->post_count : 0;
		wp_reset_postdata();

		return $total;
	}

	public function get_overriding_product( $product_id ) {
		$return = '';
		if ( $product_id ) {
			$args      = array(
				'post_type'      => 'vi_wad_draft_product',
				'post_status'    => array( 'override' ),
				'post_parent'    => $product_id,
				'posts_per_page' => 1,
			);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$return = get_the_ID();
				}
			}
			wp_reset_postdata();
		}

		return $return;

	}

	public function variation_html( $key, $parent, $attributes, $manage_stock, $variations, $use_different_currency, $currency, $product_id, $woocommerce_currency_symbol, $decimals, $lazy_load = true ) {
		?>
        <thead>
        <tr>
            <td width="1%"></td>
            <td class="vi-wad-fix-width">
                <input type="checkbox" checked
                       class="<?php echo esc_attr( self::set( array(
					       'variations-bulk-enable',
					       'variations-bulk-enable-' . $key
				       ) ) ) ?>">
            </td>
            <td class="vi-wad-fix-width">
                <input type="checkbox" checked
                       class="<?php echo esc_attr( self::set( array(
					       'variations-bulk-select-image',
				       ) ) ) ?>">
            </td>
            <th class="vi-wad-fix-width"><?php esc_html_e( 'Default variation', 'woo-alidropship' ) ?></th>
            <th><?php esc_html_e( 'Sku', 'woo-alidropship' ) ?></th>
			<?php
			if ( is_array( $parent ) && count( $parent ) ) {
				foreach ( $parent as $parent_k => $parent_v ) {
					?>
                    <th class="vi-wad-attribute-filter-list-container">
						<?php
						echo esc_html( VI_WOO_ALIDROPSHIP_DATA::get_attribute_name_by_slug( $parent_v ) );
						$attribute_values = isset( $attributes[ $parent_k ]['values'] ) ? $attributes[ $parent_k ]['values'] : array();
						if ( count( $attribute_values ) ) {
							?>
                            <ul class="vi-wad-attribute-filter-list"
                                data-attribute_slug="<?php echo esc_attr( $parent_v ) ?>">
								<?php
								foreach ( $attribute_values as $attribute_value ) {
									?>
                                    <li class="vi-wad-attribute-filter-item"
                                        title="<?php esc_attr_e( $attribute_value ) ?>"
                                        data-attribute_slug="<?php echo esc_attr( $parent_v ) ?>"
                                        data-attribute_value="<?php echo esc_attr( trim( $attribute_value ) ) ?>"><?php echo esc_html( $attribute_value ) ?></li>
									<?php
								}
								?>
                            </ul>
							<?php
						}
						?>
                    </th>
					<?php
				}
			}
			?>
            <th><?php esc_html_e( 'Cost', 'woo-alidropship' ) ?></th>
            <th class="vi-wad-sale-price-col"><?php esc_html_e( 'Sale price', 'woo-alidropship' ) ?>
                <div
                        class="<?php echo esc_attr( self::set( 'set-price' ) ) ?>"
                        data-set_price="sale_price"><?php esc_html_e( 'Set price', 'woo-alidropship' ) ?></div>
            </th>
            <th class="vi-wad-regular-price-col"><?php esc_html_e( 'Regular price', 'woo-alidropship' ) ?>
                <div class="<?php echo esc_attr( self::set( 'set-price' ) ) ?>"
                     data-set_price="regular_price"><?php esc_html_e( 'Set price', 'woo-alidropship' ) ?></div>
            </th>
			<?php
			if ( $manage_stock ) {
				?>
                <th class="vi-wad-inventory-col"><?php esc_html_e( 'Inventory', 'woo-alidropship' ) ?></th>
				<?php
			}
			?>

        </tr>
        </thead>
        <tbody>
		<?php
		foreach ( $variations as $variation_key => $variation ) {
			$variation_image         = $variation['image'];
			$inventory               = intval( $variation['stock'] );
			$variation_sale_price    = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variation['sale_price']);
			$variation_regular_price = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variation['regular_price']);
			$price                   = $variation_sale_price ? $variation_sale_price : $variation_regular_price;
			$sale_price              = $this->settings->process_price( $price, true );
			$regular_price           = $this->settings->process_price( $price );
			$profit                  = $variation_sale_price ? ( $sale_price - $variation_sale_price ) : ( $regular_price - $variation_regular_price );
			$cost_html               = wc_price( $price, array(
				'currency'     => $currency,
				'decimals'     => 2,
				'price_format' => '%1$s&nbsp;%2$s'
			) );
			$profit_html             = wc_price( $profit, array(
				'currency'     => $currency,
				'decimals'     => 2,
				'price_format' => '%1$s&nbsp;%2$s'
			) );
			if ( $use_different_currency ) {
				$cost_html   .= '(' . wc_price( $this->settings->process_exchange_price( $price ) ) . ')';
				$profit_html .= '(' . wc_price( $this->settings->process_exchange_price( $profit ) ) . ')';
			}
			$sale_price    = $this->settings->process_exchange_price( $sale_price );
			$regular_price = $this->settings->process_exchange_price( $regular_price );
			$image_src     = $variation_image ? $variation_image : wc_placeholder_img_src();
			?>
            <tr class="<?php echo esc_attr( self::set( 'product-variation-row' ) ) ?>">
                <td><?php echo esc_html( $variation_key + 1 ) ?></td>
                <td>
                    <input type="checkbox" checked
                           class="<?php echo esc_attr( self::set( array(
						       'variation-enable',
						       'variation-enable-' . $key,
						       'variation-enable-' . $key . '-' . $variation_key
					       ) ) ) ?>">
                </td>
                <td>
                    <div class="<?php echo esc_attr( self::set( array(
						'variation-image',
						'selected-item'
					) ) ) ?>">
                        <span class="<?php echo esc_attr( self::set( 'selected-item-icon-check' ) ) ?>"></span>
                        <img style="width: 64px;height: 64px"
                             src="<?php echo esc_url( $lazy_load ? VI_WOO_ALIDROPSHIP_IMAGES . 'loading.gif' : $image_src ) ?>"
                             data-image_src="<?php echo esc_url( $image_src ) ?>"
                             class="<?php echo esc_attr( self::set( 'import-data-variation-image' ) ) ?>">
                        <input type="hidden"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][image]' ) ?>"
                               value="<?php echo esc_attr( $variation_image ? $variation_image : '' ) ?>">
                    </div>
                </td>
                <td><input type="radio"
                           class="<?php echo esc_attr( self::set( 'import-data-variation-default' ) ) ?>"
                           name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][vi_wad_variation_default]' ) ?>"
                           value="<?php echo esc_attr( $variation_key ) ?>">
                </td>
                <td>
                    <div>
                        <input type="text"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][sku]' ) ?>"
                               value="<?php echo esc_attr( $variation['sku'] ) ?>"
                               class="<?php echo esc_attr( self::set( 'import-data-variation-sku' ) ) ?>">
                        <input type="hidden"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][skuId]' ) ?>"
                               value="<?php echo esc_attr( $variation['skuId'] ) ?>">
                        <input type="hidden"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][skuAttr]' ) ?>"
                               value="<?php echo esc_attr( $variation['skuAttr'] ) ?>">
                    </div>
                </td>
				<?php
				if ( is_array( $parent ) && count( $parent ) ) {
					foreach ( $parent as $parent_k => $parent_v ) {
						?>
                        <td>
                            <input type="text" readonly
                                   data-attribute_slug="<?php echo esc_attr( $parent_v ) ?>"
                                   data-attribute_value="<?php echo esc_attr( isset( $variation['attributes'][ $parent_v ] ) ? trim( $variation['attributes'][ $parent_v ] ) : '' ) ?>"
                                   name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][attributes][' . $parent_v . ']' ) ?>"
                                   class="<?php echo esc_attr( self::set( 'import-data-variation-attribute' ) ) ?>"
                                   value="<?php echo esc_attr( isset( $variation['attributes'][ $parent_v ] ) ? $variation['attributes'][ $parent_v ] : '' ) ?>">
                        </td>
						<?php
					}
				}
				?>
                <td>
                    <div class="<?php echo esc_attr( self::set( 'price-field' ) ) ?>">
                                                                <span class="<?php echo esc_attr( self::set( 'import-data-variation-cost' ) ) ?>">
																	<?php echo $cost_html ?>
                                                                </span>
                    </div>
                </td>
                <td>
                    <div class="vi-ui left labeled input">
                        <label for="amount"
                               class="vi-ui label"><?php echo $woocommerce_currency_symbol ?></label>
                        <input type="number" min="0"
                               step="<?php echo esc_attr( $decimals ) ?>"
                               value="<?php echo esc_attr( $sale_price ) ?>"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][sale_price]' ) ?>"
                               class="<?php echo esc_attr( self::set( 'import-data-variation-sale-price' ) ) ?>">
                    </div>
                </td>
                <td>
                    <div class="vi-ui left labeled input">
                        <label for="amount"
                               class="vi-ui label"><?php echo $woocommerce_currency_symbol ?></label>
                        <input type="number" min="0"
                               step="<?php echo esc_attr( $decimals ) ?>"
                               value="<?php echo esc_attr( $regular_price ) ?>"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][regular_price]' ) ?>"
                               class="<?php echo esc_attr( self::set( 'import-data-variation-regular-price' ) ) ?>">
                    </div>
                </td>
				<?php
				if ( $manage_stock ) {
					?>
                    <td>
                        <input type="number" min="0"
                               step="<?php echo esc_attr( $decimals ) ?>"
                               value="<?php echo esc_attr( $inventory ) ?>"
                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][' . $variation_key . '][stock]' ) ?>"
                               class="<?php echo esc_attr( self::set( 'import-data-variation-inventory' ) ) ?>">
                    </td>
					<?php
				}
				?>

            </tr>
			<?php
		}
		?>
        </tbody>
		<?php
	}

	public function import_list_callback() {
		$user     = get_current_user_id();
		$screen   = get_current_screen();
		$option   = $screen->get_option( 'per_page', 'option' );
		$per_page = get_user_meta( $user, $option, true );
		$decimals = wc_get_price_decimals();
		if ( $decimals < 1 ) {
			$decimals = 1;
		} else {
			$decimals = pow( 10, ( - 1 * $decimals ) );
		}
		if ( empty ( $per_page ) || $per_page < 1 ) {
			$per_page = $screen->get_option( 'per_page', 'default' );
		}

		$paged = isset( $_GET['paged'] ) ? sanitize_text_field( $_GET['paged'] ) : 1;
		?>
        <div class="wrap">
            <h2><?php esc_html_e( 'Import List', 'woo-alidropship' ) ?></h2>
			<?php
			$args    = array(
				'post_type'      => 'vi_wad_draft_product',
				'post_status'    => array( 'draft', 'override' ),
				'order'          => 'DESC',
				'orderby'        => 'ID',
				'posts_per_page' => - 1,
			);
			$keyword = isset( $_GET['vi_wad_search'] ) ? sanitize_text_field( $_GET['vi_wad_search'] ) : '';
			if ( $keyword ) {
				$args['s'] = $keyword;
			}
			$the_query = new WP_Query( $args );
			$count     = $the_query->post_count;
			wp_reset_postdata();
			$args['posts_per_page'] = $per_page;
			$args['paged']          = $paged;
			$the_query              = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				ob_start();
				?>
                <form method="get">
                    <input type="hidden" name="page" value="woo-alidropship-import-list">
                    <div class="tablenav top">
                        <div class="<?php echo esc_attr( self::set( 'button-import-all-container' ) ) ?>">
                            <span class="vi-ui button primary <?php echo esc_attr( self::set( 'button-import-all' ) ) ?>"
                                  title="<?php esc_attr_e( 'Import all products on this page', 'woo-alidropship' ) ?>"><?php esc_html_e( 'Import All', 'woo-alidropship' ) ?></span>
                        </div>
                        <div class="tablenav-pages">
                            <div class="pagination-links">
								<?php
								$total_page = ceil( $count / $per_page );
								if ( $paged > 2 ) {
									?>
                                    <a class="prev-page button" href="<?php echo esc_url( add_query_arg(
										array(
											'page'          => 'woo-alidropship-import-list',
											'paged'         => 1,
											'vi_wad_search' => $keyword,
										), admin_url( 'admin.php' )
									) ) ?>"><span
                                                class="screen-reader-text"><?php esc_html_e( 'First Page', 'woo-alidropship' ) ?></span><span
                                                aria-hidden="true">«</span></a>
									<?php
								} else {
									?>
                                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
									<?php
								}
								/*Previous button*/
								if ( $per_page * $paged > $per_page ) {
									$p_paged = $paged - 1;
								} else {
									$p_paged = 0;
								}
								if ( $p_paged ) {
									$p_url = add_query_arg(
										array(
											'page'          => 'woo-alidropship-import-list',
											'paged'         => $p_paged,
											'vi_wad_search' => $keyword,
										), admin_url( 'admin.php' )
									);
									?>
                                    <a class="prev-page button" href="<?php echo esc_url( $p_url ) ?>"><span
                                                class="screen-reader-text"><?php esc_html_e( 'Previous Page', 'woo-alidropship' ) ?></span><span
                                                aria-hidden="true">‹</span></a>
									<?php
								} else {
									?>
                                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
									<?php
								}
								?>
                                <span class="screen-reader-text"><?php esc_html_e( 'Current Page', 'woo-alidropship' ) ?></span>
                                <span id="table-paging" class="paging-input">
                                    <input class="current-page" type="text" name="paged" size="1"
                                           value="<?php echo esc_html( $paged ) ?>"><span class="tablenav-paging-text"> of <span
                                                class="total-pages"><?php echo esc_html( $total_page ) ?></span></span>

							</span>
								<?php /*Next button*/
								if ( $per_page * $paged < $count ) {
									$n_paged = $paged + 1;
								} else {
									$n_paged = 0;
								}
								if ( $n_paged ) {
									$n_url = add_query_arg(
										array(
											'page'          => 'woo-alidropship-import-list',
											'paged'         => $n_paged,
											'vi_wad_search' => $keyword,
										), admin_url( 'admin.php' )
									); ?>
                                    <a class="next-page button" href="<?php echo esc_url( $n_url ) ?>"><span
                                                class="screen-reader-text"><?php esc_html_e( 'Next Page', 'woo-alidropship' ) ?></span><span
                                                aria-hidden="true">›</span></a>
									<?php
								} else {
									?>
                                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
									<?php
								}
								if ( $total_page > $paged + 1 ) {
									?>
                                    <a class="next-page button" href="<?php echo esc_url( add_query_arg(
										array(
											'page'          => 'woo-alidropship-import-list',
											'paged'         => $total_page,
											'vi_wad_search' => $keyword,
										), admin_url( 'admin.php' )
									) ) ?>"><span
                                                class="screen-reader-text"><?php esc_html_e( 'Last Page', 'woo-alidropship' ) ?></span><span
                                                aria-hidden="true">»</span></a>
									<?php
								} else {
									?>
                                    <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
									<?php
								}
								?>
                            </div>
                        </div>
                        <p class="search-box">
                            <input type="text" class="text short" name="vi_wad_search"
                                   placeholder="<?php esc_attr_e( 'Search product in import list', 'woo-alidropship' ) ?>"
                                   value="<?php echo esc_attr( $keyword ) ?>">
                            <input type="submit" name="submit" class="button"
                                   value="<?php echo esc_attr( 'Search product', 'woo-alidropship' ) ?>">
                        </p>
                    </div>
                </form>
				<?php
				$pagination_html = ob_get_clean();
				echo $pagination_html;
				$key                         = 0;
				$currency                    = 'USD';
				$woocommerce_currency        = get_woocommerce_currency();
				$woocommerce_currency_symbol = get_woocommerce_currency_symbol();
				$default_select_image        = $this->get_params( 'product_gallery' );
				$manage_stock                = $this->get_params( 'manage_stock' );
				$use_different_currency      = false;
				if ( strtolower( $woocommerce_currency ) != strtolower( $currency ) ) {
					$use_different_currency = true;
				}
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$product_id  = get_the_ID();
					$product     = get_post( $product_id );
					$title       = $product->post_title;
					$description = $product->post_content;
					$sku         = get_post_meta( $product_id, '_vi_wad_sku', true );
					$attributes  = get_post_meta( $product_id, '_vi_wad_attributes', true );
					$store_info  = get_post_meta( $product_id, '_vi_wad_store_info', true );
					$parent      = array();
					if ( is_array( $attributes ) && count( $attributes ) ) {
						foreach ( $attributes as $attribute_k => $attribute_v ) {
							$parent[ $attribute_k ] = $attribute_v['slug'];
						}
					}
					$gallery = get_post_meta( $product_id, '_vi_wad_gallery', true );
					if ( ! $gallery ) {
						$gallery = array();
					}
					$desc_images = get_post_meta( $product_id, '_vi_wad_description_images', true );
					if ( ! $desc_images ) {
						$desc_images = array();
					}
					$image               = isset( $gallery[0] ) ? $gallery[0] : '';
					$variations          = get_post_meta( $product_id, '_vi_wad_variations', true );
					$is_variable         = ( is_array( $parent ) && count( $parent ) ) ? 1 : 0;
					$product_type        = $product->post_status;
					$override_product_id = $product->post_parent;
					$aff_url             = get_post_meta( $product_id, '_vi_wad_aff_url', true );
					?>
                    <div class="vi-ui styled fluid accordion active <?php echo esc_attr( self::set( 'accordion' ) ) ?>"
                         id="<?php echo esc_attr( self::set( 'product-item-id-' . $product_id ) ) ?>">
                        <div class="title active">
                            <i class="dropdown icon <?php echo esc_attr( self::set( 'accordion-title-icon' ) ); ?>"></i>
                            <div class="<?php echo esc_attr( self::set( 'accordion-product-image-title-container' ) ) ?>">
                                <div class="<?php echo esc_attr( self::set( 'accordion-product-image-title' ) ) ?>">
                                    <img src="<?php echo esc_url( $image ? $image : wc_placeholder_img_src() ) ?>"
                                         class="<?php echo esc_attr( self::set( 'accordion-product-image' ) ) ?>">
                                    <div class="<?php echo esc_attr( self::set( 'accordion-product-title-container' ) ) ?>">
                                        <div class="<?php echo esc_attr( self::set( 'accordion-product-title' ) ) ?>"
                                             title="<?php esc_attr_e( $title ) ?>"><?php echo esc_html( $title ) ?></div>
										<?php
										if ( ! empty( $store_info['name'] ) ) {
											$store_name = $store_info['name'];
											if ( ! empty( $store_info['url'] ) ) {
												$store_name = '<a class="' . esc_attr__( self::set( 'accordion-store-url' ) ) . '" href="' . esc_attr__( $store_info['url'] ) . '" target="_blank">' . $store_name . '</a>';
											}
											?>
                                            <div>
												<?php
												esc_html_e( 'Store: ', 'woo-alidropship' );
												echo $store_name;
												?>
                                            </div>
											<?php
										}
										?>
                                    </div>
                                </div>
                            </div>
                            <div class="<?php echo esc_attr( self::set( 'button-view-and-edit' ) ) ?>">
                                <a href="<?php echo $aff_url ? esc_attr( "https://www.aliexpress.com?aliProduct=" . base64_encode( $aff_url ) ) : esc_attr( "https://www.aliexpress.com/item/{$sku}.html" ); ?>"
                                   target="_blank" class="vi-ui button" rel="nofollow"
                                   title="<?php esc_attr_e( 'View this product on AliExpress.com', 'woo-alidropship' ) ?>">
									<?php esc_html_e( 'View on AliExpress', 'woo-alidropship' ) ?></a>
                                <span class="vi-ui button negative <?php echo esc_attr( self::set( 'button-remove' ) ) ?>"
                                      data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                      title="<?php esc_attr_e( 'Remove this product from import list', 'woo-alidropship' ) ?>"><?php esc_html_e( 'Remove', 'woo-alidropship' ) ?></span>
								<?php
								if ( $product_type == 'override' && $override_product_id ) {
									?>
                                    <span class="vi-ui button positive <?php echo esc_attr( self::set( 'button-override' ) ) ?>"
                                          data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                          data-override_product_id="<?php esc_attr_e( $override_product_id ) ?>"><?php esc_html_e( 'Import & Override', 'woo-alidropship' ) ?></span>
									<?php
								} else {
									?>
                                    <span class="vi-ui button positive <?php echo esc_attr( self::set( 'button-import' ) ) ?>"
                                          data-product_id="<?php echo esc_attr( $product_id ) ?>"
                                          title="<?php esc_attr_e( 'Import this product to your WooComemrce store', 'woo-alidropship' ) ?>"><?php esc_html_e( 'Import Now', 'woo-alidropship' ) ?></span>
									<?php
								}
								?>
                            </div>
                        </div>
                        <div class="content active">
							<?php
							if ( $product_type == 'override' && $override_product_id ) {
								?>
                                <div class="vi-ui message <?php echo esc_attr( self::set( 'override-product-message' ) ) ?>"><?php esc_html_e( 'This product will override: ', 'woo-alidropship' ) ?>
                                    <strong class="<?php echo esc_attr( self::set( 'override-product-product-title' ) ) ?>"><?php echo esc_html( get_the_title( $override_product_id ) ) ?></strong>
                                </div>
								<?php
							}
							?>
                            <div class="<?php echo esc_attr( self::set( 'message' ) ) ?>">
                            </div>
                            <form class="vi-ui form <?php echo esc_attr( self::set( 'product-container' ) ) ?>"
                                  method="post">
                                <div class="vi-ui attached tabular menu">
                                    <div class="item active" data-tab="<?php echo esc_attr( 'product-' . $key ) ?>">
										<?php esc_html_e( 'Product', 'woo-alidropship' ) ?>
                                    </div>
                                    <div class="item" data-tab="<?php echo esc_attr( 'description-' . $key ) ?>">
										<?php esc_html_e( 'Description', 'woo-alidropship' ) ?>
                                    </div>
									<?php
									if ( $is_variable ) {
										?>
                                        <div class="item <?php echo esc_attr( self::set( 'lazy-load' ) ) ?>"
                                             data-tab="<?php echo esc_attr( 'variations-' . $key ) ?>">
											<?php printf( __( 'Variations(%s)', 'woo-alidropship' ), '<span class="' . self::set( 'selected-variation-count' ) . '">' . count( $variations ) . '</span>', 'woo-alidropship' ) ?>
                                        </div>
										<?php
									}
									if ( count( $gallery ) ) {
										$gallery_count = $default_select_image ? count( $gallery ) : 0;
										?>
                                        <div class="item <?php echo esc_attr( self::set( 'lazy-load' ) ) ?>"
                                             data-tab="<?php echo esc_attr( 'gallery-' . $key ) ?>">
											<?php printf( __( 'Gallery(%s)', 'woo-alidropship' ), '<span class="' . self::set( 'selected-gallery-count' ) . '">' . $gallery_count . '</span>', 'woo-alidropship' ) ?>
                                        </div>
										<?php
									}
									?>
                                </div>
                                <div class="vi-ui bottom attached tab segment active"
                                     data-tab="<?php echo esc_attr( 'product-' . $key ) ?>">
                                    <div class="field">
                                        <div class="fields">
                                            <div class="three wide field">
                                                <div class="<?php echo esc_attr( self::set( 'product-image' ) ) ?> <?php if ( $default_select_image )
													esc_attr_e( self::set( 'selected-item' ) ) ?> ">
                                                    <span class="<?php echo esc_attr( self::set( 'selected-item-icon-check' ) ) ?>"></span>
													<?php
													if ( $image ) {
														?>
                                                        <img style="width: 100%"
                                                             src="<?php echo esc_url( $image ) ?>"
                                                             class="<?php echo esc_attr( self::set( 'import-data-image' ) ) ?>">
                                                        <input type="hidden"
                                                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][image]' ) ?>"
                                                               value="<?php echo esc_attr( $default_select_image ? $image : '' ) ?>">
														<?php
													} else {
														?>
                                                        <img style="width: 100%"
                                                             src="<?php echo esc_url( wc_placeholder_img_src() ) ?>"
                                                             class="<?php echo esc_attr( self::set( 'import-data-image' ) ) ?>">
                                                        <input type="hidden"
                                                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][image]' ) ?>"
                                                               value="">
														<?php
													}
													?>

                                                </div>
                                            </div>
                                            <div class="thirteen wide field">
                                                <div class="field">
                                                    <label><?php esc_html_e( 'Product title', 'woo-alidropship' ) ?></label>
                                                    <input type="text" value="<?php echo esc_attr( $title ) ?>"
                                                           name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][title]' ) ?>"
                                                           class="<?php echo esc_attr( self::set( 'import-data-title' ) ) ?>">
                                                </div>
                                                <div class="field">
                                                    <div class="equal width fields">
                                                        <div class="field">
                                                            <label><?php esc_html_e( 'Sku', 'woo-alidropship' ) ?></label>
                                                            <input type="text" value="<?php echo esc_attr( $sku ) ?>"
                                                                   name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][sku]' ) ?>"
                                                                   class="<?php echo esc_attr( self::set( 'import-data-sku' ) ) ?>">
                                                        </div>
                                                        <div class="field">
                                                            <label><?php esc_html_e( 'Product status', 'woo-alidropship' ) ?></label>
                                                            <select
                                                                    name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][status]' ) ?>"
                                                                    class="<?php echo esc_attr( self::set( 'import-data-status' ) ) ?> vi-ui fluid dropdown">
                                                                <option value="publish" <?php selected( $this->get_params( 'product_status' ), 'publish' ) ?>><?php esc_html_e( 'Publish', 'woo-alidropship' ) ?></option>
                                                                <option value="pending" <?php selected( $this->get_params( 'product_status' ), 'pending' ) ?>><?php esc_html_e( 'Pending', 'woo-alidropship' ) ?></option>
                                                                <option value="draft" <?php selected( $this->get_params( 'product_status' ), 'draft' ) ?>><?php esc_html_e( 'Draft', 'woo-alidropship' ) ?></option>
                                                            </select>

                                                        </div>
                                                        <div class="field">
                                                            <label><?php esc_html_e( 'Catalog visibility', 'woo-alidropship' ) ?></label>
                                                            <select
                                                                    name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][catalog_visibility]' ) ?>"
                                                                    class="<?php echo esc_attr( self::set( 'import-data-catalog-visibility' ) ) ?> vi-ui fluid dropdown">
                                                                <option value="visible" <?php selected( $this->get_params( 'catalog_visibility' ), 'visible' ) ?>><?php esc_html_e( 'Shop and search results', 'woo-alidropship' ) ?></option>
                                                                <option value="catalog" <?php selected( $this->get_params( 'catalog_visibility' ), 'catalog' ) ?>><?php esc_html_e( 'Shop only', 'woo-alidropship' ) ?></option>
                                                                <option value="search" <?php selected( $this->get_params( 'catalog_visibility' ), 'search' ) ?>><?php esc_html_e( 'Search results only', 'woo-alidropship' ) ?></option>
                                                                <option value="hidden" <?php selected( $this->get_params( 'catalog_visibility' ), 'hidden' ) ?>><?php esc_html_e( 'Hidden', 'woo-alidropship' ) ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
												<?php
												if ( ! $is_variable ) {
													$inventory               = intval( $variations[0]['stock'] );
													$variation_sale_price    = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variations[0]['sale_price']);
													$variation_regular_price = VI_WOO_ALIDROPSHIP_DATA::string_to_float($variations[0]['regular_price']);
													$price                   = $variation_sale_price ? $variation_sale_price : $variation_regular_price;
													$sale_price              = $this->settings->process_price( $price, true );
													$regular_price           = $this->settings->process_price( $price );
													$profit                  = $variation_sale_price ? ( $sale_price - $variation_sale_price ) : ( $regular_price - $variation_regular_price );
													$cost_html               = wc_price( $price, array(
														'currency'     => $currency,
														'decimals'     => 2,
														'price_format' => '%1$s&nbsp;%2$s'
													) );
													$profit_html             = wc_price( $profit, array(
														'currency'     => $currency,
														'decimals'     => 2,
														'price_format' => '%1$s&nbsp;%2$s'
													) );
													if ( $use_different_currency ) {
														$cost_html   .= '(' . wc_price( $this->settings->process_exchange_price( $price ) ) . ')';
														$profit_html .= '(' . wc_price( $this->settings->process_exchange_price( $profit ) ) . ')';
													}
													$sale_price    = $this->settings->process_exchange_price( $sale_price );
													$regular_price = $this->settings->process_exchange_price( $regular_price );
													?>
                                                    <input type="hidden"
                                                           name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][0][skuId]' ) ?>"
                                                           value="<?php echo esc_attr( $variations[0]['skuId'] ) ?>">
                                                    <div class="field">
                                                        <div class="equal width fields">
                                                            <div class="field">
                                                                <label><?php esc_html_e( 'Cost', 'woo-alidropship' ) ?></label>
                                                                <div class="<?php echo esc_attr( self::set( 'price-field' ) ) ?>">
																	<?php echo $cost_html ?>
                                                                </div>
                                                            </div>
															<?php
															/*
															?>
															<div class="field">
																<label><?php esc_html_e( "Profit", 'woo-alidropship' ) ?></label>
																<div class="<?php echo esc_attr( self::set( 'price-field' ) ) ?>">
																	<?php echo $profit_html ?>
																</div>
															</div>
															<?php
															*/
															?>
                                                            <div class="field">
                                                                <label><?php esc_html_e( 'Sale price', 'woo-alidropship' ) ?></label>
                                                                <div class="vi-ui left labeled input">
                                                                    <label for="amount"
                                                                           class="vi-ui label"><?php echo $woocommerce_currency_symbol ?></label>
                                                                    <input
                                                                            type="number" min="0"
                                                                            step="<?php echo esc_attr( $decimals ) ?>"
                                                                            value="<?php echo esc_attr( $sale_price ) ?>"
                                                                            name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][0][sale_price]' ) ?>"
                                                                            class="<?php echo esc_attr( self::set( 'import-data-variation-sale-price' ) ) ?>">
                                                                </div>
                                                            </div>
                                                            <div class="field">
                                                                <label><?php esc_html_e( 'Regular price', 'woo-alidropship' ) ?></label>
                                                                <div class="vi-ui left labeled input">
                                                                    <label for="amount"
                                                                           class="vi-ui label"><?php echo $woocommerce_currency_symbol ?></label>
                                                                    <input type="number" min="0"
                                                                           step="<?php echo esc_attr( $decimals ) ?>"
                                                                           value="<?php echo esc_attr( $regular_price ) ?>"
                                                                           name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][0][regular_price]' ) ?>"
                                                                           class="<?php echo esc_attr( self::set( 'import-data-variation-regular-price' ) ) ?>">
                                                                </div>
                                                            </div>
															<?php
															if ( $manage_stock ) {
																?>
                                                                <div class="field">
                                                                    <label><?php esc_html_e( 'Inventory', 'woo-alidropship' ) ?></label>
                                                                    <input
                                                                            type="number" min="0"
                                                                            step="<?php echo esc_attr( $decimals ) ?>"
                                                                            value="<?php echo esc_attr( $inventory ) ?>"
                                                                            name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][variations][0][stock]' ) ?>"
                                                                            class="<?php echo esc_attr( self::set( 'import-data-variation-inventory' ) ) ?>">
                                                                </div>
																<?php
															}
															?>

                                                        </div>
                                                    </div>
													<?php
												}
												?>
                                                <div class="field">
                                                    <div class="equal width fields">
                                                        <div class="field">
                                                            <label><?php esc_html_e( 'Categories', 'woo-alidropship' ) ?></label>
                                                            <select name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][categories][]' ) ?>"
                                                                    class="<?php echo esc_attr( self::set( 'import-data-categories' ) ) ?> search-category"
                                                                    multiple="multiple">
																<?php
																$categories = $this->get_params( 'product_categories' );
																if ( is_array( $categories ) && count( $categories ) ) {
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
                                                        </div>
                                                        <div class="field">
                                                            <label><?php esc_html_e( 'Tags', 'woo-alidropship' ) ?></label>
                                                            <select name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][tags][]' ) ?>"
                                                                    class="<?php echo esc_attr( self::set( 'import-data-tags' ) ) ?> search-tags"
                                                                    multiple="multiple">
																<?php
																$product_tags = $this->get_params( 'product_tags' );
																if ( is_array( $product_tags ) && count( $product_tags ) ) {
																	foreach ( $product_tags as $product_tag_id ) {
																		?>
                                                                        <option value="<?php echo $product_tag_id ?>"
                                                                                selected><?php echo $product_tag_id; ?></option>
																		<?php
																	}
																}
																?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="vi-ui bottom attached tab segment"
                                     data-tab="<?php echo esc_attr( 'description-' . $key ) ?>">
									<?php
									wp_editor( $description, self::set( 'product-description-' ) . $product_id, array(
										'media_buttons' => false,
										'editor_class'  => esc_attr__( self::set( 'import-data-description' ) ),
										'textarea_name' => esc_attr__( 'vi_wad_product[' . $product_id . '][description]' ),
									) );
									?>
                                </div>
								<?php
								if ( $is_variable ) {
									?>
                                    <div class="vi-ui bottom attached tab segment <?php echo esc_attr( self::set( array(
										'variations-tab',
										'lazy-load-tab-data'
									) ) ) ?>"
                                         data-tab="<?php echo esc_attr( 'variations-' . $key ) ?>">
										<?php

										if ( count( $variations ) ) {
											?>
                                            <div class="vi-ui blue message">
                                                <div class="header">
													<?php
													$first_attribute = array_values( $attributes )[0];
													if ( ! empty( $first_attribute['values_sub'] ) ) {
														?>
                                                        <p><?php _e( 'Have problems with product attributes values? Try <span class="vi-ui button yellow tiny ' . self::set( 'switch-product-attributes-values' ) . '" data-product_index="' . $key . '" data-product_id="' . $product_id . '">Switch Attributes</span>' ) ?></p>
														<?php
													} else {
														?>
                                                        <p><?php _e( 'If you have any problems with attributes values of this product, please remove this product and import it again with the latest version of this plugin and Chrome Extension.' ) ?></p>
														<?php
													}
													?>
                                                </div>
                                            </div>

                                            <table class="form-table vi-wad-table-fix-head">
												<?php
												$this->variation_html( $key, $parent, $attributes, $manage_stock, $variations, $use_different_currency, $currency, $product_id, $woocommerce_currency_symbol, $decimals );
												?>
                                            </table>
											<?php
										}
										?>
                                    </div>
									<?php
								}
								$gallery = array_merge( $gallery, $desc_images );
								if ( count( $gallery ) ) {
									?>
                                    <div class="vi-ui bottom attached tab segment <?php echo esc_attr( self::set( array(
										'product-gallery',
										'lazy-load-tab-data'
									) ) ) ?>"
                                         data-tab="<?php echo esc_attr( 'gallery-' . $key ) ?>">
                                        <div class="segment ui-sortable ">
											<?php
											if ( $default_select_image ) {
												foreach ( $gallery as $gallery_k => $gallery_v ) {
													if ( ! in_array( $gallery_v, $desc_images ) ) {
														$item_class = array(
															'product-gallery-item',
															'selected-item'
														);
														if ( $gallery_k === 0 ) {
															$item_class[] = 'is-product-image';
														}
														?>
                                                        <div class="<?php echo esc_attr( self::set( $item_class ) ) ?>">
                                                            <span class="<?php echo esc_attr( self::set( 'selected-item-icon-check' ) ) ?>"></span>
                                                            <i class="<?php echo esc_attr( self::set( 'set-product-image' ) ) ?> star icon"></i>
                                                            <img src="<?php echo esc_url( VI_WOO_ALIDROPSHIP_IMAGES . 'loading.gif' ) ?>"
                                                                 data-image_src="<?php echo esc_url( $gallery_v ) ?>"
                                                                 class="<?php echo esc_attr( self::set( 'product-gallery-image' ) ) ?>">
                                                            <input type="hidden"
                                                                   name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][gallery][]' ) ?>"
                                                                   value="<?php echo esc_attr( $gallery_v ) ?>">
                                                        </div>
														<?php
													} else {
														?>
                                                        <div class="<?php echo esc_attr( self::set( 'product-gallery-item' ) ) ?>">
                                                            <span class="<?php echo esc_attr( self::set( 'selected-item-icon-check' ) ) ?>"></span>
                                                            <i class="<?php echo esc_attr( self::set( 'set-product-image' ) ) ?> star icon"></i>
                                                            <img src="<?php echo esc_url( VI_WOO_ALIDROPSHIP_IMAGES . 'loading.gif' ) ?>"
                                                                 data-image_src="<?php echo esc_url( $gallery_v ) ?>"
                                                                 class="<?php echo esc_attr( self::set( 'product-gallery-image' ) ) ?>">
                                                            <input type="hidden"
                                                                   name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][gallery][]' ) ?>"
                                                                   value="">
                                                        </div>
														<?php
													}
												}
											} else {
												foreach ( $gallery as $gallery_k => $gallery_v ) {
													?>
                                                    <div class="<?php echo esc_attr( self::set( 'product-gallery-item' ) ) ?>">
                                                        <span class="<?php echo esc_attr( self::set( 'selected-item-icon-check' ) ) ?>"></span>
                                                        <i class="<?php echo esc_attr( self::set( 'set-product-image' ) ) ?> star icon"></i>
                                                        <img src="<?php echo esc_url( $gallery_v ) ?>"
                                                             class="<?php echo esc_attr( self::set( 'product-gallery-image' ) ) ?>">
                                                        <input type="hidden"
                                                               name="<?php echo esc_attr( 'vi_wad_product[' . $product_id . '][gallery][]' ) ?>"
                                                               value="">
                                                    </div>
													<?php
												}
											}
											?>
                                        </div>
                                    </div>
									<?php
								}
								?>
                            </form>
                        </div>
                        <div class="<?php echo esc_attr( self::set( array(
							'product-overlay',
							'hidden'
						) ) ) ?>"></div>
                    </div>
					<?php
					$key ++;
				}

				echo $pagination_html;
			} else {
				?>
                <form method="get">
                    <input type="hidden" name="page" value="woo-alidropship-import-list">
                    <input type="text" class="text short" name="vi_wad_search"
                           placeholder="<?php esc_attr_e( 'Search product', 'woo-alidropship' ) ?>"
                           value="<?php echo esc_attr( $keyword ) ?>">
                    <input type="submit" name="submit" class="button"
                           value="<?php echo esc_attr( 'Search product', 'woo-alidropship' ) ?>">
                    <p>
						<?php esc_html_e( 'No products found', 'woo-alidropship' ) ?>
                    </p>
                </form>
				<?php
			}
			wp_reset_postdata();
			?>
        </div>
		<?php
	}

	public function delete_product_options() {
		?>
        <div class="<?php echo esc_attr( self::set( array(
			'delete-product-options-container',
			'hidden'
		) ) ) ?>">
            <div class="<?php echo esc_attr( self::set( 'overlay' ) ) ?>"></div>
            <div class="<?php echo esc_attr( self::set( 'delete-product-options-content' ) ) ?>">
                <div class="<?php echo esc_attr( self::set( 'delete-product-options-content-header' ) ) ?>">
                    <h2 class="<?php echo esc_attr( self::set( array(
						'delete-product-options-content-header-delete',
						'hidden'
					) ) ) ?>"><?php esc_html_e( 'Delete: ', 'woo-alidropship' ) ?><span
                                class="<?php echo esc_attr( self::set( 'delete-product-options-product-title' ) ) ?>"></span>
                    </h2>
                    <span class="<?php echo esc_attr( self::set( 'delete-product-options-close' ) ) ?>"></span>
                    <h2 class="<?php echo esc_attr( self::set( array(
						'delete-product-options-content-header-override',
						'hidden'
					) ) ) ?>"><?php esc_html_e( 'Override: ', 'woo-alidropship' ) ?><span
                                class="<?php echo esc_attr( self::set( 'delete-product-options-product-title' ) ) ?>"></span>
                    </h2>
                </div>
                <div class="<?php echo esc_attr( self::set( 'delete-product-options-content-body' ) ) ?>">
                    <div class="<?php echo esc_attr( self::set( 'delete-product-options-content-body-row' ) ) ?>">
                        <div class="<?php echo esc_attr( self::set( array(
							'delete-product-options-delete-woo-product-wrap',
							'hidden'
						) ) ) ?>">
                            <input type="checkbox"
                                   id="<?php echo esc_attr( self::set( 'delete-product-options-delete-woo-product' ) ) ?>"
                                   class="<?php echo esc_attr( self::set( 'delete-product-options-delete-woo-product' ) ) ?>">
                            <label for="<?php echo esc_attr( self::set( 'delete-product-options-delete-woo-product' ) ) ?>"><?php esc_html_e( 'Also delete product from your WooCommerce store.', 'woo-alidropship' ) ?></label>
                        </div>
                        <div class="<?php echo esc_attr( self::set( array(
							'delete-product-options-override-product-wrap',
							'hidden'
						) ) ) ?>">
                            <label for="<?php echo esc_attr( self::set( 'delete-product-options-override-product' ) ) ?>"><?php esc_html_e( 'Product URL: ', 'woo-alidropship' ) ?></label>
                            <input type="text"
                                   id="<?php echo esc_attr( self::set( 'delete-product-options-override-product' ) ) ?>"
                                   class="<?php echo esc_attr( self::set( 'delete-product-options-override-product' ) ) ?>">
                            <div class="<?php echo esc_attr( self::set( array(
								'delete-product-options-override-product-new-wrap',
								'hidden'
							) ) ) ?>">
                                <span class="<?php echo esc_attr( self::set( 'delete-product-options-override-product-new-close' ) ) ?>"></span>
                                <div class="<?php echo esc_attr( self::set( 'delete-product-options-override-product-new-image' ) ) ?>">
                                    <img src="<?php echo esc_url( VI_WOO_ALIDROPSHIP_IMAGES . 'loading.gif' ) ?>">
                                </div>
                                <div class="<?php echo esc_attr( self::set( 'delete-product-options-override-product-new-title' ) ) ?>"></div>
                            </div>
                        </div>
                        <div class="<?php echo esc_attr( self::set( 'delete-product-options-override-product-message' ) ) ?>"></div>
                    </div>
                </div>
                <div class="<?php echo esc_attr( self::set( 'delete-product-options-content-footer' ) ) ?>">
                    <span class="vi-ui button positive <?php echo esc_attr( self::set( array(
	                    'delete-product-options-button-override',
	                    'hidden'
                    ) ) ) ?>"
                          data-product_id="" data-woo_product_id="">
                            <?php esc_html_e( 'Check', 'woo-alidropship' ) ?>
                        </span>
                    <span class="vi-ui button negative <?php echo esc_attr( self::set( array(
						'delete-product-options-button-delete',
						'hidden'
					) ) ) ?>"
                          data-product_id="" data-woo_product_id="">
                            <?php esc_html_e( 'Delete', 'woo-alidropship' ) ?>
                        </span>
                    <span class="vi-ui button <?php echo esc_attr( self::set( 'delete-product-options-button-cancel' ) ) ?>">
                            <?php esc_html_e( 'Cancel', 'woo-alidropship' ) ?>
                        </span>
                </div>
            </div>
            <div class="<?php echo esc_attr( self::set( 'saving-overlay' ) ) ?>"></div>
        </div>
		<?php
	}

	public function admin_footer() {
		?>
        <div class="<?php echo esc_attr( self::set( array( 'set-price-container', 'hidden' ) ) ) ?>">
            <div class="<?php echo esc_attr( self::set( 'overlay' ) ) ?>"></div>
            <div class="<?php echo esc_attr( self::set( 'set-price-content' ) ) ?>">
                <div class="<?php echo esc_attr( self::set( 'set-price-content-header' ) ) ?>">
                    <h2><?php esc_html_e( 'Set price', 'woo-alidropship' ) ?></h2>
                    <span class="<?php echo esc_attr( self::set( 'set-price-close' ) ) ?>"></span>
                </div>
                <div class="<?php echo esc_attr( self::set( 'set-price-content-body' ) ) ?>">
                    <div class="<?php echo esc_attr( self::set( 'set-price-content-body-row' ) ) ?>">
                        <div class="<?php echo esc_attr( self::set( 'set-price-action-wrap' ) ) ?>">
                            <label for="<?php echo esc_attr( self::set( 'set-price-action' ) ) ?>"><?php esc_html_e( 'Action', 'woo-alidropship' ) ?></label>
                            <select id="<?php echo esc_attr( self::set( 'set-price-action' ) ) ?>"
                                    class="<?php echo esc_attr( self::set( 'set-price-action' ) ) ?>">
                                <option value="set_new_value"><?php esc_html_e( 'Set to this value', 'woo-alidropship' ) ?></option>
                                <option value="increase_by_fixed_value"><?php esc_html_e( 'Increase by fixed value(' . get_woocommerce_currency_symbol() . ')', 'woo-alidropship' ) ?></option>
                                <option value="increase_by_percentage"><?php esc_html_e( 'Increase by percentage(%)', 'woo-alidropship' ) ?></option>
                            </select>
                        </div>
                        <div class="<?php echo esc_attr( self::set( 'set-price-amount-wrap' ) ) ?>">
                            <label for="<?php echo esc_attr( self::set( 'set-price-amount' ) ) ?>"><?php esc_html_e( 'Amount', 'woo-alidropship' ) ?></label>
                            <input type="text"
                                   id="<?php echo esc_attr( self::set( 'set-price-amount' ) ) ?>"
                                   class="<?php echo esc_attr( self::set( 'set-price-amount' ) ) ?>">
                        </div>
                    </div>
                </div>
                <div class="<?php echo esc_attr( self::set( 'set-price-content-footer' ) ) ?>">
                        <span class="button button-primary <?php echo esc_attr( self::set( 'set-price-button-set' ) ) ?>">
                            <?php esc_html_e( 'Set', 'woo-alidropship' ) ?>
                        </span>
                    <span class="button <?php echo esc_attr( self::set( 'set-price-button-cancel' ) ) ?>">
                            <?php esc_html_e( 'Cancel', 'woo-alidropship' ) ?>
                        </span>
                </div>
            </div>
            <div class="<?php echo esc_attr( self::set( 'saving-overlay' ) ) ?>"></div>
        </div>
		<?php
	}

	public function override_product_options() {
		$all_options = array(
			'replace-title'       => esc_html__( 'Replace product title', 'woo-alidropship' ),
			'replace-images'      => esc_html__( 'Replace product image and gallery', 'woo-alidropship' ),
			'replace-description' => esc_html__( 'Replace description and short description', 'woo-alidropship' ),
		);
		?>
        <div class="<?php echo esc_attr( self::set( array(
			'override-product-options-container',
			'hidden'
		) ) ) ?>">
            <div class="<?php echo esc_attr( self::set( 'override-product-overlay' ) ) ?>"></div>
            <div class="<?php echo esc_attr( self::set( 'override-product-options-content' ) ) ?>">
                <div class="<?php echo esc_attr( self::set( 'override-product-options-content-header' ) ) ?>">
                    <h2><?php esc_html_e( 'Override: ', 'woo-alidropship' ) ?><span
                                class="<?php echo esc_attr( self::set( 'override-product-title' ) ) ?>"></span>
                    </h2>
                    <span class="<?php echo esc_attr( self::set( 'override-product-options-close' ) ) ?>"></span>
                </div>
                <div class="<?php echo esc_attr( self::set( array(
					'override-product-options-content-body',
					'override-product-options-content-body-option'
				) ) ) ?>">
					<?php
					foreach ( $all_options as $option_key => $option_value ) {
						?>
                        <div class="<?php echo esc_attr( self::set( 'override-product-options-content-body-row' ) ) ?>">
                            <div class="<?php echo esc_attr( self::set( 'override-product-options-option-wrap' ) ) ?>">
                                <input type="checkbox" value="1"
                                       data-order_option="<?php echo esc_attr( $option_key ) ?>"
                                       id="<?php echo esc_attr( self::set( 'override-product-options-' . $option_key ) ) ?>"
                                       class="<?php echo esc_attr( self::set( array(
									       'override-product-options-option',
									       'override-product-options-' . $option_key
								       ) ) ) ?>">
                                <label for="<?php echo esc_attr( self::set( 'override-product-options-' . $option_key ) ) ?>"><?php echo $option_value ?></label>
                            </div>
                        </div>
						<?php
					}
					?>
                </div>
                <div class="<?php echo esc_attr( self::set( array(
					'override-product-options-content-body',
					'override-product-options-content-body-replace-old'
				) ) ) ?>">
                </div>
                <div class="<?php echo esc_attr( self::set( 'override-product-options-content-footer' ) ) ?>">
                    <span class="vi-ui button positive <?php echo esc_attr( self::set( array(
	                    'override-product-options-button-override',
                    ) ) ) ?>" data-override_product_id="">
                            <?php esc_html_e( 'Override', 'woo-alidropship' ) ?>
                        </span>
                    <span class="vi-ui button <?php echo esc_attr( self::set( array(
						'override-product-options-button-cancel',
					) ) ) ?>">
                            <?php esc_html_e( 'Cancel', 'woo-alidropship' ) ?>
                        </span>
                </div>
            </div>
            <div class="<?php echo esc_attr( self::set( 'override-product-overlay' ) ) ?>"></div>
        </div>
		<?php
	}


	public function link_to_imported_page( $post ) {
		if ( $post->post_type == 'product' && get_post_meta( $post->ID, '_vi_wad_aliexpress_product_id', true ) ) {
			$href = admin_url( "admin.php?page=woo-alidropship-imported-list&post_status=publish&vi_wad_search={$post->post_title}&submit=Search+product" );
			$link = "<a href='{$href}' target='_blank' class='button button-primary' style='margin-top:10px '>" . __( 'Edit in Imported page', 'woo-alidropship' ) . "</a>";
			?>
            <script type="text/javascript">
                'use strict';
                jQuery(document).ready(function ($) {
                    let html = `<?php echo $link?>`;
                    $('.wp-header-end').before(html);
                });
            </script>
			<?php
		}
	}
}