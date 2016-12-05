<?php

require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );
foreach ( glob( trailingslashit( get_template_directory() ) . 'inc/*.php' ) as $filename ) {
	include $filename;
}
foreach ( glob( trailingslashit( get_template_directory() ) . 'licenses/*.php' ) as $filename ) {
	include $filename;
}
foreach ( glob( trailingslashit( get_template_directory() ) . 'licenses/functions/*.php' ) as $filename ) {
	include $filename;
}

if ( ! function_exists( ( 'ct_tracks_set_content_width' ) ) ) {
	function ct_tracks_set_content_width() {
		if ( ! isset( $content_width ) ) {
			$content_width = 711;
		}
	}
}
add_action( 'after_setup_theme', 'ct_tracks_set_content_width', 0 );

if ( ! function_exists( 'ct_tracks_theme_setup' ) ) {
	function ct_tracks_theme_setup() {

		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );
		add_theme_support( 'infinite-scroll', array(
			'container' => 'loop-container',
			'footer'    => 'overflow-container',
			'render'    => 'ct_tracks_infinite_scroll_render'
		) );

		register_nav_menus( array(
			'primary'   => __( 'Primary', 'tracks' ),
			'secondary' => __( 'Secondary', 'tracks' ),
			'footer'    => __( 'Footer', 'tracks' )
		) );

		load_theme_textdomain( 'tracks', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'ct_tracks_theme_setup', 10 );

if ( ! function_exists( 'ct_tracks_register_widget_areas' ) ) {
	function ct_tracks_register_widget_areas() {

		// after post content
		register_sidebar( array(
			'name'          => __( 'After Post Content', 'tracks' ),
			'id'            => 'after-post-content',
			'description'   => __( 'Widgets in this area will be shown after post content before the prev/next post links', 'tracks' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );

		// after page content
		register_sidebar( array(
			'name'          => __( 'After Page Content', 'tracks' ),
			'id'            => 'after-page-content',
			'description'   => __( 'Widgets in this area will be shown after page content', 'tracks' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>'
		) );

		// footer
		register_sidebar( array(
			'name'          => __( 'Footer', 'tracks' ),
			'id'            => 'footer',
			'description'   => __( 'Widgets in this area will be shown in the footer', 'tracks' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		) );
	}
}
add_action( 'widgets_init', 'ct_tracks_register_widget_areas' );

if ( ! function_exists( 'ct_tracks_customize_comments' ) ) {
	function ct_tracks_customize_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
				echo get_avatar( get_comment_author_email(), 72 );
				?>
				<div>
					<div class="author-name"><?php comment_author_link(); ?></div>
					<div class="comment-date"><?php comment_date(); ?></div>
					<?php comment_reply_link( array_merge( $args, array(
						'reply_text' => __( 'Reply', 'tracks' ),
						'depth'      => $depth,
						'max_depth'  => $args['max_depth']
					) ) ); ?>
					<?php edit_comment_link( __( 'Edit', 'tracks' ) ); ?>
				</div>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'tracks' ) ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
		</article>
		<?php
	}
}

if ( ! function_exists( 'ct_tracks_update_fields' ) ) {
	function ct_tracks_update_fields( $fields ) {

		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$label     = $req ? '*' : ' ' . __( '(optional)', 'tracks' );
		$aria_req  = $req ? "aria-required='true'" : '';

		$fields['author'] =
			'<p class="comment-form-author">
            <label for="author" class="screen-reader-text">' . __( "Your Name", "tracks" ) . '</label>
            <input placeholder="' . esc_attr__( "Your Name", "tracks" ) . $label . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30" ' . $aria_req . ' />
    	</p>';
		$fields['email'] =
			'<p class="comment-form-email">
            <label for="email" class="screen-reader-text">' . __( "Your Email", "tracks" ) . '</label>
            <input placeholder="' . esc_attr__( "Your Email", "tracks" ) . $label . '" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) .
			'" size="30" ' . $aria_req . ' />
    	</p>';
		$fields['url'] =
			'<p class="comment-form-url">
            <label for="url" class="screen-reader-text">' . __( "Your Website URL", "tracks" ) . '</label>
            <input placeholder="' . esc_attr__( "Your URL", "tracks" ) . '" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" />
            </p>';

		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'ct_tracks_update_fields' );

if ( ! function_exists( 'ct_tracks_update_comment_field' ) ) {
	function ct_tracks_update_comment_field( $comment_field ) {

		$comment_field =
			'<p class="comment-form-comment">
            <label for="comment" class="screen-reader-text">' . __( "Your Comment", "tracks" ) . '</label>
            <textarea required placeholder="' . esc_attr__( "Enter Your Comment", "tracks" ) . '&#8230;" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </p>';

		return $comment_field;
	}
}
add_filter( 'comment_form_field_comment', 'ct_tracks_update_comment_field' );

if ( ! function_exists( 'ct_tracks_remove_comments_notes_after' ) ) {
	function ct_tracks_remove_comments_notes_after( $defaults ) {
		$defaults['comment_notes_after'] = '';
		return $defaults;
	}
}
add_action( 'comment_form_defaults', 'ct_tracks_remove_comments_notes_after' );

if ( ! function_exists( 'ct_tracks_excerpt' ) ) {
	function ct_tracks_excerpt() {

		global $post;
		$setting        = get_theme_mod( 'premium_layouts_full_width_full_post' );
		$read_more_text = get_theme_mod( 'read_more_text' );
		$ismore         = strpos( $post->post_content, '<!--more-->' );

		// if show full post is on and not on a search results page
		if ( ( $setting == 'yes' ) && get_theme_mod( 'premium_layouts_setting' ) == 'full-width' && ! is_search() ) {
			if ( $ismore ) {
				// Has to be written this way because i18n text CANNOT be stored in a variable
				if ( ! empty( $read_more_text ) ) {
					the_content( esc_html( $read_more_text ) . " <span class='screen-reader-text'>" . esc_html( get_the_title() ) . "</span>" );
				} else {
					the_content( __( 'Read the Post', 'tracks' ) . " <span class='screen-reader-text'>" . esc_html( get_the_title() ) . "</span>" );
				}
			} else {
				the_content();
			}
		} elseif ( $ismore ) {
			if ( ! empty( $read_more_text ) ) {
				the_content( esc_html( $read_more_text ) . " <span class='screen-reader-text'>" . esc_html( get_the_title() ) . "</span>" );
			} else {
				the_content( __( 'Read the Post', 'tracks' ) . " <span class='screen-reader-text'>" . esc_html( get_the_title() ) . "</span>" );
			}
		} else {
			the_excerpt();
		}
	}
}

if ( ! function_exists( 'ct_tracks_excerpt_read_more_link' ) ) {
	function ct_tracks_excerpt_read_more_link( $output ) {
		global $post;
		$read_more_text = get_theme_mod( 'read_more_text' );

		if ( ! empty( $read_more_text ) ) {
			return $output . "<p><a class='more-link' href='" . esc_url( get_permalink() ) . "'>" . esc_html( $read_more_text ) . "<span class='screen-reader-text'>" . esc_html( get_the_title() ) . "</span></a></p>";
		} else {
			return $output . "<p><a class='more-link' href='" . esc_url( get_permalink() ) . "'>" . __( 'Read the Post', 'tracks' ) . "<span class='screen-reader-text'>" . esc_html( get_the_title() ) . "</span></a></p>";
		}
	}
}
add_filter( 'the_excerpt', 'ct_tracks_excerpt_read_more_link' );

if ( ! function_exists( 'ct_tracks_custom_excerpt_length' ) ) {
	function ct_tracks_custom_excerpt_length( $length ) {

		$new_excerpt_length = get_theme_mod( 'additional_options_excerpt_length_settings' );

		if ( ! empty( $new_excerpt_length ) && $new_excerpt_length != 15 ) {
			return $new_excerpt_length;
		} elseif ( $new_excerpt_length === 0 ) {
			return 0;
		} else {
			return 15;
		}
	}
}
add_filter( 'excerpt_length', 'ct_tracks_custom_excerpt_length', 999 );

if ( ! function_exists( 'ct_tracks_new_excerpt_more' ) ) {
	function ct_tracks_new_excerpt_more( $more ) {

		$new_excerpt_length = get_theme_mod( 'additional_options_excerpt_length_settings' );
		$excerpt_more       = ( $new_excerpt_length === 0 ) ? '' : '&#8230;';

		return $excerpt_more;
	}
}
add_filter( 'excerpt_more', 'ct_tracks_new_excerpt_more' );

if ( ! function_exists( 'ct_tracks_remove_more_link_scroll' ) ) {
	function ct_tracks_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );
		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_tracks_remove_more_link_scroll' );

// for displaying featured images including mobile versions and default versions
if ( ! function_exists( 'ct_tracks_featured_image' ) ) {
	function ct_tracks_featured_image() {

		global $post;
		$has_image      = false;
		$featured_image = '';
		$image          = '';

		// get the current layout
		$premium_layout = get_theme_mod( 'premium_layouts_setting' );

		if ( has_post_thumbnail( $post->ID ) ) {
			// get the large version if on archive and not one of the full-width layouts
			if ( ( is_archive() || is_home() ) && $premium_layout != 'full-width' && $premium_layout != 'full-width-images' ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
			} else {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
			}

			$image     = $image[0];
			$has_image = true;
		}

		// if no featured image, try fallback
		if ( $has_image == false ) {

			if ( get_theme_mod( 'additional_options_no_featured_image' ) == 'fallback' ) {
				$image = get_theme_mod( 'additional_options_fallback_featured_image' );

				if ( $image ) {
					$has_image = true;
				}
			}
		}

		if ( $has_image == true ) {
			// if lazy loading is enabled
			if ( get_theme_mod( 'additional_options_lazy_load_settings' ) == 'yes' && ( is_archive() || is_home() ) ) {
				$featured_image = "<div class='featured-image lazy lazy-bg-image' data-background='" . esc_url( $image ) . "'></div>";
			} else {
				$featured_image = "<div class='featured-image' style='background-image: url(" . esc_url( $image ) . ")'></div>";
			}
		}

		$featured_image = apply_filters( 'ct_tracks_featured_image', $featured_image, $image, $has_image );

		if ( $featured_image ) {
			echo $featured_image;
		}
	}
}

if ( ! function_exists( 'ct_tracks_body_class' ) ) {
	function ct_tracks_body_class( $classes ) {

		global $post;
		$premium_layout_setting = get_theme_mod( 'premium_layouts_setting' );

		if ( is_singular() ) {
			$classes[] = 'singular';
			if ( is_singular( 'page' ) ) {
				$classes[] = 'singular-page';
				$classes[] = 'singular-page-' . $post->ID;
			} elseif ( is_singular( 'post' ) ) {
				$classes[] = 'singular-post';
				$classes[] = 'singular-post-' . $post->ID;
			} elseif ( is_singular( 'attachment' ) ) {
				$classes[] = 'singular-attachment';
				$classes[] = 'singular-attachment-' . $post->ID;
			}
		}

		if ( ! is_front_page() ) {
			$classes[] = 'not-front';
		}
		if ( get_theme_mod( 'ct_tracks_header_color_setting' ) == 'dark' ) {
			$classes[] = 'dark-header';
		}
		if ( empty( $premium_layout_setting ) || $premium_layout_setting == 'standard' ) {
			$classes[] = 'standard';
		}
		if ( $premium_layout_setting == 'full-width' ) {
			$classes[] = 'full-width';

			if ( get_theme_mod( 'premium_layouts_full_width_full_post' ) == 'yes' ) {
				$classes[] = 'full-post';
			}
		} elseif ( $premium_layout_setting == 'full-width-images' ) {

			$classes[] = 'full-width-images';

			if ( ( is_home() || is_archive() || is_search() ) && get_theme_mod( 'premium_layouts_full_width_image_height' ) == '2:1-ratio' ) {
				$classes[] = 'ratio';
			}
			if ( is_singular() && get_theme_mod( 'premium_layouts_full_width_image_height_post' ) == '2:1-ratio' ) {
				$classes[] = 'ratio';
			}
			if ( get_theme_mod( 'premium_layouts_full_width_image_style' ) == 'title' ) {
				$classes[] = 'title-below';
			}
		} elseif ( $premium_layout_setting == 'two-column' ) {
			$classes[] = 'two-column';
		} elseif ( $premium_layout_setting == 'two-column-images' ) {
			$classes[] = 'two-column-images';
		}
		if ( get_theme_mod( 'ct_tracks_background_image_setting' ) ) {
			$classes[] = 'background-image-active';
		}
		if ( get_theme_mod( 'ct_tracks_texture_display_setting' ) == 'yes' ) {
			$classes[] = 'background-texture-active';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'ct_tracks_body_class' );

if ( ! function_exists( 'ct_tracks_wp_page_menu' ) ) {
	function ct_tracks_wp_page_menu() {
		wp_page_menu( array(
				"menu_class" => "menu-unset"
			)
		);
	}
}

if ( ! function_exists( 'ct_tracks_add_editor_styles' ) ) {
	function ct_tracks_add_editor_styles() {
		add_editor_style( 'styles/custom-editor-style.css' );
	}
}
add_action( 'admin_init', 'ct_tracks_add_editor_styles' );

if ( ! function_exists( 'ct_tracks_post_class_update' ) ) {
	function ct_tracks_post_class_update( $classes ) {

		global $post;

		if ( ! is_singular() ) {

			$setting = get_theme_mod( 'additional_options_image_zoom_settings' );

			$classes[] = 'excerpt';

			if ( $setting != 'no-zoom' ) {
				$classes[] = 'zoom';
			}
		} else {
			$classes[] = 'entry';
		}

		if ( get_post_meta( $post->ID, 'ct_tracks_video_key', true ) ) {

			if ( is_home() || is_archive() ) {

				$display_setting = get_post_meta( $post->ID, 'ct_tracks_video_display_key', true );

				if ( $display_setting == 'blog' || $display_setting == 'both' ) {
					$classes[] = 'has-video';
				}
			} else {
				$classes[] = 'has-video';
			}
		}

		$featured_image_fallback = get_theme_mod( 'additional_options_no_featured_image' );

		// if full or not set b/c full is the default (and Customizer doesn't save by default)
		if ( $featured_image_fallback == 'full' || empty( $featured_image_fallback ) ) {
			$classes[] = 'full-without-featured';
		}

		return $classes;
	}
}
add_filter( 'post_class', 'ct_tracks_post_class_update' );

if ( ! function_exists( 'add_image_size' ) ) {
	add_image_size( 'blog', 700, 350 );
}

if ( ! function_exists( 'ct_tracks_odd_even_post_class' ) ) {
	function ct_tracks_odd_even_post_class( $classes ) {

		global $wp_query;

		// Jetpack starts new loops of 7 posts, so it always ends with odd leading to 2
		// posts in a row with content on the left
		if (
			// if jetpack infinite scroll is active
			class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' )
			// and the current page is an even page (will be 1,3,5 b/c page starts with 0)
			&& get_query_var( 'paged' ) % 2 != 0
		) {
			// flip the classes - start with even
			$classes[] = ( $wp_query->current_post % 2 == 0 ) ? 'even' : 'odd';
		} else {
			// add even/odd class
			$classes[] = ( $wp_query->current_post % 2 == 0 ) ? 'odd' : 'even';
		}

		// add post # class
		$classes[] = "excerpt-" . ( $wp_query->current_post + 1 );

		return $classes;
	}
}
add_filter( 'post_class', 'ct_tracks_odd_even_post_class' );

if ( ! function_exists( 'ct_tracks_social_site_list' ) ) {
	function ct_tracks_social_site_list() {

		$social_sites = array(
			'twitter',
			'facebook',
			'google-plus',
			'flickr',
			'pinterest',
			'youtube',
			'vimeo',
			'tumblr',
			'dribbble',
			'rss',
			'linkedin',
			'instagram',
			'reddit',
			'soundcloud',
			'spotify',
			'vine',
			'yahoo',
			'behance',
			'codepen',
			'delicious',
			'stumbleupon',
			'deviantart',
			'foursquare',
			'slack',
			'slideshare',
			'skype',
			'whatsapp',
			'snapchat',
			'bandcamp',
			'etsy',
			'quora',
			'ravelry',
			'meetup',
			'telegram',
			'podcast',
			'qq',
			'wechat',
			'xing',
			'500px',
			'digg',
			'github',
			'hacker-news',
			'steam',
			'vk',
			'weibo',
			'tencent-weibo',
			'paypal',
			'email',
			'email-form'
		);

		return apply_filters( 'ct_tracks_social_site_list_filter', $social_sites );
	}
}

// for above the post titles
if ( ! function_exists( 'ct_tracks_category_link' ) ) {
	function ct_tracks_category_link() {
		$category      = get_the_category();
		$category_link = get_category_link( $category[0]->term_id );
		$category_name = $category[0]->cat_name;
		$html          = "<a href='" . esc_url( $category_link ) . "'>" . esc_html( $category_name ) . "</a>";
		echo $html;
	}
}

if ( ! function_exists( 'ct_tracks_custom_css_output' ) ) {
	function ct_tracks_custom_css_output() {

		if ( function_exists( 'wp_get_custom_css' ) ) {
			$custom_css = wp_get_custom_css();
		} else {
			$custom_css = get_theme_mod( 'ct_tracks_custom_css_setting' );
		}

		if ( $custom_css ) {
			$custom_css = ct_tracks_sanitize_css( $custom_css );
			wp_add_inline_style( 'ct-tracks-style', $custom_css );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tracks_custom_css_output', 20 );

if ( ! function_exists( 'ct_tracks_background_image_output' ) ) {
	function ct_tracks_background_image_output() {

		$background_image = get_theme_mod( 'ct_tracks_background_image_setting' );

		if ( $background_image ) {

			$background_image_css = "
            .background-image {
                background-image: url('$background_image');
            }
        ";

			$background_image_css = ct_tracks_sanitize_css( $background_image_css );

			wp_add_inline_style( 'ct-tracks-style', $background_image_css );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tracks_background_image_output', 20 );

if ( ! function_exists( 'ct_tracks_background_texture_output' ) ) {
	function ct_tracks_background_texture_output() {

		$background_texture         = get_theme_mod( 'ct_tracks_background_texture_setting' );
		$background_texture_display = get_theme_mod( 'ct_tracks_texture_display_setting' );

		if ( $background_texture && $background_texture_display == 'yes' ) {

			$background_texture_css = "
            .overflow-container {
                background-image: url('" . plugins_url() . "/tracks-background-textures/textures/$background_texture.png');
            }
        ";

			$background_texture_css = ct_tracks_sanitize_css( $background_texture_css );

			wp_add_inline_style( 'ct-tracks-style', $background_texture_css );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ct_tracks_background_texture_output', 20 );

// green checkmark icon used in Post Video input
if ( ! function_exists( 'ct_tracks_green_checkmark_svg' ) ) {
	function ct_tracks_green_checkmark_svg() {

		$svg = '<svg width="12px" height="13px" viewBox="0 0 12 13" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
				<desc>green checkmark icon</desc>
				<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				    <path d="M12.0000143,5.99999404 C12.0000143,2.68749009 9.3125111,-1.31130219e-05 6.00000715,-1.31130219e-05 C2.6875032,-1.31130219e-05 0,2.68749009 0,5.99999404 C0,9.31249799 2.6875032,12.0000012 6.00000715,12.0000012 C9.3125111,12.0000012 12.0000143,9.31249799 12.0000143,5.99999404 Z M10.031262,4.73436753 C10.031262,4.86718019 9.9843869,4.99218034 9.89063679,5.08593045 L5.64844423,9.32812301 C5.55469412,9.42187312 5.42188146,9.47656068 5.28906881,9.47656068 C5.16406866,9.47656068 5.031256,9.42187312 4.93750589,9.32812301 L2.10937751,6.49999464 C2.0156274,6.40624452 1.96875235,6.28124437 1.96875235,6.14843172 C1.96875235,6.01561906 2.0156274,5.8828064 2.10937751,5.78905629 L2.82031586,5.08593045 C2.91406597,4.99218034 3.03906612,4.93749277 3.17187878,4.93749277 C3.30469144,4.93749277 3.42969159,4.99218034 3.5234417,5.08593045 L5.28906881,6.85155755 L8.4765726,3.67186626 C8.57032272,3.57811615 8.69532287,3.52342859 8.82813552,3.52342859 C8.96094818,3.52342859 9.08594833,3.57811615 9.17969844,3.67186626 L9.89063679,4.3749921 C9.9843869,4.46874221 10.031262,4.60155487 10.031262,4.73436753 Z" fill="#43C591"></path>
				</g>
			</svg>';

		return $svg;
	}
}

// loading indicator used in Post Video input
if ( ! function_exists( 'ct_tracks_loading_indicator_svg' ) ) {
	function ct_tracks_loading_indicator_svg() {

		$svg = '<svg width="47px" height="50px" viewBox="0 0 47 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
			    <desc>loading icon</desc>
			    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
			        <path d="M14.9464464,39.2142788 C14.9464464,36.8035617 12.9877387,34.8749879 10.6071555,34.8749879 C8.19643834,34.8749879 6.26786461,36.8035617 6.26786461,39.2142788 C6.26786461,41.624996 8.19643834,43.5535697 10.6071555,43.5535697 C12.9877387,43.5535697 14.9464464,41.624996 14.9464464,39.2142788 Z M27.9643191,45 C27.9643191,42.8604885 26.2466831,41.1428525 24.1071716,41.1428525 C21.9676601,41.1428525 20.2500241,42.8604885 20.2500241,45 C20.2500241,47.1395115 21.9676601,48.8571475 24.1071716,48.8571475 C26.2466831,48.8571475 27.9643191,47.1395115 27.9643191,45 Z M9.64286864,25.7142627 C9.64286864,23.0624738 7.47322319,20.8928284 4.82143432,20.8928284 C2.16964544,20.8928284 0,23.0624738 0,25.7142627 C0,28.3660516 2.16964544,30.535697 4.82143432,30.535697 C7.47322319,30.535697 9.64286864,28.3660516 9.64286864,25.7142627 Z M40.9821917,39.2142788 C40.9821917,37.345973 39.4754935,35.8392748 37.6071877,35.8392748 C35.7388819,35.8392748 34.2321837,37.345973 34.2321837,39.2142788 C34.2321837,41.0825846 35.7388819,42.5892828 37.6071877,42.5892828 C39.4754935,42.5892828 40.9821917,41.0825846 40.9821917,39.2142788 Z M15.9107333,12.2142466 C15.9107333,9.29125207 13.5301501,6.91066888 10.6071555,6.91066888 C7.68416095,6.91066888 5.30357775,9.29125207 5.30357775,12.2142466 C5.30357775,15.1372412 7.68416095,17.5178244 10.6071555,17.5178244 C13.5301501,17.5178244 15.9107333,15.1372412 15.9107333,12.2142466 Z M29.8928928,6.42852545 C29.8928928,3.23432521 27.3013718,0.642804265 24.1071716,0.642804265 C20.9129714,0.642804265 18.3214504,3.23432521 18.3214504,6.42852545 C18.3214504,9.62272568 20.9129714,12.2142466 24.1071716,12.2142466 C27.3013718,12.2142466 29.8928928,9.62272568 29.8928928,6.42852545 Z M46.2857695,25.7142627 C46.2857695,24.1171626 44.990009,22.8214021 43.3929089,22.8214021 C41.7958088,22.8214021 40.5000483,24.1171626 40.5000483,25.7142627 C40.5000483,27.3113628 41.7958088,28.6071233 43.3929089,28.6071233 C44.990009,28.6071233 46.2857695,27.3113628 46.2857695,25.7142627 Z M40.0179048,12.2142466 C40.0179048,10.8883522 38.9330821,9.80352947 37.6071877,9.80352947 C36.2812933,9.80352947 35.1964705,10.8883522 35.1964705,12.2142466 C35.1964705,13.5401411 36.2812933,14.6249638 37.6071877,14.6249638 C38.9330821,14.6249638 40.0179048,13.5401411 40.0179048,12.2142466 Z" fill="#FFFFFF"></path>
			    </g>
			</svg>';

		return $svg;
	}
}

if ( ! function_exists( 'ct_tracks_two_column_images_featured_image' ) ) {
	function ct_tracks_two_column_images_featured_image( $featured_image, $image, $has_image ) {

		if ( $has_image && get_theme_mod( 'premium_layouts_setting' ) == 'two-column-images' ) {

			$pre  = '';
			$post = '';

			if ( is_singular() ) {
				$pre  = "<div class='featured-image-container'>";
				$post = "</div>";
			}
			$featured_image = $pre . '<img class="featured-image" src="' . $image . '" />' . $post;
		}

		return $featured_image;
	}
}
add_filter( 'ct_tracks_featured_image', 'ct_tracks_two_column_images_featured_image', 10, 3 );

if ( ! function_exists( 'ct_tracks_full_width_images_featured_image' ) ) {
	function ct_tracks_full_width_images_featured_image( $featured_image, $image, $has_image ) {

		if ( $has_image && get_theme_mod( 'premium_layouts_setting' ) == 'full-width-images' ) {

			$pre  = '';
			$post = '';

			if ( is_singular() ) {
				$pre  = "<div class='featured-image-container'>";
				$post = "</div>";
			}

			$blog_image_type = get_theme_mod( 'premium_layouts_full_width_image_height' );
			$post_image_type = get_theme_mod( 'premium_layouts_full_width_image_height_post' );

			// if blog/archive and image-based height, or post/page and image-based height
			if (
				// if archive/blog and image type is set to image or not set yet
				( ( is_archive() || is_home() ) && ( empty( $blog_image_type ) || $blog_image_type == 'image' ) )
				// or if is post and post height type is set to image or not set yet
				|| ( is_singular() && ( empty( $post_image_type ) || $post_image_type == 'image' ) )
			) {
				$featured_image = '<img class="featured-image" src="' . $image . '" />';
			}
			$featured_image = $pre . $featured_image . $post;
		}

		return $featured_image;
	}
}
add_filter( 'ct_tracks_featured_image', 'ct_tracks_full_width_images_featured_image', 10, 3 );

if ( ! function_exists( 'ct_tracks_add_meta_elements' ) ) {
	function ct_tracks_add_meta_elements() {

		$meta_elements = '';

		$meta_elements .= sprintf( '<meta charset="%s" />' . "\n", esc_attr( get_bloginfo( 'charset' ) ) );
		$meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

		$theme    = wp_get_theme( get_template() );
		$template = sprintf( '<meta name="template" content="%s %s" />' . "\n", esc_attr( $theme->get( 'Name' ) ), esc_attr( $theme->get( 'Version' ) ) );
		$meta_elements .= $template;

		echo $meta_elements;
	}
}
add_action( 'wp_head', 'ct_tracks_add_meta_elements', 1 );

// Move the WordPress generator to a better priority.
remove_action( 'wp_head', 'wp_generator' );
add_action( 'wp_head', 'wp_generator', 1 );

if ( ! function_exists( 'ct_tracks_infinite_scroll_render' ) ) {
	function ct_tracks_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			// Two-column Images Layout
			if ( get_theme_mod( 'premium_layouts_setting' ) == 'two-column-images' ) {
				get_template_part( 'licenses/content/content-two-column-images' );
			} // Full-width Images Layout
			elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'full-width-images' ) {
				get_template_part( 'licenses/content/content-full-width-images' );
			} // Blog - No Premium Layout
			else {
				get_template_part( 'content', 'archive' );
			}
		}
	}
}

if ( ! function_exists( 'ct_tracks_get_content_template' ) ) {
	function ct_tracks_get_content_template() {

		/* Blog */
		if ( is_home() ) {

			/* Two-column Images Layout */
			if ( get_theme_mod( 'premium_layouts_setting' ) == 'two-column-images' ) {
				get_template_part( 'licenses/content/content-two-column-images' );
			} /* Full-width Images Layout */
			elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'full-width-images' ) {
				get_template_part( 'licenses/content/content-full-width-images' );
			} /* Blog - No Premium Layout */
			else {
				get_template_part( 'content', 'archive' );
			}
		} /* Post */
		elseif ( is_singular( 'post' ) ) {
			get_template_part( 'content' );
			comments_template();
		} /* Page */
		elseif ( is_page() ) {
			get_template_part( 'content', 'page' );
			comments_template();
		} /* Attachment */
		elseif ( is_attachment() ) {
			get_template_part( 'content', 'attachment' );
			comments_template();
		} /* Archive */
		elseif ( is_archive() ) {

			/* check if bbPress is active */
			if ( function_exists( 'is_bbpress' ) ) {

				/* if is bbPress forum list */
				if ( is_bbpress() ) {
					get_template_part( 'content/bbpress' );
				} /* normal archive */
				else {
					get_template_part( 'content', 'archive' );
				}
			} elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'two-column-images' ) {
				get_template_part( 'licenses/content/content-two-column-images' );
			} elseif ( get_theme_mod( 'premium_layouts_setting' ) == 'full-width-images' ) {
				get_template_part( 'licenses/content/content-full-width-images' );
			} else {
				get_template_part( 'content', 'archive' );
			}
		} /* bbPress */
		elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
			get_template_part( 'content/bbpress' );
		} /* Custom Post Types */
		else {
			get_template_part( 'content' );
		}
	}
}

// allow skype URIs to be used
if ( ! function_exists( 'ct_tracks_allow_skype_protocol' ) ) {
	function ct_tracks_allow_skype_protocol( $protocols ) {
		$protocols[] = 'skype';

		return $protocols;
	}
}
add_filter( 'kses_allowed_protocols' , 'ct_tracks_allow_skype_protocol' );

// trigger theme switch on link click and send to Appearance menu
function ct_tracks_welcome_redirect() {

	$welcome_url = add_query_arg(
		array(
			'page'          => 'tracks-options',
			'tracks_status' => 'activated'
		),
		admin_url( 'themes.php' )
	);
	wp_safe_redirect( esc_url_raw( $welcome_url ) );
}
add_action( 'after_switch_theme', 'ct_tracks_welcome_redirect' );

if ( function_exists( 'ct_tracks_pro_plugin_updater' ) ) {
	remove_action( 'admin_init', 'ct_tracks_pro_plugin_updater', 0 );
	add_action( 'admin_init', 'ct_tracks_pro_plugin_updater', 0 );
}

if ( ! function_exists( ( 'ct_tracks_settings_notice' ) ) ) {
	function ct_tracks_settings_notice() {

		if ( isset( $_GET['tracks_status'] ) ) {

			if ( $_GET['tracks_status'] == 'activated' ) {
				?>
				<div class="updated">
					<p><?php _e( 'Thanks for activating Tracks!', 'tracks' ); ?></p>
				</div>
				<?php
			}
		}
	}
}
add_action( 'admin_notices', 'ct_tracks_settings_notice' );