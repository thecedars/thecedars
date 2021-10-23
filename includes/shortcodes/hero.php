<?php
/**
 * Shortcode: Hero
 *
 * @package Cedars/Shortcodes
 */

/**
 * Hero.
 *
 * @param array  $atts The shortcode attributes.
 * @param string $contents The contents between the shortcode tags.
 * @return string
 */
function cedars_shortcode_hero( $atts, $contents = '' ) {
	$contents   = do_shortcode( $contents );
	$opacity    = ! empty( $atts['opacity'] ) ? absint( $atts['opacity'] ) : 0;
	$background = ! empty( $atts['background'] ) ? absint( $atts['background'] ) : null;

	if ( ! empty( $background ) ) {
		$background_image = cedars_image_src( $background, 'large' );
	}

	ob_start();
	include locate_template( 'template-parts/hero.php' );
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'hero', 'cedars_shortcode_hero' );
