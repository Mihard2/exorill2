<?php

/**
 * The Fasha Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Fasha feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Fasha
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Fasha extends Rex_Feed_Abstract_Template {
    
    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'Product_ID'       => 'Product ID',
                'Name'             => 'Product Name',
                'Price'            => 'Price',
                'Image_Link'       => 'Image Link',
                'Category'         => 'Category',
                'Brand'            => 'Brand',
            ),
            
            'Additional Information' => array(
                'Image2'             => 'Image 2',
                'Image3'             => 'Image 3',
            ),
            
            'Recommended Information' => array(
                'Gender'             => 'Gender',
                'Sizes'              => 'Sizes',
                'Stock'              => 'Stock',
                'Delivery_Time'      => 'Delivery Time',
                'Shipping_Cost'      => 'Shipping Cost',
                'Material'           => 'Material',
                'Old_price'          => 'Old Price',
            ),
            
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Product_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
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
                'attr'     => 'Image_Link',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Brand',
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
