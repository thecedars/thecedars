<?php
/**
 * Recaptcha
 *
 * @package Cedars/Form
 */

/**
 * Adds Recaptcha settings to the customizer.
 *
 * @param WP_Customize_Manager $wp_customize WP Customizer object.
 * @return void
 */
function cedars_recaptcha_customize_register( $wp_customize ) {
	$section_name  = 'cedars_recaptcha';
	$section_label = __( 'Recaptcha', 'the-cedars' );

	$wp_customize->add_section(
		$section_name,
		array(
			'title'    => $section_label,
			'priority' => 127,
		)
	);

	$wp_customize->add_setting(
		'google_site_key',
		array(
			'transport' => 'postMessage',
			'default'   => get_bloginfo( 'admin_email' ),
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'google_site_key',
		array(
			'id'      => 'google_site_key_control',
			'label'   => __( 'Google Site Key', 'the-cedars' ),
			'section' => $section_name,
		)
	);

	$wp_customize->add_setting(
		'google_secret_key',
		array(
			'transport' => 'postMessage',
			'default'   => get_bloginfo( 'admin_email' ),
			'type'      => 'option',
		)
	);

	$wp_customize->add_control(
		'google_secret_key',
		array(
			'id'      => 'google_secret_key_control',
			'label'   => __( 'Google Secret Key', 'the-cedars' ),
			'section' => $section_name,
		)
	);
}

add_action( 'customize_register', 'cedars_recaptcha_customize_register' );

/**
 * Processes the Google Recaptcha Token.
 *
 * @param WP_Error $error Tracks current errors.
 * @param array    $input Inputs from the mutation submission.
 * @return WP_Error
 */
function cedars_form_recaptcha( $error, $input ) {
	if ( ! $error->has_errors() ) {
		$token    = isset( $input['gToken'] ) ? sanitize_text_field( wp_unslash( $input['gToken'] ) ) : '';
		$site_key = get_option( 'google_site_key' ) ? get_option( 'google_site_key' ) : '';

		// Check Google Recaptcha.
		if ( ! empty( $site_key ) && ! cedars_check_recaptcha_token( $token ) ) {
			$error->add( 'internal_200', __( 'Internal Error 200', 'the-cedars' ) );
		}
	}
	return $error;
}

add_filter( 'cedars_form_preprocess', 'cedars_form_recaptcha', 5, 2 );

/**
 * Adds the recaptcha key to the main js.
 *
 * @param array $data The JS data array.
 * @return array
 */
function cedars_js_add_recaptcha_key( $data ) {
	$data['recaptcha'] = get_option( 'google_site_key' ) ? get_option( 'google_site_key' ) : false;

	return $data;
}

add_filter( 'cedars_js_data', 'cedars_js_add_recaptcha_key' );
