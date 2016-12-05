<?php

function ct_tracks_register_theme_page() {
	add_theme_page( __( 'Tracks Dashboard', 'tracks' ), __( 'Tracks Dashboard', 'tracks' ), 'edit_theme_options', 'tracks-options', 'ct_tracks_options_content' );
}
add_action( 'admin_menu', 'ct_tracks_register_theme_page' );

function ct_tracks_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => add_query_arg( 'page', 'tracks-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	$support_url = 'https://www.competethemes.com/documentation/tracks-support-center/';
	?>
	<div id="tracks-dashboard-wrap" class="wrap">
		<h2><?php _e( 'Tracks Dashboard', 'tracks' ); ?></h2>
		<?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'dashboard'; ?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=tracks-options&tab=dashboard"
			   class="nav-tab <?php echo $active_tab == 'dashboard' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Dashboard', 'tracks' ); ?></a>
			<a href="?page=tracks-options&tab=licenses"
			   class="nav-tab <?php echo $active_tab == 'licenses' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Licenses', 'tracks' ); ?></a>
		</h2>
		<?php
		if ( $active_tab == 'dashboard' ) { ?>
			<div class="content-boxes">
				<div class="content content-support">
					<h3><?php _e( 'Get Started', 'tracks' ); ?></h3>
					<p><?php _e( "Not sure where to start? The <strong>Tracks Getting Started Guide</strong> will take you step-by-step through every feature in Tracks.", "tracks" ); ?></p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/help/getting-started-tracks/"><?php _e( 'View Guide', 'tracks' ); ?></a>
					</p>
				</div>
				<?php if ( !function_exists( 'ct_tracks_pro_init' ) ) : ?>
					<div class="content-premium-upgrades content">
						<h3><?php _e( 'Tracks Pro Plugin', 'tracks' ); ?></h3>
						<p><?php _e( 'Make your site more customizable and beautiful with Tracks Pro', 'tracks' ); ?>.</p>
						<p><a target="_blank" class="button-primary"
						      href="https://www.competethemes.com/tracks-pro/"><?php _e( 'Visit Tracks Pro', 'tracks' ); ?></a>
						</p>
					</div>
				<?php endif; ?>
				<div class="content content-review">
					<h3><?php _e( 'Leave a Review', 'tracks' ); ?></h3>
					<p><?php _e( 'Help others find tracks by leaving a review on wordpress.org.', 'tracks' ); ?></p>
					<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/tracks/reviews/"><?php _e( 'Leave a Review', 'tracks' ); ?></a>
				</div>
			</div>
		<?php } elseif ( $active_tab == 'licenses' ) { ?>
			<div class="content-licenses">
				<?php do_action( 'tracks_before_licenses' ); ?>
				<h3><?php _e( 'Premium Layouts', 'tracks' ); ?></h3>
				<?php
				$layouts = array( 'two_column', 'two_column_images', 'full_width', 'full_width_images' );
				// create form for each layout
				ct_tracks_license_form_output( $layouts );
				?>
				<h3><?php _e( 'Premium Features', 'tracks' ); ?></h3>
				<?php
				$features = array( 'background_images', 'background_textures', 'featured_videos' );
				// create form for each feature
				ct_tracks_license_form_output( $features );
				?>
			</div>
		<?php } ?>
	</div>
<?php }

// loop through array creating a license activation form for each upgrade
function ct_tracks_license_form_output( $upgrades ) {

	$class = 'odd';

	foreach ( $upgrades as $upgrade ) {

		$license = get_option( 'ct_tracks_' . $upgrade . '_license_key' );
		$status  = get_option( 'ct_tracks_' . $upgrade . '_license_key_status' );

		?>
		<form class="<?php echo $class; ?>" method="post" action="options.php">
			<?php settings_fields( 'ct_tracks_' . $upgrade . '_license' ); ?>
			<h4>
				<?php
				// No i18n because product names are Proper Names
				if ( $upgrade == 'two_column' ) {
					echo 'Two-Column Layout';
				} elseif ( $upgrade == 'two_column_images' ) {
					echo 'Two-Column Images Layout';
				} elseif ( $upgrade == 'full_width' ) {
					echo 'Full-width Layout';
				} elseif ( $upgrade == 'full_width_images' ) {
					echo 'Full-width Images Layout';
				} elseif ( $upgrade == 'background_images' ) {
					echo 'Background Images';
				} elseif ( $upgrade == 'background_textures' ) {
					echo 'Background Textures';
				} elseif ( $upgrade == 'featured_videos' ) {
					echo 'Featured Videos';
				}
				?>
			</h4>
			<table class="form-table">
				<tbody>
				<tr valign="top">
					<th scope="row" valign="top"><?php _e( 'Save License', 'tracks' ); ?></th>
					<td>
						<input id="ct_tracks_<?php echo $upgrade; ?>_license_key"
						       name="ct_tracks_<?php echo $upgrade; ?>_license_key" type="text" class="regular-text"
						       placeholder="ex. 1d58ag920zf5e551bab24aa3d18e2c79"
						       value="<?php echo esc_attr( $license ); ?>"/>
						<label class="description"
						       for="ct_tracks_<?php echo $upgrade; ?>_license_key"><?php _e( 'Enter your license key', 'tracks' ); ?></label>
					</td>
				</tr>
				<?php if ( false !== $license ) { ?>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e( 'Activate License', 'tracks' ); ?>
						</th>
						<td>
							<?php if ( $status !== false && $status == 'valid' ) { ?>
								<?php wp_nonce_field( 'ct_tracks_' . $upgrade . '_nonce', 'ct_tracks_' . $upgrade . '_nonce' ); ?>
								<input type="submit" class="button-secondary"
								       name="ct_tracks_<?php echo $upgrade; ?>_license_deactivate"
								       value="<?php esc_attr_e( 'Deactivate License', 'tracks' ); ?>"/>
							<?php } else { ?>
								<?php wp_nonce_field( 'ct_tracks_' . $upgrade . '_nonce', 'ct_tracks_' . $upgrade . '_nonce' ); ?>
								<input type="submit" class="button-secondary"
								       name="ct_tracks_<?php echo $upgrade; ?>_license_activate"
								       value="<?php esc_attr_e( 'Activate License', 'tracks' ); ?>"/>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php if ( $status !== false && $status == 'valid' ) {

				$customizer_url = add_query_arg(
					array(
						'url'    => site_url(),
						'return' => add_query_arg( 'page', 'tracks-options', admin_url( 'themes.php' ) )
					),
					admin_url( 'customize.php' )
				);

				if ( $upgrade == 'background_images' ) { ?>
					<p class="valid"><?php printf( __( 'You can now add a background image using the "Background Image" section in the <a href="%s">Customizer</a>', 'tracks' ), esc_url( $customizer_url ) ); ?>
					.</p><?php } elseif ( $upgrade == 'background_textures' ) { ?>
					<p class="valid"><?php printf( __( "If you haven't already, please upload and activate the <a href='%s'>Background Texture plugin</a>", 'tracks' ), 'http://www.competethemes.com/wp-content/uploads/plugins/tracks-background-textures.zip' ); ?>
					.</p><?php } elseif ( $upgrade == 'featured_videos' ) { ?>
					<p class="valid"><?php _e( 'You can now add videos to Posts and Pages. Use the Featured Videos box under the Post Editor to get started', 'tracks' ); ?>
					.</p><?php } else { ?>
					<p class="valid"><?php printf( __( 'You can now switch to your new layout in the "Premium Layouts" section in the <a href="%s">Customizer</a>', 'tracks' ), esc_url( $customizer_url ) ); ?>
					.</p><?php }
			} ?>
			<?php submit_button( 'Save License' ); ?>
		</form>
		<?php
		$class = ( $class == 'odd' ) ? 'even' : 'odd';
	}
}

/* Register the options so licenses can be saved to db */
function ct_tracks_register_all_license_options() {
	register_setting( 'ct_tracks_full_width_license', 'ct_tracks_full_width_license_key', 'ct_tracks_full_width_sanitize_license' );
	register_setting( 'ct_tracks_full_width_images_license', 'ct_tracks_full_width_images_license_key', 'ct_tracks_full_width_images_sanitize_license' );
	register_setting( 'ct_tracks_two_column_license', 'ct_tracks_two_column_license_key', 'ct_tracks_two_column_sanitize_license' );
	register_setting( 'ct_tracks_two_column_images_license', 'ct_tracks_two_column_images_license_key', 'ct_tracks_two_column_images_sanitize_license' );
	register_setting( 'ct_tracks_background_images_license', 'ct_tracks_background_images_license_key', 'ct_tracks_background_images_sanitize_license' );
	register_setting( 'ct_tracks_background_textures_license', 'ct_tracks_background_textures_license_key', 'ct_tracks_background_textures_sanitize_license' );
	register_setting( 'ct_tracks_featured_videos_license', 'ct_tracks_featured_videos_license_key', 'ct_tracks_featured_videos_sanitize_license' );
}
add_action( 'admin_init', 'ct_tracks_register_all_license_options' );