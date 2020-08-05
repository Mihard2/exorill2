<?php
/**
 * The Become Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.7
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for idealo feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Idealo
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Idealo extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'Product_name' => 'Product name',
                'EAN' => 'EAN',
                'GTIN' => 'GTIN',
                'barcode' => 'Barcode',
                'UPC' => 'UPC',
                'MPN' => 'MPN',
                'Manufacturer' => 'Manufacturer',
                'Price' => 'Price',
                'Delivery_time' => 'Delivery time',
                'Product_URL' => 'Product URL',
                'Image_URL' => 'Image URL',
                'Cash_in_advance' => 'Cash in advance ',
                'Energy_efficiency_rating' => 'Energy efficiency rating',

            ) ,

            'Optional Information' => array(
                'Unit_price' => 'Unit price',
                'Article_number_in_shop' => 'Article number in shop',
                'Product_group_in_shop' => 'Product group in shop',
                'Product_description' => 'Product description',
                'Product_characteristics' => 'Product characteristics',
                'Colour' => 'Colour',
                'Size' => 'Size',
            ) ,

        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'Product_name',
                'type' => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'EAN',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'MPN',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Manufacturer',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Price',
                'type' => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Delivery_time',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Product_URL',
                'type' => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'cdata',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Image_URL',
                'type' => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Cash_in_advance',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Energy_efficiency_rating',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Product_group_in_shop',
                'type' => 'meta',
                'meta_key' => 'product_cats_path',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,

        );
    }

}
