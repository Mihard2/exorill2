<?php
$cssCode     = '';
// Typography
$heading_font_size          = get_theme_mod( 'osf_typography_footer_widget_title_font_size', 16 );
$heading_letter_spacing     = get_theme_mod( 'osf_typography_footer_widget_title_letter_spacing', 2 );
$heading_padding_top        = get_theme_mod( 'osf_typography_footer_widget_title_padding_top', 15 );
$heading_padding_bottom     = get_theme_mod( 'osf_typography_footer_widget_title_padding_bottom', 15);
$heading_margin_top         = get_theme_mod( 'osf_typography_footer_widget_title_margin_top', 0 );
$heading_margin_bottom      = get_theme_mod( 'osf_typography_footer_widget_title_margin_bottom', 20 );
$footer_font_style          = get_theme_mod( 'osf_typography_footer_widget_title_font_style' );
$footer_color               = get_theme_mod( 'osf_colors_footer', '#222' );
$footer_color_link          = get_theme_mod( 'osf_colors_footer_link_color', '#222' );
$footer_color_link_hover    = get_theme_mod( 'osf_colors_footer_link_color_hover', '#999' );
$footer_color_control       = get_theme_mod('osf_colors_footer_control',false);
$footer_font_style_css      = '';
$footer_css                 = '';
$footer_font                = get_theme_mod('osf_typography_footer_font_family');
$heading_color              = get_theme_mod('osf_typography_footer_heading_color', '#111');

if (is_array($footer_font)) {
    if ($footer_font['family']) {
        $footer_css .= "font-family:\"{$footer_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset($footer_font['fontWeight'])) {
        $footer_css .= "font-weight:{$footer_font['fontWeight']}!important;";
    }
}
if (is_array( $footer_font_style )){
    if ($footer_font_style['italic']){
        $footer_font_style_css .= "font-style:italic;";
    }
    if ($footer_font_style['underline']){
        $footer_font_style_css .= "text-decoration:underline;";
    }
    if ($footer_font_style['fontWeight']){
        $footer_font_style_css .= "font-weight:bold;";
    }
    if ($footer_font_style['uppercase']){
        $footer_font_style_css .= "text-transform:uppercase;";
    }
}
if ($footer_color_control == true) {
    $cssCode .= <<<CSS
    .site-footer {
        color: {$footer_color};
    }
    .site-footer a {
        color: {$footer_color_link};
    }
    .site-footer a:hover {
        color: {$footer_color_link_hover};
    }
CSS;
}
$cssCode .= <<<CSS
.site-footer .vc_custom_heading,.site-footer .widget-title,.site-footer .widgettitle, .site-footer .elementor-widget h5{
    font-size: {$heading_font_size}px;
    letter-spacing: {$heading_letter_spacing}px;
    padding-top: {$heading_padding_top}px;
    padding-bottom: {$heading_padding_bottom}px;
    margin-top: {$heading_margin_top}px;
    margin-bottom: {$heading_margin_bottom}px;
    color: {$heading_color};
    {$footer_font_style_css}
    {$footer_css}
}
CSS;


return $cssCode;
