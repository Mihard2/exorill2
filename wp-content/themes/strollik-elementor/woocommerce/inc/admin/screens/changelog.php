<?php
/**
 * @var Strollik_Theme_Admin $this
 */

$this->get_tab_menu( 'changelog' );
?>

<div class="opal-wrap">
    <div class="container">
        <div class="row mt-30">
            <div class="col">
                <div class="theme-log box-shadow">
                    <div class="theme-log-header">
                        <h2 class="log-title"><?php esc_html_e( 'Theme Update Log', 'strollik' ); ?></h2>
                    </div>
                    <div class="theme-log-content">
                        <div class="log-list">
                            <strong>Version: 4.0.1</strong><span class="log-date">25, Oct 2018</span>
                            <ul>
                                <li><span class="label-update">update</span>CSS off-canvas menu</li>
                            </ul>
                        </div>
                        <div class="log-list">
                            <strong>Version: 4.0.0</strong><span class="log-date">24, Oct 2018</span>
                            <ul>
                                <li><span class="label-update">update</span>Released 4.0.0</li>
                                <li><span class="label-update">update</span>Elementor Support</li>
                                <li><span class="label-del">Remove</span><strike>Visual Composer Support</strike></strike></li>
<!--                                <li><span class="label-fix">fix</span>Update woocommerce 3.2.5</li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
