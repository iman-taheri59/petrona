<?php
/**
 * Petrona functions and definitions
 *
 * @package Petrona
 * @since 1.0
 */

/**
 * Include Demo Content
 * @since 1.0
 */
require get_parent_theme_file_path( '/inc/functions/demo-content.php' );

/**
 * Include Frontend_Master Class
 */
require get_parent_theme_file_path( '/inc/classes/frontend/master.php' );

/**
 * Include Backend_Master Class
 */
require get_parent_theme_file_path( '/inc/classes/backend/backend_master.php' );

/**
 * Include Backend_Master Class
 */
require get_parent_theme_file_path( '/inc/classes/static.php' );

/**
 * Include the Redux theme options framework
 */
require get_parent_theme_file_path( '/inc/functions/template-functions.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/functions/template-tags.php' );

require get_parent_theme_file_path('/inc/functions/font-functions.php');

/**
 * Include Custom Setting Options
 */
require get_parent_theme_file_path( '/inc/admin/settings.php' );
    
/**
 * Load Jetpack compatibility file.
 */
require get_parent_theme_file_path( '/inc/functions/jetpack.php' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require get_parent_theme_file_path( '/inc/libs/tgm-plugin-activation/tgm-admin-config.php' );

/**
 * WordPress comment seciton override 
 */
require get_parent_theme_file_path( '/inc/functions/wp-comment-section-override.php' );

/**
 * Query function to get post
 */
require get_parent_theme_file_path( '/inc/functions/function-for-post.php' );

/**
 * Include CSS Helpers
 */
require get_parent_theme_file_path( '/inc/frontend/helpers.php' );

/**
 * Include Functionalities
 */
require get_parent_theme_file_path( '/inc/modules/techt-core.php' );

/**
 * Include WooCommmerce
 */
require get_parent_theme_file_path( '/woocommerce/woo-functions.php' );