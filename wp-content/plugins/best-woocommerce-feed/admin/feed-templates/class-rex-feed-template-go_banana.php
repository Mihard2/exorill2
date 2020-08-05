<?php

/**
 * The Go-Banana Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Go-Banana feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Go_banana
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Go_banana extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'           => 'Product Title',
                'description'     => 'Description',
                'price_vat_inc'   => 'Price',
                'category'        => 'Category',
                'mpn'             => 'MPN',
                'shipping_price'  => 'Shipping Price',
                'item_stock'      => 'Item Stock',
                'sku'             => 'SKU',
                'shipping_weight' => 'Shipping Weight',
                'main'            => 'Main',
                'brand'           => 'Brand',
            ),

            'Recommended Information' => array(
                'product_type'         => 'Product Type',
                'gtin'                 => 'GTIN',
                'item_sale_price_inc_vat'=> 'Item Sale Price Inc vat',
                'size'                 => 'Size',
                'width'                => 'Width',
                'height'               => 'Height',
                'finish'               => 'Finish',
                'diameter'             => 'Diameter',
                'image_2'              => 'Image-2',
                'image_3'              => 'Image-3',
                'image_4'              => 'Image-4',
                'minpurchasequantity'  => 'Minpurchasequantity',
                'colour'               => 'Colour',
                'carrier'              => 'Carrier',
                'shipping_country'     => 'Shipping Country',
                'quantity_discount'    => 'Quantity Discount',
                'parent_product_sku'   => 'Parent Product SKU',
                'variant_label1'       => 'Variant Label-1',
                'variant_label2'       => 'Variant Label-2',
                'variant_label3'       => 'Variant Label-3',
                'variant_value1'       => 'Variant Value-1',
                'variant_value2'       => 'Variant Value-2',
                'variant_value3'       => 'Variant Value-3',
            ),

            'Additional Information' => array(
                'material'              => 'Material',
                'depth'                 => 'Depth',
                'cross_sell_sku'        => 'Cross Sell SKU',
                'price_per_m2_vat_inc'  => 'Price Per m2 vat inc',
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
                'attr'     => 'price_vat_inc',
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
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'mpn',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_price',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'item_stock',
                'type'     => 'meta',
                'meta_key' => 'in_stock',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_weight',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'main',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
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

        );
    }

}
