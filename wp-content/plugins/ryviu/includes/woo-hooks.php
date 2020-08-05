<?php
/*
|--------------------------------------------------------------------------
| Hook for woocommerce actions
|--------------------------------------------------------------------------
|
| Do some hook wordpress > woocommerce
|
*/
function ryviu_hook_endpoint($end_point){
	$data_hooks = [
	    //products
	    'product-create' => [
		    'name' => 'Product Create',
		    'topic' => 'product.created',
		    'delivery_url' => RYVIU_APP_HOOK_URL.'product-create'
		],
		
		'product-delete' => [
		    'name' => 'Product Delete',
		    'topic' => 'product.deleted',
		    'delivery_url' => RYVIU_APP_HOOK_URL.'product-delete'
		],
		
		//Orders hook
		//order.created, order.updated and order.deleted
		'order-update' => [
		    'name' => 'Order updated',
		    'topic' => 'order.updated',
		    'delivery_url' => RYVIU_APP_HOOK_URL.'order-update'
		]
	];
	
	return $data_hooks[$end_point];
}


/**
 * Get secret from woocommerce
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_get_wc_secret(){
	global $wpdb;
	
	$wc_api_table = $wpdb->prefix.'woocommerce_api_keys';
	$result = $wpdb->get_row( "SELECT * FROM $wc_api_table WHERE description LIKE 'Ryviu%' ORDER BY key_id DESC" );
	
	if($result)
		return $result;
	else
		return false;
}

/**
 * Do webhook callback to app.ryviu.io
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_hook_send($endpoint, $post){
	
    if(ryviu_get_wc_secret()){
	    $product_update_hook = ryviu_hook_endpoint($endpoint);
	    $api_data = ryviu_get_wc_secret();
	    
	    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	    $postData = (array) $post;
	    $postData['image'] = $image;
	    
	    $body_arr = array( 
			'product' => $postData,
			'X_RV_Webhook_Source' => site_url(),
			'X_RV_Webhook_Topic' => $product_update_hook['topic'],
			'X_RV_Webhook_Signature' => '',
		);
		
		$data_for_sec = $body_arr;
		unset($data_for_sec['X_RV_Webhook_Signature']);
		
		//Create a singnature for security
		$signature = hash_hmac('sha256', http_build_query($data_for_sec), $api_data->consumer_secret, false);
		$body_arr['X_RV_Webhook_Signature'] = $signature;
	    
	    $response = wp_remote_post( $product_update_hook['delivery_url'], array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => $body_arr,
			'cookies' => array()
		    )
		);
		
		//print_r($response['body']); exit;
    }
}

/**
 * @snippet       Do Something When Product is Published
 * @author        Tai
 * @testedwith    WooCommerce 3.2.6
 */
function ryviu_store_custom_hook( $new_status, $old_status, $post ) {
 
    global $post;
    if ($post && $post->post_type){
		if ( $post->post_type == 'product' ){
			if ( 'publish' == $new_status && 'draft' == $old_status ) {
			    //Create product 
			    ryviu_hook_send('product-create', $post);
		    }
		    
		    if ( 'trash' == $new_status && 'publish' == $old_status ) {
			    //Delete product
			    ryviu_hook_send('product-delete', $post);
		    }
		}
		
		if ( $post->post_type == 'shop_order' ){
			if ( 
				('wc-completed' == $new_status && 'wc-completed' == $old_status) 
				|| 
				('draft' == $new_status && 'draft' == $old_status)  
			) {
			    //order update
			    ryviu_hook_send('order-update', $post);
		    }
		}
	}
}
add_action( 'transition_post_status', 'ryviu_store_custom_hook', 10, 3 );