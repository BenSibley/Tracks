<div <?php post_class(); ?>>
	<?php
	echo '<a class="featured-image-link" href="' . esc_url( get_permalink() ) . '">';
	ct_tracks_featured_image();
	echo '</a>';
	?>
	<div class="excerpt-container">
		<div class="excerpt-meta">
			<?php get_template_part( 'content/post-meta' ); ?>
		</div>
		<div class='excerpt-header'>
			<h2 class='excerpt-title'>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
		</div>
		<div class='excerpt-content'>
			<article>
				<?php ct_tracks_excerpt(); ?>
			</article>
		</div>
	</div>
</div>