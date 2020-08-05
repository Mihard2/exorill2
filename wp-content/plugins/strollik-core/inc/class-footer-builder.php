<?php

class OSF_Footer_builder {

    public static $instance;

    private $content = '';

    public static function getInstance() {
        if (!isset(self::$instance) && !(self::$instance instanceof OSF_Footer_builder)) {
            self::$instance = new OSF_Footer_builder();
        }

        return self::$instance;
    }

    public function __construct() {
        add_action( 'wp', array( $this, 'setup_object' ) );
        add_action('wp', array($this, 'setup_footer'));
        add_action('admin_bar_menu', array($this, 'custom_button_footer_builder'), 50);
    }

    /**
     * @param $wp_admin_bar WP_Admin_Bar
     */
    public function custom_button_footer_builder($wp_admin_bar) {
        global $osf_footer;
        if ($osf_footer && $osf_footer instanceof WP_Post) {
            $args = array(
                'id'    => 'footer-builder-button',
                'title' => __('Edit Footer', 'strollik-core'),
                'href'  => add_query_arg('action', 'elementor', remove_query_arg('action', get_edit_post_link($osf_footer->ID))),
//            'meta'  => array(
//                'class' => 'custom-button-class'
//            )
            );
            $wp_admin_bar->add_node($args);
        }
    }

    public function setup_object(){
        global $osf_footer;
        if (osf_get_metabox(get_the_ID(), 'osf_enable_custom_footer', false)) {
            $footer_slug = osf_get_metabox(get_the_ID(), 'osf_footer_layout', '');
            if(!$footer_slug){
                $footer_slug = get_theme_mod('osf_footer_layout', '');
            }
        } else {
            $footer_slug = get_theme_mod('osf_footer_layout', '');
        }

        $osf_footer = get_page_by_path($footer_slug, OBJECT, 'footer');

        $id = apply_filters( 'wpml_object_id', $osf_footer->ID, 'footer' );
        if($id !== $osf_footer->ID){
            $osf_footer = get_post($id);
        }

    }


    public function setup_footer() {
        global $osf_footer;

        if ($osf_footer && $osf_footer instanceof WP_Post) {
            $this->content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $osf_footer->ID );
        }
    }

    public function render(){
        return $this->content;
    }

}

OSF_Footer_builder::getInstance();