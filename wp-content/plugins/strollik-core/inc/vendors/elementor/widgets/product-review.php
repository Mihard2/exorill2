<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

/**
 * Elementor Single product.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Product_Review extends Elementor\Widget_Base
{

    public function get_categories()
    {
        return array('opal-addons');
    }

    public function get_name()
    {
        return 'opal-product-review';
    }

    public function get_title()
    {
        return __('Opal Product Review', 'strollik-core');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

	public function get_script_depends() {
		return ['magnific-popup'];
	}

	public function get_style_depends() {
		return ['magnific-popup'];
	}

    protected function _register_controls()
    {

        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'strollik-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'id_product',
            [
                'label' => __('Select Product', 'strollik-core'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->get_products_id(),
            ]
        );

        $this->end_controls_section();

    }

    protected function get_products_id()
    {
        $args = array(
            'limit' => -1,
        );
        $products = wc_get_products($args);
        $results = array();
        if (!is_wp_error($products)) {
            foreach ($products as $product) {
                $results[$product->id] = $product->name;
            }
        }
        return $results;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!$settings['id_product']) {
            return;
        }
        $query = new WP_Query(array(
            'post__in' => array($settings['id_product']),
            'post_type' => 'product'
        ));
        $args = array(
            'post_type' => 'product',
            'post_id' => $settings['id_product'],
        );
        $comments = get_comments($args);


        $this->add_render_attribute('wrapper', 'class', 'elementor-product-review');

        echo '<div ' . $this->get_render_attribute_string('wrapper') . '>';
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                ?>
                <div class="row">
                    <div class="col-lg-4 pb-5">
                        <?php
                        if ('yes' === get_option('woocommerce_enable_review_rating')) {
                            if (post_type_supports('product', 'comments')) {
                                global $product;
                                $rating_count = $product->get_rating_count();
                                $review_count = $product->get_review_count();
                                $average = $product->get_average_rating();

                                if ($rating_count > 0) : ?>

                                    <div class="woocommerce-product-rating">
                                        <strong class="average_rating"><?php echo number_format($average, 1); ?></strong>
                                        <?php echo wc_get_rating_html($average, $rating_count); ?>
                                        <?php if (comments_open()) : ?>
                                            <span class="reviews-count" rel="nofollow">
                                                <?php printf(_n('based on %s review', 'based on %s reviews', $review_count, 'strollik-core'), '<span class="count">' . esc_html($review_count) . '</span>'); ?>
                                            </span>
                                            <a class="button-primary woocommerce-review-link" href="#review_form_wrapper" data-effect="mfp-zoom-in"><?php echo esc_attr__('Write a review', 'strollik-core') ?></a><?php endif ?>
                                    </div>

                                <?php endif;
                            }
                        }
                        ?>
                    </div>
                    <?php

                    if (comments_open()) {

                        ?>
                        <div class="col-lg-8">
                            <?php if ($comments) : ?>
                                <ol class="commentlist">
                                    <?php wp_list_comments(apply_filters('woocommerce_product_review_list_args', array('callback' => 'woocommerce_comments')), $comments); ?>
                                </ol>
                                <?php
                                if (count($comments) > 3) {
                                    ?>
                                    <button class="show-all-reviews button-primary"><?php printf(esc_attr__('Read all %s customer reviews', 'strollik-core'), count($comments)); ?></button>
                                <?php } ?>

                            <?php else : ?>

                                <p class="woocommerce-noreviews"><?php _e('There are no reviews yet.', 'strollik-core'); ?></p>

                            <?php endif; ?>
                        </div>
                        <?php
                    }

                    if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())) : ?>

                        <div id="review_form_wrapper" class="mfp-hide review_wrapper">
                            <div id="review_form">
                                <?php
                                $commenter = wp_get_current_commenter();

                                $comment_form = array(
                                    'title_reply' => have_comments() ? __('Add a review', 'strollik-core') : sprintf(__('Be the first to review &ldquo;%s&rdquo;', 'strollik-core'), get_the_title()),
                                    'title_reply_to' => __('Leave a Reply to %s', 'strollik-core'),
                                    'title_reply_before' => '<span id="reply-title" class="comment-reply-title">',
                                    'title_reply_after' => '</span>',
                                    'comment_notes_after' => '',
                                    'fields' => array(
                                        'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__('Name', 'strollik-core') . '&nbsp;<span class="required">*</span></label> ' .
                                            '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" aria-required="true" required /></p>',
                                        'email' => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'strollik-core') . '&nbsp;<span class="required">*</span></label> ' .
                                            '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" aria-required="true" required /></p>',
                                    ),
                                    'label_submit' => __('Submit', 'strollik-core'),
                                    'logged_in_as' => '',
                                    'comment_field' => '',
                                );

                                if ($account_page_url = wc_get_page_permalink('myaccount')) {
                                    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a review.', 'strollik-core'), esc_url($account_page_url)) . '</p>';
                                }

                                if (get_option('woocommerce_enable_review_rating') === 'yes') {
                                    $comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'strollik-core') . '</label><select name="rating" id="rating" aria-required="true" required>
							<option value="">' . esc_html__('Rate&hellip;', 'strollik-core') . '</option>
							<option value="5">' . esc_html__('Perfect', 'strollik-core') . '</option>
							<option value="4">' . esc_html__('Good', 'strollik-core') . '</option>
							<option value="3">' . esc_html__('Average', 'strollik-core') . '</option>
							<option value="2">' . esc_html__('Not that bad', 'strollik-core') . '</option>
							<option value="1">' . esc_html__('Very poor', 'strollik-core') . '</option>
						    </select></div>';
                                }

                                $comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__('Your review', 'strollik-core') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

                                comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
                                ?>
                            </div>
                        </div>

                    <?php else : ?>

                        <p class="woocommerce-verification-required"><?php _e('Only logged in customers who have purchased this product may leave a review.', 'strollik-core'); ?></p>

                    <?php endif; ?>

                </div>

            <?php
            endwhile;
            wp_reset_query();
        endif;
        echo '</div>';
    }
}
