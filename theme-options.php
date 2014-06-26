<?php

/* create theme options page */
function ct_tracks_register_theme_page(){
add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'tracks-options', 'ct_tracks_options_content');
}
add_action( 'admin_menu', 'ct_tracks_register_theme_page' );

/* callback used to add content to options page */
function ct_tracks_options_content(){

    // working full-width license key - d7914cf73d39b04881aa79c82a67a181

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
            <h3>Quick-start Guide</h3>
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
            <p>premium layouts</p>
        </div>
    <?php }
    else { ?>
        <div class="content-licenses content">
            <p>You can assign your new layouts in the Theme Customizer in the "Premium Layouts" section after activating your license(s) below.</p>

            <?php
            // create form for each layout option available
            $layouts = array('full_width','full_width_images','two_column');
            foreach($layouts as $layout){

                $license 	= get_option( 'ct_tracks_' . $layout . '_license_key' );
                $status 	= get_option( 'ct_tracks_'. $layout . '_license_key_status' );

                ?>
                <hr />
                <form method="post" action="options.php">
                <?php settings_fields('ct_tracks_' . $layout . '_license'); ?>
                    <table class="form-table">
                        <tbody>
                        <tr valign="top">
                            <th scope="row" valign="top">
                                <?php
                                if($layout == 'full_width'){
                                    _e('Full-width Layout','tracks');
                                }
                                elseif($layout == 'full_width_images'){
                                    _e('Full-width Images Layout','tracks');
                                }
                                elseif($layout == 'two_column'){
                                    _e('Two-Column Layout','tracks');
                                }
                                ?>
                            </th>
                            <td>
                                <input id="ct_tracks_<?php echo $layout; ?>_license_key" name="ct_tracks_<?php echo $layout; ?>_license_key" type="text" class="regular-text" value="<?php echo esc_attr( $license ); ?>" />
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
                                        <span style="color:green;"><?php _e('active','tracks'); ?></span>
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
                    <p>Make sure to activate your license after saving it.</p>
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