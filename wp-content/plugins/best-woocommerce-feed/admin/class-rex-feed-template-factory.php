<?php
/**
 * The Rex_Feed_Template_Factory class file that
 * returns a feed template class for feed configuration of various merchants.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Feed_Template_Factory
 * @subpackage Rex_Feed_Template_Factory/includes
 *
 */
class Rex_Feed_Template_Factory {

    public static function build( $merchant, $feed_rules ){
        $className = 'Rex_Feed_Template_'. ucfirst( str_replace(' ', '', $merchant) );
        if( $merchant == '' || ! class_exists( $className ) ) {
            throw new Exception('Invalid Merchant.');
        } else {
            return new $className( $feed_rules );
        }
        return false;
    }
}


