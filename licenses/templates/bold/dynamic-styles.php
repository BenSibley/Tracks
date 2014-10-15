<?php

// set content type to stylesheet
header('Content-type: text/css');
header('Cache-control: must-revalidate');

// Setup location of WordPress
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

// get all setting ids
$setting_ids = ct_tracks_bold_template_customizer_inputs();

// create array to store user input
$user_input = array();

// get all the values and store in array
foreach( $setting_ids as $input ) {

	if ( $input == 'heading_color' || $input == 'sub_heading_color' || $input == 'description_color' || $input == 'button_one_color' || $input == 'button_two_color' ) {
		$value = '#ffffff';
	} elseif ( $input == 'button_one_background_color' || $input == 'button_one_border_color' || $input == 'button_two_border_color' ) {
		$value = '#e59e45';
	} elseif ( $input == 'heading_size' ) {
		$value = '51';
	} elseif ( $input == 'button_one_size' || $input == 'button_two_size' ) {
		$value = '13';
	} elseif ( $input == 'button_one_border_width' || $input == 'button_two_border_width' ) {
		$value = '0';
	} elseif ( $input == 'button_one_border_style' || $input == 'button_two_border_style' ) {
		$value = 'solid';
	} elseif ( $input == 'sub_heading_size' ) {
		$value = '37';
	} elseif ( $input == 'description_size' ) {
		$value = '16';
	} elseif ( $input == 'overlay_color' ) {
		$value = '#222222';
	} elseif ( $input == 'overlay_opacity' ) {
		$value = '0.8';
	} elseif ( $input == 'button_one_background_opacity' || $input == 'button_two_background_opacity' ) {
		// if it's set to 0, return 0 not 'false'
		if ( get_theme_mod( 'ct_tracks_bold_' . $input . '_setting' ) == 0 ) {
			$value = 0;
		} else {
			$value = 1;
		}
	}
	if ( $input == 'background_position' ) {
		if ( get_theme_mod( 'ct_tracks_bold_background_position_setting' ) == 'fill' ) {
			$user_input[ $input ] = "background-size: cover;";
		} elseif ( get_theme_mod( 'ct_tracks_bold_background_position_setting' ) == 'fit' ) {
			$user_input[ $input ] = "background-size: contain;";
		} elseif ( get_theme_mod( 'ct_tracks_bold_background_position_setting' ) == 'stretch' ) {
			$user_input[ $input ] = "height: 100%; width: 100%;";
		} else {
			$user_input[ $input ] = "background-size: cover;";
		}
	} else {
		$user_input[ $input ] = get_theme_mod( 'ct_tracks_bold_' . $input . '_setting' ) ? get_theme_mod( 'ct_tracks_bold_' . $input . '_setting' ) : $value;
	}

}

?>

.page-template-bold .site-header {
	background: none;
	border: none;
	z-index: 19;
}
.page-template-bold .top-navigation {
	display: none;
}
.page-template-bold .site-footer {
	display: none;
}
.bold-template {
	position: relative;
	z-index: 9;
	color: #fff;
	text-align: center;
}
.bold-template .container {
	padding: 3em 5.55% 6em;
}
.bold-template .heading {
	text-transform: uppercase;
	letter-spacing: 0.06em;
	font-weight: 700;
	font-size: <?php echo absint( $user_input['heading_size'] * 0.583 ); ?>px;
	line-height: 1.321;
	color: <?php echo ct_tracks_clean_color_code( $user_input['heading_color'] ); ?>
}
.bold-template .sub-heading {
	font-size: <?php echo absint( $user_input['sub_heading_size'] * 0.568 ); ?>px;
	line-height: 1.143;
	margin-bottom: 36px;
	color: <?php echo ct_tracks_clean_color_code( $user_input['sub_heading_color'] ); ?>
}
.bold-template .description {
	margin: 2.25em 0;
	font-size: <?php echo absint( $user_input['description_size'] ); ?>px;
	color: <?php echo ct_tracks_clean_color_code( $user_input['description_color'] ); ?>;
}
.bold-template .button {
	display: inline-block;
	padding: 0.75em 1.5em;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	font-weight: 700;
	opacity: 0.9;
}
.bold-template .button:hover,
.bold-template .button:active,
.bold-template .button:focus {
    opacity: 1;
}
.bold-template .button-one {
	color: <?php echo ct_tracks_clean_color_code( $user_input['button_one_color'] ); ?>;
	font-size: <?php echo absint( $user_input['button_one_size'] ); ?>px;
	background: rgba(<?php echo ct_tracks_hex2rgb( $user_input['button_one_background_color']); ?>, <?php echo floatval( $user_input['button_one_background_opacity'] ); ?>);
	outline-width: <?php echo absint( $user_input['button_one_border_width'] ); ?>px;
	outline-color: <?php echo ct_tracks_clean_color_code( $user_input['button_one_border_color'] ); ?>;
	outline-style: <?php echo ct_tracks_sanitize_border_style( $user_input['button_one_border_style'] ); ?>;
	outline-offset: -<?php echo absint( $user_input['button_one_border_width'] ); ?>px;
}
.bold-template .button-one:link,
.bold-template .button-one:visited,
.bold-template .button-one:hover,
.bold-template .button-one:active,
.bold-template .button-one:focus {
  color: <?php echo ct_tracks_clean_color_code( $user_input['button_one_color'] ); ?>;
}
.bold-template .button-two {
	margin-left: 24px;
	color: <?php echo ct_tracks_clean_color_code( $user_input['button_two_color'] ); ?>;
	font-size: <?php echo absint( $user_input['button_two_size'] ); ?>px;
	background: rgba(<?php echo ct_tracks_hex2rgb( $user_input['button_two_background_color'] ); ?>, <?php echo floatval( $user_input['button_two_background_opacity'] ); ?>);
	outline-width: <?php echo absint( $user_input['button_two_border_width'] ); ?>px;
	outline-color: <?php echo ct_tracks_clean_color_code( $user_input['button_two_border_color'] ); ?>;
	outline-style: <?php echo ct_tracks_sanitize_border_style( $user_input['button_two_border_style'] ); ?>;
	outline-offset: -<?php echo absint( $user_input['button_two_border_width'] ); ?>px;
}
.bold-template .button-two:link,
.bold-template .button-two:visited,
.bold-template .button-two:hover,
.bold-template .button-two:active,
.bold-template .button-two:focus {
	color: <?php echo ct_tracks_clean_color_code( $user_input['button_two_color'] ); ?>;
}
.template-bg-image {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 1;
	background-position: 50%;
	background-repeat: no-repeat;
	-webkit-background-size: cover cover;
	<?php echo $user_input['background_position']; ?>
}
.template-overlay {
	position: absolute;
	z-index: 2;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: <?php echo ct_tracks_clean_color_code( $user_input['overlay_color'] ); ?>;
	opacity: <?php echo floatval( $user_input['overlay_opacity'] ); ?>;
}

/* 600px */
@media all and (min-width: 37.5em) {

	.bold-template .container {
		padding: 4.5em 5.55% 7.5em;
	}
}
/* 800px */
@media all and (min-width: 50em) {

	.bold-template .container {
		padding-top: 6em;
	}
	.bold-template .heading {
		font-size: <?php echo absint( $user_input['heading_size'] * 0.771 ); ?>px;
		line-height: 1.297;
	}
	.bold-template .sub-heading {
		font-size: <?php echo absint( $user_input['sub_heading_size'] * 0.757 ); ?>px;
		line-height: 1.32;
	}
	.bold-template .description {
		padding: 0 6.24%;
	}
}
/* 1100px */
@media all and (min-width: 68.75em) {

	.bold-template .container {
		padding-top: 7.5em;
	}
	.bold-template .heading {
		font-size: <?php echo absint( $user_input['heading_size'] ); ?>px;
		line-height: 1.25;
	}
	.bold-template .sub-heading {
		font-size: <?php echo absint( $user_input['sub_heading_size'] ); ?>px;
		line-height: 1.297;
	}
	.bold-template .description {
		padding: 0 18.72%;
	}
}
