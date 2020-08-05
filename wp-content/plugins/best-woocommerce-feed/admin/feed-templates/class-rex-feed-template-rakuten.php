<?php

/**
 * The Rakuten Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Rakuten feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Rakuten
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Rakuten extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Basic Information' =>  array(
                'id'                       => 'Product Id [id]',
                'title'                    => 'Product Title [title]',
                'brand'                    => 'Product Brand',
                'description'              => 'Product Description [description]',
                'google_product_category'  => 'Google Product Category [google_product_category]',
                'link'                     => 'Product URL [link]',
                'image_link'               => 'Main Image [image_link]',
                'price'                    => 'Price',
                'sale_price'               => 'Sale Price',
                'availability'             => 'Availability',
            ),

            'Optional Attributes' => array(
                'gtin'                      => 'GTIN [gtin]',
                'mpn'                       => 'MPN [mpn]',
                'sku'                       => 'SKU',
                'additional_image_link'     => 'Additional Image  [additional_image_link]',
                'condition'                 => 'Condition [condition]',
                'gender'                    => 'Gender [gender]',
                'age_group'                 => 'Age Group [age_group]',
                'sale_price_effective_date' => 'Sale Price Effective Date [sale_price_effective_date]',
                'product_type'              => 'Product Categories [product_type] ',
                'color'                     => 'Color [color]',
                'size'                      => 'Size of the item [size]',
                'material'                  => 'Material [material]',
                'pattern'                   => 'Pattern [pattern]',
                'tax'                       => 'Tax [tax]',
                'shipping'                  => 'Shipping',
                'shipping_weight'           => 'Shipping weight',
                'multipack'                 => 'Multipack [multipack]',
                'adult'                     => 'Adult [adult]',
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
                'attr'     => 'product_type',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'google_product_category',
                'type'     => 'meta',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'image_link',
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
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'sale_price',
                'type'     => 'meta',
                'meta_key' => 'sale_price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'brand',
                'type'     => 'meta',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'mpn',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
