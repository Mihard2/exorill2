<?php

/**
 * The Adcell Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for adcell feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Adcell
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Adcell extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'produkt_titel'                => 'Produkt Titel',
                'produktbeschreibung'          => 'Produktbeschreibung',
                'deeplink'                     => 'Deeplink',
                'brutopreis'                   => 'Brutopreis',
                'anbieter_artikelnummer_ann'   => 'Anbieter Artikelnummer AAN',
                'produktbild_url'              => 'Produktbild URL',
                'produktkategorie'             => 'Produktkategorie',
                'versandkosten_allgemein'      => 'Versandkosten Allgemein',
            ),

            'Additional Information' => array(
                'produktbeschreibung_lang'          => 'Produktbeschreibung (lang)',
                'nettopreis'                        => 'Nettopreis',
                'wahrung'                           => 'Wahrung',
                'europaische_artikelnummer_ean'     => 'Europäische Artikelnummer EAN',
                'hersteller_artikelnummer_han'      => 'Hersteller Artikelnummer HAN',
                'vorschaubild_url'                  => 'Vorschaubild URL',
                'produktkategorie_id'               => 'Produktkategorie ID',
                'versandkosten_vorkasse'            => 'Versandkosten Vorkasse',
                'versandkosten_nachnahme'           => 'Versandkosten Nachnahme',
                'versandkosten_kreditkarte'         => 'Versandkosten Kreditkarte',
                'versandkosten_lastschrift'         => 'Versandkosten Lastschrift',
                'versandkosten_rechnung'            => 'Versandkosten Rechnung',
                'versandkosten_payPal'              => 'Versandkosten PayPal',
                'versandkosten_sofortuberweisung'   => 'Versandkosten Sofortüberweisung',
                'lieferzeit_verfügbarkeit'          => 'Lieferzeit/ Verfügbarkeit',
                'grundpreiseinheit'                 => 'Grundpreiseinheit',
            ),

            'Recommended Information' => array(
                'hersteller'          => 'Hersteller',
                'grundpreis'          => 'Grundpreis',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'produkt_titel',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'produktbeschreibung',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'deeplink',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'brutopreis',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'anbieter_artikelnummer_ann',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'produktbild_url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'produktkategorie',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'versandkosten_allgemein',
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
