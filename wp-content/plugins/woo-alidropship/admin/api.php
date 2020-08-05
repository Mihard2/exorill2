<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class VI_WOO_ALIDROPSHIP_Admin_API
 */

class VI_WOO_ALIDROPSHIP_Admin_API {
	protected $product_data;
	protected $settings;
	protected $orders_tracking_carriers;
	protected $found_carriers;
	protected $process_description;

	public function __construct() {
		$this->found_carriers = array(
			'url'      => array(),
			'carriers' => array(),
		);
		$this->settings       = VI_WOO_ALIDROPSHIP_DATA::get_instance();
		add_action( 'rest_api_init', array( $this, 'register_api' ) );
		if ( ! wp_next_scheduled( 'vi_wad_update_aff_urls' ) ) {
			wp_schedule_event( time(), 'daily', 'vi_wad_update_aff_urls' );
		}

		add_action( 'vi_wad_update_aff_urls', array( $this, 'update_aff_urls' ) );
		add_action( 'init', array( $this, 'update_aff_url_request' ) );
		add_filter( 'villatheme_woo_alidropship_sync_ali_order_carrier_url', array(
			$this,
			'villatheme_woo_alidropship_sync_ali_order_carrier_url'
		) );
	}

	/**
	 * @param $url
	 *
	 * @return mixed
	 */
	public function villatheme_woo_alidropship_sync_ali_order_carrier_url( $url ) {
		$carrier_url_replaces = $this->settings->get_params( 'carrier_url_replaces' );
		if ( $url && isset( $carrier_url_replaces['to_string'] ) && is_array( $carrier_url_replaces['to_string'] ) && $str_replace_count = count( $carrier_url_replaces['to_string'] ) ) {
			for ( $i = 0; $i < $str_replace_count; $i ++ ) {
				if ( false !== stripos( $url, $carrier_url_replaces['from_string'][ $i ] ) ) {
					$url = $carrier_url_replaces['to_string'][ $i ];
					add_filter( 'villatheme_woo_alidropship_sync_ali_order_carrier_name', array(
						$this,
						'villatheme_woo_alidropship_sync_ali_order_carrier_name'
					) );
					break;
				}
			}
		}

		return $url;
	}

	/**
	 * @param $name
	 *
	 * @return mixed
	 */
	public function villatheme_woo_alidropship_sync_ali_order_carrier_name( $name ) {
		$carrier_name_replaces = $this->settings->get_params( 'carrier_name_replaces' );
		if ( $name && isset( $carrier_name_replaces['to_string'] ) && is_array( $carrier_name_replaces['to_string'] ) && $str_replace_count = count( $carrier_name_replaces['to_string'] ) ) {
			for ( $i = 0; $i < $str_replace_count; $i ++ ) {
				if ( $carrier_name_replaces['sensitive'][ $i ] ) {
					$name = str_replace( $carrier_name_replaces['from_string'][ $i ], $carrier_name_replaces['to_string'][ $i ], $name );
				} else {
					$name = str_ireplace( $carrier_name_replaces['from_string'][ $i ], $carrier_name_replaces['to_string'][ $i ], $name );
				}
			}
		}

		return $name;
	}

	public static function sort_by_product_id( $array1, $array2 ) {
		return $array1['productID'] - $array2['productID'];
	}

	/**
	 * Register API json
	 */
	public function register_api() {
		/*Auto update plugins*/
		register_rest_route(
			'woocommerce_aliexpress_dropship', '/sync', array(
				'methods'  => 'POST',
				'callback' => array( $this, 'sync' ),
			)
		);
//		register_rest_route(
//			'woocommerce_aliexpress_dropship', '/test', array(
//				'methods'  => 'get',
//				'callback' => array( $this, 'get' ),
//			)
//		);
		register_rest_route(
			'woocommerce_aliexpress_dropship', '/get_product_sku', array(
				'methods'  => 'POST',
				'callback' => array( $this, 'get_product_sku' ),
			)
		);

		register_rest_route(
			'woocommerce_aliexpress_dropship', '/request_order', array(
				'methods'  => 'POST',
				'callback' => array( $this, 'request_order' ),
			)
		);
		register_rest_route(
			'woocommerce_aliexpress_dropship', '/response_order', array(
				'methods'  => 'POST',
				'callback' => array( $this, 'response_order' ),
			)
		);
		register_rest_route(
			'woocommerce_aliexpress_dropship', '/sync_order', array(
				'methods'  => 'POST',
				'callback' => array( $this, 'sync_order' ),
			)
		);
	}

	/**
	 * @param $request WP_REST_Request
	 */
	public function get( $request ) {
		print_r( $request->get_headers() );
		print_r( $_SERVER );
		die;
	}

	protected function header() {
		header( "Access-Control-Allow-Origin: *" );
		header( 'Access-Control-Allow-Methods: GET' );
	}

	/**
	 * @param $request WP_REST_Request
	 */
	public function validate( $request ) {
		$result = array(
			'status'       => 'error',
			'message'      => '',
			'message_type' => 1,
		);

		/*check enable*/
		if ( ! $this->settings->get_params( 'enable' ) ) {
			$result['message']      = esc_html__( 'Dropshipping and Fulfillment for AliExpress and WooCommerce plugin is currently disabled. Please enable it to use this function.', 'woo-alidropship' );
			$result['message_type'] = 2;

			wp_send_json( $result );
		}
		$key             = $request->get_param( 'key' );
		$require_version = $request->get_param( 'require_version' );
		/*check key*/
		if ( ! $key || $key != ( $this->settings->get_params( 'secret_key' ) ) ) {
			$result['message']      = esc_html__( 'Secret key does not match', 'woo-alidropship' );
			$result['message_type'] = 2;

			wp_send_json( $result );
		}

		/*check version*/
		if ( version_compare( VI_WOO_ALIDROPSHIP_VERSION, $require_version, '<' ) ) {
			$result['message']      = esc_html__( 'Your current version of Dropshipping and Fulfillment for AliExpress and WooCommerce plugin on your site does not work with the extension version. Please update your plugin.', 'woo-alidropship' );
			$result['message_type'] = 2;

			wp_send_json( $result );
		}
	}

	/**
	 * @param $request WP_REST_Request
	 */
	public function sync( $request ) {
		$result = array(
			'status'       => 'error',
			'message'      => '',
			'message_type' => 1,
		);
		$this->validate( $request );
		vi_wad_set_time_limit();
		$product_id   = $request->get_param( 'productID' );
		$product_html = urldecode( base64_decode( $request->get_param( 'ali_product_data' ) ) );
		$data         = array();
		$old_cookies  = get_option( 'vi_woo_alidropship_cookies_for_importing', array() );
		$cookies      = $request->get_param( 'cookies' );
		if ( ! $cookies ) {
			$cookies = $old_cookies;
		}
		if ( $product_id ) {
			if ( ! is_array( $cookies ) ) {
				$cookies = array(
					'xman_f' => $cookies,
				);
			}
			$get_data = VI_WOO_ALIDROPSHIP_DATA::get_data( 'https://www.aliexpress.com/item/' . $product_id . '.html', array(
				'cookies' => $cookies
			), $product_html );
			if ( $get_data['status'] == 'success' ) {
				$data = $get_data['data'];
				if ( $cookies ) {
					update_option( 'vi_woo_alidropship_cookies_for_importing', $cookies );
				}
			} else {
				$result['message']      = esc_html__( 'Can not retrieve data.', 'woo-alidropship' );
				$result['message_type'] = 'try_again';

				wp_send_json( $result );
			}
		} else {
			$data = vi_wad_json_decode( $request->get_param( 'data' ) );
		}

		$this->add_to_import_list( $data );
	}

	public function add_to_import_list( $data ) {
		$result  = array(
			'status'       => 'error',
			'message'      => '',
			'message_type' => 1,
		);
		$sku     = isset( $data['sku'] ) ? sanitize_text_field( $data['sku'] ) : '';
		$post_id = VI_WOO_ALIDROPSHIP_DATA::product_get_id_by_aliexpresss_id( $sku );
		if ( ! $post_id ) {
			$title            = isset( $data['name'] ) ? sanitize_text_field( $data['name'] ) : '';
			$description_url  = isset( $data['description_url'] ) ? ( stripslashes( $data['description_url'] ) ) : '';
			$description      = isset( $data['short_description'] ) ? wp_kses_post( stripslashes( $data['short_description'] ) ) : '';
			$specsModule      = isset( $data['specsModule'] ) ? stripslashes_deep( $data['specsModule'] ) : array();
			$gallery          = isset( $data['gallery'] ) ? stripslashes_deep( $data['gallery'] ) : array();
			$variation_images = isset( $data['variation_images'] ) ? stripslashes_deep( $data['variation_images'] ) : array();
			$variations       = isset( $data['variations'] ) ? stripslashes_deep( $data['variations'] ) : array();
			$attributes       = isset( $data['attributes'] ) ? stripslashes_deep( $data['attributes'] ) : array();
			$list_attributes  = isset( $data['list_attributes'] ) ? stripslashes_deep( $data['list_attributes'] ) : array();
			$store_info       = isset( $data['store_info'] ) ? stripslashes_deep( $data['store_info'] ) : array();
			$str_replace      = $this->settings->get_params( 'string_replace' );

			$description_setting = $this->settings->get_params( 'product_description' );
			if ( $description_setting == 'none' || $description_setting == 'description' ) {
				$description = '';
			} elseif ( count( $specsModule ) ) {
				ob_start();
				?>
                <div class="product-specs-list-container">
                    <ul class="product-specs-list util-clearfix">
						<?php
						foreach ( $specsModule as $specs ) {
							?>
                            <li class="product-prop line-limit-length"><span
                                        class="property-title"><?php echo $specs['attrName'] ?>:&nbsp;</span><span
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
			$aff_url = $sku ? VI_WOO_ALIDROPSHIP_DATA::get_aff_url( $sku ) : '';
			$aff_url = is_array( $aff_url ) ? current( $aff_url ) : $aff_url;

			$post_id = wp_insert_post( array(
				'post_title'   => $title,
				'post_type'    => 'vi_wad_draft_product',
				'post_status'  => 'draft',
				'post_excerpt' => '',
				'post_content' => $description,
			) );
			if ( is_wp_error( $post_id ) ) {
				$result['message'] = $post_id->get_error_message();
				wp_send_json( $result );
			}
			if ( $description_url ) {
				if ( VI_WOO_ALIDROPSHIP_DATA::get_disable_wp_cron() || $this->settings->get_params( 'disable_background_process' ) ) {
					VI_WOO_ALIDROPSHIP_DATA::download_description( $post_id, $description_url, $description, $description_setting );
				} else {
					VI_WOO_ALIDROPSHIP_Admin_Settings::$download_description->push_to_queue( array(
						'product_id'          => $post_id,
						'description'         => $description,
						'description_url'     => $description_url,
						'product_description' => $description_setting,
					) )->save()->dispatch();
				}
			}
			update_post_meta( $post_id, '_vi_wad_sku', $sku );
			update_post_meta( $post_id, '_vi_wad_attributes', $attributes );
			update_post_meta( $post_id, '_vi_wad_list_attributes', $list_attributes );
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

			$result['status']  = 'success';
			$result['message'] = __( 'Product is added to import list', 'woo-alidropship' );
		} else {
			$result['message'] = __( 'Product exists', 'woo-alidropship' );
		}

		wp_send_json( $result );
	}

	/**
	 * @param $request WP_REST_Request
	 */
	public function get_product_sku( $request ) {
		$result = array(
			'status'  => 'success',
			'message' => '',
			'data'    => json_encode( array() ),
		);
		$this->validate( $request );
		vi_wad_set_time_limit();
		wp_send_json( $result );

		/*temporarily disable this function*/
//		$result['data'] = json_encode( $this->settings->get_imported_products( array(), true ) );
		$result['data'] = json_encode( array() );

		wp_send_json( $result );
	}

	/**
	 * @param $request WP_REST_Request
	 *
	 * @throws Exception
	 */
	public function response_order( $request ) {
		$this->validate( $request );
		vi_wad_set_time_limit();
		$matchOrders = $request->get_param( 'matchOrders' );
		if ( is_array( $matchOrders ) && count( $matchOrders ) ) {
			$from_order_id = $request->get_param( 'fromOrderId' );
			$order         = wc_get_order( $from_order_id );
			if ( $from_order_id && $order ) {
				$order_items = $order->get_items();
				if ( count( $order_items ) ) {
					foreach ( $matchOrders as $matchOrder ) {
						$ali_order_id = $matchOrder['orderId'];
						$orderTotal   = $matchOrder['orderTotal'];
						if ( $orderTotal ) {
							$orderDetails = self::get_order_details( $orderTotal );
							Vi_Wad_Ali_Orders_Info_Table::insert( $ali_order_id, $orderDetails['currency'], $orderDetails['total'] );
						}
						$matchProductIds = array_unique( $matchOrder['matchProductIds'] );
						foreach ( $order_items as $item_id => $item ) {
							$product_id     = $item['product_id'];
							$ali_product_id = get_post_meta( $product_id, '_vi_wad_aliexpress_product_id', true );
							if ( in_array( $ali_product_id, $matchProductIds ) ) {
								$match_aliexpress_order_ids = wc_get_order_item_meta( $item_id, '_vi_wad_match_aliexpress_order_id', false );
								if ( ! in_array( $ali_order_id, $match_aliexpress_order_ids ) ) {
									wc_add_order_item_meta( $item_id, '_vi_wad_match_aliexpress_order_id', $ali_order_id );
								}
								if ( strtolower( trim( $matchOrder['orderStatus'] ) ) === 'wait_seller_send_goods' ) {
									wc_update_order_item_meta( $item_id, '_vi_wad_aliexpress_order_id', $ali_order_id );
								}
							}
						}
					}
				}
			}
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}

	/**Get order currency and order total
	 *
	 * @param $orderTotal
	 *
	 * @return array
	 */
	public static function get_order_details( $orderTotal ) {
		$orderTotal         = html_entity_decode( $orderTotal );
		$support_currencies = array( '$', '￡', '€', 'руб.', '￥', 'SEK' );
		$total              = $currency = '';
		foreach ( $support_currencies as $symbol ) {
			if ( strpos( $orderTotal, $symbol ) !== false ) {
				$orderTotalPatterns = explode( $symbol, $orderTotal );
				$orderTotalPatterns = array_map( 'trim', $orderTotalPatterns );
				switch ( $symbol ) {
					case '￡':
						$currency = 'GBP';
						$total    = trim( str_ireplace( array( $currency, $symbol ), array( '', '' ), $orderTotal ) );
						break;
					case '€':
						$currency = 'EUR';
						$total    = trim( str_ireplace( array( $currency, $symbol ), array( '', '' ), $orderTotal ) );
						break;
					case 'руб.':
						$currency = 'RUB';
						$total    = trim( str_ireplace( array( $currency, $symbol ), array( '', '' ), $orderTotal ) );
						break;
					case '￥':
						$currency = 'JPY';
						$total    = trim( str_ireplace( array( $currency, $symbol ), array( '', '' ), $orderTotal ) );
						break;
					case 'SEK':
						$currency = 'SEK';
						$total    = trim( str_ireplace( array( $currency, $symbol ), array( '', '' ), $orderTotal ) );
						break;
					case '$':
					default:
						$receiveCurrency = strtolower( $orderTotalPatterns[0] );
						if ( $receiveCurrency === 'au' ) {
							$currency = 'AUD';
							$total    = trim( str_ireplace( array( $currency, $symbol, 'au' ), array(
								'',
								'',
								''
							), $orderTotal ) );
						} elseif ( $receiveCurrency === 'us' ) {
							$currency = 'USD';
							$total    = trim( str_ireplace( array( $currency, $symbol, 'us' ), array(
								'',
								'',
								''
							), $orderTotal ) );
						} else {
							$currency = 'CAD';
							$total    = trim( str_ireplace( array( $currency, $symbol, 'ca' ), array(
								'',
								'',
								''
							), $orderTotal ) );
						}

				}
			}
		}
		$total = str_replace( ',', '.', $total );

		return array( 'total' => $total, 'currency' => $currency );
	}

	/**
	 * @param $ali_order_id
	 * @param $tracking_number
	 * @param $tracking_status
	 * @param $carrier_url
	 * @param $carrier_name
	 * @param $orderTotal
	 *
	 * @return array
	 * @throws Exception
	 */
	public function save_order_data( $ali_order_id, $tracking_number, $tracking_status, $carrier_url, $carrier_name, $orderTotal ) {
		$item_response = array(
			'status'  => 'error',
			'message' => '',
		);
		global $wpdb;
		$aliexpress_standard_shipping = false;
		if ( strtolower( trim( $carrier_name ) ) === 'aliexpress standard shipping' ) {
			$aliexpress_standard_shipping = true;
		} else {
			$carrier_url  = apply_filters( 'villatheme_woo_alidropship_sync_ali_order_carrier_url', $carrier_url );
			$carrier_name = apply_filters( 'villatheme_woo_alidropship_sync_ali_order_carrier_name', $carrier_name );
		}
		if ( $ali_order_id ) {
			$query          = $wpdb->prepare( "Select * from {$wpdb->prefix}woocommerce_order_itemmeta where meta_key='_vi_wad_aliexpress_order_id' and meta_value=%s", $ali_order_id );
			$q_result       = $wpdb->get_results( $query, ARRAY_A );
			$order_item_ids = array();
			if ( $orderTotal ) {
				$orderDetails = self::get_order_details( $orderTotal );
				Vi_Wad_Ali_Orders_Info_Table::insert( $ali_order_id, $orderDetails['currency'], $orderDetails['total'] );
			}
			if ( count( $q_result ) ) {
				$item_response['status']  = 'success';
				$item_response['message'] = __( 'Order synced successfully', 'woo-alidropship' );
				foreach ( $q_result as $item ) {
					$order_item_id      = $item['order_item_id'];
					$order_item_ids[]   = $order_item_id;
					$item_tracking_data = wc_get_order_item_meta( $order_item_id, '_vi_wot_order_item_tracking_data', true );
					if ( $tracking_number ) {
						$current_tracking_data = array(
							'tracking_number' => '',
							'carrier_slug'    => '',
							'carrier_url'     => '',
							'carrier_name'    => '',
							'carrier_type'    => '',
							'time'            => time(),
						);
						if ( $item_tracking_data ) {
							$item_tracking_data = vi_wad_json_decode( $item_tracking_data );
							foreach ( $item_tracking_data as $order_tracking_data_k => $order_tracking_data_v ) {
								if ( $order_tracking_data_v['tracking_number'] == $tracking_number ) {
									$current_tracking_data = $order_tracking_data_v;
									unset( $item_tracking_data[ $order_tracking_data_k ] );
									break;
								}
							}
							$item_tracking_data = array_values( $item_tracking_data );
						} else {
							$item_tracking_data = array();
						}
						$current_tracking_data['tracking_number'] = $tracking_number;
						$found_carrier                            = $this->get_orders_tracking_carrier( $carrier_url, $carrier_name, $aliexpress_standard_shipping );
						if ( count( $found_carrier ) ) {
							$current_tracking_data['carrier_slug'] = $found_carrier['slug'];
							$current_tracking_data['carrier_url']  = $found_carrier['url'];
							$current_tracking_data['carrier_name'] = $found_carrier['name'];
						} else {
							$current_tracking_data['carrier_url']  = $carrier_url;
							$current_tracking_data['carrier_name'] = $carrier_name;
						}
						$item_tracking_data[] = $current_tracking_data;
						wc_update_order_item_meta( $order_item_id, '_vi_wot_order_item_tracking_data', json_encode( $item_tracking_data ) );
					} else {
						$item_response['status']  = 'warning';
						$item_response['message'] = __( 'No tracking number', 'woo-alidropship' );
						if ( $item_tracking_data ) {
							$item_tracking_data    = vi_wad_json_decode( $item_tracking_data );
							$current_tracking_data = array_pop( $item_tracking_data );
							if ( $current_tracking_data['tracking_number'] ) {
								$item_tracking_data[] = array(
									'tracking_number' => '',
									'carrier_slug'    => '',
									'carrier_url'     => '',
									'carrier_name'    => '',
									'carrier_type'    => '',
									'time'            => time(),
								);
								wc_update_order_item_meta( $order_item_id, '_vi_wot_order_item_tracking_data', json_encode( $item_tracking_data ) );
							}
						}
					}
					if ( strtolower( trim( $tracking_status ) ) == ( 'delivery successful' ) ) { // || 'delivered'
						wc_update_order_item_meta( $order_item_id, '_vi_wad_aliexpress_order_item_status', 'shipped' );
					}
				}

			} else {
				$query    = $wpdb->prepare( "Select * from {$wpdb->prefix}woocommerce_order_itemmeta where meta_key='_vi_wad_match_aliexpress_order_id' and meta_value=%s", $ali_order_id );
				$q_result = $wpdb->get_results( $query, ARRAY_A );
				if ( count( $q_result ) ) {
					foreach ( $q_result as $item ) {
						$order_item_id    = $item['order_item_id'];
						$order_item_ids[] = $order_item_id;
						if ( wc_update_order_item_meta( $order_item_id, '_vi_wad_aliexpress_order_id', $ali_order_id ) ) {
							wc_update_order_item_meta( $order_item_id, '_vi_wad_aliexpress_order_item_status', 'processing' );
							$item_response['status']  = 'success';
							$item_response['message'] = __( 'Order synced successfully', 'woo-alidropship' );
							$item_tracking_data       = wc_get_order_item_meta( $order_item_id, '_vi_wot_order_item_tracking_data', true );
							if ( $tracking_number ) {
								$current_tracking_data = array(
									'tracking_number' => '',
									'carrier_slug'    => '',
									'carrier_url'     => '',
									'carrier_name'    => '',
									'carrier_type'    => '',
									'time'            => time(),
								);
								if ( $item_tracking_data ) {
									$item_tracking_data = vi_wad_json_decode( $item_tracking_data );
									foreach ( $item_tracking_data as $order_tracking_data_k => $order_tracking_data_v ) {
										if ( $order_tracking_data_v['tracking_number'] == $tracking_number ) {
											$current_tracking_data = $order_tracking_data_v;
											unset( $item_tracking_data[ $order_tracking_data_k ] );
											break;
										}
									}
									$item_tracking_data = array_values( $item_tracking_data );
								} else {
									$item_tracking_data = array();
								}
								$current_tracking_data['tracking_number'] = $tracking_number;
								$found_carrier                            = $this->get_orders_tracking_carrier( $carrier_url, $carrier_name, $aliexpress_standard_shipping );
								if ( count( $found_carrier ) ) {
									$current_tracking_data['carrier_slug'] = $found_carrier['slug'];
									$current_tracking_data['carrier_url']  = $found_carrier['url'];
									$current_tracking_data['carrier_name'] = $found_carrier['name'];
								} else {
									$current_tracking_data['carrier_url']  = $carrier_url;
									$current_tracking_data['carrier_name'] = $carrier_name;
								}
								$item_tracking_data[] = $current_tracking_data;
								wc_update_order_item_meta( $order_item_id, '_vi_wot_order_item_tracking_data', json_encode( $item_tracking_data ) );
							} else {
								$item_response['status']  = 'warning';
								$item_response['message'] = __( 'No tracking number', 'woo-alidropship' );
								if ( $item_tracking_data ) {
									$item_tracking_data    = vi_wad_json_decode( $item_tracking_data );
									$current_tracking_data = array_pop( $item_tracking_data );
									if ( $current_tracking_data['tracking_number'] ) {
										$item_tracking_data[] = array(
											'tracking_number' => '',
											'carrier_slug'    => '',
											'carrier_url'     => '',
											'carrier_name'    => '',
											'carrier_type'    => '',
											'time'            => time(),
										);
										wc_update_order_item_meta( $order_item_id, '_vi_wot_order_item_tracking_data', json_encode( $item_tracking_data ) );
									}
								}
							}
							if ( strtolower( trim( $tracking_status ) ) === 'delivery successful' ) {
								wc_update_order_item_meta( $order_item_id, '_vi_wad_aliexpress_order_item_status', 'shipped' );
							}
						}
					}
				} else {
					$item_response['status']  = 'error';
					$item_response['message'] = __( 'No matched order found', 'woo-alidropship' );
				}
			}

			if ( count( $order_item_ids ) ) {
				$this->change_order_status( $order_item_ids );
			}
		} else {
			$item_response['status']  = 'error';
			$item_response['message'] = __( 'No matched order found', 'woo-alidropship' );
		}

		return $item_response;
	}

	/**
	 * @param $request WP_REST_Request
	 *
	 * @throws Exception
	 */
	public function sync_order( $request ) {
		$result = array(
			'status'  => 'success',
			'message' => '',
			'data'    => array(),
			'stop'    => 0,
		);
		$this->validate( $request );
		vi_wad_set_time_limit();
		$tracking_data_array = $request->get_param( 'tracking_data_array' );
		$response_array      = array();
		if ( is_array( $tracking_data_array ) && count( $tracking_data_array ) ) {
			foreach ( $tracking_data_array as $ali_tracking_item ) {
				$ali_order_id     = $ali_tracking_item['orderId'];
				$tracking_number  = $ali_tracking_item['tracking_number'];
				$tracking_status  = $ali_tracking_item['tracking_status'];
				$carrier_url      = apply_filters( 'villatheme_woo_alidropship_sync_ali_order_carrier_url', $ali_tracking_item['carrier_url'] );
				$carrier_name     = apply_filters( 'villatheme_woo_alidropship_sync_ali_order_carrier_name', $ali_tracking_item['carrier_name'] );
				$orderTotal       = $ali_tracking_item['orderTotal'];
				$item_response    = $this->save_order_data( $ali_order_id, $tracking_number, $tracking_status, $carrier_url, $carrier_name, $orderTotal );
				$response_array[] = $item_response;
			}
			$result['data'] = $response_array;
		} else {
			$ali_order_id      = $request->get_param( 'orderId' );
			$tracking_number   = $request->get_param( 'tracking_number' );
			$tracking_status   = $request->get_param( 'tracking_status' );
			$carrier_url       = $request->get_param( 'carrier_url' );
			$carrier_name      = $request->get_param( 'carrier_name' );
			$orderTotal        = $request->get_param( 'orderTotal' );
			$item_response     = $this->save_order_data( $ali_order_id, $tracking_number, $tracking_status, $carrier_url, $carrier_name, $orderTotal );
			$result['status']  = $item_response['status'];
			$result['message'] = $item_response['message'];
		}
		wp_send_json( $result );

	}

	/**
	 * @param $order_item_ids
	 *
	 * @throws Exception
	 */
	public function change_order_status( $order_item_ids ) {
		$status = $this->settings->get_params( 'order_status_after_sync' );
		if ( in_array( $status, array_keys( wc_get_order_statuses() ) ) ) {
			$order_ids = array_unique( array_map( 'wc_get_order_id_by_order_item_id', $order_item_ids ) );
			foreach ( $order_ids as $order_id ) {
				$order                 = wc_get_order( $order_id );
				$items                 = $order->get_items();
				$sum_ali_order_id      = 0;
				$sum_ali_tracking_code = 0;
				foreach ( $items as $item_id => $item ) {
					$ali_order_id       = $item->get_meta( '_vi_wad_aliexpress_order_id' );
					$item_tracking_data = wc_get_order_item_meta( $item_id, '_vi_wot_order_item_tracking_data', true );
					if ( $item_tracking_data ) {
						$item_tracking_data    = vi_wad_json_decode( $item_tracking_data );
						$current_tracking_data = array_pop( $item_tracking_data );
						if ( $current_tracking_data['tracking_number'] ) {
							$sum_ali_tracking_code ++;
						}
					}
					if ( $ali_order_id ) {
						$sum_ali_order_id ++;
					}
				}

				if ( $sum_ali_order_id && $sum_ali_tracking_code === $sum_ali_order_id ) {
					$order->update_status( $status );
				}
			}
		}
	}

	/**
	 * @param $carrier_url
	 * @param string $carrier_name
	 * @param bool $aliexpress_standard_shipping
	 *
	 * @return array|mixed
	 */
	public function get_orders_tracking_carrier( $carrier_url, $carrier_name = '', $aliexpress_standard_shipping = false ) {
		$return_carrier = array();
		if ( $aliexpress_standard_shipping ) {
			if ( class_exists( 'VI_WOO_ORDERS_TRACKING_DATA' ) || class_exists( 'VI_WOOCOMMERCE_ORDERS_TRACKING_DATA' ) ) {
				$return_carrier = array(
					'name'               => 'Aliexpress Standard Shipping',
					'slug'               => 'aliexpress-standard-shipping',
					'url'                => 'https://global.cainiao.com/detail.htm?mailNoList={tracking_number}',
					'country'            => 'Global',
					'active'             => '',
					'tracking_more_slug' => 'cainiao',
				);
			}
		} else {
			if ( $carrier_url ) {
				if ( $this->orders_tracking_carriers !== array() ) {
					$search_carrier = array_search( $carrier_url, $this->found_carriers['url'] );
					if ( false !== $search_carrier ) {
						$return_carrier = $this->found_carriers['carriers'][ $search_carrier ];
					} else {
						$original_url = $carrier_url;
						$carrier_url  = VI_WOO_ALIDROPSHIP_DATA::get_domain_from_url( $carrier_url );
						if ( $this->orders_tracking_carriers === null ) {
							if ( class_exists( 'VI_WOO_ORDERS_TRACKING_DATA' ) ) {
								$orders_tracking_data = new VI_WOO_ORDERS_TRACKING_DATA();
								$carriers_array       = VI_WOO_ORDERS_TRACKING_DATA::shipping_carriers();
								$custom_carriers      = $orders_tracking_data->get_params( 'custom_carriers_list' );
								if ( $custom_carriers ) {
									$carriers_array = array_merge( $carriers_array, vi_wad_json_decode( $custom_carriers ) );
								}
								$this->orders_tracking_carriers = $carriers_array;
							} elseif ( class_exists( 'VI_WOOCOMMERCE_ORDERS_TRACKING_DATA' ) ) {
								$orders_tracking_data = new VI_WOOCOMMERCE_ORDERS_TRACKING_DATA();
								$carriers_array       = VI_WOOCOMMERCE_ORDERS_TRACKING_DATA::shipping_carriers();
								$custom_carriers      = $orders_tracking_data->get_params( 'custom_carriers_list' );
								if ( $custom_carriers ) {
									$carriers_array = array_merge( $carriers_array, vi_wad_json_decode( $custom_carriers ) );
								}
								$this->orders_tracking_carriers = $carriers_array;
							} else {
								$this->orders_tracking_carriers = array();
							}
						}

						if ( count( $this->orders_tracking_carriers ) ) {
							$found = false;
							foreach ( $this->orders_tracking_carriers as $carrier ) {
								$existing_url = VI_WOO_ALIDROPSHIP_DATA::get_domain_from_url( $carrier['url'] );
								if ( $carrier_url === $existing_url ) {
									$return_carrier                     = $carrier;
									$this->found_carriers['url'][]      = $original_url;
									$this->found_carriers['carriers'][] = $carrier;
									$found                              = true;
									break;
								}
							}
							if ( ! $found ) {
								$this->found_carriers['url'][] = $original_url;
								if ( class_exists( 'VI_WOO_ORDERS_TRACKING_DATA' ) ) {
									if ( ! $carrier_name ) {
										$carrier_name = $carrier_url;
									}
									$orders_tracking_data    = new VI_WOO_ORDERS_TRACKING_DATA();
									$orders_tracking_options = $orders_tracking_data->get_params();
									$custom_carriers         = $orders_tracking_data->get_params( 'custom_carriers_list' );
									if ( $custom_carriers ) {
										$custom_carriers = vi_wad_json_decode( $custom_carriers );
									} else {
										$custom_carriers = array();
									}
									$custom_carrier                                  = array(
										'name'    => $carrier_name,
										'slug'    => 'custom_' . time(),
										'url'     => $original_url,
										'country' => 'GLOBAL',
										'type'    => 'custom',
									);
									$custom_carriers[]                               = $custom_carrier;
									$return_carrier                                  = $custom_carrier;
									$this->orders_tracking_carriers[]                = $custom_carrier;
									$orders_tracking_options['custom_carriers_list'] = json_encode( $custom_carriers );
									update_option( 'woo_orders_tracking_settings', $orders_tracking_options );
									$this->found_carriers['carriers'][] = $custom_carrier;
								} elseif ( class_exists( 'VI_WOOCOMMERCE_ORDERS_TRACKING_DATA' ) ) {
									if ( ! $carrier_name ) {
										$carrier_name = $carrier_url;
									}
									$orders_tracking_data    = new VI_WOOCOMMERCE_ORDERS_TRACKING_DATA();
									$orders_tracking_options = $orders_tracking_data->get_params();
									$custom_carriers         = $orders_tracking_data->get_params( 'custom_carriers_list' );
									if ( $custom_carriers ) {
										$custom_carriers = vi_wad_json_decode( $custom_carriers );
									} else {
										$custom_carriers = array();
									}
									$custom_carrier                                  = array(
										'name'    => $carrier_name,
										'slug'    => 'custom_' . time(),
										'url'     => $original_url,
										'country' => 'GLOBAL',
										'type'    => 'custom',
									);
									$custom_carriers[]                               = $custom_carrier;
									$return_carrier                                  = $custom_carrier;
									$this->orders_tracking_carriers[]                = $custom_carrier;
									$orders_tracking_options['custom_carriers_list'] = json_encode( $custom_carriers );
									update_option( 'woo_orders_tracking_settings', $orders_tracking_options );
									$this->found_carriers['carriers'][] = $custom_carrier;
								} else {
									$this->found_carriers['carriers'][] = array();
								}

							}
						}
					}
				}
			}

		}

		return $return_carrier;
	}

	/**
	 * @param $request WP_REST_Request
	 */
	public function request_order( $request ) {
		$result = array(
			'status'  => 'error',
			'message' => __( 'Order not found', 'woo-alidropship' ),
		);
		$this->validate( $request );
		vi_wad_set_time_limit();
		$order_id = $request->get_param( 'order_id' );
		$order    = wc_get_order( $order_id );
		if ( $order ) {
			$result['message']                    = __( 'Success', 'woo-alidropship' );
			$result['status']                     = 'success';
			$result['message']                    = __( 'Order not found', 'woo-alidropship' );
			$result['order_info']                 = $this->get_order_info( $order );
			$result['customerInfo']               = $this->get_customer_info( $order );
			$result['customerInfo']['carrier']    = $this->settings->get_params( 'fulfill_default_carrier' );
			$result['customerInfo']['order_note'] = $this->settings->get_params( 'fulfill_order_note' );
		}
		wp_send_json( $result );
	}

	/**
	 * @param $order WC_Order
	 *
	 * @return array
	 */
	public function get_order_info( $order ) {
		$result     = array();
		$list_items = $order->get_items();

		foreach ( $list_items as $item ) {
			if ( $item->get_meta( '_vi_wad_aliexpress_order_id' ) ) {
				continue;
			}
			$data    = $item->get_data();
			$pid     = $data['product_id'];
			$vid     = isset( $data['variation_id'] ) ? $data['variation_id'] : '';
			$qty     = $data['quantity'];
			$ali_pid = get_post_meta( $pid, '_vi_wad_aliexpress_product_id', true );
			if ( $ali_pid ) {
				$title = get_the_title( $pid );
				if ( $vid ) {
					$title    = get_the_title( $vid );
					$ali_vid  = get_post_meta( $vid, '_vi_wad_aliexpress_variation_id', true );
					$sku_attr = get_post_meta( $vid, '_vi_wad_aliexpress_variation_attr', true );
				} else {
					$ali_vid  = get_post_meta( $pid, '_vi_wad_aliexpress_variation_id', true );
					$sku_attr = get_post_meta( $pid, '_vi_wad_aliexpress_variation_attr', true );
				}
				$result[] = array(
					'productID' => $ali_pid,
					'skuID'     => $ali_vid,
					'skuAttr'   => urlencode( $sku_attr ),
					'quantity'  => $qty,
					'title'     => $title,
				);
			}
		}

//		uasort( $result, array( $this, 'sort_by_product_id' ) );

		return $result;
	}

	/**
	 * @param $order WC_Order
	 *
	 * @return array
	 */
	public function get_customer_info( $order ) {
		$shipping_country = $order->get_shipping_country();
		if ( ! $shipping_country ) {
			$shipping_country = $order->get_billing_country();
		}
		$country       = $this->filter_country( $shipping_country );
		$countries     = WC()->countries->get_countries();
		$country_name  = isset( $countries[ $country ] ) ? $countries[ $country ] : '';
		$phone_country = $this->get_phone_country_code( $country );
		$states        = WC()->countries->get_states( $shipping_country );
		$state_code    = $order->get_shipping_state();
		if ( ! $state_code ) {
			$state_code = $order->get_billing_state();
		}
		$city = $order->get_shipping_city();
		if ( ! $city ) {
			$city = $order->get_billing_city();
		}
		$city = ucwords( remove_accents( $city ) );
		$name = trim( $order->get_formatted_shipping_full_name() );
		if ( ! $name ) {
			$name = $order->get_formatted_billing_full_name();
		}
		$address1 = $order->get_shipping_address_1();
		if ( ! $address1 ) {
			$address1 = $order->get_billing_address_1();
		}
		$group = $order->get_shipping_address_2();
		if ( ! $group ) {
			$group = $order->get_billing_address_2();
		}
		$phone     = $order->get_billing_phone();
		$phone     = str_replace( $phone_country, '', $phone );
		$phone     = str_replace( '+', '', $phone );
		$post_code = $order->get_shipping_postcode();
		if ( ! $post_code ) {
			$post_code = $order->get_billing_postcode();
		}
		$result = array(
			'name'         => remove_accents( $name ),
			'phone'        => $phone,
			'street'       => remove_accents( $address1 ),
			'group'        => remove_accents( $group ),
			'city'         => $city,
			'state_code'   => remove_accents( $state_code ),
			'state'        => isset( $states[ $state_code ] ) ? $states[ $state_code ] : $city,
			'country'      => $country,
			'countryName'  => $country_name,
			'postcode'     => $post_code,
			'phoneCountry' => empty( $phone_country ) ? WC()->countries->get_country_calling_code( $shipping_country ) : $phone_country,
			'fromOrderId'  => $order->get_id()
		);

		return $result;
	}

	public function filter_country( $country ) {
		switch ( $country ) {
			case 'AQ':
			case 'BV':
			case 'IO':
			case 'CU':
			case 'TF':
			case 'HM':
			case 'IR':
			case 'IM':
			case 'SH':
			case 'PN':
			case 'SD':
			case 'SJ':
			case 'SY':
			case 'TK':
			case 'UM':
			case 'EH':
				$country = 'OTHER';
				break;
			case 'AX':
				$country = 'ALA';
				break;
			case 'CN':
				$country = 'HK';
				break;
			case 'CD':
				$country = 'ZR';
				break;
			case 'GG':
				$country = 'GGY';
				break;
			case 'JE':
				$country = 'JEY';
				break;
			case 'ME':
				$country = 'MNE';
				break;
			case 'KP':
				$country = 'KR';
				break;
			case 'BL':
				$country = 'BLM';
				break;
			case 'MF':
				$country = 'MAF';
				break;
			case 'RS':
				$country = 'SRB';
				break;
			case 'GS':
				$country = 'SGS';
				break;
			case 'TL':
				$country = 'TLS';
				break;
			case 'GB':
				$country = 'UK';
				break;
			default:
		}

		return $country;
	}

	public function get_phone_country_code( $country ) {
		$map = '{"VU":"+678","EC":"+593","VN":"+84","VI":"","DZ":"+213","VG":"+1 (284)","DM":"+1 (767)","VE":"+58","DO":"+1 (8)","VC":"+1 (784)","VA":"+39 (066)","DE":"+49","UZ":"+998","UY":"+598","DK":"+45","DJ":"+253","US":"+1","UM":"","UG":"+256","UA":"+380","ET":"+251","ES":"+34","ER":"+291","EH":"+212","EG":"+20","TZ":"+255","EE":"+372","TT":"+1 (868)","TV":"+688","GD":"+1 (473)","GE":"+995","GF":"+594","GA":"+241","ASC":"","GB":"+44","FR":"+33","FO":"+298","FK":"+500","FJ":"+679","FM":"+691","FI":"+358","WS":"+685","GY":"+592","GW":"+245","GU":"","GT":"+502","GR":"+30","GQ":"+240","WF":"+681","GP":"+590","GN":"+224","GM":"+220","GL":"+299","GI":"+350","GH":"+233","GG":"+44","RE":"+262","RO":"+40","AT":"+43","AS":"","AR":"+54","AQ":"","AX":"","AW":"+297","QA":"+974","AU":"+61","AZ":"+994","BA":"+387","PT":"+351","AD":"+376","PW":"+680","AG":"+1 (268)","PR":"+1","AE":"+971","PS":"","AF":"","AL":"+355","AI":"","AO":"+244","PY":"+595","AM":"+374","AN":"","TG":"+228","BW":"+267","TF":"","BV":"","BY":"+375","TD":"+235","BS":"+1 (242)","TK":"","TJ":"+992","BR":"+55","TH":"+66","BT":"+975","TO":"+676","TN":"+216","TM":"+993","CA":"+1","TL":"+670","BZ":"+501","TR":"+90","BF":"+226","SV":"+503","BG":"+359","SS":"+211","BH":"+973","ST":"+239","BI":"+257","SY":"+963","BB":"+1 (246)","SZ":"+268","BD":"+880","SX":"+590","BE":"+32","BN":"+673","BO":"+591","BQ":"","BJ":"+229","TC":"+1 (649)","BL":"","BM":"+1 (441)","CZ":"+420","SD":"+249","CY":"+357","SC":"+248","CX":"","CW":"","SE":"+46","CV":"+238","SH":"","CU":"+53","SG":"+65","SJ":"+47","SI":"+386","SL":"+232","SK":"+421","SN":"+221","SM":"+378","SO":"+252","SGS":"","SR":"+597","CI":"+225","RS":"+381","CG":"+242","CH":"+41","RU":"+7","CF":"+236","RW":"+250","CC":"","CD":"+243","CR":"+506","CO":"+57","CM":"+237","CN":"+86","CK":"","SA":"+966","CL":"+56","SB":"+677","LV":"+371","LU":"+352","LT":"+370","LY":"+218","LS":"+266","LR":"+231","MG":"+261","MH":"+692","ME":"+382","MF":"","MK":"+389","ML":"+223","MC":"+377","MD":"+373","MA":"+212","MV":"+960","MU":"+230","MX":"+52","MW":"+265","MZ":"+258","MY":"+60","MN":"+976","MM":"+95","MP":"","MR":"+222","MQ":"+596","MT":"+356","MS":"","NF":"","NG":"+234","NI":"+505","NL":"+31","NA":"+264","NC":"+687","NE":"+227","NZ":"+64","NU":"","NR":"+674","NP":"+977","NO":"+47","OM":"+968","PL":"+48","PM":"+508","PN":"","PH":"+63","PK":"+92","PE":"+51","PF":"+689","PG":"+675","PA":"+507","ZA":"+27","HN":"+504","HM":"","HR":"+385","EAZ":"","HT":"+509","HU":"+36","ZM":"+260","ID":"+62","ZW":"+263","IE":"+353","IL":"+972","IM":"+44","IN":"+91","IO":"","IQ":"+964","IR":"+98","YE":"+967","IS":"+354","IT":"+39","JE":"+44","YT":"+262","JP":"+81","JO":"+962","JM":"+1 (876)","KI":"+686","KH":"","KG":"+996","KE":"+254","GBA":"","KP":"+850","KR":"+82","KM":"+269","KN":"+1 (869)","KW":"+965","KY":"+1 (345)","KZ":"+77","KS":"","LA":"+856","LC":"+1 (758)","LB":"+961","LI":"+423","LK":"+94"}';
		$map = vi_wad_json_decode( $map );

		return isset( $map[ $country ] ) ? $map[ $country ] : '';
	}

	public function update_aff_url_request() {
		if ( isset( $_GET['updateAffURL'] ) && $_GET['updateAffURL'] == 1 ) {
			$product_update_url       = $this->update_aff_url( 'product', '_vi_wad_aliexpress_product_id' );
			$product_draft_update_url = $this->update_aff_url( 'vi_wad_draft_product', '_vi_wad_sku' );

			$result = array(
				'woo_product' => $product_update_url,
				'ali_draft'   => $product_draft_update_url
			);
			echo json_encode( $result );
		}
	}

	public function update_aff_url( $post_type, $meta_key ) {
		//update aff_url for ali product
		$ali_pids = $aff_urls = array();
		$count    = array( 'success' => 0, 'not_exist' => 0 );
		$args     = array(
			'posts_per_page' => - 1,
			'post_type'      => $post_type,
			'post_status'    => array( 'draft', 'publish' ),
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => $meta_key,
					'compare' => 'EXISTS'
				),
				array(
					'relation' => 'OR',
					array(
						'key'     => '_vi_wad_check_alive',
						'value'   => 'not_exist',
						'compare' => '!='
					),
					array(
						'key'     => '_vi_wad_check_alive',
						'compare' => 'NOT EXISTS',
					),
				),
				array(
					'relation' => 'OR',
					array(
						'key'     => '_vi_wad_aff_url',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => '_vi_wad_aff_url',
						'value'   => '',
						'compare' => '='
					)
				),
			)
		);

		$get_posts = get_posts( $args );

		if ( is_array( $get_posts ) && count( $get_posts ) ) {
			foreach ( $get_posts as $post ) {
				$ali_pids[ $post->ID ] = get_post_meta( $post->ID, $meta_key, true );
			}
		}

		if ( count( $ali_pids ) ) {
			$aff_urls = VI_WOO_ALIDROPSHIP_DATA::get_aff_url( $ali_pids );
			if ( is_array( $aff_urls ) ) {
				foreach ( $ali_pids as $post_id => $ali_pid ) {
					if ( ! empty( $aff_urls[ $ali_pid ] ) ) {
						$success = update_post_meta( $post_id, '_vi_wad_aff_url', $aff_urls[ $ali_pid ] );
						if ( $success ) {
							$count['success'] ++;
						}
					} else {
						$not_exist = update_post_meta( $post_id, '_vi_wad_check_alive', 'not_exist' );
						if ( $not_exist ) {
							$count['not_exist'] ++;
						}
					}
				}
			}
		}

		return $count;
	}

	public function update_aff_urls() {
		$this->update_aff_url( 'product', '_vi_wad_aliexpress_product_id' );
		$this->update_aff_url( 'vi_wad_draft_product', '_vi_wad_sku' );
	}

}