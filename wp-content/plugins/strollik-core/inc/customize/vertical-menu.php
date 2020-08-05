<?php
$cssCode = '';
$vertical_menu_css = '';
/**
 * @var array $vertical_menu_font
 */
$vertical_menu_font = get_theme_mod('osf_typography_vertical_menu_font_family');
if (is_array($vertical_menu_font)) {
    if ($vertical_menu_font['family']) {
        $vertical_menu_css .= "font-family:\"{$vertical_menu_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset($vertical_menu_font['fontWeight'])) {
        $vertical_menu_css .= "font-weight:{$vertical_menu_font['fontWeight']};";
    }
}

$font_style = get_theme_mod('osf_typography_vertical_menu_font_style');
$font_style_code = '';
if (is_array($font_style)) {
    if ($font_style['italic']) {
        $font_style_code .= "font-style:italic;";
    }
    if ($font_style['underline']) {
        $font_style_code .= "text-decoration:underline;";
    }
    if ($font_style['fontWeight']) {
        $font_style_code .= "font-weight:bold;";
    }

    if ($font_style['uppercase']) {
        $font_style_code .= "text-transform:uppercase;";
    }
}

$font_size = get_theme_mod('osf_typography_vertical_menu_font_size', 14);

$cssCode .= <<<CSS
.otf-vertical-menu .navbar-nav > li > a {
    font-size: {$font_size}px;
    {$vertical_menu_css}
    {$font_style_code}
}
CSS;


return $cssCode;