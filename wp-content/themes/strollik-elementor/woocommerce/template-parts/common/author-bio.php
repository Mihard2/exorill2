<?php
$user = wp_get_current_user();
$description = get_the_author_meta( 'description');
if($description == ''){
	return;
}
?>

<div class="author-wrapper">
    <div class="author-avatar">
		<?php
		if ( $user ) : ?>
            <img src="<?php echo esc_url( get_avatar_url( $user->ID ) ); ?>"/>
		<?php endif; ?>
    </div>

    <div class="author-name">
        <?php if(!empty($description)): ?>
            <h6 class="a-subtitle"><?php esc_html_e("About the author", 'strollik')?></h6>
        <?php endif; ?>
        <div class="a-name"><?php echo get_the_author(); ?></div>
    </div>

    <?php if(!empty($description)): ?>
        <div class="author-description">
            <?php echo nl2br( get_the_author_meta( 'description' ) ); ?>
        </div>
    <?php endif; ?>
</div>