<?php

/**
 * The Cj affiliate Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Cj affiliate feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Cj_affiliate
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Cj_affiliate extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'name'         => 'Product Name',
                'description'  => 'Description',
                'availability' => 'Availability',
                'order'        => 'Order',
                'keywords'     => 'Keywords',
                'price'        => 'Price',
                'sku'          => 'SKU',
            ),

            'Additional Information' => array(
                'aid'                  => 'AID',
                'cid'                  => 'CID',
                'condition'            => 'Condition',
                'currency'             => 'Currency',
                'imageurl'             => 'Image URL',
                'instock'              => 'In Stock',
                'promotionaltext'      => 'Promotional Text',
                'retailprice'          => 'Retail Price',
                'saleprice'            => 'Sale Price',
                'standardshippingcost' => 'Standard Shipping Cost',
                'subid'                => 'SubI',
                'subid'                => 'SubID',
            ),

            'Recommended Information' => array(
                'advertisercategory'  => 'Advertiser Category',
                'isbn'                => 'ISBN',
                'manufacturer'        => 'Manufacturer',
                'manufacturerid'      => 'Manufacturer ID',
                'upc'                 => 'UPC',
            ),
            
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'name',
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
                'attr'     => 'order',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'keywords',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'sku',
                'type'     => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
