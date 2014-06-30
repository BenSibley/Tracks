<?php get_header(); ?>
    
<div class='archive-header'>
	<p>Category:</p>
    <h2><?php single_cat_title(); ?></h2>
</div>

<?php

// The loop
if ( have_posts() ) :
    while (have_posts() ) :
        the_post();
        get_template_part('content');
    endwhile;
endif; ?>

<?php ct_tracks_post_navigation(); ?>

<?php get_footer(); ?>