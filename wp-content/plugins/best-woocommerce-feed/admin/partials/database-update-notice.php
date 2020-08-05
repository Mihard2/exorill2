<?php ?>


<div id="wpfm-message" class="updated notice">
    <p>
        <strong><?php esc_html_e( 'WPFM Database Update Notice', 'rex-product-feed' ); ?></strong>
    </p>
    <p>
        <?php
            esc_html_e( 'WooCommerce Product Feed Manager is getting better and now, has an updated data structure for it to run smoothly. Click on update now to get the latest data structure for WPFM. None of your data will be changed/removed, only WPFM data will be restructured for better outcome.', 'rex-product-feed' );
            esc_html_e( 'The database update process runs in the background and may take a little while, so please be patient.', 'rex-product-feed' );

        ?>
    </p>
    <p class="submit">
        <a href="#" class="button-primary rex-wpfm-update-db" id="rex-wpfm-update-db">
            <?php esc_html_e( 'Update WPFM Database', 'rex-product-feed' ); ?>
        </a>

        <img src="<?php echo WPFM_PLUGIN_DIR_URL. '/admin/icon/loader.gif'?>" class="wpfm-db-update-loader">
    </p>
</div>