<?php

/**
 * The Hood Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Hood feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Hood
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Hood extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'titel'         => 'Titel',
                'beschreibung'  => 'Beschreibung',
                'preis'         => 'Preis',
                'bild_url'      => 'Bild URL',
                'aktion'        => 'Aktion',
                'format'        => 'Format',
                'artikel_nr'    => 'Artikel Nr',
                'bilder'        => 'Bilder',
                'zahlungsarten' => 'Zahlungsarten',
            ),

            'Additional Information' => array(
                'untertitel'          => 'Untertitel',
                'eigene_kategorie'    => 'Eigene Kategorie',
                'einheit_grundpreis'  => 'Einheit Grundpreis',
                'lagernd_von'         => 'Lagernd Von',
                'lagernd_bis'         => 'Lagernd Bis',
                'nicht_lagernd_von'   => 'Nicht Lagernd Von',
                'nicht_lagernd_bis'   => 'Nicht Lagernd Bis',
            ),

            'Recommended' => array(
                'itemID'             => 'ItemID',
                'ean_Code'           => 'EAN-Code',
                'ISBN_nummer'        => 'ISBN Nummer',
                'MPN'                => 'MPN',
                'hersteller'         => 'Hersteller',
                'kurzbeschreibung'   => 'Kurzbeschreibung',
                'kategorie_nr'       => 'Kategorie Nr',
                'zustand'            => 'Zustand',
                'menge'              => 'Menge',
                'gewicht'            => 'Gewicht',
                'größe'              => 'Größe',
                'material'           => 'Material',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'titel',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'beschreibung',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'preis',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'bild_url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'aktion',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'format',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'artikel_nr',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'bilder',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'zahlungsarten',
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
