<?php
/**
 * Letters.
 *
 * @package The_Cedars
 */

/**
 * Kicks off the letter template.
 *
 * @param array $query_vars WordPress Query Vars.
 * @return array
 */
function dirhoa_letters_request( $query_vars ) {
	if ( ! empty( $_GET['letter'] ) ) {
		wp_cache_set( 'dirhoa_letter', wp_unslash( $_GET['letter'] ) );
	}

	return $query_vars;
}

add_filter( 'request', 'dirhoa_letters_request' );

/**
 * Cedars Letter template include.
 *
 * @param string $include WordPress template include file.
 * @return string
 */
function dirhoa_letters_include( $include ) {
	$dirhoa_letter =  wp_cache_get( 'dirhoa_letter' );
	if ( false !== $dirhoa_letter ) {
		$posts = get_posts( ['name'=>$dirhoa_letter, 'post_type'=>'letter', 'post_status'=>'publish'] );

		if ( ! empty( $posts ) ) {
			wp_cache_set( 'dirhoa_letter_post', $posts[0] );
			return CEDARS_DIRECTORY . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'deliquent-single.php';
		}
	}

	return $include;
}

add_filter( 'template_include', 'dirhoa_letters_include' );
