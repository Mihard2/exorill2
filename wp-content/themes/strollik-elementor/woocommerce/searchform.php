<?php $unique_id = esc_attr(uniqid('search-form-')); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="input-group">
        <label for="<?php echo esc_attr($unique_id); ?>">
            <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'strollik'); ?></span>
        </label>
        <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="search-field form-control"
               placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'strollik'); ?>"
               value="<?php echo get_search_query(); ?>" name="s"/>
        <span class="input-group-btn">
            <button type="submit" class="search-submit">
                <span class="fa fa-search"></span>
                <span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'strollik'); ?></span>
            </button>
        </span>
        <?php
        if (strollik_is_Woocommerce_activated()) { ?>
            <input type="hidden" name="post_type" value="product"/>
            <?php
        } ?>
    </div>
</form>


