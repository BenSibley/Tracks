<?php

$categories = get_the_category( $post->ID );

if ( ( count( $categories ) == 1 ) && ( $categories[0]->term_id == 1 ) ) {
	return false;
}

$separator = ' ';
$output    = '';

if ( $categories ) {
	echo '<div class="entry-categories">';
		echo "<p><span>" . __( 'Categories', 'tracks' ) . "</span>";
			foreach ( $categories as $category ) {
				$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s", 'tracks' ), $category->name ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $separator;
			}
			echo trim( $output, $separator );
		echo "</p>";
	echo "</div>";
}