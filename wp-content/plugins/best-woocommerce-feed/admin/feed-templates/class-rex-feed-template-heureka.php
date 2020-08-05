<?php

/**
 * The eBay Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for eBay feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Ebay
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Heureka extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(

            'Required Information'      =>  array(
                'ITEM_ID'               => 'ITEM ID',
                'PRODUCTNAME'           => 'PRODUCT NAME',
                'DESCRIPTION'           => 'Description',
                'URL'                   => 'Product URL',
                'IMGURL'                => 'Image URL',
                'PRICE_VAT'             => 'PRICE',
                'DELIVERY_DATE'         => 'DELIVERY DATE',
            ),

            'Additional Information'        => array(
                'CATEGORYTEXT'              => 'CATEGORY TEXT',
                'EAN'                       => 'EAN',
                'ISBN'                      => 'ISBN',
                'PRODUCTNO'                 => 'PRODUCTNO',
                'ITEMGROUP_ID'              => 'ITEMGROUP_ID',
                'MANUFACTURER'              => 'MANUFACTURER',
                'EROTIC'                    => 'EROTIC',
                'BRAND'                     => 'BRAND',
                'PRODUCT'                   => 'PRODUCT',
                'ITEM_TYPE'                 => 'ITEM TYPE',
                'VIDEO_URL'                 => 'PRODUCT',
                'SIZE'                      => 'SIZE',
                'COLOR'                     => 'COLOR',
                'GIFT'                      => 'GIFT',
            ),
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(

            array(
                'attr'     => 'ITEM_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PRODUCTNAME',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'DESCRIPTION',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'URL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),


            array(
                'attr'     => 'IMGURL',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'PRICE_VAT',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'DELIVERY_DATE',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
