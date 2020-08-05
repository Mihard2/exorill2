<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Testimonials extends OSF_Elementor_Carousel_Base{

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-testimonials';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Testimonials', 'strollik-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => __('Testimonials', 'strollik-core'),
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label'       => __('Testimonials Item', 'strollik-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => [
                    [
                        'name'        => 'testimonial_content',
                        'label'       => __('Content', 'strollik-core'),
                        'type'        => Controls_Manager::TEXTAREA,
                        'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                        'label_block' => true,
                        'rows'        => '10',
                    ],
                    [
                        'name'       => 'testimonial_image',
                        'label'      => __('Choose Image', 'strollik-core'),
                        'default'    => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'type'       => Controls_Manager::MEDIA,
                        'show_label' => false,
                    ],
                    [
                        'name'    => 'testimonial_name',
                        'label'   => __('Name', 'strollik-core'),
                        'default' => 'John Doe',
                        'type'    => Controls_Manager::TEXT,
                    ],
                    [
                        'name'    => 'testimonial_job',
                        'label'   => __('Job', 'strollik-core'),
                        'default' => 'Designer',
                        'type'    => Controls_Manager::TEXT,
                    ],
                    [
                        'name'        => 'testimonial_link',
                        'label'       => __('Link to', 'strollik-core'),
                        'placeholder' => __('https://your-link.com', 'strollik-core'),
                        'type'        => Controls_Manager::URL,
                    ],
                ],
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'testimonial_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'testimonial_alignment',
            [
                'label'       => __('Alignment', 'strollik-core'),
                'type'        => Controls_Manager::CHOOSE,
                'default'     => 'center',
                'options'     => [
                    'left'   => [
                        'title' => __('Left', 'strollik-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'strollik-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'strollik-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'label_block' => false,
//                'prefix_class' => 'elementor-testimonial-text-align-',
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'strollik-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6],
            ]
        );

        $this->add_control(
            'testimonial_layout',
            [
                'label'   => __('Layout', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'layout_1',
                'options' => [
                    'layout_1'   => __('Layout 1', 'strollik-core'),
                    'layout_2'   => __('Layout 2', 'strollik-core'),
                    'layout_3'   => __('Layout 3', 'strollik-core'),
                ],
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

        // Image.
        $this->start_controls_section(
            'section_style_testimonial_image',
            [
                'label'     => __('Image', 'strollik-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label'      => __('Image Size', 'strollik-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'strollik-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => __( 'Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content
        $this->start_controls_section(
            'section_style_testimonial_style',
            [
                'label' => __('Content', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_content_color',
            [
                'label'     => __('Text Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => __( 'Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_testimonial_name',
            [
                'label' => __('Name', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => __('Text Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name, {{WRAPPER}} .elementor-testimonial-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        $this->add_responsive_control(
            'name_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label' => __( 'Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_testimonial_job',
            [
                'label' => __('Job', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => __('Text Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            ]
        );

        $this->add_responsive_control(
            'job_padding',
            [
                'label' => __( 'Padding', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'job_margin',
            [
                'label' => __( 'Margin', 'strollik-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'setting_job_inline',
            [
                'label' => __('Style Inline', 'strollik-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __('Off', 'strollik-core'),
                'label_on' => __('On', 'strollik-core'),
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-details' => 'display: flex; align-items: center;',
                    '{{WRAPPER}} .elementor-testimonial-job' => 'display: flex; align-items: center;',
                    '{{WRAPPER}} .elementor-testimonial-job:before' => 'content:""; display: inline-block;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'setting_line',
            [
                'label'     => __('Background Line', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'condition' => [
                    'setting_job_inline' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_line',
            [
                'label'     => __('Width Line', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'setting_job_inline' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job:before' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height_line',
            [
                'label'     => __('Height Line', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 12,
                ],
                'range'     => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'setting_job_inline' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job:before' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing_line',
            [
                'label'     => __('spacing Line', 'strollik-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'setting_job_inline' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job:before' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Dot
        $this->start_controls_section(
            'section_style_testimonial_dot',
            [
                'label' => __('Dot', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_carousel' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'backgroud_dot',
            [
                'label'     => __('Background', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'backgroud_dot_active',
            [
                'label'     => __('Background Active', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot.active' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Arrows
        $this->start_controls_section(
            'section_style_testimonial_arrow',
            [
                'label' => __('Arrow', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_carousel' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'color_arrow',
            [
                'label'     => __('Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav .owl-prev:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav .owl-next:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_color_arrow',
            [
                'label'     => __('Hover Color', 'strollik-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav .owl-prev:hover:before' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav .owl-next:hover:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        // Add Carousel Control
        $this->add_control_carousel();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-wrapper');
            $this->add_render_attribute('wrapper', 'class', $settings['testimonial_layout']);
            if ($settings['testimonial_alignment']) {
                $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-text-align-' . $settings['testimonial_alignment']);
            }
            // Row
            $this->add_render_attribute('row', 'class', 'row');
            if($settings['enable_carousel'] === 'yes'){
                $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
                $carousel_settings = $this->get_carousel_settings();
                $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));
            }

            $this->add_render_attribute('row', 'data-elementor-columns', $settings['column']);
            if (!empty($settings['column_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
            }
            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
            }

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-testimonial-item');
            $this->add_render_attribute('item', 'class', 'column-item');


            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php foreach ($settings['testimonials'] as $testimonial): ?>
                        <div <?php echo $this->get_render_attribute_string('item'); ?>>
                            <?php if($settings['testimonial_layout'] == 'layout_1'): ?>
                                <?php $this->render_image($settings, $testimonial); ?>
                            <?php endif; ?>
                            <div class="elementor-testimonial-content">
                                <?php echo $testimonial['testimonial_content']; ?>
                            </div>
                            <?php if($settings['testimonial_layout'] == 'layout_3'): ?>
                                <?php $this->render_image($settings, $testimonial); ?>
                            <?php endif; ?>
                            <div class="elementor-testimonial-meta-inner">
                                <?php if($settings['testimonial_layout'] == 'layout_2'): ?>
                                    <?php $this->render_image($settings, $testimonial); ?>
                                <?php endif; ?>
                                <div class="elementor-testimonial-details">
                                    <?php
                                    $testimonial_name_html = $testimonial['testimonial_name'];
                                    if (!empty($testimonial['testimonial_link']['url'])) :
                                        $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . $testimonial_name_html . '</a>';
                                    endif;
                                    ?>
                                    <div class="elementor-testimonial-name"><?php echo $testimonial_name_html; ?></div>
                                    <div class="elementor-testimonial-job"><?php echo $testimonial['testimonial_job']; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $testimonial){ ?>
        <div class="elementor-testimonial-image">
        <?php
            $testimonial['testimonial_image_size']             = $settings['testimonial_image_size'];
            $testimonial['testimonial_image_custom_dimension'] = $settings['testimonial_image_custom_dimension'];
            if (!empty($testimonial['testimonial_image']['url'])) :
                $image_html = Group_Control_Image_Size::get_attachment_image_html($testimonial, 'testimonial_image');
                echo $image_html;
            endif;
        ?>
        </div>
    <?php
    }

}
