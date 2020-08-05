<?php

/**
 * The Uvinum Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.7
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for zbozi feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Zbozi
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Zbozi extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'      =>  array(
                'PRODUCTNAME'          => 'Product Name',
                'DESCRIPTION'   => 'Product Description',
                'URL'           => 'Product URL',
                'PRICE_VAT'         => 'Product Price',
                'DELIVERY_DATE'         => 'Delivery Date',
            ),
            'Recommended Information'      =>  array(
                'CATEGORYTEXT'      => 'Product Category',
                'ITEM_ID'            => 'Product ID',
                'IMGURL'     => 'Product image URL',
                'EAN'                   => 'EAN',
                'ISBN'                  => 'ISBN',
                'PRODUCTNO'                   => 'MPN',
                'ITEMGROUP_ID'      => 'Product Group ID',
                'MANUFACTURER'  => 'Product Manufacturer',
                'EROTIC'         => 'Special Offer',
                'EXTRA_MESSAGE'=> 'Additional Information',
            ),

            'Additional Information'        => array(
                'CUSTOM_LABEL_0'             => 'CUSTOM LABEL 0',
                'CUSTOM_LABEL_1'             => 'CUSTOM LABEL 1',
                'CUSTOM_LABEL_2'             => 'CUSTOM LABEL 2',
                'BRAND'  => 'Brand',
                'SHOP_DEPOTS'            => 'Delivery sites',
                'VISIBILITY'        => 'Product Visibility',
                'MAX_CPC'    => 'Maximum cost per click',
                'MAX_CPC_SEARCH'    => 'Maximum CPC for Offers',
                'LIST_PRICE'  => 'Recommended retail Price',
                'RELEASE_DATE'                 => 'Sale Date',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
                'attr'     => 'PRICE_VAT',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'DELIVERY_DATE',
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
