<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Tabs extends  Elementor\Widget_Base{

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Opal Tabs', 'strollik-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $templates = Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();

        $options = [
            '0' => '— ' . __( 'Select', 'strollik-core' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __( 'Tabs', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => __( 'Tabs Items', 'strollik-core' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'tab_title' => __( 'Tab #1', 'strollik-core' ),
                        'source' => 'html',
                        'tab_html' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'strollik-core' ),
                    ],
                    [
                        'tab_title' => __( 'Tab #2', 'strollik-core' ),
                        'source' => 'html',
                        'tab_html' => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'strollik-core' ),
                    ],
                ],
                'fields' => [
                    [
                        'name' => 'tab_title',
                        'label' => __( 'Title & Content', 'strollik-core' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => __( 'Tab Title', 'strollik-core' ),
                        'placeholder' => __( 'Tab Title', 'strollik-core' ),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'source',
                        'label' => __( 'Source', 'strollik-core' ),
                        'type' => Controls_Manager::SELECT,
                        'default' => 'html',
                        'options' => [
                            'html' => __( 'HTML', 'strollik-core' ),
                            'template' => __( 'Template', 'strollik-core' ),
                        ],
                    ],
                    [
                        'name' => 'tab_html',
                        'label' => __( 'Content', 'strollik-core' ),
                        'default' => __( 'Tab Content', 'strollik-core' ),
                        'placeholder' => __( 'Tab Content', 'strollik-core' ),
                        'type' => Controls_Manager::WYSIWYG,
                        'show_label' => false,
                        'condition' => [
                            'source' => 'html',
                        ],
                    ],
                    [
                        'name' => 'tab_template',
                        'label' => __( 'Choose Template', 'strollik-core' ),
                        'default' => 0,
                        'type' => Controls_Manager::SELECT,
                        'options' => $options,
                        'types' => $types,
                        'label_block'  => 'true',
                        'condition' => [
                            'source' => 'template',
                        ],
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'View', 'strollik-core' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => __( 'Type', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => __( 'Horizontal', 'strollik-core' ),
                    'vertical' => __( 'Vertical', 'strollik-core' ),
                ],
                'prefix_class' => 'elementor-tabs-view-',
                'separator' => 'before',
            ]
        );

	    $this->add_control(
		    'align_items',
		    [
			    'label'        => __('Align', 'strollik-core'),
			    'type'         => Controls_Manager::CHOOSE,
			    'label_block'  => false,
			    'options'      => [
				    'flex-start'    => [
					    'title' => __('Left', 'strollik-core'),
					    'icon'  => 'eicon-h-align-left',
				    ],
				    'center'  => [
					    'title' => __('Center', 'strollik-core'),
					    'icon'  => 'eicon-h-align-center',
				    ],
				    'flex-end'   => [
					    'title' => __('Right', 'strollik-core'),
					    'icon'  => 'eicon-h-align-right',
				    ],
			    ],
//			    'prefix_class' => 'opal-tab-title-align-',
			    'condition'    => [
				    'type' => 'horizontal',
			    ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'display: flex; flex-wrap: wrap; justify-content: {{VALUE}};',
                ],
                'default' => 'flex-start',
		    ]
	    );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => __( 'Tabs', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'navigation_width',
            [
                'label' => __( 'Navigation Width', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->add_control(
            'background_tabs',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_tabs',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-tabs',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tabs_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tabs_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Title', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_responsive_control(
            'tab_title_width',
            [
                'label'     => __('Width', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_height',
            [
                'label'     => __('Heigth', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'background-color: {{VALUE}};'
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __( 'Hover', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_hover_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'title_hover_border_color',
            [
                'label' => __( 'Border Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title:hover' => 'border-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __( 'Active', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_active_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'title_active_border_color',
            [
                'label' => __( 'Border Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title.elementor-active' => 'border-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'tab_title_align',
            [
                'label' => __( 'Alignment', 'strollik-core' ),
                'type' => Controls_Manager::CHOOSE,
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_tabs_title',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tabs_title_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label' => __( 'Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __( 'Content', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_content',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label' => __( 'Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $tabs = $this->get_settings_for_display( 'tabs' );

        $id_int = substr( $this->get_id_int(), 0, 3 );
        ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
                <?php
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;

                    $class = ($index == 0)? 'elementor-active' : '';

                    $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

                    $this->add_render_attribute( $tab_title_setting_key, [
                        'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-title', 'elementor-tab-desktop-title', $class],
                        'data-tab' => $tab_count,
                        'tabindex' => $id_int . $tab_count,
                        'role' => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ] );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>><?php echo $item['tab_title']; ?></div>
                <?php endforeach; ?>
            </div>
            <div class="elementor-tabs-content-wrapper">
                <?php
                foreach ( $tabs as $index => $item ) :
                    $tab_count = $index + 1;

                    $class_content = ($index == 0)? 'elementor-active' : '';

                    $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                    $this->add_render_attribute( $tab_content_setting_key, [
                        'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class' => [ 'elementor-tab-content', 'elementor-clearfix', $class_content],
                        'data-tab' => $tab_count,
                        'role' => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                    ] );

                    $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
                        <?php if('html' === $item['source']): ?>
                            <?php echo do_shortcode( $item['tab_html']); ?>
                        <?php else: ?>
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $item['tab_template'] ); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
