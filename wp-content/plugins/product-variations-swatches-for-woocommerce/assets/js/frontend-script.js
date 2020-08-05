'use strict';
var viwpvs_check_wrap1 = false, viwpvs_check_wrap2 = false;
jQuery(document).ready(function ($) {
    jQuery(document).on('click', '.vi-wpvs-variation-style', function (e) {
        jQuery('.vi-wpvs-variation-wrap-option').addClass('vi-wpvs-hidden');
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
    });
    jQuery(document).on('click', 'body', function (e) {
        jQuery('.vi-wpvs-variation-wrap-option').addClass('vi-wpvs-hidden');
    });
    jQuery('.vi_wpvs_variation_form').each(function () {
        viwpvs_check_wrap1 = true;
        jQuery(this).vi_woo_product_variation_swatches();
    });
    let variations_form = jQuery('.variations_form:not(.vi_wpvs_variation_form)');
    if (variations_form.length > 0) {
        variations_form.each(function () {
            viwpvs_check_wrap2 = true;
            jQuery(this).addClass('vi_wpvs_variation_form').vi_woo_product_variation_swatches();
        });
    }

    jQuery(document).ajaxComplete(function (event, jqxhr, settings) {
        let form_div = jQuery('.variations_form:not(.vi_wpvs_variation_form)');
        if (form_div.length > 0) {
            form_div.each(function () {
                jQuery(this).addClass('vi_wpvs_variation_form').vi_woo_product_variation_swatches();
            });
        }
        return false;
    });
});
jQuery(window).load(function () {
    if (!viwpvs_check_wrap1 && !viwpvs_check_wrap2) {
        jQuery('.vi_wpvs_variation_form').each(function () {
            jQuery(this).vi_woo_product_variation_swatches();
        });
        let variations_form = jQuery('.variations_form:not(.vi_wpvs_variation_form)');
        if (variations_form.length > 0) {
            variations_form.each(function () {
                jQuery(this).addClass('vi_wpvs_variation_form').vi_woo_product_variation_swatches();
            });
        }
    }
});
let vi_wpvs_frontend = function ($form) {
    this.form = $form;
    this.variationData = $form.data('product_variations');
    this.init();
};

vi_wpvs_frontend.prototype.init = function () {
    let vi_wpvs_frontend = this,
        form = this.form,
        variations = this.variationData;
    if (variations) {
        vi_wpvs_frontend.check_available_variation(variations, form);
    }
    let count_select = 0, count_disable = 0, count_selected = 0;
    form.find('.vi-wpvs-select-attribute select').each(function () {
        let sl_select = jQuery(this).find('option[selected="selected"]'),
            sl_disable = jQuery(this).find('option.vi-wpvs-option-disabled[selected="selected"]');
        if (sl_select.length > 0) {
            count_selected++;
        }
        if (sl_disable.length > 0) {
            count_disable++;
            if (jQuery(this).closest('.vi-wpvs-variation-wrap-wrap').find('.vi-wpvs-variation-wrap').hasClass('vi-wpvs-variation-wrap-select')) {
                jQuery(this).closest('.vi-wpvs-variation-wrap-wrap').find('.vi-wpvs-variation-button-select >span ').html(jQuery(this).closest('.vi-wpvs-variation-wrap-wrap').find('.vi-wpvs-option-select:first-child').html());
            }
            if (form.hasClass('vi_wpvs_loop_variation_form')) {
                jQuery(this).val('').trigger('change');
            }
        }
    });
    if ((count_selected === count_disable) && form.find('.reset_variations').length > 0) {
        form.find('.reset_variations').addClass('vi-wpvs-hidden');
    }
    vi_wpvs_frontend.design_variation_item();
    vi_wpvs_frontend.select_variation_item();
    if (form.find('.vi-wpvs-variation-wrap-select-wrap').length) {
        form.find('.vi-wpvs-variation-wrap-select-wrap').each(function (k, item) {
            jQuery(item).parent().parent().parent().css({width: '100%'});
            let select_wrap, select_button;
            select_wrap = jQuery(item).find('.vi-wpvs-variation-wrap-option');
            if (!select_wrap.attr('data-offset_height')) {
                select_wrap.attr('data-offset_height', select_wrap.outerHeight()).removeClass('vi-wpvs-select-hidden').addClass('vi-wpvs-hidden');
            }
            select_button = jQuery(item).find('.vi-wpvs-variation-button-select');
            select_button.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                let select_wrap_height, scroll_top, window_height, view_able_offset;
                select_wrap_height = parseFloat(select_wrap.attr('data-offset_height'));
                scroll_top = jQuery(window).scrollTop();
                window_height = jQuery(window).outerHeight();
                view_able_offset = jQuery(this).offset().top - scroll_top;
                select_wrap.addClass('vi-wpvs-variation-wrap-option-show').removeClass('vi-wpvs-variation-wrap-select-top vi-wpvs-variation-wrap-select-bottom');
                jQuery('.vi-wpvs-variation-wrap-option:not(.vi-wpvs-variation-wrap-option-show)').addClass('vi-wpvs-hidden');
                if (scroll_top > view_able_offset || scroll_top < select_wrap_height || window_height > (view_able_offset + select_wrap_height + 40)) {
                    select_wrap.toggleClass('vi-wpvs-hidden vi-wpvs-variation-wrap-option-show vi-wpvs-variation-wrap-select-bottom');
                } else {
                    select_wrap.toggleClass('vi-wpvs-hidden vi-wpvs-variation-wrap-option-show vi-wpvs-variation-wrap-select-top');
                }
            });
        });
    }

    form.find('.vi-wpvs-option-wrap').each(function (k, item) {
        let attr_div, attr_select, attr_value, val;
        attr_div = jQuery(item).closest('.vi-wpvs-variation-wrap-wrap');
        attr_select = attr_div.find('select.vi-wpvs-select-attribute');
        attr_select.find('option').removeClass('vi-wpvs-option-disabled');
        jQuery(item).on('mouseenter', function () {
            if (!jQuery(this).hasClass('vi-wpvs-option-wrap-selected') && !jQuery(this).hasClass('vi-wpvs-option-wrap-disable')) {
                jQuery(this).removeClass('vi-wpvs-option-wrap-default').addClass('vi-wpvs-option-wrap-hover');
            }
        }).on('mouseleave', function () {
            if (!jQuery(this).hasClass('vi-wpvs-option-wrap-selected') && !jQuery(this).hasClass('vi-wpvs-option-wrap-disable')) {
                jQuery(this).removeClass('vi-wpvs-option-wrap-hover').addClass('vi-wpvs-option-wrap-default');
            }
        }).on('click', function (e) {
            e.stopPropagation();
            if (jQuery(this).hasClass('vi-wpvs-option-wrap-disable')) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
            if (!jQuery(this).parent().hasClass('vi-wpvs-variation-wrap-radio')) {
                e.preventDefault();
                e.stopPropagation();
            }
            jQuery('.vi-wpvs-variation-wrap-option').addClass('vi-wpvs-hidden');
            form.find('.reset_variations').removeClass('vi-wpvs-hidden');
            attr_div.find('.vi-wpvs-option-wrap').removeClass('vi-wpvs-option-wrap-selected vi-wpvs-option-wrap-hover').addClass('vi-wpvs-option-wrap-default');
            if (attr_div.find('.vi-wpvs-variation-wrap').hasClass('vi-wpvs-variation-wrap-select')) {
                attr_div.find('.vi-wpvs-variation-wrap-option').addClass('vi-wpvs-hidden');
                attr_div.find('.vi-wpvs-variation-button-select >span ').html(jQuery(this).find('.vi-wpvs-option-select').html());
            }
            if (jQuery(this).find('.vi-wpvs-option-radio').length > 0) {
                attr_div.find('.vi-wpvs-option-radio').prop('checked', false);
                jQuery(this).find('.vi-wpvs-option-radio').prop('checked', true);
                jQuery(this).removeClass('vi-wpvs-option-wrap-default').addClass('vi-wpvs-option-wrap-selected');
            }
            attr_value = attr_select.val().toString();
            val = jQuery(this).data('attribute_value').toString();
            if (val !== attr_value) {
                jQuery(this).removeClass('vi-wpvs-option-wrap-default').addClass('vi-wpvs-option-wrap-selected');
                attr_select.val(val).trigger('change');
                vi_wpvs_frontend.select_variation_item();
            } else if (!jQuery(this).parent().hasClass('vi-wpvs-variation-wrap-radio')) {
                if (form.hasClass('vi_wpvs_loop_variation_form')) {
                    if (form.data('vpvs_double_click')) {
                        attr_select.val('').trigger('change');
                        vi_wpvs_frontend.select_variation_item();
                    } else {
                        jQuery(this).removeClass('vi-wpvs-option-wrap-default').addClass('vi-wpvs-option-wrap-selected');
                    }
                } else {
                    if (attr_div.data('vpvs_double_click')) {
                        attr_select.val('').trigger('change');
                        vi_wpvs_frontend.select_variation_item();
                    } else {
                        jQuery(this).removeClass('vi-wpvs-option-wrap-default').addClass('vi-wpvs-option-wrap-selected');
                    }
                }
            }
            e.stopPropagation();
        });
    });
    form.find('select:not(.vi-wpvs-select-attribute):not(.vi-wpvs-variation-style-select)').change(function () {
        setTimeout(function () {
            vi_wpvs_frontend.select_variation_item();
        }, 500);
    });
    form.find('.reset_variations').on('click', function () {
        jQuery(this).addClass('vi-wpvs-hidden');
        form.find('select.vi-wpvs-select-attribute').val('').trigger('change');
        vi_wpvs_frontend.select_variation_item();
        form.find('.vi-wpvs-option-wrap').removeClass('vi-wpvs-option-wrap-selected').addClass('vi-wpvs-option-wrap-default');
        form.find('.vi-wpvs-option-radio').prop('checked', false);
    });
};
vi_wpvs_frontend.prototype.check_available_variation = function (variations, form) {
    let attrs_values = [], options = [], selected = {}, count_attr = 0, attrs_name;
    form.find('.vi-wpvs-select-attribute select').each(function () {
        let val = jQuery(this).val().toString();
        if (val) {
            count_attr++;
        }
        selected[jQuery(this).data('attribute_name')] = val;
    });

    if (count_attr > 0) {
        attrs_name = Object.getOwnPropertyNames(selected);
        if (attrs_name.length === 1) {
            jQuery.each(variations, function (k, v) {
                let propName = v.attributes[attrs_name[0]];
                if (propName && attrs_values.indexOf(propName) === -1) {
                    attrs_values.push(propName);
                }
            });
            if (attrs_values.length > 0) {
                attrs_values.push('');
                form.find('.vi-wpvs-select-attribute select option').each(function (option_item_k, option_item) {
                    let val = jQuery(option_item).val().toString();
                    if (jQuery.inArray(val, attrs_values) === -1) {
                        jQuery(option_item).addClass('vi-wpvs-option-disabled');
                    }
                });
            }
            return false;
        } else {
            for (let i = 0; i < attrs_name.length; i++) {
                let attr_key = attrs_name[i],
                    attr_value = selected[attr_key];
                if (!attr_value || attr_value === '') {
                    for (let m = 0; m < attrs_name.length; m++) {
                        if (i == m) {
                            continue;
                        }
                        let attr_key_t = attrs_name[m];
                        form.find('.vi-wpvs-select-attribute select[name="' + attr_key_t + '"] option').removeClass('vi-wpvs-option-disabled');
                    }
                }
                jQuery.each(variations, function (key, val) {
                    if (!val.attributes[attr_key]) {
                        form.find('select[name ="' + attr_key + '"]').addClass('vi-wpvs-select-option-show');
                        return true;
                    }
                    if (attrs_values.indexOf(val.attributes[attr_key]) === -1) {
                        attrs_values.push(val.attributes[attr_key]);
                    }
                    if (attr_value == val.attributes[attr_key]) {
                        form.find('option[value ="' + val.attributes[attr_key] + '"]').removeClass('vi-wpvs-option-disabled');
                        if (options.indexOf(val.attributes[attr_key]) === -1) {
                            options.push(val.attributes[attr_key]);
                        }
                        for (let j = 0; j < attrs_name.length; j++) {
                            let attr_key_t = attrs_name[j];
                            if (val.attributes[attr_key_t] && attr_key_t !== attr_key) {
                                form.find('option[value ="' + val.attributes[attr_key_t] + '"]').removeClass('vi-wpvs-option-disabled');
                                if (options.indexOf(val.attributes[attr_key_t]) === -1) {
                                    options.push(val.attributes[attr_key_t]);
                                }
                                if (attrs_values.indexOf(val.attributes[attr_key_t]) === -1) {
                                    attrs_values.push(val.attributes[attr_key_t]);
                                }
                            }
                        }
                    } else {
                        for (let k = 0; k < attrs_name.length; k++) {
                            let attr_key_t = attrs_name[k];
                            if (val.attributes[attr_key_t] === '' || val.attributes[attr_key_t] === null) {
                                form.find('select[name ="' + attr_key_t + '"]').addClass('vi-wpvs-select-option-show');
                            } else if (attr_value !== '' && attr_value !== null && attr_key_t !== attr_key && options.indexOf(val.attributes[attr_key_t]) === -1) {
                                form.find('option[value ="' + val.attributes[attr_key_t] + '"]').addClass('vi-wpvs-option-disabled');
                            }
                        }
                    }
                });
            }
        }
    } else {
        jQuery.each(variations, function (k, v) {
            let i, attributes = v.attributes, aProps = Object.getOwnPropertyNames(v.attributes);
            for (i = 0; i < aProps.length; i++) {
                let propName = aProps[i];
                if (attributes[propName] === '' || attributes[propName] === null) {
                    form.find('select[name ="' + propName + '"]').addClass('vi-wpvs-select-option-show');
                    return true;
                }
                if (attrs_values.indexOf(attributes[propName]) === -1) {
                    attrs_values.push(attributes[propName]);
                }
            }
        });
    }
    if (attrs_values.length > 0) {
        attrs_values.push('');
        form.find('.vi-wpvs-select-attribute select:not(.vi-wpvs-select-option-show) option').each(function (option_item_k, option_item) {
            let val = jQuery(option_item).val().toString();
            if (jQuery.inArray(val, attrs_values) === -1) {
                jQuery(option_item).addClass('vi-wpvs-option-disabled');
            }
        });
    }
    form.find('.vi-wpvs-select-attribute select').removeClass('vi-wpvs-select-option-show');
};
vi_wpvs_frontend.prototype.design_variation_item = function () {
    let form = this.form;
    form.find('.vi-wpvs-variation-wrap-wrap').each(function () {
        let variation_wrap = jQuery(this).parent().parent();
        jQuery(this).parent().addClass('vi-wpvs-variation-style-content');
        variation_wrap.find('.vi-wpvs-select-attribute  > select').addClass('vi-wpvs-select-attribute');
        variation_wrap.addClass(variation_wrap.find('.vi-wpvs-variation-wrap').data('display_type'));
    });
    form.find('.vi-wpvs-option.vi-wpvs-option-color').each(function (color_item_k, color_item) {
        let colors = jQuery(color_item).data('option_color');
        console.log(colors)
        jQuery(color_item).css({background: colors});
    });

    form.find('.vi-wpvs-variation-wrap-wrap').removeClass('vi-wpvs-hidden');
    form.find('.vi-wpvs-option-tooltip.vi-wpvs-option-tooltip-top,.vi-wpvs-option-tooltip.vi-wpvs-option-tooltip-bottom').each(function () {
        let tooltip_width = jQuery(this).outerWidth();
        jQuery(this).css({'margin-left': ('-' + (tooltip_width / 2) + 'px')});
    });
    form.find('.vi-wpvs-option-tooltip.vi-wpvs-option-tooltip-left,.vi-wpvs-option-tooltip.vi-wpvs-option-tooltip-right').each(function () {
        let tooltip_width = jQuery(this).outerHeight();
        jQuery(this).css({'margin-top': ('-' + (tooltip_width / 2) + 'px')});
    });
};
vi_wpvs_frontend.prototype.select_variation_item = function () {
    let form = this.form;
    let attrs_value = form.find('select option:not(.vi-wpvs-option-disabled)').map(function () {
        return jQuery(this).val();
    });
    form.find('.vi-wpvs-option-wrap').each(function (option_item_k, option_item) {
        let val = jQuery(option_item).data('attribute_value').toString();
        if (jQuery.inArray(val, attrs_value) !== -1) {
            jQuery(option_item).removeClass('vi-wpvs-option-wrap-disable');
        } else {
            jQuery(option_item).removeClass('vi-wpvs-option-wrap-selected').addClass('vi-wpvs-option-wrap-default vi-wpvs-option-wrap-disable');
        }
    });
};
jQuery.fn.vi_woo_product_variation_swatches = function () {
    new vi_wpvs_frontend(this);
    return this;
};

