<?php

/**
 * The Mydeal Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Mydeal feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Mydeal
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Mydeal extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'SKU'                           => 'SKU',
                'DealTitle'                     => 'DealTitle',
                'price'                         => 'Price',
                'CategoryID'                    => 'CategoryID',
                'ShippingCostCategory'          => 'ShippingCostCategory',
                'DeliveryTime'                  => 'DeliveryTime',
                'MaxDaysForDelivery'            => 'MaxDaysForDelivery',
                'ImageURL_1'                    => 'ImageURL 1',
                'Delivery_Details'              => 'Delivery Details',
                'Warranty_and_Returns_Policy'   => 'Warranty and Returns Policy',
            ),

            'Conditional Information' => array(
                'ProductGroupID'         => 'ProductGroupID',
                'Stock'                  => 'Stock',
                'ProductUnlimited'       => 'ProductUnlimited',
                'Description'            => 'Description',
                'Specification'          => 'Specification',
                'FlatRate'               => 'FlatRate',
                'OptionName_1'           => 'OptionName 1',
                'OptionValue_1'          => 'OptionValue 1',
                'OptionName_2'           => 'OptionName 2',
                'OptionValue_2'          => 'OptionValue 2',
                'OptionName_3'           => 'OptionName 3',
                'OptionValue_3'          => 'OptionValue 3',
                'RequestFreightQuote'    => 'RequestFreightQuote',
                'Show48Hour'             => 'Show48Hour',
                'ImageURL_2'             => 'ImageURL 2',
                'ImageURL_3'             => 'ImageURL 3',
            ),

            'Optional Information' => array(
                'RRP'                     => 'RRP',
                'GTIN'                    => 'GTIN',
                'MPN'                     => 'MPN',
                'Brand'                   => 'Brand',
                'Condition'               => 'Condition',
                'Tags'                    => 'Tags',
                'ShippingWeight'          => 'ShippingWeight',
                'ShippingLength'          => 'ShippingLength',
                'ShippingHeight'          => 'ShippingHeight',
                'ShippingWidth'           => 'ShippingWidth',
                'FreightSchemeID'         =>'FreightSchemeID',
                'RequestFreightQuote'     => 'RequestFreightQuote',
                'Show48Hour'              => 'Show48Hour',
                'ImageURL_2'              => 'ImageURL 2',
                'ImageURL_3'              => 'ImageURL 3',
                'ImageURL_4'              => 'ImageURL 4',
                'ImageURL_5'              => 'ImageURL 5',
                'ImageURL_6'              => 'ImageURL 6',
                'ImageURL_7'              => 'ImageURL 7',
                'ImageURL_8'              => 'ImageURL 8',
                'ImageURL_9'              => 'ImageURL 9',
                'ImageURL_10'              => 'ImageURL 10',
                'ImageURL_11'              => 'ImageURL 11',
                'ImageURL_12'              => 'ImageURL 12',
                'ImageURL_13'              => 'ImageURL 13',
                'ImageURL_14'              => 'ImageURL 14',
                'ImageURL_15'              => 'ImageURL 15',
                'ImageURL_16'              => 'ImageURL 16',
                'ImageURL_17'              => 'ImageURL 17',
                'ImageURL_18'              => 'ImageURL 18',
                'ImageURL_19'              => 'ImageURL 19',
                'ImageURL_20'              => 'ImageURL 20',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'DealTitle',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SKU',
                'type'     => 'meta',
                'meta_key' => 'SKU',
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
                'attr'     => 'CategoryID',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ShippingCostCategory',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'DeliveryTime',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'MaxDaysForDelivery',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ImageURL_1',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Delivery_Details',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array (
                'attr'     => 'Warranty_and_Returns_Policy',
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
