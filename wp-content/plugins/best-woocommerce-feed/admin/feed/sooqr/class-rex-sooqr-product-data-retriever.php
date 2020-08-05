<?php

/**
 * Class for retriving product data based on user selected feed configuration.
 *
 * Get the product data based on feed config selected by user.
 *
 * @package    Rex_Sooqr_Product_Data_Retriever
 * @subpackage Rex_Product_Feed/admin
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Sooqr_Product_Data_Retriever extends Rex_Product_Data_Retriever {


    /**
     * Retrieve a product's categories as a list with specified format.
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     */
    protected function get_product_cats( $before = '', $sep = ' > ', $after = '' ) {
        $categories = [];
        if ( 'WC_Product_Variation' == get_class($this->product) ) {
            $term_list = wp_get_post_terms($this->product->get_parent_id(), 'product_cat');
            foreach ($term_list as $term) {
                if($term->parent) {
                    $categories['subcategories'][] = $term->name;
                }else {
                    $categories['categories'][] = $term->name;
                }
            }
            return $categories;
        }else {
            $term_list = wp_get_post_terms($this->product->get_id(), 'product_cat');
            foreach ($term_list as $term) {
                if($term->parent) {
                    $categories['subcategories'][] = $term->name;
                }else {
                    $categories['categories'][] = $term->name;
                }
            }
            return $categories;
        }

    }
}

