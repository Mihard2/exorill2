<div class="column-item post-style-1">
    <div class="post-inner row">
        <div class="col-md-3 col-sm-4">
            <div class="entry-meta">
                <?php echo get_avatar( get_the_author_meta( 'email' ), 90 ) ?>
                <div class="entry-date">
                    <?php strollik_posted_on(); ?>
                </div>
                <div class="entry-category">
                    <?php esc_html_e('in', 'strollik'); the_category(); ?>
                </div>
                <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                    <div class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'strollik' ), esc_html__( '1 Comment', 'strollik' ), esc_html__( '% Comments', 'strollik' ) ); ?></div>
                <?php endif; ?>
            </div><!-- .entry-meta -->
        </div>
        <div class="col-md-9 col-sm-8">
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('strollik-featured-image-large'); ?>
                    </a>
                </div><!-- .post-thumbnail -->
            <?php endif; ?>
            <div class="entry-header">
                <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
            </div>
            <div class="entry-content">
                <div class="entry-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 40, '' ); ?></div>
                <div class="link-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'strollik');?></a></div>
            </div>
        </div>

    </div>
</div>