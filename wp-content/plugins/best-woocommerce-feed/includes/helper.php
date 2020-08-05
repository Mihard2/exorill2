<?php


if ( ! function_exists( 'wpfm_hierarchical_product_category_tree' ) ) {
    /**
     * Print hierarchical product categories
     *
     * @param $cat
     * @param array $config
     */
    function wpfm_hierarchical_product_category_tree( $cat, $config = array() ) {
        $args = array(
            'parent' 	=> $cat,
            'hide_empty'    => false,
            'no_found_rows' => true,
        );

        $next = get_terms('product_cat', $args);
        $separator = '';
        if( $next ) :
            foreach( $next as $cat ) :
                if($cat->parent !== 0){
                    $separator = '--';
                }
                $map_value = '';
                if(!empty($config)) {
                    $key = array_search($cat->term_id, array_column($config, 'map-key'));
                    if($key !== false) {
                        $map_value = $config[$key]['map-value'];
                    }
                }
                echo "<div class='single-category'>";
                echo "<span class='label'>{$separator}{$cat->name} ({$cat->count})</span>";
                echo "<div class='input-field'><input class='autocomplete category-suggest' type='text' name='category-{$cat->term_id}' value='{$map_value}' placeholder='Google Merchant Category'></div>";
                echo "</div>";
                $separator = '';
                wpfm_hierarchical_product_category_tree( $cat->term_id, $config );
            endforeach;
        endif;
    }
}


if ( ! function_exists( 'is_wpfm_logging_enabled' ) ) {
    /**
     * Check if logging is enabled or not
     *
     * @return bool
     */
    function is_wpfm_logging_enabled() {
        $enable_log = get_option('wpfm_enable_log', 'no') == 'yes' ? true : false;
        return $enable_log;
    }
}