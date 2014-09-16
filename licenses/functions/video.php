<?php

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function ct_tracks_add_video_meta_box() {

	$screens = array( 'post', );

	foreach ( $screens as $screen ) {

		add_meta_box(
			'ct_tracks_video',
			__( 'Post Video', 'tracks' ),
			'ct_tracks_video_callback',
			$screen
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

	// video URL input
	echo '<div>';
		echo '<label for="ct_tracks_video_url">';
			_e( 'Add video URL', 'tracks' );
		echo '</label> ';
		echo '<input type="text" class="regular-text" id="ct_tracks_video_url" name="ct_tracks_video_url" value="' . esc_url( $value ) . '" />';
	echo '</div>';

	// video upload input
	echo '<div>';
		echo '<label for="ct_tracks_video_select">';
			_e( 'Or, upload a video', 'tracks' );
		echo '</label> ';
		echo '<input type="button" id="ct_tracks_video_select" name="ct_tracks_video_select" class="button-primary" value="Upload Video" />';
	echo '</div>';

	// video preview
	echo '<div>';
		echo '<label for="ct_tracks_video_preview">';
			_e( 'Video Preview', 'tracks' );
		echo '</label> ';
//		echo '<input type="button" id="ct_tracks_video_preview" name="ct_tracks_video_preview" class="button-primary" value="Upload Video" />';
		if( $value ) {
			echo wp_oembed_get( $value );
		}
	echo '</div>';
}

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

	// Make sure that it is set.
	if ( ! isset( $_POST['ct_tracks_video_url'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = esc_url_raw( $_POST['ct_tracks_video_url'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'ct_tracks_video_key', $my_data );
}
add_action( 'save_post', 'ct_tracks_video_save_data' );