<?php

/**
 * The Datatrics  marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Datatrics marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Datatrics
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Datatrics extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'name'             => 'Name',
                'id'               => 'Id',
                'category_names'  => 'Category Names ',
            ),

            'Optional Information' => array(
                'category_ids'         => 'Category Ids',
                'category_urls'        => 'Category Urls',
                'description'          => 'Description',
                'ean'                  => 'Ean',
                'image'                => 'Image',
                'long_description'     => 'Long Description',
                'price'                => 'Price',
                'special_price'        => 'Special Price',
                'url'                  => 'Url',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(

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
                'attr'     => 'id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'category_names',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
