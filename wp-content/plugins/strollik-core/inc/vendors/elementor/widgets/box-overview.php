<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Box_Overview extends  Widget_Base {

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
        return 'opal-box-overview';
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
        return __( 'Opal Box Overview', 'strollik-core' );
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
        return 'eicon-image-box';
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

        $this->start_controls_section(
            'section_image',
            [
                'label' => __( 'Image Box', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'strollik-core' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => __( 'Title & Description', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'This is the heading', 'strollik-core' ),
                'placeholder' => __( 'Enter your title', 'strollik-core' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => __( 'Content', 'strollik-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'strollik-core' ),
                'placeholder' => __( 'Enter your description', 'strollik-core' ),
                'separator' => 'none',
                'rows' => 10,
                'show_label' => false,
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'strollik-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Click Here', 'strollik-core' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link to', 'strollik-core' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'https://your-link.com', 'strollik-core' ),
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => __( 'Image Position', 'strollik-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'strollik-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'top' => [
                        'title' => __( 'Top', 'strollik-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'strollik-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label' => __( 'Title HTML Tag', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'views',
            [
                'label' => __( 'View', 'strollik-core' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __( 'Content', 'strollik-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
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
                    'justify' => [
                        'title' => __( 'Justified', 'strollik-core' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-box-overview-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => __( 'Title', 'strollik-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => __( 'Spacing', 'strollik-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .post-thumbnail .elementor-image-box-title' => 'color: {{VALUE}};',
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
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .post-thumbnail .elementor-image-box-title',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label' => __( 'Description', 'strollik-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Color', 'strollik-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-header .elementor-image-box-description' => 'color: {{VALUE}};',
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
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .entry-header .elementor-image-box-description',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $has_content = ! empty( $settings['title_text'] ) || ! empty( $settings['description_text'] );

        $html = '<div class="elementor-box-overview-wrapper">';

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'link', 'href', $settings['link']['url'] );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }

            if ( ! empty( $settings['link']['nofollow'] ) ) {
                $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            }
        }

        if ( ! empty( $settings['image']['url'] ) ) {
            $this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
            $this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['image'] ) );
            $this->add_render_attribute( 'image', 'title', Control_Media::get_image_title( $settings['image'] ) );

            $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' );
            if ( ! empty( $settings['title_text'] ) ) {
                $this->add_render_attribute( 'title_text', 'class', 'elementor-image-box-title' );

                $this->add_inline_editing_attributes( 'title_text', 'none' );

                $title_html = $settings['title_text'];

                $image_html .= sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string( 'title_text' ), $title_html );
            }
            if ( ! empty( $settings['link']['url'] ) ) {
                $image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
            }

            $html .= '<figure class="post-thumbnail">' . $image_html . '</figure>';
        }

        if ( $has_content ) {
            $html .= '<div class="entry-header">';

            if ( ! empty( $settings['description_text'] ) ) {
                $this->add_render_attribute( 'description_text', 'class', 'elementor-image-box-description' );

                $this->add_inline_editing_attributes( 'description_text' );

                $html .= sprintf( '<p %1$s>%2$s</p>', $this->get_render_attribute_string( 'description_text' ), $settings['description_text'] );
            }

            if ( ! empty( $settings['link']['url'] ) ) {
                $html .= '<a '.$this->get_render_attribute_string("link").'>'.$settings['button_text'].'</a>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';

        echo $html;
    }

}
