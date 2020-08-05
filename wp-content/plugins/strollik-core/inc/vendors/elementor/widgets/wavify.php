<?php

namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Wavify extends Widget_Base {

	public function get_categories() {
		return array( 'opal-addons' );
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve tabs widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'opal-wavify';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve tabs widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Opal Wavify', 'strollik-core' );
	}

	public function get_script_depends() {
		return [
			'tweenmax',
			'wavify',
			'jquery-wavify'
		];
	}


	/**
	 * Register tabs widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_wavify',
			[
				'label' => __( 'Wavify', 'strollik-core' ),
			]
		);
		$this->add_responsive_control(
			'wave_wrap_height',
			[
				'label'     => __( 'Wrap Height', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default'   => [
					'size' => 100,
					'unit' => 'px'
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .wavify-wraper' => 'height: {{SIZE}}{{UNIT}};',
				],
				'frontend_available' => true,
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'wave_color',
			[
				'label'              => __( 'Wavify Color', 'strollik-core' ),
				'type'               => Controls_Manager::COLOR,
			]
		);
		$repeater->add_control(
			'wave_bones',
			[
				'label'              => __( 'Bones', 'strollik-core' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 3,
				'description'        => __( 'Number of articulations in the wave', 'strollik-core' ),
			]
		);
		$repeater->add_control(
			'wave_animate',
			[
				'label'              => __( 'Speed (ms)', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
					'description'        => __( 'Animation speed', 'strollik-core' ),
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
                        'step' => .1,
					],
				],
				'default'   => [
					'size' => 0.25,
					'unit' => 'px'
				],
			]
		);
		$repeater->add_control(
			'wave_height',
			[
				'label'              => __( 'Height (px)', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default'   => [
					'size' => 60,
					'unit' => 'px'
				],
			]
		);
		$repeater->add_control(
			'wave_amplitude',
			[
				'label'              => __( 'Amplitude (px)', 'strollik-core' ),
				'description'        => __( 'Vertical distance wave travels', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'default'   => [
					'size' => 40,
					'unit' => 'px'
				],
			]
		);

		$this->add_control(
			'repeater_item',
			[
				'label'  => __( 'Wave', 'elementor' ),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render tabs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$z_index  = 1;
		?>
        <div class="wavify-wraper">
			<?php
			foreach ( $settings['repeater_item'] as $index => $item ) :
				$z_index ++;
				$height = $settings['wave_wrap_height']['size'] - $item['wave_height']['size'];
				?>
                <div class="data" data-height="<?php echo esc_attr($height);?>"
                     data-bones="<?php echo esc_attr($item['wave_bones']);?>" data-amplitude=" <?php echo esc_attr($item['wave_amplitude']['size']);?>"
                     data-color="<?php echo esc_attr($item['wave_color']);?>" data-speed="<?php echo esc_attr($item['wave_animate']['size']);?>">
                    <svg width="100%" height="100%" version="1.1"
                         style="display: block; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index:<?php echo esc_attr( $z_index ); ?> "
                         xmlns="http://www.w3.org/2000/svg" >
                        <defs></defs>
                        <path class="wavify" d=""/>
                    </svg>
                </div>
			<?php endforeach; ?>
        </div>
		<?php
	}
}
