<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor google maps widget.
 *
 * Elementor widget that displays an embedded google map.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Google_Map extends Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve google maps widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-google_map';
    }

    /**
     * Get widget title.
     *
     * Retrieve google maps widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Opal Google Maps', 'strollik-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve google maps widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-google-maps';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the google maps widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @since 2.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'opal-addons' ];
    }

    public function get_script_depends() {
        $api_key = osf_get_option('opal-settings', 'api_key', 'AIzaSyDRKqMOV24XuzaRMpLKiLnGwDEfauduJ1A');
        wp_register_script( 'google-map', '//maps.googleapis.com/maps/api/js?key='.$api_key);
        return ['google-map'];
    }

    /**
     * Register google maps widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_map',
            array(
                'label' => __( 'Map', 'strollik-core' )
            )
        );

        $this->add_control(
            'latitude',
            array(
                'label'   => __('Latitude', 'strollik-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => '21.030497',
                'description' => sprintf( __( 'The latitude and longitude to center the map. Please go to <a href="%s" target="_blank">Google maps</a>. to find your location and get latitude and longitude.', 'strollik-core' ), 'https://www.google.com/maps')
            )

        );

        $this->add_control(
            'longitude',
            array(
                'label'   => __('Longitude', 'strollik-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => '105.852510',
                'description' => sprintf( __( 'The latitude and longitude to center the map. Ex: 21.030497, 105.852510. Please go to <a href="%s" target="_blank">Google maps</a>. to find your location and get latitude and longitude.', 'strollik-core' ), 'https://www.google.com/maps')
            )
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __( 'Height', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 40,
                        'max' => 1440,
                    ],
                ],
                'default' => [ 'size' => 500 ],
                'description' => esc_html__( 'Height of map.(px)', 'strollik-core' ),
                'selectors' => [
                    '{{WRAPPER}} .opal-google-maps' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'zoom',
            [
                'label' => __( 'Zoom Level', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
            ]
        );

        $this->add_control(
            'prevent_scroll',
            [
                'label' => __( 'Prevent Scroll', 'strollik-core' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .opal-google-maps' => 'pointer-events: none;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_map',
            [
                'label' => __( 'Map Style', 'strollik-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => __('Select Style', 'strollik-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->data_style_title(),
                'default' => 'default',
            ]
        );

        $this->add_control(
            'all',
            [
                'label' => __( 'All Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'water_color',
            [
                'label' => __( 'Water Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'water_lightness',
            [
                'label' => __( 'Water Lightness', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'landscape_color',
            [
                'label' => __( 'Landscape Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'landscape_lightness',
            [
                'label' => __( 'Landscape Lightness', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'administrative_color',
            [
                'label' => __( 'Administrative Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'administrative_lightness',
            [
                'label' => __( 'Administrative Lightness', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 17,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'poi_color',
            [
                'label' => __( 'Poi Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'poi_lightness',
            [
                'label' => __( 'Poi Lightness', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 17,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'road_color',
            [
                'label' => __( 'Road Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'road_lightness',
            [
                'label' => __( 'Road Lightness', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 17,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'transit_color',
            [
                'label' => __( 'Transit Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'scheme' => [
                    'type' => Elementor\Scheme_Color::get_type(),
                    'value' => Elementor\Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->add_control(
            'transit_lightness',
            [
                'label' => __( 'Transit Lightness', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 17,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'style' => 'customize',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render google maps widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $id = rand(time(),99999);

        if ( empty( $settings['latitude'] ) || empty( $settings['longitude'] ) ) {
            return;
        }

        if ( 0 === absint( $settings['zoom']['size'] ) ) {
            $settings['zoom']['size'] = 10;
        }

        $styles = array(
            array(
                'featureType' => 'all',
                'stylers' => array(
                    'color' => $settings['all']
                )
            ),
            array(
                'featureType' => 'water',
                'elementType' => 'geometry',
                'stylers' => array(
                    array(
                        'color' => $settings['water_color'],
                        'lightness' => $settings['water_lightness']['size']
                    )
                )
            ),
            array(
                'featureType' => 'administrative',
                'elementType' => 'geometry',
                'stylers' => array(
                    array(
                        'color' => $settings['administrative_color'],
                        'lightness' => $settings['administrative_lightness']['size']
                    )
                )
            ),
            array(
                'featureType' => 'landscape',
                'elementType' => 'geometry',
                'stylers' => array(
                    array(
                        'color' => $settings['landscape_color'],
                        'lightness' => $settings['landscape_lightness']['size']
                    )
                )
            ),
            array(
                'featureType' => 'poi',
                'elementType' => 'geometry',
                'stylers' => array(
                    array(
                        'color' => $settings['poi_color'],
                        'lightness' => $settings['poi_lightness']['size']
                    )
                )
            ),
            array(
                'featureType' => 'road',
                'elementType' => 'geometry',
                'stylers' => array(
                    array(
                        'color' => $settings['road_color'],
                        'lightness' => $settings['road_lightness']['size']
                    )
                )
            ),
            array(
                'featureType' => 'transit',
                'elementType' => 'geometry',
                'stylers' => array(
                    array(
                        'color' => $settings['transit_color'],
                        'lightness' => $settings['transit_lightness']['size']
                    )
                )
            ),
        );

        $api_key = osf_get_option('opal-settings', 'api_key', 'AIzaSyDRKqMOV24XuzaRMpLKiLnGwDEfauduJ1A');
        wp_enqueue_script( 'google-map',  '//maps.googleapis.com/maps/api/js?key='.$api_key);

        if('customize' == $settings['style']){
            $styles = wp_json_encode($styles);
        }elseif('customize' != $settings['style'] && 'default' != $settings['style']){
            $styles = $this->data_style_value($settings['style']);
        }else{
            $styles = '';
        }

        ?>

        <div id="opal-map<?php echo esc_attr( $id ); ?>" class="google-maps opal-google-maps"
             data-zoom="<?php echo esc_attr( $settings['zoom']['size'] ) ?>"
             data-lat="<?php echo esc_attr( $settings['latitude']  ) ?>"
             data-lng="<?php echo esc_attr( $settings['longitude'] ) ?>"
             data-styles='<?php echo ($styles)?>'>
        </div>
        <?php
    }

    private function data_style_value($style){
        $data = array(
            'ultra_light' => '[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]',
            'shades_of_grey' => '[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
            'blue_water' => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]',
            'light_grey_and_blue' => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#dde6e8"},{"visibility":"on"}]}]',
            'farma_gray' => '[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"},{"gamma":"1.00"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"color":"#ba5858"}]},{"featureType":"administrative.neighborhood","elementType":"labels","stylers":[{"color":"#e57878"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"visibility":"simplified"},{"lightness":"65"},{"saturation":"-100"},{"hue":"#ff0000"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"simplified"},{"saturation":"-100"},{"lightness":"80"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway.controlled_access","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#eeeeee"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#ba5858"},{"saturation":"-100"}]},{"featureType":"transit.station","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit.station","elementType":"labels.text.fill","stylers":[{"color":"#ba5858"},{"visibility":"simplified"}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"hue":"#ff0036"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#ba5858"}]}]',
            'community' => '[{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#2c52a2"}]},{"featureType":"administrative.province","elementType":"labels.text.fill","stylers":[{"color":"#2c52a2"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#2c52a2"}]},{"featureType":"administrative.neighborhood","elementType":"labels.text.fill","stylers":[{"color":"#2c52a2"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"hue":"#ff0000"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.stroke","stylers":[{"color":"#2c52a2"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"color":"#f5f5f5"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#c6ebbd"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#addbf1"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#2c52a2"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]}]',
            'chilled' => '[{"featureType":"road","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"hue":149},{"saturation":-78},{"lightness":0}]},{"featureType":"road.highway","stylers":[{"hue":-31},{"saturation":-40},{"lightness":2.8}]},{"featureType":"poi","elementType":"label","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"hue":163},{"saturation":-26},{"lightness":-1.1}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"hue":3},{"saturation":-24.24},{"lightness":-38.57}]}]'
        );

        foreach($data as $key=>$datum){
            if($style == $key){
                return $datum;
            }
        }
        return false;
    }

    private function data_style_title(){
        return array(
            'default' => __('Default', 'strollik-core'),
            'ultra_light' => __('Ultra Light', 'strollik-core'),
            'shades_of_grey' => __('Shades of Grey', 'strollik-core'),
            'blue_water' => __('Blue Water', 'strollik-core'),
            'light_grey_and_blue' => __('Light Grey and Blue', 'strollik-core'),
            'farma_gray' => __('Farma Gray', 'strollik-core'),
            'community' => __('Community', 'strollik-core'),
            'chilled' => __('Chilled', 'strollik-core'),
            'customize' => __('Customize', 'strollik-core')

        );
    }
}
