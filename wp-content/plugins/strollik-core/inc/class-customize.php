<?php
if (!defined( 'ABSPATH' )) {
    exit;
}
if (!class_exists( 'OSF_Customize' )){

class OSF_Customize {
    /**
     * @var array
     */
    private $google_fonts;
    
    /**
     * @var string
     */
    private $link_image;
    
    private $theme_domain;

    public function __construct() {
        add_action( 'customize_register', array( $this, 'customize_register' ) );
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     */
    public function customize_register($wp_customize) {
        /**
         * Theme options.
         */
        $this->google_fonts = osf_get_google_fonts();
        $this->link_image   = trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'assets/images/customize/';
        $this->theme_domain = get_template();

        $this->init_osf_typography( $wp_customize );

        $this->init_osf_colors( $wp_customize );

        $this->init_osf_layout( $wp_customize );

        $this->init_osf_header( $wp_customize );

        $this->init_osf_footer( $wp_customize );

        $this->init_osf_blog( $wp_customize );

        if( osf_is_vc_activated() ){
            $this->init_osf_vc( $wp_customize ); 
        }

        $this->init_osf_mobile( $wp_customize );

        $this->init_osf_animations( $wp_customize );

        $this->init_osf_social( $wp_customize );

        if( otf_is_woocommerce_activated() ){
            $this->init_woocommerce( $wp_customize ); 
        }

        $this->init_osf_maintenance( $wp_customize );
   
        do_action( 'osf_customize_register', $wp_customize );
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_typography($wp_customize){
    
        $wp_customize->add_panel( 'osf_typography', array(
            'title'          => __( 'Typography' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_typography_general', array(
            'title'          => __( 'General' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_typography_general_body_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_typography_general_body_button_move', array(
                'section' => 'osf_typography_general',
                'buttons'  => array(
                'osf_colors_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'osf_layout_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Primary Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_primary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_primary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Primary Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_body_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_body_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_body_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_secondary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_secondary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Heading Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_heading_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_heading_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_heading_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Tertiary Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_tertiary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_tertiary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Tertiary Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_tertiary_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_tertiary_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_tertiary_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Quaternary Font
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_quaternary_font_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_quaternary_font_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Quaternary Font' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_general_quaternary_font', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_general_quaternary_font', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_general_quaternary_font', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Body
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_body_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_body_heading_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Body' ),
            ) ) );
        }

        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_body_font_size', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_body_font_size', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '25',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_body_line_height', array(
                'default'           => '24',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_body_line_height', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => '10',
                'max' => '50',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_body_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_body_letter_spacing', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Heading
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_general_heading_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_general_heading_heading_title', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Heading' ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_general_heading_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_general_heading_font_style', array(
                'section' => 'osf_typography_general',
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_general_heading_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_general_heading_letter_spacing', array(
                'section' => 'osf_typography_general',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '10' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_typography_page_title', array(
            'title'          => __( 'Page Title' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_typography_page_title_breadcrumb_button_move', array(
                'section' => 'osf_typography_page_title',
                'buttons'  => array(
                'osf_layout_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
                'osf_colors_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Heading
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_page_title_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_page_title_heading_title', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Heading' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_page_title_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_page_title_font_family', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Font Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_page_title_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_page_title_font_style', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Heading Font Style' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_font_style', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_page_title_heading_font_size', array(
                'default'           => '24',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_page_title_heading_font_size', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Heading Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_heading_font_size', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_page_title_heading_line_height', array(
                'default'           => '28',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_page_title_heading_line_height', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => '10',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_heading_line_height', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_page_title_heading_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_page_title_heading_letter_spacing', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Breadcrumb
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_page_title_breadcrumb', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Breadcrumb' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_page_title_breadcrumb_font_family', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_breadcrumb_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Font Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_page_title_breadcrumb_font_style', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Breadcrumb Font Style' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_breadcrumb_font_style', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_page_title_breadcrumb_font_size', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Breadcrumb Font Size' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '50' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_breadcrumb_font_size', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb_heading_line_height', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_page_title_breadcrumb_heading_line_height', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_breadcrumb_heading_line_height', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_page_title_breadcrumb_letter_spacing', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_page_title_breadcrumb_letter_spacing', array(
                'section' => 'osf_typography_page_title',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '10' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_page_title_breadcrumb_letter_spacing', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_typography_mainmenu', array(
            'title'          => __( 'Main Menu' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_mainmenu_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_mainmenu_font_family', array(
                'section' => 'osf_typography_mainmenu',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_mainmenu_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_mainmenu_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_mainmenu_font_style', array(
                'section' => 'osf_typography_mainmenu',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_mainmenu_font_style', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_mainmenu_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_mainmenu_font_size', array(
                'section' => 'osf_typography_mainmenu',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '40' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_mainmenu_font_size', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_typography_vertical_menu', array(
            'title'          => __( 'Vertical Menu' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_vertical_menu_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_vertical_menu_font_family', array(
                'section' => 'osf_typography_vertical_menu',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_vertical_menu_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_vertical_menu_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_vertical_menu_font_style', array(
                'section' => 'osf_typography_vertical_menu',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_vertical_menu_font_style', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_vertical_menu_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_vertical_menu_font_size', array(
                'section' => 'osf_typography_vertical_menu',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => __( '10' ),
                'max' => __( '40' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_vertical_menu_font_size', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_typography_quotes', array(
            'title'          => __( 'Quotes' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_quotes_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_quotes_font_family', array(
                'section' => 'osf_typography_quotes',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_quotes_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_quotes_font_style', array(
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_quotes_font_style', array(
                'section' => 'osf_typography_quotes',
            ) ) );
        }

        $wp_customize->add_section( 'osf_typography_sidebar', array(
            'title'          => __( 'Sidebar' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Widget Title
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_sidebar_title_heading', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Widget Title' ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_sidebar_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_sidebar_font_style', array(
                'section' => 'osf_typography_sidebar',
            ) ) );
        }

        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_font_size', array(
                'default'           => '16',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_sidebar_title_font_size', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '40',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_letter_spacing', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_sidebar_title_letter_spacing', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_padding_top', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_sidebar_title_padding_top', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_padding_bottom', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_sidebar_title_padding_bottom', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_sidebar_title_padding_bottom', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Margin Top
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_margin_top', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_sidebar_title_margin_top', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Margin Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_sidebar_title_margin_top', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Margin Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_sidebar_title_margin_bottom', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_sidebar_title_margin_bottom', array(
                'section' => 'osf_typography_sidebar',
                'label' => __( 'Margin Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_typography_footer', array(
            'title'          => __( 'Footer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Widget Title
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_typography_footer_widget_title_heading', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Widget Title' ),
            ) ) );
        }

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_footer_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_footer_font_family', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_footer_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_footer_widget_title_font_style', array(
                'section' => 'osf_typography_footer',
            ) ) );
        }

        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_typography_footer_heading_color', array(
                'default'           => '#111',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_typography_footer_heading_color', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_footer_heading_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_font_size', array(
                'default'           => '16',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_footer_widget_title_font_size', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => '10',
                'max' => '40',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Letter Spacing
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_letter_spacing', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_footer_widget_title_letter_spacing', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Letter Spacing' ),
                'choices' => array(
                'min' => '0',
                'max' => '10',
                'unit' => 'px',
            ),
            ) ) );
        }

        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_padding_top', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_footer_widget_title_padding_top', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_padding_bottom', array(
                'default'           => '15',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_footer_widget_title_padding_bottom', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Margin Top
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_margin_top', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_footer_widget_title_margin_top', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Margin Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Margin Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_footer_widget_title_margin_bottom', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_footer_widget_title_margin_bottom', array(
                'section' => 'osf_typography_footer',
                'label' => __( 'Margin Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_typography_button', array(
            'title'          => __( 'Button' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_typography', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Font Family
        // =========================================
        if(class_exists('OSF_Customize_Control_Google_Font')){
            $wp_customize->add_setting( 'osf_typography_button_font_family', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_family',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Google_Font( $wp_customize, 'osf_typography_button_font_family', array(
                'section' => 'osf_typography_button',
                'label' => __( 'Font Family' ),
                'fonts'    => $this->google_fonts,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_button_font_family', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Font_Style')){
            $wp_customize->add_setting( 'osf_typography_button_font_style', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_font_style',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Font_Style( $wp_customize, 'osf_typography_button_font_style', array(
                'section' => 'osf_typography_button',
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_typography_button_font_style', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Font Size
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_button_font_size', array(
                'default'           => '14',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_button_font_size', array(
                'section' => 'osf_typography_button',
                'label' => __( 'Font Size' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Line Height
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_typography_button_line_height', array(
                'default'           => '20',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_typography_button_line_height', array(
                'section' => 'osf_typography_button',
                'label' => __( 'Line Height' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_colors($wp_customize){
    
        $wp_customize->add_panel( 'osf_colors', array(
            'title'          => __( 'Colors' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_colors_general', array(
            'title'          => __( 'General' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_general_color_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_general_color_heading_label', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Color' ),
                'priority' => 1,
            ) ) );
        }

        // =========================================
        // Primary Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_primary', array(
                'default'           => '#0160b4',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_primary', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Primary Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_primary', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_secondary', array(
                'default'           => '#00c484',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_secondary', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Secondary Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_secondary', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Heading Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_heading', array(
                'default'           => '#111',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_heading', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Heading Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_heading', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Body Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_general_body', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_general_body', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Body Color' ),
                'priority' => 1,
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_general_body', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Body Background
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_general_body_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_general_body_title', array(
                'section' => 'osf_colors_general',
                'label' => __( 'Body Background' ),
                'priority' => 2,
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_colors_general_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_colors_general_button_move', array(
                'section' => 'osf_colors_general',
                'buttons'  => array(
                'osf_typography_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'osf_layout_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_colors_page_title', array(
            'title'          => __( 'Page Title' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Background
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_page_title_bg_title', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Background' ),
            ) ) );
        }

        // =========================================
        // BG Image
        // =========================================
        if(class_exists('WP_Customize_Image_Control')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_image', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'osf_colors_page_title_bg_image', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'BG Image' ),
            ) ) );
        }

        // =========================================
        // BG Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Background_Position')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_position', array(
                'default'           => 'top left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Background_Position( $wp_customize, 'osf_colors_page_title_bg_position', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'BG Position' ),
            ) ) );
        }

        // =========================================
        // Disable Repeat
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg_repeat', array(
                'default'           => '1',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_colors_page_title_bg_repeat', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Disable Repeat' ),
            ) ) );
        }

        // =========================================
        // BG Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_bg', array(
                'default'           => '#fafafa',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_bg', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'BG Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_border_color', array(
                'default'           => '#ffffff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_border_color', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_border_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Top Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_colors_page_title_border_top', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_colors_page_title_border_top', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Border Top Width' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '10' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_border_top', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Bottom Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_colors_page_title_border_bottom', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_colors_page_title_border_bottom', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Border Bottom Width' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '10' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_border_bottom', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_page_title_color_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_page_title_color_title', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Color' ),
            ) ) );
        }

        // =========================================
        // Heading Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_heading_color', array(
                'default'           => '#666',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_heading_color', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Heading Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_heading_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Breadcrumb Text Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_page_title_breadcrumb_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_page_title_breadcrumb_color', array(
                'section' => 'osf_colors_page_title',
                'label' => __( 'Breadcrumb Text Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_page_title_breadcrumb_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_colors_page_title_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_colors_page_title_button_move', array(
                'section' => 'osf_colors_page_title',
                'buttons'  => array(
                'osf_typography_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'osf_layout_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_colors_footer', array(
            'title'          => __( 'Footer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Enable Custom
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_colors_footer_control', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_colors_footer_control', array(
                'section' => 'osf_colors_footer',
                'label' => __( 'Enable Custom' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_footer_control', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_footer', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_footer', array(
                'section' => 'osf_colors_footer',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_footer', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Link Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_footer_link_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_footer_link_color', array(
                'section' => 'osf_colors_footer',
                'label' => __( 'Link Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_footer_link_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Link Color Hover
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_footer_link_color_hover', array(
                'default'           => '#999',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_footer_link_color_hover', array(
                'section' => 'osf_colors_footer',
                'label' => __( 'Link Color Hover' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_footer_link_color_hover', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_colors_quotes', array(
            'title'          => __( 'Quotes' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_quotes_color', array(
                'default'           => '#666',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_quotes_color', array(
                'section' => 'osf_colors_quotes',
                'label' => __( 'Color' ),
            ) ) );
        }

        // =========================================
        // Background
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_quotes_background', array(
                'default'           => 'rgba(255,255,255,0)',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_quotes_background', array(
                'section' => 'osf_colors_quotes',
                'label' => __( 'Background' ),
            ) ) );
        }

        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_quotes_border', array(
                'default'           => '#eceeef',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_quotes_border', array(
                'section' => 'osf_colors_quotes',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_colors_sidebar', array(
            'title'          => __( 'Sidebar' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_sidebar_bg_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_sidebar_bg_color', array(
                'section' => 'osf_colors_sidebar',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_sidebar_bg_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_sidebar_border_color', array(
                'default'           => '#ddd',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_sidebar_border_color', array(
                'section' => 'osf_colors_sidebar',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_sidebar_border_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Title Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_sidebar_title_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_sidebar_title_color', array(
                'section' => 'osf_colors_sidebar',
                'label' => __( 'Title Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_sidebar_title_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_sidebar_color', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_sidebar_color', array(
                'section' => 'osf_colors_sidebar',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_sidebar_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_colors_buttons', array(
            'title'          => __( 'Buttons' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_colors', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_colors_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_colors_button_move', array(
                'section' => 'osf_colors_buttons',
                'buttons'  => array(
                'osf_layout_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
                'osf_animations_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Animation',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Enable Custom
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_colors_buttons_enable_custom', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_colors_buttons_enable_custom', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Enable Custom' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_enable_custom', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Primary Button
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_primary', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_primary', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Primary Button' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_bg', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_border', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color (outline)
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_color_outline', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_color_outline', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color (outline)' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_color_outline', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Primary Button Hover
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_primary_hover', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_primary_hover', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Primary Button Hover' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_hover_bg', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_hover_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_hover_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_hover_border', array(
                'default'           => '#222',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_hover_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_hover_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_primary_hover_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_primary_hover_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_primary_hover_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Button
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_secondary', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_secondary', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Secondary Button' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_bg', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_border', array(
                'default'           => '#767676',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color (outline)
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_color_outline', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_color_outline', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color (outline)' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_color_outline', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Secondary Button Hover
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_colors_title_buttons_secondary_hover', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_colors_title_buttons_secondary_hover', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Secondary Button Hover' ),
            ) ) );
        }

        // =========================================
        // Background Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_hover_bg', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_hover_bg', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Background Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_hover_bg', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_hover_border', array(
                'default'           => '#767676',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_hover_border', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_hover_border', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_colors_buttons_secondary_hover_color', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_colors_buttons_secondary_hover_color', array(
                'section' => 'osf_colors_buttons',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_colors_buttons_secondary_hover_color', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_layout($wp_customize){
    
        $wp_customize->add_panel( 'osf_layout', array(
            'title'          => __( 'Layout' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_layout_general', array(
            'title'          => __( 'General' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_layout_general_layout_mode', array(
                'default'           => 'wide',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_layout_general_layout_mode', array(
                'section' => 'osf_layout_general',
                'choices' => array(
                'boxed' => __( 'Boxed' ),
                'wide' => __( 'Wide' ),
            ),
            ) ) );
        }

        // =========================================
        // Boxed Container Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_layout_boxed_width', array(
                'default'           => '1170',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_layout_boxed_width', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Boxed Container Width' ),
                'choices' => array(
                'min' => '767',
                'max' => '1920',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_layout_boxed_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Boxed Offset
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_layout_boxed_offset', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_layout_boxed_offset', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Boxed Offset' ),
                'choices' => array(
                'min' => '0',
                'max' => '200',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_layout_boxed_offset', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Content Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_type', array(
                'default'           => 'px',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_layout_general_content_width_type', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Content Width' ),
                'choices' => array(
                'px' => __( 'px' ),
                '%' => __( '%' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_content_width_type', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_px', array(
                'default'           => '1170',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_content_width_px', array(
                'section' => 'osf_layout_general',
                'choices' => array(
                'min' => '767',
                'max' => '1920',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_content_width_px', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_percent', array(
                'default'           => '100',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_content_width_percent', array(
                'section' => 'osf_layout_general',
                'choices' => array(
                'min' => '20',
                'max' => '100',
                'unit' => '%',
            ),
            ) ) );
        }

        // =========================================
        // Gutter Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_gutter_width', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_gutter_width', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Gutter Width' ),
                'choices' => array(
                'min' => '10',
                'max' => '60',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_general_gutter_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Content Padding
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_general_content_width_padding', array(
                'default'           => '15',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_general_content_width_padding', array(
                'section' => 'osf_layout_general',
                'label' => __( 'Content Padding' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_layout_general_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_layout_general_button_move', array(
                'section' => 'osf_layout_general',
                'buttons'  => array(
                'osf_colors_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'osf_typography_general' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_layout_sidebar', array(
            'title'          => __( 'Sidebar' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Enable Sticky Sidebar
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_layout_sidebar_is_sticky', array(
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_layout_sidebar_is_sticky', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Enable Sticky Sidebar' ),
            ) ) );
        }

        // =========================================
        // Enable Boxed
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_layout_sidebar_is_boxed', array(
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_layout_sidebar_is_boxed', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Enable Boxed' ),
            ) ) );
        }

        // =========================================
        // Title Outside
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_layout_sidebar_title_outside', array(
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_layout_sidebar_title_outside', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Title Outside' ),
            ) ) );
        }

        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_sidebar_padding_bottom', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_sidebar_padding_bottom', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Margin Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_sidebar_margin_bottom', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_sidebar_margin_bottom', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Margin Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_layout_sidebar_sidebar_heading_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_layout_sidebar_sidebar_heading_title', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        // =========================================
        // Padding Inside Boxed
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_sidebar_padding_inside_boxed', array(
                'default'           => '30',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_sidebar_padding_inside_boxed', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Padding Inside Boxed' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '100' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        // =========================================
        // Border Radius
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_sidebar_sidebar_border_radius', array(
                'default'           => '00',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_sidebar_sidebar_border_radius', array(
                'section' => 'osf_layout_sidebar',
                'label' => __( 'Border Radius' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '20' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_layout_page_title', array(
            'title'          => __( 'Page Title' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_layout_page_title_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_layout_page_title_width', array(
                'section' => 'osf_layout_page_title',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_width', array(
            'selector'        => '#page-title-bar',
            'render_callback' => 'osf_customize_partial_page_title',
        ) );
        
        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'osf_layout_page_title_style', array(
                'default'           => 'top-bottom',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_layout_page_title_style', array(
            'section' => 'osf_layout_page_title',
            'label' => __( 'Style' ),
            'type' => 'select',
            'choices' => array(
                'left-right' => __( 'Left - Right' ),
                'right-left' => __( 'Right - Left' ),
                'top-bottom' => __( 'Top - Bottom' ),
                'top-bottom-center' => __( 'Top - Bottom - Center' ),
                'bottom-top' => __( 'Bottom - Top' ),
                'bottom-top-center' => __( 'Bottom - Top - Center' ),
                'none-right' => __( 'None - Right' ),
                'none-left' => __( 'None - Left' ),
                'none-center' => __( 'None - Center' ),
            ),
        ) );

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_style', array(
            'selector'        => '#page-title-bar',
            'render_callback' => 'osf_customize_partial_page_title',
        ) );
        
        // =========================================
        // Padding Top
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_page_title_padding_top', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_page_title_padding_top', array(
                'section' => 'osf_layout_page_title',
                'label' => __( 'Padding Top' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '300' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_padding_top', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Right
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_page_title_padding_right', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_page_title_padding_right', array(
                'section' => 'osf_layout_page_title',
                'label' => __( 'Padding Right' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '300' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_padding_right', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Bottom
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_page_title_padding_bottom', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_page_title_padding_bottom', array(
                'section' => 'osf_layout_page_title',
                'label' => __( 'Padding Bottom' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '300' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_padding_bottom', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Padding Left
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_page_title_padding_left', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_page_title_padding_left', array(
                'section' => 'osf_layout_page_title',
                'label' => __( 'Padding Left' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '300' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_padding_left', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Height
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_page_title_height', array(
                'default'           => '90',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_page_title_height', array(
                'section' => 'osf_layout_page_title',
                'label' => __( 'Height' ),
                'choices' => array(
                'min' => __( '30' ),
                'max' => __( '300' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_layout_page_title_height', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_layout_page_title_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_layout_page_title_button_move', array(
                'section' => 'osf_layout_page_title',
                'buttons'  => array(
                'osf_typography_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
                'osf_colors_page_title' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_layout_pagination', array(
            'title'          => __( 'Pagination' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Select Pagination Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_layout_pagination_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_layout_pagination_style', array(
                'section' => 'osf_layout_pagination',
                'label' => __( 'Select Pagination Style' ),
                'choices' => array(
                '1' => esc_url($this->link_image . 'pagination1.jpg'),
                '2' => esc_url($this->link_image . 'pagination2.jpg'),
                '3' => esc_url($this->link_image . 'pagination3.jpg'),
                '4' => esc_url($this->link_image . 'pagination4.jpg'),
                '5' => esc_url($this->link_image . 'pagination5.jpg'),
                '6' => esc_url($this->link_image . 'pagination6.jpg'),
                '7' => esc_url($this->link_image . 'pagination7.jpg'),
                '8' => esc_url($this->link_image . 'pagination8.jpg'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

        $wp_customize->add_section( 'osf_layout_buttons', array(
            'title'          => __( 'Button' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_layout_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_layout_button_move', array(
                'section' => 'osf_layout_buttons',
                'buttons'  => array(
                'osf_animations_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Animation',
                ),
                'osf_colors_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Border radius
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_layout_buttons_border_radius', array(
                'default'           => '3',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_layout_buttons_border_radius', array(
                'section' => 'osf_layout_buttons',
                'label' => __( 'Border radius' ),
                'choices' => array(
                'min' => __( '0' ),
                'max' => __( '50' ),
                'unit' => __( 'px' ),
            ),
            ) ) );
        }

        $wp_customize->add_section( 'osf_comment_template', array(
            'title'          => __( 'Comment Template' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Comment Skin
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_comment_template_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_comment_template_title', array(
                'section' => 'osf_comment_template',
                'label' => __( 'Comment Skin' ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_comment_template_skin', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_comment_template_skin', array(
                'section' => 'osf_comment_template',
                'choices' => array(
                '1' => esc_url($this->link_image . 'comment1.png'),
                '2' => esc_url($this->link_image . 'comment2.png'),
                '3' => esc_url($this->link_image . 'comment3.png'),
                '4' => esc_url($this->link_image . 'comment4.png'),
                '5' => esc_url($this->link_image . 'comment5.png'),
                '6' => esc_url($this->link_image . 'comment6.png'),
                '7' => esc_url($this->link_image . 'comment7.png'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

        // =========================================
        // Comment Form
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_comment_template_form_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_comment_template_form_title', array(
                'section' => 'osf_comment_template',
                'label' => __( 'Comment Form' ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_comment_template_form', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_comment_template_form', array(
                'section' => 'osf_comment_template',
                'choices' => array(
                '1' => esc_url($this->link_image . 'comment_form1.png'),
                '2' => esc_url($this->link_image . 'comment_form2.png'),
                '3' => esc_url($this->link_image . 'comment_form3.png'),
                '4' => esc_url($this->link_image . 'comment_form4.png'),
                '5' => esc_url($this->link_image . 'comment_form5.png'),
                '6' => esc_url($this->link_image . 'comment_form6.png'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

        $wp_customize->add_section( 'osf_404_page_setting', array(
            'title'          => __( '404 Page Setting' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_layout', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Page Setting
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_page_404_page_enable', array(
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_page_404_page_enable', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'Page Setting' ),
                'choices' => array(
                'default' => __( 'Default' ),
                'custom' => __( 'Customize' ),
            ),
            ) ) );
        }

        // =========================================
        // 404 Page
        // =========================================
            $wp_customize->add_setting( 'osf_page_404_page_custom', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_page_404_page_custom', array(
            'section' => 'osf_404_page_setting',
            'label' => __( '404 Page' ),
            'type' => 'dropdown-pages',
        ) );

        // =========================================
        // BG Image
        // =========================================
        if(class_exists('WP_Customize_Image_Control')){
            $wp_customize->add_setting( 'osf_page_404_bg_image', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'osf_page_404_bg_image', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'BG Image' ),
            ) ) );
        }

        // =========================================
        // BG Position
        // =========================================
        if(class_exists('OSF_Customize_Control_Background_Position')){
            $wp_customize->add_setting( 'osf_page_404_bg_position', array(
                'default'           => 'top left',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Background_Position( $wp_customize, 'osf_page_404_bg_position', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'BG Position' ),
            ) ) );
        }

        // =========================================
        // Disable Repeat
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_page_404_bg_repeat', array(
                'default'           => '1',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_page_404_bg_repeat', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'Disable Repeat' ),
            ) ) );
        }

        // =========================================
        // BG Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_page_404_bg', array(
                'default'           => '#fafafa',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_page_404_bg', array(
                'section' => 'osf_404_page_setting',
                'label' => __( 'BG Color' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_header($wp_customize){
    
        $wp_customize->add_section( 'osf_header', array(
            'title'          => __( 'Header' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_header_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_header_button_move', array(
                'section' => 'osf_header',
                'buttons'  => array(
                'osf_colors_header' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
                'title_tagline' => array(
                    'type'  => 'section',
                    'label' => 'Change Logo',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_header_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_header_layout_side_header_heading', array(
                'section' => 'osf_header',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Enable Header Builder
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_header_enable_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_header_enable_builder', array(
                'section' => 'osf_header',
                'label' => __( 'Enable Header Builder' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_header_enable_builder', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Header Builder
        // =========================================
        if(class_exists('OSF_Customize_Control_Headers')){
            $wp_customize->add_setting( 'osf_header_builder', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Headers( $wp_customize, 'osf_header_builder', array(
                'section' => 'osf_header',
                'label' => __( 'Header Builder' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_header_builder', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_header_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_header_width', array(
                'section' => 'osf_header',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_header_width', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_footer($wp_customize){
    
        $wp_customize->add_section( 'osf_footer', array(
            'title'          => __( 'Footer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_footer_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_footer_button_move', array(
                'section' => 'osf_footer',
                'buttons'  => array(
                'osf_typography_footer' => array(
                    'type'  => 'section',
                    'label' => 'Edit Typography',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_footer_title_layout', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_footer_title_layout', array(
                'section' => 'osf_footer',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Fixed Footer
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_fixed_footer', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_fixed_footer', array(
                'section' => 'osf_footer',
                'label' => __( 'Fixed Footer' ),
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Footers')){
            $wp_customize->add_setting( 'osf_footer_layout', array(
                'default'           => '0',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Footers( $wp_customize, 'osf_footer_layout', array(
                'section' => 'osf_footer',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Copyright
        // =========================================
        if(class_exists('OSF_Customize_Control_Editor')){
            $wp_customize->add_setting( 'osf_footer_copyright', array(
                'default'           => 'Proudly powered by Wpopal.com',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_editor',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Editor( $wp_customize, 'osf_footer_copyright', array(
                'section' => 'osf_footer',
                'label' => __( 'Copyright' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_footer_copyright', array(
            'selector'        => '.site-info > .container',
            'render_callback' => 'osf_customize_partial_copyright',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_blog($wp_customize){
    
        $wp_customize->add_panel( 'osf_blog', array(
            'title'          => __( 'Blog' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_blog_archive', array(
            'title'          => __( 'Archive' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_blog', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_blog_archive_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_blog_archive_layout', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Select Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_blog_archive_style', array(
                'default'           => '1',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_blog_archive_style', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Select Style' ),
                'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OSF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'osf_blog_archive_sidebar', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Sidebars( $wp_customize, 'osf_blog_archive_sidebar', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_archive_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'osf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_blog_archive_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_blog_archive_sidebar_width', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_archive_sidebar_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_blog_archive_sidebar_padding_left', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_blog_archive_sidebar_padding_left', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_archive_sidebar_padding_left', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_blog_archive_sidebar_padding_right', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_blog_archive_sidebar_padding_right', array(
                'section' => 'osf_blog_archive',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_archive_sidebar_padding_right', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'osf_blog_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_blog', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_blog_single_layout_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_blog_single_layout_title', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_blog_single_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_blog_single_layout', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OSF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'osf_blog_single_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Sidebars( $wp_customize, 'osf_blog_single_sidebar', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'osf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_blog_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_blog_single_sidebar_width', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_single_sidebar_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_blog_single_sidebar_padding_left', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_blog_single_sidebar_padding_left', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_single_sidebar_padding_left', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_blog_single_sidebar_padding_right', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_blog_single_sidebar_padding_right', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_blog_single_sidebar_padding_right', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Post Navigation
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_blog_single_post_navigation_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_blog_single_post_navigation_title', array(
                'section' => 'osf_blog_single',
                'label' => __( 'Post Navigation' ),
            ) ) );
        }

        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_blog_single_navigation', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_blog_single_navigation', array(
                'section' => 'osf_blog_single',
                'choices' => array(
                '1' => esc_url($this->link_image . 'postnavigation1.png'),
                '2' => esc_url($this->link_image . 'postnavigation2.png'),
                '3' => esc_url($this->link_image . 'postnavigation3.png'),
                '4' => esc_url($this->link_image . 'postnavigation4.png'),
            ),
                'layout' => 'sidebar'
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_vc($wp_customize){
    
        $wp_customize->add_section( 'osf_vc', array(
            'title'          => __( 'Visual Composer' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Grid Item
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'ore_vc_Grid_Item_heading_label', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'ore_vc_Grid_Item_heading_label', array(
                'section' => 'osf_vc',
                'label' => __( 'Grid Item' ),
            ) ) );
        }

        // =========================================
        // Number Words in Post Excerpt
        // =========================================
            $wp_customize->add_setting( 'osf_vc_grid_post_excerpt_number_words', array(
                'default'           => '55',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_vc_grid_post_excerpt_number_words', array(
            'section' => 'osf_vc',
            'label' => __( 'Number Words in Post Excerpt' ),
            'type' => 'text',
        ) );

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_mobile($wp_customize){
    
        $wp_customize->add_section( 'osf_mobile', array(
            'title'          => __( 'Mobile' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Effect Canvas Menu
        // =========================================
            $wp_customize->add_setting( 'osf_mobile_effect_menu', array(
                'default'           => '3',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_mobile_effect_menu', array(
            'section' => 'osf_mobile',
            'label' => __( 'Effect Canvas Menu' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Slide in on top' ),
                '3' => __( 'Push' ),
                '4' => __( 'Slide Along' ),
                '6' => __( 'Rotate Pusher' ),
                '7' => __( '3D Rotate In' ),
                '8' => __( '3D Rotate In' ),
                '9' => __( 'Scale Down Pusher' ),
                '10' => __( 'Scale Up' ),
                '11' => __( 'Scale & Rotate Pusher' ),
                '12' => __( 'Open Door' ),
                '13' => __( 'Fall Down' ),
                '14' => __( 'Delayed 3d Rotate' ),
            ),
        ) );

        // =========================================
        // Skin
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_mobile_menu_skin', array(
                'default'           => 'light',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_mobile_menu_skin', array(
                'section' => 'osf_mobile',
                'label' => __( 'Skin' ),
                'choices' => array(
                'light' => __( 'Light' ),
                'dark' => __( 'Dark' ),
            ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_animations($wp_customize){
    
        $wp_customize->add_panel( 'osf_animations', array(
            'title'          => __( 'Animation' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_animations_buttons', array(
            'title'          => __( 'Button' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'osf_animations', 
            'priority'       => 1, 
        ) );

        if(class_exists('OSF_Customize_Control_Button_Move')){
            $wp_customize->add_setting( 'osf_animations_button_move', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Move( $wp_customize, 'osf_animations_button_move', array(
                'section' => 'osf_animations_buttons',
                'buttons'  => array(
                'osf_layout_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Layout',
                ),
                'osf_colors_buttons' => array(
                    'type'  => 'section',
                    'label' => 'Edit Color',
                ),
            ),
            ) ) );
        }

        // =========================================
        // Background Transitions
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_animations_buttons_title', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_animations_buttons_title', array(
                'section' => 'osf_animations_buttons',
                'label' => __( 'Background Transitions' ),
            ) ) );
        }

        // =========================================
        // Type
        // =========================================
            $wp_customize->add_setting( 'osf_animations_buttons_background', array(
                'default'           => '1',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_animations_buttons_background', array(
            'section' => 'osf_animations_buttons',
            'label' => __( 'Type' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Fade' ),
                '2' => __( 'Back Pulse' ),
                '3' => __( 'Sweep To Right' ),
                '4' => __( 'Sweep To Left' ),
                '5' => __( 'Sweep To Bottom' ),
                '6' => __( 'Sweep To Top' ),
                '7' => __( 'Bounce To Right' ),
                '8' => __( 'Bounce To Left' ),
                '9' => __( 'Bounce To Bottom' ),
                '10' => __( 'Bounce To Top' ),
                '11' => __( 'Radial Out' ),
                '12' => __( 'Radial In' ),
                '13' => __( 'Rectangle In' ),
                '14' => __( 'Rectangle Out' ),
                '15' => __( 'Shutter In Horizontal' ),
                '16' => __( 'Shutter Out Horizontal' ),
                '17' => __( 'Shutter In Vertical' ),
                '18' => __( 'Shutter Out Vertical' ),
            ),
        ) );

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_social($wp_customize){
    
        $wp_customize->add_section( 'osf_social', array(
            'title'          => __( 'Socials' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Socials Share
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_social_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_social_layout_side_header_heading', array(
                'section' => 'osf_social',
                'label' => __( 'Socials Share' ),
            ) ) );
        }

        // =========================================
        // Socials
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_socials', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_socials', array(
                'section' => 'osf_social',
                'label' => __( 'Socials' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_socials', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Facebook
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_facebook', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_facebook', array(
                'section' => 'osf_social',
                'label' => __( 'Facebook' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_facebook', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Twitter
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_twitter', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_twitter', array(
                'section' => 'osf_social',
                'label' => __( 'Twitter' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_twitter', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Linkedin
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_linkedin', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_linkedin', array(
                'section' => 'osf_social',
                'label' => __( 'Linkedin' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_linkedin', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Tumblr
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_tumblr', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_tumblr', array(
                'section' => 'osf_social',
                'label' => __( 'Tumblr' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_tumblr', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Google Plus
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_google_plus', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_google_plus', array(
                'section' => 'osf_social',
                'label' => __( 'Google Plus' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_google_plus', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Pinterest
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_pinterest', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_pinterest', array(
                'section' => 'osf_social',
                'label' => __( 'Pinterest' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_pinterest', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Email
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_email', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_email', array(
                'section' => 'osf_social',
                'label' => __( 'Email' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_email', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_woocommerce($wp_customize){
    
        $wp_customize->add_panel( 'woocommerce', array(
            'title'          => __( 'Woocommerce' ),
            'capability'     => 'edit_theme_options',
            'priority'       => 1,
        ));

        $wp_customize->add_section( 'osf_woocommerce_archive', array(
            'title'          => __( 'Archive' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_archive_layout_heading', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_woocommerce_archive_layout', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_product_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_woocommerce_archive_product_width', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OSF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Sidebars( $wp_customize, 'osf_woocommerce_archive_sidebar', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_archive_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_woocommerce_archive_sidebar_width', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_archive_sidebar_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_sidebar_padding_left', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_woocommerce_archive_sidebar_padding_left', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_archive_sidebar_padding_left', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_sidebar_padding_right', array(
                'default'           => '0',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_woocommerce_archive_sidebar_padding_right', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_archive_sidebar_padding_right', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Filter position
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_archive_filter_position', array(
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_archive_filter_position', array(
            'section' => 'osf_woocommerce_archive',
            'label' => __( 'Filter position' ),
            'type' => 'select',
            'choices' => array(
                'none' => __( 'None' ),
                'top' => __( 'Top' ),
                'left' => __( 'Left' ),
                'right' => __( 'Right' ),
            ),
        ) );

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_archive_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_archive_columns', array(
            'section' => 'osf_woocommerce_archive',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Number product to show
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_archive_number', array(
                'default'           => '12',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_archive_number', array(
            'section' => 'osf_woocommerce_archive',
            'label' => __( 'Number product to show' ),
            'type' => 'number',
        ) );

        // =========================================
        // Product Catalog
        // =========================================
        if(osf_woocommerce_version_check() && class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_archive_catalog_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_archive_catalog_heading', array(
                'section' => 'osf_woocommerce_archive',
                'label' => __( 'Product Catalog' ),
                'priority' => 20,
            ) ) );
        }

        $wp_customize->add_section( 'osf_woocommerce_single', array(
            'title'          => __( 'Single' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Image
        // =========================================
        if(osf_woocommerce_version_check() && class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single__image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single__image_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Image' ),
                'priority' => 8,
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_layout_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Select Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Image_Select')){
            $wp_customize->add_setting( 'osf_woocommerce_single_layout', array(
                'default'           => '2cr',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Image_Select( $wp_customize, 'osf_woocommerce_single_layout', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Select Layout' ),
                'choices' => array(
                '2cl' => esc_url($this->link_image . '2cl.png'),
                '1c' => esc_url($this->link_image . '1col.png'),
                '2cr' => esc_url($this->link_image . '2cr.png'),
            ),
            ) ) );
        }

        // =========================================
        // Sidebar
        // =========================================
        if(class_exists('OSF_Customize_Control_Sidebars')){
            $wp_customize->add_setting( 'osf_woocommerce_single_sidebar', array(
                'default'           => 'sidebar-1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Sidebars( $wp_customize, 'osf_woocommerce_single_sidebar', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Sidebar' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_single_sidebar', array(
            'selector'        => '#secondary',
            'render_callback' => 'otf_customize_partial_sidebar',
        ) );
        
        // =========================================
        // Sidebar Width
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_woocommerce_single_sidebar_width', array(
                'default'           => '320',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_woocommerce_single_sidebar_width', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Sidebar Width' ),
                'choices' => array(
                'min' => '200',
                'max' => '500',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_single_sidebar_width', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_woocommerce_single_sidebar_padding_left', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_woocommerce_single_sidebar_padding_left', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_single_sidebar_padding_left', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Space Between
        // =========================================
        if(class_exists('OSF_Customize_Control_Slider')){
            $wp_customize->add_setting( 'osf_woocommerce_single_sidebar_padding_right', array(
                'default'           => '0',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Slider( $wp_customize, 'osf_woocommerce_single_sidebar_padding_right', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Space Between' ),
                'choices' => array(
                'min' => '0',
                'max' => '100',
                'unit' => 'px',
            ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_single_sidebar_padding_right', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Fullwidth?
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_woocommerce_single_product_width', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_woocommerce_single_product_width', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Fullwidth?' ),
            ) ) );
        }

        // =========================================
        // Tab Style
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Group')){
            $wp_customize->add_setting( 'osf_woocommerce_single_product_tab_style', array(
                'default'           => 'tab',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Group( $wp_customize, 'osf_woocommerce_single_product_tab_style', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Tab Style' ),
                'choices' => array(
                'tab' => __( 'Tab' ),
                'accordion' => __( 'Accordion' ),
            ),
            ) ) );
        }

        // =========================================
        // Product Gallery
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_image_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Product Gallery' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_product_thumbnail_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_product_thumbnail_columns', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Product Upsale
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_upsale_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_upsale_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Product Upsale' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_upsale_columns', array(
                'default'           => '4',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_upsale_columns', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Product Related
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_related_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_related_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Product Related' ),
            ) ) );
        }

        // =========================================
        // Number product to show
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_related_number', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_related_number', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Number product to show' ),
            'type' => 'number',
        ) );

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_related_columns', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_related_columns', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        // =========================================
        // Product Up-sell
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_single_upsell_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_single_upsell_heading', array(
                'section' => 'osf_woocommerce_single',
                'label' => __( 'Product Up-sell' ),
            ) ) );
        }

        // =========================================
        // Columns
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_single_upsell_columns', array(
                'default'           => '3',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_single_upsell_columns', array(
            'section' => 'osf_woocommerce_single',
            'label' => __( 'Columns' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( '1' ),
                '2' => __( '2' ),
                '3' => __( '3' ),
                '4' => __( '4' ),
                '5' => __( '5' ),
                '6' => __( '6' ),
            ),
        ) );

        $wp_customize->add_section( 'osf_woocommerce_product', array(
            'title'          => __( 'Product' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Image
        // =========================================
        if(osf_woocommerce_version_check() && class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_archive__image_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_archive__image_heading', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Image' ),
                'priority' => 8,
            ) ) );
        }

        // =========================================
        // Layout
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'otf_woocommerce_product_layout_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'otf_woocommerce_product_layout_heading', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Layout' ),
            ) ) );
        }

        // =========================================
        // Style
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_product_style', array(
                'default'           => '1',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_product_style', array(
            'section' => 'osf_woocommerce_product',
            'label' => __( 'Style' ),
            'type' => 'select',
            'choices' => array(
                '1' => __( 'Style 1' ),
                '2' => __( 'Style 2' ),
                '3' => __( 'Style 3' ),
            ),
        ) );

        // =========================================
        // Animation Image Hover
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_product_hover', array(
                'default'           => 'none',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_product_hover', array(
            'section' => 'osf_woocommerce_product',
            'label' => __( 'Animation Image Hover' ),
            'type' => 'select',
            'choices' => array(
                'none' => __( 'None' ),
                'bottom-to-top' => __( 'Bottom to Top' ),
                'top-to-bottom' => __( 'Top to Bottom' ),
                'right-to-left' => __( 'Right to Left' ),
                'left-to-right' => __( 'Left to Right' ),
                'swap' => __( 'Swap' ),
                'fade' => __( 'Fade' ),
                'zoom-in' => __( 'Zoom In' ),
                'zoom-out' => __( 'Zoom Out' ),
            ),
        ) );

        // =========================================
        // Label Sale
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_woocommerce_product_color_heading_label_sale', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_woocommerce_product_color_heading_label_sale', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Label Sale' ),
            ) ) );
        }

        // =========================================
        // Shape
        // =========================================
            $wp_customize->add_setting( 'osf_woocommerce_product_label_sale_shape', array(
                'default'           => 'square',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_woocommerce_product_label_sale_shape', array(
            'section' => 'osf_woocommerce_product',
            'label' => __( 'Shape' ),
            'type' => 'select',
            'choices' => array(
                'square' => __( 'Square' ),
                'rounded' => __( 'Rounded' ),
                'circle' => __( 'Circle' ),
                'rotate' => __( 'Rotate' ),
            ),
        ) );

        // =========================================
        // Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_woocommerce_product_color_label_sale', array(
                'default'           => '#666',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_woocommerce_product_color_label_sale', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_product_color_label_sale', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Background
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_woocommerce_product_color_bg_label_sale', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_woocommerce_product_color_bg_label_sale', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Background' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_product_color_bg_label_sale', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        // =========================================
        // Border Color
        // =========================================
        if(class_exists('OSF_Customize_Control_Color')){
            $wp_customize->add_setting( 'osf_woocommerce_product_color_border_label_sale', array(
                'default'           => '#fff',
                'transport'         => 'postMessage',
                'sanitize_callback' => 'maybe_hash_hex_color',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Color( $wp_customize, 'osf_woocommerce_product_color_border_label_sale', array(
                'section' => 'osf_woocommerce_product',
                'label' => __( 'Border Color' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_woocommerce_product_color_border_label_sale', array(
            'selector'        => '#osf-style-inline-css-customizer',
            'render_callback' => 'osf_customize_partial_css',
        ) );
        
        $wp_customize->add_section( 'otf_woocommerce_extra', array(
            'title'          => __( 'Extra' ),
            'capability'     => 'edit_theme_options',
            'panel'          => 'woocommerce', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Enable Product Recently Viewed
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'otf_woocommerce_extra_enable_product_recently_viewed', array(
                'default'           => '1',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'otf_woocommerce_extra_enable_product_recently_viewed', array(
                'section' => 'otf_woocommerce_extra',
                'label' => __( 'Enable Product Recently Viewed' ),
            ) ) );
        }

    }

    /**
     * @param $wp_customize WP_Customize_Manager
     *
     * @return void
     */
    public function init_osf_maintenance($wp_customize){
    
        $wp_customize->add_section( 'osf_maintenance', array(
            'title'          => __( 'Maintenance' ),
            'capability'     => 'edit_theme_options',
            'panel'          => '', 
            'priority'       => 1, 
        ) );

        // =========================================
        // Maintenance Mode
        // =========================================
        if(class_exists('OSF_Customize_Control_Heading')){
            $wp_customize->add_setting( 'osf_maintenance_layout_side_header_heading', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Heading( $wp_customize, 'osf_maintenance_layout_side_header_heading', array(
                'section' => 'osf_maintenance',
                'label' => __( 'Maintenance Mode' ),
            ) ) );
        }

        // =========================================
        // Activated
        // =========================================
        if(class_exists('OSF_Customize_Control_Button_Switch')){
            $wp_customize->add_setting( 'osf_maintenance', array(
                'transport'         => 'postMessage',
                'sanitize_callback' => 'osf_sanitize_button_switch',
            ) );
            $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_maintenance', array(
                'section' => 'osf_maintenance',
                'label' => __( 'Activated' ),
            ) ) );
        }

        $wp_customize->selective_refresh->add_partial( 'osf_maintenance', array(
            'selector'        => '#masthead',
            'render_callback' => 'osf_customize_partial_header_content',
        ) );
        
        // =========================================
        // Maintenance Page
        // =========================================
            $wp_customize->add_setting( 'osf_maintenance_page', array(
                'sanitize_callback' => 'sanitize_text_field',
            ) );
        $wp_customize->add_control( 'osf_maintenance_page', array(
            'section' => 'osf_maintenance',
            'label' => __( 'Maintenance Page' ),
            'type' => 'dropdown-pages',
        ) );

    }

}
}
new OSF_Customize();