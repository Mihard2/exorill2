<?php
$cssCode        = '';
$page_title_css = '';
$breadcrumb_css = '';
$breadcrumb_font_css = '';
$page_title_bar = '';

$page_title_font = get_theme_mod( 'osf_typography_page_title_font_family' );
if (is_array( $page_title_font )){
    if ($page_title_font['family']){
        $page_title_css .= "font-family:\"{$page_title_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset( $page_title_font['fontWeight'] )){
        $page_title_css .= "font-weight:{$page_title_font['fontWeight']};";
    }
}

$breadcrumb_font = get_theme_mod( 'osf_typography_page_title_breadcrumb_font_family' );
if (is_array( $breadcrumb_font )){
    if ($breadcrumb_font['family']){
        $breadcrumb_font_css .= "font-family:\"{$breadcrumb_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset( $breadcrumb_font['fontWeight'] )){
        $breadcrumb_font_css .= "font-weight:{$breadcrumb_font['fontWeight']};";
    }
}

$page_title_height = get_theme_mod( 'osf_layout_page_title_height', 90 );
if ($page_title_height && $page_title_height != 90){
    $cssCode .= <<<CSS
@media screen and (min-width: 48em) {
    .page-title-bar .wrap {
        min-height:{$page_title_height}px;
    }
}
CSS;
}

$page_title_padding_top = get_theme_mod( 'osf_layout_page_title_padding_top', 0);
if ($page_title_padding_top && $page_title_padding_top !=0){
    $cssCode .= <<<CSS
@media screen and (min-width: 48em) {
    .page-title-bar .wrap {
        padding-top:{$page_title_padding_top}px;
    }
}
CSS;

}
$page_title_padding_right = get_theme_mod( 'osf_layout_page_title_padding_right', 0);
if ($page_title_padding_right && $page_title_padding_right !=0){
    $cssCode .= <<<CSS
@media screen and (min-width: 768px) {
    .page-title-bar .wrap {
        padding-right:{$page_title_padding_right}px;
    }
}
CSS;
}

$page_title_padding_bottom = get_theme_mod( 'osf_layout_page_title_padding_bottom', 0);
if ($page_title_padding_bottom && $page_title_padding_bottom !=0){
    $cssCode .= <<<CSS
@media screen and (min-width: 48em) {
    .page-title-bar .wrap {
        padding-bottom:{$page_title_padding_bottom}px;
    }
}
CSS;
}
$page_title_padding_left = get_theme_mod( 'osf_layout_page_title_padding_left', 0);
if ($page_title_padding_left && $page_title_padding_left !=0){
    $cssCode .= <<<CSS
@media screen and (min-width: 768px) {
    .page-title-bar .wrap {
        padding-left:{$page_title_padding_left}px;
    }
}
CSS;
}

if (is_page()){
    $page_title_bg_color = ( $page_title_bg_color = get_post_meta( get_the_ID(), 'osf_breadcrumb_bg_color', 1 ) ) ? $page_title_bg_color : get_theme_mod( 'osf_colors_page_title_bg', '#fafafa' );
    $page_title_bg_image = ( $page_title_bg_image = get_post_meta( get_the_ID(), 'osf_breadcrumb_bg_image', 1 ) ) ? $page_title_bg_image : get_theme_mod( 'osf_colors_page_title_bg_image' );
    $breadcrumb_color    = ( $breadcrumb_color = get_post_meta( get_the_ID(), 'osf_breadcrumb_text_color', 1 ) ) ? $breadcrumb_color : get_theme_mod( 'osf_colors_page_title_breadcrumb_color', '#222' );
    $page_title_color    = ( $page_title_color = get_post_meta( get_the_ID(), 'osf_heading_color', 1 ) ) ? $page_title_color : get_theme_mod( 'osf_colors_page_title_heading_color', '#666' );
} else{
    $page_title_bg_color = get_theme_mod( 'osf_colors_page_title_bg', '#fafafa' );
    $page_title_bg_image = get_theme_mod( 'osf_colors_page_title_bg_image' );
    $page_title_color    = get_theme_mod( 'osf_colors_page_title_heading_color', '#666' );
    $breadcrumb_color    = get_theme_mod( 'osf_colors_page_title_breadcrumb_color', '#222' );
    $page_title_border_color = get_theme_mod( 'osf_colors_page_title_border_color', '#ffffff' );
    $page_title_border_top       = get_theme_mod( 'osf_colors_page_title_border_top', 0 );
    $page_title_border_bottom       = get_theme_mod( 'osf_colors_page_title_border_bottom', 0 );
}

$breadcrumb_color = ariColor::new_color( $breadcrumb_color );

if (!empty($page_title_border_top) && $page_title_border_top != 0){
    $page_title_bar .= "border-top-width: {$page_title_border_bottom}px;";
}
if (!empty($page_title_border_top) && $page_title_border_top != 0){
    $page_title_bar .= "border-bottom-width: {$page_title_border_top}px;";
}
if (!empty($page_title_border_color) && $page_title_border_color != '#ffffff'){
    $page_title_bar .= "border-color: {$page_title_border_color};";
    $page_title_bar .= "border-style: solid;";
}

if (!empty($page_title_bg_color) && $page_title_bg_color != '#fafafa'){
    $page_title_bar .= "background-color: {$page_title_bg_color};";
}


if (!empty( $page_title_bg_image )){
    $page_title_bar .= "background-image: url({$page_title_bg_image});";
}

$page_title_bg_repeat = get_theme_mod( 'osf_colors_page_title_bg_repeat', 1 );
if (!empty( $page_title_bg_image ) && $page_title_bg_repeat){
    $page_title_bar .= "background-repeat: no-repeat;";
}
$page_title_bg_position = get_theme_mod( 'osf_colors_page_title_bg_position', 'top left' );
if (!empty( $page_title_bg_position )){
    $page_title_bar .= "background-position: {$page_title_bg_position};";
}

if (!empty( $page_title_bar )){
    $cssCode .= <<<CSS
.page-title-bar {
    {$page_title_bar};
}
CSS;
}
$page_title_css_color = '';
if ($page_title_color && $page_title_color != '#666'){
    $page_title_css_color .= "color: {$page_title_color};";
}

$font_style = get_theme_mod( 'osf_typography_page_title_font_style' );
if (is_array( $font_style )){
    if ($font_style['italic']){
        $page_title_css .= "font-style:italic;";
    }
    if ($font_style['underline']){
        $page_title_css .= "text-decoration:underline;";
    }
    if ($font_style['fontWeight']){
        $page_title_css .= "font-weight:bold;";
    }
    if ($font_style['uppercase']){
        $page_title_css .= "text-transform:uppercase;";
    }
}

$heading_font_size = get_theme_mod( 'osf_typography_page_title_heading_font_size', 24 );
if ($heading_font_size){
    $page_title_css .= "font-size: {$heading_font_size}px;";
}

$heading_line_height = get_theme_mod( 'osf_typography_page_title_heading_line_height', 28 );
if ($heading_line_height){
    $page_title_css .= "line-height: {$heading_line_height}px;";
}

$heading_letter_spacing = get_theme_mod( 'osf_typography_page_title_heading_letter_spacing', 0 );
if ($heading_letter_spacing && $heading_letter_spacing != 0){
    $page_title_css .= "letter-spacing: {$heading_letter_spacing}px;";
}

if (!empty( $page_title_css )){
    $cssCode .= <<<CSS
    .page-title{
        $page_title_css_color 
    }
@media screen and (min-width: 48em) {
    .page-title {
        {$page_title_css};
    }
}
CSS;
}

$breadcrumb_css .= "color: {$breadcrumb_color->toCSS()};";


$breadcrumb_font_style = get_theme_mod( 'osf_typography_page_title_breadcrumb_font_style' );
if (is_array( $breadcrumb_font_style )){
    if ($breadcrumb_font_style['italic']){
        $breadcrumb_css .= "font-style:italic;";
    }
    if ($breadcrumb_font_style['underline']){
        $breadcrumb_css .= "text-decoration:underline;";
    }
    if ($breadcrumb_font_style['fontWeight']){
        $breadcrumb_css .= "font-weight:bold;";
    }
    if ($breadcrumb_font_style['uppercase']){
        $breadcrumb_css .= "text-transform:uppercase;";
    }
}

$breadcrumb_font_size = get_theme_mod( 'osf_typography_page_title_breadcrumb_font_size', 14 );
if ($breadcrumb_font_size){
    $breadcrumb_css .= "font-size: {$breadcrumb_font_size}px;";
}

$breadcrumb_line_height = get_theme_mod( 'osf_typography_page_title_breadcrumb_heading_line_height', 20 );
if ($breadcrumb_line_height){
    $breadcrumb_css .= "line-height: {$breadcrumb_line_height}px;";
}

$breadcrumb_letter_spacing = get_theme_mod( 'osf_typography_page_title_breadcrumb_letter_spacing"', 0 );
if ($breadcrumb_letter_spacing && $breadcrumb_letter_spacing != 0){
    $breadcrumb_css .= "letter-spacing: {$breadcrumb_letter_spacing}px;";
}

if (!empty( $breadcrumb_css )){
    $cssCode .=
        <<<CSS
@media screen and (min-width: 48em) {
    .breadcrumb, .breadcrumb span, .breadcrumb * {
        {$breadcrumb_css};
    }
}
CSS;
}
if (!empty( $breadcrumb_font_css )){
    $cssCode .=
        <<<CSS
    .breadcrumb {
        {$breadcrumb_font_css};
    }
CSS;
}

$breadcrumb_color_hover = $breadcrumb_color->get_new( 'lightness', $breadcrumb_color->lightness - 20 )->toCSS();
$cssCode                .= <<<CSS
.breadcrumb a:hover{
    color: {$breadcrumb_color_hover};
}
CSS;


/**
 * @return string Css Typograply page title
 */
return $cssCode;
