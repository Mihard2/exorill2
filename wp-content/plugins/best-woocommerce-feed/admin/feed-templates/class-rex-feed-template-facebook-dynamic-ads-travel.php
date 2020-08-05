<?php

/**
 * The Facebook dynamic ads for travel marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Facebook dynamic ads for travel marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Facebook_dynamic_ads_travel
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Facebook_dynamic_ads_travel extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'origin_airport'      => 'origin_airport',
                'destination_airport' => 'destination_airport',
                'url'                  => 'Image Url',
            ),
            'Hotel Information' => array(
                'hotel_id'      => 'hotel_id',
                'name'          => 'name',
                'neighborhood'  => 'neighborhood',
                'url'           => 'House',
                'latitude'      => 'latitude',
                'longitude'     => 'longitude',
                'brand'         => 'brand',
                'base_price'    => 'base_price',
                'description'   => 'description',
            ),
            'Destinations Listing' => array(
                'destination_id'        => 'destination_id',
                'name	'               => 'name',
                'latitude'              => 'latitude',
                'longitude'             => 'longitude',
                'type'                  => 'type',
                'url'                   => 'url',
            ),
        );

    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'origin_airport',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'destination_airport',
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

        );
    }

}
