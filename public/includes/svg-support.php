<?php
/**
 * Adds the ability to upload SVG files to the library.
 *
 * @package Cedars
 */

/**
 * Adds SVG to the supported mime types for the library.
 *
 * @param array $mimes Mime types
 * @return array
 */
function cedars_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter( 'upload_mimes', 'cedars_mime_types' );

/**
 * Filter to add SVG to the allowed uploads.
 *
 * @param array    $data Values for the extension, mime type, and corrected filename.
 * @param string   $file     Full path to the file.
 * @param string   $filename The name of the file (may differ from $file due to $file being in a tmp directory).
 * @param string[] $mimes    Optional. Array of allowed mime types keyed by their file extension regex.
 * @return array
 */
function cedars_check_svg_filetype( $data, $file, $filename, $mimes ) {
	if ( ! version_compare( get_bloginfo( 'version' ), '4.7.1', '>=' ) ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );

	return array(
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename'],
	);

}

add_filter( 'wp_check_filetype_and_ext', 'cedars_check_svg_filetype', 10, 4 );
