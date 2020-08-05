<?php

/**
 * The De-denicheur Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for De-denicheur feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_De_denicheur
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Ledenicheur extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'ID-de-votre-produit'   => 'ID de votre produit',
                'Nom-du-produit'        => 'Nom du produit',
                'Etat-du-produit'       => 'Etat du produit',
                'Coût-de-livraison-ou-prix-incluant-la-livraison'  => 'Coût de livraison ou prix incluant la livraison',
                'Marque-Fabricant'      => 'Marque/Fabricant',
                'URL-vers-votre-page-produit-(non-trackée)' => 'URL vers votre page produit (non-trackée)',
                'URL-vers-votre-page-produit-(trackée)' => 'URL vers votre page produit (trackée)',
                'Catégorie'             => 'Catégorie',
                'Statut-stock'          => 'Statut stock',
                'Prix'                  => 'Prix',

            ),

            'Recommended Information' => array(
                'Délai-de-livraison'  => 'Délai de livraison',
                'URL-vers-une-grande-image-produit' => 'URL vers une grande image produit',
                'Code-MPN'            => 'Code MPN',
                'Code-EAN/GTIN-13'    => 'Code EAN/GTIN-13',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'ID-de-votre-produit',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Nom-du-produit',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Etat-du-produit',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Coût-de-livraison-ou-prix-incluant-la-livraison',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Marque-Fabricant',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'URL-vers-votre-page-produit-(non-trackée)',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'URL-vers-votre-page-produit-(trackée)',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Catégorie',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Statut-stock',
                'type'     => 'meta',
                'meta_key' => 'in_stock',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Prix',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),
            

        );
    }

}
