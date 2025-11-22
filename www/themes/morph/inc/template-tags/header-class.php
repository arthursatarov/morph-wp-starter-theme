<?php
/**
 * Displays the class attribute for the header tag.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param string|array $class Additional classes as string or array. Default empty.
 * @return void
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function morph_header_class( $class = '' ) {
	// Get classes
	$classes = morph_get_header_class( $class );

	// Output result
	echo 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
}
