<?php

// set content type to stylesheet
header('Content-type: text/css');
//header('Cache-control: must-revalidate');

// Setup location of WordPress
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

// set heading color (#fff if not set yet)
$heading_color = ( get_theme_mod( 'ct_tracks_bold_heading_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_heading_color_setting' ) : "#ffffff";

// set heading font size (51px if not set yet)
$heading_font_size = ( get_theme_mod( 'ct_tracks_bold_heading_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_heading_size_setting' ) : "51";

// set sub-heading color (#fff if not set yet)
$sub_heading_color = ( get_theme_mod( 'ct_tracks_bold_sub_heading_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_sub_heading_color_setting' ) : "#ffffff";

// set sub-heading font size (37px if not set yet)
$sub_heading_font_size = ( get_theme_mod( 'ct_tracks_bold_sub_heading_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_sub_heading_size_setting' ) : "37";

// set description color (#fff if not set yet)
$description_color = ( get_theme_mod( 'ct_tracks_bold_description_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_description_color_setting' ) : "#ffffff";

// set description font size (16px if not set yet)
$description_font_size = ( get_theme_mod( 'ct_tracks_bold_description_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_description_size_setting' ) : "16";

/* Button One */

$button_one_size = ( get_theme_mod( 'ct_tracks_bold_button_one_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_one_size_setting' ) : "13";
$button_one_color = ( get_theme_mod( 'ct_tracks_bold_button_one_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_one_color_setting' ) : "#ffffff";
$button_one_bg_color = ( get_theme_mod( 'ct_tracks_bold_button_one_background_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_one_background_color_setting' ) : "#E59E45";

// if it's set, use the set value (or if it's 0 allow it)
if( get_theme_mod( 'ct_tracks_bold_button_one_background_opacity_setting') || get_theme_mod( 'ct_tracks_bold_button_one_background_opacity_setting') == 0 ) {
	$button_one_bg_opacity = get_theme_mod( 'ct_tracks_bold_button_one_background_opacity_setting');
} else {
	$button_one_bg_opacity = 1;
}

$button_one_border_width = ( get_theme_mod( 'ct_tracks_bold_button_one_border_width_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_one_border_width_setting' ) : "0";
$button_one_border_color = ( get_theme_mod( 'ct_tracks_bold_button_one_border_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_one_border_color_setting' ) : "#E59E45";
$button_one_border_style = ( get_theme_mod( 'ct_tracks_bold_button_one_border_style_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_one_border_style_setting' ) : "solid";

/* Button Two */

$button_two_size = ( get_theme_mod( 'ct_tracks_bold_button_two_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_two_size_setting' ) : "13";
$button_two_color = ( get_theme_mod( 'ct_tracks_bold_button_two_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_two_color_setting' ) : "#ffffff";
$button_two_bg_color = ( get_theme_mod( 'ct_tracks_bold_button_two_background_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_two_background_color_setting' ) : "#E59E45";

// if it's set, use the set value (or if it's 0 allow it)
if( get_theme_mod( 'ct_tracks_bold_button_two_background_opacity_setting') || get_theme_mod( 'ct_tracks_bold_button_two_background_opacity_setting') == 0 ) {
	$button_two_bg_opacity = get_theme_mod( 'ct_tracks_bold_button_two_background_opacity_setting');
} else {
	$button_two_bg_opacity = 1;
}

$button_two_border_width = ( get_theme_mod( 'ct_tracks_bold_button_two_border_width_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_two_border_width_setting' ) : "0";
$button_two_border_color = ( get_theme_mod( 'ct_tracks_bold_button_two_border_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_two_border_color_setting' ) : "#E59E45";
$button_two_border_style = ( get_theme_mod( 'ct_tracks_bold_button_two_border_style_setting' )) ? get_theme_mod( 'ct_tracks_bold_button_two_border_style_setting' ) : "solid";

$overlay_color = ( get_theme_mod( 'ct_tracks_bold_overlay_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_overlay_color_setting' ) : "#222222";
$overlay_opacity = ( get_theme_mod( 'ct_tracks_bold_overlay_opacity_setting' )) ? get_theme_mod( 'ct_tracks_bold_overlay_opacity_setting' ) : "0.8";

if( get_theme_mod( 'ct_tracks_bold_background_position_setting' ) == 'fill' ) {
	$background_position = "background-size: cover;";
}
elseif( get_theme_mod( 'ct_tracks_bold_background_position_setting' ) == 'fit' ) {
	$background_position = "background-size: contain;";
}
elseif( get_theme_mod( 'ct_tracks_bold_background_position_setting' ) == 'stretch' ) {
	$background_position = "height: 100%; width: 100%;";
}
else {
	$background_position = "background-size: cover;";
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
	font-size: <?php echo $heading_font_size * 0.583; ?>px;
	line-height: 1.321;
	color: <?php echo $heading_color; ?>
}
.bold-template .sub-heading {
	font-size: <?php echo $sub_heading_font_size * 0.568; ?>px;
	line-height: 1.143;
	margin-bottom: 36px;
	color: <?php echo $sub_heading_color; ?>
}
.bold-template .description {
	margin: 2.25em 0;
	font-size: <?php echo $description_font_size; ?>px;
	color: <?php echo $description_color; ?>;
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
	color: <?php echo $button_one_color; ?>;
	font-size: <?php echo $button_one_size; ?>px;
	background: rgba(<?php echo ct_tracks_hex2rgb( $button_one_bg_color); ?>, <?php echo $button_one_bg_opacity; ?>);
	outline-width: <?php echo $button_one_border_width; ?>px;
	outline-color: <?php echo $button_one_border_color; ?>;
	outline-style: <?php echo $button_one_border_style; ?>;
	outline-offset: -<?php echo $button_one_border_width; ?>px;
}
.bold-template .button-one:link,
.bold-template .button-one:visited,
.bold-template .button-one:hover,
.bold-template .button-one:active,
.bold-template .button-one:focus {
  color: <?php echo $button_one_color; ?>;
}
.bold-template .button-two {
	margin-left: 24px;
	color: <?php echo $button_two_color; ?>;
	font-size: <?php echo $button_two_size; ?>px;
	background: rgba(<?php echo ct_tracks_hex2rgb( $button_two_bg_color); ?>, <?php echo $button_two_bg_opacity; ?>);
	outline-width: <?php echo $button_two_border_width; ?>px;
	outline-color: <?php echo $button_two_border_color; ?>;
	outline-style: <?php echo $button_two_border_style; ?>;
	outline-offset: -<?php echo $button_two_border_width; ?>px;
}
.bold-template .button-two:link,
.bold-template .button-two:visited,
.bold-template .button-two:hover,
.bold-template .button-two:active,
.bold-template .button-two:focus {
	color: <?php echo $button_two_color; ?>;
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
	<?php echo $background_position; ?>
}
.template-bg-image:after {
	content: '';
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: <?php echo $overlay_color; ?>;
	opacity: <?php echo $overlay_opacity; ?>;
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
		font-size: <?php echo $heading_font_size * 0.771; ?>px;
		line-height: 1.297;
	}
	.bold-template .sub-heading {
		font-size: <?php echo $sub_heading_font_size * 0.757; ?>px;
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
		font-size: <?php echo $heading_font_size; ?>px;
		line-height: 1.25;
	}
	.bold-template .sub-heading {
		font-size: <?php echo $sub_heading_font_size; ?>px;
		line-height: 1.297;
	}
	.bold-template .description {
		padding: 0 18.72%;
	}
}
