( function( $ ) {

    var panel = $('html', window.parent.document);
    var body = $('body');
    var siteTitle = $('#site-title');
    var tagline = $('.site-description');
    var menuPrimary = $('#menu-primary');
    var footer = $('#site-footer');
    var inlineStyles = $('#ct-tracks-style-inline-css');

    // Site title
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // if there is a logo, don't replace it
            if( siteTitle.find('img').length == 0 ) {
                siteTitle.children('a').text( to );
            }
            footer.children('h3').children('a').text( to );
        } );
    } );

    // Tagline
    wp.customize( 'blogdescription', function( value ) {
        value.bind( function( to ) {
            var tagline = $('.site-description');
            var taglineDisplay = panel.find('#customize-control-tagline_display_setting').find('input:checked').val()
            if( tagline.length == 0 ) {
                if ( taglineDisplay == 'header-footer' ) {
                    menuPrimary.prepend('<p class="site-description"></p>');
                    footer.children('h3').after('<p class="site-description"></p>');
                } else if ( taglineDisplay == 'header' ) {
                    menuPrimary.prepend('<p class="site-description"></p>');
                } else if ( taglineDisplay == 'footer' ) {
                    footer.children('h3').after('<p class="site-description"></p>');
                }
            }
            tagline.text( to );
        } );
    } );

    // Custom CSS

    // get current Custom CSS
    var setting = 'ct_tracks_custom_css_setting';
    var customCSS = panel.find('#customize-control-ct_tracks_custom_css_setting').find('textarea').val();

    if ( panel.find('#sub-accordion-section-custom_css').length ) {
        setting = 'custom_css[tracks]';
        customCSS = panel.find('#customize-control-custom_css').find('textarea').val();
    }

    // get the CSS in the inline element
    var allCSS = inlineStyles.text();

    // remove the Custom CSS from the other CSS
    allCSS = allCSS.replace(customCSS, '');

    // update the CSS in the inline element w/o the custom css
    inlineStyles.text(allCSS);

    // add custom CSS to its own style element
    body.append('<style id="style-inline-custom-css" type="text/css">' + customCSS + '</style>');

    // Custom CSS
    wp.customize( setting, function( value ) {
        value.bind( function( to ) {
            $('#style-inline-custom-css').remove();
            if ( to != '' ) {
                to = '<style id="style-inline-custom-css" type="text/css">' + to + '</style>';
                body.append( to );
            }
        } );
    } );

} )( jQuery );