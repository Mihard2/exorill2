<?php

/**
 * The Verizon Product Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Verizon Product feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Verizon
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Verizon extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'id'                => 'ID',
                'title'             => 'Title',
                'description'       => 'Description',
                'image_link'        => 'Image Link',
                'link'              => 'Link',
                'condition'         => 'Condition',
                'price'             => 'Price',
                'gtin'              => 'GTIN',
                'mpn'               => 'MPN',
                'brand'             => 'Brand',
            ),

            'Additional Information' => array(
                'additional_image_link'     => 'Additional Image Link',
                'age_group'                 => 'Age Group',
                'color'                     => 'Color',
                'expiration_date'           => 'Expiration Date',
                'gender'                    => 'Gender',
                'item_group_id'             => 'Item Group ID',
                'google_product_category'   => 'Google Product Category',
                'material'                  => 'Material',
                'pattern'                   => 'Pattern',
                'product_type'              => 'Product Type',
                'sale_price'                => 'Sale Price',
                'sale_price_effective_date' => 'Sale Price Effective Date',
                'shipping'                  => 'Shipping',
                'shipping_weight'           => 'Shipping Weight',
                'shipping_size'             => 'Shipping Size',
                'custom_label_0'            => 'Custom Label 0',
                'custom_label_1'            => 'Custom Label 1',
                'custom_label_2'            => 'Custom Label 2',
                'custom_label_3'            => 'Custom Label 3',
                'custom_label_4'            => 'Custom Label 4',
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
                'attr'     => 'gtin',
                'type'     => 'meta',
                'meta_key' => 'gtin',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'mpn',
                'type'     => 'meta',
                'meta_key' => 'mpn',
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

        );
    }

}
