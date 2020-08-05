(function( $ ) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(document).ready(function(){

        function wpfm_add_to_cart_ajax(product_id) {
            $.ajax({
                type : "post",
                dataType : "json",
                url : wpfm_frontent_ajax.ajax_url,
                data: {
                    action   : 'wpfm_add_to_cart',
                    product_id: product_id,
                    security : wpfm_frontent_ajax.ajax_nonce,
                },
                success: function(response) {
                    console.log('Whooo!');
                    fbq('track', 'AddToCart', {
                        content_ids: [response.product_id],
                        content_name: response.product_name,
                        content_category: response.cats,
                        content_type: 'product',
                        value: response.product_price,
                        currency: response.currency,
                    });
                },
                error: function(){
                    console.log( 'uh, oh!' );
                }
            });
        }

        /**
         * Shop page AddToCart event
         */
        $(".add_to_cart_button").click(function(){
            var product_id = $(this).attr('data-product_id');
            if(product_id) {
                wpfm_add_to_cart_ajax(product_id);
            }
        });


        /**
         * Product single page
         * AddToCart event
         */
        $(".single_add_to_cart_button").click(function(event){
            var product_id =  $('input[name=product_id]').val();
            if(!product_id){
                product_id = $(this).attr('value');
            }
            if(product_id) {
                wpfm_add_to_cart_ajax(product_id);
            }
        });
    });
})( jQuery );