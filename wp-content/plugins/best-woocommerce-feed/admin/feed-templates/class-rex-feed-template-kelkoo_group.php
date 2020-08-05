<?php

/**
 * The Kelkoo Group Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Kelkoo Group feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Kelkoo_group
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Kelkoo_group extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'             => 'Product Title',
                'product-url'       => 'Product URL',
                'price'             => 'Price',
                'brand'             => 'Brand',
                'description'       => 'Description',
                'image-url'         => 'Image Url',
                'ean'               => 'EAN',
                'availability'      => 'Availability',
                'condition'         => 'Condition',
                'ecotax'            => 'Ecotax',
                'warranty'          => 'Warranty',
                'kelkoo-category-id'=> 'Kelkoo Category ID',
                'mpn'               => 'MPN',
                'sku'               => 'SKU',
                'currency'          => 'Currency',

            ),

            'Additional Information' => array(
                'merchant-category'   => 'Merchant Category',
                'delivery-cost'       => 'Delivery Cost',
                'delivery-time'       => 'Delivery Time',
                'mobile-url'          => 'Mobile URL',
                'color'               => 'Color',
                'unit-price'          => 'Unit Price',
                'offer-type'          => 'Offer Type',
                'merchant-info'       => 'Merchant Info',
                'image-url-2'         => 'Image URL-2',
                'image-url-3'         => 'Image URL-3',
                'image-url-4'         => 'Image URL-4',
                'green-product'       => 'Green Product',
                'green-label'         => 'Green Label',
                'sales-rank'          => 'Sales Rank',
                'unit-quantity'       => 'Unit Quantity',
                'made-in'             => 'Made In',
                'occasion'            => 'Occasion',
                'keywords'            => 'Keywords',
                'shipping-method'     => 'Shipping Method',
                'delivery-cost-2'     => 'Delivery Cost-2',
                'delivery-cost-3'     => 'Delivery Cost-3',
                'delivery-cost-4'     => 'Delivery Cost-4',
                'shipping-method-2'   => 'Shipping Method-2',
                'shipping-method-3'   => 'Shipping Method-3',
                'shipping-method-4'   => 'Shipping Method-4',
                'zip-code'            => 'Zip Code',
                'stock-quantity'      => 'Stock Quantity',
                'shipping-weight'     => 'Shipping Weight',
                'payment-methods'     => 'Payment Methods',
                'voucher-title'       => 'Voucher Title',
                'voucher-description' => 'Voucher Description',
                'voucher-url'         => 'Voucher URL',
                'voucher-code'        => 'Voucher Code',
                'voucher-start-date'  => 'Voucher Start Date',
                'voucher-end-date'    => 'Voucher End Date',
                'price-no-rebate'     => 'Price No Rebate',
                'percentage-promo'    => 'Percentage Promo',
                'promo-start-date'    => 'Promo Start Date',
                'vpromo-end-date'     => 'Promo End Date',
                'user-rating'         => 'User Rating',
                'nb-reviews'          => 'NB Reviews',
                'user-review-link'    => 'User Review Link',
                'video-link'          => 'Video Link',
                'video-title'         => 'Video Title',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'title',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product-url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'brand',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'image-url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ean',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'condition',
                'type'     => 'meta',
                'meta_key' => 'condition',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ecotax',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'warranty',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'kelkoo-category-id',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'mpn',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'currency',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
