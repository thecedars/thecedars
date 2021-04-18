<?php
/**
 * Form Completion Hooks
 *
 * @package Cedars
 */

/**
 * Default form save to the database and email.
 *
 * @param boolean $success Current form status.
 * @param array   $input The input fields.
 * @return boolean
 */
function cedars_success_default( $success, $input ) {
	// Insert into the database.
	if ( $success ) {
		$success = cedars_insert_form_into_database( $input, 'default' );
	}

	// Alert.
	if ( $success ) {
		$success = cedars_mail_notify( $input, 'default' );
	}

	return $success;
}

/**
 * Notifies the powers that be.
 *
 * @param array  $input Associative array of form fields and values.
 * @param string $form Form Name.
 * @return bool WP_Mail status.
 */
function cedars_mail_notify( $input, $form ) {
	$to      = cedars_get_form_to( $form );
	$from    = cedars_get_form_from( $form );
	$subject = cedars_get_form_subject( $form );
	$replyto = ! empty( $input['email'] ) ? $email : $from;

	return wp_mail(
		$to,
		$subject,
		nl2br( cedars_input_to_text( $input ) ),
		array(
			"From: $from",
			"Sender: $from",
			'Content-type: text/html',
			"Reply-to: $replyto",
		)
	);
}

/**
 * Inserts inputs into the form submissions post type.
 *
 * @param array  $input Associative array of form fields and values.
 * @param string $form Form Name.
 * @return bool
 */
function cedars_insert_form_into_database( $input, $form = 'Form Submission' ) {
	$subject = cedars_get_form_subject( $form );
	$content = cedars_input_to_text( $input );

	$p = array(
		'post_type'    => 'form_submission',
		'post_status'  => 'publish',
		'post_content' => $content,
		'post_title'   => $subject,
		'post_name'    => wp_create_nonce( $content ),
	);

	$id = wp_insert_post( $p );

	if ( $id && ! is_wp_error( $id ) ) {
		foreach ( $input as $key => $value ) {
			update_post_meta( $id, $key, $value );
		}

		$form_name = wp_cache_get( 'cedars_form_name' );
		if ( false !== $form_name ) {
			update_post_meta( $id, 'form_name', $form_name );
		}

		do_action( 'cedars_after_db_insert', $id );

		return true;
	}

	return false;
}
