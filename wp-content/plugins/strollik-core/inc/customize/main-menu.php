<?php
if (!defined( 'ABSPATH' )){
    exit;
}
$mainmenu_css = '';
$cssCode      = '';
/**
 * @var array $mainmenu_font
 */
$mainmenu_font = get_theme_mod( 'osf_typography_mainmenu_font_family' );
if (is_array( $mainmenu_font )){
    if ($mainmenu_font['family']){
        $mainmenu_css .= "font-family:\"{$mainmenu_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset( $mainmenu_font['fontWeight'] )){
        $mainmenu_css .= "font-weight:{$mainmenu_font['fontWeight']};";
    }
}

$font_style      = get_theme_mod( 'osf_typography_mainmenu_font_style' );
$font_style_code = '';
if (is_array( $font_style )){
    if ($font_style['italic']){
        $font_style_code .= "font-style:italic;";
    }
    if ($font_style['underline']){
        $font_style_code .= "text-decoration:underline;";
    }
    if ($font_style['fontWeight']){
        $font_style_code .= "font-weight:bold;";
    }

    if ($font_style['uppercase']){
        $font_style_code .= "text-transform:uppercase;";
    }
}

$font_size = get_theme_mod('osf_typography_mainmenu_font_size', 14);


    $cssCode .= <<<CSS
.site-header-desktop .mainmenu-container .top-menu > li > a, .vertical-navigation .menu-open-label{
    font-size: {$font_size}px;
    {$mainmenu_css}
    {$font_style_code}
}
CSS;

return $cssCode;