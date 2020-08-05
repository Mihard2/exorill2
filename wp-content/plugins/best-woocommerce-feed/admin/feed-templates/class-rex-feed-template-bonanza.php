<?php

/**
 * The Bonanza Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for bonanza feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Bonanza
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Bonanza extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'id'                => 'id',
                'title'             => 'Product Title',
                'description'       => 'Description',
                'price'             => 'Price',
                'image-url'         => 'Images',
                'category'          => 'Category',
                'sku'               => 'sku',
                'quantity'          => 'quantity',
            ),

            'Additional Information' => array(
                'booth_category'                => 'Booth Category',
                'shipping_price'                => 'Shipping Price',
                'shipping_type'                 => 'Shipping Type',
                'shipping_service'              => 'Shipping Service',
                'shipping_lbs'                  => 'Shipping lbs',
                'shipping_oz'                   => 'Shipping oz',
                'shipping_carrier'              => 'Shipping Carrier',
                'shipping_package'              => 'Shipping Package',
                'worldwide_shipping_price'      => 'Worldwide Shipping Price',
                'worldwide_shipping_type'       => 'Worldwide Shipping Type',
                'worldwide_shipping_carrier'    => 'Worldwide Shipping Carrier',
                'trait'                         => 'trait',
                'force_update'                  => 'Force Update',
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
            ),
            array(
                'attr'     => 'title',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'description',
                'type'     => 'meta',
                'meta_key' => 'description',
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
                'attr'     => 'image-url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'quantity',
                'type'     => 'meta',
                'meta_key' => 'quantity',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
