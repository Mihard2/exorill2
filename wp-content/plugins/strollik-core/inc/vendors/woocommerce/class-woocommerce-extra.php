<?php

/**
 * Main class of plugin for admin
 */
class Opal_Woocommerce_Extra {


    /**
     * Class constructor.
     */
    public function __construct() {

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'woocommerce_product_options_pricing', array( $this, 'add_deal_fields' ) );
        add_action( 'save_post', array( $this, 'save_product_data' ) );
        add_action('wp_head',array($this,'initAjaxUrl'),15);

        //Add Custom Taxonomy Brand
        add_action( 'init', array($this, 'custom_taxonomy_brands' ) );
        add_action('cmb2_admin_init', array($this, 'brands_taxonomy_metaboxes'));
        include_once( STROLLIK_CORE_PLUGIN_DIR . '/inc/vendors/woocommerce/class-wc-widget-product-brands.php' );
        include_once( STROLLIK_CORE_PLUGIN_DIR . '/inc/vendors/woocommerce/class-wc-widget-layered-nav.php' );

        add_action( 'widgets_init', array($this, 'register_widget' ) );


        // add section in product edit page
        add_filter( 'woocommerce_screen_ids', array( $this, 'brand_screen_ids' ), 20 );

        add_action( 'woocommerce_recorded_sales', array( $this, 'update_deal_sales' ) );
        add_action( 'woocommerce_scheduled_sales', array( $this, 'schedule_deals' ) );
        add_filter( 'woocommerce_quantity_input_args', array( $this, 'quantity_input_args' ), 10, 2 );

        add_action( 'wp_ajax_otf_ajax_load_shortcode', array($this,'ajax_load_shortcode') );
        add_action( 'wp_ajax_nopriv_otf_ajax_load_shortcode', array($this,'ajax_load_shortcode') );
        require_once( ABSPATH . '/wp-includes/shortcodes.php' );

    }


    /**
     * Enqueue scripts
     *
     * @param string $hook
     */
    public function enqueue_scripts( $hook ) {
        if($hook === 'post.php' && get_post_type() === 'product'){
	        wp_enqueue_script( 'otf-woocommerce-admin', STROLLIK_CORE_PLUGIN_URL. 'assets/js/woocommerce/admin.js', array( 'jquery' ), STROLLIK_CORE_VERSION, true );
        }
    }

    public function initAjaxUrl() { ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
        </script>
        <?php
    }

    // Register Custom Taxonomy
    public function custom_taxonomy_brands()  {

        $labels = array(
            'name'                       => esc_html__('Brands','strollik-core'),
            'singular_name'              => esc_html__('Brands','strollik-core'),
            'menu_name'                  => esc_html__('Brands','strollik-core'),
            'all_items'                  => esc_html__('All Brands','strollik-core'),
            'parent_item'                => esc_html__('Parent Brand','strollik-core'),
            'parent_item_colon'          => esc_html__('Parent Brand:','strollik-core'),
            'new_item_name'              => esc_html__('New Brand Name','strollik-core'),
            'add_new_item'               => esc_html__('Add New Brands','strollik-core'),
            'edit_item'                  => esc_html__('Edit Brand','strollik-core'),
            'update_item'                => esc_html__('Update Brand','strollik-core'),
            'separate_items_with_commas' => esc_html__('Separate Brand with commas','strollik-core'),
            'search_items'               => esc_html__('Search Brands','strollik-core'),
            'add_or_remove_items'        => esc_html__('Add or remove Brands','strollik-core'),
            'choose_from_most_used'      => esc_html__('Choose from the most used Brands','strollik-core'),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => false,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'rewrite'                    => array('slug' => 'product-brand')
        );
        register_taxonomy( 'product_brand', 'product', $args );
    }

    public function brands_taxonomy_metaboxes() {
        $prefix = 'product_brand_';
        $cmb_term = new_cmb2_box(array(
            'id'           => 'product_brand',
            'title'        => __('Product Metabox', 'strollik-core'), // Doesn't output for term boxes
            'object_types' => array('term'),
            'taxonomies'   => array('product_brand'),
            // 'new_term_section' => true, // Will display in the "Add New Category" section
        ));

        $cmb_term->add_field(array(
            'name'       => __('Logo', 'strollik-core'),
            //                'desc' => __('Location image', 'homefinder'),
            'id'         => $prefix . 'logo',
            'type'       => 'file',
            'options'    => array(
                'url' => false, // Hide the text input for the url
            ),
            'query_args' => array(
                'type' => 'image',
            ),
        ));
    }

    public function product_video_custom_field(){
        $prefix = 'otf_products_';
        $cmb = new_cmb2_box( array(
            'id'            => $prefix . 'product_video',
            'title'         => esc_html__( 'Product Video Config', 'strollik-core' ),
            'object_types'  => array( 'product' ),
            'context'    => 'normal',
            'priority'   => 'default',
        ) );

        $cmb->add_field( array(
            'name' => __('Product video','strollik-core'),
            'desc' => __('Supports video from youtube and vimeo.','strollik-core'),
            'id'   => $prefix . 'video',
            'type' => 'oembed',
        ) );

        $cmb->add_field( array(
            'name'    => __('Video Thumbnail','strollik-core'),
            'desc'    => 'Upload an image or enter an URL.',
            'id'      => $prefix . 'video_thumbnail',
            'type'    => 'file',
            'text'    => array(
                'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
            ),
            'options' => array(
                'url' => false, // Hide the text input for the url
            ),
            'preview_size' => 'thumbnail', // Image size to use when previewing in the admin.
        ) );


    }

    public function register_widget(){
        register_widget( 'OSF_Widget_Product_Brands' );
        register_widget( 'OSF_Widget_Layered_Nav' );
    }

    /**
     * Add the sale quantity field
     */
    public function add_deal_fields() {
        global $thepostid;

        $quantity     = get_post_meta( $thepostid, '_deal_quantity', true );
        $sales_counts = get_post_meta( $thepostid, '_deal_sales_counts', true );
        $sales_counts = intval( $sales_counts );
        $min          = $sales_counts > 0 ? $sales_counts + 1 : 0;
        ?>

        <p class="form-field _deal_quantity_field">
            <label for="_sale_quantity"><?php esc_html_e( 'Sale quantity', 'strollik-core' ) ?></label>
            <?php echo wc_help_tip( __( 'Set this quantity will make the product to be a deal. The sale will end when this quantity is sold out.', 'strollik-core' ) ); ?>
            <input type="number" min="<?php echo $min; ?>" class="short" name="_deal_quantity" id="_deal_quantity" value="<?php echo esc_attr( $quantity ) ?>">

            <?php
            if ( $quantity > 0 ) {
                echo '<span class="deal-sold-counts" style="clear:both;display:block;"><strong>' . sprintf( _n( '%s product is sold', '%s products are sold', max( 1, $sales_counts ), 'bicomart-core', 'filaminimal-core', 'strollik-core', 'strollik-core' ), $sales_counts ) . '</strong></span>';
            }
            ?>
        </p>

        <?php
    }

    /**
     * Save product data
     *
     * @param int $post_id
     */
    public function save_product_data( $post_id ) {
        if ( 'product' !== get_post_type( $post_id ) ) {
            return;
        }

        if ( isset( $_POST['_deal_quantity'] ) ) {
            $current_sales = get_post_meta( $post_id, '_deal_sales_counts', true );

            // Reset sales counts if set the qty to 0
            if ( $_POST['_deal_quantity'] <= 0 ) {
                update_post_meta( $post_id, '_deal_sales_counts', 0 );
                update_post_meta( $post_id, '_deal_quantity', '' );
            } elseif ( $_POST['_deal_quantity'] < $current_sales ) {
                $this->end_deal( $post_id );
            } else {
                update_post_meta( $post_id, '_deal_quantity', wc_clean( $_POST['_deal_quantity'] ) );
            }
        } else {
            // Reset sales counts and qty setting
            update_post_meta( $post_id, '_deal_sales_counts', 0 );
            update_post_meta( $post_id, '_deal_quantity', '' );
        }
    }

    /**
     * Update deal sales count
     *
     * @param int $order_id
     */
    public function update_deal_sales( $order_id ) {
        $order_post = get_post( $order_id );

        // Only apply for the main order
        if ( $order_post->post_parent != 0 ) {
            return;
        }

        $order = wc_get_order( $order_id );

        if ( sizeof( $order->get_items() ) > 0 ) {
            foreach ( $order->get_items() as $item ) {
                /**
                 * @var $item WC_Order_Item_Product
                 */
                if ( $product_id = $item->get_product_id() ) {
                    ;
                    add_post_meta( $product_id, '_deal_sales_counts', 0, true );

                    $current_sales = get_post_meta( $product_id, '_deal_sales_counts', true );
                    $deal_quantity = get_post_meta( $product_id, '_deal_quantity', true );
                    $new_sales     = $current_sales + absint( $item->get_quantity() );

                    // Reset deal sales and remove sale price when reach to limit sale quantity
                    if ( $new_sales >= $deal_quantity ) {
                        $this->end_deal( $product_id );
                    } else {
                        update_post_meta( $product_id, '_deal_sales_counts', $new_sales );
                    }
                }
            }
        }
    }

    /**
     * Remove deal data when sale is scheduled end
     */
    public function schedule_deals() {
        $data_store  = WC_Data_Store::load( 'product' );
        $product_ids = $data_store->get_ending_sales();

        if ( $product_ids ) {
            foreach ( $product_ids as $product_id ) {
                if ( $product = wc_get_product( $product_id ) ) {
                    update_post_meta( $product_id, '_deal_sales_counts', 0 );
                    update_post_meta( $product_id, '_deal_quantity', '' );
                }
            }
        }
    }

    /**
     * Remove deal data of a product.
     * Remove sale price
     * Remove sale schedule dates
     * Remove sale quantity
     * Reset sales counts
     *
     * @param int $post_id
     *
     * @return void
     */
    public function end_deal( $post_id ) {
        update_post_meta( $post_id, '_deal_sales_counts', 0 );
        update_post_meta( $post_id, '_deal_quantity', '' );

        // Remove sale price
        $product       = wc_get_product( $post_id );
        $regular_price = $product->get_regular_price();
        $product->set_price( $regular_price );
        $product->set_sale_price( '' );
        $product->set_date_on_sale_to( '' );
        $product->set_date_on_sale_from( '' );
        $product->save();

        delete_transient( 'wc_products_onsale' );
    }

    /**
     * Add  all WooCommerce screen ids.
     *
     * @since  1.0
     *
     * @param  array $screen_ids
     *
     * @return array
     */
    function brand_screen_ids( $screen_ids ) {
        $screen_ids[] = 'opal_woocommerce_product_brand';

        return $screen_ids;
    }

    /**
     * Change the "max" attribute of quantity input
     *
     * @param array $args
     * @param object $product
     *
     * @return array
     */
    public function quantity_input_args( $args, $product ) {
        if ( ! osf_woocommerce_is_deal_product( $product ) ) {
            return $args;
        }

        $args['max_value'] = $this->get_max_purchase_quantity( $product );

        return $args;
    }

    /**
     * Get max value of quantity input for a deal product
     *
     * @param object $product
     *
     * @return int
     */
    public function get_max_purchase_quantity( $product ) {
        $limit = get_post_meta( $product->get_id(), '_deal_quantity', true );
        $sold = intval(get_post_meta( $product->get_id(), '_deal_sales_counts', true ));

        $max = $limit - $sold;
        $original_max = $product->is_sold_individually() ? 1 : ( $product->backorders_allowed() || ! $product->managing_stock() ? -1 : $product->get_stock_quantity() );

        if ( $original_max < 0 ) {
            return $max;
        }

        return min( $max, $original_max );
    }

    public function ajax_load_shortcode(){
        $shortcode = $_REQUEST['shortcode'];
        echo do_shortcode($shortcode);
        die;
    }
}

new Opal_Woocommerce_Extra;