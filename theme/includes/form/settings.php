<?php
/**
 * Admin settings
 *
 * @package Cedars
 */

/**
 * Adds the page to the admin menu.
 *
 * @return void
 */
function cedars_admin_menu_recaptcha() {
	add_options_page(
		apply_filters( 'cedars_recaptcha_label', __( 'Recaptcha', 'cedars' ) ),
		apply_filters( 'cedars_recaptcha_label', __( 'Recaptcha', 'cedars' ) ),
		'manage_options',
		'cedars_recaptcha',
		'cedars_recaptcha_page'
	);
}

add_action( 'admin_menu', 'cedars_admin_menu_recaptcha' );

/**
 * Recaptcha settings output.
 *
 * @return void
 */
function cedars_recaptcha_page() {
	ob_start();
	settings_fields( 'cedars_recaptcha' );
	do_settings_sections( 'cedars_recaptcha' );
	submit_button();
	$settings = ob_get_clean();

	printf(
		'<div class="wrap"><h2>%s</h2><form action="options.php" method="post">%s</form></div>',
		esc_html( get_admin_page_title() ),
		$settings // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Recaptcha settings fields.
 *
 * @return void
 */
function cedars_recaptcha_settings() {
	add_settings_section(
		'keys',
		__( 'Google Recaptcha', 'cedars' ),
		'__return_false',
		'cedars_recaptcha'
	);

	add_settings_field(
		'google_site_key',
		__( 'Site Key', 'cedars' ),
		function() {
			cedars_admin_settings_input( 'google_site_key' ); },
		'cedars_recaptcha',
		'keys',
		array( 'label_for' => 'google_site_key' )
	);

	add_settings_field(
		'google_secret_key',
		__( 'Secret Key', 'cedars' ),
		function() {
			cedars_admin_settings_input( 'google_secret_key' ); },
		'cedars_recaptcha',
		'keys',
		array( 'label_for' => 'google_secret_key' )
	);
}

add_action( 'admin_init', 'cedars_recaptcha_settings' );

/**
 * Settings form field output.
 *
 * @param string $field Field id being displayed.
 * @return void
 */
function cedars_admin_settings_input( $field ) {
	$value = get_option( $field );
	printf(
		'<input class="large-text" type="text" name="%s" id="%s" value="%s"> ',
		esc_attr( $field ),
		esc_attr( $field ),
		esc_attr( $value )
	);
}

/**
 * Registers settings
 *
 * @return void
 */
function cedars_recaptcha_register() {
	register_setting(
		'cedars_recaptcha',
		'google_site_key',
		'sanitize_text_field'
	);

	register_setting(
		'cedars_recaptcha',
		'google_secret_key',
		'sanitize_text_field'
	);
}

add_action( 'admin_init', 'cedars_recaptcha_register' );
