<?php

$social_sites = ct_tracks_social_site_list();

$square_icons = array(
	'linkedin',
	'twitter',
	'vimeo',
	'youtube',
	'pinterest',
	'rss',
	'reddit',
	'tumblr',
	'steam',
	'xing',
	'github',
	'google-plus',
	'behance',
	'facebook'
);

foreach ( $social_sites as $social_site ) {
	if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
		$active_sites[] = $social_site;
	}
}

if ( ! empty( $active_sites ) ) {

	echo '<ul class="social-media-icons">';

		foreach ( $active_sites as $active_site ) {

			if ( in_array( $active_site, $square_icons ) ) {
				$class = 'fa fa-' . $active_site . '-square';
			} else {
				$class = 'fa fa-' . $active_site;
			}

			if ( $active_site == 'email' ) { ?>
				<li>
					<a class="email" target="_blank"
					   href="mailto:<?php echo antispambot( is_email( get_theme_mod( $active_site ) ) ); ?>">
						<i class="fa fa-envelope" title="<?php echo esc_attr_x( 'email', 'noun', 'tracks' ); ?>"></i>
						<span class="screen-reader-text"><?php echo esc_html_x( 'email', 'noun', 'tracks' ); ?></span>
					</a>
				</li>
			<?php } elseif ( $active_site == 'email-form' ) { ?>
				<li>
					<a class="contact-form" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $active_site ) ); ?>">
						<i class="fa fa-envelope-o" title="<?php esc_attr_e( 'contact form', 'tracks' ); ?>"></i>
						<span class="screen-reader-text"><?php esc_html_e( 'contact form', 'tracks' ); ?></span>
					</a>
				</li>
			<?php }  elseif ( $active_site == 'skype') { ?>
				<li>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $active_site ), array( 'http', 'https', 'skype' ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $active_site ); ?>"></i>
						<span class="screen-reader-text"><?php echo esc_html( $active_site ); ?></span>
					</a>
				</li>
				<?php
			} else { ?>
				<li>
					<a class="<?php echo esc_attr( $active_site ); ?>" target="_blank"
					   href="<?php echo esc_url( get_theme_mod( $active_site ) ); ?>">
						<i class="<?php echo esc_attr( $class ); ?>" title="<?php echo esc_attr( $active_site ); ?>"></i>
						<span class="screen-reader-text"><?php echo esc_html( $active_site ); ?></span>
					</a>
				</li>
				<?php
			}
		}
	echo "</ul>";
}