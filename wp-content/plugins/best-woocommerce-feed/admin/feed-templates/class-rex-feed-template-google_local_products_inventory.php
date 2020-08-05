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
class Rex_Feed_Template_Google_local_products_inventory extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'store_code'                       => 'Store code',
                'id'                    => 'Product id',
                'quantity'                    => 'Quantity',
                'price'                     => 'Price',
            ),
            'Optional' => array(
                'sale_price'                => 'Sale Price [sale_price]',
                'sale_price_effective_date' => 'Sale Price Effective Date [sale_price_effective_date]',
                'availability' => 'Availability',
                'pickup_method' => 'Pickup method',
                'pickup_sla' => 'Pickup SLA',
            )
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'store_code',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
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
                'attr'     => 'quantity',
                'type'     => 'meta',
                'meta_key' => 'quantity',
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
        );
    }

}
