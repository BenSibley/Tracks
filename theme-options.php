<?php

/* create theme options page */
function ct_tracks_register_theme_page(){
    add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'tracks-options', 'ct_tracks_options_content');
}
add_action( 'admin_menu', 'ct_tracks_register_theme_page' );

/* callback used to add content to options page */
function ct_tracks_options_content(){

    ?>

    <div id="tracks-dashboard-wrap" class="wrap">

        <h2>Tracks Dashboard</h2>

        <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'getting-started'; ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=tracks-options&tab=getting-started" class="nav-tab <?php echo $active_tab == 'getting-started' ? 'nav-tab-active' : ''; ?>">Getting Started</a>
            <a href="?page=tracks-options&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>">Support</a>
            <a href="?page=tracks-options&tab=premium-upgrades" class="nav-tab <?php echo $active_tab == 'premium-upgrades' ? 'nav-tab-active' : ''; ?>">Premium Upgrades</a>
            <a href="?page=tracks-options&tab=licenses" class="nav-tab <?php echo $active_tab == 'licenses' ? 'nav-tab-active' : ''; ?>">Licenses</a>
        </h2>
        <?php
        if($active_tab == 'getting-started'){ ?>
            <div class="content-getting-started content">
                <h3><?php _e('Start Customizing', 'tracks'); ?></h3>
                <p><?php _e('Thanks for downloading Tracks!', 'tracks'); ?></p>
                <p><?php _e("To start customizing Tracks, click the 'Customize' option in your menu, or use the button below to get started", 'tracks'); ?>.</p>
                <p>
                    <a class="button-primary" href="customize.php"><?php _e('Use Customizer', 'tracks') ?></a>
                </p>
            </div>
        <?php }
        elseif($active_tab == 'support'){ ?>
            <div class="content-support content">
                <h3><?php _e('Get Support', 'tracks'); ?></h3>
                <p><?php _e("You can find the knowledgebase, tutorials, support forum, and more in the Tracks Support Center", "tracks"); ?>.</p>
                <p>
                    <a target="_blank" class="button-primary" href="http://www.competethemes.com/documentation/tracks-support-center/"><?php _e('Visit Support Center', 'tracks'); ?></a>
                </p>
            </div>
        <?php }
        elseif($active_tab == 'premium-upgrades'){ ?>
            <div class="content-premium-upgrades content">
                <h3>Premium Upgrades ($9-15)</h3>
                <p>New layouts, features, and more. Make your site more customizable and beautiful with Tracks premium upgrades.</p>
                <p><a target="_blank" class="button-primary" href="http://www.competethemes.com/tracks-theme-upgrades/">Visit Upgrades Gallery</a></p>
            </div>
        <?php }
        elseif($active_tab == 'licenses'){ ?>
            <div class="content-licenses content">
                <h3>Premium Layouts</h3>
                <?php
                // array of available layouts
                $layouts = array('two_column', 'two_column_images', 'full_width', 'full_width_images');
                // create form for each layout
                ct_tracks_license_form_output($layouts);
                ?>
                <h3>Premium Features</h3>
                <?php
                // array of available features
                $features = array('background_images', 'background_textures');
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
                if($upgrade == 'two_column'){
                    _e('Two-Column Layout','tracks');
                }
                elseif($upgrade == 'two_column_images'){
                    _e('Two-Column Images Layout','tracks');
                }
                elseif($upgrade == 'full_width'){
                    _e('Full-width Layout','tracks');
                }
                elseif($upgrade == 'full_width_images'){
                    _e('Full-width Images Layout','tracks');
                }
                elseif($upgrade == 'background_images'){
                    _e('Background Images','tracks');
                }
                elseif($upgrade == 'background_textures'){
                    _e('Background Textures','tracks');
                }
                ?>
            </h4>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row" valign="top">Save License</th>
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
                if($upgrade == 'background_images'){ ?>
                    <p class="valid">You can add a background image now in the "Background Image" section in the <a href="customize.php">Customizer</a></p><?php }
                elseif($upgrade == 'background_textures'){ ?>
                    <p class="valid">You can add a background texture now in the "Background Texture" section in the <a href="customize.php">Customizer</a></p><?php }
                else { ?>
                    <p class="valid">You can switch to your new layout in the "Premium Layouts" section in the <a href="customize.php">Customizer</a></p><?php }
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