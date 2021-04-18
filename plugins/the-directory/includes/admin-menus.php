<?php
/**
 * Admin menus
 *
 * @package Directory
 */

/**
 * Adds the menus in the admin.
 *
 * @return void
 */
function dirhoa_admin_menus() {
	add_submenu_page(
		'edit.php?post_type=directory',
		__( 'Email', 'directory' ),
		__( 'Bulk Email', 'directory' ),
		'manage_options',
		'email',
		'dirhoa_email'
	);

	add_submenu_page(
		'edit.php?post_type=directory',
		__( 'List', 'directory' ),
		__( 'List by Name (Print)', 'directory' ),
		'manage_options',
		'print_list',
		'dirhoa_print_list'
	);

	add_submenu_page(
		'edit.php?post_type=directory',
		__( 'List', 'directory' ),
		__( 'List by Street (Print)', 'directory' ),
		'manage_options',
		'print_list_street',
		'dirhoa_print_street'
	);

	add_submenu_page(
		'edit.php?post_type=directory',
		__( 'Export', 'directory' ),
		__( 'Export (CSV)', 'directory' ),
		'manage_options',
		'csv_list',
		'__return_empty_string'
	);

	add_submenu_page(
		'edit.php?post_type=directory',
		__( 'Export', 'directory' ),
		__( 'Billing (CSV)', 'directory' ),
		'manage_options',
		'csv_billing',
		'__return_empty_string'
	);

	add_submenu_page(
		'edit.php?post_type=directory',
		__( 'PDF', 'directory' ),
		__( 'Annual Dues Checklist', 'directory' ),
		'manage_options',
		'dues_checklist',
		'dirhoa_dues_checklist'
	);
}

add_action( 'admin_menu', 'dirhoa_admin_menus' );

/**
 * Admin enqueue styles.
 *
 * @return void
 */
function dirhoa_admin_enqueue() {
	wp_register_style(
		'cedars_hoa_directory',
		sprintf( '%s%s', plugin_dir_url( DIRHOA_PLUGIN_FILE ), '/css/directory.css' ),
		array(),
		filemtime( sprintf( '%s%s', dirname( DIRHOA_PLUGIN_FILE ), '/css/directory.css' ) )
	);

	if ( isset( $_GET['post_type'] ) && 'directory' === $_GET['post_type'] ) {
		wp_enqueue_style( 'cedars_hoa_directory' );
	}
}

add_action( 'admin_enqueue_scripts', 'dirhoa_admin_enqueue' );

/**
 * Gets array of street names.
 *
 * @return array Street names.
 */
function dirhoa_get_streets() {
	global $wpdb;

	$streets = wp_cache_get( 'dirhoa_streets' );

	if ( false === $streets ) {

		$sql = $wpdb->prepare(
			sprintf(
				'SELECT DISTINCT(`a`.`meta_value`) FROM `%s` `a` INNER JOIN `%s` `b` ON `a`.`post_id` = `b`.`ID` WHERE `b`.`post_type` = %%s AND `a`.`meta_key` = %%s ORDER BY `a`.`meta_value` ASC;',
				$wpdb->postmeta,
				$wpdb->posts
			),
			'directory',
			'street_name'
		);

		$streets = $wpdb->get_col( $sql );
		wp_cache_set( 'dirhoa_streets', $streets );
	}

	return $streets;
}

/**
 * Prints last name list.
 *
 * @return void
 */
function dirhoa_print_list() {
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

	echo '<div class="button button-primary button-large" onClick="(() => {window.print();})()">Print</div><div class="page directory-print-list"><table><tbody>';

	foreach ( $items as $item ) {
		if ( get_post_meta( $item->ID, 'private_listing', true ) ) {
			continue;
		}

		$phone = (array) explode( '/n', get_post_meta( $item->ID, 'phone', true ) );
		echo '<tr>';
		printf( '<td class="last">%s</td>', esc_html( get_post_meta( $item->ID, 'last_name', true ) ) );
		printf( '<td class="listing">%s</td>', esc_html( get_post_meta( $item->ID, 'listing', true ) ) );
		printf( '<td class="children">%s</td>', esc_html( get_post_meta( $item->ID, 'children', true ) ) );
		printf(
			'<td class="street">%s %s</td>',
			esc_html( get_post_meta( $item->ID, 'street_number', true ) ),
			esc_html( get_post_meta( $item->ID, 'street_name', true ) )
		);
		printf( '<td class="phone">%s</td>', esc_html( dirhoa_format_phone( current( $phone ) ) ) );
		echo '</tr>';
	}

	echo '</tbody></table></div>';
}

/**
 * Prints list by street.
 *
 * @return void
 */
function dirhoa_print_street() {
	$streets = dirhoa_get_streets();

	echo '<div class="button button-primary button-large" onClick="(() => {window.print();})()">Print</div><div class="page directory-print-street">';

	$str_count = 0;
	foreach ( $streets as $street ) {
		$items = get_posts(
			array(
				'post_type'      => 'directory',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => array(
					'dir_strname' => 'ASC',
					'dir_stnum'   => 'ASC',
				),
				'meta_query'     => array(
					'relation'   => 'AND',
					'dir_stname' => array(
						'key'     => 'street_name',
						'value'   => $street,
						'compare' => '=',
					),
					'dir_stnum'  => array(
						'key'     => 'street_number',
						'compare' => 'EXISTS',
					),
				),
			)
		);

		printf( '<h1>%s</h1>', $street );
		echo '<div class="column">';

		$peoplecount       = count( $items );
		$columncount       = ceil( $peoplecount / 3 );
		$lastcolumncount   = $peoplecount - $columncount * 2;
		$middlecolumnstart = $peoplecount - $columncount - $lastcolumncount + 1;
		$lastcolumnstart   = $peoplecount - $lastcolumncount + 1;
		$count             = 1;

		foreach ( $items as $item ) {
			if ( $count === intval( $middlecolumnstart ) ) {
				echo '</div><div class="column">';
			}

			if ( $count === intval( $lastcolumnstart ) ) {
				echo '</div><div class="column last-column">';
			}

			if ( get_post_meta( $item->ID, 'private_listing', true ) ) {
				continue;
			}

			$phone = (array) explode( "\n", get_post_meta( $item->ID, 'phone', true ) );

			echo '<table><tbody><tr>';
			printf( '<td class="street">%s</td>', esc_html( get_post_meta( $item->ID, 'street_number', true ) ) );
			printf( '<td class="last">%s</td>', esc_html( get_post_meta( $item->ID, 'last_name', true ) ) );
			printf( '<td class="phone">%s</td>', esc_html( dirhoa_format_phone( current( $phone ) ) ) );
			echo '</tr></tbody></table>';

			$count++;
		}

		echo '</div>';

		echo '<div style="clear:both"></div>';

		if ( 2 === $str_count ) {
			echo '<div class="page-break"></div>';
		}

		$str_count++;
	}

	echo '</div>';
}

/**
 * Dues checklist metabox (all houses with a checkbox next to it.
 *
 * @return void
 */
function dirhoa_dues_checklist() {
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

	$rows = '';
	foreach ( $items as $item ) {
		$phone = (array) explode( "\n", get_post_meta( $item->ID, 'phone', true ) );

		$rows .= sprintf(
			'<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>',
			esc_html( get_post_meta( $item->ID, 'last_name', true ) ),
			esc_html( get_post_meta( $item->ID, 'listing', true ) ),
			esc_html( sprintf( '%s %s', get_post_meta( $item->ID, 'street_number', true ), get_post_meta( $item->ID, 'street_name', true ) ) ),
			esc_html( dirhoa_format_phone( current( $phone ) ) )
		);
	}

	printf(
		'<style type="text/css">
            body, html, #wpbody-content {
                font-size:11px;
            }
            .dues-checklist td {
                border:solid 1px #000 !important;
                padding:5px !important;
            }
            .dues-checklist table {
                max-width:99%%;
            }
        </style>
        <div class="button button-primary button-large" onClick="(() => {window.print();})()">Print</div>
        <div class="page dues-checklist"><h1>CHA Annual Dues Checklist <div style="float:right;font-size:0.5em;font-style:normal">%s</div></h1>

        <table>
            <thead>
                <tr>
                    <th colspan="2">Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Check #</th>
                    <th>Date</th>
                    <th>Deposit</th>
                </tr>
            </thead>
            <tbody>
                %s
            </tbody>
        </table></div>',
		date( 'l, F j, Y' ),
		$rows
	);
}

/**
 * Directory sent email message.
 *
 * @return string Email sent message.
 */
function dirhoa_email_sent() {
	return apply_filters( 'dirhoa_message', '' );
}

/**
 * Directory email page.
 *
 * @return void
 */
function dirhoa_email() {
	echo '<style type="text/css">.content2 { width:75%;margin:0 auto;background:rgba(255,255,255,0.75);border-radius:0.5em;padding:1.75rem;color:#333; text-align:left;margin:1em auto;}p { font-size:0.7em; }form > input,textarea { width:100%;border:0;font-size:1.5rem;margin-bottom:1.5rem;padding:1rem;box-sizing:border-box;-moz-boz-sizing:border-box; }textarea { height:18rem; }input[type="file"] {width:auto;font-size:1em;}.button-primary {font-size: 2rem !important; display:block; width: 100%;}</style>';

	ob_start();
	wp_editor(
		isset( $_POST['shipman_body'] ) ? sanitize_text_field( wp_unslash( $_POST['shipman_body'] ) ) : '',
		'shipman_body',
		array(
			'textarea_rows' => 40,
		)
	);
	$editor = ob_get_clean();

	printf(
		'<div class="content2">
            <h1>Bulk Email</h1>

            %s

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_wpnonce" value="%s" />
                <input autocomplete="off" name="shipman_fromName" type="text" placeholder="From Name" value="%s" />
                <input autocomplete="off" name="shipman_from" type="text" placeholder="From Email" value="%s" />
                <input autocomplete="off" name="shipman_subject" type="text" placeholder="Subject" value="%s" />
                %s
                <p>&nbsp;</p>
                %s
            </form>
        </div>',
		dirhoa_email_sent() ? '<div class="updated"><p>' . dirhoa_email_sent() . '</p></div>' : '',
		esc_attr( wp_create_nonce( 'dirhoa_bulk_mailer' ) ),
		esc_attr( isset( $_POST['shipman_fromName'] ) ? sanitize_text_field( wp_unslash( $_POST['shipman_fromName'] ) ) : 'The Cedars Board' ),
		esc_attr( isset( $_POST['shipman_from'] ) ? sanitize_text_field( wp_unslash( $_POST['shipman_from'] ) ) : 'board@the-cedars.org' ),
		esc_attr( isset( $_POST['shipman_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['shipman_subject'] ) ) : '' ),
		$editor,
		dirhoa_email_sent() ? '' : '<button class="button button-primary button-large">Send</button>'
	);
}

/**
 * Email controller. Handles the email post action.
 *
 * @return void
 */
function dirhoa_email_controller() {
	if ( current_user_can( 'manage_options' ) ) {
		$nonce = isset( $_POST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ) : '';

		if ( wp_verify_nonce( $nonce, 'dirhoa_bulk_mailer' ) ) {
			$from_name = isset( $_POST['shipman_fromName'] ) ? sanitize_text_field( wp_unslash( $_POST['shipman_fromName'] ) ) : '';
			$from      = isset( $_POST['shipman_from'] ) ? sprintf( '<%s>', sanitize_text_field( wp_unslash( $_POST['shipman_from'] ) ) ) : '';
			$subject   = isset( $_POST['shipman_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['shipman_subject'] ) ) : '';
			$body      = isset( $_POST['shipman_body'] ) ? apply_filters( 'the_content', sanitize_text_field( wp_unslash( $_POST['shipman_body'] ) ) ) : '';
			$headers   = array(
				'Content-Type: text/html; charset=UTF-8',
				sprintf( 'From: %s %s', $from_name, $from ),
			);

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

			$filtered_emails = array();

			foreach ( $items as $item ) {
				$email = array();

				if ( get_post_meta( $item->ID, 'billing_email', true ) ) {
					$email[] = get_post_meta( $item->ID, 'billing_email', true );
				}

				$emails = (array) explode( "\n", get_post_meta( $item->ID, 'email', true ) );
				$email  = array_merge(
					$email,
					$emails
				);

				foreach ( $email as $_email ) {
					if ( $_email && filter_var( $_email, FILTER_VALIDATE_EMAIL ) ) {
						$filtered_emails[] = $_email;
					}
				}
			}

			$filtered_emails = array_filter( array_unique( $filtered_emails ) );

			$chunked = array_chunk( $filtered_emails, 25 );

			foreach ( $chunked as $ch ) {
				$new_headers = $headers;

				foreach ( $ch as $e ) {
					$new_headers[] = 'Bcc: ' . $e;
				}

				$new_headers[] = 'Reply-To: board@the-cedars.org';

				wp_mail( 'noreply@the-cedars.org', $subject, $body, $new_headers );
				sleep( 1 );
			}

			if ( wp_mail( 'webmaster@the-cedars.org', 'Bulk Mailer Used', "<p>Here's the Body</p><p>=======</p>" . $body, $headers ) ) {
				add_filter(
					'dirhoa_message',
					function( $str ) {
						return __( 'Mesasge has been sent', 'directory' );
					}
				);
			}
		}
	}
}

add_action( 'admin_init', 'dirhoa_email_controller' );
