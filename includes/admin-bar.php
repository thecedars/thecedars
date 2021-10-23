<?php
/**
 * Admin bar styling.
 *
 * @package Cedars
 * @phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
 */

/**
 * Removes the styling to bump the html element.
 *
 * @return void
 */
function cedars_remove_admin_bar_bump() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

add_action( 'wp_head', 'cedars_remove_admin_bar_bump', 5 );

/**
 * Adds the same bumpout for the admin bar, but as padding for the header.
 *
 * @return void
 */
function cedars_add_bump_for_admin_bar() {
	if ( is_admin_bar_showing() ) {
		$style = '#header { padding-top: 32px; } @media screen and ( max-width: 782px ) { #header { padding-top: 46px; } } ';

		printf( "\n\t<style type=\"text/css\">\n%s\n\t</style>\n", $style );
	}
}

add_action( 'wp_head', 'cedars_add_bump_for_admin_bar' );
