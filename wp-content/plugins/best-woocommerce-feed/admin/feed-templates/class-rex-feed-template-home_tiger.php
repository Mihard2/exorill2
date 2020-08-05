<?php

/**
 * The Home Tiger Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      5.19
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Home Tiger feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Home_tiger
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Home_tiger extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'      =>  array(
                'Master_SKU_ID'         => 'Master_SKU_ID',
                'Name'                  => 'Name',
                'Description'           => 'Description',
                'Price'                 => 'Price',
                'Category_Path'         => 'Category_Path',
                'Product_URL'           => 'Product_URL',
                'Product_Image_URL_1'   => 'Product_Image_URL_1',
                'Product_Image_URL_2'   => 'Product_Image_URL_2',
                'Clean_URL'             => 'Clean_URL',
                'SKU_ID'                => 'SKU_ID',
                'Tax'                   => 'Tax',
                'Delivery_Cost'         => 'Delivery_Cost',
                'Delivery_Time'         => 'Delivery_Time',
                'Color'                 => 'Color',
                'Material'              => 'Material',
                'Length'                => 'Length',
                'Width'                 => 'Width',
                'Height'                => 'Height',
                'EAN'                   => 'EAN',
                'Brand'                 => 'Brand',
            ),

            'Additional Information' => array(
                'Related_Product_Codes'   => 'Related_Product_Codes',
                'Additional_Size'         => 'Additional_Size',
                'Weight'                  => 'Weight',
            ),

            'Recommended Information' => array(
                'Alternate_Price'       => 'Alternate_Price',
                'Short_Description'     => 'Short_Description',
                'Mobile_URL'            => 'Mobile_URL',
                'Product_Image_URL_3'   => 'Product_Image_URL_3',
                'Product_Image_URL_4'   => 'Product_Image_URL_4',
                'Product_Image_URL_5'   => 'Product_Image_URL_5',
                'MPN'                   => 'MPN',
                'Average_Rating'        => 'Average_Rating',
                'Minimum_Rating'        => 'Minimum_Rating',
                'Maximum_Rating'        => 'Maximum_Rating',
                'Number_Rating'         => 'Number_Rating',
                'Labels'                => 'Labels',
                'Certificates'          => 'Certificates',
                'CPC'                   => 'CPC',
                'Availability'          => 'Availability',
                'Manufacturer_Code'     => 'Manufacturer_Code',
                'Keywords'              => 'Keywords',
                'Sales_Rank'            => 'Sales_Rank',
                'Voucher_Code'          => 'Voucher_Code',
                'Voucher_Description'   => 'Voucher_Description',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Master_SKU_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Name',
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
                'attr'     => 'Price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Category_Path',
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
                'attr'     => 'Product_Image_URL_1',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Product_Image_URL_2',
                'type'     => 'meta',
                'meta_key' => 'image_1',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SKU_ID',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Tax',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Delivery_Cost',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Delivery_Time',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Color',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Material',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Length',
                'type'     => 'meta',
                'meta_key' => 'length',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Width',
                'type'     => 'meta',
                'meta_key' => 'width',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Height',
                'type'     => 'meta',
                'meta_key' => 'height',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'EAN',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Brand',
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
