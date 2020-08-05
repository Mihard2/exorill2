<?php
/**
 * The Preis Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for kelkoo feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Preis
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Preis extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'category' => 'Category',
                'manufacturer' => 'Manufacturer',
                'product_name' => 'Product name',
                'manufacturer_item_number' => 'Manufacturer item number',
                'price' => 'Price',
                'link' => 'Link',
                'availability' => 'Availability',
                'Product_picture' => 'Product picture',

            ) ,
            'Recommended Information' => array(
                'shipping_price ' => 'Shipping price',
                'EAN ' => 'EAN',
            ) ,

            'Optional Information' => array(
                'PZN ' => 'PZN',
                'ISBN ' => 'ISBN',
            ) ,

        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'category',
                'type' => 'meta',
                'meta_key' => 'product_cats_path',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'manufacturer',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'product_name',
                'type' => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'manufacturer_item_number',
                'type' => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'price',
                'type' => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'link',
                'type' => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'cdata',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'availability',
                'type' => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Product_picture',
                'type' => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
        );
    }

}

