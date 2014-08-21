jQuery(function($){

    $('html', window.parent.document).find('#customize-control-ct_tracks_background_texture_setting input').each(function(){
       $(this).parent().css('background-image', 'url("../wp-content/themes/tracks/assets/images/textures/' + $(this).val() + '.png")');
    });

});