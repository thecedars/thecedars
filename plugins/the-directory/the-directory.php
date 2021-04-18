<?php
/**
 * The Directory (Cedars HOA)
 *
 * @package Directory
 */

/*
Plugin Name: The Directory (The Cedars HOA)
Plugin URI: https://www.the-cedars.org/
Description: Directory management
Author: Jon Shipman
Version: 1.0.0
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define the plugin file to use within the plugin.
define( 'DIRHOA_PLUGIN_FILE', __FILE__ );

// Includes.
require_once __DIR__ . '/includes/index.php';