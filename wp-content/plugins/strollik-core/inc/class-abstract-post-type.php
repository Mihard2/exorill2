<?php

/**
 * Class OSF_Custom_Post_Type_Abstract
 */
abstract class OSF_Custom_Post_Type_Abstract {
    public $link_image;
    public $options;

    public function __construct() {
        $this->create_post_type();
        $this->create_taxonomy();

        add_filter( 'osf_customizer_buttons', array( $this, 'customizer_buttons' ) );
        add_action( 'cmb2_admin_init', array( $this, 'create_meta_box' ) );
        add_action( 'customize_register', array( $this, 'customize_register' ) );

        add_filter( 'body_class', array( $this, 'body_class' ) );
        add_filter('opal_theme_sidebar', array($this, 'set_sidebar'));


        $this->link_image = trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/images/customize/';
        $this->options    = array(
            '2cl' => esc_url( $this->link_image . '2cl.png' ),
            '1c'  => esc_url( $this->link_image . '1col.png' ),
            '2cr' => esc_url( $this->link_image . '2cr.png' ),
        );

    }

    /**
     * @return array
     */
    public function add_shortcode() {
        return array();
    }

    /**
     * @param        $name
     * @param        $atts
     * @param string $content
     *
     * @return string
     */
    public function render_shortcode($name, $atts, $content = '') {
        $name = preg_replace( '/_/', '-', $name ) . '.php';
        $path = include locate_template( 'template-parts/shortcodes/' . $name );
        if (file_exists( $path )){
            include $path;
        }

        return '';
    }


    public function set_sidebar($name) {
        return $name;
    }

    public function body_class($classes) {
        return $classes;
    }

    /**
     * @return void
     */
    public function create_post_type() {
    }

    /**
     * @return void
     */
    public function create_taxonomy() {
    }

    /**
     * @return void
     */
    public function create_meta_box() {
    }

    /**
     * @return string
     */
    public function get_icon($name) {
        $name = wp_basename( $name, '.php' );
        if (file_exists( STROLLIK_CORE_PLUGIN_DIR . '/assets/images/post-type/' . $name . '.png' )){
            return STROLLIK_CORE_PLUGIN_URL . '/assets/images/post-type/' . $name . '.png';
        } else{
            return 'dashicons-admin-post';
        }
    }

    /**
     * @param CMB2  $cbm2
     * @param array $args
     */
    protected function init_meta_box($cbm2, $args = array(), $name) {
        $name = wp_basename( $name, '.php' );
        $args = apply_filters( 'osf_metabox_' . $name . '_fields', $args );
        foreach ($args as $arg) {
            $cbm2->add_field( $arg );
        }
    }

    public function customizer_buttons($buttons) {
        return $buttons;
    }

    public function customize_register($wp_customize) {
    }
}

