<?php
/**
 * Template Name: Bold
 */

$post_id = $post->ID;
$heading = get_post_meta( $post_id, 'ct_tracks_bold_heading', true );
$sub_heading = get_post_meta( $post_id, 'ct_tracks_bold_sub_heading', true );
$description = get_post_meta( $post_id, 'ct_tracks_bold_description', true );
$button_one_text = get_post_meta( $post_id, 'ct_tracks_bold_button_one', true );
$button_one_link = get_post_meta( $post_id, 'ct_tracks_bold_button_one_link', true );
$button_two_text = get_post_meta( $post_id, 'ct_tracks_bold_button_two', true );
$button_two_link = get_post_meta( $post_id, 'ct_tracks_bold_button_two_link', true );
$bg_image = get_post_meta( $post_id, 'ct_tracks_bold_bg_image', true );

?>

<?php get_header() ?>

	<div class="bold-template">
		<div class="container">
			<?php
			if( $heading ) {
				echo "<h1 class='heading'>$heading</h1>";
			}
			if( $sub_heading ) {
				echo "<h2 class='sub-heading'>$sub_heading</h2>";
			}
			if( $description ) {
				echo "<div class='description'>";
					echo "<p>$description</p>";
				echo "</div>";
			}
			if( $button_one_text ) {
				echo "<a class='button button-one' href='$button_one_link'>$button_one_text</a>";
			}
			if( $button_two_text ) {
				echo "<a class='button button-two' href='$button_two_link'>$button_two_text</a>";
			}
			?>
		</div>
	</div>
	<?php
	if( $bg_image ) {
		echo "<div id='template-bg-image' class='template-bg-image' style='background-image: url($bg_image)'></div>";
	}
	?>

<?php get_footer() ?>