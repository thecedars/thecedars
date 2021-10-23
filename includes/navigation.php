<?php
/**
 * Navigation object.
 *
 * @package Cedars
 */

/**
 * Gets the nested navigation structure.
 *
 * @param string $theme_location The theme location to get the items for.
 * @return array Nested array of nav_items.
 */
function cedars_navigation( $theme_location ) {
	$ckey       = 'cedars_navigation_' . $theme_location;
	$navigation = wp_cache_get( $ckey );

	if ( false === $navigation ) {
		$navigation = array();
		$locations  = get_nav_menu_locations();

		if ( ! empty( $locations ) && isset( $locations[ $theme_location ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $theme_location ] );

			if ( $menu ) {
				$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

				if ( ! empty( $menu_items ) ) {
					foreach ( $menu_items as $item ) {
						if ( '0' === $item->menu_item_parent ) {
							$_menu_item   = cedars__navigation( $item, $menu_items );
							$navigation[] = $_menu_item;
						}
					}
				}
			}
		}
	}

	$navigation = apply_filters( 'cedars_navigation_items', $navigation, $theme_location );

	return $navigation;
}

/**
 * Nesting function used by cedars_navigation.
 *
 * @param WP_Term        $item The nav_item in current recusrsion.
 * @param array[WP_Term] $menu_items Complete flatten array of nav_items.
 * @return array
 */
function cedars__navigation( $item, $menu_items ) {
	$_menu_item = array(
		'label'     => $item->title,
		'url'       => $item->url,
		'classes'   => implode( ' ', $item->classes ),
		'object_id' => $item->object_id,
		'object'    => $item->object,
		'target'    => $item->target,
		'title'     => $item->attr_title,
		'children'  => array(),
		'ID'        => $item->ID,
	);

	$_menu_item['id'] = $_menu_item['ID'];

	foreach ( $menu_items as $_item ) {
		if ( intval( $_item->menu_item_parent ) === $item->ID ) {
			$_menu_item['children'][] = cedars__navigation( $_item, $menu_items );
		}
	}

	return cedars_keys_to_camel( $_menu_item );
}

/**
 * Creates an alternative to wp_nav_menu that we can pass classes into.
 *
 * @param array $args Optional. Array of nav menu arguments.
 * @return void|string|false Void if 'echo' argument is true, menu output if 'echo' is false.
 *                           False if there are no items or no menu was found.
 */
function cedars_nav_menu( $args = array() ) {
	$defaults = array(
		'menu'            => '',
		'container'       => 'div',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'link_before'     => '',
		'link_after'      => '',
		'menu_item_class' => '',
		'link_class'      => 'no-underline primary',
		'depth'           => 0,
		'theme_location'  => '',
	);

	$args = wp_parse_args( $args, $defaults );

	$args = apply_filters( 'cedars_nav_menu_args', $args );
	$args = (object) $args;

	$menu = cedars_navigation( $args->theme_location );

	if ( empty( $menu ) ) {
		return false;
	}

	$nav_menu = sprintf( '<%s class="" id="">', esc_attr( $args->container ), esc_attr( $args->menu_class ), esc_attr( $args->menu_id ) );

	$level = 0;

	wp_cache_set( 'cedars_nav_menu_args', $args );

	foreach ( $menu as $menu_item ) {
		$nav_menu .= cedars__nav_menu( $menu_item, $level );
	}

	wp_cache_set( 'cedars_nav_menu_args', false );

	$nav_menu .= sprintf( '</%s>', esc_attr( $args->container ) );

	$nav_menu = apply_filters( 'cedars_nav_menu', $nav_menu, $args );

	if ( $args->echo ) {
		echo wp_kses_post( $nav_menu );
	} else {
		return $nav_menu;
	}
}

/**
 * Recursive function that steps over menu items and creates markup.
 *
 * @param array $item Array. Nav menu item.
 * @param int   $level Incrementing level count.
 * @return string Assembled interior string.
 */
function cedars__nav_menu( $item, $level ) {
	$args      = wp_cache_get( 'cedars_nav_menu_args' );
	$menu_item = '';

	if ( $args->depth < $level ) {
		return '';
	}

	if ( false !== $args ) {
		$menu_item_tag = 'ul' === $args->container || 'ol' === $args->container ? 'li' : 'div';

		$menu_item .= sprintf(
			'<%s class="%s" id="%s"><a href="%s" class="%s" target="%s">%s%s%s</a>',
			esc_attr( $menu_item_tag ),
			esc_attr( apply_filters( 'cedars_nav_menu_item_class', $args->menu_item_class, $item ) ),
			esc_attr( 'menu-item-' . $args->theme_location . '-' . $item['ID'] ),
			esc_attr( $item['url'] ),
			esc_attr( $args->link_class ),
			esc_attr( $item['target'] ),
			esc_attr( $args->link_before ),
			esc_attr( $item['label'] ),
			esc_attr( $args->link_after )
		);

		if ( ! empty( $item['children'] ) ) {
			$menu_item .= sprintf( '<%s>', esc_attr( $args->container ) );

			foreach ( $item['children'] as $child ) {
				$menu_item .= cedars__nav_menu( $child, $level + 1 );
			}

			$menu_item .= sprintf( '</%s>', esc_attr( $args->container ) );
		}

		$menu_item .= sprintf( '</%s>', esc_attr( $menu_item_tag ) );
	}

	return $menu_item;
}
