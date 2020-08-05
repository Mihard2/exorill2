<?php

/**
 * Class for retriving product data based on user selected feed configuration.
 *
 * Get the product data based on feed config selected by user.
 *
 * @package    Rex_Yandex_Product_Data_Retriever
 * @subpackage Rex_Product_Feed/admin
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Yandex_Product_Data_Retriever extends Rex_Product_Data_Retriever {


    /**
     * Retrieve a product's categories as a list with specified format.
     *
     * @param string $before Optional. Before list.
     * @param string $sep Optional. Separate items using this.
     * @param string $after Optional. After list.
     * @return string|false
     */
    protected function get_product_cats( $before = '', $sep = ' > ', $after = '' ) {
        $term_ids_array = array();
        $terms = get_the_terms( $this->product->get_id(), 'product_cat' );
        $count = 0;
        if($terms) $count = count($terms);
        if($count) {
            foreach ($terms as $term) {
                $term_ids_array[] = $term->term_id;
            }
        }
        return $term_ids_array;
    }
}