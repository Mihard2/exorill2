<?php
/**
 * Product Brands Widget
 *
 * @author   WPOpal
 * @category Widgets
 * @package  WooCommerce/Widgets
 * @version  2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Product categories widget class.
 *
 * @extends WC_Widget
 */
class OSF_Widget_Product_Brands extends WC_Widget{

    /**
     * Category ancestors.
     *
     * @var array
     */
    public $brand_ancestors;

    /**
     * Current Category.
     *
     * @var bool
     */
    public $current_brand;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_product_brands';
        $this->widget_description = __( 'A list or dropdown of product brands.', 'strollik-core' );
        $this->widget_id          = 'woocommerce_product_brands';
        $this->widget_name        = __( 'Product Brands', 'strollik-core' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => __( 'Product Brands', 'strollik-core' ),
                'label' => __( 'Title', 'strollik-core' ),
            ),
            'dropdown' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show as dropdown', 'strollik-core' ),
            ),
            'show_logo' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show logo brand', 'strollik-core' ),
            ),
            'count' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Show product counts', 'strollik-core' ),
            ),
            'hierarchical' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => __( 'Show hierarchy', 'strollik-core' ),
            ),
            'show_children_only' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Only show children of the current brand', 'strollik-core' ),
            ),
            'hide_empty' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => __( 'Hide empty brands', 'strollik-core' ),
            ),
            'max_depth'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => __( 'Maximum depth', 'strollik-core' ),
            ),
        );

        parent::__construct();
    }

    /**
     * Output widget.
     *
     * @see WP_Widget
     * @param array $args     Widget arguments.
     * @param array $instance Widget instance.
     */
    public function widget( $args, $instance ) {
        global $wp_query, $post;

        $count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
        $hierarchical       = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
        $show_children_only = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
        $dropdown           = isset( $instance['dropdown'] ) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
        $hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
        $show_logo          = isset( $instance['show_logo'] ) ? $instance['show_logo'] : $this->settings['show_logo']['std'];
        $dropdown_args      = array(
            'hide_empty' => $hide_empty,
        );
        $list_args          = array(
            'show_count'   => $count,
            'hierarchical' => $hierarchical,
            'taxonomy'     => 'product_brand',
            'hide_empty'   => $hide_empty,
        );
        $max_depth          = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

        $list_args['menu_order'] = false;
        $dropdown_args['depth']  = $max_depth;
        $list_args['depth']      = $max_depth;

        $this->current_brand   = false;
        $this->brand_ancestors = array();

        if ( is_tax( 'product_brand' ) ) {
            $this->current_brand   = $wp_query->queried_object;
            $this->brand_ancestors = get_ancestors( $this->current_brand->term_id, 'product_brand' );

        } elseif ( is_singular( 'product' ) ) {
            $product_category = wc_get_product_terms( $post->ID, 'product_cat', apply_filters( 'woocommerce_product_brands_widget_product_terms_args', array(
                'orderby' => 'parent',
            ) ) );

            if ( ! empty( $product_category ) ) {
                $this->current_brand   = end( $product_category );
                $this->brand_ancestors = get_ancestors( $this->current_brand->term_id, 'product_cat' );
            }
        }

        // Show Siblings and Children Only.
        if ( $show_children_only && $this->current_brand ) {
            if ( $hierarchical ) {
                $include = array_merge(
                    $this->brand_ancestors,
                    array( $this->current_brand->term_id ),
                    get_terms(
                        'product_brand',
                        array(
                            'fields'       => 'ids',
                            'parent'       => 0,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    ),
                    get_terms(
                        'product_brand',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $this->current_brand->term_id,
                            'hierarchical' => true,
                            'hide_empty'   => false,
                        )
                    )
                );
                // Gather siblings of ancestors.
                if ( $this->brand_ancestors ) {
                    foreach ( $this->brand_ancestors as $ancestor ) {
                        $include = array_merge( $include, get_terms(
                            'product_brand',
                            array(
                                'fields'       => 'ids',
                                'parent'       => $ancestor,
                                'hierarchical' => false,
                                'hide_empty'   => false,
                            )
                        ) );
                    }
                }
            } else {
                // Direct children.
                $include = get_terms(
                    'product_brand',
                    array(
                        'fields'       => 'ids',
                        'parent'       => $this->current_brand->term_id,
                        'hierarchical' => true,
                        'hide_empty'   => false,
                    )
                );
            } // End if().

            $list_args['include']     = implode( ',', $include );
            $dropdown_args['include'] = $list_args['include'];

            if ( empty( $include ) ) {
                return;
            }
        } elseif ( $show_children_only ) {
            $dropdown_args['depth']        = 1;
            $dropdown_args['child_of']     = 0;
            $dropdown_args['hierarchical'] = 1;
            $list_args['depth']            = 1;
            $list_args['child_of']         = 0;
            $list_args['hierarchical']     = 1;
        } // End if().

        $this->widget_start( $args, $instance );

        if ( $dropdown ) {
            wc_product_dropdown_categories( apply_filters( 'woocommerce_product_brands_widget_dropdown_args', wp_parse_args( $dropdown_args, array(
                'show_count'         => $count,
                'hierarchical'       => $hierarchical,
                'show_uncategorized' => 0,
                'selected'           => $this->current_brand ? $this->current_brand->slug : '',
                'taxonomy'           => 'product_brand',
                'name'               => 'product_brand',
                'class'              => 'dropdown_product_brand',
            ) ) ) );
            wc_enqueue_js( "
				jQuery( '.dropdown_product_brand' ).change( function() {
					if ( jQuery(this).val() != '' ) {
						var this_page = '';
						var home_url  = '" . esc_js( home_url( '/' ) ) . "';
						if ( home_url.indexOf( '?' ) > 0 ) {
							this_page = home_url + '&product_brand=' + jQuery(this).val();
						} else {
							this_page = home_url + '?product_brand=' + jQuery(this).val();
						}
						location.href = this_page;
					}
				});
			" );
        } else {
            include_once( STROLLIK_CORE_PLUGIN_DIR . '/inc/vendors/woocommerce/class-product-brand-list-walker.php' );

            $list_args['walker']                     = new OTF_Product_Brand_List_Walker;
            $list_args['title_li']                   = '';
            $list_args['pad_counts']                 = 1;
            $list_args['show_option_none']           = __( 'No product brands exist.', 'strollik-core' );
            $list_args['current_brand']              = ( $this->current_brand ) ? $this->current_brand->term_id : '';
            $list_args['current_brand_ancestors']    = $this->brand_ancestors;
            $list_args['max_depth']                  = $max_depth;
            $list_args['show_logo']                  = $show_logo;
            $id = wp_generate_uuid4();

            echo '<input type="text" id="otf-product-brands-'. $id .'" onkeyup="Otf_search_product_brand();" placeholder="'. esc_attr__('Search for brand name...', 'strollik-core').'" title="'.esc_attr__('Type in a name','strollik-core').'">';

            echo '<ul class="product-brands" id="otf-brands-'. $id .'">';

                wp_list_categories( apply_filters( 'woocommerce_product_brands_widget_args', $list_args ) );


            echo '</ul>';

            echo '<script>
                function Otf_search_product_brand() {
                    var input, filter, ul, li, a, i;
                    input = document.getElementById("otf-product-brands-'. $id .'");
                    filter = input.value.toUpperCase();
                    ul = document.getElementById("otf-brands-'. $id .'");
                    li = ul.getElementsByTagName("li");
                    for (i = 0; i < li.length; i++) {
                        a = li[i].getElementsByTagName("a")[0];
                        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            li[i].style.display = "";
                        } else {
                            li[i].style.display = "none";
                
                        }
                    }
                }
                </script>';
        } // End if().

        $this->widget_end( $args );
    }
}