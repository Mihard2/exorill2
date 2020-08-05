<?php


/**
 *
 * Defines the attributes and template for daisycon feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Daisycon
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Daisycon extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information'              =>  array(
                'title'                 => 'Product title',
                'price'                 => 'Product price',
                'link'                   => 'Product URL',
                'description'           => 'Product description',
                'id'                    => 'Product ID',
            ),

            'Additional Information'            => array(
                'additional_costs'              => 'Additional costs',
                'product_brand'                 => 'Product brand',
                'product_brand_URL'             => 'Product brand URL',
                'product_category'              => 'Product category',
                'product_category_path'         => 'Product category path',
                'primary_color'                 => 'Primary color',
                'product_condition'             => 'Product condition',
                'delivery_description'          => 'Delivery description',
                'delivery_time'                 => 'Delivery time',
                'EAN'                           => 'EAN',
                'gender_target'                 => 'Gender target',
                'google_category_ID	'           => 'Google category ID',
                'in_stock'                      => 'In stock',
                'in_stock_amount'               => 'In stock amount',
                'keywords'                      => 'Keywords',
                'Model_name_number'             => 'Model name/number',
                'old_price'                     => 'Old price',
                'shipping_costs'                => 'Shipping costs',
                'product_size'                  => 'Product size',
                'size_description'              => 'Size description',
                'terms_and_conditions'          => 'Terms and conditions',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'title',
                'type'     => 'meta',
                'meta_key' => 'title',
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
                'attr'     => 'id',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
        );
    }

}
