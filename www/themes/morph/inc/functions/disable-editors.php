<?php
/**
 * Editor Disabling Module
 *
 * Provides functionality to selectively disable both Gutenberg and Classic
 * editors for specific page templates and page IDs. Designed to work with
 * custom page templates that use ACF fields or custom layouts instead of
 * traditional content editors.
 *
 * Implements caching to minimize database queries and improve performance,
 * especially in multi-page admin contexts.
 *
 * @package MORPH
 * @since   1.0.0
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/*=======================================================
Table of Contents
–––––––––––––––––––––––––––––––––––––––––––––––––––––––––
	1.0 CONFIGURATION
		1.1 Excluded templates
		1.2 Excluded page IDs
	2.0 EDITOR STATE DETECTION
		2.1 Check if editors should be disabled
		2.2 Clear editor cache
	3.0 EDITOR DISABLING
		3.1 Disable Gutenberg
		3.2 Disable Classic Editor
	4.0 ADMIN UI
		4.1 Editor disabled notice
=======================================================*/


/*=======================================================
	1.0 CONFIGURATION
=======================================================*/

/* 1.1 EXCLUDED TEMPLATES
/––––––––––––––––––––––––-------------*/
/**
 * Get list of templates where editors should be disabled
 *
 * Returns an array of template file paths (relative to theme root) where both
 * Gutenberg and Classic editors should be disabled. This is useful for templates
 * that rely entirely on ACF fields or custom meta boxes.
 *
 * @since 1.0.0
 *
 * @return array<string> Array of template paths
 */
function morph_get_excluded_templates(): array {
	static $excluded_templates = null;

	// Use static cache to avoid repeated array initialization
	if ( null === $excluded_templates ) {
		// Hardcoded template paths where editors should be disabled
		$templates = [];

		/**
		 * Filters the list of templates where editors should be disabled.
		 *
		 * Allows themes or plugins to modify which templates have editors disabled.
		 * This is useful for child themes or when adding custom page templates.
		 *
		 * @package MORPH
		 * @since   1.0.0
		 *
		 * @param array<string> $templates Array of template paths relative to theme root.
		 */
		$excluded_templates = apply_filters( 'morph_excluded_templates', $templates );
	}

	return $excluded_templates;
}

/* 1.2 EXCLUDED PAGE IDS
/––––––––––––––––––––––––-------------*/
/**
 * Get list of page IDs where editors should be disabled.
 *
 * Returns an array of page IDs where both Gutenberg and Classic editors should
 * be disabled. By default, this includes the front page.
 *
 * @package MORPH
 * @since   1.0.0
 *
 * @return array<int> Array of page IDs (non-zero values only).
 */
function morph_get_excluded_page_ids(): array {
	static $excluded_ids = null;

	// Use static cache to avoid multiple get_option() calls
	if ( null === $excluded_ids ) {

		// Hardcoded page IDs where editors should be disabled
		$ids = [];

		// Add front page if it's set as static page
		$front_page = (int) get_option( 'page_on_front', 0 );
		if ( $front_page > 0 ) {
			$ids[] = $front_page;
		}

		// Remove duplicates in case front page is already in hardcoded list
		$ids = array_unique( $ids );

		/**
		 * Filters the list of page IDs where editors should be disabled.
		 *
		 * Allows themes or plugins to add or remove specific page IDs where
		 * editors should be disabled.
		 *
		 * @package MORPH
		 * @since   1.0.0
		 *
		 * @param array<int> $ids Array of page IDs.
		 */
		$excluded_ids = apply_filters( 'morph_excluded_page_ids', $ids );
	}

	return $excluded_ids;
}


/*=======================================================
	2.0 EDITOR STATE DETECTION
=======================================================*/

/* 2.1 CHECK IF EDITORS SHOULD BE DISABLED
/––––––––––––––––––––––––-------------*/
/**
 * Check if editors should be disabled for a given page.
 *
 * Determines whether Gutenberg and Classic editors should be disabled based on
 * the page's template or ID. Uses transient caching to improve performance on
 * repeated checks.
 *
 * The function checks:
 * 1. If the page ID matches any excluded IDs (e.g., front page)
 * 2. If the page template matches any excluded templates
 *
 * @package MORPH
 * @since   1.0.0
 *
 * @param int|string|null $post_id Page ID to check. Accepts int, numeric string, or null.
 * @return bool True if editors should be disabled, false otherwise.
 */
function morph_should_disable_editors( $post_id = null ): bool {
	// Early return for empty values
	if ( empty( $post_id ) ) {
		return false;
	}

	$post_id = absint( $post_id );

	// Additional validation
	if ( $post_id <= 0 ) {
		return false;
	}

	// Check transient cache first (cache for 12 hours)
	$cache_key = "morph_disable_editor_{$post_id}";
	$cached_value = get_transient( $cache_key );

	if ( false !== $cached_value ) {
		return (bool) $cached_value;
	}

	// Verify post exists and is a page
	$post = get_post( $post_id );
	if ( ! $post || 'page' !== $post->post_type ) {
		set_transient( $cache_key, 0, 12 * HOUR_IN_SECONDS );
		return false;
	}

	// Check if page ID is in excluded list
	$excluded_ids = morph_get_excluded_page_ids();
	if ( in_array( $post_id, $excluded_ids, true ) ) {
		set_transient( $cache_key, 1, 12 * HOUR_IN_SECONDS );
		return true;
	}

	// Check if template is in excluded list
	$template = get_page_template_slug( $post_id );
	$excluded_templates = morph_get_excluded_templates();

	$should_disable = in_array( $template, $excluded_templates, true );

	// Cache the result
	set_transient( $cache_key, $should_disable ? 1 : 0, 12 * HOUR_IN_SECONDS );

	return $should_disable;
}

/* 2.2 CLEAR EDITOR CACHE
/––––––––––––––––––––––––-------------*/
/**
 * Clear editor disable cache when page is updated.
 *
 * Clears the transient cache when a page is saved to ensure the editor state
 * is re-evaluated on next load. This is necessary when a page template is changed.
 *
 * @package MORPH
 * @since   1.0.0
 *
 * @param int $post_id Post ID that was updated.
 * @return void
 */
function morph_clear_editor_cache( int $post_id ): void {
	if ( 'page' === get_post_type( $post_id ) ) {
		delete_transient( "morph_disable_editor_{$post_id}" );
	}
}
add_action( 'save_post', 'morph_clear_editor_cache' );


/*=======================================================
	3.0 EDITOR DISABLING
=======================================================*/

/* 3.1 DISABLE GUTENBERG
/––––––––––––––––––––––––-------------*/
/**
 * Disable Gutenberg editor for specific templates.
 *
 * Hooks into Gutenberg's capability check to disable the block editor for
 * specific page templates and page IDs. This runs early in the admin init
 * process before the editor is loaded.
 *
 * @package MORPH
 * @since   1.0.0
 *
 * @param bool   $can_edit  Whether the post type can be edited with Gutenberg.
 * @param string $post_type The post type being checked.
 * @return bool False if editors should be disabled, original value otherwise.
 */
function morph_disable_gutenberg( bool $can_edit, string $post_type ): bool {
	// Only process for pages in admin context
	if ( 'page' !== $post_type || ! is_admin() ) {
		return $can_edit;
	}

	// Get post ID from request (safely)
	$post_id = filter_input( INPUT_GET, 'post', FILTER_VALIDATE_INT );

	if ( ! $post_id ) {
		return $can_edit;
	}

	// Check if editors should be disabled
	if ( morph_should_disable_editors( $post_id ) ) {
		return false;
	}

	return $can_edit;
}
add_filter( 'gutenberg_can_edit_post_type', 'morph_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'morph_disable_gutenberg', 10, 2 );

/* 3.2 DISABLE CLASSIC EDITOR
/––––––––––––––––––––––––-------------*/
/**
 * Disable Classic Editor for specific templates.
 *
 * Removes post type support for the 'editor' feature on pages where editors
 * should be disabled. This prevents the Classic Editor from displaying.
 *
 * Runs on admin_head to ensure screen object is available and after WordPress
 * has registered post type supports.
 *
 * @package MORPH
 * @since   1.0.0
 *
 * @return void
 */
function morph_disable_classic_editor(): void {
	$screen = get_current_screen();

	// Verify we're on a page edit screen
	if ( ! $screen || 'page' !== $screen->id ) {
		return;
	}

	// Get post ID from request (safely)
	$post_id = filter_input( INPUT_GET, 'post', FILTER_VALIDATE_INT );

	if ( ! $post_id ) {
		return;
	}

	// Check if editors should be disabled
	if ( morph_should_disable_editors( $post_id ) ) {
		remove_post_type_support( 'page', 'editor' );
	}
}
add_action( 'admin_head', 'morph_disable_classic_editor' );


/*=======================================================
	4.0 ADMIN UI
=======================================================*/

/* 4.1 EDITOR DISABLED NOTICE
/––––––––––––––––––––––––-------------*/
/**
 * Add admin notice when editor is disabled.
 *
 * Displays an informational notice in the admin when editing a page with
 * disabled editors. Helps users understand why the editor isn't available.
 *
 * @package MORPH
 * @since   1.0.0
 *
 * @return void
 */
function morph_editor_disabled_notice(): void {
	$screen = get_current_screen();

	if ( ! $screen || 'page' !== $screen->id ) {
		return;
	}

	$post_id = filter_input( INPUT_GET, 'post', FILTER_VALIDATE_INT );

	if ( ! $post_id || ! morph_should_disable_editors( $post_id ) ) {
		return;
	}

	?>
	<div class="notice notice-info">
		<p>
			<?php
			esc_html_e(
				'Редактор контента отключен для этого шаблона страницы. Используйте настраиваемые поля ниже для управления контентом страницы.',
				'morph'
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', 'morph_editor_disabled_notice' );
