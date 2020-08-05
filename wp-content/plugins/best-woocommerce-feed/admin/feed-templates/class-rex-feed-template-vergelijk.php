<?php


/**
 *
 * Defines the attributes and template for vergelijk feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Vergelijk
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Vergelijk extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'              =>  array(
                'product_name'                  => 'Product name',
                'shop_reference'                => 'Shop Reference',
                'shop_category'                 => 'Shop Category',
                'brand'                         => 'Product Brand',
                'price'                         => 'Product Price',
                'deep_link'                     => 'Deeplink',
                'delivery_time'                 => 'Delivery Time',
                'shipping_method'               => 'Shipping method',
                'delivery_price'                => 'Delivery price',
                'country_code'                  => 'Service Country Code',
            ),

            'Additional Information'            => array(
                'identifier_value'              => 'Identifier value',
                'identifier_type'               => 'Identifier type',
                'features_name'                 => 'Features name',
                'features_value'                => 'Features value',
                'promotional_text'              => 'Promotional text',
                'media_type'                    => 'Media type',
                'media_url'                     => 'Media url',
                'stock_status'                  => 'Stock status',
                'number_of_products_in_stock'   => 'Number of products in stock',
                'shipping_country_code'         => 'Shipping country code',
                'shipping_description'          => 'Shipping description',
                'service_name'                  => 'Service name',
                'service_price'                 => 'Service price',
                'service_type'                  => 'Service type',
                'shop_offer_id'                 => 'Shop offer id',
                'product_description'           => 'Product description',
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
                'attr'     => 'shop_reference',
                'type'     => 'meta',
                'meta_key' => 'shop_reference',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shop_category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'brand',
                'type'     => 'meta',
                'meta_key' => '',
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
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'deep_link',
                'type'     => 'meta',
                'meta_key' => 'deep_link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'delivery_time',
                'type'     => 'static',
                'meta_key' => '5 days',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping_method',
                'type'     => 'static',
                'meta_key' => 'method',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'delivery_price',
                'type'     => 'meta',
                'meta_key' => 'delivery_price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'country_code',
                'type'     => 'meta',
                'meta_key' => 'country_code',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
        );
    }

}
