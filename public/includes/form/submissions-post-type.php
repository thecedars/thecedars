<?php
/**
 * Submission CPT.
 *
 * @package Cedars
 */

/**
 * Adds the form submission post type.
 *
 * @return void
 */
function cedars_form_post_type() {
	if ( ! post_type_exists( 'form_submission' ) ) {
		$labels = array(
			'name'                  => 'Form Submissions',
			'singular_name'         => 'Form Submission',
			'menu_name'             => 'Form Submissions',
			'new_item'              => __( 'New Form Submission', 'cedars' ),
			'add_new_item'          => __( 'Add new Form Submission', 'cedars' ),
			'edit_item'             => __( 'Edit Form Submission', 'cedars' ),
			'view_item'             => __( 'View Form Submission', 'cedars' ),
			'view_items'            => __( 'View Form Submissions', 'cedars' ),
			'search_items'          => __( 'Search Form Submissions', 'cedars' ),
			'not_found'             => __( 'No Form Submissions found', 'cedars' ),
			'not_found_in_trash'    => __( 'No Form Submissions found in trash', 'cedars' ),
			'all_items'             => __( 'All Form Submissions', 'cedars' ),
			'archives'              => __( 'Form Submission Archives', 'cedars' ),
			'attributes'            => __( 'Form Submission Attributes', 'cedars' ),
			'insert_into_item'      => __( 'Insert into Form Submissions', 'cedars' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Form Submission', 'cedars' ),
			'parent_item'           => __( 'Parent Form Submission', 'cedars' ),
			'parent_item_colon'     => __( 'Parent Form Submission:', 'cedars' ),
			'archive_title'         => 'Form Submissions',
		);

		$args = array(
			'labels'              => $labels,
			'description'         => 'Forms submitted from the frontend into backend.',
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => false,
			'show_in_admin_bar'   => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'supports'            => array(
				'title',
				'editor',
			),
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-format-aside',
			'show_in_nav_menus'   => false,
			'rewrite'             => false,
			'show_in_rest'        => true,
		);

		register_post_type( 'form_submission', $args );
	}
}

add_action( 'init', 'cedars_form_post_type', 15 );

/**
 * Adds email, phone, and location to the form submissions.
 *
 * @param array $columns Associative array of columns and labels.
 * @return array
 */
function cedars_set_custom_edit_columns( $columns ) {
	$date = $columns['date'];
	unset( $columns['date'] );
	unset( $columns['title'] );
	unset( $columns['form'] );

	$columns['name']  = __( 'Name', 'cedars' );
	$columns['email'] = __( 'Email', 'cedars' );
	$columns['phone'] = __( 'Phone', 'cedars' );

	$columns['date'] = $date;
	return $columns;
}

add_filter( 'manage_form_submission_posts_columns', 'cedars_set_custom_edit_columns' );

/**
 * Custom form submission column content.
 *
 * @param string $column Column name.
 * @param int    $post_id Post ID.
 * @return void
 */
function cedars_custom_column( $column, $post_id ) {
	switch ( $column ) {
		case 'name':
			echo esc_html( get_post_meta( $post_id, 'yourName', true ) );
			break;

		case 'email':
			echo esc_html( get_post_meta( $post_id, 'email', true ) );
			break;

		case 'phone':
			echo esc_html( get_post_meta( $post_id, 'phone', true ) );
			break;

		default:
			break;

	}
}

add_action( 'manage_form_submission_posts_custom_column', 'cedars_custom_column', 10, 2 );
