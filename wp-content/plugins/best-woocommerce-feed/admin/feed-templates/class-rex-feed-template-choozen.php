<?php

/**
 * The Ceneo Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.2.5
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Choozen feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Choozen
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Choozen extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'  =>  array(
                'Category'            => 'Product Categories',
                'availability'         => 'Availability',
                'delivery_charge'   => 'Delivery charge',
                'description'         => 'Description',
                'image_URL'          => 'Image URL',
                'landing-page-url'          => 'Landing page URL',
                'marque'          => 'Marque',
                'price'          => 'Price',
                'product_URL'          => 'Product URL',
                'title'          => 'Product title',
                'unique_id'          => 'Unique id',
            ),
            'Recommended Information'  =>  array(
                'MPN'            => 'MPN',
                'colour'            => 'Colour',
                'currency'            => 'Currency',
                'delivery_time'            => 'Delivery time',
                'ean'            => 'Ean',
                'full_price'            => 'Full price',
                'guarantee'            => 'Guarantee',
                'Material'            => 'Material',
                'model_reference'            => 'Model reference',
                'second_hand'            => 'Second hand',
                'size'            => 'Size',
            ),
            'Optional Information'  =>  array(
                'mobile_URL'            => 'Mobile URL',
                'type_promotion'            => 'Type promotion',
                'unit_price'            => 'Unit price',
            )
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
                'attr'     => 'unique_id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'delivery_charge',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'image_URL',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'landing-page-url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'marque',
                'type'     => 'static',
                'meta_key' => '',
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
            )
        );
    }

}
