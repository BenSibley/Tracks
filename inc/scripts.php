<?php

// Front-end
function ct_tracks_load_javascript_files() {

	$font_args = array(
		'family' => urlencode( 'Raleway:400,700' ),
		'subset' => urlencode( 'latin,latin-ext' )
	);
	$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );

	wp_enqueue_style( 'ct-tracks-google-fonts', $fonts_url );

	wp_enqueue_script( 'ct-tracks-production', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'ct-tracks-style', get_stylesheet_uri() );

	// enqueue any required layout-specific stylesheets
	if ( get_theme_mod( 'premium_layouts_setting' ) == 'full-width' ) {
		wp_enqueue_style( 'ct-tracks-full-width', get_template_directory_uri() . '/licenses/css/full-width.min.css' );
	} elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'full-width-images' ) {
		wp_enqueue_style( 'ct-tracks-full-width-images', get_template_directory_uri() . '/licenses/css/full-width-images.min.css' );
	} elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'two-column' ) {
		wp_enqueue_style( 'ct-tracks-two-column', get_template_directory_uri() . '/licenses/css/two-column.min.css' );
	} elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'two-column-images' ) {
		wp_enqueue_style( 'ct-tracks-two-column-images', get_template_directory_uri() . '/licenses/css/two-column-images.min.css' );
	}

	// enqueue the comment-reply script on posts & pages if comments open (included in WP by default)
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tracks_load_javascript_files' );

// Back-end
function ct_tracks_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_tracks-options' ) {
		wp_enqueue_style( 'ct-tracks-style-admin', get_template_directory_uri() . '/styles/style-admin.css' );
	}

	// Featured Videos
	if ( trim( get_option( 'ct_tracks_featured_videos_license_key_status' ) ) == 'valid' ) {

		// Post Editor
		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'ct-tracks-admin-js', get_template_directory_uri() . '/js/build/admin.min.js', array(
				'jquery',
				'fitvids'
			), '', true );
			wp_enqueue_style( 'ct-tracks-style-admin', get_template_directory_uri() . '/styles/style-admin.css' );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'ct_tracks_enqueue_admin_styles' );

// Customizer
function ct_tracks_enqueue_customizer_styles() {
	wp_enqueue_script( 'ct-tracks-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'ct-tracks-customizer-css', get_template_directory_uri() . '/styles/style-customizer.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_tracks_enqueue_customizer_styles' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_tracks_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-tracks-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );
}
add_action( 'customize_preview_init', 'ct_tracks_enqueue_customizer_post_message_scripts' );