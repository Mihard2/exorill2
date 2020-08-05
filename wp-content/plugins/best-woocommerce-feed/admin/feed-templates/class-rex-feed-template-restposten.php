<?php

/**
 * The Restposten Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Restposten feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Restposten
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Restposten extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'artikel_nr'      => 'Artikel-Nr',
                'bezeichnung'     => 'Bezeichnung',
                'beschreibung'    => 'Beschreibung',
                'preis'           => 'Preis',
                'wahrung'         => 'Wahrung',
                'unter_rubrik'    => 'Unter Rubrik',
                'verkaufseinheit' => 'Verkaufseinheit',
                'menge'           => 'Menge',
                'lieferzeit'      => 'Lieferzeit',
                'deeplink'        => 'Deeplink',
                'foto'            => 'Foto',
            ),

            'Additional Information' => array(
                'kurzbeschreibung'   => 'Kurzbeschreibung',
            ),

            'Recommended Information' => array(
                'foto_2'           => 'Foto 2',
                'foto_3'           => 'Foto 3',
                'foto_4'           => 'Foto 4',
                'ehemaliger_preis' => 'Ehemaliger Preis',
                'ean'              => 'Ean',
                'marke'            => 'Marke',
                'warenzustand'     => 'Warenzustand',
                'regular_price'    => 'Regular Price',
                'color'            => 'Color',
                'size'             => 'Size',
                'brand'            => 'Brand'
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'artikel_nr',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'bezeichnung',
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
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'wahrung',
                'type'     => 'meta',
                'meta_key' => get_option('woocommerce_currency'),
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'unter_rubrik',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'verkaufseinheit',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'menge',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'lieferzeit',
                'type'     => 'static',
                'meta_key' => '',
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
                'attr'     => 'foto',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
