<?php
/**
 * Loads the text domain
 *
 * @package Cedars
 */

function cedars_load_text_domain() {
	/*
	* Make theme available for translation.
	* Translations can be filed in the /languages/ directory.
	*/
	load_theme_textdomain( 'cedars', get_template_directory() . '/languages' );
}

add_action( 'after_setup_theme', 'cedars_load_text_domain' );
