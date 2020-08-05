<?php
/**
 (C) Copryright https://www.ryviu.com
 
**/


/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_hello_world(){
    return __('Ryviu hello world!', 'ryviu');
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
add_action( 'wp_head', 'ryviu_set_flatform' );
function ryviu_set_flatform(){
	global $post;
	$settings = get_option( 'ryviu_client_settings' ); 
	if(!$settings || $settings == new \stdClass()){ 
		$settings = '';
	}else{
		if($settings != ''){
			$settings = json_encode($settings);
		}
	}
	
	$shop_url = site_url();
	$domain = str_replace(array('https://', 'http://'), '', $shop_url);
	
	if($settings){
		echo '<script type="text/javascript">var ryviu_WC = {domain: "'. $domain .'", shop_url: "'. $shop_url .'"}, ryviu_global_settings = '.$settings.'</script>';
	}
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
//Add app settings for js to wp header
add_action( 'wp_head', 'ryviu_custom_script_header' );
function ryviu_custom_script_header(){
	global $RYVIU;
	
	$active_reviews_tab = ryviu_settings::get_option( 'active_reviews_tab' );
	$active_reviews_tab = (isset($active_reviews_tab) && !empty($active_reviews_tab )) ? 1 : 0;
	$position_display = ryviu_settings::get_option( 'position_display' );
	$position_display = (isset($position_display) && !empty($position_display )) ? $position_display : 1;
	
	$enable_ajax_add_to_cart = ryviu_settings::get_option( 'enable_ajax_add_to_cart' );
	$enable_ajax_add_to_cart = (isset($enable_ajax_add_to_cart) && !empty($active_reviews_tab) ) ? 1 : 0;
	
	echo '<script type="text/javascript">var ryviu_app = {active_reviews_tab: '. $active_reviews_tab .', position_display: '. $position_display .', enable_ajax_add_to_cart: '.$enable_ajax_add_to_cart.'};</script>';
}

/**
 Make some display setting for ryviu
**/
$position_display 					= ryviu_settings::get_option('position_display');
$position_display_widget 			= ryviu_settings::get_option('position_display_widget');
$position_display_widget_in_loop 	= ryviu_settings::get_option('position_display_widget_in_loop');
$question_and_answer 	            = ryviu_settings::get_option('question_and_answer');

if($question_and_answer == 1){
	add_action( 'woocommerce_after_single_product_summary', 'ryviu_add_questions_answers_section', 10);
}else{
	add_action( 'ryviu_question_and_answer', 'ryviu_add_questions_answers_section', 20);
}


if($position_display){
	switch($position_display){
		case 1: {
				
				$priority = 65;
				if(null !== ryviu_settings::get_option('position_display')){
					$priority = ryviu_settings::get_option('priority_position_display');
				}
				
				add_filter( 'woocommerce_product_tabs', 'woo_ryviu_review_product_tab', $priority );
			}
			break;
		
		case 11:
		case 4: {
				$config_hook = ryviu_display_position_hook();
				$config = $config_hook[$position_display];
				
				$priority = 10;
				if(null !== ryviu_settings::get_option('position_display')){
					$priority = ryviu_settings::get_option('priority_position_display');
				}
				
				add_action( $config['hook_name'], 'ryviu_product_display_review', $config['priority'] );
			}
			break;
			
		case 10: {
				$priority = 20;
				if(null !== ryviu_settings::get_option('position_display')){
					$priority = ryviu_settings::get_option('priority_position_display');
				}
				
				add_action('ryviu_display_review', 'ryviu_product_display_review', 20 );
			}
			break;
	}
}

if($position_display_widget){
	switch($position_display_widget){
		case 2:
		case 3: {
				$config_hook = ryviu_display_position_hook();
				$config = $config_hook[$position_display_widget];
				
				add_action( $config['hook_name'], 'ryviu_widget_rating_total', $config['priority'] );
			}
			break;
			
		case 10: {
				add_action('ryviu_display_total_review', 'ryviu_widget_rating_total', 20 );
			}
			break;
	}
}


if($position_display_widget_in_loop){
	switch($position_display_widget_in_loop){
		case 5:
		case 6: {
				$config_hook = ryviu_display_position_hook();
				$config = $config_hook[$position_display_widget_in_loop];

				add_action( $config['hook_name'], 'ryviu_widget_rating_total_in_product_category', $config['priority'] );
			}
			break;
			
		case 10: {
				add_action('ryviu_display_review_total_in_loop', 'ryviu_widget_rating_total_in_product_category', 20 );
			}
			break;
	}
}


/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
/* Functions includes html block for ryviu
--------------------------------------------------*/
function ryviu_add_questions_answers_section(){
	global $product;
	if($product && $product->get_slug()){
		$product_handle = '';
		if(is_string($product)){
			$product_handle = $product;
		}else if(is_object($product)){
			$product_handle = $product->get_slug();
		}
		if($product_handle){
			echo "<div class=\"lt-block-reviews\"><questions-answers handle=\"$product_handle\"></questions-answers></div>";
		}
	}
}

function ryviu_widget_rating_total_in_product_category(){
	global $product;
    //get product handle
    if($product && $product->get_slug()){
	    $product_handle = $product->get_slug();
		if(!$product_handle) $product_handle = $product->post->post_name;
	
		// add review wiget total
		echo '<div class="ryviu-collection"><ryviu-widget-total 
			collection="1"
			product_id = "'.$product->get_id().'"
			handle="'.$product_handle.'"
			reviews_data="'. htmlspecialchars(get_post_meta( $product->get_id(), 'ryviu_product_reviews_info', true ), ENT_QUOTES, 'UTF-8') .'">
		</ryviu-widget-total></div>';
	}
}


function ryviu_wiget_get_meta_info($product, $alway_update = false){
	$shop_domain = str_replace( array( 'http://', 'https://' ), '', site_url() );
	
	$product_handle = $product->get_slug();
	if(!$product_handle) $product_handle = $product->post->post_name;
	
	$data = array(
		'domain' => $shop_domain,
		'handle' => $product_handle
	);
	
	$url = 'https://app.ryviu.io/client/mt/'.base64_encode(json_encode($data));
	
	$meta_info_res = wp_remote_get( $url, ['timeout' => 3] );
	
	if ( is_wp_error( $meta_info_res ) ) {
		$meta_info_obj = '0;0';
		return $meta_info_obj;
	} else {
		$meta_info = $meta_info_res['body']; 
		
		if(isset($meta_info_obj->total) && $meta_info_obj->total > 0){
			$meta_info_obj = json_decode($meta_info);
			update_post_meta( $product->get_id(), 'ryviu_product_reviews_info', $meta_info );
		}else{
			$meta_info_obj = $meta_info = str_replace('"','',$meta_info);
		}
		
		if($alway_update){
			update_post_meta( $product->get_id(), 'ryviu_product_reviews_info', $meta_info );
		}
		return $meta_info_obj;
	}
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_widget_rating_total(){
	global $product;
	
	//get product handle
	if($product && $product->get_slug()){
		$product_handle = $product->get_slug();
		if(!$product_handle) $product_handle = $product->post->post_name;
	
		$metaInfo = get_post_meta( $product->get_id(), 'ryviu_product_reviews_info', true );
		
		if($metaInfo){
			$metaInfoObj = json_decode($metaInfo);
			
			if(isset($metaInfoObj->total) && $metaInfoObj->total == 0){
				ryviu_wiget_get_meta_info($product);
			}
		}else{
			ryviu_wiget_get_meta_info($product);
		}
		
		// add review wiget total
		echo '<div class="review-widget"><ryviu-widget-total  
			product_id = "'.$product->get_id().'"
			handle="'.$product_handle.'"
			reviews_data="'. htmlspecialchars(get_post_meta( $product->get_id(), 'ryviu_product_reviews_info', true ), ENT_QUOTES, 'UTF-8') .'">
		</ryviu-widget-total></div>';
	}
    
}

function add_google_snippet( $markup, $product ) {
	global $product;
	
	$product_reviews_info = get_post_meta( $product->get_id(), 'ryviu_product_reviews_info', true );
	if($product_reviews_info && strpos($product_reviews_info, '{}') <= -1 ){
		if(strpos($product_reviews_info, 'total') ){
			$product_reviews_info = json_decode($product_reviews_info);
			$total_reviews = isset($product_reviews_info->total)? $product_reviews_info->total: 0;
			$avg = round($product_reviews_info->avg, 1);
		}else{
			$product_reviews_info = explode(";",$product_reviews_info);
			$total_reviews = $product_reviews_info[0];
			$avg = $product_reviews_info[1];
		}
		
		if($total_reviews > 0){
			unset( $markup['aggregateRating'] );
			$markup['aggregateRating'] = array(
				'@type'       => 'AggregateRating',
				'ratingValue' => $avg,
				'reviewCount' => $total_reviews,
			);
		}
		
	}
	return $markup;
}
add_filter( 'woocommerce_structured_data_product', 'add_google_snippet', 10, 2 );

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_product_display_review(){
    global $product;
    if($product && $product->get_slug()){
	    $product_handle = $product->get_slug();
		if(!$product_handle) $product_handle = $product->post->post_name;
		
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );
		
		if($product_handle){
			echo '<div class="lt-block-reviews"><ryviu-widget handle="'.$product_handle.'" product_id="'.$product->get_id().'" title_product="'.$product->get_name().'" image_product="'.$image[0].'"></ryviu-widget></div>';
		}
	}
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
 

function woo_ryviu_review_product_tab( $tabs ) {
	global $product;
	if($product && $product->get_id()){
		$product_reviews_info = get_post_meta( $product->get_id(), 'ryviu_product_reviews_info', true );
		$custom_title = ryviu_settings::get_option('custom_tab_title');
		$custom_title = isset($custom_title)? $custom_title: 'Reviews (%total_number%)';
		if ($custom_title == '') {
		    $custom_title = 'Reviews (%total_number%)';
		}
		
		if(strpos($product_reviews_info, '{}') > -1 ){
			$custom_title = str_replace('(%total_number%)', '', $custom_title);
		}else{
			if(strpos($product_reviews_info, 'total') ){
				$product_reviews_info = json_decode($product_reviews_info);
				$total_reviews = isset($product_reviews_info->total)? $product_reviews_info->total: 0;
			}else{
				$product_reviews_info = explode(";",$product_reviews_info);
				$total_reviews = $product_reviews_info[0];
			}
			if($total_reviews == ''){
				$custom_title = str_replace('(%total_number%)', '', $custom_title);
			}else{
				$total_reviews = '('.$total_reviews.')';
				$custom_title = str_replace('(%total_number%)', $total_reviews, $custom_title);
			}
		}
	    
	    $tabs['ryviu_reviews_tab'] = array(
	        'title'     => __( $custom_title, 'woocommerce' ),
	        'priority'  => 50,
	        'callback'  => 'ryviu_product_display_review'
	    );

	    unset($tabs['reviews']);

	    return $tabs;
	}
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_display_position_hook($name = ''){
	
	$options = get_option( 'ryviu_settings_reviews' );
	$hook_after_pr = $hook_before_pr = $after_single = 'woocommerce_single_product_summary';
	$hook_after_cl = 'woocommerce_after_shop_loop_item_title';
	if(is_array($options) && isset($options['wordpress_theme']) && $options['wordpress_theme'] == 'ocean'){
		$hook_after_pr = 'ocean_before_single_product_price';
		$hook_after_cl = 'ocean_before_archive_product_inner';
	}
	$p = array(
        '1' => array(
            'type' => 'replace',
            'title' => 'Replace default reviews',
            'hook_name' => '',
            'priority' => 55
        ),
        '2' => array(
            'type' => 'position',
            'title' => 'After single product title',
            'hook_name' => $hook_after_pr,
            'priority' => 10
        ),
        '3' => array(
            'type' => 'position',
            'title' => 'Before single product title',
            'hook_name' => $hook_before_pr,
            'priority' => 3
        ),
        '11' => array(
            'type' => 'position',
            'title' => 'After single product summary',
            'hook_name' => 'woocommerce_after_single_product_summary',
            'priority' => 10
        ),
        '4' => array(
            'type' => 'position',
            'title' => 'After single product sharing',
            'hook_name' => $after_single,
            'priority' => 55
        ),
        '5' => array(
            'type' => 'position',
            'title' => 'Before product title',
            'hook_name' => 'woocommerce_before_shop_loop_item_title',
            'priority' => 8
        ),
        '6' => array(
            'type' => 'position',
            'title' => 'After product title',
            'hook_name' => $hook_after_cl,
            'priority' => 12
        ),
        '10' => array(
            'type' => 'custom',
            'title' => 'Custom Position',
            'hook_name' => 'ryviu_display_review',
            'priority' => 55
        ),
        '99' => array(
            'type' => 'none',
            'title' => 'Disable',
            'hook_name' => 'ryviu_display_none',
            'priority' => 10
        ),
    );
    
    switch( $name ){
	    case 'position_display': 
	    	return array('1' => $p[1], '11' => $p[11], '4' => $p[4], '10' => $p[10]);
	    	break;
	    case 'position_display_widget': 
	    	return array('2' => $p[2], '3' => $p[3], '10' => $p[10]);
	    	break;
	    case 'position_display_widget_in_loop': 
	    	return array('99' => $p[99], '5' => $p[5], '6' => $p[6], '10' => $p[10]);
	    	break;
	    default: 
	    	return $p;
    }
    
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
add_action( 'wp_ajax_ryviu_add_to_cart', 'ryviu_add_to_cart' );
add_action( 'wp_ajax_nopriv_ryviu_add_to_cart', 'ryviu_add_to_cart' );
function ryviu_add_to_cart() {
    global $woocommerce;
	$status = false;
	
    $product_data = $_POST['data'];

    $product_id = $product_data['product_id'];
    $quantity = $product_data['quantity'];
    $variation_id = $product_data['variation_id'];
    
    $cart_count_before = $woocommerce->cart->get_cart_contents_count();
    $woocommerce->cart->add_to_cart($product_id, $quantity, $variation_id);
    $cart_count_after = $woocommerce->cart->get_cart_contents_count();
    
    if($cart_count_after > $cart_count_before){
	    $status = true;
    }
    
    $output = array(
	    'status' => $status
    );
    
    wp_send_json($output);
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
add_filter('manage_product_posts_columns', 'ryviu_woo_product_custom_columns');
function ryviu_woo_product_custom_columns($defaults) {
    $defaults['ryviu_meta']  = 'Ryviu Meta';
    
    return $defaults;
}


/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
add_action('manage_product_posts_custom_column', 'ryviu_woo_product_custom_column_content', 10, 2);
function ryviu_woo_product_custom_column_content($column_name, $post_ID) {
    if ($column_name == 'ryviu_meta') {
	    $total = $avg = 0;
	    $total_reviews = '0 review';
	    $metaInfo = htmlspecialchars(get_post_meta( $post_ID, 'ryviu_product_reviews_info', true ), ENT_QUOTES, 'UTF-8');
	    if($metaInfo){
		    if (strpos($metaInfo, ';') !== false) {
		    	// New meta format
			    list($total, $avg) = explode(';',$metaInfo);
		    }else{
		    	// Old meta format
			    $metaInfoObj = json_decode($metaInfo);
			    $total = isset($metaInfoObj->total)?$metaInfoObj->total:0;
			    $avg = isset($metaInfoObj->avg)?$metaInfoObj->avg:0;
		    }
		    if(intval($total) < 2){
			   $total_reviews = $total.' review';
			}else{
			   $total_reviews = $total.' reviews';
			}
	    }
	    echo '<a style="display: block;" href="javascript:void(0)" data-pid="'.$post_ID.'">Update Meta </a>';
        echo '<span class="rv-number">'.$total_reviews.'</span><span class="rv-rating">★ '.round($avg, 2).'</span>';
    }
}

/**
 * Description for this functions
 *
 * @param Request object $request Data.
 * @return JSON data
 */
add_action( 'wp_ajax_ryviu_update_meta', 'ryviu_update_meta_total' );
function ryviu_update_meta_total() {
	$product = wc_get_product($_POST['product_id']);
	if($product){
		$meta_info_obj = ryviu_wiget_get_meta_info($product, true);
	    wp_send_json([
		    'status' => 'success',
		    'meta_info' => $meta_info_obj
	    ]);
	}
}

/**
 * Short code show total
 *
 * @param Request object $request Data.
 * @return JSON data
 */
function ryviu_widget_total_func( $atts ) {
	$a = shortcode_atts( array(
		'product_id' => 0
	), $atts );

	ob_start();
	
	ryviu_widget_rating_total();
	
	return ob_get_clean();
}
add_shortcode( 'ryviu_widget_total', 'ryviu_widget_total_func' );

function ryviu_widget_sc( $atts ) {
	$a = shortcode_atts( array(
		'product_id' => 0
	), $atts );

	ob_start();
	
	ryviu_product_display_review();
	
	return ob_get_clean();
}
add_shortcode( 'ryviu_widget', 'ryviu_widget_sc' );

function ryviu_widget_colection_func( $atts ) {
	$a = shortcode_atts( array(
		'product_id' => 0
	), $atts );

	ob_start();
	
	ryviu_widget_rating_total_in_product_category();
	
	return ob_get_clean();
}
add_shortcode( 'ryviu_widget_colection', 'ryviu_widget_colection_func' );

function question_and_answer_func( $atts ) {
	$a = shortcode_atts( array(
		'product_id' => 0
	), $atts );

	ob_start();
	
	ryviu_add_questions_answers_section();
	
	return ob_get_clean();
}
add_shortcode( 'ryviu_question_and_answer', 'question_and_answer_func' );