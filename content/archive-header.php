<?php

if ( is_home() ) {
	echo '<h1 class="screen-reader-text">' . esc_html( get_bloginfo("name") ) . ' ' . __('Posts', 'tracks') . '</h1>';
}

if ( ! is_archive() ) {
	return;
}
?>

<div class='archive-header'>
	<h1><?php the_archive_title(); ?></h1>
	<?php the_archive_description(); ?>
</div>