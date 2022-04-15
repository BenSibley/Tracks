<!DOCTYPE html>
<!--[if IE 9 ]>
<html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>><!--<![endif]-->

<head>
	<?php wp_head(); ?>
</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class('ct-body'); ?>>
	<?php do_action('tracks_body_top'); ?>
	<?php
    if (function_exists('wp_body_open')) {
        wp_body_open();
    } else {
        do_action('wp_body_open');
    } ?>
	<div id="overflow-container" class="overflow-container">
		<a class="skip-content" href="#main"><?php esc_html_e('Skip to content', 'tracks'); ?></a>
		<?php
            // Elementor `header` location
            if (! function_exists('elementor_theme_do_location') || ! elementor_theme_do_location('header')) :
        ?>
		<header id="site-header" class="site-header" role="banner">
			<?php get_template_part('content/top-navigation'); ?>
			<?php do_action('tracks_after_top_navigation'); ?>
			<div class="container">
				<div id="title-info" class="title-info">
					<?php get_template_part('logo', '', ['context' => 'header'])?>
				</div>
				<?php get_template_part('menu', 'primary'); ?>
			</div>
		</header>
		<?php endif; ?>
		<?php do_action('tracks_after_header'); ?>
		<div id="main" class="main" role="main">
			<?php if (function_exists('yoast_breadcrumb')) {
            yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
        }
            do_action('tracks_main_top');
