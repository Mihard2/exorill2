<?php
/**
 * @var $atts array
 */


$class       = 'd-inline-block';
$smooth_menu = '';
$logo        = false;
if (strollik_is_header_builder()) {
    extract($atts);
    if ($display == 'full') {
        $class = 'd-block text-' . esc_attr($align);
    }
    $class .= ' skin-' . esc_attr($skin);
    if ($logo) {
        $class .= ' navigation-has-logo';
    }

    if (!empty($atts['css'])) {
        $class .= ' ' . $atts['css'];
    }

    if (!empty($atts['smooth_menu']) && $atts['smooth_menu']) {
        $smooth_menu = ' opal-smooth-menu';
    }
}
$id = wp_generate_uuid4();
?>

<nav class="main-navigation <?php echo esc_attr($class); ?>"
     aria-label="<?php esc_attr_e('Top Menu', 'strollik'); ?>">
    <button class="menu-toggle">
        <i class="opal-icon-menu"></i>
        <span class="m-text"><?php esc_html_e('Menu', 'strollik'); ?></span>
    </button>
    <?php
    if ($logo) {
        echo '<div class="navigation-logo">';
        get_template_part('template-parts/header/site-branding');
        echo '</div>';
    }
    $args = array(
        'theme_location'  => 'top',
        'menu_id'         => 'top-menu-' . esc_attr($id),
        'menu_class'      => 'top-menu menu',
        'container_class' => 'mainmenu-container mainmenu-skicky' . esc_attr($smooth_menu)
    );
    if (class_exists("OTF_Nav_walker")) {
        $args['walker'] = new OTF_Nav_walker();
    }
    wp_nav_menu($args);
    ?>
</nav><!-- #site-navigation -->
