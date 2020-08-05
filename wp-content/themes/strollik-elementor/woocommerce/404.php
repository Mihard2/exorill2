<?php
get_header(); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?php if (get_theme_mod( 'osf_page_404_page_enable' ) != 'default' && !empty( get_theme_mod( 'osf_page_404_page_custom' ) )): ?>
                    <?php $query = new WP_Query( 'page_id=' . get_theme_mod( 'osf_page_404_page_custom' ) );
                    if ($query->have_posts()):
                        while ($query->have_posts()) : $query->the_post();
                            the_content();
                        endwhile;
                    endif; ?>
                <?php else: ?>
                    <section class="error-404 not-found">
                        <div class="page-content">
                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-sm-6 text-center d-none d-sm-block">
                                        <img src="<?php echo  get_theme_file_uri('assets/images/img_page404.jpg')?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <h1 class="p-0 m-0"><?php esc_html_e( 'Whoops!', 'strollik' ); ?></h1>
                                        <div class="error-title"><?php esc_html_e( 'Your style does not exis!', 'strollik' ); ?></div>
                                        <p class="error-text pb-5"><?php echo esc_html_e( "Any question? please contact us, we're usually pretty quick. Cowboys to urbanites, professional athletes to ski bums, business suits to fishing guides.", 'strollik' ) ?></p>
                                        <a href="javascript: history.go(-1)" class="go-back"><?php esc_html_e( 'Go back', 'strollik' ); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->
                <?php endif; ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->

<?php get_footer();
