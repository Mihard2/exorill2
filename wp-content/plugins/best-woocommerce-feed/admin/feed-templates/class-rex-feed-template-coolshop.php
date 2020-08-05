<?php

/**
 * The Coolshop Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Coolshop feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Coolshop
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Coolshop extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'             => 'Product Title',
                'description'       => 'Description',
                'category'          => 'Category',
                'sku'               => 'SKU',
                'ean'               => 'EAN',
                'primary_image'     => 'Primary Image',
            ),

            'Additional Information' => array(
                'campaign'                => 'Campaign',
                'youtub_vimeo_url_1'      => 'YouTube/Vimeo URL 1',
                'youtub_vimeo_url_2'      => 'YouTube/Vimeo URL 2',
                'youtub_vimeo_url_3'      => 'YouTube/Vimeo URL 3',
                'release_date'            => 'Release Date',
                'power'                   => 'Power (W)',
                'primary_color'           => 'Primary Color',
                'size'                    => 'Size',
                'look'                    => 'Look',
                'size'                    => 'Size',
                'supplier_delivery_time'  => 'Supplier delivery time',
                'volume_discount'         => 'Volume Discount',
                'age'                     => 'Age',
                'attributes'              => 'Attributes',
                'gift_box'                => 'Gift Box',
                'character'               => 'Character',
                'occasion'                => 'Occasion',
                'theme'                   => 'Theme',
                'number_of_people'        => 'Number of people',
                'sub_brand'               => 'Sub Brand',
            ),

            'Recommended Information' => array(
                'brand'        => 'Brand',
                'variant_id'   => 'Variant ID',
                'image_2'      => 'Image 2',
                'image_3'      => 'Image 3',
                'image_4'      => 'Image 4',
                'image_5'      => 'Image 5',
                'image_6'      => 'Image 6',
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
                'attr'     => 'primary_image',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            
        );
    }

}
