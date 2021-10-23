<?php
/**
 * Form success filters.
 *
 * @package Cedars/Form
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
 * Converts the key value input pairs to something that can be read in a mail message.
 *
 * @param array $input Fields submitted in the form.
 * @return string
 */
function cedars_input_to_text( $input ) {
	$walked = $input;
	array_walk(
		$walked,
		function( &$value, $key ) use ( $input ) {
			$value = apply_filters( 'cedars_input_to_text', sprintf( "%s: %s\n", ucwords( $key ), $value ), $value, $key, $input );
		}
	);

	return implode( "\n", $walked );
}

/**
 * Sanitizes a comma delimited list of emails.
 *
 * @param array $to The passed list of emails.
 * @return array Sanitized email array.
 */
function cedars_sanitize_email_list( $to ) {
	$to = array_map( 'trim', explode( ',', str_replace( array( "\n", "\r\n", ';', ':', ' ' ), ',', $to ) ) );
	$ro = array_merge( $to, array( get_bloginfo( 'admin_email' ) ) );
	$to = array_unique( $to );
	$to = array_values( $to );

	return $to;
}

add_filter( 'cedars_sanitize_email_list', 'cedars_sanitize_email_list' );

/**
 * Get the schema.
 *
 * @param string $form Optional. The name of the form.
 */
function cedars_form_get_schema( $form = 'default' ) {
	$errors = new WP_Error();
	$form   = str_replace( '_', '-', $form );
	$data   = '';

	try {
		ob_start();
		require __DIR__ . "/form-${form}.json";
		$data = ob_get_clean();
	} catch ( Exception $e ) {
		$errors->add( $e->getCode(), $e->getMessage() );
	}

	if ( $errors->has_errors() ) {
		return $errors;
	}

	$data = str_replace( 'http://localhost', get_template_directory_uri(), $data );

	return json_decode( $data );
}

/**
 * Get example data.
 *
 * @param object|string $schema Loaded JSON schema.
 * @return array
 */
function cedars_form_example_data( $schema ) {
	if ( is_string( $schema ) ) {
		$schema = cedars_form_get_schema( $schema );
	}

	return (array) $schema->examples[0];
}


/**
 * Validate schema.
 *
 * @param object|string $schema Loaded JSON schema.
 * @param array         $data Data to check against.
 * @return boolea|WP_Error
 */
function cedars_form_validate( $schema, $data ) {
	if ( is_string( $schema ) ) {
		$schema = cedars_form_get_schema( $schema );
	}

	$errors    = new WP_Error();
	$validator = new Opis\JsonSchema\Validator();

	$validator->setMaxErrors( 99 );

	$result = $validator->validate( (object) $data, $schema );

	if ( $result->isValid() ) {
		return true;
	}

	$validation_error = $result->error();
	$error_formatter  = cedars_get_error_formatter();
	$all_errors       = $error_formatter->format( $validation_error, false, 'cedars_form_custom_validation_formatter' );

	foreach ( $all_errors as $key => $__error ) {
		$errors->add( $key, sprintf( '%s: %s', $__error['title'], $__error['error'] ) );
	}

	return $errors;
}

/**
 * Returns the error formatter.
 *
 * @return Opis\JsonSchema\Errors\ErrorFormatter
 */
function cedars_get_error_formatter() {
	$f = wp_cache_get( 'error_formatter', 'the-cedars' );

	if ( ! $f ) {
		$f = new Opis\JsonSchema\Errors\ErrorFormatter();
		wp_cache_set( 'error_formatter', $f, 'the-cedars' );
	}

	return $f;
}

/**
 * Custom error formater.
 *
 * @param ValidationError $error JSON schema error.
 * @return array
 */
function cedars_form_custom_validation_formatter( $error ) {
	$schema          = $error->schema()->info();
	$formatter       = cedars_get_error_formatter();
	$formatted_error = $formatter->format( $error, false );

	foreach ( array_keys( $formatted_error ) as $error_key ) {
		$formatted_error[ $error_key ] = apply_filters(
			'cedars_form_field_error_message',
			$formatted_error[ $error_key ],
			$error_key,
			$schema->data()
		);
	}

	return array(
		'title' => $schema->data()->title,
		'error' => implode( ', ', array_values( $formatted_error ) ),
	);
}

/**
 * Validate one field.
 * Using the examples in the schema, validate a single field.
 *
 * @param object|string $schema Loaded JSON schema.
 * @param string        $field Field to check.
 * @param string        $value Value of field.
 * @return boolea|WP_Error
 */
function cedars_form_validate_one( $schema, $field, $value ) {
	$data           = cedars_form_example_data( $schema );
	$data[ $field ] = $value;

	return cedars_form_validate( $schema, $data );
}

/**
 * Form validation.
 *
 * @param WP_Error $error Tracks current errors.
 * @param array    $input Inputs from the mutation submission.
 * @param string   $form_name Form name being submitted.
 * @return WP_Error
 */
function cedars_form_field_validation( $error, $input, $form_name ) {
	if ( ! $error->has_errors() ) {
		$check = cedars_form_validate( $form_name, $input );

		if ( is_wp_error( $check ) ) {
			return $check;
		}
	}

	return $error;
}

add_filter( 'cedars_form_preprocess', 'cedars_form_field_validation', 10, 3 );

/**
 * Custom error messages.
 *
 * @param string   $message The message being filtered.
 * @param string   $key Property key being assessed.
 * @param stdClass $data Schema data.
 * @return string
 */
function cedars_form_field_error_message( $message, $key, $data ) {
	switch ( $key ) {
		case '/yourName':
		case '/firstName':
		case '/lastName':
		case '/zipcode':
		case '/message':
			// translators: %s Field label.
			return sprintf( __( '%s is required.', 'the-cedars' ), $data->title );
		case '/email':
			return __( 'Email must be an email.', 'the-cedars' );
		case '/phone':
			return __( 'Phone number must be a phone number, e.g. 123-456-7890.', 'the-cedars' );
		default:
			return $message;
	}
}

add_filter( 'cedars_form_field_error_message', 'cedars_form_field_error_message', 10, 3 );
