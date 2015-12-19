<?php

/* Avoid use of these functions in favor of newer functions */

/*
 * @deprecated 1.19
 * Now template part /content/category-links.php
 */
function ct_tracks_category_display() {

	$categories = get_the_category();
	$separator  = ' ';
	$output     = '';
	if ( $categories ) {
		echo "<p><span>Categories</span>";
		foreach ( $categories as $category ) {
			$output .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'tracks' ), $category->name ) ) . '">' . $category->cat_name . '</a>' . $separator;
		}
		echo trim( $output, $separator );
		echo "</p>";
	}
}

/*
 * @deprecated 1.19
 * Now template part /content/tag-links.php
 */
function ct_tracks_tags_display() {

	$tags      = get_the_tags();
	$separator = ' ';
	$output    = '';
	if ( $tags ) {
		echo "<p><span>Tags</span>";
		foreach ( $tags as $tag ) {
			$output .= '<a href="' . get_tag_link( $tag->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts tagged %s", 'tracks' ), $tag->name ) ) . '">' . $tag->name . '</a>' . $separator;
		}
		echo trim( $output, $separator );
		echo "</p>";
	}
}

/*
 * @deprecated 1.19
 * Now template part /content/further-reading.php
 */
function ct_tracks_further_reading() {

	global $post;

	// gets the next & previous posts if they exist
	$previous_blog_post = get_adjacent_post( false, '', true );
	$next_blog_post     = get_adjacent_post( false, '', false );

	if ( get_the_title( $previous_blog_post ) ) {
		$previous_title = get_the_title( $previous_blog_post );
	} else {
		$previous_title = "The Previous Post";
	}
	if ( get_the_title( $next_blog_post ) ) {
		$next_title = get_the_title( $next_blog_post );
	} else {
		$next_title = "The Next Post";
	}

	echo "<nav class='further-reading'>";
	if ( $previous_blog_post ) {
		echo "<p class='prev'>
        		<span>Previous Post</span>
        		<a href='" . get_permalink( $previous_blog_post ) . "'>" . $previous_title . "</a>
	        </p>";
	} else {
		echo "<p class='prev'>
                <span>This is the oldest post</span>
        		<a href='" . esc_url( home_url() ) . "'>Return to Blog</a>
        	</p>";
	}
	if ( $next_blog_post ) {

		echo "<p class='next'>
        		<span>Next Post</span>
        		<a href='" . get_permalink( $next_blog_post ) . "'>" . $next_title . "</a>
	        </p>";
	} else {
		echo "<p class='next'>
                <span>This is the newest post</span>
        		<a href='" . esc_url( home_url() ) . "'>Return to Blog</a>
        	 </p>";
	}
	echo "</nav>";
}

/*
 * @deprecated 1.30
 * Now template part /content/social-icons.php
 */
function ct_tracks_customizer_social_icons_output() {

	// array of social media site names
	$social_sites = ct_tracks_social_site_list();

	// any inputs that aren't empty are stored in $active_sites array
	foreach ( $social_sites as $social_site ) {
		if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
			$active_sites[] = $social_site;
		}
	}

	// for each active social site, add it as a list item
	if ( ! empty( $active_sites ) ) {
		echo "<ul class='social-media-icons'>";
		foreach ( $active_sites as $active_site ) { ?>
			<li>
			<?php if ( $active_site == 'email' ) : ?>
			<a target="_blank" href="mailto:<?php echo antispambot( is_email( get_theme_mod( $active_site ) ) ); ?>">
			<?php else : ?>
			<a target="_blank" href="<?php echo esc_url( get_theme_mod( $active_site ) ); ?>">
		<?php endif; ?>

			<?php if ( $active_site == "flickr" || $active_site == "dribbble" || $active_site == "instagram" || $active_site == "soundcloud" || $active_site == "spotify" || $active_site == "vine" || $active_site == "yahoo" || $active_site == "codepen" || $active_site == "delicious" || $active_site == "stumbleupon" || $active_site == "deviantart" || $active_site == "digg" || $active_site == "hacker-news" || $active_site == 'vk' || $active_site == 'weibo' || $active_site == 'tencent-weibo' ) { ?>
				<i class="fa fa-<?php echo $active_site; ?>"></i>
			<?php } elseif ( $active_site == 'email' ) { ?>
				<i class="fa fa-envelope"></i>
			<?php } else { ?>
			<i class="fa fa-<?php echo $active_site; ?>-square"></i><?php
			} ?>
			</a>
			</li><?php
		}
		echo "</ul>";
	}
}

/*
 * @deprecated 1.30
 * Now template part /content/author-social-icons.php
 */
function ct_tracks_author_social_icons() {

	// array of social media site names
	$social_sites = ct_tracks_social_array();

	foreach ( $social_sites as $key => $social_site ) {
		if ( get_the_author_meta( $social_site ) ) {
			if ( $key == "flickr" || $key == "dribbble" || $key == "instagram" || $key == "soundcloud" || $key == "spotify" || $key == "vine" || $key == "yahoo" || $key == "codepen" || $key == "delicious" || $key == "stumbleupon" || $key == "deviantart" || $key == "digg" || $key == "hacker-news" || $key == 'vk' || $key == 'weibo' || $key == 'tencent-weibo' ) {
				echo "<a href='" . esc_url( get_the_author_meta( $social_site ) ) . "'><i class=\"fa fa-$key\"></i></a>";
			} elseif ( $key == 'googleplus' ) {
				echo "<a href='" . esc_url( get_the_author_meta( $social_site ) ) . "'><i class=\"fa fa-google-plus-square\"></i></a>";
			} elseif ( $key == 'email' ) {
				echo "<a href='mailto:" . antispambot( is_email( get_the_author_meta( $social_site ) ) ) . "'><i class=\"fa fa-envelope\"></i></a>";
			} else {
				echo "<a href='" . esc_url( get_the_author_meta( $social_site ) ) . "'><i class=\"fa fa-$key-square\"></i></a>";
			}
		}
	}
}

/*
 * @deprecated 1.38
 * No longer needed
 */
function ct_tracks_get_image_id( $url ) {

	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}

	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;

	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );

	// Returns null if no attachment is found
	return $attachment[0];
}

/*
 * @deprecated 1.38
 * Recommended to use WP User Avatar instead
 */
function ct_tracks_profile_image_output() {

	// use User's profile image, else default to their Gravatar
	if ( get_the_author_meta( 'user_profile_image' ) ) {

		// get the id based on the image's URL
		$image_id = ct_tracks_get_image_id( get_the_author_meta( 'user_profile_image' ) );

		// retrieve the thumbnail size of profile image
		$image_thumb = wp_get_attachment_image( $image_id, 'thumbnail' );

		// display the image
		echo $image_thumb;

	} else {
		echo get_avatar( get_the_author_meta( 'ID' ), 72 );
	}
}