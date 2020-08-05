<?php

/**
 * The lyst marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */
/**
 *
 * Defines the attributes and template for lyst marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Lyst
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Lyst extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'additional_image_link' => 'Additional Image Link',
                'availability'          => 'Availability',
                'brand'                 => 'Brand',
                'color'                 => 'Color',
                'description'           => 'Description',
                'gender'                => 'Gender',
                'gtin'                  => 'Gtin',
                'id'                    => 'Id',
                'image_link'            => 'Image Link',
                'item_group_id'         => 'Item Group Id',
                'link'                  => 'Link',
                'price'                 => 'Price',
                'product_video_link'    => 'Product Video Link',
                'shipping'              => 'Shipping',
                'size'                  => 'Size',
                'sizing_schema'         => 'Sizing Schema',
                'title'                 => 'Title',
            ),
            'Recommended Information' => array(
                'size_system'          => 'Size System',
                'size_type'            => 'Size Type',
            ),

            'Optional Information' => array(
                'affiliate_link'          => 'Affiliate Link',
                'availability_date'       => 'Availability Date',
                'availability_units'      => 'Availability Units',
                'care_instructions'       => 'Care Instructions',
                'collection'              => 'Collection',
                'condition'               => 'Condition',
                'cross_sell_item_link'    => 'Cross sell Item Link',
                'cross_sell_items'        => 'Cross Sell Items',
                'cut'                     => 'Cut',
                'fit_details'             => 'Fit Details',
                'material'                => 'Material',
                'max_handling_time'       => 'Max Handling Time',
                'min_handling_time'       => 'Min Handling Time',
                'model_measurements'      => 'Model Measurements',
                'pattern'                 => 'Pattern',
                'product_type'            => 'Product Type',
                'promotion_id'            => 'Promotion Id',
                'raw_color'               => 'Raw Color',
                'sale_price'              => 'Sale Price',
                'sale_price_end_date'     => 'Sale Price End Date',
                'style'                   => 'Style',
                'tags'                    => 'Tags',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
                'attr'     => 'additional_image_link',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'brand',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'color',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'gender',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'gtin',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'image_link',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'item_group_id',
                'type'     => 'meta',
                'meta_key' => 'item_group_id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'link',
                'type'     => 'meta',
                'meta_key' => 'url',
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
                'attr'     => 'product_video_link',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shipping',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'size',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'sizing_schema',
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
