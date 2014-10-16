<?php

// social icon output in top-navigation

// array of social media site names
$social_sites = ct_tracks_social_site_list();

// store social sites with input in array
foreach( $social_sites as $social_site ) {
	if( strlen( get_theme_mod( $social_site ) ) > 0 ) {
		$active_sites[] = $social_site;
	}
}

// output markup for social icons
if( ! empty( $active_sites ) ) {
	echo '<ul class="social-media-icons">';
		foreach ( $active_sites as $active_site ) {
			echo '<li>';
			// output link <a>
			if( $active_site == 'email' ) {
				echo '<a target="_blank" href="mailto:' . antispambot( is_email( get_theme_mod( $active_site ) ) ) . '">';
			} else {
				echo '<a target="_blank" href="' . esc_url( get_theme_mod( $active_site ) ) . '">';
			}
			// output icon <i>
			if( $active_site ==  "flickr" || $active_site ==  "dribbble" || $active_site ==  "instagram" || $active_site ==  "soundcloud" || $active_site ==  "spotify" || $active_site ==  "vine" || $active_site ==  "yahoo" || $active_site ==  "codepen" || $active_site ==  "delicious" || $active_site ==  "stumbleupon" || $active_site ==  "deviantart" || $active_site ==  "digg" || $active_site ==  "hacker-news" || $active_site == 'vk' || $active_site == 'weibo' || $active_site == 'tencent-weibo') {
				echo '<i class="fa fa-' . $active_site . '"></i>';
			} elseif( $active_site == 'email' ) {
				echo '<i class="fa fa-envelope"></i>';
			} else {
				echo '<i class="fa fa-' . $active_site . '-square"></i>';
			}
			echo '</a></li>';
		}
	echo "</ul>";
}