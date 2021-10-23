<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cedars
 */

$cedars_footer_nav = cedars_navigation( 'footer-menu' );

?>

	</div> <!-- .main -->

	<footer id="footer" class="tc tl-l bg-secondary white"> <!-- #footer -->
		<div class="<?php cedars_page_width(); ?>">
			<div class="flex-l pv4">
				<div class="w-100 w-50-l">
					<div class="pr5-l">
						<div class="f3 mb2"><?php echo esc_html( get_bloginfo( 'title' ) ); ?></div>
						<div><?php echo esc_html( get_bloginfo( 'description' ) ); ?></div>
					</div>
				</div>
				<div class="w-100 w-50-l ml-auto-l tr-l">
					<nav class="lh-copy pl0 lh-copy ma0 f6 flex-ns justify-between-ns">
						<?php foreach ( $cedars_footer_nav as $cedars_nav_item ) : ?>
							<a
								href="<?php echo esc_attr( $cedars_nav_item['url'] ); ?>"
								class="color-inherit no-underline tc tl-l db dib-ns mv2 mv0-ns"
							>
								<?php echo esc_html( $cedars_nav_item['label'] ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				</div>
			</div>
			<div class="pv2 f7">
				Copyright
				<?php echo esc_html( gmdate( 'Y' ) ); ?>
				<?php echo esc_html( get_bloginfo( 'title' ) ); ?>
				<span> | All rights reserved</span>
			</div>
		</div>
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
