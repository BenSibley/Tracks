<?php 

/* Add layout option in Customize. */
add_action( 'customize_register', 'ct_tracks_customize_register_logo' );

/**
 * Add logo upload in theme customizer screen.
 *
 * @since 1.0
 */
function ct_tracks_customize_register_logo( $wp_customize ) {

	/* Add the layout section. */
	$wp_customize->add_section(
		'ct-upload',
		array(
			'title'      => esc_html__( 'Logo', 'tracks' ),
			'priority'   => 60,
			'capability' => 'edit_theme_options'
		)
	);

	/* Add the 'logo' setting. */
	$wp_customize->add_setting(
		'logo_upload',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, 'logo_image',
				array(
					'label'    => esc_html__( 'Upload custom logo.', 'tracks' ),
					'section'  => 'ct-upload',
					'settings' => 'logo_upload',
			)
		)
	);

}

function ct_tracks_create_social_array() {

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
        'RSS' => 'rss_profile'
	);
	return $social_sites;
}

// add the social profile boxes to the user screen.  NEEDS sanitize callback?
function ct_tracks_add_social_profile_settings($user) {
	
	$social_sites = ct_tracks_create_social_array();
	
	?>	
    <table class="form-table">
        <tr>
            <th><h3>Social Profiles</h3></th>
        </tr>
        <?php
        	foreach($social_sites as $key => $social_site) {
  				?>      	
        		<tr>
					<td>
						<label for="<?php echo $key; ?>-profile"><?php echo ucfirst($key); ?> Profile:</label>
					</td>
					<td>
						<input type='url' id='<?php echo $key; ?>-profile' class='regular-text' name='<?php echo $key; ?>-profile' value='<?php echo esc_url_raw(get_the_author_meta($social_site, $user->ID )); ?>' />
					</td>
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

	$social_sites = ct_tracks_create_social_array();
   	
   	foreach ($social_sites as $key => $social_site) {
		if( isset( $_POST["$key-profile"] ) ){
			update_user_meta( $user_id, $social_site, esc_url_raw( $_POST["$key-profile"] ) );
		}
	}
}

add_action( 'personal_options_update', 'ct_tracks_save_social_profiles' );
add_action( 'edit_user_profile_update', 'ct_tracks_save_social_profiles' );

?>