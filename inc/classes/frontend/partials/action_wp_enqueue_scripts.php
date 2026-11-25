<?php
/**
 * Front-End CSS and Scripts Files
 * @package Petrona
 * @since 1.0
 */ 
if ( ! defined( 'ABSPATH' ) ) die( esc_html__( 'Direct access forbidden.', 'petrona' ) );

$resource_minification = Techt_Utility::theme_options('combine_resource' );

if(defined ('SCRIPT_DEBUG')){
    if(SCRIPT_DEBUG){
        $suffix = '';
    }else{
        $suffix = '.min';
    }
}else{
    $suffix = '.min';
}
// $ltr = ! is_rtl() ? '-ltr' : '';
$ltr = '';
// enqueue styles
if( $resource_minification == true ) {
	wp_enqueue_style( 'petrona-all-style', get_theme_file_uri( '/assets/css/all-plugin-css.min.css' ) );
} else {
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ) );
	wp_enqueue_style( 'font-awesome-5-all', get_theme_file_uri( '/assets/css/fontawesome.min.css' ) );
	wp_enqueue_style( 'techt-icons', get_theme_file_uri( '/assets/css/techt-icons.min.css' ) );
	wp_enqueue_style( 'flaticons', get_theme_file_uri( '/assets/css/flaticon.min.css' ) );
	wp_enqueue_style( 'magnific-popup', get_theme_file_uri( '/assets/css/magnific-popup.min.css' ) );
	// wp_enqueue_style( 'odometer-theme', get_theme_file_uri( '/assets/css/odometer-theme-default'. $suffix .'.css' ) );
}
wp_enqueue_style( 'petrona-style', get_theme_file_uri( '/assets/css/style'. $ltr  . '.css' ) );

wp_enqueue_style( 'petrona-main-style', get_stylesheet_uri() );

// enqueue scripts
if( $resource_minification == true ) {
	wp_enqueue_script( 'petrona-all-plugin', get_theme_file_uri( '/assets/js/all-plugin.min.js' ), array('jquery'), false, true);
} else {
	wp_enqueue_script( 'isInViewport', get_theme_file_uri( '/assets/js/isInViewport.jquery.min.js' ), array('jquery'), false, true);
	wp_enqueue_script( 'isotope', get_theme_file_uri( '/assets/js/isotope.pkgd.min.js' ), array('jquery'), false, true);
	wp_enqueue_script( 'packery-mode', get_theme_file_uri( '/assets/js/packery-mode.pkgd.min.js' ), array('jquery'), false, true);
	wp_enqueue_script( 'magnific-popup', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array('jquery'), false, true);
	wp_enqueue_script( 'scrolla', get_theme_file_uri( '/assets/js/scrolla.jquery.min.js' ), array('jquery'), false, true);
	wp_enqueue_script( 'theia-sticky-sidebar', get_theme_file_uri( '/assets/js/theia-sticky-sidebar.min.js' ), array('jquery'), false, true);
	wp_enqueue_script( 'tweenmax', get_theme_file_uri( '/assets/js/TweenMax.min.js' ), array('jquery'), false, true);
}
wp_enqueue_script( 'petrona-main', get_theme_file_uri( '/assets/js/main.js' ), array('jquery', 'masonry'), false, true);

// localize scripts
wp_localize_script('petrona-main', 'petrona', array (
        'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
        "please_wait_text" => esc_html__('Please wait...', 'petrona' ),
        "no_more_post_text" => esc_html__('No More Posts', 'petrona' ),
        "no_more_post_to_load_text" => esc_html__('No More Posts To Load', 'petrona' ),
        "load_more_post_text" => esc_html__('Load More Posts', 'petrona' ),
        'blog_layout' => Techt_Utility::theme_options(array('blog_layout_display', 'list')),
        'enable_custom_scroll' => Techt_Utility::theme_options('custom_scrollbar'),
    )
);

// Comment Reply Scripts
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
}
