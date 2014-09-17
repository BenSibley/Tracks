jQuery(function($) {

    // add fitvid to Post Video preview div
    $('#ct_tracks_video_preview_container').fitVids();


    if( $('#ct_tracks_video_preview_container').children('div').length > 0 ) {
        $('#ct_tracks_video_preview_container, .ct_tracks_video_input_container').addClass('has-vid');
    }

    // watch for a video selection
    //$( '#ct_tracks_video_url').change( oEmbedAjax );
    $('#ct_tracks_video_url').on( 'input propertychange', oEmbedAjax );

    function oEmbedAjax() {

        $(document).bind("ajaxStart.mine", function() {
            $('#ct_tracks_video_preview_container').addClass('ajax-loading');
        });
        $(document).bind("ajaxStop.mine", function() {
            $('#ct_tracks_video_preview_container').removeClass('ajax-loading');
            $(document).unbind(".mine");
        });

        var videoURL = $(this).val();
        var data = {
            action: 'add_oembed',
            videoURL: videoURL
        };

        jQuery.post(ajaxurl, data, function(response) {

            $('#ct_tracks_video_preview_container div, #ct_tracks_video_preview_container video').remove();

            if( response ){

                $('#ct_tracks_video_preview_container, .ct_tracks_video_input_container').addClass('has-vid');

                $('#ct_tracks_video_preview_container').append(response);

                // add fitvid to Post Video preview div
                $('#ct_tracks_video_preview_container').fitVids();


            } else {
                $('#ct_tracks_video_preview_container, .ct_tracks_video_input_container').removeClass('has-vid');
            }
        });

    }

});
