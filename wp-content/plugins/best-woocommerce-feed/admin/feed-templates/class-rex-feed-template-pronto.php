<?php

/**
 * The pronto Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for pronto feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Pronto
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Pronto extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'            => 'Product Title',
                'description'      => 'Description',
                'SalePrice'        => 'Sale Price',
                'URL'              => 'URL',
                'Category'         => 'Category',
                'Condition'        => 'Condition',

            ),

            'Additional Information' => array(
                'ShortTitle'         => 'ShortTitle',
                'Color'              => 'Color',
                'Size'               => 'Size',
                'Attributes'         => 'Attributes',
                'Keywords'           => 'Keywords',
                'Brand'              => 'Brand',
                'Manufacturer'       => 'Manufacturer',
                'ArtistAuthor'       => 'Artist Author',
                'RetailPrice'        => 'Retail Price',
                'SpecialOffer'       => 'Special Offer',
                'CouponText'         => 'Coupon Text',
                'CouponCode'         => 'Coupon Code',
                'InStock'            => 'In Stock',
                'InventoryCount'     => 'Inventory Count',
                'Bundle'             => 'Bundle',
                'ReleaseDate'        => 'Release Date',
                'ProntoCategoryID'   => 'Pronto Category ID',
                'MobileURL'          => 'Mobile URL',
                'ImageURL'           => 'Image URL',
                'ShippingCost'       => 'Shipping Cost',
                'ShippingWeight'     => 'Shipping Weight',
                'ZipCode'            => 'Zip Code',
                'EstimatedShipDate'  => 'Estimated Ship Date',
                'ProductBid'         => 'Product Bid',
                'ProductSKU'         => 'Product SKU',
                'ISBN'               => 'ISBN',
                'UPC'                => 'UPC',
                'EAN'                => 'EAN',
                'MPN'                => 'MPN',
                'SaleRank'           => 'Sale Rank',
                'Product Highlights' => 'ProductHighlights',
                'AltImage0'          => 'AltImage0',
                'AltImage1'          => 'AltImage1',
                'AltImage2'          => 'AltImage2',
                'AltImage3'          => 'AltImage3',
                'AltImage4'          => 'AltImage4',
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
                'attr'     => 'SalePrice',
                'type'     => 'meta',
                'meta_key' => 'sale_price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'URL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Category',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Condition',
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
