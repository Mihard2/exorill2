<?php
/**
 * @return string
 */
function osf_theme_custom_css() {
    $a1root = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/a1root.php';
    $grid = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/grid.php';
    $main_menu = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/main-menu.php';
    $vertical_menu = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/vertical-menu.php';
    $button_animation = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/button-animation.php';
    $button = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/button.php';
    $error_404 = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/error-404.php';
    $footer = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/footer.php';
    $header = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/header.php';
    $heading = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/heading.php';
    $main_layout = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/main-layout.php';
    $offcanvas_menu = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/offcanvas-menu.php';
    $page_bg = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/page-bg.php';
    $page_title = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/page-title.php';
    $quote = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/quote.php';
//    $side_header         = include trailingslashit( STROLLIK_CORE_PLUGIN_DIR ) . 'inc/customize/side-header.php';
    $sidebar = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/sidebar.php';
    $widget = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/widget.php';
    $woocommerce_product = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/woocommerce-product.php';
    $css = <<<CSS
{$a1root}
{$grid}
{$main_menu}
{$vertical_menu}
{$button_animation}
{$error_404}
{$footer}
{$header}
{$heading}
{$main_layout}
{$offcanvas_menu}
{$page_bg}
{$page_title}
{$quote}
{$sidebar}
{$widget}
{$button}
{$woocommerce_product}
CSS;

    $css = apply_filters('osf_theme_customizer_css', $css);
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}

/**
 * @return string
 */
function osf_theme_custom_css_no_cache($css) {
    $sidebar_width = include trailingslashit(STROLLIK_CORE_PLUGIN_DIR) . 'inc/customize/sidebar-width.php';
    $css .= $sidebar_width;
    global $osf_header;
    if ($osf_header) {
        $header_css = get_post_meta($osf_header->ID, '_wpb_shortcodes_custom_css', true);
        $css .= $header_css;
        $bg_header = osf_get_metabox($osf_header->ID, 'osf_header_bg_color_mobile', '');
        if(!empty($bg_header)){
            $css .= '@media(max-width: 991px){.opal-header-absolute .site-header{background:'.$bg_header.';}}';
        }
    }

    // Footer Css
    $footer_id = get_theme_mod('osf_footer_layout');
    $page_id = get_the_ID();

    if (is_page() && osf_get_metabox(get_the_ID(), 'osf_enable_custom_footer', false)) {
        $footer_id = osf_get_metabox($page_id, 'osf_footer_layout', false);
        $footer_padding_top = osf_get_metabox(get_the_ID(), 'osf_footer_padding_top', 15);
        $css .= '.site-footer {padding-top:' . $footer_padding_top . 'px!important;}';
    }
    if ($footer_id) {
        $footer_css = get_post_meta($footer_id, '_wpb_shortcodes_custom_css', true);
        $css .= $footer_css;
    }

    // Padding Page
    if (is_page()) {
        $padding_top = osf_get_metabox($page_id, 'osf_padding_top', 0);
        $padding_bottom = osf_get_metabox($page_id, 'osf_padding_bottom', 0);
        if (is_front_page()) {
            $css .= '.panel-content .wrap{padding-top:' . $padding_top . 'px!important;}';
            $css .= '.panel-content .wrap{padding-bottom:' . $padding_bottom . 'px!important;}';
        } else {
            $css .= '.site-content{padding-top:' . $padding_top . 'px!important;}';
            $css .= '.site-content{padding-bottom:' . $padding_bottom . 'px!important;}';
        }
    }

    return $css;
}

add_filter('osf_theme_custom_inline_css', 'osf_theme_custom_css_no_cache');