<?php
/**
 * Print a simple tooltip element.
 *
 * @package MORPH
 * @since 0.0.1
 *
 * @param string|null $id      Tooltip ID. Auto-generated if null.
 * @param string      $content Tooltip text content.
 *
 * @return string Generated or provided tooltip ID.
 */
function morph_print_tooltip( $id = null, $content = '' ) {
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	if ( empty( $content ) ) {
		return '';
	}

	// Auto-generate ID if not provided
	if ( empty( $id ) ) {
		static $counter = 0;
		$id = 'tooltip-' . ++$counter;
	}

	?>
	<span id="<?php echo esc_attr( $id ); ?>" class="tooltip" role="tooltip">
		<?php echo esc_html( $content ); ?>
	</span>
	<?php

	return $id;
}
