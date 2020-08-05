<?php
/*
|--------------------------------------------------------------------------
| Ryviu Connect API
|--------------------------------------------------------------------------
|
| Do some hook wordpress > woocommerce
|
*/

class RyviuApiController {

	/**
     * Allow method for endpoint
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	protected $endpoint_method = array(
		'shop' => ['GET'],
		'update-metafields' => ['POST'],
		'update-settings' => ['POST']
	);


	/**
     * __construct
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function __construct(){
		RyviuApiController::_header();
	}
	
	
	/**
     * Set access control allow header
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function _header(){
		header('Access-Control-Allow-Headers: Content-Type');  
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS');  
		header('Access-Control-Allow-Origin: https://app.ryviu.io');
	}
		
		
	/**
     * Request data
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function request(){
		$data_input = json_decode(file_get_contents("php://input"));
		if(!$data_input){
			$data_input = array();
		}	
		
		$request = array_merge($_REQUEST, $data_input);
		
		return $request;
	}
	
	
	/**
     * Check request endpoint
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function check($request, $endpoint){
		global $wpdb;
		
		$_this = new self;
		
		if(empty($endpoint)){
			wp_die('Error: Empty endpoint!', 'Request Error', array('response' => 405));
		}
		
		$fc = false;

		foreach($_this->endpoint_method as $_endpoint => $_allow_method){
			if($_endpoint === $endpoint && in_array($_SERVER['REQUEST_METHOD'], $_allow_method)){
				$fc = true;
			}
		}
		
		if (!$fc) {
			wp_die('Method not allowed', 'Request Error', array('response' => 405));
		}

		$request_error = false;
		if($request){
			update_option('ryviu_request', $request);
			
			$wc_api_table = $wpdb->prefix.'woocommerce_api_keys';
			$consumer_key = isset($request['consumer_key'])? $request['consumer_key']: '';
			$consumer_secret = isset($request['consumer_secret'])? $request['consumer_secret']: '';
			$consumer_key = wc_api_hash($consumer_key);	
			
			$results = $wpdb->get_results( "SELECT * FROM $wc_api_table WHERE consumer_key = '$consumer_key' AND consumer_secret = '$consumer_secret'" );

			if(!$results){
				$request_error = true;
			}
		}else{
			$request_error = true;
		}
		
		if($request_error){
			wp_die('Wrong key and secret!', 'Request Error', array('response' => 401));
		}
	}
	
	
	/**
     * Do actions
     *
     * @param Request object $endpoint Data.
     * @return JSON data
     */
	public static function doAction($endpoint = ''){
		$request = self::request();
		
		self::check($request, $endpoint);
		
		switch ($endpoint) {
			case 'shop': {
					$output_array = array(
						'endpoint' => $endpoint,
						'shop_url' => get_permalink( wc_get_page_id( 'shop' ) )
					);
					wp_send_json( $output_array, 200 );
				}
				break;
				
		    case 'update-metafields':
		    	$namespace = isset($request['namespace'])? $request['namespace']: 'ryviu';
			    $product_id = isset($request['product_id'])? $request['product_id']: 0;
			    $meta_key = isset($request['meta_key'])? $request['meta_key']: '';
			    $meta_value = isset($request['meta_value'])? $request['meta_value']: '';
			    
			    $meta_key = $namespace.'_'.$meta_key;
			    
			    if($product_id && $meta_key){
				    self::updateProductMetafield($product_id, $meta_key, $meta_value);
			    }else{
				    wp_die( 'Empty product ID or meta key', 'Request Error' );
			    }
		        
		        break;
		        
		    case 'update-settings':
			    $settings = base64_decode($request['settings']);
			    $key_id = $request['api_id'];
			    
			    if($settings){
				    self::updateSettings( 'ryviu_client_settings', json_decode($settings) );
			    }
			    
			    if($key_id){
				    self::updateSettings( 'ryviu_user_api_key_id', $key_id );
			    }
		        
		        break;
		}
		
		wp_send_json( ['endpoint' => $endpoint], 200 );
	}
	
	
	/**
     * Update product metafield
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function updateProductMetafield($product_id, $meta_key, $meta_value){
		if ( get_post_status ( $product_id ) ) {
		    update_post_meta($product_id, $meta_key, $meta_value);
		}
	}
	
	
	/**
     * Update settings
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function updateSettings($option_key, $option_value){
		update_option($option_key, $option_value);
	}
	
	
	/**
     * Show log
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function log($data, $file = __DIR__.'/logs.txt'){
		
		if(is_object($data) || is_array($data)){
			$log_content = json_encode($data)."\n";
		}else{
			$log_content = $data;
		}
		
		file_put_contents($file, $log_content, FILE_APPEND);
	}
}


