<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Cedars
 */

get_header();
?>

	<?php
	do_action( 'cedars_title_open' );

	if ( get_search_query() ) {
		/* translators: %s: search query. */
		printf( esc_html__( 'Search Results for: %s', 'the-cedars' ), '<span>' . get_search_query() . '</span>' );
	} else {
		esc_html_e( 'Search', 'the-cedars' );
	}

	do_action( 'cedars_title_close' );
	?>

	<div class="<?php cedars_page_width(); ?>">
		<?php get_search_form(); ?>

		<?php if ( have_posts() ) : ?>

			<?php
			do_action( 'cedars_before_loop' );

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			do_action( 'cedars_after_loop' );

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</div>

<?php
get_footer();
