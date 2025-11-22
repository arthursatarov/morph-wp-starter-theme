<?php
/**
 * Adds custom classes to the array of <body> classes
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param array $classes Array of body tag class names.
 * @return array Modified array of class names.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function morph_custom_body_classes( $classes ) {
	// Override default WP body classes
	$classes = [ 'page' ];

	// Optionally, you can add classes dynamically:
	// if ( is_front_page() ) {
	// 	$classes[] = '';
	// }

	return $classes;
}
add_filter( 'body_class', 'morph_custom_body_classes' );
