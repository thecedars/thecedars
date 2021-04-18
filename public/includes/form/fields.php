<?php
/**
 * Form Fields
 *
 * @package Cedars
 */

/**
 * Default Form Fields Filter.
 *
 * @param array $fields Forms to filter.
 * @return array
 */
function cedars_fields_default( $fields ) {
	$fields['default'] = array(
		'yourName' => array(
			'type'        => 'String',
			'description' => __( 'Form submitter\'s name', 'cedars' ),
		),
		'email'    => array(
			'type'        => 'String',
			'description' => __( 'Form submitter\'s email', 'cedars' ),
		),
		'phone'    => array(
			'type'        => 'String',
			'description' => __( 'Form submitter\'s phone', 'cedars' ),
		),
		'message'  => array(
			'type'        => 'String',
			'description' => __( 'Form submitter\'s message', 'cedars' ),
		),
	);

	return $fields;
}

add_filter( 'cedars_fields', 'cedars_fields_default' );

add_filter( 'cedars_success_default', 'cedars_success_default', 10, 2 );
