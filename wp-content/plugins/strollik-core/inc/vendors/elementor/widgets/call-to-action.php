<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class OSF_Elementor_CallToAction extends Elementor\Widget_Base {


	public function get_name() {
		return 'call-to-action';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}


	public function get_title() {
		return __( 'Call to Action', 'strollik-core' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_main_image',
			[
				'label' => __( 'Image', 'strollik-core' ),
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => __( 'Skin', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'classic' => __( 'Classic', 'strollik-core' ),
					'cover' => __( 'Cover', 'strollik-core' ),
				],
				'render_type' => 'template',
				'prefix_class' => 'elementor-cta--skin-',
				'default' => 'classic',
			]
		);

		$this->add_responsive_control(
			'layout',
			[
				'label' => __( 'Layout', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'strollik-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'above' => [
						'title' => __( 'Above', 'strollik-core' ),
						'icon'  => 'eicon-v-align-top',
					],
					'right' => [
						'title' => __( 'Right', 'strollik-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor-cta-%s-layout-image-',
				'condition' => [
					'skin!' => 'cover',
				],
			]
		);

		$this->add_control(
			'bg_image',
			[
				'label' => __( 'Choose Image', 'strollik-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'bg_image', // Actually its `image_size`
				'label' => __( 'Image Resolution', 'strollik-core' ),
				'default' => 'large',
				'condition' => [
					'bg_image[id]!' => '',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'strollik-core' ),
			]
		);

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
				'separator' => 'before',
				'default' => 'none',
			]
		);

		$this->add_control(
			'graphic_image',
			[
				'label' => __( 'Choose Image', 'strollik-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'graphic_element' => 'image',
				],
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'graphic_image', // Actually its `image_size`
				'default' => 'thumbnail',
				'condition' => [
					'graphic_element' => 'image',
					'graphic_image[id]!' => '',
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
			'title',
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
			'description',
			[
				'label' => __( 'Description', 'strollik-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet consectetur adipiscing elit dolor', 'strollik-core' ),
				'placeholder' => __( 'Enter your description', 'strollik-core' ),
				'separator' => 'none',
				'rows' => 5,
				'show_label' => false,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'h2',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'button',
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
				'separator' => 'none',
				'condition' => [
					'link[url]!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon',
			[
				'label' => __( 'Ribbon', 'strollik-core' ),
			]
		);

		$this->add_control(
			'ribbon_title',
			[
				'label' => __( 'Title', 'strollik-core' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'ribbon_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'strollik-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'strollik-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'strollik-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'condition' => [
					'ribbon_title!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'box_style',
			[
				'label' => __( 'Box', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'min-height',
			[
				'label' => __( 'Min. Height', 'strollik-core' ),
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
					'{{WRAPPER}} .elementor-cta__content' => 'min-height: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'alignment',
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
					'{{WRAPPER}} .elementor-cta__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'vertical_position',
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
				'prefix_class' => 'elementor-cta--valign-',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Padding', 'strollik-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_bg_image_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Image', 'strollik-core' ),
				'condition' => [
					'bg_image[url]!' => '',
					'skin' => 'classic',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_min_width',
			[
				'label' => __( 'Min. Width', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__bg-wrapper' => 'min-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'skin' => 'classic',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_min_height',
			[
				'label' => __( 'Min. Height', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],

				'selectors' => [
					'{{WRAPPER}} .elementor-cta__bg-wrapper' => 'min-height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'skin' => 'classic',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'graphic_element_style',
			[
				'label' => __( 'Graphic Element', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'graphic_element!' => 'none',
				],
			]
		);

		$this->add_control(
			'graphic_image_spacing',
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
					'{{WRAPPER}} .elementor-cta__image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'graphic_image_width',
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
					'{{WRAPPER}} .elementor-cta__image img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'graphic_image_opacity',
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
					'{{WRAPPER}} .elementor-cta__image' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'graphic_image_border',
				'selector' => '{{WRAPPER}} .elementor-cta__image img',
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'graphic_image_border_radius',
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
					'{{WRAPPER}} .elementor-cta__image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Content', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'title',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'description',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'heading_style_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-cta__title',
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__title:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_style_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-cta__description',
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label' => __( 'Spacing', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__description:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'heading_content_colors',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Colors', 'strollik-core' ),
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'color_tabs' );

		$this->start_controls_tab( 'colors_normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__content' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'skin' => 'classic',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Description Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__description' => 'color: {{VALUE}}',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'button!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'colors_hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'content_bg_color_hover',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta:hover .elementor-cta__content' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'skin' => 'classic',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => __( 'Title Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta:hover .elementor-cta__title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title!' => '',
				],
			]
		);

		$this->add_control(
			'description_color_hover',
			[
				'label' => __( 'Description Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta:hover .elementor-cta__description' => 'color: {{VALUE}}',
				],
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'button_color_hover',
			[
				'label' => __( 'Button Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta:hover .elementor-cta__button' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'button!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'button!' => '',
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
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typography', 'strollik-core' ),
				'selector' => '{{WRAPPER}} .elementor-cta__button',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'button_normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button-hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__button:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .elementor-cta__button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
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
					'{{WRAPPER}} .elementor-cta__button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon_style',
			[
				'label' => __( 'Ribbon', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => [
					'ribbon_title!' => '',
				],
			]
		);

		$this->add_control(
			'ribbon_bg_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-ribbon-inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ribbon_text_color',
			[
				'label' => __( 'Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-ribbon-inner' => 'color: {{VALUE}}',
				],
			]
		);

		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'ribbon_distance',
			[
				'label' => __( 'Distance', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ribbon_typography',
				'selector' => '{{WRAPPER}} .elementor-ribbon-inner',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .elementor-ribbon-inner',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'hover_effects',
			[
				'label' => __( 'Hover Effects', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_hover_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Content', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'skin' => 'cover',
				],
			]
		);

		$this->add_control(
			'content_animation',
			[
				'label' => __( 'Hover Animation', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'None', 'strollik-core' ),
						'options' => [
							'' => __( 'None', 'strollik-core' ),
						],
					],
					[
						'label' => __( 'Entrance', 'strollik-core' ),
						'options' => [
							'enter-from-right' => 'Slide In Right',
							'enter-from-left' => 'Slide In Left',
							'enter-from-top' => 'Slide In Up',
							'enter-from-bottom' => 'Slide In Down',
							'enter-zoom-in' => 'Zoom In',
							'enter-zoom-out' => 'Zoom Out',
							'fade-in' => 'Fade In',
						],
					],
					[
						'label' => __( 'Reaction', 'strollik-core' ),
						'options' => [
							'grow' => 'Grow',
							'shrink' => 'Shrink',
							'move-right' => 'Move Right',
							'move-left' => 'Move Left',
							'move-up' => 'Move Up',
							'move-down' => 'Move Down',
						],
					],
					[
						'label' => __( 'Exit', 'strollik-core' ),
						'options' => [
							'exit-to-right' => 'Slide Out Right',
							'exit-to-left' => 'Slide Out Left',
							'exit-to-top' => 'Slide Out Up',
							'exit-to-bottom' => 'Slide Out Down',
							'exit-zoom-in' => 'Zoom In',
							'exit-zoom-out' => 'Zoom Out',
							'fade-out' => 'Fade Out',
						],
					],
				],
				'default' => 'grow',
				'condition' => [
					'skin' => 'cover',
				],
			]
		);

		/*
		 *
		 * Add class 'elementor-animated-content' to widget when assigned content animation
		 *
		 */
		$this->add_control(
			'animation_class',
			[
				'label' => 'Animation',
				'type' => Controls_Manager::HIDDEN,
				'default' => 'animated-content',
				'prefix_class' => 'elementor-',
				'condition' => [
					'content_animation!' => '',
				],
			]
		);

		$this->add_control(
			'content_animation_duration',
			[
				'label' => __( 'Animation Duration', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'default' => [
					'size' => 1000,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__content-item' => 'transition-duration: {{SIZE}}ms',
					'{{WRAPPER}}.elementor-cta--sequenced-animation .elementor-cta__content-item:nth-child(2)' => 'transition-delay: calc( {{SIZE}}ms / 3 )',
					'{{WRAPPER}}.elementor-cta--sequenced-animation .elementor-cta__content-item:nth-child(3)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) * 2 )',
					'{{WRAPPER}}.elementor-cta--sequenced-animation .elementor-cta__content-item:nth-child(4)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) * 3 )',
				],
				'condition' => [
					'content_animation!' => '',
					'skin' => 'cover',
				],
			]
		);

		$this->add_control(
			'sequenced_animation',
			[
				'label' => __( 'Sequenced Animation', 'strollik-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'strollik-core' ),
				'label_off' => __( 'Off', 'strollik-core' ),
				'return_value' => 'elementor-cta--sequenced-animation',
				'prefix_class' => '',
				'condition' => [
					'content_animation!' => '',
				],
			]
		);

		$this->add_control(
			'background_hover_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Background', 'strollik-core' ),
				'separator' => 'before',
				'condition' => [
					'skin' => 'cover',
				],
			]
		);

		$this->add_control(
			'transformation',
			[
				'label' => __( 'Hover Animation', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => 'None',
					'zoom-in' => 'Zoom In',
					'zoom-out' => 'Zoom Out',
					'move-left' => 'Move Left',
					'move-right' => 'Move Right',
					'move-up' => 'Move Up',
					'move-down' => 'Move Down',
				],
				'default' => 'zoom-in',
				'prefix_class' => 'elementor-bg-transform elementor-bg-transform-',
			]
		);

		$this->start_controls_tabs( 'bg_effects_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => __( 'Overlay Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta:not(:hover) .elementor-cta__bg-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'overlay_blend_mode',
			[
				'label' => __( 'Blend Mode', 'strollik-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Normal', 'strollik-core' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-cta__bg-overlay' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);



		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'overlay_color_hover',
			[
				'label' => __( 'Overlay Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-cta:hover .elementor-cta__bg-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);



		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'effect_duration',
			[
				'label' => __( 'Effect Duration', 'strollik-core' ),
				'type' => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'default' => [
					'size' => 1500,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-cta .elementor-cta__bg, {{WRAPPER}} .elementor-cta .elementor-cta__bg-overlay' => 'transition-duration: {{SIZE}}ms',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		$title_tag = $settings['title_tag'];
		$wrapper_tag = 'div';
		$button_tag = 'a';
		$link_url = empty( $settings['link']['url'] ) ? false : $settings['link']['url'];
		$bg_image = '';
		$content_animation = $settings['content_animation'];
		$animation_class = '';
		$print_bg = true;
		$print_content = true;

		if ( ! empty( $settings['bg_image']['id'] ) ) {
			$bg_image = Group_Control_Image_Size::get_attachment_image_src( $settings['bg_image']['id'], 'bg_image', $settings );
		} elseif ( ! empty( $settings['bg_image']['url'] ) ) {
			$bg_image = $settings['bg_image']['url'];
		}

		if ( empty( $bg_image ) && 'classic' == $settings['skin'] ) {
			$print_bg = false;
		}

		if ( empty( $settings['title'] ) && empty( $settings['description'] ) && empty( $settings['button'] ) && 'none' == $settings['graphic_element'] ) {
			$print_content = false;
		}

		$this->add_render_attribute( 'background_image', 'style', [
			'background-image: url(' . $bg_image . ');',
		] );

		$this->add_render_attribute( 'title', 'class', [
			'elementor-cta__title',
			'elementor-cta__content-item',
			'elementor-content-item',
		] );

		$this->add_render_attribute( 'description', 'class', [
			'elementor-cta__description',
			'elementor-cta__content-item',
			'elementor-content-item',
		] );

		$this->add_render_attribute( 'button', 'class', [
			'elementor-cta__button',
			'elementor-button',
			'elementor-size-' . $settings['button_size'],
		] );

		$this->add_render_attribute( 'graphic_element', 'class',
			[
				'elementor-content-item',
				'elementor-cta__content-item',
			]
		);

		if ( 'icon' === $settings['graphic_element'] ) {
			$this->add_render_attribute( 'graphic_element', 'class',
				[
					'elementor-icon-wrapper',
					'elementor-cta__icon',
				]
			);
			$this->add_render_attribute( 'graphic_element', 'class', 'elementor-view-' . $settings['icon_view'] );
			if ( 'default' != $settings['icon_view'] ) {
				$this->add_render_attribute( 'graphic_element', 'class', 'elementor-shape-' . $settings['icon_shape'] );
			}
			if ( ! empty( $settings['icon'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			}
		} elseif ( 'image' === $settings['graphic_element'] && ! empty( $settings['graphic_image']['url'] ) ) {
			$this->add_render_attribute( 'graphic_element', 'class', 'elementor-cta__image');
		}

		if ( ! empty( $content_animation ) && 'cover' == $settings['skin'] ) {

			$animation_class = 'elementor-animated-item--' . $content_animation;

			$this->add_render_attribute( 'title', 'class', $animation_class );

			$this->add_render_attribute( 'graphic_element', 'class', $animation_class );

			$this->add_render_attribute( 'description', 'class', $animation_class );

		}

		if ( ! empty( $link_url ) ) {

			if ( 'box' === $settings['link_click'] ) {
				$wrapper_tag = 'a';
				$button_tag  = 'button';
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
		}

		$this->add_inline_editing_attributes( 'title' );
		$this->add_inline_editing_attributes( 'description' );
		$this->add_inline_editing_attributes( 'button' );

		?>
		<<?php echo $wrapper_tag . ' ' . $this->get_render_attribute_string( 'wrapper' ); ?> class="elementor-cta">
		<?php if ( $print_bg ) : ?>
			<div class="elementor-cta__bg-wrapper">
				<div class="elementor-cta__bg elementor-bg" <?php echo $this->get_render_attribute_string( 'background_image' ); ?>></div>
				<div class="elementor-cta__bg-overlay"></div>
			</div>
		<?php endif; ?>
		<?php if ( $print_content ) : ?>
			<div class="elementor-cta__content">
			<?php if ( 'image' === $settings['graphic_element'] && ! empty( $settings['graphic_image']['url'] ) ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'graphic_element' ); ?>>
					<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings , 'graphic_image' ); ?>
				</div>
			<?php elseif ( 'icon' === $settings['graphic_element'] && ! empty( $settings['icon'] ) ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'graphic_element' ); ?>>
					<div class="elementor-icon">
						<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['title'] ) ) : ?>
				<<?php echo $title_tag . ' ' . $this->get_render_attribute_string( 'title' ); ?>>
				<?php echo $settings['title']; ?>
				</<?php echo $title_tag; ?>>
			<?php endif; ?>

			<?php if ( ! empty( $settings['description'] ) ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'description' ); ?>>
					<?php echo $settings['description']; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['button'] ) ) : ?>
			<div class="elementor-cta__button-wrapper elementor-cta__content-item elementor-content-item <?php echo $animation_class; ?>">
				<<?php echo $button_tag . ' ' . $this->get_render_attribute_string( 'button' ); ?>>
				<?php echo $settings['button']; ?>
				</<?php echo $button_tag; ?>>
				</div>
			<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $settings['ribbon_title'] ) ) :
			$this->add_render_attribute( 'ribbon-wrapper', 'class', 'elementor-ribbon' );

			if ( ! empty( $settings['ribbon_horizontal_position'] ) ) {
				$this->add_render_attribute( 'ribbon-wrapper', 'class', 'elementor-ribbon-' . $settings['ribbon_horizontal_position'] );
			} ?>
			<div <?php echo $this->get_render_attribute_string( 'ribbon-wrapper' ); ?>>
				<div class="elementor-ribbon-inner"><?php echo $settings['ribbon_title']; ?></div>
			</div>
		<?php endif; ?>
		</<?php echo $wrapper_tag; ?>>
		<?php
	}
}