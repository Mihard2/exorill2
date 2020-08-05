<?php

class OSF_Header_Sticky {
    public function __construct() {
        // Render Template Header Sticky
        if ($this->checkEnableSticky()) {
            add_action('wp_footer', array($this, 'render_template'));
            add_filter('body_class', array($this, 'add_body_class'));
        }
    }

    /**
     * @return bool
     */
    private function checkEnableSticky() {
        return get_theme_mod('osf_header_layout_is_sticky', false) && (!get_theme_mod('osf_header_layout_enable_side_header', false));
    }

    /**
     * @return void
     */
    public function render_template() {
        $layout = get_theme_mod('osf_header_layout_sticky_layout', '1');
        echo '<script type="text/html" id="tmpl-opal-header-sticky">';
        get_template_part('template-parts/header/sticky', $layout);
        echo '</script>';
    }

    /**
     * @param $classes array
     * @return array
     */
    public function add_body_class($classes) {
        $classes[] = 'opal-header-sticky';
        return $classes;
    }
}

new OSF_Header_Sticky();