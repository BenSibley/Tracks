</div> <!-- .main -->

<footer class="site-footer" role="contentinfo">
    <h3>
        <a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('title'); ?></a>
    </h3>
    <p>
        <?php bloginfo('description'); ?>
    </p>
    <?php
        // add footer menu if set
        get_template_part( 'menu', 'footer' );
    ?>
    <?php
        // add social icons if set
        if( (get_theme_mod('social_icons_display_setting') == 'header-footer') || (get_theme_mod('social_icons_display_setting') == 'footer')){
            ct_tracks_social_icons_output();
        }
    ?>
    <div class="design-credit">
        <p><a href="http://www.competethemes.com/tracks/">Tracks WordPress Theme</a> by Compete Themes</p>
    </div>
</footer>
<button id="return-top" class="return-top">
    <i class="fa fa-arrow-up"></i>
</button>

</div><!-- .overflow-container -->

<?php wp_footer(); ?>
</body>
</html>