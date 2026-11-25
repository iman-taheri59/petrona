<?php
/**
 * This template Predefine Header Template
 *
 * @package Petrona
 * @since 1.0
 */
$header_class = array('site-header');
if( techt_header_transparent() == 'yes' ) {
    $header_class[] = 'header-transparent';
} 

if( techt_header_sticky() == 'yes' ) {
    $header_class[] = 'sticky-header';
} ?>

<!-- Predefine Header
================================================== --> 
<header class="<?php echo esc_attr( join(' ',$header_class) ); ?>"<?php techt_schema_markup('header') ?>>
    <div class="<?php echo esc_attr( ( techt_header_width() == 'yes') ? 'container-fluid' : 'container' ); ?>">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="header-left-block">
                    <!-- Site Branding --> 
                    <?php if( Techt_Utility::meta_options('header_logo_main') !== false && Techt_Utility::meta_options('header_logo_main') !== '' ) { ?>
                    <div class="site-branding"<?php techt_schema_markup('logo') ?>>
                    
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
                            <img loading="lazy" class="custom-logo" src="<?php echo esc_url( Techt_Utility::meta_options('header_logo_main') ); ?>" alt="<?php echo esc_attr__('Site Logo', 'petrona'); ?>" />
                        </a>
                    </div><!--  /.site-branding -->
                    <?php } elseif ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { ?>
                        <div class="site-branding"<?php techt_schema_markup('logo') ?>>
                            <?php the_custom_logo(); ?>
                        </div><!--  /.site-branding -->
                    <?php } else { 
                        if ( function_exists( 'display_header_text' ) ) { 
                            if( display_header_text() == true ) { ?>
                            <div class="site-branding">
                                <div class="site-branding-text">
                                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                    <?php $description = get_bloginfo( 'description', 'display' );
                                    if ( $description || is_customize_preview() ) : ?>
                                    <p class="site-description"><?php echo esc_html($description); ?></p>
                                    <?php endif; ?>
                                </div><!-- .site-branding-text -->
                            </div><!--  /.site-branding -->
                            <?php }
                        }
                    } ?>
                </div><!--  /.header-left-block -->
            </div><!--  /.col-md-3 -->

            <div class="col-6 col-md-9">
                <!-- Site Navigation -->
                <div class="site-navigation">
                    <nav class="navigation"<?php techt_schema_markup('site_navigation') ?>>
                        <div class="overlaybg"></div><!--  /.overlaybg -->
                        <div class="menu-wrapper">
                            <div class="menu-content">
                                <!-- Main Menu -->
                                <?php if( Techt_Utility::meta_options('header_page_menu') ) {
                                        wp_nav_menu ( array(
                                            'menu_class' => 'mainmenu',
                                            'container'=> 'ul',
                                            'menu' => Techt_Utility::meta_options('header_page_menu'),
                                            'theme_location' => 'main-menu',  
                                        )); 
                                    } else {
                                        wp_nav_menu ( array(
                                            'menu_class' => 'mainmenu',
                                            'container'=> 'ul',
                                            'theme_location' => 'main-menu',  
                                        )); 
                                    }
                                ?>
                                <div class="hamburger-menu hamburger-mobile">
                                    <a href="#" class="menu-indicator">
                                        <span class="hamburger-content"></span>
                                    </a>
                                </div><!--  /.hamburger-menu -->
                            </div> <!-- /.hours-content-->
                        </div><!-- /.menu-wrapper -->
                    </nav>
                </div><!--  /.site-navigation -->
            </div><!--  /.col-md-9 -->
        </div><!--  /.row -->
        
    </div><!--  /.container-fluid -->
</header><!-- /.site-header -->

<div class="disable-content-menu"></div>