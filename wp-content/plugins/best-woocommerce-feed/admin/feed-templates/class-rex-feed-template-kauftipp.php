<?php

/**
 * The kauftipp marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */
/**
 *
 * Defines the attributes and template for git marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Kauftipp
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Kauftipp extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'            =>  'Title',
                'url'              => 'Url',
                'id'               => 'Id',
                'logo'             => 'Logo',
                'category'         => 'Category',
                'price'            => 'Price',
                'image'            => 'Image',
            ),

            'Recommended Information' => array(
                'EAN'            => 'EAN',
                'MPN'            => 'MPN',
                'availability'   => 'Availability',
                'brand'          => 'Brand',
                'description'    => 'Description',
                'shipping_cost'  => 'Shipping Cost',
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
                'attr'     => 'url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
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
                'attr'     => 'logo',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'category',
                'type'     => 'meta',
                'meta_key' => 'category',
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
        );
    }

}
