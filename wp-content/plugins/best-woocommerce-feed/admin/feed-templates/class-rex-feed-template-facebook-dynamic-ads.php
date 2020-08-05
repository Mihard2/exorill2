<?php

/**
 * The facebook_dynamic_ads marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Facebook Dynamic Ads for Real Estate marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_facebook_dynamic_ads
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Facebook_dynamic_ads extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'home_listing_id'      => 'Home Listing Id',
                'name'                 => 'Name',
                'description'          => 'Description',
                'image'                => 'Image',
                'url'                  => 'Image Url',
                'tag'                  => 'Image Tag',
                'url'                  => 'Url',
                'price'                => 'Price',
                'num_beds'             => 'Number of Beds',
                'num_baths'            => 'Number of Baths',
                'num_units'            => 'Number of Units',
                'neighborhood'         => 'Neighborhood',
                'latitude'             => 'Latitude',
                'longitude'            => 'Longitude',
                'applink'              => 'Applink',
            ),
            'Type of Property' => array(
                'property_type'        => 'Type of Property',
                'apartment'            => 'Apartment',
                'condo'                => 'Condo',
                'house'                => 'House',
                'land'                 => 'Land',
                'manufactured'         => 'Manufactured',
                'other'                => 'Other',
                'townhouse'            => 'townhouse',
            ),
            'Type of Listing' => array(
                'for_rent_by_agent'        => 'For Rent By Agent',
                'for_rent_by_owner'        => 'For Rent By Owner',
                'for_sale_by_agent'        => 'For Sale By Agent',
                'for_sale_by_owner'        => 'For Sale By Owner',
                'foreclosed'               => 'Foreclosed',
                'new_construction'         => 'New Construction',
                'new_listing'              => 'New Listing',
            ),
            'Listing is Availability' => array(
                'for_rent_by_agent'        => 'For Rent By Agent',
                'for_rent_by_owner'        => 'For Rent By Owner',
                'for_sale_by_agent'        => 'For Sale By Agent',
                'for_sale_by_owner'        => 'For Sale By Owner',
                'foreclosed'               => 'Foreclosed',
                'new_construction'         => 'New Construction',
                'new_listing'              => 'New Listing',
            ),
            'Address Listing' => array(
                'availability'             => 'Availability',
                'for_sale'                 => 'For Sale',
                'for_rent'                 => 'For Rent',
                'sale_pending'             => 'Sale Pending',
                'recently_sold'            => 'Recently Sold',
                'off_market'               => 'Off Market',
                'available_soon'           => 'Available Soon',
            ),
        );

    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'home_listing_id',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
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
                'attr'     => 'image',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'tag',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'url',
                'type'     => 'meta',
                'meta_key' => 'link',
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
                'attr'     => 'num_beds',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'num_baths',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'num_units',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'neighborhood',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'latitude',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'longitude',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'applink',
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
