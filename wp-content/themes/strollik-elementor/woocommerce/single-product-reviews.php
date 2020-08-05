<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! comments_open() ) {
	return;
}

$count =  $product->get_review_count() ;

$counts = strollik_get_review_counting();

$average      = $product->get_average_rating();

?>
<div id="reviews" class="woocommerce-Reviews">
    <div class="row">
        <div class="col-lg-4">
            <h3 class="title-heading"><span><?php esc_html_e('Customer reviews', 'strollik'); ?></span></h3>
        </div>
        <div class="col-lg-8">
            <div class="reviews-summary media">
                <div class="review-summary-total">
                    <div class="review-summary-result">
                        <strong><?php echo floatval($average); ?></strong>
                    </div>
                    <?php printf( esc_html__( '%s ratings','strollik'),$count )  ; ?>
                </div>
                <div class="review-summary-detal media ">
                    <?php foreach( $counts as $key => $value ):  $pc = ($count == 0 ? 0: ( ($value/$count)*100  ) ); ?>
                        <div class="review-summery-item">
                            <div class="review-label pull-left"> <?php echo trim($key); ?> <?php esc_html_e('Star','strollik'); ?></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($pc);?>%;">
                                    <?php echo round($pc,2);?>%
                                </div>
                            </div>


                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="comments">
                <h2 class="woocommerce-Reviews-title"><?php
                    if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
                        /* translators: 1: reviews count 2: product name */
                        printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'strollik' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
                    } else {
                        _e( 'Reviews', 'strollik' );
                    }
                    ?></h2>

                <?php if ( have_comments() ) : ?>

                    <ol class="commentlist">
                        <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
                    </ol>

                    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                        echo '<nav class="woocommerce-pagination">';
                        paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
                            'prev_text' => '&larr;',
                            'next_text' => '&rarr;',
                            'type'      => 'list',
                        ) ) );
                        echo '</nav>';
                    endif; ?>

                <?php else : ?>

                    <p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'strollik' ); ?></p>

                <?php endif; ?>
            </div>

            <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

                <div id="review_form_wrapper">
                    <div id="review_form">
                        <?php
                        $commenter = wp_get_current_commenter();

                        $comment_form = array(
                            'title_reply'          => have_comments() ? __( 'Add a review', 'strollik' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'strollik' ), get_the_title() ),
                            'title_reply_to'       => __( 'Leave a Reply to %s', 'strollik' ),
                            'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
                            'title_reply_after'    => '</span>',
                            'comment_notes_after'  => '',
                            'fields'               => array(
                                'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'strollik' ) . '&nbsp;<span class="required">*</span></label> ' .
                                    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
                                'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'strollik' ) . '&nbsp;<span class="required">*</span></label> ' .
                                    '<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
                            ),
                            'label_submit'  => __( 'Submit', 'strollik' ),
                            'logged_in_as'  => '',
                            'comment_field' => '',
                        );

                        if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                            $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'strollik' ), esc_url( $account_page_url ) ) . '</p>';
                        }

                        if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                            $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'strollik' ) . '</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'strollik' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'strollik' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'strollik' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'strollik' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'strollik' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'strollik' ) . '</option>
						</select></div>';
                        }

                        $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'strollik' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

                        comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                        ?>
                    </div>
                </div>

            <?php else : ?>

                <p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'strollik' ); ?></p>

            <?php endif; ?>

            <div class="clear"></div>
        </div>
    </div>
</div>
