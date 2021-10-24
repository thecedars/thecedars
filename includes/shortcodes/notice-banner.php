<?php
/**
 * Shortcode: Notice Banner
 *
 * @package Cedars/Shortcodes
 */

/**
 * Notice Banner.
 *
 * @param array  $atts The shortcode attributes.
 * @param string $contents The contents between the shortcode tags.
 * @return string
 */
function cedars_shortcode_notice_banner( $atts, $contents = '' ) {
	$contents = do_shortcode( $contents );
	$margin   = ! empty( $atts['margin'] ) ? absint( $atts['margin'] ) : 0;

	ob_start();
	?>

	<div class="br4 bg-secondary pa4 overflow-hidden light-gray mv<?php echo esc_attr( $margin ); ?>">
		<?php echo wp_kses_post( $contents ); ?>
	</div>

	<?php
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'cedars-notice-banner', 'cedars_shortcode_notice_banner' );
