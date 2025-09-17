<?php
/**
 * Theme setup
 *
 * @package MORPH
 */

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

