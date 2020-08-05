<?php
/**
 * The Ladenzeile Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.7
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Ladenzeile feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Idealo
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Ladenzeile extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'Artikelnummer'       => 'Artikelnummer',
                'Bild'                => 'Bild',
                'EAN'                 => 'EAN',
                'Farbe'               => 'Farbe',
                'Hauptkategorie'      => 'Hauptkategorie',
                'Marke'               => 'Marke',
                'Preis'               => 'Preis',
                'Produktname'         => 'Produktname',
                'Unterkategorie'      => 'Unterkategorie',
                'Versandkosten'       => 'Versandkosten',
                'deepURL'             => 'DeepURL',
                'product_description' => 'Product description',
            ) ,

            'Recommended Information' => array(
                'Absatzhoehe'     => 'Absatzhoehe',
                'AlterPreis'      => 'AlterPreis',
                'CPC'             => 'CPC',
                'Geschlecht'      => 'Geschlecht',
                'Groessen'        => 'Groessen',
                'Grundpreis'      => 'Grundpreis',
                'Gutscheine'      => 'Gutscheine',
                'Lieferzeit'      => 'Lieferzeit',
                'Material'        => 'Material',
                'Unterkategorie2' => 'Unterkategorie2',
                'Waehrung'        => 'Waehrung',
                'auxbild_1'       => 'Auxbild 1',
                'auxbild_2'       => 'Auxbild 2',
                'auxbild_3'       => 'Auxbild 3',
            ) ,

            'Optional Information' => array(
                'Muster' => 'Muster',
                'looks'  => 'Looks',
            )

        );
    }

    protected function init_default_template_mappings()
    {
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
            ) ,
            array(
                'attr'      => 'Artikelnummer',
                'type'      => 'meta',
                'meta_key'  => 'id',
                'st_value'  => '',
                'prefix'    => '',
                'suffix'    => '',
                'escape'    => 'default',
                'limit'     => 0,
            ) ,
            array(
                'attr'     => 'Bild',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'EAN',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'Farbe',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'Hauptkategorie',
                'type'     => 'meta',
                'meta_key' => 'product_cats_path',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'Marke',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'Preis',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'      => 'Unterkategorie',
                'type'      => 'meta',
                'meta_key'  => 'sku',
                'st_value'  => '',
                'prefix'    => '',
                'suffix'    => '',
                'escape'    => 'default',
                'limit'     => 0,
            ) ,
            array(
                'attr'     => 'Versandkosten',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'deepURL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ) ,
            array(
                'attr'     => 'product_description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ) ,
        );
    }

}

