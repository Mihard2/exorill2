<?php

/**
 * The Giftboxx Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for giftboxx feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Giftboxx
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Giftboxx extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'supplier_product_id' => 'Supplier Product ID',
                'title'               => 'Product Title',
                'price'               => 'Price',
                'categories'          => 'Category',
                'shipping_time'       => 'Shipping Time',
                'shipping_price'      => 'Shipping Price',
                'stock'               => 'Stock',
            ),

            'Additional Information' => array(
                'kleur'              => 'Kleur',
                'materiaal'          => 'Materiaal',
                'merk'               => 'Merk',
                'action_price'       => 'Action Price',
                'content'            => 'Content',
                'cost_price'         => 'Cost Price',
                'ean'                => 'EAN',
                'ext_url'            => 'Ext URL',
                'subtitle'           => 'Subtitle',
                'tax'                => 'Tax',
            ),
            
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'supplier_product_id',
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
                'attr'     => 'categories',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_time',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_price',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'stock',
                'type'     => 'meta',
                'meta_key' => 'in_stock',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            
        );
    }

}
