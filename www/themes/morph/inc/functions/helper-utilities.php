<?php
/**
 * Helper Utilities
 *
 * Collection of utility functions for debugging and environment detection.
 *
 * @package     MORPH
 * @since       0.0.1
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*=======================================================
Table of Contents
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
	1.0 DEBUGGING UTILITIES
	2.0 ENVIRONMENT DETECTION
=======================================================*/

/*=======================================================
  1.0 DEBUGGING UTILITIES
=======================================================*/

/* 1.1 DEBUG OUTPUT
/––––––––––––––––––––––––-------------*/
/**
 * Outputs a variable dump wrapped in pre tags for debugging.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param mixed $var Variable to debug.
 * @return void
 */
function morph_debug( $var ) {
	echo '<pre>';
	var_dump( $var );
	echo '</pre>';
}

/**
 * Outputs a variable dump wrapped in pre tags and terminates execution.
 *
 * Useful for debugging when you want to stop script execution
 * immediately after inspecting a variable.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param mixed $var Variable to debug.
 * @return void
 */
function morph_dd( $var ) {
	echo '<pre>';
	var_dump( $var );
	echo '</pre>';
	die();
}

/**
 * Outputs a formatted print_r() wrapped in pre tags for debugging.
 *
 * More readable alternative to var_dump() for arrays and objects.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param mixed $var Variable to print.
 * @return void
 */
function morph_pp( $var ) {
	echo '<pre>';
	print_r( $var );
	echo '</pre>';
}

/*=======================================================
  2.0 ENVIRONMENT DETECTION
=======================================================*/

/* 2.1 LOCALHOST CHECK
/––––––––––––––––––––––––-------------*/
/**
 * Checks whether the current environment is a local development environment.
 *
 * Detects local environments by checking for common localhost indicators
 * in the hostname and WordPress environment constants.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @return bool True if running on localhost, false otherwise.
 */
function morph_is_localhost() {
	$local_indicators = array(
		'localhost',
		'127.0.0.1',
		'::1',
		'.local',
		'.test',
		'.dev',
		'.docker'
	);

	$host = $_SERVER['HTTP_HOST'] ?? '';

	// Check hostname against local indicators
	foreach ( $local_indicators as $indicator ) {
		if ( strpos( $host, $indicator ) !== false ) {
			return true;
		}
	}

	// Support for standard WordPress constants
	if ( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE !== 'production' ) {
		return true;
	}

	return false;
}
