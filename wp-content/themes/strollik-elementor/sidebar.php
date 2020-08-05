<?php
$sidebar = apply_filters( 'opal_theme_sidebar', '' );
if (!$sidebar){
    return;
}
?>
<aside id="secondary" class="widget-area" role="complementary">
    <div class="inner">
        <?php dynamic_sidebar( $sidebar ); ?>
    </div>
</aside><!-- #secondary -->
