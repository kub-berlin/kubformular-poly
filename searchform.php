<?php
/**
 * @package Yoko
 */
?>

<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
	<div>
		<label class="screen-reader-text" for="s"><?php _ex( 'Search for:', 'label', 'yoko' ); ?></label>
		<input type="text" class="search-input" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" />
		<input type="submit" class="searchsubmit" value="<?php esc_attr_e( 'Search', 'yoko' ); ?>" />
	</div>
</form>