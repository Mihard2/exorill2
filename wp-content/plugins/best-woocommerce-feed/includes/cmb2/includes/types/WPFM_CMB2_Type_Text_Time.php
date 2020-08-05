<?php
/**
 * CMB text_time field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   WPFM_CMB2
 * @author    WPFM_CMB2 team
 * @license   GPL-2.0+
 * @link      https://cmb2.io
 */
class WPFM_CMB2_Type_Text_Time extends WPFM_CMB2_Type_Text_Date {

	public function render( $args = array() ) {
		$this->args = $this->parse_picker_options( 'time', wp_parse_args( $this->args, array(
			'class'           => 'cmb2-timepicker text-time',
			'value'           => $this->field->get_timestamp_format( 'time_format' ),
			'js_dependencies' => array( 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-datetimepicker' ),
		) ) );

		return parent::render();
	}

}
