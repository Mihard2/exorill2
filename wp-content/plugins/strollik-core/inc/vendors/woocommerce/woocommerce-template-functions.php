<?php
if (!function_exists('osf_woocommerce_version_check')) {
    function osf_woocommerce_version_check($version = '3.3')
    {
        if (osf_is_woocommerce_activated()) {
            global $woocommerce;
            if (version_compare($woocommerce->version, $version, ">=")) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('osf_before_content')) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @since   1.0.0
     * @return  void
     */
    function osf_before_content()
    {
        ?>
        <div class="wrap">
        <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
        <?php
        if (is_product_category()) {
            $cate = get_queried_object();
            $cateID = $cate->term_id;
            $banner_id = get_term_meta($cateID, 'product_cat_banner_id', true);

            if ($banner_id) {
                echo '<div class="product-category-banner">';
                echo wp_get_attachment_image($banner_id, 'full');
                echo '</div>';
            }
        }
    }
}

if (!function_exists('osf_after_content')) {
    /**
     * After Content
     * Closes the wrapping divs
     *
     * @since   1.0.0
     * @return  void
     */
    function osf_after_content()
    {
        ?>
        </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
        </div>
        <?php
    }
}

if (!function_exists('osf_cart_link_fragment')) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     *
     * @return array            Fragments to refresh via AJAX
     */
    function osf_cart_link_fragment($fragments)
    {
        global $woocommerce;

        ob_start();
        $fragments['a.cart-contents .amount'] = osf_cart_amount();
        $fragments['a.cart-contents .count'] = osf_cart_count();
        $fragments['a.cart-contents .count-text'] = osf_cart_count_text();

        ob_start();
        osf_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean();

        return $fragments;
    }
}

if (!function_exists('osf_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return string
     * @since  1.0.0
     */
    function osf_cart_link()
    {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            $items = '';
            $items .= '<a data-toggle="toggle" class="cart-contents header-button" href="' . esc_url(wc_get_cart_url()) . '" title="' . __("View your shopping cart", "strollik-core") . '">';
            $items .= '<i class="fa fa-cart-arrow-down" aria-hidden="true"></i>';
            $items .= '<span class="title">' . esc_html__('cart', 'strollik-core') . '</span>';
            $items .= '<span class="amount">' . wp_kses_data(WC()->cart->get_cart_subtotal()) . '</span>';
            $items .= '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span>';
            $items .= '<span class="count-text">' . wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "strollik-core")) . '</span>';
            $items .= '</a>';

            return $items;
        }

        return '';
    }
}

if (!function_exists('osf_cart_amount')) {
    /**
     *
     * @return string
     *
     */
    function osf_cart_amount()
    {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="amount">' . wp_kses_data(WC()->cart->get_cart_subtotal()) . '</span>';
        }

        return '';
    }
}

if (!function_exists('osf_cart_count')) {
    /**
     *
     * @return string
     *
     */
    function osf_cart_count()
    {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count">' . wp_kses_data(WC()->cart->get_cart_contents_count()) . '</span>';
        }

        return '';
    }
}

if (!function_exists('osf_cart_count_text')) {
    /**
     *
     * @return string
     *
     */
    function osf_cart_count_text()
    {
        if (!empty(WC()->cart) && WC()->cart instanceof WC_Cart) {
            return '<span class="count-text">' . wp_kses_data(_n("item", "items", WC()->cart->get_cart_contents_count(), "strollik-core")) . '</span>';
        }

        return '';
    }
}

if (!function_exists('osf_upsell_display')) {
    /**
     * Upsells
     * Replace the default upsell function with our own which displays the correct number product columns
     *
     * @since   1.0.0
     * @return  void
     * @uses    woocommerce_upsell_display()
     */
    function osf_upsell_display()
    {
        global $product;
        $number = count($product->get_upsell_ids());
        if ($number <= 0) {
            return;
        }
        $columns = absint(get_theme_mod('osf_woocommerce_single_upsell_columns', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        woocommerce_upsell_display();
        echo '</div>';
    }
}

if (!function_exists('osf_output_related_products')) {
    /**
     * Related
     *
     * @since   1.0.0
     * @return  void
     * @uses    woocommerce_related_products()
     */
    function osf_output_related_products()
    {
        $columns = absint(get_theme_mod('osf_woocommerce_single_related_columns', 3));
        $number = absint(get_theme_mod('osf_woocommerce_single_related_number', 3));
        if ($columns < $number) {
            echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
        } else {
            echo '<div class="columns-' . esc_attr($columns) . '">';
        }
        woocommerce_related_products($args = array(
            'posts_per_page' => $number,
            'columns' => $columns,
            'orderby' => 'rand',
        ));
        echo '</div>';
    }
}

if (!function_exists('osf_sorting_wrapper')) {
    /**
     * Sorting wrapper
     *
     * @since   1.4.3
     * @return  void
     */
    function osf_sorting_wrapper()
    {
        echo '<div class="osf-sorting">';
    }
}

if (!function_exists('osf_sorting_wrapper_close')) {
    /**
     * Sorting wrapper close
     *
     * @since   1.4.3
     * @return  void
     */
    function osf_sorting_wrapper_close()
    {
        echo '</div>';
    }
}

if (!function_exists('osf_sorting_group')) {
    /**
     * Sorting wrapper
     *
     * @since   1.4.3
     * @return  void
     */
    function osf_sorting_group()
    {
        echo '<div class="osf-sorting-group col-lg-6 col-sm-12">';
    }
}

if (!function_exists('osf_sorting_group_close')) {
    /**
     * Sorting wrapper close
     *
     * @since   1.4.3
     * @return  void
     */
    function osf_sorting_group_close()
    {
        echo '</div>';
    }
}


if (!function_exists('osf_product_columns_wrapper')) {
    /**
     * Product columns wrapper
     *
     * @since   2.2.0
     * @return  void
     */
    function osf_product_columns_wrapper()
    {
        $columns = osf_loop_columns();
        if (isset($_GET['display']) && $_GET['display'] === 'list') {
            $columns = 1;
        }
        echo '<div class="columns-' . intval($columns) . '">';
    }
}

if (!function_exists('osf_loop_columns')) {
    /**
     * Default loop columns on product archives
     *
     * @return integer products per row
     * @since  1.0.0
     */
    function osf_loop_columns()
    {
        $columns = get_theme_mod('osf_woocommerce_archive_columns', 3);

        return intval(apply_filters('osf_products_columns', $columns));
    }
}

if (!function_exists('osf_product_columns_wrapper_close')) {
    /**
     * Product columns wrapper close
     *
     * @since   2.2.0
     * @return  void
     */
    function osf_product_columns_wrapper_close()
    {
        echo '</div>';
    }
}

if (!function_exists('osf_shop_messages')) {
    /**
     * homefinder shop messages
     *
     * @since   1.4.4
     * @uses    osf_do_shortcode
     */
    function osf_shop_messages()
    {
        if (!is_checkout()) {
            echo wp_kses_post(osf_do_shortcode('woocommerce_messages'));
        }
    }
}

if (!function_exists('osf_woocommerce_pagination')) {
    /**
     * homefinder WooCommerce Pagination
     * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
     * but since homefinder adds pagination before that function is excuted we need a separate function to
     * determine whether or not to display the pagination.
     *
     * @since 1.4.4
     */
    function osf_woocommerce_pagination()
    {
        if (woocommerce_products_will_display()) {
            woocommerce_pagination();
        }
    }
}


if (!function_exists('osf_handheld_footer_bar_search')) {
    /**
     * The search callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function osf_handheld_footer_bar_search()
    {
        echo '<a href="">' . esc_attr__('Search', 'strollik-core') . '</a>';
        osf_product_search();
    }
}

if (!function_exists('osf_handheld_footer_bar_cart_link')) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function osf_handheld_footer_bar_cart_link()
    {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'strollik-core'); ?>">
            <span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count()); ?></span>
        </a>
        <?php
    }
}

if (!function_exists('osf_handheld_footer_bar_account_link')) {
    /**
     * The account callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function osf_handheld_footer_bar_account_link()
    {
        echo '<a href="' . esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))) . '">' . esc_attr__('My Account', 'strollik-core') . '</a>';
    }
}


if (!function_exists('osf_checkout_before_customer_details_container')) {
    function osf_checkout_before_customer_details_container()
    {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '<div class="row"><div class="col-lg-7 col-md-12 col-sm-12"><div class="inner">';
        }
    }
}

if (!function_exists('osf_checkout_after_customer_details_container')) {
    function osf_checkout_after_customer_details_container()
    {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div><div class="col-lg-5 col-md-12 col-sm-12"><div class="inner order_review_inner"> ';
        }
    }
}

if (!function_exists('osf_checkout_after_order_review_container')) {
    function osf_checkout_after_order_review_container()
    {
        if (WC()->checkout()->get_checkout_fields()) {
            echo '</div></div></div>';
        }
    }
}

if (!function_exists('osf_woocommerce_single_product_add_to_cart_before')) {
    function osf_woocommerce_single_product_add_to_cart_before()
    {
        echo '<div class="woocommerce-cart"><div class="inner">';
    }
}

if (!function_exists('osf_woocommerce_single_product_add_to_cart_after')) {
    function osf_woocommerce_single_product_add_to_cart_after()
    {
        echo '</div></div>';
    }
}

if (!function_exists('osf_woocommerce_single_product_summary_inner_start')) {
    function osf_woocommerce_single_product_summary_inner_start()
    {
        echo '<div class="inner">';
    }
}

if (!function_exists('osf_woocommerce_single_product_summary_inner_end')) {
    function osf_woocommerce_single_product_summary_inner_end()
    {
        echo '</div>';
    }
}


if (!function_exists('osf_template_loop_product_thumbnail')) {
    function osf_template_loop_product_thumbnail($size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0)
    {
        echo osf_get_loop_product_thumbnail();

    }
}
if (!function_exists('osf_woocommerce_order_review_heading')) {
    function osf_woocommerce_order_review_heading()
    {
        echo ' <h3 class="h2 order_review_heading">'. esc_attr__('Your order', 'strollik-core') .'</h3>';
    }
}


if (!function_exists('osf_get_loop_product_thumbnail')) {
    function osf_get_loop_product_thumbnail($size = 'woocommerce_thumbnail', $deprecated1 = 0, $deprecated2 = 0)
    {
        global $product;
        if (!$product) {
            return '';
        }
        $gallery = $product->get_gallery_image_ids();
        $hover_skin = get_theme_mod('osf_woocommerce_product_hover', 'none');
        if ($hover_skin == '0' || count($gallery) <= 0) {
            echo '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';

            return '';
        }
        $image_featured = '<div class="product-image">' . $product->get_image('shop_catalog') . '</div>';
        $image_featured .= '<div class="product-image second-image">' . wp_get_attachment_image($gallery[0], 'shop_catalog') . '</div>';

        echo <<<HTML
<div class="product-img-wrap {$hover_skin}">
    <div class="inner">
        {$image_featured}
    </div>
</div>
HTML;
    }
}

if (!function_exists('osf_woocommerce_product_loop_image_start')) {
    function osf_woocommerce_product_loop_image_start()
    {
        echo '<div class="product-transition">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_image_end')) {
    function osf_woocommerce_product_loop_image_end()
    {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_loop_action_start')) {
    function osf_woocommerce_product_loop_action_start()
    {
        echo '<div class="product-caption"><div class="shop-action">';
    }
}


if (!function_exists('osf_woocommerce_product_loop_action_end')) {
    function osf_woocommerce_product_loop_action_end()
    {
        echo '</div></div>';
    }
}

if (!function_exists('osf_woocommerce_product_loop_wishlist_button')) {
    function osf_woocommerce_product_loop_wishlist_button()
    {
        if (osf_is_woocommerce_extension_activated('YITH_WCWL')) {
            echo osf_do_shortcode('yith_wcwl_add_to_wishlist');
        }
    }
}

if (!function_exists('osf_woocommerce_product_loop_compare_button')) {
    function osf_woocommerce_product_loop_compare_button()
    {
        if (osf_is_woocommerce_extension_activated('YITH_Woocompare')) {
            echo osf_do_shortcode('yith_compare_button');
        }
    }
}

if (!function_exists('osf_woocommerce_change_path_shortcode')) {
    function osf_woocommerce_change_path_shortcode($template, $slug, $name)
    {
        wc_get_template('content-widget-product.php', array('show_rating' => false));
    }
}

if (!function_exists('osf_woocommerce_product_loop_start')) {
    function osf_woocommerce_product_loop_start()
    {
        echo '<div class="product-block">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_end')) {
    function osf_woocommerce_product_loop_end()
    {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_loop_caption_start')) {
    function osf_woocommerce_product_loop_caption_start()
    {
        echo '<div class="caption">';
    }
}

if (!function_exists('osf_woocommerce_product_loop_caption_end')) {
    function osf_woocommerce_product_loop_caption_end()
    {
        echo '</div>';
    }
}

if (!function_exists('osf_woocommerce_product_rating')) {
    function osf_woocommerce_product_rating()
    {
        global $product;
        if (get_option('woocommerce_enable_review_rating') === 'no') {
            return;
        }
        if ($rating_html = wc_get_rating_html($product->get_average_rating())) {
            echo apply_filters('osf_woocommerce_rating_html', $rating_html);
        } else {
            echo '<div class="star-rating"></div>';
        }
    }
}

if (!function_exists('oft_woocommerce_template_loop_product_excerpt')) {

    /**
     * Show the excerpt in the product loop.
     */
    function osf_woocommerce_template_loop_product_excerpt()
    {
        global $product;
        echo '<div class="excerpt">' . get_the_excerpt() . '</div>';
    }
}
if (!function_exists('woocommerce_template_loop_product_title')) {

    /**
     * Show the product title in the product loop.
     */
    function woocommerce_template_loop_product_title()
    {
        echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url_raw(get_the_permalink()) . '">' . get_the_title() . '</a></h3>';
    }
}


if (!function_exists('osf_woocommerce_get_product_category')) {
    function osf_woocommerce_get_product_category()
    {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<span class="posted_in">', '</span>');
    }
}
if (!function_exists('osf_woocommerce_get_product_label_stock')) {
    function osf_woocommerce_get_product_label_stock()
    {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->get_stock_status() == 'outofstock') {
            echo '<span class="out-of-stock">' . esc_html__('Out Of Stock', 'strollik-core') . '</span>';
        }
    }
}

if (!function_exists('osf_woocommerce_get_product_label_sale')) {
    function osf_woocommerce_get_product_label_sale()
    {
        /**
         * @var $product WC_Product
         */
        global $product;
        if ($product->is_on_sale() && $product->is_type('simple')) {
            $sale = $product->get_sale_price();
            $price = $product->get_regular_price();
            $ratio = round(($price - $sale) / $price * 100);
            echo '<span class="onsale"> - ' . esc_html($ratio) . ' % </span>';
        }
    }
}

if (!function_exists('osf_woocommerce_set_register_text')) {
    function osf_woocommerce_set_register_text()
    {
        echo '<div class="user-text">' . __("Creating an account is quick and easy, and will allow you to move through our checkout quicker.", "strollik-core") . '</div>';
    }
}


if (!function_exists('osf_header_cart_nav')) {
    /**
     * Display Header Cart
     *
     * @since  1.0.0
     * @uses   osf_is_woocommerce_activated() check if WooCommerce is activated
     * @return string
     */

    function osf_header_cart_nav()
    {
        if (osf_is_woocommerce_activated()) {
            $items = '';
            $items .= '<li class="megamenu-item menu-item  menu-item-has-children menu-item-cart site-header-cart " data-level="0">';
            $items .= osf_cart_link();
            if (!is_cart() && !is_checkout()) {
                $items .= '<ul class="shopping_cart_nav shopping_cart"><li><div class="widget_shopping_cart_content"></div></li></ul>';
            }
            $items .= '</li>';

            return $items;
        }

        return '';
    }
}

if (!function_exists('osf_woocommerce_add_woo_cart_to_nav')) {
    function osf_woocommerce_add_woo_cart_to_nav($items, $args)
    {

        if ('top' == $args->theme_location) {
            global $osf_header;
            if ($osf_header && $osf_header instanceof WP_Post) {
                if (osf_get_metabox($osf_header->ID, 'osf_enable_cart', false)) {
                    $items .= osf_header_cart_nav();
                }

                return $items;
            }

            if (get_theme_mod('osf_header_layout_enable_cart_in_menu', true)) {
                $items .= osf_header_cart_nav();
            }
        }

        return $items;
    }
}

if (!function_exists('osf_woocommerce_list_get_excerpt')) {
    function osf_woocommerce_list_show_excerpt()
    {
        echo '<div class="product-excerpt">' . get_the_excerpt() . '</div>';
    }
}

if (!function_exists('osf_woocommerce_list_get_category')) {
    function osf_woocommerce_list_show_category()
    {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<div class="posted_in">', '</div>');
    }
}

if (!function_exists('osf_woocommerce_list_get_rating')) {
    function osf_woocommerce_list_show_rating()
    {
        global $product;
        echo wc_get_rating_html($product->get_average_rating());
    }
}

if (!function_exists('osf_woocommerce_set_lable_price')) {
    function osf_woocommerce_set_lable_price()
    {
        echo '<span class="lable-price" style="display: none;" >'.esc_html__('Price:','strollik-core').'</span>';
    }
}

if (!function_exists('osf_woocommerce_time_sale')) {
    function osf_woocommerce_time_sale()
    {
        /**
         * @var $product WC_Product
         */
        global $product;
        $time_sale = get_post_meta($product->get_id(), '_sale_price_dates_to', true);
        if ($time_sale) {
            wp_enqueue_script('otf-countdown');
            $time_sale += (get_option('gmt_offset') * 3600);
            echo '<div class="time">
                    <div class="opal-countdown clearfix"
                        data-countdown="countdown"
                        data-days="' . esc_html__("days", "strollik-core") . '" 
                        data-hours="' . esc_html__("hours", "strollik-core") . '"
                        data-minutes="' . esc_html__("mins", "strollik-core") . '"
                        data-seconds="' . esc_html__("secs", "strollik-core") . '"
                        data-Message="' . esc_html__('Expired', 'strollik-core') . '"
                        data-date="' . date('m', $time_sale) . '-' . date('d', $time_sale) . '-' . date('Y', $time_sale) . '-' . date('H', $time_sale) . '-' . date('i', $time_sale) . '-' . date('s', $time_sale) . '">
                    </div>
            </div>';
        }
    }
}
if (!function_exists('osf_output_product_data_accordion')) {
    function osf_output_product_data_accordion()
    {
        $tabs = apply_filters('woocommerce_product_tabs', array());
        if (!empty($tabs)) : ?>
            <div id="osf-accordion-container" class="woocommerce-tabs wc-tabs-wrapper">
                <?php $_count = 0; ?>
                <?php foreach ($tabs as $key => $tab) : ?>
                    <div data-accordion<?php echo $_count == 0 ? ' class="accordion open"' : ''; ?>>
                        <div data-control class="<?php echo esc_attr($key); ?>_tab"
                             id="tab-title-<?php echo esc_attr($key); ?>">
                            <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
                        </div>
                        <div data-content>
                            <?php call_user_func($tab['callback'], $key, $tab); ?>
                        </div>
                    </div>
                    <?php $_count++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }
}


if (!function_exists('osf_woocommerce_cross_sell_display')) {
    function osf_woocommerce_cross_sell_display()
    {
        woocommerce_cross_sell_display(get_theme_mod('osf_woocommerce_cart_cross_sells_limit', 4), get_theme_mod('osf_woocommerce_cart_cross_sells_columns', 2));
    }
}

function osf_woocommerce_render_variable()
{
    /**
     * @var $product WC_Product_Variable
     */
    if (!function_exists('TA_WCVS')) {
        return;
    }
    global $product;
    if ($product->is_type('variable')) {
        $attr_name = 'pa_color';
        $variables = $product->get_variation_attributes()[$attr_name];
        $attr = TA_WCVS()->get_tax_attribute($attr_name);
        $options = $product->get_available_variations();
        $html = '<div class="osf-wrap-swatches"><div class="inner">';
        $terms = wc_get_product_terms($product->get_id(), $attr_name, array('fields' => 'all'));
        foreach ($terms as $term) {
            if (in_array($term->slug, $variables)) {
                $html .= osf_woocommerce_get_swatch_html($term, $attr, $options, $attr_name);
            }
        }
        $html .= '</div></div>';
        echo $html;
    }
}

function osf_woocommerce_get_swatch_html($term, $attr, $options, $attr_name)
{
    $html = '';
    $selected = '';
    $attr_name = 'attribute_' . $attr_name;
    $name = esc_html(apply_filters('woocommerce_variation_option_name', $term->name));
    $image = array();
    foreach ($options as $option) {
        foreach ($option['attributes'] as $_k => $_v) {
            if ($_k === $attr_name && $_v === $term->slug) {
                $image = $option['image'];
                break;
            }
            if (count($image) > 0) {
                break;
            }
        }
    }
    switch ($attr->attribute_type) {
        case 'color':
            $color = get_term_meta($term->term_id, 'color', true);
            list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
            $html = sprintf(
                '<span class="swatch swatch-color osf-tooltip swatch-%s %s" data-image="%s" style="background-color:%s;color:%s;" title="%s" data-value="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($color),
                "rgba($r,$g,$b,0.5)",
                esc_attr($name),
                esc_attr($term->slug),
                $name
            );
            break;

        case 'image':
            $image = get_term_meta($term->term_id, 'image', true);
            $image = $image ? wp_get_attachment_image_src($image) : '';
            $image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
            $html = sprintf(
                '<span class="swatch swatch-image swatch-%s osf-tooltip %s" data-image="%s" title="%s" data-value="%s"><img src="%s" alt="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($name),
                esc_attr($term->slug),
                esc_url($image),
                esc_attr($name),
                esc_attr($name)
            );
            break;

        case 'label':
            $label = get_term_meta($term->term_id, 'label', true);
            $label = $label ? $label : $name;
            $html = sprintf(
                '<span class="swatch swatch-label swatch-%s %s" data-image="%s" title="%s" data-value="%s">%s</span>',
                esc_attr($term->slug),
                $selected,
                htmlspecialchars(wp_json_encode($image)),
                esc_attr($name),
                esc_attr($term->slug),
                esc_html($label)
            );
            break;
    }

    return $html;
}


function osf_woocommerce_single_product_image_thumbnail_html($image, $attachment_id)
{
    return wc_get_gallery_image_html($attachment_id, true);
}

if (!function_exists('osf_active_filters')) {
    function osf_active_filters()
    {
        $link_remove_all = $_SERVER['REQUEST_URI'];
        $link_remove_all = strtok($link_remove_all, '?');
        echo '<div class="osf-active-filters">';
        the_widget('WC_Widget_Layered_Nav_Filters');
        echo '<span class="osf_active_filters_label">' . esc_html__('Active Filters: ', 'strollik-core') . '</span>
    <a class="clear-all" href="' . esc_url($link_remove_all) . '">' . __('Clear Filters', 'strollik-core') . '</a>
</div>';
    }
}


function osf_single_product_video()
{
    global $product;
    $video = get_post_meta($product->get_id(), 'otf_products_video', true);
    if (!$video) {
        return;
    }
    $video_thumbnail = get_post_meta($product->get_id(), 'otf_products_video_thumbnail_id', true);
    if ($video_thumbnail) {
        $video_thumbnail = wp_get_attachment_image_url($video_thumbnail, 'thumbnail');
    } else {
        $video_thumbnail = wc_placeholder_img_src();
    }
    $video = wc_do_oembeds($video);
    echo '<div data-thumb="' . esc_url_raw($video_thumbnail) . '" class="woocommerce-product-gallery__image">
    <a>
        ' . $video . '

    </a>
</div>';
}

function osf_single_product_social()
{
    if (get_theme_mod('osf_socials')) {
        $template = WP_PLUGIN_DIR . '/strollik-core/templates/socials.php';
        if (file_exists($template)) {
            require $template;
        }
    }
}

/**
 * Check if a product is a deal
 *
 * @param int|object $product
 *
 * @return bool
 */
function osf_woocommerce_is_deal_product($product)
{
    $product = is_numeric($product) ? wc_get_product($product) : $product;

    // It must be a sale product first
    if (!$product->is_on_sale()) {
        return false;
    }

    if (!$product->is_in_stock()) {
        return false;
    }

    // Only support product type "simple" and "external"
    if (!$product->is_type('simple') && !$product->is_type('external')) {
        return false;
    }

    $deal_quantity = get_post_meta($product->get_id(), '_deal_quantity', true);

    if ($deal_quantity > 0) {
        return true;
    }

    return false;
}


/**
 * Display deal progress on shortcode
 */
if (!function_exists('osf_woocommerce_deal_progress')) {
    function osf_woocommerce_deal_progress()
    {
        global $product;

        $limit = get_post_meta($product->get_id(), '_deal_quantity', true);
        $sold = intval(get_post_meta($product->get_id(), '_deal_sales_counts', true));
        if (empty($limit)) {
            return;
        }

        ?>

        <div class="deal-sold">
            <span class="deal-text d-block"><span><?php esc_html_e('HURRY! ONLY', 'strollik-core') ?></span> <span
                        class="c-primary"><?php echo esc_attr(trim($limit - $sold)) ?></span> <span><?php esc_html_e('LEFT IN STOCK.', 'strollik-core') ?></span></span>
            <div>
                <div class="deal-progress">
                    <div class="progress-bar">
                        <div class="progress-value" style="width: <?php echo trim($sold / $limit * 100) ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
}

if (!function_exists('osf_woocommerce_single_deal')) {
    function osf_woocommerce_single_deal()
    {
        global $product;


        if (!osf_woocommerce_is_deal_product($product)) {
            return;
        }
        ?>

        <div class="opal-woocommerce-deal deal">
            <?php
            osf_woocommerce_deal_progress();
            osf_woocommerce_time_sale();
            ?>
        </div>
        <?php
    }
}


//Recently Viewed Product
function otf_woocommerce_recently_viewed_product()
{
    if (get_theme_mod('otf_woocommerce_extra_enable_product_recently_viewed', false)) {
        $columns = get_theme_mod('otf_woocommerce_extra_product_recently_viewed_columns', 5);
        if (!empty($_COOKIE['otf_woocommerce_recently_viewed'])) {
            echo '<div class="otf-product-recently-review">';
            echo '<h2 class="otf-woocommerce-recently-viewed">' . esc_html__('Your Recently Viewed', 'strollik-core') . '</h2>';
            echo '<div class="otf-product-recently-content" id="otf-woocommerce-recently-viewed">';
            echo '<div class="woocommerce-product" data-columns="' . esc_attr($columns) . '">';
            otf_woocommerce_widget_recently_viewed();
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

    }
}

function otf_wc_track_product_view()
{

    if (!is_singular('product')) {
        return;
    }

    global $post;

    if (!isset($_COOKIE['otf_woocommerce_recently_viewed']) || isset($_COOKIE['otf_woocommerce_recently_viewed']) && empty($_COOKIE['otf_woocommerce_recently_viewed'])) {
        $viewed_products = array();
    } else {
        $viewed_products = (array)explode('|', $_COOKIE['otf_woocommerce_recently_viewed']);
    }

    // Unset if already in viewed products list.
    $keys = array_flip($viewed_products);
    if (isset($keys[$post->ID])) {
        unset($viewed_products[$keys[$post->ID]]);
    }

    $viewed_products[] = $post->ID;

    if (count($viewed_products) > 15) {
        array_shift($viewed_products);
    }

    // Store for session only.
    wc_setcookie('otf_woocommerce_recently_viewed', implode('|', $viewed_products));
}

add_action('template_redirect', 'otf_wc_track_product_view', 20);

function otf_woocommerce_widget_recently_viewed()
{
    $viewed_products = !empty($_COOKIE['otf_woocommerce_recently_viewed']) ? (array)explode('|', wp_unslash($_COOKIE['otf_woocommerce_recently_viewed'])) : array(); // @codingStandardsIgnoreLine
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if (empty($viewed_products)) {
        return;
    }

    $columns = get_theme_mod('otf_woocommerce_extra_product_recently_viewed_columns', 5);

    ob_start();


    $query_args = array(
        'posts_per_page' => $columns,
        'no_found_rows' => 1,
        'post_status' => 'publish',
        'post_type' => 'product',
        'post__in' => $viewed_products,
        'orderby' => 'post__in',
    );

    if ('yes' === get_option('woocommerce_hide_out_of_stock_items')) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'outofstock',
                'operator' => 'NOT IN',
            ),
        ); // WPCS: slow query ok.
    }

    $products = new WP_Query($query_args);

    if ($products->have_posts()) {
        echo '<div class="widget woocommerce widget_recently_viewed_products">';

        echo '<ul class="product_list_widget products columns-' . $columns . '">';

        while ($products->have_posts()) {
            $products->the_post();
            wc_get_template('content-widget-product.php');
        }

        echo '</ul>';

        echo '</div>';
    }

    wp_reset_postdata();

    $content = ob_get_clean();

    echo $content; // WPCS: XSS ok.
}


function osf_woocommerce_single_breadcrumb()
{
    if (function_exists('bcn_display')) {
        bcn_display();
    }
}