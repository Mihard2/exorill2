<?php

/**
 * The Realde Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Realde feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Realde
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Realde extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'            => 'Product Title',
                'description'      => 'Description',
                'category'         => 'Category',
                'manufacturer'     => 'Manufacturer',
                'picture'          => 'Picture',
                'ean'              => 'EAN',
            ),

            'Additional Information' => array(
                'short_description'       => 'Short Description',
                'mpn'                     => 'Manufacturer Part Number',
                'target'                  => 'Target',
                'shose_size'              => 'Shose Size',
                'colthing_size'           => 'Colthing Size',
                'material_composition'    => 'Material Composition',
                'content_volume'          => 'Content Volume',
                'weight'                  => 'Weight',
                'lenght'                  => 'Lenght',
                'quantity'                => 'Quantity',
                'width'                   => 'Width',
                'height'                  => 'Height',
                'energy_efficiency_class' => 'Energy Efficiency Class',
                'energylable'             => 'Energylable',
                'eu_product_data_sheet'   => 'EU Product Data Sheet',
                'safety_guideline'        => 'Safety Guideline',
                'fsk'                     => 'FSK',
                'thr_atributt'            => 'THR Atributt',
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
                'attr'     => 'picture',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
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
            
        );
    }
    
}
