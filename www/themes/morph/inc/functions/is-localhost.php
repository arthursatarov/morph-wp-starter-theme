<?php
/**
 * Checking whether the current environment is a local development
 *
 * @return bool
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
