<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

/**
 * Elementor Single product.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Single_Product_2 extends Elementor\Widget_Base
{

    public function get_categories()
    {
        return array('opal-addons');
    }

    public function get_name()
    {
        return 'opal-single-product-2';
    }

    public function get_title()
    {
        return __('Opal Single Product 2', 'strollik-core');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'strollik-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'id_product',
            [
                'label' => __('Product id', 'strollik-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_products_id(),
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Hide Title', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .product_title' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_rating',
            [
                'label' => __('Hide Rating', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-product-rating' => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'show_price',
            [
                'label' => __('Hide Price', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .price' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_description',
            [
                'label' => __('Hide Description', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .woocommerce-product-details__short-description' => 'display: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'show_quantity',
            [
                'label' => __('Hide Quantity', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'none',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product form.cart .quantity' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'align',
            [
                'label'     => __( 'Text Alignment', 'strollik-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __( 'Left', 'strollik-core' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __( 'Center', 'strollik-core' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => __( 'Right', 'strollik-core' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'left',
                'prefix_class' => 'elementor-align-',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .entry-summary' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_style',
            [
                'label' => __('General', 'strollik-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'general_color',
            [
                'label' => __('Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product form.cart .quantity label, {{WRAPPER}} .single-product div.product form.cart .quantity input, {{WRAPPER}} .single-product div.product .woocommerce-product-rating .reviews-count,{{WRAPPER}} label, {{WRAPPER}} p ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'general_border',
            [
                'label' => __('Border Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product form.cart .quantity input, {{WRAPPER}} .single-product div.product .woocommerce-product-rating' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Title', 'strollik-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'show_title' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .single-product div.product .product_title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .product_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .product_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_price',
            [
                'label' => __('Price', 'strollik-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'show_price' => '',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .single-product div.product .summary .price',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => __('price Color', 'strollik-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .summary .price' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'price_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .summary .price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Button', 'strollik-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'background_color',
                'types'             => [ 'classic', 'gradient' ],
                'selector'          => '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button',
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
            'hover_color',
            [
                'label' => __( 'Text Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'background_color_hover',
                'types'             => [ 'classic', 'gradient' ],
                'selector'          => '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_hover',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button',
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .single-product div.product .entry-summary .single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

    }

    private function remove_hook()
    {
        remove_all_actions('woocommerce_before_single_product_summary');
        remove_all_actions('woocommerce_after_single_product_summary');
        remove_all_actions('woocommerce_single_product_summary');
    }

    private function add_hook()
    {
        add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 15);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);
    }

    protected function get_products_id()
    {
        $args = array(
            'limit' => -1,
        );
        $products = wc_get_products($args);
        $results = array();
        if (!is_wp_error($products)) {
            foreach ($products as $product) {
                $results[$product->id] = $product->name;
            }
        }
        return $results;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!$settings['id_product']) {
            return;
        }
        $this->add_render_attribute('wrapper', 'class', 'elementor-single-product');
        ?>
        <?php
        $this->remove_hook();
        $this->add_hook();
        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        echo do_shortcode('[product_page id="' . $settings['id_product'] . '"]');
        echo '</div>';
    }
}
