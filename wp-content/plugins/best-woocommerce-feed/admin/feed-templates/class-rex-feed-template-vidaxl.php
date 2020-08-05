<?php

/**
 * The VidaXL Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for VidaXL feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_VidaXL
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_VidaXL extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'CategoryIdentifier' => 'CategoryIdentifier',
                'EAN'                => 'EAN',
                'title'              => 'Title',
                'ProductID'          => 'ProductID',
                'Brand'              => 'Brand',
                'ShortDescription'   => 'ShortDescription',
                'Description'        => 'Description',
                'MainWhiteImage'     => 'MainWhiteImage',
                'state'              => 'State',
                'shippingtime'       => 'Shippingtime',
                'quantity'           => 'Quantity',
                'price'              => 'Price',
                'product-id-type'    => 'Product Id Type',
                'product-id'         => 'Product Id',
                'sku'                => 'Sku',
            ),

            'Optional Information' => array(
                'Specification'           => 'Specification',
                'Separator'               => 'Separator',
                'MainMoodImage'           => 'MainMoodImage',
                'Gallery1'                => 'Gallery1',
                'Gallery2'                => 'Gallery2',
                'Gallery3'                => 'Gallery3',
                'Gallery4'                => 'Gallery4',
                'Gallery5'                => 'Gallery5',
                'Gallery6'                => 'Gallery6',
                'Gallery7'                => 'Gallery7',
                'Gallery8'                => 'Gallery8',
                'Gallery9'                => 'Gallery9',
                'Gallery10'                => 'Gallery10',
                'size'                    => 'Product size',
                'color'                   => 'Product color',
                'material'                => 'Product material',
                'weight'                  => 'Product weight',
                'quantity'                => 'Product quantity',
                'value'                   => 'Energy label value',
                'Min-quantity-alert'      => 'Min quantity alert',
                'Available-start-date'    => 'Available  Date',
                'Available-end-date'      => 'Available End Date',
                'Favorite rank'           => 'Favorite rank',
                'Discount-price'          => 'Discount Price',
                'Discount-start-date'     => 'Discount Start Date',
                'Discount End Date'       => 'Discount End Date',
                'Leadtime-to-ship'        => 'Leadtime To Ship',
                'Update-delete'           => 'Update Delete',
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
                'attr'     => 'EAN',
                'type'     => 'meta',
                'meta_key' => 'EAN',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'MainWhiteImage',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
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
                'attr'     => 'ProductID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
