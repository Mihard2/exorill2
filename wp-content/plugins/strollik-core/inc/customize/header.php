<?php
$cssCode = '';
if (get_theme_mod('osf_colors_header_skin', 'light') === 'custom' || is_customize_preview()) {
    $header_bg_color = ariColor::new_color(get_theme_mod('osf_colors_header_bg', '#fff'));
    $main_menu_color = get_theme_mod('osf_colors_mainmenu');
    $header_color = get_theme_mod('osf_colors_header_color', '#000');
    $header_dark_bg_color = $header_bg_color->get_new('lightness', $header_bg_color->lightness - 10)->to_css('rgba');
    $topbar_bg_color = ariColor::new_color(get_theme_mod('osf_colors_topbar_bg', '#ddd'));
    $topbar_bg_hover = $topbar_bg_color->get_new('lightness', $topbar_bg_color->lightness - 20)->to_css('rgba');
    $topbar_color = get_theme_mod('osf_colors_topbar_color', '#222');
    if (empty($main_menu_color)) {
        $main_menu_color = $header_color;
    }
    $cssCode
        .= <<<CSS
.opal-header-skin-custom .site-header{
    background: {$header_bg_color->to_css('rgba')};
}

.opal-header-skin-custom .site-header,
.opal-header-skin-custom .site-header a:not(.vc_btn3),
.opal-header-skin-custom .site-header .menu-toggle,
.opal-header-skin-custom .site-header .header-button .title,
.opal-header-skin-custom .site-header .header-button .amount,
.opal-header-skin-custom .site-header .header-button .count-text{
    color: $header_color;
}
.opal-header-skin-custom .site-header .main-navigation .top-menu > li > a {
    color: $main_menu_color;
}
.opal-header-skin-custom .top-bar, 
.opal-header-skin-custom .top-bar .social-navigation a, 
.opal-header-skin-custom .top-bar li a,
.opal-header-skin-custom .top-bar .my-account-links-menu .sub-menu, 
.opal-header-skin-custom .top-bar .site-header-cart .widget_shopping_cart {
    background-color: {$topbar_bg_color->to_css('rgba')};
}

.opal-header-skin-custom .top-bar .social-navigation a:hover,
.opal-header-skin-custom .top-bar .social-navigation a:focus,
.opal-header-skin-custom .top-bar li a:hover,
.opal-header-skin-custom .top-bar li a:focus{
    background-color: {$topbar_bg_hover};
}

.opal-header-skin-custom .top-bar, 
.opal-header-skin-custom .top-bar a, 
.opal-header-skin-custom .top-bar a:hover {
    color: $topbar_color;
}
CSS;
}

if (get_theme_mod('osf_colors_header_sticky_skin', 'light') === 'custom' || is_customize_preview()) {
    $header_sticky_bg_color = ariColor::new_color(get_theme_mod('osf_colors_header_sticky_bg', '#fff'));
    $header_sticky_color = get_theme_mod('osf_colors_header_sticky_color', '#000');
    $main_menu_sticky_color = get_theme_mod('osf_colors_mainmenu_sticky');
    if (empty($main_menu_sticky_color)) {
        $main_menu_sticky_color = $header_sticky_color;
    }
    $cssCode .= <<<CSS
    
.opal-header-sticky-skin-custom #opal-header-sticky{
    background: {$header_sticky_bg_color->to_css('rgba')};
}

.opal-header-sticky-skin-custom #opal-header-sticky,
.opal-header-sticky-skin-custom #opal-header-sticky a:not(.vc_btn3),
.opal-header-sticky-skin-custom #opal-header-sticky .header-button .title,
.opal-header-sticky-skin-custom #opal-header-sticky .header-button .amount,
.opal-header-sticky-skin-custom #opal-header-sticky .header-button .count-text{
    color: $header_sticky_color;
}
.opal-header-sticky-skin-custom #opal-header-sticky .main-navigation .top-menu > li > a {
    color: $main_menu_sticky_color;
}
CSS;

}

if (get_theme_mod('osf_header_layout_enable_side_header', false)) {
    $side_header_width = get_theme_mod('osf_header_layout_side_header_width', 300);
    $older_nav_position = $side_header_width - 190;
    $cssCode .= <<<CSS
@media (min-width: 1200px){
    body.opal-header-layout-sideHeader .site-header {
        width: {$side_header_width}px !important;
    }
    
    body.opal-header-layout-sideHeader.opal-side-header-left #page > :not(.site-header):not(.popup) {
        margin-left: {$side_header_width}px !important;
    }
    
    body.opal-header-layout-sideHeader.opal-side-header-right #page > :not(.site-header):not(.popup) {
        margin-right: {$side_header_width}px !important;
    }
    .opal-header-layout-sideHeader .vc_row[data-vc-full-width], .opal-header-layout-sideHeader section[data-vc-full-width] {
        padding-left: {$side_header_width}px;
    }
    .opal-header-layout-sideHeader .product-navigator #older-nav {
        left: {$older_nav_position}px;
    }
    .opal-header-layout-sideHeader .product-navigator #older-nav:hover {
        left: {$side_header_width}px;
    }
}
CSS;

}

return $cssCode;
