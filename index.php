<?php get_header(); ?>

<?php

/* Category header */
if(is_category()){ ?>
    <div class='archive-header'>
    <p>Category:</p>
    <h2><?php single_cat_title(); ?></h2>
    </div><?php
}
/* Tag header */
elseif(is_tag()){ ?>
    <div class='archive-header'>
    <p>Tag:</p>
    <h2><?php single_tag_title(); ?></h2>
    </div><?php
}
/* Author header */
elseif(is_author()){ ?>
    <div class='archive-header'>
    <p>These Posts are by:</p>
    <h2><?php echo get_the_author(); ?></h2>
    </div><?php
}

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
                get_template_part('content');
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

            if(get_theme_mod('premium_layouts_setting') == 'two-column-images'){
                get_template_part('licenses/content/content-two-column-images');
            }
            elseif(get_theme_mod('premium_layouts_setting') == 'full-width-images'){
                get_template_part('licenses/content/content-full-width-images');
            }
            else {
                get_template_part('content');
            }
        }
        /* Custom Post Types */
        else {
            get_template_part('content');
        }
    endwhile;
endif; ?>

<?php ct_tracks_post_navigation(); ?>
    
<?php get_footer(); ?>