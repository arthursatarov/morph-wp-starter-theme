<?php
/**
 * Override default WP body classes with custom ones.
 *
 * @package MORPH
 */
function morph_customize_body_classes( $classes ) {
	$classes = [ 'page' ];

	// Optionally, you can add classes dynamically:
	// if ( is_front_page() ) {
	//     $classes[] = 'front-page';
	// }

	return $classes;
}
add_filter( 'body_class', 'morph_customize_body_classes' );
