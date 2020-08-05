<?php

/**
 * The Hitmeister Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for hitmeister feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Hitmeister
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Hitmeister extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'  =>  array(
                'title'             => 'Product Title',
                'description'       => 'Description',
                'price'             => 'Price',
                'delivery_time'     => 'Delivery Time',
                'ean'               => 'EAN',
                'manufacturer'      => 'Manufacturer',
            ),

            'Additional Information' => array(
                'short_description'         => 'Short Description',
                'energie_efficiency_class'  => 'Energie Efficiency Class',
                'energie_efficiency_label'  => 'Energie Efficiency Label',
                'safety_guidelines'         => 'Safety Guidelines',
                'fsk'                       => 'FSK',
                'usk'                       => 'USK',
            ),

            'Recommended Information'  => array(
                'mpn'                  => 'MPN',
                'picture'              => 'Picture',
                'colour'               => 'Colour',
                'target'               => 'Target',
                'shoe_size'            => 'Shoe Size',
                'clothing_size'        => 'Clothing Size',
                'material_composition' => 'Material Composition',
                'content_volume'       => 'Content Volume',
                'weight'               => 'Weight',
                'length'               => 'Length',
                'quantity'             => 'Quantity',
                'width'                => 'Width',
                'height'               => 'Height',
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
                'attr'     => 'manufacturer',
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
