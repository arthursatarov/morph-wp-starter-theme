<?php
/**
 * Theme assets
 *
 * @package MORPH
 */

/*==================================================================================
	Table of Contents:
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  1.0 STYLES & SCRIPTS
		1.1. ENQUEUE SCRIPTS
  2.0 FONTS
		2.2. PRELOAD LOCAL FONTS
		2.3. PRECONNECT GOOGLE FONTS
==================================================================================*/

add_action( 'wp_enqueue_scripts', 'morph_enqueue_scripts' );
add_action( 'wp_head', 'morph_preload_local_fonts' );
add_action( 'wp_head', 'morph_preconnect_google_fonts', 1 );

/*==================================================================================
  1.0. STYLES & SCRIPTS
==================================================================================*/

/* 1.1. ENQUEUE SCRIPTS
/––––––––––––––––––––––––*/
function morph_enqueue_scripts() {
	// styles
	wp_enqueue_style( 'morph', MORPH_THEME_URI . '/assets/styles/main.css', array(), MORPH_THEME_VERSION, 'all' );

	// scripts
	wp_enqueue_script( 'morph', MORPH_THEME_URI . '/assets/scripts/main.js', array(), MORPH_THEME_VERSION, true );
}

/*==================================================================================
  2.0. FONTS
==================================================================================*/

/* 2.1. PRELOAD LOCAL FONTS
/––––––––––––––––––––––––*/
// preload local font files for performance optimization.
function morph_preload_local_fonts() {
	$enabled = false;

	if ( ! $enabled ) {
		return;
	}

	$fonts = [
		'Inter' => [ 'woff2' ],
	];

	foreach ( $fonts as $name => $formats ) {
		foreach ( $formats as $format ) {
			printf(
				'<link rel="preload" href="%s" as="font" type="font/%s" crossorigin>' . PHP_EOL,
				esc_url( MORPH_THEME_URI . '/assets/fonts/' . $name . '.' . $format ),
				esc_attr( $format )
			);
		}
	}
}

/* 2.2. PRECONNECT GOOGLE FONTS
/––––––––––––––––––––––––*/
// preconnect to Google Fonts for faster resource fetching.
function morph_preconnect_google_fonts() {
	$enabled = false;

	if ( ! $enabled ) {
		return;
	}

	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . PHP_EOL;
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . PHP_EOL;
}
