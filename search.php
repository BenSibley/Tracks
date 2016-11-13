<?php get_header(); ?>
	<div class="search-box">
		<h1 class="entry-title">
			<?php
			global $wp_query;
			$total_results = $wp_query->found_posts;
			$s             = htmlentities( $s );
			if ( $total_results ) {
				printf( esc_html( _n( '%1$d search result for "%2$s"', '%1$d search results for "%2$s"', $total_results, 'tracks' ) ), $total_results, $s );
			} else {
				printf( esc_html__( 'No search results for "%s"', 'tracks' ), $s );
			}
			?>
		</h1>
		<?php get_search_form(); ?>
	</div>
	<div id="loop-container" class="loop-container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				/* Two-column Images Layout */
				if ( get_theme_mod( 'premium_layouts_setting' ) == 'two-column-images' ) {
					get_template_part( 'licenses/content/content-two-column-images' );
				} /* Full-width Images Layout */
				elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'full-width-images' ) {
					get_template_part( 'licenses/content/content-full-width-images' );
				} /* Blog - No Premium Layout */
				else {
					get_template_part( 'content', 'archive' );
				}
			endwhile;
		endif;
		?>
	</div>

<?php the_posts_pagination();

// only display bottom search bar if there are search results
$total_results = $wp_query->found_posts;
if ( $total_results ) {
	?>
	<div class="search-box bottom">
		<p><?php _e( "Can't find what you're looking for?  Try refining your search:", "tracks" ); ?></p>
		<?php get_search_form(); ?>
	</div>
<?php }

get_footer();