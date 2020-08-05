<?php

trait Vi_WAD_Functions {

	/**
	 * Really long running process
	 *
	 * @return int
	 */
	public function really_long_running_task() {
		return sleep( 5 );
	}

	/**
	 * Log
	 *
	 * @param string $message
	 */
	public function log( $message ) {
		error_log( $message );
	}

	/**
	 * Get lorem
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	protected function get_message( $name ) {
		$response = wp_remote_get( esc_url_raw( 'http://loripsum.net/api/1/short/plaintext' ) );
		$body     = trim( wp_remote_retrieve_body( $response ) );

		if ( empty( $body ) ) {
			$body = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quippe: habes enim a rhetoribus; Eaedem res maneant alio modo.';
		}

		return $name . ': ' . $body;
	}

	public function import_product_variation( $product_variable_id, $item, $product_data ) {
		$product = wc_get_product( $product_variable_id );
		if ( $product ) {
			if ( is_array( $item['variations'] ) && count( $item['variations'] ) ) {
				$variation_ids = array();
				if ( count( $item['variation_images'] ) ) {
					foreach ( $item['variation_images'] as $key => $val ) {
						$variation_ids[ $key ] = array();
					}
				}

				$option       = new VI_WOO_ALIDROPSHIP_DATA();
				$manage_stock = $option->get_params( 'manage_stock' );
				$manage_stock = $manage_stock ? 'yes' : 'no';

				foreach ( $item['variations'] as $product_variation ) {
					$stock_quantity = isset( $product_variation['stock'] ) ? absint( $product_variation['stock'] ) : 0;
					$variation      = new WC_Product_Variation();
					$variation->set_parent_id( $product_variable_id );
					$variation->set_attributes( $product_variation['attributes'] );
					/*Set metabox for variation . Check field name at woocommerce/includes/class-wc-ajax.php*/
					$fields = array(
						'sku'            => VI_WOO_ALIDROPSHIP_DATA::sku_exists( $product_variation['sku'] ) ? '' : $product_variation['sku'],
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
					update_post_meta( $variation->get_id(), '_vi_wad_aliexpress_variation_id', $product_variation['skuId'] );
					update_post_meta( $variation->get_id(), '_vi_wad_aliexpress_variation_attr', $product_variation['skuAttr'] );
					if ( $product_variation['image'] ) {
						$pos = array_search( $product_variation['image'], $item['variation_images'] );
						if ( $pos !== false ) {
							$variation_ids[ $pos ][] = $variation->get_id();
						}
					}
				}
				if ( count( $variation_ids ) ) {
					foreach ( $variation_ids as $key => $values ) {
						if ( count( $values ) && ! empty( $item['variation_images'][ $key ] ) ) {
							$process    = new Vi_WAD_Background_Download_Images();
							$image_data = array(
								'woo_product_id' => $product_variable_id,
								'parent_id'      => '',
								'src'            => $item['variation_images'][ $key ],
								'product_ids'    => $values,
								'set_gallery'    => 0,
							);
							$process->push_to_queue( $image_data )->save()->dispatch();
						}
					}
				}
			}

			$data_store = $product->get_data_store();
			$data_store->sort_all_product_variations( $product->get_id() );
		}
	}

	protected function download_variation_images( $variation_images, $variation_ids ) {
		if ( count( $variation_images ) ) {
			foreach ( $variation_images as $key => $variation_image ) {
				if ( isset( $variation_ids[ $key ] ) && is_array( $variation_ids[ $key ] ) && count( $variation_ids[ $key ] ) && $variation_image ) {
					$thumb_id = vi_wad_upload_image( $variation_image );
					if ( ! is_wp_error( $thumb_id ) ) {
						foreach ( $variation_ids[ $key ] as $variation_id ) {
							update_post_meta( $variation_id, '_thumbnail_id', $thumb_id );
						}
					}
				}
			}
		}
	}
}