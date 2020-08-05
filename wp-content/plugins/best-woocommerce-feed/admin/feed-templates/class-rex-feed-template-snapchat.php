<?php

/**
 * The Snapchat Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Snapchat feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Snapchat
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Snapchat extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'id'                => 'ID',
                'title'             => 'Title',
                'description'       => 'Description',
                'link'              => 'Link',
                'image_link'        => 'Image Link',
                'availability'      => 'Availability',
                'price'             => 'Price',
                'currency'          => 'Currency',
                'condition'         => 'Condition',
            ),

            'Additional Information' => array(
                'icon_media_url'    => 'Icon Media Url',
                'ios_app_name'      => 'IOS App Name',
                'ios_app_store_id'  => 'IOS App Store ID',
                'ios_url'           => 'IOS URL',
                'android_app_name'  => 'Android App Name',
                'android_package'   => 'Android Package',
                'android_url'       => 'Android URL',
                'mobile_link'       => 'Mobile Link',
            ),

            'Recommended Information' => array(
                'sale_price_effective_date'     => 'Sale Price Effective Date',
                'sale_price'                    => 'Sale Price',
                'additional_image_link'         => 'Additional Image Link',
                'brand'                         => 'Brand',
                'gtin'                          => 'GTIN',
                'mpn'                           => 'MPN',
                'age_group'                     => 'Age Group',
                'color'                         => 'Color',
                'gender'                        => 'Gender',
                'item_group_id'                 => 'Item Group ID',
                'google_product_category'       => 'Google Product Category',
                'product_type'                  => 'Product Type',
                'adult'                         => 'Adult',
                'custom_label'                  => 'Custom Label',
                'custom_label_1'                => 'Custom Label-1',
                'custom_label_2'                => 'Custom Label-2',
                'custom_label_3'                => 'Custom Label-3',
                'custom_label_4'                => 'Custom Label-4',
                'size'                          => 'Size',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
                'attr'     => 'description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'link',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'image_link',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
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
                'attr'     => 'currency',
                'type'     => 'meta',
                'meta_key' => 'currency',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'condition',
                'type'     => 'meta',
                'meta_key' => 'condition',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
