<div <?php post_class(); ?>>
	<?php ct_tracks_featured_image(); ?>
	<div class="entry-meta">
		<?php get_template_part( 'content/post-meta' ); ?>
	</div>
	<div class='entry-header'>
		<h1 class='entry-title'><?php the_title(); ?></h1>
	</div>
	<div class="entry-container">
		<div class="entry-content">
			<article>
				<?php the_content(); ?>
				<?php wp_link_pages( array(
					'before' => '<p class="singular-pagination">' . __( 'Pages:', 'tracks' ),
					'after'  => '</p>',
				) ); ?>
			</article>
		</div>
		<?php get_template_part( 'sidebar', 'after-post-content' ); ?>
		<div class='entry-meta-bottom'>
			<?php get_template_part( 'content/further-reading' ); ?>
			<?php get_template_part( 'content/category-links' ); ?>
			<?php get_template_part( 'content/tag-links' ); ?>
		</div>
		<?php get_template_part( 'content/author-meta' ); ?>
	</div>
</div>