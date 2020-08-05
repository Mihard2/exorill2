<?php
$cssCode = '';
$enable_custom = get_theme_mod('osf_colors_buttons_enable_custom', false);
if ($enable_custom) {
    $primary = get_theme_mod('osf_colors_buttons_primary_bg', '#222');
    $primary_border = get_theme_mod('osf_colors_buttons_primary_border', '#222');
    $primary_color = get_theme_mod('osf_colors_buttons_primary_color', '#fff');
    $primary_color_outline = get_theme_mod('osf_colors_buttons_primary_color_outline', '#222');
    $primary_hover = get_theme_mod('osf_colors_buttons_primary_hover_bg', '#222');
    $primary_border_hover = get_theme_mod('osf_colors_buttons_primary_hover_border', '#222');
    $primary_color_hover = get_theme_mod('osf_colors_buttons_primary_hover_color', '#fff');

    $secondary = get_theme_mod('osf_colors_buttons_secondary_bg', '#767676');
    $secondary_border = get_theme_mod('osf_colors_buttons_secondary_border', '#767676');
    $secondary_color = get_theme_mod('osf_colors_buttons_secondary_color', '#fff');
    $secondary_color_outline = get_theme_mod('osf_colors_buttons_secondary_color_outline', '#767676');
    $secondary_hover = get_theme_mod('osf_colors_buttons_secondary_hover_bg', '#767676');
    $secondary_border_hover = get_theme_mod('osf_colors_buttons_secondary_hover_border', '#767676');
    $secondary_color_hover = get_theme_mod('osf_colors_buttons_secondary_hover_color', '#fff');
} else {
    $ariPrimary = ariColor::new_color(get_theme_mod('osf_colors_general_primary', '#0160b4'));
    $primary = $primary_border = $primary_color_outline = $ariPrimary->toCSS();
    $primary_hover = $primary_border_hover = $ariPrimary->get_new('lightness', $ariPrimary->lightness - 10)->toCSS();

    $ariSecondary = ariColor::new_color(get_theme_mod('osf_colors_general_secondary', '#00c484'));
    $secondary = $secondary_border = $secondary_color_outline = $ariSecondary->toCSS();
    $secondary_hover = $secondary_border_hover = $ariSecondary->get_new('lightness', $ariSecondary->lightness - 10)->toCSS();

    $primary_color = $primary_color_hover = $secondary_color = $secondary_color_hover = '#fff';
}

$button_css = '';
$button_font = get_theme_mod('osf_typography_button_font_family');
if (is_array($button_font)) {
    if ($button_font['family']) {
        $button_css .= "font-family:\"{$button_font['family']}\",-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, \"Helvetica Neue\", Arial, sans-serif;";
    }
    if (isset($button_font['fontWeight'])) {
        $button_css .= "font-weight:{$button_font['fontWeight']};";
    }
}

$font_style = get_theme_mod('osf_typography_button_font_style');
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

$font_size = get_theme_mod('osf_typography_button_font_size',14);
$line_height = get_theme_mod('osf_typography_button_line_height',20);
$button_css .= "font-size:{$font_size}px;";
$button_css .= "line-height:{$line_height}px";

$animation = get_theme_mod('osf_animations_buttons_background', 1);
$border_radius = get_theme_mod('osf_layout_buttons_border_radius', 3);

$cssCode .= apply_filters('osf_customize_button_primary_color', $cssCode, $primary, $primary_hover, $primary_border, $primary_border_hover, $primary_color, $primary_color_hover, $border_radius, $primary_color_outline, $button_css, $font_style_code);
$cssCode .= apply_filters('osf_customize_button_secondary_color', $cssCode, $secondary, $secondary_hover, $secondary_border, $secondary_border_hover, $secondary_color, $secondary_color_hover, $border_radius, $secondary_color_outline, $button_css, $font_style_code);

$cssCode .= <<<CSS
    button ,input[type="submit"], input[type="reset"], input[type="button"], .button, .btn, .vc_btn, .vc_btn3 {
        {$button_css}
        {$font_style_code}
    }
CSS;

if ($animation != 1) {
    $cssCode .= <<<CSS
@-webkit-keyframes primary-back-pulse {
    50% {
        background-color: $primary;
        border-color: $primary;
    }
}
@keyframes primary-back-pulse {
    50% {
        background-color: $primary;
        border-color: $primary;
    }
}
@-webkit-keyframes secondary-back-pulse {
    50% {
        background-color: $secondary;
        border-color: $secondary;
    }
}
@keyframes secondary-back-pulse {
    50% {
        background-color: $secondary;
        border-color: $secondary;
    }
}
CSS;

    if ($animation == 2) {
        $cssCode .= <<<CSS

.opal-button-animation-bg-2 .button-secondary:hover,
.opal-button-animation-bg-2 .button-secondary:focus,
.opal-button-animation-bg-2 .button-secondary:active,
.opal-button-animation-bg-2 .button-outline-secondary:hover,
.opal-button-animation-bg-2 .button-outline-secondary:focus,
.opal-button-animation-bg-2 .button-outline-secondary:active{
    background-color: $secondary_hover;
}

.opal-button-animation-bg-2 .button-primary:hover, 
.opal-button-animation-bg-2 .button-primary:focus,
.opal-button-animation-bg-2 .button-primary:active,
.opal-button-animation-bg-2 .button-outline-primary:hover,
.opal-button-animation-bg-2 .button-outline-primary:focus,
.opal-button-animation-bg-2 .button-outline-primary:active,
.opal-button-animation-bg-2 .search-submit:hover,
.opal-button-animation-bg-2 .search-submit:focus,
.opal-button-animation-bg-2 .search-submit:active,
.opal-button-animation-bg-2 .entry-footer .edit-link a.post-edit-link:hover,
.opal-button-animation-bg-2 .entry-footer .edit-link a.post-edit-link:focus,
.opal-button-animation-bg-2 .entry-footer .edit-link a.post-edit-link:active {
    background-color: $primary_hover;
}
.opal-header-skin-custom .site-header a.button-primary {
    color: $primary_color;
}
.opal-header-skin-custom .site-header a.button-secondary {
    color: $secondary_color;
}
CSS;

    } else {

        $cssCode
            .= <<<CSS
.opal-button-animation-bg-{$animation} .button-primary:before,
.opal-button-animation-bg-{$animation} .button-outline-primary:before,
.opal-button-animation-bg-{$animation} .search-submit:before,
.opal-button-animation-bg-{$animation} .entry-footer .edit-link a.post-edit-link:before{
    background-color: $primary_hover;
    border-radius: {$border_radius}px;
}
.opal-button-animation-bg-{$animation} .button-primary:hover, 
.opal-button-animation-bg-{$animation} .button-primary:focus, 
.opal-button-animation-bg-{$animation} .button-primary:active,
.opal-button-animation-bg-{$animation} .button-outline-primary:hover, 
.opal-button-animation-bg-{$animation} .button-outline-primary:focus, 
.opal-button-animation-bg-{$animation} .button-outline-primary:active,
.opal-button-animation-bg-{$animation} .search-submit:hover, 
.opal-button-animation-bg-{$animation} .search-submit:focus, 
.opal-button-animation-bg-{$animation} .search-submit:active,
.opal-button-animation-bg-{$animation} .entry-footer .edit-link a.post-edit-link:hover,
.opal-button-animation-bg-{$animation} .entry-footer .edit-link a.post-edit-link:focus,
.opal-button-animation-bg-{$animation} .entry-footer .edit-link a.post-edit-link:active{
        background-color: $primary;
        border-color: transparent;
}

.opal-button-animation-bg-{$animation} .button-secondary:before,
.opal-button-animation-bg-{$animation} .button-outline-secondary:before{
    background-color: $secondary_hover;
    border-radius: {$border_radius}px;
}
.opal-button-animation-bg-{$animation} .button-secondary:hover,
.opal-button-animation-bg-{$animation} .button-secondary:focus,
.opal-button-animation-bg-{$animation} .button-secondary:active,
.opal-button-animation-bg-{$animation} .button-outline-secondary:hover,
.opal-button-animation-bg-{$animation} .button-outline-secondary:focus,
.opal-button-animation-bg-{$animation} .button-outline-secondary:active {
        background-color: $secondary;
        border-color: transparent;
}
.opal-button-animation-bg-{$animation} .site-header .button-secondary {
    color: $secondary_color;
}
.opal-button-animation-bg-{$animation} .site-header .button-secondary:hover,
.opal-button-animation-bg-{$animation} .site-header .button-outline-secondary:hover{
    color: $secondary_color_hover;
}
CSS;
    }
}
return $cssCode;
