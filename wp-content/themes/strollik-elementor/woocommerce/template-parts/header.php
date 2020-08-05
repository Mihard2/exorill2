<div class="site-header">
	<?php
	if ( strollik_is_header_builder() ) {
		strollik_the_header_builder();
	} else {
		$container = get_theme_mod( 'osf_header_width', false ) ? 'container-fluid' : 'container';
		?>
        <div id="opal-header-content" class="header-content">
            <div class="custom-header <?php echo esc_attr( $container ) ?>">
                <div class="header-main-content w-100 d-flex align-items-center<?php echo get_theme_mod( 'osf_header_layout_is_sticky', false ) ? ' opal-element-sticky' : ''; ?>">
					<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
					<?php if ( has_nav_menu( 'top' ) ) : ?>
                        <div class="navigation-top">
							<?php get_template_part( 'template-parts/header/navigation' ); ?>
                        </div><!-- .navigation-top -->
					<?php endif; ?>
                    <div class="header-group">
						<?php get_search_form(); ?>
						<?php get_template_part( 'template-parts/header/account' ); ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
	?>
</div>
