<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Cedars
 */

/**
 * Page width classes.
 *
 * @return string
 */
function cedars_page_width__() {
	return apply_filters( 'cedars_page_width', 'w-100 mw8 ph3 center' );
}

/**
 * Button classes.
 *
 * @return string
 */
function cedars_button__() {
	$classes = 'dib bg-animate pointer no-underline br2 pv2 ph4 white bg-primary bn hover-bg-secondary';

	return apply_filters( 'cedars_button', $classes );
}

/**
 * Input classes.
 *
 * @return string
 */
function cedars_input__() {
	$classes = 'db w-100 f5 ba pa2 border-box bg-transparent b--moon-gray';

	return apply_filters( 'cedars_input', $classes );
}

/**
 * Adds overflow-x-hidden to the body tag.
 *
 * @param string[] $classes Class name array.
 * @return string[]
 */
function cedars_add_overflow_x_bodyclass( $classes ) {
	$classes[] = 'overflow-x-hidden';

	return $classes;
}

add_filter( 'body_class', 'cedars_add_overflow_x_bodyclass' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function cedars_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'cedars_pingback_header' );

/**
 * Array_map loop.
 *
 * @param array $functions Array of functions.
 * @param array $subject Array to map.
 * @return array
 */
function cedars_array_map_loop( $functions, $subject ) {
	$functions = array_reverse( $functions );

	foreach ( $functions as $fn ) {
		$subject = array_map( $fn, $subject );
	}

	return $subject;
}

/**
 * Returns an array of all the image urls in the sizes specified.
 *
 * @param integer  $id WP_Post ID for the attachment.
 * @param string[] $sizes List of WordPress image sizes.
 * @return array Array of image urls.
 */
function cedars_image_srcs( $id, $sizes = array( 'full', 'medium', 'thumbnail' ) ) {
	$attachment = get_post( $id );
	if ( empty( $attachment ) ) {
		return false;
	}

	$images = array();
	foreach ( $sizes as $_size ) {
		$images[ $_size ] = wp_get_attachment_image_src( $id, $_size )[0];
	}

	return $images;
}

/**
 * Returns one src in the size specified.
 *
 * @param integer $id WP_Post ID for the attachment.
 * @param string  $size List of WordPress image sizes.
 * @return string Image src.
 */
function cedars_image_src( $id, $size = 'large' ) {
	$images = cedars_image_srcs( $id, array( $size ) );

	if ( ! empty( $images[ $size ] ) ) {
		return $images[ $size ];
	}

	return '';
}

/**
 * Replace the regular img markup without the height and width attributes.
 *
 * @param string       $html HTML markup.
 * @param integer      $attachment_id WP_Post ID for attachment.
 * @param string       $size WP image size enum.
 * @param boolean      $icon Whether the image should be treated as an icon.
 * @param string|array $attr Attributes for the image markup.
 * @return string HTML markup.
 */
function cedars_picture_markup( $html, $attachment_id, $size, $icon, $attr ) {
	$defaults    = array();
	$attr        = wp_parse_args( $attr, $defaults );
	$attr['src'] = cedars_image_src( $attachment_id, $size );

	$attr = array_map( 'esc_attr', $attr );
	$html = '<img';

	foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
	}

	$html .= ' />';

	return $html;
}

add_filter( 'wp_get_attachment_image', 'cedars_picture_markup', 10, 5 );

/**
 * Array key to camalcase.
 *
 * @param array|object $subject Subject to loop over the keys and apply camelcase.
 * @return mixed Same as $subject with new keys.
 */
function cedars_keys_to_camel( $subject ) {
	$updated = array();

	foreach ( (array) $subject as $key => $value ) {
		$updated[ cedars_camelcase( $key ) ] = $value;
	}

	if ( isset( $updated['iD'] ) ) {
		$updated['id'] = $updated['iD'];
	}

	if ( is_object( $subject ) ) {
		return (object) $updated;
	}

	return $updated;
}

/**
 * String to camelCase.
 *
 * @param string $string String to make camelcase.
 * @return string
 */
function cedars_camelcase( $string ) {
	$replace_field_name = preg_replace( '/[^A-Za-z0-9]/i', ' ', $string );
	if ( ! empty( $replace_field_name ) ) {
		$string = $replace_field_name;
	}
	$replace_field_name = preg_replace( '/[^A-Za-z0-9]/i', '', ucwords( $string ) );
	if ( ! empty( $replace_field_name ) ) {
		$string = $replace_field_name;
	}
	$string = lcfirst( $string );

	return $string;
}

/**
 * Updates the global JS window variable with additional data.
 *
 * @param string $handle Enqueued handle to use.
 * @param array  $data PHP array to be encoded into json.
 */
function cedars_add_js_data( $handle, $data ) {
	if ( null === $handle ) {
		$handle = 'the-cedars-frontend';
	}

	wp_add_inline_script(
		$handle,
		sprintf(
			'window.cedars = window.cedars||{};window.cedars = Object.assign(window.cedars, %s);',
			wp_json_encode( $data )
		),
		'before'
	);
}

/**
 * Remove Prefix on archive titles.
 *
 * @param string $title          Archive title to be displayed.
 * @param string $original_title Archive title without prefix.
 */
function cedars_remove_prefix_on_archive_titles( $title, $original_title ) {
	return $original_title;
}

add_filter( 'get_the_archive_title', 'cedars_remove_prefix_on_archive_titles', 10, 2 );
