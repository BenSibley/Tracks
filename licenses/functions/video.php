<?php

/**
 * Adds Featured Video meta box to top of main column on the Post edit screens.
 */
function ct_tracks_add_video_meta_box() {

	// query database to get license status
	$license_status = trim( get_option( 'ct_tracks_featured_videos_license_key_status' ) );

	// check license status
	if( $license_status != 'valid' ) {
		return false;
	}

	$screens = array('post', 'page');

	foreach( $screens as $screen ) {

		add_meta_box(
			'ct_tracks_video',
			esc_html__( 'Featured Video', 'tracks' ),
			'ct_tracks_video_callback',
			$screen,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'ct_tracks_add_video_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post.
 */
function ct_tracks_video_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_video', 'ct_tracks_video_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_video_key', true );

	// post or post and blog?
	$display_value = get_post_meta( $post->ID, 'ct_tracks_video_display_key', true );

	// youtube parameters
	$youtube_title    = get_post_meta( $post->ID, 'ct_tracks_video_youtube_title', true );
	$youtube_related  = get_post_meta( $post->ID, 'ct_tracks_video_youtube_related', true );
	$youtube_logo     = get_post_meta( $post->ID, 'ct_tracks_video_youtube_logo', true );
	$youtube_captions = get_post_meta( $post->ID, 'ct_tracks_video_youtube_captions', true );
	$youtube_autoplay = get_post_meta( $post->ID, 'ct_tracks_video_youtube_autoplay', true );
	$youtube_loop     = get_post_meta( $post->ID, 'ct_tracks_video_youtube_loop', true );
	$youtube_mute     = get_post_meta( $post->ID, 'ct_tracks_video_youtube_mute', true );

	// sets video to display on posts only by default
	if( empty( $display_value ) ) {
		$display_value = "post";
	}

	// video preview
	$container_classes = 'ct_tracks_video_preview_container';
	if ( strpos( $value, 'youtube-nocookie.com' ) !== false ) {
		$container_classes .= ' youtube-nocookie';
	}
	echo '<div class="'. $container_classes .'" id="ct_tracks_video_preview_container">';
		echo '<label for="ct_tracks_video_url">';
			esc_html_e( 'Video Preview', 'tracks' );
		echo '</label> ';
		if ( $value ) {
			// output video embed
			echo ct_tracks_pro_output_video_backend( $value );
		}
		// add loading indicator
		echo '<span class="loading">' . ct_tracks_loading_indicator_svg() . '</span>';
	echo '</div>';

	// video URL input
	echo '<div class="ct_tracks_video_input_container">';
		echo '<label for="ct_tracks_video_url">';
			esc_html_e( 'Add video URL:', 'tracks' );
		echo '</label> ';
		echo '<div>';
			echo '<input type="text" class="regular-text" id="ct_tracks_video_url" name="ct_tracks_video_url" value="' . esc_url( $value ) . '" />';
			echo ct_tracks_green_checkmark_svg();
		echo '</div>';
	echo '</div>';

	// Display option
	if( $post->post_type == 'post' ) {
		echo '<div class="ct_tracks_video_display_container">';
			echo '<p>' . esc_html__( 'Choose where to display the video:', 'tracks' ) . '</p>';
			echo '<label for="ct_tracks_video_display_post">';
				echo '<input type="radio" name="ct_tracks_video_display" id="ct_tracks_video_display_post" value="post" ' . checked( $display_value, "post", false ) . '>';
				echo esc_html_x( 'Post', 'noun', 'tracks' );
			echo '</label> ';
			echo '<label for="ct_tracks_video_display_blog">';
				echo '<input type="radio" name="ct_tracks_video_display" id="ct_tracks_video_display_blog" value="blog" ' . checked( $display_value, "blog", false ) . '>';
				echo esc_html_x( 'Blog', 'noun', 'tracks' );
			echo '</label> ';
			echo '<label for="ct_tracks_video_display_both">';
				echo '<input type="radio" name="ct_tracks_video_display" id="ct_tracks_video_display_both" value="both" ' . checked( $display_value, "both", false ) . '>';
				esc_html_e( 'Post & Blog', 'tracks' );
			echo '</label> ';
		echo '</div>';
	}

	// Youtube options

	// hide class for initially hiding youtube options
	$class = 'hide';

	// if it's a youtube video, don't add the class
	if( strpos($value, 'youtube.com' ) || strpos($value, 'youtu.be' ) ) {
		$class = '';
	}

	echo '<div class="ct_tracks_video_youtube_controls_container ' . $class . '">';
		echo '<p>' . esc_html__( 'Youtube controls', 'tracks' ) . '</p>';
		echo '<label for="ct_tracks_video_youtube_logo">';
			echo '<input type="checkbox" name="ct_tracks_video_youtube_logo" id="ct_tracks_video_youtube_logo" value="1" ' . checked( '1', $youtube_logo, false ) . '>';
			esc_html_e( 'Hide Youtube logo', 'tracks' );
		echo '</label> ';
		echo '<label for="ct_tracks_video_youtube_captions">';
			echo '<input type="checkbox" name="ct_tracks_video_youtube_captions" id="ct_tracks_video_youtube_captions" value="1" ' . checked( '1', $youtube_captions, false ) . '>';
			esc_html_e( 'Show Captions by Default', 'tracks' );
		echo '</label> ';
		echo '<label for="ct_tracks_video_youtube_autoplay">';
			echo '<input type="checkbox" name="ct_tracks_video_youtube_autoplay" id="ct_tracks_video_youtube_autoplay" value="1" ' . checked( '1', $youtube_autoplay, false ) . '>';
			esc_html_e( 'Autoplay video', 'tracks' );
		echo '</label> ';
		echo '<label for="ct_tracks_video_youtube_loop">';
			echo '<input type="checkbox" name="ct_tracks_video_youtube_loop" id="ct_tracks_video_youtube_loop" value="1" ' . checked( '1', $youtube_loop, false ) . '>';
			esc_html_e( 'Loop video', 'tracks' );
		echo '</label> ';
		echo '<label for="ct_tracks_video_youtube_mute">';
			echo '<input type="checkbox" name="ct_tracks_video_youtube_mute" id="ct_tracks_video_youtube_mute" value="1" ' . checked( '1', $youtube_mute, false ) . '>';
			esc_html_e( 'Auto-mute video', 'tracks' );
		echo '</label> ';
	echo '</div>';
}

// ajax callback to return video embed content
function add_oembed_callback() {

	global $wpdb, $post;  // $wpdb - access to the database

	// get the video url passed from the JS (validate user input right away)
	$video_url = esc_url_raw( $_POST['videoURL'] );

	// if got a URL
	if ( $video_url ) {

		// output video embed
		$response = wp_oembed_get( esc_url( $video_url ) );

	// else return nothing
	} else {
		$response = "";
	}

	// return response
	echo $response;

	die(); // this is required to return a proper result

}
add_action('wp_ajax_add_oembed', 'add_oembed_callback');

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function ct_tracks_video_save_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	global $post;

	// Check if our nonce is set.
	if ( ! isset( $_POST['ct_tracks_video_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['ct_tracks_video_nonce'], 'ct_tracks_video' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure video URL is set
	if ( isset( $_POST['ct_tracks_video_url'] ) ) {

		// validate user input.
		$video_url = esc_url_raw( $_POST['ct_tracks_video_url'] );

		// Update the meta field in the database.
		update_post_meta( $post_id, 'ct_tracks_video_key', $video_url );

		// save display option for posts only
		if( $post->post_type == 'post' ) {

			// Make sure display setting is set
			if ( isset( $_POST['ct_tracks_video_display'] ) ) {

				// get user input
				$display_setting = esc_attr( $_POST['ct_tracks_video_display'] );

				// validate user input
				if ( $display_setting == 'post' || $display_setting == 'blog' || $display_setting == 'both' ) {

					// Saves video display option
					update_post_meta( $post_id, 'ct_tracks_video_display_key', $display_setting );
				}
			}
		}
	}

	$youtube_IDs = array(
		'ct_tracks_video_youtube_logo',
		'ct_tracks_video_youtube_captions',
		'ct_tracks_video_youtube_autoplay',
		'ct_tracks_video_youtube_loop',
		'ct_tracks_video_youtube_mute'
	);

	foreach ( $youtube_IDs as $youtube_option ) {

		if ( ! isset( $_POST[ $youtube_option ] ) ) {
			$_POST[ $youtube_option ] = '0';
		}
		$youtube_option_data = $_POST[ $youtube_option ];

		if ( $youtube_option_data == '1' || $youtube_option_data == '0' ) {
			update_post_meta( $post_id, $youtube_option, $youtube_option_data );
		}
	}
}
add_action( 'save_post', 'ct_tracks_video_save_data' );

// front-end output
if ( ! function_exists( ( 'ct_tracks_pro_output_featured_video' ) ) ) {
	function ct_tracks_pro_output_featured_video( $featured_image ){

		if ( trim( get_option( 'ct_tracks_featured_videos_license_key_status' ) ) != 'valid' )
			return $featured_image;

		// get the post object
		global $post;

		// check for a featured video
		$featured_video = get_post_meta( $post->ID, 'ct_tracks_video_key', true );

		if( $featured_video ) {

			$container_classes = 'featured-video';
			if ( strpos( $featured_video, 'youtube-nocookie.com' ) !== false ) {
				$container_classes .= ' youtube-nocookie';
			}

			// get the display setting (post or blog)
			$display_blog = get_post_meta( $post->ID, 'ct_tracks_video_display_key', true );

			// post and setting is post or both, or if the blog and setting is blog or both, or if a page
			if(
				( is_singular() && ( $display_blog == 'post' || $display_blog == 'both' ) )
				|| ( ( is_home() || is_archive() || is_search() ) && ( $display_blog == 'blog' || $display_blog == 'both' ) )
				|| is_singular('page')
			) {
				$featured_image = '<div class="'. esc_attr($container_classes) .'">' . wp_oembed_get( esc_url( $featured_video ) ) . '</div>';
			}
		}

		return $featured_image;
	}
}
add_filter( 'ct_tracks_featured_image', 'ct_tracks_pro_output_featured_video', 20 );

// Filter video output
function ct_tracks_add_youtube_parameters($html, $url, $args) {

	// access post object
	global $post;

	// get featured video
	if( ! empty( $post ) ) $featured_video = get_post_meta( $post->ID, 'ct_tracks_video_key', true );

	// only run filter if there is a featured video
	if( ! empty( $featured_video ) ) {

		// only run filter on the featured video
		if( $url == $featured_video ) {

			// only add parameters if featured vid is a youtube vid
			if( strpos($featured_video, 'youtube.com' ) || strpos($featured_video, 'youtu.be' ) ) {

				// get user Youtube parameter settings
				$youtube_logo     = get_post_meta( $post->ID, 'ct_tracks_video_youtube_logo', true );
				$youtube_captions = get_post_meta( $post->ID, 'ct_tracks_video_youtube_captions', true );
				$youtube_autoplay = get_post_meta( $post->ID, 'ct_tracks_video_youtube_autoplay', true );
				$youtube_loop     = get_post_meta( $post->ID, 'ct_tracks_video_youtube_loop', true );
				$youtube_mute     = get_post_meta( $post->ID, 'ct_tracks_video_youtube_mute', true );

				$youtube_parameters = array(
					'modestbranding' => $youtube_logo,
					'cc_load_policy' => $youtube_captions,
					'autoplay'       => $youtube_autoplay,
					'loop'           => $youtube_loop,
					'mute'					 => $youtube_mute
				);

				if ( $youtube_loop == 1 ) {
					$video_id = explode( 'v=', $featured_video );
					$video_id = $video_id[1];
					$youtube_parameters['playlist'] = $video_id;
				}

				$args       = is_array( $args ) ? array_merge( $args, $youtube_parameters ) : $youtube_parameters;
				$parameters = http_build_query( $args );
				// Modify video parameters
				$html = str_replace( '?feature=oembed', '?feature=oembed&' . $parameters, $html );
			}
		}
	}

	return $html;
}
add_filter('oembed_result','ct_tracks_add_youtube_parameters', 10, 3);

wp_oembed_add_provider( '/https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true);