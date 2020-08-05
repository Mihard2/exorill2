'use strict';
(function ($) {
    var body = $('body');
    var masthead   = $('#masthead');
    var menuToggle = $('.menu-toggle');
    var offcanvas  = $('#opal-canvas-menu');

    // Return early if menuToggle is missing.
    if (!menuToggle.length) {
        return;
    }

    // Add an initial value for the attribute.
    menuToggle.attr('aria-expanded', 'false');

    body.on('click', '.opal-overlay', function () {
        $('body .opal-wrapper').removeClass('opal-canvas-open');
    });
    body.on('click', '.menu-toggle' ,function () {
        var $body = $('body .opal-wrapper');
        if ($body.hasClass('opal-canvas-open')) {
            $body.removeClass('opal-canvas-open').css('height', '');
        } else {
            $body.addClass('opal-canvas-open').css('height', $body.attr('canvas-height'));
        }
    });

    offcanvas.find('.menu-canvas-default .menu-item-has-children > .sub-menu').before('<button class="dropdown-toggle"><i class="fa fa-angle-down"></i></button>')

    offcanvas.find('button.dropdown-toggle').on('click', function (event) {
        event.preventDefault();
        var $this   = $(this);
        var $parent = $this.closest('.menu-item');
        var $container = $this.closest('ul');
        if($parent.hasClass('menu-open')){
            $parent.removeClass('menu-open');
        }else{
            $container.find('>li.menu-item').removeClass('menu-open');
            $parent.addClass('menu-open');
        }
    });

})(jQuery);