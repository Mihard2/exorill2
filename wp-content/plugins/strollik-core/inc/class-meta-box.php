<?php
if (!defined( 'ABSPATH' )){
    exit;
}

class OSF_Metabox {
    public function __construct() {
        add_action( 'cmb2_admin_init', array( $this, 'page_meta_box' ) );
    }

    public function page_meta_box() {
        $prefix = 'osf_';
        if (apply_filters('osf_check_page_settings', true)) {
            $this->page_meta_box_tabs();
        }
        $this->header_builder($prefix);
    }

    private function page_meta_box_tabs() {
        $prefix = 'osf_';
        $cmb2 = new_cmb2_box(array(
            'id'            => $prefix . 'page_setting',
            'title'         => __('Page Setting', 'striz-core'),
            'object_types'  => array('page'),
            'vertical_tabs' => true,
            'tabs'          => array(
                array(
                    'id'     => 'osf_page_layout1',
                    'title'  => __('Layout', 'striz-core'),
                    'fields' => array(
                        $prefix . 'enable_sidebar_page',
                        $prefix . 'sidebar_width',
                        $prefix . 'sidebar',
                        $prefix . 'enable_page_heading',
                        $prefix . 'padding_top',
                        $prefix . 'padding_bottom',
                        $prefix . 'enable_full_page',
                    ),
                ),
                array(
                    'id'     => 'osf_page_header',
                    'title'  => __('Header', 'striz-core'),
                    'fields' => array(
                        $prefix . 'enable_custom_header',
                        $prefix . 'header_layout'
                    ),
                ),
                array(
                    'id'     => 'osf_page_breadcrumb',
                    'title'  => __('Breadcrumb', 'striz-core'),
                    'fields' => array(
                        $prefix . 'enable_breadcrumb',
                        $prefix . 'breadcrumb_text_color',
                        $prefix . 'breadcrumb_bg_color',
                        $prefix . 'breadcrumb_bg_image',
                        $prefix . 'heading_color',
                    ),
                ),
                array(
                    'id'     => 'osf_page_footer',
                    'title'  => __('Footer', 'striz-core'),
                    'fields' => array(
                        $prefix . 'enable_custom_footer',
                        $prefix . 'footer_padding_top',
                        $prefix . 'footer_layout',
                        $prefix . 'enable_fixed_footer',
                    ),
                )
            )
        ));
        $cmb2->add_field(array(
            'name'        => __('Enable Sidebar', 'striz-core'),
            'id'          => $prefix . 'enable_sidebar_page',
            'type'        => 'opal_switch',
            'default'     => '0',
            'show_fields' => array(
                $prefix . 'sidebar',
            ),
        ));

        $cmb2->add_field(array(
            'name'    => __('Sidebar Width', 'striz-core'),
            'id'      => $prefix . 'sidebar_width',
            'type'    => 'opal_slider',
            'default' => '320',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '400',
                'step' => '1',
                'unit' => 'px',
            ),
        ));

        $cmb2->add_field(array(
            'name'             => __('Sidebar', 'striz-core'),
            'desc'             => 'Select sidebar',
            'id'               => $prefix . 'sidebar',
            'type'             => 'select',
            'show_option_none' => true,
            'options'          => $this->get_sidebars(),
        ));

        $cmb2->add_field(array(
            'name'    => __('Enable Page Title', 'striz-core'),
            'id'      => $prefix . 'enable_page_heading',
            'type'    => 'opal_switch',
            'default' => '1',
        ));

        $cmb2->add_field( array(
            'name'    => __( 'Padding Top', 'strollik-core' ),
            'id'      => $prefix . 'padding_top',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Padding Bottom', 'strollik-core' ),
            'id'      => $prefix . 'padding_bottom',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ),
        ) );

        if (osf_is_elementor_activated()) {
            $cmb2->add_field(array(
                'name'    => __('Enable Full Page', 'striz-core'),
                'id'      => $prefix . 'enable_full_page',
                'type'    => 'opal_switch',
                'default' => '0',
            ));
        }

        // Header
        $cmb2->add_field(array(
            'name'        => __('Enable Custom Header', 'striz-core'),
            'id'          => $prefix . 'enable_custom_header',
            'type'        => 'opal_switch',
            'default'     => '0',
            'show_fields' => array(
                $prefix . 'header_layout',
            ),
        ));
        $headers = wp_parse_args($this->get_post_type_data('header'), array(
            'default' => esc_html__('Default', 'striz-core'),
        ));
        $cmb2->add_field(array(
            'name'             => __('Layout', 'striz-core'),
            'id'               => $prefix . 'header_layout',
            'type'             => 'select',
            'show_option_none' => false,
            'default'          => 'default',
            'options'          => $headers,
        ));

        //Breadcrumb

        $cmb2->add_field(array(
            'name'        => __('Enable Breadcrumb', 'striz-core'),
            'id'          => $prefix . 'enable_breadcrumb',
            'type'        => 'opal_switch',
            'default'     => '1',
            'show_fields' => array(
                $prefix . 'breadcrumb_text_color',
                $prefix . 'breadcrumb_bg_color',
                $prefix . 'breadcrumb_bg_image',
                $prefix . 'heading_color',
            ),
        ));

        $cmb2->add_field(array(
            'name'    => __('Heading Color', 'striz-core'),
            'id'      => $prefix . 'heading_color',
            'type'    => 'colorpicker',
            'default' => '',
        ));

        $cmb2->add_field(array(
            'name'    => __('Breadcrumb Text Color', 'striz-core'),
            'id'      => $prefix . 'breadcrumb_text_color',
            'type'    => 'colorpicker',
            'default' => '',
        ));

        $cmb2->add_field(array(
            'name'    => __('Breadcrumb Background Color', 'striz-core'),
            'id'      => $prefix . 'breadcrumb_bg_color',
            'type'    => 'colorpicker',
            'default' => '',
        ));

        $cmb2->add_field(array(
            'name'         => __('Breadcrumb Background', 'striz-core'),
            'desc'         => 'Upload an image or enter an URL.',
            'id'           => $prefix . 'breadcrumb_bg_image',
            'type'         => 'file',
            'options'      => array(
                'url' => false, // Hide the text input for the url
            ),
            'text'         => array(
                'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
            ),
            'preview_size' => 'large', // Image size to use when previewing in the admin.
        ));

        //Footer

        $cmb2->add_field(array(
            'name'        => __('Enable Custom Footer', 'striz-core'),
            'id'          => $prefix . 'enable_custom_footer',
            'type'        => 'opal_switch',
            'default'     => '0',
            'show_fields' => array(
                $prefix . 'footer_padding_top',
                $prefix . 'footer_layout',
            ),
        ));

        $cmb2->add_field(array(
            'name'    => __('Padding Top', 'striz-core'),
            'id'      => $prefix . 'footer_padding_top',
            'type'    => 'opal_slider',
            'default' => '15',
            'attrs'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
                'unit' => 'px',
            ),
        ));

        $cmb2->add_field(array(
            'name'    => __('Layout', 'striz-core'),
            'id'      => $prefix . 'footer_layout',
            'type'    => 'opal_footer_layout',
            'default' => '',
        ));

        $cmb2->add_field(array(
            'name'    => __('Enable Fixed Footer', 'striz-core'),
            'id'      => $prefix . 'enable_fixed_footer',
            'type'    => 'opal_switch',
            'default' => '0'
        ));

    }

    private function header_builder($prefix = 'osf_') {
        $cmb2 = new_cmb2_box( array(
            'id'           => 'osf_header_builder',
            'title'        => __( 'Header Settings', 'strollik-core' ),
            'object_types' => array( 'header' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
            // 'cmb_styles' => false, // false to disable the CMB stylesheet
            // 'closed'     => true, // Keep the metabox closed by default
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Enable AbHeader Absolute', 'strollik-core' ),
            'id'      => $prefix . 'enable_header_absolute',
            'type'    => 'opal_switch',
            'default' => '0',
            'show_fields' => array(
                $prefix . 'header_bg_color_mobile',
            ),
        ) );

        $cmb2->add_field( array(
            'name'    => __( 'Background Color Mobile', 'strollik-core' ),
            'id'      => $prefix . 'header_bg_color_mobile',
            'type'    => 'colorpicker',
            'default' => '',
        ) );



        $cmb2->add_field( array(
            'name'    => __( 'Show Search Form', 'strollik-core' ),
            'id'      => $prefix . 'enable_search_form',
            'type'    => 'opal_switch',
            'default' => '0',
            'desc'    => 'Show search form in [Main Navigation]',
        ) );
    }

    private function get_post_type_data($post_type = 'post') {
        $args = array(
            'post_type'      => 'header',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );
        $data = array();
        if ($posts = get_posts( $args )){
            foreach ($posts as $post) {
                /**
                 * @var $post WP_Post
                 */
                $data[$post->post_name] = $post->post_title;
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    private function get_sidebars() {
        global $wp_registered_sidebars;
        $output = array();

        if (!empty( $wp_registered_sidebars )){
            foreach ($wp_registered_sidebars as $sidebar) {
                $output[$sidebar['id']] = $sidebar['name'];
            }
        }

        return $output;
    }
}