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

	add_meta_box(
		'ct_tracks_video',
		__( 'Featured Video', 'tracks' ),
		'ct_tracks_video_callback',
		'post',
		'normal',
		'high'
	);
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

	$display_value = get_post_meta( $post->ID, 'ct_tracks_video_display_key', true );

	// sets video to display on posts only by default
	if( empty( $display_value ) ) {
		$display_value = "post";
	}

	// video preview
	echo '<div class="ct_tracks_video_preview_container" id="ct_tracks_video_preview_container">';
		echo '<label for="ct_tracks_video_url">';
			_e( 'Video Preview', 'tracks' );
		echo '</label> ';
		if( $value ) {
			// output video embed
			echo wp_oembed_get( esc_url( $value ) );

		}
		// add loading indicator
		echo '<span class="loading">' . ct_tracks_loading_indicator_svg() . '</span>';
	echo '</div>';

	// video URL input
	echo '<div class="ct_tracks_video_input_container">';
		echo '<label for="ct_tracks_video_url">';
			_e( 'Add video URL:', 'tracks' );
		echo '</label> ';
		echo '<div>';
			echo '<input type="text" class="regular-text" id="ct_tracks_video_url" name="ct_tracks_video_url" value="' . esc_url( $value ) . '" />';
			echo ct_tracks_green_checkmark_svg();
		echo '</div>';
	echo '</div>';

	// Display option
	echo '<div class="ct_tracks_video_display_container">';
		echo '<p>' . __("Choose where to display the video:", "tracks") . '</p>';
		echo '<label for="ct_tracks_video_display_post">';
			echo '<input type="radio" name="ct_tracks_video_display" id="ct_tracks_video_display_post" value="post" ' . checked( $display_value, "post", false ) . '>';
			_e( 'Display on Post', 'tracks' );
		echo '</label> ';
		echo '<label for="ct_tracks_video_display_both">';
			echo '<input type="radio" name="ct_tracks_video_display" id="ct_tracks_video_display_both" value="both" ' . checked( $display_value, "both", false ) . '>';
			_e( 'Display on Post and Blog', 'tracks' );
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
	if ( ! isset( $_POST['ct_tracks_video_url'] ) ) {
		return;
	}

	// validate user input.
	$my_data = esc_url_raw( $_POST['ct_tracks_video_url'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'ct_tracks_video_key', $my_data );

	// Make sure display setting is set
	if ( ! isset( $_POST['ct_tracks_video_display'] ) ) {
		return;
	}

	// get user input
	$raw_data = $_POST[ 'ct_tracks_video_display' ];

	// validate user input
	if( $raw_data == 'post' || $raw_data == 'both' ) {
		$clean_data = $raw_data;
	} else {
		return;
	}

	// Saves video display option
	update_post_meta( $post_id, 'ct_tracks_video_display_key', $clean_data );

}
add_action( 'save_post', 'ct_tracks_video_save_data' );