<?php get_header(); ?>

<?php get_template_part('content/archive-header'); ?>

<div id="loop-container" class="loop-container">

    <?php
    // The loop
    if ( have_posts() ) :
        while (have_posts() ) :
            the_post();

            /* Blog */
            if(is_home()){

                /* Two-column Images Layout */
                if(get_theme_mod('premium_layouts_setting') == 'two-column-images'){
                    get_template_part('licenses/content/content-two-column-images');
                }
                /* Full-width Images Layout */
                elseif(get_theme_mod('premium_layouts_setting') == 'full-width-images'){
                    get_template_part('licenses/content/content-full-width-images');
                }
                /* Blog - No Premium Layout */
                else {
                    get_template_part('content', 'archive');
                }
            }
            /* Post */
            elseif(is_singular('post')){
                get_template_part('content');
                comments_template();
            }
            /* Page */
            elseif(is_page()){
                get_template_part('content', 'page');
                comments_template();
            }
            /* Attachment */
            elseif(is_attachment()){
                get_template_part( 'content', 'attachment' );
                comments_template();
            }
            /* Archive */
            elseif(is_archive()){

                /* check if bbPress is active */
                if( function_exists( 'is_bbpress' ) ) {

                    /* if is bbPress forum list */
                    if( is_bbpress() ) {
                        get_template_part( 'content/bbpress' );
                    }
                    /* normal archive */
                    else {
                        get_template_part('content', 'archive');
                    }
                }
                elseif(get_theme_mod('premium_layouts_setting') == 'two-column-images'){
                    get_template_part('licenses/content/content-two-column-images');
                }
                elseif(get_theme_mod('premium_layouts_setting') == 'full-width-images'){
                    get_template_part('licenses/content/content-full-width-images');
                }
                else {
                    get_template_part('content', 'archive');
                }
            }
            /* bbPress */
            elseif( function_exists( 'is_bbpress' ) && is_bbpress() ) {
                get_template_part( 'content/bbpress' );
            }
            /* Custom Post Types */
            else {
                get_template_part('content');
            }
        endwhile;
    endif; ?>

</div>

<?php

// include loop pagination except for on bbPress Forum root
if( function_exists( 'is_bbpress' ) ) {

    if( ! ( is_bbpress() && is_archive() ) ) {
        echo ct_tracks_loop_pagination();
    }

} else {
    echo ct_tracks_loop_pagination();
}

?>

<?php get_footer(); ?>