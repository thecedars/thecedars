<?php
/**
 * Theme Includes
 *
 * @package Cedars
 */

// Theme Supports.
require_once __DIR__ . '/supports.php';

// Menus in use by theme.
require_once __DIR__ . '/menus.php';

// Admin Bar.
require_once __DIR__ . '/admin-bar.php';

// Login GQL, email template, and URL changes.
require_once __DIR__ . '/auth/index.php';

// Form Mutation (leadforms).
require_once __DIR__ . '/form/index.php';

// Javascript window.__WP object.
require_once __DIR__ . '/javascript.php';

// Enqueue.
require_once __DIR__ . '/enqueue.php';

// Routing.
require_once __DIR__ . '/routing.php';

// Ads.
require_once __DIR__ . '/ads/index.php';

// i18n.
require_once __DIR__ . '/text-domain.php';

// SVG support in the Media Library.
require_once __DIR__ . '/svg-support.php';

// Advanced Custom Fields.
require_once __DIR__ . '/acf/index.php';

// ThemeMod GQL
require_once __DIR__ . '/gql-thememod.php';
