'use strict';
let vi_wpvs_custom_attribute;
vi_wpvs_custom_attribute = {
    init: function () {
        this.editAttribute();
        this.editItem();
        this.ColorPicker();
        this.UploadImage();
        this.duplicateItem();
        this.removeItem();
    },
    editAttribute: function () {
        jQuery('.vi-wpvs-attribute-info-custom-open').unbind().on('click', function () {
            jQuery(this).find('.vi-wpvs-attribute-value-action-icon').toggleClass('vi-wpvs-hidden');
            jQuery(this).closest('.vi-wpvs-attribute-content-wrap').find('.vi-wpvs-attribute-info-custom-wrap').toggleClass('vi-wpvs-hidden');
        });
        jQuery('.vi-wpvs-attribute-value-title-wrap').unbind().on('click', function () {
            if (!jQuery(this).hasClass('vi-wpvs-attribute-value-title-toggle')) {
                return false;
            }
            jQuery(this).find('.vi-wpvs-attribute-value-action-icon').toggleClass('vi-wpvs-hidden');
            jQuery(this).closest('.vi-wpvs-attribute-value-wrap').find('.vi-wpvs-attribute-value-content-wrap').toggleClass('vi-wpvs-attribute-value-content-open').toggleClass('vi-wpvs-attribute-value-content-close');
        });
        jQuery('.vi-wpvs-attribute-taxonomy-select-all').unbind().on('click', function () {
            let attribute_value_wrap = jQuery(this).closest('.vi-wpvs-attribute-value-wrap-wrap').find('.vi-wpvs-attribute-value-wrap');
            if (attribute_value_wrap.length === 0) {
                return false;
            }
            jQuery(this).parent().find('.vi-wpvs-attribute-taxonomy-add-new').addClass('disabled');
            attribute_value_wrap.each(function (key, value) {
                jQuery(value).removeClass('vi-wpvs-hidden');
                let attr_values = jQuery(value).find('.vi_wpvs_attribute_values');
                if (attr_values.length) {
                    attr_values.val(jQuery(value).attr('data-term_id'));
                } else {
                    jQuery(value).append('<input type="hidden" class="vi_wpvs_attribute_values" name="attribute_values[' + jQuery(value).attr('data-attribute_number') + '][]" value="' + jQuery(value).attr('data-term_id') + '">');
                }
            });
        });
        jQuery('.vi-wpvs-attribute-taxonomy-select-none').unbind().on('click', function () {
            let attribute_value_wrap = jQuery(this).closest('.vi-wpvs-attribute-value-wrap-wrap').find('.vi-wpvs-attribute-value-wrap');
            if (attribute_value_wrap.length === 0) {
                return false;
            }
            jQuery(this).parent().find('.vi-wpvs-attribute-taxonomy-add-new').removeClass('disabled');
            attribute_value_wrap.each(function (key, value) {
                jQuery(value).addClass('vi-wpvs-hidden');
                jQuery(value).find('.vi_wpvs_attribute_values').remove();
            });
        });
        jQuery('.vi-wpvs-attribute-taxonomy-add-new').unbind().on('click', function () {
            jQuery(this).addClass('vi-wpvs-action-editing');
            jQuery(this).closest('.vi-wpvs-attribute-value-wrap-wrap').find('.vi-wpvs-attribute-taxonomy-add-new-term-wrap').removeClass('vi-wpvs-hidden');
        });

        jQuery('.vi-wpvs-attribute-type select').unbind().on('change', function () {
            let attribute_check_type = ['color', 'image'],
                val = jQuery(this).val(),
                div_container = jQuery(this).closest('.vi-wpvs-attribute-content').find('.vi-wpvs-attribute-value-wrap-wrap');
            div_container.find('.vi-wpvs-attribute-value-content-wrap > div, .vi-wpvs-attribute-value-action-icon').addClass('vi-wpvs-hidden');
            if (jQuery.inArray(val, attribute_check_type) !== -1) {
                div_container.find('.vi-wpvs-attribute-value-title-wrap').addClass('vi-wpvs-attribute-value-title-toggle');
                div_container.find('.vi-wpvs-attribute-value-content-wrap  .vi-wpvs-attribute-value-content-' + val + '-wrap,.vi-wpvs-attribute-value-action-icon-down ').removeClass('vi-wpvs-hidden');
            } else {
                div_container.find('.vi-wpvs-attribute-value-title-wrap').removeClass('vi-wpvs-attribute-value-title-toggle');
                div_container.find('.vi-wpvs-attribute-value-content-wrap').removeClass('vi-wpvs-attribute-value-content-open').addClass('vi-wpvs-attribute-value-content-close');
            }
        });
    },
    editItem: function () {
        jQuery('.vi-wpvs-attribute-value-name').unbind().on('click', function (e) {
            e.stopPropagation();
        });
        jQuery('.vi-wpvs-attribute-edit-button-cancel').unbind().on('click', function () {
            jQuery('.vi-wpvs-action-editing').removeClass('vi-wpvs-action-editing');
            jQuery(this).closest('.vi-wpvs-attribute-edit-wrap-wrap').addClass('vi-wpvs-hidden');
        });
        jQuery('.vi-wpvs-attribute-edit-button-ok').unbind().on('click', function () {
            let attribute_wrap = jQuery('.vi-wpvs-action-editing').closest('.vi-wpvs-attribute-value-wrap-wrap'),
                new_terms = jQuery(this).closest('.vi-wpvs-attribute-taxonomy-add-new-term-wrap').find('.vi-wpvs-taxonomy-add-new-term').val();
            if (new_terms && new_terms.length > 0) {
                new_terms.forEach(function (v) {
                    let attribute_value_wrap = attribute_wrap.find('.vi-wpvs-attribute-taxonomy-value-wrap-' + v);
                    attribute_value_wrap.removeClass('vi-wpvs-hidden');
                    if (attribute_value_wrap.find('.vi_wpvs_attribute_values').length > 0) {
                        attribute_value_wrap.find('.vi_wpvs_attribute_values').val(attribute_value_wrap.attr('data-term_id'));
                    } else {
                        attribute_value_wrap.append('<input type="hidden" class="vi_wpvs_attribute_values" name="attribute_values[' + attribute_value_wrap.attr('data-attribute_number') + '][]" value="' + v + '">');
                    }
                });
            }
            jQuery('.vi-wpvs-action-editing').removeClass('vi-wpvs-action-editing');
            jQuery(this).closest('.vi-wpvs-attribute-taxonomy-add-new-term-wrap').addClass('vi-wpvs-hidden');
        });
    },
    removeItem: function () {
        jQuery('.vi-wpvs-attribute-wrap-wrap .vi-wpvs-attribute-value-action-remove').unbind().on('click', function (e) {
            e.stopPropagation();
            let attribute_wrap = jQuery(this).closest('.vi-wpvs-attribute-value-wrap');
            if (attribute_wrap.hasClass('vi-wpvs-attribute-taxonomy-value-wrap')) {
                if (confirm(vi_woo_product_variation_swatches_admin_custom_attribute.remove_item)) {
                    attribute_wrap.addClass('vi-wpvs-hidden');
                    attribute_wrap.find('.vi_wpvs_attribute_values').remove();
                    attribute_wrap.parent().find('.vi-wpvs-attribute-taxonomy-add-new').removeClass('disabled');
                }
            } else {
                if (attribute_wrap.parent().find('.vi-wpvs-attribute-value-wrap').length === 1) {
                    alert(vi_woo_product_variation_swatches_admin_custom_attribute.remove_last_item);
                    return false;
                }
                if (confirm(vi_woo_product_variation_swatches_admin_custom_attribute.remove_item)) {
                    attribute_wrap.remove();
                }
            }
            e.stopPropagation();
        });
        jQuery('.vi-wpvs-attribute-colors-action-remove').unbind().on('click', function (e) {
            if (jQuery(this).closest('.vi-wpvs-attribute-value-content-color-table').find('tr').length === 2) {
                alert(vi_woo_product_variation_swatches_admin_custom_attribute.remove_last_item);
                return false;
            }
            if (confirm(vi_woo_product_variation_swatches_admin_custom_attribute.remove_item)) {
                jQuery(this).parent().parent().remove();
            }
            e.stopPropagation();
        });
        jQuery('.vi-wpvs-attribute-row-remove').unbind().on('click', function (e) {
            e.preventDefault();
            if (confirm(vi_woo_product_variation_swatches_admin_custom_attribute.remove_attribute)) {
                let wrap = jQuery(this).closest('.vi-wpvs-attribute-wrap');
                if (wrap.is('.taxonomy')) {
                    wrap.remove();
                    jQuery('select.attribute_taxonomy').find('option[value="' + wrap.data('taxonomy') + '"]').removeAttr('disabled');
                } else {
                    wrap.find('select, input[type=text]').val('');
                    wrap.hide();
                    jQuery('.product_attributes .woocommerce_attribute').each(function (index, el) {
                        jQuery('.attribute_position', el).val(parseInt(jQuery(el).index('.product_attributes .woocommerce_attribute'), 10));
                    });
                }
            }
            e.stopPropagation();
        });
    },
    duplicateItem: function () {
        jQuery('.vi-wpvs-attribute-colors-action-clone').unbind().on('click', function (e) {
            e.stopPropagation();
            var current = jQuery(this).parent().parent();
            var newRow = current.clone();
            newRow.find('.iris-picker').remove();
            newRow.insertAfter(current);
            vi_wpvs_custom_attribute.init();
            e.stopPropagation();
        });
        jQuery('.vi-wpvs-attribute-value-action-clone').unbind().on('click', function (e) {
            e.stopPropagation();
            let i = jQuery('.vi-wpvs-attribute-value-wrap').length, j;
            var current = jQuery(this).closest('.vi-wpvs-attribute-value-wrap');
            var newRow = current.clone();
            j = current.data('attribute_number');
            newRow.find('.iris-picker').remove();
            newRow.find('.vi_attribute_colors').each(function () {
                jQuery(this).attr('name', 'vi_attribute_colors[' + j + '][' + i + '][]');
            });
            newRow.insertAfter(current);
            vi_wpvs_custom_attribute.init();
            e.stopPropagation();
        });
    },
    UploadImage: function () {
        var vi_img_uploader;
        jQuery('.vi-wpvs-term-image-upload-img').unbind().on('click', function (e) {
            e.preventDefault();
            jQuery(this).closest('.vi-wpvs-attribute-value-content-image-wrap').find('.vi_attribute_image,.vi-attribute-image-preview').addClass('vi_attribute_image-editing');
            //If the uploader object has already been created, reopen the dialog
            if (vi_img_uploader) {
                vi_img_uploader.open();
                return false;
            }
            //Extend the wp.media object
            vi_img_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: true
            });

            //When a file is selected, grab the URL and set it as the text field's value
            vi_img_uploader.on('select', function () {
                let attachment = vi_img_uploader.state().get('selection').first().toJSON();
                jQuery('.vi_attribute_image.vi_attribute_image-editing').val(attachment.id).removeClass('vi_attribute_image-editing');
                jQuery('.vi-attribute-image-preview.vi_attribute_image-editing').html('<img src="' + attachment.url + '">').removeClass('vi_attribute_image-editing');
            });

            //Open the uploader dialog
            vi_img_uploader.open();
        });
    },
    ColorPicker: function () {
        jQuery('.vi-wpvs-color').each(function () {
            jQuery(this).css({backgroundColor: jQuery(this).val()});
        });
        jQuery('.vi-wpvs-color.vi_attribute_colors').unbind().minicolors({
            change: function (value, opacity) {
                jQuery(this).parent().find('.vi-wpvs-color.vi_attribute_colors').css({backgroundColor: value});
            },
            animationSpeed: 50,
            animationEasing: 'swing',
            changeDelay: 0,
            control: 'wheel',
            defaultValue: '',
            format: 'rgb',
            hide: null,
            hideSpeed: 100,
            inline: false,
            keywords: '',
            letterCase: 'lowercase',
            opacity: true,
            position: 'bottom left',
            show: null,
            showSpeed: 100,
            theme: 'default',
            swatches: []
        });
    },
    wpvs_term_color_preview: function () {
    }
};
jQuery(document).ready(function () {
    jQuery('.product_attributes.vi-wpvs-attribute-wrap-wrap').find('.woocommerce_attribute:not(.vi-wpvs-attribute-wrap)').remove();
    jQuery('.product_attributes:not(.vi-wpvs-attribute-wrap-wrap)').remove();
    jQuery('#product_attributes > .toolbar-top').append('<button class="button primary vi_wpvs_global_setting_url"><a href="' + vi_woo_product_variation_swatches_admin_custom_attribute.global_setting_url + '" target="_blank">' + vi_woo_product_variation_swatches_admin_custom_attribute.global_setting_title + '</a></button>');
    jQuery('.vi-wpvs-taxonomy-add-new-term').select2({
        closeOnSelect: false
    });
    var vi_wpvs_custom_attribute_t = vi_wpvs_custom_attribute;
    vi_wpvs_custom_attribute_t.init();
    jQuery(document).ajaxComplete(function (event, jqxhr, settings) {
        let data = settings.data;
        if (data && (data.search('woocommerce_add_attribute') !== -1 || data.search('woocommerce_load_variations') !== -1 || data.search('woocommerce_save_attributes') !== -1)) {
            vi_wpvs_custom_attribute_t.init();
            jQuery('.vi-wpvs-taxonomy-add-new-term').select2({
                closeOnSelect: false
            });
        }
    });
});