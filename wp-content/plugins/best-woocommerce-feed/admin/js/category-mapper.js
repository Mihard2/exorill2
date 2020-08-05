




jQuery(document).ready(function($){

    $(function() {
        var $payload = {};
        wpAjaxHelperRequest( 'rex-wpfm-fetch-google-category', $payload )
            .success( function( data ) {
                var googleCatArray = $.parseJSON(data);
                var dataCountry = {};
                // for (var i = 0; i < googleCatArray.length; i++) {
                //     dataCountry[googleCatArray[i]]= null;
                // }
                $('.category-suggest').autocomplete({
                    source: googleCatArray,
                    classes: {
                        "ui-autocomplete": "category-map"
                    },
                    position: { my : "right top", at: "right bottom", collision: "flip" },
                    minLength: 3
                });
            })
            .error( function( res ) {
                console.log( 'Uh, oh!' );
                console.log( res.statusText );
            });
    });


    /**
     * Function for updating select and input box name
     * attribute under a table-row.
     * duplicate of old one
     */
    function updateFormNameAtts( $row, rowId){
        var name, $el;
        $el = $row.find('input, select');
        $el.each(function(index, item) {
            name = $(item).attr('name');

            if ( name != undefined ) {
                name = name.replace(/^category-map\[\d+\]/, 'category-map[' + rowId + ']');
                $(item).attr('name', name);

            }

        });
    }



    /**
     * Category Map Save
     */
    function category_mapping(event) {
        event.preventDefault();
        var $payload = {
            map_name: $('#map_name').val(),
            cat_map: $('.add_cat_map').serialize(),
        };
        console.log($('.add_cat_map').serialize())
        if ($('#map_name').val().length != 0){
            $('.rex-loading-spinner').css('display', 'flex');
            wpAjaxHelperRequest( 'category-mapping', $payload )
                .success( function( response ) {
                    $('.rex-loading-spinner').css('display', 'none');
                    setTimeout(function(){// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 1000);
                    console.log( 'Woohoo!' );
                })
                .error( function( response ) {
                    console.log( 'Uh, oh!' );
                    console.log( response.statusText );
                });
        }else {
            alert('Please Insert Category Map Name')
        }
        return false;

    }
    $(document).on('click', '#save_mapping_cat', category_mapping);


    /**
     * Category Map Update
     */
    function category_mapping_update(event) {
        event.preventDefault();
        var form = $(this).closest('form');
        var container = $(this).closest('.acordion-item');
        var map_name = container.find('.mapper_name_update');
        var $payload = {
            map_name: map_name.text(),
            cat_map: form.serialize(),
            map_key: map_name.attr('data-id')
        };
        $('.rex-loading-spinner').css('display', 'flex');
        wpAjaxHelperRequest( 'category-mapping-update', $payload )
            .success( function( response ) {
                $('.rex-loading-spinner').css('display', 'none');
                console.log( 'Woohoo!' );
            })
            .error( function( response ) {
                $('.rex-loading-spinner').css('display', 'none');
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });
    }
    $(document).on('click', '#update_mapping_cat', category_mapping_update);



    /**
     * Category Map Delete
     */
    function delete_mapping(event) {
        event.preventDefault();
        var container = $(this).closest('.acordion-item');
        var map_name = container.find('.mapper_name_update');
        var $payload = {
            map_key: map_name.attr('data-id')
        };
        $('.rex-loading-spinner').css('display', 'flex');
        wpAjaxHelperRequest( 'category-mapping-delete', $payload )
            .success( function( response ) {
                $('.rex-loading-spinner').css('display', 'none');
                container.fadeOut();
            })
            .error( function( response ) {
                $('.rex-loading-spinner').css('display', 'none');
                console.log( 'Uh, oh!' );
                console.log( response.statusText );
            });

    }
    $(document).on('click', '#delete_mapping_cat', delete_mapping);


    /**
     * Add row to category map
     */
    $(document).on('click', '.rex-new-cat', function () {
        var rowId = $(this).siblings('.cat-map').find('tbody tr').length;
        var lastrow = $(this).siblings('.cat-map').find('tbody tr:last');
        var parent = $(this).siblings('.cat-map').parent();
        var parent_table = $(this).siblings('.cat-map');

        $(this).siblings('.cat-map').find('tbody tr:first')
            .clone()
            .insertAfter(lastrow)
            .attr('data-row-id', rowId);

        var $row = $(this).siblings('.cat-map').find("[data-row-id='" + rowId + "']");
        $row.find('ul.dropdown-content.select-dropdown, .caret, .select-dropdown ').remove();
        $row.find('input, select').val('');
        $(parent_table).find(".trow:last").find('.easy-autocomplete').remove();
        $(parent_table).find(".trow:last").find('.input-map').append('<input class="category-suggest" type="text" name="category-map[0][map-value]" data-value="">');
        updateFormNameAtts( $row, rowId);
        $(parent_table).find(".trow:last").find('.category-suggest:last').easyAutocomplete(options);
        $row.find('select').formSelect();
    });



    /**
     * Delete a table-row and update all row-id
     * beneath it and their input attributes names.
     * Duplicate of main
     */
    $(document).on('click', '.cat-map .delete', function () {
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
            $nextRows = $('.cat-map tbody').children();
        }else{
            $nextRows = $('.cat-map').find("[data-row-id='" + (rowId -1) + "']").nextAll('tr');
        }

        // Update their row-id and name attributes
        $nextRows.each( function (index, el) {
            $(el).attr( 'data-row-id', rowId);
            updateFormNameAtts( $(el), rowId, filter);
            rowId++;
        });
    });



    function category_mapper_accordion(event) {
        $(this).slideDown(500);
        var this_a = $(this);
        $('.acordion-item h6 a').not(this_a).removeClass('selected');
        $(this).toggleClass('selected');

        var this_inner = $(this).parent().next();


        $(this).parent().next().slideToggle(function() {
            $(".inner").not(this_inner).slideUp();
        });
        return false;
    }
    $(document).on('click', '.rex-accordion h6 a', category_mapper_accordion);

}); 