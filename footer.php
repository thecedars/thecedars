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

?>

	</div> <!-- #page-content-wrapper -->
	</div> <!-- .main -->

	<footer id="footer" class="tc"> <!-- #footer -->
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
