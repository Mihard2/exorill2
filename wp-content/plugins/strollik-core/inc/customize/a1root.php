<?php
if (!defined( 'ABSPATH' )){
    exit;
}
$cssCode = $body_code = '';

/**
 * @var array $body_font
 */
$vc_grid_font = '';
$body_font = get_theme_mod( 'osf_typography_general_body_font' );

if (is_array( $body_font ) && $body_font['family']){
    $body_code .= "font-family:\"{$body_font['family']}\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    $body_code .= "font-weight: {$body_font['fontWeight']};";
}else{
    $body_font['family'] = '';
    $body_font['fontWeight'] = '400';
}
$body_font_size = get_theme_mod( 'osf_typography_general_body_font_size', 15 );
if ($body_font_size && $body_font_size != 15){
    $body_font_size_css = "font-size: {$body_font_size}px;";
}else{
    $body_font_size_css = '';
}

$body_letter_spacing = get_theme_mod( 'osf_typography_general_body_letter_spacing', 0 );
if ($body_letter_spacing && $body_letter_spacing != 0){
    $body_code .= "letter-spacing: {$body_letter_spacing}px;";
}

$body_line_height = get_theme_mod( 'osf_typography_general_body_line_height', 24 );
if ($body_line_height && $body_line_height != 24){
    $body_code .= "line-height: {$body_line_height}px;";
}

$body_color = get_theme_mod( 'osf_colors_general_body', '#222' );
if ($body_color){
    $body_code .= "color: {$body_color}";
}

$heading_color = get_theme_mod( 'osf_colors_general_heading', '#111' );

$color_primary         = ariColor::new_color( get_theme_mod( 'osf_colors_general_primary', '#0160b4' ) );
$color_primary_hover   = $color_primary->get_new( 'lightness', $color_primary->lightness - 10 );
$color_secondary       = ariColor::new_color( get_theme_mod( 'osf_colors_general_secondary', '#00c484' ) );
$color_secondary_hover = $color_secondary->get_new( 'lightness', $color_secondary->lightness - 10 );

$cssCode .= <<<CSS
body, input, button, button[type="submit"], select, textarea{
    {$body_code}
}
body, input, select, textarea{
    {$body_font_size_css}
}

.c-heading{
    color: {$heading_color};
}

.c-primary{
    color: {$color_primary->toCSS()};
}

.bg-primary{
    background-color: {$color_primary->toCSS()};
}
.b-primary{
    border-color: {$color_primary->toCSS()};
}

.button-primary:hover
{
    background-color: {$color_primary_hover->toCSS()};
    border-color: {$color_primary_hover->toCSS()};
}

.c-secondary {
    color: {$color_secondary->toCSS()};
}
.bg-secondary {
    background-color: {$color_secondary->toCSS()};
}
.b-secondary{
    border-color: {$color_secondary->toCSS()};
}
.button-secondary:hover
{
    background-color: {$color_secondary_hover->toCSS()};
}

CSS;
return apply_filters( 'osf_customize_colors', $cssCode, $color_primary, $color_primary_hover, $color_secondary, $color_secondary_hover, $body_color, $heading_color );
