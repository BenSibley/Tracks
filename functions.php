<?php

// register and enqueue all of the scripts used by Aside
function ct_tracks_load_javascript_files() {

    wp_register_style( 'google-fonts', '//fonts.googleapis.com/css?family=Raleway:400,700');

    if(! is_admin() ) {
        wp_enqueue_script('production', get_template_directory_uri() . '/js/build/production.min.js#ct_tracks_asyncload', array('jquery'),'', true);
        wp_enqueue_style('google-fonts');
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');
    }
    // enqueues the comment-reply script on posts & pages.  This script is included in WP by default
    if( is_singular() && comments_open() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' ); 
}

add_action('wp_enqueue_scripts', 'ct_tracks_load_javascript_files' );

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

// load all scripts enqueued by theme asynchronously
function ct_tracks_add_async_script($url) {

    // if async parameter not present, do nothing
    if (strpos($url, '#ct_tracks_asyncload')===false){
        return $url;
    }
    // if async parameter present, add async attribute
    return str_replace('#ct_tracks_asyncload', '', $url)."' async='async";
}
add_filter('clean_url', 'ct_tracks_add_async_script', 11, 1);

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'ct_tracks_theme_setup', 10 );

function ct_tracks_theme_setup() {
	
    /* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();
    
	/* Theme-supported features go here. */
    add_theme_support( 'hybrid-core-template-hierarchy' );
    add_theme_support( 'hybrid-core-styles', array( 'style', 'reset', 'gallery' ) );
    add_theme_support( 'loop-pagination' );
    add_theme_support( 'featured-header' );
    add_theme_support( 'cleaner-gallery' );
    add_theme_support( 'automatic-feed-links' ); //from WordPress core not theme hybrid

    register_nav_menu('primary', __('Primary', 'tracks'));

    // register after post widget area
    register_sidebar( array(
        'name'         => __( 'After Post Content', 'tracks' ),
        'id'           => 'after-post-content',
        'description'  => __( 'Widgets in this area will be shown after post content before the author info box' )
    ) );
    
    // adds the file with the customizer functionality
    require_once( trailingslashit( get_template_directory() ) . 'functions-admin.php' );
}

// Creates the next/previous post section below every post
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

// Outputs the categories the post was included in with their names hyperlinked to their permalink
// separator removed so links site tightly against each other
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

// Outputs the tags the post used with their names hyperlinked to their permalink
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

/* added to customize the comments. Same as default except -> added use of gravatar images for comment authors */
function ct_tracks_customize_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
 
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <div class="comment-author"><?php echo get_avatar( get_comment_author_email(), 72 ); ?>
                <div>
                    <div class="author-name"><?php comment_author_link(); ?></div>
                    <div class="comment-date"><?php comment_date('n/j/Y'); ?></div>
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'tracks' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    <?php edit_comment_link( 'edit' ); ?>
                </div>    
            </div>
            <div class="comment-content">
                <?php if ($comment->comment_approved == '0') : ?>
                    <em><?php _e('Your comment is awaiting moderation.', 'tracks') ?></em>
                    <br />
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
        </article>
    </li>
    <?php
}

/* added HTML5 placeholders for each default field and aria-required to required */
function ct_tracks_update_fields($fields) {

    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );

    $fields['author'] =
        '<p class="comment-form-author">
            <label class="screen-reader-text">Your Name</label>
            <input required placeholder="Your Name*" id="author" name="author" type="text" aria-required="true" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30"' . $aria_req . ' />
    	</p>';

    $fields['email'] =
        '<p class="comment-form-email">
            <label class="screen-reader-text">Your Email</label>
            <input required placeholder="Your Email*" id="email" name="email" type="email" aria-required="true" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30"' . $aria_req . ' />
    	</p>';

    $fields['url'] =
        '<p class="comment-form-url">
            <label class="screen-reader-text">Your Website URL</label>
            <input placeholder="Your URL" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30" />
            </p>';

    return $fields;
}
add_filter('comment_form_default_fields','ct_tracks_update_fields');

function ct_tracks_update_comment_field($comment_field) {
	
	$comment_field =
        '<p class="comment-form-comment">
            <label class="screen-reader-text">Your Comment</label>
            <textarea required placeholder="Enter Your Comment&#8230;" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </p>';
	
	return $comment_field;
}
add_filter('comment_form_field_comment','ct_tracks_update_comment_field');

// remove allowed tags text after comment form
function ct_tracks_remove_comments_notes_after($defaults){

    $defaults['comment_notes_after']='';
    return $defaults;
}

add_action('comment_form_defaults', 'ct_tracks_remove_comments_notes_after');

// for 'read more' tag excerpts
function ct_tracks_excerpt() {
	
	global $post;
	// check for the more tag
    $ismore = strpos( $post->post_content, '<!--more-->');
    
	/* if there is a more tag, edit the link to keep reading
	*  works for both manual excerpts and read more tags
	*/
    if($ismore) {
        the_content("Read the Post <span class='screen-reader-text'>" . get_the_title() . "</span>");
    }
    // otherwise the excerpt is automatic, so output it
    else {
        the_excerpt();
    }
}

// for custom & automatic excerpts
function ct_tracks_excerpt_read_more_link($output) {
	global $post;
	return $output . "<p><a class='more-link' href='". get_permalink() ."'>Read the Post <span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
}

add_filter('the_excerpt', 'ct_tracks_excerpt_read_more_link');

// change the length of the excerpts
function ct_tracks_custom_excerpt_length( $length ) {
    return 15;
}
add_filter( 'excerpt_length', 'ct_tracks_custom_excerpt_length', 999 );

// switch [...] to ellipsis on automatic excerpt
function ct_tracks_new_excerpt_more( $more ) {
	return '&#8230;';
}
add_filter('excerpt_more', 'ct_tracks_new_excerpt_more');

// turns of the automatic scrolling to the read more link 
function ct_tracks_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}

add_filter( 'the_content_more_link', 'ct_tracks_remove_more_link_scroll' );

// Adds navigation through pages in the loop
function ct_tracks_post_navigation() {
    if ( current_theme_supports( 'loop-pagination' ) ) loop_pagination();
}

// displays the social icons in the .entry-author div
function ct_tracks_author_social_icons() {

	$social_sites = ct_tracks_create_social_array();
    
    foreach($social_sites as $key => $social_site) {
    	if(get_the_author_meta( $social_site)) {
    		if($key == 'googleplus') {
				echo "<a href='".esc_url(get_the_author_meta( $social_site))."'><i class=\"fa fa-google-plus-square\"></i></a>";
			} elseif($key == 'flickr') {
				echo "<a href='".esc_url(get_the_author_meta( $social_site))."'><i class=\"fa fa-flickr\"></i></a>";
			} elseif($key == 'dribbble') {
                echo "<a href='".esc_url(get_the_author_meta( $social_site))."'><i class=\"fa fa-dribbble\"></i></a>";
            } elseif($key == 'instagram') {
                echo "<a href='".esc_url(get_the_author_meta( $social_site))."'><i class=\"fa fa-instagram\"></i></a>";
            } else {
	    		echo "<a href='".esc_url(get_the_author_meta( $social_site))."'><i class=\"fa fa-$key-square\"></i></a>";
	    	}
    	}
    }
}

// for displaying featured images including mobile versions and default versions
function ct_tracks_featured_image() {

    global $post;
    $has_image = false;

    // load smaller version on archive pages and larger version on post pages
    if(is_archive() || is_home()) {
        if (has_post_thumbnail( $post->ID ) ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'blog' );
            $image = $image[0];
            $has_image = true;
        }
    } elseif (has_post_thumbnail( $post->ID ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        $image = $image[0];
        $has_image = true;
    }
    if ($has_image == true) {
        echo "<div class='featured-image' style=\"background-image: url('".$image."')\"></div>";
    }
}

// puts site title & description in the title tag on front page
add_filter( 'wp_title', 'ct_tracks_add_homepage_title' );
function ct_tracks_add_homepage_title( $title )
{
    if( empty( $title ) && ( is_home() || is_front_page() ) ) {
        return __( get_bloginfo( 'title' ), 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
    }
    return $title;
}

/* add a class of 'not-front' to all pages that aren't the front page */
function ct_tracks_body_class( $classes ) {
    if ( ! is_front_page() ) {
        $classes[] = 'not-front';
    }
    return $classes;
}
add_filter( 'body_class', 'ct_tracks_body_class' );

// calls pages for menu if menu not set
function ct_tracks_wp_page_menu() {
    wp_page_menu(array(
            "menu_class" => "menu-unset"
        )
    );
}

function ct_tracks_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'init', 'ct_tracks_add_editor_styles' );

function ct_tracks_post_class_update($classes){

    $remove = array();
    $remove[] = 'entry';

    if ( ! is_singular() ) {
        foreach ( $classes as $key => $class ) {

            if ( in_array( $class, $remove ) ){
                unset( $classes[ $key ] );
                $classes[] = 'excerpt';
            }
        }
    }
    return $classes;
}
add_filter( 'post_class', 'ct_tracks_post_class_update' );

// fix for bug with Disqus saying comments are closed
if ( function_exists( 'dsq_options' ) ) {
    remove_filter( 'comments_template', 'dsq_comments_template' );
    add_filter( 'comments_template', 'dsq_comments_template', 99 ); // You can use any priority higher than '10'
}

/* add a smaller size for the portfolio page */
if( function_exists('add_image_size')){
    add_image_size('blog', 600, 460);
}

function ct_tracks_odd_even_post_class( $classes ) {

    global $wp_query;
    $classes[] = ($wp_query->current_post % 2 == 0) ? 'odd' : 'even';
    return $classes;
}
add_filter ( 'post_class' , 'ct_tracks_odd_even_post_class' );

/* css output for hiding the scroll to top link */
function ct_tracks_return_top_settings_output(){

    $setting = get_theme_mod('additional_options_return_top_settings');

    /* if 'hide' is selected, hide it */
    if($setting == 'hide') {
        $css = "#return-top { display: none; }";
        wp_add_inline_style('style', $css);
    }
}
add_action('wp_enqueue_scripts','ct_tracks_return_top_settings_output');


/* css output for hiding the scroll to top link */
function ct_tracks_image_zoom_settings_output(){

    $setting = get_theme_mod('additional_options_image_zoom_settings');

    /* if 'hide' is selected, hide it */
    if($setting == 'no-zoom') {
        $css = "
            .featured-image-link:hover .featured-image { -ms-transform: none; -moz-transform: none; -o-transform: none; -webkit-transform: none; transform: none;}
            .featured-image-link:active .featured-image { -ms-transform: none; -moz-transform: none; -o-transform: none; -webkit-transform: none; transform: none;}
            .featured-image-link:focus .featured-image { -ms-transform: none; -moz-transform: none; -o-transform: none; -webkit-transform: none; transform: none;}
        ";
        wp_add_inline_style('style', $css);
    }
}
add_action('wp_enqueue_scripts','ct_tracks_image_zoom_settings_output');


?>