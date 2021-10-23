<?php
/**
 * Theme includes
 *
 * @package Cedars
 */

// Setup.
require_once __DIR__ . '/setup.php';

// Menus in use by theme.
require_once __DIR__ . '/menus.php';

// Navigation.
require_once __DIR__ . '/navigation.php';

// Enqueue the scripts/styles.
require_once __DIR__ . '/enqueue.php';

// Customizer.
require_once __DIR__ . '/customizer.php';

// Template Functions.
require_once __DIR__ . '/template-functions.php';

// Template Tags.
require_once __DIR__ . '/template-tags.php';

// SVG support in the Media Library.
require_once __DIR__ . '/svg-support.php';

// Login logo.
require_once __DIR__ . '/login.php';

// Admin-bar edits.
require_once __DIR__ . '/admin-bar.php';

// Form.
require_once __DIR__ . '/form/index.php';

// Shortcodes.
require_once __DIR__ . '/shortcodes/index.php';
