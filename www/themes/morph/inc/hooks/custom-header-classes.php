<?php
/**
 * Adds custom classes to the array of <header> classes
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param array $classes Array of header tag class names.
 * @return array Modified array of class names.
 */
function morph_custom_header_classes( $classes ) {
	// Optionally, you can add classes dynamically:
	// if ( is_front_page() ) {
	// 	$classes[] = 'header--index';
	// }

	return $classes;
}
add_filter( 'morph_header_class', 'morph_custom_header_classes' );
