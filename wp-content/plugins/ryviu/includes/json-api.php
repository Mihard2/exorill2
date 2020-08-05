<?php
header('Access-Control-Allow-Headers: Content-Type');  
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');  
header('Access-Control-Allow-Origin: *');
/**
* Ryviu JSON API
*/
class ryviu_json_ap {

	public function __construct(){
		add_action( 'init', array( $this, 'rewrite_products_url'), 10, 0);
		add_action( 'init', array( $this, 'rewrite_product_url'), 10, 0);
		add_filter( 'query_vars', array( $this, 'query_vars' ), 1 );
		add_action( 'template_redirect', array( $this, 'get_json_info'), 20, 0);
		
		add_image_size( 'ryviu-small', 40, 40, true );
		add_image_size( 'ryviu-medium', 132, 132, true );
	}
	
	public function query_vars( $vars ){
		array_push( $vars, 'ryviu' );
		array_push( $vars, 'type' );
		array_push( $vars, 'handle' );
		return $vars;
	}
	
	public function rewrite_products_url() {
		add_rewrite_rule('^products.json/?$','index.php?ryviu=json&type=products_list','top');
		add_rewrite_tag('%ryviu%', '([^&]+)');
	}
	
	public function rewrite_product_url() {
		add_rewrite_rule('^products/([^/]*).json/?$','index.php?ryviu=json&type=product_detail&handle=$matches[1]','top');
	}
	
	public function get_json_info(){
		if(! is_admin()){
			
			if(get_query_var('ryviu') && get_query_var('ryviu') == 'json'){
				global $wp_query;
				
				if( get_query_var('type') == 'products_list'){
					//error_reporting(E_ERROR | E_PARSE);
					header( 'Content-type: application/json' );
					
					$products_data = $products = array();
					
					$args = array(
				        'post_type' => 'product',
				        'posts_per_page' => -1
				    );
				    
				    $loop = new WP_Query( $args );
				    if ( $loop->have_posts() ): while ( $loop->have_posts() ): $loop->the_post();
					//==================================
				        global $product;
				        $id = $loop->post->ID;
				        
				        $product = wc_get_product( $id );
				        //print_r($product);
				        $title = $product->name;
				        $handle = $product->slug;
				        $body_html = $product->description;
				        $published_at = str_replace(' ', 'T', $product->date_created->date('Y-m-d H:i:s'));
				        $created_at = str_replace(' ', 'T', $product->date_created->date('Y-m-d H:i:s'));
				        $updated_at = str_replace(' ', 'T', $product->date_modified->date('Y-m-d H:i:s'));
				        $vendor = 'ryviu';
				        $product_type = '';
				        $tags = $variants = $images = $options = array();
				        
				        $attachment_ids = $product->get_gallery_image_ids();
							
						foreach( $attachment_ids as $attachment_id ){
							$att_info = get_post($attachment_id);
							//print_r($att_info);
							$images[] = array(
								'id' => $attachment_id,
								'product_id' => $id,
								'created_at' => str_replace( ' ', 'T', $att_info->post_date),
								'updated_at' => str_replace( ' ', 'T', $att_info->post_modified),
								'src' => wp_get_attachment_url( $attachment_id )
							);
						}
				        
				        $products[] = array(
					        'id' => $id,
					        'title' => $title,
					        'handle' => $handle,
					        'body_html' => $body_html,
					        'published_at' => $published_at,
					        'created_at' => $created_at,
					        'updated_at' => $updated_at,
					        'vendor' => $vendor,
					        'product_type' => $product_type,
					        'tags' => $tags,
					        'variants' => $variants,
					        'images' => $images,
					        'options' => $options
				        );
				
					//==================================
				    endwhile; endif; wp_reset_postdata();
					
					$products_data = array(
						'products' => $products
					);
					
					wp_send_json( $products_data );
				}
				
				if( get_query_var('type') == 'product_detail'){
					header( 'Content-type: application/json' );
					
					$handle = get_query_var('handle');
					
					if($handle){
						global $product;
						
						$product_obj = get_page_by_path( $handle, OBJECT, 'product' );
						
						if( isset($product_obj->ID) ){
							$id = $product_obj->ID;
							$data_product = wc_get_product( $id );
							$product = $data_product->get_data();
							$title = $product['name'];
					        
					        
					        $handle = $product['slug'];
					        $body_html = $product['description']; //print_r($product);
					        $published_at = str_replace(' ', 'T', $product['date_created']->date('Y-m-d H:i:s'));
					        $created_at = str_replace(' ', 'T', $product['date_created']->date('Y-m-d H:i:s'));
					        $updated_at = str_replace(' ', 'T', $product['date_modified']->date('Y-m-d H:i:s'));
					        $vendor = 'ryviu';
					        $product_type = '';
					        $tags = $variants = $images = $options = array();
					        
					        $img_id = $product['image_id'];
					        $image = array(
						        'id' => $img_id,
						        'product_id' => $id,
						        'position' => 1,
						        'created_at' => $created_at,
						        'updated_at' => $updated_at,
						        'width' => 800,
						        'height' => 800,
						        'woo_src' => $this->get_feature_product_image($id),
						        'src' => ''
					        );
					        

							$attachment_ids = $data_product->get_gallery_image_ids();
							
							foreach( $attachment_ids as $attachment_id ){
								$att_info = get_post($attachment_id);
								//print_r($att_info);
								$images[] = array(
									'id' => $attachment_id,
									'product_id' => $id,
									'created_at' => str_replace( ' ', 'T', $att_info->post_date),
									'updated_at' => str_replace( ' ', 'T', $att_info->post_modified),
									'src' => wp_get_attachment_url( $attachment_id )
								);
							}
														
							$product_arr = array(
								'id' => $id,
								'title' => $title,
								'body_html' => $body_html,
								'vendor' => $vendor,
								'product_type' => '',
								'created_at' => '',
								'handle' => $handle,
								'updated_at' => $updated_at,
								'published_at' => $published_at,
								'template_suffix' => null,
								'published_scope' => 'global',
								'tags' => $tags,
								'variants' => $variants,
								'options' => $options,
								'images' => $images,
								'image' => $image
							);
							
							$product_data = array(
								'product' => (OBJECT) $product_arr
							);
							wp_send_json( $product_data );
						}else{
							wp_send_json( array('error'=> 'Not Found') );
						}
						
					}
					
				}
			}
			
		}
		
	}
	
	public function get_feature_product_image( $product_id ){
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'thumbnail' );
		
		if($image){
			return $image[0];
		}else{
			return null;
		}		
	}

}

new ryviu_json_ap();
