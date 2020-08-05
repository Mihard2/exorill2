<?php

/**
 * The eBay Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for billiger feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Billiger
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Billiger extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'          =>  array(
                'name'                      => 'Name',
                'aid'                       => 'AID/SKU',
                'price'                     => 'Price',               
                'link'                      => 'Link',
                'shop_cat'                  => 'Shop Category',
                'pzn'                       => 'PZN',
                'brand'                     => 'Brand',
                'mpn'                       => 'MPN(r)',
                'GTIN'                      => 'GTIN (EAN)',
            ),

            'Additional Information'        => array(
                'image'                     => 'Image',
                'dlv_time'                  => 'Dlv Time',
                'dlv_cost'                  => 'Dlv Cost',
                'dlv_cost_at'               => 'Dlv Cost at',
                'desc'                      => 'Description',
                'base_price'                => 'Base Price or PPU',
                'old_price'                 => 'Old Price',
                'promo_text'                => 'Promo Text',
                'voucher_text'              => 'Voucher Text',
                'eec'                       => 'EEC',
                'light_socket'              => 'Light Socket',
                'wet_grip'                  => 'Wet Grip',
                'fuel'                      => 'Fuel',
                'rolling_noise'             => 'Rolling Noise',
                'hsn_tsn'                   => 'HSN TSN',
                'dia'                       => 'DIA',
                'bc'                        => 'BC',
                'sph_pwr'                   => 'SPH PWR',
                'cyl'                       => 'CYL',
                'axis'                      => 'Axis',
                'size'                      => 'Size',
                'color'                     => 'Color',
                'gender'                    => 'Gender',
                'material'                  => 'Material',
                'class'                     => 'Class',
                'features'                  => 'Features',
                'style'                     => 'Style',
            ),
        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'name',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'aid',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'price',
                'type'     => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'link',
                'type'     => 'meta',
                'meta_key' => 'link',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'cdata',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'shop_cat',
                'type'     => 'meta',
                'meta_key' => 'product_cats',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'pzn',
                'type'     => 'meta',
                'meta_key' => 'pzn',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'brand',
                'type'     => 'meta',
                'meta_key' => 'brand',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'mpn',
                'type'     => 'meta',
                'meta_key' => 'mpn',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'GTIN',
                'type'     => 'meta',
                'meta_key' => 'GTIN',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
