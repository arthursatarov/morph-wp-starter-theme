<?php
/**
 * Get taxonomy terms data
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param int|null $post_id Post ID (null for current post)
 * @param string $taxonomy Taxonomy name (e.g., 'category', 'post_tag')
 * @param array $args {
 *     Optional. Array of arguments.
 *
 *     @type string $count 'all' or 'first' - Get all terms or only first one. Default 'all'.
 *     @type string $icon_field ACF field name for icon. Default empty string (no icon).
 *     @type bool $include_url Include term URL in result. Default true.
 * }
 * @return array|null Array with terms data or null if no terms found
 */
function morph_get_taxonomy_terms( $post_id = null, $taxonomy = 'category', $args = array() ) {
	// Default arguments
	$defaults = array(
		'count'       => 'all',      // 'all' or 'first'
		'icon_field'  => '',         // ACF field name for icon
		'include_url' => true,       // Include term URL
	);

	$args = wp_parse_args( $args, $defaults );

	// Get terms based on taxonomy type
	if ( $taxonomy === 'category' ) {
		// Use get_the_category() for standard post categories
		$terms = get_the_category( $post_id );
	} else {
		// Use get_the_terms() for custom taxonomies
		$terms = get_the_terms( $post_id, $taxonomy );
	}

	// Check if terms exist and valid
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	// If only first term needed, convert to single-item array
	if ( $args['count'] === 'first' ) {
		$terms = array( $terms[0] );
	}

	$result = array();

	foreach ( $terms as $term ) {
		$term_data = array(
			'id'   => $term->term_id,
			'name' => $term->name,
			'slug' => $term->slug,
		);

		// Add icon if ACF field specified
		if ( ! empty( $args['icon_field'] ) ) {
			$icon = get_field( $args['icon_field'], $taxonomy . '_' . $term->term_id );
			$term_data['icon'] = $icon;
		}

		// Add URL if needed
		if ( $args['include_url'] ) {
			if ( $taxonomy === 'category' ) {
				$term_data['url'] = get_category_link( $term->term_id );
			} else {
				$term_data['url'] = get_term_link( $term->term_id, $taxonomy );
			}
		}

		$result[] = $term_data;
	}

	// If 'first' count requested, return single array instead of array of arrays
	if ( $args['count'] === 'first' ) {
		return $result[0];
	}

	return $result;
}
