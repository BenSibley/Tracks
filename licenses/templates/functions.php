<?php

/**
 * is_edit_page
 * function to check if the current page is a post edit page
 *
 * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
 * @return boolean
 */
function ct_tracks_is_edit_page($new_edit = null){

	global $pagenow;

	// make sure we are on the backend
	if (!is_admin()) return false;

	if($new_edit == "edit")
		return in_array( $pagenow, array( 'post.php',  ) );
	elseif($new_edit == "new") //check for new post page
		return in_array( $pagenow, array( 'post-new.php' ) );
	else // check for either new or edit
		return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}

function ct_tracks_change_preview_button( $translation, $text ) {

	if ( $text == 'Preview' ) {
		return 'Preview & Style';
	}
	if ( $text == 'Preview Changes' ) {
		return 'Preview & Style';
	}

	return $translation;
}

function ct_tracks_show_customizer_template_preview( $url ) {

	// get post object
	global $post;

	// if editing a page
	if( ct_tracks_is_edit_page('edit') && $post->post_type == 'page' ) {

		// get the page id
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

			add_action( 'customize_register', 'ct_tracks_bold_update_customizer_content', 999 );
		}
	}
}
add_action( 'customize_register', 'ct_tracks_customizer_check', 10 );