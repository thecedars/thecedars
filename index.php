<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cedars
 */

get_header();
?>

	<?php
	if ( ! is_singular() && ! is_front_page() ) {
		do_action( 'cedars_title_open' );
		the_archive_title();
		do_action( 'cedars_title_close' );
	}
	?>

	<?php if ( ! is_singular() ) : ?>
		<div class="<?php cedars_page_width(); ?>">
	<?php endif; ?>

		<?php
		if ( have_posts() ) :

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

	<?php if ( ! is_singular() ) : ?>
		</div>
	<?php endif; ?>

<?php
get_footer();
