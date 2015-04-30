<?php

/* Category header */
if(is_category()){ ?>
	<div class='archive-header'>
	<p><?php _e('Category:', 'tracks'); ?></p>
	<h2><?php single_cat_title(); ?></h2>
	</div><?php
}
/* Tag header */
elseif(is_tag()){ ?>
	<div class='archive-header'>
	<p><?php _e('Tag:', 'tracks'); ?></p>
	<h2><?php single_tag_title(); ?></h2>
	</div><?php
}
/* Author header */
elseif(is_author()){ ?>
	<div class='archive-header'>
	<p><?php _e('These Posts are by:', 'tracks'); ?></p><?php
	$author = get_userdata(get_query_var('author')); ?>
	<h2><?php echo $author->nickname; ?></h2>
	</div><?php
}