<?php

/**
 * The Jurkjes Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Jurkjes feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Jurkjes
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Jurkjes extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'g:id'                       => 'ID',
                'title'                      => 'Title',
                'description'                => 'Description',
                'g:image_link'               => 'Image Link',
                'g:price'                    => 'Price',
                'link'                       => 'Link',
                'g:google_product_category'  => 'Google Product Category',
                'g:availability'             => 'Availability',
                'g:brand'                    => 'Brand',
                'g:condition'                => 'Condition',
                'g:shipping.country'         => 'Shipping Country',
                'g:shipping.price'           => 'Shipping Price',
                'g:age_group'                => 'Age Group',
                'g:color'                    => 'Color',
                'g:gender'                   => 'Gender',
                'g:size'                     => 'Size',
            ),

            'Additional Information' => array(
                'g:sale_price_effective_date'  => 'Sale Price Effective Date',
                'g:unit_pricing_base_measure'  => 'Unit Pricing Base Measure',
                'g:identifier_exists'          => 'Identifier Exists',
                'g:multipack'                  => 'Multipack',
                'g:is_bundle'                  => 'Is Bundle',
                'g:shipping.service'           => 'Shipping Service',
                'g:shipping_weight'            => 'Shipping Weight',
                'g:custom_label_0'             => 'Custom Label 0',
                'g:custom_label_1'             => 'Custom Label 1',
                'g:custom_label_2'             => 'Custom Label 2',
                'g:custom_label_3'             => 'Custom Label 3',
                'g:custom_label_4'             => 'Custom Label 4',
                'g:adwords_grouping'           => 'Adwords Grouping',
                'g:promotion_id'               => 'Promotion ID',
                'g:adwords_redirect'           => 'Adwords Redirect',
                'g:adwords_labels'             => 'Adwords Labels',
                'g:subscription_period'        => 'Subscription Period',
                'g:subscription_period_length' => 'Subscription Period Length',
                'g:subscription_amount'        => 'Subscription Amount',
                'g:installment_months'         => 'Installment Months',
                'g:installment_amount'         => 'Installment Amount',
                'g:pattern'                    => 'Pattern',
            ),

            'Recommended Information' => array(
                'g:item_group_id'          => 'Item Group ID',
                'g:material'               => 'Material',
                'g:mpn'                    => 'MPN',
                'g:gtin'                   => 'GTIN',
                'g:product_type'           => 'Product Type',
                'g:unit_pricing_measure'   => 'Unit Pricing Measure',
                'g:sale_price'             => 'Sale Price',
                'g:additional_image_link'  => 'Additional Image Link',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'g:id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
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
                'attr'     => 'g:image_link',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
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
                'attr'     => 'g:google_product_category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:brand',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:condition',
                'type'     => 'meta',
                'meta_key' => 'condition',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:shipping.country',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:shipping.price',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:age_group',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:color',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:gender',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'g:size',
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
