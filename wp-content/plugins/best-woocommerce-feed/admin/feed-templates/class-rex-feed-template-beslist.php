<?php


/**
 *
 * Defines the attributes and template for beslist feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Beslist
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Beslist extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'              =>  array(
                'title'                 => 'Product title',
                'price'                 => 'Product price',
                'unique_code'           => 'Unique code',
                'product_url'           => 'Product URL',
                'image_url'             => 'Product image URL',
                'extra_images'          => 'Extra images',
                'category'              => 'Product category',
                'delivery_period'       => 'Delivery period',
                'delivery_charges'      => 'Delivery charges',
                'ean'                   => 'EAN',
                'description'           => 'Product description',
                'display'               => 'Display',
            ),
            'Required Information with specific categories'  =>  array(
                'SKU'                           => 'SKU',
                'brand'                         => 'Brand',
                'size'                          => 'Size',
                'condition'                     => 'Condition',
                'variant_code'                  => 'Variant code',
                'specifications_numerical_values'  => 'Specifications with numerical values',
            ),
            'Recommended Fields'            => array(
                'variant_code'                  => 'Variant code',
                'model_code'                    => 'Model code',
                'old_price'                     => 'Old price',
                'product_url'                   => 'Product URL',
                'miscellaneous_specifications'  => 'Miscellaneous specifications',
            ),

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
                'attr'     => 'price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'unique_code',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
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
                'attr'     => 'extra_images',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'delivery_period',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'delivery_charges',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ean',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'display',
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