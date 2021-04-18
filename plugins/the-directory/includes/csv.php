<?php
/**
 * CSV
 *
 * @package Directory
 */

/**
 * Converts array to CSV
 *
 * @return void
 */
function dirhoa_convert_to_csv( $input_array, $output_file_name, $delimiter ) {
	$temp_memory = fopen( 'php://memory', 'w' );

	$header = array_keys( (array) $input_array[0] );
	fputcsv( $temp_memory, $header, $delimiter );

	foreach ( $input_array as $line ) {
		fputcsv( $temp_memory, array_values( (array) $line ), $delimiter );
	}

	fseek( $temp_memory, 0 );
	header( 'Content-Type: application/csv; charset=utf-8' );
	header( 'Content-Disposition: attachement; filename="' . $output_file_name . '";' );
	fpassthru( $temp_memory );
	die;
}

/**
 * Constucts the array for CSV looking at GET.
 *
 * @return void
 */
function dirhoa_csv_output() {
	if ( isset( $_GET['page'] ) && ( 'csv_list' === $_GET['page'] || 'csv_billing' === $_GET['page'] ) ) {
		$items = get_posts(
			array(
				'post_type'      => 'directory',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'meta_value',
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key' => 'last_name',
					),
					array(
						'key'     => 'last_name',
						'compare' => 'NOT EXISTS',
					),
				),
				'order'          => 'asc',
			)
		);

		$name = 'Export-' . @date( 'Y-m-d_H-i-s' ) . '.csv';

		$people = array();

		foreach ( $items as $item ) {
			$person = array();

			$email = (array) explode( "\n", get_post_meta( $item->ID, 'email', true ) );
			$phone = (array) explode( "\n", get_post_meta( $item->ID, 'phone', true ) );

			$person['DirectoryID']          = $item->ID;
			$person['rStreetNumber']        = get_post_meta( $item->ID, 'street_number', true );
			$person['rStreetName']          = get_post_meta( $item->ID, 'street_name', true );
			$person['rCity']                = get_post_meta( $item->ID, 'city', true );
			$person['rState']               = get_post_meta( $item->ID, 'state', true );
			$person['rZip']                 = get_post_meta( $item->ID, 'zip', true );
			$person['rLastName']            = get_post_meta( $item->ID, 'last_name', true );
			$person['rListingName']         = get_post_meta( $item->ID, 'listing', true );
			$person['rPhone']               = dirhoa_format_phone( current( $phone ) );
			$person['rChildren']            = get_post_meta( $item->ID, 'children', true );
			$person['rEmail1']              = current( $email );
			$person['rEmail2']              = next( $email );
			$person['Flag_Print']           = get_post_meta( $item->ID, 'private_listing', true );
			$person['bName']                = get_post_meta( $item->ID, 'billing_name', true );
			$person['bAddress']             = get_post_meta( $item->ID, 'billing_address', true );
			$person['bCity']                = get_post_meta( $item->ID, 'billing_city', true );
			$person['bState']               = get_post_meta( $item->ID, 'billing_state', true );
			$person['bZip']                 = get_post_meta( $item->ID, 'billing_zip', true );
			$person['bPhone']               = dirhoa_format_phone( get_post_meta( $item->ID, 'billing_phone', true ) );
			$person['bEmail']               = get_post_meta( $item->ID, 'billing_email', true );
			$person['Notes']                = get_post_meta( $item->ID, 'notes', true );
			$person['Flag_OptionalBilling'] = get_post_meta( $item->ID, 'optional_billing', true );
			$person['Flag_HideEmail']       = get_post_meta( $item->ID, 'private_email', true );

			if ( 'csv_billing' === $_GET['page'] ) {
				$billingAddress = trim( $person['bAddress'] );

				if ( empty( $billingAddress ) ) {
					$person['bAddress'] = sprintf( '%s %s', $person['rStreetNumber'], $person['rStreetName'] );
					$person['bCity']    = $person['rCity'];
					$person['bState']   = $person['rState'];
					$person['bZip']     = $person['rZip'];
					$person['bName']    = $person['rListingName'];
				}

				unset( $person['DirectoryID'] );
				unset( $person['rLastName'] );
				unset( $person['Flag_Print'] );
				unset( $person['bPhone'] );
				unset( $person['bEmail'] );
				unset( $person['Notes'] );
				unset( $person['Flag_OptionalBilling'] );
			}

			$people[] = $person;
		}

		if ( 'csv_billing' === $_GET['page'] ) {
			$name = 'Export-Billing-' . @date( 'Y-m-d_H-i-s' ) . '.csv';
		}

		dirhoa_convert_to_csv( $people, $name, ',' );
	}
}

add_action('admin_init','dirhoa_csv_output');
