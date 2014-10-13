<?php

// function to check if the current page is a post edit page
function ct_tracks_is_edit_page($new_edit = null){

	global $pagenow;

	// make sure we are on the backend
	if (! is_admin() ) {
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
		return;
	}

	// get the page id
	$post_id = isset( $_GET['post'] ) ? $_GET['post'] : $_POST['post_ID'] ;

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
			return;
		}

		$post_id = $_POST['post_ID'];

		// get the template currently used by the page
		$template_file = get_post_meta( $post_id, '_wp_page_template', true );

		// if it's using the Bold template
		if ( $template_file == 'templates/bold.php' ) {

			// create argument array
			$args = array();

			// add url to args array
			$args['url'] = $url;

			// add the return url for when customizer closed
			$args['return'] = get_edit_post_link( get_post()->ID, 'raw' );

			// construct new url for preview
			$url = admin_url( 'customize.php' ) . '?' . http_build_query( $args ) . '?template=bold';
		}
	}
	return $url;
}
add_filter( 'preview_post_link', 'ct_tracks_show_customizer_template_preview' );

// update the customizer on Template page previews
function ct_tracks_customizer_check( $wp_customize ) {

	/*
	 * When coming from /edit.php, the $_GET variable contains a return url.
	 * The return url may contain the name of a template being used.
	 * The template name is added to the url by ct_tracks_show_customizer_template_preview()
	 */

	// if 'return' key is present
	if( isset( $_GET['return'] ) ) {

		// and bold template preview
		if ( strpos( $_GET['return'], 'template=bold' ) ) {

			// update the customizer content
			add_action( 'customize_register', 'ct_tracks_bold_update_customizer_content', 999 );

			// remove the Premium Upgrades ad
			remove_action('customize_controls_print_footer_scripts', 'ct_tracks_customize_preview_js');
		}
	}
}
add_action( 'customize_register', 'ct_tracks_customizer_check', 1 );

function ct_tracks_hex2rgb( $colour ) {

	// remove #
	$colour = substr( $colour, 1 );

	list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );

	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );

	return "$r, $g, $b";
}