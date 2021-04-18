<?php
/**
 * Post meta boxes.
 *
 * @package Directory
 */

/**
 * Adds metaboxes to letters for output (csv, addreses, labels).
 *
 * @return void
 */
function dirhoa_choose_recipients_letter_metabox() {
	add_meta_box(
		'dirhoa_checkboxen',
		__( 'Choose Recipients', 'directory' ),
		'add_dirhoa_metaboxes_callback',
		'letter',
		'normal',
		'default'
	);
}

add_action( 'add_meta_boxes', 'dirhoa_choose_recipients_letter_metabox' );

/**
 * Metabox callback for "Choose Recipients".
 *
 * @return void.
 */
function add_dirhoa_metaboxes_callback() {
	global $post;
	$saved = explode(
		',',
		get_post_meta( $post->ID, 'dirhoa_checkboxen', true )
	);

	echo '
        <style type="text/css">
            .directory-list:after {
                content:"";
                clear:both;
                height:0;
                display:block;
                width:100%;
            }
            .directory-list li {
                width:33.3%;
                float:left;
            }

            .directory-list li:nth-child(3n+1) {
                clear:both;
            }
        </style>
    ';

	echo '<ul class="directory-list">';

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

	foreach ( $items as $item ) {
		printf(
			'<li><input %s type="checkbox" name="dirhoa_checkboxen[]" id="directory-%s" value="%s" /> <label for="directory-%s">%s %s</label></li>',
			checked(
				in_array(
					$item->ID,
					$saved
				),
				true,
				false
			),
			esc_attr( $item->ID ),
			esc_attr( $item->ID ),
			esc_attr( $item->ID ),
			esc_attr( get_post_meta( $item->ID, 'listing', true ) ),
			esc_attr( get_post_meta( $item->ID, 'street_number', true ) )
		);
	}

	echo '</ul>';
}

/**
 * Save metabox values on post save "Choose Recipient".
 *
 * @param int     $post_id WP_Post ID.
 * @param WP_Post $post Post being edited.
 * @return void
 */
function dirhoa_letter_save_post( $post_id, $post ) {
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return $post->ID;
	}

	if ( isset( $_POST['dirhoa_checkboxen'] ) && 'letter' === $post->post_type ) {
		update_post_meta(
			$post->ID,
			'dirhoa_checkboxen',
			implode(
				',',
				$_POST['dirhoa_checkboxen']
			)
		);
	}

	if ( 'letter' === $post->post_type && ! isset( $_POST['dirhoa_checkboxen'] ) ) {
		delete_post_meta( $post->ID, 'dirhoa_checkboxen' );
	}
}

add_action( 'save_post', 'dirhoa_letter_save_post', 10, 2 );
