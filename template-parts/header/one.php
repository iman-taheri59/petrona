<?php
/**
 * This template for displaying header part
 *
 * @package Petrona
 * @since 1.0
 */
/* ================================================== */
/**
 * Preloader
 * @package Petrona
 * @since 1.0
 */
techt_preloader(); 

/**
 * Header Part show/hide condition
 * @package Petrona
 * @since 1.0
 */
if( Techt_Utility::meta_options('header_show_header') == 'no' ) {
    return;
} ?>
<!-- Custom Header
================================================== --> 
<?php if( Techt_Utility::theme_options('header_type') == 'custom_header' && Techt_Utility::theme_options('header_templates') !== 'default' || Techt_Utility::meta_options('header_type')  ) : 
    get_template_part( "template-parts/header/custom-header" );
else : 
    get_template_part( "template-parts/header/content-header" );
endif;
?>
