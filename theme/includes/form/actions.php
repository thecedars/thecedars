<?php
/**
 * Form success filters.
 *
 * @package Cedars
 */

/**
 * Converts the key value input pairs to something that can be read in a mail message.
 *
 * @param array $input Fields submitted in the form.
 * @return string
 */
function cedars_input_to_text( $input ) {
	$walked = $input;
	array_walk(
		$walked,
		function( &$value, $key ) {
			$value = apply_filters( 'cedars_input_to_text', sprintf( "%s: %s\n", ucwords( $key ), $value ), $value, $key, $input );
		}
	);

	return implode( "\n", $walked );
}

/**
 * Add recaptcha key to window.
 *
 * @param array $window_wp Form nonces.
 * @return array
 */
function cedars_add_recaptcha_to_window( $window_wp ) {
	$window_wp['recaptcha'] = get_option( 'google_site_key' ) ? get_option( 'google_site_key' ) : false;

	return $window_wp;
}

add_filter( 'cedars_wp_js_window', 'cedars_add_recaptcha_to_window' );
