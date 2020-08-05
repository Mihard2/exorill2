<?php

/**
 * The Google Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for google feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Google
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Google_local_products extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'itemid'                       => 'Product Id [id]',
                'title'                    => 'Product Title [title]',
                'description'              => 'Product Description [description]',
                'image_link'               => 'Main Image [image_link]',
                'condition'                => 'Condition [condition]',
                'google_product_category'  => 'Google Product Category [google_product_category]',
                'webitemid'     => 'Webitemid',
            ),
            'Required energy efficiency class attributes (EU only)' => array(
                'energy_efficiency_class' => 'Energy efficiency class',
                'energy_efficiency_class_min' => 'Energy efficiency class min',
                'energy_efficiency_class_max' => 'Energy efficiency class max',
            ),
            'Optional matching attributes' => array(
                'brand'             => 'Manufacturer [brand]',
                'gtin'              => 'GTIN [gtin]',
                'mpn'               => 'MPN [mpn]',
            ),
            'Optional pricing attributes' => array(
                'price'                     => 'Regular Price [price]',
                'sale_price'                => 'Sale Price [sale_price]',
                'sale_price_effective_date' => 'Sale Price Effective Date [sale_price_effective_date]',
                'unit_pricing_measure' => 'Unit pricing measure',
                'unit_pricing_base_measure' => 'Unit pricing base measure',
            ),
            'Optional' => array(
                'pickup_method' => 'Pickup method',
                'pickup_SLA' => 'Pickup SLA',
                'pickup_link_template' => 'Pickup link template',
                'mobile_pickup_link_template' => 'Mobile pickup link template',
                'link_template' => 'Link template',
                'mobile_link_template' => 'Mobile link template',
                'ads_redirect' => 'Ads redirect',
            )
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'itemid',
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
        );
    }

}
