<?php
/**
 * CMB checkbox field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   WPFM_CMB2
 * @author    WPFM_CMB2 team
 * @license   GPL-2.0+
 * @link      https://cmb2.io
 */
class WPFM_CMB2_Type_Checkbox extends WPFM_CMB2_Type_Text {

	/**
	 * If checkbox is checked
	 *
	 * @var mixed
	 */
	public $is_checked = null;

	/**
	 * Constructor
	 *
	 * @since 2.2.2
	 *
	 * @param WPFM_CMB2_Types $types
	 * @param array      $args
	 */
	public function __construct( WPFM_CMB2_Types $types, $args = array(), $is_checked = null ) {
		parent::__construct( $types, $args );
		$this->is_checked = $is_checked;
	}

	public function render( $args = array() ) {
		$defaults = array(
			'type'  => 'checkbox',
			'class' => 'cmb2-option cmb2-list',
			'value' => 'on',
			'desc'  => '',
		);

		$meta_value = $this->field->escaped_value();

		$is_checked = null === $this->is_checked
			? ! empty( $meta_value )
			: $this->is_checked;

		if ( $is_checked ) {
			$defaults['checked'] = 'checked';
		}

		$args = $this->parse_args( 'checkbox', $defaults );

		return $this->rendered(
			sprintf(
				'<label for="%s">%s</label> %s',
                $this->_id(),
				parent::render( $args ),
				$this->_desc()
			)
		);
	}

}
