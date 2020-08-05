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
 * Defines the attributes and template for scoupz feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Scoupz
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Scoupz extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Product Information'  =>  array(
                'MAIN_CATEGORY'     => 'MAIN_CATEGORY',
                'SUB_CATEGORY'      => 'SUB_CATEGORY',
                'TITLE'             => 'TITLE',
                'DESCRIPTION'       => 'DESCRIPTION',
                'IMAGE'             => 'IMAGE',
                'BRAND'             => 'BRAND',
                'SKU'               => 'SKU',
                'PRICE'             => 'PRICE',
                'EAN_UPC'           => 'EAN_UPC',
                'SHIPPING'          => 'SHIPPING',
                'BUY_URL'           => 'BUY_URL',
                'ISAVAILIBLE'       => 'ISAVAILIBLE',
                'DELIVERYTIME'      => 'DELIVERY TIME',
                'SELLING_PRICE'     => 'SELLING PRICE',
                'SHIPPING_COSTS'    => 'SHIPPING COSTS',
                'MICRO_CATEGORY'    => 'Micro Category',
                'CATEGORY_PATH'     => 'CATEGORY PATH',
                'PRODUCT_DEEPLINK'  => 'PRODUCT DEEPLINK',
                'STOCK'             => 'Stock',
                'GENDER'            => 'Gender',
                'FAMILYCODE'        => 'Familycode',
            ),
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'MAIN_CATEGORY',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SUB_CATEGORY',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'TITLE',
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
                'attr'     => 'IMAGE',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'BRAND',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SKU',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PRICE',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'EAN_UPC',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SHIPPING',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'BUY_URL',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ISAVAILIBLE',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'DELIVERYTIME',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            )
        );
    }

}
