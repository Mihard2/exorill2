<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ( ! class_exists( 'StrollikCore' ) ) { ?>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->
   <?php } ?>
    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'strollik' ),
            'after'  => '</div>',
        ) );

        ?>
    </div><!-- .entry-content -->
</article><!-- #post-## -->
