<?php
/**
 * Login Style Tag CSS
 *
 * @package Cedars
 */

?>

<style type="text/css">
	#login {
		position: relative;
		z-index: 2;
	}

	#login h1 a, .login h1 a {
		background-image: url("<?php echo esc_url( wp_cache_get( 'logo_url' ) ); ?>");
		height: 128px;
		width: 256px;
		background-size: contain;
		background-position: 50% 50%;;
	}
</style>
