<?php

/**
 * The Bloomville Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Bloomville feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Bloomville
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Bloomville extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'Title'            => 'Product Title',
                'Code'             => 'Code',
                'Language'         => 'Language',
                'PriceBase'        => 'Price Base',
                'PriceVat'         => 'Price Vat',
            ),

            'Additional Information' => array(
                'CertValue'                => 'Cert Value',
                'CourseFormat'             => 'Course Format',
                'Delivery'                 => 'Delivery',
                'DescriptionLong'          => 'Description Long',
                'Goals'                    => 'Goals',
                'Level'                    => 'Level',
                'NextSteps'                => 'Next Steps',
                'PriceArrFacHighBase'      => 'Price Arr Fac High Base',
                'PriceArrFacHighVat'       => 'Price Arr Fac High Vat',
                'PriceArrFacHighVatFree'   => 'Price Arr Fac High Vat Free',
                'PriceArrFacLowBase'       => 'Price Arr Fac Low Base',
                'PriceArrFacLowVat'        => 'Price Arr Fac Low Vat',
                'PriceArrFacLowVatFree'    => 'Price Arr Fac Low Vat Free',
                'PriceExamBase'            => 'Price Exam Base',
                'PriceExamVat'             => 'Price Exam Vat',
                'PriceExamVatFree'         => 'Price Exam Vat Free',
                'PriceGroup'               => 'Price Group',
                'PriceMaterialHighBase'    => 'Price Material High Base',
                'PriceMaterialHighVat'     => 'Price Material High Vat',
                'PriceMaterialHighVatFree' => 'Price Material High Vat Free',
                'PriceMaterialLowBase'     => 'Price Material Low Base',
                'PriceMaterialLowVat'      => 'Price Material Low Vat',
                'PriceMaterialLowVatFree'  => 'Price Material Low Vat Free',
                'PriceOvernightBase'       => 'Price Overnight Base',
                'PriceOvernightVat'        => 'Price Overnight Vat',
                'PriceOvernightVatFree'    => 'Price Overnight Vat Free',
                'StartLevel'               => 'Start Level',
                'Subjects'                 => 'Subjects',
                'TargetAudience'           => 'Target Audience',
            ),

            'Recommended Information' => array(
                'DateAvailableFrom'   => 'DateAvailable From',
                'DateAvailableTill'   => 'DateAvailable Till',
                'Description'         => 'Description',
                'Duration'            => 'Duration',
                'PriceDate'           => 'Price Date',
                'PriceEnrolBase'      => 'Price Enrol Base',
                'PriceEnrolVat'       => 'Price Enrol Vat',
                'PriceEnrolVatFree'   => 'Price Enrol Vat Free',
                'PriceVatFree'        => 'Price Vat Free',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Title',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Code',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Language',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PriceBase',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PriceVat',
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
