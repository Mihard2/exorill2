<?php

/**
 * The onbuy Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for onbuy feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_onbuy
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Onbuy extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'site_id'                      => 'Site Id',
                'uid'                          => 'Uid',
                'category_id'                  => 'Category Id',
                'product_name'                 => 'Product Name',
                'product_codes'                => 'Product Codes',

            ),

            'Additional Information' => array(
                'published'          => 'Published',
                'mpn'                => 'Mpn',
                'description'        => 'Description',
                'videos'             => 'Videos',
                'documents'          => 'Documents',
                'default_image'      => 'Default Image',
                'additional_images'  => 'Additional Images',
                'rrp'                => 'Rrp',
                'product_data'       => 'Product Data',
                'listings'           => 'Listings',
                'features'           => 'Features',
                'technical_detail'   => 'Technical Detail',

            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'site_id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_name',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'uid',
                'type'     => '',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'product_codes',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'category_id',
                'type'     => 'meta',
                'meta_key' => 'category',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
