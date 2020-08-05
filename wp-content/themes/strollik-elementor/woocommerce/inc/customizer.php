<?php
add_filter( 'osf_customize_colors', 'strollik_customizer_custom_color', 10, 7 );
function strollik_customizer_custom_color($cssCode, $color_primary, $color_primary_hover, $color_secondary, $color_secondary_hover, $color_body, $color_heading) {
    $cssCode .= <<<CSS

input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], textarea, .mainmenu-container ul ul .menu-item > a, .mainmenu-container li a span, .opal-header-skin-custom .site-header .sub-menu a:not(.vc_btn3),
.opal-header-skin-custom .site-header .sub-menu-inner a:not(.vc_btn3), .opal-header-skin-custom .site-header-account .account-links-menu li a,
.opal-header-skin-custom .site-header-account .account-dashboard li a, .opal-header-sticky-skin-custom #opal-header-sticky .sub-menu-inner a:not(.vc_btn3), .opal-header-sticky-skin-custom #opal-header-sticky .site-header-account .account-links-menu li a,
.opal-header-sticky-skin-custom #opal-header-sticky .site-header-account .account-dashboard li a, .breadcrumb a, .breadcrumb span, .opal-header-skin-custom .site-header .site-header-account .account-links-menu li a,
.opal-header-skin-custom .site-header .site-header-account .account-dashboard li a, .widget a, .opal-custom-menu-inline .widget_nav_menu li ul a, .c-body, .blog article.type-post .more-link:hover, .blog article.type-page .more-link:hover, .archive article.type-post .more-link:hover, .archive article.type-page .more-link:hover, .search article.type-post .more-link:hover, .search article.type-page .more-link:hover, .site-header-account .account-links-menu li a,
.site-header-account .account-dashboard li a, .column-item .post-inner .posted-on .entry-date, .cart-collaterals .cart_totals th, #payment .payment_methods li.woocommerce-notice, #payment .payment_methods li.woocommerce-notice--info, #payment .payment_methods li.woocommerce-info, table.woocommerce-checkout-review-order-table th, .owl-theme.woocommerce-carousel.nav-style-4 .owl-nav .owl-prev, .owl-theme.woocommerce-carousel.nav-style-4 .owl-nav .owl-next, .owl-theme.owl-carousel.nav-style-4 .owl-nav .owl-prev, .entry-gallery .nav-style-4.gallery .owl-nav .owl-prev, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-prev, .woocommerce-product-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-prev, .owl-theme.owl-carousel.nav-style-4 .owl-nav .owl-next, .entry-gallery .nav-style-4.gallery .owl-nav .owl-next, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-next, .woocommerce-product-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-next,
.owl-theme .products.nav-style-4 .owl-nav .owl-prev,
.entry-gallery .gallery .products.nav-style-4 .owl-nav .owl-prev,
.owl-theme .products.nav-style-4 .owl-nav .owl-next,
.entry-gallery .gallery .products.nav-style-4 .owl-nav .owl-next, .mc4wp-form .widget-title p .c-body, .mc4wp-form .widget-title p .site-header-account .account-links-menu li a, .site-header-account .account-links-menu li .mc4wp-form .widget-title p a,
.mc4wp-form .widget-title p .site-header-account .account-dashboard li a, .site-header-account .account-dashboard li .mc4wp-form .widget-title p a, .mc4wp-form .widget-title p .cart-collaterals .cart_totals th, .cart-collaterals .cart_totals .mc4wp-form .widget-title p th, .mc4wp-form .widget-title p table.woocommerce-checkout-review-order-table th, table.woocommerce-checkout-review-order-table .mc4wp-form .widget-title p th, .woocommerce-shipping-fields .select2-container--default .select2-selection--single .select2-selection__rendered, .woocommerce-billing-fields .select2-container--default .select2-selection--single .select2-selection__rendered, .opal-currency_switcher .list-currency button[type="submit"], .select-selected, .select-items div, .widget .woof_list_label li .woof_label_term, .opal-style-1.search-form-wapper .search-submit span, .opal-style-1.search-form-wapper .search-submit span:before {
  color: {$color_body}; }



h2.widget-title, h2.widgettitle, .c-heading, .form-group .form-row label, fieldset legend, .vertical-navigation .menu-open-label, .related-heading, .author-wrapper .author-name, .post-navigation .nav-title, .search .entry-header a, .page .entry-header .entry-title, .site-header-account .login-form-title, .comments-title, .column-item .post-inner .entry-title a, table.shop_table_responsive tbody th, .site-header-cart .widget_shopping_cart p.total .woocommerce-Price-amount, .site-header-cart .shopping_cart_nav p.total .woocommerce-Price-amount, .filter-toggle, .filter-close, table.cart:not(.wishlist_table) th, table.cart:not(.wishlist_table) .product-name a, table.cart:not(.wishlist_table) .product-subtotal .woocommerce-Price-amount, .cart-collaterals .cart_totals .order-total .woocommerce-Price-amount, .cart-collaterals .cart_totals .amount, .woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info, #payment .payment_methods > .wc_payment_method > label, table.woocommerce-checkout-review-order-table .order-total .woocommerce-Price-amount, table.woocommerce-checkout-review-order-table .product-name, .woocommerce-billing-fields label, .woocommerce-billing-fields > h3, .cart th,
.shop_table th, .woocommerce-account .woocommerce-MyAccount-content strong,
.woocommerce-account .woocommerce-MyAccount-content .woocommerce-Price-amount, .osf-sorting .display-mode button.active, .osf-sorting .display-mode button:hover, .woocommerce-Tabs-panel table.shop_attributes th,
#osf-accordion-container table.shop_attributes th, .single-product div.product .product_meta .sku_wrapper,
.single-product div.product .product_meta .posted_in,
.single-product div.product .product_meta .tagged_as, .woocommerce-tabs#osf-accordion-container [data-accordion] [data-control], .widget .woof_list_checkbox input[type="checkbox"] + label:after, .widget .woof_list_checkbox input[type="checkbox"]:checked + label, .widget .woof_list_radio input[type="radio"]:checked + label {
  color: {$color_heading}; }



.btn-link, .button-link, .more-link, .mainmenu-container .menu > li.current-menu-item > a, .mainmenu-container ul ul .menu-item > a:hover, .mainmenu-container ul ul .menu-item > a:active, .mainmenu-container ul ul .menu-item > a:focus, .mainmenu-container li.current-menu-parent > a, .mainmenu-container .menu-item > a:hover, .opal-header-skin-dark #opal-header-sticky .main-navigation .top-menu > li > a:hover,
.opal-header-sticky-skin-dark #opal-header-sticky .main-navigation .top-menu > li > a:hover, .opal-header-skin-custom .site-header a:not(.vc_btn3):hover, .opal-header-skin-custom .site-header a:not(.vc_btn3):active, .opal-header-skin-custom .site-header a:not(.vc_btn3):focus,
.opal-header-skin-custom .site-header .main-navigation .top-menu > li > a:hover,
.opal-header-skin-custom .site-header .main-navigation .top-menu > li > a:active,
.opal-header-skin-custom .site-header .main-navigation .top-menu > li > a:focus, .opal-header-sticky-skin-custom #opal-header-sticky a:not(.vc_btn3):hover, .opal-header-sticky-skin-custom #opal-header-sticky a:not(.vc_btn3):active, .opal-header-sticky-skin-custom #opal-header-sticky a:not(.vc_btn3):focus,
.opal-header-sticky-skin-custom #opal-header-sticky .main-navigation .top-menu > li > a:hover,
.opal-header-sticky-skin-custom #opal-header-sticky .main-navigation .top-menu > li > a:active,
.opal-header-sticky-skin-custom #opal-header-sticky .main-navigation .top-menu > li > a:focus, .opal-menu-canvas .current-menu-item > a, .breadcrumb a:hover,
.button-outline-primary, .c-primary, .opal-header-skin-custom .site-header-account .account-dropdown a.lostpass-link, .opal-header-skin-custom .site-header-account .account-dropdown a.register-link, .opal-header-skin-custom .site-header-account .account-links-menu li a:hover,
.opal-header-skin-custom .site-header-account .account-dashboard li a:hover, .opal-header-sticky-skin-custom #opal-header-sticky .site-header-account .account-dropdown a.lostpass-link, .opal-header-sticky-skin-custom #opal-header-sticky .site-header-account .account-dropdown a.register-link, .opal-header-sticky-skin-custom #opal-header-sticky .site-header-account .account-links-menu li a:hover,
.opal-header-sticky-skin-custom #opal-header-sticky .site-header-account .account-dashboard li a:hover, .main-navigation .menu-item > a:hover, .site-header .header-group .search-submit:hover, .navigation-button .menu-toggle:hover, .navigation-button .menu-toggle:focus, .entry-title a:hover, .entry-meta a:hover, body.single-post.opal-single-post-style .navigation .nav-link a:hover, .opal-post-navigation-2 .post-navigation .nav-links .nav-previous a:hover:before, .opal-post-navigation-2 .post-navigation .nav-links .nav-next a:hover:before, .blog article.type-post .more-link, .blog article.type-page .more-link, .archive article.type-post .more-link, .archive article.type-page .more-link, .search article.type-post .more-link, .search article.type-page .more-link, .search .entry-header a:hover, .error404 .go-back:hover, .scrollup:hover .icon, .site-header-account .account-dropdown a.register-link, .site-header-account .account-dropdown a.lostpass-link, .site-header-account .account-links-menu li a:hover,
.site-header-account .account-dashboard li a:hover, .opal-header-skin-custom .site-header .site-header-account .account-dropdown a:not(.vc_btn3), .opal-header-skin-custom .site-header .site-header-account .account-links-menu li a:hover,
.opal-header-skin-custom .site-header .site-header-account .account-dashboard li a:hover, .opal-comment-4 .comment-content h1, .opal-comment-4 .comment-content h2, .opal-comment-4 .comment-content h3, .opal-comment-4 .comment-content h4, .opal-comment-4 .comment-content h5, .opal-comment-4 .comment-content h6, .comment-form a:hover, #secondary .widget_product_categories ul li.current-cat > a, .widget a:hover, .widget_search button[type="submit"]:hover, .widget_search button[type="submit"]:focus, .opal-custom-menu-inline .widget ul li a:hover, .owl-theme.woocommerce-carousel.nav-style-4 .owl-nav .owl-prev:hover, .entry-gallery .woocommerce-carousel.nav-style-4.gallery .owl-nav .owl-prev:hover,
.owl-theme.woocommerce-carousel.nav-style-4 .owl-nav .owl-next:hover,
.entry-gallery .woocommerce-carousel.nav-style-4.gallery .owl-nav .owl-next:hover, .owl-theme.owl-carousel.nav-style-4 .owl-nav .owl-prev:hover, .entry-gallery .nav-style-4.gallery .owl-nav .owl-prev:hover, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-prev:hover, .woocommerce-product-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-prev:hover,
.owl-theme.owl-carousel.nav-style-4 .owl-nav .owl-next:hover,
.entry-gallery .nav-style-4.gallery .owl-nav .owl-next:hover,
.woocommerce .woocommerce-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-next:hover,
.woocommerce-product-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-next:hover,
.owl-theme .products.nav-style-4 .owl-nav .owl-prev:hover,
.entry-gallery .gallery .products.nav-style-4 .owl-nav .owl-prev:hover,
.owl-theme .products.nav-style-4 .owl-nav .owl-next:hover,
.entry-gallery .gallery .products.nav-style-4 .owl-nav .owl-next:hover, .elementor-nav-menu-popup .mfp-close, .column-item .post-inner .entry-title a:hover, .column-item.post-style-5 .post-inner .entry-title a:hover, #secondary .elementor-widget-container h5:first-of-type, .site-header-cart .widget_shopping_cart .product_list_widget li a:hover, .site-header-cart .widget_shopping_cart .product_list_widget li a:focus, .site-header-cart .shopping_cart_nav .product_list_widget li a:hover, .site-header-cart .shopping_cart_nav .product_list_widget li a:focus, .site-header-cart .woocommerce-mini-cart__empty-message:before, .woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info a, .woocommerce-checkout .woocommerce-form-coupon-toggle .woocommerce-info a:hover, .woocommerce-privacy-policy-link, .opal-currency_switcher .list-currency button[type="submit"]:hover, .opal-currency_switcher .list-currency li.active button[type="submit"], ul.products li.product.osf-product-list .price, ul.products li.product .posfed_in a:hover, .select-items div:hover, .single-product div.product .summary .price, .woocommerce-tabs#osf-accordion-container [data-accordion] [data-control]:hover, .button-wrapper #chart-button, #reviews .reviews-summary .review-summary-total .review-summary-result, .link-comment, #secondary section.widget .current-cat > a, .widget_product_categories ul li a:hover,
.widget_rating_filter ul li a:hover,
.woocommerce-widget-layered-nav ul li a:hover,
.widget_product_brands ul li a:hover, .widget_product_categories ul li.chosen a,
.widget_rating_filter ul li.chosen a,
.woocommerce-widget-layered-nav ul li.chosen a,
.widget_product_brands ul li.chosen a, .product_list_widget a:hover, .product_list_widget a:active, .product_list_widget a:focus, .woocommerce-product-list a:hover, .woocommerce-product-list a:active, .woocommerce-product-list a:focus, .product-style-1 li.product .price, .product-style-1 li.product .price ins, .product-style-2 li.product:not(.otf-product-list) .price, .product-style-2 li.product:not(.otf-product-list) .price ins, .product-style-3 li.product .price, .product-style-3 li.product .price ins, .owl-theme.woocommerce-carousel.nav-style-2 .owl-nav [class*=owl]:hover:before, .entry-gallery .woocommerce-carousel.nav-style-2.gallery .owl-nav [class*=owl]:hover:before, .owl-theme.owl-carousel.nav-style-2 .owl-nav [class*=owl]:hover:before, .entry-gallery .nav-style-2.gallery .owl-nav [class*=owl]:hover:before, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-2.products .owl-nav [class*=owl]:hover:before, .woocommerce-product-carousel ul.owl-theme.nav-style-2.products .owl-nav [class*=owl]:hover:before,
.owl-theme .products.nav-style-2 .owl-nav [class*=owl]:hover:before,
.entry-gallery .gallery .products.nav-style-2 .owl-nav [class*=owl]:hover:before, .owl-theme.woocommerce-carousel.nav-style-3 .owl-nav [class*=owl]:hover:before, .entry-gallery .woocommerce-carousel.nav-style-3.gallery .owl-nav [class*=owl]:hover:before, .owl-theme.owl-carousel.nav-style-3 .owl-nav [class*=owl]:hover:before, .entry-gallery .nav-style-3.gallery .owl-nav [class*=owl]:hover:before, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-3.products .owl-nav [class*=owl]:hover:before, .woocommerce-product-carousel ul.owl-theme.nav-style-3.products .owl-nav [class*=owl]:hover:before,
.owl-theme .products.nav-style-3 .owl-nav [class*=owl]:hover:before,
.entry-gallery .gallery .products.nav-style-3 .owl-nav [class*=owl]:hover:before, .column-item .study-case-inner .entry-category a:hover, .elementor-widget-opal-box-overview .elementor-box-overview-wrapper .entry-header a, .single-case_study .entry-title, .single-case_study .entry-meta a:hover, .single-case_study .information h4, .single-case_study .information li a:hover, .single-case_study .information li .meta-label, #secondary .elementor-widget-wp-widget-recent-posts a, .woocommerce-MyAccount-navigation ul li.is-active a {
  color: {$color_primary->toCss()}; }


.cat-tags-links .tags-links a:hover, .page-links .page-number, .opal-comment-form-2 .comment-form input[type="submit"], .opal-comment-form-3 .comment-form input[type="submit"], #secondary .widget_product_categories ul li.current-cat > a:before, section.widget_price_filter .ui-slider .ui-slider-range, .button-primary, input[type="button"], input[type="submit"], input[type="reset"], input.secondary[type="button"], input.secondary[type="reset"], input.secondary[type="submit"], button[type="submit"], .page .edit-link a.post-edit-link, .wc-proceed-to-checkout .button, .woocommerce-cart .return-to-shop a, .wishlist_table .product-add-to-cart a.button, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button, .widget_shopping_cart .buttons .button, .button-outline-primary:hover, .button-outline-primary:active, .button-outline-primary.active,
.show > .button-outline-primary.dropdown-toggle, .bg-primary, [class*="after-title"]:after, .before-title-primary:before, .owl-theme.woocommerce-carousel .owl-dots .owl-dot:hover, .owl-theme.woocommerce-carousel .owl-dots .owl-dot.active, .owl-theme.owl-carousel .owl-dots .owl-dot:hover, .entry-gallery .gallery .owl-dots .owl-dot:hover, .woocommerce .woocommerce-carousel ul.owl-theme.products .owl-dots .owl-dot:hover, .woocommerce-product-carousel ul.owl-theme.products .owl-dots .owl-dot:hover, .owl-theme.owl-carousel .owl-dots .owl-dot.active, .entry-gallery .gallery .owl-dots .owl-dot.active, .woocommerce .woocommerce-carousel ul.owl-theme.products .owl-dots .owl-dot.active, .woocommerce-product-carousel ul.owl-theme.products .owl-dots .owl-dot.active,
.owl-theme .products .owl-dots .owl-dot:hover,
.owl-theme .products .owl-dots .owl-dot.active, .elementor-widget-divider .elementor-divider-separator:before, .column-item .post-inner .post-author:before, .column-item.post-style-5 .post-inner .entry-title:hover:before, .header-button, .notification-added-to-cart .ns-content, #payment .place-order .button:hover, form.register .button[type="submit"]:hover, .opal-label-sale-circle li.product .onsale:before, #yith-quick-view-modal ::-webkit-scrollbar-thumb, #yith-quick-view-modal :window-inactive::-webkit-scrollbar-thumb, .woocommerce-tabs ul.tabs li a:after, .single-product .single_add_to_cart_button, .single-product button.disabled.single_add_to_cart_button[type="submit"], .title-heading:after, .woocommerce-widget-layered-nav ul li.chosen a.osf-label-type, .widget_price_filter .ui-slider .ui-slider-handle, .widget_price_filter .ui-slider .ui-slider-range, .handheld-footer-bar .cart .footer-cart-contents .count, .product-style-1 li.product .yith-wcqv-button,
.product-style-1 li.product .yith-wcwl-add-to-wishlist > div > a,
.product-style-1 li.product .compare, .product-style-1 li.product a[class*="product_type_"], .product-style-2 li.product:not(.otf-product-list) .yith-wcqv-button,
.product-style-2 li.product:not(.otf-product-list) .yith-wcwl-add-to-wishlist > div > a,
.product-style-2 li.product:not(.otf-product-list) .compare, .product-style-2 li.product:not(.otf-product-list) a[class*="product_type_"]:hover, .product-style-2 li.product:not(.otf-product-list) a.loading[class*="product_type_"], .product-style-3 li.product .yith-wcqv-button,
.product-style-3 li.product .yith-wcwl-add-to-wishlist > div > a,
.product-style-3 li.product .compare, .product-style-3 li.product a[class*="product_type_"]:hover, .product-style-3 li.product a.loading[class*="product_type_"] {
  background-color: {$color_primary->toCss()}; }


.form-control:focus, .error404 .go-back, .opal-comment-form-2 .comment-form input[type="submit"], .opal-comment-form-3 .comment-form input[type="submit"], #secondary .widget_product_categories ul li.current-cat > a:before, .button-primary, input[type="button"], input[type="submit"], input[type="reset"], input.secondary[type="button"], input.secondary[type="reset"], input.secondary[type="submit"], button[type="submit"], .page .edit-link a.post-edit-link, .wc-proceed-to-checkout .button, .woocommerce-cart .return-to-shop a, .wishlist_table .product-add-to-cart a.button, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button, .widget_shopping_cart .buttons .button,
.button-outline-primary, .button-outline-primary:hover, .button-outline-primary:active, .button-outline-primary.active,
.show > .button-outline-primary.dropdown-toggle, .b-primary, .owl-theme.woocommerce-carousel.nav-style-2 .owl-nav [class*=owl]:hover, .owl-theme.owl-carousel.nav-style-2 .owl-nav [class*=owl]:hover, .entry-gallery .nav-style-2.gallery .owl-nav [class*=owl]:hover, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-2.products .owl-nav [class*=owl]:hover, .woocommerce-product-carousel ul.owl-theme.nav-style-2.products .owl-nav [class*=owl]:hover,
.owl-theme .products.nav-style-2 .owl-nav [class*=owl]:hover,
.entry-gallery .gallery .products.nav-style-2 .owl-nav [class*=owl]:hover, .owl-theme.woocommerce-carousel.nav-style-4 .owl-nav .owl-prev:hover,
.owl-theme.woocommerce-carousel.nav-style-4 .owl-nav .owl-next:hover, .owl-theme.owl-carousel.nav-style-4 .owl-nav .owl-prev:hover, .entry-gallery .nav-style-4.gallery .owl-nav .owl-prev:hover, .woocommerce .woocommerce-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-prev:hover, .woocommerce-product-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-prev:hover,
.owl-theme.owl-carousel.nav-style-4 .owl-nav .owl-next:hover,
.entry-gallery .nav-style-4.gallery .owl-nav .owl-next:hover,
.woocommerce .woocommerce-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-next:hover,
.woocommerce-product-carousel ul.owl-theme.nav-style-4.products .owl-nav .owl-next:hover,
.owl-theme .products.nav-style-4 .owl-nav .owl-prev:hover,
.entry-gallery .gallery .products.nav-style-4 .owl-nav .owl-prev:hover,
.owl-theme .products.nav-style-4 .owl-nav .owl-next:hover,
.entry-gallery .gallery .products.nav-style-4 .owl-nav .owl-next:hover, .elementor-widget-opal-portfolio .elementor-portfolio__filter.elementor-active, .elementor-widget-opal-portfolio .elementor-portfolio__filter:hover, #payment .place-order .button:hover, form.register .button[type="submit"]:hover, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs li img.flex-active, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs li:hover img, .single-product .single_add_to_cart_button, .single-product button.disabled.single_add_to_cart_button[type="submit"], .woocommerce-widget-layered-nav ul li.chosen a.osf-label-type, .osf-product-deal .woocommerce-product-list .opal-countdown .day, .otf-product-recently-content li:hover .product-thumbnail img, .product-style-3 li.product a[class*="product_type_"] {
  border-color: {$color_primary->toCss()}; }



.btn-link:focus, .btn-link:hover, .button-link:focus, .more-link:focus, .button-link:hover, .more-link:hover, a:hover, a:active {
  color: {$color_primary_hover->toCss()}; }


.button-primary:hover, input:hover[type="button"], input:hover[type="submit"], input:hover[type="reset"], button:hover[type="submit"], .page .edit-link a.post-edit-link:hover, .wc-proceed-to-checkout .button:hover, .woocommerce-cart .return-to-shop a:hover, .wishlist_table .product-add-to-cart a.button:hover, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button:hover, .widget_shopping_cart .buttons .button:hover, .button-primary:active, input:active[type="button"], input:active[type="submit"], input:active[type="reset"], button:active[type="submit"], .page .edit-link a.post-edit-link:active, .wc-proceed-to-checkout .button:active, .woocommerce-cart .return-to-shop a:active, .wishlist_table .product-add-to-cart a.button:active, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button:active, .widget_shopping_cart .buttons .button:active, .button-primary.active, input.active[type="button"], input.active[type="submit"], input.active[type="reset"], button.active[type="submit"], .page .edit-link a.active.post-edit-link, .wc-proceed-to-checkout .active.button, .woocommerce-cart .return-to-shop a.active, .wishlist_table .product-add-to-cart a.active.button, .woocommerce-MyAccount-content .woocommerce-Pagination .active.woocommerce-button, .widget_shopping_cart .buttons .active.button,
.show > .button-primary.dropdown-toggle, .show > input.dropdown-toggle[type="button"], .show > input.dropdown-toggle[type="submit"], .show > input.dropdown-toggle[type="reset"], .show > button.dropdown-toggle[type="submit"], .page .edit-link .show > a.dropdown-toggle.post-edit-link, .wc-proceed-to-checkout .show > .dropdown-toggle.button, .woocommerce-cart .return-to-shop .show > a.dropdown-toggle, .wishlist_table .product-add-to-cart .show > a.dropdown-toggle.button, .woocommerce-MyAccount-content .woocommerce-Pagination .show > .dropdown-toggle.woocommerce-button, .widget_shopping_cart .buttons .show > .dropdown-toggle.button, .single-product .single_add_to_cart_button:hover, .single-product button.disabled.single_add_to_cart_button[type="submit"]:hover, .product-style-1 li.product .yith-wcqv-button:hover,
.product-style-1 li.product .yith-wcwl-add-to-wishlist > div > a:hover,
.product-style-1 li.product .compare:hover, .product-style-2 li.product:not(.otf-product-list) .yith-wcqv-button:hover,
.product-style-2 li.product:not(.otf-product-list) .yith-wcwl-add-to-wishlist > div > a:hover,
.product-style-2 li.product:not(.otf-product-list) .compare:hover, .product-style-3 li.product .yith-wcqv-button:hover,
.product-style-3 li.product .yith-wcwl-add-to-wishlist > div > a:hover,
.product-style-3 li.product .compare:hover {
  background-color: {$color_primary_hover->toCss()}; }


.button-primary:hover, input:hover[type="button"], input:hover[type="submit"], input:hover[type="reset"], button:hover[type="submit"], .page .edit-link a.post-edit-link:hover, .wc-proceed-to-checkout .button:hover, .woocommerce-cart .return-to-shop a:hover, .wishlist_table .product-add-to-cart a.button:hover, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button:hover, .widget_shopping_cart .buttons .button:hover, .button-primary:active, input:active[type="button"], input:active[type="submit"], input:active[type="reset"], button:active[type="submit"], .page .edit-link a.post-edit-link:active, .wc-proceed-to-checkout .button:active, .woocommerce-cart .return-to-shop a:active, .wishlist_table .product-add-to-cart a.button:active, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button:active, .widget_shopping_cart .buttons .button:active, .button-primary.active, input.active[type="button"], input.active[type="submit"], input.active[type="reset"], button.active[type="submit"], .page .edit-link a.active.post-edit-link, .wc-proceed-to-checkout .active.button, .woocommerce-cart .return-to-shop a.active, .wishlist_table .product-add-to-cart a.active.button, .woocommerce-MyAccount-content .woocommerce-Pagination .active.woocommerce-button, .widget_shopping_cart .buttons .active.button,
.show > .button-primary.dropdown-toggle, .show > input.dropdown-toggle[type="button"], .show > input.dropdown-toggle[type="submit"], .show > input.dropdown-toggle[type="reset"], .show > button.dropdown-toggle[type="submit"], .page .edit-link .show > a.dropdown-toggle.post-edit-link, .wc-proceed-to-checkout .show > .dropdown-toggle.button, .woocommerce-cart .return-to-shop .show > a.dropdown-toggle, .wishlist_table .product-add-to-cart .show > a.dropdown-toggle.button, .woocommerce-MyAccount-content .woocommerce-Pagination .show > .dropdown-toggle.woocommerce-button, .widget_shopping_cart .buttons .show > .dropdown-toggle.button, .single-product .single_add_to_cart_button:hover, .single-product button.disabled.single_add_to_cart_button[type="submit"]:hover {
  border-color: {$color_primary_hover->toCss()}; }




.button-outline-secondary, .c-secondary, .author-wrapper .author-name h6, .list-feature-box > li:before, .elementor-widget-opal-box-overview .elementor-box-overview-wrapper .entry-header a:hover, .column-item .services-inner .more-link, article.type-osf_service .more-link, .single-case_study .information li a {
  color: {$color_secondary->toCss()}; }


.site-footer .underline-title .vc_custom_heading:before,
.site-footer .underline-title .widget-title:before,
.site-footer .underline-title .widgettitle:before,
.button-secondary, .secondary-button .search-submit, .button-outline-secondary:hover, .button-outline-secondary:active, .button-outline-secondary.active,
.show > .button-outline-secondary.dropdown-toggle, .bg-secondary, .before-title-secondary:before, #secondary .elementor-nav-menu a:before,
.e--pointer-dot a:before, #secondary .elementor-widget-wp-widget-categories a:before {
  background-color: {$color_secondary->toCss()}; }


.secondary-border .search-form input[type="text"], .secondary-border .search-form input[type="text"]:focus,
.button-secondary, .secondary-button .search-submit,
.button-outline-secondary, .button-outline-secondary:hover, .button-outline-secondary:active, .button-outline-secondary.active,
.show > .button-outline-secondary.dropdown-toggle, .b-secondary {
  border-color: {$color_secondary->toCss()}; }



.button-secondary:hover, .secondary-button .search-submit:hover, .button-secondary:active, .secondary-button .search-submit:active, .button-secondary.active, .secondary-button .active.search-submit,
.show > .button-secondary.dropdown-toggle, .secondary-button .show > .dropdown-toggle.search-submit {
  background-color: {$color_secondary_hover->toCss()}; }


.button-secondary:hover, .secondary-button .search-submit:hover, .button-secondary:active, .secondary-button .search-submit:active, .button-secondary.active, .secondary-button .active.search-submit,
.show > .button-secondary.dropdown-toggle, .secondary-button .show > .dropdown-toggle.search-submit {
  border-color: {$color_secondary_hover->toCss()}; }


CSS;
    return $cssCode;
}
add_filter('osf_customize_grid', 'strollik_customizer_grid_bootstrap', 10 , 2);
function strollik_customizer_grid_bootstrap($cssCode, $gridGutter){
    $cssCode .= <<<CSS

.row, body.opal-content-layout-2cl #content .wrap, body.opal-content-layout-2cr #content .wrap, [data-opal-columns], .opal-archive-style-4.blog .site-main, .opal-archive-style-4.archive .site-main, .opal-default-content-layout-2cr .site-content .wrap, .site-footer .widget-area, .opal-comment-form-2 .comment-form, .opal-comment-form-3 .comment-form, .opal-comment-form-4 .comment-form, .opal-comment-form-6 .comment-form, .widget .gallery,
.elementor-element .gallery,
.single .gallery, .list-feature-box, [data-elementor-columns], .opal-canvas-filter.top .opal-canvas-filter-wrap, .opal-canvas-filter.top .opal-canvas-filter-wrap section.WOOF_Widget .woof_redraw_zone, .woocommerce-cart .woocommerce, .woocommerce-billing-fields .woocommerce-billing-fields__field-wrapper, .woocommerce-MyAccount-content form[class^="woocommerce-"], .woocommerce-columns--addresses, form.track_order, .woocommerce-account .woocommerce, .woocommerce-account .woocommerce .u-columns.woocommerce-Addresses, .woocommerce-Addresses, .woocommerce-address-fields__field-wrapper, ul.products, .osf-sorting, .single-product div.product, .single-product div.product .woocommerce-product-gallery .flex-control-thumbs {
    margin-right: -{$gridGutter}px;
    margin-left: -{$gridGutter}px;
}



.col-1, .col-2, [data-elementor-columns-mobile="6"] .column-item, .col-3, [data-elementor-columns-mobile="4"] .column-item, .col-4, .opal-comment-form-2 .comment-form .comment-form-author, .opal-comment-form-3 .comment-form .comment-form-author, .opal-comment-form-2 .comment-form .comment-form-email, .opal-comment-form-3 .comment-form .comment-form-email, .opal-comment-form-2 .comment-form .comment-form-url, .opal-comment-form-3 .comment-form .comment-form-url, [data-elementor-columns-mobile="3"] .column-item, .col-5, .col-6, .opal-comment-form-4 .comment-form .comment-form-author,
.opal-comment-form-4 .comment-form .comment-form-email,
.opal-comment-form-4 .comment-form .comment-form-url, .opal-comment-form-6 .comment-form .comment-form-author, .opal-comment-form-6 .comment-form .comment-form-email, [data-elementor-columns-mobile="2"] .column-item, .single-product.opal-comment-form-2 .comment-form-author, .single-product.opal-comment-form-3 .comment-form-author,
.single-product.opal-comment-form-2 .comment-form-email,
.single-product.opal-comment-form-3 .comment-form-email, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .related-posts .column-item, .site-footer .widget-area .widget-column, .opal-comment-form-2 .comment-form .logged-in-as, .opal-comment-form-3 .comment-form .logged-in-as,
.opal-comment-form-2 .comment-form .comment-notes,
.opal-comment-form-3 .comment-form .comment-notes,
.opal-comment-form-2 .comment-form .comment-form-comment,
.opal-comment-form-3 .comment-form .comment-form-comment, .opal-comment-form-2 .comment-form .form-submit, .opal-comment-form-3 .comment-form .form-submit, .opal-comment-form-4 .comment-form .logged-in-as,
.opal-comment-form-4 .comment-form .comment-notes,
.opal-comment-form-4 .comment-form .comment-form-comment,
.opal-comment-form-4 .comment-form .form-submit, .opal-comment-form-6 .comment-form .logged-in-as,
.opal-comment-form-6 .comment-form .comment-notes,
.opal-comment-form-6 .comment-form .comment-form-comment, .opal-comment-form-6 .comment-form .comment-form-url, .opal-comment-form-6 .comment-form .form-submit, .widget .gallery-columns-1 .gallery-item,
.elementor-element .gallery-columns-1 .gallery-item,
.single .gallery-columns-1 .gallery-item, [data-elementor-columns-mobile="1"] .column-item, .elementor-single-product .single-product div.product .entry-summary, .woocommerce-cart .cart-empty, .woocommerce-cart .return-to-shop, .woocommerce-billing-fields .form-row-wide, .woocommerce-MyAccount-content form[class^="woocommerce-"] > *:not(fieldset), .woocommerce-MyAccount-content form[class^="woocommerce-"] .form-row-wide, #customer_details [class*='col'], .columns-1 ul.products li.product,
.columns-1 ul.products > li, #reviews .comment-form-rating, .col, body #secondary, .mfp-content .comment-form-rating, .opal-canvas-filter.top .opal-canvas-filter-wrap section, .opal-canvas-filter.top .opal-canvas-filter-wrap section.WOOF_Widget .woof_redraw_zone .woof_container, .columns-5 ul.products li.product,
.columns-5 ul.products > li, .woocommerce-product-list.boxed, .woocommerce-product-list.skin-border-box li .inner, .woocommerce-product-list.skin-line-right li .inner,
.col-auto, .col-sm-1, [data-opal-columns="12"] .column-item, .col-sm-2, [data-opal-columns="6"] .column-item, .columns-6 ul.products li.product,
.columns-6 ul.products > li, .col-sm-3, [data-opal-columns="4"] .column-item, .col-sm-4, [data-opal-columns="3"] .column-item, .widget .gallery-columns-6 .gallery-item,
.elementor-element .gallery-columns-6 .gallery-item,
.single .gallery-columns-6 .gallery-item, .col-sm-5, .col-sm-6, [data-opal-columns="2"] .column-item, .widget .gallery-columns-2 .gallery-item,
.elementor-element .gallery-columns-2 .gallery-item,
.single .gallery-columns-2 .gallery-item, .widget .gallery-columns-3 .gallery-item,
.elementor-element .gallery-columns-3 .gallery-item,
.single .gallery-columns-3 .gallery-item, .widget .gallery-columns-4 .gallery-item,
.elementor-element .gallery-columns-4 .gallery-item,
.single .gallery-columns-4 .gallery-item, .list-feature-box > li, .woocommerce-billing-fields .form-row-first, .woocommerce-billing-fields .form-row-last, .woocommerce-MyAccount-content form[class^="woocommerce-"] .form-row-first, .woocommerce-MyAccount-content form[class^="woocommerce-"] .form-row-last, ul.products li.product, .columns-2 ul.products li.product,
.columns-2 ul.products > li, .columns-3 ul.products li.product,
.columns-3 ul.products > li, .columns-4 ul.products li.product,
.columns-4 ul.products > li, .opal-content-layout-2cl .columns-3 ul.products li.product,
.opal-content-layout-2cl .columns-3 ul.products > li,
.opal-content-layout-2cr .columns-3 ul.products li.product,
.opal-content-layout-2cr .columns-3 ul.products > li, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, [data-opal-columns="1"] .column-item, body.archive [data-columns="1"] .type-osf_service, body.archive [data-columns="1"] .column-item, body.archive [data-columns="1"] .type-portfolio, .cart-collaterals .cross-sells, .woocommerce-columns--addresses .woocommerce-column, form.track_order p:first-of-type, .woocommerce-account .woocommerce-MyAccount-navigation, .woocommerce-account .woocommerce-MyAccount-content, .woocommerce-address-fields__field-wrapper .form-row, .woocommerce-product-carousel ul.products li.product, .osf-sorting .woocommerce-message, .osf-sorting .woocommerce-notice, .opal-content-layout-2cl .osf-sorting .osf-sorting-group,
.opal-content-layout-2cr .osf-sorting .osf-sorting-group, .col-sm,
.col-sm-auto, .col-md-1, .col-md-2, [data-elementor-columns-tablet="6"] .column-item, .col-md-3, [data-elementor-columns-tablet="4"] .column-item, .col-md-4, [data-elementor-columns-tablet="3"] .column-item, .col-md-5, .opal-default-content-layout-2cr #secondary, .osf-sorting .osf-sorting-group, .col-md-6, [data-elementor-columns-tablet="2"] .column-item, .col-md-7, .opal-default-content-layout-2cr #primary, .osf-sorting .osf-sorting-group + .osf-sorting-group, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, [data-elementor-columns-tablet="1"] .column-item, .cart-collaterals, form.track_order p.form-row-first, form.track_order p.form-row-last, form.track_order p:last-of-type, .single-product div.product .entry-summary, .single-product div.product .images, .col-md,
.col-md-auto, .col-lg-1, .col-lg-2, [data-elementor-columns="6"] .column-item, .col-lg-3, [data-elementor-columns="4"] .column-item, .col-lg-4, .opal-default-content-layout-2cr .related-posts .column-item,
.opal-content-layout-2cr .related-posts .column-item,
.opal-content-layout-2cl .related-posts .column-item, [data-elementor-columns="3"] .column-item, .col-lg-5, .col-lg-6, [data-elementor-columns="2"] .column-item, .col-lg-7, .col-lg-8, .opal-content-layout-2cl .osf-sorting .osf-sorting-group + .osf-sorting-group,
.opal-content-layout-2cr .osf-sorting .osf-sorting-group + .osf-sorting-group, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, [data-elementor-columns="1"] .column-item, .col-lg,
.col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, body.archive [data-columns="4"] .type-osf_service, body.archive [data-columns="4"] .column-item, body.archive [data-columns="4"] .type-portfolio, .col-xl-4, body.archive [data-columns="3"] .type-osf_service, body.archive [data-columns="3"] .column-item, body.archive [data-columns="3"] .type-portfolio, .col-xl-5, .col-xl-6, body.archive [data-columns="2"] .type-osf_service, body.archive [data-columns="2"] .column-item, body.archive [data-columns="2"] .type-portfolio, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
.col-xl-auto {
    padding-right: {$gridGutter}px;
    padding-left: {$gridGutter}px;
}



.container, #content, .opal-canvas-filter.top, .otf-product-recently-content .widget_recently_viewed_products {
    padding-right: {$gridGutter}px;
    padding-left: {$gridGutter}px;
}
  @media (min-width: 576px) {
    .container, #content, .opal-canvas-filter.top, .otf-product-recently-content .widget_recently_viewed_products {
      max-width: 540px; } }
  @media (min-width: 768px) {
    .container, #content, .opal-canvas-filter.top, .otf-product-recently-content .widget_recently_viewed_products {
      max-width: 720px; } }
  @media (min-width: 992px) {
    .container, #content, .opal-canvas-filter.top, .otf-product-recently-content .widget_recently_viewed_products {
      max-width: 960px; } }
  @media (min-width: 1200px) {
    .container, #content, .opal-canvas-filter.top, .otf-product-recently-content .widget_recently_viewed_products {
      max-width: 1140px; } }


CSS;
    return $cssCode;
}
add_filter('osf_customize_button_primary_color', 'strollik_customizer_button_primary_color', 10 , 11);
function strollik_customizer_button_primary_color($cssCode, $primary, $primary_hover, $primary_border, $primary_border_hover, $primary_color, $primary_color_hover, $border_radius, $primary_color_outline, $button_css, $font_style_code){
    $cssCode .= <<<CSS

.button-primary, input[type="button"], input[type="submit"], input[type="reset"], input.secondary[type="button"], input.secondary[type="reset"], input.secondary[type="submit"], button[type="submit"], .page .edit-link a.post-edit-link, .wc-proceed-to-checkout .button, .woocommerce-cart .return-to-shop a, .wishlist_table .product-add-to-cart a.button, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button, .widget_shopping_cart .buttons .button {
    background-color: {$primary};
    border-color: {$primary};
    color: {$primary_color};
    border-radius: {$border_radius}px;
    {$button_css}
    {$font_style_code}
}



.button-primary:hover, input:hover[type="button"], input:hover[type="submit"], input:hover[type="reset"], button:hover[type="submit"], .page .edit-link a.post-edit-link:hover, .wc-proceed-to-checkout .button:hover, .woocommerce-cart .return-to-shop a:hover, .wishlist_table .product-add-to-cart a.button:hover, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button:hover, .widget_shopping_cart .buttons .button:hover, .button-primary:active, input:active[type="button"], input:active[type="submit"], input:active[type="reset"], button:active[type="submit"], .page .edit-link a.post-edit-link:active, .wc-proceed-to-checkout .button:active, .woocommerce-cart .return-to-shop a:active, .wishlist_table .product-add-to-cart a.button:active, .woocommerce-MyAccount-content .woocommerce-Pagination .woocommerce-button:active, .widget_shopping_cart .buttons .button:active, .button-primary.active, input.active[type="button"], input.active[type="submit"], input.active[type="reset"], button.active[type="submit"], .page .edit-link a.active.post-edit-link, .wc-proceed-to-checkout .active.button, .woocommerce-cart .return-to-shop a.active, .wishlist_table .product-add-to-cart a.active.button, .woocommerce-MyAccount-content .woocommerce-Pagination .active.woocommerce-button, .widget_shopping_cart .buttons .active.button,
.show > .button-primary.dropdown-toggle, .show > input.dropdown-toggle[type="button"], .show > input.dropdown-toggle[type="submit"], .show > input.dropdown-toggle[type="reset"], .show > button.dropdown-toggle[type="submit"], .page .edit-link .show > a.dropdown-toggle.post-edit-link, .wc-proceed-to-checkout .show > .dropdown-toggle.button, .woocommerce-cart .return-to-shop .show > a.dropdown-toggle, .wishlist_table .product-add-to-cart .show > a.dropdown-toggle.button, .woocommerce-MyAccount-content .woocommerce-Pagination .show > .dropdown-toggle.woocommerce-button, .widget_shopping_cart .buttons .show > .dropdown-toggle.button {
    background-color: {$primary_hover};
    border-color: {$primary_hover};
    color: {$primary_color_hover};
    {$button_css}
    {$font_style_code}
}




.button-outline-primary {
    color: {$primary_color_outline};
    border-color: {$primary_border};
    border-radius: {$border_radius}px;
    {$button_css}
    {$font_style_code}
}



.button-outline-primary:hover, .button-outline-primary:active, .button-outline-primary.active,
.show > .button-outline-primary.dropdown-toggle {
    color: {$primary_color_hover};
    background-color: {$primary_hover};
    border-color: {$primary_border_hover};
    {$button_css}
    {$font_style_code}
}


CSS;
    return $cssCode;
}

add_filter('osf_customize_button_secondary_color', 'strollik_customizer_button_secondary_color', 10 , 11);
function strollik_customizer_button_secondary_color($cssCode, $secondary, $secondary_hover, $secondary_border, $secondary_border_hover, $secondary_color, $secondary_color_hover, $border_radius, $secondary_color_outline, $button_css, $font_style_code){
    $cssCode .= <<<CSS


.button-secondary, .secondary-button .search-submit {
    background-color: {$secondary};
    border-color: {$secondary};
    color: {$secondary_color};
    border-radius: {$border_radius}px;
    {$button_css}
    {$font_style_code}
}



.button-secondary:hover, .secondary-button .search-submit:hover, .button-secondary:active, .secondary-button .search-submit:active, .button-secondary.active, .secondary-button .active.search-submit,
.show > .button-secondary.dropdown-toggle, .secondary-button .show > .dropdown-toggle.search-submit {
    background-color: {$secondary_hover};
    border-color: {$secondary_hover};
    color: {$secondary_color};
    {$button_css}
    {$font_style_code}
}




.button-outline-secondary {
    color: {$secondary_color_outline};
    border-color: {$secondary_border};
    border-radius: {$border_radius}px;
    {$button_css}
    {$font_style_code}
}



.button-outline-secondary:hover, .button-outline-secondary:active, .button-outline-secondary.active,
.show > .button-outline-secondary.dropdown-toggle {
    color: {$secondary_color_hover};
    background-color: {$secondary_hover};
    border-color: {$secondary_border_hover};
    border-radius: {$border_radius}px;
    {$button_css}
    {$font_style_code}
}


CSS;
    return $cssCode;
}
add_filter('osf_customize_typo_heading', 'strollik_customizer_custom_typo_heading', 10 , 2);
function strollik_customizer_custom_typo_heading($cssCode, $heading_css){
    $cssCode .= <<<CSS

.typo-heading, .author-wrapper .author-name, .post-navigation .nav-subtitle, .post-navigation .nav-title, h2.widget-title, h2.widgettitle, #secondary .elementor-widget-container h5:first-of-type, .osf-product-deal .woocommerce-product-list .opal-countdown {
    {$heading_css}
}


CSS;
    return $cssCode;
}
