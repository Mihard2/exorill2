<?php

/**
 * The Google Adwords Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for google adwords feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Google_Ad
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Google_Ad extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'ID'               => 'ID',
                'Item title'       => 'Product Title',
                'Final URL'        => 'Final URL',
            ),

            'Additional Information' => array(
                'ID2'                => 'ID2',
                'Item address'       => 'Item address',
                'Tracking template'  => 'Tracking template',
                'Custom parameter'   => 'Custom parameter',
            ),

            'Recommended Information' => array(
                'Image URL'           => 'Image URL',
                'Item subtitle'       => 'Item subtitle',
                'Item description'    => 'Item description',
                'Item Category'       => 'Item Category',
                'Price'               => 'Price',
                'Sale Price'          => 'Sale Price',
                'Formatted price'     => 'Formatted price',
                'Formatted sale price'=> 'Formatted sale price',
                'Contextual keywords' => 'Contextual keywords',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Item title',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Final URL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
