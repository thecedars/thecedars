<?php
/**
 * Removes several unwarranted enqueues.
 *
 * @package Cedars
 */

/**
 * Enqueue the block library.
 *
 * @return void
 */
function cedars_block_library() {
	wp_enqueue_style( 'wp-block-library' );
	wp_enqueue_style( 'wp-block-library-theme' );
}

add_action( 'wp_enqueue_scripts', 'cedars_block_library' );

/**
 * Removes the wp-embed script.
 *
 * @return void
 */
function cedars_deregister_scripts() {
	wp_dequeue_script( 'wp-embed' );
}

add_action( 'wp_footer', 'cedars_deregister_scripts' );

// Remove Emoji styles and scripts.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Prevents unwarranted redirects.
remove_action( 'template_redirect', 'redirect_canonical' );
remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
