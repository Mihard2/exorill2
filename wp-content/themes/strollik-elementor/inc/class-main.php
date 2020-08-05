<?php

/**
 * Class strollik_setup_theme'
 */
class strollik_setup_theme {
    function __construct() {
        add_action('after_setup_theme', array($this, 'setup'));
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'), 20);
        add_action('wp_head', array($this, 'pingback_header'));
        add_action('widgets_init', array($this, 'widgets_init'));

        add_filter('body_class', array($this, 'add_body_class'));
        add_filter('excerpt_more', array($this, 'excerpt_more'), 1);
        add_filter('frontpage_template', array($this, 'front_page_template'));

        add_filter('wp_resource_hints', array($this, 'resource_hints'), 10, 2);
        add_filter('upload_mimes', array($this, 'allow_svg_upload'), 100, 1);

        add_action('opal_end_wrapper', array($this, 'render_menu_canvas'));
    }

    /**
     * Enqueue scripts and styles.
     */
    public function add_scripts() {
        if (!get_theme_mod('osf_dev_mode', false)) {
            wp_enqueue_style('strollik-opal-icon', get_theme_file_uri('assets/css/opal-icons.css'));
            wp_style_add_data('strollik-opal-icon', 'rtl', 'replace');

            wp_enqueue_style('strollik-carousel', get_theme_file_uri('assets/css/carousel.css'));
            wp_style_add_data('strollik-carousel', 'rtl', 'replace');

            wp_enqueue_style('strollik-boostrap', get_theme_file_uri('assets/css/opal-boostrap.css'));
            wp_style_add_data('strollik-boostrap', 'rtl', 'replace');

            if (strollik_is_Woocommerce_activated()) {
                wp_enqueue_style('strollik-woocommerce', get_theme_file_uri('assets/css/woocommerce.css'));
                wp_style_add_data('strollik-woocommerce', 'rtl', 'replace');
            }

            wp_enqueue_style('strollik-elementor', get_theme_file_uri('assets/css/elementor.css'));
            wp_style_add_data('strollik-elementor', 'rtl', 'replace');
        }
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style('strollik-style', get_parent_theme_file_uri('style.css'));
        wp_style_add_data('strollik-style', 'rtl', 'replace');

        if (!class_exists('OSF_Scripts')) {
            $google_fonts_url = get_theme_mod('osf_theme_google_fonts', false);
            if ($google_fonts_url) {
                wp_enqueue_style('strollik-google-fonts', $google_fonts_url, array(), null);
            }
            wp_add_inline_style('strollik-style', get_theme_mod('osf_theme_custom_style', ''));
        }

        // ========================================================================
        // Customize Preview
        // ========================================================================
        if (is_customize_preview()) {
            wp_enqueue_style('strollik-button-animation', get_theme_file_uri('/assets/css/button-animation.css'), array('strollik-style'), '1.0');
            wp_enqueue_style('strollik-offcanvas-menu', get_theme_file_uri('/assets/css/offcanvas-menu.css'), array('strollik-style'), '1.0');
            wp_enqueue_style('strollik-ie9', get_theme_file_uri('/assets/css/ie9.css'), array('strollik-style'), '1.0');
            wp_style_add_data('strollik-ie9', 'conditional', 'IE 9');

            wp_style_add_data('strollik-button-animation', 'rtl', 'replace');
            wp_style_add_data('strollik-offcanvas-menu', 'rtl', 'replace');
            wp_style_add_data('strollik-ie9', 'rtl', 'replace');
        }

        // Owl Carousel
        wp_enqueue_script('owl-carousel', get_theme_file_uri('/assets/js/libs/owl.carousel.js'), array('jquery'), '2.2.1', true);

        wp_enqueue_script('sticky-kit', get_theme_file_uri('assets/js/libs/jquery.sticky-kit.min.js'), array('jquery'), '1.1.3', true);

        // MainJs
        wp_enqueue_script('strollik-theme-js', get_theme_file_uri('/assets/js/theme.js'), array('jquery'), '1.0', true);
        wp_localize_script('strollik-theme-js', 'osfAjax', array('ajaxurl' => admin_url('admin-ajax.php')));


        // Load the html5 shiv.
        wp_enqueue_script('html5', get_theme_file_uri('/assets/js/libs/html5.js'), array(), '3.7.3');
        wp_script_add_data('html5', 'conditional', 'lt IE 9');

        $opal_l10n = array(
            'quote'          => '<i class="fa-quote-right"></i>',
            'smoothCallback' => '',
        );

        // ================================================================================
        // ================================================================================
        // ================================================================================
        if (has_nav_menu('top')) {
            wp_enqueue_script('strollik-navigation', get_theme_file_uri('/assets/js/navigation.js'), array('jquery'), '1.0', true);
            $opal_l10n['expand']   = __('Expand child menu', 'strollik');
            $opal_l10n['collapse'] = __('Collapse child menu', 'strollik');
            $opal_l10n['icon']     = '<i class="fa fa-angle-down"></i>';
        }

        wp_localize_script('strollik-theme-js', 'poemeJS', $opal_l10n);


        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

    }

    /**
     * Add preconnect for Google Fonts.
     *
     *
     * @param array $urls URLs to print for resource hints.
     * @param string $relation_type The relation type the URLs are printed.
     *
     * @return array $urls           URLs to print for resource hints.
     */
    public function resource_hints($urls, $relation_type) {
        if (wp_style_is('otf-fonts', 'queue') && 'preconnect' === $relation_type) {
            $urls[] = array(
                'href' => 'https://fonts.gstatic.com',
                'crossorigin',
            );
        }

        return $urls;
    }

    /**
     * Adds custom classes to the array of body classes.
     *
     * @param array $classes Classes for the body element.
     *
     * @return array
     */
    public function add_body_class($classes) {
        // Canvas Menu
        $classes[] = 'opal-menu-effect-' . get_theme_mod('osf_mobile_effect_menu', '3');


        // Side-header
        if (get_theme_mod('osf_header_layout_enable_side_header', false)) {
            $classes[] = 'opal-header-layout-sideHeader';
            $classes[] = 'opal-layout-wide';
            $classes[] = 'opal-side-header-' . get_theme_mod('osf_header_layout_side_header_position', 'left');
        } else {
            $layoutMode = get_theme_mod('osf_layout_general_layout_mode', 'wide');
            $classes[]  = 'opal-layout-' . $layoutMode;
        }

        // Pagination
        $classes[] = 'opal-pagination-' . get_theme_mod('osf_layout_pagination_style', '1');

        // Menu Canvas Skin
        $classes[] = 'opal-canvas-' . get_theme_mod('osf_mobile_menu_skin', 'light');

        // Page Title
        $classes[] = 'opal-page-title-' . get_theme_mod('osf_layout_page_title_style', 'left-right');

        // Footer Skin
        $classes[] = 'opal-footer-skin-' . get_theme_mod('osf_colors_footer_skin', 'light');

        // Header Skin
        $classes[] = 'opal-header-skin-' . get_theme_mod('osf_colors_header_skin', 'light');

        // Header Sticky Skin
        $classes[] = 'opal-header-sticky-skin-' . get_theme_mod('osf_colors_header_sticky_skin', 'light');

        // Button Animation
        $classes[] = 'opal-button-animation-bg-' . get_theme_mod('osf_animations_buttons_background', '1');

        // Comment Template
        $classes[] = 'opal-comment-' . get_theme_mod('osf_comment_template_skin', '1');

        // Comment Template
        $classes[] = 'opal-comment-form-' . get_theme_mod('osf_comment_template_form', '1');

        // Blog navigation
        $classes[] = 'opal-post-navigation-' . get_theme_mod('osf_blog_single_navigation', '1');

        // Add class of group-blog to blogs with more than 1 published author.
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        // Add class of hfeed to non-singular pages.
        if (!is_singular()) {
            $classes[] = 'hfeed';
        }

        // Add class on front page.
        if (is_front_page() && 'posts' !== get_option('show_on_front')) {
            $classes[] = 'strollik-front-page';
        }

        if (has_nav_menu('top')) {
            $classes[] = 'opal-has-menu-top';
        }

        return $classes;
    }

    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function widgets_init() {

        register_sidebar(array(
            'name'          => esc_html__('Footer 1', 'strollik'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'strollik'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar(array(
            'name'          => esc_html__('Footer 2', 'strollik'),
            'id'            => 'footer-2',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'strollik'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

        register_sidebar(array(
            'name'          => esc_html__('Footer 3', 'strollik'),
            'id'            => 'footer-3',
            'description'   => esc_html__('Add widgets here to appear in your footer.', 'strollik'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));

    }


    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and
     * a 'Continue reading' link.
     *
     * @param string $link Link to single post/page.
     *
     * @return string 'Continue reading' link prepended with an ellipsis.
     */
    public function excerpt_more($link) {
        if (is_admin()) {
            return $link;
        }

        $link = sprintf('<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
            esc_url(get_permalink(get_the_ID())),
            /* translators: %s: Name of current post */
            sprintf(__('Read More <span class="screen-reader-text"> "%s"</span>', 'strollik'), get_the_title(get_the_ID()))
        );

        return ' &hellip; ' . $link;
    }

    /**
     * Add a pingback url auto-discovery header for singularly identifiable articles.
     */
    public function pingback_header() {
        if (is_singular() && pings_open()) {
            printf('<link rel="pingback" href="%s">' . "\n", get_bloginfo('pingback_url'));
        }
    }

    /**
     * Use front-page.php when Front page displays is set to a static page.
     *
     * @param string $template front-page.php.
     *
     * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
     */
    public function front_page_template($template) {
        return is_home() ? '' : $template;
    }

    public function setup() {
        load_theme_textdomain('poeme', get_template_directory() . '/languages');
        load_theme_textdomain('poeme', get_stylesheet_directory() . '/languages');

        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');

        // Set the default content width.
        $GLOBALS['content_width'] = 600;

        // This theme uses wp_nav_menu() in two locations. ex: 'social'     => __('Social Links Menu', 'poeme'),
        register_nav_menus(array(
            'top' => __('Top Menu', 'strollik'),
        ));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, and column width.
          */
        add_editor_style(array('assets/css/editor-style.css'));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside',
            'image',
            'video',
            'quote',
            'link',
            'gallery',
            'audio',
            'status',
        ));

        // Add theme support for Custom Logo.
        add_theme_support('custom-logo', array(
            'width'       => 250,
            'height'      => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        add_image_size('strollik-featured-image-full', 1400, 700, true);
        add_image_size('strollik-featured-image-large', 600, 337, true);
        add_image_size('strollik-featured-image-small', 300, 184, true);
        add_image_size('strollik-thumbnail', 100, 100, true);

        // This theme allows users to set a custom background.
        add_theme_support('custom-background', array(
            'default-color' => 'f1f1f1',
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

	    add_theme_support( 'opal-customize-css' );
	    add_theme_support( 'opal-admin-menu' );
	    add_theme_support( 'opal-custom-page-field' );
	    add_theme_support( 'opal-portfolio' );
	    add_theme_support( 'opal-footer-builder' );
	    add_theme_support( 'opal-header-builder' );
    }

    public function render_menu_canvas() {
        echo '<div id="opal-canvas-menu" class="opal-menu-canvas">';
        if (is_active_sidebar('sidebar-off-canvas') && class_exists('StrollikCore')) {
            dynamic_sidebar('sidebar-off-canvas');
        } else {
            $args = array(
                'theme_location'  => 'top',
                'menu_id'         => 'offcanvas-menu',
                'menu_class'      => 'offcanvas-menu menu menu-canvas-default',
                'container_class' => 'mainmenu widget'
            );
            if (class_exists("OSF_Nav_walker")) {
                $args['walker'] = new OSF_Nav_walker();
            }
            wp_nav_menu($args);
        }
        echo '</div>';
        echo '<div class="opal-overlay"></div>';

    }

    public function allow_svg_upload($mimes) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }
}
return new strollik_setup_theme();