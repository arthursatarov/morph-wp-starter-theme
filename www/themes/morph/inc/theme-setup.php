<?php
/**
 * Theme setup
 *
 * @package MORPH
 */

add_action( 'after_setup_theme', 'morph_theme_support' );
add_action( 'after_setup_theme', 'morph_register_theme_menus' );
add_action( 'wp_enqueue_scripts', 'morph_enqueue_assets' );
add_action( 'wp_head', 'morph_preload_local_fonts' );
add_action( 'wp_head', 'morph_preconnect_google_fonts', 1 );
add_action( 'after_setup_theme', 'morph_wphead_cleanup' );

/* REGISTER MENUS
/––––––––––––––––––––––––*/
function morph_register_theme_menus() {
	register_nav_menus(
		array(
			'main_menu' => esc_html__( 'Main menu', 'morph' ),
		)
	);
}

/* ENQUEUE STYLES/SCRIPTS
/––––––––––––––––––––––––*/
function morph_enqueue_assets() {
	// styles
	wp_enqueue_style( 'morph', MORPH_THEME_URI . '/assets/styles/main.css', array(), MORPH_THEME_VERSION, 'all' );

	// scripts
	wp_enqueue_script( 'morph', MORPH_THEME_URI . '/assets/scripts/main.js', array(), MORPH_THEME_VERSION, true );
}

/* PRELOAD LOCAL FONTS
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

/* PRECONNECT GOOGLE FONTS
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

/* THEME SUPPORT
/––––––––––––––––––––––––*/
// registers support for WordPress features
function morph_theme_support() {
	// allow WordPress to manage the <title> tag automatically.
	// => https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
	add_theme_support( 'title-tag' );

	// enable automatic RSS feed links in <head>.
	// => https://developer.wordpress.org/reference/functions/add_theme_support/#automatic-feed-links
	add_theme_support( 'automatic-feed-links' );

	// enable featured images (post thumbnails) for posts and pages.
	// => https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	add_theme_support( 'post-thumbnails' );

	// use valid HTML5 markup for various components.
	// => https://developer.wordpress.org/reference/functions/add_theme_support/#html5
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

/* WP-HEAD CLEANUP
/––––––––––––––––––––––––*/
// cleans up default <head> output for performance and security
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
