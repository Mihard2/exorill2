<div class="wrap">
    <div class="container">
        <?php
        if (is_active_sidebar( 'footer-1' ) ||
            is_active_sidebar( 'footer-2' ) ||
            is_active_sidebar( 'footer-3' )
        ) :
            ?>
            <aside class="widget-area" >
                <div class="widget-column footer-widget-1">
                    <?php if (is_active_sidebar( 'footer-1' )){ ?>
                        <?php dynamic_sidebar( 'footer-1' ); ?>
                    <?php } ?>
                </div>
                <div class="widget-column footer-widget-2">
                    <?php if (is_active_sidebar( 'footer-2' )){ ?>
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    <?php } ?>
                </div>
                <div class="widget-column footer-widget-3">
                    <?php if (is_active_sidebar( 'footer-3' )){ ?>
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    <?php } ?>
                </div>
            </aside><!-- .widget-area -->
        <?php endif; ?>

        <?php  strollik_render_menu_social('text-center'); ?>

    </div>
</div>
<div class="site-info py-3">
    <div class="container">
        <?php echo  get_theme_mod( 'osf_footer_copyright_left', 'Proudly powered by Wpopal.com' ) ; ?>
    </div>
</div><!-- .site-info -->
