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
			//'transport'         => 'postMessage'
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
						<input type='url' id='<?php echo $key; ?>-profile' class='regular-text' name='<?php echo $key; ?>-profile' value='<?php echo esc_attr(get_the_author_meta($social_site, $user->ID )); ?>' />
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

	$social_sites = ct_tracks_create_social_array();
   	
   	foreach ($social_sites as $key => $social_site) {
		if( isset( $_POST["$key-profile"] ) ){
			update_user_meta( $user_id, $social_site, esc_attr( $_POST["$key-profile"] ) );
		}
	}
}

add_action( 'personal_options_update', 'ct_tracks_save_social_profiles' );
add_action( 'edit_user_profile_update', 'ct_tracks_save_social_profiles' );

// adds widget that aside uses to give people access to support
function ct_tracks_add_dashboard_widget() {

	wp_add_dashboard_widget(
                 'ct_tracks_dashboard_widget',    // Widget slug.
                 'Support Dashboard',   // Title.
                 'ct_tracks_widget_contents' 	  // Display function.
        );	
        
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
 	global $wp_meta_boxes;
 	
 	// Get the regular dashboard widgets array 
 	// (which has our new widget already but at the end)
 	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
 	
 	// Backup and delete our new dashboard widget from the end of the array
 	$example_widget_backup = array( 'ct_tracks_dashboard_widget' => $normal_dashboard['ct_tracks_dashboard_widget'] );
 	unset( $normal_dashboard['ct_tracks_dashboard_widget'] );
 
 	// Merge the two arrays together so our widget is at the beginning
 	$sorted_dashboard = array_merge( $example_widget_backup, $normal_dashboard );
 
 	// Save the sorted array back into the original metaboxes 
 	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}
add_action( 'wp_dashboard_setup', 'ct_tracks_add_dashboard_widget' );

// outputs contents for widget created by aside_add_dashboard_widget
function ct_tracks_widget_contents() { ?>

    <ol>
        <li>For self-help, <a target="_blank" href="http://competethemes.com/documentation">visit the knowledgebase</a></li>
        <li>For support, <a target="_blank" href="http://wordpress.org/support/theme/tracks">visit the support forum</a></li>
        <li>If you like Tracks, <a target="_blank" href="http://wordpress.org/support/view/theme-reviews/tracks">take 1 minute to leave a review</a></li>
    </ol>
	
	<?php
}

?>