<?php

define( 'MORPH_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'MORPH_THEME_DIR', get_template_directory() );
define( 'MORPH_THEME_URI', get_template_directory_uri() );

/*==================================================================================
  THEME SETUP
==================================================================================*/
require_once MORPH_THEME_DIR . '/inc/setup/theme-setup.php';
require_once MORPH_THEME_DIR . '/inc/setup/theme-assets.php';

/*==================================================================================
  HOOKS
==================================================================================*/
require_once MORPH_THEME_DIR . '/inc/hooks/body-classes.php';
