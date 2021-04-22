<?php
/**
 * Logout
 *
 * GraphQL resolve to logout.
 *
 * @link https://github.com/funkhaus/wp-graphql-cors
 *
 * @package Cedars
 */

/**
 * Used to logout.
 *
 * @return void
 */
function cedars_logout_resolve() {
	register_graphql_mutation(
		'logout',
		array(
			'inputFields'         => array(),
			'outputFields'        => array(
				'status' => array(
					'type'        => 'String',
					'description' => 'Logout operation status',
					'resolve'     => function( $payload ) {
						return $payload['status'];
					},
				),
			),
			'mutateAndGetPayload' => function() {
				// Logout and destroy session.
				wp_logout();

				return array( 'status' => 'SUCCESS' );
			},
		)
	);
}

add_action( 'graphql_register_types', 'cedars_logout_resolve' );
