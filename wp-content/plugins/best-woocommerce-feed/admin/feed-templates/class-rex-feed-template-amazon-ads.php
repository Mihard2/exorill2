<?php

/**
 * The Amazon Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Amazon feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Amazon
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Amazon extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'category'      => 'Category',
                'title'         => 'Product Title',
                'link'          => 'Product URL',
                'price'         => 'Price',
                'sku'           => 'SKU',
            ),

            'Additional Information'    => array(
                'brand'                 => 'Brand',
                'upc'                   => 'UPC / EAN',
                'image'                 => 'Image Url',
                'description'           => 'Description',
                'mpn'                   => 'Manufacturer Part Number',
                'shipping_cost'         => 'Shipping Cost',
                'age'                   => 'Age',
                'bullet_point1'         => 'Bullet point1',
                'bullet_point2'         => 'Bullet point2',
                'bullet_point3'         => 'Bullet point3',
                'bullet_point4'         => 'Bullet point4',
                'bullet_point5'         => 'Bullet point5',
                'height'                => 'Height',
                'item_package_quantity' => 'Item package quantity',
                'Keywords1'             => 'Keywords1',
                'Keywords2'             => 'Keywords2',
                'Keywords3'             => 'Keywords3',
                'Keywords4'             => 'Keywords4',
                'Keywords5'             => 'Keywords5',
                'length'                => 'Length',
                'model_number'          => 'Model Number',
                '0ther_image_url1'      => 'Other image-url1',
                '0ther_image_url2'      => 'Other image-url2',
                '0ther_image_url3'      => 'Other image-url3',
                '0ther_image_url4'      => 'Other image-url4',
                '0ther_image_url5'      => 'Other image-url5',
                '0ther_image_url6'      => 'Other image-url6',
                '0ther_image_url7'      => 'Other image-url7',
                '0ther_image_url8'      => 'Other image-url8',
                'recommended_browse_node'=> 'Recommended Browse Node',
                'shipping_weight'       => 'Shipping Weight',
                'weight'                => 'Weight',
                'width'                 => 'Width',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
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
            array(
                'attr'     => 'image',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
