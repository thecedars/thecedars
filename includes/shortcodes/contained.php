<?php
/**
 * Shortcode: Contained
 *
 * @package Cedars/Shortcodes
 */

/**
 * Contained.
 *
 * @param array  $atts The shortcode attributes.
 * @param string $contents The contents between the shortcode tags.
 * @return string
 */
function cedars_shortcode_contained( $atts, $contents = '' ) {
	$contents = do_shortcode( $contents );

	return '<div class="' . cedars_page_width__() . '">' . $contents . '</div>';
}

add_shortcode( 'contained', 'cedars_shortcode_contained' );
