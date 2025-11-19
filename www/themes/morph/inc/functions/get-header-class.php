<?php
/**
 * Retrieves an array of classes for the header tag.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param string|array $class Additional classes as string or array. Default empty.
 * @return array Array of unique class names.
 */
function morph_get_header_class( $class = '' ) {
	// Base classes
	$classes = [ 'header' ];

	// Add additional classes if provided
	if ( ! empty( $class ) ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_merge( $classes, $class );
	}

	// Apply filter for customization
	$classes = apply_filters( 'morph_header_class', $classes, $class );

	// Remove duplicates and empty values
	$classes = array_unique( array_filter( $classes ) );

	return $classes;
}
