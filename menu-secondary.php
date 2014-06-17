<div id="menu-secondary" class="menu-container menu-secondary" role="navigation">

    <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'container_class' => 'menu', 'menu_class' => 'menu-secondary-items', 'menu_id' => 'menu-secondary-items', 'items_wrap' => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>', 'fallback_cb' => '') ); ?>

</div><!-- #menu-secondary .menu-container -->
