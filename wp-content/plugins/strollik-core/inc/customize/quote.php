<?php
$quote_css = '';

$quote_font  = get_theme_mod( 'osf_typography_quotes_font_family' );
$color       = get_theme_mod( 'osf_colors_quotes_color', '#666' );
$background  = get_theme_mod( 'osf_colors_quotes_background', 'rgba(255,255,255,0)' );
$borderColor = get_theme_mod( 'osf_colors_quotes_border', '#eceeef' );

if (is_array( $quote_font )){
    if ($quote_font['family']){
        $quote_css .= "font-family:\"{$quote_font['family']}\", -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
}

$quote_font_style = get_theme_mod( 'osf_typography_quotes_font_style' );
if (is_array( $quote_font_style )){
    if ($quote_font_style['italic']){
        $quote_css .= "font-style:italic;";
    }
    if ($quote_font_style['underline']){
        $quote_css .= "text-decoration:underline;";
    }
    if ($quote_font_style['fontWeight']){
        $quote_css .= "font-weight:bold;";
    }
}

if ($color && $color != '#666'){
    $quote_css .= "color:{$color};";
}

if ($background && $background != 'rgba(255,255,255,0)'){
    $quote_css .= "background-color:{$background};";
}

if ($borderColor && $borderColor != '#eceeef'){
    $quote_css .= "border-left-color:{$borderColor};";
}

if ($quote_css){
    return <<<CSS
blockquote{
    {$quote_css}
}
CSS;
} else{
    return '';
}