<?php

/**
 * The Kelkoo Moebel Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for Moebel feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Moebel
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Moebel extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'art_id'        => 'Art ID',
                'art_nom'       => 'Art Nom',
                'art_desc'      => 'Art Desc',
                'art_url'       => 'Art URL',
                'art_img_url'   => 'Art Img URL',
                'art_devise'    => 'Art Devise',
                'art_prix'      => 'Art Prix',
                'art_frais_liv' => 'Art Frais Liv',
            ),

            'Recommended Information' => array(
                'art_encherescpc_desktop'   => 'Art Encherescpc Desktop',
                'art_vecteur_mobile'        => 'Art Vecteur Mobile',
                'art_delai_liv'             => 'Art Delai Liv',
                'art_couleur'               => 'Art Couleur',
                'art_matiere'               => 'Art Matiere',
                'art_marque'                => 'Art Marque',
                'art_categorie'             => 'Art Categorie',
                'art_image_url2'            => 'Art Image URL-2',
                'art_image_url3'            => 'Art Image URL-3',
                'art_image_url4'            => 'Art Image URL-4',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'art_id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_nom',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_desc',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_url',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_img_url',
                'type'     => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_devise',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_prix',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'art_frais_liv',
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
