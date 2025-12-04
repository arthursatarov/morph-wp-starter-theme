<?php
/**
 * Print an SVG icon from sprite.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param array $args {
 *     Icon parameters.
 *
 *     @type string $icon        Required. Icon name (ID in sprite).
 *     @type string $class       Additional CSS classes. Default ''.
 *     @type string $size        Icon size (sm, md, lg, xl). Default ''.
 *     @type bool   $aria_hidden Whether icon is decorative. Default true.
 *     @type string $aria_label  Accessible label for screen readers. Default ''.
 *     @type string $title       Tooltip text. Default ''.
 *     @type string $role        ARIA role attribute. Default null.
 * }
 *
 * @return void
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function morph_print_sprite_icon( array $args ) {
	$args = wp_parse_args( $args, [
		'icon'        => null,
		'class'       => '',
		'size'        => '',
		'aria_hidden' => true,
		'aria_label'  => '',
		'title'       => '',
		'role'        => null,
	] );

	if ( empty( $args['icon'] ) ) {
		trigger_error( 'SVG icon name is required.', E_USER_WARNING );
		return;
	}

	$icon = sanitize_title( $args['icon'] );
	$size = sanitize_html_class( $args['size'] );

	// Build CSS classes: custom classes first, then base class, then modifiers
	$classes = [];

	// Add custom classes first
	if ( ! empty( $args['class'] ) ) {
		$custom_classes = array_filter( array_map( 'trim', explode( ' ', $args['class'] ) ) );
		$classes = array_merge( $classes, $custom_classes );
	}

	// Add base class
	$classes[] = 'icon';

	// Add size modifier last
	if ( ! empty( $size ) ) {
		$classes[] = "icon--{$size}";
	}

	$class_attr = esc_attr( implode( ' ', array_unique( $classes ) ) );
	$href = esc_url( MORPH_IMG_URI . "/sprite.svg#{$icon}" );

	// Build accessibility attributes
	$accessibility_attrs = [];

	if ( $args['aria_hidden'] ) {
		$accessibility_attrs[] = 'aria-hidden="true"';
		$accessibility_attrs[] = 'focusable="false"';
	} else {
		// Icon is meaningful, add semantic attributes
		$role = ! empty( $args['role'] ) ? $args['role'] : 'img';
		$accessibility_attrs[] = sprintf( 'role="%s"', esc_attr( $role ) );

		if ( ! empty( $args['aria_label'] ) ) {
			$accessibility_attrs[] = sprintf( 'aria-label="%s"', esc_attr( $args['aria_label'] ) );
		}
	}

	$accessibility_html = implode( ' ', $accessibility_attrs );

	// Generate unique ID for title element if provided
	$title_id = ! empty( $args['title'] ) ? 'icon-title-' . wp_unique_id() : '';

	if ( $title_id ) {
		$accessibility_html .= sprintf( ' aria-labelledby="%s"', esc_attr( $title_id ) );
	}
	?>
	<svg
		class="<?php echo $class_attr; ?>"
		width="16"
		height="16"
		<?php echo $accessibility_html; ?>
	>
		<?php if ( ! empty( $args['title'] ) ) : ?>
			<title id="<?php echo esc_attr( $title_id ); ?>"><?php echo esc_html( $args['title'] ); ?></title>
		<?php endif; ?>
		<use href="<?php echo $href; ?>"></use>
	</svg>
	<?php
}
