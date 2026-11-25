<?php 
if ( ! defined( 'ABSPATH' ) ) die( esc_html__( 'Direct access forbidden.', 'petrona' ) );

/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 */
load_theme_textdomain( 'petrona', get_template_directory() . '/languages' );

/**
 * Add default posts and comments RSS feed links to head.
 * @package Petrona
 * @since 1.0
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Let WordPress manage the document title.
 * By adding theme support, we declare that this theme does not use a
 * hard-coded <title> tag in the document head, and expect WordPress to
 * provide it for us.
 * @package Petrona
 * @since 1.0
 */
add_theme_support( 'title-tag' );

/**
 * Enable support for Post Thumbnails on posts and pages.
 * @package Petrona
 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
 * @since 1.0
 */
add_theme_support( 'post-thumbnails' );

/**
 * Enable support for register menu
 * @package Petrona
 * @since 1.0
 */
register_nav_menus( 
    array(
        'main-menu' => esc_html__( 'Main Menu', 'petrona' ),
    ) 
);

/**
 * Switch default core markup for search form, comment form, and comments to output valid HTML5.
 * @package Petrona
 * @since 1.0
 */
add_theme_support( 'html5', array(
    'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style',
    ) 
);

/**
 * Enable support for custom background.
 * @package Petrona
 * @since 1.0
 */
add_theme_support( 'custom-background', apply_filters( 'techt_custom_background_args', array (
    'default-color' => 'fff',
    'default-image' => '',
) ) );

/**
 * Enable support for custom Header Image.
 * @package Petrona
 * @since 1.0
 */
$args = array(
    'flex-width'    => true,
    'width'         => 1920,
    'flex-height'    => true,
    'height'        => 600,
);
add_theme_support( 'custom-header', $args );

/**
 * Enable support for custom Logo Image.
 * @package Petrona
 * @since 1.0
 */
// Custom logo.
$logo_width  = 120;
$logo_height = 60;

// If the retina setting is active, double the recommended width and height.
if ( get_theme_mod( 'retina_logo', false ) ) {
    $logo_width  = floor( $logo_width * 2 );
    $logo_height = floor( $logo_height * 2 );
}
$techt_custom_logo = array(
    'height'      => $logo_height,
    'width'       => $logo_width,
    'flex-height' => true,
    'flex-width'  => true,
);
add_theme_support( 'custom-logo', $techt_custom_logo );


/** 
 * Enable WP Responsive embedded content
 *
 * @since 1.0
 */
add_theme_support( 'responsive-embeds' );

/** 
 * Enable WP Gutenberg Align Wide
 *
 * @since 1.0
 */
add_theme_support( 'align-wide' );


/** 
 * Enable selective refresh for widgets.
 *
 * @since 1.0
 */
add_theme_support( 'customize-selective-refresh-widgets' );

/** 
 * Enable WP Gutenberg Block Style
 *
 * @since 1.0
 */
add_theme_support( 'wp-block-styles' );

/**
 * Add Editor Style
 *
 * @since 1.0
 */
// Add support for editor styles.
add_theme_support( 'editor-styles' );

/**
 * Enable support for custom Editor Style.
 *
 * @since 1.0
 */
add_editor_style( 'editor-style.css' );
