<?php
/**
 * Ad Custom Post Type
 *
 * @package Cedars
 */

/**
 * Registers the Ad CPT.
 *
 * @return void
 */
function cedars_register_ad_cpt() {
	$labels = array(
		'name'                     => __( 'Ads', 'cedars' ),
		'singular_name'            => __( 'Ad', 'cedars' ),
		'menu_name'                => __( 'Ads', 'cedars' ),
		'all_items'                => __( 'All Ads', 'cedars' ),
		'add_new'                  => __( 'Add new', 'cedars' ),
		'add_new_item'             => __( 'Add new Ad', 'cedars' ),
		'edit_item'                => __( 'Edit Ad', 'cedars' ),
		'new_item'                 => __( 'New Ad', 'cedars' ),
		'view_item'                => __( 'View Ad', 'cedars' ),
		'view_items'               => __( 'View Ads', 'cedars' ),
		'search_items'             => __( 'Search Ads', 'cedars' ),
		'not_found'                => __( 'No Ads found', 'cedars' ),
		'not_found_in_trash'       => __( 'No Ads found in trash', 'cedars' ),
		'parent'                   => __( 'Parent Ad:', 'cedars' ),
		'featured_image'           => __( 'Featured image for this Ad', 'cedars' ),
		'set_featured_image'       => __( 'Set featured image for this Ad', 'cedars' ),
		'remove_featured_image'    => __( 'Remove featured image for this Ad', 'cedars' ),
		'use_featured_image'       => __( 'Use as featured image for this Ad', 'cedars' ),
		'archives'                 => __( 'Ad archives', 'cedars' ),
		'insert_into_item'         => __( 'Insert into Ad', 'cedars' ),
		'uploaded_to_this_item'    => __( 'Upload to this Ad', 'cedars' ),
		'filter_items_list'        => __( 'Filter Ads list', 'cedars' ),
		'items_list_navigation'    => __( 'Ads list navigation', 'cedars' ),
		'items_list'               => __( 'Ads list', 'cedars' ),
		'attributes'               => __( 'Ads attributes', 'cedars' ),
		'name_admin_bar'           => __( 'Ad', 'cedars' ),
		'item_published'           => __( 'Ad published', 'cedars' ),
		'item_published_privately' => __( 'Ad published privately.', 'cedars' ),
		'item_reverted_to_draft'   => __( 'Ad reverted to draft.', 'cedars' ),
		'item_scheduled'           => __( 'Ad scheduled', 'cedars' ),
		'item_updated'             => __( 'Ad updated.', 'cedars' ),
		'parent_item_colon'        => __( 'Parent Ad:', 'cedars' ),
	);

	$args = array(
		'label'                 => __( 'Ads', 'cedars' ),
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
		'show_in_nav_menus'     => false,
		'delete_with_user'      => false,
		'exclude_from_search'   => true,
		'capability_type'       => 'post',
		'map_meta_cap'          => true,
		'hierarchical'          => false,
		'rewrite'               => false,
		'query_var'             => false,
		'menu_icon'             => 'dashicons-id',
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
	);

	register_post_type( 'ad', $args );
}

add_action( 'init', 'cedars_register_ad_cpt' );

/**
 * Removes cpts from Yoast accessible Post Types.
 *
 * @param array $post_types Array of post types.
 * @return array
 */
function cedars_remove_ads_from_yoast( $post_types ) {
	return array_diff( $post_types, array( 'ad' ) );
}

add_filter( 'wpseo_accessible_post_types', 'cedars_remove_ads_from_yoast' );
