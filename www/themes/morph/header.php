<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MORPH
 */

?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- WP_HEAD -->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!-- WP_BODY_OPEN -->
	<?php wp_body_open(); ?>

	<!-- HEADER -->
	<header class="header" id="header"></header>
