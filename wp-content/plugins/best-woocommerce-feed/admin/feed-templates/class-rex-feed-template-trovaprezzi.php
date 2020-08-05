<?php

/**
 * The Uvinum Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      5.5
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for trovaprezzi feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Trovaprezzi
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Trovaprezzi extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'      =>  array(
                'Categories'            => 'Product Categories',
                'Image'                 => 'Image Link',
                'Internal_Code'         => 'Internal Code',
                'Code'                  => 'Code',
                'Link'                  => 'Product URL',
                'Name'                  => 'Product Name',
                'RetailPrice'           => 'Retail price',
                'SellingPrice'          => 'Selling Price',
                'Price'                 => 'Price',
                'ShippingCost'          => 'Shipping Cost',
                'Brand'  => 'Brand',
                'Description'  => 'Description',
                'Availability'  => 'Availability',
                'Manafacturer_Code'  => 'Manufacturer Code',
                'EanCode'  => 'Ean Code',
                'Weight'  => 'Weight',
                'PartNumber'  => 'Part Number',
            ),

            'Recommended Information'      =>  array(
                'OriginalPrice'         => 'Original Price',
                'Size'         => 'Size',
                'Color'         => 'Color',
                'Imag2'         => 'Image 2',
                'Imag3'         => 'Image 3',
                'Imag4'         => 'Image 4',
                'Imag5'         => 'Image 5',
            ),

            'Additional Information'    => array(
                'Stock'  => 'Stock',
                'Width'  => 'Width',
                'Height'  => 'Height',
                'Additional_Image_Link'  => 'Additional Image Link',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Code',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Name',
                'type'     => 'meta',
                'meta_key' => 'title',
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
            array(
                'attr'     => 'Categories',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Image',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Link',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'RetailPrice',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SellingPrice',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ShippingCost',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Brand',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => '',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Availability',
                'type'     => 'meta',
                'meta_key' => 'availability',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => '',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'EanCode',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => '',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Manafacturer_Code',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => '',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PartNumber',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => '',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Weight',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => '',
                'limit'    => 0,
            ),

        );
    }

}
