<?php

/**
 * Adds the meta boxes for Bold Template
 */
function ct_tracks_bold_meta_boxes() {

	// get post object
	global $post;

	// if adding a new page or not a page, abort
	if( ct_tracks_is_edit_page('new') || $post->post_type != 'page' ) {
		return;
	}

	// get the page id
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;

	// get the template currently used by the page
	$template_file = get_post_meta( $post_id, '_wp_page_template', TRUE );

	// if it's using the Bold template
	if ( $template_file == 'templates/bold.php' ) {

		// add the required meta boxes for UGC
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
		add_meta_box(
			'ct_tracks_bold_description',
			__( 'Description', 'tracks' ),
			'ct_tracks_bold_description_callback',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'ct_tracks_bold_button_one',
			__( 'Button 1', 'tracks' ),
			'ct_tracks_bold_button_one_callback',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'ct_tracks_bold_button_two',
			__( 'Button 2', 'tracks' ),
			'ct_tracks_bold_button_two_callback',
			'page',
			'normal',
			'high'
		);
		add_meta_box(
			'ct_tracks_bold_bg_image',
			__( 'Background Image', 'tracks' ),
			'ct_tracks_bold_bg_image_callback',
			'page',
			'normal',
			'high'
		);

		// remove all unnecessary meta boxes to reduce clutter
		remove_meta_box('commentstatusdiv', 'page', 'normal');
		remove_meta_box('postimagediv', 'page', 'side');
		remove_meta_box('postexcerpt', 'page', 'normal');
		remove_meta_box('postcustom', 'page', 'normal');
		remove_meta_box('commentsdiv', 'page', 'normal');
		remove_meta_box('postimagediv', 'page', 'side');
		remove_meta_box('slugdiv', 'page', 'normal');
		remove_meta_box('authordiv', 'page', 'normal');

		// remove the editor
		remove_post_type_support( 'page', 'editor' );

		// change the preview button text
		add_filter( 'gettext', 'ct_tracks_change_preview_button', 10, 2 );
	}
}
add_action( 'add_meta_boxes', 'ct_tracks_bold_meta_boxes' );

/**
 * Saves the meta boxes
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
	$meta_boxes = array( 'ct_tracks_bold_heading', 'ct_tracks_bold_sub_heading', 'ct_tracks_bold_description', 'ct_tracks_bold_button_one', 'ct_tracks_bold_button_two', 'ct_tracks_bold_bg_image' );

	foreach( $meta_boxes as $meta_box ){

		// Check if our nonce is set.
		if ( isset( $_POST[ $meta_box . '_nonce' ] ) ) {

			// Verify that the nonce is valid.
			if ( wp_verify_nonce( $_POST[ $meta_box . '_nonce' ], $meta_box ) ) {

				// Make sure heading value is set
				if ( isset( $_POST[ $meta_box ] ) ) {

					/* Sanitize */

					// if description
					if( $meta_box == 'ct_tracks_bold_description' ) {

						// sanitize user input.
						$clean_data = esc_textarea( $_POST[ $meta_box ] );

					} elseif( $meta_box == 'ct_tracks_bold_button_one' || $meta_box == 'ct_tracks_bold_button_two' ) {

						// sanitize button text
						$clean_data = sanitize_text_field( $_POST[ $meta_box ] );

						// sanitize the button url
						$clean_data_secondary = esc_url_raw( $_POST[ $meta_box . '_link' ]);

					} elseif( $meta_box == 'ct_tracks_bold_bg_image' ) {

						// sanitize user input.
						$clean_data = esc_url_raw( $_POST[ $meta_box ] );

					} else {

						// sanitize user input.
						$clean_data = sanitize_text_field( $_POST[ $meta_box ] );
					}

					/* Update */

					// update meta boxes
					update_post_meta( $post_id, $meta_box . '_key', $clean_data );

					// update second url value in button one
					if( $meta_box == 'ct_tracks_bold_button_one' || $meta_box == 'ct_tracks_bold_button_two' ) {
						update_post_meta( $post_id, $meta_box . '_link_key', $clean_data_secondary );
					}
				}
			}
		}
	}
}
add_action( 'save_post', 'ct_tracks_bold_save_data' );

/*
 * Heading meta box
 */
function ct_tracks_bold_heading_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_heading', 'ct_tracks_bold_heading_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_heading_key', true );

	echo '<input type="text" class="large-text" id="ct_tracks_bold_heading" name="ct_tracks_bold_heading" value="' . sanitize_text_field( $value ) . '" />';
}

/*
 * Sub-heading meta box
 */
function ct_tracks_bold_sub_heading_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_sub_heading', 'ct_tracks_bold_sub_heading_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_sub_heading_key', true );

	echo '<input type="text" class="large-text" id="ct_tracks_bold_sub_heading" name="ct_tracks_bold_sub_heading" value="' . sanitize_text_field( $value ) . '" />';
}

/*
 * Description meta box
 */
function ct_tracks_bold_description_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_description', 'ct_tracks_bold_description_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_description_key', true );

	echo '<textarea id="ct_tracks_bold_description" name="ct_tracks_bold_description" class="large-text" rows="6">' . esc_textarea( $value ) . '</textarea>';
}

/*
 * Button One meta box
 */
function ct_tracks_bold_button_one_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_button_one', 'ct_tracks_bold_button_one_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$text_value = get_post_meta( $post->ID, 'ct_tracks_bold_button_one_key', true );

	$link_value = get_post_meta( $post->ID, 'ct_tracks_bold_button_one_link_key', true );

	echo '
		<label>Button text:
			<input type="text" class="regular-text" id="ct_tracks_bold_button_one" name="ct_tracks_bold_button_one" value="' . sanitize_text_field( $text_value ) . '" />
		</label>';

	echo '
		<label>Button URL:
			<input type="url" class="regular-text" id="ct_tracks_bold_button_one_link" name="ct_tracks_bold_button_one_link" value="' . esc_url( $link_value ) . '" />
		</label>';
}

/*
 * Button Two meta box
 */
function ct_tracks_bold_button_two_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_button_two', 'ct_tracks_bold_button_two_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$text_value = get_post_meta( $post->ID, 'ct_tracks_bold_button_two_key', true );

	$link_value = get_post_meta( $post->ID, 'ct_tracks_bold_button_two_link_key', true );

	echo '
		<label>Button text:
			<input type="text" class="regular-text" id="ct_tracks_bold_button_two" name="ct_tracks_bold_button_two" value="' . sanitize_text_field( $text_value ) . '" />
		</label>';

	echo '
		<label>Button URL:
			<input type="url" class="regular-text" id="ct_tracks_bold_button_two_link" name="ct_tracks_bold_button_two_link" value="' . esc_url( $link_value ) . '" />
		</label>';
}

/*
 * Background Image meta box
 */
function ct_tracks_bold_bg_image_callback( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'ct_tracks_bold_bg_image', 'ct_tracks_bold_bg_image_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, 'ct_tracks_bold_bg_image_key', true );

	// url input
	echo '<input type="url" class="regular-text" id="ct_tracks_bold_bg_image" name="ct_tracks_bold_bg_image" value="' . esc_url( $value ) . '" />';

	// upload button
	echo '<input type="button" id="bg-image-upload" class="button-primary" value="' . __( 'Upload Image', 'tracks' ) . '" />';
}
