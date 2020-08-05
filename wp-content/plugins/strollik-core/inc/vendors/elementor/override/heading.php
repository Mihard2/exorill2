<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class OSF_Elementor_Heading extends Widget_Heading
{

    public function get_title()
    {
        return __('Opal Heading', 'strollik-core');
    }

    public function get_keywords()
    {
        return ['heading', 'title', 'text'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'strollik-core'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'strollik-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Enter your title', 'strollik-core'),
                'default' => __('Add Your Heading Text Here', 'strollik-core'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link', 'strollik-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => '',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => __('Size', 'strollik-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'strollik-core'),
                    'small' => __('Small', 'strollik-core'),
                    'medium' => __('Medium', 'strollik-core'),
                    'large' => __('Large', 'strollik-core'),
                    'xl' => __('XL', 'strollik-core'),
                    'xxl' => __('XXL', 'strollik-core'),
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label' => __('HTML Tag', 'strollik-core'),
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
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __('Alignment', 'strollik-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'strollik-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'strollik-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'strollik-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'strollik-core'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __('View', 'strollik-core'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'strollik-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color_style',
            [
                'label' => __('Color Gradient', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'gradian',
                'prefix_class' => 'elementor-heading-'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Text Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}}.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title_color_style' => ''
                ]
            ]
        );

        $this->add_control(
            'title_color_gradian',
            [
                'label' => __('Text Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default' => '#30aece',
                'condition' => [
                    'title_color_style!' => ''
                ],
            ]
        );

        $this->add_control(
            'location_color',
            [
                'label' => __('Location', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'render_type' => 'ui',
                'condition' => [
                    'title_color_style!' => ''
                ],

            ]
        );

        $this->add_control(
            'title_color_gradian_secondary',
            [
                'label' => __('Color Secondary', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default' => '#0048ce',
                'condition' => [
                    'title_color_style!' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-heading-gradian .elementor-heading-title' => 'background: -webkit-linear-gradient({{angle_gradian.SIZE}}{{angle_gradian.UNIT}}, {{title_color_gradian.VALUE}} {{location_color.SIZE}}{{location_color.UNIT}} , {{VALUE}} {{location_secondary.SIZE}}{{location_secondary.UNIT}} ); -webkit-background-clip: text; -webkit-text-fill-color: transparent;',
                ],
            ]
        );

        $this->add_control(
            'location_secondary',
            [
                'label' => __('Location', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'render_type' => 'ui',
                'condition' => [
                    'title_color_style!' => ''
                ],

            ]
        );

        $this->add_control(
            'angle_gradian',
            [
                'label' => __('Angle', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'default' => [
                    'unit' => 'deg',
                    'size' => 0,
                ],
                'range' => [
                    'deg' => [
                        'step' => 10,
                    ],
                ],
                'condition' => [
                    'title_color_style!' => ''
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label' => __('Blend Mode', 'strollik-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('Normal', 'strollik-core'),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'difference' => 'Difference',
                    'exclusion' => 'Exclusion',
                    'hue' => 'Hue',
                    'luminosity' => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'show_dot_style',
            [
                'label' => __('Dot', 'strollik-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_dot_before',
            [
                'label' => __('Dot Before', 'strollik-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_dot_before',
            [
                'label' => __('Show', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('Off', 'strollik-core'),
                'label_on' => __('On', 'strollik-core'),
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'position: relative; z-index: 2',
                    '{{WRAPPER}} .elementor-heading-title:before' => 'content: "";position: relative;display: inline-block;vertical-align: middle;z-index: -1',
                ],
            ]
        );
        $this->add_control(
            'dot_before_background_color',
            [
                'label' => __('Background Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'condition' => [
                    'show_dot_before' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_before_width',
            [
                'label' => __('Width', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'show_dot_before' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:before' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'dot_before_height',
            [
                'label' => __('Height', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'show_dot_before' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_before_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'show_dot_before' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_before_border_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'show_dot_before' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'heading_dot_after',
            [
                'label' => __('Dot After', 'strollik-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_dot_after',
            [
                'label' => __('Show', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('Off', 'strollik-core'),
                'label_on' => __('On', 'strollik-core'),
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'position: relative; z-index: 2',
                    '{{WRAPPER}} .elementor-heading-title:after' => 'content: "";position: relative;display: inline-block;vertical-align: middle;z-index: -1',
                ],
            ]
        );
        $this->add_control(
            'dot_after_background_color',
            [
                'label' => __('Background Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'condition' => [
                    'show_dot_after' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_after_width',
            [
                'label' => __('Width', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'show_dot_after' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'dot_after_height',
            [
                'label' => __('Height', 'strollik-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'show_dot_after' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_after_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'show_dot_after' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'dot_after_border_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'condition' => [
                    'show_dot_after' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title:after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['title'])) {
            return;
        }

        $this->add_render_attribute('title', 'class', 'elementor-heading-title');

        if (!empty($settings['size'])) {
            $this->add_render_attribute('title', 'class', 'elementor-size-' . $settings['size']);
        }

        $this->add_inline_editing_attributes('title');

        $title = $settings['title'];

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('url', 'href', $settings['link']['url']);

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('url', 'target', '_blank');
            }

            if (!empty($settings['link']['nofollow'])) {
                $this->add_render_attribute('url', 'rel', 'nofollow');
            }

            $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
        }

        $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'), $title);

        echo $title_html;
    }

    /**
     * Render heading widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _content_template()
    {
        ?>
        <#
        var title = settings.title;

        if ( '' !== settings.link.url ) {
        title = '<a href="' + settings.link.url + '">' + title + '</a>';
        }

        view.addRenderAttribute( 'title', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );

        view.addInlineEditingAttributes( 'title' );

        var title_html = '<' + settings.header_size  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + settings.header_size + '>';

        print( title_html );
        #>
        <?php
    }
}
