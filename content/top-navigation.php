<?php

$social_icon_setting = get_theme_mod( 'social_icons_display_setting' );

if ( ( has_nav_menu( 'secondary' ) ) ||
     ( get_theme_mod( 'search_input_setting' ) == 'show' ) ||
     ( $social_icon_setting == 'header-footer' || $social_icon_setting == 'header' )
) {
	echo "<div class='top-navigation'><div class='container'>";

	get_template_part( 'menu', 'secondary' );

	if ( get_theme_mod( 'search_input_setting' ) == 'show' ) {
		get_search_form();
	}

	if ( ( $social_icon_setting == 'header-footer' ) || ( $social_icon_setting == 'header' ) ) {
		get_template_part( 'content/social-icons' );
	}

	echo "</div></div>";
}