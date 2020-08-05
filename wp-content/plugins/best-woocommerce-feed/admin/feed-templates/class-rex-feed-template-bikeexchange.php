<?php

/**
 * The bike exchange Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for bike exchange feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Bikeexchange
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Bikeexchange extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'             => 'Product Title',
                'description'       => 'Description',
                'price'             => 'Price',
                'ean'               => 'EAN',
                'manufacturer'      => 'Manufacturer',
                'delivery_time'     => 'Delivery Time',
            ),

            'Additional Information' => array(
                'energie_efficiency_class'   => 'Energie Efficiency Class',
                'energie_efficiency_label'   => 'Energie Efficiency Label',
                'safety_guidelines'          => 'Safety Guidelines',
                'short_description'          => 'Short Description',
                'fsk'                        => 'FSK',
                'usk'                        => 'USK',
            ),
            
            'Recommended Information' => array(
                'clothing_size'      => 'Clothing Size',
                'picture'            => 'Picture',
                'weight'             => 'Weight',
                'height'             => 'Height',
                'quantity'           => 'Quantity',
                'shoe_size'          => 'Shoe Size',
                'colour'             => 'Colour',
                'length'             => 'Length',
                'content_volume'     => 'Content Volume',
                'mpn'                => 'MPN',
                'material_composition' => 'Material Composition',
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

        );
    }

}
