<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class OSF_Elementor_Nav_Menu extends Widget_Base {

	protected $nav_menu_index = 1;

	public function get_name() {
		return 'opal-nav-menu';
	}

	public function get_title() {
		return __( 'Opal Nav Menu', 'strollik-core' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_script_depends() {
		return [

			[
				'smartmenus',
				'magnific-popup',
				'pushmenu',
				'pushmenu-classie',
				'modernizr'
			]
		];
	}

	public function get_style_depends() {
		return [
			'magnific-popup',
		];
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}

	public function on_export( $element ) {
		unset( $element['settings']['menu'] );

		return $element;
	}

	protected function get_nav_menu_index() {
		return $this->nav_menu_index ++;
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'strollik-core' ),
			]
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label'        => __( 'Menu', 'strollik-core' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => array_keys( $menus )[0],
					'save_default' => true,
					'separator'    => 'after',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'strollik-core' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'strollik-core' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

		$this->add_control(
			'layout',
			[
				'label'              => __( 'Layout', 'strollik-core' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'horizontal',
				'options'            => [
					'horizontal' => __( 'Horizontal', 'strollik-core' ),
					'vertical'   => __( 'Vertical', 'strollik-core' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'align_items',
			[
				'label'        => __( 'Align', 'strollik-core' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'    => [
						'title' => __( 'Left', 'strollik-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'strollik-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'strollik-core' ),
						'icon'  => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Stretch', 'strollik-core' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'elementor-nav-menu%s__align-',
				'default'      => '',
			]
		);

		$this->add_control(
			'pointer',
			[
				'label'   => __( 'Pointer', 'strollik-core' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [
					'none'        => __( 'None', 'strollik-core' ),
					'underline'   => __( 'Underline', 'strollik-core' ),
					'overline'    => __( 'Overline', 'strollik-core' ),
					'double-line' => __( 'Double Line', 'strollik-core' ),
					'framed'      => __( 'Framed', 'strollik-core' ),
					'background'  => __( 'Background', 'strollik-core' ),
					'text'        => __( 'Text', 'strollik-core' ),
					'dot'         => __( 'Dot', 'strollik-core' ),
				],
			]
		);

		$this->add_control(
			'animation_line',
			[
				'label'     => __( 'Animation', 'strollik-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'     => 'Fade',
					'slide'    => 'Slide',
					'grow'     => 'Grow',
					'drop-in'  => 'Drop In',
					'drop-out' => 'Drop Out',
					'none'     => 'None',
				],
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label'     => __( 'Animation', 'strollik-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'    => 'Fade',
					'grow'    => 'Grow',
					'shrink'  => 'Shrink',
					'draw'    => 'Draw',
					'corners' => 'Corners',
					'none'    => 'None',
				],
				'condition' => [
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_background',
			[
				'label'     => __( 'Animation', 'strollik-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'fade'                   => 'Fade',
					'grow'                   => 'Grow',
					'shrink'                 => 'Shrink',
					'sweep-left'             => 'Sweep Left',
					'sweep-right'            => 'Sweep Right',
					'sweep-up'               => 'Sweep Up',
					'sweep-down'             => 'Sweep Down',
					'shutter-in-vertical'    => 'Shutter In Vertical',
					'shutter-out-vertical'   => 'Shutter Out Vertical',
					'shutter-in-horizontal'  => 'Shutter In Horizontal',
					'shutter-out-horizontal' => 'Shutter Out Horizontal',
					'none'                   => 'None',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label'     => __( 'Animation', 'strollik-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'grow',
				'options'   => [
					'grow'   => 'Grow',
					'shrink' => 'Shrink',
					'sink'   => 'Sink',
					'float'  => 'Float',
					'skew'   => 'Skew',
					'rotate' => 'Rotate',
					'none'   => 'None',
				],
				'condition' => [
					'pointer' => 'text',
				],
			]
		);

		$this->add_control(
			'indicator',
			[
				'label'        => __( 'Submenu Indicator', 'strollik-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'classic',
				'options'      => [
					'none'    => __( 'None', 'strollik-core' ),
					'classic' => __( 'Classic', 'strollik-core' ),
					'chevron' => __( 'Chevron', 'strollik-core' ),
					'angle'   => __( 'Angle', 'strollik-core' ),
					'plus'    => __( 'Plus', 'strollik-core' ),
				],
				'prefix_class' => 'elementor-nav-menu--indicator-',
			]
		);

		$this->add_responsive_control(
			'subMenusMinWidth',
			[
				'label'   => __( 'Min width Submenu(px)', 'strollik-core' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 50,
						'max' => 100,
					],
				],
				'default' => array(
					'size' => 50
				),
			]
		);


		$this->add_responsive_control(
			'subMenusMaxWidth',
			[
				'label'   => __( 'Max width Submenu(px)', 'strollik-core' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'default' => array(
					'size' => 500
				),
			]
		);

		$this->add_control(
			'heading_mobile_dropdown',
			[
				'label'     => __( 'Mobile Dropdown', 'strollik-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'enable_mobile_dropdown',
			[
				'label'   => __( 'Enable Mobile Menu', 'strollik-core' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'dropdown_layout',
			[
				'label'     => __( 'Style', 'strollik-core' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'dropdown',
				'options'   => [
					'dropdown' => __( 'Dropdown', 'strollik-core' ),
					'canvas'   => __( 'Canvas', 'strollik-core' ),
					'popup'    => __( 'Popup', 'strollik-core' ),
				],
				'condition' => [
					'enable_mobile_dropdown' => 'yes'
				],
			]
		);

		$this->add_control(
			'dropdown',
			[
				'label'        => __( 'Breakpoint', 'strollik-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'tablet',
				'options'      => [
					'mobile' => __( 'Mobile (767px >)', 'strollik-core' ),
					'tablet' => __( 'Tablet (1023px >)', 'strollik-core' ),
					'destop' => __( 'Destop', 'strollik-core' ),
				],
				'prefix_class' => 'elementor-nav-menu--dropdown-',
				'condition'    => [
					'enable_mobile_dropdown' => 'yes',
				],
			]
		);

		$this->add_control(
			'full_width',
			[
				'label'              => __( 'Full Width', 'strollik-core' ),
				'type'               => Controls_Manager::SWITCHER,
				'description'        => __( 'Stretch the dropdown of the menu to full width.', 'strollik-core' ),
				'prefix_class'       => 'elementor-nav-menu--',
				'return_value'       => 'stretch',
				'frontend_available' => true,
				'condition'          => [
					'enable_mobile_dropdown' => 'yes',
					'dropdown_layout'        => 'dropdown'
				],
			]
		);

		$this->add_responsive_control(
			'width_dropdown',
			[
				'label'      => __( 'Width Dropdown', 'strollik-core' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'size' => 500,
					'unit' => 'px'
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown.elementor-nav-menu__container' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'full_width!'            => 'stretch',
					'enable_mobile_dropdown' => 'yes',
					'dropdown_layout'        => 'dropdown'
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'        => __( 'Align', 'strollik-core' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'aside',
				'options'      => [
					'aside'  => __( 'Aside', 'strollik-core' ),
					'center' => __( 'Center', 'strollik-core' ),
				],
				'prefix_class' => 'elementor-nav-menu__text-align-',
				'condition'    => [
					'enable_mobile_dropdown' => 'yes'
				],
			]
		);

		$this->add_control(
			'toggle',
			[
				'label'              => __( 'Toggle Button', 'strollik-core' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'burger',
				'options'            => [
					''       => __( 'None', 'strollik-core' ),
					'burger' => __( 'Hamburger', 'strollik-core' ),
				],
				'prefix_class'       => 'elementor-nav-menu--toggle elementor-nav-menu--',
				'render_type'        => 'template',
				'frontend_available' => true,
				'condition'          => [
					'enable_mobile_dropdown' => 'yes',
				],
			]
		);

		$this->add_control(
			'toggle_align',
			[
				'label'                => __( 'Toggle Align', 'strollik-core' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'center',
				'options'              => [
					'left'   => [
						'title' => __( 'Left', 'strollik-core' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'strollik-core' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'strollik-core' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'margin-right: auto',
					'center' => 'margin: 0 auto',
					'right'  => 'margin-left: auto',
				],
				'selectors'            => [
					'{{WRAPPER}} .elementor-menu-toggle' => '{{VALUE}}',
				],
				'condition'            => [
					'toggle!'                => '',
					'enable_mobile_dropdown' => 'yes',

				],
				'label_block'          => false,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => __( 'Main Menu', 'strollik-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'menu_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-nav-menu--main, #nav-popup-{{ID}} .elementor-nav-menu--popup, #nav-popup-{{ID}} .elementor-nav-menu--popup > ul > li > a',
			]
		);

		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'color_menu_item',
			[
				'label'     => __( 'Text Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item'                              => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-nav-menu--main.e--pointer-dot .elementor-item:before'        => 'background-color: {{VALUE}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup .elementor-item'                       => 'color: {{VALUE}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup.e--pointer-dot .elementor-item:before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'enable_divider',
			[
				'label'     => __( 'Enable Divider', 'strollik-core' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'layout' => 'horizontal',
				],
			]
		);

		$this->add_control(
			'color_divider',
			[
				'label'     => __( 'Divider Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default'   => '',
				'condition' => [
					'enable_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--divider > ul >li:after'       => 'background-color: {{VALUE}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--divider > ul >li:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'height_divider',
			[
				'label'     => __( 'Divider Padding', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--divider > ul >li:after'       => 'height: {{SIZE}}{{UNIT}}; margin-top: calc(-{{SIZE}}{{UNIT}} / 2)',
					'#nav-popup-{{ID}} .elementor-nav-menu--divider > ul >li:after' => 'height: {{SIZE}}{{UNIT}}; margin-top: calc(-{{SIZE}}{{UNIT}} / 2)',
				],
				'condition' => [
					'enable_divider' => 'yes',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'color_menu_item_hover',
			[
				'label'     => __( 'Text Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.highlighted,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus,
					#nav-popup-{{ID}} .elementor-nav-menu--popup .elementor-item:hover,
					#nav-popup-{{ID}} .elementor-nav-menu--popup .elementor-item:focus'                 => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-nav-menu--main.e--pointer-dot .elementor-item:hover:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => 'background',
				],
			]
		);

		$this->add_control(
			'color_menu_item_hover_pointer_bg',
			[
				'label'     => __( 'Text Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item:hover,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item.highlighted,
					{{WRAPPER}} .elementor-nav-menu--main .elementor-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_hover',
			[
				'label'     => __( 'Pointer Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:before,
					{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .elementor-item:before,
					{{WRAPPER}} .e--pointer-framed .elementor-item:after'            => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => __( 'Active', 'strollik-core' ),
			]
		);

		$this->add_control(
			'color_menu_item_active',
			[
				'label'     => __( 'Text Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item.elementor-item-active'                              => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-nav-menu--main.e--pointer-dot .elementor-item.elementor-item-active:before'        => 'background-color: {{VALUE}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup .elementor-item.elementor-item-active'                       => 'color: {{VALUE}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup.e--pointer-dot .elementor-item.elementor-item-active:before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pointer_color_menu_item_active',
			[
				'label'     => __( 'Pointer Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:before,
					{{WRAPPER}} .elementor-nav-menu--main:not(.e--pointer-framed) .elementor-item.elementor-item-active:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:before,
					{{WRAPPER}} .e--pointer-framed .elementor-item.elementor-item-active:after'            => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		/* This control is required to handle with complicated conditions */
		$this->add_control(
			'hr',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'pointer_width',
			[
				'label'     => __( 'Pointer Width', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'devices'   => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET ],
				'range'     => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .e--pointer-framed .elementor-item:before'                         => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:before'       => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .elementor-item:after'        => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:before'    => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .elementor-item:after'     => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--pointer-underline .elementor-item:after,
					 {{WRAPPER}} .e--pointer-overline .elementor-item:before,
					 {{WRAPPER}} .e--pointer-double-line .elementor-item:before,
					 {{WRAPPER}} .e--pointer-double-line .elementor-item:after' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
				],
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label'     => __( 'Horizontal Padding', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'devices'   => [ 'desktop', 'tablet' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item'        => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup .elementor-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
			]
		);


		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label'     => __( 'Vertical Padding', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'devices'   => [ 'desktop', 'tablet' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main .elementor-item'        => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup .elementor-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label'     => __( 'Space Between', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)'                 => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)'                       => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-nav-menu--main:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius_menu_item',
			[
				'label'      => __( 'Border Radius', 'strollik-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-item:before'                                     => 'border-radius: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:before' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--animation-shutter-in-horizontal .elementor-item:after'  => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:before'   => 'border-radius: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--animation-shutter-in-vertical .elementor-item:after'    => 'border-radius: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					'pointer' => 'background',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label'     => __( 'Dropdown', 'strollik-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_mobile_dropdown' => 'yes',
					'dropdown_layout'        => 'dropdown',
					'dropdown_layout'        => 'popup'
				],
			]
		);

		$this->add_control(
			'dropdown_description',
			[
				'raw'             => __( 'On desktop, this will affect the submenu. On mobile, this will affect the entire menu.', 'strollik-core' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->start_controls_tabs( 'tabs_dropdown_item_style' );

		$this->start_controls_tab(
			'tab_dropdown_item_normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'color_dropdown_item',
			[
				'label'     => __( 'Text Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a, #nav-popup-{{ID}} .elementor-nav-menu--dropdown a, {{WRAPPER}} .elementor-menu-toggle' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item',
			[
				'label'     => __( 'Background Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown, #nav-popup-{{ID}} .elementor-nav-menu--dropdown' => 'background-color: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dropdown_item_hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'color_dropdown_item_hover',
			[
				'label'     => __( 'Text Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a:hover, {{WRAPPER}} .elementor-menu-toggle:hover, #nav-popup-{{ID}} .elementor-nav-menu--dropdown a:hover, #nav-popup-{{ID}} .elementor-menu-toggle:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'background_color_dropdown_item_hover',
			[
				'label'     => __( 'Background Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a:hover, {{WRAPPER}} .elementor-nav-menu--dropdown a.highlighted'             => 'background-color: {{VALUE}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown a:hover, #nav-popup-{{ID}} .elementor-nav-menu--dropdown a.highlighted' => 'background-color: {{VALUE}}'
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'dropdown_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'exclude'   => [ 'line_height' ],
				'selector'  => '{{WRAPPER}} .elementor-nav-menu--dropdown, #nav-popup-{{ID}} .elementor-nav-menu--dropdown',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'dropdown_border',
				'selector'  => '{{WRAPPER}} .elementor-nav-menu--dropdown, #nav-popup-{{ID}} .elementor-nav-menu--dropdown',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'dropdown_border_radius',
			[
				'label'      => __( 'Border Radius', 'strollik-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown'                        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-nav-menu--dropdown li:first-child a'       => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} .elementor-nav-menu--dropdown li:last-child a'        => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown'                  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown li:last-child a'  => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'dropdown_box_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .elementor-nav-menu--main .elementor-nav-menu--dropdown, {{WRAPPER}} .elementor-nav-menu__container.elementor-nav-menu--dropdown ,#nav-popup-{{ID}} .elementor-nav-menu--main .elementor-nav-menu--dropdown, #nav-popup-{{ID}} .elementor-nav-menu__container.elementor-nav-menu--dropdown',
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_dropdown_item',
			[
				'label'     => __( 'Horizontal Padding', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a'       => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',

			]
		);

		$this->add_responsive_control(
			'padding_vertical_dropdown_item',
			[
				'label'     => __( 'Vertical Padding', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown a'       => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_dropdown_divider',
			[
				'label'     => __( 'Divider', 'strollik-core' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'dropdown_divider',
				'selector' => '{{WRAPPER}} .elementor-nav-menu--dropdown li:not(:last-child), #nav-popup-{{ID}} .elementor-nav-menu--dropdown li:not(:last-child)',
				'exclude'  => [ 'width' ],
			]
		);

		$this->add_control(
			'dropdown_divider_width',
			[
				'label'     => __( 'Border Width', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--dropdown li:not(:last-child)'       => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					'#nav-popup-{{ID}} .elementor-nav-menu--dropdown li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dropdown_divider_border!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'dropdown_top_distance',
			[
				'label'     => __( 'Distance', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-nav-menu--main > .elementor-nav-menu > li > .elementor-nav-menu--dropdown, {{WRAPPER}} .elementor-nav-menu__container.elementor-nav-menu--dropdown'              => 'margin-top: {{SIZE}}{{UNIT}} !important',
					'#nav-popup-{{ID}} .elementor-nav-menu--popup > .elementor-nav-menu > li > .elementor-nav-menu--dropdown, #nav-popup-{{ID}} .elementor-nav-menu__container.elementor-nav-menu--dropdown' => 'margin-top: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'dropdown_padding',
			[
				'label'      => __( 'Padding', 'strollik-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .sub-menu.elementor-nav-menu--dropdown'       => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'#nav-popup-{{ID}} .sub-menu.elementor-nav-menu--dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_dropdown',
			[
				'label'     => __( 'Canvas', 'strollik-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_mobile_dropdown' => 'yes',
					'dropdown_layout'        => 'canvas'
				],
			]
		);
		$this->end_controls_section();


		$this->start_controls_section( 'style_toggle',
			[
				'label'     => __( 'Toggle Button', 'strollik-core' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'toggle!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_style' );

		$this->start_controls_tab(
			'tab_toggle_style_normal',
			[
				'label' => __( 'Normal', 'strollik-core' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label'     => __( 'Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.elementor-menu-toggle, {{WRAPPER}} a.elementor-menu-toggle' => 'color: {{VALUE}}',
					// Harder selector to override text color control
				],
			]
		);

		$this->add_control(
			'toggle_background_color',
			[
				'label'     => __( 'Background Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_style_hover',
			[
				'label' => __( 'Hover', 'strollik-core' ),
			]
		);

		$this->add_control(
			'toggle_color_hover',
			[
				'label'     => __( 'Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} div.elementor-menu-toggle:hover, {{WRAPPER}} a.elementor-menu-toggle:hover' => 'color: {{VALUE}}',
					// Harder selector to override text color control
				],
			]
		);

		$this->add_control(
			'toggle_background_color_hover',
			[
				'label'     => __( 'Background Color', 'strollik-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_size',
			[
				'label'     => __( 'Size', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'toggle_border_width',
			[
				'label'     => __( 'Border Width', 'strollik-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'toggle_border_radius',
			[
				'label'      => __( 'Border Radius', 'strollik-core' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_padding',
			[
				'label'      => __( 'Padding', 'strollik-core' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$available_menus = $this->get_available_menus();

		if ( ! $available_menus ) {
			return;
		}

		$settings = $this->get_active_settings();

		$args = [
			'echo'        => false,
			'menu'        => $settings['menu'],
			'menu_class'  => 'elementor-nav-menu',
			'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container'   => '',
		];

		$args_canvas = [
			'echo'        => false,
			'menu'        => $settings['menu'],
			'menu_class'  => 'nav-menu--canvas',
			'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
			'fallback_cb' => '__return_empty_string',
			'container'   => '',
		];

		if ( 'vertical' === $settings['layout'] ) {
			$args['menu_class'] .= ' sm-vertical';
		}

		// Add custom filter to handle Nav Menu HTML output.
		add_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ], 10, 4 );
		add_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
		add_filter( 'nav_menu_item_id', '__return_empty_string' );

		// General Menu.
		$menu_html = wp_nav_menu( $args );

		// Dropdown Menu.
		$args['menu_id']    = 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id();
		$dropdown_menu_html = wp_nav_menu( $args );

		// Remove all our custom filters.
		remove_filter( 'nav_menu_link_attributes', [ $this, 'handle_link_classes' ] );
		remove_filter( 'nav_menu_submenu_css_class', [ $this, 'handle_sub_menu_classes' ] );
		remove_filter( 'nav_menu_item_id', '__return_empty_string' );

		// Canvas Menu
		$menu_canvas_html = wp_nav_menu( $args_canvas );

		if ( empty( $menu_html ) ) {
			return;
		}
		if ( $settings['enable_mobile_dropdown'] === 'yes' ) {
			$this->add_render_attribute( 'menu-toggle', 'class', [
				'elementor-menu-toggle',
			] );
			$this->add_render_attribute( 'menu-toggle', 'data-target', [
				'#menu-' . $this->get_id(),
			] );

			$this->add_render_attribute( 'main-menu', 'class', 'elementor-nav-menu--mobile-enable' );
		}

		$this->add_render_attribute( 'main-menu', 'data-subMenusMinWidth', $settings['subMenusMinWidth']['size'] );
		$this->add_render_attribute( 'main-menu', 'data-subMenusMaxWidth', $settings['subMenusMaxWidth']['size'] );


		$this->add_render_attribute( 'main-menu', 'class', [
			'elementor-nav-menu--main',
			'elementor-nav-menu__container',
			'elementor-nav-menu--layout-' . $settings['layout'],
		] );

		if ( $settings['enable_divider'] === 'yes' ) {
			$this->add_render_attribute( 'main-menu', 'class', 'elementor-nav-menu--divider' );
		}

		if ( $settings['pointer'] ) :
			$this->add_render_attribute( 'main-menu', 'class', 'e--pointer-' . $settings['pointer'] );

			foreach ( $settings as $key => $value ) :
				if ( 0 === strpos( $key, 'animation' ) && $value ) :
					$this->add_render_attribute( 'main-menu', 'class', 'e--animation-' . $value );

					break;
				endif;
			endforeach;
		endif; ?>
        <nav <?php echo $this->get_render_attribute_string( 'main-menu' ); ?>><?php echo $menu_html; ?></nav>
		<?php

		if ( $settings['enable_mobile_dropdown'] === 'yes' ):

			if ( $settings['dropdown_layout'] === 'canvas' ) {
				?>

                <div <?php echo $this->get_render_attribute_string( 'menu-toggle' ); ?>>
                    <i class="eicon" aria-hidden="true"></i>
                </div>
                <nav id="menu-<?php echo esc_attr( $this->get_id() ); ?>"
                     class="elementor-nav-menu--canvas mp-menu"><?php echo $menu_canvas_html; ?></nav>
				<?php
			} elseif ( $settings['dropdown_layout'] === 'popup' ) {

				$this->add_render_attribute( 'button-popup', 'href', '#nav-popup-' . esc_attr( $this->get_id() ) );
				$this->add_render_attribute( 'button-popup', 'role', 'button' );
				$this->add_render_attribute( 'button-popup', 'class', 'elementor-menu-popup elementor-menu-toggle' );
				$this->add_render_attribute( 'button-popup', 'data-effect', 'mfp-zoom-in' );
				?>
                <a <?php echo $this->get_render_attribute_string( 'button-popup' ); ?>>
                    <i class="eicon" aria-hidden="true"></i>
                </a>
                <div id="nav-popup-<?php echo esc_attr( $this->get_id() ); ?>"
                     class="mfp-hide elementor-nav-menu-popup elementor-nav-menu__text-align-center">
                    <nav class="elementor-nav-menu--popup elementor-nav-menu__container elementor-nav-menu--indicator-<?php echo esc_attr( $settings['indicator'] ); ?>"><?php echo $dropdown_menu_html; ?></nav>
                </div>
				<?php
			} else {
				?>
                <div <?php echo $this->get_render_attribute_string( 'menu-toggle' ); ?>>
                    <i class="eicon" aria-hidden="true"></i>
                </div>
                <nav class="elementor-nav-menu--dropdown elementor-nav-menu__container"><?php echo $dropdown_menu_html; ?></nav>
			<?php }
		endif;
	}

	public function handle_link_classes( $atts, $item, $args, $depth ) {
		$classes = $depth ? 'elementor-sub-item' : 'elementor-item';

		if ( in_array( 'current-menu-item', $item->classes ) ) {
			$classes .= '  elementor-item-active';
		}

		if ( empty( $atts['class'] ) ) {
			$atts['class'] = $classes;
		} else {
			$atts['class'] .= ' ' . $classes;
		}

		return $atts;
	}

	public function handle_sub_menu_classes( $classes ) {
		$classes[] = 'elementor-nav-menu--dropdown';

		return $classes;
	}

	public function render_plain_content() {
	}
}

