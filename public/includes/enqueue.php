<?php
/**
 * Removes several unwarranted enqueues.
 *
 * @package Cedars
 */

/**
 * Dequeue block library as we're including it in the public folder for development.
 *
 * @return void
 */
function cedars_remove_block_library() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );

	if ( function_exists( 'is_woocommerce' ) ) {
		wp_dequeue_style( 'wc-block-style' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'wc-add-to-cart' );

		wp_deregister_script( 'js-cookie' );
		wp_dequeue_script( 'js-cookie' );
	}
}

add_action( 'wp_enqueue_scripts', 'cedars_remove_block_library', PHP_INT_MAX );

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
