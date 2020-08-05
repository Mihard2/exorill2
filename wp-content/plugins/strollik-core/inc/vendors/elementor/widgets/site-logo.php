<?php

use Elementor\Widget_Image;
use Elementor\Plugin;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Element_Site_Logo extends Widget_Image {

    public function get_name() {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'opal-site-logo';
    }

    public function get_title() {
        return __( 'Opal Site Logo', 'strollik-core' );
    }

    public function get_icon() {
        return 'eicon-site-logo';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_extra',
            [
                'label' => __( 'Logo Site', 'strollik-core' ),
            ]
        );
        $this->add_control(
            'logo_select',
            [
                'label' => __( 'Image from', 'strollik-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'site_logo',
                'options' => [
                    'site_logo' => __( 'Use Site Logo', 'strollik-core' ),
                    'customize' => __( 'Custom Logo', 'strollik-core' ),
                ]
            ]
        );

        $this->add_control(
            'image_logo',
            [
                'label' => __( 'Choose Image', 'strollik-core' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'logo_select' => 'customize'
                ],
            ]
        );
        $this->end_controls_section();


        parent::_register_controls();
        $this->remove_control('image');
        $this->update_control(
            'image_size',
            [
                'default' => 'full',
            ]
        );

        $this->update_control(
            'link_to',
            [
                'default' => 'custom',
            ]
        );

        $this->update_control(
            'link',
            [
                'placeholder' => site_url(),
            ]
        );

    }

    protected function get_html_wrapper_class() {
        return parent::get_html_wrapper_class() . ' elementor-widget-' . parent::get_name();
    }

    public function get_value( array $options = [] ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        if ( $custom_logo_id ) {
            $url = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
        } else {
            $url = Elementor\Utils::get_placeholder_image_src();
        }

        return [
            'id' => $custom_logo_id,
            'url' => $url,
        ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if('site_logo' === $settings['logo_select']){
            $custom_logo = $this->get_value();
            $settings['image']['url'] = $custom_logo['url'];
            $settings['image']['id'] = $custom_logo['id'];
        }else{
            $settings['image']['url'] = $settings['image_logo']['url'];
            $settings['image']['id'] = $settings['image_logo']['id'];
        }

        if ( empty( $settings['image']['url'] ) ) {
            return;
        }


        $has_caption = ! empty( $settings['caption'] );

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-image' );

        if ( ! empty( $settings['shape'] ) ) {
            $this->add_render_attribute( 'wrapper', 'class', 'elementor-image-shape-' . $settings['shape'] );
        }

        $link = $this->get_link_url( $settings );

        if ( $link ) {
            $this->add_render_attribute( 'link', [
                'href' => $link['url'],
                'data-elementor-open-lightbox' => $settings['open_lightbox'],
            ] );

            if ( Plugin::$instance->editor->is_edit_mode() ) {
                $this->add_render_attribute( 'link', [
                    'class' => 'elementor-clickable',
                ] );
            }

            if ( ! empty( $link['is_external'] ) ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }

            if ( ! empty( $link['nofollow'] ) ) {
                $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            }
        } ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php if ( $has_caption ) : ?>
            <figure class="wp-caption">
                <?php endif; ?>
                <?php if ( $link ) : ?>
                <a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
                    <?php endif; ?>
                    <?php echo  Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
                    <?php if ( $link ) : ?>
                </a>
            <?php endif; ?>
                <?php if ( $has_caption ) : ?>
                    <figcaption class="widget-image-caption wp-caption-text"><?php echo $settings['caption']; ?></figcaption>
                <?php endif; ?>
                <?php if ( $has_caption ) : ?>
            </figure>
        <?php endif; ?>
        </div>
        <?php
    }

    private function get_link_url( $settings ) {
        if ( 'none' === $settings['link_to'] ) {
            return false;
        }

        if ( 'custom' === $settings['link_to'] ) {
            if ( empty( $settings['link']['url'] ) ) {
                $settings['link']['url'] = site_url();
            }
            return $settings['link'];
        }

        return [
            'url' => $settings['image']['url'],
        ];
    }

    protected function _content_template() {
        return;
    }
}
