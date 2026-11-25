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

wp_enqueue_style( 'petrona-style', get_theme_file_uri( '/assets/admin/css/style' . '.css' ) );