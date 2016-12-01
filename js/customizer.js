jQuery(document).ready(function($) {

    // set context to customizer panel outside iframe site content is in
    var panel = $('html', window.parent.document);

    // add multiple select styling
    $('#comment-display-control').multipleSelect({
        selectAll: false
    });

    // hide the display none option
    $.each($('.ms-drop.bottom').find('li'), function(){

        if( $(this).find('input').val() == 'none' ) {
            $(this).hide();
        }
    });

    addLayoutThumbnails();
    ctHideNoneText();
    displayLayoutOptions();
    hideFallbackImageControl();

    // show/hide additional layout options
    panel.find('#customize-control-additional_options_no_featured_image').find('input').bind('change', hideFallbackImageControl );

    // show/hide fallback featured image control
    panel.find('#customize-control-premium_layouts_setting').find('select').bind('change', displayLayoutOptions );

    $('.ms-drop.bottom').find('li').bind('click', ctHideNoneText);

    // move control descriptions for certain sections (advertisements) below the control
    $('#customize-control-premium_layouts_setting').find('.customize-control-description').appendTo( '#customize-control-premium_layouts_setting' ).css('margin-top', '12px');

    // replaces radio buttons with images
    function addLayoutThumbnails() {

        // get layout inputs
        var textureInputs = panel.find('#customize-control-ct_tracks_background_texture_setting').find('input');

        // add the appropriate image to each label
        textureInputs.each( function() {

            if ( $('#accordion-panel-ct_tracks_pro_colors_panel').length ) {
                $(this).parent().css('background-image', 'url("../wp-content/plugins/tracks-pro/assets/images/textures/' + $(this).val() + '.png")');
            } else {
                $(this).parent().css('background-image', 'url("../wp-content/plugins/tracks-background-textures/textures/' + $(this).val() + '.png")');
            }

            // add initial 'selected' class
            if ($(this).prop('checked')) {
                $(this).parent().addClass('selected');
            }
        });

        // watch for change of inputs (layouts)
        panel.on('click', '#customize-control-ct_tracks_background_texture_setting input', function () {
            addSelectedLayoutClass(textureInputs, $(this));
        });
    }

    // add the 'selected' class when a new input is selected
    function addSelectedLayoutClass(inputs, target) {

        // remove 'selected' class from all labels
        inputs.parent().removeClass('selected');

        // apply 'selected' class to :checked input
        if (target.prop('checked')) {
            target.parent().addClass('selected');
        }
    }

    // Don't show the do not show text
    function ctHideNoneText() {

        // hide the "Do not show" text from the list of selected options
        $('.ms-choice span:contains("Do not show")').each(function(){

            // remove the text
            $(this).html($(this).html().split("Do not show").join(""));

            // remove trailing commas left over
            if( $(this).html().trim().slice(-1) == ',' ) {
                $(this).html( $(this).html().trim().slice(0, -1) );
            }
            // text to display instead if empty
            if (!$(this).text().trim().length) {
                $(this).text("Comments not displaying");
            }
        });
    }

    function displayLayoutOptions(){

        var imageHeightOption = panel.find('#customize-control-premium_layouts_full_width_image_height');
        var imageHeightPostOption = panel.find('#customize-control-premium_layouts_full_width_image_height_post');
        var imageStyleOption = panel.find('#customize-control-premium_layouts_full_width_image_style');
        var fullPostOption = panel.find('#customize-control-premium_layouts_full_width_full_post');
        var contentDisplayOption = panel.find('#customize-control-premium_layouts_two_column_images_content_display');

        imageHeightOption.removeClass('show');
        imageStyleOption.removeClass('show');
        imageHeightPostOption.removeClass('show');
        fullPostOption.removeClass('show');
        contentDisplayOption.removeClass('show');

        // if the layout is set to full-width images, display the image height option
        panel.find('#customize-control-premium_layouts_setting option').each(function(){
            if($(this).attr('selected') == 'selected' && $(this).val() == 'full-width-images'){
                imageHeightOption.addClass('show');
                imageStyleOption.addClass('show');
                imageHeightPostOption.addClass('show');
            }
            if($(this).attr('selected') == 'selected' && $(this).val() == 'full-width'){
                fullPostOption.addClass('show');
            }
            if($(this).attr('selected') == 'selected' && $(this).val() == 'two-column-images'){
                contentDisplayOption.addClass('show');
            }
        });
    }

    function hideFallbackImageControl() {

        var selected = panel.find('#customize-control-additional_options_no_featured_image').find('input:checked');
        var fallbackControl = panel.find('#customize-control-additional_options_fallback_featured_image');

        if ( selected.val() == 'fallback' ) {
            fallbackControl.addClass('show');
        } else {
            fallbackControl.removeClass('show');
        }
    }
});