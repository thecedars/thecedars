<?php
/**
 * ACF GraphQL Resolver
 *
 * @package Cedars
 */

/**
 * Registers the type.
 *
 * @return void
 */
function cedars_add_about_gql() {
	register_graphql_scalar(
		'Raw',
		array(
			'description'  => __( 'Arbitrary raw value', 'cedars' ),
			'serialize'    => function( $value ) {
				return $value;
			},
			'parseValue'   => function( $value ) {
				return $value;
			},
			'parseLiteral' => function( $value_node, $variables = null ) {
				return $value;
			},
		)
	);

	register_graphql_field(
		'RootQuery',
		'AdvancedCustomFields',
		array(
			'type'        => 'Raw',
			'description' => 'ACF fields for given URI',
			'args'        => array(
				'uri' => array(
					'type'        => 'String',
					'description' => 'Resource URI to get the data',
				),
			),
			'resolve'     => function( $root, $args ) {
				$uri = ! empty( $args['uri'] ) ? $args['uri'] : null;
				if ( null === $uri ) {
					return null;
				}

				if ( '/' === $uri ) {
					$post_id = get_option( 'page_on_front' );
				} else {
					$post_id = url_to_postid( $uri );
				}

				if ( empty( $post_id ) || is_wp_error( $post_id ) ) {
					return null;
				}

				return get_fields( $post_id );
			},
		)
	);
}

add_action( 'graphql_register_types', 'cedars_add_about_gql' );
