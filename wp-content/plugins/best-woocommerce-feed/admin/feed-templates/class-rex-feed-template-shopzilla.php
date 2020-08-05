<?php

/**
 * The Shopzilla Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.10
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Shopzilla feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Shopzilla
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Shopzilla extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'Unique_ID'         => 'Unique ID',
                'Title'             => 'Product Title',
                'Description'       => 'Product Description',
                'Category'          => 'Product Category',
                'Product_URL'       => 'Product URL',
                'Image_URL'         => 'Image Url',
                'Condition'         => 'Condition',
                'Availability'      => 'Availability',
                'Current_Price'     => 'Current Price',
            ),

            'Additional Information'    => array(
                'additional_image'  => 'Additional Image Link',
                'item_group_id'     => 'Item Group ID',
                'regular_price'     => 'Original Price',
                'weight'            => 'Shipping Weight [shipping_weight]',
                'length'            => 'Shipping Length [shipping_length]',
                'width'             => 'Shipping Width [shipping_width]',
                'height'            => 'Shipping Height [shipping_height]',
                'brand'             => 'Manufacturer',
                'upc'               => 'GTIN',
                'mpn'               => 'MPN',
                'color'             => 'Color',
                'gender'            => 'Gender',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Unique_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Title',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),


            array(
                'attr'     => 'Product_URL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),


            array(
                'attr'     => 'Image_URL',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),


            array(
                'attr'     => 'Condition',
                'type'     => 'meta',
                'meta_key' => 'condition',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Current_Price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
