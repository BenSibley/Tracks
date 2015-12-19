<?php if ( is_active_sidebar( 'after-page-content' ) ) : ?>
	<div class="sidebar sidebar-after-page-content" id="sidebar-after-page-content">
		<?php dynamic_sidebar( 'after-page-content' ); ?>
	</div>
<?php endif;