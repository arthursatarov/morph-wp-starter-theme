<?php
/**
 * Retrieves an array of classes for the main tag.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param string|array $class Additional classes as string or array. Default empty.
 * @return array Array of unique class names.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function morph_get_main_class( $class = '' ) {
	// Base classes
	$classes = [ 'content' ];

	// Add additional classes if provided
	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	}

	// Apply filter for customization
	$classes = apply_filters( 'morph_main_class', $classes, $class );

	// Remove duplicates and empty values
	$classes = array_unique( array_filter( $classes ) );

	return $classes;
}
