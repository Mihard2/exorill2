<?php // Silence is golden
require_once("../../../wp-load.php");
require_once 'includes/ajax-handle.php';

header('Access-Control-Allow-Headers: Content-Type');  
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');  
header('Access-Control-Allow-Origin: https://www.ryviu.com');

global $wpdb;

if($_REQUEST && isset($_REQUEST['action'])){
	$action = $_REQUEST['action'];
	
	if($action == 'updateSettings'){
		$data = $_REQUEST['data'];
		
		if ( base64_encode(base64_decode($data)) === $data){
		    $data = base64_decode($_REQUEST['data']);
			update_option( 'ryviu_user_settings', $data );
			
			wp_send_json( array(
				'msg' => 'Data updated!'
			) );
		}else{
			wp_send_json( array(
				'msg' => 'Data error!'
			) );
		}
	}else{
		if ( is_user_logged_in() ) {
			do_action( 'ryviu_ajax_' . $_REQUEST['action'] );
		} else {
			do_action( 'ryviu_ajax_nopriv_' . $_REQUEST['action'] );
		}
	}
	
	die('0');
}else{
	die('0');
}