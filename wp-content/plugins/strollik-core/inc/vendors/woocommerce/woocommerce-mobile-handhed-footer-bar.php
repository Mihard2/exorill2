<?php

if ( get_theme_mod( 'osf_mobile_handheld_footer_bar_hide' ) == true ) {
    remove_action('wp_footer', array(osf_WooCommerce::getInstance(), 'mobile_handheld_footer_bar'));
}

add_action( 'customize_register', 'customize_hide_footer_handheld_mobile' );
function customize_hide_footer_handheld_mobile($wp_customize){
    if(class_exists('OSF_Customize_Control_Button_Switch')){
        $wp_customize->add_setting( 'osf_mobile_handheld_footer_bar_hide', array(
            'sanitize_callback' => 'osf_sanitize_button_switch',
        ) );
        $wp_customize->add_control( new OSF_Customize_Control_Button_Switch( $wp_customize, 'osf_mobile_handheld_footer_bar_hide', array(
            'section' => 'osf_footer',
            'label' => __( 'Hide mobile handheld footer bar', 'auros-core' ),
        ) ) );
    }
}