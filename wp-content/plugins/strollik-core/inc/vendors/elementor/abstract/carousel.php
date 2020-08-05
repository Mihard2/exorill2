<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

abstract class OSF_Elementor_Carousel_Base extends Elementor\Widget_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_name() {
        return 'opal-carousel-base';
    }


    protected function add_control_carousel($condition = array()) {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => __('Carousel Options', 'strollik-core'),
                'type'  => Controls_Manager::SECTION,
                'condition' => $condition,
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => __('Enable', 'strollik-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'     => __('Navigation', 'strollik-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'both',
                'options'   => [
                    'both'   => __('Arrows and Dots', 'strollik-core'),
                    'arrows' => __('Arrows', 'strollik-core'),
                    'dots'   => __('Dots', 'strollik-core'),
                    'none'   => __('None', 'strollik-core'),
                ],
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'     => __('Pause on Hover', 'strollik-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'     => __('Autoplay', 'strollik-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __('Autoplay Speed', 'strollik-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay'        => 'yes',
                    'enable_carousel' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-slide-bg' => 'animation-duration: calc({{VALUE}}ms*1.2); transition-duration: calc({{VALUE}}ms)',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'     => __('Infinite Loop', 'strollik-core'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'enable_carousel' => 'yes'
                ],
            ]
        );

//        $this->add_control(
//            'transition',
//            [
//                'label' => __( 'Transition', 'elementor-pro' ),
//                'type' => Controls_Manager::SELECT,
//                'default' => 'slide',
//                'options' => [
//                    'slide' => __( 'Slide', 'elementor-pro' ),
//                    'fade' => __( 'Fade', 'elementor-pro' ),
//                ],
//                'condition' => [
//                    'enable_carousel' => 'yes'
//                ],
//            ]
//        );
//
//        $this->add_control(
//            'transition_speed',
//            [
//                'label' => __( 'Transition Speed (ms)', 'elementor-pro' ),
//                'type' => Controls_Manager::NUMBER,
//                'default' => 500,
//                'condition' => [
//                    'enable_carousel' => 'yes'
//                ],
//            ]
//        );

//        $this->add_control(
//            'content_animation',
//            [
//                'label' => __( 'Content Animation', 'elementor-pro' ),
//                'type' => Controls_Manager::SELECT,
//                'default' => 'fadeInUp',
//                'options' => [
//                    '' => __( 'None', 'elementor-pro' ),
//                    'fadeInDown' => __( 'Down', 'elementor-pro' ),
//                    'fadeInUp' => __( 'Up', 'elementor-pro' ),
//                    'fadeInRight' => __( 'Right', 'elementor-pro' ),
//                    'fadeInLeft' => __( 'Left', 'elementor-pro' ),
//                    'zoomIn' => __( 'Zoom', 'elementor-pro' ),
//                ],
//                'condition' => [
//                    'enable_carousel' => 'yes'
//                ],
//            ]
//        );

        $this->end_controls_section();
    }

    protected function get_carousel_settings() {
        $settings = $this->get_settings_for_display();
        return array(
            'navigation'         => $settings['navigation'],
            'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? 'true' : 'false',
            'autoplay'           => $settings['autoplay'] === 'yes' ? 'true' : 'false',
            'autoplayTimeout'    => $settings['autoplay_speed'],
            'items'              => $settings['column'],
            'items_tablet'       => $settings['column_tablet'] ? $settings['column_tablet'] : $settings['column'],
            'items_mobile'       => $settings['column_mobile'] ? $settings['column_mobile'] : 1,
            'loop'               => $settings['infinite'] === 'yes' ? 'true' : 'false',
        );
    }

    protected function render_carousel_template(){
        ?>
        var carousel_settings = {
            navigation: settings.navigation,
            autoplayHoverPause: settings.pause_on_hover === 'yes' ? true : false,
            autoplay: settings.autoplay === 'yes' ? true : false,
            autoplayTimeout: settings.autoplay_speed,
            items: settings.column,
            items_tablet: settings.column_tablet ? settings.column_tablet : settings.column,
            items_mobile: settings.column_mobile ? settings.column_mobile : 1,
            loop: settings.infinite === 'yes' ? true : false,
        };
<?php
    }
}