'use strict';
jQuery(document).ready(function ($) {
    $('.vi-ui.tabular.menu .item').vi_tab({
        history: true,
        historyType: 'hash'
    });

    $('.vi-ui.checkbox').checkbox();
    $('select.vi-ui.dropdown').dropdown();
    /*Button save*/
    $('.vi-wad-save-settings').on('click', function (e) {
        let rule_error = 0;
        $('.vi-wad-price-rule-row').map(function () {
            let $row = $(this);
            let $sale_price = $row.find('.vi-wad-plus-sale-value');
            let $price = $row.find('.vi-wad-plus-value');
            if ($sale_price.val() > -1 && $sale_price.val() > $price.val()) {
                rule_error++;
            }
        });
        if (rule_error > 0) {
            alert('Regular price can not be smaller than sale price');
            return false;
        }
    });
    /*Search categories*/
    $('.search-category').select2({
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
    /*Search tags*/
    $('.search-tags').select2({
        closeOnSelect: false,
        placeholder: "Please fill in your category title",
        ajax: {
            url: "admin-ajax.php?action=wad_search_tags",
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

    $('.vi-wad-generate-secretkey').on('click', function () {
        var a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split(""), b = [];
        for (let i = 0; i < 32; i++) {
            var j = (Math.random() * (a.length - 1)).toFixed(0);
            b[i] = a[j];
        }

        $('.vi-wad-secret-key').val(b.join(""));
    });

    $('.vi-wad-copy-secretkey').on('click', function () {
        let $container = $(this).closest('td');
        $container.find('.vi-wad-secret-key').select();
        $container.find('.vi-wad-copy-secretkey-success').remove();
        document.execCommand('copy', true);
        let $result_icon = $('<span class="vi-wad-copy-secretkey-success dashicons dashicons-yes" title="Copied to Clipboard"></span>');
        $container.append($result_icon);
        $result_icon.fadeOut(10000);
        setTimeout(function () {
            $result_icon.remove();
        }, 10000);
    });

//String replace

    $('.add-string-replace-rule').on('click', function () {
        let clone = `<tr class="clone-source">
                        <td>
                            <input type="text" name="wad_string_replace[from_string][]">
                        </td>
                         <td>
                            <div class="vi-wad-string-replace-sensitive-container">
                            <input type="checkbox" value="1" class="vi-wad-string-replace-sensitive">                            
                            <input type="hidden" class="vi-wad-string-replace-sensitive-value" value="" name="wad_string_replace[sensitive][]">
                            </div>
                        </td>
                        <td>
                            <input type="text" name="wad_string_replace[to_string][]"  placeholder="Blank is delete">
                        </td>
                        <td>
                            <button type="button" class="vi-ui button negative delete-string-replace-rule">
                                <i class="dashicons dashicons-trash "></i>
                            </button>
                        </td>
                    </tr>`;

        $('.string-replace tbody').append(clone);
    });

    $('body').on('change', '.vi-wad-string-replace-sensitive', function () {
        let $container = $(this).closest('.vi-wad-string-replace-sensitive-container');
        let $sensitive_value = $container.find('.vi-wad-string-replace-sensitive-value');
        let sensitive_value = $(this).prop('checked') ? 1 : '';
        $sensitive_value.val(sensitive_value);
    });
    $('body').on('click', '.delete-string-replace-rule', function () {
        if (confirm('Remove this item?')) {
            $(this).closest('.clone-source').remove();
        }
    });
    /*String replace*/
    $('.add-string-replace-rule-url').on('click', function () {
        let clone = `<tr class="clone-source">
                        <td>
                            <input type="text" value="" name="vi-wad-carrier_url_replaces[from_string][]">
                        </td>
                        <td>
                            <input type="text" placeholder="URL of a replacement carrier" value="" name="vi-wad-carrier_url_replaces[to_string][]">
                        </td>
                        <td>
                            <button type="button" class="vi-ui button negative delete-string-replace-rule">
                                <i class="dashicons dashicons-trash"></i>
                            </button>
                        </td>
                    </tr>`;

        $('.string-replace-url tbody').append(clone);
    });
    $('.add-string-replace-rule-name').on('click', function () {
        let clone = `<tr class="clone-source">
                        <td>
                            <input type="text" value="" name="vi-wad-carrier_name_replaces[from_string][]">
                        </td>
                         <td>
                            <div class="vi-wad-string-replace-sensitive-container">
                                <input type="checkbox" value="1" class="vi-wad-string-replace-sensitive">
                                <input type="hidden" class="vi-wad-string-replace-sensitive-value" value="" name="vi-wad-carrier_name_replaces[sensitive][]">
                            </div>
                        </td>
                        <td>
                            <input type="text" placeholder="Blank is delete" value="" name="vi-wad-carrier_name_replaces[to_string][]">
                        </td>                                       
                        <td>
                            <button type="button" class="vi-ui button negative delete-string-replace-rule">
                                <i class="dashicons dashicons-trash"></i>
                            </button>
                        </td>
                    </tr>`;

        $('.string-replace-name tbody').append(clone);
    });
});