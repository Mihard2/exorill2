<?php

$cssCode = '/** Sidebar */';
if (get_theme_mod( 'osf_layout_sidebar_is_boxed', false )){
    $sidebar_background_color = get_theme_mod( 'osf_colors_sidebar_bg_color', '#fff' );
    $sidebar_border_color     = get_theme_mod( 'osf_colors_sidebar_border_color', '#ddd' );
    $sidebar_padding          = get_theme_mod( 'osf_layout_sidebar_padding_inside_boxed', 30 );
    $sidebar_color            = ariColor::new_color( get_theme_mod( 'osf_colors_sidebar_color', '#222' ) );
    $sidebar_color_hover      = $sidebar_color->get_new( 'lightness', $sidebar_color->lightness - 15 )->to_css( 'rgba' );
    $sidebar_layout_prefix    = '';
    $border_radius            = get_theme_mod( 'osf_layout_sidebar_sidebar_border_radius', 0 );

    if (get_theme_mod( 'osf_layout_sidebar_title_outside', false )){
        $sidebar_layout_prefix = '>*:not(.widget-title):not(.customize-partial-edit-shortcut)';
    }
    $cssCode .= <<<CSS
.opal-sidebar-boxed #secondary .widget{$sidebar_layout_prefix} {
    background-color: $sidebar_background_color;
    padding: {$sidebar_padding}px;
    border-radius: {$border_radius}px;
}
.opal-sidebar-boxed #secondary .widget ul li {
    border-color: $sidebar_border_color;
}
#secondary .widget_recent_entries ul li:before, #secondary .widget_pages ul li:before, #secondary .widget_categories ul li:before, #secondary .widget_archive ul li:before, #secondary .widget_recent_comments ul li:before, #secondary .widget_nav_menu ul li:before, #secondary .widget_links ul li:before, #secondary .widget_product_categories ul li:before, #secondary .widget_layered_nav ul li:before, #secondary .widget_layered_nav_filters ul li:before,
#secondary .widget a:not(.button)
{
    color: {$sidebar_color->to_css( 'rgba' )};
}
#secondary .widget a:hover:not(.button),
#secondary .widget a:active:not(.button){
    color: {$sidebar_color_hover};
}
.opal-sidebar-boxed #secondary .widget-property-filter form > div {
    margin-left: -{$sidebar_padding}px;
    margin-right: -{$sidebar_padding}px;
    padding-left: {$sidebar_padding}px;
    padding-right: {$sidebar_padding}px;
}
CSS;
    if ($sidebar_layout_prefix){
        $height  = $sidebar_padding * 2;
        $cssCode .= <<<CSS
.opal-sidebar-boxed #secondary .search-form .search-submit{
    height: calc(100% - {$height}px - 12px);
    top: calc({$sidebar_padding}px + 9px);
    right: calc({$sidebar_padding}px + 3px);
}
CSS;
    }
}

$font_size      = get_theme_mod( 'osf_typography_sidebar_title_font_size', 16 );
$letter_spacing = get_theme_mod( 'osf_typography_sidebar_title_letter_spacing', 1 );
$padding_top    = get_theme_mod( 'osf_typography_sidebar_title_padding_top', 15 );
$padding_bottom = get_theme_mod( 'osf_typography_sidebar_title_padding_bottom', 15 );
$margin_top     = get_theme_mod( 'osf_typography_sidebar_title_margin_top', 20 );
$margin_bottom  = get_theme_mod( 'osf_typography_sidebar_title_margin_bottom', 20 );
$color_title    = get_theme_mod( 'osf_colors_sidebar_title_color', '#222' );

$cssCode .= <<<CSS
#secondary .widget-title{
    font-size: {$font_size}px;
    letter-spacing: {$letter_spacing}px;
    padding-top: {$padding_top}px;
    padding-bottom: {$padding_bottom}px;
    margin-top: {$margin_top}px;
    margin-bottom: {$margin_bottom}px;
    color: {$color_title};
}
CSS;

$font_style              = get_theme_mod( 'osf_typography_sidebar_font_style' );
$widget_title_font_style = '';
if (is_array( $font_style )){
    if ($font_style['italic']){
        $widget_title_font_style .= "font-style:italic;";
    }
    if ($font_style['underline']){
        $widget_title_font_style .= "text-decoration:underline;";
    }
    if ($font_style['fontWeight']){
        $widget_title_font_style .= "font-weight:bold;";
    }

    if ($font_style['uppercase']){
        $widget_title_font_style .= "text-transform:uppercase;";
    }
}

if ($widget_title_font_style){
    $cssCode .= <<<CSS
#secondary .widget-title {
    {$widget_title_font_style}
}

CSS;
}
return $cssCode;
