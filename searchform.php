<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Cedars
 */

?>

<form role="search" method="get" class="search-form flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="flex-auto">
		<label>
				<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'the-cedars' ); ?></span>
				<input type="search" class="<?php cedars_input(); ?>" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'the-cedars' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
		</label>
	</div>
	<div class="flex-none pl1">
		<input type="submit" class="<?php cedars_button(); ?>" value="<?php echo esc_attr_x( 'Search', 'submit button', 'the-cedars' ); ?>" />
	</div>
</form>
