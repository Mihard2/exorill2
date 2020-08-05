<?php

/**
 * The Adtraction Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for adtraction feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Adtraction
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Adtraction extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'name'             => 'Product Name',
                'price'            => 'Price',
                'producturl'       => 'Product URL',
                'sku'              => 'SKU',
            ),

            'Additional Information' => array(
                'color'              => 'Color',
                'gender'             => 'Gender',
                'isbn'               => 'ISBN',
                'size'               => 'size',
            ),

            'Recommended Information' => array(
                'articlenumber'          => 'Article Number',
                'category'               => 'Category',
                'currency'               => 'Currency',
                'deliverytime'           => 'Delivery Time',
                'description'            => 'Description',
                'ean'                    => 'EAN',
                'imageurl'               => 'Image URL',
                'instock'                => 'In Stock',
                'manufacturer'           => 'Manufacturer',
                'oldprice'               => 'Old Price',
                'shipping'               => 'Shipping',
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
                'attr'     => 'producturl',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
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
