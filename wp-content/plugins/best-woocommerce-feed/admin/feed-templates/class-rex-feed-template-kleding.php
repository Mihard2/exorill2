<?php
/**
 * The Kleding Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for kelkoo feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Kleding
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Kleding extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'productnummer' => 'Product Number',
                'titel' => 'Product title',
                'afbeelding' => 'Afbeelding',
                'kleur' => 'Kleur',
                'link' => 'Link',
                'merk' => 'Merk',
                'omschrijving' => 'Omschrijving',
                'oude_prijs' => 'Oude prijs',
                'prijs' => 'Prijs',
                'rubriek' => 'Rubriek',

            ) ,
            'Additional Information' => array(
                'geslacht ' => 'Geslacht',
                'maten' => 'Maten',
                'materiaal' => 'materiaal',
                'verzendkosten' => 'Verzendkosten',
                'verzendtijd' => 'Verzendtijd',
                'voorraad' => 'Voorraad',
            ) ,

        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'productnummer',
                'type' => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'titel',
                'type' => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'afbeelding',
                'type' => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'kleur',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'merk',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'oude_prijs',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'prijs',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
            array(
                'attr' => 'rubriek',
                'type' => 'meta',
                'meta_key' => 'product_cats_path',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0,
            ) ,
        );
    }

}

