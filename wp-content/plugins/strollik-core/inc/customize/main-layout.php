<?php
$cssCode = '';

// ==================================================
//  Container Width
// ==================================================
$containerSelector = '.container, #content ,.submenu-fullwidth .sub-menu-inner';
$containerType     = get_theme_mod('osf_layout_general_content_width_type', 'px');
if ('px' === $containerType) {
    $containerPx = get_theme_mod('osf_layout_general_content_width_px', 1170);
    $cssCode     .= <<<CSS
@media screen and (min-width: 1200px){
    {$containerSelector}{
        max-width: {$containerPx}px;
    }
}

CSS;

} elseif ('%' === $containerType) {
    $containerPercent = get_theme_mod('osf_layout_general_content_width_percent', 100);
    $cssCode          .= <<<CSS
@media screen and (min-width: 768px){
    {$containerSelector}{
        width: {$containerPercent}%;
    }
}
CSS;
}
//// ==================================================
////  Padding contatiner
//// ==================================================
$containerPaddingSelector = '.container, #content , .container-fluid';
$containerPadding    = get_theme_mod('osf_layout_general_content_width_padding', 15);
if ($containerPadding != 15) {
    $cssCode .= <<<CSS
@media screen and (min-width: 768px){
    {$containerPaddingSelector}{
        padding-left: {$containerPadding}px;
        padding-right: {$containerPadding}px;
    }
}

CSS;
}
//
//// ==================================================
////  Boxed Container Width
//// ==================================================
$layoutMode             = get_theme_mod('osf_layout_general_layout_mode', 'wide');
$containerBoxedSelector = 'body.opal-layout-boxed';
if ('boxed' == $layoutMode) {
    $containerBoxedPx     = get_theme_mod('osf_layout_general_layout_boxed_width', 1170);
    $containerBoxedOffset = get_theme_mod('osf_layout_general_layout_boxed_offset', 20);
    $cssCode              .= <<<CSS
@media screen and (min-width: {$containerBoxedPx}px){
    {$containerBoxedSelector}{
        margin: ${containerBoxedOffset}px auto;
        width: {$containerBoxedPx}px;
    }
    
    {$containerBoxedSelector} #opal-header-sticky{
        left: auto!important;
        width: {$containerBoxedPx}px;
    }
    {$containerBoxedSelector} .elementor-section.elementor-section-stretched{
        max-width: {$containerBoxedPx}px;
    }
}
CSS;

}

//==================================================
// Archive Property
//==================================================
$property_archive_padding_top    = get_theme_mod('osf_property_archive_padding_top', 60);
$property_archive_padding_bottom = get_theme_mod('osf_property_archive_padding_bottom', 60);

$cssCode .= '@media screen and (min-width: 48em) {';
$cssCode .= <<<CSS
    body.opal-property-archive .site-content {
        padding-top:{$property_archive_padding_top}px;
        padding-bottom:{$property_archive_padding_bottom}px;
    }
CSS;
$cssCode .= '}';


return $cssCode;