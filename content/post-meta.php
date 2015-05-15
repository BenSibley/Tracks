<?php

// get the post meta display options
$post_date = get_theme_mod('post_date_display_setting');
$post_author = get_theme_mod('post_author_display_setting');
$post_category = get_theme_mod('post_category_display_setting');

// has to equal 'hide' in case still unset
if($post_date != 'hide'){ ?>
    <span class="date"><?php
	echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date('r') ) );
	?></span><?php
}
// if the date and either other meta item is displayed, add the separator
if($post_date != 'hide' && ($post_author != 'hide' || $post_category != 'hide')){ ?>
    <span> / </span><?php
}
// has to equal 'hide' in case still unset
if($post_author != 'hide'){ ?>
    <span class="author"><?php the_author_posts_link(); ?></span><?php
}
// if the author and category are present, add the separator
if($post_author != 'hide' && $post_category != 'hide' && has_term( '', 'category' ) ){ ?>
    <span> / </span><?php
}
// has to equal 'hide' in case still unset, and have the category taxonomy
if( $post_category != 'hide' && has_term( '', 'category' ) ){ ?>
    <span class="category">
    <?php ct_tracks_category_link();?>
    </span><?php
}
?>