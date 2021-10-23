<?php
/**
 * Form customizer actions.
 *
 * @package Cedars/Form
 */

/**
 * Adds forms settings to the customizer.
 *
 * @param WP_Customize_Manager $wp_customize WP Customizer object.
 * @return void
 */
function cedars_default_form_customize_register( $wp_customize ) {
		$host         = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : 'shaemarcus.com';
		$default_from = 'wordpress@' . str_replace( 'www.', '', $host );

		$name = 'default';

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
				'label'   => __( 'To', 'the-cedars' ),
				'section' => $section_name,
				'type'    => 'textarea',
			)
		);

		$wp_customize->add_setting( $setting_prefix . 'subject', array( 'default' => 'WordPress Form Submission' ) );
		$wp_customize->add_control(
			$setting_prefix . 'subject',
			array(
				'id'      => $setting_prefix . 'subject_control',
				'label'   => __( 'Subject', 'the-cedars' ),
				'section' => $section_name,
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting( $setting_prefix . 'from', array( 'default' => $default_from ) );
		$wp_customize->add_control(
			$setting_prefix . 'from',
			array(
				'id'      => $setting_prefix . 'from_control',
				'label'   => __( 'From', 'the-cedars' ),
				'section' => $section_name,
				'type'    => 'text',
			)
		);
}

add_action( 'customize_register', 'cedars_default_form_customize_register' );
