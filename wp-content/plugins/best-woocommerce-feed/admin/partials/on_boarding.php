<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is display the on boarding page
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/partials
 */


//$is_premium_activated = apply_filters('wpfm_is_premium', false);


$is_premium_activated = apply_filters('wpfm_is_premium_activate', false);
$custom_field = get_option('rex-wpfm-product-custom-field');
$amazon_custom_field = get_option('wpfm_amazon_fields', 'no');
$pa_field = get_option('rex-wpfm-product-pa-field');
$structured_data = get_option('rex-wpfm-product-structured-data');
$exclude_tax = get_option('rex-wpfm-product-structured-data-exclude-tax');

if($is_premium_activated) {
    $per_batch = get_option('rex-wpfm-product-per-batch', 50);
}else {
    $per_batch = get_option('rex-wpfm-product-per-batch', 50) > 50 ? 50 : get_option('rex-wpfm-product-per-batch', 50);
}

$wpfm_fb_pixel_enabled = get_option('wpfm_fb_pixel_enabled', 'no');
$wpfm_fb_pixel_data = get_option('wpfm_fb_pixel_value');


$wpfm_enable_log = get_option('wpfm_enable_log');

$pro_url = add_query_arg( 'wpfm-dashboard', '1', 'https://rextheme.com/best-woocommerce-product-feed/' );

//$wpfm_drm_pixel_enabled = get_option('wpfm_drm_pixel_enabled', 'no');
//$wpfm_drm_pixel_data = get_option('wpfm_drm_pixel_value');
?>

<div class="columns">
    <div class="column">
        <div class="rex-onboarding">
            <div class="premium-merchant-alert">
                <div class="alert-box">
                    <a class="delete is-large close"></a>
                    <i class="fa fa-warning warning"></i>
                    <h2><?php echo __('Go Premium', 'rex-product-feed')?></h2>
                    <p>
                        <?php
                            echo sprintf(__('Purchase our <a href="%s" target="_blank" title="Click to Upgrade Pro">premium version</a> to unlock these pro components!', 'rex-product-feed'), $pro_url);

                        ?>
                    </p>
                    <button type="button" class="close"><?php echo __('ok', 'rex-product-feed')?></button>
                </div>
            </div>

            <div class="rex-settings-tab-wrapper">
                <ul class="rex-settings-tabs">
                    <li class="tab-link general active" data-tab="tab1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 21" width="20" height="21">
                            <defs>
                                <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                    <path d="M-29 -37L1291 -37L1291 556L-29 556Z" />
                                </clipPath>
                            </defs>
                            <style>
                                .general-icon { fill: none;stroke: #a8a7be;stroke-linecap:round;stroke-linejoin:round;stroke-width: 1.5 }
                            </style>
                            <g id="Control" clip-path="url(#cp1)">
                                <g id="Group 6">
                                    <g id="1 copy 6">
                                        <g id="Group 21">
                                            <path id="Stroke 1" class="general-icon" d="M4.34 11C4.34 14.12 6.88 16.66 10 16.66C13.12 16.66 15.66 14.12 15.66 11C15.66 7.88 13.12 5.34 10 5.34C6.88 5.34 4.34 7.88 4.34 11Z" />
                                            <path id="Stroke 3" class="general-icon" d="M8.3 11C8.3 11.94 9.06 12.7 10 12.7C10.94 12.7 11.7 11.94 11.7 11C11.7 10.06 10.94 9.3 10 9.3C9.06 9.3 8.3 10.06 8.3 11Z" />
                                            <path id="Stroke 5" class="general-icon" d="M10 3L10 4.79" />
                                            <path id="Stroke 7" class="general-icon" d="M10 17.21L10 19" />
                                            <path id="Stroke 9" class="general-icon" d="M2 11L3.79 11" />
                                            <path id="Stroke 11" class="general-icon" d="M16.21 11L18 11" />
                                            <path id="Stroke 13" class="general-icon" d="M15.66 5.34L14.39 6.61" />
                                            <path id="Stroke 15" class="general-icon" d="M5.61 15.39L4.34 16.66" />
                                            <path id="Stroke 17" class="general-icon" d="M4.34 5.34L5.61 6.61" />
                                            <path id="Stroke 19" class="general-icon" d="M14.39 15.39L15.66 16.66" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <?php echo __('General', 'rex-product-feed')?>
                    </li>
                    <li class="tab-link" data-tab="tab2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 22" width="20" height="22">
                            <defs>
                                <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                    <path d="M-207 -37L1113 -37L1113 556L-207 556Z" />
                                </clipPath>
                            </defs>
                            <style>
                                .marchants { fill: none;stroke: #a8a7be;stroke-linecap:round;stroke-linejoin:round;stroke-width: 1.5 }
                            </style>
                            <g id="Control" clip-path="url(#cp1)">
                                <g id="Group 6">
                                    <g id="1 copy 4">
                                        <g id="Group 7">
                                            <path id="Stroke 1" class="marchants" d="M6.08 6.82C6.08 4.71 7.8 3 9.91 3C12.02 3 13.73 4.71 13.73 6.82L13.73 7.64" />
                                            <path id="Stroke 3" class="marchants" d="M13.73 7.64L16.35 7.64C17.2 7.64 17.83 8.43 17.65 9.26L15.8 17.8C15.65 18.5 15.03 19 14.31 19L5.38 19C4.66 19 4.04 18.5 3.89 17.8L2.03 9.26C1.85 8.43 2.48 7.64 3.33 7.64L10.93 7.64" />
                                            <path id="Stroke 5" class="marchants" d="M5.71 14.26L16.53 14.26" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <?php echo __('Merchants', 'rex-product-feed')?>
                    </li>
                    <li class="tab-link" data-tab="tab4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 31 23" width="31" height="23">
                            <defs>
                                <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                    <path d="M-410 -36L910 -36L910 557L-410 557Z" />
                                </clipPath>
                            </defs>
                            <style>
                                .control-icon { fill: none;stroke: #a8a7be;stroke-linecap:round;stroke-linejoin:round;stroke-width: 1.5 }
                            </style>
                            <g id="Control" clip-path="url(#cp1)">
                                <g id="Group 6">
                                    <g id="1 copy 5">
                                        <g id="Group 21">
                                            <path id="Stroke 1" class="control-icon" d="M4.34 13C4.34 16.12 6.88 18.66 10 18.66C13.12 18.66 15.66 16.12 15.66 13C15.66 9.88 13.12 7.34 10 7.34C6.88 7.34 4.34 9.88 4.34 13Z" />
                                            <path id="Stroke 3" class="control-icon" d="M8.3 13C8.3 13.94 9.06 14.7 10 14.7C10.94 14.7 11.7 13.94 11.7 13C11.7 12.06 10.94 11.3 10 11.3C9.06 11.3 8.3 12.06 8.3 13Z" />
                                            <path id="Stroke 5" class="control-icon" d="M10 5L10 6.79" />
                                            <path id="Stroke 7" class="control-icon" d="M10 19.21L10 21" />
                                            <path id="Stroke 9" class="control-icon" d="M2 13L3.79 13" />
                                            <path id="Stroke 11" class="control-icon" d="M16.21 13L18 13" />
                                            <path id="Stroke 13" class="control-icon" d="M15.66 7.34L14.39 8.61" />
                                            <path id="Stroke 15" class="control-icon" d="M5.61 17.39L4.34 18.66" />
                                            <path id="Stroke 17" class="control-icon" d="M4.34 7.34L5.61 8.61" />
                                            <path id="Stroke 19" class="control-icon" d="M14.39 17.39L15.66 18.66" />
                                        </g>
                                        <g id="Group 21 Copy">
                                            <path id="Stroke 1" class="control-icon" d="M20.46 8C20.46 9.95 22.05 11.54 24 11.54C25.95 11.54 27.54 9.95 27.54 8C27.54 6.05 25.95 4.46 24 4.46C22.05 4.46 20.46 6.05 20.46 8Z" />
                                            <path id="Stroke 3" class="control-icon" d="M22.94 8C22.94 8.59 23.41 9.06 24 9.06C24.59 9.06 25.06 8.59 25.06 8C25.06 7.41 24.59 6.94 24 6.94C23.41 6.94 22.94 7.41 22.94 8Z" />
                                            <path id="Stroke 5" class="control-icon" d="M24 3L24 4.12" />
                                            <path id="Stroke 7" class="control-icon" d="M24 11.88L24 13" />
                                            <path id="Stroke 9" class="control-icon" d="M19 8L20.12 8" />
                                            <path id="Stroke 11" class="control-icon" d="M27.88 8L29 8" />
                                            <path id="Stroke 13" class="control-icon" d="M27.54 4.46L26.75 5.25" />
                                            <path id="Stroke 15" class="control-icon" d="M21.25 10.75L20.46 11.54" />
                                            <path id="Stroke 17" class="control-icon" d="M20.46 4.46L21.25 5.25" />
                                            <path id="Stroke 19" class="control-icon" d="M26.75 10.75L27.54 11.54" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <?php echo __('Controls', 'rex-product-feed')?>
                    </li>
                    <li class="tab-link video" data-tab="tab3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 15" width="23" height="15">
                            <defs>
                                <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                    <path d="M-610 -42L710 -42L710 551L-610 551Z" />
                                </clipPath>
                            </defs>
                            <style>
                                .video-icon { fill: #a8a7be;stroke: #a8a7be;stroke-width: 0.5 }
                            </style>
                            <g id="Control" clip-path="url(#cp1)">
                                <g id="Group 6">
                                    <g id="1">
                                        <g id="electronics">
                                            <path id="Shape" fill-rule="evenodd" class="video-icon" d="M21 2.42L21 11.61C21 11.75 20.92 11.88 20.79 11.96C20.66 12.03 20.5 12.03 20.37 11.96L15.78 9.58L15.78 10.98C15.78 12.1 14.84 13 13.67 13L3.12 13C1.95 13 1 12.1 1 10.98L1 3.02C1 1.9 1.95 1 3.12 1L13.67 1C14.84 1 15.78 1.9 15.78 3.02L15.78 4.45L20.37 2.06C20.5 1.99 20.66 2 20.79 2.07C20.92 2.14 21 2.27 21 2.42ZM14.94 3.02C14.94 2.35 14.37 1.81 13.67 1.81L3.12 1.81C2.42 1.81 1.85 2.35 1.85 3.02L1.85 10.98C1.85 11.65 2.42 12.19 3.12 12.19L13.67 12.19C14.37 12.19 14.94 11.65 14.94 10.98L14.94 3.02ZM20.15 3.1L15.78 5.37L15.78 8.66L20.15 10.93L20.15 3.1Z" />
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <?php echo __('Video Tutorials', 'rex-product-feed')?>
                    </li>
                    <li class="tab-link status" data-tab="tab5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 18" width="16" height="18">
                            <defs>
                                <clipPath clipPathUnits="userSpaceOnUse" id="cp1">
                                    <path d="M-851 -39L469 -39L469 554L-851 554Z" />
                                </clipPath>
                            </defs>
                            <style>
                                .status-icon { fill: #a8a7be }
                            </style>
                            <g id="Control" clip-path="url(#cp1)">
                                <g id="Group 6">
                                    <g id="1 copy">
                                        <path id="Shape" fill-rule="evenodd" class="status-icon" d="M7.5 1.62L7.5 7.87C7.5 8.22 7.22 8.5 6.87 8.5L0.62 8.5C0.28 8.5 0 8.22 0 7.87L0 1.62C0 1.28 0.28 1 0.62 1L6.87 1C7.22 1 7.5 1.28 7.5 1.62ZM6.25 2.25L1.25 2.25L1.25 7.25L6.25 7.25L6.25 2.25ZM16 10.12L16 16.37C16 16.72 15.72 17 15.37 17L9.12 17C8.87 17 8.64 16.85 8.55 16.61C8.45 16.38 8.5 16.11 8.68 15.93L14.93 9.68C15.11 9.5 15.38 9.45 15.61 9.55C15.85 9.64 16 9.87 16 10.12ZM14.75 11.63L10.63 15.75L14.75 15.75L14.75 11.63ZM8.5 4.75C8.5 2.68 10.18 1 12.25 1C14.32 1 16 2.68 16 4.75C16 6.82 14.32 8.5 12.25 8.5C10.18 8.5 8.5 6.82 8.5 4.75ZM9.75 4.75C9.75 6.13 10.87 7.25 12.25 7.25C13.63 7.25 14.75 6.13 14.75 4.75C14.75 3.37 13.63 2.25 12.25 2.25C10.87 2.25 9.75 3.37 9.75 4.75ZM7.32 10.57L4.63 13.25L7.32 15.93C7.56 16.18 7.56 16.57 7.32 16.82C7.07 17.06 6.68 17.06 6.43 16.82L3.75 14.13L1.07 16.82C0.82 17.06 0.43 17.06 0.18 16.82C-0.06 16.57 -0.06 16.18 0.18 15.93L2.87 13.25L0.18 10.57C-0.06 10.32 -0.06 9.93 0.18 9.68C0.43 9.44 0.82 9.44 1.07 9.68L3.75 12.37L6.43 9.68C6.68 9.44 7.07 9.44 7.32 9.68C7.56 9.93 7.56 10.32 7.32 10.57Z" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <?php echo __('System Status', 'rex-product-feed')?>
                    </li>
                    <?php
                    if ( !$is_premium_activated ) {?>
                        <li class="tab-link" data-tab="tab6"><i class="fa fa-gift"></i><?php echo __('Go Premium', 'rex-product-feed')?></li>
                    <?php }
                    ?>
                    <li class="tab-link" data-tab="tab7"><i class="fa fa-question-circle"></i><?php echo __('Logs', 'rex-product-feed')?></li>
                </ul>

                <div class="rex-settings-tab-content">

                    <div id="tab1" class="tab-content active block-wrapper">
                        <div class="rex-general__content-area">

                            <div class="rex-general__left-info-wrapper">

                                <div class="rex-general__single-block-wrapper">

                                    <div class="rex-general__single-block-area">
                                        <div class="rex-general__single-block banner-block">
                                            <div class="onboarding-block">
                                                <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/wpfm-Banner.png'?>" alt="rex-banner">
                                            </div>
                                        </div>

                                        <div class="rex-general__logo-block">
                                            <div class="upgrade-pro">
                                                <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/logo.png'?>" alt="logo" class="img-fluid">
                                                
                                                    <?php if ( !$is_premium_activated ){ ?>
                                                        <a class="btn-default" href="https://rextheme.com/best-woocommerce-product-feed/" target="_blank"><?php _e('Upgrade to Pro ','rex-product-feed'); ?></a>
                                                    <?php } ?>
                                            </div>

                                            <div class="rex-general__single-blocks social-share">
                                                <h4><?php _e('Share On','rex-product-feed'); ?></h4>
                                                <ul class="social">
                                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A//wordpress.org/plugins/best-woocommerce-feed/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=https%3A//wordpress.org/plugins/best-woocommerce-feed/&title=Best%20WooCommerce%20Product%20Feed%20Manager&summary=&source=" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                                                    <li><a href="https://twitter.com/home?status=https%3A//wordpress.org/plugins/best-woocommerce-feed/" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- rex-general__single-block-area -->
                                  

                                    <div class="rex-general__single-block-category">
                                        <div class="rex-general__single-block">
                                            <div class="header">
                                                <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/Document.png'?>" class="title-icon" alt="documentation">
                                                <h4><?php echo __('Documentation', 'rex-product-feed')?></h4>
                                            </div>

                                            <div class="body">
                                                <p>
                                                    <?php echo __('Get started by spending some time with the documentation and generate flawless product feed for major online marketplaces within minutes.', 'rex-product-feed')?>
                                                </p>

                                                <a class="btn-default" href="<?php echo apply_filters('wpfm_document_link', 'https://rextheme.com/docs-category/product-feed-manager/'); ?>" target="_blank"><?php echo __('Documentation', 'rex-product-feed')?></a>
                                            </div>
                                        </div>
                                        <!-- rex-general__single-block one -->

                                        <div class="rex-general__single-block popular">

                                            <div class="header">
                                                <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/Support.png'?>" class="title-icon" alt="support">
                                                <h4><?php echo __('Support', 'rex-product-feed')?></h4>
                                            </div>

                                            <div class="body">
                                                <p>
                                                    <?php echo __('Can’t find solution with our documentation? Just post a ticket. Our professional team is here to solve your problems.', 'rex-product-feed')?>
                                                </p>

                                                <a class="btn-default" href="<?php echo apply_filters('wpfm_support_link', 'https://rextheme.com/your-account/?active_tab=support') ?>" target="_blank"><?php echo __('Post a Ticket', 'rex-product-feed')?> </a>
                                            </div>

                                        </div>
                                        <!-- rex-general__single-block two -->

                                        <div class="rex-general__single-block">

                                            <div class="header">
                                                <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/Rating.png'?>" class="title-icon" alt="rating">
                                                <h4><?php echo __('Show Your Love', 'rex-product-feed')?></h4>
                                            </div>

                                            <div class="body">
                                                <p>
                                                    <?php echo __('We love to have you in WooCommerce Product Feed Manager family. Take your 2 minutes to review and speed the love to encourage us to keep it going.', 'rex-product-feed')?>
                                                </p>

                                                <a class="btn-default" href="<?php echo apply_filters('wpfm_review_link', 'https://wordpress.org/support/plugin/best-woocommerce-feed/reviews/#new-post') ?>" target="_blank"><?php echo __('Leave A Review ', 'rex-product-feed')?> </a>
                                           
                                            </div>

                                        </div>
                                        <!-- rex-general__single-block.three -->

                                    </div>
                                    <!-- rex-general__single-block-category.end -->

                                </div>
                                <!-- rex-general__single-block-wrapper -->
                            </div>
                            <!-- rex-general__left-info-wrapper -->

                            <div class="rex-general__right-info-wrapper">

                                <h4 class="title"><?php _e('Check out our other amazing free plugins!','rex-product-feed'); ?></h4>

                                <div class="rex-general__single-block cart">
                                    <div class="header">
                                        <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/Cart-Lift.png'?>" class="title-icon" alt="cart-lift">
                                        <h4><?php echo __('Cart Lift', 'rex-product-feed')?></h4>
                                    </div>

                                    <div class="body">
                                        <p><?php _e('Recover your abandoned cart customers with automated e-mail drip campaigns. Enjoy immediate increase in your sales..','rex-product-feed'); ?></p>

                                        <a class="btn-default" href="<?php echo apply_filters('wpfm_cart_link', 'https://wordpress.org/plugins/cart-lift/'); ?>" target="_blank"><?php echo __('Get It Now', 'rex-product-feed')?></a>
                                    </div>
                                 </div>
                                 <!-- rex-general__single-block -->

                                 <div class="rex-general__single-block vas">
                                    <div class="header">
                                        <img src="<?php echo WPFM_PLUGIN_DIR_URL . 'admin/icon/variation-swatch.png'?>" class="title-icon" alt="variation-swatch">
                                        <h4><?php echo __('Variation Swatches', 'rex-product-feed')?></h4>
                                    </div>

                                    <div class="body">
                                        <p><?php _e('Use engaging color, image, or text swatches to display your product variations and make your product page more attractive.','rex-product-feed'); ?></p>
                                        <a class="btn-default" href="<?php echo apply_filters('wpfm_variation_link', 'https://wordpress.org/plugins/rex-variation-swatches-for-woocommerce/'); ?>" target="_blank"><?php echo __('Get It Now', 'rex-product-feed')?></a>
                                    </div>
                                 </div>
                                 <!-- rex-general__single-block -->
                                
                            </div>
                            <!-- rex-general__right-info-wrapper.end -->

                        </div>
                        <!-- rex-general__content-area.end -->
                    </div>
                    <!-- rex-general__block-wrapper.end -->

                    <div id="tab2" class="tab-content block-wrapper">
                        <div class="rex-merchant">
                            <h3 class="merchant-title"><?php echo __('Available Merchants', 'rex-product-feed')?></h3>
                            <?php
                            // free vs pro merchants
                            $_merchants = array(
                                'custom'       => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Custom'
                                ),
                                'google'       => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Google Shopping'
                                ),
                                'google_Ad'    => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Google Dynamic Display Ads'
                                ),
                                'google_local_products'    => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Google Local Products'
                                ),
                                'google_local_products_inventory'    => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Google Local Products Inventory'
                                ),
                                'google_merchant_promotion'    => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Google Merchant Promotion Feed'
                                ),
                                'google_dsa'    => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Google Dynamic Search Ads'
                                ),
                                'google_shopping_actions' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Google Shopping Actions'
                                ),
                                'facebook'     => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Facebook'
                                ),
                                'instagram'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Instagram (by Facebook)'
                                ),
                                'amazon_seller'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Amazon Seller'
                                ),
                                'adroll'       => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'AdRoll'
                                ),
                                'nextag'       => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Nextag'
                                ),
                                'pricegrabber' => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Pricegrabber'
                                ),
                                'bing'         => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Bing'
                                ),
                                'kelkoo'       => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Kelkoo'
                                ),
                                'become'       => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Become'
                                ),
                                'shopzilla'    => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'ShopZilla'
                                ),
                                'shopping'     => array(
                                    'free'  => true,
                                    'status'    => 1,
                                    'name'  => 'Shopping'
                                ),
                                'pricerunner'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'PriceRunner'
                                ),
                                'billiger'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Billiger'
                                ),
                                'vergelijk'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Vergelijk'
                                ),
                                'marktplaats'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Marktplaats'
                                ),
                                'beslist'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Beslist'
                                ),
                                'daisycon'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Daisycon'
                                ),
                                'twenga'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Twenga'
                                ),
                                'kieskeurig'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kieskeurig.nl'
                                ),
                                'yandex'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Yandex'
                                ),
                                'spartoo'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Spartoo.nl'
                                ),
                                'tweakers'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Tweakers.nl'
                                ),
                                'sooqr'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Sooqr'
                                ),
                                'heureka'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Heureka'
                                ),
                                'koopkeus'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Koopkeus'
                                ),
                                'scoupz'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Scoupz'
                                ),
                                'cdiscount'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Cdiscount'
                                ),
                                'kelkoonl'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kelkoo.nl'
                                ),
                                'uvinum'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Uvinum / DrinsksAndCo'
                                ),
                                'idealo'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Idealo'
                                ),
                                'rakuten'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Rakuten'
                                ),
                                'pricesearcher'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Pricesearcher'
                                ),
                                'pricemasher'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Pricemasher'
                                ),
                                'pinterest'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Pinterest'
                                ),
                                'fashionchick'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Fashionchick'
                                ),
                                'ceneo'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Ceneo'
                                ),
                                'choozen'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Choozen'
                                ),
                                'rss'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'RSS'
                                ),
                                'ciao'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Ciao'
                                ),
                                'prisjkat'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Pricespy/Prisjkat'
                                ),
                                'crowdfox'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Crowdfox'
                                ),
                                'powerreviews'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'PowerReviews'
                                ),
                                'trovaprezzi'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Trovaprezzi'
                                ),
                                'zbozi'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Zbozi'
                                ),
                                'liveintent'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'LiveIntent'
                                ),
                                'skroutz'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Skroutz'
                                ),
                                'otto'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Otto'
                                ),
                                'sears'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Sears'
                                ),
                                'ammoseek'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'AmmoSeek'
                                ),
                                'fnac'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Fnac'
                                ),
                                'zalando'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Zalando'
                                ),
                                'pixmania'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Pixmania'
                                ),
                                'coolblue'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Coolblue'
                                ),
                                'shopmania'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'ShopMania'
                                ),
                                'kleding'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kleding'
                                ),
                                'ladenzeile'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Ladenzeile'
                                ),
                                'preis'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Preis'
                                ),
                                'winesearcher'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Winesearcher'
                                ),
                                'walmart'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Walmart'
                                ),
                                'snapchat'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Snapchat'
                                ),
                                'verizon'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Yahoo/Verizon Dynamic Product Ads'
                                ),
                                'kelkoo_group'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kelkoo Group'
                                ),
                                'target'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Target'
                                ),
                                'pepperjam'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Pepperjam'
                                ),
                                'cj_affiliate'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'CJ Affiliate'
                                ),
                                'guenstiger'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Guenstiger'
                                ),
                                'hood'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Hood'
                                ),
                                'livingo'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Livingo'
                                ),
                                'jet'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Jet'
                                ),
                                'bonanza'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Bonanza'
                                ),
                                'adcell'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Adcell'
                                ),
                                'adform'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Adform'
                                ),
                                'stylefruits'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Stylefruits'
                                ),
                                'medizinfuchs'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Medizinfuchs'
                                ),
                                'moebel'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Moebel'
                                ),
                                'restposten'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Restposten'
                                ),
                                'sparmedo'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Sparmedo'
                                ),
                                'whiskymarketplace'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Whiskymarketplace'
                                ),
                                'newegg'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'NewEgg'
                                ),
                                '123i'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => '123I'
                                ),
                                'adcrowd'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Adcrowd'
                                ),
                                'bikeexchange'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Bike Exchange'
                                ),
                                'cenowarka'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Cenowarka'
                                ),
                                'cezigue'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Cezigue'
                                ),
                                'check24'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Check24'
                                ),
                                'clang'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Clang'
                                ),
                                'cherchons'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Cherchons'
                                ),
                                'boetiek'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Boetiek B.V'
                                ),
                                'comparer'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Comparer'
                                ),
                                'converto'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Converto'
                                ),
                                'coolshop'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Coolshop'
                                ),
                                'commerce_connector'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Commerce Connector'
                                ),
                                'everysize'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Everysize'
                                ),
                                'encuentraprecios'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Encuentraprecios'
                                ),
                                'geizhals'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Geizhals'
                                ),
                                'geizkragen'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Geizkragen'
                                ),
                                'giftboxx'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Giftboxx'
                                ),
                                'go_banana'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Go Banana'
                                ),
                                'goed_geplaatst'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Goed Geplaatst'
                                ),
                                'grosshandel'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Grosshandel'
                                ),
                                'hardware'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Hardware.info'
                                ),
                                'hatch'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Hatch'
                                ),
                                'hintaopas'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Hintaopas'
                                ),
                                'fyndiq'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Fyndiq.se'
                                ),
                                'fasha'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Fasha'
                                ),
                                'realde'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Real.de'
                                ),
                                'hintaseuranta'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Hintaseuranta'
                                ),
                                'family_blend'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Family Blend'
                                ),
                                'hitmeister'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Hitmeister'
                                ),
                                'lazada'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Lazada'
                                ),
                                'get_price'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'GetPrice.com.au'
                                ),
                                'home_tiger'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'HomeTiger'
                                ),
                                'jurkjes'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Jurkjes.nl'
                                ),
                                'kiesproduct'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kiesproduct'
                                ),
                                'kiyoh'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kiyoh'
                                ),
                                'kompario'     => array(
                                    'free'  => true,
                                    'status'    => 0,
                                    'name'  => 'Kompario'
                                ),
                                'kwanko'     => array(
                                    'free'   => true,
                                    'status' => 0,
                                    'name'   => 'Kwanko'
                                ),
                                'ledenicheur' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Le Dénicheur'
                                ),
                                'les_bonnes_bouilles' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Les Bonnes Bouilles'
                                ),
                                'lions_home'  => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Lions Home'
                                ),
                                'locamo'      => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Locamo'
                                ),
                                'logicsale'      => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Logicsale'
                                ),
                                'google_manufacturer_center'      => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Google Manufacturer Center'
                                ),
                                'pronto'      => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Pronto'
                                ),
                                'awin'      => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Awin'
                                ),
                                'indeed'      => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Indeed'
                                ),
                                'incurvy'     => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Incurvy'
                                ),
                                'jobbird' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Jobbird'
                                ),
                                'job_board_io' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'JobBoard.io'
                                ),
                                'joblift' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Joblift'
                                ),
                                'kuantokusta' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'KuantoKusta'
                                ),
                                'kauftipp' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Kauftipp'
                                ),
                                'vivino' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Vivino'
                                ),
                                'rakuten_advertising' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Rakuten Advertising'
                                ),
                                'pricefalls' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Pricefalls Feed'
                                ),
                                'clubic' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Clubic'
                                ),
                                'criteo' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Criteo'
                                ),
                                'shopalike' => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Shopalike'
                                ),
                                'compartner'     => array(
                                    'free'       => true,
                                    'status'     => 0,
                                    'name'       => 'Compartner'
                                ),
                                'adtraction'    => array(
                                    'free'      => true,
                                    'status'    => 0,
                                    'name'      => 'Adtraction'
                                ),
                                'admitad'       => array(
                                    'free'      => true,
                                    'status'    => 0,
                                    'name'      => 'Admitad'
                                ),
                                'bloomville'     => array(
                                    'free'       => true,
                                    'status'     => 0,
                                    'name'       => 'Bloomville'
                                ),
                                'datatrics'     => array(
                                    'free'      => true,
                                    'status'    => 0,
                                    'name'      => 'Datatrics'
                                ),
                                'deltaprojects'  => array(
                                    'free'       => true,
                                    'status'     => 0,
                                    'name'       => 'Delta Projects'
                                ),
                                'drezzy'       => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Drezzy'
                                ),
                                'domodi'     => array(
                                    'free'   => true,
                                    'status' => 0,
                                    'name'   => 'Domodi'
                                ),
                                'doofinder'   => array(
                                    'free'    => true,
                                    'status'  => 0,
                                    'name'    => 'Doofinder'
                                ),
                                'homebook'   => array(
                                    'free'      => true,
                                    'status'    => 0,
                                    'name'      => 'Homebook.pl'
                                ),
                                'homedeco'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Home Deco'
                                ),
                                'glami'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Glami'
                                ),
                                'fashiola'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Fashiola'
                                ),
                                'emarts'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Emarts'
                                ),
                                'epoq'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Epoq'
                                ),
                                'grupo_zap'    => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Grupo Zap'
                                ),
                                'emag'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Emag'
                                ),
                                'lyst'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Lyst'
                                ),
                                'listupp'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Listupp'
                                ),
                                'hertie'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Hertie'
                                ),
                                'etsy'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'Etsy'
                                ),
//                                'okazii'     => array(
//                                    'free'     => true,
//                                    'status'   => 0,
//                                    'name'     => 'Okazii'
//                                ),
//                                'pricepanda'     => array(
//                                    'free'     => true,
//                                    'status'   => 0,
//                                    'name'     => 'Price Panda'
//                                ),
                                'webgains'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => ' Webgains'
                                ),
                               'vidaXL'     => array(
                                   'free'     => true,
                                   'status'   => 0,
                                   'name'     => 'VidaXL'
                               ),
                               'mydeal'     => array(
                                    'free'     => true,
                                    'status'   => 0,
                                    'name'     => 'My Deal'
                                ),

                            );

                            $_pro_merchants = array(
                                'drm'     => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Google Remarketing (DRM)'
                                ),
                                'google_review'     => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Google Review'
                                ),
                                'ebay_mip'     => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'eBay (MIP)'
                                ),
                                'ebay_seller'     => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'eBay Seller Center'
                                ),
                                'ebay_seller_tickets'  => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'eBay Seller Center (Event tickets)'
                                ),
                                'bol'       => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Bol.com'
                                ),
                                'wish'       => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Wish.com'
                                ),
                                'fruugo'       => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Fruugo'
                                ),
                                'leguide'       => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Leguide'
                                ),
                                'connexity'       => array(
                                    'free'  => false,
                                    'status'    => 0,
                                    'name'  => 'Connexity'
                                ),
                            );
                            $_merchants = array_merge($_merchants, $_pro_merchants);

                            $merchants = get_option('rex_wpfm_merchant_status');
                            if($merchants) {
                                $_merchants = array_merge($_merchants, $merchants);
                            }

                            if(!$is_premium_activated) {
                                $_merchants = array_merge($_merchants, $_pro_merchants);
                            }

                            /**
                             * result of bad planning
                             */
                            $_merchants['google']['name'] = 'Google Shopping';
                            $_merchants['google_Ad']['name'] = 'Google AdWords';
                            $_merchants['drm']['name'] = 'Google Remarketing (DRM)';

                            ?>
                            <?php foreach ($_merchants as $key => $merchant): ?>
                                <?php if($key && $key != 'undefined'):
                                        $show_pro = false;
                                        if( $is_premium_activated ) {
                                            $pro_cls = '';
                                            $disabled = '';
                                            $show_pro = false;
                                        }else {
                                            if( $merchant['free']) {
                                                $pro_cls = '';
                                                $disabled = '';
                                                $show_pro = false;
                                            }else {
                                                $pro_cls = 'wpfm-pro';
                                                $disabled = 'disabled';
                                                $show_pro = true;
                                            }
                                        }
                                    ?>
                                    <div class="single-merchant <?php echo $pro_cls; ?>">
                                        <?php if( $show_pro ) { ?>
                                            <a href="<?php echo $pro_url; ?>" target="_blank" title="Click to Upgrade Pro" class="wpfm-pro-cta">
                                                <span class="wpfm-pro-tag"><?php echo __('pro', 'rex-product-feed'); ?></span>
                                            </a>
                                        <?php } ?>

                                        <span class="title"><?php echo $merchant['name']; ?></span>
                                        <?php
                                        $checked = $merchant['status'] ? 'checked' : '';
                                        $is_free = $merchant['free'] ? true : false;
                                        $name = $merchant['name'] ;

                                        ?>
                                        <div class="switch <?php echo $disabled; ?>" >
                                            <div class="wpfm-switcher">
                                                <input class="switch-input merchant-change" type="checkbox" <?php echo $checked; ?> <?php echo $disabled; ?> id="switcher-<?php echo strtolower($key); ?>" data-value="<?php echo $key; ?>" data-is-free="<?php echo $is_free; ?>" data-name="<?php echo ucfirst($name); ?>">
                                                <label class="lever" for="switcher-<?php echo strtolower($key); ?>"></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!--/merchant tab-->

                    <div id="tab3" class="tab-content block-wrapper">
                        <div class="video-container">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLelDqLncNWcVoPA7T4eyyfzTF0i_Scbnq" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    </div>

                    <div id="tab4" class="tab-content block-wrapper">
                        <div class="rex-merchant feed-settings">
                            <h3 class="merchant-title"><?php echo __('Controls', 'rex-product-feed'); ?> </h3>

                            <div class="single-merchant product-batch">
                                <span class="title"><?php echo __('Product(s) per batch', 'rex-product-feed'); ?></span>
                                <div class="switch">
                                    <form id="wpfm-per-batch" class="wpfm-per-batch">
                                        <input id="wpfm_product_per_batch" type="number" name="wpfm_product_per_batch" value="<?php echo $per_batch; ?>" min="1" <?php echo !$is_premium_activated ?  "max='50'" : ''?>>
                                        <button type="submit" class="save-batch"><span>save</span> <i class="fa fa-spinner fa-pulse fa-fw"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="single-merchant wpfm-clear-btn">
                                <span class="title"><?php echo __('Clear batch', 'rex-product-feed'); ?></span>
                                <button class="wpfm-clear-batch" id="wpfm-clear-batch"><span>Clear</span> <i class="fa fa-spinner fa-pulse fa-fw"></i></button>
                            </div>

                            <div class="single-merchant fb-pixel">
                                <span class="title">
                                    <?php echo __('Enable Facebook Pixel', 'rex-product-feed'); ?>
                                </span>
                                <div class="switch">
                                    <?php
                                        $checked = $wpfm_fb_pixel_enabled === 'yes' ? 'checked': '';
                                        $hidden_class = $wpfm_fb_pixel_enabled === 'yes' ? '': 'is-hidden';
                                    ?>
                                    <div class="wpfm-switcher">
                                        <input class="switch-input" type="checkbox" id="wpfm_fb_pixel" <?php echo $checked; ?>>
                                        <label class="lever" for="wpfm_fb_pixel"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="single-merchant enable-log">
                                <span class="title">
                                    <?php echo __('Enable log', 'rex-product-feed'); ?>
                                </span>
                                <div class="switch">
                                    <?php
                                    $checked = $wpfm_enable_log === 'yes' ? 'checked': '';
                                    ?>
                                    <div class="wpfm-switcher">
                                        <input class="switch-input" type="checkbox" id="wpfm_enable_log" <?php echo $checked; ?>>
                                        <label class="lever" for="wpfm_enable_log"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="single-merchant wpfm-fb-pixel-field <?php echo $hidden_class; ?>">
                                <span class="title"><?php echo __('Facebook Pixel id', 'rex-product-feed'); ?></span>
                                <div class="switch">
                                    <form id="wpfm-fb-pixel" class="wpfm-fb-pixel" style="width: 300px;">
                                        <input id="wpfm_fb_pixel" type="text" name="wpfm_fb_pixel" value="<?php echo $wpfm_fb_pixel_data; ?>" style="width: 200px;">
                                        <button type="submit" class="save-fb-pixel"><span>save</span> <i class="fa fa-spinner fa-pulse fa-fw"></i></button>
                                    </form>
                                </div>
                            </div>

                            <div class="single-merchant exclude-tax <?php echo !$is_premium_activated ? 'wpfm-pro' : '' ?>">
                                <?php if( !$is_premium_activated ) { ?>
                                    <a href="<?php echo $pro_url; ?>" target="_blank" title="Click to Upgrade Pro" class="wpfm-pro-cta">
                                        <span class="wpfm-pro-tag"><?php echo __('pro', 'rex-product-feed'); ?></span>
                                    </a>
                                <?php } ?>

                                <span class="title"><?php echo __('Add custom fields for Amazon', 'rex-product-feed'); ?></span>
                                <div class="switch">
                                    <?php
                                    if(!$is_premium_activated) {
                                        $disabled = 'disabled';
                                        $checked = '';
                                    }else {
                                        $disabled = '';
                                        $checked = $amazon_custom_field === 'yes' ? 'checked': '';
                                    }
                                    ?>
                                    <div class="wpfm-switcher">
                                        <input class="switch-input" type="checkbox" id="rex-product-custom-field-amazon" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                        <label class="lever" for="rex-product-custom-field-amazon"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="single-merchant exclude-tax <?php echo !$is_premium_activated ? 'wpfm-pro' : '' ?>">
                                <?php if( !$is_premium_activated ) { ?>
                                    <a href="<?php echo $pro_url; ?>" target="_blank" title="Click to Upgrade Pro" class="wpfm-pro-cta">
                                        <span class="wpfm-pro-tag"><?php echo __('pro', 'rex-product-feed'); ?></span>
                                    </a>
                                <?php } ?>

                                <span class="title">
                                    <?php echo __('Exclude TAX from structured data prices', 'rex-product-feed'); ?>
                                </span>
                                <div class="switch">
                                    <?php
                                    if(!$is_premium_activated) {
                                        $disabled = 'disabled';
                                        $checked = '';
                                    }else {
                                        $disabled = '';
                                        $checked = $exclude_tax === 'yes' ? 'checked': '';
                                    }
                                    ?>
                                    <div class="wpfm-switcher <?php echo $disabled; ?>">
                                        <input class="switch-input" type="checkbox" id="rex-product-exclude-tax" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                        <label class="lever" for="rex-product-exclude-tax"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="single-merchant unique-product <?php echo !$is_premium_activated ? 'wpfm-pro' : '' ?>">
                                <?php if( !$is_premium_activated ) { ?>
                                    <a href="<?php echo $pro_url; ?>" target="_blank" title="Click to Upgrade Pro" class="wpfm-pro-cta">
                                        <span class="wpfm-pro-tag"><?php echo __('pro', 'rex-product-feed'); ?></span>
                                    </a>
                                <?php } ?>

                                <span class="title"><?php echo __('Add Unique Product Identifiers ( Brand, GTIN, MPN, UPC, EAN, JAN, ISBN, ITF14, Offer price, Offer effective date, Additional info ) to product', 'rex-product-feed'); ?></span>
                                <div class="switch">
                                    <?php
                                    if(!$is_premium_activated) {
                                        $disabled = 'disabled';
                                        $checked = '';
                                    }else {
                                        $disabled = '';
                                        $checked = $custom_field === 'yes' ? 'checked': '';
                                    }
                                    ?>
                                    <div class="wpfm-switcher <?php echo $disabled; ?>">
                                        <input class="switch-input" type="checkbox" id="rex-product-custom-field" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                        <label class="lever" for="rex-product-custom-field"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="single-merchant increase-product <?php echo !$is_premium_activated ? 'wpfm-pro' : '' ?>">
                                <?php if( !$is_premium_activated ) { ?>
                                    <a href="<?php echo $pro_url; ?>" target="_blank" title="Click to Upgrade Pro" class="wpfm-pro-cta">
                                        <span class="wpfm-pro-tag"><?php echo __('pro', 'rex-product-feed'); ?></span>
                                    </a>
                                <?php } ?>

                                <span class="title">
                                    <?php echo __('Increase the number of products that will be approved in Google\'s Merchant Center:
                                           This option will fix WooCommerce\'s (JSON-LD) structured data bug and add extra structured data elements to your pages', 'rex-product-feed'); ?>
                                </span>
                                <div class="switch">
                                    <?php
                                    if(!$is_premium_activated) {
                                        $disabled = 'disabled';
                                        $checked = '';
                                    }else {
                                        $disabled = '';
                                        $checked = $structured_data === 'yes' ? 'checked': '';
                                    }
                                    ?>
                                    <div class="wpfm-switcher <?php echo $disabled; ?>">
                                        <input class="switch-input" type="checkbox" id="rex-product-structured-data" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                        <label class="lever" for="rex-product-structured-data"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="single-merchant detailed-product <?php echo !$is_premium_activated ? 'wpfm-pro' : '' ?>">
                                <?php if( !$is_premium_activated ) { ?>
                                    <a href="<?php echo $pro_url; ?>" target="_blank" title="Click to Upgrade Pro" class="wpfm-pro-cta">
                                        <span class="wpfm-pro-tag"><?php echo __('pro', 'rex-product-feed'); ?></span>
                                    </a>
                                <?php } ?>

                                <span class="title"><?php echo __('Add Detailed Product Attributes ( Size, Color, Pattern, Material, Age group, Gender ) to product', 'rex-product-feed'); ?></span>
                                <div class="switch">
                                    <?php
                                    if(!$is_premium_activated) {
                                        $disabled = 'disabled';
                                        $checked = '';
                                    }else {
                                        $disabled = '';
                                        $checked = $pa_field === 'yes' ? 'checked': '';
                                    }
                                    ?>
                                    <div class="wpfm-switcher <?php echo $disabled; ?>">
                                        <input class="switch-input" type="checkbox" id="rex-product-pa-field" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                        <label class="lever" for="rex-product-pa-field"></label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <!--/settings tab-->

                    <div id="tab5" class="tab-content block-wrapper">
                        <div class="system-status">
                            <h3 class="title"><?php echo __('System Status', 'rex-product-feed'); ?></h3>
                            <?php

                            $path  = wp_upload_dir();
                            $path  = $path['basedir'] . '/rex-feed';
                            if (is_writable($path)) {
                                $isWritable = "True";
                            } else {
                                $isWritable = "False";
                            }

                            $status = array(
                                'php_version'           =>  phpversion(),
                                'php_version_status'    =>  version_compare(phpversion(),  "5.6", ">="),
                                'wp_version'            =>  get_bloginfo('version'),
                                'wp_version_status'     =>  get_bloginfo('version') >= 4,
                                'wc_version'            =>  WC()->version,
                                'wc_version_status'     =>  WC()->version >= 3.4,
                                'memory'                =>  ini_get('memory_limit'),
                                'memory_status'         =>  preg_replace('/[^0-9]/', '', ini_get('memory_limit')) >= 64, // 64M
                                'upload_limit'          =>  ini_get('upload_max_filesize'),
                                'upload_limit_status'   =>  preg_replace('/[^0-9]/', '', ini_get('upload_max_filesize')) >= 64, // 64M,
                                'wp_cron'               =>  !( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ),
                                'feed_directory'        =>  $path,
                                'is_writable'           =>  $isWritable,
                            );
                            ?>
                            <table class="wpfm_status_table widefat" id="status" cellspacing="0">
                                <tbody>
                                <tr>
                                    <td><?php echo __('PHP version:', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['php_version_status'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span>'.$status['php_version'].'</mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend using PHP version 7.2 or above for greater performance and security.', 'rex-product-feed' ), esc_html( $status['php_version'] )) . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('WordPress version:', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['wp_version_status'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span>'.$status['wp_version'].'</mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - WP version above 4 is required. ', 'rex-product-feed' ), esc_html( $status['wp_version'] )) . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('WooCommerce Version:', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['wc_version_status'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span>'.$status['wc_version'].'</mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - WC version above 4 is required. ', 'rex-product-feed' ), esc_html( $status['wc_version'] )) . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Memory:', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['memory_status'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span>'.$status['memory'].'</mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend setting memory to at least 64MB. See: %2$s', 'rex-product-feed' ), esc_html( $status['memory'] ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'rex-product-feed' ) . '</a>' ) . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Upload Limit:', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['upload_limit_status'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span>'.$status['upload_limit'].'</mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We recommend upload limit to at least 64MB.', 'rex-product-feed' ), esc_html( $status['upload_limit'] ) . '</a>' ) . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('WP Cron', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['wp_cron'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span>Enable</mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( 'Disable - Cron should be enabled') . '</a>' . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo __('Product Feed Directory Writable', 'rex-product-feed'); ?></td>
                                    <td>
                                        <?php
                                        if ( $status['is_writable'] ) {
                                            echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> <code class="private">' . esc_html( $status['feed_directory'] ) . '</code></mark> ';
                                        } else {
                                            echo '<mark class="error"><span class="dashicons dashicons-warning"></span>  ' . sprintf( esc_html__( 'It is required to make feed directory writable. %1$s', 'rex-product-feed' ), '<code>' . esc_html( $status['feed_directory'] ) . '</code>', '<code>Feed Directory</code>' ) . '</mark>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>

                    <?php
                    if ( !$is_premium_activated ) {?>
                        <div id="tab6" class="tab-content block-wrapper">
                            <div class="upgrade">
                                <div class="rex-upgrade wpfm-pro-features">
                                    <h4 class="title"><?php echo __('Why upgrade to Pro?', 'rex-product-feed'); ?></h4>
                                    <ul>
                                        <li class="item"><?php echo __('Generate feed for unlimited products', 'rex-product-feed'); ?></li>
                                        <li class="item"><?php echo __('Unique Product Identifiers Custom Fields (Brand, GTIN, MPN, UPC, EAN, JAN, ISBN, ITF14, Offer price, Offer effective date)', 'rex-product-feed'); ?></li>
                                        <li class="item"><?php echo __('Detailed Product Attributes Custom Fields (Size, Pattern, Material, Age Group, Gender, Color)', 'rex-product-feed'); ?></li>
                                        <li class="item"><?php echo __('Ability To Exclude Tax From Structured Data Prices', 'rex-product-feed'); ?></li>
                                        <li class="item"><?php echo __('Option To Fix WooCommerce’s (Json-Ld) Structured Data Bug', 'rex-product-feed'); ?></li>
                                        <li class="item"><?php echo __('Custom Batch configuration', 'rex-product-feed'); ?></li>
                                        <li class="item"><?php echo __('9 more pre-built templates (including eBay MIP, eBay Seller Center, Google Product Review, Google Re-marketing (DRM) and others)', 'rex-product-feed'); ?></li>
                                    </ul>
                                    <a href="https://rextheme.com/best-woocommerce-product-feed/#upgrade-pro" target="_blank" class="btn-default"><?php echo __('Get Premium Version', 'rex-product-feed')?></a>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div id="tab7" class="tab-content block-wrapper wpfm-log">
                        <?php
                            $logs = WC_Admin_Status::scan_log_files();
                            $wpfm_logs = array();
                            $pattern = '/^wpfm|fatal/';
                            foreach($logs as $key => $value) {
                                if (preg_match($pattern,$key)){
                                    $wpfm_logs[$key] = $value;
                                }
                            }
                            echo '<form id="wpfm-error-log-form" action="'.esc_url( admin_url( 'admin.php?page=wpfm_dashboard' ) ).'" method="post">';
                                echo '<select id="wpfm-error-log" name="wpfm-error-log">';
                                    echo '<option value="">Please Select</option>';
                                    foreach($wpfm_logs as $key => $value) {
                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                    }
                                echo '<select>';
                                echo '<button type="submit" class="btn-default">'.__('View log', 'rex-product-feed').'</button>';
                            echo '</form>';

                            echo '<div id="log-viewer">';
                            echo '<button id="wpfm-log-copy" class="btn-default" style="display: none"> <i class="fa fa-files-o"></i>'.__('Copy log', 'rex-product-feed').'</button>';
                            echo '<pre id="wpfm-log-content"></pre>';
                            echo '</div>';

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>