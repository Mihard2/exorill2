<?php

/**
 * The hertie marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */
/**
 *
 * Defines the attributes and template for hertie marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Hertie
 */
class Rex_Feed_Template_Hertie extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'Bestand'              => 'Bestand',
                'EAN'                  => 'EAN',
                'EK'                   => 'EK',
                'Marke'                => 'Marke',
                'MediaLink'            => 'MediaLink',
                'ParentSKU'            => 'ParentSKU',
                'Produktbeschreibung'  => 'Produktbeschreibung',
                'Produktname'          => 'Produktname',
                'SKU'                  => 'SKU',
                'UVP'                  => 'UVP',
                'VariantenAusfuehrung' => 'VariantenAusfuehrung',
                'Warengruppe'          => 'Warengruppe',
            ),
            'Recommended Information' => array(
                'Warnhinweis'         => 'Warnhinweis',
            ),
            'Optional Information' => array(
                'Gefahrgut'                 => 'Gefahrgut',
                'HerstellerArtikelnummer'   => 'HerstellerArtikelnummer',
                'Keywords'                  => 'Keywords',
                'Lieferzeit'                => 'Lieferzeit',
                'MWST'                      => 'MWST',
                'Packstuecke'               => 'Packstuecke',
                'Untertitel'                => 'Untertitel',
                'VPE'                       => 'VPE',
                'VerpackungBreite'          => 'VerpackungBreite',
                'VerpackungHoehe'           => 'VerpackungHoehe',
                'VerpackungLaenge'          => 'VerpackungLaenge',
                'Versandart'                => 'Versandart',
                'Versandgewicht'            => 'Versandgewicht',
                'Versandkosten'             => 'Versandkosten',
                'Zolltarifnr'               => 'Zolltarifnr',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'Produktname',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Produktbeschreibung',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SKU',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Bestand',
                'type'     => 'meta',
                'meta_key' => 'stock',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'EAN',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'EK',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Marke',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'MediaLink',
                'type'     => 'meta',
                'meta_key' => 'url',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'ParentSKU',
                'type'     => 'meta',
                'meta_key' => 'SKU',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'UVP',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'VariantenAusfuehrung',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Warengruppe',
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
