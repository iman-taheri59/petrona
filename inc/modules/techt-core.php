<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$this_theme = wp_get_theme();
define( 'TECHT_CORE_VERSION', $this_theme->get( 'Version' ) );
define( 'TECHT_MADULES_PATH', ABSPATH . 'wp-content/themes/petrona/inc/modules' );
define( 'TECHT_MADULES_URL', get_parent_theme_file_uri() . '/inc/modules' );
define( 'TECHT_WIDGET_TEMPLATES_PATH', TECHT_MADULES_PATH . '/public/elementor/templates/' );

// require_once TECHT_MADULES_PATH . '/includes/class-techt-core-utility.php';
require_once TECHT_MADULES_PATH . '/includes/class-techt-core.php';

// include_once TECHT_MADULES_PATH . '/includes/ion-checker.php';
// if (!empty($ioncube_error_checker)){
//     add_action('admin_notices', function () use ($ioncube_error_checker){printf('<div class="notice notice-error notice-alt"> <p>%s</p> </div>',implode('<hr>',$ioncube_error_checker));},1);
//     return;
// }


/**
 * @since    1.0.0
 */
function run_techt_core() {

	$plugin = new Techt_Core();
	$plugin->run();

}
run_techt_core();