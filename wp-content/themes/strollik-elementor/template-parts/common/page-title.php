<?php
/**
 * Theme Options
 */

if (!strollik_page_enable_breadcrumb()) {
    return;
}

// Get the query & post information
global $post, $wp_query;


$fullwidth = get_theme_mod('osf_layout_page_title_width', 0);
$layout = get_theme_mod('osf_layout_page_title_style', 'top-bottom');
$class_container = $class_page_title = $class_breadcrumb = '';
switch ($layout) {
    case 'left-right':
        $class_container = ' d-sm-flex justify-content-between align-items-center w-100';
        $class_breadcrumb = ' mb-0 order-last text-sm-right';
        $class_page_title = ' mb-0 order-first text-sm-left';
        break;
    case 'right-left':
        $class_container = ' d-sm-flex justify-content-between align-items-center w-100';
        $class_breadcrumb = ' mb-0';
        $class_page_title = ' mb-0';
        break;
    case 'top-bottom':
        $class_container = ' d-flex align-self-center flex-column w-100';
        $class_breadcrumb = ' mb-0 order-last';
        $class_page_title = ' mb-2 order-first';
        break;
    case 'top-bottom-center':
        $class_container = ' d-flex align-self-center flex-column w-100 text-center';
        $class_breadcrumb = ' mb-0 w-100 order-last';
        $class_page_title = ' mb-2 w-100 order-first';
        break;
    case 'bottom-top':
        $class_container = ' align-self-center d-flex flex-column';
        $class_breadcrumb = ' mb-0';
        $class_page_title = ' mb-2';
        break;
    case 'bottom-top-center':
        $class_container = ' align-self-center flex-column w-100 text-center d-flex flex-column';
        $class_breadcrumb = ' mb-0 w-100';
        $class_page_title = ' mb-2 w-100';
        break;
    case 'none-right':
        $class_container = ' text-sm-right w-100';
        $class_breadcrumb = ' mb-0';
        $class_page_title = ' d-none';
        break;
    case 'none-left':
        $class_container = ' text-sm-left w-100';
        $class_breadcrumb = ' mb-0';
        $class_page_title = ' d-none';
        break;
    case 'none-center':
        $class_container = ' text-sm-center w-100';
        $class_breadcrumb = ' mb-0';
        $class_page_title = ' d-none';
        break;
}

$otf_sep = '<i class="fa fa-angle-right"></i>';
$otf_class = 'breadcrumbs clearfix';
$otf_home = __('Home', 'strollik');
$otf_blog = __('Blog', 'strollik');
$otf_shop = __('Shop', 'strollik');
$otf_title = '';

// Get the query & post information
global $post, $wp_query;

// Get post category
$otf_category = get_the_category();

// Get gallery category
$otf_gallery_category = wp_get_post_terms(get_the_ID(), 'gallery_cat');

// Get product category
$otf_product_cat = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

if ($otf_product_cat) {
    $otf_tax_title = $otf_product_cat->name;
}

if (!function_exists('bcn_display')) {
    $otf_output = '';
    if (is_single()) {
        $class_page_title = ' d-none';
    }

    if (!is_front_page()) {
        $otf_output .= '<ul class="' . esc_attr($otf_class) . ' list-inline m-0">';
        if (is_home()) {
            // Home page
            $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_blog . ' </li>';
            $otf_title = $otf_blog;

        } elseif (function_exists('is_shop') && is_shop()) {

            $otf_output .= '<li class="list-inline-item item">' . $otf_shop . '</li>';
            $otf_title = $otf_shop;

        } else {
            if (function_exists('is_product') && is_product() || function_exists('is_cart') && is_cart() || function_exists('is_checkout') && is_checkout() || function_exists('is_account_page') && is_account_page()) {
                $otf_title = get_the_title();
                $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_post_type_archive_link('product')) . '" title="' . esc_attr($otf_home) . '">' . $otf_shop . '</a></li>';
                $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                $otf_output .= '<li class="list-inline-item item">' . $otf_title . '</li>';
            } else {
                if (function_exists('is_product_category') && is_product_category()) {

                    $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_post_type_archive_link('product')) . '" title="' . esc_attr($otf_home) . '">' . $otf_shop . '</a></li>';
                    $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                    $otf_output .= '<li class="list-inline-item item">' . $otf_tax_title . '</li>';
                    $otf_title = $otf_tax_title;

                } else {
                    if (function_exists('is_product_tag') && is_product_tag()) {

                        $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_post_type_archive_link('product')) . '" title="' . esc_attr($otf_home) . '">' . $otf_shop . '</a></li>';
                        $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                        $otf_output .= '<li class="list-inline-item item">' . $otf_tax_title . '</li>';
                        $otf_title = $otf_tax_title;

                    } else {
                        if (is_single()) {
                            $otf_title = get_the_title();
                            $post_type = get_post_type();
                            // Home page
                            $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                            if ('post' == $post_type && !empty($otf_category)) {
                                // First post category
                                $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_category_link($otf_category[0]->term_id)) . '" title="' . esc_attr($otf_category[0]->cat_name) . '">' . $otf_category[0]->cat_name . '</a></li>';
                                $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                            }
                            $otf_output .= '<li class="list-inline-item item current">' . $otf_title . '</li>';

                        } else {
                            if (is_archive() && is_tax() && !is_category() && !is_tag()) {
                                $tax_object = get_queried_object();

                                // Home page
                                $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                                if (!empty($tax_object)) {
                                    $otf_title = esc_html($tax_object->name);
                                    $otf_output .= '<li class="list-inline-item item current">' . $otf_title . '</li>';
                                }
                            } else {
                                if (is_category()) {
                                    // Home page
                                    $otf_title = single_cat_title('', false);
                                    $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                    $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                                    // Category page
                                    $otf_output .= '<li class="list-inline-item item current">' . $otf_title . '</li>';

                                } else {
                                    if (is_page()) {
                                        $otf_title = get_the_title();
                                        $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                        $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                                        // Standard page
                                        if ($post->post_parent) {

                                            // If child page, get parents
                                            $otf_anc = get_post_ancestors($post->ID);

                                            // Get parents in the right order
                                            $otf_anc = array_reverse($otf_anc);

                                            // Parent page loop
                                            foreach ($otf_anc as $otf_ancestor) {
                                                $otf_parents = '<li class="list-inline-item item"><a href="' . esc_url(get_permalink($otf_ancestor)) . '" title="' . esc_attr(get_the_title($otf_ancestor)) . '">' . get_the_title($otf_ancestor) . '</a></li>';
                                                $otf_parents .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                                            }

                                            // Display parent pages
                                            $otf_output .= $otf_parents;

                                            // Current page
                                            $otf_output .= '<li class="list-inline-item item current"> ' . $otf_title . '</li>';

                                        } else {

                                            // Just display current page if not parents
                                            $otf_output .= '<li class="list-inline-item item current"> ' . $otf_title . '</li>';

                                        }

                                    } else {
                                        if (is_tag()) {

                                            // Tag page
                                            $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                                            // Get tag information
                                            $otf_term_id = get_query_var('tag_id');
                                            $otf_taxonomy = 'post_tag';
                                            $otf_args = 'include=' . $otf_term_id;
                                            $otf_terms = get_terms($otf_taxonomy, $otf_args);

                                            // Display the tag name
                                            if (isset($otf_terms[0]->name)) {
                                                $otf_title = $otf_terms[0]->name;
                                                $otf_output .= '<li class="list-inline-item item current">' . $otf_terms[0]->name . '</li>';
                                            }

                                        } elseif (is_day()) {
                                            $otf_title = __('Day', 'strollik');
                                            // Day archive

                                            // Year link
                                            $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '">' . get_the_time('Y') . esc_html__(' Archives', 'strollik') . '</a></li>';
                                            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                                            // Month link
                                            $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))) . '" title="' . esc_attr(get_the_time('M')) . '">' . get_the_time('M') . esc_html__(' Archives', 'strollik') . '</a></li>';
                                            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                                            // Day display
                                            $otf_output .= '<li class="list-inline-item item current"> ' . get_the_time('jS') . ' ' . get_the_time('M') . esc_html__(' Archives', 'strollik') . '</li>';

                                        } else {
                                            if (is_month()) {
                                                $otf_title = __('Month', 'strollik');
                                                // Month Archive

                                                // Year link
                                                $otf_output .= '<li class="list-inline-item item"><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '" title="' . esc_attr(get_the_time('Y')) . '">' . get_the_time('Y') . esc_html__(' Archives', 'strollik') . '</a></li>';
                                                $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';

                                                // Month display
                                                $otf_output .= '<li class="list-inline-item item">' . get_the_time('M') . esc_html__(' Archives', 'strollik') . '</li>';

                                            } else {
                                                if (is_year()) {
                                                    $otf_title = __('Year', 'strollik');
                                                    // Display year archive
                                                    $otf_output .= '<li class="list-inline-item item current">' . get_the_time('Y') . esc_html__('Archives', 'strollik') . '</li>';

                                                } else {
                                                    if (is_author()) {
                                                        global $author;
                                                        if (!empty($author->ID)) {
                                                            $otf_userdata = get_userdata($author->ID);
                                                            // Display author name
                                                            $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                                            $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                                                            $otf_title = __('Author', 'strollik');
                                                            // Get the author information
                                                            $otf_output .= '<li class="list-inline-item item current">' . esc_html__('Author: ', 'strollik') . '<a href="' . get_author_posts_url($otf_userdata->ID, $otf_userdata->nice_name) . '">' . $otf_userdata->display_name . '</a></li>';
                                                        }

                                                    } else {
                                                        if (get_query_var('paged')) {

                                                            // Paginated archives
                                                            $otf_output .= '<li class="list-inline-item item current">' . esc_html__('Page', 'strollik') . ' ' . get_query_var('paged', '1') . '</li>';

                                                        } else {
                                                            if (is_search()) {
                                                                $otf_title = __('Search', 'strollik');
                                                                // Search results page
                                                                $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                                                $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                                                                $otf_output .= '<li class="list-inline-item item current">' . esc_html__('Keyword: ', 'strollik') . get_search_query() . '</li>';

                                                            } elseif (is_404()) {
                                                                $otf_title = __('Error 404', 'strollik');
                                                                // 404 page
                                                                $otf_output .= '<li class="list-inline-item item home"><a href="' . esc_url(get_home_url()) . '" title="' . esc_attr($otf_home) . '">' . $otf_home . '</a></li>';
                                                                $otf_output .= '<li class="list-inline-item separator"> ' . $otf_sep . ' </li>';
                                                                $otf_output .= '<li class="list-inline-item item current">' . $otf_title . '</li>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
    }
    $otf_output .= '</ul>';
} else {
    if (!is_front_page()) {
        if (is_home()) {
            $otf_title = $otf_blog;

        } elseif (function_exists('is_shop') && is_shop()) {
            $otf_title = $otf_shop;

        } else {
            if (function_exists('is_product') && is_product() || function_exists('is_cart') && is_cart() || function_exists('is_checkout') && is_checkout() || function_exists('is_account_page') && is_account_page()) {
                $otf_title = get_the_title();
            } else {
                if (function_exists('is_product_category') && is_product_category()) {

                    $otf_title = $otf_tax_title;

                } else {
                    if (function_exists('is_product_tag') && is_product_tag()) {
                        $otf_title = $otf_tax_title;

                    } else {
                        if (is_single()) {
                            $otf_title = get_the_title();
                            $class_page_title = ' d-none';

                        } else {
                            if (is_archive() && is_tax() && !is_category() && !is_tag()) {
                                $tax_object = get_queried_object();
                                if (!empty($tax_object)) {
                                    $otf_title = esc_html($tax_object->name);

                                }
                            } else {
                                if (is_category()) {
                                    // Home page
                                    $otf_title = single_cat_title('', false);

                                } else {
                                    if (is_page()) {

                                    } else {
                                        if (is_tag()) {
                                            // Get tag information
                                            $otf_term_id = get_query_var('tag_id');
                                            $otf_taxonomy = 'post_tag';
                                            $otf_args = 'include=' . $otf_term_id;
                                            $otf_terms = get_terms($otf_taxonomy, $otf_args);

                                            // Display the tag name
                                            if (isset($otf_terms[0]->name)) {
                                                $otf_title = $otf_terms[0]->name;
                                            }

                                        } elseif (is_day()) {
                                            $otf_title = __('Day', 'strollik');
                                        } else {
                                            if (is_month()) {
                                                $otf_title = __('Month', 'strollik');
                                            } else {
                                                if (is_year()) {
                                                    $otf_title = __('Year', 'strollik');
                                                } else {
                                                    if (is_author()) {
                                                        global $author;
                                                        if (!empty($author->ID)) {
                                                            $otf_title = __('Author', 'strollik');
                                                        }

                                                    } else {
                                                        if (get_query_var('paged')) {
                                                        } else {
                                                            if (is_search()) {
                                                                $otf_title = __('Search', 'strollik');

                                                            } elseif (is_404()) {
                                                                $otf_title = __('Error 404', 'strollik');
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
    }
}

$title_class = (absint(strollik_get_metabox(get_the_ID(), 'osf_enable_page_heading', 1)) != 0) ? '' : ' screen-reader-text';
?>
<div class="<?php echo ($fullwidth) ? 'container-fluid' : 'container' ?>">
    <div class="wrap w-100 d-flex align-items-center">
        <div class="page-title-bar-inner<?php echo esc_attr($class_container) ?>">
            <div class="breadcrumb<?php echo esc_attr($class_breadcrumb); ?>">
                <?php if (function_exists('bcn_display')): ?>
                    <?php bcn_display(); ?>
                <?php else: ?>
                    <?php echo wp_kses_post($otf_output); ?>
                <?php endif; ?>
            </div>
            <?php if (is_page() && class_exists('StrollikCore')) { ?>
                <div class="page-header <?php if (!($layout == 'none-right' || $layout == 'none-left' || $layout == 'none-center')): echo esc_attr($class_page_title); endif; ?>">
                    <?php the_title('<h1 class="page-title' . esc_attr($title_class) . '">', '</h1>'); ?>
                </div>
            <?php } else { ?>
                <div class="page-header<?php echo esc_attr($class_page_title) ?>">
                    <?php
                    if (is_404() && is_archive() && is_search() && is_home()) {
                        echo '<h1 class="page-title">' . $otf_title . '</h1>';
                    } else {
                        echo '<h2 class="page-title">' . $otf_title . '</h2>';
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
