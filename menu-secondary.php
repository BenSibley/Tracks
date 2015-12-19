<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<div id="menu-secondary" class="menu-container menu-secondary" role="navigation">
		<button id="toggle-secondary-navigation" class="toggle-secondary-navigation"><i class="fa fa-plus"></i></button>
		<?php wp_nav_menu(
			array(
				'theme_location'  => 'secondary',
				'container_class' => 'menu',
				'menu_class'      => 'menu-secondary-items',
				'menu_id'         => 'menu-secondary-items',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'     => ''
			) ); ?>
	</div>
<?php endif;