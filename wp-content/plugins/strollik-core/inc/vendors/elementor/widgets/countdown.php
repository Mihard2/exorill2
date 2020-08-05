<?php


use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OSF_Elementor_Countdown extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-countdown';
    }

    public function get_title() {
        return __( 'Opal Countdown', 'strollik-core' );
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_countdown',
            [
                'label' => __( 'Countdown', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'due_date',
            [
                'label' => __( 'Due Date', 'strollik-core' ),
                'type' => Controls_Manager::DATE_TIME,
                'default' => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
                /* translators: %s: Time zone. */
                'description' => sprintf( __( 'Date set according to your timezone: %s.', 'strollik-core' ), Utils::get_timezone_string() ),
            ]
        );

        $this->add_control(
            'label_display',
            [
                'label' => __( 'View', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'block' => __( 'Block', 'strollik-core' ),
                    'inline' => __( 'Inline', 'strollik-core' ),
                ],
                'default' => 'block',
                'prefix_class' => 'elementor-countdown--label-',
            ]
        );

        $this->add_control(
            'show_days',
            [
                'label' => __( 'Days', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'strollik-core' ),
                'label_off' => __( 'Hide', 'strollik-core' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_hours',
            [
                'label' => __( 'Hours', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'strollik-core' ),
                'label_off' => __( 'Hide', 'strollik-core' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_minutes',
            [
                'label' => __( 'Minutes', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'strollik-core' ),
                'label_off' => __( 'Hide', 'strollik-core' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_seconds',
            [
                'label' => __( 'Seconds', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'strollik-core' ),
                'label_off' => __( 'Hide', 'strollik-core' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label' => __( 'Show Label', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'strollik-core' ),
                'label_off' => __( 'Hide', 'strollik-core' ),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'custom_labels',
            [
                'label' => __( 'Custom Label', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'show_labels!' => '',
                ],
            ]
        );

        $this->add_control(
            'label_days',
            [
                'label' => __( 'Days', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Days', 'strollik-core' ),
                'placeholder' => __( 'Days', 'strollik-core' ),
                'condition' => [
                    'show_labels!' => '',
                    'custom_labels!' => '',
                    'show_days' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_hours',
            [
                'label' => __( 'Hours', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Hours', 'strollik-core' ),
                'placeholder' => __( 'Hours', 'strollik-core' ),
                'condition' => [
                    'show_labels!' => '',
                    'custom_labels!' => '',
                    'show_hours' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_minutes',
            [
                'label' => __( 'Minutes', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Minutes', 'strollik-core' ),
                'placeholder' => __( 'Minutes', 'strollik-core' ),
                'condition' => [
                    'show_labels!' => '',
                    'custom_labels!' => '',
                    'show_minutes' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'label_seconds',
            [
                'label' => __( 'Seconds', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Seconds', 'strollik-core' ),
                'placeholder' => __( 'Seconds', 'strollik-core' ),
                'condition' => [
                    'show_labels!' => '',
                    'custom_labels!' => '',
                    'show_seconds' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_box_style',
            [
                'label' => __( 'Boxes', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'container_width',
            [
                'label' => __( 'Container Width', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ '%', 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'box_background_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'selector' => '{{WRAPPER}} .elementor-countdown-item',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label' => __( 'Border Radius', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_spacing',
            [
                'label' => __( 'Space Between', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .elementor-countdown-item:not(:first-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body:not(.rtl) {{WRAPPER}} .elementor-countdown-item:not(:last-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-countdown-item:not(:first-of-type)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-countdown-item:not(:last-of-type)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'heading_digits',
            [
                'label' => __( 'Digits', 'strollik-core' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'digits_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-digits' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'digits_typography',
                'selector' => '{{WRAPPER}} .elementor-countdown-digits',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'heading_label',
            [
                'label' => __( 'Label', 'strollik-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-countdown-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .elementor-countdown-label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_2,
            ]
        );

        $this->end_controls_section();
    }

    private function get_strftime( $instance ) {
        $string = '';
        if ( $instance['show_days'] ) {
            $string .= $this->render_countdown_item( $instance, 'label_days', 'elementor-countdown-days' );
        }
        if ( $instance['show_hours'] ) {
            $string .= $this->render_countdown_item( $instance, 'label_hours', 'elementor-countdown-hours' );
        }
        if ( $instance['show_minutes'] ) {
            $string .= $this->render_countdown_item( $instance, 'label_minutes', 'elementor-countdown-minutes' );
        }
        if ( $instance['show_seconds'] ) {
            $string .= $this->render_countdown_item( $instance, 'label_seconds', 'elementor-countdown-seconds' );
        }

        return $string;
    }

    private $_default_countdown_labels;

    private function _init_default_countdown_labels() {
        $this->_default_countdown_labels = [
            'label_months' => __( 'Months', 'strollik-core' ),
            'label_weeks' => __( 'Weeks', 'strollik-core' ),
            'label_days' => __( 'Days', 'strollik-core' ),
            'label_hours' => __( 'Hours', 'strollik-core' ),
            'label_minutes' => __( 'Minutes', 'strollik-core' ),
            'label_seconds' => __( 'Seconds', 'strollik-core' ),
        ];
    }

    public function get_default_countdown_labels() {
        if ( ! $this->_default_countdown_labels ) {
            $this->_init_default_countdown_labels();
        }

        return $this->_default_countdown_labels;
    }

    private function render_countdown_item( $instance, $label, $part_class ) {
        $string = '<div class="elementor-countdown-item"><span class="elementor-countdown-digits ' . $part_class . '"></span>';

        if ( $instance['show_labels'] ) {
            $default_labels = $this->get_default_countdown_labels();
            $label = ( $instance['custom_labels'] ) ? $instance[ $label ] : $default_labels[ $label ];
            $string .= ' <span class="elementor-countdown-label">' . $label . '</span>';
        }

        $string .= '</div>';

        return $string;
    }

    protected function render() {
        $instance  = $this->get_settings();

        $due_date  = $instance['due_date'];
        $string    = $this->get_strftime( $instance );

        // Handle timezone ( we need to set GMT time )
        $due_date = strtotime( $due_date ) - ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
        ?>
        <div class="elementor-opal-countdown"  data-date="<?php echo $due_date; ?>">
            <?php echo $string; ?>
        </div>
        <?php
    }
}
