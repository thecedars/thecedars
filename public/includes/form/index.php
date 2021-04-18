<?php
/**
 * Form
 *
 * @package Cedars
 */

// Submission CPT.
require_once __DIR__ . '/submissions-post-type.php';

// Form Completion hooks.
require_once __DIR__ . '/completed.php';

// Form Fields.
require_once __DIR__ . '/fields.php';

// Form Mutations.
require_once __DIR__ . '/mutations.php';

// Form actions that fire from the mutations.
require_once __DIR__ . '/actions.php';

// Recaptcha settings.
require_once __DIR__ . '/settings.php';

// To, Subject, From settings.
require_once __DIR__ . '/customizer.php';
