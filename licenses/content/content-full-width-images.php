<div <?php post_class(); ?>>
    <?php
    // check for Featured Video
    $video = get_post_meta( $post->ID, 'ct_tracks_video_key', true );

    // if has a video, embed it instead of featured image
    if( $video ) {
	    echo '<div class="featured-video">';
	        echo ct_tracks_embed_video( $video );
	    echo '</div>';
    }
    // otherwise, output the featured image
    else {
	    ct_tracks_featured_image();
    }
    ?>
    <a class="overlay-link" href="<?php the_permalink(); ?>">
        <span class="screen-reader-text"><?php the_title(); ?></span>
    </a>
    <div class="excerpt-container">
        <div class='excerpt-header'>
            <h1 class='excerpt-title'><?php the_title(); ?></h1>
            <i class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
    <div class="overlay"></div>
</div>