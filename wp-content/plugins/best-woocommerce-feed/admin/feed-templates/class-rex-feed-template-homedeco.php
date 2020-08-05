<?php

/**
 * The homedeco Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for homedeco feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Homedeco
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Homedeco extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'NameField'        => 'Name Field',
                'id'               => 'ID',
                'Description'      => 'Description',
                'Category'         => 'Category',
                'price'            => 'Price',
                'brand'            => 'Brand',
                'ImageUrl'         => 'Image Url',
            ),

            'Recommended Information' => array(
                'DeliveryCosts'       => 'DeliveryCosts',
                'DeliveryTime'        => 'DeliveryTime',
                'EAN'                 => 'EAN',
                'Sku'                 => 'Sku',
                'Stock'                => 'Stock',
            ),

            'Optional Information' => array(
                'Afmetingen'                => 'Afmetingen',
                'AlternativeDeliveryCosts'  => 'AlternativeDeliveryCosts',
                'Color'                     => 'Color',
                'ExtraImageUrl1'            => 'ExtraImageUrl1',
                'ExtraImageUrl2'            => 'ExtraImageUrl2',
                'ExtraImageUrl3'            => 'ExtraImageUrl3',
                'ExtraImageUrl4'            => 'ExtraImageUrl4',
                'ExtraImageUrl5'            => 'ExtraImageUrl5',
                'FromPrice'                 => 'FromPrice',
                'Material'                  => 'Material',
                'Specifications'            => 'Specifications',
                'Url'                       => 'Url',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
                'attr'     => 'NameField',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Category',
                'type'     => 'meta',
                'meta_key' => 'category',
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
                'attr'     => 'brand',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ImageUrl',
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
