<?php
/**
 * Internal routing
 *
 * @package Cedars
 */

/**
 * Removes 404 for builtin pages.
 *
 * @return void
 */
function cedars_template_redirect() {
	global $wp_query;
	$current_uri    = trim( wp_parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
	$built_in_pages = apply_filters( 'cedars_built_in_pages', array( 'search', 'login', 'forgot-password', 'logout', 'register' ) );

	if ( ! empty( $current_uri ) && ( in_array( $current_uri, $built_in_pages, true ) || false !== strpos( $current_uri, 'rp/' ) ) ) {
		$wp_query->is_404 = false;
		status_header( 200 );
	}
}

add_action( 'template_redirect', 'cedars_template_redirect', PHP_INT_MAX );
