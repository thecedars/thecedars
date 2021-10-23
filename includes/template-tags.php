<?php
/**
 * Custom template tags for this theme
 *
 * @package Cedars
 */

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function cedars_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'the-cedars' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'the-cedars' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'the-cedars' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'the-cedars' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'the-cedars' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'the-cedars' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			wp_kses_post( get_the_title() )
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function cedars_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

			<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
}

/**
 * Page width classes.
 */
function cedars_page_width() {
	echo esc_attr( cedars_page_width__() );
}

/**
 * Button classes.
 */
function cedars_button() {
	echo esc_attr( cedars_button__() );
}

/**
 * Page width classes.
 */
function cedars_input() {
	echo esc_attr( cedars_input__() );
}

/**
 * Opening tag for titles.
 */
function cedars_title_open() {
	$tag   = 'h1';
	$_post = get_queried_object();
	if ( ! empty( $_post->post_content ) && false !== stripos( $_post->post_content, '<h1' ) ) {
		$tag = 'div';
	}

	wp_cache_set( 'title_tag', $tag, 'cedars' );

	?>

	<div class="title mb4">
		<div class="<?php cedars_page_width(); ?>">
			<?php printf( '<%s class="ma0 lh-solid pv4">', $tag ); // @phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="f3 fw4 db">
	<?php
}

add_action( 'cedars_title_open', 'cedars_title_open' );

/**
 * Closing tag for titles.
 */
function cedars_title_close() {
	$tag = wp_cache_get( 'title_tag', 'cedars' );

	?>
				</span>
			<?php printf( '</%s>', $tag ); // @phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>

	<?php
}

add_action( 'cedars_title_close', 'cedars_title_close' );

/**
 * Wrap archives with a flexbox.
 */
function cedars_archive_flexbox_start() {
	if ( is_home() || is_archive() || is_search() ) :
		?>

	<div class="overflow-hidden pv4">
		<div class="flex flex-wrap nl4 nt4 nb4 nr4 justify-center">

		<?php
	endif;
}

add_action( 'cedars_before_loop', 'cedars_archive_flexbox_start' );

/**
 * Wrap archives with a flexbox (end).
 */
function cedars_archive_flexbox_end() {
	if ( is_home() || is_archive() || is_search() ) :
		?>

		</div>
	</div>

		<?php
	endif;
}

add_action( 'cedars_after_loop', 'cedars_archive_flexbox_end' );

// @phpcs:disable
if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;
// @phpcs:enable
