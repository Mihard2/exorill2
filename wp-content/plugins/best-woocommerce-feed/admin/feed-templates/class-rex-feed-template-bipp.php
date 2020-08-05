<?php

/**
 * The Bipp Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Bipp feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Bipp
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Bipp extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'CatalogueNumber'   => 'Catalogue Number',
            ),

            'Recommended Information' => array(
                'available'                => 'Available',
                'BIPPPRice'                => 'BIPPPRice',
                'CataloguePrice'           => 'Catalogue Price',
                'DeliveryTime'             => 'Delivery Time',
                'Description'              => 'Description',
                'EANNumber'                => 'EAN Number',
                'ManufacturerName'         => 'Manufacturer Name',
                'Name'                     => 'Name',
                'PhotoURL'                 => 'Photo URL',
                'ProvideLicense'           => 'Provide License',
                'SupplierClassification'   => 'Supplier Classification',
                'SupplierStockCondition'   => 'Supplier Stock Condition',
                'UNSPSCCode'               => 'UNSPSC Code',
                'Unit'                     => 'Unit',
                'VAT'                      => 'VAT',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'CatalogueNumber',
                'type'     => 'meta',
                'meta_key' => 'CatalogueNumber',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
