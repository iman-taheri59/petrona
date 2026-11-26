<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$this_theme = wp_get_theme();
if ( ! defined( 'TECHT_CORE_VERSION' ) ) {
	define( 'TECHT_CORE_VERSION', $this_theme->get( 'Version' ) );
}
/*
 * Never hard-code the theme folder name or ABSPATH layout: the theme may be
 * installed in a renamed folder (e.g. petrona-main from a GitHub ZIP), run from
 * a child theme, or use a custom WP_CONTENT_DIR. get_template_directory()
 * resolves all of those correctly.
 */
if ( ! defined( 'TECHT_MADULES_PATH' ) ) {
	define( 'TECHT_MADULES_PATH', get_template_directory() . '/inc/modules' );
}
if ( ! defined( 'TECHT_MADULES_URL' ) ) {
	define( 'TECHT_MADULES_URL', get_template_directory_uri() . '/inc/modules' );
}
if ( ! defined( 'TECHT_WIDGET_TEMPLATES_PATH' ) ) {
	define( 'TECHT_WIDGET_TEMPLATES_PATH', TECHT_MADULES_PATH . '/public/elementor/templates/' );
}

// require_once TECHT_MADULES_PATH . '/includes/class-techt-core-utility.php';
require_once TECHT_MADULES_PATH . '/includes/class-techt-core.php';

/**
 * @since    1.0.0
 */
function run_techt_core() {

	$plugin = new Techt_Core();
	$plugin->run();

}
run_techt_core();