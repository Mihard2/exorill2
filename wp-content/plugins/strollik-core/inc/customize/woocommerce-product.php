<?php
if (!otf_is_woocommerce_activated()) {
    return '';
}
$cssCode = '';
$SaleFlash = get_theme_mod('osf_woocommerce_product_color_label_sale', '#666');
$bgSaleFlash = get_theme_mod('osf_woocommerce_product_color_bg_label_sale', '#fff');
$borderSaleFlash = get_theme_mod('osf_woocommerce_product_color_border_label_sale', '#fff');

$cssCode .= <<<CSS
/*sale*/
[class*="product-style-"] li.product .product-block .onsale,[class*="product-style-"] li.product .product-block .onsale:before 
{
    background-color: {$bgSaleFlash};
    color: {$SaleFlash};
    border-color: {$borderSaleFlash};
}
CSS;

return $cssCode;
