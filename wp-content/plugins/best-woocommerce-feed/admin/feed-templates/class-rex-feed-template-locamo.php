<?php

/**
 * The Locamo Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      5.19
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Locamo feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Locamo
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Locamo extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'DEALERCODE'         => 'DEALERCODE',
                'PRODUCTNAME'        => 'PRODUCTNAME',
                'PRODUCTDESCRIPTION' => 'PRODUCTDESCRIPTION',
                'PRICE'              => 'PRICE',
                'STOCK'              => 'STOCK',
                'PRODUCTCATEGORY'    => 'PRODUCTCATEGORY',
                'IMAGE_URL'          => 'IMAGE_URL',
            ),

            'Additional Information' => array(
                'PRODUCTSUMMARY'     => 'PRODUCTSUMMARY',
                'IMAGE_URL_1'        => 'IMAGE_URL_1',
                'IMAGE_URL_2'        => 'IMAGE_URL_2',
                'IMAGE_URL_3'        => 'IMAGE_URL_3',
                'IMAGE_URL_4'        => 'IMAGE_URL_4',
                'IMAGE_URL_5'        => 'IMAGE_URL_5',
                'IMAGE_URL_6'        => 'IMAGE_URL_6',
                'IMAGE_URL_7'        => 'IMAGE_URL_7',
                'VARIANT'            => 'VARIANT',
                'EU_WARNING'         => 'EU_WARNING',
                'FORCE_IN_STOCK'     => 'FORCE_IN_STOCK',
                'BOUTIQUEPRODUCT'    => 'BOUTIQUEPRODUCT',
                'ATTRIBUT_1'         => 'ATTRIBUT_1',
                'ATTRIBUTE_2'        => 'ATTRIBUTE_2',
            ),

            'Recommended Information' => array(
                'BRAND'               => 'BRAND',
                'EAN'                 => 'EAN',
                'DEALERCODEMAIN'      => 'DEALERCODEMAIN',
                'DISCOUNTPRICE'       => 'DISCOUNTPRICE',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'DEALERCODE',
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
                'attr'     => 'PRODUCTDESCRIPTION',
                'type'     => 'meta',
                'meta_key' => 'description',
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
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'STOCK',
                'type'     => 'meta',
                'meta_key' => 'in_stock',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PRODUCTCATEGORY',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'IMAGE_URL',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
