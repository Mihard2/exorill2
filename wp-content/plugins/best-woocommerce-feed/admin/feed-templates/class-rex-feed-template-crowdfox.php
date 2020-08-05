<?php

/**
 * The Become Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      5.5
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Crowdfox feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Crowdfox
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Crowdfox extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(

            'Required Information'     =>  array(
                'aid'                 => 'Product ID',
                'image'             => 'Image',
                'name'                => 'Product name',
                'price'             => 'Product price',
                'sell_max'     => 'Sell max',
                'obl_info'           => 'Obl info',
                'desc'           => 'Description',
            ),

            'Additional Information' => array(
                'brand'            => 'Brand',
                'mpn'            => 'Mpn',
                'ean'            => 'EAN',
                'shop_cat'            => 'Shop category',
                'image_2'            => 'Image 2',
                'image_3'            => 'Image 3',
                'image_4'            => 'Image 4',
                'base_price'            => 'Price',
                'obl_info_2'            => 'Obl info 2',
                'div_cost'            => 'Div cost',
                'div_time'            => 'Div time',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'aid',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'image',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
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
                'attr'     => 'sell_max',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'obl_info',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'desc',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
