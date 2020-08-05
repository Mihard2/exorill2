<?php
$cssCode = '';
$width = $bg_color = $padding_left = $padding_right = false;
$layout = '1c';
if (is_singular('post')) {
    $layout = get_theme_mod('osf_blog_single_layout', '2cr');
    $width = get_theme_mod('osf_blog_single_sidebar_width', 320);
    $padding_left = get_theme_mod('osf_blog_single_sidebar_padding_left', 0);
    $padding_right = get_theme_mod('osf_blog_single_sidebar_padding_right', 0);
} else if (osf_is_blog_archive()) {
    $layout = get_theme_mod('osf_blog_archive_layout', '2cr');
    $width = get_theme_mod('osf_blog_archive_sidebar_width', 320);
    $padding_left = get_theme_mod('osf_blog_archive_sidebar_padding_left', 0);
    $padding_right = get_theme_mod('osf_blog_archive_sidebar_padding_right', 0);
} else if (is_singular('osf_service')) {
    $layout = get_theme_mod('osf_service_single_layout', '2cr');
    $width = get_theme_mod('osf_service_single_sidebar_width', 320);
} else if (is_post_type_archive('osf_service')) {
    $layout = get_theme_mod('osf_service_archive_layout', '2cr');
    $width = get_theme_mod('osf_service_archive_sidebar_width', 320);
    $padding_left = get_theme_mod('osf_blog_archive_sidebar_padding_left', 0);
    $padding_right = get_theme_mod('osf_blog_archive_sidebar_padding_right', 0);
} elseif (is_page()) {
    if (osf_get_metabox(get_the_ID(), 'osf_enable_sidebar_page', 0) == 1) {
        $layout = '2cr';
    } else {
        $layout = '1c';
    }
    $width = osf_get_metabox(get_the_ID(), 'osf_sidebar_width', 320);
}

$layout = apply_filters('osf_customize_layout_page', $layout);
$width = apply_filters('osf_customize_sidebar_width', $width);
$padding_left = apply_filters('osf_customize_sidebar_padding_left', $padding_left);
$padding_right = apply_filters('osf_customize_sidebar_padding_right', $padding_right);


if ($width && '1c' != $layout) {
    $cssCode .= <<<CSS
@media (min-width: 769px){
    body #secondary{
        flex: 0 0 {$width}px;
        max-width: {$width}px;
    }
    
    #primary{
        flex: 0 0 calc(100% - {$width}px);
        max-width: calc(100% - {$width}px);
    }
}
@media (min-width: 1200px){ 
     .opal-content-layout-2cl #primary .site-main{
        padding-left: {$padding_left}px;
    }
    .opal-content-layout-2cr #primary .site-main {
        padding-right: {$padding_right}px;
    }
}

@media(max-width: 768px){
    #secondary, #primary{
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    body.opal-content-layout-2cl #secondary{
        order: 2;
    }
}

CSS;
}

if ($bg_color) {
    $cssCode .= <<<CSS
.site-content-contain{
    background-color: {$bg_color};
}
CSS;

}

return $cssCode;
