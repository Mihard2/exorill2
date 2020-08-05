<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Elementor_Search_Form extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-search-form';
    }

    public function get_title() {
        return __( 'Opal Search Form', 'strollik-core' );
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'search_content',
            [
                'label' => __( 'Search Form', 'strollik-core' ),
            ]
        );

        if(osf_is_woocommerce_activated()){
            $this->add_control(
                'search_product_only',
                [
                    'label' => __( 'Search Produt Only?', 'strollik-core' ),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes'
                ]
            );
        }

        $this->add_control(
            'skin',
            [
                'label' => __( 'Skin', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'classic',
                'options' => [
                    'classic' => __( 'Classic', 'strollik-core' ),
                    'minimal' => __( 'Minimal', 'strollik-core' ),
                    'full_screen' => __( 'Full Screen', 'strollik-core' ),
                ],
                'prefix_class' => 'elementor-search-form--skin-',
                'render_type' => 'template',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'icon_skin',
            [
                'label' => __( 'Choose Icon', 'strollik-core' ),
                'type' => Controls_Manager::ICON,
                'default' => 'opal-icon-search2',
                'condition' => [
                    'skin!' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => __( 'Placeholder', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'default' => __( 'Search', 'strollik-core' ) . '...',
            ]
        );

        $this->add_control(
            'heading_button_content',
            [
                'label' => __( 'Button', 'strollik-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __( 'Type', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'icon',
                'options' => [
                    'icon' => __( 'Icon', 'strollik-core' ),
                    'text' => __( 'Text', 'strollik-core' ),
                ],
                'prefix_class' => 'elementor-search-form--button-type-',
                'render_type' => 'template',
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Text', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Search', 'strollik-core' ),
                'separator' => 'after',
                'condition' => [
                    'button_type' => 'text',
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'strollik-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'search',
                'options' => [
                    'search' => [
                        'title' => __( 'Search', 'strollik-core' ),
                        'icon' => 'fa fa-search',
                    ],
                    'arrow' => [
                        'title' => __( 'Arrow', 'strollik-core' ),
                        'icon' => 'fa fa-arrow-right',
                    ],
                ],
                'render_type' => 'template',
                'prefix_class' => 'elementor-search-form--icon-',
                'condition' => [
                    'button_type' => 'icon',
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => __( 'Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__container' => 'min-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-search-form__submit' => 'min-width: {{SIZE}}{{UNIT}}',
                    'body:not(.rtl) {{WRAPPER}} .elementor-search-form__icon' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3)',
                    'body.rtl {{WRAPPER}} .elementor-search-form__icon' => 'padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                    '{{WRAPPER}} .elementor-search-form__input, {{WRAPPER}}.elementor-search-form--button-type-text .elementor-search-form__submit' => 'padding-left: calc({{SIZE}}{{UNIT}} / 3); padding-right: calc({{SIZE}}{{UNIT}} / 3)',
                ],
                'condition' => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'toggle_button_content',
            [
                'label' => __( 'Toggle', 'strollik-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'toggle_align',
            [
                'label' => __( 'Alignment', 'strollik-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'center',
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'strollik-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'strollik-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'strollik-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle' => 'display: flex; justify-content: {{VALUE}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_control(
            'toggle_size',
            [
                'label' => __( 'Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 33,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __( 'Input', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size_minimal',
            [
                'label' => __( 'Icon Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__icon' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'skin' => 'minimal',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'overlay_background_color',
            [
                'label' => __( 'Overlay Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-search-form--skin-full_screen .elementor-search-form__container' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'tabs_input_colors' );

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => __( 'Text Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'input_background_color',
                    'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                    'types'             => [ 'classic', 'gradient' ],
                    'condition' => [
	                    'skin!' => 'full_screen',
                    ],

                ]
        );

        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'input_border',
                    'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input',
                ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition' => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label' => __( 'Focus', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'input_text_color_focus',
            [
                'label' => __( 'Text Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:not(.elementor-search-form--skin-full_screen) .elementor-search-form--focus .elementor-search-form__input,
					{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__icon,
					{{WRAPPER}} .elementor-lightbox .dialog-lightbox-close-button:hover,
					{{WRAPPER}}.elementor-search-form--skin-full_screen input[type="search"].elementor-search-form__input:focus' => 'color: {{VALUE}}',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'input_background_color_focus',
			    'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input:focus',
			    'types'             => [ 'classic', 'gradient' ],
			    'condition' => [
				    'skin!' => 'full_screen',
			    ],

		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'input_border_focus',
			    'selector' => '{{WRAPPER}} input[type="search"].elementor-search-form__input:focus',
		    ]
	    );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow_focus',
                'selector' => '{{WRAPPER}} .elementor-search-form--focus .elementor-search-form__container',
                'fields_options' => [
                    'box_shadow_type' => [
                        'separator' => 'default',
                    ],
                ],
                'condition' => [
                    'skin!' => 'full_screen',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __( 'Button', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-search-form__submit',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'condition' => [
                    'button_type' => 'text',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_button_colors' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'color: {{VALUE}}',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'button_background_color',
			    'types'             => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .elementor-search-form__submit',

		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'button_border',
			    'selector' => '{{WRAPPER}} .elementor-search-form__submit',
		    ]
	    );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => __( 'Text Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Background::get_type(),
		    [
			    'name' => 'button_background_color_hover',
			    'types'             => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .elementor-search-form__submit:hover',

		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Border::get_type(),
		    [
			    'name' => 'button_border_hover',
			    'selector' => '{{WRAPPER}} .elementor-search-form__submit:hover',
		    ]
	    );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'button_type' => 'icon',
                    'skin!' => 'full_screen',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __( 'Width', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__submit' => 'min-width: calc( {{SIZE}} * {{size.SIZE}}{{size.UNIT}} )',
                ],
                'condition' => [
                    'skin' => 'classic',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style',
            [
                'label' => __( 'Toggle', 'strollik-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'skin' => 'full_screen',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_toggle_color' );

        $this->start_controls_tab(
            'tab_toggle_normal',
            [
                'label' => __( 'Normal', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'toggle_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_background_color',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_toggle_hover',
            [
                'label' => __( 'Hover', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'toggle_color_hover',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_background_color_hover',
            [
                'label' => __( 'Background Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'toggle_icon_size',
            [
                'label' => __( 'Icon Size', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i:before' => 'font-size: calc({{SIZE}}em / 100)',
                ],
                'condition' => [
                    'skin' => 'full_screen',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toggle_border_width',
            [
                'label' => __( 'Border Width', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'border-width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toggle_border_radius',
            [
                'label' => __( 'Border Radius', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-search-form__toggle i' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $this->add_render_attribute(
            'input', [
                'placeholder' => $settings['placeholder'],
                'class' => 'elementor-search-form__input',
                'type' => 'search',
                'name' => 's',
                'title' => __( 'Search', 'strollik-core' ),
                'value' => get_search_query(),
            ]
        );

        // Set the selected icon.
        if ( 'icon' == $settings['button_type'] ) {
            $icon_class = 'search';

            if ( 'arrow' == $settings['icon'] ) {
                $icon_class = is_rtl() ? 'arrow-left' : 'arrow-right';
            }

            $this->add_render_attribute( 'icon', [
                'class' => 'fa fa-' . $icon_class,
            ] );
        }

        ?>
        <form class="elementor-search-form" role="search" action="<?php echo home_url(); ?>" method="get">
            <?php if ( 'full_screen' === $settings['skin']) : ?>
                <div class="elementor-search-form__toggle">
                    <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                </div>
            <?php endif; ?>

            <div class="elementor-search-form__container">
                <?php if ( 'minimal' === $settings['skin'] ) : ?>
                    <div class="elementor-search-form__icon">
                        <i class="<?php echo $settings['icon_skin']; ?>" aria-hidden="true"></i>
                    </div>
                <?php endif; ?>
                <input <?php echo $this->get_render_attribute_string('input'); ?>>
                <?php if(osf_is_woocommerce_activated() && $settings['search_product_only'] === 'yes'): ?>
                    <input type="hidden" name="post_type" value="product" />
                <?php endif; ?>
                <?php if ( 'classic' === $settings['skin'] ) : ?>
                    <button class="elementor-search-form__submit" type="submit">
                        <?php if ( 'icon' === $settings['button_type'] ) : ?>
                            <i <?php echo $this->get_render_attribute_string('icon'); ?> aria-hidden="true"></i>
                        <?php elseif ( ! empty( $settings['button_text'] ) ) : ?>
                            <?php echo $settings['button_text']; ?>
                        <?php endif; ?>
                    </button>
                <?php endif; ?>
                <?php if ( 'full_screen' === $settings['skin'] ) : ?>
                    <div class="dialog-lightbox-close-button dialog-close-button">
                        <i class="eicon-close" aria-hidden="true"></i>
                        <span class="elementor-screen-only"><?php esc_html_e( 'Close', 'strollik-core' ); ?></span>
                    </div>
                <?php endif ?>
            </div>
        </form>
        <?php
    }
}
