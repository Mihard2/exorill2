<div class="column-item post-style-2">
    <div class="post-inner">
	    <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
				    <?php the_post_thumbnail('strollik-featured-image-large'); ?>
                </a>
            </div><!-- .post-thumbnail -->
	    <?php endif; ?>
        <div class="post-content">
            <div class="entry-header">
                <div class="entry-meta"><?php strollik_posted_on(); ?></div>
                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
            </div>
            <div class="entry-content">
                <div class="entry-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '' ); ?></div>
                <div class="link-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'strollik');?></a></div>
            </div>
        </div>

    </div>
</div>