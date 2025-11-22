<?php
/**
 * Google Tag Manager Integration
 *
 * All analytics systems (Google Analytics, Yandex Metrica, etc.)
 * are configured inside GTM, not in the theme code.
 *
 * ACF field (Options Page):
 * - site_gtm_id (Text) - Google Tag Manager ID (GTM-XXXXXXX)
 *
 * @param string $position Output position: 'head' or 'body'
 * @return void
 */
function morph_google_tag_manager( $position = 'head' ) {
	// Don't output on local environment
	if ( morph_is_localhost() ) {
		return;
	}

	// Get GTM ID from settings
	$gtm_id = get_field('site_gtm_id', 'option');

	// If GTM ID is not set - don't output anything
	if ( empty( $gtm_id ) ) {
		return;
	}

	// Output corresponding GTM code
	if ( $position === 'head' ) {
		?>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','<?= esc_js($gtm_id) ?>');</script>
		<!-- End Google Tag Manager -->
		<?php
	} elseif ( $position === 'body' ) {
		?>
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= esc_attr($gtm_id) ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		<?php
	}
}
add_action( 'wp_head', function () {
	morph_google_tag_manager( 'head' );
}, 1 );

add_action( 'wp_body_open', function () {
	morph_google_tag_manager( 'body' );
}, 1 );
