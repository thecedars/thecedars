<?php
/**
 * Form GraphQL mutation.
 *
 * @package Cedars
 */

/**
 * Function to check the recaptcha.
 *
 * @param string $token Google Recaptcha token to test.
 * @return boolean If successful.
 */
function cedars_check_recaptcha_token( $token ) {
	$body = array(
		'secret'   => get_option( 'google_secret_key' ),
		'response' => $token,
		'remoteip' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1',
	);

	$response = wp_remote_post(
		'https://www.google.com/recaptcha/api/siteverify',
		array(
			'body' => $body,
		)
	);

	$body = wp_remote_retrieve_body( $response );

	$results = ( ! is_wp_error( $response ) ) ? json_decode( $body, true ) : array( 'success' => false );

	if ( true === $results['success'] ) {
		return true;
	}

	return false;
}

/**
 * Register the muations for submitting forms.
 *
 * @param \WPGraphQL\Registry\TypeRegistry $type_registry WPGraphQL Type registry.
 * @return void
 */
function cedars_register_mutations( \WPGraphQL\Registry\TypeRegistry $type_registry ) {
	$forms = apply_filters( 'cedars_fields', array() );

	foreach ( $forms as $mutation_name => $fields ) {
		$default_args = array(
			'gToken'  => array(
				'type'        => 'String',
				'description' => __( 'Recaptcha Token', 'cedars' ),
			),
		);

		$merged_fields = array_merge( $default_args, $fields );

		register_graphql_mutation(
			sprintf( '%sFormMutation', $mutation_name ),
			array(
				'inputFields'         => $merged_fields,
				'outputFields'        => array(
					'success'      => array(
						'type'        => 'Boolean',
						'description' => __( 'Description of the output field', 'cedars' ),
						'resolve'     => function ( $payload, $args, $context, $info ) {
							return isset( $payload['success'] ) ? $payload['success'] : false;
						},
					),
					'errorMessage' => array(
						'type'        => 'String',
						'description' => 'Error message if relevant',
						'resolve'     => function ( $payload, $args, $context, $info ) {
							return isset( $payload['errorMessage'] ) ? $payload['errorMessage'] : '';
						},
					),
				),
				'mutateAndGetPayload' => function ( $input, $context, $info ) use ( $mutation_name ) {
					$success   = true;
					$error     = '';
					$gToken    = isset( $input['gToken'] ) ? sanitize_text_field( wp_unslash( $input['gToken'] ) ) : '';
					$site_key  = get_option( 'google_site_key' ) ? get_option( 'google_site_key' ) : '';

					// Check Google Recaptcha.
					if ( $success && ! empty( $site_key ) && ! cedars_check_recaptcha_token( $gToken ) ) {
						$success = false;
						$error = __( 'Internal Error 200', 'cedars' );
					}

					if ( isset( $input['gToken'] ) ) {
						unset( $input['gToken'] );
					}

					// Process Form filters.
					if ( $success ) {
						unset( $input['clientMutationId'] );

						$input = apply_filters( 'cedars_input_modifications', $input, $mutation_name );

						wp_cache_set( 'cedars_form_input', $input );
						wp_cache_set( 'cedars_form_name', $mutation_name );

						$success = apply_filters( 'cedars_success_' . $mutation_name, $success, $input );

						if ( is_wp_error( $success ) ) {
							$error = $success->get_error_message();
							$success = false;
						}
					}

					return array(
						'success'      => $success,
						'errorMessage' => $error,
					);
				},
			)
		);
	}
}

add_action( 'graphql_register_types', 'cedars_register_mutations' );
