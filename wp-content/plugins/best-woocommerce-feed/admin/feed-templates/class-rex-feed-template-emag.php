<?php

/**
 * The Emag Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Emag feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Emag
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Emag extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'brand'           => 'Brand',
                'id'              => 'Id',
                'images_url_1'    => 'images_url_1',
                'name'            => 'Name',
                'part_number'     => 'Part Number',
                'sale_price'      => 'Sale Price',
                'url'             => 'Url',

            ),
            'Recommended Information' => array(
                'category'             => 'category',
            ),
            'Optional Information' => array(
                'VAT'               => 'VAT',
                'description'       => 'description',
                'ean'               => 'ean',
                'handling_time'     => 'handling_time',
                'images_url_2'      => 'images_url_2',
                'images_url_3'      => 'images_url_3',
                'images_url_4'      => 'images_url_4',
                'images_url_5'      => 'images_url_5',
                'recommended_price' => 'recommended_price',
                'stock'             => 'stock',
                'warranty'          => 'warranty',
                'weight'            => 'weight',
            ),
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'name',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'sale_price',
                'type'     => 'meta',
                'meta_key' => 'sale_price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'brand',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'images_url_1',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'part_number',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
