<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_tracks_add_customizer_content' );

function ct_tracks_add_customizer_content( $wp_customize ) {

    /***** Add PostMessage Support *****/

    // Add postMessage support for site title and description.
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

    /***** Add Custom Controls *****/

    // create url input control
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

    // create number input control
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

    // create textarea control
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

    // create multi-checkbox/select control
    class ct_tracks_Multi_Checkbox_Control extends WP_Customize_Control {
        public $type = 'multi-checkbox';

        public function render_content() {

            if ( empty( $this->choices ) )
                return;
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <select id="comment-display-control" <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
                    <?php
                    foreach ( $this->choices as $value => $label ) {
                        $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
                        echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
                    }
                    ?>
                </select>
            </label>
        <?php }
    }

	// create dropdown menu control
	class ct_tracks_Dropdown_Control extends WP_Customize_Control {

		public $type = 'dropdown';

		public function render_content() {

			if ( empty( $this->choices ) )
				return;
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select id="dropdown-control" <?php $this->link(); ?> style="height: 100%;">
					<?php
					foreach ( $this->choices as $value => $label ) {
						$selected = ( $value == $this->value() ) ? selected( 1, 1, false ) : '';
						echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
					}
					?>
				</select>
			</label>
		<?php }
	}

    /***** Tagline Display *****/

    // section
    $wp_customize->add_section( 'ct_tracks_tagline_display', array(
        'title'      => __( 'Tagline Display', 'tracks' ),
        'priority'   => 25,
        'capability' => 'edit_theme_options'
    ) );
    // setting
    $wp_customize->add_setting( 'tagline_display_setting', array(
        'default'           => 'header-footer',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_tagline_display'
    ) );
    // control
    $wp_customize->add_control( 'tagline_display_setting', array(
        'type' => 'radio',
        'label' => __('Where should the tagline display?', 'tracks'),
        'default' => 'header-footer',
        'section' => 'ct_tracks_tagline_display',
        'setting' => 'tagline_display_setting',
        'choices' => array(
            'header-footer' => __('Header & Footer', 'tracks'),
            'header' => __('Header', 'tracks'),
            'footer' => __('Footer', 'tracks')
        ),
    ) );

    /***** Logo Upload *****/

    // section
    $wp_customize->add_section( 'ct-upload', array(
        'title'      => __( 'Logo', 'tracks' ),
        'priority'   => 30,
        'capability' => 'edit_theme_options'
    ) );
    // setting
    $wp_customize->add_setting( 'logo_upload', array(
        'default'           => '',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    // control
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize, 'logo_image', array(
            'label'    => __( 'Upload custom logo.', 'tracks' ),
            'section'  => 'ct-upload',
            'settings' => 'logo_upload',
        )
    ) );

    /***** Social Media Icons *****/

    // array of social media site names
    $social_sites = ct_tracks_social_site_list();

    // set priority to keep icons in order
    $priority = 5;

    // section
    $wp_customize->add_section( 'ct_tracks_social_icons', array(
        'title'       => __( 'Social Media Icons', 'tracks' ),
        'priority'    => 35,
        'description' => __( 'Add the URL for each of your social profiles.', 'tracks' )
    ) );
    // setting - display
    $wp_customize->add_setting( 'social_icons_display_setting', array(
        'type'              => 'theme_mod',
        'default'           => 'no',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_social_icons_display'
    ) );
    // control - display
    $wp_customize->add_control( 'social_icons_display_setting', array(
        'type' => 'radio',
        'label' => __('Where should the icons display?', 'tracks'),
        'priority' => 1,
        'section' => 'ct_tracks_social_icons',
        'setting' => 'social_icons_display_setting',
        'choices' => array(
            'header-footer' => __('Header & Footer', 'tracks'),
            'header' => __('Header', 'tracks'),
            'footer' => __('Footer', 'tracks'),
            'no' => __('Do not display', 'tracks')
        ),
    ) );

    // output social site setting/control pairs
    foreach($social_sites as $social_site) {

        if( $social_site == 'email' ) {

            // setting
            $wp_customize->add_setting( "$social_site", array(
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'ct_tracks_sanitize_email'
            ) );
            // control
            $wp_customize->add_control( $social_site, array(
                'label'    => __('Email Address', 'tracks'), // brand name so i18n not required
                'section'  => 'ct_tracks_social_icons',
                'priority' => $priority,
            ) );

            // increment priority to retain order
            $priority = $priority + 5;
        } else {

            $label = ucfirst( $social_site );

            if ( $social_site == 'google-plus' ) {
                $label = 'Google Plus';
            } elseif ( $social_site == 'rss' ) {
                $label = 'RSS';
            } elseif ( $social_site == 'soundcloud' ) {
                $label = 'SoundCloud';
            } elseif ( $social_site == 'slideshare' ) {
                $label = 'SlideShare';
            } elseif ( $social_site == 'codepen' ) {
                $label = 'CodePen';
            } elseif ( $social_site == 'stumbleupon' ) {
                $label = 'StumbleUpon';
            } elseif ( $social_site == 'deviantart' ) {
                $label = 'DeviantArt';
            } elseif ( $social_site == 'hacker-news' ) {
                $label = 'Hacker News';
            } elseif ( $social_site == 'whatsapp' ) {
                $label = 'WhatsApp';
            } elseif ( $social_site == 'qq' ) {
                $label = 'QQ';
            } elseif ( $social_site == 'vk' ) {
                $label = 'VK';
            } elseif ( $social_site == 'wechat' ) {
                $label = 'WeChat';
            } elseif ( $social_site == 'tencent-weibo' ) {
                $label = 'Tencent Weibo';
            } elseif ( $social_site == 'paypal' ) {
                $label = 'PayPal';
            }

            // setting
            $wp_customize->add_setting( $social_site, array(
                'type'              => 'theme_mod',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'esc_url_raw'
            ) );
            // control
            $wp_customize->add_control( new ct_tracks_url_input_control(
                $wp_customize, $social_site, array(
                    'label'   => $label, // brand name so i18n not required
                    'section' => 'ct_tracks_social_icons',
                    'priority'=> $priority,
                )
            ) );

            // increment priority to retain order
            $priority = $priority + 5;
        }
    }

    /***** Search Bar *****/

    // section
    $wp_customize->add_section( 'ct_tracks_search_input', array(
        'title'      => __( 'Search Bar', 'tracks' ),
        'priority'   => 60,
        'capability' => 'edit_theme_options'
    ) );
    // setting
    $wp_customize->add_setting( 'search_input_setting', array(
        'default'           => 'hide',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
    ) );
    // control
    $wp_customize->add_control( 'search_input_setting', array(
        'type' => 'radio',
        'label' => __('Show search bar at top of site?', 'tracks'),
        'section' => 'ct_tracks_search_input',
        'setting' => 'search_input_setting',
        'choices' => array(
            'show' => __('Show', 'tracks'),
            'hide' => __('Hide', 'tracks')
        ),
    ) );

    /***** Post Meta Display *****/

    // section
    $wp_customize->add_section( 'ct_tracks_post_meta_display', array(
        'title'      => __( 'Post Meta', 'tracks' ),
        'priority'   => 65,
        'capability' => 'edit_theme_options'
    ) );
    // setting - date
    $wp_customize->add_setting( 'post_date_display_setting', array(
        'default'           => 'show',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
    ) );
    // control - date
    $wp_customize->add_control( 'post_date_display_setting', array(
        'type' => 'radio',
        'label' => __('Display date above post title?', 'tracks'),
        'section' => 'ct_tracks_post_meta_display',
        'setting' => 'post_date_display_setting',
        'choices' => array(
            'show' => __('Show', 'tracks'),
            'hide' => __('Hide', 'tracks')
        ),
    ) );
    // setting - author
    $wp_customize->add_setting( 'post_author_display_setting', array(
        'default'           => 'show',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
    ) );
    // control - author
    $wp_customize->add_control( 'post_author_display_setting', array(
        'type' => 'radio',
        'label' => __('Display author name above post title?', 'tracks'),
        'section' => 'ct_tracks_post_meta_display',
        'setting' => 'post_author_display_setting',
        'choices' => array(
            'show' => __('Show', 'tracks'),
            'hide' => __('Hide', 'tracks')
        ),
    ) );
    // setting - category
    $wp_customize->add_setting( 'post_category_display_setting', array(
        'default'           => 'show',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
    ) );
    // control - category
    $wp_customize->add_control( 'post_category_display_setting', array(
        'type' => 'radio',
        'label' => __('Display category above post title?', 'tracks'),
        'section' => 'ct_tracks_post_meta_display',
        'setting' => 'post_category_display_setting',
        'choices' => array(
            'show' => __('Show', 'tracks'),
            'hide' => __('Hide', 'tracks')
        ),
    ) );

    /***** Comment Display *****/

    // section
    $wp_customize->add_section( 'ct_tracks_comments_display', array(
        'title'      => __( 'Comments', 'tracks' ),
        'priority'   => 70,
        'capability' => 'edit_theme_options'
    ) );
    // setting
    $wp_customize->add_setting( 'ct_tracks_comments_setting', array(
        'default'           => array('post','page','attachment','none'),
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_comments_setting',
    ) );
    // control
    $wp_customize->add_control( new ct_tracks_Multi_Checkbox_Control(
        $wp_customize, 'ct_tracks_comments_setting', array(
            'label'          => __( 'Show comments on:', 'tracks' ),
            'section'        => 'ct_tracks_comments_display',
            'settings'       => 'ct_tracks_comments_setting',
            'type'           => 'multi-checkbox',
            'choices'        => array(
                'posts'       => __('Posts', 'tracks'),
                'pages'       => __('Pages', 'tracks'),
                'attachments' => __('Attachments', 'tracks'),
                'none'        => __('Do not show', 'tracks')
            )
        )
    ) );

    /***** Footer Text *****/

    // section
    $wp_customize->add_section( 'ct-footer-text', array(
        'title'      => __( 'Footer Text', 'tracks' ),
        'priority'   => 75,
        'capability' => 'edit_theme_options'
    ) );
    // setting
    $wp_customize->add_setting( 'ct_tracks_footer_text_setting', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    // control
    $wp_customize->add_control( new ct_tracks_Textarea_Control(
        $wp_customize, 'ct_tracks_footer_text_setting', array(
            'label'          => __( 'Edit the text in your footer', 'tracks' ),
            'section'        => 'ct-footer-text',
            'settings'       => 'ct_tracks_footer_text_setting',
        )
    ) );

    /***** Custom CSS *****/

    // section
    $wp_customize->add_section( 'ct-custom-css', array(
        'title'      => __( 'Custom CSS', 'tracks' ),
        'priority'   => 80,
        'capability' => 'edit_theme_options'
    ) );
    // setting
    $wp_customize->add_setting( 'ct_tracks_custom_css_setting', array(
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
        'transport'         => 'postMessage'
    ) );
    // control
    $wp_customize->add_control( new ct_tracks_Textarea_Control(
        $wp_customize, 'ct_tracks_custom_css_setting', array(
            'label'          => __( 'Add Custom CSS Here:', 'tracks' ),
            'section'        => 'ct-custom-css',
            'settings'       => 'ct_tracks_custom_css_setting',
        )
    ) );

    /***** Premium Layout *****/

    // set the available templates to just the standard layout
    $available_templates = array('standard' => 'Standard');

    // query database to get layout license statuses
    $full_width = trim( get_option( 'ct_tracks_full_width_license_key_status' ) );
    $full_width_images = trim( get_option( 'ct_tracks_full_width_images_license_key_status' ) );
    $two_column = trim( get_option( 'ct_tracks_two_column_license_key_status' ) );
    $two_column_images = trim( get_option( 'ct_tracks_two_column_images_license_key_status' ) );

    // check if any layout statuses are valid, and add to available layouts if they are
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

    // section
    $wp_customize->add_section( 'ct_tracks_premium_layouts',array(
        'title'      => __( 'Premium Layouts', 'tracks' ),
        'priority'   => 85,
        'capability' => 'edit_theme_options'
    ) );
    // setting - layout select
    $wp_customize->add_setting( 'premium_layouts_setting', array(
        'default'           => 'standard',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts'
    ) );

	$tracks_upgrades = 'https://www.competethemes.com/tracks/tracks-theme-upgrades/';

	$description_layout = sprintf( __('Want more layouts? Check out the <a target="_blank" href="%s">Tracks Theme Upgrades</a>.', 'tracks'), $tracks_upgrades );

    // control - layout select
    $wp_customize->add_control( 'premium_layouts_setting', array(
        'type'        => 'select',
        'label'       => __('Choose the layout for Tracks', 'tracks'),
	    'description' => $description_layout,
        'section'     => 'ct_tracks_premium_layouts',
        'setting'     => 'premium_layouts_setting',
        'choices'     => $available_templates, // no i18n b/c product names
    ) );
    // setting - full-width image height
    $wp_customize->add_setting( 'premium_layouts_full_width_image_height', array(
        'default'           => 'image',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_height'
    ) );
    // control - full-width image height
    $wp_customize->add_control( 'premium_layouts_full_width_image_height', array(
        'type' => 'radio',
        'label' => __('Image size on Blog', 'tracks'),
        'section' => 'ct_tracks_premium_layouts',
        'setting' => 'premium_layouts_setting',
        'choices' => array(
            'image' => _x('size based on image size', 'size of the featured image', 'tracks'),
            '2:1-ratio'   => _x('2:1 width/height ratio like posts', 'size of the featured image', 'tracks')
        ),
    ) );
    // setting - full-width image height post
    $wp_customize->add_setting( 'premium_layouts_full_width_image_height_post', array(
        'default'           => 'image',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_height'
    ) );
    // control - full-width image height
    $wp_customize->add_control( 'premium_layouts_full_width_image_height_post', array(
        'type' => 'radio',
        'label' => __('Image size on Posts', 'tracks'),
        'section' => 'ct_tracks_premium_layouts',
        'setting' => 'premium_layouts_setting',
        'choices' => array(
            'image' => _x('size based on image size', 'size of the featured image', 'tracks'),
            '2:1-ratio'   => _x('2:1 width/height ratio like posts', 'size of the featured image', 'tracks')
        ),
    ) );
	// setting - full-width image style
	$wp_customize->add_setting( 'premium_layouts_full_width_image_style', array(
		'default'           => 'overlay',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_style'
	) );
	// control - full-width image style
	$wp_customize->add_control( 'premium_layouts_full_width_image_style', array(
		'type' => 'radio',
		'label' => __('Style', 'tracks'),
		'section' => 'ct_tracks_premium_layouts',
		'setting' => 'premium_layouts_setting',
		'choices' => array(
			'overlay' => __('Overlay', 'tracks'),
			'title'   => __('Title below', 'tracks')
		),
	) );
    // setting - full-width full post
    $wp_customize->add_setting( 'premium_layouts_full_width_full_post', array(
        'default'           => 'no',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
    ) );
    // control - full-width full post
    $wp_customize->add_control( 'premium_layouts_full_width_full_post', array(
        'type' => 'radio',
        'label' => __('Show full posts on Blog/Archives?', 'tracks'),
        'section' => 'ct_tracks_premium_layouts',
        'setting' => 'premium_layouts_full_width_full_post',
        'choices' => array(
            'yes' => __('Yes', 'tracks'),
            'no'   => __('No', 'tracks')
        ),
    ) );

    /***** Additional Options *****/

    // section
    $wp_customize->add_section( 'ct_tracks_additional_options', array(
        'title'      => __( 'Additional Options', 'tracks' ),
        'priority'   => 90,
        'capability' => 'edit_theme_options'
    ) );
    // setting - return to top arrow
    $wp_customize->add_setting( 'additional_options_return_top_settings', array(
        'default'           => 'show',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings',
    ) );
    // control - return to top arrow
    $wp_customize->add_control( 'additional_options_return_top_settings', array(
        'type' => 'radio',
        'label' => __('Show scroll-to-top arrow?', 'tracks'),
        'section' => 'ct_tracks_additional_options',
        'setting' => 'additional_options_return_top_settings',
	    'priority' => 5,
        'choices' => array(
            'show' => __('Show', 'tracks'),
            'hide' => __('Hide', 'tracks')
        ),
    ) );
    // setting - author meta
    $wp_customize->add_setting( 'additional_options_author_meta_settings', array(
        'default'           => 'show',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings',
    ) );
    // control - author meta
    $wp_customize->add_control( 'additional_options_author_meta_settings', array(
        'type' => 'radio',
        'label' => __('Show author info box after posts?', 'tracks'),
        'section' => 'ct_tracks_additional_options',
        'setting' => 'additional_options_author_meta_settings',
        'priority' => 10,
        'choices' => array(
            'show' => __('Show', 'tracks'),
            'hide' => __('Hide', 'tracks')
        ),
    ) );
	// setting - further reading
	$wp_customize->add_setting( 'additional_options_further_reading_settings', array(
		'default'           => 'show',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings',
	) );
	// control - further
	$wp_customize->add_control( 'additional_options_further_reading_settings', array(
		'type' => 'radio',
		'label' => __('Show prev/next links after posts?', 'tracks'),
		'section' => 'ct_tracks_additional_options',
		'setting' => 'additional_options_further_reading_settings',
		'priority' => 15,
		'choices' => array(
			'show' => __('Show', 'tracks'),
			'hide' => __('Hide', 'tracks')
		),
	) );
    // setting - image zoom
    $wp_customize->add_setting( 'additional_options_image_zoom_settings', array(
        'default'           => 'zoom',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_sanitize_image_zoom_settings',
    ) );
    // control - image zoom
    $wp_customize->add_control( 'additional_options_image_zoom_settings', array(
        'type' => 'radio',
        'label' => __('Zoom-in blog images on hover?', 'tracks'),
        'section' => 'ct_tracks_additional_options',
        'priority' => 20,
        'choices' => array(
            'zoom' => __('Zoom in', 'tracks'),
            'no-zoom' => __('Do not zoom in', 'tracks')
        ),
    ) );
    // setting - lazy loading
    $wp_customize->add_setting( 'additional_options_lazy_load_settings', array(
        'default'           => 'no',
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization',
    ) );
    // control - lazy loading
    $wp_customize->add_control( 'additional_options_lazy_load_settings', array(
        'type' => 'radio',
        'label' => __('Lazy load images?', 'tracks'),
        'section' => 'ct_tracks_additional_options',
        'priority' => 25,
        'choices' => array(
            'yes' => __('Yes', 'tracks'),
            'no' => __('No', 'tracks')
        ),
    ) );
    // setting - excerpt length
    $wp_customize->add_setting( 'additional_options_excerpt_length_settings', array(
        'default'           => 15,
        'type'              => 'theme_mod',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    ) );
    // control - excerpt length
    $wp_customize->add_control( new ct_tracks_number_input_control(
        $wp_customize, 'additional_options_excerpt_length_settings', array(
            'label' => __('Word count in automatic excerpts', 'tracks'),
            'section' => 'ct_tracks_additional_options',
            'settings' => 'additional_options_excerpt_length_settings',
            'type' => 'number',
            'priority' => 30,
        )
    ) );

    /***** Background Image *****/

    // get the license status from the database
    $license = trim( get_option( 'ct_tracks_background_images_license_key_status' ) );

    // only add the background images if license is valid
    if($license == 'valid'){

        // section
        $wp_customize->add_section( 'ct_tracks_background_image', array(
            'title'      => __( 'Background Image', 'tracks' ),
            'description' => __('Use the Header Color section above if your new background image makes the menu hard to read.', 'tracks'),
            'priority'   => 95,
            'capability' => 'edit_theme_options'
        ) );
        // setting
        $wp_customize->add_setting( 'ct_tracks_background_image_setting', array(
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        // control
        $wp_customize->add_control( new WP_Customize_Image_Control(
            $wp_customize, 'ct_tracks_background_image_setting', array(
                'label'    => __( 'Background image', 'tracks' ),
                'section'  => 'ct_tracks_background_image',
                'settings' => 'ct_tracks_background_image_setting'
            )
        ) );
    }

	/***** Background Texture *****/

	// get texture license status from database
	$license = trim( get_option( 'ct_tracks_background_textures_license_key_status' ) );

	// only add the background textures if license is valid
	if($license == 'valid'){

		// section
		$wp_customize->add_section( 'ct_tracks_background_texture', array(
			'title'      => __( 'Background Texture', 'tracks' ),
			'description' => __('Use the Header Color section above if your new texture makes the menu hard to read.', 'tracks'),
			'priority'   => 96,
			'capability' => 'edit_theme_options'
		) );
		// setting - display
		$wp_customize->add_setting( 'ct_tracks_texture_display_setting', array(
			'default'           => 'no',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
		) );
		// control - display
		$wp_customize->add_control( 'ct_tracks_texture_display_setting', array(
			'type' => 'radio',
			'label' => __('Enable background texture?', 'tracks'),
			'section' => 'ct_tracks_background_texture',
			'setting' => 'ct_tracks_texture_display_setting',
			'choices' => array(
				'yes' => __('Yes', 'tracks'),
				'no' => __('No', 'tracks')
			),
		) );
		// setting - texture
		$wp_customize->add_setting( 'ct_tracks_background_texture_setting', array(
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'ct_tracks_background_texture_setting_sanitization',
		) );

		// get textures (textures from subtlepatterns.com)
		$textures = ct_tracks_textures_array();

		// control - texture
		$wp_customize->add_control( 'ct_tracks_background_texture_setting', array(
			'label'          => __( 'Choose a Texture', 'tracks' ),
			'section'        => 'ct_tracks_background_texture',
			'settings'       => 'ct_tracks_background_texture_setting',
			'type'           => 'radio',
			'choices'        => $textures
		) );
	}

    /***** Header Color *****/

    // get license statuses from databases
    $license_images = trim( get_option( 'ct_tracks_background_images_license_key_status' ) );
    $license_textures = trim( get_option( 'ct_tracks_background_textures_license_key_status' ) );

    // only add if one or more licenses are active
    if( $license_images == 'valid' || $license_textures == 'valid') {

        // section
        $wp_customize->add_section( 'ct_tracks_header_color', array(
            'title'      => __( 'Header Color', 'tracks' ),
            'description' => __('Change to dark if your new background makes the menu hard to read.', 'tracks'),
            'priority'   => 99,
            'capability' => 'edit_theme_options'
        ) );
        // setting
        $wp_customize->add_setting( 'ct_tracks_header_color_setting', array(
            'default'           => 'light',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'ct_tracks_sanitize_header_color_settings'
        ) );
        // control
        $wp_customize->add_control( 'ct_tracks_header_color_setting', array(
            'type' => 'radio',
            'label' => __('Light or dark header color?', 'tracks'),
            'section' => 'ct_tracks_header_color',
            'setting' => 'ct_tracks_header_color_setting',
            'choices' => array(
                'light' => __('Light', 'tracks'),
                'dark' => __('Dark', 'tracks')
            ),
        ) );
    }
}

/***** Custom Sanitization Functions *****/

// sanitize tagline display setting
function ct_tracks_sanitize_tagline_display($input){
    $valid = array(
        'header-footer' => __('Header & Footer', 'tracks'),
        'header' => __('Header', 'tracks'),
        'footer' => __('Footer', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_tracks_sanitize_email( $input ) {

    return sanitize_email( $input );
}

// sanitize social icon display setting
function ct_tracks_sanitize_social_icons_display($input){
    $valid = array(
        'header-footer' => __('Header & Footer', 'tracks'),
        'header' => __('Header', 'tracks'),
        'footer' => __('Footer', 'tracks'),
        'no' => __('Do not display', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/*
 * Sanitize settings with show/hide as options
 * Used in: author meta, return-to-top arrow, post meta, search bar
 */
function ct_tracks_sanitize_all_show_hide_settings($input){
    $valid = array(
        'show' => __('Show', 'tracks'),
        'hide' => __('Hide', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/*
 * Sanitize settings with yes/no as options
 * Used in: background texture, lazy loading, full-width image show full post
 */
function ct_tracks_all_yes_no_setting_sanitization($input){

    $valid = array(
        'yes' => __('Yes', 'tracks'),
        'no' => __('No', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// sanitize comment display multi-check
function ct_tracks_sanitize_comments_setting($input){

    // valid data
    $valid = array(
        'posts'   => __('Posts', 'tracks'),
        'pages'  => __('Pages', 'tracks'),
        'attachments'  => __('Attachments', 'tracks'),
        'none'  => __('Do not show', 'tracks')
    );

    // loop through array
    foreach( $input as $selection ) {

        // if it's in the valid data, return it
        if ( array_key_exists( $selection, $valid ) ) {
            return $input;
        } else {
            return '';
        }
    }
}

// sanitize image zoom setting
function ct_tracks_sanitize_image_zoom_settings($input){
    $valid = array(
        'zoom' => __('Zoom', 'tracks'),
        'no-zoom' => __('Do not Zoom', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

// sanitize premium layout setting
function ct_tracks_sanitize_premium_layouts($input){

	// no i18n because these are product names
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

// sanitize full-width image height setting
function ct_tracks_sanitize_premium_layouts_image_height($input){
    $valid = array(
	    'image' => _x('size based on image size', 'size of the featured image', 'tracks'),
	    '2:1-ratio'   => _x('2:1 width/height ratio like posts', 'size of the featured image', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function ct_tracks_sanitize_premium_layouts_image_style( $input ) {
	$valid = array(
		'overlay' => __('Overlay', 'tracks'),
		'title'   => __('Title below', 'tracks')
	);

    if ( array_key_exists( $input, $valid ) ) {
	    return $input;
    } else {
	    return '';
    }
}

// sanitize background texture setting
function ct_tracks_background_texture_setting_sanitization($input){

	$textures = ct_tracks_textures_array();

	$valid = $textures;

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

// sanitize header color setting
function ct_tracks_sanitize_header_color_settings($input){
    $valid = array(
        'light' => __('Light', 'tracks'),
        'dark' => __('Dark', 'tracks')
    );

    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}

/***** Helper Functions *****/

// array of textures used as choices in texture setting
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

function ct_tracks_customize_preview_js() { ?>

	<script>
		jQuery('#customize-info').prepend('<div class="upgrades-ad"><a href="https://www.competethemes.com/tracks/tracks-theme-upgrades/" target="_blank">View Tracks Theme Upgrades <span>&rarr;</span></a></div>');
	</script>
<?php }
add_action('customize_controls_print_footer_scripts', 'ct_tracks_customize_preview_js');