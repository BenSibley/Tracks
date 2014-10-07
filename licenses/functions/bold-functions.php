<?php

/**
 * Adds the meta boxes for Bold Template
 */
function ct_tracks_bold_meta_boxes() {

	global $post;

	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

	$template_file = get_post_meta( $post_id, '_wp_page_template', TRUE );

	// check for a template type
	if ( $template_file == 'templates/bold.php' ) {

		add_meta_box(
			'ct_tracks_bold_heading',
			__( 'Heading', 'tracks' ),
			'ct_tracks_bold_heading_callback',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'ct_tracks_bold_sub_heading',
			__( 'Sub-heading', 'tracks' ),
			'ct_tracks_bold_sub_heading_callback',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'ct_tracks_bold_meta_boxes' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post.
 */
function ct_tracks_bold_heading_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_heading', 'ct_tracks_bold_heading_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_heading_key', true );

	echo '<input type="text" class="regular-text" id="ct_tracks_bold_heading" name="ct_tracks_bold_heading" value="' . sanitize_text_field( $value ) . '" />';
}

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post.
 */
function ct_tracks_bold_sub_heading_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_sub_heading', 'ct_tracks_bold_sub_heading_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_sub_heading_key', true );

	echo '<input type="text" class="regular-text" id="ct_tracks_bold_sub_heading" name="ct_tracks_bold_sub_heading" value="' . sanitize_text_field( $value ) . '" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function ct_tracks_bold_save_data( $post_id ) {

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// array of meta box IDs
	$meta_boxes = array( 'ct_tracks_bold_heading', 'ct_tracks_bold_sub_heading' );

	foreach( $meta_boxes as $meta_box ){

		// Check if our nonce is set.
		if ( isset( $_POST[ $meta_box . '_nonce' ] ) ) {

			// Verify that the nonce is valid.
			if ( wp_verify_nonce( $_POST[ $meta_box . '_nonce' ], $meta_box ) ) {

				// Make sure heading value is set
				if ( isset( $_POST[ $meta_box ] ) ) {

					// sanitize user input.
					$clean_data = sanitize_text_field( $_POST[ $meta_box ] );

					// Update the meta field in the database.
					update_post_meta( $post_id, $meta_box . '_key', $clean_data );
				}
			}
		}
	}

}
add_action( 'save_post', 'ct_tracks_bold_save_data' );