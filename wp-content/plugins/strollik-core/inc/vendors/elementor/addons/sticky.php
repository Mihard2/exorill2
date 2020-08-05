<?php

use Elementor\Controls_Manager;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class OSF_Elementor_Section {
    public function __construct() {
        add_action('elementor/element/section/section_layout/after_section_end', [$this, 'register_controls'], 10, 2);
    }
    public function register_controls($element, $args) {
        $element->start_controls_section(
            'section_sticky',
            [
                'label' => __('Sticky ', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $element->add_control(
            'sticky_show',
            [
                'label'        => __('Enable Sticky', 'strollik-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'label_on'     => 'Yes',
                'label_off'    => 'No',
                'return_value' => 'active',
                'prefix_class' => 'osf-sticky-',
            ]
        );
        $element->add_responsive_control(
            'sticky_padding',
            [
                'label'      => __('Padding', 'strollik-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.sticky-show' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'sticky_show' => 'active'
                ]

            ]
        );

        $element->end_controls_section();

    }
}
new OSF_Elementor_Section();