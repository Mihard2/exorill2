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
 * Defines the attributes and template for koopkeus feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Koopkeus
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Koopkeus extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'      =>  array(
                'product_title'         => 'Product title',
                'product_description'   => 'Product description',
                'product_price'         => 'Product price',
                'product_category'      => 'Product category',
                'unique_ID'             => 'Unique ID',
                'product_image_URL'     => 'Product image URL',
                'delivery_cost'         => 'Delivery cost',
                'product_availability'  => 'Product availability',
                'delivery_time'         => 'Delivery time',
                'guarantee'             => 'Guarantee',
            ),

            'Additional Information' => array(
                'product_URL'           => 'Product URL',
                'model_reference'       => 'Model reference',
                'marque'                => 'Marque (Brand)',
                'EAN'                   => 'EAN',
                'full_price'            => 'Full price',
                'currency'              => 'Currency',
                'second_hand'           => 'Second-hand',
                'type_promotion	'       => 'Promotion type',
                'mobile_URL'            => 'Mobile URL',
            ),
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'product_title',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_category',
                'type'     => 'meta',
                'meta_key' => 'product_cats_path',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'unique_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_image_URL',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'delivery_cost',
                'type'     => 'static',
                'meta_key' => 'delivery_cost',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'delivery_time',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'guarantee',
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
