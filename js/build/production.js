/*global jQuery */
/*jshint browser:true */
/*!
 * FitVids 1.1
 *
 * Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 */

(function( $ ){

    "use strict";

    $.fn.fitVids = function( options ) {
        var settings = {
            customSelector: null,
            ignore: null,
        };

        if(!document.getElementById('fit-vids-style')) {
            // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement('div');
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }

        if ( options ) {
            $.extend( settings, options );
        }

        return this.each(function(){
            var selectors = [
                "iframe[src*='player.vimeo.com']",
                "iframe[src*='youtube.com']",
                "iframe[src*='youtube-nocookie.com']",
                "iframe[src*='kickstarter.com'][src*='video.html']",
                "object",
                "embed"
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var ignoreList = '.fitvidsignore';

            if(settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }

            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not("object object"); // SwfObj conflict patch
            $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

            $allVideos.each(function(){
                var $this = $(this);
                if($this.parents(ignoreList).length > 0) {
                    return; // Disable FitVids on this video.
                }
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
                if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
                {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if(!$this.attr('id')){
                    var videoID = 'fitvid' + Math.floor(Math.random()*999999);
                    $this.attr('id', videoID);
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );
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
/* 
 * The MIT License
 *
 * Copyright (c) 2012 James Allardice
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), 
 * to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

// Defines the global Placeholders object along with various utility methods
(function (global) {

    "use strict";

    // Cross-browser DOM event binding
    function addEventListener(elem, event, fn) {
        if (elem.addEventListener) {
            return elem.addEventListener(event, fn, false);
        }
        if (elem.attachEvent) {
            return elem.attachEvent("on" + event, fn);
        }
    }

    // Check whether an item is in an array (we don't use Array.prototype.indexOf so we don't clobber any existing polyfills - this is a really simple alternative)
    function inArray(arr, item) {
        var i, len;
        for (i = 0, len = arr.length; i < len; i++) {
            if (arr[i] === item) {
                return true;
            }
        }
        return false;
    }

    // Move the caret to the index position specified. Assumes that the element has focus
    function moveCaret(elem, index) {
        var range;
        if (elem.createTextRange) {
            range = elem.createTextRange();
            range.move("character", index);
            range.select();
        } else if (elem.selectionStart) {
            elem.focus();
            elem.setSelectionRange(index, index);
        }
    }

    // Attempt to change the type property of an input element
    function changeType(elem, type) {
        try {
            elem.type = type;
            return true;
        } catch (e) {
            // You can't change input type in IE8 and below
            return false;
        }
    }

    // Expose public methods
    global.Placeholders = {
        Utils: {
            addEventListener: addEventListener,
            inArray: inArray,
            moveCaret: moveCaret,
            changeType: changeType
        }
    };

}(this));

(function (global) {

    "use strict";

    var validTypes = [
            "text",
            "search",
            "url",
            "tel",
            "email",
            "password",
            "number",
            "textarea"
        ],

    // The list of keycodes that are not allowed when the polyfill is configured to hide-on-input
        badKeys = [

            // The following keys all cause the caret to jump to the end of the input value
            27, // Escape
            33, // Page up
            34, // Page down
            35, // End
            36, // Home

            // Arrow keys allow you to move the caret manually, which should be prevented when the placeholder is visible
            37, // Left
            38, // Up
            39, // Right
            40, // Down

            // The following keys allow you to modify the placeholder text by removing characters, which should be prevented when the placeholder is visible
            8, // Backspace
            46 // Delete
        ],

    // Styling variables
        placeholderStyleColor = "#ccc",
        placeholderClassName = "placeholdersjs",
        classNameRegExp = new RegExp("(?:^|\\s)" + placeholderClassName + "(?!\\S)"),

    // These will hold references to all elements that can be affected. NodeList objects are live, so we only need to get those references once
        inputs, textareas,

    // The various data-* attributes used by the polyfill
        ATTR_CURRENT_VAL = "data-placeholder-value",
        ATTR_ACTIVE = "data-placeholder-active",
        ATTR_INPUT_TYPE = "data-placeholder-type",
        ATTR_FORM_HANDLED = "data-placeholder-submit",
        ATTR_EVENTS_BOUND = "data-placeholder-bound",
        ATTR_OPTION_FOCUS = "data-placeholder-focus",
        ATTR_OPTION_LIVE = "data-placeholder-live",
        ATTR_MAXLENGTH = "data-placeholder-maxlength",

    // Various other variables used throughout the rest of the script
        test = document.createElement("input"),
        head = document.getElementsByTagName("head")[0],
        root = document.documentElement,
        Placeholders = global.Placeholders,
        Utils = Placeholders.Utils,
        hideOnInput, liveUpdates, keydownVal, styleElem, styleRules, placeholder, timer, form, elem, len, i;

    // No-op (used in place of public methods when native support is detected)
    function noop() {}

    // Avoid IE9 activeElement of death when an iframe is used.
    // More info:
    // http://bugs.jquery.com/ticket/13393
    // https://github.com/jquery/jquery/commit/85fc5878b3c6af73f42d61eedf73013e7faae408
    function safeActiveElement() {
        try {
            return document.activeElement;
        } catch (err) {}
    }

    // Hide the placeholder value on a single element. Returns true if the placeholder was hidden and false if it was not (because it wasn't visible in the first place)
    function hidePlaceholder(elem, keydownValue) {
        var type,
            maxLength,
            valueChanged = (!!keydownValue && elem.value !== keydownValue),
            isPlaceholderValue = (elem.value === elem.getAttribute(ATTR_CURRENT_VAL));

        if ((valueChanged || isPlaceholderValue) && elem.getAttribute(ATTR_ACTIVE) === "true") {
            elem.removeAttribute(ATTR_ACTIVE);
            elem.value = elem.value.replace(elem.getAttribute(ATTR_CURRENT_VAL), "");
            elem.className = elem.className.replace(classNameRegExp, "");

            // Restore the maxlength value
            maxLength = elem.getAttribute(ATTR_MAXLENGTH);
            if (parseInt(maxLength, 10) >= 0) { // Old FF returns -1 if attribute not set (see GH-56)
                elem.setAttribute("maxLength", maxLength);
                elem.removeAttribute(ATTR_MAXLENGTH);
            }

            // If the polyfill has changed the type of the element we need to change it back
            type = elem.getAttribute(ATTR_INPUT_TYPE);
            if (type) {
                elem.type = type;
            }
            return true;
        }
        return false;
    }

    // Show the placeholder value on a single element. Returns true if the placeholder was shown and false if it was not (because it was already visible)
    function showPlaceholder(elem) {
        var type,
            maxLength,
            val = elem.getAttribute(ATTR_CURRENT_VAL);
        if (elem.value === "" && val) {
            elem.setAttribute(ATTR_ACTIVE, "true");
            elem.value = val;
            elem.className += " " + placeholderClassName;

            // Store and remove the maxlength value
            maxLength = elem.getAttribute(ATTR_MAXLENGTH);
            if (!maxLength) {
                elem.setAttribute(ATTR_MAXLENGTH, elem.maxLength);
                elem.removeAttribute("maxLength");
            }

            // If the type of element needs to change, change it (e.g. password inputs)
            type = elem.getAttribute(ATTR_INPUT_TYPE);
            if (type) {
                elem.type = "text";
            } else if (elem.type === "password") {
                if (Utils.changeType(elem, "text")) {
                    elem.setAttribute(ATTR_INPUT_TYPE, "password");
                }
            }
            return true;
        }
        return false;
    }

    function handleElem(node, callback) {

        var handleInputsLength, handleTextareasLength, handleInputs, handleTextareas, elem, len, i;

        // Check if the passed in node is an input/textarea (in which case it can't have any affected descendants)
        if (node && node.getAttribute(ATTR_CURRENT_VAL)) {
            callback(node);
        } else {

            // If an element was passed in, get all affected descendants. Otherwise, get all affected elements in document
            handleInputs = node ? node.getElementsByTagName("input") : inputs;
            handleTextareas = node ? node.getElementsByTagName("textarea") : textareas;

            handleInputsLength = handleInputs ? handleInputs.length : 0;
            handleTextareasLength = handleTextareas ? handleTextareas.length : 0;

            // Run the callback for each element
            for (i = 0, len = handleInputsLength + handleTextareasLength; i < len; i++) {
                elem = i < handleInputsLength ? handleInputs[i] : handleTextareas[i - handleInputsLength];
                callback(elem);
            }
        }
    }

    // Return all affected elements to their normal state (remove placeholder value if present)
    function disablePlaceholders(node) {
        handleElem(node, hidePlaceholder);
    }

    // Show the placeholder value on all appropriate elements
    function enablePlaceholders(node) {
        handleElem(node, showPlaceholder);
    }

    // Returns a function that is used as a focus event handler
    function makeFocusHandler(elem) {
        return function () {

            // Only hide the placeholder value if the (default) hide-on-focus behaviour is enabled
            if (hideOnInput && elem.value === elem.getAttribute(ATTR_CURRENT_VAL) && elem.getAttribute(ATTR_ACTIVE) === "true") {

                // Move the caret to the start of the input (this mimics the behaviour of all browsers that do not hide the placeholder on focus)
                Utils.moveCaret(elem, 0);

            } else {

                // Remove the placeholder
                hidePlaceholder(elem);
            }
        };
    }

    // Returns a function that is used as a blur event handler
    function makeBlurHandler(elem) {
        return function () {
            showPlaceholder(elem);
        };
    }

    // Functions that are used as a event handlers when the hide-on-input behaviour has been activated - very basic implementation of the "input" event
    function makeKeydownHandler(elem) {
        return function (e) {
            keydownVal = elem.value;

            //Prevent the use of the arrow keys (try to keep the cursor before the placeholder)
            if (elem.getAttribute(ATTR_ACTIVE) === "true") {
                if (keydownVal === elem.getAttribute(ATTR_CURRENT_VAL) && Utils.inArray(badKeys, e.keyCode)) {
                    if (e.preventDefault) {
                        e.preventDefault();
                    }
                    return false;
                }
            }
        };
    }
    function makeKeyupHandler(elem) {
        return function () {
            hidePlaceholder(elem, keydownVal);

            // If the element is now empty we need to show the placeholder
            if (elem.value === "") {
                elem.blur();
                Utils.moveCaret(elem, 0);
            }
        };
    }
    function makeClickHandler(elem) {
        return function () {
            if (elem === safeActiveElement() && elem.value === elem.getAttribute(ATTR_CURRENT_VAL) && elem.getAttribute(ATTR_ACTIVE) === "true") {
                Utils.moveCaret(elem, 0);
            }
        };
    }

    // Returns a function that is used as a submit event handler on form elements that have children affected by this polyfill
    function makeSubmitHandler(form) {
        return function () {

            // Turn off placeholders on all appropriate descendant elements
            disablePlaceholders(form);
        };
    }

    // Bind event handlers to an element that we need to affect with the polyfill
    function newElement(elem) {

        // If the element is part of a form, make sure the placeholder string is not submitted as a value
        if (elem.form) {
            form = elem.form;

            // If the type of the property is a string then we have a "form" attribute and need to get the real form
            if (typeof form === "string") {
                form = document.getElementById(form);
            }

            // Set a flag on the form so we know it's been handled (forms can contain multiple inputs)
            if (!form.getAttribute(ATTR_FORM_HANDLED)) {
                Utils.addEventListener(form, "submit", makeSubmitHandler(form));
                form.setAttribute(ATTR_FORM_HANDLED, "true");
            }
        }

        // Bind event handlers to the element so we can hide/show the placeholder as appropriate
        Utils.addEventListener(elem, "focus", makeFocusHandler(elem));
        Utils.addEventListener(elem, "blur", makeBlurHandler(elem));

        // If the placeholder should hide on input rather than on focus we need additional event handlers
        if (hideOnInput) {
            Utils.addEventListener(elem, "keydown", makeKeydownHandler(elem));
            Utils.addEventListener(elem, "keyup", makeKeyupHandler(elem));
            Utils.addEventListener(elem, "click", makeClickHandler(elem));
        }

        // Remember that we've bound event handlers to this element
        elem.setAttribute(ATTR_EVENTS_BOUND, "true");
        elem.setAttribute(ATTR_CURRENT_VAL, placeholder);

        // If the element doesn't have a value and is not focussed, set it to the placeholder string
        if (hideOnInput || elem !== safeActiveElement()) {
            showPlaceholder(elem);
        }
    }

    Placeholders.nativeSupport = test.placeholder !== void 0;

    if (!Placeholders.nativeSupport) {

        // Get references to all the input and textarea elements currently in the DOM (live NodeList objects to we only need to do this once)
        inputs = document.getElementsByTagName("input");
        textareas = document.getElementsByTagName("textarea");

        // Get any settings declared as data-* attributes on the root element (currently the only options are whether to hide the placeholder on focus or input and whether to auto-update)
        hideOnInput = root.getAttribute(ATTR_OPTION_FOCUS) === "false";
        liveUpdates = root.getAttribute(ATTR_OPTION_LIVE) !== "false";

        // Create style element for placeholder styles (instead of directly setting style properties on elements - allows for better flexibility alongside user-defined styles)
        styleElem = document.createElement("style");
        styleElem.type = "text/css";

        // Create style rules as text node
        styleRules = document.createTextNode("." + placeholderClassName + " { color:" + placeholderStyleColor + "; }");

        // Append style rules to newly created stylesheet
        if (styleElem.styleSheet) {
            styleElem.styleSheet.cssText = styleRules.nodeValue;
        } else {
            styleElem.appendChild(styleRules);
        }

        // Prepend new style element to the head (before any existing stylesheets, so user-defined rules take precedence)
        head.insertBefore(styleElem, head.firstChild);

        // Set up the placeholders
        for (i = 0, len = inputs.length + textareas.length; i < len; i++) {
            elem = i < inputs.length ? inputs[i] : textareas[i - inputs.length];

            // Get the value of the placeholder attribute, if any. IE10 emulating IE7 fails with getAttribute, hence the use of the attributes node
            placeholder = elem.attributes.placeholder;
            if (placeholder) {

                // IE returns an empty object instead of undefined if the attribute is not present
                placeholder = placeholder.nodeValue;

                // Only apply the polyfill if this element is of a type that supports placeholders, and has a placeholder attribute with a non-empty value
                if (placeholder && Utils.inArray(validTypes, elem.type)) {
                    newElement(elem);
                }
            }
        }

        // If enabled, the polyfill will repeatedly check for changed/added elements and apply to those as well
        timer = setInterval(function () {
            for (i = 0, len = inputs.length + textareas.length; i < len; i++) {
                elem = i < inputs.length ? inputs[i] : textareas[i - inputs.length];

                // Only apply the polyfill if this element is of a type that supports placeholders, and has a placeholder attribute with a non-empty value
                placeholder = elem.attributes.placeholder;
                if (placeholder) {
                    placeholder = placeholder.nodeValue;
                    if (placeholder && Utils.inArray(validTypes, elem.type)) {

                        // If the element hasn't had event handlers bound to it then add them
                        if (!elem.getAttribute(ATTR_EVENTS_BOUND)) {
                            newElement(elem);
                        }

                        // If the placeholder value has changed or not been initialised yet we need to update the display
                        if (placeholder !== elem.getAttribute(ATTR_CURRENT_VAL) || (elem.type === "password" && !elem.getAttribute(ATTR_INPUT_TYPE))) {

                            // Attempt to change the type of password inputs (fails in IE < 9)
                            if (elem.type === "password" && !elem.getAttribute(ATTR_INPUT_TYPE) && Utils.changeType(elem, "text")) {
                                elem.setAttribute(ATTR_INPUT_TYPE, "password");
                            }

                            // If the placeholder value has changed and the placeholder is currently on display we need to change it
                            if (elem.value === elem.getAttribute(ATTR_CURRENT_VAL)) {
                                elem.value = placeholder;
                            }

                            // Keep a reference to the current placeholder value in case it changes via another script
                            elem.setAttribute(ATTR_CURRENT_VAL, placeholder);
                        }
                    }
                } else if (elem.getAttribute(ATTR_ACTIVE)) {
                    hidePlaceholder(elem);
                    elem.removeAttribute(ATTR_CURRENT_VAL);
                }
            }

            // If live updates are not enabled cancel the timer
            if (!liveUpdates) {
                clearInterval(timer);
            }
        }, 100);
    }

    Utils.addEventListener(global, "beforeunload", function () {
        Placeholders.disable();
    });

    // Expose public methods
    Placeholders.disable = Placeholders.nativeSupport ? noop : disablePlaceholders;
    Placeholders.enable = Placeholders.nativeSupport ? noop : enablePlaceholders;

}(this));