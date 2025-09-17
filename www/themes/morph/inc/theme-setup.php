<?php
/**
 * Theme setup
 *
 * @package MORPH
 */

add_action( 'after_setup_theme', 'morph_theme_support' );
add_action( 'after_setup_theme', 'morph_register_theme_menus' );
add_action( 'wp_enqueue_scripts', 'morph_enqueue_assets' );

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
