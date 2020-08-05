<?php

/**
 * The AdRoll Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.2.5
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for AdRoll feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_become
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Google_merchant_promotion extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Basic promotions data'  =>  array(
                'promotion_id' => 'Promotion id',
                'product_applicability' => 'Product applicability',
                'offer_type' => 'Offer type',
                'long_title' => 'Long title',
                'promotion_effective_dates' => 'Promotion effective dates',
                'redemption_channel' => 'Redemption channel',
                'promotion_destination' => 'Promotion destination',
            ),

            'Promotion categories'  =>  array(
                'percent_off' => 'Percent off',
                'money_off_amount' => 'Money off amount',
                'get_this_quantity_discounted' => 'Get this quantity discounted',
                'free_shipping' => 'Free shipping',
                'free_gift_value' => 'Free gift value',
                'free_gift_description' => 'Free gift description',
                'free_gift_item_id' => 'Free gift item id',
            )

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'promotion_id',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'product_applicability',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'offer_type',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'long_title',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'promotion_effective_dates',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'redemption_channel',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'promotion_destination',
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
