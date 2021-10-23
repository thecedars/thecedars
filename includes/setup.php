<?php
/**
 * Setup the theme supports.
 *
 * @package Cedars
 */

/**
 * Theme supports.
 */
function cedars_setup() {
	/**
	 * Editor Styles. Allows us to add styles to the block editor.
	 */
	add_theme_support( 'editor-styles' );

	$defaults = array(
		'width'       => 512,
		'height'      => 512,
		'flex-height' => true,
		'flex-width'  => true,
	);

	add_theme_support( 'custom-logo', $defaults );

	load_theme_textdomain( 'the-cedars', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );
}

add_action( 'after_setup_theme', 'cedars_setup' );
