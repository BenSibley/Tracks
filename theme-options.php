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

        <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general'; ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=tracks-options&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>
            <a href="?page=tracks-options&tab=support" class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?>">Support</a>
            <a href="?page=tracks-options&tab=premium-layouts" class="nav-tab <?php echo $active_tab == 'premium-layouts' ? 'nav-tab-active' : ''; ?>">Premium Layouts</a>
            <a href="?page=tracks-options&tab=licenses" class="nav-tab <?php echo $active_tab == 'licenses' ? 'nav-tab-active' : ''; ?>">Licenses</a>
        </h2>
        <?php
        if($active_tab == 'general'){ ?>
            <div class="content-general content">
                <p>Thanks for downloading Tracks!</p>
                <h3>Getting Started</h3>
                <p>Here are a few steps to make your site pixel-perfect with Tracks:</p>
                <ul>
                    <li>Setup your menus (<a href="nav-menus.php">visit Menus page</a>)</li>
                    <li>Add your logo and social icons (<a href="customize.php">visit Theme Customizer</a>)</li>
                    <li>Add widgets after your posts and/or pages (<a href="widgets.php">visit Widgets page</a>)</li>
                    <li>Review Tracks on wordpress.org (<a href="http://wordpress.org/support/view/theme-reviews/tracks">review now</a>)</li>
                </ul>
                <p>If you want more help getting your site setup, we have <a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase/">detailed tutorials</a> in our knowledgebase.</p>
            </div>
        <?php }
        elseif($active_tab == 'support'){ ?>
            <div class="content-support content">
                <p>There are a few ways to get support for Tracks: </p>
                <ul>
                    <li>Find an answer on the knowledgebase (<a target="_blank" href="http://www.competethemes.com/documentation/tracks-knowledgebase">visit the Tracks Knowledgebase</a>)</li>
                    <li>Ask a question on the support forum (<a target="_blank" href="http://wordpress.org/support/theme/tracks">visit support forum</a>)</li>
                </ul>
            </div>
        <?php }
        elseif($active_tab == 'premium-layouts'){ ?>
            <div class="content-premium-layouts content">
                <h2>Upgrade your site with a new layout</h2>
                <p>Tracks has premium layouts you can unlock to take your site to the next level. <a target="_blank" href="http://www.competethemes.com/tracks-theme-upgrades/">Check out the upgrades gallery.</a></p>
                <div>
                    <h3>Two-column Layout</h3><span> - <a target="_blank" href="http://www.competethemes.com/tracks-theme-upgrades/tracks-two-column-layout/">View Layout</a></span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tracks-two-column-layout.png" />
                </div>
                <div>
                    <h3>Two-column Images Layout</h3><span> - <a target="_blank" href="http://www.competethemes.com/tracks-theme-upgrades/tracks-two-column-images-layout/">View Layout</a></span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tracks-two-column-images-layout.png" />
                </div>
                <div>
                    <h3>Full-width Layout</h3><span> - <a target="_blank" href="http://www.competethemes.com/tracks-theme-upgrades/tracks-full-width-layout/">View Layout</a></span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tracks-full-width-layout.png" />
                </div>
                <div>
                    <h3>Full-width Images Layout</h3><span> - <a target="_blank" href="http://www.competethemes.com/tracks-theme-upgrades/tracks-full-width-images-layout/">View Layout</a></span>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/tracks-full-width-images-layout.png" />
                </div>
            </div>
        <?php }
        else { ?>
            <div class="content-licenses content">

                <?php
                // create form for each layout option available
                $layouts = array('two_column', 'two_column_images', 'full_width', 'full_width_images');
                foreach($layouts as $layout){

                    $license 	= get_option( 'ct_tracks_' . $layout . '_license_key' );
                    $status 	= get_option( 'ct_tracks_'. $layout . '_license_key_status' );

                    ?>
                    <form method="post" action="options.php">
                        <?php settings_fields('ct_tracks_' . $layout . '_license'); ?>
                        <?php if( $status !== false && $status == 'valid' ) { ?>
                            <p class='valid'>License activated!</p>
                            <span>You can switch to your new layout in the "Premium Layouts" section in the <a href="customize.php">Customizer</a></span>
                        <?php } else { ?>
                            <p class='invalid'>License not active</p>
                        <?php } ?>
                        <table class="form-table">
                            <tbody>
                            <tr valign="top">
                                <th scope="row" valign="top">
                                    <?php
                                    if($layout == 'two_column'){
                                        _e('Two-Column Layout','tracks');
                                    }
                                    elseif($layout == 'two_column_images'){
                                        _e('Two-Column Images Layout','tracks');
                                    }
                                    elseif($layout == 'full_width'){
                                        _e('Full-width Layout','tracks');
                                    }
                                    elseif($layout == 'full_width_images'){
                                        _e('Full-width Images Layout','tracks');
                                    }
                                    ?>
                                </th>
                                <td>
                                    <input id="ct_tracks_<?php echo $layout; ?>_license_key" name="ct_tracks_<?php echo $layout; ?>_license_key" type="text" class="regular-text" placeholder="ex. 1d58ag920zf5e551bab24aa3d18e2c79" value="<?php echo esc_attr( $license ); ?>" />
                                    <label class="description" for="ct_tracks_<?php echo $layout; ?>_license_key"><?php _e('Enter your license key','tracks'); ?></label>
                                </td>
                            </tr>
                            <?php if( false !== $license ) { ?>
                                <tr valign="top">
                                    <th scope="row" valign="top">
                                        <?php _e('Activate License','tracks'); ?>
                                    </th>
                                    <td>
                                        <?php if( $status !== false && $status == 'valid' ) { ?>
                                            <?php wp_nonce_field( 'ct_tracks_' . $layout . '_nonce', 'ct_tracks_' . $layout . '_nonce' ); ?>
                                            <input type="submit" class="button-secondary" name="ct_tracks_<?php echo $layout; ?>_license_deactivate" value="<?php _e('Deactivate License','tracks'); ?>"/>
                                        <?php } else { ?>
                                            <?php wp_nonce_field( 'ct_tracks_' . $layout . '_nonce', 'ct_tracks_' . $layout . '_nonce' ); ?>
                                            <input type="submit" class="button-secondary" name="ct_tracks_<?php echo $layout; ?>_license_activate" value="<?php _e('Activate License','tracks'); ?>"/>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php submit_button('Save License'); ?>
                    </form>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php }

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