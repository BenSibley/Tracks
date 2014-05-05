<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
    <!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
    <!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
    <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv/html5shiv.js"></script>
    <![endif]-->
    <!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> <html class=""> <!--<![endif]-->
    
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title("",true); ?></title>

    <!-- set width to the device viewing the site -->
    <meta name="viewport" content="width=device-width" />

    <?php wp_head(); ?>

</head>

<body id="<?php print get_stylesheet(); ?>" <?php body_class('ct-body'); ?>>

<div class="overflow-container">
    <a class="skip-content" href="#main">Skip to content</a>
<header id="site-header" class="site-header" role="banner">

	<div class="title-info">
		<?php get_template_part('logo')  ?>    
	</div>
	
	<?php get_template_part( 'menu', 'primary' ); // adds the primary menu ?>

</header>
<div id="main" class="main" role="main">