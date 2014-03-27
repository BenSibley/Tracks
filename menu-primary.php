<span id="toggle-navigation" class="toggle-navigation"><i class="fa fa-bars"></i></span>

<div id="menu-primary-tracks" class="menu-primary-tracks"></div>
<div id="menu-primary" class="menu-container menu-primary">

    <p class="site-description"><?php bloginfo('description'); ?></p>

    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'menu', 'menu_class' => 'menu-primary-items', 'menu_id' => 'menu-primary-items') ); ?>

</div><!-- #menu-primary .menu-container -->
