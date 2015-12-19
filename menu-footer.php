<?php if ( has_nav_menu( 'footer' ) ) : ?>
	<div id="menu-footer" class="menu-container menu-footer" role="navigation">
		<?php wp_nav_menu(
			array(
				'theme_location'  => 'footer',
				'container_class' => 'menu',
				'menu_class'      => 'menu-footer-items',
				'menu_id'         => 'menu-footer-items',
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'     => ''
			) ); ?>
	</div>
<?php endif;