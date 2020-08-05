<?php

/**
 * The Eytsy Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Eytsy feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Eytsy
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Eytsy extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'header'           => 'Header',
                'title'            => 'Title',
                'sku'              => 'Sku',
                'listing ID'       => 'Listing ID',
                'price'            => 'Price',
                'description'      => 'Description',
                'quantity'         => 'Quantity',
            ),

            'Recommended Information' => array(
                'is_supply'           => 'is_supply',
                'taxonomy_id'         => 'taxonomy_id',
                'who_made'            => 'who_made',
                'is_customizable'     => 'is_customizable',
                'when_made'           => 'when_made',
                'tags'                => 'tags',
                'processing_min'      => 'processing_min',
                'processing_max'      => 'processing_max',
                'shop_section_id'     => 'shop_section_id',
                'materials'           => 'materials',
                'is_private'          => 'is_private',
                'state'               => 'state',
                'recipient'           => 'recipient',
                'occasion'            => 'occasion',
                'color'               => 'color',
                'image1'              => 'image1',
                'image2'              => 'image2',
                'image3'              => 'image3',
                'image4'              => 'image4',
                'Available Size'      => 'Available Size',
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
                'attr'     => 'header',
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
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'SKU',
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
                'attr'     => 'listing ID',
                'type'     => 'meta',
                'meta_key' => 'id',
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
