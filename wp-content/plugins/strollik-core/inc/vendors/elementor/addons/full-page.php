<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class OSF_Elementor_Full_Page {
	public function __construct() {
		add_action('wp_enqueue_scripts', array( $this, 'add_frontend_scripts' ), 100);
		add_filter( 'body_class', array( $this, 'add_body_class' ) );
	}
	public function add_frontend_scripts() {
		if(osf_get_metabox(get_the_ID(), 'osf_enable_full_page', false)) {
			wp_enqueue_script('scrolloverflow', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/scrolloverflow.min.js', array( 'jquery' ), false, true);
			wp_enqueue_script('fullpage', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/js/libs/fullpage.min.js', array( 'jquery' ), false, true);
			wp_enqueue_style('fullpage', trailingslashit(STROLLIK_CORE_PLUGIN_URL) . 'assets/css/fullpage.css');
		}
	}
	public function add_body_class($classes) {
		if(osf_get_metabox(get_the_ID(), 'osf_enable_full_page', false)) {
			$classes[] = 'opal-fullpage';
		}
		return $classes;
	}
}
new OSF_Elementor_Full_Page();