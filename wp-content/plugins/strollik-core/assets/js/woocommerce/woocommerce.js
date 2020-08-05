//Woocommerce single js
jQuery(document).ready(function ($) {

    var $fbtProducts = $('.opal-frequently-bought');

    if ( $fbtProducts.length <= 0 ) {
        return;
    }

    //product Together Select
    var priceAt = $fbtProducts.find('.otf-total-price .woocommerce-Price-amount'),
        $button = $fbtProducts.find('.otf_add_to_cart_button'),
        totalPrice = parseFloat($fbtProducts.find('#otf-data_price').data('price')),
        currency = $fbtProducts.data('currency'),
        thousand = $fbtProducts.data('thousand'),
        decimal = $fbtProducts.data('decimal'),
        price_decimals = $fbtProducts.data('price_decimals'),
        currency_pos = $fbtProducts.data('currency_pos');

    $fbtProducts.find('input[type=checkbox]').on('change', function () {
        let id = $(this).val();
        $(this).closest('li').toggleClass('uncheck');
        let currentPrice = parseFloat($(this).closest('li').find('.product-price').data('price'));
        if ($(this).closest('li').hasClass('uncheck')) {
            $fbtProducts.find('#fbt-product-' + id).addClass('un-active');
            totalPrice -= currentPrice;

        } else {
            $fbtProducts.find('#fbt-product-' + id).removeClass('un-active');
            totalPrice += currentPrice;
        }

        let $product_ids = '0';
        $fbtProducts.find('.product-list li').each(function () {
            if (!$(this).hasClass('uncheck')) {
                $product_ids += ',' + $(this).find('input[type=checkbox]').val();
            }
        });

        $button.attr('value', $product_ids);

        priceAt.html( formatNumber( totalPrice) );
    });


    function formatNumber(number) {
        let n = number;
        if (parseInt(price_decimals) > 0) {
            number = number.toFixed(price_decimals) + '';
            var x = number.split('.');
            var x1 = x[0],
                x2 = x.length > 1 ? decimal + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + thousand + '$2');
            }

            n = x1 + x2
        }


        switch (currency_pos) {
            case 'left' :
                return currency + n;
                break;
            case 'right' :
                return n + currency;
                break;
            case 'left_space' :
                return currency + ' ' + n;
                break;
            case 'right_space' :
                return n + ' ' + currency;
                break;
        }
    }

    // Add to cart ajax
    $fbtProducts.on('click', '.otf_add_to_cart_button.ajax_add_to_cart', function() {
        var $singleBtn = $(this);
        $singleBtn.addClass('loading');

        var currentURL = window.location.href;

        $.ajax({
            url     : ajaxurl,
            dataType: 'json',
            method  : 'post',
            data    : {
                action     : 'otf_woocommerce_fbt_add_to_cart',
                product_ids: $singleBtn.attr('value')
            },
            error   : function() {
                window.location = currentURL;
            },
            success : function(response) {
                if ( typeof wc_add_to_cart_params !== 'undefined' ) {
                    if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
                        window.location = wc_add_to_cart_params.cart_url;
                        return;
                    }
                }

                $(document.body).trigger('updated_wc_div');
                $(document.body).on('wc_fragments_refreshed', function() {
                    $singleBtn.removeClass('loading');
                });

            }
        });

    });
});