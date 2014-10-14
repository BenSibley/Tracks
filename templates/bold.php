<?php
/**
 * Template Name: Bold
 */

// get page ID
$post_id = $post->ID;

// get all UGC from template meta boxes
$heading = sanitize_text_field( get_post_meta( $post_id, 'ct_tracks_bold_heading_key', true ) );
$sub_heading = sanitize_text_field( get_post_meta( $post_id, 'ct_tracks_bold_sub_heading_key', true ) );
$description = sanitize_text_field( get_post_meta( $post_id, 'ct_tracks_bold_description_key', true ) );
$button_one_text = sanitize_text_field( get_post_meta( $post_id, 'ct_tracks_bold_button_one_key', true ) );
$button_one_link = esc_url_raw( get_post_meta( $post_id, 'ct_tracks_bold_button_one_link_key', true ) );
$button_two_text = sanitize_text_field( get_post_meta( $post_id, 'ct_tracks_bold_button_two_key', true ) );
$button_two_link = esc_url_raw( get_post_meta( $post_id, 'ct_tracks_bold_button_two_link_key', true ) );
$bg_image = esc_url_raw( get_post_meta( $post_id, 'ct_tracks_bold_bg_image_key', true ) );

?>

<?php get_header() ?>

	<div class="bold-template">
		<div class="container">
			<?php
			if( $heading ) {
				echo "<h1 class='heading'>" . sanitize_text_field($heading) . "</h1>";
			}
			if( $sub_heading ) {
				echo "<h2 class='sub-heading'>" . sanitize_text_field($sub_heading) . "</h2>";
			}
			if( $description ) {
				echo "<div class='description'>";
					echo "<p>" . sanitize_text_field($description) . "</p>";
				echo "</div>";
			}
			if( $button_one_text ) {
				echo "<a class='button button-one' href='" . esc_url($button_one_link) . "'>" . sanitize_text_field($button_one_text) . "</a>";
			}
			if( $button_two_text ) {
				echo "<a class='button button-two' href='" . esc_url($button_two_link) . "'>" . sanitize_text_field($button_two_text) . "</a>";
			}
			?>
		</div>
	</div>
	<?php
	if( $bg_image ) {
		echo "<div id='template-bg-image' class='template-bg-image' style='background-image: url(" . esc_url($bg_image) . ")'></div>";
	}
	echo "<div id='template-overlay' class='template-overlay'></div>";
	?>

<?php get_footer() ?>