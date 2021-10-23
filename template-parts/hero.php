<?php
/**
 * Template Hero
 *
 * @package Cedars
 */

?>

<div class="fullwidth">
	<div class="min-vh-100 flex justify-center items-center bg-center cover white relative z-1"
	<?php

	if ( ! empty( $background ) ) {
		printf( "style=\"background-image:url('%s');\"", esc_attr( $background_image ) );
	}

	?>
	>
		<div class="w-100 pv4 relative z-2">
			<div class="pa4">
				<?php echo wp_kses_post( $contents ); ?>
			</div>
		</div>

		<?php if ( ! empty( $opacity ) ) : ?>
			<div class="absolute absolute--fill bg-black z-1" style="opacity: <?php echo $opacity / 100; // @phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;"></div>
		<?php endif; ?>
	</div>
</div>
