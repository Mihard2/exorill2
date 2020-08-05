<?php


/**
 *
 * Defines the attributes and template for skroutz feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Skroutz
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Skroutz extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'              =>  array(
                'Name'             => 'Product Name',
                'UniqueID'        => 'Unique ID',
                'link'     => 'Product Link',
                'imageurl'       => 'Image Link',
                'category'         => 'Category Name',
                'price'            => 'Price',
                'availability'     => 'Availability',
                'manufacturer'     => 'Manufacturer',
                'mpn'         => 'MPN/ISBN',
            ),

            'Additional Information'      => array(
                'additional_imageurl'   => 'Additional Image Link',
                'ean'             => 'EAN/Barcode',
                'size'                    => 'Size',
                'weight'                  => 'Weight',
                'instock'                => 'InStock',
                'shipping_costs'          => 'Shipping Costs',
                'color'                   => 'Color',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(

            array(
                'attr'     => 'Name',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'UniqueID',
                'type'     => 'meta',
                'meta_key' => 'unique_id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'link',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'imageurl',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
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
        );
    }

}
