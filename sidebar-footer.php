<?php if ( is_active_sidebar( 'footer' ) ) :
	$widgets      = get_option( 'sidebars_widgets' );
	$widget_count = count( $widgets['footer'] );
	?>
	<div class="sidebar sidebar-footer active-<?php echo $widget_count; ?>" id="sidebar-footer">
		<?php dynamic_sidebar( 'footer' ); ?>
	</div>
<?php endif;