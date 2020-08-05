<?php

add_action('wp_enqueue_scripts','strollik_child_styles');

function strollik_child_styles()
{
    wp_enqueue_style('strollik-child',get_stylesheet_directory_uri().'/assets/css/style.css',
        array('strollik-style','strollik-woocommerce'),'1.0.1');
}

add_action('init','strollik_child_redefine_woo_hooks',1000);

function strollik_child_redefine_woo_hooks()
{
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    remove_action('woocommerce_after_single_product_summary', 'osf_output_related_products', 20);

    //add_action( 'woo_related_products_tab_content', 'woocommerce_output_related_products', 20 );
    add_action( 'woo_related_products_tab_content', 'custom_osf_output_related_products', 20 );
}

add_filter( 'woocommerce_product_tabs', 'strollik_child_woo_remove_product_tabs', 98 );

function strollik_child_woo_remove_product_tabs( $tabs ) {

    $new_tabs=[];
    foreach ($tabs as $key=>$value){
        if ($key=='additional_information'){
            $new_tabs['related_product'] = array(
                'title' 	=> __( 'Related products', 'woocommerce' ),
                'priority' 	=> 50,
                'callback' 	=> 'woo_related_product_tab_content'
            );
        }else{
            $new_tabs[$key]=$value;
        }
    }

    return $new_tabs;
}

function woo_related_product_tab_content()
{
    do_action('woo_related_products_tab_content');
}

function custom_osf_output_related_products()
{
    $columns = absint(get_theme_mod('osf_woocommerce_single_related_columns', 3));
    $number = absint(get_theme_mod('osf_woocommerce_single_related_number', 3));
    if ($columns < $number) {
        echo '<div class="woocommerce-product-carousel owl-theme" data-columns="' . esc_attr($columns) . '">';
    } else {
        echo '<div class="columns-' . esc_attr($columns) . '">';
    }
    woocommerce_related_products($args = array(
        'posts_per_page' => $number,
        'columns' => $columns,
        'orderby' => 'rand',
    ));
    echo '</div>';
}
?>