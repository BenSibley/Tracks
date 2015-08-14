jQuery(function($) {

    // add fitvid to Post Video preview
    if( typeof $.fn.fitVids === 'function' ) {
        $('#ct_tracks_video_preview_container').fitVids({
            customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="vine.co"], iframe[src*="wordpress.tv"], iframe[src*="soundcloud.com"]'
        });
    }

    // if there is a video saved already, add has-vid class
    if( $('#ct_tracks_video_preview_container').children('div').length > 0 ) {
        $('#ct_tracks_video_preview_container, .ct_tracks_video_input_container').addClass('has-vid');
    }

    // watch for a video selection
    $('#ct_tracks_video_url').on( 'input propertychange', oEmbedAjax );

    // ajax to load in video
    function oEmbedAjax() {

        // trigger loading icon when ajax starts
        $(document).bind("ajaxStart.mine", function() {
            $('#ct_tracks_video_preview_container').addClass('ajax-loading');
        });
        // turn off loading icon when ajax stops
        $(document).bind("ajaxStop.mine", function() {
            $('#ct_tracks_video_preview_container').removeClass('ajax-loading');

            // unind ajax to prevent other ajax on page from triggering loading indicator
            $(document).unbind(".mine");
        });

        // get the URL in the input
        var videoURL = $(this).val();

        // set up data object
        var data = {
            action: 'add_oembed',
            videoURL: videoURL,
            security: '<?php echo $ajax_nonce; ?>'
        };

        // post data received from PHP responde
        jQuery.post(ajaxurl, data, function(response) {

            // remove any videos already included
            $('#ct_tracks_video_preview_container div').remove();

            // if valid response
            if( response ){

                // add has-vid class for styling
                $('#ct_tracks_video_preview_container, .ct_tracks_video_input_container').addClass('has-vid');

                // add the video embed content
                $('#ct_tracks_video_preview_container').append(response);

                // reapply fitvids to Post Video preview div
                $('#ct_tracks_video_preview_container').fitVids({
                    customSelector: 'iframe[src*="dailymotion.com"], iframe[src*="slideshare.net"], iframe[src*="animoto.com"], iframe[src*="blip.tv"], iframe[src*="funnyordie.com"], iframe[src*="hulu.com"], iframe[src*="ted.com"], iframe[src*="vine.co"], iframe[src*="wordpress.tv"], iframe[src*="soundcloud.com"]'
                });

                // show youtube options if youtube video
                if( response.includes('youtube.com') || response.includes('youtu.be') ) {
                    $('.ct_tracks_video_youtube_controls_container.hide').removeClass('hide');
                }

            }
            // else remove the has-vid class in case already had video
            else {
                $('#ct_tracks_video_preview_container, .ct_tracks_video_input_container').removeClass('has-vid');

                // hide youtube options
                $('.ct_tracks_video_youtube_controls_container').addClass('hide');
            }
        });
    }
});