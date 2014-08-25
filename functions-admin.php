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
            'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
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

// add display option for post meta
function ct_tracks_customize_post_meta_display( $wp_customize ) {

    /* section */
    $wp_customize->add_section(
        'ct_tracks_post_meta_display',
        array(
            'title'      => esc_html__( 'Post Meta', 'tracks' ),
            'priority'   => 65,
            'capability' => 'edit_theme_options'
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'post_date_display_setting',
        array(
            'default'           => 'show',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
        )
    );
    /* control */
    $wp_customize->add_control(
        'post_date_display_setting',
        array(
            'type' => 'radio',
            'label' => 'Display date above post title?',
            'section' => 'ct_tracks_post_meta_display',
            'setting' => 'post_date_display_setting',
            'choices' => array(
                'show' => 'Show',
                'hide' => 'Hide'
            ),
        )
    );

    /* setting */
    $wp_customize->add_setting(
        'post_author_display_setting',
        array(
            'default'           => 'show',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
        )
    );
    /* control */
    $wp_customize->add_control(
        'post_author_display_setting',
        array(
            'type' => 'radio',
            'label' => 'Display author name above post title?',
            'section' => 'ct_tracks_post_meta_display',
            'setting' => 'post_author_display_setting',
            'choices' => array(
                'show' => 'Show',
                'hide' => 'Hide'
            ),
        )
    );

    /* setting */
    $wp_customize->add_setting(
        'post_category_display_setting',
        array(
            'default'           => 'show',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
        )
    );
    /* control */
    $wp_customize->add_control(
        'post_category_display_setting',
        array(
            'type' => 'radio',
            'label' => 'Display category above post title?',
            'section' => 'ct_tracks_post_meta_display',
            'setting' => 'post_category_display_setting',
            'choices' => array(
                'show' => 'Show',
                'hide' => 'Hide'
            ),
        )
    );
}
add_action( 'customize_register', 'ct_tracks_customize_post_meta_display' );

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

// allow users to switch to a dark header
function ct_tracks_customize_header_color( $wp_customize ) {

    // only add if background images or textures active
    $license_images = trim( get_option( 'ct_tracks_background_images_license_key_status' ) );
    $license_textures = trim( get_option( 'ct_tracks_background_textures_license_key_status' ) );

    if( $license_images == 'valid' || $license_textures == 'valid') {

        /* section */
        $wp_customize->add_section(
            'ct_tracks_header_color',
            array(
                'title'      => esc_html__( 'Header Color', 'tracks' ),
                'description' => esc_html__('Change to dark if your new background makes the menu hard to read.', 'tracks'),
                'priority'   => 81,
                'capability' => 'edit_theme_options'
            )
        );
        /* setting */
        $wp_customize->add_setting(
            'ct_tracks_header_color_setting',
            array(
                'default'           => 'light',
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'ct_tracks_sanitize_header_color_settings'
            )
        );
        /* control */
        $wp_customize->add_control(
            'ct_tracks_header_color_setting',
            array(
                'type' => 'radio',
                'label' => 'Light or dark header color?',
                'section' => 'ct_tracks_header_color',
                'setting' => 'ct_tracks_header_color_setting',
                'choices' => array(
                    'light' => 'Light',
                    'dark' => 'Dark',
                ),
            )
        );
    }
}
add_action( 'customize_register', 'ct_tracks_customize_header_color' );

/* sanitize input */
function ct_tracks_sanitize_header_color_settings($input){
    $valid = array(
        'light' => 'Light',
        'dark' => 'Dark',
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function ct_tracks_customizer_additional_options( $wp_customize ) {

    /* create custom control for number input */
    class ct_tracks_number_input_control extends WP_Customize_Control {
        public $type = 'number';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="number" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
            </label>
        <?php
        }
    }

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
        'additional_options_excerpt_length_settings',
        array(
            'default'           => 15,
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'absint',
        )
    );
    /* control */
    $wp_customize->add_control(
        new ct_tracks_number_input_control(
            $wp_customize, 'additional_options_excerpt_length_settings',
            array(
                'label' => 'Word count in automatic excerpts',
                'section' => 'ct_tracks_additional_options',
                'settings' => 'additional_options_excerpt_length_settings',
                'type' => 'number',
            )
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'additional_options_return_top_settings',
        array(
            'default'           => 'show',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings',
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
        'additional_options_author_meta_settings',
        array(
            'default'           => 'show',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings',
        )
    );
    /* control */
    $wp_customize->add_control(
        'additional_options_author_meta_settings',
        array(
            'type' => 'radio',
            'label' => 'Show author info box after posts?',
            'section' => 'ct_tracks_additional_options',
            'setting' => 'additional_options_author_meta_settings',
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
            'label' => 'Zoom-in blog images on hover?',
            'section' => 'ct_tracks_additional_options',
            'choices' => array(
                'zoom' => 'Zoom in',
                'no-zoom' => 'Do not zoom in'
            ),
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'additional_options_lazy_load_settings',
        array(
            'default'           => 'no',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization',
        )
    );
    /* control */
    $wp_customize->add_control(
        'additional_options_lazy_load_settings',
        array(
            'type' => 'radio',
            'label' => 'Lazy load images?',
            'section' => 'ct_tracks_additional_options',
            'choices' => array(
                'yes' => 'Yes',
                'no' => 'No'
            ),
        )
    );
}
add_action( 'customize_register', 'ct_tracks_customizer_additional_options' );

/* sanitize radio button input */
function ct_tracks_sanitize_all_show_hide_settings($input){
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

function ct_tracks_textures_array(){

    $textures = array(
        'binding_dark'   => '',
        'brickwall'   => '',
        'congruent_outline'  => '',
        'crossword'  => '',
        'escheresque_ste'  => '',
        'fabric_squares'  => '',
        'geometry'  => '',
        'grey_wash_wall'  => '',
        'halftone'  => '',
        'notebook'  => '',
        'office'  => '',
        'pixel_weave'  => '',
        'sativa'  => '',
        'shattered'  => '',
        'skulls'  => '',
        'snow'  => '',
        'sos'  => '',
        'sprinkles'  => '',
        'squared_metal'  => '',
        'stardust'  => '',
        'tweed'  => '',
        'small_steps'  => '',
        'restaurant_icons'  => '',
        'congruent_pentagon'  => '',
        'photography'  => '',
        'giftly'  => '',
        'food'  => '',
        'light_grey'  => '',
        'diagonal_waves'  => '',
        'otis_redding'  => '',
        'wild_oliva'  => '',
        'cream_dust'  => '',
        'back_pattern'  => '',
        'skelatal_weave'  => '',
        'retina_wood'  => '',
        'escheresque'  => '',
        'greyfloral'  => '',
        'diamond_upholstery'  => '',
        'hexellence'  => ''
    );

    return $textures;
}

// Background texture section
function ct_tracks_customize_background_texture($wp_customize){

    $license = trim( get_option( 'ct_tracks_background_textures_license_key_status' ) );

    // only add the background textures if license is valid
    if($license == 'valid'){

        /* section */
        $wp_customize->add_section(
            'ct_tracks_background_texture',
            array(
                'title'      => esc_html__( 'Background Texture', 'tracks' ),
                'description' => esc_html__('Use the Header Color section above if your new texture makes the menu hard to read.', 'tracks'),
                'priority'   => 83,
                'capability' => 'edit_theme_options'
            )
        );
        /* setting */
        $wp_customize->add_setting(
            'ct_tracks_texture_display_setting',
            array(
                'default'           => 'no',
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
            )
        );
        /* control */
        $wp_customize->add_control(
            'ct_tracks_texture_display_setting',
            array(
                'type' => 'radio',
                'label' => 'Enable background texture?',
                'section' => 'ct_tracks_background_texture',
                'setting' => 'ct_tracks_texture_display_setting',
                'choices' => array(
                    'yes' => 'Yes',
                    'no' => 'No',
                ),
            )
        );
        /* setting */
        $wp_customize->add_setting(
            'ct_tracks_background_texture_setting',
            array(
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'ct_tracks_background_texture_setting_sanitization',
            )
        );
        // textures from subtlepatterns.com
        $textures = ct_tracks_textures_array();

         /* control */
        $wp_customize->add_control(
            'ct_tracks_background_texture_setting',
            array(
                'label'          => __( 'Choose a Texture', 'tracks' ),
                'section'        => 'ct_tracks_background_texture',
                'settings'       => 'ct_tracks_background_texture_setting',
                'type'           => 'radio',
                'choices'        => $textures
            )
        );
    }
}
add_action( 'customize_register', 'ct_tracks_customize_background_texture' );

function ct_tracks_all_yes_no_setting_sanitization($input){

    $valid = array(
        'yes' => 'Yes',
        'no' => 'No',
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

function ct_tracks_background_texture_setting_sanitization($input){

    $textures = ct_tracks_textures_array();

    $valid = $textures;

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// Background images section
function ct_tracks_customize_background_image($wp_customize){

    $license = trim( get_option( 'ct_tracks_background_images_license_key_status' ) );

    // only add the background images if license is valid
    if($license == 'valid'){

        /* section */
        $wp_customize->add_section(
            'ct_tracks_background_image',
            array(
                'title'      => esc_html__( 'Background Image', 'tracks' ),
                'description' => esc_html__('Use the Header Color section above if your new background image makes the menu hard to read.', 'tracks'),
                'priority'   => 84,
                'capability' => 'edit_theme_options'
            )
        );
        /* setting */
        $wp_customize->add_setting(
            'ct_tracks_background_image_setting',
            array(
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        /* control */
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize, 'ct_tracks_background_image_setting',
                array(
                    'label'    => __( 'Background image', 'tracks' ),
                    'section'  => 'ct_tracks_background_image',
                    'settings' => 'ct_tracks_background_image_setting'
                )
            )
        );
    }
}
add_action( 'customize_register', 'ct_tracks_customize_background_image' );


// Premium Layouts section
function ct_tracks_customize_premium_layouts( $wp_customize ) {

    $available_templates = array('standard' => 'Standard');

    $full_width = trim( get_option( 'ct_tracks_full_width_license_key_status' ) );
    $full_width_images = trim( get_option( 'ct_tracks_full_width_images_license_key_status' ) );
    $two_column = trim( get_option( 'ct_tracks_two_column_license_key_status' ) );
    $two_column_images = trim( get_option( 'ct_tracks_two_column_images_license_key_status' ) );

    if($full_width == 'valid'){
        $available_templates['full-width'] = 'Full-width';
    }
    if($full_width_images == 'valid'){
        $available_templates['full-width-images'] = 'Full-width Images';
    }
    if($two_column == 'valid'){
        $available_templates['two-column'] = 'Two-Column';
    }
    if($two_column_images == 'valid'){
        $available_templates['two-column-images'] = 'Two-Column Images';
    }

    /* section */
    $wp_customize->add_section(
        'ct_tracks_premium_layouts',
        array(
            'title'      => esc_html__( 'Premium Layouts', 'tracks' ),
            'priority'   => 85,
            'capability' => 'edit_theme_options'
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'premium_layouts_setting',
        array(
            'default'           => 'standard',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts'
        )
    );
    /* control */
    $wp_customize->add_control(
        'premium_layouts_setting',
        array(
            'type' => 'select',
            'label' => 'Choose the layout for Tracks',
            'section' => 'ct_tracks_premium_layouts',
            'setting' => 'premium_layouts_setting',
            'choices' => $available_templates,
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'premium_layouts_full_width_image_height',
        array(
            'default'           => 'image',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_height'
        )
    );
    /* control */
    $wp_customize->add_control(
        'premium_layouts_full_width_image_height',
        array(
            'type' => 'radio',
            'label' => 'Image size on Blog',
            'section' => 'ct_tracks_premium_layouts',
            'setting' => 'premium_layouts_setting',
            'choices' => array(
                'image' => 'size based on image size',
                '2:1-ratio'   => '2:1 width/height ratio like posts'
            ),
        )
    );
    /* setting */
    $wp_customize->add_setting(
        'premium_layouts_full_width_full_post',
        array(
            'default'           => 'no',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
        )
    );
    /* control */
    $wp_customize->add_control(
        'premium_layouts_full_width_full_post',
        array(
            'type' => 'radio',
            'label' => 'Show full posts on Blog/Archives?',
            'section' => 'ct_tracks_premium_layouts',
            'setting' => 'premium_layouts_full_width_full_post',
            'choices' => array(
                'yes' => 'Yes',
                'no'   => 'No'
            ),
        )
    );
}
add_action( 'customize_register', 'ct_tracks_customize_premium_layouts' );

/* sanitize premium layout options */
function ct_tracks_sanitize_premium_layouts($input){
    $valid = array(
        'standard' => 'Standard',
        'full-width' => 'Full-width',
        'full-width-images' => 'Full-width Images',
        'two-column' => 'Two-Column',
        'two-column-images' => 'Two-Column Images',
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/* sanitize radio button input */
function ct_tracks_sanitize_premium_layouts_image_height($input){
    $valid = array(
        'image' => 'size based on image size',
        '2:1-ratio'   => '2:1 width/height ratio like posts'
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/* Custom CSS Section */
function ct_tracks_customizer_custom_css( $wp_customize ) {

    // Custom Textarea Control
    class ct_tracks_Textarea_Control extends WP_Customize_Control {
        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
        <?php
        }
    }
    // section
    $wp_customize->add_section(
        'ct-custom-css',
        array(
            'title'      => __( 'Custom CSS', 'tracks' ),
            'priority'   => 90,
            'capability' => 'edit_theme_options'
        )
    );
    // setting
    $wp_customize->add_setting(
        'ct_tracks_custom_css_setting',
        array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_textarea',
        )
    );
    // control
    $wp_customize->add_control(
        new ct_tracks_Textarea_Control(
            $wp_customize,
            'ct_tracks_custom_css_setting',
            array(
                'label'          => __( 'Add Custom CSS Here:', 'tracks' ),
                'section'        => 'ct-custom-css',
                'settings'       => 'ct_tracks_custom_css_setting',
            )
        ) );
}
add_action( 'customize_register', 'ct_tracks_customizer_custom_css' );

function ct_tracks_user_profile_image_setting( $user ) { ?>

    <table id="profile-image-table" class="form-table">

        <tr>
            <th><label for="user_profile_image"><?php _e( 'Profile image', 'tracks' ); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <img id="image-preview" src="<?php echo esc_url( get_the_author_meta( 'user_profile_image', $user->ID ) ); ?>" style="width:100px;"><br />
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="text" name="user_profile_image" id="user_profile_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_profile_image', $user->ID ) ); ?>" class="regular-text" />
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
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    update_user_meta( $user_id, 'user_profile_image', $_POST['user_profile_image'] );
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
        'steam' => 'vk_profile'
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