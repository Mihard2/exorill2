<?php

/**
 * The awin Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for awin feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Awin
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Awin extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'product_id'       => 'Product ID',
                'product_name'     => 'Product Name',
                'description'      => 'Description',
                'image_url'        => 'Image Url',
                'deep_link'        => 'Deep Link',
                'price'            => 'Price',
                'currency'         => 'Currency',

            ),

            'Additional Information' => array(
                'swatch'                           => 'Swatch',
                'commission_group'                 => 'Commission Group',
                'dimensions'                       => 'Dimensions',
                'merchant_product_second_category' => 'Merchant Product Second Category',
                'basket_link'                      => 'Basket Link',
                'merchant_product_third_category'  => 'Merchant Product Third Category',
                'valid_from'                       => 'Valid From',
                'isbn'                             => 'ISBN',
                'keywords'                         => 'Keywords',
                'custom2'                          => 'Custom2',
                'parent_product_id'                => 'Parent Product ID',
                'large_image'                      => 'Large Image',
                'rating'                           => 'Rating',
                'custom1'                          => 'Custom1',
                'saving'                           => 'Saving',
                'valid_to'                         => 'Valid to',
                'product_short_description'        => 'Product Short Description',
                'pattern'                          => 'Pattern',
                'savings_percent'                  => 'Savings Percent',
                'warranty'                         => 'Warranty',
            ),

            'Recommended Information' => array(
                'delivery_time'                  => 'Delivery Time',
                'merchant_product_category_path' => 'Merchant Product Category Path',
                'alternate_image_four'           => 'Alternate Image Four',
                'delivery_cost'                  => 'Delivery Cost',
                'stock_quantity'                 => 'Stock Quantity',
                'size'                           => 'Size',
                'suitable_for'                   => 'Suitable For',
                'colour'                         => 'Colour',
                'language'                       => 'Language',
                'alternate_image_two'            => 'Alternate Image Two',
                'ean'                            => 'EAN',
                'brand_name'                     => 'Brand Name',
                'last_updated'                   => 'Last Updated',
                'merchant_thumb'                 => 'Merchant Thumb',
                'pre_order'                      => 'Pre Order',
                'store_price'                    => 'Store Price',
                'in_stock'                       => 'In Stock',
                'alternate_image_three'          => 'Alternate Image Three',
                'specifications'                 => 'Specifications',
                'mpn'                            => 'MPN',
                'condition'                      => 'Condition',
                'product_price_old'              => 'Product Price Old',
                'material'                       => 'Material',
                'alternate_image'                => 'Alternate Image',
                'web_offer'                      => 'Web Offer',
                'merchant_category'              => 'Merchant Category',
                'model_number'                   => 'Model Number',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'product_id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_name',
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
                'attr'     => 'image_url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'deep_link',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
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
                'attr'     => 'currency',
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
