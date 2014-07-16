jQuery(document).ready(function($){

    $(".entry-content").fitVids();
    $(".excerpt-content").fitVids();

    // bind the tap event on the menu icon
    $('#toggle-navigation').bind('click', onTap);

    function onTap() {

        var siteHeader = $('#site-header');
        var menuPrimary = $('#menu-primary');

        if (siteHeader.hasClass('toggled')) {
            siteHeader.removeClass('toggled');
            menuPrimary.css('transform', 'translateX(' + 0 + 'px)');
            $('#menu-primary-tracks').css('transform', 'translateX(' + 0 + 'px)');
            $(window).unbind('scroll');
            // delayed so it isn't seen
            setTimeout(function() {
                menuPrimary.removeAttr('style');
            }, 400);
        } else {
            var menuWidth = menuPrimary.width();
            siteHeader.addClass('toggled');
            menuPrimary.css('transform', 'translateX(' + -menuWidth + 'px)');
            $('#menu-primary-tracks').css('transform', 'translateX(' + menuWidth + 'px)');
            $(window).scroll(onScroll);
        }
    }
    function onScroll() {
        var menuPrimaryItems = $('#menu-primary-items');
        var menuItemsBottom = menuPrimaryItems.offset().top + menuPrimaryItems.height();

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
            var sitePadding = body.width() * 0.0555;

            // get width of site padding-right
            var searchFormWidth = $('#site-header').find('.search-form').width();

            /* transform on a button makes it disappear in webkit, so using left.
            *  Move search-form width left minus site padding plus extra 7px space */
            $('#search-icon').css('left', -searchFormWidth + sitePadding - 7);
        }
    }

    // ===== Show/Hide Customizer Options ==== //

    function displayLayoutOptions(){

        var imageHeightOption = $('html', window.parent.document).find('#customize-control-premium_layouts_full_width_image_height');
        var fullPostOption = $('html', window.parent.document).find('#customize-control-premium_layouts_full_width_full_post');
        var contentDisplayOption = $('html', window.parent.document).find('#customize-control-premium_layouts_two_column_images_content_display');

        imageHeightOption.hide();
        fullPostOption.hide();
        contentDisplayOption.hide();

        // if the layout is set to full-width images, display the image height option
        $('html', window.parent.document).find('#customize-control-premium_layouts_setting option').each(function(){
            if($(this).attr('selected') == 'selected' && $(this).val() == 'full-width-images'){
                imageHeightOption.show();
            }
            if($(this).attr('selected') == 'selected' && $(this).val() == 'full-width'){
                fullPostOption.show();
            }
            if($(this).attr('selected') == 'selected' && $(this).val() == 'two-column-images'){
                contentDisplayOption.show();
            }
        });
    }
    displayLayoutOptions();

    // ===== Two-Column Layout ==== //

    function removeLayoutGaps(){

        if( $('body').hasClass('two-column') || $('body').hasClass('two-column-images')){

            $('.excerpt').each(function(){

                // 40% of the screen over to be safe
                var windowWidth = $(window).width() * 0.4;

                // if it ends of over on the right, float it right
                if($(this).offset().left > windowWidth){
                    $(this).css('float','right');
                } else {
                    // to remove old float: right; on window resize
                    $(this).css('float','left');
                }
            });
        }
    }
    removeLayoutGaps();


    // ===== Full-width Images - create separation between image and post ===== //

    function separatePostImage(){

        if($('.featured-image').width() < $('.featured-image-container').width()){
            $('.featured-image-container').css('padding-bottom', 48);
        } else {
            $('.featured-image-container').css('padding-bottom', 0);
        }
    }
    separatePostImage();

    // ===== Window Resize ===== //

    $(window).on('resize', function(){
        separatePostImage();
        removeLayoutGaps();
    });

    /* ===== IE9 full-width image text positioning ===== */

    function centerContentIE(){

        // only if ie9 and full-width-images layout or two-column-images layout
        if($('html').hasClass('ie9') && ($('body').hasClass('full-width-images') || $('body').hasClass('two-column-images'))){

            $('.excerpt').each(function(){

                // excerpt is container of content-container
                var container = $(this);
                var content = $(this).find('.content-container');

                // if theres a featured-image use .excerpt height, else use .excerpt padding-bottom
                if($(this).hasClass('has-post-thumbnail')){
                    var containerBottom = container.offset().top + container.height();
                } else {
                    var containerBottom = container.offset().top + parseInt(container.css('padding-bottom'));
                }
                // coordinates of bottom of content
                var contentBottom = content.offset().top + content.height();

                // distance of bottom of container - content / 2 gives desired distance from top
                var topDistance = (containerBottom - contentBottom) / 2;

                // add the distance to the top
                $(this).find('.excerpt-container').css('top', topDistance);
            });
        }
    }
    centerContentIE();

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
