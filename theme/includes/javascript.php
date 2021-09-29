<?php
/**
 * Javascript window.__WP Object
 *
 * @package Cedars
 */

/**
 * WP-GraphQL Endpoint.
 *
 * @return string
 */
function cedars_get_gql_endpoint() {
	$filtered_endpoint = apply_filters( 'graphql_endpoint', null );
	$endpoint          = $filtered_endpoint ? $filtered_endpoint : get_graphql_setting( 'graphql_endpoint', 'graphql' );

	return home_url( $endpoint );
}

/**
 * Builds the __WP javascript object.
 *
 * @return void
 */
function cedars_wp_js() {
	$wordpress_window_object = wp_json_encode( apply_filters( 'cedars_wp_js_window', array() ) );

	printf( '<script type="text/javascript">window.__WP=%s;</script>', $wordpress_window_object ); // phpcs:ignore
}

add_action( 'wp_head', 'cedars_wp_js' );

/**
 * Filters the __WP window object.
 *
 * @param array $wp Associative array being filtered.
 * @return array
 */
function cedars_js_window_filter( $wp ) {
	$wp['GQLURL']    = cedars_get_gql_endpoint();
	$wp['THEME_URL'] = get_stylesheet_directory_uri();
	$wp['SITE_URL']  = get_site_url( null );
	return $wp;
}

add_filter( 'cedars_wp_js_window', 'cedars_js_window_filter' );
