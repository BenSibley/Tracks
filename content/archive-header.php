<?php

/* Category header */
if ( is_category() ) { ?>
	<div class='archive-header'>
	<span><?php _e('Category:', 'tracks'); ?></span>
	<h2><?php single_cat_title(); ?></h2>
	<?php if ( category_description() ) echo category_description(); ?>
	</div><?php
}
/* Tag header */
elseif ( is_tag() ) { ?>
	<div class='archive-header'>
	<span><?php _e('Tag:', 'tracks'); ?></span>
	<h2><?php single_tag_title(); ?></h2>
	<?php if ( tag_description() ) echo tag_description(); ?>
	</div><?php
}
/* Author header */
elseif ( is_author() ) { ?>
	<div class='archive-header'>
	<span><?php _e('These Posts are by:', 'tracks'); ?></span>
	<h2><?php the_author_meta( 'display_name' ); ?></h2>
	<?php if ( get_the_author_meta( 'description' ) ) echo '<p>' . get_the_author_meta( 'description' ) . '</p>'; ?>
	</div><?php
}