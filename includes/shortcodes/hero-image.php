<?php
/**
 * Shortcode: Hero Image
 *
 * @package Cedars/Shortcodes
 */

/**
 * Hero.
 *
 * @param array  $atts The shortcode attributes.
 * @param string $contents The contents between the shortcode tags.
 * @return string
 */
function cedars_shortcode_hero_image( $atts, $contents = '' ) {
	$contents = do_shortcode( $contents );
	$margin   = ! empty( $atts['margin'] ) ? absint( $atts['margin'] ) : 0;
	$image    = ! empty( $atts['image'] ) ? absint( $atts['image'] ) : null;
	$title    = ! empty( $atts['title'] ) ? $atts['title'] : '';

	ob_start();
	?>

	<div class="flex items-center mv<?php echo esc_attr( $margin ); ?> pv0-l">
		<div class="flex-l items-center-l">
			<div class="w-60-l pr4-l mb4 mb0-l">
				<div class="ttu tracked"><?php echo esc_html( get_bloginfo( 'title' ) ); ?> <span rol="img" aria-label="Picture of a tree.">🌲</span></div>
				<div class="f1 f-5-l fw7 lh-solid mb3"><?php echo esc_html( $title ); ?></div>
				<div class="post-content mid-gray">
					<?php echo wp_kses_post( $contents ); ?>
				</div>
			</div>
			<div class="w-40-l overflow-hidden br4 shadow-1 h5 h-auto-l animate__animated animate__slideInRight">
				<?php
					cedars_the_image_src(
						$image,
						'large',
						array(
							'class' => 'object-cover w-100 h-100 db',
						)
					);
				?>
			</div>
		</div>
	</div>

	<?php
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'cedars-image-hero', 'cedars_shortcode_hero_image' );
