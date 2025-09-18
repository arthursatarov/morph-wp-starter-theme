<?php
/**
 * Theme setup
 *
 * @package MORPH
 */

/*==================================================================================
	Table of Contents:
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
  1.0 THEME SETUP
		1.1. REGISTER MENUS
		1.2. THEME SUPPORT
  2.0 UTILITIES / TWEAKS
		2.1. WPHEAD CLEANUP
==================================================================================*/

add_action( 'after_setup_theme', 'morph_register_menus' );
add_action( 'after_setup_theme', 'morph_theme_support' );
add_action( 'after_setup_theme', 'morph_wphead_cleanup' );

/*==================================================================================
  1.0. THEME SETUP
==================================================================================*/

/* 1.1. REGISTER MENUS
/––––––––––––––––––––––––*/
function morph_register_menus() {
	register_nav_menus(
		array(
			'main_menu' => esc_html__( 'Main menu', 'morph' ),
		)
	);
}

/* 1.2. THEME SUPPORT
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

/*==================================================================================
  2.0. UTILITIES / TWEAKS
==================================================================================*/

/* 2.1. WP-HEAD CLEANUP
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
