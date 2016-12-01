jQuery(function($){

    // set variables
    var siteHeader = $('#site-header');
    var menuPrimary = $('#menu-primary');
    var menuPrimaryTracks = $('#menu-primary-tracks');
    var primaryMenu = $('.menu-unset');
    if( $('#menu-primary-items').length){
        primaryMenu = $('#menu-primary-items');
    }
    var body = $('body');
    var main = $('#main');
    var loop = $('#loop-container');
    var overflowContainer = $('#overflow-container');
    var titleInfo = $('#title-info');

    positionPostMeta();
    centerContentIE();
    lazyLoadImages();
    positionSiteDescription();
    videoHeightAdjust();
    adjustSiteHeight();

    $(window).load(function(){
        removeLayoutGaps();
        separatePostImage();
    });

    $(window).on('resize', function(){
        separatePostImage();
        videoHeightAdjust();
        removeLayoutGaps();

        if( window.innerWidth > 799 && $('#site-header').hasClass('toggled') ) {
            onTap();
        }
    });

    $('.entry-content, .excerpt-content').fitVids({
        customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="wordpress.tv"]'
    });
    $('.featured-video').fitVids({
        customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="vine.co"], iframe[src*="wordpress.tv"], iframe[src*="soundcloud.com"], iframe[src*="wistia.net"]'
    });

    // Jetpack infinite scroll event that reloads posts. Reapply fitvids to new featured videos
    $( document.body ).on( 'post-load', function () {

        $('.featured-video').fitVids({
            customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="vine.co"], iframe[src*="wordpress.tv"], iframe[src*="soundcloud.com"], iframe[src*="wistia.net"]'
        });
        removeLayoutGaps();
    } );

    // bind the tap event on the menu icon
    $('#toggle-navigation').bind('click', onTap);

    function onTap() {

        // get height of primary menu
        var menuHeight = primaryMenu.height();

        // if menu already open
        if (siteHeader.hasClass('toggled')) {

            // remove class
            siteHeader.removeClass('toggled');

            // stop watching scroll to auto-close menu
            $(window).unbind('scroll');

            // delayed so it isn't seen
            setTimeout(function() {
                // remove the remaining translateX(0px)
                menuPrimary.removeAttr('style');
                // remove min-height added
                overflowContainer.removeAttr('style');
            }, 400);

        }
        // if menu not open already
        else {

            // get width of primary menu
            var menuWidth = menuPrimary.width();

            // add class
            siteHeader.addClass('toggled');

            // if page is shorter than menu, extend to fit menu
            overflowContainer.css('min-height', menuHeight + 240);

            menuPrimary.css('padding-top', titleInfo.height() + titleInfo.position().top );
            menuPrimaryTracks.css('padding-top', $('#title-info').height() + 48);

            // watch scroll to auto-close the menu if visitor scrolls past it
            $(window).scroll(onScroll);
        }
    }
    function onScroll() {

        var menuItemsBottom = primaryMenu.offset().top + primaryMenu.height();

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

        if (body.hasClass('secondary-toggle')) {
            body.removeClass('secondary-toggle');
            $('#main, #title-info, #toggle-navigation, #site-footer').css('transform','translateY(0)');
            body.css('height', 'auto');
        } else {
            body.addClass('secondary-toggle');
            var menuHeight = $('#menu-secondary-items').height() + 48;
            $('#main, #title-info, #toggle-navigation, #site-footer').css('transform','translateY(' + menuHeight + 'px)');
            body.css('height', body.outerHeight() + menuHeight + 'px');
        }
    }

    // bind the click event on the search icon
    $('#search-icon').bind('click', openSearchBar);

    function openSearchBar() {

        if (body.hasClass('search-open')) {
            body.removeClass('search-open');
            $('#search-icon').css('left', 0);
        } else {
            body.addClass('search-open');

            // get the width of the search bar
            var sitePadding = body.width() * 0.0555;

            // get width of site padding-right
            var searchFormWidth = siteHeader.find('.search-form').width();

            /* transform on a button makes it disappear in webkit, so using left.
            *  Move search-form width left minus site padding plus extra 7px space */
            $('#search-icon').css('left', -searchFormWidth + sitePadding - 5);
        }
    }

    // ===== Full-width Images - create separation between image and post ===== //

    function separatePostImage(){

        if($('.featured-image').width() < $('.featured-image-container').width()){
            $('.featured-image-container').css('padding-bottom', 48);
        } else {
            $('.featured-image-container').css('padding-bottom', 0);
        }
    }

    /* ===== IE9 full-width image text positioning ===== */

    function centerContentIE(){

        // only if ie9 and full-width-images layout or two-column-images layout
        if($('html').hasClass('ie9') && (body.hasClass('full-width-images') || body.hasClass('two-column-images'))){

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

    // reposition the description if a logo is present
    function positionSiteDescription(){

        var logo = siteHeader.find('.logo');

        // if screen is 800px+ wide
        if( window.innerWidth > 799 ) {

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


    // get videos on the blog to better fit with the standard layout
    function videoHeightAdjust() {

        // only if side-by-side layout active
        if( window.innerWidth > 899 ) {

            // only if standard layout
            if( body.hasClass('standard') ) {

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

    // adjust height to fit footer into viewport instead of keeping it just out of view
    function adjustSiteHeight() {
        var footerHeight = $('#site-footer').outerHeight();
        body.css('height', 'calc(100% - ' + footerHeight + 'px)');
    }

    function removeLayoutGaps(){

        if( window.innerWidth > 899 ) {

            if( body.hasClass('two-column') || body.hasClass('two-column-images')) {

                // move any posts in infinite wrap to main
                $('.infinite-wrap').children('.excerpt').detach().appendTo( loop );
                $('.infinite-wrap, .infinite-loader').remove();

                var entry = loop.find('.excerpt');

                // set counter
                var counter = 1;

                // for each post...
                entry.each(function () {

                    // prevent entry's from being re-sorted
                    if ( $(this).hasClass('sorted') ) {
                        counter++;
                        return;
                    } else {
                        $(this).addClass('sorted');
                    }

                    if (counter == 2) {
                        $(this).addClass('right');
                    }

                    if (counter > 2) {

                        // get prev entry
                        var prev = $(this).prev();

                        // 2 entries ago
                        var prevPrev = $(this).prev().prev();

                        var prevBottom = Math.ceil(prev.offset().top + prev.outerHeight());
                        var prevPrevBottom = Math.ceil(prevPrev.offset().top + prevPrev.outerHeight());

                        if (prev.hasClass('right')) {
                            var prevFloat = 'right';
                            var prevPrevFloat = 'left';
                        } else {
                            var prevFloat = 'left';
                            var prevPrevFloat = 'right';
                        }
                        // float towards previous
                        if (prevBottom < prevPrevBottom) {
                            $(this).addClass(prevFloat);
                        }
                        // float towards 2 entries ago
                        else {
                            $(this).addClass(prevPrevFloat);
                        }
                    }
                    counter++;
                });
            }
        }
    }

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