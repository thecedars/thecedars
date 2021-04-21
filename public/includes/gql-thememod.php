<?php
/**
 * GraphQL Thememod
 *
 * @package Cedars
 */

/**
 * Registers the field ThemeMod
 *
 * @return void
 * @phpcs:disable WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
 */
function cedars_gql_theme_mod() {
	$_mods  = get_theme_mods();
	$config = array();
	$mods   = array(
		'customLogo'    => '',
		'customLogoSrc' => '',
		'customLogoSvg' => '',
	);

	array_walk(
		$mods,
		function( $a, $b ) use ( &$config ) {
			$name            = graphql_format_field_name( $b );
			$config[ $name ] = array(
				'type'        => cedars_guess_gql_type( $a ),
				'description' => __( 'An option on the theme.', 'cedars' ),
			);
		}
	);

	array_walk(
		$_mods,
		function( $a, $b ) use ( &$mods, &$config ) {
			if ( ! is_array( $a ) ) {
				if ( false !== strpos( $b, 'theme_form' ) ) {
					return;
				}

				$name            = graphql_format_field_name( $b );
				$mods[ $name ]   = $a;
				$config[ $name ] = array(
					'type'        => cedars_guess_gql_type( $a ),
					'description' => __( 'An option on the theme.', 'cedars' ),
				);

				if ( 'customLogo' === $name ) {
					$mods['customLogoSrc']   = ! empty( $mods['customLogo'] ) ? wp_get_attachment_url( $mods['customLogo'] ) : null;
					$config['customLogoSrc'] = array(
						'type'        => 'String',
						'description' => __( 'The custom logo src.', 'cedars' ),
					);

					$mods['customLogoSvg']   = '';
					$config['customLogoSvg'] = array(
						'type'        => 'String',
						'description' => __( 'The custom logo svg contents.', 'cedars' ),
					);

					if ( $mods['customLogoSrc'] && false !== strpos( $mods['customLogoSrc'], '.svg' ) ) {
						$mods['customLogoSvg'] = file_get_contents( get_attached_file( $mods['customLogo'] ) );
					}
				}
			}
		}
	);

	if ( ! empty( $mods ) ) {
		register_graphql_object_type(
			'ThemeMod',
			array(
				'description' => __( 'Gets the theme mods for the active theme.', 'cedars' ),
				'fields'      => $config,
			)
		);

		register_graphql_field(
			'RootQuery',
			'ThemeMods',
			array(
				'type'    => 'ThemeMod',
				'resolve' => function( $root, $args, $context, $info ) use ( $mods ) {
					return $mods;
				},
			)
		);
	}
}
// @phpcs:enable

add_action( 'graphql_register_types', 'cedars_gql_theme_mod' );

/**
 * Guesses the GQL type from the value passed.
 *
 * @param mixed $value A variable to test.
 * @return string Type string.
 */
function cedars_guess_gql_type( $value ) {
	$type = 'String';

	switch ( true ) {
		case is_int( $value ):
			$type = 'Integer';
			break;
		case is_bool( $value ):
			$type = 'Boolean';
			break;
		default:
			$type = 'String';
	}

	return $type;
}
