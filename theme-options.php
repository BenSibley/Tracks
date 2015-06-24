<?php

/* create theme options page */
function ct_tracks_register_theme_page(){
    add_theme_page( 'Tracks Dashboard', 'Tracks Dashboard', 'edit_theme_options', 'tracks-options', 'ct_tracks_options_content');
}
add_action( 'admin_menu', 'ct_tracks_register_theme_page' );

/* callback used to add content to options page */
function ct_tracks_options_content(){

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => admin_url('themes.php?page=tracks-options')
		),
		admin_url('customize.php')
	);
	?>
    <div id="tracks-dashboard-wrap" class="wrap">
        <h2><?php _e('Tracks Dashboard', 'tracks'); ?></h2>

        <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard'; ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=tracks-options&tab=dashboard" class="nav-tab <?php echo $active_tab == 'dashboard' ? 'nav-tab-active' : ''; ?>"><?php _e('Dashboard', 'tracks'); ?></a>
            <a href="?page=tracks-options&tab=licenses" class="nav-tab <?php echo $active_tab == 'licenses' ? 'nav-tab-active' : ''; ?>"><?php _e('Licenses', 'tracks'); ?></a>
        </h2>
        <?php
        if($active_tab == 'dashboard'){ ?>
            <div class="content-customization content">
                <h3><?php _e('Customization', 'tracks'); ?></h3>
                <p><?php _e('Click the "Customize" link in your menu, or use the button below to get started customizing Tracks', 'tracks'); ?>.</p>
                <p>
                    <a class="button-primary" href="<?php echo esc_url( $customizer_url ); ?>"><?php _e('Use Customizer', 'tracks') ?></a>
                </p>
            </div>
	        <div class="content-support content">
		        <h3><?php _e('Support', 'tracks'); ?></h3>
		        <p><?php _e("You can find the knowledgebase, changelog, forum, and more in the Tracks Support Center", "tracks"); ?>.</p>
		        <p>
			        <a target="_blank" class="button-primary" href="https://www.competethemes.com/documentation/tracks-support-center/"><?php _e('Visit Support Center', 'tracks'); ?></a>
		        </p>
	        </div>
	        <div class="content-premium-upgrades content">
		        <h3><?php _e('Premium Upgrades ($9-15)', 'tracks'); ?></h3>
		        <p><?php _e('Make your site more customizable and beautiful with premium upgrades', 'tracks');?>.</p>
		        <p><a target="_blank" class="button-primary" href="https://www.competethemes.com/tracks/tracks-theme-upgrades/"><?php _e('Visit Upgrades Gallery', 'tracks'); ?></a></p>
	        </div>
	        <div class="content content-resources">
		        <h3><?php _e('WordPress Resources', 'tracks'); ?></h3>
		        <p><?php _e("Save time and money searching for WordPress products by following our recommendations", "tracks"); ?>.</p>
		        <p>
			        <a target="_blank" class="button-primary" href="https://www.competethemes.com/wordpress-resources/"><?php _e('View Resources', 'tracks'); ?></a>
		        </p>
	        </div>
        <?php }
        elseif($active_tab == 'licenses'){ ?>
            <div class="content-licenses">
                <h3><?php _e('Premium Layouts', 'tracks'); ?></h3>
                <?php
                // array of available layouts
                $layouts = array('two_column', 'two_column_images', 'full_width', 'full_width_images');
                // create form for each layout
                ct_tracks_license_form_output($layouts);
                ?>
                <h3><?php _e('Premium Features', 'tracks'); ?></h3>
                <?php
                // array of available features
                $features = array('background_images', 'background_textures', 'featured_videos');
                // create form for each feature
                ct_tracks_license_form_output($features);
                ?>
            </div>
        <?php } ?>
    </div>
<?php }

// loop through array creating a license activation form for each upgrade
function ct_tracks_license_form_output($upgrades){

    $class = 'odd';

    foreach($upgrades as $upgrade){

        $license 	= get_option( 'ct_tracks_' . $upgrade . '_license_key' );
        $status 	= get_option( 'ct_tracks_'. $upgrade . '_license_key_status' );

        ?>
        <form class="<?php echo $class; ?>" method="post" action="options.php">
            <?php settings_fields('ct_tracks_' . $upgrade . '_license'); ?>
            <h4>
                <?php
                // No i18n because product names are Proper Names
                if($upgrade == 'two_column'){
                    echo 'Two-Column Layout';
                }
                elseif($upgrade == 'two_column_images'){
                    echo 'Two-Column Images Layout';
                }
                elseif($upgrade == 'full_width'){
                    echo 'Full-width Layout';
                }
                elseif($upgrade == 'full_width_images'){
                    echo 'Full-width Images Layout';
                }
                elseif($upgrade == 'background_images'){
                    echo 'Background Images';
                }
                elseif($upgrade == 'background_textures'){
                    echo 'Background Textures';
                }
                elseif($upgrade == 'featured_videos'){
	                echo 'Featured Videos';
                }
                ?>
            </h4>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row" valign="top"><?php _e('Save License', 'tracks'); ?></th>
                    <td>
                        <input id="ct_tracks_<?php echo $upgrade; ?>_license_key" name="ct_tracks_<?php echo $upgrade; ?>_license_key" type="text" class="regular-text" placeholder="ex. 1d58ag920zf5e551bab24aa3d18e2c79" value="<?php echo esc_attr( $license ); ?>" />
                        <label class="description" for="ct_tracks_<?php echo $upgrade; ?>_license_key"><?php _e('Enter your license key','tracks'); ?></label>
                    </td>
                </tr>
                <?php if( false !== $license ) { ?>
                    <tr valign="top">
                        <th scope="row" valign="top">
                            <?php _e('Activate License','tracks'); ?>
                        </th>
                        <td>
                            <?php if( $status !== false && $status == 'valid' ) { ?>
                                <?php wp_nonce_field( 'ct_tracks_' . $upgrade . '_nonce', 'ct_tracks_' . $upgrade . '_nonce' ); ?>
                                <input type="submit" class="button-secondary" name="ct_tracks_<?php echo $upgrade; ?>_license_deactivate" value="<?php _e('Deactivate License','tracks'); ?>"/>
                            <?php } else { ?>
                                <?php wp_nonce_field( 'ct_tracks_' . $upgrade . '_nonce', 'ct_tracks_' . $upgrade . '_nonce' ); ?>
                                <input type="submit" class="button-secondary" name="ct_tracks_<?php echo $upgrade; ?>_license_activate" value="<?php _e('Activate License','tracks'); ?>"/>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php if( $status !== false && $status == 'valid' ) {

	            // set variable for customizer url
	            $customizer_url = 'customize.php';

	            $textures_plugin_url = 'http://www.competethemes.com/wp-content/uploads/plugins/tracks-background-textures.zip';

                if($upgrade == 'background_images'){ ?>
                    <p class="valid"><?php printf( __('You can now add a background image using the "Background Image" section in the <a href="%s">Customizer</a>', 'tracks'), esc_url( $customizer_url ) ); ?>.</p><?php }
                elseif($upgrade == 'background_textures'){ ?>
                    <p class="valid"><?php printf( __("If you haven't already, please upload and activate the <a href='%s'>Background Texture plugin</a>", 'tracks'), esc_url( $textures_plugin_url ) ); ?>.</p><?php }
                elseif($upgrade == 'featured_videos'){ ?>
	                <p class="valid"><?php _e('You can now add videos to Posts and Pages. Use the Featured Videos box under the Post Editor to get started', 'tracks'); ?>.</p><?php }
                else { ?>
                    <p class="valid"><?php printf( __('You can now switch to your new layout in the "Premium Layouts" section in the <a href="%s">Customizer</a>', 'tracks'), esc_url( $customizer_url ) ); ?>.</p><?php }
            } ?>
            <?php submit_button('Save License'); ?>
        </form>
        <?php
        if($class == 'odd'){
            $class = 'even';
        } else {
            $class = 'odd';
        }
    }
}

/* Register the options so licenses can be saved to db */

function ct_tracks_full_width_register_option() {
    // creates our settings in the options table
    register_setting('ct_tracks_full_width_license', 'ct_tracks_full_width_license_key', 'ct_tracks_full_width_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_full_width_register_option');

function ct_tracks_full_width_images_register_option() {
    // creates our settings in the options table
    register_setting('ct_tracks_full_width_images_license', 'ct_tracks_full_width_images_license_key', 'ct_tracks_full_width_images_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_full_width_images_register_option');

function ct_tracks_two_column_register_option() {
    // creates our settings in the options table
    register_setting('ct_tracks_two_column_license', 'ct_tracks_two_column_license_key', 'ct_tracks_two_column_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_two_column_register_option');

function ct_tracks_two_column_images_register_option() {
    // creates our settings in the options table
    register_setting('ct_tracks_two_column_images_license', 'ct_tracks_two_column_images_license_key', 'ct_tracks_two_column_images_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_two_column_images_register_option');

function ct_tracks_background_images_register_option() {
    // creates our settings in the options table
    register_setting('ct_tracks_background_images_license', 'ct_tracks_background_images_license_key', 'ct_tracks_background_images_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_background_images_register_option');

function ct_tracks_background_textures_register_option() {
    // creates our settings in the options table
    register_setting('ct_tracks_background_textures_license', 'ct_tracks_background_textures_license_key', 'ct_tracks_background_textures_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_background_textures_register_option');

function ct_tracks_featured_videos_register_option() {
	// creates our settings in the options table
	register_setting('ct_tracks_featured_videos_license', 'ct_tracks_featured_videos_license_key', 'ct_tracks_featured_videos_sanitize_license' );
}
add_action('admin_init', 'ct_tracks_featured_videos_register_option');