<?php

/**
 * The Guenstiger Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Guenstiger feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Guenstiger
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Guenstiger extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'hersteller'        => 'Hersteller',
                'ean'                => 'EAN',
            ),

            'Recommended' => array(
                'category'            => 'Category',
                'click_out_url'       => 'Click-out-URL',
                'ISBN'                => 'ISBN',
                'description'         => 'Description',
                'delivery_time'       => 'Delivery Time',
                'image_url'           => 'Image URL',
                'price'               => 'Price',
                'product_name'        => 'Product Name',
                'ground_shipping'     => 'Ground Shipping',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'hersteller',
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

        );
    }

}
