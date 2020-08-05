<?php

/**
 * The logicsale Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for logicsale feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Logicsale
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Logicsale extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'sku'                        => 'SKU',
                'product-id'                 => 'Product id',
                'product-id-type'            => 'Product id type',
                'title'                      => 'Title',
                'quantity'                   => 'Quantity',
                'item-condition'             => 'Item Condition',
                'will-ship-internationally'  => 'Will Ship Internationally',

            ),

            'Additional Information' => array(
                'linked-sku'                         => 'Linked SKU',
                'initial-price-on-system'            => 'Initial Price on System',
                'delete-item'                        => 'Delete Item',
                'custom-shipping'                    => 'Custom Shipping',
                'item-note'                          => 'Item Note',
                'seller-skipped-list'                => 'Seller Skipped List',
                'seller-skipped-list-mode'           => 'Seller Skipped List Mode',
                'seller-skipped-by-rating-percent'   => 'Seller Skipped by Rating Percent',
                'seller-skipped-by-rating-per-year'  => 'Seller Skipped by Rating per year',
                'info-item-is-fba'                   => 'Info Item is fba',
                'info-my-totalprice'                 => 'Info my Total price',
                'info-lowest-compi-totalprice'       => 'Info Lowest compi Total price',
                'info-difference'                    => 'Info Difference',
                'info-compi-name'                    => 'Info compi Name',
                'info-ean'                           => 'Info EAN',
                'bbc-active'                         => 'BBC Active',
                'bbc-strategy'                       => 'BBC Strategy',
                'use-individual-price-gap'           => 'Use Individual Price Gap',
                'bbc-custom-no'                      => 'BBC custom no',
                'bbc-custom-yes'                     => 'BBC Custom yes',
            ),

            'Recommended Information' => array(
                'min-price'           => 'Min Price',
                'max-price'           => 'Max Price',
                'stand-alone-price'   => 'Stand Alone Price',
                'price-gap'           => 'Price Gap',
                'optimization-active' => 'Optimization Active',
                'fixed-price'         => 'Fixed Price',
                'fixed-price-active'  => 'Fixed Price Active',
                'leadtime-to-ship'    => 'Leadtime to Ship',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product-id',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product-id-type',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'item-condition',
                'type'     => 'meta',
                'meta_key' => 'condition',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'will-ship-internationally',
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
