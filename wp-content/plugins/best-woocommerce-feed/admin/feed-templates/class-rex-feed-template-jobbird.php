<?php

/**
 * The Jobbird marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Jobbird marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Jobbird
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Jobbird extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'jobAddedDate'     => 'JobAddedDate',
                'jobDescription'   => 'JobDescription',
                'jobId'            => 'JobId',
                'jobTitle'         => 'JobTitle',
                'locationPlace'    => 'LocationPlace',
            ),

            'Optional Information' => array(
                'addressPlace'                => 'addressPlace',
                'addressStreet'               => 'addressStreet',
                'addressZipcode'              => 'addressZipcode',
                'alternativeJobId'            => 'alternativeJobId',
                'applicationUrl'              => 'applicationUrl',
                'branchName'                  => 'branchName',
                'branchPlace'                 => 'branchPlace',
                'contactEmail'                => 'contactEmail',
                'contactName'                 => 'contactName',
                'contactPhone'                => 'contactPhone',
                'contactUrl'                  => 'contactUrl',
                'contractDescription'         => 'contractDescription',
                'contractSalaryDescription'   => 'contractSalaryDescription',
                'contractType'                => 'contractType',
                'hoursDescription'            => 'hoursDescription',
                'hoursMax'                    => 'hoursMax',
                'hoursMin'                    => 'hoursMin',
                'hoursType'                   => 'hoursType',
                'jobCategory'                 => 'jobCategory',
                'jobEducation'                => 'jobEducation',
                'jobEmployerInfo'             => 'jobEmployerInfo',
                'jobUrl'                      => 'jobUrl',
                'mandatoryMotivation'         => 'mandatoryMotivation',
                'offerDescription'            => 'offerDescription',
                'requirementsCourses'         => 'requirementsCourses',
                'requirementsDescription'     => 'requirementsDescription',
                'requirementsExperience'      => 'requirementsExperience',
                'youtube'                     => 'youtube',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'jobAddedDate',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'jobDescription',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'jobId',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'jobTitle',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'locationPlace',
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
