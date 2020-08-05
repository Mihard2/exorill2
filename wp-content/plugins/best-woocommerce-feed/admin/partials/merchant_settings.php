<?php


require plugin_dir_path( __FILE__ ) . 'loading-spinner.php';

$rex_google_merchant = new Rex_Google_Merchant_Settings_Api();

$html = '';
$disable = '';
$client_id = $rex_google_merchant::$client_id;
$client_secret = $rex_google_merchant::$client_secret;
$merchant_id = $rex_google_merchant::$merchant_id;
$redirect_uri = admin_url( 'admin.php?page=merchant_settings' );

if(isset($_GET['code'])){
    $rex_google_merchant->save_access_token($_GET['code']);
}

if (!($rex_google_merchant->is_authenticate())){
    if($client_id && $client_secret && $merchant_id)
        $html  = $rex_google_merchant->get_access_token_html();
}else{
    $html = $rex_google_merchant->authorization_success_html();
}
//$html = $rex_google_merchant->authorization_success_html();
if($client_id && $client_secret && $merchant_id)
    $disable = 'disabled';

?>

    <div class="merchant-settings">
        <div class="left-merchant">
            <!-- single-merchant-area .end  -->
            <?php echo $html; ?>
            <div class="single-merchant-area configure">
                <div class="single-merchant-block">
                    <div class="merchant-authorized-area">
                    </div>
                    <h2 class="title"><?php echo __('Configure your google merchant', 'rex-product-feed'); ?></h2>
                    <form class="rex-google-merchant" id="rex-google-merchant">
                        <div class="row">
                            <div class="input-field">
                                <input id="client_id" type="text" name="client_id" class="validate" required value="<?php echo $client_id; ?>">
                                <label for="client_id"><?php echo __('Client ID#: ', 'rex-product-feed'); ?></label>
                            </div>
                            <div class="input-field">
                                <input id="client_secret" type="text" name="client_secret" class="validate" required value="<?php echo $client_secret; ?>">
                                <label for="client_secret"><?php echo __('Client Secret: ', 'rex-product-feed'); ?></label>
                            </div>
                            <div class="input-field">
                                <input id="merchant_id" type="text" name="merchant_id" class="validate" required value="<?php echo $merchant_id; ?>">
                                <label for="merchant_id"><?php echo __('Merchant ID# : ', 'rex-product-feed'); ?></label>
                            </div>

                            <div class="input-field">
                                <input disabled value="<?php echo $redirect_uri; ?>" id="disabled" type="text" class="validate">
                                <label for="disabled"><?php echo __('Redirect URL', 'rex-product-feed'); ?></label>
                            </div>

                            <div class="button-area">
                                <button class="btn waves-effect waves-light btn-default rex-reset-btn" type="button" style="margin-right: 10px;"><?php echo __('Reset', 'rex-product-feed'); ?>

                                </button>

                                <button class="btn waves-effect waves-light btn-default" type="submit" name="action" <?php echo $disable; ?>><?php echo __('Submit', 'rex-product-feed'); ?>

                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <!-- single-merchant-area .end -->

        </div>
        <!-- left-merchant -->

        <div class="right-merchant">
            <div class="single-merchant-area">
                <div class="single-merchant-block">
                    <div class="video-container">
                        <iframe width="853" height="480" src="//www.youtube.com/embed/CVMqRunbW5g" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
            <!-- single-merchant-area -->
        </div>
        <!-- right-merchant -->

    </div>
    <!-- merchant-settings .end -->

