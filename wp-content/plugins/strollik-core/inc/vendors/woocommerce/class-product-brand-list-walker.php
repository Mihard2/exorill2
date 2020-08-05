<?php
/**
 * OTF_Product_Brand_List_Walker class
 *
 * @extends 	Walker
 * @class 		OTF_Product_Brand_List_Walker
 * @version		2.3.0
 * @package		WooCommerce/Classes/Walkers
 * @author 		WooThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'OTF_Product_Brand_List_Walker', false ) ) :

    class OTF_Product_Brand_List_Walker extends Walker{

        /**
         * What the class handles.
         *
         * @var string
         */
        public $tree_type = 'product_brand';

	    /**
	     * DB fields to use.
	     *
	     * @var array
	     */
	    public $db_fields = array(
		    'parent' => 'parent',
		    'id'     => 'term_id',
		    'slug'   => 'slug',
	    );

	    /**
	     * Starts the list before the elements are added.
	     *
	     * @see Walker::start_lvl()
	     * @since 2.1.0
	     *
	     * @param string $output Passed by reference. Used to append additional content.
	     * @param int    $depth Depth of category. Used for tab indentation.
	     * @param array  $args Will only append content if style argument value is 'list'.
	     */
	    public function start_lvl( &$output, $depth = 0, $args = array() ) {
		    if ( 'list' !== $args['style'] ) {
			    return;
		    }

		    $indent  = str_repeat( "\t", $depth );
		    $output .= "$indent<ul class='children'>\n";
	    }

	    /**
	     * Ends the list of after the elements are added.
	     *
	     * @see Walker::end_lvl()
	     * @since 2.1.0
	     *
	     * @param string $output Passed by reference. Used to append additional content.
	     * @param int    $depth Depth of category. Used for tab indentation.
	     * @param array  $args Will only append content if style argument value is 'list'.
	     */
	    public function end_lvl( &$output, $depth = 0, $args = array() ) {
		    if ( 'list' !== $args['style'] ) {
			    return;
		    }

		    $indent  = str_repeat( "\t", $depth );
		    $output .= "$indent</ul>\n";
	    }


        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         * @since 2.1.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $cat
         * @param int $depth Depth of category in reference to parents.
         * @param array $args
         * @param integer $current_object_id
         */
        public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {

            $output .= '<li class="brand-item brand-item-' . $cat->term_id;

            if ( $args['current_brand'] == $cat->term_id ) {
                $output .= ' current-brand chosen';
            }

            if ( $args['has_children'] && $args['hierarchical'] && ( empty( $args['max_depth'] ) || $args['max_depth'] > $depth + 1 ) ) {
                $output .= ' brand-parent';
            }

            if ( $args['current_brand_ancestors'] && $args['current_brand'] && in_array( $cat->term_id, $args['current_brand_ancestors'] ) ) {
                $output .= ' current-brand-parent chosen';
            }


            $output .= '">';
            $output .= '<a href="' . get_term_link( (int) $cat->term_id, $this->tree_type ) . '">';

            if($args['show_logo']){
                $image_logo = get_term_meta((int) $cat->term_id, 'product_brand_logo', true);
                $image_logo = (!empty($image_logo)) ? $image_logo : wc_placeholder_img_src();
                $output .= '<img class="product-brand-logo" src="'.esc_url_raw($image_logo).'" alt="'. esc_attr( $cat->name ) .'"  title="'. esc_attr( $cat->name ) .'">';
            }else{
                $output .= _x( $cat->name, 'product brand name', 'strollik-core' );
            }
            $output .= '</a>';

            if ( $args['show_count'] ) {
                $output .= ' <span class="count">(' . $cat->count . ')</span>';
            }
        }

	    public function end_el( &$output, $cat, $depth = 0, $args = array() ) {
		    $output .= "</li>\n";
	    }

	    public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		    if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
			    return;
		    }
		    parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	    }
    }

endif;
