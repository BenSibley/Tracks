<?php

// create and return array of all the input ids
function ct_tracks_bold_template_inputs() {
	$input_ids = array( 'heading', 'sub_heading', 'description', 'button_one', 'button_one_link', 'button_two', 'button_two_link', 'bg_image' );

	return $input_ids;
}

// create and return array of all the customizer ids
function ct_tracks_bold_template_customizer_inputs() {
	$setting_ids = array( 'heading_color', 'heading_size', 'sub_heading_color', 'sub_heading_size', 'description_color', 'description_size', 'button_one_size', 'button_one_color', 'button_one_background_color', 'button_one_background_opacity', 'button_one_border_width', 'button_one_border_color', 'button_one_border_style', 'button_two_size', 'button_two_color', 'button_two_background_color', 'button_two_background_opacity', 'button_two_border_width', 'button_two_border_color', 'button_two_border_style', 'overlay_color', 'overlay_opacity', 'background_position' );

	return $setting_ids;
}
// function to check if the current page is a post edit page
function ct_tracks_is_edit_page($new_edit = null){

	global $pagenow;

	// make sure we are on the backend
	if ( ! is_admin() ) {
		return false;
	}

	// returns what type of screen is active
	if($new_edit == "edit")
		return in_array( $pagenow, array( 'post.php'  ) ); // post editor
	elseif($new_edit == "new") // new post editor
		return in_array( $pagenow, array( 'post-new.php' ) );
	else // check for either new or edit
		return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

// adds meta boxes for template pages
function ct_tracks_meta_box_check() {

	// get post object
	global $post;

	// if adding a new page or not a page, abort
	if( ct_tracks_is_edit_page('new') || $post->post_type != 'page' ) {
		return false;
	}

	// get the page id
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post_ID'] );

	// get the template currently used by the page
	$template_file = get_post_meta( $post_id, '_wp_page_template', TRUE );

	// if it's using the Bold template
	if ( $template_file == 'templates/bold.php' ) {

		// load Bold template meta boxes
		add_action( 'add_meta_boxes', 'ct_tracks_bold_meta_boxes', 99 );

		// change the preview button text
		add_filter( 'gettext', 'ct_tracks_change_preview_button', 10, 2 );
	}
}
add_action( 'add_meta_boxes', 'ct_tracks_meta_box_check', 1 );

// changes the preview button text to say "Preview & Style"
function ct_tracks_change_preview_button( $translation, $text ) {

	if ( $text == 'Preview' ) {
		return 'Preview & Style';
	}
	if ( $text == 'Preview Changes' ) {
		return 'Preview & Style';
	}

	return $translation;
}

// Redirects page preview to load customizer in preview when preview button clicked
function ct_tracks_show_customizer_template_preview( $url ) {

	// get post object
	global $post;

	// if editing an existing page
	if( ct_tracks_is_edit_page('edit') && $post->post_type == 'page' ) {

		// get the page id
		if( ! isset($_POST['post_ID'] ) ) {
			return $url;
		}

		// get the page ID
		$post_id = absint( $_POST['post_ID'] );

		// get the template currently used by the page
		$template_file = get_post_meta( $post_id, '_wp_page_template', true );

		// if it's using the Bold template
		if ( $template_file == 'templates/bold.php' ) {

			// create argument array
			$args = array();

			// add url to args array with template parameter
			$args['url'] = $url . '&preview_template=bold';

			// add the return url for when customizer closed
			$args['return'] = get_edit_post_link( $post_id, 'raw' );

			// construct new url for preview
			$url = admin_url( 'customize.php' ) . '?' . http_build_query( $args );
		}
	}
	return $url;
}
add_filter( 'preview_post_link', 'ct_tracks_show_customizer_template_preview' );

function ct_tracks_bold_template_check() {

	/*
	 * When coming from /edit.php, the $_GET variable contains a url value.
	 * The template name is added to the url by ct_tracks_show_customizer_template_preview()
	 */

	// if 'return' key is present
	if ( isset( $_GET['url'] ) ) {

		// and bold template preview
		if ( strpos( $_GET['url'], 'template=bold' ) ) {
			define( 'BOLD_TEMPLATE_PREVIEW', true );
		}
	}
}
add_action('init', 'ct_tracks_bold_template_check' );

function ct_tracks_hex2rgb( $colour ) {

	// make sure it's valid first
	ct_tracks_clean_color_code( $colour );

	// remove #
	$colour = substr( $colour, 1 );

	list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );

	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );

	return "$r, $g, $b";
}

function ct_tracks_clean_color_code($input) {

	if( preg_match('/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $input ) ) {
		return $input;
	} else {
		return '';
	}
}