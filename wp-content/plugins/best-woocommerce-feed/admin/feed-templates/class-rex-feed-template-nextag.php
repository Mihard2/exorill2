<?php

/**
 * The Nextag Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for nextag feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Nextag
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Nextag extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'  =>  array(
                'title'             => 'Product Name',
                'description'       => 'Product Description',
                'price'             => 'Price',
                'link'              => 'Click-out URL',
                'category'          => 'Category',
                'manufacturer'      => 'Manufacturer',
            ),

            'Unique Product Identifier' => array(
                'distributor_id '     => 'Distributor ID ',
                'upc'                 => 'UPC',
                'isbn'                => 'ISBN',
                'muze_id'             => 'MUZE ID',
                'manufacturer_part_#' => 'Manufacturer Part #',
            ),

            'Additional Information' => array(
                'feature_imgurl'    => 'Image URL',
                'stock_status'      => 'Stock Status',
                'condition'         => 'Product Condition',
                'weight'            => 'Weight',
                'listprice'         => 'ListPrice',
                'seller_part_#'     => 'Seller Part #',
                'ingram_part_#'     => 'Ingram Part #',
                'cost_per_click'    => 'Cost-per-Click',
                'ground_shipping'   => 'Ground Shipping',
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
                'attr'     => 'description',
                'type'     => 'meta',
                'meta_key' => 'description',
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
                'attr'     => 'feature_imgurl',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'stock_status',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'condition',
                'type'     => 'meta',
                'meta_key' => 'condition',
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
        );
    }

}
