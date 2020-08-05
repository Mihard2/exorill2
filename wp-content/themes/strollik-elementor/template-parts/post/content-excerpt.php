<?php
/**
 * Template part for displaying posts with excerpts
 *
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
            <header class="entry-header">

                <?php if (is_front_page() && !is_home()) {

                    // The excerpt is being displayed within a front page section, so it's a lower hierarchy than h2.
                    the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
                } else {
                    the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                } ?>
            </header><!-- .entry-header -->

            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
        </div>

    </div>
</article><!-- #post-## -->
