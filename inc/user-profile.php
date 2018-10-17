<?php

if ( ! function_exists( 'ct_tracks_social_array' ) ) {
	function ct_tracks_social_array() {

		$social_sites = array(
			'twitter'       => 'twitter_profile',
			'facebook'      => 'facebook_profile',
			'googleplus'    => 'googleplus_profile',
			'pinterest'     => 'pinterest_profile',
			'linkedin'      => 'linkedin_profile',
			'youtube'       => 'youtube_profile',
			'vimeo'         => 'vimeo_profile',
			'tumblr'        => 'tumblr_profile',
			'instagram'     => 'instagram_profile',
			'flickr'        => 'flickr_profile',
			'dribbble'      => 'dribbble_profile',
			'rss'           => 'rss_profile',
			'reddit'        => 'reddit_profile',
			'soundcloud'    => 'soundcloud_profile',
			'spotify'       => 'spotify_profile',
			'vine'          => 'vine_profile',
			'yahoo'         => 'yahoo_profile',
			'behance'       => 'behance_profile',
			'codepen'       => 'codepen_profile',
			'delicious'     => 'delicious_profile',
			'stumbleupon'   => 'stumbleupon_profile',
			'deviantart'    => 'deviantart_profile',
			'foursquare'    => 'foursquare_profile',
			'slack'         => 'slack_profile',
			'slideshare'    => 'slideshare_profile',
			'skype'         => 'skype_profile',
			'whatsapp'      => 'whatsapp_profile',
			'snapchat'      => 'snapchat_profile',
			'bandcamp'      => 'bandcamp_profile',
			'etsy'          => 'etsy_profile',
			'quora'         => 'quora_profile',
			'ravelry'       => 'ravelry_profile',
			'meetup'        => 'meetup_profile',
			'telegram'      => 'telegram_profile',
			'twitch'        => 'twitch_profile',
			'podcast'       => 'podcast_profile',
			'yelp'          => 'yelp_profile',
			'amazon'        => 'amazon_profile',
			'google-wallet' => 'google_wallet_profile',
			'qq'            => 'qq_profile',
			'wechat'        => 'wechat_profile',
			'xing'          => 'xing_profile',
			'500px'         => '500px_profile',
			'digg'          => 'digg_profile',
			'github'        => 'github_profile',
			'hacker-news'   => 'hacker-news_profile',
			'steam'         => 'steam_profile',
			'vk'            => 'vk_profile',
			'weibo'         => 'weibo_profile',
			'tencent-weibo' => 'tencent_weibo_profile',
			'paypal'        => 'paypal_profile',
			'email'         => 'email_profile'
		);

		return apply_filters( 'ct_tracks_social_array_filter', $social_sites );
	}
}

function ct_tracks_add_social_profile_settings( $user ) {

	$social_sites = ct_tracks_social_array();
	$user_id      = get_current_user_id();

	// only added for contributors and above
	if ( ! current_user_can( 'edit_posts', $user_id ) ) {
		return false;
	}

	?>
	<table class="form-table">
		<tr>
			<th><h3><?php esc_html_e( 'Social Profiles', 'tracks' ); ?></h3></th>
		</tr>
		<?php
		foreach ( $social_sites as $key => $social_site ) {

			$label = ucfirst( $key );

			if ( $key == 'google-plus' ) {
				$label = __('Google Plus', 'tracks');
			} elseif ( $key == 'rss' ) {
				$label = __('RSS', 'tracks');
			} elseif ( $key == 'soundcloud' ) {
				$label = __('SoundCloud', 'tracks');
			} elseif ( $key == 'slideshare' ) {
				$label = __('SlideShare', 'tracks');
			} elseif ( $key == 'codepen' ) {
				$label = __('CodePen', 'tracks');
			} elseif ( $key == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'tracks');
			} elseif ( $key == 'deviantart' ) {
				$label = __('DeviantArt', 'tracks');
			} elseif ( $key == 'google-wallet' ) {
				$label = __('Google Wallet', 'tracks');
			} elseif ( $key == 'hacker-news' ) {
				$label = __('Hacker News', 'tracks');
			} elseif ( $key == 'whatsapp' ) {
				$label = __('WhatsApp', 'tracks');
			} elseif ( $key == 'qq' ) {
				$label = __('QQ', 'tracks');
			} elseif ( $key == 'vk' ) {
				$label = __('VK', 'tracks');
			} elseif ( $key == 'ok-ru' ) {
				$label = __('OK.ru', 'tracks');
			} elseif ( $key == 'wechat' ) {
				$label = __('WeChat', 'tracks');
			} elseif ( $key == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'tracks');
			} elseif ( $key == 'paypal' ) {
				$label = __('PayPal', 'tracks');
			} elseif ( $key == 'email-form' ) {
				$label = __('Contact Form', 'tracks');
			}
			?>
			<tr>
				<th>
					<?php if ( $key == 'email' ) : ?>
						<label for="<?php echo esc_attr( $key ); ?>-profile"><?php esc_html_e( 'Email Address', 'tracks' ); ?></label>
					<?php else : ?>
						<label for="<?php echo esc_attr( $key ); ?>-profile"><?php echo esc_html( $label ); ?></label>
					<?php endif; ?>
				</th>
				<td>
					<?php if ( $key == 'email' ) : ?>
						<input type='text' id='<?php echo esc_attr( $key ); ?>-profile' class='regular-text'
						       name='<?php echo esc_attr( $key ); ?>-profile'
						       value='<?php echo is_email( get_the_author_meta( $social_site, $user->ID ) ); ?>'/>
					<?php else : ?>
						<input type='url' id='<?php echo esc_attr( $key ); ?>-profile' class='regular-text'
						       name='<?php echo esc_attr( $key ); ?>-profile'
						       value='<?php echo esc_url( get_the_author_meta( $social_site, $user->ID ) ); ?>'/>
					<?php endif; ?>
				</td>
			</tr>
		<?php } ?>
	</table>
	<?php
}
add_action( 'show_user_profile', 'ct_tracks_add_social_profile_settings' );
add_action( 'edit_user_profile', 'ct_tracks_add_social_profile_settings' );

function ct_tracks_save_social_profiles( $user_id ) {

	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	$social_sites = ct_tracks_social_array();

	foreach ( $social_sites as $key => $social_site ) {
		if ( $key == 'email' ) {
			// if email, only accept 'mailto' protocol
			if ( isset( $_POST["$key-profile"] ) ) {
				update_user_meta( $user_id, $social_site, sanitize_email( $_POST["$key-profile"] ) );
			}
		} else {
			if ( isset( $_POST["$key-profile"] ) ) {
				update_user_meta( $user_id, $social_site, esc_url_raw( $_POST["$key-profile"] ) );
			}
		}
	}
}
add_action( 'personal_options_update', 'ct_tracks_save_social_profiles' );
add_action( 'edit_user_profile_update', 'ct_tracks_save_social_profiles' );