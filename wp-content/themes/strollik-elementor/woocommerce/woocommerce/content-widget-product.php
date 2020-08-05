<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $product WC_Product
 */
global $product; ?>

<li>
    <div class="inner">
        <?php do_action('woocommerce_widget_product_item_start', $args); ?>
        <a class="product-thumbnail" href="<?php echo esc_url($product->get_permalink()); ?>">
            <?php echo apply_filters('the_content', $product->get_image()); ?>
        </a>
        <div class="product-content">
            <h3 class="product-title">
                <a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_name()); ?></a>
            </h3>
            <?php if (!empty($show_rating)) : ?>
                <?php echo wc_get_rating_html($product->get_average_rating()); ?>
            <?php endif; ?>
            <?php do_action('otf_product_list_before_price') ?>
            <?php echo '<div class="product-price">' . $product->get_price_html() . '</div>'; ?>
            <?php do_action('otf_product_list_after_price') ?>
        </div>
        <?php do_action('woocommerce_widget_product_item_end', $args); ?>
    </div>
</li>