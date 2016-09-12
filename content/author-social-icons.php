<?php

$social_sites = ct_tracks_social_array();

$square_icons = array(
	'linkedin',
	'twitter',
	'vimeo',
	'youtube',
	'pinterest',
	'reddit',
	'tumblr',
	'steam',
	'xing',
	'github',
	'google-plus',
	'behance',
	'facebook'
);

foreach ( $social_sites as $key => $social_site ) {

	if ( get_the_author_meta( $social_site ) ) {

		if ( in_array( $key, $square_icons ) ) {
			$class = 'fa fa-' . $key . '-square';
		} else {
			$class = 'fa fa-' . $key;
		}

		if ( $key == 'googleplus' ) {
			$class = 'fa fa-google-plus-square';
		}

		if ( $key == 'email' ) { ?>
			<a class="email" target="_blank"
			   href="mailto:<?php echo antispambot( is_email( get_the_author_meta( $social_site ) ) ); ?>">
				<i class="fa fa-envelope" title="<?php esc_attr_e( 'email icon', 'tracks' ); ?>"></i>
			</a>
		<?php } else { ?>
			<a class="<?php echo esc_attr( $key ); ?>" target="_blank"
			   href="<?php echo esc_url( get_the_author_meta( $social_site ) ); ?>">
				<i class="<?php echo esc_attr( $class ); ?>"
				   title="<?php printf( esc_attr__( '%s icon', 'tracks' ), $key ); ?>"></i>
			</a>
			<?php
		}
	}
}