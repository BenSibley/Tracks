<?php

/**
 * Adds...
 */
function ct_tracks_bold_meta_box_heading() {

	// query database to get license status
//	$license_status = trim( get_option( 'ct_tracks_featured_videos_license_key_status' ) );

	// check license status
//	if( $license_status != 'valid' ) {
//		return false;
//	}

	global $post;

	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

	// check for a template type
	if ($template_file == 'templates/bold.php') {

		add_meta_box(
			'ct_tracks_bold_heading',
			__( 'Heading', 'tracks' ),
			'ct_tracks_bold_heading_callback',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'ct_tracks_bold_meta_box_heading' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post.
 */
function ct_tracks_bold_heading_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_heading', 'ct_tracks_bold_heading' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_heading_key', true );

	echo "<input type='text' />";
}