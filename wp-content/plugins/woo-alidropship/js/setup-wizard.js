'use strict';
jQuery(document).ready(function ($) {
    //
    // $('.vi-ui.checkbox').checkbox();
    // $('select.vi-ui.dropdown').dropdown();
    /*Search categories*/
    $(".search-category").select2({
        closeOnSelect: false,
        placeholder: "Please fill in your category title",
        ajax: {
            url: "admin-ajax.php?action=wad_search_cate",
            dataType: 'json',
            type: "GET",
            quietMillis: 50,
            delay: 250,
            data: function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1
    });

    /*Add row*/
    $('.vi-wad-price-rule-add').on('click', function () {
        let rows = $('.vi-wad-price-rule-row'),
            lastRow = rows.last(),
            min_price = 0;
        if (lastRow.length > 0) {
            min_price = parseInt(lastRow.find('.vi-wad-price-from').val()) + 1;
            lastRow.find('.vi-wad-price-from').prop('max', min_price - 1);
            lastRow.find('.vi-wad-price-to').val(min_price);
        }
        let newRow = lastRow.clone();
        newRow.find('.vi-wad-price-from').val(min_price).prop('min', min_price).prop('max', '');
        newRow.find('.vi-wad-price-to').val('');
        console.log(newRow);

        $('.vi-wad-price-rule-container').append(newRow);
        calculateNewPriceRange();
    });

    /*remove last row*/
    $('.vi-wad-price-rule-remove').on('click', function () {
        let rows = $('.vi-wad-price-rule-row'),
            lastRow = rows.last();
        if (rows.length > 1) {
            if (confirm('Do you want to remove the last level of price rules?')) {
                let prev = $('.vi-wad-price-rule-row').eq(rows.length - 2);
                prev.find('.vi-wad-price-to').val('');
                lastRow.remove();
                /*recalculate new price range*/
                if (rows.length > 2) {
                    prev.find('.vi-wad-price-from').prop('max', '');
                }
            }
        } else {
            alert('Cannot remove more.')
        }
    });
    calculateNewPriceRange();

    function calculateNewPriceRange() {
        /*calculate when "price from" changes*/
        $('.vi-wad-price-from').unbind().on('change', function () {
            let rows = $('.vi-wad-price-rule-row'),
                current = $(this).closest('tr'),
                value = parseInt($(this).val()),
                plusValue = parseInt(current.find('.vi-wad-plus-value').val());
            let currentPos = rows.index(current),
                nextRow = rows.eq(currentPos + 1),
                prevRow = rows.eq(currentPos - 1),
                prevRowPlusVal = parseInt(prevRow.find('.vi-wad-plus-value').val());
            let max = parseInt($(this).prop('max')),
                min = parseInt($(this).prop('min'));
            if (value < min) {
                value = min;
                $(this).val(value);
            } else if (value > max) {
                value = max;
                $(this).val(value);
            }
            if (currentPos > 0) {
                prevRow.find('.vi-wad-price-to').val(value);
            }
            if (currentPos > 1) {
                prevRow.find('.vi-wad-price-from').prop('max', value - 1);
            }
            if (nextRow.length > 0) {
                nextRow.find('.vi-wad-price-from').prop('min', value + 1);
            }
        });
        $('.vi-wad-plus-value-type').unbind().on('change', function () {
            let rows = $('.vi-wad-price-rule-row'),
                current = $(this).closest('tr');
            switch ($(this).val()) {
                case 'fixed':
                    current.find('.vi-wad-value-label-left').html('+');
                    current.find('.vi-wad-value-label-right').html('$');
                    break;
                case 'percent':
                    current.find('.vi-wad-value-label-left').html('+');
                    current.find('.vi-wad-value-label-right').html('%');
                    break;
                default:
                    current.find('.vi-wad-value-label-left').html('=');
                    current.find('.vi-wad-value-label-right').html('$');
            }
        });
    }

    function roundResult(number) {
        let decNum = parseInt($('.vi-wad-woocommerce-decimal').val()),
            temp = Math.pow(10, decNum);
        return Math.round(number * temp) / temp;
    }

    $('.vi-ui.button.primary').on('click', function () {
        if ($('.vi-wad-secret-key').val() == '') {
            alert('Secret key cannot be empty.');
            return false;
        } else if (!$('#vi-wad-import-currency-rate').val()) {
            alert('Please enter Import products currency exchange rate');
            return false;
        }
    });


});