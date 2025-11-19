<?php
/**
 * Theme Setup and Core Functionality
 *
 * @package MORPH
 */


/*=======================================================
Table of Contents
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
	1.0 THEME SETTINGS
		1.1 register menus
		1.2 theme support
		1.3 head cleanup / optimization
	2.0 THEME ASSETS
		2.1 enqueue styles/scripts
		2.2 preload local hosted fonts
		2.3 enqueue google fonts
=======================================================*/


/*=======================================================
	1.0 THEME SETTINGS
=======================================================*/

/* 1.1 REGISTER MENUS
/––––––––––––––––––––––––-------------*/
function morph_register_menus() {
	register_nav_menus(
		array(
			'header_menu' => esc_html__( 'Header menu', 'morph' ),
			'footer_menu' => esc_html__( 'Footer menu', 'morph' ),
		)
	);
}
add_action( 'after_setup_theme', 'morph_register_menus' );

/* 1.2 THEME SUPPORT
/––––––––––––––––––––––––-------------*/
function morph_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
}
add_action( 'after_setup_theme', 'morph_theme_support' );

/* 1.3 HEAD CLEANUP / OPTIMIZATION
/––––––––––––––––––––––––-------------*/
function morph_wphead_cleanup() {
	// remove the generator meta tag
	remove_action( 'wp_head', 'wp_generator' );
	// remove wlwmanifest link
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// remove RSD API connection
	remove_action( 'wp_head', 'rsd_link' );
	// remove wp shortlink support
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	// remove next/previous links (this is not affecting blog-posts)
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
	// remove generator name from RSS
	add_filter( 'the_generator', '__return_false' );
	// disable emoji support
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	// disable automatic feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	// remove rest API link
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	// remove oEmbed link
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}
add_action( 'after_setup_theme', 'morph_wphead_cleanup' );

/*=======================================================
	2.0 THEME ASSETS
=======================================================*/

/* 2.1 ENQUEUE STYLES/SCRIPTS
/––––––––––––––––––––––––-------------*/
function morph_enqueue_scripts() {
	// jQuery
  wp_deregister_script( 'jquery' );
  wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', [], '3.7.1' );
	wp_enqueue_script( 'jquery' );

	// Theme scripts/styles
	wp_enqueue_script( 'morph', MORPH_SCRIPTS_URI . '/main.js', [], MORPH_THEME_VERSION, true );
	wp_enqueue_style( 'morph', MORPH_STYLES_URI . '/main.css', [], MORPH_THEME_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts', 'morph_enqueue_scripts' );

/* 2.1 PRELOAD LOCAL HOSTED FONTS
/––––––––––––––––––––––––-------------*/
function morph_preload_local_fonts() {
	$fonts = [
		// 'Inter' => [ 'woff2' ],
	];

	if ( empty( $fonts ) ) {
		return;
	}

	foreach ( $fonts as $name => $formats ) {
		foreach ( $formats as $format ) {
			$font_url = MORPH_FONTS_URI . '/' . $name . '.' . $format;

			printf(
				'<link rel="preload" href="%s" as="font" type="font/%s" crossorigin>' . PHP_EOL,
				esc_url( $font_url ),
				esc_attr( $format )
			);
		}
	}
}
add_action( 'wp_head', 'morph_preload_local_fonts', 1 );

/* 2.3 ENQUEUE GOOGLE FONTS
/––––––––––––––––––––––––-------------*/
function morph_get_google_fonts() {
	return [
		// 'Roboto:ital,wght@0,100..900;1,100..900',
	];
}

function morph_preconnect_google_fonts() {
	$fonts = morph_get_google_fonts();

	if ( empty( $fonts ) ) {
		return;
	}

	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . PHP_EOL;
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . PHP_EOL;
}
add_action( 'wp_head', 'morph_preconnect_google_fonts', 1 );

function morph_enqueue_google_fonts() {
	$fonts = morph_get_google_fonts();

	if ( empty( $fonts ) ) {
		return;
	}

	$fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $fonts ) . '&display=swap';

	wp_enqueue_style( 'morph-google-fonts', $fonts_url, [], null );
}
add_action( 'wp_enqueue_scripts', 'morph_enqueue_google_fonts' );




