<?php
if ( get_theme_mod( 'additional_options_author_meta_settings' ) == 'hide' ) {
	return;
}
?>
<div class="author-meta">
	<div class="author">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 72, '', get_the_author() ); ?>
		<span>
			<?php
			_e( 'Written by:', 'tracks' );
			the_author_posts_link();
			?>
        </span>
	</div>
	<div class="bio">
		<p><?php the_author_meta( 'description' ); ?></p>
		<?php get_template_part( 'content/author-social-icons' ); ?>
	</div>
</div>