<?php
/**
 * Theme supports
 *
 * @package Cedars
 */

/**
 * Adds the theme_supports for the theme.
 *
 * @return void
 */
function cedars_add_theme_supports() {
	$defaults = array(
		'width'       => 512,
		'height'      => 512,
		'flex-height' => true,
		'flex-width'  => true,
	);

	add_theme_support( 'custom-logo', $defaults );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
}

add_action( 'after_setup_theme', 'cedars_add_theme_supports' );
