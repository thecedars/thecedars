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
	register_nav_menu( 'header-menu', __( 'Header Menu', 'react-build' ) );
	register_nav_menu( 'footer-menu', __( 'Footer Menu', 'react-build' ) );
}

add_action( 'after_setup_theme', 'cedars_register_menus' );
