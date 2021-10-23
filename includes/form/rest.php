<?php
/**
 * Form REST
 *
 * @package Cedars/Form
 */

/**
 * Add REST Route
 */
function cedars_form_rest_route() {
	register_rest_route(
		'the-cedars/v1',
		'/form/(?P<form_name>[a-zA-Z0-9-\._]+)/validate/(?P<field>[a-zA-Z0-9-\._]+)/',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'cedars_form_validation_cb',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'the-cedars/v1',
		'/form',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'cedars_form_rest_cb',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'the-cedars/v1',
		'/form/(?P<form_name>[a-zA-Z0-9-\._]+)',
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'cedars_form_rest_cb',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'the-cedars/v1',
		'/form-schema',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'cedars_form_schema_rest_cb',
			'permission_callback' => '__return_true',
		)
	);

	register_rest_route(
		'the-cedars/v1',
		'/form-schema/(?P<form_name>[a-zA-Z0-9-\._]+)',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'cedars_form_schema_rest_cb',
			'permission_callback' => '__return_true',
		)
	);
}

add_action( 'rest_api_init', 'cedars_form_rest_route' );

/**
 * REST Callback.
 *
 * @param WP_REST_Request $request This function accepts a rest request to process data.
 * @return WP_REST_Response
 */
function cedars_form_rest_cb( $request ) {
	$form_name = ! empty( $request['form_name'] ) ? $request['form_name'] : 'default';

	$json = file_get_contents( 'php://input' );

	if ( empty( $json ) ) {
		return new WP_Error( 'no_data', __( 'No data submitted', 'the-cedars' ) );
	}

	$input = json_decode( $json, true );

	wp_cache_set( 'cedars_form_input', $input );

	$error = new WP_Error();

	/**
	 * Preprocesses form with all the inputs.
	 *
	 * @param WP_Error $error Tracks current errors.
	 * @param array $input Inputs from the mutation submission.
	 * @param string Name of form.
	 */
	$error = apply_filters( 'cedars_form_preprocess', $error, $input, $form_name );

	// Remove input fields not used in data.
	if ( isset( $input['gToken'] ) ) {
		unset( $input['gToken'] );
	}

	// Process Form.
	if ( ! $error->has_errors() ) {
		$error = apply_filters( 'cedars_form_process', $error, $input, $form_name );
	}

	if ( ! $error->has_errors() ) {
		return rest_ensure_response( true );
	}

	return rest_ensure_response( $error );
}

/**
 * REST Callback for field validation.
 *
 * @param WP_REST_Request $request This function accepts a rest request to process data.
 * @return WP_REST_Response
 */
function cedars_form_validation_cb( $request ) {
	$form_name = ! empty( $request['form_name'] ) ? $request['form_name'] : 'default';
	$field     = ! empty( $request['field'] ) ? $request['field'] : '';

	$value = file_get_contents( 'php://input' );

	return rest_ensure_response( cedars_form_validate_one( $form_name, $field, $value ) );
}

/**
 * Sends the alert for emails
 *
 * @param WP_Error $error Tracks current errors.
 * @param array    $input Inputs from the mutation submission.
 * @param string   $name Form name.
 * @return WP_Error
 */
function cedars_form_alert( $error, $input, $name ) {
	if ( ! $error->has_errors() ) {
		$to      = get_theme_mod( 'theme_form_' . $name . '_to', get_bloginfo( 'admin_email' ) );
		$to      = apply_filters( 'cedars_sanitize_email_list', $to, $name );
		$host    = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : 'shaemarcus.com';
		$from    = get_theme_mod( 'theme_form_' . $name . '_from', 'wordpress@' . str_replace( 'www.', '', $host ) );
		$subject = get_theme_mod( 'theme_form_' . $name . '_subject', __( 'WordPress Form Submission', 'the-cedars' ) );
		$replyto = ! empty( $input['email'] ) ? $input['email'] : $from;

		$result = wp_mail(
			$to,
			$subject,
			nl2br( cedars_input_to_text( $input ) ),
			array(
				"From: $from",
				"Sender: $from",
				'Content-type: text/html',
				"Reply-to: $replyto",
				'Bcc: shae@shaemarcus.com',
			)
		);

		if ( is_wp_error( $result ) ) {
			$error->merge_from( $result );
		}
	}

	return $error;
}

add_filter( 'cedars_form_process', 'cedars_form_alert', 11, 3 );

/**
 * Form Schema.
 *
 * @param WP_REST_Request $request This function accepts a rest request to process data.
 * @return WP_REST_Response
 */
function cedars_form_schema_rest_cb( $request ) {
	$form_name = ! empty( $request['form_name'] ) ? $request['form_name'] : 'default';

	$schema     = cedars_form_get_schema( $form_name );
	$properties = $schema->properties;

	$error_messages = array();

	foreach ( $properties as $key => $property ) {
		$error_messages[ $key ] = apply_filters(
			'cedars_form_field_error_message',
			false,
			'/' . $key,
			$property
		);
	}

	return rest_ensure_response(
		array(
			'schema'        => $schema,
			'errorMessages' => $error_messages,
		)
	);
}
