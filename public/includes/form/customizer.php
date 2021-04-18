<?php
/**
 * Form customizer actions.
 *
 * @package Cedars
 */

/**
 * Adds forms settings to the customizer.
 *
 * @param WP_Customize_Manager $wp_customize WP Customizer object.
 * @return void
 */
function cedars_form_customize_register( $wp_customize ) {
	$forms = apply_filters( 'cedars_fields', array() );

	if ( ! empty( $forms ) ) {
		$host         = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : 'shaemarcus.com';
		$default_from = 'wordpress@' . str_replace( 'www.', '', $host );

		foreach ( $forms as $name => $fields ) {
			$sanitized_name = sanitize_title( $name );
			$labeled_name   = implode( ' ', array_map( 'ucwords', explode( '-', $name ) ) );

			$section_name   = sprintf( '%s-%s', 'theme-form', $sanitized_name );
			$section_label  = sprintf( '%s %s', $labeled_name, 'Form Settings' );
			$setting_prefix = sprintf( '%s_%s_', 'theme_form', str_replace( '-', '_', $sanitized_name ) );

			$wp_customize->add_section(
				$section_name,
				array(
					'title'    => $section_label,
					'priority' => 128,
				)
			);

			$wp_customize->add_setting( $setting_prefix . 'to', array( 'default' => get_bloginfo( 'admin_email' ) ) );
			$wp_customize->add_control(
				$setting_prefix . 'to',
				array(
					'id'      => $setting_prefix . 'to_control',
					'label'   => __( 'To', 'cedars' ),
					'section' => $section_name,
					'type'    => 'textarea',
				)
			);

			$wp_customize->add_setting( $setting_prefix . 'subject', array( 'default' => 'WordPress Form Submission' ) );
			$wp_customize->add_control(
				$setting_prefix . 'subject',
				array(
					'id'      => $setting_prefix . 'subject_control',
					'label'   => __( 'Subject', 'cedars' ),
					'section' => $section_name,
					'type'    => 'text',
				)
			);

			$wp_customize->add_setting( $setting_prefix . 'from', array( 'default' => $default_from ) );
			$wp_customize->add_control(
				$setting_prefix . 'from',
				array(
					'id'      => $setting_prefix . 'from_control',
					'label'   => __( 'From', 'cedars' ),
					'section' => $section_name,
					'type'    => 'text',
				)
			);
		}
	}
}

add_action( 'customize_register', 'cedars_form_customize_register' );

/**
 * Retrieves the theme_mods setting for a form name for the to.
 *
 * @param string $name Form name.
 * @return array
 */
function cedars_get_form_to( $name ) {
	$sanitized_name = str_replace( '-', '_', sanitize_title( $name ) );

	$to = get_theme_mod( sprintf( 'theme_form_%s_to', $sanitized_name ), get_bloginfo( 'admin_email' ) );
	$to = array_map( 'trim', explode( ',', str_replace( array( "\n", "\r\n", ';', ':', ' ' ), ',', $to ) ) );
	$ro = array_merge( $to, array( get_bloginfo( 'admin_email' ) ) );
	$to = array_unique( $to );
	$to = array_values( $to );

	return $to;
}

/**
 * Retrieves the theme_mods setting for a form name for the subject.
 *
 * @param string $name Form name.
 * @return string
 */
function cedars_get_form_subject( $name ) {
	$sanitized_name = str_replace( '-', '_', sanitize_title( $name ) );

	$subject = get_theme_mod( sprintf( 'theme_form_%s_subject', $sanitized_name ), 'WordPress Form Submission' );

	$input = wp_cache_get( 'cedars_form_input' );

	if ( false !== $input ) {
		$forms = apply_filters( 'cedars_fields', array() );

		if ( ! empty( $forms[ $name ] ) ) {
			foreach ( $forms[ $name ] as $key => $config ) {
				if ( ! empty( $input[ $key ] ) && false !== strpos( $subject, "%{$key}%" ) ) {
					$subject = str_replace( "%{$key}%", $input[ $key ], $subject );
				}
			}
		}
	}

	return $subject;
}

/**
 * Retrieves the theme_mods setting for a form name for the from.
 *
 * @param string $name Form name.
 * @return string
 */
function cedars_get_form_from( $name ) {
	$host           = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : 'shaemarcus.com';
	$default_from   = 'wordpress@' . str_replace( 'www.', '', $host );
	$sanitized_name = str_replace( '-', '_', sanitize_title( $name ) );

	$from = get_theme_mod( sprintf( 'theme_form_%s_from', $sanitized_name ), $default_from );

	return $from;
}
