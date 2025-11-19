<?php
/**
 * Central configuration and function loader for the MORPH theme.
 * This file defines all global constants (paths, URIs, version) and
 * includes all core functionality files located in the /inc directory.
 *
 * @package MORPH
 */

/*=======================================================
Table of Contents
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
	1.0 GLOBAL CONSTANTS
		1.1 theme info
		1.2 theme directory paths
	2.0 THEME INCLUDES
=======================================================*/


/*=======================================================
	1.0 GLOBAL CONSTANTS
=======================================================*/

/* 1.1 THEME INFO
/––––––––––––––––––––––––-------------*/
define( 'MORPH_THEME_VERSION', wp_get_theme()->get( 'Version' ) );

/* 1.2 THEME PATHS
/––––––––––––––––––––––––-------------*/
define( 'MORPH_THEME_DIR', get_template_directory() );
define( 'MORPH_THEME_URI', get_template_directory_uri() );
// Fonts
define( 'MORPH_FONTS_DIR', MORPH_THEME_DIR . '/assets/fonts' );
define( 'MORPH_FONTS_URI', MORPH_THEME_URI . '/assets/fonts' );
// Images
define( 'MORPH_IMG_DIR', MORPH_THEME_DIR . '/assets/images' );
define( 'MORPH_IMG_URI', MORPH_THEME_URI . '/assets/images' );
// Styles
define( 'MORPH_STYLES_DIR', MORPH_THEME_DIR . '/assets/styles' );
define( 'MORPH_STYLES_URI', MORPH_THEME_URI . '/assets/styles' );
// Scripts
define( 'MORPH_SCRIPTS_DIR', MORPH_THEME_DIR . '/assets/scripts' );
define( 'MORPH_SCRIPTS_URI', MORPH_THEME_URI . '/assets/scripts' );

/*=======================================================
	2.0 THEME INCLUDES
=======================================================*/
function morph_load_theme_files() {
	$files = [
		'inc/functions',
		'inc/hooks',
		'inc/template-tags',
		'inc/setup.php',
	];

	foreach ( $files as $include ) {
		// Build full path to the file or directory
		$include = trailingslashit( MORPH_THEME_DIR ) . $include;

		if ( is_dir( $include ) ) {
			// Get all PHP files from directory
			$php_files = glob( trailingslashit( $include ) . '*.php' );

			// Check if glob() returned any files
			if ( $php_files ) {
				foreach ( $php_files as $file ) {
					require_once $file;
				}
			}
		} elseif ( file_exists( $include ) ) {
			// Include single file if it exists
			require_once $include;
		}
	}
}
morph_load_theme_files();
