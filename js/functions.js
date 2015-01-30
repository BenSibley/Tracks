jQuery(function($){

    $('.entry-content, .excerpt-content, .featured-video').fitVids();

    // bind the tap event on the menu icon
    $('#toggle-navigation').bind('click', onTap);

    function onTap() {

        var siteHeader = $('#site-header');
        var menuPrimary = $('#menu-primary');

        if($('#menu-primary-items').length){
            var menuHeight = $('#menu-primary-items').height();
        } else {
            var menuHeight = $('.menu-unset').height();
        }

        if (siteHeader.hasClass('toggled')) {
            siteHeader.removeClass('toggled');
            menuPrimary.css('transform', 'translateX(' + 0 + 'px)');
            $('#menu-primary-tracks').css('transform', 'translateX(' + 0 + 'px)');
            $(window).unbind('scroll');
            // delayed so it isn't seen
            setTimeout(function() {
                menuPrimary.removeAttr('style');
                $('.overflow-container').removeAttr('style');
            }, 400);
        } else {
            var menuWidth = menuPrimary.width();
            siteHeader.addClass('toggled');
            menuPrimary.css('transform', 'translateX(' + -menuWidth + 'px)');
            $('#menu-primary-tracks').css('transform', 'translateX(' + menuWidth + 'px)');
            $('.overflow-container').css('min-height', menuHeight + 240); // if page is shorter than menu, extend to fit menu
            $(window).scroll(onScroll);
        }
    }
    function onScroll() {

        if($('#menu-primary-items').length){
            var menuPrimaryItems = $('#menu-primary-items');
        } else {
            var menuPrimaryItems = $('.menu-unset');
        }

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
            $('#search-icon').css('left', -searchFormWidth + sitePadding - 5);
        }
    }

    // ===== Show/Hide Customizer Options ==== //

    function displayLayoutOptions(){

        var imageHeightOption = $('html', window.parent.document).find('#customize-control-premium_layouts_full_width_image_height');
        var imageHeightPostOption = $('html', window.parent.document).find('#customize-control-premium_layouts_full_width_image_height_post');
        var imageStyleOption = $('html', window.parent.document).find('#customize-control-premium_layouts_full_width_image_style');
        var fullPostOption = $('html', window.parent.document).find('#customize-control-premium_layouts_full_width_full_post');
        var contentDisplayOption = $('html', window.parent.document).find('#customize-control-premium_layouts_two_column_images_content_display');

        imageHeightOption.hide();
        imageHeightPostOption.hide();
        imageStyleOption.hide();
        fullPostOption.hide();
        contentDisplayOption.hide();

        // if the layout is set to full-width images, display the image height option
        $('html', window.parent.document).find('#customize-control-premium_layouts_setting option').each(function(){
            if($(this).attr('selected') == 'selected' && $(this).val() == 'full-width-images'){
                imageHeightOption.show();
                imageStyleOption.show();
                imageHeightPostOption.show();
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

    // ===== Full-width Images - create separation between image and post ===== //

    function separatePostImage(){

        if($('.featured-image').width() < $('.featured-image-container').width()){
            $('.featured-image-container').css('padding-bottom', 48);
        } else {
            $('.featured-image-container').css('padding-bottom', 0);
        }
    }

    // wait until image loaded
    $(window).bind('load', function() {
        separatePostImage();
    });

    // ===== Window Resize ===== //

    $(window).on('resize', function(){
        separatePostImage();
        videoHeightAdjust();

        if( $(window).width() > 799 && $('#site-header').hasClass('toggled') ) {
            onTap();
        }
    });

    /* ===== IE9 full-width image text positioning ===== */

    function centerContentIE(){

        // only if ie9 and full-width-images layout or two-column-images layout
        if($('html').hasClass('ie9') && ($('body').hasClass('full-width-images') || $('body').hasClass('two-column-images'))){

            $('.excerpt-container').each(function(){

                // excerpt is container of content-container
                var container = $(this);
                var content = $(this).find('.excerpt-header');

                var containerBottom = container.offset().top + container.height();

                // coordinates of bottom of content
                var contentBottom = content.offset().top + content.height();

                // distance of bottom of container - content / 2 gives desired distance from top
                var topDistance = (containerBottom - contentBottom) / 2;

                // add the distance to the top
                content.css('top', topDistance);

            });
        }
    }
    centerContentIE();

    /* lazy load images */
    function lazyLoadImages(){

        $('.lazy').each(function(){
            var distanceToTop = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();

            // distance from top plus 100 px to help it load a bit earlier to avoid FOUC and b/c only checked every 400ms
            var isVisible = distanceToTop - scroll - 100 < windowHeight;
            if (isVisible) {

                if( $(this).hasClass('lazy-image') ){
                    $(this).attr('src', $(this).attr('data-src')).removeClass('lazy-image');
                }
                if( $(this).hasClass('lazy-bg-image') ){
                    $(this).css('background-image', 'url("' + $(this).attr('data-background') + '")').removeClass('lazy-bg-image');
                }
            }
        });
    }
    lazyLoadImages();

    var scrollHandling = {
        allow: true,
        reallow: function() {
            scrollHandling.allow = true;
        },
        delay: 100 //(milliseconds) adjust to the highest acceptable value
    };
    $(window).scroll(function() {

        if(scrollHandling.allow) {
            lazyLoadImages();
            scrollHandling.allow = false;
            setTimeout(scrollHandling.reallow, scrollHandling.delay);
        }
    });

    // reapply closed class for touch device usage
    // doesn't have any impact unless 'touchstart' fired
    function reApplyClosedClass(e) {

        var container = $('.menu-item-has-children');

        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            container.addClass('closed');
        }
    }
    $(document).on('click', reApplyClosedClass);

    // reposition the description if a logo is present
    function positionSiteDescription(){

        var logo = $('#site-header').find('.logo');

            // if screen is 800px+ wide
            if( $(window).width() > 799 ) {

                // if there is a logo
                if( logo.length ) {

                    // get the logo height
                    var logoHeight = logo.height();

                    // if logo hasn't loaded yet, wait 1000ms
                    if( logoHeight == 0 ) {
                        setTimeout( function(){
                            $(".site-description").css('top', logoHeight - 25 );
                        }, 1000 )
                    } else {
                        // adjust the description placement accordingly
                        $(".site-description").css('top', logoHeight - 25 );
                    }
                }
            }
    }
    positionSiteDescription();


    // get videos on the blog to better fit with the standard layout
    function videoHeightAdjust() {

        // only if side-by-side layout active
        if( $(window).width() > 899 ) {

            // only if standard layout
            if( $('body').hasClass('standard') ) {

                // foreach excerpt with a video
                $('.excerpt.has-video').each( function() {

                    // get the video height
                    var videoHeight = $(this).find('.fluid-width-video-wrapper').outerHeight();

                    // set excerpt min-height to the video's height
                    $(this).css('min-height', videoHeight );

                    // get current height of excerpt content
                    var contentHeight = $(this).find('.excerpt-container').outerHeight();

                    if( videoHeight > contentHeight ) {
                        var difference = (videoHeight - contentHeight) / 2;
                    } else {
                        var difference = 0;
                    }

                    var padding = difference + 'px 5.55%';

                    // center excerpt container
                    $(this).find('.excerpt-container').css('padding', padding );
                });
            }
        }
    }
    videoHeightAdjust();

    // adjust height to fit footer into viewport instead of keeping it just out of view
    function adjustSiteHeight() {

        var footerHeight = $('#site-footer').outerHeight();

        $('body').css('height', 'calc(100% - ' + footerHeight + 'px)');
    }
    adjustSiteHeight();

});

jQuery(window).load(function(){

    var $ = jQuery;

    // ===== Two-Column Layout ==== //

    function removeLayoutGaps(){

        // if wide enough for two-column layout
        if($(window).width() > 899){

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
        // otherwise, remove inline styles in case screen shrunk from >900 to <900
        else {
            $('.excerpt').removeAttr('style');
        }
    }
    removeLayoutGaps();

    // ===== Window Resize ===== //

    $(window).on('resize', function(){
        removeLayoutGaps();
    });

});

// wait to see if a touch event is fired
var hasTouch;
window.addEventListener('touchstart', setHasTouch, false );

// require a double-click on parent dropdown items
function setHasTouch() {

    hasTouch = true;

    // Remove event listener once fired
    window.removeEventListener('touchstart', setHasTouch);

    // get the width of the window
    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth;


    // don't require double clicks for the toggle menu
    if (x > 799) {
        enableTouchDropdown();
    }
}

// require a second click to visit parent navigation items
function enableTouchDropdown(){

    // get all the parent menu items
    var menuParents = document.getElementsByClassName('menu-item-has-children');

    // add a 'closed' class to each and add an event listener to them
    for (i = 0; i < menuParents.length; i++) {
        menuParents[i].className = menuParents[i].className + " closed";
        menuParents[i].addEventListener('click', openDropdown);
    }
}

// check if an element has a class
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

// open the dropdown without visiting parent link
function openDropdown(e){

    // if has 'closed' class...
    if(hasClass(this, 'closed')){
        // prevent link from being visited
        e.preventDefault();
        // remove 'closed' class to enable link
        this.className = this.className.replace('closed', '');
    }
}


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
