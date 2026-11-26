<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Petrona
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php techt_schema_markup('html') ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php
        if ( function_exists( 'wp_body_open' ) ) {
            wp_body_open();
        }
        $theme_color_version = ( Techt_Utility::meta_options('enable_dark_background') == 'yes') ? 'dark' : Techt_Utility::theme_options('theme_background_status');
        if( $theme_color_version == 'dark' ) {
            $version_color = 'dark-version';
        } else {
            $version_color = 'light-version';
        }
    ?>
    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to the content', 'petrona' ) ?></a>
	<div class="techt-body <?php echo esc_attr( $version_color ); ?>">
		<?php do_action( 'techt_header_template' ); ?>
