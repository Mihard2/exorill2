<?php
/**
 * Provide a progress bar
 *
 *
 * @link       https://rextheme.com
 * @since      2.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/partials
 */


?>



<div class="bwfm-progressbar clearfix" style="display: none">
    <div class="progressbar-bar" style="background: #2ecc71;"></div>
    <div class="progressbar-bar-percent">0</div>
</div>



<div class="progress-msg" style="display: none">
    <div class="feed-msg">
        <i class="fa fa-cog fa-spin" style="font-size:24px"></i> <span><?php echo __('Your feed is generating', 'rex-product-feed').'....'?></span>
    </div>

    <div class="wpfm-time-container" id="wpfm-feed-clock"></div>
</div>