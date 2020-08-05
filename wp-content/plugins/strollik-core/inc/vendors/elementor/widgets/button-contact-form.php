<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Button_Contact_Form extends  Widget_Button {
    public function get_name() {
        return 'opal-button-contact7';
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_title() {
        return __('Opal Button Contact Form 7', 'strollik-core');
    }


    public function get_categories() {
        return [ 'opal-addons' ];
    }

    public function get_script_depends() {
        return [ 'magnific-popup' ];
    }

    public function get_style_depends(){
        return ['magnific-popup'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'contactform7',
            [
                'label' => __('General', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');

        $contact_forms[''] = __('Please select form', 'strollik-core');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = __('No contact forms found', 'strollik-core');
        }

        $this->add_control(
            'cf_id',
            [
                'label'   => __('Select contact form', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => $contact_forms,
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label' => __( 'Form name', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Request A Call Back', 'strollik-core' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label' => __( 'Sub Title', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Free consultation', 'strollik-core' ),
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
            'formstyle',
            [
                'label'     => __('Form', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'background_color_form',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#opal-contactform-popup-{{ID}}' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_form',
            [
                'label'     => __('width', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 500,
                ],
                'range'     => [
                    'px' => [
                        'min' => 300,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}}' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_form',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label'     => __('Title', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'form_title_align',
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
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .form-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_title_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .form-title' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '#opal-contactform-popup-{{ID}} .form-title',
            ]
        );

        $this->add_responsive_control(
            'form_title_padding',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .form-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'form_title_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .form-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'form_subtitle',
            [
                'label'     => __('Sub Title', 'strollik-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'form_subtitle_align',
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
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .subtitle' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_subtitle_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .subtitle' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_subtitle',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '#opal-contactform-popup-{{ID}} .subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => __('Padding', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => __('Margin', 'strollik-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '#opal-contactform-popup-{{ID}} .subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->remove_control('link');
    }

    protected function render(){
        $settings = $this->get_settings_for_display();

        if(!$settings['cf_id']){
            return;
        }


        $args['id']    = $settings['cf_id'];
        $args['title'] = $settings['form_name'];


        $this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-button-contact7' );

        $this->add_render_attribute( 'button', 'href', '#opal-contactform-popup-'.esc_attr( $this->get_id() ) );
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
        <div id="opal-contactform-popup-<?php echo esc_attr( $this->get_id()); ?>" class="mfp-hide contactform-content">
            <div class="heading-form">
                <div class="subtitle"><?php echo esc_html($settings['sub_title']);?></div>
                <div class="form-title"><?php echo esc_html($settings['form_name']);?></div>
            </div>
            <?php echo osf_do_shortcode('contact-form-7', $args); ?>
        </div>
<?php

    }

    protected function _content_template() {
        return;
    }
}