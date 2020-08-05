<?php

/**
 * The Webgains Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Webgains feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Webgains
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Webgains extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'product_name'     => 'Product Name',
                'product_id'       => 'Product ID',
                'description'      => 'Description',
                'category_name'    => 'Category Name',
                'deeplink'         => 'Deeplink',
                'image_url'        => 'Image URL',
                'price'            => 'Price',
            ),

            'Recommended Information' => array(
                'delivery_cost'                 => 'Delivery Cost',
                'delivery_period'               => 'Delivery Period',
                'image_thumbnail_url'           => 'Image Thumbnail Url',
                'manufacturer'                  => 'Manufacturer',
                'manufacturers_product_number'  => 'Manufacturers Product Number',
            ),

            'Optional Information' => array(
                'baseprice'               => 'Baseprice',
                'certifications'          => 'Certifications',
                'currency'                => 'Currency',
                'destination'             => 'Destination',
                'european_article_number' => 'European Article Number',
                'in_stock'                => 'In Stock',
                'keywords'                => 'Keywords',
                'merchant_category_id'    => 'Merchant Category Id',
                'normal_price'            => 'Normal Price',
                'payment_methods'         => 'Payment Methods',
                'short_description'       => 'Short Description',
                'voucher_code'            => 'Voucher Code',
                'voucher_discount'        => 'Voucher Discount',
                'voucher_price'           => 'Voucher Price',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
                'attr'     => 'deeplink',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'category_name',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
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


        );
    }

}
