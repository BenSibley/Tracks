<div <?php post_class(); ?>>
    <?php

    // if post has video enabled on blog
    if( get_post_meta( $post->ID, 'ct_tracks_video_display_key', true ) == 'both' ) {

	    // check for Featured Video
	    $video = get_post_meta( $post->ID, 'ct_tracks_video_key', true );

	    // if has a video, embed it instead of featured image
	    if ( $video ) {
		    echo '<div class="featured-video">';
		        echo wp_oembed_get( esc_url( $video ) );
		    echo '</div>';
	    } // otherwise, output the featured image
	    else {
	        ct_tracks_featured_image();
	    }
    }
    else {
		ct_tracks_featured_image();
    }
    ?>
    <a class="overlay-link" href="<?php the_permalink(); ?>">
        <span class="screen-reader-text"><?php the_title(); ?></span>
    </a>
    <div class="excerpt-container">
        <div class='excerpt-header'>
            <h1 class='excerpt-title'>
	            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h1>
            <i class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
    <div class="overlay"></div>
</div>