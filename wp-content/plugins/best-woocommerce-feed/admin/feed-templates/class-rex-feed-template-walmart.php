<?php
/**
 * The Walmart Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Walmart feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Walmart
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Walmart extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'Product ID Type' => 'Product ID Type',
                'Product ID' => 'Product ID',
                'SKU' => 'SKU',
                'Price Currency' => 'Price Currency',
                'Price Amount' => 'Price Amount',
                'Shipping Weight-Value' => 'Shipping Weight-Value',
                'Shipping Weight-Units' => 'Shipping Weight-Units',
                'Category' => 'Category',
                'Sub-category' => 'Sub-category',
            )
        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'Product ID Type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Product ID',
                'type' => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'SKU',
                'type' => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Price Currency',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Price Amount',
                'type' => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ),
            array(
                'attr' => 'Shipping Weight-Value',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ),
            array(
                'attr' => 'Shipping Weight-Units',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ),
            array(
                'attr' => 'Category',
                'type' => 'meta',
                'meta_key' => 'product_cats_path',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ),
            array(
                'attr' => 'Sub-category',
                'type' => 'meta',
                'meta_key' => 'product_subcategory',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            )
        );
    }

}

