<?php

/**
 * The joblift marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */
/**
 *
 * Defines the attributes and template for joblift marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Joblift
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Joblift extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'title'            => 'Title',
                'url'              => 'Url',
                'id'               => 'ID',
                'fullDescription'  => 'Full Description',
                'company'          => 'Company',
                'location_city'    => 'Location City',
                'location_country' => 'Location Country',
                'location_zip'     => 'location Zip',
            ),

            'Recommended Information' => array(
                'employmentTypes'     => 'Employment Types',
                'location_address'    => 'Location Address',
                'publishDate'         => 'Publish Date',
                'workingTimes'        => 'Working Times',
            ),

            'Optional Information' => array(
                'contact_address'          => 'contact_address',
                'contact_city'             => 'contact_city',
                'contact_country'          => 'contact_country',
                'contact_email'            => 'contact_email',
                'contact_fax'              => 'contact_fax',
                'contact_person'           => 'contact_person',
                'contact_phone'            => 'contact_phone',
                'contact_website'          => 'contact_website',
                'contact_zip'              => 'contact_zip',
                'description_application'  => 'description_application',
                'description_candidate'    => 'description_candidate',
                'description_conditions'   => 'description_conditions',
                'description_employer'     => 'description_employer',
                'description_job'          => 'description_job',
                'industries'               => 'industries',
                'keywords'                 => 'keywords',
                'location_district'        => 'location_district',
                'location_geo_lat'         => 'location_geo_lat',
                'location_geo_lon'         => 'location_geo_lon',
                'location_state'           => 'location_state',
                'partnerDisplayName'       => 'partnerDisplayName',
                'pricing_account'          => 'pricing_account',
                'pricing_budget'           => 'pricing_budget',
                'pricing_cpc'              => 'pricing_cpc',
                'pricing_cpcCategory'      => 'pricing_cpcCategory',
                'pricing_currency'         => 'pricing_currency',
                'referenceId'              => 'referenceId',
                'salary_benefits'          => 'salary_benefits',
                'salary_currency'          => 'salary_currency',
                'salary_from'              => 'salary_from',
                'salary_full'              => 'salary_full',
                'salary_period'            => 'salary_period',
                'salary_to'                => 'salary_to',
                'source'                   => 'source',
                'viaAgency'                => 'viaAgency',
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
                'attr'     => 'url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
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
                'attr'     => 'company',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),


            array(
                'attr'     => 'location_city',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'location_country',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'location_zip',
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
