<?php
/* Start the Loop */

$style = get_theme_mod('osf_blog_archive_style');

if(!empty($style) && !is_front_page() || !empty($style) && !is_home()) {
    echo '<div class="row">';
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        get_template_part( 'template-parts/posts-grid/item-post', 'style-' . $style );

    endwhile;
    echo '</div>';
}else {
    while (have_posts()) : the_post();

        /*
         * Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */

        get_template_part( 'template-parts/post/content', get_post_format() );

    endwhile;
}
