<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Products extends OSF_Elementor_Carousel_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-products';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Products', 'strollik-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tabs';
    }


    public static function get_button_sizes() {
        return [
            'xs' => __('Extra Small', 'strollik-core'),
            'sm' => __('Small', 'strollik-core'),
            'md' => __('Medium', 'strollik-core'),
            'lg' => __('Large', 'strollik-core'),
            'xl' => __('Extra Large', 'strollik-core'),
        ];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'strollik-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'limit',
            [
                'label'   => __('Posts Per Page', 'strollik-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'   => __('columns', 'strollik-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5=> 5, 6 => 6],
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'strollik-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __('Order By', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => __('Date', 'strollik-core'),
                    'id'         => __('Post ID', 'strollik-core'),
                    'menu_order' => __('Menu Order', 'strollik-core'),
                    'popularity' => __('Number of purchases', 'strollik-core'),
                    'rating'     => __('Average Product Rating', 'strollik-core'),
                    'title'      => __('Product Title', 'strollik-core'),
                    'rand'       => __('Random', 'strollik-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __('Order', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __('ASC', 'strollik-core'),
                    'desc' => __('DESC', 'strollik-core'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'    => __('Categories', 'strollik-core'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_product_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label'     => __('Category Operator', 'strollik-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => __('AND', 'strollik-core'),
                    'IN'     => __('IN', 'strollik-core'),
                    'NOT IN' => __('NOT IN', 'strollik-core'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'product_type',
            [
                'label'   => __('Product Type', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => [
                    'newest'       => __('Newest Products', 'strollik-core'),
                    'on_sale'      => __('On Sale Products', 'strollik-core'),
                    'best_selling' => __('Best Selling', 'strollik-core'),
                    'top_rated'    => __('Top Rated', 'strollik-core'),
                    'featured'     => __('Featured Product', 'strollik-core'),
                ],
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label'   => __('Paginate', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'       => __('None', 'strollik-core'),
                    'pagination' => __('Pagination', 'strollik-core'),
                ],
            ]
        );

        $this->add_control(
            'product_layout',
            [
                'label'   => __('Product Layout', 'strollik-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => __('Grid', 'strollik-core'),
                    'list' => __('List', 'strollik-core'),
                ]
            ]
        );

        $this->end_controls_section();
        //End Section Query


        // Carousel Option
        $this->add_control_carousel(array(
            'product_layout' => 'grid'
        ));
    }


    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    protected function get_product_type($atts, $product_type) {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;

            case 'on_sale':
                $atts['on_sale'] = true;
                break;

            case 'best_selling':
                $atts['best_selling'] = true;
                break;

            case 'top_rated':
                $atts['top_rated'] = true;
                break;

            default:
                break;
        }
        return $atts;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $type     = 'products';
        $atts     = [
            'limit'          => $settings['limit'],
            'columns'        => $settings['column'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'product_layout' => $settings['product_layout'],
        ];

        $atts = $this->get_product_type($atts, $settings['product_type']);
        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
            $type = 'sale_products';
        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
            $type = 'best_selling_products';
        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
            $type = 'top_rated_products';
        }

        if (!empty($settings['categories'])) {
            $atts['category']     = implode(',', $settings['categories']);
            $atts['cat_operator'] = $settings['cat_operator'];
        }

        // Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['carousel_settings'] = json_encode(wp_slash($this->get_carousel_settings()));
            $atts['product_layout']    = 'carousel';
        }

        if ($settings['paginate'] === 'pagination') {
            $atts['paginate'] = 'true';
        }

        $shortcode = new WC_Shortcode_Products($atts, $type);

        echo $shortcode->get_content();
    }
}
