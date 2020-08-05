<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.ryviu.com
 * @since             2.0.0
 * @package           Ryviu
 *
 * @wordpress-plugin
 * Plugin Name:       Ryviu - Product Reviews for WooCommerce
 * Plugin URI:        https://www.ryviu.com
 * Description:       Display reviews in product page for woocommerce, manager data and get from https://app.ryviu.io
 * Version:           3.1.18
 * Requires at least: 4.0
 * Tested up to:      5.4
 * WC requires at least: 3.0
 * WC tested up to: 4.1
 * Author:            Ryviu
 * Author URI:        https://www.ryviu.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ryviu
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define('RYVIU_WOO_VERSION', '3.1.18');
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
define('RYVIU_DIR_PATH', plugin_dir_path(__FILE__) );
define('RYVIU_URL_ASSETS', plugins_url( 'assets/', __FILE__ ) );
define('RYVIU_APP_HOOK_URL', 'https://app.ryviu.io/webhook/woocommerce/');

/**
 * The code that runs during plugin activation.
 */
function activate_ryviu() {
	$options = get_option( 'ryviu_settings_reviews' );
	
	$default_opt = array(
		'position_display' => 1,
		'priority_position_display' => 50,
		'position_display_widget' => 2,
		'priority_position_display_widget' => 50,
		'position_display_widget_in_loop' => 6,
		'priority_position_display_widget_in_loop' => 50,
		'active_reviews_tab' => 0,
		'wordpress_theme' => 'default',
		'question_and_answer' => 0
	);
	
	if(is_array($options) && $options){
		update_option('ryviu_settings_reviews', $options);
	}else{
		add_option('ryviu_settings_reviews', $default_opt);
	}
	add_rewrite_rule('^ryviu-json/([^/]*)/?$','index.php?ryviu=port&type=ryviu-action&endpoint=$matches[1]','top');
	add_rewrite_rule('^products/([^/]*).json/?$','index.php?ryviu=json&type=product_detail&handle=$matches[1]','top');
	flush_rewrite_rules();
}
// Check if do not connect show Notice Need connect Ryviu
function check_connect_ryviu() {
	$settings = get_option( 'ryviu_client_settings' ); 
	if(!$settings || $settings == new \stdClass()){ 
		$shop_domain = str_replace( array( 'http://', 'https://' ), '', site_url() );
		$url = 'https://app.ryviu.io/client/settings/'.base64_encode($shop_domain);
		
		try{
			$settings_info = wp_remote_get( $url, ['timeout' => 3] ); 
		
			if ( is_wp_error( $settings_info ) ) {
			   $settings = '';
			} else {
			   if(isset($settings_info['body'])){
					$body = $settings_info['body'];
					$settings_body = json_decode($body); 
					if($settings_body->status == 'error'){
						$settings = '';
					}else{
						$settings_ryviu = $settings_body->settings;
						$update_settings = json_decode($settings_ryviu);
						$settings = json_encode($update_settings);
						if($update_settings){
							update_option( 'ryviu_client_settings', $update_settings );
						}
					}
				}
			}
		}catch(Exception $e){
			//handle exception
		}
	}
}
function r_admin_notices() {
	$settings = get_option( 'ryviu_client_settings' ); 
	if(!$settings || $settings == new \stdClass()){ 
		echo '<div class="notice notice-error is-dismissible"><p><b>The Ryviu plugin is almost ready.</b> <a target="_blank" href="https://app.ryviu.io/platform">Connect Ryviu</a> to complete your configuration.</p></div>';
	}
}
/**
 * The code that runs during plugin deactivation.
 */
function deactivate_ryviu() {

}
//uninstall send request to app to delete url shop
function uninstall_ryviu(){
	delete_option( 'ryviu_client_settings' );
	delete_option( 'ryviu_settings_reviews' );
	$shop_domain = str_replace( array( 'http://', 'https://' ), '', site_url() );
	wp_remote_post( RYVIU_APP_HOOK_URL.'uninstall-woo', array( 'body' => array('domain' => site_url())));
}

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'code_add_plugin_page_settings_link');

function code_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'options-general.php?page=ryviu-setting-admin' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}

check_connect_ryviu();
register_activation_hook( __FILE__, 'activate_ryviu' );
register_deactivation_hook( __FILE__, 'deactivate_ryviu' );
register_uninstall_hook( __FILE__, 'uninstall_ryviu' );
add_action( 'admin_notices','r_admin_notices');

$active_plugins = get_option( 'active_plugins' );
$ryviuStatus = false;
$ryviu_index = 0;
$wc_index = 0;
	 
foreach($active_plugins as $key => $plugin){
	if($plugin == 'ryviu/ryviu.php'){ 
		$ryviu_index = $key;
		$ryviuStatus = true;
	}
	if($plugin == 'woocommerce/woocommerce.php') $wc_index = $key;
}
if ($ryviuStatus){
	if($wc_index > $ryviu_index){
		$active_plugins[$ryviu_index] = 'woocommerce/woocommerce.php';
		$active_plugins[$wc_index] = 'ryviu/ryviu.php';
		update_option( 'active_plugins',  $active_plugins);
	}
}

//Include main ryviu class
require plugin_dir_path( __FILE__ ) . 'includes/class-ryviu.php';

//Main Class Called
function RYVIU() {
	return ryviu_woo::instance();
}

$GLOBALS['RYVIU'] = RYVIU();