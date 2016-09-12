<div class='entry'>
	<div class="entry-meta">
		<span class="date"><?php echo get_the_date( 'F j' ); ?> / </span>
		<span class="author"><?php the_author_posts_link(); ?></span>
	</div>
	<div class='entry-header'>
		<h1 class='entry-title'><?php the_title(); ?></h1>
	</div>
	<div class="entry-container">
		<div class="entry-content">
			<article>
				<?php
				$image = wp_get_attachment_image($post->ID, 'full');
				$image_meta = wp_prepare_attachment_for_js($post->ID);
				?>
				<div class="attachment-container">
					<?php echo $image; ?>
					<span class="attachment-caption">
					<?php echo esc_html( $image_meta['caption'] ); ?>
				</span>
				</div>
				<?php echo wpautop( esc_html( $image_meta['description'] ) ); ?>
			</article>
			<nav class='further-reading'>
				<p class='prev'>
					<span><?php previous_image_link( false, __( 'Previous Image', 'tracks' ) ); ?></span>
				</p>

				<p class='next'>
					<span><?php next_image_link( false, __( 'Next Image', 'tracks' ) ); ?></span>
				</p>
			</nav>
		</div>
	</div>
</div>

