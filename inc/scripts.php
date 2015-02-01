<?php

// register and enqueue all front-end scripts used by Tracks
function ct_tracks_load_javascript_files() {

	// register Google Fonts
	wp_register_style( 'ct-tracks-google-fonts', '//fonts.googleapis.com/css?family=Raleway:400,700');

	// if front-end
	if (! is_admin() ) {

		// enqueue main JS file
		wp_enqueue_script('ct-tracks-production', get_template_directory_uri() . '/js/build/production.min.js', array('jquery'),'', true);

		// enqueue Google Fonts
		wp_enqueue_style('ct-tracks-google-fonts');

		// enqueue Font Awesome
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');

		// enqueue the stylesheet
		wp_enqueue_style('style', get_template_directory_uri() . 'style.min.css');

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

			// Enqueues all scripts, styles, settings, and templates necessary to use media JavaScript APIs.
			wp_enqueue_media();

			// enqueue the JS needed to utilize media uploader on profile image upload
			wp_enqueue_script( 'ct-profile-uploader', get_template_directory_uri() . '/js/build/profile-uploader.min.js#ct_tracks_asyncload' );
		}
	}

	// Profile (and edit other user)
	if('profile.php' == $hook || 'user-edit.php' == $hook){

		// Enqueues all scripts, styles, settings, and templates necessary to use media JavaScript APIs.
		wp_enqueue_media();

		// enqueue the JS needed to utilize media uploader on profile image upload
		wp_enqueue_script('ct-profile-uploader', get_template_directory_uri() . '/js/build/profile-uploader.min.js#ct_tracks_asyncload');
	}
}
add_action('admin_enqueue_scripts',	'ct_tracks_enqueue_admin_styles' );

// enqueues customizer scripts
function ct_tracks_enqueue_customizer_styles(){

	// script for Comments select dropdown functionality
	wp_enqueue_script('multiple-select', get_template_directory_uri() . '/js/build/multiple-select.min.js',array('jquery'),'',true);

	// stylesheet for Comment display option
	wp_enqueue_style('multiple-select-styles', get_template_directory_uri() . '/styles/multiple-select.css');

	// JS for customizer
	wp_enqueue_script('ct-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js#ct_tracks_asyncload');

	// CSS for cusotmizer
	wp_enqueue_style('ct-customizer-css', get_template_directory_uri() . '/styles/style-customizer.css');
}
add_action('customize_controls_enqueue_scripts','ct_tracks_enqueue_customizer_styles');

// load marked scripts asynchronously
function ct_tracks_add_async_script($url) {

	// if async parameter not present, do nothing
	if (strpos($url, '#ct_tracks_asyncload') === false){
		return $url;
	}
	// if async parameter present, add async attribute
	return str_replace('#ct_tracks_asyncload', '', $url)."' async='async";
}
add_filter('clean_url', 'ct_tracks_add_async_script', 11, 1);