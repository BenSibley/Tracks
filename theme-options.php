<?php

function ct_tracks_register_theme_page()
{
    add_theme_page(
        sprintf(esc_html__('%s Dashboard', 'tracks'), wp_get_theme()),
        sprintf(esc_html__('%s Dashboard', 'tracks'), wp_get_theme()),
        'edit_theme_options',
        'tracks-options',
        'ct_tracks_options_content'
    );
}
add_action('admin_menu', 'ct_tracks_register_theme_page');

function ct_tracks_options_content()
{
    $pro_url = 'https://www.competethemes.com/tracks-pro/?utm_source=wp-dashboard&utm_medium=Dashboard&utm_campaign=Tracks%20Pro%20-%20Dashboard'; ?>
	<div id="tracks-dashboard-wrap" class="wrap tracks-dashboard-wrap">
		<h2><?php printf(esc_html__('%s Dashboard', 'tracks'), wp_get_theme()); ?></h2>
		<?php do_action('theme_options_before'); ?>
		<?php do_action('tracks_before_licenses'); ?>
		<div class="main">
			<?php if (function_exists('ct_tracks_pro_init')) : ?>
			<div class="thanks-upgrading" style="background-image: url(<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/bg-texture.png'; ?>)">
				<h3>Thanks for upgrading!</h3>
				<p>You can find the new features in the Customizer</p>
			</div>
			<?php endif; ?>
			<?php if (!function_exists('ct_tracks_pro_init')) : ?>
			<div class="getting-started">
				<h3>Get Started with Tracks</h3>
				<p>Follow this step-by-step guide to customize your website with Tracks:</p>
				<a href="https://www.competethemes.com/help/getting-started-tracks/" target="_blank">Read the Getting Started Guide</a>
			</div>
			<div class="pro">
				<h3>Customize More with Tracks Pro</h3>
				<p>Add 8 new customization features to your site with the <a href="<?php echo $pro_url; ?>" target="_blank">Tracks Pro</a> plugin.</p>
				<ul class="feature-list">
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/layouts.png'; ?>" />
						</div>
						<div class="text">
							<h4>New Layouts</h4>
							<p>New layouts help your content look and perform its best. You can switch to new layouts effortlessly from the Customizer, or from specific posts or pages.</p>
							<p>Tracks Pro adds 4 new layouts.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/custom-colors.png'; ?>" />
						</div>
						<div class="text">
							<h4>Custom Colors</h4>
							<p>Custom colors let you match the color of your site with your brand. Point-and-click to select a color, and watch your site update instantly.</p>
							<p>With 45 color controls, you can change the color of any element on your site.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/header-image.png'; ?>" />
						</div>
						<div class="text">
							<h4>Flexible Header Image</h4>
							<p>Header images welcome visitors and set your site apart. Upload your image and quickly resize it to the perfect size.</p>
							<p>Display the header image on just the homepage, or leave it sitewide and link it to the homepage.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/featured-videos.png'; ?>" />
						</div>
						<div class="text">
							<h4>Featured Videos</h4>
							<p>Featured Videos are an easy way to share videos in place of Featured Images. Instantly embed a Youtube video by copying and pasting its URL into an input.</p>
							<p>Tracks Pro auto-embeds videos from Youtube, Vimeo, DailyMotion, Flickr, Animoto, TED, Blip, Cloudup, FunnyOrDie, Hulu, Vine, WordPress.tv, and VideoPress.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/featured-sliders.png'; ?>" />
						</div>
						<div class="text">
							<h4>Featured Sliders</h4>
							<p>Featured Sliders are an easy way to share image sliders in place of Featured Images. Quickly add responsive sliders to any page or post.</p>
							<p>Tracks Pro integrates with the free Meta Slider plugin with styling and sizing controls for your sliders.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/background-images.png'; ?>" />
						</div>
						<div class="text">
							<h4>Background Images</h4>
							<p>Background images help you stand out from the rest. Upload a unique image to use as the backdrop for your site.</p>
							<p>Background images are automatically centered and sized to fit the screen.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/background-textures.png'; ?>" />
						</div>
						<div class="text">
							<h4>Background Textures</h4>
							<p>Background textures transform the look and feel of your site. Switch to a textured background with a click.</p>
							<p>Tracks Pro includes 39 bundled textures to choose from.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/page-backgrounds.png'; ?>" />
						</div>
						<div class="text">
							<h4>Page-specific Backgrounds</h4>
							<p>Page-specific background images make every Post feel unique. Easily upload an image for Posts or Pages to display in the background.</p>
							<p>Every Post and Page on your site can have a unique background image.</p>
						</div>
					</li>
				</ul>
				<p><a href="<?php echo $pro_url; ?>" target="_blank">Click here</a> to view Tracks Pro now, and see what it can do for your site.</p>
			</div>
			<div class="pro-ad" style="background-image: url(<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/bg-texture.png'; ?>)">
				<h3>Add Incredible Flexibility to Your Site</h3>
				<p>Start customizing with Tracks Pro today</p>
				<a href="<?php echo $pro_url; ?>" target="_blank">View Tracks Pro</a>
			</div>
			<?php endif; ?>
		</div>
		<div class="sidebar">
			<div class="dashboard-widget">
				<h4>More Amazing Resources</h4>
				<ul>
					<li><a href="https://www.competethemes.com/documentation/tracks-support-center/" target="_blank">Tracks Support Center</a></li>
					<li><a href="https://wordpress.org/support/theme/tracks" target="_blank">Support Forum</a></li>
					<li><a href="https://www.competethemes.com/help/tracks-changelog/" target="_blank">Changelog</a></li>
					<li><a href="https://www.competethemes.com/help/tracks-css-snippets/" target="_blank">CSS Snippets</a></li>
					<li><a href="https://www.competethemes.com/help/child-theme-tracks/" target="_blank">Starter child theme</a></li>
					<li><a href="https://www.competethemes.com/help/tracks-demo-data/" target="_blank">Tracks demo data</a></li>
					<li><a href="<?php echo $pro_url; ?>" target="_blank">Tracks Pro</a></li>
				</ul>
			</div>
			<div class="ad iawp">
				<div class="logo-container">
					<img width="308px" height="46px" src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/iawp.svg'; ?>" alt="Independent Analytics logo" />
				</div>
				<div class="features">
					<div class="title">Free WordPress Analytics Plugin</div>
					<ul>
						<li>Beautiful analytics dashboard</li>
						<li>Views & traffic sources</li>
						<li>Easy setup</li>
						<li>GDPR compliant</li>
						<li>Google Analytics alternative</li>
					</ul>
				</div>
				<div class="button">
					<a href="https://independentwp.com" target="_blank" data-product-name="Independent Analytics">Learn More</a>
				</div>
			</div>
			<div class="dashboard-widget">
				<h4>User Reviews</h4>
				<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/reviews.png'; ?>" />
				<p>Users are loving Tracks! <a href="https://wordpress.org/support/theme/tracks/reviews/?filter=5#new-post" target="_blank">Click here</a> to leave your own review.</p>
			</div>
			<div class="dashboard-widget">
				<h4>Reset Customizer Settings</h4>
				<p><b>Warning:</b> Clicking this buttin will erase the Tracks theme's current settings in the Customizer.</p>
				<form method="post">
					<input type="hidden" name="tracks_reset_customizer" value="tracks_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field('tracks_reset_customizer_nonce', 'tracks_reset_customizer_nonce'); ?>
						<?php submit_button('Reset Customizer Settings', 'delete', 'delete', false); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action('theme_options_after'); ?>
	</div>
<?php
}
