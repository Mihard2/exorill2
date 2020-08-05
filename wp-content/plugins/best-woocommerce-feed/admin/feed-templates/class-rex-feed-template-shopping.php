<?php

/**
 * The Shopping Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for shopping feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Shopping
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Shopping extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'  =>  array(
                'Product_ID'        => 'Product ID',
                'Product_Name'      => 'Product Title',
                'Producl_URL'       => 'Product URL',
                'Image_URL'         => 'Primary Image URL',
                'Current_Price'     => 'Price',
                'Condition'         => 'Condition',
                'Stock_Availability'=> 'Availability',
                'Merchant_SKU'      => 'Merchant SKU',
            ),

            'Additional Information'    => array(
                'Shipping_Rate'             => 'Shipping Rate',
                'MPN'                       => 'MPN',
                'ISBN'                      => 'ISBN',
                'UPC'                       => 'UPC',
                'EAN'                       => 'EAN',
                'Original_Price'            => 'Original_Price',
                'Coupon_Code'               => 'Coupon_Code',
                'Coupon_Code_Description'   => 'Coupon_Code_Description',
                'Manufacturer'              => 'Manufacturer',
                'Product_Description'       => 'Product_Description',
                'Product_Type'              => 'Product_Type',
                'Category'                  => 'Category',
                'Category_ID'               => 'Category_ID',
                'Parent_SKU'                => 'Parent_SKU',
                'Parent_Name'               => 'Parent_Name',
                'Top_Seller_Rank'           => 'Top_Seller_Rank',
                'Estimated_Ship_Date'       => 'Estimated_Ship_Date',
                'Gender'                    => 'Gender',
                'Colour'                    => 'Colour',
                'Material'                  => 'Material',
                'Size'                      => 'Size',
                'Size_Unit_of_Measure'      => 'Size_Unit_of_Measure',
                'Age_Range'                 => 'Age_Range',
                'additional_image_link_1'   => 'Additional Image 1 [additional_image_link]',
                'additional_image_link_2'   => 'Additional Image 2 [additional_image_link]',
                'additional_image_link_3'   => 'Additional Image 3 [additional_image_link]',
                'additional_image_link_4'   => 'Additional Image 4 [additional_image_link]',
                'additional_image_link_5'   => 'Additional Image 5 [additional_image_link]',
                'additional_image_link_6'   => 'Additional Image 6 [additional_image_link]',
                'additional_image_link_7'   => 'Additional Image 7 [additional_image_link]',
                'additional_image_link_8'   => 'Additional Image 8 [additional_image_link]',
                'additional_image_link_9'   => 'Additional Image 9 [additional_image_link]',
                'additional_image_link_10'  => 'Additional Image 10 [additional_image_link]',
                'Mobile_URL'                => 'Mobile_URL',
                'Product_Weight'            => 'Product_Weight',
                'Shipping_Weight'           => 'Shipping_Weight',
                'Unit_Price'                => 'Unit_Price',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Product_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Product_Name',
                'type'     => 'meta',
                'meta_key' => 'title',
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
            array(
                'attr'     => 'Producl_URL',
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
                'attr'     => 'Stock_Availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Merchant_SKU',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
