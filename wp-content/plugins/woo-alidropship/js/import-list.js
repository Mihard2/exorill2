'use strict';
jQuery(document).ready(function ($) {
    let queue = [];
    let is_importing = false;
    /*Set paged to 1 before submitting*/
    jQuery('.search-box').find('input[type="submit"]').on('click', function () {
        let $form = jQuery(this).closest('form');
        $form.find('.current-page').val(1);
    });
    $('.vi-ui.tabular.menu .item').vi_tab();
    $('.vi-ui.accordion').vi_accordion('refresh');
    $('.vi-ui.checkbox').checkbox();
    $('.ui-sortable').sortable();
    $('select.vi-ui.dropdown').dropdown();
    $('.vi-wad-button-view-and-edit').on('click', function (e) {
        e.stopPropagation();
    });
    /**
     * Filter product attributes
     */
    $('body').on('click', '.vi-wad-attribute-filter-item', function (e) {
        let $button = $(this);
        let selected = [];
        let $container = $button.closest('table');
        let $attribute_filters = $container.find('.vi-wad-attribute-filter-list');
        let $attribute_filter = $attribute_filters.eq(0);
        let current_filter_slug = $attribute_filter.data('attribute_slug');
        if ($button.hasClass('vi-wad-attribute-filter-item-active')) {
            $button.removeClass('vi-wad-attribute-filter-item-active');
        } else {
            $button.addClass('vi-wad-attribute-filter-item-active');
        }
        let $variations_rows = $container.find('.vi-wad-product-variation-row');
        let $active_filters = $attribute_filter.find('.vi-wad-attribute-filter-item-active');
        let active_variations = [];
        if ($active_filters.length > 0) {
            $active_filters.map(function () {
                selected.push($(this).data('attribute_value'));
            });
            for (let $i = 0; $i < $variations_rows.length; $i++) {
                let $current_attribute = $variations_rows.eq($i).find('.vi-wad-import-data-variation-attribute[data-attribute_slug="' + current_filter_slug + '"]');
                if (selected.indexOf($current_attribute.data('attribute_value')) > -1) {
                    active_variations[$i] = 1;
                } else {
                    active_variations[$i] = 0;
                }
            }
        } else {
            for (let $i = 0; $i < $variations_rows.length; $i++) {
                active_variations[$i] = 1;
            }
        }

        if ($attribute_filters.length > 1) {
            for (let $j = 1; $j < $attribute_filters.length; $j++) {
                $attribute_filter = $attribute_filters.eq($j);
                current_filter_slug = $attribute_filter.data('attribute_slug');
                $active_filters = $attribute_filter.find('.vi-wad-attribute-filter-item-active');
                if ($active_filters.length > 0) {
                    $active_filters.map(function () {
                        selected.push($(this).data('attribute_value'));
                    });
                    for (let $i = 0; $i < $variations_rows.length; $i++) {
                        let $current_attribute = $variations_rows.eq($i).find('.vi-wad-import-data-variation-attribute[data-attribute_slug="' + current_filter_slug + '"]');
                        if (selected.indexOf($current_attribute.data('attribute_value')) < 0) {
                            active_variations[$i] = 0;
                        }
                    }
                }
            }
        }
        let variations_count = 0;
        for (let $i = 0; $i < $variations_rows.length; $i++) {
            let $current_variation = $variations_rows.eq($i);
            if (active_variations[$i] == 1) {
                $current_variation.removeClass('vi-wad-variation-filter-inactive');
                if ($current_variation.find('.vi-wad-variation-enable').prop('checked')) {
                    variations_count++;
                }
            } else {
                $current_variation.addClass('vi-wad-variation-filter-inactive');
            }
        }
        let $current_container = $button.closest('form');
        $current_container.find('.vi-wad-selected-variation-count').html(variations_count);
    });
    /**
     * Set product featured image
     */
    $('body').on('click', '.vi-wad-set-product-image', function (e) {
        e.stopPropagation();
        let $button = $(this);
        let container = $button.closest('form');
        let $product_image_container = container.find('.vi-wad-product-image');
        let $gallery_item = $button.closest('.vi-wad-product-gallery-item');
        let $product_gallery = $button.closest('.vi-wad-product-gallery');
        if ($gallery_item.hasClass('vi-wad-is-product-image')) {
            $gallery_item.removeClass('vi-wad-is-product-image');
            $product_image_container.removeClass('vi-wad-selected-item');
            $product_image_container.find('input[type="hidden"]').val('');
        } else {
            if (!$gallery_item.hasClass('vi-wad-selected-item')) {
                $gallery_item.click();
            }

            if (!$product_image_container.hasClass('vi-wad-selected-item')) {
                $product_image_container.addClass('vi-wad-selected-item');
            }
            $product_gallery.find('.vi-wad-product-gallery-item').removeClass('vi-wad-is-product-image');
            $gallery_item.addClass('vi-wad-is-product-image');
            let product_image_url = $gallery_item.find('img').data('image_src');

            $(this).closest('.vi-wad-accordion').find('.vi-wad-accordion-product-image').attr('src', product_image_url);
            $product_image_container.find('img').attr('src', product_image_url);
            $product_image_container.find('input[type="hidden"]').val(product_image_url);
        }

    });

    add_keyboard_event();

    /**
     * Support ESC(cancel) and Enter(OK) key
     */
    function add_keyboard_event() {
        $(document).on('keydown', function (e) {
            if (!$('.vi-wad-set-price-container').hasClass('vi-wad-hidden')) {
                if (e.keyCode == 13) {
                    $('.vi-wad-set-price-button-set').click();
                } else if (e.keyCode == 27) {
                    $('.vi-wad-overlay').click();
                }
            } else if (!$('.vi-wad-override-product-options-container').hasClass('vi-wad-hidden')) {
                if (e.keyCode == 13) {
                    $('.vi-wad-override-product-options-button-override').click();
                } else if (e.keyCode == 27) {
                    $('.vi-wad-override-product-overlay').click();
                }
            }
        });
    }

    /**
     * Search Category
     */
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
    /**
     * Search Tags
     */
    $('.search-tags').select2({
        closeOnSelect: false,
        placeholder: "Please fill in tag name",
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

    count_selected_variations();
    let current_focus_checkbox;

    /**
     * Count currently selected variations
     */
    function count_selected_variations() {
        $('body').on('click', '.vi-wad-variations-bulk-enable', function () {
            let $current_container = $(this).closest('form');
            let selected = 0;
            if ($(this).prop('checked')) {
                selected = $current_container.find('.vi-wad-product-variation-row').length - $current_container.find('.vi-wad-variation-filter-inactive').length;
                $current_container.find('.vi-wad-variations-bulk-select-image').prop('checked', true).trigger('change');
            } else {
                $current_container.find('.vi-wad-import-data-variation-default').prop('checked', false);
                $current_container.find('.vi-wad-variations-bulk-select-image').prop('checked', false).trigger('change');
            }
            $current_container.find('.vi-wad-selected-variation-count').html(selected);
        });
        $('body').on('click', '.vi-wad-variation-enable', function (e) {
            let $current_select = $(this);
            let $current_container = $current_select.closest('form');
            let prev_select = $current_container.find('.vi-wad-variation-enable').index(current_focus_checkbox);
            let selected = 0;
            if (e.shiftKey) {
                let current_index = $current_container.find('.vi-wad-variation-enable').index($current_select);
                if ($current_select.prop('checked')) {
                    if (prev_select < current_index) {
                        for (let i = prev_select; i <= current_index; i++) {
                            $current_container.find('.vi-wad-variation-enable').eq(i).prop('checked', true)
                        }
                    } else {
                        for (let i = current_index; i <= prev_select; i++) {
                            $current_container.find('.vi-wad-variation-enable').eq(i).prop('checked', true)
                        }
                    }
                } else {
                    if (prev_select < current_index) {
                        for (let i = prev_select; i <= current_index; i++) {
                            $current_container.find('.vi-wad-variation-enable').eq(i).prop('checked', false)
                        }
                    } else {
                        for (let i = current_index; i <= prev_select; i++) {
                            $current_container.find('.vi-wad-variation-enable').eq(i).prop('checked', false)
                        }
                    }
                }
            }
            $current_container.find('.vi-wad-variation-enable').map(function () {
                let $current_row = $(this).closest('tr');
                if ($(this).prop('checked') && !$current_row.hasClass('vi-wad-variation-filter-inactive')) {
                    selected++;
                    $current_row.find('.vi-wad-variation-image').removeClass('vi-wad-selected-item').click();
                } else {
                    $current_row.find('.vi-wad-variation-image').addClass('vi-wad-selected-item').click();
                    $current_row.find('.vi-wad-import-data-variation-default').prop('checked', false);
                }
            });

            $current_container.find('.vi-wad-selected-variation-count').html(selected);
            current_focus_checkbox = $(this);
        })
    }

    /**
     * Bulk select variations
     */
    $('body').on('change', '.vi-wad-variations-bulk-enable', function () {
        let product = $(this).closest('form');
        product.find('.vi-wad-variation-enable').prop('checked', $(this).prop('checked'));
    });

    /**
     * Bulk select images
     */
    $('body').on('change', '.vi-wad-variations-bulk-select-image', function () {
        let button_bulk = $(this);
        let product = button_bulk.closest('form');
        let image_wrap = product.find('.vi-wad-variation-image');
        if (button_bulk.prop('checked')) {
            image_wrap.addClass('vi-wad-selected-item');
        } else {
            image_wrap.removeClass('vi-wad-selected-item');
        }
        image_wrap.map(function () {
            let current = $(this);
            if (button_bulk.prop('checked')) {
                current.find('input[type="hidden"]').val(current.find('.vi-wad-import-data-variation-image').attr('src'));
            } else {
                current.find('input[type="hidden"]').val('');
            }
        })

    });

    function hide_message($parent) {
        $parent.find('.vi-wad-message').html('')
    }

    function show_message($parent, type, message) {
        $parent.find('.vi-wad-message').html(`<div class="vi-ui message ${type}"><div>${message}</div></div>`)
    }

    let $import_list_count = $('#toplevel_page_woo-alidropship').find('.current').find('.vi-wad-import-list-count');
    let $imported_list_count = $('.vi-wad-imported-list-count');
    /**
     * Remove product
     */
    $('.vi-wad-button-remove').on('click', function (e) {
        e.stopPropagation();
        let $button_remove = $(this);
        let product_id = $button_remove.data()['product_id'];
        let $product_container = $('#vi-wad-product-item-id-' + product_id);
        if ($button_remove.closest('.vi-wad-button-view-and-edit').find('.loading').length === 0 && confirm(vi_wad_import_list_params.i18n_remove_product_confirm)) {
            $product_container.vi_accordion('close', 0).addClass('vi-wad-accordion-removing');
            $button_remove.addClass('loading');
            hide_message($product_container);
            $.ajax({
                url: vi_wad_import_list_params.url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'vi_wad_remove',
                    product_id: product_id,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        let import_list_count_value = parseInt($import_list_count.html());
                        if (import_list_count_value > 0) {
                            let current_count = parseInt(import_list_count_value - 1);
                            $import_list_count.html(current_count);
                            $import_list_count.parent().attr('class', 'update-plugins count-' + current_count);
                        }
                        $product_container.fadeOut(300);
                        setTimeout(function () {
                            $product_container.remove();
                            if ($('.vi-wad-button-import').length == 0) {
                                $('.vi-wad-button-import-all').remove();
                            }
                        }, 300)
                    } else {
                        $product_container.vi_accordion('open', 0).removeClass('vi-wad-accordion-removing');
                        show_message($product_container, 'negative', response.message ? response.message : 'Error');
                    }
                },
                error: function (err) {
                    console.log(err);
                    $product_container.vi_accordion('open', 0).removeClass('vi-wad-accordion-removing');
                    show_message($product_container, 'negative', err.statusText);
                },
                complete: function () {
                    $button_remove.removeClass('loading');
                }
            })
        }
    });

    /**
     * Import product
     */
    $('.vi-wad-button-import').on('click', function (e) {
        e.stopPropagation();
        let $button_import = $(this);
        let $button_container = $button_import.closest('.vi-wad-button-view-and-edit');
        let product_id = $button_import.data()['product_id'];
        let $product_container = $('#vi-wad-product-item-id-' + product_id);
        if ($product_container.hasClass('vi-wad-accordion-importing') || $product_container.hasClass('vi-wad-accordion-removing')) {
            return;
        }
        let $form = $product_container.find('.vi-wad-product-container');
        let data = $form.serializeArray();
        let description = $('#wp-vi-wad-product-description-' + product_id + '-wrap').hasClass('tmce-active') ? tinyMCE.get('vi-wad-product-description-' + product_id).getContent() : $('#vi-wad-product-description-' + product_id).val();
        data.push({name: 'vi_wad_product[' + product_id + '][description]', value: description});
        data = $.param(data);
        let selected = {};
        if ($form.find('.vi-wad-variation-enable').length > 0) {
            let each_selected = [];
            let selected_key = 0;
            $form.find('.vi-wad-variation-enable').map(function () {
                let $row = $(this).closest('.vi-wad-product-variation-row');
                if ($(this).prop('checked') && !$row.hasClass('vi-wad-variation-filter-inactive')) {
                    each_selected.push(selected_key);
                }
                selected_key++;
            });
            selected[product_id] = each_selected;
        } else {
            selected[product_id] = [0];
        }

        if (selected[product_id].length === 0) {
            alert(vi_wad_import_list_params.i18n_empty_variation_error);
            return;
        }
        let empty_price_error = false, sale_price_error = false;
        $form.find('.vi-wad-import-data-variation-sale-price').removeClass('vi-wad-price-error');
        $form.find('.vi-wad-import-data-variation-regular-price').removeClass('vi-wad-price-error');
        for (let i = 0; i < $form.find('.vi-wad-import-data-variation-sale-price').length; i++) {
            let sale_price = $form.find('.vi-wad-import-data-variation-sale-price').eq(i);
            let regular_price = $form.find('.vi-wad-import-data-variation-regular-price').eq(i);
            if (!parseFloat(regular_price.val())) {
                empty_price_error = true;
                regular_price.addClass('vi-wad-price-error')
            } else if (parseFloat(sale_price.val()) > parseFloat(regular_price.val())) {
                sale_price_error = true;
                sale_price.addClass('vi-wad-price-error')
            }
        }
        if (empty_price_error) {
            alert(vi_wad_import_list_params.i18n_empty_price_error);
            return;
        } else if (sale_price_error) {
            alert(vi_wad_import_list_params.i18n_sale_price_error);
            return;
        }
        $button_import.addClass('loading');
        if (!is_importing) {
            $product_container.vi_accordion('close', 0).addClass('vi-wad-accordion-importing');
            is_importing = true;
            $.ajax({
                url: vi_wad_import_list_params.url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    action: 'vi_wad_import',
                    data: data,
                    selected: selected,
                },
                success: function (response) {
                    if (response.status === 'success') {
                        let import_list_count_value = parseInt($import_list_count.html());
                        if (import_list_count_value > 0) {
                            import_list_count_value--;
                            $import_list_count.html(import_list_count_value);
                            $import_list_count.parent().attr('class', 'update-plugins count-' + import_list_count_value);
                        } else {
                            $import_list_count.html(0);
                            $import_list_count.parent().attr('class', 'update-plugins count-' + 0);
                        }
                        let imported_list_count_value = parseInt($imported_list_count.html());
                        imported_list_count_value++;
                        $imported_list_count.html(imported_list_count_value);
                        $imported_list_count.parent().attr('class', 'update-plugins count-' + imported_list_count_value);
                        if ($('.vi-wad-button-import').length === 0) {
                            $('.vi-wad-button-import-all').remove();
                        }
                        $button_container.append(response.button_html);
                        $button_container.find('.vi-wad-button-remove').remove();
                        $button_import.remove();
                        $product_container.find('.content').remove();
                        $product_container.find('.vi-wad-accordion-title-icon').attr('class', 'icon check green');
                    } else {
                        $button_import.removeClass('loading');
                        show_message($product_container, 'negative', response.message ? response.message : 'Error');
                    }
                },
                error: function (err) {
                    console.log(err)
                    $button_import.removeClass('loading');
                    show_message($product_container, 'negative', err.statusText);
                },
                complete: function () {
                    is_importing = false;
                    $product_container.vi_accordion('open', 0).removeClass('vi-wad-accordion-importing');
                    if (queue.length > 0) {
                        queue.shift().click();
                    } else if ($('.vi-wad-button-import-all').hasClass('loading')) {
                        $('.vi-wad-button-import-all').removeClass('loading')
                    }
                }
            })
        } else {
            queue.push($button_import);
        }
    });
    /**
     * Bulk import
     */
    $('.vi-wad-button-import-all').on('click', function () {
        let $button_import = $(this);
        if ($button_import.hasClass('loading')) {
            return;
        }
        if (!confirm(vi_wad_import_list_params.i18n_import_all_confirm)) {
            return;
        }
        $('.vi-wad-button-import').not('.loading').map(function () {
            if ($(this).closest('.vi-wad-button-view-and-edit').find('.loading').length === 0) {
                queue.push($(this));
                $(this).addClass('loading');
            }
        });
        if (queue.length > 0) {
            if (!is_importing) {
                queue.shift().click();
            }
            $button_import.addClass('loading');
        } else {
            alert(vi_wad_import_list_params.i18n_not_found_error);
        }
    });

    let found_items, check_orders;
    /**
     * Override product
     */
    $('.vi-wad-button-override').on('click', function (e) {
        e.stopPropagation();
        let $button_import = $(this);
        let product_id = $button_import.data()['product_id'];
        let form = $button_import.closest('.vi-wad-accordion').find('.vi-wad-product-container');
        let selected = {};
        if (form.find('.vi-wad-variation-enable').length > 0) {
            let each_selected = [];
            let selected_key = 0;
            form.find('.vi-wad-variation-enable').map(function () {
                let $row = $(this).closest('.vi-wad-product-variation-row');
                if ($(this).prop('checked') && !$row.hasClass('vi-wad-variation-filter-inactive')) {
                    each_selected.push(selected_key);
                }
                selected_key++;
            });
            selected[product_id] = each_selected;
        } else {
            selected[product_id] = [0];
        }
        if (selected[product_id].length == 0) {
            alert(vi_wad_import_list_params.i18n_empty_variation_error);
            return;
        }
        let empty_price_error = false, sale_price_error = false;
        let container = $button_import.closest('.vi-wad-accordion').find('.vi-wad-product-container');
        container.find('.vi-wad-import-data-variation-sale-price').removeClass('vi-wad-price-error');
        container.find('.vi-wad-import-data-variation-regular-price').removeClass('vi-wad-price-error');
        for (let i = 0; i < container.find('.vi-wad-import-data-variation-sale-price').length; i++) {
            let sale_price = container.find('.vi-wad-import-data-variation-sale-price').eq(i);
            let regular_price = container.find('.vi-wad-import-data-variation-regular-price').eq(i);
            if (!parseFloat(regular_price.val())) {
                empty_price_error = true;
                regular_price.addClass('vi-wad-price-error')
            } else if (parseFloat(sale_price.val()) > parseFloat(regular_price.val())) {
                sale_price_error = true;
                sale_price.addClass('vi-wad-price-error')
            }
        }

        if (empty_price_error) {
            alert(vi_wad_import_list_params.i18n_empty_price_error);
            return;
        } else if (sale_price_error) {
            alert(vi_wad_import_list_params.i18n_sale_price_error);
            return;
        }
        $('.vi-wad-override-product-title').html($('.vi-wad-override-product-product-title').html());
        $('.vi-wad-override-product-options-button-override').data('product_id', product_id).data('override_product_id', $button_import.data('override_product_id'));
        vi_wad_override_product_show();
    });

    /**
     * Confirm Override product
     */
    $('.vi-wad-override-product-options-button-override').on('click', function () {
        let $button = $(this);
        let product_id = $button.data()['product_id'];
        let override_product_id = $button.data()['override_product_id'];
        let $button_import = $('.vi-wad-button-override[data-product_id="' + product_id + '"]');
        let $product_container = $('#vi-wad-product-item-id-' + product_id);
        let $form = $product_container.find('.vi-wad-product-container');
        let data = $form.serializeArray();
        let description = $('#wp-vi-wad-product-description-' + product_id + '-wrap').hasClass('tmce-active') ? tinyMCE.get('vi-wad-product-description-' + product_id).getContent() : $('#vi-wad-product-description-' + product_id).val();
        data.push({name: 'vi_wad_product[' + product_id + '][description]', value: description});
        data = $.param(data);
        let selected = {};
        if ($form.find('.vi-wad-variation-enable').length > 0) {
            let each_selected = [];
            let selected_key = 0;
            $form.find('.vi-wad-variation-enable').map(function () {
                let $row = $(this).closest('.vi-wad-product-variation-row');
                if ($(this).prop('checked') && !$row.hasClass('vi-wad-variation-filter-inactive')) {
                    each_selected.push(selected_key);
                }
                selected_key++;
            });
            selected[product_id] = each_selected;
        } else {
            selected[product_id] = [0];
        }
        let replace_items = {};
        if (check_orders) {
            $('.vi-wad-override-order-container').map(function () {
                replace_items[$(this).data('replace_item_id')] = $(this).find('.vi-wad-override-with').val();
            })
        }
        let is_simple = 0;
        if ($form.find('.vi-wad-variations-tab').length == 0) {
            is_simple = 1;
        }
        $button_import.addClass('loading');
        $button.addClass('loading');
        $.ajax({
            url: vi_wad_import_list_params.url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'vi_wad_override',
                data: data,
                is_simple: is_simple,
                selected: selected,
                override_product_id: override_product_id,
                check_orders: check_orders,
                replace_items: replace_items,
                found_items: found_items,
                replace_title: $('.vi-wad-override-product-options-replace-title').prop('checked') ? 1 : 0,
                replace_images: $('.vi-wad-override-product-options-replace-images').prop('checked') ? 1 : 0,
                replace_description: $('.vi-wad-override-product-options-replace-description').prop('checked') ? 1 : 0,
            },
            success: function (response) {
                if (check_orders) {
                    if (response.status === 'success') {
                        vi_wad_override_product_hide();
                        $product_container.fadeOut(300);
                        setTimeout(function () {
                            $product_container.remove();
                        }, 300)
                    } else {
                        alert(response.message);
                    }

                } else {
                    if (response.status === 'checked') {
                        $('.vi-wad-override-product-options-content-body-replace-old').removeClass('vi-wad-hidden').html(response.replace_order_html);
                        $('.vi-wad-override-product-options-content-body-option').addClass('vi-wad-hidden');
                        check_orders = 1;
                        found_items = response.found_items;
                    } else if (response.status === 'success') {
                        vi_wad_override_product_hide();
                        let $product_container = $('#vi-wad-product-item-id-' + product_id);
                        $product_container.fadeOut(300);
                        setTimeout(function () {
                            $product_container.remove();
                        }, 300)
                    } else {
                        alert(response.message);
                    }
                }
            },
            error: function (err) {
                console.log(err)
            },
            complete: function () {
                $button_import.removeClass('loading');
                $button.removeClass('loading');
            }
        })
    });

    /**
     * Bulk set sale price
     */
    $('.vi-wad-import-data-variation-sale-price').on('change', function () {
        let button = $(this);
        let container_row = button.closest('tr');
        let current_value = parseFloat(button.val());
        let profit = container_row.find('.vi-wad-import-data-variation-profit');
        let cost = container_row.find('.vi-wad-import-data-variation-cost');
        let profit_value = 0;
        if (current_value) {
            profit_value = current_value - parseFloat(cost.html());
        } else {
            profit_value = parseFloat(container_row.find('.vi-wad-import-data-variation-regular-price').val()) - parseFloat(cost.html());
        }
        profit.html(roundResult(profit_value));
    });

    /**
     * Bulk set regular price
     */
    $('.vi-wad-import-data-variation-regular-price').on('change', function () {
        let button = $(this);
        let container_row = button.closest('tr');
        let sale_price = parseFloat(container_row.find('.vi-wad-import-data-variation-sale-price').val());
        let profit = container_row.find('.vi-wad-import-data-variation-profit');
        let cost = container_row.find('.vi-wad-import-data-variation-cost');
        let profit_value = 0;
        if (!sale_price) {
            profit_value = parseFloat(button.val()) - parseFloat(cost.html());
            profit.html(roundResult(profit_value));
        }
    });

    /**
     * Bulk set price confirm
     */
    $('body').on('click', '.vi-wad-set-price', function () {
        let button = $(this);
        button.addClass('vi-wad-set-price-editing');
        let container = $('.vi-wad-set-price-container');
        container.find('.vi-wad-set-price-content-header').find('h2').html('Set ' + button.data()['set_price'].replace(/_/g, ' '));
        vi_wad_set_price_show();
    });


    /**
     * Select gallery images
     */
    $('body').on('click', '.vi-wad-product-gallery-item', function () {
        let current = $(this);
        let image = current.find('.vi-wad-product-gallery-image');
        let container = current.closest('form');
        let gallery_container = container.find('.vi-wad-product-gallery');
        let $product_image_container = container.find('.vi-wad-product-image');
        if (current.hasClass('vi-wad-selected-item')) {
            if (current.hasClass('vi-wad-is-product-image')) {
                current.removeClass('vi-wad-is-product-image');
                current.find('vi-wad-set-product-image').click();
                $product_image_container.removeClass('vi-wad-selected-item').find('input[type="hidden"]').val('');
            }
            current.removeClass('vi-wad-selected-item').find('input[type="hidden"]').val('');
        } else {
            current.addClass('vi-wad-selected-item').find('input[type="hidden"]').val(image.data('image_src'));
        }
        container.find('.vi-wad-selected-gallery-count').html(gallery_container.find('.vi-wad-selected-item').length);
    });

    /**
     * Select product image
     */
    $('body').on('click', '.vi-wad-product-image', function () {
        let image_src = $(this).find('.vi-wad-import-data-image').attr('src');
        let $container = $(this).closest('form');
        if (image_src) {
            let $gallery_item = $container.find('.vi-wad-product-gallery-image[data-image_src="' + image_src + '"]').closest('.vi-wad-product-gallery-item');
            $gallery_item.find('.vi-wad-set-product-image').click();
        }
    });

    /**
     * Select default variation
     */
    $('body').on('click', '.vi-wad-import-data-variation-default', function () {
        let $current = $(this);
        if ($current.prop('checked')) {
            let $enable = $current.closest('tr').find('.vi-wad-variation-enable');
            if (!$enable.prop('checked')) {
                $enable.click();
            }
        }
    });

    /**
     * Select variation image
     */
    $('body').on('click', '.vi-wad-variation-image', function () {
        let $current = $(this);
        if ($current.hasClass('vi-wad-selected-item')) {
            $current.removeClass('vi-wad-selected-item').find('input[type="hidden"]').val('');
        } else {
            $current.addClass('vi-wad-selected-item').find('input[type="hidden"]').val($current.find('img').attr('src'));
            $current.closest('tr').find('.vi-wad-variation-enable').prop('checked', true);
        }
    });

    $('.vi-wad-overlay').on('click', function () {
        vi_wad_set_price_hide()
    });
    $('.vi-wad-set-price-close').on('click', function () {
        vi_wad_set_price_hide()
    });
    $('.vi-wad-set-price-button-cancel').on('click', function () {
        vi_wad_set_price_hide()
    });

    $('.vi-wad-set-price-amount').on('change', function () {
        let price = parseFloat($(this).val());
        if (isNaN(price)) {
            price = 0;
        }
        $(this).val(price);
    });
    $('.vi-wad-set-price-button-set').on('click', function () {
        let button = $(this);
        let action = $('.vi-wad-set-price-action').val(),
            amount = parseFloat($('.vi-wad-set-price-amount').val());
        let editing = $('.vi-wad-set-price-editing');
        let container = editing.closest('table');
        let target_field;
        if (editing.data()['set_price'] === 'sale_price') {
            target_field = container.find('.vi-wad-import-data-variation-sale-price');
        } else {
            target_field = container.find('.vi-wad-import-data-variation-regular-price');
        }
        if (target_field.length > 0) {
            switch (action) {
                case 'set_new_value':
                    target_field.map(function () {
                        $(this).val(amount)
                    });
                    break;
                case 'increase_by_fixed_value':
                    target_field.map(function () {
                        let current_amount = parseFloat($(this).val());
                        $(this).val(current_amount + amount);
                    });
                    break;
                case 'increase_by_percentage':
                    target_field.map(function () {
                        let current_amount = parseFloat($(this).val());
                        $(this).val((1 + amount / 100) * current_amount);
                    });
                    break;
            }
        }
        container.find('.vi-wad-import-data-variation-profit').map(function () {
            let current_row = $(this).closest('tr');
            let sale_price = current_row.find('.vi-wad-import-data-variation-sale-price');
            let regular_price = current_row.find('.vi-wad-import-data-variation-regular-price');
            let cost = current_row.find('.vi-wad-import-data-variation-cost');
            let sale_price_v = parseFloat(sale_price.val()), regular_price_v = parseFloat(regular_price.val()),
                cost_v = parseFloat(cost.html()), profit_v;
            if (sale_price_v) {
                profit_v = roundResult(sale_price_v - cost_v);
            } else {
                profit_v = roundResult(regular_price_v - cost_v);
            }
            $(this).html(profit_v);
        });
        vi_wad_set_price_hide()
    });
    $('.vi-wad-accordion-store-url').on('click', function (e) {
        e.stopPropagation();
    });
    $('.vi-wad-lazy-load').on('click', function () {
        let $tab = $(this);
        let tab_data = $tab.data('tab');
        if (!$tab.hasClass('vi-wad-lazy-load-loaded')) {
            $tab.addClass('vi-wad-lazy-load-loaded');
            let $tab_data = $('.vi-wad-lazy-load-tab-data[data-tab="' + tab_data + '"]');
            $tab_data.find('img').map(function () {
                let image_src = $(this).data('image_src');
                if (image_src) {
                    $(this).attr('src', image_src);
                }
            })
        }
    });

    function vi_wad_set_price_hide() {
        $('.vi-wad-set-price').removeClass('vi-wad-set-price-editing');
        $('.vi-wad-set-price-container').addClass('vi-wad-hidden');
        vi_wad_enable_scroll()
    }

    function vi_wad_set_price_show() {
        $('.vi-wad-set-price-container').removeClass('vi-wad-hidden');

        vi_wad_disable_scroll();
    }

    $('.vi-wad-override-product-overlay').on('click', function () {
        vi_wad_override_product_hide()
    });
    $('.vi-wad-override-product-options-close').on('click', function () {
        vi_wad_override_product_hide()
    });
    $('.vi-wad-override-product-options-button-cancel').on('click', function () {
        vi_wad_override_product_hide()
    });

    function vi_wad_override_product_hide() {
        $('.vi-wad-override-product-options-container').addClass('vi-wad-hidden');
        found_items = [];
        check_orders = 0;
        vi_wad_enable_scroll()
    }

    function vi_wad_override_product_show() {
        $('.vi-wad-override-product-options-container').removeClass('vi-wad-hidden');
        $('.vi-wad-override-product-options-content-body-replace-old').addClass('vi-wad-hidden');
        $('.vi-wad-override-product-options-content-body-option').removeClass('vi-wad-hidden');

        vi_wad_disable_scroll();
    }

    function vi_wad_enable_scroll() {
        let scrollTop = parseInt($('html').css('top'));
        $('html').removeClass('vi_wad-noscroll');
        $('html,body').scrollTop(-scrollTop);
    }

    function vi_wad_disable_scroll() {
        if ($(document).height() > $(window).height()) {
            let scrollTop = ($('html').scrollTop()) ? $('html').scrollTop() : $('body').scrollTop(); // Works for Chrome, Firefox, IE...
            $('html').addClass('vi_wad-noscroll').css('top', -scrollTop);
        }
    }

    function roundResult(number) {
        let decNum = parseInt(vi_wad_import_list_params.decimals),
            temp = Math.pow(10, decNum);
        return Math.round(number * temp) / temp;
    }

    /**
     * Find replacements for current attributes values
     */
    $('body').on('click', '.vi-wad-switch-product-attributes-values', function () {
        let button = $(this);
        let $container = button.closest('.vi-wad-accordion');
        let $overlay = $container.find('.vi-wad-product-overlay');
        $overlay.removeClass('vi-wad-hidden');
        let product_id = button.data()['product_id'];
        let product_index = button.data()['product_index'];
        button.addClass('loading');
        $.ajax({
            url: vi_wad_import_list_params.url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'vi_wad_switch_product_attributes_values',
                product_id: product_id,
                product_index: product_index,
            },
            success: function (response) {
                if (response.status === 'success' && response.data) {
                    button.closest('.vi-wad-variations-tab').find('.vi-wad-table-fix-head').html(response.data)
                }
            },
            error: function (err) {
                console.log(err)
            },
            complete: function () {
                button.removeClass('loading');
                $overlay.addClass('vi-wad-hidden');
            }
        })
    });
});
