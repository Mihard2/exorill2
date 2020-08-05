<?php
/**
 * The Winesearcher Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Winesearcher feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Winesearcher
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Winesearcher extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'Deeplink' => 'Deeplink',
                'Price' => 'Price',
                'Unit_size' => 'Unit_size',
                'Vintage' => 'Vintage',
                'WineName' => 'WineName',
            )
        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'Deeplink',
                'type' => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'cdata',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Price',
                'type' => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Unit_size',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'Vintage',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'WineName',
                'type' => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            )
        );
    }

}

