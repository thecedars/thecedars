<?php
/**
 * Custom Post Type
 *
 * @package Directory
 */

/**
 * Post Type: Directory Entries.
 *
 * @return void
 */
function dirhoa_register_my_cpts() {

	$labels = array(
		'name'                     => __( 'Directory Entries', 'directory' ),
		'singular_name'            => __( 'Directory Entry', 'directory' ),
		'menu_name'                => __( 'Directory', 'directory' ),
		'all_items'                => __( 'All Directory Entries', 'directory' ),
		'add_new'                  => __( 'Add new', 'directory' ),
		'add_new_item'             => __( 'Add new Directory Entry', 'directory' ),
		'edit_item'                => __( 'Edit Directory Entry', 'directory' ),
		'new_item'                 => __( 'New Directory Entry', 'directory' ),
		'view_item'                => __( 'View Directory Entry', 'directory' ),
		'view_items'               => __( 'View Directory Entries', 'directory' ),
		'search_items'             => __( 'Search Directory Entries', 'directory' ),
		'not_found'                => __( 'No Directory Entries found', 'directory' ),
		'not_found_in_trash'       => __( 'No Directory Entries found in trash', 'directory' ),
		'parent'                   => __( 'Parent Directory Entry:', 'directory' ),
		'featured_image'           => __( 'Featured image for this Directory Entry', 'directory' ),
		'set_featured_image'       => __( 'Set featured image for this Directory Entry', 'directory' ),
		'remove_featured_image'    => __( 'Remove featured image for this Directory Entry', 'directory' ),
		'use_featured_image'       => __( 'Use as featured image for this Directory Entry', 'directory' ),
		'archives'                 => __( 'Directory Entry archives', 'directory' ),
		'insert_into_item'         => __( 'Insert into Directory Entry', 'directory' ),
		'uploaded_to_this_item'    => __( 'Upload to this Directory Entry', 'directory' ),
		'filter_items_list'        => __( 'Filter Directory Entries list', 'directory' ),
		'items_list_navigation'    => __( 'Directory Entries list navigation', 'directory' ),
		'items_list'               => __( 'Directory Entries list', 'directory' ),
		'attributes'               => __( 'Directory Entries attributes', 'directory' ),
		'name_admin_bar'           => __( 'Directory Entry', 'directory' ),
		'item_published'           => __( 'Directory Entry published', 'directory' ),
		'item_published_privately' => __( 'Directory Entry published privately.', 'directory' ),
		'item_reverted_to_draft'   => __( 'Directory Entry reverted to draft.', 'directory' ),
		'item_scheduled'           => __( 'Directory Entry scheduled', 'directory' ),
		'item_updated'             => __( 'Directory Entry updated.', 'directory' ),
		'parent_item_colon'        => __( 'Parent Directory Entry:', 'directory' ),
	);

	$args = array(
		'label'                 => __( 'Directory Entries', 'directory' ),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_in_graphql'       => false,
		'graphql_single_name'   => 'directory',
		'graphql_plural_name'   => 'directories',
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => false,
		'delete_with_user'      => false,
		'exclude_from_search'   => true,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'rewrite'               => false,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-multisite',
		'supports'              => array( 'title' ),
	);

	register_post_type( 'directory', $args );

	/**
	 * Post Type: Ads.
	 */

	$labels = array(
		'name'                     => __( 'Ads', 'directory' ),
		'singular_name'            => __( 'Ad', 'directory' ),
		'menu_name'                => __( 'Ads', 'directory' ),
		'all_items'                => __( 'All Ads', 'directory' ),
		'add_new'                  => __( 'Add new', 'directory' ),
		'add_new_item'             => __( 'Add new Ad', 'directory' ),
		'edit_item'                => __( 'Edit Ad', 'directory' ),
		'new_item'                 => __( 'New Ad', 'directory' ),
		'view_item'                => __( 'View Ad', 'directory' ),
		'view_items'               => __( 'View Ads', 'directory' ),
		'search_items'             => __( 'Search Ads', 'directory' ),
		'not_found'                => __( 'No Ads found', 'directory' ),
		'not_found_in_trash'       => __( 'No Ads found in trash', 'directory' ),
		'parent'                   => __( 'Parent Ad:', 'directory' ),
		'featured_image'           => __( 'Featured image for this Ad', 'directory' ),
		'set_featured_image'       => __( 'Set featured image for this Ad', 'directory' ),
		'remove_featured_image'    => __( 'Remove featured image for this Ad', 'directory' ),
		'use_featured_image'       => __( 'Use as featured image for this Ad', 'directory' ),
		'archives'                 => __( 'Ad archives', 'directory' ),
		'insert_into_item'         => __( 'Insert into Ad', 'directory' ),
		'uploaded_to_this_item'    => __( 'Upload to this Ad', 'directory' ),
		'filter_items_list'        => __( 'Filter Ads list', 'directory' ),
		'items_list_navigation'    => __( 'Ads list navigation', 'directory' ),
		'items_list'               => __( 'Ads list', 'directory' ),
		'attributes'               => __( 'Ads attributes', 'directory' ),
		'name_admin_bar'           => __( 'Ad', 'directory' ),
		'item_published'           => __( 'Ad published', 'directory' ),
		'item_published_privately' => __( 'Ad published privately.', 'directory' ),
		'item_reverted_to_draft'   => __( 'Ad reverted to draft.', 'directory' ),
		'item_scheduled'           => __( 'Ad scheduled', 'directory' ),
		'item_updated'             => __( 'Ad updated.', 'directory' ),
		'parent_item_colon'        => __( 'Parent Ad:', 'directory' ),
	);

	$args = array(
		'label'                 => __( 'Ads', 'directory' ),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => true,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_in_graphql'       => true,
		'graphql_single_name'   => 'ad',
		'graphql_plural_name'   => 'ads',
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => true,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'rewrite'               => false,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-id',
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'ad', $args );

	/**
	 * Post Type: Letters.
	 */

	$labels = array(
		'name'                     => __( 'Letters', 'directory' ),
		'singular_name'            => __( 'Letter', 'directory' ),
		'menu_name'                => __( 'Letters', 'directory' ),
		'all_items'                => __( 'All Letters', 'directory' ),
		'add_new'                  => __( 'Add new', 'directory' ),
		'add_new_item'             => __( 'Add new Letter', 'directory' ),
		'edit_item'                => __( 'Edit Letter', 'directory' ),
		'new_item'                 => __( 'New Letter', 'directory' ),
		'view_item'                => __( 'View Letter', 'directory' ),
		'view_items'               => __( 'View Letters', 'directory' ),
		'search_items'             => __( 'Search Letters', 'directory' ),
		'not_found'                => __( 'No Letters found', 'directory' ),
		'not_found_in_trash'       => __( 'No Letters found in trash', 'directory' ),
		'parent'                   => __( 'Parent Letter:', 'directory' ),
		'featured_image'           => __( 'Featured image for this Letter', 'directory' ),
		'set_featured_image'       => __( 'Set featured image for this Letter', 'directory' ),
		'remove_featured_image'    => __( 'Remove featured image for this Letter', 'directory' ),
		'use_featured_image'       => __( 'Use as featured image for this Letter', 'directory' ),
		'archives'                 => __( 'Letter archives', 'directory' ),
		'insert_into_item'         => __( 'Insert into Letter', 'directory' ),
		'uploaded_to_this_item'    => __( 'Upload to this Letter', 'directory' ),
		'filter_items_list'        => __( 'Filter Letters list', 'directory' ),
		'items_list_navigation'    => __( 'Letters list navigation', 'directory' ),
		'items_list'               => __( 'Letters list', 'directory' ),
		'attributes'               => __( 'Letters attributes', 'directory' ),
		'name_admin_bar'           => __( 'Letter', 'directory' ),
		'item_published'           => __( 'Letter published', 'directory' ),
		'item_published_privately' => __( 'Letter published privately.', 'directory' ),
		'item_reverted_to_draft'   => __( 'Letter reverted to draft.', 'directory' ),
		'item_scheduled'           => __( 'Letter scheduled', 'directory' ),
		'item_updated'             => __( 'Letter updated.', 'directory' ),
		'parent_item_colon'        => __( 'Parent Letter:', 'directory' ),
	);

	$args = array(
		'label'                 => __( 'Letters', 'directory' ),
		'labels'                => $labels,
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => false,
		'show_ui'               => true,
		'show_in_rest'          => true,
		'show_in_graphql'       => false,
		'rest_base'             => '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive'           => false,
		'show_in_menu'          => true,
		'show_in_nav_menus'     => true,
		'delete_with_user'      => false,
		'exclude_from_search'   => true,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'rewrite'               => false,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-email',
		'supports'              => array( 'title', 'editor' ),
	);

	register_post_type( 'letter', $args );
}

add_action( 'init', 'dirhoa_register_my_cpts' );
