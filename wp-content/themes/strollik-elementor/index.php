<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php
                if (have_posts()) :

                    /* Start the Loop */
                    while (have_posts()) : the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/post/content', get_post_format() );

                    endwhile;

                    the_posts_pagination( array(
                        'prev_text'          => '<span class="fa fa-arrow-left"></span><span class="screen-reader-text">' . esc_html__( 'Prev', 'strollik' ) . '</span>',
                        'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next', 'strollik' ) . '</span><span class="fa fa-arrow-right"></span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'strollik' ) . ' </span>',
                    ) );

                else :

                    get_template_part( 'template-parts/post/content', 'none' );

                endif;
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
