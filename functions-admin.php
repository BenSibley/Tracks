<?php

// add logo uploader to customizer
function ct_tracks_customize_register_logo( $wp_customize ) {

	/* section */
	$wp_customize->add_section(
		'ct-upload',
		array(
			'title'      => esc_html__( 'Logo', 'tracks' ),
			'priority'   => 30,
			'capability' => 'edit_theme_options'
		)
	);
	/* setting */
	$wp_customize->add_setting(
		'logo_upload',
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
    /* control */
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
add_action( 'customize_register', 'ct_tracks_customize_register_logo' );

function ct_tracks_customize_social_icons($wp_customize) {

    /* create custom control for url input so http:// is automatically added */
    class ct_tracks_url_input_control extends WP_Customize_Control {
        public $type = 'url';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="url" <?php $this->link(); ?> value="<?php echo esc_url_raw( $this->value() ); ?>" />
            </label>
        <?php
        }
    }
    /* section */
    $wp_customize->add_section(
        'ct_tracks_social_icons',
        array(
        'title'          => 'Social Media Icons',
        'priority'       => 35,
    ) );
    /* setting */
    $wp_customize->add_setting(
        'social_icons_display_setting',
        array(
            'type'              => 'theme_mod',
            'default'           => 'no',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_social_icons_display'
        ) );
    /* control */
    $wp_customize->add_control(
        'social_icons_display_setting',
        array(
            'type' => 'radio',
            'label' => 'Where should the icons display?',
            'priority' => 1,
            'section' => 'ct_tracks_social_icons',
            'setting' => 'social_icons_display_setting',
            'choices' => array(
                'header-footer' => 'Header & Footer',
                'header' => 'Header',
                'footer' => 'Footer',
                'no' => 'Do not display'
            ),
        )
    );

    // array of social media site names
    $social_sites = ct_tracks_social_site_list();
    $priority = 5;

    foreach($social_sites as $social_site) {

        /* setting */
        $wp_customize->add_setting(
            "$social_site",
            array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw'
        ) );

        /* control */
        $wp_customize->add_control(
            new ct_tracks_url_input_control(
                $wp_customize, $social_site, array(
                    'label'   => $social_site, // brand name so no internationalization required
                    'section' => 'ct_tracks_social_icons',
                    'priority'=> $priority,
                )
            )
        );
        $priority = $priority + 5;
    }
}
add_action('customize_register', 'ct_tracks_customize_social_icons');

/* sanitize radio button input */
function ct_tracks_sanitize_social_icons_display($input){
    $valid = array(
        'header-footer' => 'Header & Footer',
        'header' => 'Header',
        'footer' => 'Footer',
        'no' => 'Do not display'
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// add search input option to customizer
function ct_tracks_customize_search_input( $wp_customize ) {

    /* section */
    $wp_customize->add_section(
        'ct_tracks_search_input',
        array(
            'title'      => esc_html__( 'Search Bar', 'tracks' ),
            'priority'   => 60,
            'capability' => 'edit_theme_options'
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'search_input_setting',
        array(
            'default'           => 'hide',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_return_top_settings' // reusing b/c same values
        )
    );
    /* control */
    $wp_customize->add_control(
        'search_input_setting',
        array(
            'type' => 'radio',
            'label' => 'Show search bar at top of site?',
            'section' => 'ct_tracks_search_input',
            'setting' => 'search_input_setting',
            'choices' => array(
                'show' => 'Show',
                'hide' => 'Hide'
            ),
        )
    );
}
add_action( 'customize_register', 'ct_tracks_customize_search_input' );

// add tagline display options to existing 'site title & tagline' section
function ct_tracks_customize_tagline_display( $wp_customize ) {

    /* section */
    $wp_customize->add_section(
        'ct_tracks_tagline_display',
        array(
            'title'      => esc_html__( 'Tagline Display', 'tracks' ),
            'priority'   => 25,
            'capability' => 'edit_theme_options'
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'tagline_display_setting',
        array(
            'default'           => 'header-footer',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_tagline_display'
        )
    );
    /* control */
    $wp_customize->add_control(
        'tagline_display_setting',
        array(
            'type' => 'radio',
            'label' => 'Where should the tagline display?',
            'default' => 'header-footer',
            'section' => 'ct_tracks_tagline_display',
            'setting' => 'tagline_display_setting',
            'choices' => array(
                'header-footer' => 'Header & Footer',
                'header' => 'Header',
                'footer' => 'Footer'
            ),
        )
    );
}
add_action( 'customize_register', 'ct_tracks_customize_tagline_display' );

/* sanitize radio button input */
function ct_tracks_sanitize_tagline_display($input){
    $valid = array(
        'header-footer' => 'Header & Footer',
        'header' => 'Header',
        'footer' => 'Footer'
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function ct_tracks_customizer_additional_options( $wp_customize ) {

    /* section */
    $wp_customize->add_section(
        'ct_tracks_additional_options',
        array(
            'title'      => esc_html__( 'Additional Options', 'tracks' ),
            'priority'   => 80,
            'capability' => 'edit_theme_options'
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'additional_options_return_top_settings',
        array(
            'default'           => 'show',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_return_top_settings',
        )
    );
    /* control */
    $wp_customize->add_control(
        'additional_options_return_top_settings',
        array(
            'type' => 'radio',
            'label' => 'Show scroll-to-top arrow?',
            'section' => 'ct_tracks_additional_options',
            'setting' => 'additional_options_return_top_settings',
            'choices' => array(
                'show' => 'Show',
                'hide' => 'Hide'
            ),
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'additional_options_image_zoom_settings',
        array(
            'default'           => 'zoom',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_image_zoom_settings',
        )
    );
    /* control */
    $wp_customize->add_control(
        'additional_options_image_zoom_settings',
        array(
            'type' => 'radio',
            'label' => 'Zoom-in blog images on hover',
            'section' => 'ct_tracks_additional_options',
            'choices' => array(
                'zoom' => 'Zoom in',
                'no-zoom' => 'Do not zoom in'
            ),
        )
    );
}
add_action( 'customize_register', 'ct_tracks_customizer_additional_options' );

/* sanitize radio button input */
function ct_tracks_sanitize_return_top_settings($input){
    $valid = array(
        'show' => 'Show',
        'hide' => 'Hide'
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/* sanitize radio button input */
function ct_tracks_sanitize_image_zoom_settings($input){
    $valid = array(
        'zoom' => 'Zoom',
        'no-zoom' => 'Do not Zoom'
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

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
        'steam' => 'steam_profile'
    );
    return $social_sites;
}

// add the social profile boxes to the user screen.  NEEDS sanitize callback?
function ct_tracks_add_social_profile_settings($user) {

    $social_sites = ct_tracks_social_array();

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

	$social_sites = ct_tracks_social_array();
   	
   	foreach ($social_sites as $key => $social_site) {
		if( isset( $_POST["$key-profile"] ) ){
			update_user_meta( $user_id, $social_site, esc_url_raw( $_POST["$key-profile"] ) );
		}
	}
}

add_action( 'personal_options_update', 'ct_tracks_save_social_profiles' );
add_action( 'edit_user_profile_update', 'ct_tracks_save_social_profiles' );