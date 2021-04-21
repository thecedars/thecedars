<?php
/**
 * Register main menu.
 *
 * @package Cedars
 */

/**
 * Register navigation menu.
 *
 * @return void
 */
function cedars_register_menus() {
	register_nav_menu( 'header-menu', __( 'Header Menu', 'cedars' ) );
}

add_action( 'after_setup_theme', 'cedars_register_menus' );
