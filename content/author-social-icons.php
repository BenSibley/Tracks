<?php

$social_sites = ct_tracks_social_array();

$square_icons = array(
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
			$class = 'fab fa-' . $key . '-square';
		} elseif ( $key == 'email-form' ) {
			$class = 'far fa-envelope';
		} elseif ( $key == 'rss' ) {
			$class = 'fas fa-rss';
		} elseif ( $key == 'podcast' ) {
			$class = 'fas fa-podcast';
		} elseif ( $key == 'wechat' ) {
			$class = 'fab fa-weixin';
		} elseif ( $key == 'ok-ru' ) {
			$class = 'fab fa-odnoklassniki';
		} elseif ( $key == 'phone' ) {
			$class = 'fas fa-phone';
		} else {
			$class = 'fab fa-' . $key;
		}

		if ( $key == 'email' ) { ?>
			<a class="email" target="_blank"
			   href="mailto:<?php echo antispambot( is_email( get_the_author_meta( $social_site ) ) ); ?>">
				<i class="fas fa-envelope" title="<?php esc_attr_e( 'email icon', 'tracks' ); ?>"></i>
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