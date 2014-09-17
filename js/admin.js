jQuery(function($) {

    // add fitvid to Post Video preview div
    $('#ct_tracks_video_preview_container').fitVids();

    // watch for a video selection
    $( '#ct_tracks_video_url').change( oEmbedAjax );

    function oEmbedAjax() {

        var videoURL = $(this).val();
        var data = {
            action: 'add_oembed',
            videoURL: videoURL
        };

        jQuery.post(ajaxurl, data, function(response) {
            $('#ct_tracks_video_preview_container').append(response);
        });
    }

});
