<?php
/**
 * Displays the class attribute for the main tag.
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

function morph_main_class( $class = '' ) {
	// Get classes
	$classes = morph_get_main_class( $class );

	// Output result
	echo 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
}
