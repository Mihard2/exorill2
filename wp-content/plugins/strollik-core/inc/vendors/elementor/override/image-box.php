<?php

namespace Elementor;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class OSF_Widget_Image_Box extends Widget_Image_Box {

    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'image-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Image Box', 'strollik-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    /**
     * Register image box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image Box', 'strollik-core'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __('Choose Image', 'strollik-core'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'view_style',
            [
                'label' => __( 'View', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __( 'Default', 'strollik-core' ),
                    'stacked' => __( 'Stacked', 'strollik-core' ),
                    'framed' => __( 'Framed', 'strollik-core' ),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-',
                'condition' => [
                    'image!' => '',
                ],
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => __( 'Shape', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => __( 'Circle', 'strollik-core' ),
                    'square' => __( 'Square', 'strollik-core' ),
                ],
                'default' => 'circle',
                'condition' => [
                    'view_style!' => 'default',
                    'image!' => '',
                ],
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'       => __('Title & Description', 'strollik-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('This is the heading', 'strollik-core'),
                'placeholder' => __('Enter your title', 'strollik-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_title_text',
            [
                'label'       => __('Sub Title', 'strollik-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your sub-title', 'strollik-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label'       => __('Description', 'strollik-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'strollik-core'),
                'placeholder' => __('Enter your description', 'strollik-core'),
                'separator'   => 'none',
                'rows'        => 10,
            ]
        );
        $this->add_control(
            'hover_animation_wrapper',
            [
                'label' => __( 'Hover Wrapper Animation', 'strollik-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'prefix_class' => 'elementor-animation-',
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link to', 'strollik-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'strollik-core'),
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'link_download',
            [
                'label'       => __('Donload Link ?', 'strollik-core'),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'position',
            [
                'label'        => __('Image Position', 'strollik-core'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'top',
                'options'      => [
                    'left'  => [
                        'title' => __('Left', 'strollik-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'top'   => [
                        'title' => __('Top', 'strollik-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'strollik-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle'       => false,
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label'   => __('Title HTML Tag', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __('View', 'strollik-core'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label'     => __('Spacing', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .elementor-image-box-img'  => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .elementor-image-box-img'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .elementor-image-box-img'                  => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label'          => __('Width', 'strollik-core'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'size' => 80,
                    'unit' => 'px',
                ],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ]

                ],
                'size_units' => [
                    'px', '%'
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'          => __('Height', 'strollik-core'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'size' => 80,
                    'unit' => 'px',
                ],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ]

                ],
                'size_units' => [
                    'px', '%'
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_image_hover_style');

        $this->start_controls_tab(
            'tab_image_hover_style_normal',
            [
                'label' => __('Normal', 'elementor-pro'),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     => __('Opacity', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_hover_style_hover',
            [
                'label' => __('Hover', 'elementor-pro'),
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label'     => __('Opacity', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'strollik-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();




        $this->start_controls_section(
            'section_style_svg',
            [
                'label' => __('SVG', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'svg_size',
            [
                'label'          => __('SVG Size', 'strollik-core'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'size' => 46,
                    'unit' => 'px',
                ],
                'range'          => [
                    'min' => 5,
                    'max' => 100,
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-image-box-img svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_svg_style');

        $this->start_controls_tab(
            'svg_button_normal',
            [
                'label' => __('Normal', 'strollik-core'),
            ]
        );

        $this->add_control(
            'svg_color',
            [
                'label'     => __('SVG Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'svg_button_hover',
            [
                'label' => __('Hover', 'strollik-core'),
            ]
        );

        $this->add_control(
            'svg_hover_color',
            [
                'label'     => __('SVG Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();



        $this->start_controls_section(
            'config_box_view_section',
            [
                'label' => __('Box View', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'view_style!' => 'default',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view_style!' => 'default',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_width_box',
            [
                'label'     => __('Border Width', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'view_style' => 'framed',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_view_style');

        $this->start_controls_tab(
            'view_button_normal',
            [
                'label' => __('Normal', 'strollik-core'),
            ]
        );

        $this->add_control(
            'view_bg',
            [
                'label'     => __('Box View Background', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'framed_color',
            [
                'label'     => __('Border Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view_style' => 'framed',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'view_button_hover',
            [
                'label' => __('Hover', 'strollik-core'),
            ]
        );

        $this->add_control(
            'view_bg_hover',
            [
                'label'     => __('Box View Background', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'framed_color_hover',
            [
                'label'     => __('Border Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view_style' => 'framed',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => __('Alignment', 'strollik-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __('Left', 'strollik-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'strollik-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'strollik-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'strollik-core'),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_vertical_alignment',
            [
                'label'        => __('Vertical Alignment', 'strollik-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'top'    => __('Top', 'strollik-core'),
                    'middle' => __('Middle', 'strollik-core'),
                    'bottom' => __('Bottom', 'strollik-core'),
                ],
                'default'      => 'top',
                'prefix_class' => 'elementor-vertical-align-',
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label'     => __('Title', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label'     => __('Spacing', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Color Hover (Wrapper)', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );



        $this->add_control(
            'sub_heading_title',
            [
                'label'     => __('Sub Title', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'sub_title_bottom_space',
            [
                'label'     => __('Spacing', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'heading_sub_title',
            [
                'label'     => __('Sub-title', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );




        $this->add_control(
            'sub_title_color',
            [
                'label'     => __('Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );



        $this->add_control(
            'heading_description',
            [
                'label'     => __('Description', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'description_color',
            [
                'label'     => __('Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $has_content = ! empty( $settings['title_text'] ) || ! empty( $settings['description_text'] );
        $this->add_render_attribute('wrapper', 'class', 'elementor-image-box-wrapper');
//        if ( $settings['hover_animation_wrapper'] ) {
//            $this->add_render_attribute( 'wrapper', 'class', 'elementor-animation-' . $settings['hover_animation_wrapper'] );
//        }

        $html = '<div '.$this->get_render_attribute_string("wrapper").'>';

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'link', 'href', $settings['link']['url'] );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }

            if ( ! empty( $settings['link']['nofollow'] ) ) {
                $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            }

            if($settings['link_download'] === 'yes'){
                $this->add_render_attribute( 'link', 'download' );
            }
        }

        if ( ! empty( $settings['image']['url'] ) ) {
            $this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
            $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['image'] ) );
            $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['image'] ) );

            if ( $settings['hover_animation'] ) {
                $this->add_render_attribute( 'image', 'class', 'elementor-animation-' . $settings['hover_animation'] );
            }
            $this->add_render_attribute( 'image-wrapper', 'class', 'elementor-image-box-img');
            if($settings['view_style'] !== 'default' && $settings['view_style']){
                $this->add_render_attribute( 'image-wrapper', 'class', 'elementor-icon');
            }

            $image_url = '';
            $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
            if(!empty($settings['image']['url'])){
                $image_url = $settings['image']['url'];
                $path_parts = pathinfo($image_url);
                if ($path_parts['extension'] === 'svg') {
                    $image   = $this->get_settings_for_display('image');
//                    var_dump($image);
                    if($image['id']){
                        $pathSvg = get_attached_file($image['id']);
                        $image_html = osf_get_icon_svg($pathSvg);
                    }
//                    else{
//                        $image_html = osf_get_icon_svg_uri($image['url']);
//                    }
                }
            }


            if ( ! empty( $settings['link']['url'] ) ) {
                $image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
            }
            $html .= '<div class="elementor-image-framed">';
            $html .= '<figure '.$this->get_render_attribute_string("image-wrapper").'>' . $image_html . '</figure>';
            $html .= '</div>';
        }

        if ( $has_content ) {
            $html .= '<div class="elementor-image-box-content">';

            if(!empty($settings['sub_title_text'])){
                $this->add_render_attribute('sub_title_text', 'class', 'elementor-image-box-sub-title');
                $html .= '<div '.$this->get_render_attribute_string("sub_title_text").'>'.$settings["sub_title_text"].'</div>';
            }

            if ( ! empty( $settings['title_text'] ) ) {
                $this->add_render_attribute( 'title_text', 'class', 'elementor-image-box-title' );

                $this->add_inline_editing_attributes( 'title_text', 'none' );

                $title_html = $settings['title_text'];

                if ( ! empty( $settings['link']['url'] ) ) {
                    $title_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $title_html . '</a>';
                }

                $html .= sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string( 'title_text' ), $title_html );
            }

            if ( ! empty( $settings['description_text'] ) ) {
                $this->add_render_attribute( 'description_text', 'class', 'elementor-image-box-description' );

                $this->add_inline_editing_attributes( 'description_text' );

                $html .= sprintf( '<p %1$s>%2$s</p>', $this->get_render_attribute_string( 'description_text' ), $settings['description_text'] );
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        echo $html;
    }

    protected function _content_template() {
        return;
        ?>
        <#
        view.addRenderAttribute( 'wrapper', 'class', 'elementor-image-box-wrapper' );
        var html = '<div '+ view.getRenderAttributeString("wrapper") +'>';

        if ( settings.image.url ) {
        var image = {
        id: settings.image.id,
        url: settings.image.url,
        size: settings.thumbnail_size,
        dimension: settings.thumbnail_custom_dimension,
        model: view.getEditModel()
        };

        var image_url = elementor.imagesManager.getImageUrl( image );
        if(image_url.substr((image_url.lastIndexOf('.') + 1)) === 'svg'){
        var imageHtml = '<object data="'+image_url+'" type="image/svg+xml"></object>';
        }else{
        var imageHtml = '<img src="' + image_url + '" class="elementor-animation-' + settings.hover_animation + '" />';
        }

        if ( settings.link.url ) {
        imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
        }

        view.addRenderAttribute( 'image-wrapper', 'class', 'elementor-image-box-img' );
        if(settings.view_style !== 'default'){
        view.addRenderAttribute( 'image-wrapper', 'class', 'elementor-icon' );
        }
        html += '<div class="elementor-image-framed">';
            html += '<figure ' + view.getRenderAttributeString( 'image-wrapper' ) + '>' + imageHtml + '</figure>';
            html += '</div>';
        }

        var hasContent = !! ( settings.title_text || settings.description_text );

        if ( hasContent ) {
        html += '<div class="elementor-image-box-content">';
            if ( settings.sub_title_text ) {
            html += '<div class="elementor-image-box-sub-title">' + settings.sub_title_text + '</div>';
            }
            if ( settings.title_text ) {
            var title_html = settings.title_text;

            if ( settings.link.url ) {
            title_html = '<a href="' + settings.link.url + '">' + title_html + '</a>';
            }

            view.addRenderAttribute( 'title_text', 'class', 'elementor-image-box-title' );

            view.addInlineEditingAttributes( 'title_text', 'none' );

            html += '<' + settings.title_size  + ' ' + view.getRenderAttributeString( 'title_text' ) + '>' + title_html + '</' + settings.title_size  + '>';
        }

        if ( settings.description_text ) {
        view.addRenderAttribute( 'description_text', 'class', 'elementor-image-box-description' );

        view.addInlineEditingAttributes( 'description_text' );

        html += '<p ' + view.getRenderAttributeString( 'description_text' ) + '>' + settings.description_text + '</p>';
        }

        html += '</div>';
        }

        html += '</div>';

        print( html );
        #>
        <?php
    }
}
