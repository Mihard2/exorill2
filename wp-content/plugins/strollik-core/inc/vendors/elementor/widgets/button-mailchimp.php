<?php
namespace Elementor;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class OSF_Elementor_Button_Mailchimp extends Widget_Button {

    public function get_name() {
        return 'opal-button-mailchimp';
    }

    public function get_title() {
        return __('Opal Button MailChimp Sign-Up Form', 'strollik-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_script_depends() {
        return [ 'magnific-popup' ];
    }

    public function get_style_depends(){
        return ['magnific-popup'];
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'mailchmip',
            [
                'label' => __('General', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label' => __( 'Form name', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Newsletter', 'strollik-core' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Stay up to date with our latest news and products', 'strollik-core' ),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        parent::_register_controls();

        $this->start_controls_section(
            'section_form_style',
            [
                'label' => __( 'Form Style', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color_form',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'default' => '#fff',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'width_form',
            [
                'label' => __( 'Width', 'strollik-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '500',
                'description' => ['px'],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'max-width: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'padding_form',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '20',
                'description' => 'px',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'padding: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'form_align',
            [
                'label' => __( 'Text Alignment', 'strollik-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
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
                        'title' => __( 'Justified', 'strollik-core' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_color',
            [
                'label' => __( 'Text Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}}' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label'     => __('Heading Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .form-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '#opal-mailchimp-popup-{{ID}} .form-title',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __( 'Headhing Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .form-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label'     => __('Sub title Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '#opal-mailchimp-popup-{{ID}} .subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => __( 'Subtitle Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '#opal-mailchimp-popup-{{ID}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->remove_control('link');

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-button-mailchimp' );

        $this->add_render_attribute( 'button', 'href', '#opal-mailchimp-popup-'.esc_attr( $this->get_id() ) );
        $this->add_render_attribute( 'button', 'class', 'elementor-button' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        $this->add_render_attribute( 'button', 'data-effect', 'mfp-zoom-in' );

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
        }

        if ( $settings['hover_animation'] ) {
            $this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                <?php $this->render_text(); ?>
            </a>
        </div>
        <?php

        ?>

        <div id="opal-mailchimp-popup-<?php echo esc_attr( $this->get_id()); ?>" class="mfp-hide mailchimp-content">
            <div class="heading-form">
                <div class="subtitle"><?php echo esc_html($settings['sub_title']);?></div>
                <div class="form-title"><?php echo esc_html($settings['form_name']);?></div>
            </div>
            <?php mc4wp_show_form(); ?>
        </div>
        <?php
    }

    protected function _content_template() {
        return;
    }
}