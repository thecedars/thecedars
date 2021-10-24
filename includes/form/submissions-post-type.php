<?php
/**
 * Submission CPT.
 *
 * @package Cedars/Form
 */

/**
 * Adds the form submission post type.
 *
 * @return void
 */
function cedars_form_submission_post_type() {
	if ( ! post_type_exists( 'form_submission' ) ) {
		$labels = array(
			'name'                  => 'Form Submissions',
			'singular_name'         => 'Form Submission',
			'menu_name'             => 'Form Submissions',
			'new_item'              => __( 'New Form Submission', 'the-cedars' ),
			'add_new_item'          => __( 'Add new Form Submission', 'the-cedars' ),
			'edit_item'             => __( 'Edit Form Submission', 'the-cedars' ),
			'view_item'             => __( 'View Form Submission', 'the-cedars' ),
			'view_items'            => __( 'View Form Submissions', 'the-cedars' ),
			'search_items'          => __( 'Search Form Submissions', 'the-cedars' ),
			'not_found'             => __( 'No Form Submissions found', 'the-cedars' ),
			'not_found_in_trash'    => __( 'No Form Submissions found in trash', 'the-cedars' ),
			'all_items'             => __( 'All Form Submissions', 'the-cedars' ),
			'archives'              => __( 'Form Submission Archives', 'the-cedars' ),
			'attributes'            => __( 'Form Submission Attributes', 'the-cedars' ),
			'insert_into_item'      => __( 'Insert into Form Submissions', 'the-cedars' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Form Submission', 'the-cedars' ),
			'parent_item'           => __( 'Parent Form Submission', 'the-cedars' ),
			'parent_item_colon'     => __( 'Parent Form Submission:', 'the-cedars' ),
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
			'show_in_rest'        => false,
		);

		register_post_type( 'form_submission', $args );
	}
}

add_action( 'init', 'cedars_form_submission_post_type', 15 );

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

	$columns['name']  = __( 'Name', 'the-cedars' );
	$columns['email'] = __( 'Email', 'the-cedars' );
	$columns['phone'] = __( 'Phone', 'the-cedars' );

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

/**
 * Adds the form to the DB.
 *
 * @param WP_Error $error Tracks current errors.
 * @param array    $input Inputs from the mutation submission.
 * @param string   $name Form name.
 * @return WP_Error
 */
function cedars_form_db( $error, $input, $name ) {
	if ( ! $error->has_errors() ) {
		$subject = get_theme_mod( 'theme_form_' . $name . '_subject', 'WordPress Form Submission' );
		$content = nl2br( cedars_input_to_text( $input ) );

		// Insert into the database.
		$p = array(
			'post_type'    => 'form_submission',
			'post_status'  => 'publish',
			'post_content' => $content,
			'post_title'   => $subject,
			'post_name'    => wp_create_nonce( $content ),
		);

		$id = wp_insert_post( $p );

		if ( $id && ! is_wp_error( $id ) ) {
			foreach ( $input as $key => $value ) {
				update_post_meta( $id, $key, $value );
			}

			if ( ! empty( $name ) ) {
				update_post_meta( $id, 'form_name', $name );
			}

			do_action( 'cedars_after_db_insert', $id, $input, $name );
		} else {
			$error->merge_from( $results );
		}
	}

	return $error;
}

add_filter( 'cedars_form_process', 'cedars_form_db', 10, 3 );
