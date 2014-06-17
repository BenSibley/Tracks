<!DOCTYPE html>

<!--[if lt IE 7 ]> <html class="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv/html5shiv.js"></script>
<![endif]-->
<!--[if IE 9 ]><html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

    <?php wp_head(); ?>

</head>


<body id="<?php print get_stylesheet(); ?>" <?php body_class('ct-body'); ?>>

<div class="overflow-container">
    <a class="skip-content" href="#main">Skip to content</a>
<header id="site-header" class="site-header" role="banner">

    <?php get_template_part( 'menu', 'secondary' ); // adds the secondary menu ?>

	<div id="title-info" class="title-info">
		<?php get_template_part('logo')  ?>    
	</div>
	
	<?php get_template_part( 'menu', 'primary' ); // adds the primary menu ?>

</header>
<div id="main" class="main" role="main">