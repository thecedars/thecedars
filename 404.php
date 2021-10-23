<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cedars
 */

get_header();
?>

	<section class="error-404 not-found">
		<?php
		do_action( 'cedars_title_open' );

		esc_html_e( 'Oops! That page can&rsquo;t be found.', 'the-cedars' );

		do_action( 'cedars_title_close' );
		?>

		<div class="<?php cedars_page_width(); ?>">
			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'the-cedars' ); ?></p>

					<?php
					get_search_form();
					?>

			</div><!-- .page-content -->
		</div>
	</section><!-- .error-404 -->

<?php
get_footer();
