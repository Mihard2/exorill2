<?php

/**
 * The Admitad Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for admitad feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Admitad
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Admitad extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'id'               => 'ID',
                'name'             => 'Product Name',
                'oldprice'         => 'Old Price',
                'picture'          => 'Picture',
                'price'            => 'Price',
                'product_category' => 'Product Category',
                'product_url'      => 'Product URL',
                'vendor'           => 'Vendor',
            ),

            'Additional Information' => array(
                'adult'                 => 'Adult',
                'barcode'               => 'Barcode',
                'category_id'           => 'Category Id',
                'delivery'              => 'Delivery',
                'local_delivery_cost'   => 'Local Delivery Cost',
                'manufacturer_warranty' => 'Manufacturer Warranty',
                'parent_id'             => 'Parent ID',
                'sales_notes'           => 'Sales Notes',
                'topseller'             => 'Top Seller',
            ),

            'Recommended Information' => array(
                'description'            => 'Description',
                'product_subcategory'    => 'Product Subcategory',
                'product_subsubcategory' => 'Product Subsubcategory',
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
                'attr'     => 'oldprice',
                'type'     => 'meta',
                'meta_key' => 'oldprice',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'picture',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
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
                'attr'     => 'product_category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'vendor',
                'type'     => 'meta',
                'meta_key' => 'vendor',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
