<?php

/* Avoid use of these functions in favor of newer functions */

/*
 * @deprecated 1.19
 * Now template part /content/category-links.php
 */
function ct_tracks_category_display() {

    $categories = get_the_category();
    $separator = ' ';
    $output = '';
    if($categories){
        echo "<p><span>Categories</span>";
        foreach($categories as $category) {
            $output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", 'tracks' ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
        }
        echo trim($output, $separator);
        echo "</p>";
    }
}

/*
 * @deprecated 1.19
 * Now template part /content/tag-links.php
 */
function ct_tracks_tags_display() {

    $tags = get_the_tags();
    $separator = ' ';
    $output = '';
    if($tags){
        echo "<p><span>Tags</span>";
        foreach($tags as $tag) {
            $output .= '<a href="'.get_tag_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts tagged %s", 'tracks' ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator;
        }
        echo trim($output, $separator);
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
    $previous_blog_post = get_adjacent_post(false,'',true);
    $next_blog_post = get_adjacent_post(false,'',false);

    if(get_the_title($previous_blog_post)) {
        $previous_title = get_the_title($previous_blog_post);
    } else {
        $previous_title = "The Previous Post";
    }
    if(get_the_title($next_blog_post)) {
        $next_title = get_the_title($next_blog_post);
    } else {
        $next_title = "The Next Post";
    }

    echo "<nav class='further-reading'>";
    if($previous_blog_post) {
        echo "<p class='prev'>
        		<span>Previous Post</span>
        		<a href='".get_permalink($previous_blog_post)."'>".$previous_title."</a>
	        </p>";
    } else {
        echo "<p class='prev'>
                <span>This is the oldest post</span>
        		<a href='".esc_url(home_url())."'>Return to Blog</a>
        	</p>";
    }
    if($next_blog_post) {

        echo "<p class='next'>
        		<span>Next Post</span>
        		<a href='".get_permalink($next_blog_post)."'>".$next_title."</a>
	        </p>";
    } else {
        echo "<p class='next'>
                <span>This is the newest post</span>
        		<a href='".esc_url(home_url())."'>Return to Blog</a>
        	 </p>";
    }
    echo "</nav>";
}