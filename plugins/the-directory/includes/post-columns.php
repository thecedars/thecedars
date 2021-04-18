<?php
/**
 * Post columns
 *
 * @package Directory
 */

/**
 * Custom column output for the direcotry cpt.
 *
 * @return void
 */
function dirhoa_custom_columns( $column, $post_id ) {
	if ( 'last_name' === $column ) {
		echo get_post_meta( $post_id, 'last_name', true );
	}

	if ( 'phone' === $column ) {
		$item = (array) explode( "\n", get_post_meta( $post_id, 'phone', true ) );
		echo dirhoa_format_phone( current( $item ) );
	}

	if ( 'email' === $column ) {
		$item = (array) explode( "\n", get_post_meta( $post_id, 'email', true ) );
		echo current( $item );
	}
}

add_action( 'manage_directory_posts_custom_column', 'dirhoa_custom_columns', 10, 2 );

/**
 * Adds columns to the Directory cpt table.
 *
 * @param array $columns WP List Table columns.
 * @return array Filtered column array.
 */
function dirhoa_add_custom_columns( $columns ) {
	$date = $columns['date'];
	unset( $columns['date'] );

	$columns['title']     = __( 'Home', 'directory' );
	$columns['last_name'] = __( 'Last Name', 'directory' );
	$columns['phone']     = __( 'Phone', 'directory' );
	$columns['email']     = __( 'Email Address', 'directory' );

	$columns['date'] = $date;

	return $columns;
}

add_filter( 'manage_directory_posts_columns', 'dirhoa_add_custom_columns' );

/**
 * Adds sortable columns.
 *
 * @param array $columns Columns that are sortable.
 * @return array Filtered sortable columns.
 */
function dirhoa_custom_sortable_columns( $columns ) {
	$columns['last_name'] = 'last_name';
	$columns['phone']     = 'phone';
	$columns['email']     = 'email';
	return $columns;
}

add_filter( 'manage_edit-directory_sortable_columns', 'dirhoa_custom_sortable_columns' );

/**
 * Pre get posts that sorts the directories in admin.
 *
 * @param WP_Query $query Query being targeted.
 * @return void
 */
function dirhoa_sort_directory_posts( $query ) {
	if ( is_admin() && 'directory' === $query->query['post_type'] ) {
		$orderby = $query->get( 'orderby' );

		if ( 'last_name' === $orderby ) {
			$meta_query = array(
				'relation' => 'OR',
				array(
					'key' => 'last_name',
				),
				array(
					'key'     => 'last_name',
					'compare' => 'NOT EXISTS',
				),
			);

			$query->set( 'meta_query', $meta_query );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'phone' === $orderby ) {
			$meta_query = array(
				'relation' => 'OR',
				array(
					'key' => 'phone',
				),
				array(
					'key'     => 'phone',
					'compare' => 'NOT EXISTS',
				),
			);

			$query->set( 'meta_query', $meta_query );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'email' === $orderby ) {
			$meta_query = array(
				'relation' => 'OR',
				array(
					'key' => 'email',
				),
				array(
					'key'     => 'email',
					'compare' => 'NOT EXISTS',
				),
			);

			$query->set( 'meta_query', $meta_query );
			$query->set( 'orderby', 'meta_value' );
		}
	}
}

add_action( 'pre_get_posts', 'dirhoa_sort_directory_posts' );
