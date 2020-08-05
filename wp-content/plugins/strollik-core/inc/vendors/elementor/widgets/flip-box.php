<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OSF_Elementor_Flip_Box extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-flip-box';
	}

	public function get_title() {
		return __( 'Opal Flip Box', 'strollik-core' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

    public function get_categories() {
        return [ 'opal-addons' ];
    }

	protected function _register_controls() {

		$this->start_controls_section(
			'section_side_a_content',
			[
				'label' => __( 'Front', 'strollik-core' ),
			]
		);

		$this->start_controls_tabs( 'side_a_content_tabs' );

		$this->start_controls_tab( 'side_a_content_tab', [ 'label' => __( 'Content', 'strollik-core' ) ] );

		$this->add_control(
			'graphic_element',
			[
				'label' => __( 'Graphic Element', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'none' => [
						'title' => __( 'None', 'strollik-core' ),
						'icon' => 'fa fa-ban',
					],
					'image' => [
						'title' => __( 'Image', 'strollik-core' ),
						'icon' => 'fa fa-picture-o',
					],
					'icon' => [
						'title' => __( 'Icon', 'strollik-core' ),
						'icon' => 'fa fa-star',
					],
				],
				'default' => 'icon',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'strollik-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`
				'default' => 'thumbnail',
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'strollik-core' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-star',
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_view',
			[
				'label' => __( 'View', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'strollik-core' ),
					'stacked' => __( 'Stacked', 'strollik-core' ),
					'framed' => __( 'Framed', 'strollik-core' ),
				],
				'default' => 'default',
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_shape',
			[
				'label' => __( 'Shape', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'strollik-core' ),
					'square' => __( 'Square', 'strollik-core' ),
				],
				'default' => 'circle',
				'condition' => [
					'icon_view!' => 'default',
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'title_text_a',
			[
				'label' => __( 'Title & Description', 'strollik-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'strollik-core' ),
				'placeholder' => __( 'Enter your title', 'strollik-core' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_text_a',
			[
				'label' => __( 'Description', 'strollik-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'strollik-core' ),
				'placeholder' => __( 'Enter your description', 'strollik-core' ),
				'separator' => 'none',
				'rows' => 10,
				'show_label' => false,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_a_background_tab', [ 'label' => __( 'Background', 'strollik-core' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_a',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementor-flip-box__front',
			]
		);

		$this->add_control(
			'background_overlay_a',
			[
				'label' => __( 'Background Overlay', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'background_a_image[id]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_side_b_content',
			[
				'label' => __( 'Back', 'strollik-core' ),
			]
		);

		$this->start_controls_tabs( 'side_b_content_tabs' );

		$this->start_controls_tab( 'side_b_content_tab', [ 'label' => __( 'Content', 'strollik-core' ) ] );

		$this->add_control(
			'title_text_b',
			[
				'label' => __( 'Title & Description', 'strollik-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'strollik-core' ),
				'placeholder' => __( 'Enter your title', 'strollik-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text_b',
			[
				'label' => __( 'Description', 'strollik-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'strollik-core' ),
				'placeholder' => __( 'Enter your description', 'strollik-core' ),
				'separator' => 'none',
				'rows' => 10,
				'show_label' => false,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'strollik-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'strollik-core' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'strollik-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'strollik-core' ),
			]
		);

		$this->add_control(
			'link_click',
			[
				'label' => __( 'Apply Link On', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'box' => __( 'Whole Box', 'strollik-core' ),
					'button' => __( 'Button Only', 'strollik-core' ),
				],
				'default' => 'button',
				'condition' => [
					'link[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_b_background_tab', [ 'label' => __( 'Background', 'strollik-core' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_b',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementor-flip-box__back',
			]
		);

		$this->add_control(
			'background_overlay_b',
			[
				'label' => __( 'Background Overlay', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'background_b_image[id]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_settings',
			[
				'label' => __( 'Settings', 'strollik-core' ),
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__layer, {{WRAPPER}} .elementor-flip-box__layer__overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'flip_effect',
			[
				'label' => __( 'Flip Effect', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'flip',
				'options' => [
					'flip' => 'Flip',
					'slide' => 'Slide',
					'push' => 'Push',
					'zoom-in' => 'Zoom In',
					'zoom-out' => 'Zoom Out',
					'fade' => 'Fade',
				],
				'prefix_class' => 'elementor-flip-box--effect-',
			]
		);

		$this->add_control(
			'flip_direction',
			[
				'label' => __( 'Flip Direction', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'up',
				'options' => [
					'left' => __( 'Left', 'strollik-core' ),
					'right' => __( 'Right', 'strollik-core' ),
					'up' => __( 'Up', 'strollik-core' ),
					'down' => __( 'Down', 'strollik-core' ),
				],
				'condition' => [
					'flip_effect!' => [
							'fade',
							'zoom-in',
							'zoom-out',
						],
				],
				'prefix_class' => 'elementor-flip-box--direction-',
			]
		);

		$this->add_control(
			'flip_3d',
			[
				'label' => __( '3D Depth', 'strollik-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'strollik-core' ),
				'label_off' => __( 'Off', 'strollik-core' ),
				'return_value' => 'elementor-flip-box--3d',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'flip_effect' => 'flip',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_a',
			[
				'label' => __( 'Front', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding_a',
			[
				'label' => __( 'Padding', 'strollik-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_a',
			[
				'label' => __( 'Alignment', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'vertical_position_a',
			[
				'label' => __( 'Vertical Position', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'strollik-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'strollik-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'strollik-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_a',
				'selector' => '{{WRAPPER}} .elementor-flip-box__front',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_image_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Image', 'strollik-core' ),
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'image_width',
			[
				'label' => __( 'Size (%)', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elementor-flip-box__image img',
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Icon', 'strollik-core' ),
				'condition' => [
					'graphic_element' => 'icon',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label' => __( 'Primary Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-view-framed .elementor-icon, {{WRAPPER}} .elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => __( 'Secondary Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Icon Padding', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'icon_rotate',
			[
				'label' => __( 'Icon Rotate', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_border_width',
			[
				'label' => __( 'Border Width', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view' => 'framed',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'strollik-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'heading_title_style_a',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing_a',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'description_text_a!' => '',
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_a',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title',
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description_style_a',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'description_color_a',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography_a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description',
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_b',
			[
				'label' => __( 'Back', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding_b',
			[
				'label' => __( 'Padding', 'strollik-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_b',
			[
				'label' => __( 'Alignment', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .elementor-flip-box__button' => 'margin-{{VALUE}}: 0',
				],
			]
		);

		$this->add_control(
			'vertical_position_b',
			[
				'label' => __( 'Vertical Position', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'strollik-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'strollik-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'strollik-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_b',
				'selector' => '{{WRAPPER}} .elementor-flip-box__back',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_title_style_b',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing_b',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_b',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_b',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title',
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description_style_b',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'description_spacing_b',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'description_text_b!' => '',
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'description_color_b',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography_b',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description',
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'heading_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Button', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => [
					'xs' => __( 'Extra Small', 'strollik-core' ),
					'sm' => __( 'Small', 'strollik-core' ),
					'md' => __( 'Medium', 'strollik-core' ),
					'lg' => __( 'Large', 'strollik-core' ),
					'xl' => __( 'Extra Large', 'strollik-core' ),
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-flip-box__button',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		$wrapper_tag = 'div';
		$button_tag = 'a';
		$link_url = empty( $settings['link']['url'] ) ? '#' : $settings['link']['url'];
		$this->add_render_attribute( 'button', 'class', [
				'elementor-flip-box__button',
				'elementor-button',
				'elementor-size-' . $settings['button_size'],
			]
		);

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-flip-box__layer elementor-flip-box__back' );
		if ( 'box' === $settings['link_click'] ) {
			$wrapper_tag = 'a';
			$button_tag = 'button';
			$this->add_render_attribute( 'wrapper', 'href', $link_url );
			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'wrapper', 'target', '_blank' );
			}
		} else {
			$this->add_render_attribute( 'button', 'href', $link_url );
			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
		}

		if ( 'icon' === $settings['graphic_element'] ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon-wrapper' );
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-view-' . $settings['icon_view'] );
			if ( 'default' != $settings['icon_view'] ) {
				$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-shape-' . $settings['icon_shape'] );
			}
			if ( ! empty( $settings['icon'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			}
		}

		?>
		<div class="elementor-flip-box">
			<div class="elementor-flip-box__layer elementor-flip-box__front">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<?php if ( 'image' === $settings['graphic_element'] && ! empty( $settings['image']['url'] ) ) : ?>
							<div class="elementor-flip-box__image">
								<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
							</div>
						<?php elseif ( 'icon' === $settings['graphic_element'] && ! empty( $settings['icon'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
								<div class="elementor-icon">
									<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['title_text_a'] ) ) : ?>
							<h3 class="elementor-flip-box__layer__title">
								<?php echo $settings['title_text_a']; ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $settings['description_text_a'] ) ) : ?>
							<div class="elementor-flip-box__layer__description">
								<?php echo $settings['description_text_a']; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<<?php echo $wrapper_tag; ?> <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<?php if ( ! empty( $settings['title_text_b'] ) ) : ?>
							<h3 class="elementor-flip-box__layer__title">
								<?php echo $settings['title_text_b']; ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $settings['description_text_b'] ) ) : ?>
							<div class="elementor-flip-box__layer__description">
								<?php echo $settings['description_text_b']; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['button_text'] ) ) : ?>
							<<?php echo $button_tag; ?> <?php echo $this->get_render_attribute_string( 'button' ); ?>>
								<?php echo $settings['button_text']; ?>
							</<?php echo $button_tag; ?>>
						<?php endif; ?>
					</div>
				</div>
			</<?php echo $wrapper_tag; ?>>
		</div>
		<?php
	}

	protected function _content_template() {
		?>
		<#
			var btnClasses = 'elementor-flip-box__button elementor-button elementor-size-' + settings.button_size;

			if ( 'image' === settings.graphic_element && '' !== settings.image.url ) {
				var image = {
					id: settings.image.id,
					url: settings.image.url,
					size: settings.image_size,
					dimension: settings.image_custom_dimension,
					model: view.getEditModel()
				};

				var imageUrl = elementor.imagesManager.getImageUrl( image );
			}

			var wrapperTag = 'div',
				buttonTag = 'a';

			if ( 'box' === settings.link_click ) {
				wrapperTag = 'a';
				buttonTag = 'button';
			}

			if ( 'icon' === settings.graphic_element ) {
				var iconWrapperClasses = 'elementor-icon-wrapper';
					iconWrapperClasses += ' elementor-view-' + settings.icon_view;
				if ( 'default' !== settings.icon_view ) {
					iconWrapperClasses += ' elementor-shape-' + settings.icon_shape;
				}
			}
		#>

		<div class="elementor-flip-box">
			<div class="elementor-flip-box__layer elementor-flip-box__front">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<# if ( 'image' === settings.graphic_element && '' !== settings.image.url ) { #>
							<div class="elementor-flip-box__image">
								<img src="{{ imageUrl }}">
							</div>
						<#  } else if ( 'icon' === settings.graphic_element && settings.icon ) { #>
							<div class="{{ iconWrapperClasses }}" >
								<div class="elementor-icon">
									<i class="{{ settings.icon }}"></i>
								</div>
							</div>
						<# } #>

						<# if ( settings.title_text_a ) { #>
							<h3 class="elementor-flip-box__layer__title">{{{ settings.title_text_a }}}</h3>
						<# } #>

						<# if ( settings.description_text_a ) { #>
							<div class="elementor-flip-box__layer__description">{{{ settings.description_text_a }}}</div>
						<# } #>
					</div>
				</div>
			</div>
			<{{ wrapperTag }} class="elementor-flip-box__layer elementor-flip-box__back">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<# if ( settings.title_text_b ) { #>
							<h3 class="elementor-flip-box__layer__title">{{{ settings.title_text_b }}}</h3>
						<# } #>

						<# if ( settings.description_text_b ) { #>
							<div class="elementor-flip-box__layer__description">{{{ settings.description_text_b }}}</div>
						<# } #>

						<# if ( settings.button_text ) { #>
							<{{ buttonTag }} href="#" class="{{ btnClasses }}">{{{ settings.button_text }}}</{{ buttonTag }}>
						<# } #>
					</div>
				</div>
			</{{ wrapperTag }}>
		</div>
		<?php
	}
}
