<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package yoko
 */

function yoko_jetpack_setup() {
	add_theme_support( 'jetpack-responsive-videos' );
	add_image_size( 'yoko-logo', 328, 164 );
	add_theme_support( 'site-logo', array( 'size' => 'yoko-logo' ) );
}
add_action( 'after_setup_theme', 'yoko_jetpack_setup' );

/**
 * Return early if Site Logo is not available.
 */
function yoko_the_site_logo() {
	if ( ! function_exists( 'jetpack_the_site_logo' ) ) {
		return;
	} else {
		jetpack_the_site_logo();
	}
}