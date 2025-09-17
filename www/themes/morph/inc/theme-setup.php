<?php
/**
 * Theme setup
 *
 * @package MORPH
 */

add_action( 'after_setup_theme', 'morph_register_theme_menus' );

/* REGISTER MENUS
/––––––––––––––––––––––––*/
function morph_register_theme_menus() {
	register_nav_menus(
		array(
			'main_menu' => esc_html__( 'Main menu', 'morph' ),
		)
	);
}

