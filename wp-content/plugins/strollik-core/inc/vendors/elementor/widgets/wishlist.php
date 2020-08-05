<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class OSF_Elementor_Wishlist extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-wishlist';
	}

	public function get_title() {
		return __( 'Opal Wishlist', 'strollik-core' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'cart_content',
			[
				'label' => __( 'WooCommerce Wishlist', 'strollik-core' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Choose Icon', 'strollik-core' ),
				'type' => Controls_Manager::ICON,
				'default' => 'opal-icon-wishlist',
			]
		);

		$this->add_control(
			'show_subtotal',
			[
				'label'       => __('Show Total', 'strollik-core'),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'title_hover',
			[
				'label' => __( 'Title Hover', 'strollik-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'View wishlist ', 'strollik-core' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_lable_style',
			[
				'label' => __( 'Style', 'strollik-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_colors' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .fa' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'item_color',
			[
				'label' => __( 'Item Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Icon Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .fa:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_text_color_hover',
			[
				'label' => __( 'Item Text Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->add_control(
			'item_background_color_hover',
			[
				'label' => __( 'Background Color', 'strollik-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .opal-header-wishlist .count:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'show_subtotal' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();

		$items = '';

		if (function_exists('yith_wcwl_count_all_products')) {
			$items = '<div class="site-header-wishlist d-inline-block">';
			$items .= '<a class="opal-header-wishlist header-button" title="'. esc_attr($settings['title_hover']).'" href="'. esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))).'">';
			$items .= '<i class="fa '. $settings['icon'].'" aria-hidden="true"></i>';
			if($settings['show_subtotal']){
				$items .= '<span class="count">'. esc_html(yith_wcwl_count_all_products()).'</span>';
			}
			$items .= '</a>';
			$items .= '</div>';
		}
		echo ($items);

	}
}
