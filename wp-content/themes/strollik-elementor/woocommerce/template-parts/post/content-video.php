<?php
/**
 * Template part for displaying video posts
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
            <?php
            $content = apply_filters('the_content', get_the_content());
            $video   = false;

            // Only get video from the content if a playlist isn't present.
            if (false === strpos($content, 'wp-playlist-script')) {
                $video = get_media_embedded_in_content($content, array('video', 'object', 'embed', 'iframe'));
            }
            ?>

            <?php if ('' !== get_the_post_thumbnail() && empty($video)) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('strollik-featured-image-full'); ?>
                    </a>
                </div><!-- .post-thumbnail -->
            <?php endif; ?>

            <?php if (!is_single()) {

                // If not a single post, highlight the video file.
                if (!empty($video)) {
                    foreach ($video as $video_html) {
                        echo '<div class="entry-video embed-responsive embed-responsive-16by9">';
                        echo wp_kses_post($video_html);
                        echo '</div>';
                    }
                };
            };
            ?>
            <header class="entry-header">
                <?php
                if (is_single()) {
                    the_title('<h1 class="entry-title">', '</h1>');
                } else if (is_front_page() && is_home()) {
                    the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
                } else {
                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                }
                ?>
            </header><!-- .entry-header -->

            <?php
            if (is_single() || empty($video)) {

                /* translators: %s: Name of current post */
                the_content(sprintf(
                    __('Read more<span class="screen-reader-text"> "%s"</span>', 'strollik'),
                    get_the_title()
                ));

                wp_link_pages(array(
                    'before'      => '<div class="page-links">' . esc_html__('Pages:', 'strollik'),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                ));
            };
            ?>

            <?php
            if (is_single()) {
                strollik_entry_footer();
                strollik_social_share();
            }
            ?>
        </div>

    </div>
</article><!-- #post-## -->
