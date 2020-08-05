(function( $ ) {
    'use strict';

    var progressWidth = 0;

    $(function() {
        $(".meter > span").each(function() {
            $(this)
                .data("origWidth", $(this).width())
                .width(0)
                .animate({
                    width: $(this).data("origWidth")
                }, 1200);
        });
    });



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

    $(document).ready(function() {
        $('#rex_feed_conf select, #rex_feed_products select, #cmb2-metabox-rex_feed_google_merchant select').niceSelect();
        //$('.ui-timepicker-select').formSelect('destroy');

        if ( $('#rex_feed_xml_file').val() == '' ) {
            $('#rex_feed_file_link').slideUp('fast');
        }

        //$('.rex-tabs').tabs();

        //---------popup when click disabled input-------
        $( ".single-merchant.wpfm-pro .wpfm-pro-cta" ).on("click", function(e){
            e.preventDefault();
            $(".premium-merchant-alert").addClass("show-alert");
        });

        $( ".premium-merchant-alert .close, .premium-merchant-alert button.close, .premium-merchant-alert" ).on("click", function(){
            $(".premium-merchant-alert").removeClass("show-alert");
        });

        $(".premium-merchant-alert .alert-box").on("click", function (e) {
            e.stopPropagation();
        });
        

    });

    /**
     * Add a new table-row and update it's
     */
    $(document).on('click', '#rex-new-attr', function () {
        var rowId = $(this).siblings('#config-table').find('tbody tr').length;
        var lastrow = $(this).siblings('#config-table').find('tbody tr:last');
        var parent = $(this).siblings('#config-table').parent();

        if(parent.hasClass('rex-feed-config-filter')) {
            var filter = true;
        }else {
            filter = false;
        }
        $(this).siblings('#config-table').find('tbody tr:first')
            .clone()
            .insertAfter(lastrow)
            .attr('data-row-id', rowId)
            .show();


        var $row = $(this).siblings('#config-table').find("[data-row-id='" + rowId + "']");
        $row.find('ul.dropdown-content.select-dropdown, .caret, .select-dropdown ').remove();

        // $row.find('input, select').val('');

        updateFormNameAtts( $row, rowId, filter);
        $row.find('select').niceSelect('update');
    });


    /**
     * add new custom attributes
     */
    $(document).on('click', '#rex-new-custom-attr', function () {
        // var rowId = $(this).siblings('#config-table').find('tbody tr').length;
        var rowId = $(this).siblings('#config-table').find('tbody tr').last().attr('data-row-id');
        rowId = parseInt(rowId)+1;
        var lastrow = $(this).siblings('#config-table').find('tbody tr:last');
        var parent = $(this).siblings('#config-table').parent();

        if(parent.hasClass('rex-feed-config-filter')) {
            var filter = true;
        }else {
            filter = false;
        }

        $(this).siblings('#config-table').find('tbody tr:first')
            .clone()
            .insertAfter(lastrow)
            .attr('data-row-id', rowId)
            .show();


        var $row = $(this).siblings('#config-table').find("[data-row-id='" + rowId + "']");
        $row.find('ul.dropdown-content.select-dropdown, .caret, .select-dropdown ').remove();

        $row.find('td:eq(0)').empty();
        $row.find('td:eq(0)').append('<input type="text" name="fc[0][cust_attr]" value="">');
        // $row.find('input, select').val('');

        updateFormNameAtts( $row, rowId, filter);
        $row.find('select').niceSelect('update');
    });


    /**
     * Delete a table-row and update all row-id
     * beneath it and their input attributes names.
     */
    $(document).on('click', '#config-table .delete-row', function () {
        var $nextRows, rowId;



        var table = $(this).closest('table');
        var parent = table.parent();

        // delete row and get it's row-id
        rowId = $(this).closest('tr').remove().data('row-id');

        if(parent.hasClass('rex-feed-config-filter')) {
            var filter = true;
        }else {
            filter = false;
        }



        // Gell the next rows
        if ( rowId == 0) {
            $nextRows = $('#config-table tbody').children();
        }else{
            $nextRows = $('#config-table').find("[data-row-id='" + (rowId -1) + "']").nextAll('tr');
        }

        // Update their row-id and name attributes
        $nextRows.each( function (index, el) {
            if(!$(el).css('display') == 'none') {
                $(el).attr( 'data-row-id', rowId);
                updateFormNameAtts( $(el), rowId, filter);
                rowId++;
            }

        });
    });

    /**
     * Function for updating select and input box name
     * attribute under a table-row.
     */
    function updateFormNameAtts( $row, rowId, filter){
        var name, $el;
        $el = $row.find('input, select');
        $el.each(function(index, item) {
            name = $(item).attr('name');
            if( $(item).parent().hasClass('static-input') ) {
                $(item).parent().hide();
            }
            if ( name != undefined ) {
                // get new name via regex
                if (filter) {
                    name = name.replace(/^ff\[\d+\]/, 'ff[' + rowId + ']');
                    $(item).attr('name', name);
                }else {
                    name = name.replace(/^fc\[\d+\]/, 'fc[' + rowId + ']');
                    $(item).attr('name', name);
                }

            }
        });
    }


    /**
     * Event listener for Attribute type change functionality.
     */
    $(document).on('change', 'select.type-dropdown', function () {
        var selected = $(this).find('option:selected').val();
        if ( selected == 'static' ) {
            $(this).closest('td').next('td').find('.meta-dropdown').hide();
            $(this).closest('td').next('td').find('.static-input').show();
        }else{
            $(this).closest('td').next('td').find('.static-input').hide();
            $(this).closest('td').next('td').find('.meta-dropdown').show();
        }
    });

    /**
     * Event listener for Filter Product.
     */
    $(document).on('change', '#rex_feed_products', function () {
        var selected = $('#rex_feed_products').find(':selected').val();
        if ( selected == 'filter' ) {
            $('.cmb2-id-rex-feed-config-filter-title').show();
            $('#rex-feed-config-filter').show();
        }else{
            $('.cmb2-id-rex-feed-config-filter-title').hide();
            $('#rex-feed-config-filter').hide();
        }
    });



    /**
     * Event listener for feed type change.
     */
    // $(document).on('change', '#rex_feed_merchant', function () {
    //     var selected = $(this).find('option:selected').val();
    //     var csv = '';
    //     if ( selected == 'google' ) {
    //         $('.cmb2-id-rex-feed-feed-format').hide();
    //     }else{
    //         $('.cmb2-id-rex-feed-feed-format').show();
    //     }
    // });


    /**
     * Event listener for Merchant change functionality.
     */
    $(document).on('change', '#rex_feed_merchant', function () {

        var $confBox = $('.rex-feed-config');
        var merchant_name = $('#rex_feed_merchant').find(':selected').val();
        if(merchant_name !== '-1') {
            $confBox.find('.rex-loading-spinner').css('display', 'flex');
            var $payload = {
                merchant: $('#rex_feed_merchant').find(':selected').val(),
                post_id: $('#post_ID').val()
                // feed_format: $('#rex_feed_feed_format').find(':selected').val()
            };
            wpAjaxHelperRequest( 'merchant-change', $payload )
                .success( function( response ) {
                    // console.log(response);
                    $confBox.fadeOut();
                    $confBox.find('#config-table').html( response );
                    $('#config-table select').niceSelect('update');
                    $confBox.fadeIn();
                    $('.rex-loading-spinner').css('display', 'none');
                    $('#rex_feed_conf .cmb2-id-rex-feed-config-heading').css('display', 'block');
                    $('#rex-new-attr, #rex-new-custom-attr').css('display', 'inline-block');
                })
                .error( function( response ) {
                    $('.rex-loading-spinner').css('display', 'none');
                    console.log( 'Uh, oh! Merchant change returned error!' );
                    console.log( response.statusText );
                });
        }

    });

    function get_checkbox_val( name ){
        var items = 'input[name="rex_feed_' + name + '[]"]';
        var vals = [];

        $(items).each( function (){
            if( $(this).prop('checked') == true){
                vals.push( $(this).val() );
            }
        });

        return vals;
    }


    // $(document).on('click', '#publish', save_feed);


    /**
     * Start the feed processing
     * @param event
     */
    function get_product_number(event) {
        event.preventDefault();

        var merchant_name = $('#rex_feed_merchant').find(':selected').val();
        if(merchant_name == '-1') {
            alert('Please choose a merchant!');
            return;
        }

        if($('.wpfm-field-mappings').find('tbody tr:first').css('display') == 'none') {
            $('.wpfm-field-mappings').find('tbody tr:first').remove();
        }
        $('#wpfm-feed-clock').stopwatch().stopwatch('start');
        var merchant = $('#rex_feed_merchant').find(':selected').val();

        var $payload = {};
        $('#publishing-action span.spinner').addClass('is-active');
        $(this).addClass('disabled');
        $('.bwfm-progressbar, .progress-msg').fadeIn();
        $('.progress-msg span').html('Calculating products.....');
        wpAjaxHelperRequest( 'my-handle', $payload )
            .success( function( response ) {
                var per_batch = response.per_batch ? parseInt(response.per_batch) : 50;
                if(merchant !== 'google_merchant_promotion') {
                    generate_feed(response.products, 0, 1, per_batch, response.total_batch);
                }else {
                    generate_promotion_feed();
                }

            })
            .error( function( response ) {
                $('#publishing-action span.spinner').removeClass('is-active');
                $('#publish').removeClass('disabled');
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on('click', '#publish', get_product_number);


    /**
     * generate promotion feed
     */
    function generate_promotion_feed() {
        var $payload = {
            merchant: $('#rex_feed_merchant').find(':selected').val(),
            feed_format: $('#rex_feed_feed_format').find(':selected').val(),
            localization: $('#rex_feed_ebay_mip_localization').find(':selected').val(),
            ebay_cat_id: $('#rex_feed_ebay_seller_category').val(),
            info : {
                post_id     : $('#post_ID').val(),
                title       : $('#title').val(),
                desc        : $('#title').val(),
            },
            products: {
                products_scope: $('#rex_feed_products').find(':selected').val(),
                tags: get_checkbox_val('tags'),
                cats: get_checkbox_val('cats'),
            },

            feed_config : $('form').serialize(),
        };



        wpAjaxHelperRequest( 'generate-promotion-feed', $payload )
            .success( function( response ) {
                console.log( 'Woohoo!' );
                console.log(response);
                $('#publish').removeClass('disabled');
                $(document).off( 'click', '#publish', get_product_number );
                $('#publish').trigger( 'click' );
            })
            .error( function( response ) {
                $('#publishing-action span.spinner').removeClass('is-active');
                $('#publish').removeClass('disabled');
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });
    }

    /**
     * Generate feed
     * @param product
     * @param offset
     * @param batch
     * @param per_batch
     */
    function generate_feed( product, offset, batch, per_batch, total_batch ) {

        per_batch = typeof per_batch !== 'undefined' ? per_batch : 50;

        var $payload = {
            merchant: $('#rex_feed_merchant').find(':selected').val(),
            feed_format: $('#rex_feed_feed_format').find(':selected').val(),
            localization: $('#rex_feed_ebay_mip_localization').find(':selected').val(),
            ebay_cat_id: $('#rex_feed_ebay_seller_category').val(),
            info : {
                post_id     : $('#post_ID').val(),
                title       : $('#title').val(),
                desc        : $('#title').val(),
                offset      : offset,
                batch       : batch,
                total_batch : total_batch,
                per_batch   : per_batch,
            },

            products: {
                products_scope: $('#rex_feed_products').find(':selected').val(),
                tags: get_checkbox_val('tags'),
                cats: get_checkbox_val('cats'),
            },

            feed_config : $('form').serialize(),
        };

        var batches = total_batch;
        console.log('Total Batch: '+ batches);
        console.log('Total Product(s): '+ product);
        console.log('Processing Batch Number: '+ batch);
        console.log('Offset Number: '+ offset);

        var progressbar = 100/batches;
        progressWidth = progressWidth + progressbar;
        if(progressWidth > 100) {
            progressWidth = 100;
        }

        // feed_progressBar(progressWidth);
        if (progressWidth >= 100) {
            $('.progress-msg span').html('Generating feed. Please wait.....');
        }else {
            $('.progress-msg span').html('Processing feed.....');
        }

        wpAjaxHelperRequest( 'generate-feed', $payload )
            .success( function( response ) {
                console.log( 'Woohoo!' );
                console.log(response);
                var msg = '<div id="message" class="error notice notice-error is-dismissible"><p>You feed exceed the limit.Please <a href="edit.php?post_type=product-feed&page=best-woocommerce-feed-pricing">Upgrade!!!</a> </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                if(response == 'false' || response == ''){
                    generate_feed(product, offset, batch, per_batch, total_batch);
                }else if (response.msg == 'finish') {
                    feed_progressBar(progressWidth);
                    $('#wpfm-feed-clock').stopwatch().stopwatch('stop');
                    $('#publish').removeClass('disabled');
                    $(document).off( 'click', '#publish', get_product_number );
                    $('#publish').trigger( 'click' );
                } else {
                    if ( batch < batches ) {
                        offset = offset + per_batch;
                        batch++;
                        feed_progressBar(progressWidth);
                        generate_feed(product, offset, batch, per_batch, total_batch);
                    }
                }
            })
            .error( function( response ) {
                $(".progressbar-bar").css('background', '#ff0000');
                $(".progressbar-bar").css('border-color', '#ff0000');
                $(".progress-msg span").css('color', '#ff0000');
                $(".progress-msg i").css('color', '#ff0000');
                $(".progress-msg span").html(response.statusText);
                $('#publishing-action span.spinner').removeClass('is-active');
                $('#publish').removeClass('disabled');
                $('#wpfm-feed-clock').stopwatch().stopwatch('stop');
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });
    }

    function feed_progressBar(width) {

        $('.progressbar-bar').animate({
            width: Math.ceil(width) + '%'
        },1000);
        $('.progressbar-bar-percent').html(Math.ceil(width)+ '%');
    }


    /*
     * google merchant settings
     */
    function save_google_merchant_settings(event) {
        event.preventDefault();
        $('.rex-loading-spinner').css('display', 'flex');
        var payload = {
            client_id : $(this).find('#client_id').val(),
            client_secret : $(this).find('#client_secret').val(),
            merchant_id : $(this).find('#merchant_id').val(),
            merchant_settings: true
        };
        wpAjaxHelperRequest( 'google-merchant-settings', payload )
            .success( function( response ) {
                console.log('Woohoo!');
                $('.merchant-action').html(response.html);
                $('.rex-loading-spinner').css('display', 'none');
            })
            .error( function( response ) {
                console.log( 'Uh, oh!' );
                $('.rex-loading-spinner').css('display', 'none');
                console.log( response.statusText );
            });


    }
    $(document).on('submit', '#rex-google-merchant', save_google_merchant_settings);




    /*
     * Send feed to Google
     * Merchant Center
     */
    function send_to_google(event) {
        event.preventDefault();
        $('.rex-loading-spinner').css('display', 'flex');
        var payload = {
            feed_id     : $('#post_ID').val(),
            schedule    : $('#rex_feed_google_schedule option:selected').val(),
            hour        : $('#rex_feed_google_schedule_time option:selected').val(),
            country     : $('#rex_feed_google_target_country').val(),
            language    : $('#rex_feed_google_target_language').val()
        };

        if ($('#rex_feed_google_schedule option:selected').val() == 'monthly') {
            payload['month'] = $('#rex_feed_google_schedule_month option:selected').val();
            payload['day'] = '';
        }else if ($('#rex_feed_google_schedule option:selected').val() == 'weekly') {
            payload['day'] = $('#rex_feed_google_schedule_week_day option:selected').val();
            payload['month'] = '';
        }else {
            payload['month'] = '';
            payload['day'] = '';
        }
        $('.rex-google-status').removeClass('info');
        $('.rex-google-status').removeClass('success');
        $('.rex-google-status').removeClass('warning');
        $('.rex-google-status').removeClass('error');
        $('.rex-google-status').addClass('info');
        $('.rex-google-status').show();
        $('.rex-google-status').html('<p>Feed is sending. Please wait...</p>');
        wpAjaxHelperRequest( 'send-to-google', payload )
            .success( function( response ) {
                if(response.success) {
                    $('.rex-google-status').removeClass('info');
                    $('.rex-google-status').removeClass('success');
                    $('.rex-google-status').removeClass('warning');
                    $('.rex-google-status').removeClass('error');
                    $('.rex-google-status').addClass('success');
                    $('.rex-google-status').show();
                    $('.rex-google-status').html('<p>Feed sent to google successfully.</p>');
                    console.log('Woohoo!');
                    console.log(response);
                    location.reload();
                }else {
                    $('.rex-google-status').removeClass('info');
                    $('.rex-google-status').removeClass('success');
                    $('.rex-google-status').removeClass('warning');
                    $('.rex-google-status').removeClass('error');
                    $('.rex-google-status').addClass('warning');
                    $('.rex-google-status').show();
                    $('.rex-google-status').html('<p>Feed not sent to google. Please check.</p><p>' + response.reason + ': ' + response.message + '</p>');
                    console.log(response)
                }
            })
            .error( function( response ) {
                $('.rex-google-status').removeClass('info');
                $('.rex-google-status').removeClass('success');
                $('.rex-google-status').removeClass('warning');
                $('.rex-google-status').removeClass('error');
                $('.rex-google-status').addClass('error');
                $('.rex-google-status').show();
                $('.rex-google-status').html('<p>Something wrong happened. Please check.</p><p>' + response.reason + ': ' + response.message + '</p>');
                console.log( 'Uh, oh!' );
                console.log( response );
                console.log( response.statusText );
            });
    }
    $(document).on('click', '#send-to-google', send_to_google);


    function reset_form(event) {
        event.preventDefault();
        $(this).closest('form').find("input[type=text]").not(':disabled').val("");
        $(this).closest('form').find("button[type=submit]").prop('disabled', false);
    }
    $(document).on('click', '.rex-reset-btn', reset_form);


    /**
     * Change merchant status
     */
    function product_feed_change_merchant_status() {
        var payload = {};
        var $this = $(this);
        var key = $this.attr('data-value');
        var name = $this.attr('data-name');
        var isfree = $this.attr('data-is-free');
        if($this.is(":checked")) {
            payload[key] = {
                status : 1,
                name : name,
                free: isfree,
            };
        }else {
            payload[key] = {
                status : 0,
                name : name,
                free: isfree,
            };
        }


        wpAjaxHelperRequest( 'rex-product-change-merchant-status', payload )
            .success( function( response ) {
                console.log('woohoo!');
            })
            .error( function( response ) {
                console.log( 'uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on('change', '.merchant-change', product_feed_change_merchant_status);


    /**
     * Update product per batch
     * @param e
     */
    function update_per_batch(e) {
        e.preventDefault();
        var $form = $(this);
        $form.find("button.save-batch span").text("");
        $form.find("button.save-batch i").show();
        var per_batch = $form.find('#wpfm_product_per_batch').val();
        wpAjaxHelperRequest( 'rex-product-update-batch-size', per_batch )
            .success( function( response ) {
                $form.find("button.save-batch i").hide();
                $form.find("button.save-batch span").text("saved");
                setTimeout(function(){
                    $form.find("button.save-batch span").text("save");
                }, 1000);
                console.log('woohoo!');
            })
            .error( function( response ) {
                $form.find("button.save-batch i").hide();
                $form.find("button.save-batch span").text("failed");
                setTimeout(function(){
                    $form.find("button.save-batch span").text("save");
                }, 1000);
                console.log( 'uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on("submit", "#wpfm-per-batch", update_per_batch);


    /**
     *
     * @param e
     */
    function wpfm_clear_batch(e) {
        e.preventDefault();
        var payload = {};
        $(this).find("i").show();
        wpAjaxHelperRequest( 'rex-product-clear-batch', payload )
            .success( function( response ) {
                $("#wpfm-clear-batch").find("i").hide();
            })
            .error( function( response ) {
                console.log( 'uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on("click", "#wpfm-clear-batch", wpfm_clear_batch);
    
    
    //----------setting tab-------
    $(document).ready(function(){
        $('ul.rex-settings-tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');

            $('ul.rex-settings-tabs li').removeClass('active');
            $('.rex-settings-tab-content .tab-content').removeClass('active');

            $(this).addClass('active');
            $("#"+tab_id).addClass('active');
        });

    });


    /**
     * WPFM error log
     */
    function show_wpfm_error_log(e) {
        e.preventDefault();
        var $form = $(this);
        var log_key = $form.find('#wpfm-error-log option:selected').val();
        var payload = {
            'logKey' : log_key
        };
        if(!log_key) {
            $("#wpfm-log-copy").hide();
            $('#log-viewer pre').html('');
        }else {
            wpAjaxHelperRequest( 'rex-product-feed-show-log', payload )
                .success( function( response ) {
                    console.log('woohoo!');
                    $('#log-viewer pre').html(response.content);
                    if(log_key) {
                        $("#wpfm-log-copy").show();
                    }
                    $('#log-download').attr('href',response.file_url);
                })
                .error( function( response ) {

                    console.log( 'uh, oh!' );
                    console.log( response.statusText );
                });
        }

    }
    $(document).on("submit", "#wpfm-error-log-form", show_wpfm_error_log);


    $(document).on("click", "#wpfm-log-copy", wpfm_copy_log);
    function wpfm_copy_log(event) {
        event.preventDefault();
        var elm = document.getElementById("wpfm-log-content");
        if(document.body.createTextRange) {
            var range = document.body.createTextRange();
            range.moveToElementText(elm);
            range.select();
            document.execCommand("Copy");
            alert("Copied div content to clipboard");
        }
        else if(window.getSelection) {
            var selection = window.getSelection();
            var range = document.createRange();
            range.selectNodeContents(elm);
            selection.removeAllRanges();
            selection.addRange(range);
            document.execCommand("Copy");
            alert("Copied div content to clipboard");
        }
    }


    /**
     * Enable/disable facebook pixel
     * @param event
     */
    function enable_fb_pixel(event) {
        event.preventDefault();
        var payload = {};
        if($(this).is(":checked")) {
            payload = {
                wpfm_fb_pixel_enabled : 'yes',
            };
        }else {
            payload = {
                wpfm_fb_pixel_enabled : 'no',
            };
        }
        wpAjaxHelperRequest( 'wpfm-enable-fb-pixel', payload )
            .success( function( response ) {
                if(response.data == 'enabled') {
                    $('.wpfm-fb-pixel-field').removeClass('is-hidden');
                }else {
                    $('.wpfm-fb-pixel-field').addClass('is-hidden');
                }
            })
            .error( function( response ) {
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on('change', '#wpfm_fb_pixel', enable_fb_pixel);


    /**
     * Save FB pixel ID
     * @param e
     */
    function save_fb_pixel_id(e) {
        e.preventDefault();
        var $form = $(this);
        $form.find("button.save-fb-pixel span").text("");
        $form.find("button.save-fb-pixel i").show();
        var value = $form.find('#wpfm_fb_pixel').val();
        wpAjaxHelperRequest( 'save-fb-pixel-value', value )
            .success( function( response ) {
                $form.find("button.save-fb-pixel i").hide();
                $form.find("button.save-fb-pixel span").text("saved");
                setTimeout(function(){
                    $form.find("button.save-fb-pixel span").text("save");
                }, 1000);
                console.log('woohoo!');
            })
            .error( function( response ) {
                $form.find("button.ssave-fb-pixel i").hide();
                $form.find("button.save-fb-pixel span").text("failed");
                setTimeout(function(){
                    $form.find("button.save-fb-pixel span").text("save");
                }, 1000);
                console.log( 'uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on("submit", "#wpfm-fb-pixel", save_fb_pixel_id);


    /**
     * Log settings
     */
    function wpfm_enable_log() {
        var payload = {};
        if($(this).is(":checked")) {
            payload = {
                wpfm_enable_log : 'yes',
            };
        }else {
            payload = {
                wpfm_enable_log : 'no',
            };
        }
        wpAjaxHelperRequest( 'rex-enable-log', payload )
            .success( function( response ) {
                console.log('Woohoo!');
            })
            .error( function( response ) {
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on('change', '#wpfm_enable_log', wpfm_enable_log);

})( jQuery );



window.WPFM_Ajaxified_Product_Taxonomies = (function ( window, document, $, undefined ) {
    'use strict';

    var app = {};

    app.cache = function(){
        app.$metabox = $( '#rex_feed_products' );
        app.$select_cat = app.$metabox.find( '#rex_feed_products' );
    };

    app.init = function () {
        app.cache();
        app.$select_cat.on( 'change', app.change_color);
    };

    app.change_color = function( evt ){
        var that = $( this ),
            new_val = that.val();

        if(new_val === 'all') {
            $('.cmb2-id-rex-feed-config-filter-title').hide();
            $('#rex-feed-product-taxonomies').hide();
            $('.cmb2-id-rex-feed-tags-wrapper').hide();
        }else if (new_val === 'filter') {
            $('.cmb2-id-rex-feed-config-filter-title').show();
            $('#rex-feed-product-taxonomies').hide();
        }else if(new_val === 'product_cat' || new_val === 'product_tag') {
            $('.cmb2-id-rex-feed-config-filter-title').hide();
            $('#rex-feed-product-taxonomies').show();
        }

        $(".rex-feed-product-taxonomies-spinner").show();


        if(new_val === 'product_cat' || new_val === 'product_tag') {
            var payload = {
                val: new_val,
                postID : $('#post_ID').val()
            };
            var l10n = window.cmb2_l10;
            wpAjaxHelperRequest( 'fetch-product-taxonomies', payload )
                .success( function( response ) {
                    console.log('Woohoo!');
                    if(response.data.hasContent) {
                        $("#rex-feed-product-taxonomies-contents").html(response.data.html);
                        $( '<p><span class="button-secondary cmb-multicheck-toggle">' + l10n.strings.check_toggle + '</span></p>' ).insertBefore( '.cmb2-checkbox-list:not(.no-select-all)' );
                        l10n.fields[response.data.hash] = response.data.js_data;
                        $(".rex-feed-product-taxonomies-spinner").hide();
                    }
                })
                .error( function( response ) {
                    console.log( 'Uh, oh!' );
                    console.log( response.statusText );
                });
        }


    };

    $( document ).ready( app.init );

    return app;

})( window, document, jQuery );