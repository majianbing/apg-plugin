<?php
/**
 * The template for displaying search forms in shoes-store
 *
 * @package Shoes Store 
 */
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'shoes-store' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search here', 'placeholder','shoes-store' ); ?>" value="<?php echo esc_attr( get_search_query()); ?>" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button','shoes-store' ); ?>">
</form>