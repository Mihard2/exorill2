<?php
/*
|--------------------------------------------------------------------------
| Ryviu Ajax Handle
|--------------------------------------------------------------------------
|
| Do some hook wordpress > woocommerce
|
*/

class ryviu_ajax_handle{
	
	public $request;
	
	
	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function __construct(){
		$ajax_events = array(
			'get_welcome' => true,
			'get_product_info' => true
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {

			add_action( 'ryviu_ajax_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );

			if ( $nopriv ) {
				add_action( 'ryviu_ajax_nopriv_' . $ajax_event, array( $this, esc_attr( $ajax_event ) ) );
			}
		}
		
		$this->request = (OBJECT) $_REQUEST;
	}
	
	
	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function get_welcome(){

		$data = array(
			'message' => __('Hello Ryviu Ajax!', 'ryviu')
		);

		wp_send_json( $data );
	}
	
	
	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function get_post_id_by_slug( $slug ){
		if ( $post = get_page_by_path( $slug, OBJECT, 'product' ) )
		    $id = $post->ID;
		else
		    $id = 0;
		    
		return $id;
	}
	
	
	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function get_product_info(){
		global $product;
		
		$handle = $this->request->handle;
		
		$product_id = $this->get_post_id_by_slug($handle);
		
		$product_return = array(
			'title' => '',
			'image' => ''
		);
		
		if($product_id && function_exists('wc_get_product')){
			$product = wc_get_product($product_id);
			
			if($product){				
				$product_return['title'] = $product->get_name();
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
				$image_normal = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array( 132,132 ) );
				$image_small = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), array( 40, 40 ) );
				
				if($image[0]){
					$product_return['image'] = $image[0];
					$product_return['image_normal'] = $image_normal[0];
					$product_return['image_small'] = $image_small[0];
				}
			}
		}
		
		wp_send_json( $product_return );
	}
}

new ryviu_ajax_handle();