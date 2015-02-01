<?php

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

function ct_tracks_theme_setup() {
	
    /* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();
    
	/* Theme-supported features go here. */
    add_theme_support( 'hybrid-core-template-hierarchy' );
    add_theme_support( 'loop-pagination' );
	add_theme_support( 'cleaner-gallery' );

    // from WordPress core not theme hybrid
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );

    register_nav_menus(array(
        'primary' => __('Primary', 'tracks'),
        'secondary' => __('Secondary', 'tracks'),
        'footer' => __('Footer', 'tracks')
    ));

    // adds theme options page
    require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );

	// add inc folder files
	foreach (glob(trailingslashit( get_template_directory() ) . 'inc/*.php') as $filename)
	{
		include $filename;
	}
    // add license folder files
    foreach (glob(trailingslashit( get_template_directory() ) . 'licenses/*.php') as $filename)
    {
        include $filename;
    }
	// add license/functions folder files
	foreach (glob(trailingslashit( get_template_directory() ) . 'licenses/functions/*.php') as $filename)
	{
		include $filename;
	}

	// load text domain
	load_theme_textdomain('tracks', get_template_directory() . '/languages');
}
add_action( 'after_setup_theme', 'ct_tracks_theme_setup', 10 );

function ct_tracks_remove_cleaner_gallery() {

	if( class_exists( 'Jetpack' ) && ( Jetpack::is_module_active( 'carousel' ) || Jetpack::is_module_active( 'tiled-gallery' ) ) ) {
		remove_theme_support( 'cleaner-gallery' );
	}
}
add_action( 'after_setup_theme', 'ct_tracks_remove_cleaner_gallery', 11 );

function ct_tracks_register_widget_areas(){

    /* register after post content widget area */
    hybrid_register_sidebar( array(
        'name'         => __( 'After Post Content', 'tracks' ),
        'id'           => 'after-post-content',
        'description'  => __( 'Widgets in this area will be shown after post content before the prev/next post links', 'tracks' )
    ) );

    /* register after page content widget area */
    hybrid_register_sidebar( array(
        'name'         => __( 'After Page Content', 'tracks' ),
        'id'           => 'after-page-content',
        'description'  => __( 'Widgets in this area will be shown after page content', 'tracks' )
    ) );

	/* register footer widget area */
	hybrid_register_sidebar( array(
		'name'         => __( 'Footer', 'tracks' ),
		'id'           => 'footer',
		'description'  => __( 'Widgets in this area will be shown in the footer', 'tracks' ),
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	) );
}
add_action('widgets_init','ct_tracks_register_widget_areas');

/* added to customize the comments. Same as default except -> added use of gravatar images for comment authors */
function ct_tracks_customize_comments( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    global $post;
 
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <div class="comment-author">
                <?php
                // if is post author
                if( $comment->user_id === $post->post_author ) {
                    ct_tracks_profile_image_output();
                } else {
                    echo get_avatar( get_comment_author_email(), 72 );
                }
                ?>
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
    <?php
}

/* added HTML5 placeholders for each default field and aria-required to required */
function ct_tracks_update_fields($fields) {

	// get commenter object
    $commenter = wp_get_current_commenter();

	// are name and email required?
    $req = get_option( 'require_name_email' );

	// required or optional label to be added
	if( $req == 1 ) {
		$label = '*';
	} else {
		$label = ' (optional)';
	}

	// adds aria required tag if required
	$aria_req = ( $req ? " aria-required='true'" : '' );

    $fields['author'] =
        '<p class="comment-form-author">
            <label class="screen-reader-text">' . __("Your Name", "tracks") . '</label>
            <input placeholder="' . __("Your Name", "tracks") . $label . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30" ' . $aria_req . ' />
    	</p>';

    $fields['email'] =
        '<p class="comment-form-email">
            <label class="screen-reader-text">' . __("Your Email", "tracks") . '</label>
            <input placeholder="' . __("Your Email", "tracks") . $label . '" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30" ' . $aria_req . ' />
    	</p>';

    $fields['url'] =
        '<p class="comment-form-url">
            <label class="screen-reader-text">' . __("Your Website URL", "tracks") . '</label>
            <input placeholder="' . __("Your URL", "tracks") . ' (optional)" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30" />
            </p>';

    return $fields;
}
add_filter('comment_form_default_fields','ct_tracks_update_fields');

function ct_tracks_update_comment_field($comment_field) {
	
	$comment_field =
        '<p class="comment-form-comment">
            <label class="screen-reader-text">' . __("Your Comment", "tracks") . '</label>
            <textarea required placeholder="' . __("Enter Your Comment", "tracks") . '&#8230;" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
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

// excerpt handling
function ct_tracks_excerpt() {

    // make post variable available
    global $post;

    // make 'read more' setting available
    global $more;

    // get the 'show full post' setting
    $setting = get_theme_mod('premium_layouts_full_width_full_post');

    // check for the more tag
    $ismore = strpos( $post->post_content, '<!--more-->');

    // if show full post is on, and full-width layout is on, show full post unless on search page
    if(($setting == 'yes') && get_theme_mod('premium_layouts_setting') == 'full-width' && !is_search()){

        // set read more value for all posts to 'off'
        $more = -1;

        // output the full content
        the_content();
    }
    // use the read more link if present
    elseif($ismore) {
        the_content( __('Read More', 'tracks') . "<span class='screen-reader-text'>" . get_the_title() . "</span>");
    }
    // otherwise the excerpt is automatic, so output it
    else {
        the_excerpt();
    }
}

// filter the link on excerpts
function ct_tracks_excerpt_read_more_link($output) {
	global $post;
	return $output . "<p><a class='more-link' href='". get_permalink() ."'>" . __('Read the Post', 'tracks') . "<span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
}

add_filter('the_excerpt', 'ct_tracks_excerpt_read_more_link');

// change the length of the excerpts
function ct_tracks_custom_excerpt_length( $length ) {

    $new_excerpt_length = get_theme_mod('additional_options_excerpt_length_settings');

    // if there is a new length set and it's not 15, change it
    if(!empty($new_excerpt_length) && $new_excerpt_length != 15){
        return $new_excerpt_length;
    } else {
        return 15;
    }
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

// for displaying featured images including mobile versions and default versions
function ct_tracks_featured_image() {

    global $post;
    $has_image = false;

    $premium_layout = get_theme_mod('premium_layouts_setting');

    if (has_post_thumbnail( $post->ID ) ) {

        if( ( is_archive() || is_home() ) && $premium_layout != 'full-width' && $premium_layout != 'full-width-images' ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
        } else {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
        }
        $image = $image[0];
        $has_image = true;
    }
    if ($has_image == true) {

        // for layouts using img
        if($premium_layout == 'two-column-images'){ ?>
             <img class="featured-image" src='<?php echo $image; ?>' /><?php
        }
        elseif(
        ( ( is_archive() || is_home() ) && $premium_layout == 'full-width-images' && get_theme_mod('premium_layouts_full_width_image_height') == 'image' )
        || is_singular() && $premium_layout == 'full-width-images' && get_theme_mod('premium_layouts_full_width_image_height_post') == 'image' ) { ?>
            <img class="featured-image" src='<?php echo $image; ?>' /><?php
        }
        // otherwise, output the src as a bg image
        else {
            // if lazy loading is enabled
            if(get_theme_mod('additional_options_lazy_load_settings') == 'yes'){
                echo "<div class='featured-image lazy lazy-bg-image' data-background='$image'></div>";
            }
            // if lazy loading is NOT enabled
            else {
                echo "<div class='featured-image' style=\"background-image: url('" . $image . "')\"></div>";
            }
        }
    }
}

// puts site title & description in the title tag on front page
add_filter( 'wp_title', 'ct_tracks_add_homepage_title' );
function ct_tracks_add_homepage_title( $title )
{
    if( empty( $title ) && ( is_home() || is_front_page() ) ) {
        return get_bloginfo( 'title' ) . ' | ' . get_bloginfo( 'description' );
    }
    return $title;
}

/* add conditional classes for premium layouts */
function ct_tracks_body_class( $classes ) {

	$premium_layout_setting = get_theme_mod('premium_layouts_setting');

	if ( ! is_front_page() ) {
        $classes[] = 'not-front';
    }
    if (get_theme_mod('ct_tracks_header_color_setting') == 'dark'){
        $classes[] = 'dark-header';
    }
	if( empty( $premium_layout_setting ) || $premium_layout_setting == 'standard') {
		$classes[] = 'standard';
	}
    if( $premium_layout_setting == 'full-width'){
        $classes[] = 'full-width';

        if(get_theme_mod('premium_layouts_full_width_full_post') == 'yes'){
            $classes[] = 'full-post';
        }
    }
    elseif( $premium_layout_setting == 'full-width-images'){
        $classes[] = 'full-width-images';

        if( ( is_home() || is_archive() ) && get_theme_mod('premium_layouts_full_width_image_height') == '2:1-ratio'){
            $classes[] = 'ratio';
        }
        if( is_singular() && get_theme_mod('premium_layouts_full_width_image_height_post') == '2:1-ratio'){
            $classes[] = 'ratio';
        }
	    if(get_theme_mod('premium_layouts_full_width_image_style') == 'title'){
		    $classes[] = 'title-below';
	    }
    }
    elseif( $premium_layout_setting == 'two-column'){
        $classes[] = 'two-column';
    }
    elseif( $premium_layout_setting == 'two-column-images'){
        $classes[] = 'two-column-images';
    }
    if(get_theme_mod( 'ct_tracks_background_image_setting')){
        $classes[] = 'background-image-active';
    }
    if(get_theme_mod( 'ct_tracks_texture_display_setting') == 'yes'){
        $classes[] = 'background-texture-active';
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
    add_editor_style( 'styles/custom-editor-style.css' );
}
add_action( 'init', 'ct_tracks_add_editor_styles' );

function ct_tracks_post_class_update($classes){

	global $post;

    $remove = array();
    $remove[] = 'entry';

	// remove 'entry' class newer version of Hybrid Core adds
    if ( ! is_singular() ) {
        foreach ( $classes as $key => $class ) {

            if ( in_array( $class, $remove ) ){
                unset( $classes[ $key ] );
                $classes[] = 'excerpt';
            }
        }

	    // add image zoom class
	    $setting = get_theme_mod('additional_options_image_zoom_settings');
	    if( $setting != 'no-zoom' ) {
		    $classes[] = 'zoom';
	    }
    }
	// add class for posts with Featured Videos
	if( get_post_meta( $post->ID, 'ct_tracks_video_key', true ) ) {

		// only add on blog/archive if enabled
		if( is_home() || is_archive() ) {
			// if post has video enabled on blog
			if( get_post_meta( $post->ID, 'ct_tracks_video_display_key', true ) == 'both' ) {
				$classes[] = 'has-video';
			}
		} else {
			$classes[] = 'has-video';
		}
	}

    // if < 3.9
    if( version_compare( get_bloginfo('version'), '3.9', '<') ) {

        // add the has-post-thumbnail class
        if( has_post_thumbnail() ) {
            $classes[] = 'has-post-thumbnail';
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
    add_image_size('blog', 700, 350);
}

function ct_tracks_odd_even_post_class( $classes ) {

    // access the post object
    global $wp_query;

    // add even/odd class
    $classes[] = ($wp_query->current_post % 2 == 0) ? 'odd' : 'even';

    // add post # class
    $classes[] = "excerpt-" . ($wp_query->current_post + 1);

    return $classes;
}
add_filter ( 'post_class' , 'ct_tracks_odd_even_post_class' );

// array of social media site names
function ct_tracks_social_site_list(){

    $social_sites = array('twitter', 'facebook', 'google-plus', 'flickr', 'pinterest', 'youtube', 'vimeo', 'tumblr', 'dribbble', 'rss', 'linkedin', 'instagram', 'reddit', 'soundcloud', 'spotify', 'vine','yahoo', 'behance', 'codepen', 'delicious', 'stumbleupon', 'deviantart', 'digg', 'git', 'hacker-news', 'steam', 'vk', 'weibo', 'tencent-weibo', 'email' );
    return $social_sites;
}

// for above the post titles
function ct_tracks_category_link(){
    $category = get_the_category();
    $category_link = get_category_link( $category[0]->term_id );
    $category_name = $category[0]->cat_name;
    $html = "<a href='" . $category_link . "'>" . $category_name . "</a>";
    echo $html;
}

// retrieves the attachment ID from the file URL
function ct_tracks_get_image_id($url) {

    // Split the $url into two parts with the wp-content directory as the separator
    $parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

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

function ct_tracks_profile_image_output(){

    // use User's profile image, else default to their Gravatar
    if(get_the_author_meta('user_profile_image')){

        // get the id based on the image's URL
        $image_id = ct_tracks_get_image_id(get_the_author_meta('user_profile_image'));

        // retrieve the thumbnail size of profile image
        $image_thumb = wp_get_attachment_image($image_id, 'thumbnail');

        // display the image
        echo $image_thumb;

    } else {
        echo get_avatar( get_the_author_meta( 'ID' ), 72 );
    }
}

function ct_tracks_custom_css_output(){

    $custom_css = get_theme_mod('ct_tracks_custom_css_setting');

    /* output custom css */
    if($custom_css) {
        wp_add_inline_style('style', $custom_css);
    }
}
add_action('wp_enqueue_scripts','ct_tracks_custom_css_output');


function ct_tracks_background_image_output(){

    $background_image = get_theme_mod( 'ct_tracks_background_image_setting');

    if($background_image){

        $background_image_css = "
            .background-image {
                background-image: url('$background_image');
            }
        ";
        wp_add_inline_style('style', $background_image_css);
    }
}
add_action('wp_enqueue_scripts','ct_tracks_background_image_output');

function ct_tracks_background_texture_output(){

    $background_texture = get_theme_mod( 'ct_tracks_background_texture_setting');
    $background_texture_display = get_theme_mod('ct_tracks_texture_display_setting');

    if($background_texture && $background_texture_display == 'yes'){

        $background_texture_css = "
            .overflow-container {
                background-image: url('" . plugins_url() . "/tracks-background-textures/textures/$background_texture.png');
            }
        ";
        wp_add_inline_style('style', $background_texture_css);
    }
}
add_action('wp_enqueue_scripts','ct_tracks_background_texture_output');

// green checkmark icon used in Post Video input
function ct_tracks_green_checkmark_svg() {

	$svg = '<svg width="12px" height="13px" viewBox="0 0 12 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
				<desc>green checkmark icon</desc>
				<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				    <path d="M12.0000143,5.99999404 C12.0000143,2.68749009 9.3125111,-1.31130219e-05 6.00000715,-1.31130219e-05 C2.6875032,-1.31130219e-05 0,2.68749009 0,5.99999404 C0,9.31249799 2.6875032,12.0000012 6.00000715,12.0000012 C9.3125111,12.0000012 12.0000143,9.31249799 12.0000143,5.99999404 Z M10.031262,4.73436753 C10.031262,4.86718019 9.9843869,4.99218034 9.89063679,5.08593045 L5.64844423,9.32812301 C5.55469412,9.42187312 5.42188146,9.47656068 5.28906881,9.47656068 C5.16406866,9.47656068 5.031256,9.42187312 4.93750589,9.32812301 L2.10937751,6.49999464 C2.0156274,6.40624452 1.96875235,6.28124437 1.96875235,6.14843172 C1.96875235,6.01561906 2.0156274,5.8828064 2.10937751,5.78905629 L2.82031586,5.08593045 C2.91406597,4.99218034 3.03906612,4.93749277 3.17187878,4.93749277 C3.30469144,4.93749277 3.42969159,4.99218034 3.5234417,5.08593045 L5.28906881,6.85155755 L8.4765726,3.67186626 C8.57032272,3.57811615 8.69532287,3.52342859 8.82813552,3.52342859 C8.96094818,3.52342859 9.08594833,3.57811615 9.17969844,3.67186626 L9.89063679,4.3749921 C9.9843869,4.46874221 10.031262,4.60155487 10.031262,4.73436753 Z" id="" fill="#43C591"></path>
				</g>
			</svg>';

	return $svg;
}

// loading indicator used in Post Video input
function ct_tracks_loading_indicator_svg() {

	$svg = '<svg width="47px" height="50px" viewBox="0 0 47 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
			    <desc>loading icon</desc>
			    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			        <path d="M14.9464464,39.2142788 C14.9464464,36.8035617 12.9877387,34.8749879 10.6071555,34.8749879 C8.19643834,34.8749879 6.26786461,36.8035617 6.26786461,39.2142788 C6.26786461,41.624996 8.19643834,43.5535697 10.6071555,43.5535697 C12.9877387,43.5535697 14.9464464,41.624996 14.9464464,39.2142788 Z M27.9643191,45 C27.9643191,42.8604885 26.2466831,41.1428525 24.1071716,41.1428525 C21.9676601,41.1428525 20.2500241,42.8604885 20.2500241,45 C20.2500241,47.1395115 21.9676601,48.8571475 24.1071716,48.8571475 C26.2466831,48.8571475 27.9643191,47.1395115 27.9643191,45 Z M9.64286864,25.7142627 C9.64286864,23.0624738 7.47322319,20.8928284 4.82143432,20.8928284 C2.16964544,20.8928284 0,23.0624738 0,25.7142627 C0,28.3660516 2.16964544,30.535697 4.82143432,30.535697 C7.47322319,30.535697 9.64286864,28.3660516 9.64286864,25.7142627 Z M40.9821917,39.2142788 C40.9821917,37.345973 39.4754935,35.8392748 37.6071877,35.8392748 C35.7388819,35.8392748 34.2321837,37.345973 34.2321837,39.2142788 C34.2321837,41.0825846 35.7388819,42.5892828 37.6071877,42.5892828 C39.4754935,42.5892828 40.9821917,41.0825846 40.9821917,39.2142788 Z M15.9107333,12.2142466 C15.9107333,9.29125207 13.5301501,6.91066888 10.6071555,6.91066888 C7.68416095,6.91066888 5.30357775,9.29125207 5.30357775,12.2142466 C5.30357775,15.1372412 7.68416095,17.5178244 10.6071555,17.5178244 C13.5301501,17.5178244 15.9107333,15.1372412 15.9107333,12.2142466 Z M29.8928928,6.42852545 C29.8928928,3.23432521 27.3013718,0.642804265 24.1071716,0.642804265 C20.9129714,0.642804265 18.3214504,3.23432521 18.3214504,6.42852545 C18.3214504,9.62272568 20.9129714,12.2142466 24.1071716,12.2142466 C27.3013718,12.2142466 29.8928928,9.62272568 29.8928928,6.42852545 Z M46.2857695,25.7142627 C46.2857695,24.1171626 44.990009,22.8214021 43.3929089,22.8214021 C41.7958088,22.8214021 40.5000483,24.1171626 40.5000483,25.7142627 C40.5000483,27.3113628 41.7958088,28.6071233 43.3929089,28.6071233 C44.990009,28.6071233 46.2857695,27.3113628 46.2857695,25.7142627 Z M40.0179048,12.2142466 C40.0179048,10.8883522 38.9330821,9.80352947 37.6071877,9.80352947 C36.2812933,9.80352947 35.1964705,10.8883522 35.1964705,12.2142466 C35.1964705,13.5401411 36.2812933,14.6249638 37.6071877,14.6249638 C38.9330821,14.6249638 40.0179048,13.5401411 40.0179048,12.2142466 Z" id="" fill="#FFFFFF"></path>
			    </g>
			</svg>';

	return $svg;
}

// set the date format for new users
function ct_tracks_set_date_format() {

	// immediately set the date format
	if( get_option('ct_tracks_date_format_origin') != 'updated' ) {
		update_option('date_format', 'F j');

		// add option so never updates date format again. Allows users to change format.
		add_option('ct_tracks_date_format_origin', 'updated');
	}
}
add_action( 'admin_init', 'ct_tracks_set_date_format' );

function ct_tracks_toolbar_link( $wp_admin_bar ) {

	global $wp;

	// create argument array
	$args = array();

	// if front-end, customize and return to this page
	if( ! is_admin() ) {

		// get the current url
		$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );

		// add url to args array with template parameter
		$args['url'] = $current_url;

		// add the return url for when customizer closed
		$args['return'] = $current_url;

		// construct new url for preview
		$url = admin_url( 'customize.php' ) . '?' . http_build_query( $args );
	} else {

		// back-end, take to default customize page and return to admin
		$url = admin_url( 'customize.php' );
	}

	// Create parent nod
	$args = array(
		'id'    => 'ct_tracks_dashboard',
		'title' => 'Tracks Dashboard',
		'href'  => admin_url() . 'themes.php?page=tracks-options',
		'meta'  => array( 'class' => 'tracks-dashboard' )
	);
	$wp_admin_bar->add_node( $args );

	// Customize
	$args = array(
		'id'    => 'ct_tracks_dashboard_customize',
		'title' => 'Customize',
		'parent' => 'ct_tracks_dashboard',
		'href'  => $url,
		'meta'  => array( 'class' => 'tracks-dashboard-customize' )
	);
	$wp_admin_bar->add_node( $args );

	// Support
	$args = array(
		'id'    => 'ct_tracks_dashboard_support',
		'title' => 'Support',
		'parent' => 'ct_tracks_dashboard',
		'href'  => 'http://www.competethemes.com/documentation/tracks-support-center/',
		'meta'  => array( 'class' => 'tracks-dashboard-support', 'target' => '_blank' )
	);
	$wp_admin_bar->add_node( $args );

	// Upgrades
	$args = array(
		'id'    => 'ct_tracks_dashboard_upgrades',
		'title' => 'Upgrades',
		'parent' => 'ct_tracks_dashboard',
		'href'  => 'http://www.competethemes.com/tracks-theme-upgrades/',
		'meta'  => array( 'class' => 'tracks-dashboard-upgrades', 'target' => '_blank' )
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'ct_tracks_toolbar_link', 999 );

function ct_tracks_wp_backwards_compatibility() {

	// not using this function, simply remove it so use of "has_image_size" doesn't break < 3.9
	if( version_compare( get_bloginfo('version'), '3.9', '<') ) {
		remove_filter( 'image_size_names_choose', 'hybrid_image_size_names_choose' );
	}
}
add_action('init', 'ct_tracks_wp_backwards_compatibility');

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function ct_tracks_add_title_tag() {
        ?>
        <title><?php wp_title( ' | ' ); ?></title>
    <?php
    }
    add_action( 'wp_head', 'ct_tracks_add_title_tag' );
endif;