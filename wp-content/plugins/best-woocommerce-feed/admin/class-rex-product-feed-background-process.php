<?php

/**
 * The Rex_Product_Feed_Background_Process class file that
 * handle background process
 *
 * @link       https://rextheme.com
 * @since      2.0.0
 *
 * @package    Rex_Product_Feed_Cron_Handler
 * @subpackage Rex_Product_Feed/admin
 */


class Rex_Product_Feed_Background_Process extends WP_Background_Process {

    protected $action = 'rex_product_feed_background_process';


    /**
     * Product Number
     *
     * @since    1.3.3
     * @access   protected
     * @var      Rex_Product_Feed_Background_Process    $product_no    Contains no of products to process.
     */
    protected $product_no;


    /**
     * Total Batch
     *
     * @since    1.3.3
     * @access   protected
     * @var      Rex_Product_Feed_Background_Process    $total_batches
     */
    protected $total_batches;


    /**
     * Batch No
     *
     * @since    1.3.3
     * @access   protected
     * @var      Rex_Product_Feed_Background_Process    $batch
     */
    protected $batch;


    /**
     * Product Batch
     *
     * @since    1.3.3
     * @access   protected
     * @var      Rex_Product_Feed_Background_Process    $offset
     */
    protected $offset;


    /**
     * Task
     *
     * Override this method to perform any actions required on each
     * queue item. Return the modified item for further processing
     * in the next pass through. Or, return false to remove the
     * item from the queue.
     *
     * @param mixed $item Queue item to iterate over
     *
     * @return mixed
     */
    protected function task( $merchant ) {
        $merchant->make_feed();
        sleep(3);
        return false;
    }


    /**
     * Complete
     *
     * Override if applicable, but ensure that the below actions are
     * performed, or, call parent::complete().
     */
    protected function complete() {
        $feed_queue_ids = Rex_Product_Feed_Controller::get_feed_queue();
        foreach ($feed_queue_ids as $feed_id) {
            Rex_Product_Feed_Controller::remove_id_from_feed_queue($feed_id);
            Rex_Product_Feed_Controller::update_feed_status($feed_id, 'completed');
        }
        parent::complete();
    }
}
