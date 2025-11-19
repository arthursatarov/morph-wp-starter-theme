<?php
/**
 * Adds custom classes to the array of <main> classes
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param array $classes Array of main tag class names.
 * @return array Modified array of class names.
 */
function morph_custom_main_classes( $classes ) {
	// Optionally, you can add classes dynamically:
	// if ( is_front_page() ) {
	// 	$classes[] = 'main--index';
	// }

	return $classes;
}
add_filter( 'morph_main_class', 'morph_custom_main_classes' );
