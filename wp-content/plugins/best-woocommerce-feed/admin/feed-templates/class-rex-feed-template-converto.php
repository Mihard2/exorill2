<?php

/**
 * The converto Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for converto feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Converto
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Converto extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'id'                => 'ID',
                'name'              => 'Product Title',
                'price'             => 'Price',
                'image_url'         => 'Image Url',
                'click_url'         => 'Click URL',
            ),

            'Additional Information' => array(
                'brand_url'           => 'Brand URL',
                'old_price'           => 'Old Price',
                'ean'                 => 'EAN',
                'manufacturer_code'   => 'Manufacturer Code',
                'availability_status' => 'Availability Status',
                'shop_product_number' => 'Shop Product Number',
                'categories'          => 'Categories',
                'display_info'        => 'Display Info',
            ),

            'Additional Information' => array(
                'description'        => 'Description',
                'brand'              => 'Brand',
                'currency'           => 'Currency',
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
                'attr'     => 'name',
                'type'     => 'meta',
                'meta_key' => 'title',
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
                'attr'     => 'image_url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'click_url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            
        );
    }

}
