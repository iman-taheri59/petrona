<?php 
if ( ! defined( 'ABSPATH' ) ) die( esc_html__( 'Direct access forbidden.', 'petrona' ) );

register_sidebar(  array(
    'name'          => esc_html__( 'Blog Sidebar', 'petrona' ),
    'description'   => esc_html__( 'This sidebar will show in blog page', 'petrona' ),
    'id'            => 'sidebar-blog',
    'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>',
) );

register_sidebar(  array(
    'name'          => esc_html__( 'Single Sidebar', 'petrona' ),
    'description'   => esc_html__( 'This sidebar will show in blog single page', 'petrona' ),
    'id'            => 'sidebar-single',
    'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s ">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>',
) );

register_sidebar(  array(
    'name'          => esc_html__( 'Page Sidebar', 'petrona' ),
    'description'   => esc_html__( 'This sidebar will show in page', 'petrona' ),
    'id'            => 'sidebar-page',
    'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s ">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h4 class="widget-title">',
    'after_title'   => '</h4>',
) );

$sidebar_woo = Techt_Utility::theme_options('woo_sidebar_display');
if ( class_exists( 'WooCommerce' ) && (isset($sidebar_woo) && $sidebar_woo !== 'full') ) {
    // Register new woo_sidebar widget area
    register_sidebar( array (
        'name'          => esc_html__( 'WooCommerce Sidebar', 'petrona' ),
        'id'            => 'woo_sidebar',
        'before_widget' => '<aside id="%1$s" class="widget sidebar-woocommerce %2$s clr">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
} 


$footer_widgets_num = count( techt_footer_widgets_layout_array() );
// only register if not 0
if ( $footer_widgets_num > 0 ) {
    register_sidebar(
        array(
            'name'          => esc_html_x( 'Footer', 'backend', 'petrona' ),
            'id'            => 'footer-widgets',
            'description'   => sprintf( esc_html_x( 'Footer area works best with %d widgets. This number can be changed in the Appearance &rarr; Customize &rarr; Footer Settings &rarr; Widget Settings.', 'backend', 'petrona' ), $footer_widgets_num ),
            'before_widget' => '<div class="col-sm-12 col-lg-%%d"><div id="%1$s" class="widget clearfix %2$s">', // %%d is replaced dynamically in filter 'dynamic_sidebar_params'
            'after_widget'  => '</div></div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        )
    );
} 