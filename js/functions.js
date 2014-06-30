jQuery(document).ready(function($){

    $(".entry-content").fitVids();

    // bind the tap event on the menu icon
    // no longer using tappy.js b/c didn't work when production.min.js loaded asynchronously
    $('#toggle-navigation').bind('click', onTap);

    function onTap() {

        if ($('#site-header').hasClass('toggled')) {
            $('#site-header').removeClass('toggled')
            $('#menu-primary').css('transform', 'translateX(' + 0 + 'px)');
            $('#menu-primary-tracks').css('transform', 'translateX(' + 0 + 'px)');
            $(window).unbind('scroll');
            // delayed so it isn't seen
            setTimeout(function() {
                $('#menu-primary').removeAttr('style');
            }, 400);
        } else {
            var menuWidth = $('#menu-primary').width();
            $('#site-header').addClass('toggled')
            $('#menu-primary').css('transform', 'translateX(' + -menuWidth + 'px)');
            $('#menu-primary-tracks').css('transform', 'translateX(' + menuWidth + 'px)');
            $(window).scroll(onScroll);
        }
    }
    function onScroll() {
        var menuItemsBottom = $('#menu-primary-items').offset().top + $('#menu-primary-items').height();

        // keep updating var on scroll
        var topDistance = $(window).scrollTop();
        if (topDistance > menuItemsBottom) {
            $(window).unbind('scroll');
            onTap();
        }
    }
    function positionPostMeta() {
        /* give space for vertical margins, 'categories', and 'tags' */
        var minHeight = 168;
        var availableSpace = $('.entry-content').height();
        var categoryChildren = $(".entry-categories a").length;
        var tagChildren = $(".entry-tags a").length;
        var height = minHeight + (categoryChildren * 24) + (tagChildren * 24);

        if(availableSpace > height){
            $('.entry-meta-bottom').addClass('float');
            var categoriesHeight = $('.entry-categories').height();
            $('.entry-tags').css('top', 72 + categoriesHeight);
        }
    }
    positionPostMeta();

    /* allow keyboard access/visibility for dropdown menu items */
    $('.menu-item a, .page_item a').focus(function(){
        $(this).parent('li').addClass('focused');
        $(this).parents('ul').addClass('focused');
    });
    $('.menu-item a, .page_item a').focusout(function(){
        $(this).parent('li').removeClass('focused');
        $(this).parents('ul').removeClass('focused');
    });

    // ===== Scroll to Top ==== //

    $(window).scroll(function() {
        if ($(this).scrollTop() >= 600) {        // If page is scrolled more than 50px
            $('#return-top').addClass('visible');    // Fade in the arrow
        } else {
            $('#return-top').removeClass('visible');   // Else fade out the arrow
        }
    });
    $('#return-top').click(function(e) {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 800);
    });

    // bind the click event on the secondary menu icon
    $('#toggle-secondary-navigation').bind('click', openSecondaryMenu);

    function openSecondaryMenu() {

        var body = $('body');

        if (body.hasClass('secondary-toggle')) {
            body.removeClass('secondary-toggle');
            $('#main, #title-info, #toggle-navigation').css('transform','translateY(0)');
        } else {
            body.addClass('secondary-toggle');
            var menuHeight = $('#menu-secondary-items').height() + 48;
            $('#main, #title-info, #toggle-navigation').css('transform','translateY(' + menuHeight + 'px)');
        }
    }

    // bind the click event on the search icon
    $('#search-icon').bind('click', openSearchBar);

    function openSearchBar() {

        var body = $('body');

        if (body.hasClass('search-open')) {
            body.removeClass('search-open');
            $('#search-icon').css('left', 0);
        } else {
            body.addClass('search-open');

            // get the width of the search bar
            var sitePadding = $('body').width() * 0.0555;

            // get width of site padding-right
            var searchFormWidth = $('#site-header').find('.search-form').width();

            /* transform on a button makes it disappear in webkit, so using left.
            *  Move search-form width left minus site padding plus extra 7px space */
            $('#search-icon').css('left', -searchFormWidth + sitePadding - 7);
        }
    }

});

/* fix for skip-to-content link bug in Chrome & IE9 */
window.addEventListener("hashchange", function(event) {

    var element = document.getElementById(location.hash.substring(1));

    if (element) {

        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
        }

        element.focus();
    }

}, false);
