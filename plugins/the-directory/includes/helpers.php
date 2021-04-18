<?php
/**
 * Directory helper functions
 *
 * @package The_Cedars
 */

/**
 * Returns an array of all the Directory people
 *
 * @param boolean $associative Whether to return an associated array (true) or object (false).
 * @return array
 */
function dirhoa_get_directory( $associative = false ) {
	$directory = wp_cache_get( 'dirhoa_get_directory' );

	if ( false === $directory ) {
		$items = get_posts(
			array(
				'post_type'   => 'directory',
				'numberposts' => -1,
				'post_status' => 'publish',
				'orderby'     => 'meta_value',
				'meta_query'  => array(
					'relation' => 'OR',
					array(
						'key' => 'last_name',
					),
					array(
						'key'     => 'last_name',
						'compare' => 'NOT EXISTS',
					),
				),
				'order'       => 'asc',
			)
		);

		$directory = array();

		if ( ! empty( $items ) ) {
			foreach ( $items as $item ) {
				$resident = array();

				$email = (array) explode( "\n", get_post_meta( $item->ID, 'email', true ) );
				$phone = (array) explode( "\n", get_post_meta( $item->ID, 'phone', true ) );

				$resident['DirectoryID']          = $item->ID;
				$resident['rStreetNumber']        = get_post_meta( $item->ID, 'street_number', true );
				$resident['rStreetName']          = get_post_meta( $item->ID, 'street_name', true );
				$resident['rCity']                = get_post_meta( $item->ID, 'city', true );
				$resident['rState']               = get_post_meta( $item->ID, 'state', true );
				$resident['rZip']                 = get_post_meta( $item->ID, 'zip', true );
				$resident['rLastName']            = get_post_meta( $item->ID, 'last_name', true );
				$resident['rListingName']         = get_post_meta( $item->ID, 'listing', true );
				$resident['rPhone']               = dirhoa_format_phone( current( $phone ) );
				$resident['rChildren']            = get_post_meta( $item->ID, 'children', true );
				$resident['rEmail1']              = current( $email );
				$resident['rEmail2']              = next( $email );
				$resident['Flag_Print']           = get_post_meta( $item->ID, 'private_listing', true );
				$resident['bName']                = get_post_meta( $item->ID, 'billing_name', true );
				$resident['bAddress']             = get_post_meta( $item->ID, 'billing_address', true );
				$resident['bCity']                = get_post_meta( $item->ID, 'billing_city', true );
				$resident['bState']               = get_post_meta( $item->ID, 'billing_state', true );
				$resident['bZip']                 = get_post_meta( $item->ID, 'billing_zip', true );
				$resident['bPhone']               = dirhoa_format_phone( get_post_meta( $item->ID, 'billing_phone', true ) );
				$resident['bEmail']               = get_post_meta( $item->ID, 'billing_email', true );
				$resident['Notes']                = get_post_meta( $item->ID, 'notes', true );
				$resident['Flag_OptionalBilling'] = get_post_meta( $item->ID, 'optional_billing', true );
				$resident['Flag_HideEmail']       = get_post_meta( $item->ID, 'private_email', true );

				$directory[] = $resident;
			}
		}

		wp_cache_set( 'dirhoa_get_directory', $directory );
	}

	if ( ! $associative ) {
		array_walk(
			$directory,
			function( &$row ) {
				$row = (object) $row;
			}
		);
	}

	return $directory;
}

/**
 * Returns a single directory by post_id.
 *
 * @param integer $post_id WordPress Post ID.
 * @param boolean $associative Whether to return an associated array (true) or object (false).
 * @return object|array|boolean
 */
function dirhoa_get_resident( $post_id, $associative = false ) {
	$directory = dirhoa_get_directory( $associative );

	foreach ( $directory as $resident ) {
		$_pid = $associative ? $resident['DirectoryID'] : $resident->DirectoryID;

		if ( absint( $post_id ) === absint( $_pid ) ) {
			return $resident;
		}
	}

	return false;
}

/**
 * Returns an array of fields used by the directory.
 *
 * @return array
 */
function dirhoa_fields() {
	$directory = dirhoa_get_directory( true );
	$result    = array();
	if ( ! empty( $directory ) ) {
		$last = array_pop( $directory );
		return array_keys( $last );
	}

	return $result;
}

/**
 * Common formatting for the numbers.
 *
 * @param string $number Phone number.
 * @return string
 */
function dirhoa_format_phone( $number ) {
	return preg_replace( '~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $number );
}
