<button id="toggle-navigation" class="toggle-navigation">
	<i class="fa fa-bars"></i>
</button>

<div id="menu-primary-tracks" class="menu-primary-tracks"></div>
<div id="menu-primary" class="menu-container menu-primary" role="navigation">

	<?php if ( get_bloginfo( 'description' ) && ( get_theme_mod( 'tagline_display_setting' ) != 'footer' ) ) : ?>
		<p class="site-description">
			<?php esc_html( bloginfo( 'description' ) ); ?>
		</p>
	<?php endif;

	wp_nav_menu(
		array(
			'theme_location'  => 'primary',
			'container_class' => 'menu',
			'menu_class'      => 'menu-primary-items',
			'menu_id'         => 'menu-primary-items',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'fallback_cb'     => 'ct_tracks_wp_page_menu'
		) ); ?>
</div>