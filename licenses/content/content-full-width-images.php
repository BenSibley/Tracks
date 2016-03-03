<div <?php post_class(); ?>> <?php
	echo '<a class="full-width-featured-image" href="' . esc_url( get_permalink() ) . '">';
		ct_tracks_featured_image();
	echo '</a>';
    if( get_theme_mod('premium_layouts_full_width_image_style') == 'title' ) { ?>
	    <div class="excerpt-container">
		    <div class='excerpt-header'>
			    <h1 class='excerpt-title'>
				    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			    </h1>
		    </div>
	    </div>
    <?php } else { ?>
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
    <?php } ?>
</div>