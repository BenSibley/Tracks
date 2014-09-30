<?php

// add profile image option for contributors roles and higher
function ct_tracks_user_profile_image_setting( $user ) { ?>

    <?php
    $user_id = get_current_user_id();

    // only added for contributors and above
    if ( ! current_user_can( 'edit_posts', $user_id ) ) return false;
    ?>

    <table id="profile-image-table" class="form-table">

        <tr>
            <th><label for="user_profile_image"><?php _e( 'Profile image', 'tracks' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <img id="image-preview" src="<?php echo esc_url( get_the_author_meta( 'user_profile_image', $user->ID ) ); ?>" style="width:100px;"><br />
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="text" name="user_profile_image" id="user_profile_image" value="<?php echo esc_url( get_the_author_meta( 'user_profile_image', $user->ID ) ); ?>" class="regular-text" />
                <!-- Outputs the save button -->
                <input type='button' id="user-profile-upload" class="button-primary" value="<?php _e( 'Upload Image', 'tracks' ); ?>"/><br />
                <span class="description"><?php _e( 'Upload an image here to use instead of your Gravatar. Perfectly square images will not be cropped.', 'tracks' ); ?></span>
            </td>
        </tr>

    </table><!-- end form-table -->
<?php } // additional_user_fields

add_action( 'show_user_profile', 'ct_tracks_user_profile_image_setting' );
add_action( 'edit_user_profile', 'ct_tracks_user_profile_image_setting' );

/**
 * Saves additional user fields to the database
 */
function ct_tracks_save_user_profile_image( $user_id ) {

    // only saves if the current user can edit user profiles
    if ( ! current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'user_profile_image', esc_url_raw( $_POST['user_profile_image'] ) );
}

add_action( 'personal_options_update', 'ct_tracks_save_user_profile_image' );
add_action( 'edit_user_profile_update', 'ct_tracks_save_user_profile_image' );

function ct_tracks_social_array(){

    $social_sites = array(
        'twitter' => 'twitter_profile',
        'facebook' => 'facebook_profile',
        'googleplus' => 'googleplus_profile',
        'pinterest' => 'pinterest_profile',
        'linkedin' => 'linkedin_profile',
        'youtube' => 'youtube_profile',
        'vimeo' => 'vimeo_profile',
        'tumblr' => 'tumblr_profile',
        'instagram' => 'instagram_profile',
        'flickr' => 'flickr_profile',
        'dribbble' => 'dribbble_profile',
        'rss' => 'rss_profile',
        'reddit' => 'reddit_profile',
        'soundcloud' => 'soundcloud_profile',
        'spotify' => 'spotify_profile',
        'vine' => 'vine_profile',
        'yahoo' => 'yahoo_profile',
        'behance' => 'behance_profile',
        'codepen' => 'codepen_profile',
        'delicious' => 'delicious_profile',
        'stumbleupon' => 'stumbleupon_profile',
        'deviantart' => 'deviantart_profile',
        'digg' => 'digg_profile',
        'git' => 'git_profile',
        'hacker-news' => 'hacker-news_profile',
        'steam' => 'steam_profile',
        'vk' => 'vk_profile',
        'weibo' => 'weibo_profile',
        'tencent-weibo' => 'tencent_weibo_profile',
        'email' => 'email_profile'
    );
    return $social_sites;
}

// add the social profile boxes to the user screen.
function ct_tracks_add_social_profile_settings($user) {

    $social_sites = ct_tracks_social_array();

    $user_id = get_current_user_id();

    // only added for contributors and above
    if ( ! current_user_can( 'edit_posts', $user_id ) ) return false;

    ?>
    <table class="form-table">
        <tr>
            <th><h3><?php _e('Social Profiles', 'tracks'); ?></h3></th>
        </tr>
        <?php
        foreach($social_sites as $key => $social_site) {
            ?>
            <tr>
                <th>
                    <?php if( $key == 'email' ) : ?>
                        <label for="<?php echo $key; ?>-profile"><?php echo ucfirst($key); ?> <?php _e('Address:', 'tracks'); ?></label>
                    <?php else : ?>
                        <label for="<?php echo $key; ?>-profile"><?php echo ucfirst($key); ?> <?php _e('Profile:', 'tracks'); ?></label>
                    <?php endif; ?>
                </th>
                <td>
                    <?php if( $key == 'email' ) : ?>
                        <input type='text' id='<?php echo $key; ?>-profile' class='regular-text' name='<?php echo $key; ?>-profile' value='<?php echo is_email(get_the_author_meta($social_site, $user->ID )); ?>' />
                    <?php else : ?>
                        <input type='url' id='<?php echo $key; ?>-profile' class='regular-text' name='<?php echo $key; ?>-profile' value='<?php echo esc_url(get_the_author_meta($social_site, $user->ID )); ?>' />
                    <?php endif; ?>
                </td>
            </tr>
        <?php }	?>
    </table>
<?php
}

add_action( 'show_user_profile', 'ct_tracks_add_social_profile_settings' );
add_action( 'edit_user_profile', 'ct_tracks_add_social_profile_settings' );

function ct_tracks_save_social_profiles($user_id) {

    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

    $social_sites = ct_tracks_social_array();

    foreach ($social_sites as $key => $social_site) {
        if( $key == 'email' ) {
            // if email, only accept 'mailto' protocol
            if( isset( $_POST["$key-profile"] ) ){
                update_user_meta( $user_id, $social_site, sanitize_email( $_POST["$key-profile"] ) );
            }
        } else {
            if( isset( $_POST["$key-profile"] ) ){
                update_user_meta( $user_id, $social_site, esc_url_raw( $_POST["$key-profile"] ) );
            }
        }
    }
}

add_action( 'personal_options_update', 'ct_tracks_save_social_profiles' );
add_action( 'edit_user_profile_update', 'ct_tracks_save_social_profiles' );