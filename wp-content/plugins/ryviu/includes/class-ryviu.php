<?php
/**
 (C) Copryright https://www.ryviu.com
 
**/

class ryviu_woo{

	private $shop_url;
	protected static $_instance = null;

	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function __construct(){
		$this->shop_url = str_replace( array( 'http://', 'https://' ), '', site_url() );
		$this->init();
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function init(){
		$load_file = array(
			'json-api.php' 				=> 'ro',
			'ryviu-api-controller.php' 	=> 'ro',
			'settings.php' 				=> 'ro',
			'functions.php' 			=> 'ro',
			'woo-hooks.php' 			=> 'ro'
		);

		foreach( $load_file as $file => $type ){
			$_file = explode('|', $file);

			if(count($_file) > 1 ){
				$this->incl( $_file[1], $type, $_file[0]);
			}else{
				$this->incl( $file, $type );
			}
		}
		
		add_action( 'wp_enqueue_scripts', array( &$this, 'load_scripts' ), 99 );
		add_action( 'admin_enqueue_scripts', array( &$this, 'ryviu_enqueue_admin_js' ) );

		add_filter('script_loader_tag', array( &$this, 'add_async_attribute'), 10, 2);
		add_action( 'init', array( &$this, 'add_endpoint' ), 10, 1 );
		add_filter( 'query_vars', array( $this, 'query_vars' ), 1 );
		
		add_action( 'template_redirect', array( $this, 'ryviu_auth'), 20, 0);
		add_action( 'init', array( $this, 'check_rewrite' ) );
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function query_vars( $vars ){
		array_push( $vars, 'ryviu' );
		array_push( $vars, 'type' );
		array_push( $vars, 'handle' );
		array_push( $vars, 'endpoint' );
		return $vars;
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function check_rewrite(){
		if(is_admin()){
			$frr_status = get_option( 'ryviu_frr_status', 0 );
			if(!$frr_status){
				flush_rewrite_rules();
				update_option( 'ryviu_frr_status', 1 );
			}
		}
	}

	/**
	 * Add auth endpoint.
	 *
	 * @since 2.4.0
	 */
	public function add_endpoint() {
		add_rewrite_rule('^ryviu-json/([^/]*)/?$','index.php?ryviu=port&type=ryviu-action&endpoint=$matches[1]','top');
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function ryviu_auth(){
		if(! is_admin()){
			
			if(null === get_query_var( 'ryviu')){
				flush_rewrite_rules();
			}
			
			if(null !== get_query_var('ryviu') && get_query_var('ryviu') == 'port'){
				new RyviuApiController();
				
				$endpoint = get_query_var('endpoint');
				
				if(!empty($endpoint)){
					RyviuApiController::doAction($endpoint);
				}
			}
		}
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function incl( $file, $type = 'i', $dir = 'includes' ){
		$dir_file = RYVIU_DIR_PATH . $dir . DS . $file;

		if(file_exists($dir_file)){
			switch ( $type ) {
				case 'r':
					require $dir_file;
					break;

				case 'ro':
					require_once $dir_file;
					break;

				default:
					include $dir_file;
					break;
			}
		}else{
			die('Error: File '.$dir_file.' does not exists.');
		}
	}

	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	function ryviu_enqueue_admin_js($hook) {
	    if ( 'settings_page_ryviu-setting-admin' == $hook ) {
	        wp_enqueue_script( 'ryviu_admin_script', RYVIU_URL_ASSETS.'js/admin-local-ryviu.js' );
	    }

		if($hook == 'edit.php'){
			wp_enqueue_script( 'ryviu_product_script', RYVIU_URL_ASSETS.'js/ryviu-product.js', array(),RYVIU_WOO_VERSION, true );
			wp_enqueue_style( 'woo_ryviu_products', RYVIU_URL_ASSETS.'css/woo-product.css' );
		}
	}
	
	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function get_styles(){
		$styles = array(
			//'src' => RYVIU_URL_ASSETS.'css/woo-products.css'
		);

		return apply_filters( 'ryviu_app_styles', $styles );
	}
	
	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function add_async_attribute($tag, $handle) {
		if ( 'ryviu-app' !== $handle ){
			return $tag;
		}else{
			$options = get_option( 'ryviu_settings_reviews' );
			$rocket_param = '';

			if(is_array($options) && isset($options['data_rocket_status']) && $options['data_rocket_status'] != ''){
				$rocket_status = $options['data_rocket_status'];
				
				if($rocket_status == 'on'){
					return str_replace( ' src', ' data-cfasync="false" src', $tag );
				}else{
					return $tag;
				}
			}else{
				return $tag;
			}
		}
	}

	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	public function load_scripts() {

		$options  = get_option( 'ryviu_settings_reviews' );
		$settings = get_option( 'ryviu_client_settings' ); 
		if($settings && $settings != new \stdClass()){ 
			$rocket_param = '';

			if(is_array($options) && isset($options['data_rocket_status']) && $options['data_rocket_status'] !== ''){
				$rocket_status = $options['data_rocket_status'];
				
				if($rocket_status == 'on'){
					$rocket_param = '&rocket=true';
				}
			}
			$ryviu_scripts_app = array(
				'ryviu-app' => 'https://cdn.ryviu.com/v/static/js/app.js?shop='. $this->shop_url . $rocket_param.'&t='.time(),
				'ryviu-local' => RYVIU_URL_ASSETS.'js/local-ryviu.js'
			);

			wp_enqueue_style( 'ryviu-local-css', RYVIU_URL_ASSETS.'css/local-ryviu.css', array(), RYVIU_WOO_VERSION );
			
			foreach ($ryviu_scripts_app as $key => $script) {
				wp_enqueue_script($key, $script, array(), RYVIU_WOO_VERSION , true );
			}

			
			if ( $enqueue_styles = $this->get_styles() )
			{
				foreach ( $enqueue_styles as $handle => $args ) {
					wp_enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
				}
			}
		}
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	private function register_script( $handle, $path, $deps = array( 'jquery' ), $version = RYVIU_WOO_VERSION, $in_footer = true ) {
		$this->scripts[] = $handle;
		wp_register_script( $handle, $path, $deps, $version, $in_footer );
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	private function register_style( $handle, $path, $deps = array(), $version = RYVIU_WOO_VERSION, $media = 'all' ) {
		$this->styles[] = $handle;
		wp_register_style( $handle, $path, $deps, $version, $media );
	}


	/**
     * Description for this functions
     *
     * @param Request object $request Data.
     * @return JSON data
     */
	private function enqueue_script( $handle, $path = '', $deps = array( 'jquery' ), $version = RYVIU_WOO_VERSION, $in_footer = true ) {
		if ( ! in_array( $handle, $this->scripts ) && $path ) {
			$this->register_script( $handle, $path, $deps, $version, $in_footer );
		}
		wp_enqueue_script( $handle );
	}
}