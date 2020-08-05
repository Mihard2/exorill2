<?php

/**
 * The Become Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.7
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for become feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_become
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Become extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'     =>  array(
                'Label'                 => 'Product Title',
                'Offer Url'             => 'Product URL',
                'Prices'                => 'Price',
                'Image Url'             => 'Image URL',
                'Merchant Category'     => 'Category',
                'Description'           => 'Product Description',
            ),

            'Additional Information' => array(
                'Product Id'            => 'Product ID',
                'MFPN'                  => 'Mfr Part',
                'UPC'                   => 'UPC (Universal Product Code)',
                'ISBN'                  => 'ISBN',
                'Asin'                  => 'ASIN(alphanumeric Amazon stock number)',
                'Delivery Period'       => 'Delivery Period',
                'Delivery Charge'       => 'Delivery Cost',
                'Delivery Period Text'  => 'Delivery Period Text',
                'Manufacturer'          => 'Manufacturer',
                'Old Prices'            => 'Old Prices',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Label',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Offer Url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Prices',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Image Url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Merchant Category',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
