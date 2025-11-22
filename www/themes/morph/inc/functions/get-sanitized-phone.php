<?php
/**
 * Cleans the phone number for use in href="tel:"
 * Removes all characters except numbers and +
 *
 * @param string $phone Phone number in any format
 * @return string Cleaned number for tel: links
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function morph_get_sanitized_phone($phone) {
    return preg_replace('/[^0-9+]/', '', $phone);
}
