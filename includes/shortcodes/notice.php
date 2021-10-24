<?php
/**
 * Shortcode: Notice
 *
 * @package Cedars/Shortcodes
 */

/**
 * Notice.
 *
 * @param array $atts The shortcode attributes.
 * @return string
 */
function cedars_shortcode_notice( $atts ) {
	$icon     = ! empty( $atts['icon'] ) ? $atts['icon'] : '';
	$title    = ! empty( $atts['title'] ) ? $atts['title'] : '';
	$subtitle = ! empty( $atts['subtitle'] ) ? $atts['subtitle'] : '';
	$link     = ! empty( $atts['link'] ) ? $atts['link'] : '';

	ob_start();
	?>

	<div class="w-third-l pa3">
		<div>
			<div class="w-50 center mw3 mb4">
					<div class="br-100 bg-near-white aspect-ratio aspect-ratio--1x1 lh-solid">
						<?php if ( ! empty( $link ) ) : ?>
							<a href="<?php echo esc_attr( $link ); ?>" class="flex items-center justify-center aspect-ratio--object ">
								<span class="db dashicon primary" data-icon="<?php echo esc_attr( $icon ); ?>"></span>
							</a>
						<?php else : ?>
							<span class="flex items-center justify-center aspect-ratio--object ">
								<span class="db dashicon primary" data-icon="<?php echo esc_attr( $icon ); ?>"></span>
							</span>
						<?php endif; ?>
					</div>
			</div>
			<div class="tc">
				<?php if ( ! empty( $link ) ) : ?>
					<a href="<?php echo esc_attr( $link ); ?>" class="no-underline">
				<?php endif; ?>

				<div class="fw7 f4 white"><?php echo esc_html( $title ); ?></div>
				<div class="f5 moon-gray"><?php echo esc_html( $subtitle ); ?></div>

				<?php if ( ! empty( $link ) ) : ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php
	$output = ob_get_clean();

	return $output;
}

add_shortcode( 'cedars-notice', 'cedars_shortcode_notice' );
