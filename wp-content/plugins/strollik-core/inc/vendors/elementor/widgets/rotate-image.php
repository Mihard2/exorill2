<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor rotate images widget.
 *
 * Elementor widget that displays a set of images in a rotating carousel or
 * slider.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Rotate_Image extends Widget_Base {


	public function get_name() {
		return 'rotate-image';
	}

	public function get_title() {
		return __( 'Opal Rotate Image', 'strollik-core' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'carousel', 'slider', '360'];
	}

	public function get_script_depends() {
		return [ 'spritespin' ];
	}


    public function get_categories() {
        return array('opal-addons');
    }

	protected function _register_controls() {
		$this->start_controls_section(
			'section_image_carousel',
			[
				'label' => __( 'Rotate Image', 'strollik-core' ),
			]
		);

		$this->add_control(
			'carousel',
			[
				'label' => __( 'Add Images', 'strollik-core' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'show_label' => false,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'separator' => 'none',
			]
		);

        $this->add_control(
            'width',
            [
                'label'     => __('Width', 'strollik-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 500,
            ]
        );

        $this->add_control(
            'height',
            [
                'label'     => __('Height', 'strollik-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 500,
            ]
        );

		$this->end_controls_section();

	}

	/**
	 * Render rotate images widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        $_id = wp_generate_uuid4();

		if ( empty( $settings['carousel'] ) ) {
			return;
		}

		$slides = [];

		foreach ( $settings['carousel'] as $index => $attachment ) {
			$image_url = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );
			$slides[] = $image_url;

		}
		if ( empty( $slides ) ) {
			return;
		}
		?>
            <div id="rotateimages-<?php echo esc_attr($_id); ?>" class="m-auto mw-100 opal-loading "></div>

        <?php if (count($slides) > 0): ?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $("#rotateimages-<?php echo esc_attr($_id); ?>").spritespin({
                        source: [<?php echo '"' . implode('","', $slides) . '"'; ?>],
                        width:<?php echo  $settings['width'];?>,
                        height:<?php echo  $settings['height'];?>,
                        sense: 1,
                        responsive: true,
                        animate: false,
                        onComplete: function(){
                            $(this).removeClass('opal-loading');
                        }
                    });
                })

            </script>
        <?php endif;
	}

}
