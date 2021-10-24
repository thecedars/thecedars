<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cedars
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="root" class="min-vh-100 flex items-stretch flex-column w-100 sans-serif near-black relative z-1">
	<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'the-cedars' ); ?></a>

	<header id="header">
		<nav id="site-menu"></nav>

		<?php cedars_add_js_data( null, array( 'headerMenu' => cedars_navigation( 'header-menu' ) ) ); ?>
	</header><!-- #header -->

	<div class="main lh-copy relative z-1 flex-auto flex items-center justify-center"><!-- .main -->
		<div id="main-content"></div>

		<div id="page-content-wrapper" class="w-100 mw7 br3 pa4 mv3 center bg-white shadow-1">
