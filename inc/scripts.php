<?php

// register and enqueue all front-end scripts used by Tracks
function ct_tracks_load_javascript_files() {

	// register Google Fonts
	wp_register_style( 'ct-tracks-google-fonts', '//fonts.googleapis.com/css?family=Raleway:400,700');

	// enqueue main JS file
	wp_enqueue_script('ct-tracks-production', get_template_directory_uri() . '/js/build/production.min.js', array('jquery'),'', true);

	// enqueue Google Fonts
	wp_enqueue_style('ct-tracks-google-fonts');

	// enqueue Font Awesome
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');

	// enqueue the stylesheet
	wp_enqueue_style('style', get_stylesheet_uri() );

	// enqueue any required layout-specific stylesheets
	if(get_theme_mod('premium_layouts_setting') == 'full-width'){
		wp_enqueue_style('ct-tracks-full-width', get_template_directory_uri() . '/licenses/css/full-width.min.css');
	}
	elseif(get_theme_mod('premium_layouts_setting') == 'full-width-images'){
		wp_enqueue_style('ct-tracks-full-width-images', get_template_directory_uri() . '/licenses/css/full-width-images.min.css');
	}
	elseif(get_theme_mod('premium_layouts_setting') == 'two-column'){
		wp_enqueue_style('ct-tracks-two-column', get_template_directory_uri() . '/licenses/css/two-column.min.css');
	}
	elseif(get_theme_mod('premium_layouts_setting') == 'two-column-images'){
		wp_enqueue_style('ct-tracks-two-column-images', get_template_directory_uri() . '/licenses/css/two-column-images.min.css');
	}

	// enqueue the comment-reply script on posts & pages if comments open (included in WP by default)
	if( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tracks_load_javascript_files' );

// enqueue back-end scripts
function ct_tracks_enqueue_admin_styles($hook){

	// Theme Options and Post Editor
	if ( 'appearance_page_tracks-options' == $hook ) {

		// admin stylesheet
		wp_enqueue_style('style-admin', get_template_directory_uri() . '/styles/style-admin.css');
	}

	// Featured Videos
	if( trim( get_option( 'ct_tracks_featured_videos_license_key_status' ) ) == 'valid' ) {

		// Post Editor
		if ( 'post.php' == $hook || 'post-new.php' == $hook ) {

			// enqueue fitvids
			wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.js', array( 'jquery' ), '', true );

			// enqueue admin JS file
			wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/js/build/admin.min.js', array( 'jquery', 'fitvids' ), '', true );

			// admin stylesheet
			wp_enqueue_style( 'style-admin', get_template_directory_uri() . '/styles/style-admin.css' );
		}
	}
}
add_action('admin_enqueue_scripts',	'ct_tracks_enqueue_admin_styles' );

// enqueues customizer scripts
function ct_tracks_enqueue_customizer_styles(){

	// JS for customizer
	wp_enqueue_script('ct-tracks-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js',array('jquery'),'',true);

	// CSS for cusotmizer
	wp_enqueue_style('ct-customizer-css', get_template_directory_uri() . '/styles/style-customizer.css');
}
add_action('customize_controls_enqueue_scripts','ct_tracks_enqueue_customizer_styles');

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_tracks_enqueue_customizer_post_message_scripts(){

	// JS for live updating with customizer input
	wp_enqueue_script('ct-tracks-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js',array('jquery'),'',true);

}
add_action( 'customize_preview_init', 'ct_tracks_enqueue_customizer_post_message_scripts' );