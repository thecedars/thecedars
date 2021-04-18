<?php
/**
 * ACF Hooks.
 *
 * @package Cedars
 */

/**
 * Hides the menu item if WP_DEBUG isn't enabled.
 *
 * @param boolean $show_admin Whether to show or hide the menu.
 * @return boolean
 */
function cedars_acf_settings_hide_admin( $show_admin ) {
	if ( WP_DEBUG ) {
		return $show_admin;
	}

	return false;
}

add_filter( 'acf/settings/show_admin', 'cedars_acf_settings_hide_admin' );

