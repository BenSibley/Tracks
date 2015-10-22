( function( $ ) {

    var panel = $('html', window.parent.document);
    var body = $('body');
    var siteTitle = $('#site-title');
    var tagline = $('.site-description');
    var menuPrimary = $('#menu-primary');
    var footer = $('#site-footer');

    // Site title
    wp.customize( 'blogname', function( value ) {
        value.bind( function( to ) {
            // if there is a logo, don't replace it
            if( siteTitle.find('img').length == 0 ) {
                siteTitle.children('a').text( to );
            }
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

} )( jQuery );