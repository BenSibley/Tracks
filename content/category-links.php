<?php
// Outputs the categories the post was included in with their names hyperlinked to their permalink
// separator removed so links site tightly against each other

$categories = get_the_category( $post->ID );

// if only uncategorized, don't display
if( (count($categories) == 1) && ($categories[0]->term_id == 1) ){
    return false;
}
$separator = ' ';
$output = '';
if($categories){
	echo '<div class="entry-categories">';
	    echo "<p><span>" . __('Categories', 'tracks') . "</span>";
		    foreach($categories as $category) {
		        $output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'tracks' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
		    }
		    echo trim($output, $separator);
	    echo "</p>";
	echo "</div>";
}