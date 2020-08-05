<?php

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Element_Social_Share extends Elementor\Widget_Base {

    public function get_name() {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'opal-social-share';
    }

    public function get_title() {
        return __( 'Opal Social Share', 'strollik-core' );
    }

    public function get_icon() {
        return 'eicon-share';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    public function socials(){
        return [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'google_plus' => 'Google+',
            'linkedin' => 'LinkedIn',
            'pinterest' => 'Pinterest',
            'tumblr' => 'Tumblr',
            'envelope' => 'Email'
        ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_buttons_content',
            [
                'label' => __( 'Share Buttons', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'socials',
            [
                'label' => __( 'Select Socials', 'strollik-core' ),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->socials(),
                'multiple' => true,
            ]
        );



        $this->add_control(
            'skin',
            [
                'label' => __( 'Skin', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'gradient' => __( 'Gradient', 'strollik-core' ),
                    'minimal' => __( 'Minimal', 'strollik-core' ),
                    'framed' => __( 'Framed', 'strollik-core' ),
                    'boxed' => __( 'Boxed Icon', 'strollik-core' ),
                    'flat' => __( 'Flat', 'strollik-core' ),
                ],
                'default' => 'gradient',
                'prefix_class' => 'elementor-share-buttons--skin-',
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => __( 'Shape', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'square' => __( 'Square', 'strollik-core' ),
                    'rounded' => __( 'Rounded', 'strollik-core' ),
                    'circle' => __( 'Circle', 'strollik-core' ),
                ],
                'default' => 'square',
                'prefix_class' => 'elementor-share-buttons--shape-',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __( 'Columns', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [
                    '0' => 'Auto',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'prefix_class' => 'elementor-grid%s-',
            ]
        );

        $this->add_control(
            'alignment',
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
                    'justify' => [
                        'title' => __( 'Justify', 'strollik-core' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor-share-buttons--align-',
                'condition' => [
                    'columns' => '0',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_buttons_style',
            [
                'label' => __( 'Share Buttons', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label'     => __( 'Columns Gap', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .elementor-grid' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => __( 'Rows Gap', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_size',
            [
                'label' => __( 'Button Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn' => 'font-size: calc({{SIZE}}{{UNIT}} * 10);',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'em' => [
                        'min' => 0.5,
                        'max' => 4,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                ],
                'tablet_default' => [
                    'unit' => 'em',
                ],
                'mobile_default' => [
                    'unit' => 'em',
                ],
                'size_units' => [ 'em', 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'text',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label' => __( 'Button Height', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'em' => [
                        'min' => 1,
                        'max' => 7,
                        'step' => 0.1,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                ],
                'tablet_default' => [
                    'unit' => 'em',
                ],
                'mobile_default' => [
                    'unit' => 'em',
                ],
                'size_units' => [ 'em', 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_size',
            [
                'label' => __( 'Border Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'default' => [
                    'size' => 2,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                    'em' => [
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-share-btn' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'skin' => [ 'framed', 'boxed' ],
                ],
            ]
        );

        $this->add_control(
            'color_source',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'official' => 'Official Color',
                    'custom' => 'Custom Color',
                ],
                'default' => 'official',
                'prefix_class' => 'elementor-share-buttons--color-',
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
                'condition' => [
                    'color_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => __( 'Primary Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn .elementor-share-btn__icon' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-share-buttons--skin-framed .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
                'condition' => [
                    'color_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => __( 'Secondary Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn__icon, 
					 {{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn__text, 
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn__icon' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'color_source' => 'custom',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'strollik-core' ),
                'condition' => [
                    'color_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'primary_color_hover',
            [
                'label' => __( 'Primary Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-share-buttons--skin-framed .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover .elementor-share-btn__icon, 
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover .elementor-share-btn__icon' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'color_source' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'secondary_color_hover',
            [
                'label' => __( 'Secondary Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover .elementor-share-btn__icon, 
					 {{WRAPPER}}.elementor-share-buttons--skin-flat .elementor-share-btn:hover .elementor-share-btn__text, 
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-gradient .elementor-share-btn:hover .elementor-share-btn__text,
					 {{WRAPPER}}.elementor-share-buttons--skin-boxed .elementor-share-btn:hover .elementor-share-btn__icon,
					 {{WRAPPER}}.elementor-share-buttons--skin-minimal .elementor-share-btn:hover .elementor-share-btn__icon' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'color_source' => 'custom',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .elementor-share-btn__title, {{WRAPPER}} .elementor-share-btn__counter',
                'exclude' => [ 'line_height' ],
            ]
        );

        $this->add_control(
            'text_padding',
            [
                'label' => __( 'Text Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'view' => 'text',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_active_settings();
        if ( empty( $settings['socials'] ) ) {
            return;
        }
        ?>
        <div class="elementor-grid">
            <?php foreach ( $settings['socials'] as $button ) {
                if('google_plus' == $button):
                    $title = 'Google plus';
                elseif('envelope' == $button):
                    $title = 'Email';
                else:
                    $title = $button;
                endif;
                    ?>
                <div class="elementor-grid-item">
                    <div class="elementor-share-btn">
                        <a href="<?php $this->render_html_social($button); ?>" target="_blank" title="<?php printf( __('Share on %s', 'strollik-core'), $title)?>">
                            <i class="fa fa-<?php echo str_replace('_', '-', $button ); ?>"></i>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
    }

    public function render_html_social($key){
        $ssl = is_ssl() ? 'https://' : 'http://';
        switch ($key){
            case 'facebook':
                echo $ssl.'facebook.com/sharer.php?s=100&p&#91;url&#93;='. get_the_permalink().'&p&#91;title&#93;='. get_the_title();
                break;

            case 'twitter':
                echo $ssl.'twitter.com/home?status='.get_the_permalink();
                break;

            case 'linkedin':
                echo $ssl.'linkedin.com/shareArticle?mini=true&amp;url='. get_the_permalink().'&amp;title='.get_the_title();
                break;

            case 'tumblr':
                echo $ssl.'tumblr.com/share/link?url='. urlencode(get_permalink()).'&amp;name='. urlencode(get_the_title()).'&amp;description='. urlencode(get_the_excerpt());
                break;

            case 'google_plus':
                echo $ssl.'plus.google.com/share?url='. get_the_permalink();
                break;

            case 'pinterest':
                echo $ssl.'pinterest.com/pin/create/button/?url=' .urlencode(get_permalink()).'&amp;description='. urlencode(get_the_title());
                break;

            case 'envelope':
                echo 'mailto:?subject='. get_the_title().'&amp;body='.get_the_permalink();
                break;
        }
    }
}

