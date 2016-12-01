<?php

add_action( 'customize_register', 'ct_tracks_add_customizer_content' );

function ct_tracks_add_customizer_content( $wp_customize ) {

	/***** Add PostMessage Support *****/

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Add Custom Controls *****/

	// create multi-checkbox/select control
	class ct_tracks_Multi_Checkbox_Control extends WP_Customize_Control {
		public $type = 'multi-checkbox';

		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			}
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

			if ( empty( $this->choices ) ) {
				return;
			}
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

	/***** Tracks Pro Control *****/

	class ct_tracks_pro_ad extends WP_Customize_Control {
		public function render_content() {
			$link = 'https://www.competethemes.com/tracks-pro/';
			echo "<a href='" . $link . "' target='_blank'><img src='" . get_template_directory_uri() . "/assets/images/tracks-pro.png' srcset='" . get_template_directory_uri() . "/assets/images/tracks-pro-2x.png 2x' /></a>";
			echo "<p class='bold'>" . sprintf( __('<a target="_blank" href="%s">Tracks Pro</a> is the plugin that makes advanced customization simple - and fun too!', 'tracks'), $link) . "</p>";
			echo "<p>" . __('Tracks Pro adds the following features to Tracks:', 'tracks') . "</p>";
			echo "<ul>
					<li>" . __('Custom Colors', 'tracks') . "</li>
					<li>" . __('4 New layouts', 'tracks') . "</li>
					<li>" . __('Featured Videos', 'tracks') . "</li>
					<li>" . __('+ 5 more features', 'tracks') . "</li>
				  </ul>";
			echo "<p class='button-wrapper'><a target=\"_blank\" class='tracks-pro-button' href='" . $link . "'>" . __('View Tracks Pro', 'tracks') . "</a></p>";
		}
	}

	/***** Tracks Pro Section *****/

	// don't add if Tracks Pro is active
	if ( !function_exists( 'ct_tracks_pro_init' ) ) {
		// section
		$wp_customize->add_section( 'ct_tracks_pro', array(
			'title'    => __( 'Tracks Pro', 'tracks' ),
			'priority' => 1
		) );
		// Upload - setting
		$wp_customize->add_setting( 'tracks_pro', array(
			'sanitize_callback' => 'absint'
		) );
		// Upload - control
		$wp_customize->add_control( new ct_tracks_pro_ad(
			$wp_customize, 'tracks_pro', array(
				'section'  => 'ct_tracks_pro',
				'settings' => 'tracks_pro'
			)
		) );
	}

	/***** Tagline Display *****/

	// section
	$wp_customize->add_section( 'ct_tracks_tagline_display', array(
		'title'    => __( 'Tagline Display', 'tracks' ),
		'priority' => 25
	) );
	// setting
	$wp_customize->add_setting( 'tagline_display_setting', array(
		'default'           => 'header-footer',
		'sanitize_callback' => 'ct_tracks_sanitize_tagline_display'
	) );
	// control
	$wp_customize->add_control( 'tagline_display_setting', array(
		'type'    => 'radio',
		'label'   => __( 'Where should the tagline display?', 'tracks' ),
		'default' => 'header-footer',
		'section' => 'ct_tracks_tagline_display',
		'setting' => 'tagline_display_setting',
		'choices' => array(
			'header-footer' => __( 'Header & Footer', 'tracks' ),
			'header'        => __( 'Header', 'tracks' ),
			'footer'        => __( 'Footer', 'tracks' )
		),
	) );

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct-upload', array(
		'title'    => __( 'Logo', 'tracks' ),
		'priority' => 30
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'logo_image', array(
			'label'    => __( 'Upload custom logo.', 'tracks' ),
			'section'  => 'ct-upload',
			'settings' => 'logo_upload'
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
		'default'           => 'no',
		'sanitize_callback' => 'ct_tracks_sanitize_social_icons_display'
	) );
	// control - display
	$wp_customize->add_control( 'social_icons_display_setting', array(
		'type'     => 'radio',
		'label'    => __( 'Where should the icons display?', 'tracks' ),
		'priority' => 1,
		'section'  => 'ct_tracks_social_icons',
		'setting'  => 'social_icons_display_setting',
		'choices'  => array(
			'header-footer' => __( 'Header & Footer', 'tracks' ),
			'header'        => __( 'Header', 'tracks' ),
			'footer'        => __( 'Footer', 'tracks' ),
			'no'            => __( 'Do not display', 'tracks' )
		),
	) );

	// output social site setting/control pairs
	foreach ( $social_sites as $social_site ) {

		if ( $social_site == 'email' ) {

			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_tracks_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'tracks' ), // brand name so i18n not required
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
			} elseif ( $social_site == 'email-form' ) {
				$label = 'Contact Form';
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_tracks_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label, // brand name so i18n not required
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'tracks' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_tracks_social_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label, // brand name so i18n not required
					'section'  => 'ct_tracks_social_icons',
					'priority' => $priority
				) );
			}

			// increment priority to retain order
			$priority = $priority + 5;
		}
	}

	/***** Search Bar *****/

	// section
	$wp_customize->add_section( 'ct_tracks_search_input', array(
		'title'    => __( 'Search Bar', 'tracks' ),
		'priority' => 60
	) );
	// setting
	$wp_customize->add_setting( 'search_input_setting', array(
		'default'           => 'hide',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
	) );
	// control
	$wp_customize->add_control( 'search_input_setting', array(
		'type'    => 'radio',
		'label'   => __( 'Show search bar at top of site?', 'tracks' ),
		'section' => 'ct_tracks_search_input',
		'setting' => 'search_input_setting',
		'choices' => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );

	/***** Post Meta Display *****/

	// section
	$wp_customize->add_section( 'ct_tracks_post_meta_display', array(
		'title'    => __( 'Post Meta', 'tracks' ),
		'priority' => 65
	) );
	// setting - date
	$wp_customize->add_setting( 'post_date_display_setting', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
	) );
	// control - date
	$wp_customize->add_control( 'post_date_display_setting', array(
		'type'    => 'radio',
		'label'   => __( 'Display date above post title?', 'tracks' ),
		'section' => 'ct_tracks_post_meta_display',
		'setting' => 'post_date_display_setting',
		'choices' => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );
	// setting - author
	$wp_customize->add_setting( 'post_author_display_setting', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
	) );
	// control - author
	$wp_customize->add_control( 'post_author_display_setting', array(
		'type'    => 'radio',
		'label'   => __( 'Display author name above post title?', 'tracks' ),
		'section' => 'ct_tracks_post_meta_display',
		'setting' => 'post_author_display_setting',
		'choices' => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );
	// setting - category
	$wp_customize->add_setting( 'post_category_display_setting', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
	) );
	// control - category
	$wp_customize->add_control( 'post_category_display_setting', array(
		'type'    => 'radio',
		'label'   => __( 'Display category above post title?', 'tracks' ),
		'section' => 'ct_tracks_post_meta_display',
		'setting' => 'post_category_display_setting',
		'choices' => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );

	/***** Comment Display *****/

	// section
	$wp_customize->add_section( 'ct_tracks_comments_display', array(
		'title'    => __( 'Comments', 'tracks' ),
		'priority' => 70
	) );
	// setting
	$wp_customize->add_setting( 'ct_tracks_comments_setting', array(
		'default'           => array( 'posts', 'pages', 'attachments', 'none' ),
		'sanitize_callback' => 'ct_tracks_sanitize_comments_setting',
	) );
	// control
	$wp_customize->add_control( new ct_tracks_Multi_Checkbox_Control(
		$wp_customize, 'ct_tracks_comments_setting', array(
			'label'    => __( 'Show comments on:', 'tracks' ),
			'section'  => 'ct_tracks_comments_display',
			'settings' => 'ct_tracks_comments_setting',
			'type'     => 'multi-checkbox',
			'choices'  => array(
				'posts'       => __( 'Posts', 'tracks' ),
				'pages'       => __( 'Pages', 'tracks' ),
				'attachments' => __( 'Attachments', 'tracks' ),
				'none'        => __( 'Do not show', 'tracks' )
			)
		)
	) );

	/***** Footer Text *****/

	// section
	$wp_customize->add_section( 'ct-footer-text', array(
		'title'    => __( 'Footer Text', 'tracks' ),
		'priority' => 75
	) );
	// setting
	$wp_customize->add_setting( 'ct_tracks_footer_text_setting', array(
		'sanitize_callback' => 'wp_kses_post'
	) );
	// control
	$wp_customize->add_control( 'ct_tracks_footer_text_setting', array(
		'type'     => 'textarea',
		'label'    => __( 'Edit the text in your footer', 'tracks' ),
		'section'  => 'ct-footer-text',
		'settings' => 'ct_tracks_footer_text_setting'
	) );

	/***** Custom CSS *****/

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		// Migrate any existing theme CSS to the core option added in WordPress 4.7.
		$css = get_theme_mod( 'ct_tracks_custom_css_setting' );
		if ( $css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'ct_tracks_custom_css_setting' );
			}
		}
	} else {
		// section
		$wp_customize->add_section( 'ct-custom-css', array(
			'title'    => __( 'Custom CSS', 'tracks' ),
			'priority' => 80
		) );
		// setting
		$wp_customize->add_setting( 'ct_tracks_custom_css_setting', array(
			'sanitize_callback' => 'ct_tracks_sanitize_css',
			'transport'         => 'postMessage'
		) );
		// control
		$wp_customize->add_control( 'ct_tracks_custom_css_setting', array(
			'type'     => 'textarea',
			'label'    => __( 'Add Custom CSS Here:', 'tracks' ),
			'section'  => 'ct-custom-css',
			'settings' => 'ct_tracks_custom_css_setting'
		) );
	}

	/***** Premium Layout *****/

	// set the available templates to just the standard layout
	$available_templates = array( 'standard' => 'Standard' );

	// query database to get layout license statuses
	$full_width        = trim( get_option( 'ct_tracks_full_width_license_key_status' ) );
	$full_width_images = trim( get_option( 'ct_tracks_full_width_images_license_key_status' ) );
	$two_column        = trim( get_option( 'ct_tracks_two_column_license_key_status' ) );
	$two_column_images = trim( get_option( 'ct_tracks_two_column_images_license_key_status' ) );

	// check if any layout statuses are valid, and add to available layouts if they are
	if ( $full_width == 'valid' ) {
		$available_templates['full-width'] = 'Full-width';
	}
	if ( $full_width_images == 'valid' ) {
		$available_templates['full-width-images'] = 'Full-width Images';
	}
	if ( $two_column == 'valid' ) {
		$available_templates['two-column'] = 'Two-Column';
	}
	if ( $two_column_images == 'valid' ) {
		$available_templates['two-column-images'] = 'Two-Column Images';
	}

	// section
	$wp_customize->add_section( 'ct_tracks_premium_layouts', array(
		'title'    => __( 'Premium Layouts', 'tracks' ),
		'priority' => 85
	) );
	// setting - layout select
	$wp_customize->add_setting( 'premium_layouts_setting', array(
		'default'           => 'standard',
		'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts'
	) );

	// control - layout select
	$wp_customize->add_control( 'premium_layouts_setting', array(
		'type'        => 'select',
		'label'       => __( 'Choose the layout for Tracks', 'tracks' ),
		'description' => sprintf( __( 'Want more layouts? Check out the <a target="_blank" href="%s">Tracks Pro Plugin</a>.', 'tracks' ), 'https://www.competethemes.com/tracks-pro/' ),
		'section'     => 'ct_tracks_premium_layouts',
		'setting'     => 'premium_layouts_setting',
		'choices'     => $available_templates, // no i18n b/c product names
	) );
	// setting - full-width image height
	$wp_customize->add_setting( 'premium_layouts_full_width_image_height', array(
		'default'           => 'image',
		'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_height'
	) );
	// control - full-width image height
	$wp_customize->add_control( 'premium_layouts_full_width_image_height', array(
		'type'    => 'radio',
		'label'   => __( 'Image size on Blog', 'tracks' ),
		'section' => 'ct_tracks_premium_layouts',
		'setting' => 'premium_layouts_setting',
		'choices' => array(
			'image'     => _x( 'size based on image size', 'size of the featured image', 'tracks' ),
			'2:1-ratio' => _x( '2:1 width/height ratio like posts', 'size of the featured image', 'tracks' )
		),
	) );
	// setting - full-width image height post
	$wp_customize->add_setting( 'premium_layouts_full_width_image_height_post', array(
		'default'           => 'image',
		'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_height'
	) );
	// control - full-width image height
	$wp_customize->add_control( 'premium_layouts_full_width_image_height_post', array(
		'type'    => 'radio',
		'label'   => __( 'Image size on Posts', 'tracks' ),
		'section' => 'ct_tracks_premium_layouts',
		'setting' => 'premium_layouts_setting',
		'choices' => array(
			'image'     => _x( 'size based on image size', 'size of the featured image', 'tracks' ),
			'2:1-ratio' => _x( '2:1 width/height ratio like posts', 'size of the featured image', 'tracks' )
		),
	) );
	// setting - full-width image style
	$wp_customize->add_setting( 'premium_layouts_full_width_image_style', array(
		'default'           => 'overlay',
		'sanitize_callback' => 'ct_tracks_sanitize_premium_layouts_image_style'
	) );
	// control - full-width image style
	$wp_customize->add_control( 'premium_layouts_full_width_image_style', array(
		'type'    => 'radio',
		'label'   => __( 'Style', 'tracks' ),
		'section' => 'ct_tracks_premium_layouts',
		'setting' => 'premium_layouts_setting',
		'choices' => array(
			'overlay' => __( 'Overlay', 'tracks' ),
			'title'   => __( 'Title below', 'tracks' )
		),
	) );
	// setting - full-width full post
	$wp_customize->add_setting( 'premium_layouts_full_width_full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
	) );
	// control - full-width full post
	$wp_customize->add_control( 'premium_layouts_full_width_full_post', array(
		'type'    => 'radio',
		'label'   => __( 'Show full posts on Blog/Archives?', 'tracks' ),
		'section' => 'ct_tracks_premium_layouts',
		'setting' => 'premium_layouts_full_width_full_post',
		'choices' => array(
			'yes' => __( 'Yes', 'tracks' ),
			'no'  => __( 'No', 'tracks' )
		),
	) );

	/***** Additional Options *****/

	// section
	$wp_customize->add_section( 'ct_tracks_additional_options', array(
		'title'    => __( 'Additional Options', 'tracks' ),
		'priority' => 90
	) );
	// setting - no featured image
	$wp_customize->add_setting( 'additional_options_no_featured_image', array(
		'default'           => 'full',
		'sanitize_callback' => 'ct_tracks_sanitize_no_featured_image',
	) );
	// control - no featured image
	$wp_customize->add_control( 'additional_options_no_featured_image', array(
		'type'     => 'radio',
		'label'    => __( 'Posts without Featured Images should display:', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'setting'  => 'additional_options_no_featured_image',
		'priority' => 5,
		'choices'  => array(
			'empty'    => __( 'Empty half', 'tracks' ),
			'full'     => __( 'Full-width text', 'tracks' ),
			'fallback' => __( 'Fallback image', 'tracks' )
		),
	) );
	// setting - fallback image
	$wp_customize->add_setting( 'additional_options_fallback_featured_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control - fallback image
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'additional_options_fallback_featured_image', array(
			'label'    => __( 'Upload a fallback image', 'tracks' ),
			'section'  => 'ct_tracks_additional_options',
			'priority' => 6,
			'settings' => 'additional_options_fallback_featured_image'
		)
	) );
	// setting - return to top arrow
	$wp_customize->add_setting( 'additional_options_return_top_settings', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings',
	) );
	// control - return to top arrow
	$wp_customize->add_control( 'additional_options_return_top_settings', array(
		'type'     => 'radio',
		'label'    => __( 'Show scroll-to-top arrow?', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'setting'  => 'additional_options_return_top_settings',
		'priority' => 19,
		'choices'  => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );
	// setting - author meta
	$wp_customize->add_setting( 'additional_options_author_meta_settings', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
	) );
	// control - author meta
	$wp_customize->add_control( 'additional_options_author_meta_settings', array(
		'type'     => 'radio',
		'label'    => __( 'Show author info box after posts?', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'setting'  => 'additional_options_author_meta_settings',
		'priority' => 10,
		'choices'  => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );
	// setting - further reading
	$wp_customize->add_setting( 'additional_options_further_reading_settings', array(
		'default'           => 'show',
		'sanitize_callback' => 'ct_tracks_sanitize_all_show_hide_settings'
	) );
	// control - further
	$wp_customize->add_control( 'additional_options_further_reading_settings', array(
		'type'     => 'radio',
		'label'    => __( 'Show prev/next links after posts?', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'setting'  => 'additional_options_further_reading_settings',
		'priority' => 15,
		'choices'  => array(
			'show' => __( 'Show', 'tracks' ),
			'hide' => __( 'Hide', 'tracks' )
		),
	) );
	// setting - image zoom
	$wp_customize->add_setting( 'additional_options_image_zoom_settings', array(
		'default'           => 'zoom',
		'sanitize_callback' => 'ct_tracks_sanitize_image_zoom_settings'
	) );
	// control - image zoom
	$wp_customize->add_control( 'additional_options_image_zoom_settings', array(
		'type'     => 'radio',
		'label'    => __( 'Zoom-in blog images on hover?', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'priority' => 20,
		'choices'  => array(
			'zoom'    => __( 'Zoom in', 'tracks' ),
			'no-zoom' => __( 'Do not zoom in', 'tracks' )
		),
	) );
	// setting - lazy loading
	$wp_customize->add_setting( 'additional_options_lazy_load_settings', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
	) );
	// control - lazy loading
	$wp_customize->add_control( 'additional_options_lazy_load_settings', array(
		'type'     => 'radio',
		'label'    => __( 'Lazy load images?', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'priority' => 25,
		'choices'  => array(
			'yes' => __( 'Yes', 'tracks' ),
			'no'  => __( 'No', 'tracks' )
		),
	) );
	// setting - excerpt length
	$wp_customize->add_setting( 'additional_options_excerpt_length_settings', array(
		'default'           => 15,
		'sanitize_callback' => 'absint'
	) );
	// control - excerpt length
	$wp_customize->add_control( 'additional_options_excerpt_length_settings', array(
		'label'    => __( 'Word count in automatic excerpts', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'settings' => 'additional_options_excerpt_length_settings',
		'type'     => 'number',
		'priority' => 30
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Read the Post', 'tracks' ),
		'sanitize_callback' => 'ct_tracks_sanitize_text'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More link text', 'tracks' ),
		'section'  => 'ct_tracks_additional_options',
		'settings' => 'read_more_text',
		'type'     => 'text',
		'priority' => 35
	) );

	/***** Background Image *****/

	// get the license status from the database
	$license = trim( get_option( 'ct_tracks_background_images_license_key_status' ) );

	// only add the background images if license is valid
	if ( $license == 'valid' ) {

		// section
		$wp_customize->add_section( 'ct_tracks_background_image', array(
			'title'       => __( 'Background Image', 'tracks' ),
			'description' => __( 'Use the Header Color section if your new background image makes the menu hard to read.', 'tracks' ),
			'priority'    => 95
		) );
		// setting
		$wp_customize->add_setting( 'ct_tracks_background_image_setting', array(
			'sanitize_callback' => 'esc_url_raw'
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
	if ( $license == 'valid' ) {

		// section
		$wp_customize->add_section( 'ct_tracks_background_texture', array(
			'title'       => __( 'Background Texture', 'tracks' ),
			'description' => __( 'Use the Header Color section if your new texture makes the menu hard to read.', 'tracks' ),
			'priority'    => 96
		) );
		// setting - display
		$wp_customize->add_setting( 'ct_tracks_texture_display_setting', array(
			'default'           => 'no',
			'sanitize_callback' => 'ct_tracks_all_yes_no_setting_sanitization'
		) );
		// control - display
		$wp_customize->add_control( 'ct_tracks_texture_display_setting', array(
			'type'    => 'radio',
			'label'   => __( 'Enable background texture?', 'tracks' ),
			'section' => 'ct_tracks_background_texture',
			'setting' => 'ct_tracks_texture_display_setting',
			'choices' => array(
				'yes' => __( 'Yes', 'tracks' ),
				'no'  => __( 'No', 'tracks' )
			),
		) );
		// setting - texture
		$wp_customize->add_setting( 'ct_tracks_background_texture_setting', array(
			'sanitize_callback' => 'ct_tracks_background_texture_setting_sanitization',
		) );

		// get textures (textures from subtlepatterns.com)
		$textures = ct_tracks_textures_array();

		// control - texture
		$wp_customize->add_control( 'ct_tracks_background_texture_setting', array(
			'label'    => __( 'Choose a Texture', 'tracks' ),
			'section'  => 'ct_tracks_background_texture',
			'settings' => 'ct_tracks_background_texture_setting',
			'type'     => 'radio',
			'choices'  => $textures
		) );
	}

	/***** Header Color *****/

	// get license statuses from databases
	$license_images   = trim( get_option( 'ct_tracks_background_images_license_key_status' ) );
	$license_textures = trim( get_option( 'ct_tracks_background_textures_license_key_status' ) );

	// only add if one or more licenses are active
	if ( $license_images == 'valid' || $license_textures == 'valid' ) {

		// section
		$wp_customize->add_section( 'ct_tracks_header_color', array(
			'title'       => __( 'Header Color', 'tracks' ),
			'description' => __( 'Change to dark if your new background makes the menu hard to read.', 'tracks' ),
			'priority'    => 99
		) );
		// setting
		$wp_customize->add_setting( 'ct_tracks_header_color_setting', array(
			'default'           => 'light',
			'sanitize_callback' => 'ct_tracks_sanitize_header_color_settings'
		) );
		// control
		$wp_customize->add_control( 'ct_tracks_header_color_setting', array(
			'type'    => 'radio',
			'label'   => __( 'Light or dark header color?', 'tracks' ),
			'section' => 'ct_tracks_header_color',
			'setting' => 'ct_tracks_header_color_setting',
			'choices' => array(
				'light' => __( 'Light', 'tracks' ),
				'dark'  => __( 'Dark', 'tracks' )
			),
		) );
	}
}

/***** Custom Sanitization Functions *****/

function ct_tracks_sanitize_tagline_display( $input ) {
	$valid = array(
		'header-footer' => __( 'Header & Footer', 'tracks' ),
		'header'        => __( 'Header', 'tracks' ),
		'footer'        => __( 'Footer', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_tracks_sanitize_email( $input ) {

	return sanitize_email( $input );
}

function ct_tracks_sanitize_social_icons_display( $input ) {
	$valid = array(
		'header-footer' => __( 'Header & Footer', 'tracks' ),
		'header'        => __( 'Header', 'tracks' ),
		'footer'        => __( 'Footer', 'tracks' ),
		'no'            => __( 'Do not display', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * Sanitize settings with show/hide as options
 * Used in: author meta, return-to-top arrow, post meta, search bar
 */
function ct_tracks_sanitize_all_show_hide_settings( $input ) {
	$valid = array(
		'show' => __( 'Show', 'tracks' ),
		'hide' => __( 'Hide', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * Sanitize settings with yes/no as options
 * Used in: background texture, lazy loading, full-width image show full post
 */
function ct_tracks_all_yes_no_setting_sanitization( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'tracks' ),
		'no'  => __( 'No', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_comments_setting( $input ) {

	$valid = array(
		'posts'       => __( 'Posts', 'tracks' ),
		'pages'       => __( 'Pages', 'tracks' ),
		'attachments' => __( 'Attachments', 'tracks' ),
		'none'        => __( 'Do not show', 'tracks' )
	);

	foreach ( $input as $selection ) {
		return array_key_exists( $selection, $valid ) ? $input : '';
	}
}

function ct_tracks_sanitize_image_zoom_settings( $input ) {

	$valid = array(
		'zoom'    => __( 'Zoom', 'tracks' ),
		'no-zoom' => __( 'Do not Zoom', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_premium_layouts( $input ) {

	// no i18n because these are product names
	$valid = array(
		'standard'          => 'Standard',
		'full-width'        => 'Full-width',
		'full-width-images' => 'Full-width Images',
		'two-column'        => 'Two-Column',
		'two-column-images' => 'Two-Column Images',
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_premium_layouts_image_height( $input ) {
	$valid = array(
		'image'     => _x( 'size based on image size', 'size of the featured image', 'tracks' ),
		'2:1-ratio' => _x( '2:1 width/height ratio like posts', 'size of the featured image', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_premium_layouts_image_style( $input ) {
	$valid = array(
		'overlay' => __( 'Overlay', 'tracks' ),
		'title'   => __( 'Title below', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_background_texture_setting_sanitization( $input ) {

	$textures = ct_tracks_textures_array();

	$valid = $textures;

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_header_color_settings( $input ) {
	$valid = array(
		'light' => __( 'Light', 'tracks' ),
		'dark'  => __( 'Dark', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_tracks_sanitize_no_featured_image( $input ) {
	$valid = array(
		'empty'    => __( 'Empty half', 'tracks' ),
		'full'     => __( 'Full-width text', 'tracks' ),
		'fallback' => __( 'Fallback image', 'tracks' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_tracks_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

/***** Helper Functions *****/

function ct_tracks_textures_array() {

	$textures = array(
		'binding_dark'       => '',
		'brickwall'          => '',
		'congruent_outline'  => '',
		'crossword'          => '',
		'escheresque_ste'    => '',
		'fabric_squares'     => '',
		'geometry'           => '',
		'grey_wash_wall'     => '',
		'halftone'           => '',
		'notebook'           => '',
		'office'             => '',
		'pixel_weave'        => '',
		'sativa'             => '',
		'shattered'          => '',
		'skulls'             => '',
		'snow'               => '',
		'sos'                => '',
		'sprinkles'          => '',
		'squared_metal'      => '',
		'stardust'           => '',
		'tweed'              => '',
		'small_steps'        => '',
		'restaurant_icons'   => '',
		'congruent_pentagon' => '',
		'photography'        => '',
		'giftly'             => '',
		'food'               => '',
		'light_grey'         => '',
		'diagonal_waves'     => '',
		'otis_redding'       => '',
		'wild_oliva'         => '',
		'cream_dust'         => '',
		'back_pattern'       => '',
		'skelatal_weave'     => '',
		'retina_wood'        => '',
		'escheresque'        => '',
		'greyfloral'         => '',
		'diamond_upholstery' => '',
		'hexellence'         => ''
	);

	return $textures;
}

function ct_tracks_sanitize_css( $css ) {
	$css = wp_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );

	return $css;
}