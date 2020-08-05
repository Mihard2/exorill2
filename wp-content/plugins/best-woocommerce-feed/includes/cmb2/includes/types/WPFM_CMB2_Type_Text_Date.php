<?php
/**
 * CMB text_date field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   WPFM_CMB2
 * @author    WPFM_CMB2 team
 * @license   GPL-2.0+
 * @link      https://cmb2.io
 */
class WPFM_CMB2_Type_Text_Date extends WPFM_CMB2_Type_Picker_Base {

	public function render( $args = array() ) {
		$args = $this->parse_args( 'text_date', array(
			'class'           => 'cmb2-text-small cmb2-datepicker',
			'value'           => $this->field->get_timestamp_format(),
			'desc'            => $this->_desc(),
			'js_dependencies' => array( 'jquery-ui-core', 'jquery-ui-datepicker' ),
		) );

		if ( false === strpos( $args['class'], 'timepicker' ) ) {
			$this->parse_picker_options( 'date' );
		}

		return parent::render( $args );
	}

}
