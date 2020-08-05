<div class="column-item post-style-4">
    <div class="post-inner">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('strollik-featured-image-large'); ?>
                </a>
            </div><!-- .post-thumbnail -->
        <?php endif; ?>
        <div class="entry-content">
            <div class="entry-meta">
                <?php strollik_posted_on(); ?>
            </div>
        </div>
        <div class="entry-header">
            <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
        </div>
        <div class="entry-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '' ); ?></div>
    </div>
</div>