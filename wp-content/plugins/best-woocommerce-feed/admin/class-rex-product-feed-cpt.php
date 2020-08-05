<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Metabox
 * @subpackage Rex_Product_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines all the Metaboxes for Products
 *
 * @package    Rex_Product_Metabox
 * @subpackage Rex_Product_Feed/admin
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Product_CPT {

    /**
     * Register all metaboxes.
     *
     * @since    1.0.0
     */
    public function register() {
        $this->post_types();
    }

    /**
     * Metabox for Google Merchant.
     *
     * @since    1.0.0
     */
    private function post_types(){
        register_extended_post_type( 'product-feed', array(
            'show_in_menu'       => 'product-feed',
            'rewrite'            => false,
            'query_var'          => true,
            'publicly_queryable' => false,
            'supports'           => array( 'title' ),
            'enter_title_here'   => 'Enter feed title here',
            'menu_icon'           => WPFM_PLUGIN_DIR_URL . 'admin/icon/icon.png',
            'admin_cols' => array(

                'merchant' => array(
                    'title'       => 'Merchant',
                    'meta_key'    => 'rex_feed_merchant',
                    'function'    => function (){
                        echo ucwords( esc_html( str_replace('_', ' ' , get_post_meta( get_the_id(), 'rex_feed_merchant', true )) ) );
                    }
                ),

                'xml_feed' => array(
                    'title'       => 'Feed URL',
                    'meta_key'    => 'rex_feed_xml_file',
                ),

                'refresh_interval'  => array(
                    'title'         => 'Refresh Interval',
                    'meta_key'      => 'rex_feed_schedule',
                    'function'    => function (){
                        echo ucwords( esc_html( get_post_meta( get_the_id(), 'rex_feed_schedule', true ) ) );
                    }
                ),

                'feed_status'  => array(
                    'title'         => 'Feed Status',
                    'function'    => function (){
                        if ( get_post_meta( get_the_id(), 'rex_feed_status', true ) ) {

                            if(get_post_meta( get_the_id(), 'rex_feed_status', true ) == 'processing') {
                                echo '<div class="blink">'.ucwords( esc_html( get_post_meta( get_the_id(), 'rex_feed_status', true ) ) ).'<span>.</span><span>.</span><span>.</span></div>';
                            }else {
                                echo ucwords( esc_html( get_post_meta( get_the_id(), 'rex_feed_status', true ) ) );
                            }

                        }else {
                            echo 'Completed';
                        }

                    }
                ),

                'view_feed' => array(
                    'title'       => 'View/Download',
                    'function'    => function (){
                        $url = esc_url( get_post_meta( get_the_id(), 'rex_feed_xml_file', true ) );
                        echo '<a target="_blank" class="button" href="' . $url . '">View</a> ';
                        echo '<a target="_blank" class="button" href="' . $url . '" download>Download</a>';
                    }
                ),

                'total_products' => array(
                    'title'         => 'Total products',
                    'meta_key'      => 'rex_feed_total_products',
                    'function'    => function (){
                        $total_products = get_post_meta( get_the_id(), 'rex_feed_total_products', true ) ? get_post_meta( get_the_id(), 'rex_feed_total_products', true ) : array(
                            'total' => 0,
                            'simple' => 0,
                            'variable' => 0,
                            'variable_parent' => 0,
                            'group' => 0,
                        );

                        if(!array_key_exists('variable_parent', $total_products)) {
                            $total_products['variable_parent'] = 0;
                        }


                        echo '<ul style="margin: 0;">';
                        echo '<li><b>' . __('Total products : ', 'rex-product-feed'). $total_products['total'] . '</b></li>';
                        echo '<li><b>' . __('Simple products : ', 'rex-product-feed'). $total_products['simple'] . '</b></li>';
                        echo '<li><b>' . __('Variable parent : ', 'rex-product-feed'). $total_products['variable_parent'] . '</b></li>';
                        echo '<li><b>' . __('Variations : ', 'rex-product-feed'). $total_products['variable'] . '</b></li>';
                        echo '<li><b>' . __('Group products : ', 'rex-product-feed'). $total_products['group'] . '</b></li>';
                        echo '</ul><b>';
                    }
                ),
                'date',
                'scheduled' => array(
                    'title_icon'  => 'dashicons-calendar-alt',
                    'title'         => 'Updated',
                    'meta_key'    => 'updated',
                    'date_format' => 'Y/m/d g:i:s A',
                    'function'    => function (){
                        $format = get_option('time_format') . ', '.get_option('date_format');
                        $last_updated = get_post_meta(get_the_id(), 'updated', true);
                        $formatted_time = '';
                        if($last_updated) {
                            $formatted_time = date($format, strtotime($last_updated));
                        }

                        $schedule = get_post_meta( get_the_id(), 'rex_feed_schedule', true );
                        echo '<div><strong>'.__('Last Updated: ', 'rex-product-feed').'</strong><span style="text-decoration: dotted underline;" title="'.$formatted_time.'">'.$formatted_time.'</span></div></br>';

                        $next_update = '';
                        if($schedule === 'hourly') {
                            $next_update = date($format, strtotime('+1 hours', strtotime($last_updated)));
                        }elseif ($schedule === 'daily') {
                            $next_update = date($format, strtotime('+1 days', strtotime($last_updated)));
                        }elseif ($schedule === 'weekly') {
                            $next_update = date($format, strtotime('+ 7 days', strtotime($last_updated)));
                        }

                        if($schedule !== 'no') {
                            echo '<div><strong>'.__('Next Schedule: ', 'rex-product-feed').'</strong><span style="text-decoration: dotted underline;" title="'.$next_update.'">'.$next_update.'</span></div>';
                        }
                    }
                ),
            ),
        ));
    }

}
