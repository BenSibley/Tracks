<?php get_header(); ?>

<?php get_template_part( 'content/archive-header' ); ?>

	<div id="loop-container" class="loop-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				ct_tracks_get_content_template();
			endwhile;
		endif;
		?>
	</div>

<?php

// include loop pagination except for on bbPress Forum root
if ( function_exists( 'is_bbpress' ) ) {
	if ( ! ( is_bbpress() && is_archive() ) ) {
		the_posts_pagination( array(
			'prev_text' => __( 'Previous', 'tracks' ),
			'next_text' => __( 'Next', 'tracks' )
		) );
	}
} else {
	the_posts_pagination( array(
		'prev_text' => __( 'Previous', 'tracks' ),
		'next_text' => __( 'Next', 'tracks' )
	) );
}

get_footer();