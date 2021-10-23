<?php
/**
 * Enqueue the javascripts and styles.
 *
 * @package Cedars
 */

/**
 * Enqueue scripts and styles.
 */
function cedars_scripts() {
	$assets = require_once get_template_directory() . '/js/build/frontend.asset.php';

	wp_enqueue_style( 'the-cedars-style', get_stylesheet_uri(), array(), $assets['version'] );

	wp_register_script( 'the-cedars-frontend', get_template_directory_uri() . '/js/build/frontend.js', $assets['dependencies'], $assets['version'], true );
	wp_register_style( 'the-cedars-frontend', get_template_directory_uri() . '/js/build/frontend.css', array(), $assets['version'] );

	wp_enqueue_script( 'the-cedars-frontend' );
	wp_enqueue_style( 'the-cedars-frontend' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$data = array(
		'siteUrl'     => get_site_url( null ),
		'siteTitle'   => get_bloginfo( 'title' ),
		'siteLogo'    => null,
		'templateUri' => get_template_directory_uri(),
		'pageWidth'   => cedars_page_width__(),
		'input'       => cedars_input__(),
		'button'      => cedars_button__(),
	);

	if ( get_theme_mod( 'custom_logo' ) ) {
		$data['siteLogo'] = cedars_image_srcs( get_theme_mod( 'custom_logo' ) );
	}

	cedars_add_js_data( 'the-cedars-frontend', $data );
}

add_action( 'wp_enqueue_scripts', 'cedars_scripts' );

/**
 * Registers all blocks with their metadata.
 */
function cedars_register_block_metadata() {
	$asset_file = include get_template_directory() . '/js/build/blocks.asset.php';

	wp_register_script(
		'the-cedars-blocks',
		get_template_directory_uri() . '/js/build/blocks.js',
		$asset_file['dependencies'],
		$asset_file['version'],
		false
	);

	wp_register_style(
		'the-cedars-blocks',
		get_template_directory_uri() . '/js/build/blocks.css',
		array(),
		$asset_file['version']
	);

	/**
	 * Populate this folder array with all the folders in the src folder you want
	 * registered as blocks.
	 */
	$scandir   = get_template_directory() . '/js/blocks';
	$directory = scandir( $scandir );
	$folders   = array();
	foreach ( $directory as $file ) {
		if ( file_exists( $scandir . '/' . $file . '/block.json' ) ) {
			$folders[] = $file;
		}
	}

	foreach ( $folders as $folder ) {
		register_block_type_from_metadata(
			get_template_directory() . '/js/blocks/' . $folder . '/block.json',
			array(
				'editor_script' => 'the-cedars-blocks',
				'editor_style'  => 'the-cedars-blocks',
			)
		);
	}

	$data = array(
		'siteUrl'     => get_site_url( null ),
		'templateUri' => get_template_directory_uri(),
		'pageWidth'   => cedars_page_width__(),
		'input'       => cedars_input__(),
		'button'      => cedars_button__(),
	);

	cedars_add_js_data( 'the-cedars-blocks', $data );
}

add_action( 'admin_init', 'cedars_register_block_metadata' );
