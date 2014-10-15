<?php
/**
 * Template Name: Bold
 */

// get page ID
$post_id = $post->ID;

// meta box ids
$input_ids = ct_tracks_bold_template_inputs();

// create array to store user input
$user_input = array();

// for each meta box, add the user input to the $user_input array
foreach( $input_ids as $input ) {

	if( $input == 'button_one_link' || $input == 'button_two_link' || $input == 'bg_image' ) {
		$user_input[$input] = esc_url_raw( get_post_meta( $post_id, 'ct_tracks_bold_' . $input . '_key', true ) );
	} else {
		$user_input[$input] = sanitize_text_field( get_post_meta( $post_id, 'ct_tracks_bold_' . $input . '_key', true ) );
	}
}

// combine arrays ( heading => user input )
$user_input = array_combine( $input_ids, $user_input );
?>

<?php get_header() ?>

	<div class="bold-template">
		<div class="container">
			<?php
			if( $user_input['heading'] ) {
				echo "<h1 class='heading'>" . sanitize_text_field( $user_input['heading'] ) . "</h1>";
			}
			if( $user_input['sub_heading'] ) {
				echo "<h2 class='sub-heading'>" . sanitize_text_field( $user_input['sub_heading'] ) . "</h2>";
			}
			if( $user_input['description'] ) {
				echo "<div class='description'>";
					echo "<p>" . sanitize_text_field( $user_input['description'] ) . "</p>";
				echo "</div>";
			}
			if( $user_input['button_one_link'] ) {
				echo "<a class='button button-one' href='" . esc_url( $user_input['button_one_link'] ) . "'>" . sanitize_text_field( $user_input['button_one'] ) . "</a>";
			}
			if( $user_input['button_two_link'] ) {
				echo "<a class='button button-two' href='" . esc_url( $user_input['button_two_link'] ) . "'>" . sanitize_text_field( $user_input['button_two'] ) . "</a>";
			}
			?>
		</div>
	</div>
	<?php
	if( $user_input['bg_image'] ) {
		echo "<div id='template-bg-image' class='template-bg-image' style='background-image: url(" . esc_url( $user_input['bg_image'] ) . ")'></div>";
	}
	echo "<div id='template-overlay' class='template-overlay'></div>";
	?>

<?php get_footer() ?>