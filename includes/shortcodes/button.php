<?php
/**
 * Shortcode: Button
 *
 * @package Cedars/Shortcodes
 */

/**
 * Button.
 *
 * @param array $atts The shortcode attributes.
 * @return string
 */
function cedars_shortcode_button( $atts ) {
	$text     = ! empty( $atts['text'] ) ? $atts['text'] : '';
	$link     = ! empty( $atts['link'] ) ? $atts['link'] : '';
	$inverted = ! empty( $atts['inverted'] ) ? boolval( $atts['inverted'] ) : false;

	ob_start();
	?>

	<a class="<?php cedars_button( $inverted ); ?>" href="<?php echo esc_attr( $link ); ?>">
		<?php echo esc_html( $text ); ?>
	</a>

	<?php
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'cedars-button', 'cedars_shortcode_button' );
