<?php

/**
 * The Kiesproduct Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      5.19
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Kiesproduct feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Kiesproduct
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Kiesproduct extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'Product ID'                => 'Product ID',
                'Product Name'             => 'Product Name',
                'Price'             => 'Price',
                'Product URL'       => 'Product URL',
                'Image URL'         => 'Image URL',
            ),

            'Additional Information' => array(
                'MPN'                => 'MPN',
                'Gender'             => 'Gender',
                'SKU'                => 'SKU',
                'From price'         => 'From price',
                'Content'            => 'Content',
                'Dimensions'         => 'Dimensions',
                'Extra info'         => 'Extra info',
                'Sub category'       => 'Sub category',
                'Sub Sub category'   => 'Sub Sub category',
            ),

            'Recommended Information' => array(
                'Brand'                => 'Brand',
                'Product description'  => 'Product description',
                'EAN'                  => 'EAN',
                'Ship costs'           => 'Ship costs',
                'Delivery time'        => 'Delivery time',
                'Stock'                => 'Stock',
                'Category'             => 'Category',
                'Category Path'        => 'Category Path',
                'Color'                => 'Color',
                'Material'             => 'Material',
                'Size'                 => 'Size',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Product ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Product Name',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Product URL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Image URL',
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
