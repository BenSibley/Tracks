<div class='entry'>
	<?php ct_tracks_featured_image(); ?>
	<div class='entry-header'>
		<h1 class='entry-title'><?php the_title(); ?></h1>
	</div>
	<div class="entry-container">
		<div class='entry-content'>
			<article>
				<?php the_content(); ?>
				<?php wp_link_pages( array(
					'before' => '<p class="singular-pagination">' . __( 'Pages:', 'tracks' ),
					'after'  => '</p>',
				) ); ?>
			</article>
		</div>
		<?php get_template_part( 'sidebar', 'after-page-content' ); ?>
	</div>
</div>