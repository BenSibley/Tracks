<?php

// outputs social icons added to author info box

// array of social media site names
$social_sites = ct_tracks_social_array();

foreach ( $social_sites as $key => $social_site ) {

	if( get_the_author_meta( $social_site) ) {
		if( $key ==  "flickr" || $key ==  "dribbble" || $key ==  "instagram" || $key ==  "soundcloud" || $key ==  "spotify" || $key ==  "vine" || $key ==  "yahoo" || $key ==  "codepen" || $key ==  "delicious" || $key ==  "stumbleupon" || $key ==  "deviantart" || $key ==  "digg" || $key ==  "hacker-news" || $key == 'vk' || $key == 'weibo' || $key == 'tencent-weibo') {
			echo "<a href='" . esc_url( get_the_author_meta( $social_site ) ) . "'><i class=\"fa fa-$key\"></i></a>";
		}
		elseif( $key == 'googleplus' ){
			echo "<a href='" . esc_url( get_the_author_meta( $social_site ) ) . "'><i class=\"fa fa-google-plus-square\"></i></a>";
		}
		elseif( $key == 'email' ){
			echo "<a href='mailto:" . antispambot( is_email( get_the_author_meta( $social_site ) ) ) . "'><i class=\"fa fa-envelope\"></i></a>";
		}
		else {
			echo "<a href='" . esc_url( get_the_author_meta( $social_site ) ) . "'><i class=\"fa fa-$key-square\"></i></a>";
		}
	}
}