<?php

/**
 * The Glami marketplace Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */
/**
 *
 * Defines the attributes and template for Glami marketplace feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Glami
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Glami extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'CATEGORYTEXT'            => 'CATEGORYTEXT',
                'DELIVERY_DATE'           => 'DELIVERY DATE',
                'description'             => 'DESCRIPTION',
                'IMGURL'                  => 'IMGURL',
                'ITEM_ID'                 => 'ITEM_ID',
                'MANUFACTURER'            => 'MANUFACTURER',
                'PRICE_VAT'               => 'PRICE_VAT',
                'PRODUCTNAME'             => 'PRODUCTNAME',
                'SIZE'                    => 'SIZE',
                'URL'                     => 'URL',
            ),
            'Recommended Information' =>  array(
                'EAN'                     => 'EAN',
                'IMGURL_ALTERNATIVE'      => 'IMGURL ALTERNATIVE',
                'ITEMGROUP_ID'            => 'ITEMGROUP_ID',
                'SIZE_SYSTEM'             => 'SIZE SYSTEM',
                'URL_SIZE'                => 'URL SIZE',
            ),

            'Optional Information' => array(
                'CATEGORY_ID'            => 'CATEGORY ID',
                'DELIVERY_ID'            => 'DELIVERY ID',
                'DELIVERY_PRICE'         => 'DELIVERY PRICE',
                'DELIVERY_PRICE_COD'     => 'DELIVERY PRICE COD',
                'GLAMI_CPC '             => 'GLAMI CPC',
                'MATERIAL'               => 'MATERIAL',
                'PROMOTION_ID  	'        => 'PROMOTION ID',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(

            array(
                'attr'     => 'PRODUCTNAME',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'ITEM_ID',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'description',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'PRICE_VAT',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' '.get_option('woocommerce_currency'),
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'CATEGORYTEXT',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'DELIVERY_DATE',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'IMGURL',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'MANUFACTURER',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'SIZE',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'URL',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
