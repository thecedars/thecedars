<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cedars
 */

$cedars_classes = '';

if ( ! is_singular( get_post_type() ) ) {
	$cedars_classes = 'pa4 w-third-l';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $cedars_classes ); ?>>
	<?php	if ( is_singular( get_post_type() ) ) : ?>

		<?php
		do_action( 'cedars_title_open' );
		the_title();
		do_action( 'cedars_title_close' );
		?>
		<div class="<?php cedars_page_width(); ?>">
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php cedars_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div> <!-- page_width -->

	<?php else : ?>

		<div class="bg-white">
			<header class="entry-header">
				<?php cedars_post_thumbnail(); ?>

				<div class="pt4 ph4">
					<?php the_title( '<h2 class="entry-title ma0 ttu lh-title"><a class="no-underline color-inherit" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
				</div>

				<div class="ph4"><?php echo esc_html( get_the_date() ); ?></div>
			</header><!-- .entry-header -->

			<div class="entry-content pa4">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<div class="flex justify-center pb4">
				<a href="<?php the_permalink(); ?>" rel="bookmark" class="<?php cedars_button(); ?>">
					<?php esc_html_e( 'View Details', 'the-cedars' ); ?>
				</a>
			</div>
		</div>

	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
