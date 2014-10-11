<?php

/*
 * Updates customizer content for Bold template
 * called conditionally from ct_tracks_customizer_check()
 */
function ct_tracks_bold_update_customizer_content( $wp_customize ) {

	// remove all default and custom sections
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'ct_tracks_tagline_display' );
	$wp_customize->remove_section( 'ct-upload' );
	$wp_customize->remove_section( 'ct_tracks_social_icons' );
	$wp_customize->remove_section( 'ct_tracks_search_input' );
	$wp_customize->remove_section( 'ct_tracks_post_meta_display' );
	$wp_customize->remove_section( 'ct_tracks_comments_display' );
	$wp_customize->remove_section( 'ct-footer-text' );
	$wp_customize->remove_section( 'ct-custom-css' );
	$wp_customize->remove_section( 'ct_tracks_premium_layouts' );
	$wp_customize->remove_section( 'ct_tracks_additional_options' );
	$wp_customize->remove_section( 'ct_tracks_background_image' );
	$wp_customize->remove_section( 'ct_tracks_background_texture' );
	$wp_customize->remove_section( 'ct_tracks_header_color' );
	$wp_customize->remove_section( 'nav' );
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'widgets' );
	$wp_customize->remove_panel( 'widgets' );

	/*
	 * Add Bold Template sections & controls
	 * settings in ct_tracks_bold_customizer_settings()
	 */

	/* Heading */

	// section - heading
	$wp_customize->add_section( 'ct_tracks_bold_heading', array(
		'title'      => __( 'Heading', 'tracks' ),
		'priority'   => 10,
		'capability' => 'edit_theme_options',
	) );
	// control - color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_heading_color_control', array(
			'label'           => __( 'Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_heading',
			'settings'        => 'ct_tracks_bold_heading_color_setting'
		)
	) );
	// control - font size
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_heading_size_setting', array(
			'label'           => __( 'Font Size', 'tracks' ),
			'section'         => 'ct_tracks_bold_heading',
			'settings'        => 'ct_tracks_bold_heading_size_setting',
			'type'            => 'number'
		)
	) );

	/* Sub-heading */

	// section - sub-heading
	$wp_customize->add_section( 'ct_tracks_bold_sub_heading', array(
		'title'      => __( 'Sub-heading', 'tracks' ),
		'priority'   => 20,
		'capability' => 'edit_theme_options',
	) );
	// control - color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_sub_heading_color_control', array(
			'label'           => __( 'Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_sub_heading',
			'settings'        => 'ct_tracks_bold_sub_heading_color_setting'
		)
	) );
	// control - font size
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_sub_heading_size_setting', array(
			'label'           => __( 'Font Size', 'tracks' ),
			'section'         => 'ct_tracks_bold_sub_heading',
			'settings'        => 'ct_tracks_bold_sub_heading_size_setting',
			'type'            => 'number'
		)
	) );

	/* Description */

	// section - description
	$wp_customize->add_section( 'ct_tracks_bold_description', array(
		'title'      => __( 'Description', 'tracks' ),
		'priority'   => 30,
		'capability' => 'edit_theme_options',
	) );
	// control - color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_description_color_control', array(
			'label'           => __( 'Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_description',
			'settings'        => 'ct_tracks_bold_description_color_setting'
		)
	) );
	// control - font size
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_description_size_setting', array(
			'label'           => __( 'Font Size', 'tracks' ),
			'section'         => 'ct_tracks_bold_description',
			'settings'        => 'ct_tracks_bold_description_size_setting',
			'type'            => 'number'
		)
	) );

}

/*
 * Bold customizer settings always loaded.
 * If loaded conditionally, settings will not save
 */
function ct_tracks_bold_customizer_settings( $wp_customize ) {

	/* Heading */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_heading_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_heading_size_setting', array(
		'default'           => '48',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'abs_int',
	) );

	/* Sub-heading */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_sub_heading_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_sub_heading_size_setting', array(
		'default'           => '37',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'abs_int',
	) );

	/* Description */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_description_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_description_size_setting', array(
		'default'           => '37',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'abs_int',
	) );
}
add_action( 'customize_register', 'ct_tracks_bold_customizer_settings' );