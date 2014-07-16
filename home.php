<?php get_header(); ?>

<?php

// The loop
if ( have_posts() ) :
    while (have_posts() ) :
        the_post();
        if(get_theme_mod('premium_layouts_setting') == 'two-column-images'){
            get_template_part('licenses/content/content-two-column-images');
        } else {
            get_template_part('content');
        }
    endwhile;
endif; ?>

           
<?php ct_tracks_post_navigation(); ?>
    
<?php get_footer(); ?>