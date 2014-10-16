<?php

/*
 * Updates customizer content for Bold template
 * called conditionally from ct_tracks_customizer_check()
 */
add_action( 'customize_register', 'ct_tracks_bold_update_customizer_content', 999 );

function ct_tracks_bold_update_customizer_content( $wp_customize ) {

	if( ! defined('BOLD_TEMPLATE_PREVIEW') ) return;

	// remove upgrade ad
	remove_action( 'customize_controls_print_footer_scripts', 'ct_tracks_customize_preview_js' );

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
		'title'       => __( 'Sub-heading', 'tracks' ),
		'priority'    => 20,
		'capability'  => 'edit_theme_options'
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

	/* Button 1 */

	// section - button 1
	$wp_customize->add_section( 'ct_tracks_bold_button_one', array(
		'title'      => __( 'Button 1', 'tracks' ),
		'priority'   => 40,
		'capability' => 'edit_theme_options',
	) );
	// control - color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_button_one_color_control', array(
			'label'           => __( 'Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_one',
			'settings'        => 'ct_tracks_bold_button_one_color_setting'
		)
	) );
	// control - font size
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_button_one_size_setting', array(
			'label'           => __( 'Font Size', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_one',
			'settings'        => 'ct_tracks_bold_button_one_size_setting',
			'type'            => 'number'
		)
	) );
	// control - background color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_button_one_background_color_control', array(
			'label'           => __( 'Background Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_one',
			'settings'        => 'ct_tracks_bold_button_one_background_color_setting'
		)
	) );
	// control - background opacity
	$wp_customize->add_control( 'ct_tracks_bold_button_one_background_opacity_control', array(
		'type'            => 'range',
		'label'           => __( 'Background Opacity', 'tracks' ),
		'section'         => 'ct_tracks_bold_button_one',
		'settings'        => 'ct_tracks_bold_button_one_background_opacity_setting',
		'input_attrs'     => array(
			'min'         => 0,
			'max'         => 1,
			'step'        => 0.05
		)
	) );
	// control - border color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_button_one_border_color_control', array(
			'label'           => __( 'Border Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_one',
			'settings'        => 'ct_tracks_bold_button_one_border_color_setting'
		)
	) );
	// control - border width
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_button_one_border_width_control', array(
			'label'           => __( 'Border Width', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_one',
			'settings'        => 'ct_tracks_bold_button_one_border_width_setting'
		)
	) );
	// control - border style
	$wp_customize->add_control( new ct_tracks_Dropdown_Control(
		$wp_customize, 'ct_tracks_bold_button_one_border_style_control', array(
			'label'           => __( 'Border Style', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_one',
			'settings'        => 'ct_tracks_bold_button_one_border_style_setting',
			'choices'         => array(
				'solid' => __('Solid', 'tracks'),
				'dashed' => __('Dashed', 'tracks'),
				'dotted' => __('Dotted', 'tracks'),
				'double' => __('Double', 'tracks'),
				'groove' => __('Groove', 'tracks'),
				'ridge' => __('Ridge', 'tracks'),
				'inset' => __('Inset', 'tracks'),
				'outset' => __('Outset', 'tracks')
			)
		)
	) );

	/* Button 2 */

	// section - button 2
	$wp_customize->add_section( 'ct_tracks_bold_button_two', array(
		'title'      => __( 'Button 2', 'tracks' ),
		'priority'   => 50,
		'capability' => 'edit_theme_options',
	) );
	// control - color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_button_two_color_control', array(
			'label'           => __( 'Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_two',
			'settings'        => 'ct_tracks_bold_button_two_color_setting'
		)
	) );
	// control - font size
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_button_two_size_setting', array(
			'label'           => __( 'Font Size', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_two',
			'settings'        => 'ct_tracks_bold_button_two_size_setting',
			'type'            => 'number'
		)
	) );
	// control - background color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_button_two_background_color_control', array(
			'label'           => __( 'Background Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_two',
			'settings'        => 'ct_tracks_bold_button_two_background_color_setting'
		)
	) );
	// control - background opacity
	$wp_customize->add_control( 'ct_tracks_bold_button_two_background_opacity_control', array(
		'type'            => 'range',
		'label'           => __( 'Background Opacity', 'tracks' ),
		'section'         => 'ct_tracks_bold_button_two',
		'settings'        => 'ct_tracks_bold_button_two_background_opacity_setting',
		'input_attrs'     => array(
			'min'         => 0,
			'max'         => 1,
			'step'        => 0.05
		)
	) );
	// control - border color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_button_two_border_color_control', array(
			'label'           => __( 'Border Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_two',
			'settings'        => 'ct_tracks_bold_button_two_border_color_setting'
		)
	) );
	// control - border width
	$wp_customize->add_control( new ct_tracks_number_input_control(
		$wp_customize, 'ct_tracks_bold_button_two_border_width_control', array(
			'label'           => __( 'Border Width', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_two',
			'settings'        => 'ct_tracks_bold_button_two_border_width_setting'
		)
	) );
	// control - border style
	$wp_customize->add_control( new ct_tracks_Dropdown_Control(
		$wp_customize, 'ct_tracks_bold_button_two_border_style_control', array(
			'label'           => __( 'Border Style', 'tracks' ),
			'section'         => 'ct_tracks_bold_button_two',
			'settings'        => 'ct_tracks_bold_button_two_border_style_setting',
			'choices'         => array(
				'solid' => __('Solid', 'tracks'),
				'dashed' => __('Dashed', 'tracks'),
				'dotted' => __('Dotted', 'tracks'),
				'double' => __('Double', 'tracks'),
				'groove' => __('Groove', 'tracks'),
				'ridge' => __('Ridge', 'tracks'),
				'inset' => __('Inset', 'tracks'),
				'outset' => __('Outset', 'tracks')
			)
		)
	) );

	/* Overlay */

	// section - overlay
	$wp_customize->add_section( 'ct_tracks_bold_overlay', array(
		'title'      => __( 'Overlay', 'tracks' ),
		'priority'   => 60,
		'capability' => 'edit_theme_options',
	) );
	// control - color
	$wp_customize->add_control( new WP_Customize_Color_Control(
		$wp_customize, 'ct_tracks_bold_overlay_color_control', array(
			'label'           => __( 'Overlay Color', 'tracks' ),
			'section'         => 'ct_tracks_bold_overlay',
			'settings'        => 'ct_tracks_bold_overlay_color_setting'
		)
	) );
	// control - overlay opacity
	$wp_customize->add_control( 'ct_tracks_bold_overlay_opacity_control', array(
		'type'            => 'range',
		'label'           => __( 'Overlay Opacity', 'tracks' ),
		'section'         => 'ct_tracks_bold_overlay',
		'settings'        => 'ct_tracks_bold_overlay_opacity_setting',
		'input_attrs'     => array(
			'min'         => 0,
			'max'         => 1,
			'step'        => 0.05
		)
	) );

	/* Background Image */

	// section - background image
	$wp_customize->add_section( 'ct_tracks_bold_background_image', array(
		'title'      => __( 'Background Image', 'tracks' ),
		'priority'   => 70,
		'capability' => 'edit_theme_options',
	) );
	// control - position
	$wp_customize->add_control( 'ct_tracks_bold_background_position_control', array(
		'type'      => 'radio',
		'label'     => __( 'Position', 'tracks' ),
		'section'   => 'ct_tracks_bold_background_image',
		'settings'  => 'ct_tracks_bold_background_position_setting',
		'choices'   => array(
			'fill'      =>  __('Fill screen', 'tracks'),
			'fit'       =>  __('Fit to screen', 'tracks'),
			'stretch'   =>  __('Stretch to fill screen', 'tracks')
		),
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
		'transport'         => 'postMessage'
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_heading_size_setting', array(
		'default'           => '51',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );

	/* Sub-heading */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_sub_heading_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_sub_heading_size_setting', array(
		'default'           => '37',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );

	/* Description */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_description_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_description_size_setting', array(
		'default'           => '37',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );

	/* Button 1 */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_size_setting', array(
		'default'           => '13',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );
	// setting - background color
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_background_color_setting', array(
		'default'           => '#E59E45',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - background opacity
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_background_opacity_setting', array(
		'default'           => '1',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_float',
		'transport'         => 'postMessage'
	) );
	// setting - border color
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_border_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - border width
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_border_width_setting', array(
		'default'           => '2',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );
	// setting - border style
	$wp_customize->add_setting( 'ct_tracks_bold_button_one_border_style_setting', array(
		'default'           => 'solid',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_border_style',
		'transport'         => 'postMessage'
	) );

	/* Button 2 */

	// setting - color
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - font size
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_size_setting', array(
		'default'           => '13',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );
	// setting - background color
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_background_color_setting', array(
		'default'           => '#E59E45',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - background opacity
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_background_opacity_setting', array(
		'default'           => '0',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_float',
		'transport'         => 'postMessage'
	) );
	// setting - border color
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_border_color_setting', array(
		'default'           => '#ffffff',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - border width
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_border_width_setting', array(
		'default'           => '2',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint',
		'transport'         => 'postMessage'
	) );
	// setting - border style
	$wp_customize->add_setting( 'ct_tracks_bold_button_two_border_style_setting', array(
		'default'           => 'solid',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_border_style',
		'transport'         => 'postMessage'
	) );

	/* Overlay */

	// setting - overlay color
	$wp_customize->add_setting( 'ct_tracks_bold_overlay_color_setting', array(
		'default'           => '#222222',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage'
	) );
	// setting - overlay opacity
	$wp_customize->add_setting( 'ct_tracks_bold_overlay_opacity_setting', array(
		'default'           => '0.8',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_float',
		'transport'         => 'postMessage'
	) );

	/* Background Image */

	// setting - background position
	$wp_customize->add_setting( 'ct_tracks_bold_background_position_setting', array(
		'default'           => 'fill',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_background_position',
		'transport'         => 'postMessage'
	) );

	// add js function
	if ( $wp_customize->is_preview() && ! is_admin() ) {
		add_action( 'wp_footer', 'ct_tracks_bold_customizer_js', 21 );
	}
}
add_action( 'customize_register', 'ct_tracks_bold_customizer_settings' );

/* Custom sanitization callbacks */

// sanitize float
function ct_tracks_sanitize_float( $input ) {

	return floatval( $input );
}

// sanitize border style
function ct_tracks_sanitize_border_style( $input ) {

	$valid = array(
		'solid' => __('Solid', 'tracks'),
		'dashed' => __('Dashed', 'tracks'),
		'dotted' => __('Dotted', 'tracks'),
		'double' => __('Double', 'tracks'),
		'groove' => __('Groove', 'tracks'),
		'ridge' => __('Ridge', 'tracks'),
		'inset' => __('Inset', 'tracks'),
		'outset' => __('Outset', 'tracks')
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

// sanitize background position
function ct_tracks_sanitize_background_position( $input ) {

	$valid = array(
		'fill'      =>  __('Fill screen', 'tracks'),
		'fit'       =>  __('Fit to screen', 'tracks'),
		'stretch'   =>  __('Stretch to fill screen', 'tracks')
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function ct_tracks_bold_customizer_js() {

	/*
	 * Settings have to be loaded on customizer.
	 * This at least prevents the javascript from running on every instance of the customizer
	 */

	if( is_page_template('templates/bold.php') ) : ?>

		<script type="text/javascript">
			(function ($) {

				// get the customize object
				var api = parent.wp.customize;

				// output: rgba(25, 174, 211,
				function hexToRgb(hex) {
					var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
					return parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) + ', ';
				}

				// resizing fonts for different screen widths
				function adjustFontSizes(heading, subHeading) {

					var previewWidth = $('html', window.parent.document).find('#customize-preview').width();
					var headingSelector = $('.heading');
					var subHeadingSelector = $('.sub-heading');

					// adjust for screen width
					headingSelector.css('font-size', heading * 0.583 + 'px');
					subHeadingSelector.css('font-size', subHeading * 0.568 + 'px');

					if( previewWidth > 499 ) {
						headingSelector.css('font-size', heading * 0.771 + 'px');
						subHeadingSelector.css('font-size', subHeading * 0.757 + 'px');
					}
					if( previewWidth > 899 ) {
						headingSelector.css('font-size', heading + 'px');
						subHeadingSelector.css('font-size', subHeading + 'px');
					}
					if( previewWidth > 1399 ) {
						headingSelector.css('font-size', heading * 1.314 + 'px');
					}
					if( previewWidth > 1699 ) {
						headingSelector.css('font-size', heading * 1.765 + 'px');
						subHeadingSelector.css('font-size', subHeading * 1.297 + 'px');
					}
				}
				// resize fonts when screen resized
				$(window).resize(function(){
					var headingSize = api.control.instance('ct_tracks_bold_heading_size_setting').setting._value;
					var subHeadingSize = api.control.instance('ct_tracks_bold_sub_heading_size_setting').setting._value;
					adjustFontSizes(headingSize, subHeadingSize);
				});
				// Heading color
				wp.customize('ct_tracks_bold_heading_color_setting', function (value) {
					value.bind(function (to) {
						$('.heading').css('color', to);
					});
				});
				// Heading size
				wp.customize('ct_tracks_bold_heading_size_setting', function (value) {
					value.bind(function (to) {
						var subHeadingSize = api.control.instance('ct_tracks_bold_sub_heading_size_setting').setting._value;
						adjustFontSizes(to, subHeadingSize);
					});
				});
				// Sub-Heading color
				wp.customize('ct_tracks_bold_sub_heading_color_setting', function (value) {
					value.bind(function (to) {
						$('.sub-heading').css('color', to);
					});
				});
				// Sub-Heading size
				wp.customize('ct_tracks_bold_sub_heading_size_setting', function (value) {
					value.bind(function (to) {
						var headingSize = api.control.instance('ct_tracks_bold_heading_size_setting').setting._value;
						adjustFontSizes(headingSize, to);
					});
				});
				// Description color
				wp.customize('ct_tracks_bold_description_color_setting', function (value) {
					value.bind(function (to) {
						$('.description').css('color', to);
					});
				});
				// Description size
				wp.customize('ct_tracks_bold_description_size_setting', function (value) {
					value.bind(function (to) {
						$('.description').css('font-size', to + 'px');
					});
				});
				// Button One color
				wp.customize('ct_tracks_bold_button_one_color_setting', function (value) {
					value.bind(function (to) {
						$('.button-one').css('color', to);
					});
				});
				// Button One size
				wp.customize('ct_tracks_bold_button_one_size_setting', function (value) {
					value.bind(function (to) {
						$('.button-one').css('font-size', to + 'px');
					});
				});
				// Button One background color
				wp.customize('ct_tracks_bold_button_one_background_color_setting', function (value) {
					value.bind(function (to) {

						// get current opacity
						var bgOpacity = api.control.instance('ct_tracks_bold_button_one_background_opacity_control').setting._value;

						// set new color
						$('.button-one').css('background', 'rgba(' + hexToRgb(to) + bgOpacity + ')' );
					});
				});
				// Button One background opacity
				wp.customize('ct_tracks_bold_button_one_background_opacity_setting', function (value) {
					value.bind(function (to) {

						// get current color
						var bgColor = api.control.instance('ct_tracks_bold_button_one_background_color_control').setting._value;

						// set new opacity
						$('.button-one').css('background', 'rgba(' + hexToRgb(bgColor) + to + ')' );
					});
				});
				// Button One border width
				wp.customize('ct_tracks_bold_button_one_border_width_setting', function (value) {
					value.bind(function (to) {
						$('.button-one').css('outline-width', to + 'px');
						$('.button-one').css('outline-offset', '-' + to + 'px');
					});
				});
				// Button One border color
				wp.customize('ct_tracks_bold_button_one_border_color_setting', function (value) {
					value.bind(function (to) {
						$('.button-one').css('outline-color', to);
					});
				});
				// Button One border style
				wp.customize('ct_tracks_bold_button_one_border_style_setting', function (value) {
					value.bind(function (to) {
						$('.button-one').css('outline-style', to);
					});
				});
				// Button two color
				wp.customize('ct_tracks_bold_button_two_color_setting', function (value) {
					value.bind(function (to) {
						$('.button-two').css('color', to);
					});
				});
				// Button two size
				wp.customize('ct_tracks_bold_button_two_size_setting', function (value) {
					value.bind(function (to) {
						$('.button-two').css('font-size', to + 'px');
					});
				});
				// Button two background color
				wp.customize('ct_tracks_bold_button_two_background_color_setting', function (value) {
					value.bind(function (to) {

						// get current opacity
						var bgOpacity = api.control.instance('ct_tracks_bold_button_two_background_opacity_control').setting._value;

						// set new color
						$('.button-two').css('background', 'rgba(' + hexToRgb(to) + bgOpacity + ')' );
					});
				});
				// Button two background opacity
				wp.customize('ct_tracks_bold_button_two_background_opacity_setting', function (value) {
					value.bind(function (to) {

						// get current color
						var bgColor = api.control.instance('ct_tracks_bold_button_two_background_color_control').setting._value;

						// set new opacity
						$('.button-two').css('background', 'rgba(' + hexToRgb(bgColor) + to + ')' );
					});
				});
				// Button two border width
				wp.customize('ct_tracks_bold_button_two_border_width_setting', function (value) {
					value.bind(function (to) {
						$('.button-two').css('outline-width', to + 'px');
						$('.button-two').css('outline-offset', '-' + to + 'px');
					});
				});
				// Button two border color
				wp.customize('ct_tracks_bold_button_two_border_color_setting', function (value) {
					value.bind(function (to) {
						$('.button-two').css('outline-color', to);
					});
				});
				// Button two border style
				wp.customize('ct_tracks_bold_button_two_border_style_setting', function (value) {
					value.bind(function (to) {
						$('.button-two').css('outline-style', to);
					});
				});
				// Overlay color
				wp.customize('ct_tracks_bold_overlay_color_setting', function (value) {
					value.bind(function (to) {
						$('#template-overlay').css('background', 'rgba(' + hexToRgb(to) + '1)');
					});
				});
				// Overlay opacity
				wp.customize('ct_tracks_bold_overlay_opacity_setting', function (value) {
					value.bind(function (to) {
						$('#template-overlay').css('opacity', to);
					});
				});
				// Background image position
				wp.customize('ct_tracks_bold_background_position_setting', function (value) {
					value.bind(function (to) {
						if( to == 'fill' ) {
							$('#template-bg-image').css('background-size', 'cover');
						}
						if( to == 'fit' ) {
							$('#template-bg-image').css('background-size', 'contain');
						}
						if( to == 'stretch' ) {
							$('#template-bg-image').css({
								'background-size': 'initial',
								'height':          '100%',
								'width':           '100%'
							});
						}
					});
				});

			})(jQuery)
		</script>

	<?php endif;
}
