<?php

/**
 * The Pixmania Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      5.5
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for pixmania feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Pixmania
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Pixmania extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'name' => 'Product name',
                'gtin' => 'Gtin',
                'brand' => 'Brand',
                'description' => 'Description',
                'application_category_external_ids' => 'Application category external ids',
                'primary_image' => 'Primary image',
                'language' => 'Language'
            ),
            'Auditional Information' => array(
                'external_id' => 'External id',
                'application_categories' => 'Application categories',
                'images' => 'Images',
                'gender' => 'Gender',
                'keywords' => 'Keywords',
                'made_in' => 'Made in',
                'composition' => 'Composition',
                'product_care' => 'Product_care',
                'item_height' => 'Item height',
                'item_length' => 'Item length',
                'item_weight' => 'Item weight',
                'item_width' => 'Item width',
                'manufacturer' => 'Manufacturer',
                'package_height' => 'Package height',
                'package_length' => 'Package length',
                'package_weight' => 'Package weight',
                'package_width' => 'Package width',
                'details' => 'Details',
                'condition' => 'Condition',
                'smartphone_grade' => 'Smartphone grade',
                'product_state' => 'Product state',
                'exist_any' => 'Exist any',
            )
        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'name',
                'type' => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'gtin',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'brand',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'description',
                'type' => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'application_category_external_ids',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'primary_image',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'language',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),

        );
    }

}