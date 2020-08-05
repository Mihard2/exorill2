<?php

use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Video_Popup extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-video-popup';
    }

    public function get_title() {
        return __('Opal Video', 'strollik-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

	public function get_script_depends() {
		return ['magnific-popup'];
	}

	public function get_style_depends() {
		return ['magnific-popup'];
	}


    protected function _register_controls() {
        $this->start_controls_section(
            'section_videos',
            [
                'label' => __('General', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => __( 'Link to', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'description' => __('Support video from Youtube and Vimeo', 'strollik-core'),
                'placeholder' => __( 'https://your-link.com', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Tile', 'strollik-core' ),
            ]
        );

        $this->add_responsive_control(
            'video_align',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_font',
            [
                'label' => __( 'Icon Font', 'strollik-core' ),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => 'fa fa-play-circle-o',
            ]
        );

        $this->end_controls_section();

        //Wrapper
        $this->start_controls_section(
            'section_video_wrapper',
            [
                'label' => __( 'Wrapper', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_wrapper_style' );

        $this->start_controls_tab(
            'tab_wrapper_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'background_wrapper',
            [
                'label' => __( 'Background', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [
                'label' => __( 'Hover', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'background_wrapper_hover',
            [
                'label' => __( 'Background', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_wrapper_hover',
            [
                'label' => __( 'Border Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name' => 'border_wrapper',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-video-popup',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Icon
        $this->start_controls_section(
            'section_video_style',
            [
                'label' => __( 'Icon', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_size',
            [
                'label'     => __('Font Size', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_width',
            [
                'label'     => __('Width', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_height',
            [
                'label'     => __('Height', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_video_style' );

        $this->start_controls_tab(
            'tab_video_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'video_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_background_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_video_hover',
            [
                'label' => __( 'Hover', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'video_hover_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup :hover .elementor-video-icon' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'video_hover_background_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup :hover .elementor-video-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_hover_border_color',
            [
                'label' => __( 'Border Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup :hover .elementor-video-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_video',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .opal-video-popup .elementor-video-icon',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'video_border_radius',
            [
                'label' => __('Border Radius', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_padding',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'video_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //title
        $this->start_controls_section(
            'section_video_title',
            [
                'label' => __( 'Title', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Color Hover', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover .elementor-video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .opal-video-popup .elementor-video-title',
            ]
        );

        $this->add_control(
            'show_title_block',
            [
                'label' => __( 'Style Block', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'strollik-core' ),
                'label_on' => __( 'On', 'strollik-core' ),
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-popup' => 'flex-direction: column;',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if(empty($settings['video_link'])){
            return;
        }

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-video-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-video-popup' );

        $this->add_render_attribute( 'button', 'class', 'elementor-video-popup' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        $this->add_render_attribute( 'button', 'href',  esc_url( $settings['video_link']));
        $this->add_render_attribute( 'button', 'data-effect', 'mfp-zoom-in' );

        $contentHtml = '<i class="'. esc_attr( $settings['icon_font'] ).'"></i>';

        $titleHtml = !empty($settings['title']) ? '<span class="elementor-video-title">'.$settings['title'].'</span>' : '';


        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                <span class="elementor-video-icon"><?php echo $contentHtml; ?></span>
                <?php echo ($titleHtml);?>
            </a>

        </div>
        <?php
    }

}