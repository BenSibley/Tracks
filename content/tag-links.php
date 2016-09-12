<?php

$tags      = get_the_tags( $post->ID );
$separator = ' ';
$output    = '';

if ( $tags ) {
	echo '<div class="entry-tags">';
		echo "<p><span>" . __( 'Tags', 'tracks' ) . "</span>";
			foreach ( $tags as $tag ) {
				$output .= '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts tagged %s", 'tracks' ), $tag->name ) ) . '">' . esc_html( $tag->name ) . '</a>' . $separator;
			}
			echo trim( $output, $separator );
		echo "</p>";
	echo "</div>";
}