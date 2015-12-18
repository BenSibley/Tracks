<?php
if ( ! is_archive() ) {
	return;
}
?>

<div class='archive-header'>
	<h2><?php the_archive_title(); ?></h2>
	<?php the_archive_description(); ?>
</div>