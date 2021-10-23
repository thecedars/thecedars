<?php
/**
 * Login screen
 *
 * @package Cedars
 */

/**
 * Changes out the logo for the logo in theme_mods.
 *
 * @return void
 */
function cedars_wp_login_logo() {
	$logo = get_theme_mod( 'custom_logo' );

	if ( $logo ) {
		$url = wp_get_attachment_url( $logo );

		if ( $url ) {
			wp_cache_set( 'logo_url', $url );

			get_template_part( 'template-parts/login-css' );
		}
	}
}

add_action( 'login_enqueue_scripts', 'cedars_wp_login_logo' );

/**
 * Replaces the wp-login logo link with the site url.
 *
 * @return string Site url.
 */
function cedars_site_url_link() {
	return get_site_url( null );
}

add_filter( 'login_headerurl', 'cedars_site_url_link' );
