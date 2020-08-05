<?php

/**
 * The Pepperjam Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Pepperjam feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Pepperjam
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Pepperjam extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'program_id'        => 'Program ID',
                'program_name'      => 'Program Name',
                'age_range'         => 'Age Range',
                'artist'            => 'Artist',
                'aspect_ratio'      => 'Aspect Ratio',
                'author'            => 'Author',
                'binding'           => 'Binding',
                'buy_url'           => 'Buy URL',
                'image_url'         => 'Image URL',
                'isbn'              => 'ISBN',
                'manufacturer'      => 'Manufacturer',
                'mpn'               => 'MPN',
                'name'              => 'Name',
                'quantity_in_stock' => 'Quantity In Stock',
                'sku'               => 'SKU',

            ),

            'Additional Information' => array(
                'battery_life'        => 'Battery Life',
                'color'               => 'Color',
                'color_output'        => 'Color Output',
                'description_long'    => 'Description Long',
                'director'            => 'director',
                'display_type'        => 'Display Type',
                'edition'             => 'Edition',
                'expiration_date'     => 'Expiration Date',
                'features'            => 'Features',
                'focus_type'          => 'Focus Type',
                'format'              => 'Format',
                'functions'           => 'Functions',
                'genre'               => 'Genre',
                'heel_height'         => 'Heel Height',
                'height'              => 'Height',
                'image_thumb_url'     => 'Image Thumb URL',
                'installation'        => 'Installation',
                'length'              => 'Length',
                'load_type'           => 'Load Type',
                'location'            => 'Location',
                'made_in'             => 'Made In',
                'material'            => 'Material',
                'megapixels'          => 'Megapixels',
                'memory_type'         => 'Memory Type',
                'memory_capacity'     => 'Memory Capacity',
                'memory_card_slot'    => 'Memory Card Slot',
                'model_number'        => 'Model Number',
                'occasion'            => 'Occasion',
                'operating_system'    => 'Operating System',
                'optical_drive'       => 'Optical Drive',
                'price_retail'        => 'Price Retail',
                'pages'               => 'Pages',
                'payment_accepted'    => 'Payment Accepted',
                'payment_notes'       => 'Payment Notes',
                'platform'            => 'Platform',
                'price_sale'          => 'Price Sale',
                'processor'           => 'Processor',
                'publisher'           => 'Publisher',
                'rating'              => 'Rating',
                'recommended_usage'   => 'Recommended Usage',
                'resolution'          => 'Resolution',
                'shoe_size'           => 'Shoe Size',
                'screen_size'         => 'Screen Size',
                'shipping_method'     => 'Shipping Method',
                'price_shipping'      => 'Price Shipping',
                'shoe_width'          => 'Shoe Width',
                'size'                => 'Size',
                'staring'             => 'Staring',
                'style'               => 'Style',
                'tracks'              => 'Tracks',
                'upc'                 => 'UPC',
                'weight'              => 'Weight',
                'width'               => 'Width',
                'wireless_interface'  => 'Wireless Interface',
                'year'                => 'Year',
                'zoom'                => 'Zoom',
                'category_network'    => 'Category Network',
                'category_program'    => 'Category Program',
                'description_short'   => 'Description Short',
                'discontinued'        => 'Discontinued',
                'in_stock'            => 'In Stock',
                'tech_spec_url'       => 'Tech Spec URL',
                'keywords'            => 'Keywords',
                'price'               => 'Price',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'program_id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'program_name',
                'type'     => 'meta',
                'meta_key' => 'name',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'age_range',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'artist',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'aspect_ratio',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'author',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'binding',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'buy_url',
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
                'attr'     => 'isbn',
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
                'attr'     => 'mpn',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'name',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'quantity_in_stock',
                'type'     => 'meta',
                'meta_key' => 'quantity',
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

        );
    }

}
