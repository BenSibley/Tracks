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
$heading_color = ( get_theme_mod( 'ct_tracks_bold_heading_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_heading_color_setting' ) : "#fff";

// set heading font size (51px if not set yet)
$heading_font_size = ( get_theme_mod( 'ct_tracks_bold_heading_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_heading_size_setting' ) : "51";

// set sub-heading color (#fff if not set yet)
$sub_heading_color = ( get_theme_mod( 'ct_tracks_bold_sub_heading_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_sub_heading_color_setting' ) : "#fff";

// set sub-heading font size (37px if not set yet)
$sub_heading_font_size = ( get_theme_mod( 'ct_tracks_bold_sub_heading_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_sub_heading_size_setting' ) : "37";

// set description color (#fff if not set yet)
$description_color = ( get_theme_mod( 'ct_tracks_bold_description_color_setting' )) ? get_theme_mod( 'ct_tracks_bold_description_color_setting' ) : "#fff";

// set description font size (16px if not set yet)
$description_font_size = ( get_theme_mod( 'ct_tracks_bold_description_size_setting' )) ? get_theme_mod( 'ct_tracks_bold_description_size_setting' ) : "16";

?>

.page-template-bold .site-header {
	background: none;
	border: none;
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
.bold-template .sub-heading,
.bold-template .description {
	opacity: 0.8;
}
.bold-template .button {
	display: inline-block;
	padding: 0.75em 1.5em;
	color: #fff;
	text-transform: uppercase;
	letter-spacing: 0.08em;
	font-weight: 700;
	font-size: 0.8125em;
	outline: solid 2px #fff;
	opacity: 0.8;
}
.bold-template .button:link, .bold-template .button:visited {
	color: #fff;
}
.template-bg-image {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 1;
	background-position: 50%;
	-webkit-background-size: cover cover;
	background-size: cover;
}
.template-bg-image:after {
	content: '';
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: #222222;
	opacity: 0.5;
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
