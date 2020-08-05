<?php

/**
 * The Compartner Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for compartner feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Compartner
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Compartner extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'id'                      => 'ID',
                'title'                   => 'Product Title',
                'description'             => 'Description',
                'price'                   => 'Price',
                'image_link'              => 'Image Link',
                'link'                    => 'Link',
                'google_product_category' => 'Google Product Category',
                'availability'            => 'Availability',
                'brand'                   => 'Brand',
                'condition'               => 'Condition',
            ),

            'Recommended Information' => array(
                'additional_image_link'=> 'Additional Image Link',
                'gtin'                 => 'Gtin',
                'mpn'                  => 'MPN',
                'product_type'         => 'Product Type',
                'sale_price'           => 'Sale Price',
                'unit_pricing_measure' => 'Unit Pricing Measure',
            ),

            'Tax & Shipping' => array(
                'shipping_country' => 'Shipping Country',
                'shipping_price'   => 'Shipping Price',
            ),

            'Optional Information' => array(
                'adwords_grouping'          => 'Adwords Grouping',
                'adwords_labels'            => 'Adwords Labels',
                'adwords_redirect'          => 'Adwords Redirect',
                'custom_label_0'            => 'Custom Label 0',
                'custom_label_1'            => 'Custom Label 1',
                'custom_label_2'            => 'Custom Label 2',
                'custom_label_3'            => 'Custom Label 3',
                'custom_label_4'            => 'Custom Label 4',
                'identifier_exists'         => 'Identifier Exists',
                'installment_amount'        => 'Installment Amount',
                'installment_months'        => 'Installment Months',
                'is_bundle'                 => 'Is Bundle',
                'multipack'                 => 'Multipack',
                'promotion_id'              => 'Promotion ID',
                'sale_price_effective_date' => 'Sale Price Effective Date',
                'shipping_service'          => 'Shipping Service',
                'shipping_weight'           => 'Shipping Weight',
                'subscription_amount'       => 'Subscription Amount',
                'subscription_period'       => 'Subscription Period',
                'subscription_period_length'=> 'Subscription Period Length',
                'unit_pricing_base_measure' => 'Unit Pricing Base Measure',
            ),



        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),array(
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
                'attr'     => 'image_link',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'link',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'google_product_category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_price',
                'type'     => 'meta',
                'meta_key' => 'shipping_price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_country',
                'type'     => 'meta',
                'meta_key' => 'shipping_country',
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
                'attr'     => 'brand',
                'type'     => 'meta',
                'meta_key' => 'brand',
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

        );
    }

}
