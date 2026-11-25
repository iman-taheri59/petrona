<?php
/**
 * One Click Demo Importer
 *
 * @package Petrona
 */

/**
 * add identical meta for imported demo 
 *
 * @package Petrona
 * @since 1.0
 */
add_action('wxr_importer.processed.post', 'techt_add_meta_to_post');
function techt_add_meta_to_post($post_id){
    $meta_value = array(
        'demo' => 'interior',
        'ver' => TECHT_CORE_VERSION
    );
    update_post_meta($post_id, 'petrona_demo', $meta_value);
}

add_action('admin_head', 'ocdi_styles');
function ocdi_styles() {
    echo '<style>
        .ocdi__theme-about-screenshots{
            margin-right: unset;
            margin-left: 30px;
        }
    </style>';
}
function techt_theme_ocdi_import_files() {
    return array(
        array(
            'import_file_name'           =>     esc_html__('Demo Content', 'petrona'),
            'import_file_url'            =>     esc_url('https://demo.technotheme.ir/petrona/interior/demo-contents/petrona-content.xml'),
            'import_widget_file_url'     =>     esc_url('https://demo.technotheme.ir/petrona/interior/demo-contents/petrona-widgets.wie'),
            'import_customizer_file_url' =>     esc_url('https://demo.technotheme.ir/petrona/interior/demo-contents/petrona-options.xml'),
            'import_preview_image_url'   =>     esc_url( get_theme_file_uri('screenshot.jpg') ),
            'import_notice'              =>     esc_html__( 'Before importing demo data you must have to install required plugins, Also ensure you are enable elementor svg upload Options form ( Elementor > Settings > Advance Tab ) Then Enable Unfiltered File Uploads.', 'petrona' ),
            'preview_url'                =>     esc_url('https://demo.technotheme.ir/petrona/interior'), 
        ), 
    );
}
add_filter( 'ocdi/import_files', 'techt_theme_ocdi_import_files' );


function techt_theme_ocdi_after_import_setup( $selected_import ) {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'اصلی', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'main-menu' => $main_menu->term_id,
        )
    );

    $front_page_id = get_posts(
        array(
            'post_type'              => 'page',
            'title'                  => 'خانه',
            'post_status'            => 'publish',
            'numberposts'            => 1,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,           
            'orderby'                => 'post_date ID',
            'order'                  => 'ASC',
            'fields'                 => 'ids',
        )
    );

    $blog_page_id = get_posts(
        array(
            'post_type'              => 'page',
            'title'                  => 'بلاگ',
            'post_status'            => 'publish',
            'numberposts'            => 1,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,           
            'orderby'                => 'post_date ID',
            'order'                  => 'ASC',
            'fields'                 => 'ids',
        )
    );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id);
    update_option( 'page_for_posts', $blog_page_id);

}
add_action( 'ocdi/after_import', 'techt_theme_ocdi_after_import_setup' );


function techt_theme_ocdi_plugin_page_setup( $default_settings ) {
    $default_settings['parent_slug'] = 'themes.php';
    $default_settings['page_title']  = esc_html__( 'Petrona Demo Import' , 'petrona' );
    $default_settings['menu_title']  = esc_html__( 'Demo Importer' , 'petrona' );
    $default_settings['capability']  = 'import';
    $default_settings['menu_slug']   = 'petrona-one-click-demo-import';

    return $default_settings;
}
add_filter( 'ocdi/plugin_page_setup', 'techt_theme_ocdi_plugin_page_setup' );

add_filter( 'ocdi/disable_pt_branding', '__return_true' );

add_filter( 'ocdi/importer_options', 'techt_theme_ocdi_importer_options' );
function techt_theme_ocdi_importer_options( $options ) {
    $options['aggressive_url_search'] = true;
    return $options;
}