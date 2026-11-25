<?php
/**
 * Petrona CSS Helpers
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if(! class_exists( 'Techt_CSS_Helpers' ) ) {
    
    class Techt_CSS_Helpers {

        public static $petrona_colors = array(
            'header_background_colors' => '#ffffff',
            'header_border_colors' => '#e4e0d8',
            'theme_color'          => 'var(--color-primary-1)',
            'theme_secondary_color'=> 'var(--color-secondary-1)',
            'theme_link_hover'     => '#fe651f',
            'theme_cover_color'     => '#331e00',
            'theme_text_color'   => '#202020',
            'theme_text_dark_color' => '#b0b0b0',
            'theme_input_border' =>'#e4e0d8',
            'theme_preloader_bg' => '#ffffff',
            'theme_preloader_color_1' => 'var(--color-primary-1)',
            'theme_preloader_color_2' => 'var(--color-secondary-1)',
            'theme_preloader_color_3' => 'var(--color-primary-2)',
            'theme_background_light_color'=> '#ffffff',
            'theme_background_dark_color' => '#272727',
            'site_branding_color' => '#000000',
            'site_description_color' => '#858585',
            'menu_color'   => '#252424',
            'main_menu_hover_color' => '#313131',
            'main_menu_separator_color' => '#fe651f',
            'dropdown_menu_bg' => '#080d18',
            'dropdown_menu_color' => '#f7f7f7',
            'mobile_menu_color' => '#f7f7f7',
            'mobile_menu_bg' => '#12141c',
            'mobile_menu_hamburger_color' => '#12141c',
            'footer_bg_colors' => '#0f0d80',
            'footer_top_border_color' => '#333333',
            'footer_color' => '#505050',
            'footer_widget_title' => '#101010',
            'footer_link_color' => '#505050',
            'footer_link_hover_color' => '#fe651f',
            'footer_copy_color' => '#5e5e5e',
            'footer_copy_border_top' => '#ebebeb',
            'body_font_color' => '#434343',
            'heading_font_color' => '#101010',
            'portfolio_details_bg_color'=> '#0f0d80',
            'portfolio_details_title_color'=> '#fe651f',
        );
        
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        public function __construct() {
            add_action( 'wp_enqueue_scripts', array( $this, 'techt_spaing_elements' ), 300 );
        }

        /**
         * Hexa to RGBA Convector
         *
         * @package Petrona
         * @since 1.0
         */
        private function techt_hex_2_rgba($color, $opacity = false) {
            $default = 'rgb(0,0,0)';
            //Return default if no color provided
            if(empty($color))
                return $default; 
         
            //Sanitize $color if "#" is provided 
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }
         
            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }
         
            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);
         
            //Check if opacity is set(rgba or rgb)
            if($opacity){
                if(abs($opacity) > 1)
                    $opacity = 1.0;
                $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }
         
            //Return rgb(a) color string
            return $output;
        }

        /**
         * Theme Dynamic CSS
         *
         * @package Petrona
         * @since 1.0
         */
        public function techt_spaing_elements( $css ) {
            //Typography

            if(is_rtl()){
                $body_font = Techt_Utility::theme_options( array('body_font', 'Vazir' ) );
                $site_title_font = Techt_Utility::theme_options( array('site_title_font', 'Vazir' ) );
                $site_form_fields = Techt_Utility::theme_options( array('input_form', 'Vazir' ) );
                $site_button = Techt_Utility::theme_options( array('button_typo', 'Vazir' ) );
                $headings_font = Techt_Utility::theme_options( array('headings_font', 'Vazir' ) );
                $breadcrumb_font = Techt_Utility::theme_options( array('breadcrumb_font', 'VazirFD' ) );
            }else{
                $body_font = Techt_Utility::theme_options( array('body_font', 'Roboto Slab' ) );
                $site_title_font = Techt_Utility::theme_options( array('site_title_font', 'Poppins' ) );
                $site_form_fields = Techt_Utility::theme_options( array('input_form', 'Roboto Slab' ) );
                $site_button = Techt_Utility::theme_options( array('button_typo', 'Poppins' ) );
                $headings_font = Techt_Utility::theme_options( array('headings_font', 'Poppins' ) );
                $breadcrumb_font = Techt_Utility::theme_options( array('breadcrumb_font', 'Poppins' ) );
            }
            
            $body_font_color = Techt_Utility::theme_options( array('body_font_color', '#434343' ) );

            $site_title_font_color = Techt_Utility::theme_options( array('site_branding_color', '#000000' ) );
            $site_description_font_color = Techt_Utility::theme_options( array('site_description_color', '#858585' ) );

            $techt_color = Techt_Utility::theme_options(array('theme_color', '#fe651f'));
            $techt_text_color = Techt_Utility::theme_options(array('theme_text_color', '#202020'));
            
            //rgba color
            $techt_rgba_color = $this->techt_hex_2_rgba($techt_color, 0.90);

            $techt_secondary_color = Techt_Utility::theme_options(array('theme_secondary_color', self::$petrona_colors['theme_secondary_color']));
        
            $techt_link_hover_color = Techt_Utility::theme_options( array( 'theme_link_hover', self::$petrona_colors['theme_link_hover'] ) );

            $techt_cover_color = Techt_Utility::theme_options( array( 'theme_cover_color', self::$petrona_colors['theme_cover_color'] ) );

            $techt_portfolio_details_bg_color = Techt_Utility::theme_options( array( 'portfolio_details_bg_color', self::$petrona_colors['portfolio_details_bg_color'] ) );
            $techt_input_border = Techt_Utility::theme_options( array( 'theme_input_border', self::$petrona_colors['theme_input_border'] ) );
            //Blog Wrapper Padding
            $blog_wrap_desktop_top = Techt_Utility::theme_options( array('top_padding', 40) );
            $blog_wrap_desktop_bottom = Techt_Utility::theme_options( array('bottom_padding', 40) );            
            $blog_wrap_tablet_top = Techt_Utility::theme_options( array('tablet_top_padding', 40) );
            $blog_wrap_tablet_bottom = Techt_Utility::theme_options( array('tablet_bottom_padding', 40) );
            $blog_wrap_mobile_top = Techt_Utility::theme_options( array('mobile_top_padding', 40) );
            $blog_wrap_mobile_bottom = Techt_Utility::theme_options( array('mobile_bottom_padding', 40) );            

            //Single Post Wrapper Padding
            $blog_single_wrap_desktop_top = Techt_Utility::theme_options( array('blog_single_top_padding', 50) );
            $blog_single_wrap_desktop_bottom = Techt_Utility::theme_options( array('blog_single_bottom_padding', 30) );            
            $blog_single_wrap_tablet_top = Techt_Utility::theme_options( array('blog_single_tablet_top_padding', 50) );
            $blog_single_wrap_tablet_bottom = Techt_Utility::theme_options( array('blog_single_tablet_bottom_padding', 30) );
            $blog_single_wrap_mobile_top = Techt_Utility::theme_options( array('blog_single_mobile_top_padding', 50) );
            $blog_single_wrap_mobile_bottom = Techt_Utility::theme_options( array('blog_single_mobile_bottom_padding', 30) );            

            //Single Post Content Margin
            $blog_single_content_mr_desktop_top = Techt_Utility::theme_options( array('blog_single_top_margin', 0) );
            $blog_single_content_mr_desktop_bottom = Techt_Utility::theme_options( array('blog_single_bottom_margin', 0) );            
            $blog_single_content_mr_tablet_top = Techt_Utility::theme_options( array('blog_single_tablet_top_margin', 0) );
            $blog_single_content_mr_tablet_bottom = Techt_Utility::theme_options( array('blog_single_tablet_bottom_margin', 0) );
            $blog_single_content_mr_mobile_top = Techt_Utility::theme_options( array('blog_single_mobile_top_margin', 0) );
            $blog_single_content_mr_mobile_bottom = Techt_Utility::theme_options( array('blog_single_mobile_bottom_margin', 0) );

            //Page Wrapper Padding
            $page_wrap_desktop_top = Techt_Utility::theme_options( array('page_content_top_padding', 60) );
            $page_wrap_desktop_bottom = Techt_Utility::theme_options( array('page_content_bottom_padding', 40) );            
            $page_wrap_tablet_top = Techt_Utility::theme_options( array('page_content_tablet_top_padding', 60) );
            $page_wrap_tablet_bottom = Techt_Utility::theme_options( array('page_content_tablet_bottom_padding', 40) );
            $page_wrap_mobile_top = Techt_Utility::theme_options( array('page_content_mobile_top_padding', 40) );
            $page_wrap_mobile_bottom = Techt_Utility::theme_options( array('page_content_mobile_bottom_padding', 60) );

            //Logo Padding
            $logo_desktop_top = Techt_Utility::theme_options( 'logo_top_padding' );
            $logo_desktop_bottom = Techt_Utility::theme_options( 'logo_bottom_padding');
            $logo_tablet_top = Techt_Utility::theme_options( 'logo_tablet_top_padding');
            $logo_tablet_bottom = Techt_Utility::theme_options( 'logo_tablet_bottom_padding');
            $logo_mobile_top = Techt_Utility::theme_options( 'logo_mobile_top_padding');
            $logo_mobile_bottom = Techt_Utility::theme_options( 'logo_mobile_bottom_padding');  

            //Footer Padding
            $footer_desktop_top = Techt_Utility::theme_options( array('footer_top_padding', 0) );
            $footer_desktop_bottom = Techt_Utility::theme_options( array('footer_bottom_padding', 0) );
            $footer_tablet_top = Techt_Utility::theme_options( array('footer_tablet_top_padding', 0) );
            $footer_tablet_bottom = Techt_Utility::theme_options( array('footer_tablet_bottom_padding', 0) );
            $footer_mobile_top = Techt_Utility::theme_options( array('footer_mobile_top_padding', 0) );
            $footer_mobile_bottom = Techt_Utility::theme_options( array('footer_mobile_bottom_padding', 0) );

            //Single Portfolio Wrapper Padding
            $blog_single_wrap_desktop_top = Techt_Utility::theme_options( array('portfolio_single_top_padding', 50) );
            $blog_single_wrap_desktop_bottom = Techt_Utility::theme_options( array('portfolio_single_bottom_padding', 30) );            
            $blog_single_wrap_tablet_top = Techt_Utility::theme_options( array('portfolio_single_tablet_top_padding', 50) );
            $blog_single_wrap_tablet_bottom = Techt_Utility::theme_options( array('portfolio_single_tablet_bottom_padding', 30) );
            $blog_single_wrap_mobile_top = Techt_Utility::theme_options( array('portfolio_single_mobile_top_padding', 50) );
            $blog_single_wrap_mobile_bottom = Techt_Utility::theme_options( array('portfolio_single_mobile_bottom_padding', 30) );            

            //Single Portfolio Content Margin
            $blog_single_content_mr_desktop_top = Techt_Utility::theme_options( array('portfolio_single_top_margin', 0) );
            $blog_single_content_mr_desktop_bottom = Techt_Utility::theme_options( array('portfolio_single_bottom_margin', 0) );            
            $blog_single_content_mr_tablet_top = Techt_Utility::theme_options( array('portfolio_single_tablet_top_margin', 0) );
            $blog_single_content_mr_tablet_bottom = Techt_Utility::theme_options( array('portfolio_single_tablet_bottom_margin', 0) );
            $blog_single_content_mr_mobile_top = Techt_Utility::theme_options( array('portfolio_single_mobile_top_margin', 0) );
            $blog_single_content_mr_mobile_bottom = Techt_Utility::theme_options( array('portfolio_single_mobile_bottom_margin', 0) );

            $css = '';

            $content_padding_css = '';
            $tablet_content_padding_css = '';
            $mobile_content_padding_css = '';    

            $single_content_padding_css = '';
            $single_tablet_content_padding_css = '';
            $single_mobile_content_padding_css = '';                

            $single_content_margin_css = '';
            $single_tablet_content_margin_css = '';
            $single_mobile_content_margin_css = '';            

            $page_content_padding_css = '';
            $page_tablet_content_padding_css = '';
            $page_mobile_content_padding_css = '';

            $logo_desktop_padding_css = '';
            $logo_tablet_padding_css = '';
            $logo_mobile_padding_css = '';            

            $footer_desktop_padding_css = '';
            $footer_tablet_padding_css = '';
            $footer_mobile_padding_css = '';

            $menu_font = Techt_Utility::meta_options('menu_font');
            $menu_font_size = Techt_Utility::meta_options('menu_font_size');
            $menu_font_weight = Techt_Utility::meta_options('menu_font_weight');
            $menu_font_style = Techt_Utility::meta_options('menu_font_style');
            $menu_font_transform = Techt_Utility::meta_options('menu_font_transform');
            $menu_font_line_height = Techt_Utility::meta_options('menu_font_line_height');
            $menu_font_letter_spacing = Techt_Utility::meta_options('menu_font_latter_spacing');

            /**
             * Font Family
             */ 
            if ( ! empty( $body_font ) ) {

                if(is_rtl()){
                    techt_enqueue_persian_font( $body_font ); 
                }else{
                    techt_enqueue_google_font( $body_font );
                }
               
                $css .= 'body {font-family: ' . $body_font . '; color: '.$body_font_color.'; }';
            }
            if( isset( $menu_font ) && '' != $menu_font  ) {
                if(is_rtl()){
                    techt_enqueue_persian_font( Techt_Utility::meta_options('menu_font') );
                }else{
                    techt_enqueue_google_font( Techt_Utility::meta_options('menu_font') );
                }
                $css .= '.navigation .mainmenu > li > a { font-family: ' . $menu_font . ';}';
            } else {

                if(is_rtl()){
                    $css .= '.navigation .mainmenu > li > a { font-family: ' . Techt_Utility::theme_options( array('headings_font','Vazir') ) . ';}';
                }else{
                    $css .= '.navigation .mainmenu > li > a { font-family: ' . Techt_Utility::theme_options( array('headings_font','Poppins') ) . ';}';
                }
                
            }            

            if( isset( $menu_font_size ) && '' != $menu_font_size  ) {
                $css .= '.navigation .mainmenu > li > a { font-size: ' . $menu_font_size . ' !important;}';
            } else {
                $css .= '.navigation .mainmenu > li > a { font-size: ' . esc_attr( Techt_Utility::theme_options( array('menu_font_size', 16 ) ) ) . 'px !important;}';
            }

            if( isset( $menu_font_weight ) && '' != $menu_font_weight  ) {
                $css .= '.navigation .mainmenu > li > a { font-weight: ' . Techt_Utility::meta_options('menu_font_weight') . ' !important;}';
            }             

            if( isset( $menu_font_style ) && '' != $menu_font_style  ) {
                $css .= '.navigation .mainmenu > li > a { font-style: ' . $menu_font_style . ' !important;}';
            }             

            if( isset( $menu_font_transform ) && '' != $menu_font_transform ) {
                $css .= '.navigation .mainmenu > li > a { text-transform: ' . $menu_font_transform . ' !important;}';
            }             

            if( isset( $menu_font_line_height ) && '' != $menu_font_line_height   ) {
                $css .= '.navigation .mainmenu > li > a { line-height: ' . $menu_font_line_height . ' !important;}';
            } 

            if( isset( $menu_font_letter_spacing ) && '' != $menu_font_letter_spacing  ) {
                $css .= '.navigation .mainmenu > li > a { letter-spacing: ' . $menu_font_letter_spacing . ' !important;}';
            } 

            // Heading Fonts
            $css .= 'h1, h2, h3, h4, h5, h6 { color: '. Techt_Utility::theme_options( array('heading_font_color', '#101010' ) ) .';}';
            $css .= '.techt-advance-heading .techt-sub-heading .line:after,.techt-advance-heading .techt-main-heading .line:after { color: '. Techt_Utility::theme_options( array('heading_font_color', '#101010' ) ) .';}';

            $css .= 'body { font-size: ' . esc_attr( Techt_Utility::theme_options( array('body_font_size', 16 ) ) ) .'px;}';
            if ( ! empty( $headings_font ) ) {
            
                if(is_rtl()){
                    techt_enqueue_persian_font( $headings_font );
                    techt_enqueue_google_font( $headings_font );
                }else{
                    techt_enqueue_google_font( $headings_font );
                }
                $css .= 'h1, h2, h3, h4, h5, h6 { font-family: ' . $headings_font . '; }';
                $css .= '.hamburger-wrapper .mainmenu > li > a, .woocommerce div.product .woocommerce-tabs ul.tabs li { font-family: ' . $headings_font . ';} ';
                $css .= '.blog-block .grid-layout .entry-title, .blog-latest-items article.page .entry-title { font-size: ' . esc_attr( Techt_Utility::theme_options( array('post_title_content', 18 ) ) ) . 'px !important;}';
                $css .= '.blog-single-page>article .entry-title { font-size: ' . esc_attr( Techt_Utility::theme_options( array('post_single_title_content', 24 ) ) ) . 'px !important;}';
                $css .= '.more-link { font-family: ' . $headings_font . ';}';
                $css .= 'h1 { font-size: ' . esc_attr( Techt_Utility::theme_options( array('heading_one_content', 2 ) ) ) . 'em;}';
                $css .= 'h2 { font-size: ' . esc_attr( Techt_Utility::theme_options( array('heading_two_content', 1.5 ) ) ) . 'em;}';
                $css .= 'h3 { font-size: ' . esc_attr( Techt_Utility::theme_options( array('heading_three_content', 1.17 ) ) ) . 'em;}';
                $css .= 'h4 { font-size: ' . esc_attr( Techt_Utility::theme_options( array('heading_four_content', 1 ) ) ) . 'em;}';
                $css .= 'h5 { font-size: ' . esc_attr( Techt_Utility::theme_options( array('heading_five_content', 0.83 ) ) ) . 'em;}';
                $css .= 'h6 { font-size: ' . esc_attr( Techt_Utility::theme_options( array('heading_six_content', 0.67 ) ) ) . 'em;}';
                $css .= '.site-footer .footer-top-block>.container .widget .widget-title, .site-footer .footer-top-block>.container-fluid .widget .widget-title { font-size: ' . esc_attr( Techt_Utility::theme_options( array('footer_widget_title_font_size', 20 ) ) ) . 'px;}';
                $css .= '.site-footer .footer-top-block>.container .widget, .site-footer .footer-top-block>.container-fluid .widget { font-size: ' . esc_attr( Techt_Utility::theme_options( array('footer_widget_content_font_size', 16 ) ) ) . 'px !important;}';
                $css .= '.site-footer .footer-top-block>.container .widget, .site-footer .footer-top-block>.container-fluid .widget { line-height: ' . esc_attr( Techt_Utility::theme_options( array('footer_widget_content_font_line_height', 1.2 ) ) ) . 'em;}';
                $css .= '.widget .widget-title { font-size: ' . esc_attr( Techt_Utility::theme_options( array('widget_title_font_size', 16 ) ) ) . 'px;}';
            }

            if(!empty($site_title_font)) {
                
                if(is_rtl()){
                    techt_enqueue_persian_font( $site_title_font );
                }else{
                    techt_enqueue_google_font( $site_title_font );
                }

                $site_logo_font = Techt_Utility::theme_options( array('site_title_font_size', 20 ) );
                $css .= '.site-branding-text .site-title { font-family: ' . $site_title_font . '; font-size: '. esc_attr( $site_logo_font ) .'px; color: '. $site_title_font_color .';}';
                $css .= '.form-controller, .form-control { font-family: ' . $site_form_fields . ';}';
                $css .= '.posts-loadmore a, .btn, .button, .added_to_cart.wc-forward { font-family: ' . $site_button . ';}';
            }

            if ( !empty($breadcrumb_font) ){
                $breadcrumb_font_size = Techt_Utility::theme_options( array('breadcrumb_font_size', 16 ) );
                $css .= '.techt-breadcrumbs { font-family: ' . $breadcrumb_font . '; font-size: '. esc_attr( $breadcrumb_font_size ) .'px;}';
            }

            /**
             * End Typography
             */ 

            // Header Text Color
            $header_text_color = get_theme_mod('header_textcolor');
            if(!empty( $header_text_color) && $header_text_color !== 'blank' ) {
                $css .= '.hero-block .techt-title, .hero-block .woocommerce-products-header__title.page-title { color: '. $header_text_color .';  }';
            } else {
                $head_text_color = 'ffffff';
                $css .= '.hero-block .techt-title, .hero-block .woocommerce-products-header__title.page-title { color: #ffffff;  }';
            }

            // Header Background color 
            $header_background = Techt_Utility::meta_options('custom_header_bg') ? Techt_Utility::meta_options('custom_header_bg') : Techt_Utility::theme_options('theme_header_background_colors');
            if( isset( $header_background ) && '' != $header_background  ) { 
                $css .= 'header.site-header, header.techt-custom-header, header.sticky-header { background: '. $header_background .';  }';
            }              

            // Header Border Bottom color
            $header_border = Techt_Utility::meta_options('custom_header_border_color');
            if( isset( $header_border ) && '' != $header_border  ) { 
                $css .= 'header.site-header { border-bottom-color: '. $header_border .';  }';
            } else {
                $css .= 'header.site-header { border-bottom-color: '. Techt_Utility::theme_options( array('theme_header_border_colors', '#e4e0d8') ) .'; }';
            }  

            // Menu Main color
            $menu_color = Techt_Utility::meta_options('menu_colors');
            if( isset( $menu_color ) && '' != $menu_color ) { 
                $css .= '@media only screen and (min-width: 992px) { .navigation .mainmenu > li > a { color: '. $menu_color .' !important;  } }';
            } else {
                if(Techt_Utility::theme_options('theme_background_status') == 'light'){
                    $css .= '@media only screen and (min-width: 992px) { .navigation .mainmenu > li > a { color: '. Techt_Utility::theme_options( array( 'menu_color', '#252424' )) .'!important;  } }';
                } elseif(Techt_Utility::theme_options('theme_background_status') == 'dark'){
                    $css .= '@media only screen and (min-width: 992px) { .navigation .mainmenu > li > a { color: #dedede !important; } }';
                }
                
            }

            // Header Height
            if( Techt_Utility::theme_options( array( 'header_heights', '130'  ) ) ) { 
                $css .= '.site-branding, header.site-header .menu-content, .custom-header { height: '. Techt_Utility::theme_options( array('header_heights', '130') ) .'px }';
                $css .= '.hero-block.header-transparent { padding-top: '. Techt_Utility::theme_options( array('header_heights', '130') ) .'px }';
                $css .= '.blog-block-single.blog-single-spacing.header-transparent { padding-top: '. Techt_Utility::theme_options( array('header_heights', '130') ) .'px }';
                $css .= '.shop-single-contents.header-transparent { padding-top: '. Techt_Utility::theme_options( array('header_heights', '130') ) .'px }';
            }           

            // Dropdown Menu background colors
            if( Techt_Utility::theme_options( array( 'main_menu_hover_color', '#313131' ) ) ) { 
                $css .= '@media only screen and (min-width: 992px) { .navigation .mainmenu > li > a:hover { color: '. Techt_Utility::theme_options( array('main_menu_hover_color', '#313131') ) .'; }}';
            }              

            // Menu indicator color
            if( Techt_Utility::theme_options( array( 'main_menu_separator_color', '#313131' ) ) ) { 
                $css .= '@media only screen and (min-width: 992px) { .navigation .mainmenu > li:after { background: '. Techt_Utility::theme_options( array('main_menu_separator_color', '#f44e2b') ) .'; }}';
            }              

            // Sub Menu Background
            if( Techt_Utility::theme_options( array( 'main_menu_separator_color', '#313131' ) ) ) { 
                $css .= '@media only screen and (min-width: 992px) { .mainmenu .sub-menu, .mainmenu .sub-menu .sub-menu, .mainmenu .sub-menu .sub-menu .sub-menu, .shoping-cart .header-cart-dropdown { background: '. Techt_Utility::theme_options(array('dropdown_menu_bg', '#1d2023')) .'; }}';
            }             

            // Sub Menu Background
            if( Techt_Utility::theme_options( array( 'main_menu_separator_color', '#f7f7f7' ) ) ) { 
                $css .= '@media only screen and (min-width: 992px) { .mainmenu .sub-menu li a { color: '. Techt_Utility::theme_options(array('dropdown_menu_color', '#f7f7f7')) .'; }}';
            }              

            if( Techt_Utility::theme_options( array( 'mobile_menu_hamburger_color', '#12141c' ) ) ) { 
                $css .= '@media only screen and (max-width: 992px) { .hamburger-menu .hamburger-content, .hamburger-menu .hamburger-content:before, .hamburger-menu .hamburger-content:after { background: '. Techt_Utility::theme_options(array('mobile_menu_hamburger_color', '#12141c')) .'; }}';
            }              

            if( Techt_Utility::theme_options( array( 'mobile_menu_bg', '#12141c' ) ) ) { 
                $css .= '@media only screen and (max-width: 992px) { header .mainmenu { background: '. Techt_Utility::theme_options(array('mobile_menu_bg', '#12141c')) .'; }}';
            }  

            if( Techt_Utility::theme_options( array( 'mobile_menu_color', '#ffffff' ) ) ) { 
                $css .= '@media only screen and (max-width: 992px) { header .mainmenu li a { color: '. Techt_Utility::theme_options(array('mobile_menu_color', '#ffffff')) .' !important; }}';
            }  

            // Theme Input Border Color
            if( $techt_input_border ) { 
                $css .= '.widget_links ul li, .widget_meta ul li, .widget_nav_menu ul li, .widget_pages ul li, .widget_recent_comments ul li, .widget_recent_entries ul li, .widget_product_categories ul li, .widget_categories ul li, .widget_archive ul li, .widget_layered_nav ul li { border-top-color: '. $techt_input_border .'; }';
                $css .= '.woocommerce-form-coupon input { border-color: '. $techt_input_border .' }';
                $css .= '#review_form_wrapper .comment-respond .comment-form>p>textarea[name="comment"], #review_form_wrapper .comment-respond .comment-form>.comment-form-rating>textarea[name="comment"], #review_form_wrapper .comment-respond .comment-form>p>input[type="text"], #review_form_wrapper .comment-respond .comment-form>p>input[type="email"], #review_form_wrapper .comment-respond .comment-form>.comment-form-rating>input[type="text"], #review_form_wrapper .comment-respond .comment-form>.comment-form-rating>input[type="email"], .form-controller, .form-control, .woocommerce #reviews #comments ol.commentlist li .comment-text, techt-social-share-link { border-color: '. $techt_input_border .' }';
            }  

            // Light version Body Background
            $theme_light_bg = Techt_Utility::meta_options('body_bg_colors');
            if( Techt_Utility::theme_options( array( 'theme_background_light_color', '#ffffff' ) ) ) { 
                $css .= 'body:not(.custom-background) .light-version { background: '. Techt_Utility::theme_options(array('theme_background_light_color', '#ffffff')) .'; }';
            }            

            if( isset( $theme_light_bg ) && '' != $theme_light_bg ) {
                $css .= 'body:not(.custom-background) .techt-body { background: '. $theme_light_bg .'; }';          
            }

            if( Techt_Utility::meta_options('fixed_footer') == 'yes' ) {
                $css .= 'body:not(.custom-background) .light-version .portfolio-main, body:not(.custom-background) .light-version .blog-block, body:not(.custom-background) .light-version .error-page-block, body:not(.custom-background) .light-version .blog-block-single, body:not(.custom-background) .light-version .techt-page-builder-elementor{ background: '. Techt_Utility::theme_options(array('theme_background_light_color', '#ffffff')) .'; }';
            } elseif(Techt_Utility::theme_options('fixed_footer') == true ) {
                $css .= 'body:not(.custom-background) .light-version .portfolio-main, body:not(.custom-background) .light-version .blog-block, body:not(.custom-background) .light-version .error-page-block, body:not(.custom-background) .light-version .blog-block-single, body:not(.custom-background) .light-version .techt-page-builder-elementor{ background: '. Techt_Utility::theme_options(array('theme_background_light_color', '#ffffff')) .'; }';
            }

            // Dark version Body Background
            $theme_dark_bg = Techt_Utility::meta_options('body_bg_colors');
            if(  Techt_Utility::theme_options( array( 'theme_background_dark_color', '#333333' ) ) ) { 
                $css .= 'body:not(.custom-background) .dark-version { background: '. Techt_Utility::theme_options(array('theme_background_dark_color', '#333333')) .'; }';
            }

            if( isset( $theme_dark_bg ) && '' != $theme_dark_bg ) {
                $css .= '.techt-body { background: '. $theme_dark_bg .'; }';          
            }
                    
            if( Techt_Utility::theme_options( array( 'theme_text_dark_color', '#b0b0b0' ) ) ) { 
                $css .= '.dark-version { color: '. Techt_Utility::theme_options(array('theme_text_dark_color', '#b0b0b0')) .'; }';
            }

            if( Techt_Utility::meta_options('fixed_footer') == 'yes' ) {
                $css .= 'body:not(.custom-background) .dark-version .portfolio-main, body:not(.custom-background) .dark-version .shop-main-content, body:not(.custom-background) .dark-version .blog-block,body:not(.custom-background) .dark-version .error-page-block,body:not(.custom-background) .dark-version .blog-block-single, body:not(.custom-background) .dark-version .techt-page-builder-elementor{ background: '. Techt_Utility::theme_options(array('theme_background_dark_color', '#333333')) .'; }';
            } elseif(Techt_Utility::theme_options('fixed_footer') == true ) {
                $css .= 'body:not(.custom-background) .dark-version .portfolio-main, body:not(.custom-background) .dark-version .shop-main-content, body:not(.custom-background) .dark-version .blog-block,body:not(.custom-background) .dark-version .error-page-block,body:not(.custom-background) .dark-version .blog-block-single, body:not(.custom-background) .dark-version .techt-page-builder-elementor{ background: '. Techt_Utility::theme_options(array('theme_background_dark_color', '#333333')) .'; }';
            }

            // Preloader

            if( is_singular( array('page', 'attachment', 'post') ) ){
                $current_obj = get_queried_object();
                $preloader_bg = Techt_Utility::meta_options(['preloader_bg', $current_obj->ID]) ? Techt_Utility::meta_options(['preloader_bg', $current_obj->ID]) : Techt_Utility::theme_options(array('theme_preloader_bg', self::$petrona_colors['theme_preloader_bg']));
                if( Techt_Utility::theme_options( array( 'theme_preloader_bg', self::$petrona_colors['theme_preloader_bg'] ) ) ) { 
                    $css .= '.preloader { background-color: '. $preloader_bg .'; }';
                    $css .= '.el_preloader { background-color: '. $preloader_bg .'; }';
                }            

                $preloader_box_color_1 = Techt_Utility::meta_options(['preloader_color_1', $current_obj->ID]) ? Techt_Utility::meta_options(['preloader_color_1', $current_obj->ID]) : Techt_Utility::theme_options(array('theme_preloader_color_1', self::$petrona_colors['theme_preloader_color_1']));
                if( Techt_Utility::theme_options( array( 'theme_preloader_color_1', self::$petrona_colors['theme_preloader_color_1'] ) ) ) { 
                    $css .= '.preloader .inner.one { border-bottom-color: '. $preloader_box_color_1 .'; }';
                }

                $preloader_box_color_2 = Techt_Utility::meta_options(['preloader_color_2', $current_obj->ID]) ? Techt_Utility::meta_options(['preloader_color_2', $current_obj->ID]) : Techt_Utility::theme_options(array('theme_preloader_color_2', self::$petrona_colors['theme_preloader_color_2']));
                if( Techt_Utility::theme_options( array( 'theme_preloader_color_2', self::$petrona_colors['theme_preloader_color_2'] ) ) ) { 
                    $css .= '.preloader .inner.two { border-right-color: '. $preloader_box_color_2 .'; }';
                }
                
                $preloader_box_color_3 = Techt_Utility::meta_options(['preloader_color_3', $current_obj->ID]) ? Techt_Utility::meta_options(['preloader_color_3', $current_obj->ID]) : Techt_Utility::theme_options(array('theme_preloader_color_3', self::$petrona_colors['theme_preloader_color_3']));
                if( Techt_Utility::theme_options( array( 'theme_preloader_color_3', self::$petrona_colors['theme_preloader_color_3'] ) ) ) { 
                    $css .= '.preloader .inner.three { border-top-color: '. $preloader_box_color_3 .'; }';
                }   
            }
            

            // Site Branding Heading
            if(  Techt_Utility::theme_options( array( 'site_branding_color', '#000000' ) ) ) { 
                $css .= '.site-branding-text .site-title { color: '. Techt_Utility::theme_options(array('site_branding_color', '#000000')) .'; }';
            }            

            if( Techt_Utility::theme_options( array( 'site_description_color', '#858585' ) ) ) { 
                $css .= '.site-branding-text .site-description { color: '. Techt_Utility::theme_options(array('site_description_color', '#858585')) .'; }';
            }

            // Footer Color
            $footer_link_color = Techt_Utility::meta_options('footer_link_color');   
            $footer_text_color = Techt_Utility::meta_options('footer_text');   
            $footer_bg_color = Techt_Utility::meta_options('footer_background');   
            if( isset( $footer_link_color ) && '' != $footer_link_color ) { 
                $css .= 'footer.site-footer { color: '. $footer_link_color .'; }';
            } else {
                $css .= 'footer.site-footer { color: '. Techt_Utility::theme_options(array('footer_color', '#505050')) .'; }';
            }     

            if( isset( $footer_bg_color ) && '' != $footer_bg_color ) { 
                $css .= 'footer.site-footer, footer.site-footer, footer.techt-custom-footer { background: '. $footer_bg_color .'; }';
            } else {
                $css .= 'footer.site-footer, footer.techt-custom-footer { background: '. Techt_Utility::theme_options(array('footer_bg_colors', '#c4c4c4')) .'; }';
            }       

            $css .= 'light-version footer.site-footer h3.widget-title { color: '. Techt_Utility::theme_options(array('footer_widget_title', '#101010')) .' !important; }';

            $css .= 'light-version footer.site-footer h1, light-version footer.site-footer h2,light-version footer.site-footer h3,light-version footer.site-footer h4,light-version footer.site-footer h5,light-version footer.site-footer h6 { color: '. Techt_Utility::theme_options(array('footer_widget_title', '#101010')) .' !important; }';   

            $css .= '.widget_search .form-control, .widget_product_search .form-control, .widget select { border-color:  '. Techt_Utility::theme_options(array('footer_color', '#e4e0d8')) .'73; }';

            if( isset( $footer_link_color ) && '' != $footer_link_color ) { 
                $css .= 'footer.site-footer a, .site-footer .footer-social li a  { color: '. $footer_link_color .'; }';
            } else {
                $css .= 'footer.site-footer a, .site-footer .footer-social li a  { color: '. Techt_Utility::theme_options(array('footer_link_color', '#505050')) .'; }';
            }           

            if(  Techt_Utility::meta_options( 'footer_link_hover_color' )  ) { 
                $css .= 'footer .copyright-text i, footer a:hover, .site-footer .footer-social li a:hover { color: '. Techt_Utility::meta_options( 'footer_link_hover_color' ) .'; }';
            } else {
                $css .= 'footer .copyright-text i, footer a:hover, .site-footer .footer-social li a:hover { color: '. Techt_Utility::theme_options(array('footer_link_hover_color', '#f68872')) .'; }';
            }            
            $css .= 'footer .copyright-text { color: '. Techt_Utility::theme_options(array('footer_copy_color', '#5e5e5e')) .' !important; }';
            $css .= 'footer .copyright-text { color: '. Techt_Utility::theme_options(array('footer_copy_border_top', '#5e5e5e')) .'; border-top: 1px solid '. Techt_Utility::theme_options(array('footer_copy_border_top', '#ebebeb')) .'; }';

            // Content top padding
            if ( isset( $blog_wrap_desktop_top ) && '' != $blog_wrap_desktop_top ) {
                $content_padding_css .= 'padding-top:'. $blog_wrap_desktop_top .'px;';
            }

            // Content bottom padding
            if ( isset( $blog_wrap_desktop_bottom ) && '' != $blog_wrap_desktop_bottom ) {
                $content_padding_css .= 'padding-bottom:'. $blog_wrap_desktop_bottom .'px;';
            }

            // Content padding css
            if ( isset( $blog_wrap_desktop_top ) && '' != $blog_wrap_desktop_top
                || isset( $blog_wrap_desktop_bottom ) && '' != $blog_wrap_desktop_bottom ) {
                $css .= '.blog-block {'. $content_padding_css .'}';
            }

            // Tablet content top padding
            if ( isset( $blog_wrap_tablet_top ) && '' != $blog_wrap_tablet_top ) {
                $tablet_content_padding_css .= 'padding-top:'. $blog_wrap_tablet_top .'px;';
            }

            // Tablet content bottom padding
            if ( isset( $blog_wrap_tablet_bottom ) && '' != $blog_wrap_tablet_bottom ) {
                $tablet_content_padding_css .= 'padding-bottom:'. $blog_wrap_tablet_bottom .'px;';
            }

            // Tablet content padding css
            if ( isset( $blog_wrap_tablet_top ) && '' != $blog_wrap_tablet_top
                || isset( $blog_wrap_tablet_bottom ) && '' != $blog_wrap_tablet_bottom ) {
                $css .= '@media (max-width: 768px){.blog-block {'. $tablet_content_padding_css .'}}';
            }

            // Mobile content top padding
            if ( isset( $blog_wrap_mobile_top ) && '' != $blog_wrap_mobile_top ) {
                $mobile_content_padding_css .= 'padding-top:'. $blog_wrap_mobile_top .'px;';
            }

            // Mobile content bottom padding
            if ( isset( $blog_wrap_mobile_bottom ) && '' != $blog_wrap_mobile_bottom ) {
                $mobile_content_padding_css .= 'padding-bottom:'. $blog_wrap_mobile_bottom .'px;';
            }

            // Mobile content padding css
            if ( isset( $blog_wrap_mobile_bottom ) && '' != $blog_wrap_mobile_bottom
                || isset( $blog_wrap_mobile_top ) && '' != $blog_wrap_mobile_top ) {
                $css .= '@media (max-width: 480px){.blog-block {'. $mobile_content_padding_css .'}}';
            } 

            // Page Content top padding
            if ( isset( $page_wrap_desktop_top ) && '' != $page_wrap_desktop_top ) {
                $page_content_padding_css .= 'padding-top:'. $page_wrap_desktop_top .'px;';
            }

            // Page Content bottom padding
            if ( isset( $page_wrap_desktop_bottom ) && '' != $page_wrap_desktop_bottom ) {
                $page_content_padding_css .= 'padding-bottom:'. $page_wrap_desktop_bottom .'px;';
            }

            // Page Content padding css
            if ( isset( $page_wrap_desktop_top ) && '' != $page_wrap_desktop_top
                || isset( $page_wrap_desktop_bottom ) && '' != $page_wrap_desktop_bottom ) {
                $css .= '.page-content-main {'. $page_content_padding_css .'}';
            }

            // Tablet Page content top padding
            if ( isset( $page_wrap_tablet_top ) && '' != $page_wrap_tablet_top ) {
                $page_tablet_content_padding_css .= 'padding-top:'. $page_wrap_tablet_top .'px;';
            }

            // Tablet Page content bottom padding
            if ( isset( $page_wrap_tablet_bottom ) && '' != $page_wrap_tablet_bottom ) {
                $page_tablet_content_padding_css .= 'padding-bottom:'. $page_wrap_tablet_bottom .'px;';
            }

            // Tablet Page content padding css
            if ( isset( $page_wrap_tablet_top ) && '' != $page_wrap_tablet_top
                || isset( $page_wrap_tablet_bottom ) && '' != $page_wrap_tablet_bottom ) {
                $css .= '@media (max-width: 768px){ .page-content-main {'. $page_tablet_content_padding_css .'}}';
            }         

            // Mobile Page content top padding
            if ( isset( $page_wrap_mobile_top ) && '' != $page_wrap_mobile_top ) {
                $page_mobile_content_padding_css .= 'padding-top:'. $page_wrap_mobile_top .'px;';
            }

            // Mobile Page content bottom padding
            if ( isset( $page_wrap_mobile_bottom ) && '' != $page_wrap_mobile_bottom ) {
                $page_mobile_content_padding_css .= 'padding-bottom:'. $page_wrap_mobile_bottom .'px;';
            }

            // Mobile Page content padding css
            if ( isset( $page_wrap_mobile_bottom ) && '' != $page_wrap_mobile_bottom
                || isset( $page_wrap_mobile_top ) && '' != $page_wrap_mobile_top ) {
                $css .= '@media (max-width: 480px){.page-content-main {'. $page_mobile_content_padding_css .'}}';
            }

            //logo top padding
            if ( isset( $logo_desktop_top ) && '' != $logo_desktop_top ) {
                $logo_desktop_padding_css .= 'padding-top:'. $logo_desktop_top .'px;';
            }            

            //logo bottom padding
            if ( isset( $logo_desktop_bottom ) && '' != $logo_desktop_bottom ) {
                $logo_desktop_padding_css .= 'padding-bottom:'. $logo_desktop_bottom .'px;';
            }

            // logo padding css
            if ( isset( $logo_desktop_top ) && '' != $logo_desktop_top
                || isset( $logo_desktop_bottom ) && '' != $logo_desktop_bottom ) {
                $css .= '@media (min-width: 992px) {.site-branding {'. $logo_desktop_padding_css .'}}';
            }

            //logo tablet top padding
            if ( isset( $logo_tablet_top ) && '' != $logo_tablet_top ) {
                $logo_tablet_padding_css .= 'padding-top:'. $logo_tablet_top .'px;';
            }            

            //logo tablet bottom padding
            if ( isset( $logo_tablet_bottom ) && '' != $logo_tablet_bottom ) {
                $logo_tablet_padding_css .= 'padding-bottom:'. $logo_tablet_bottom .'px;';
            }

            // logo tablet padding css
            if ( isset( $logo_tablet_top ) && '' != $logo_tablet_top
                || isset( $logo_tablet_bottom ) && '' != $logo_tablet_bottom ) {
                $css .= '@media (max-width: 991px){ .site-branding {'. $logo_tablet_padding_css .'}}';
            }

            //logo mobile top padding
            if ( isset( $logo_mobile_top ) && '' != $logo_mobile_top ) {
                $logo_mobile_padding_css .= 'padding-top:'. $logo_mobile_top .'px;';
            }            

            //logo mobile bottom padding
            if ( isset( $logo_mobile_bottom ) && '' != $logo_mobile_bottom ) {
                $logo_mobile_padding_css .= 'padding-bottom:'. $logo_mobile_bottom .'px;';
            }

            // logo mobile padding css
            if ( isset( $logo_mobile_top ) && '' != $logo_mobile_top
                || isset( $logo_mobile_bottom ) && '' != $logo_mobile_bottom ) {
                $css .= '@media (max-width: 480px){ .site-branding {'. $logo_mobile_padding_css .'}}';
            }

            //Single Blog top padding
            if ( isset( $blog_single_wrap_desktop_top ) && '' != $blog_single_wrap_desktop_top ) {
                $single_content_padding_css .= 'padding-top:'. $blog_single_wrap_desktop_top .'px;';
            }            

            //Single Blog bottom padding
            if ( isset( $blog_single_wrap_desktop_bottom ) && '' != $blog_single_wrap_desktop_bottom ) {
                $single_content_padding_css .= 'padding-bottom:'. $blog_single_wrap_desktop_bottom .'px;';
            }

            // Single Blog padding css
            if ( isset( $blog_single_wrap_desktop_top ) && '' != $blog_single_wrap_desktop_top
                || isset( $blog_single_wrap_desktop_bottom ) && '' != $blog_single_wrap_desktop_bottom ) {
                $css .= '.blog-single-spacing {'. $single_content_padding_css .'}';
            }

            //Single Blog tablet top padding
            if ( isset( $blog_single_wrap_tablet_top ) && '' != $blog_single_wrap_tablet_top ) {
                $single_tablet_content_padding_css .= 'padding-top:'. $blog_single_wrap_tablet_top .'px;';
            }            

            //Single Blog tablet bottom padding
            if ( isset( $blog_single_wrap_tablet_bottom ) && '' != $blog_single_wrap_tablet_bottom ) {
                $single_tablet_content_padding_css .= 'padding-bottom:'. $blog_single_wrap_tablet_bottom .'px;';
            }

            // Single Blog tablet padding css
            if ( isset( $blog_single_wrap_tablet_top ) && '' != $blog_single_wrap_tablet_top
                || isset( $blog_single_wrap_tablet_bottom ) && '' != $blog_single_wrap_tablet_bottom ) {
                $css .= '@media (max-width: 768px){ .blog-single-spacing {'. $single_tablet_content_padding_css .'}}';
            }

            //Single Blog mobile top padding
            if ( isset( $blog_single_wrap_mobile_top ) && '' != $blog_single_wrap_mobile_top ) {
                $single_mobile_content_padding_css .= 'padding-top:'. $blog_single_wrap_mobile_top .'px;';
            }            

            //Single Blog mobile bottom padding
            if ( isset( $blog_single_wrap_mobile_bottom ) && '' != $blog_single_wrap_mobile_bottom ) {
                $single_mobile_content_padding_css .= 'padding-bottom:'. $blog_single_wrap_mobile_bottom .'px;';
            }

            // Single Blog mobile padding css
            if ( isset( $blog_single_wrap_mobile_top ) && '' != $blog_single_wrap_mobile_top
                || isset( $blog_single_wrap_mobile_bottom ) && '' != $blog_single_wrap_mobile_bottom ) {
                $css .= '@media (max-width: 480px){ .blog-single-spacing {'. $single_mobile_content_padding_css .'}}';
            }

            //Single Blog top padding
            if ( isset( $blog_single_content_mr_desktop_top ) && '' != $blog_single_content_mr_desktop_top ) {
                $single_content_margin_css .= 'margin-top:'. $blog_single_content_mr_desktop_top .'px;';
            }            

            //Single Blog bottom margin
            if ( isset( $blog_single_content_mr_desktop_bottom ) && '' != $blog_single_content_mr_desktop_bottom ) {
                $single_content_margin_css .= 'margin-bottom:'. $blog_single_content_mr_desktop_bottom .'px;';
            }

            // Single Blog margin css
            if ( isset( $blog_single_content_mr_desktop_top ) && '' != $blog_single_content_mr_desktop_top
                || isset( $blog_single_content_mr_desktop_bottom ) && '' != $blog_single_content_mr_desktop_bottom ) {
                $css .= 'body.single-post .blog-block-single .blog-single-page > article {'. $single_content_margin_css .'}';
            } else {
                $css .= 'body.single:not(.woocommerce) .hero-block.bg-soft-black {display: none}';
            }

            //Single Blog tablet top margin
            if ( isset( $blog_single_content_mr_tablet_top ) && '' != $blog_single_content_mr_tablet_top ) {
                $single_tablet_content_margin_css .= 'margin-top:'. $blog_single_content_mr_tablet_top .'px;';
            }            

            //Single Blog tablet bottom margin
            if ( isset( $blog_single_content_mr_tablet_bottom ) && '' != $blog_single_content_mr_tablet_bottom ) {
                $single_tablet_content_margin_css .= 'margin-bottom:'. $blog_single_content_mr_tablet_bottom .'px;';
            }

            // Single Blog tablet margin css
            if ( isset( $blog_single_content_mr_tablet_top ) && '' != $blog_single_content_mr_tablet_top
                || isset( $blog_single_content_mr_tablet_bottom ) && '' != $blog_single_content_mr_tablet_bottom ) {
                $css .= '@media (max-width: 768px){ body.single-post .blog-block-single .blog-single-page > article {'. $single_tablet_content_margin_css .'}}';
            }

            //Single Blog mobile top margin
            if ( isset( $blog_single_content_mr_mobile_top ) && '' != $blog_single_content_mr_mobile_top ) {
                $single_mobile_content_margin_css .= 'margin-top:'. $blog_single_content_mr_mobile_top .'px;';
            }            

            //Single Blog mobile bottom margin
            if ( isset( $blog_single_content_mr_mobile_bottom ) && '' != $blog_single_content_mr_mobile_bottom ) {
                $single_mobile_content_margin_css .= 'margin-bottom:'. $blog_single_content_mr_mobile_bottom .'px;';
            }

            // Single Blog mobile margin css
            if ( isset( $blog_single_content_mr_mobile_top ) && '' != $blog_single_content_mr_mobile_top
                || isset( $blog_single_content_mr_mobile_bottom ) && '' != $blog_single_content_mr_mobile_bottom ) {
                $css .= '@media (max-width: 480px){ body.single-post .blog-block-single .blog-single-page > article {'. $single_mobile_content_margin_css .'}}';
            }

            //Footer padding
            if ( isset( $footer_desktop_top ) && '' != $footer_desktop_top ) {
                $footer_desktop_padding_css .= 'padding-top:'. $footer_desktop_top .'px;';
            }            

            //Footer bottom padding
            if ( isset( $footer_desktop_bottom ) && '' != $footer_desktop_bottom ) {
                $footer_desktop_padding_css .= 'padding-bottom:'. $footer_desktop_bottom .'px;';
            }

            // Footer padding css
            if ( isset( $footer_desktop_top ) && '' != $footer_desktop_top
                || isset( $footer_desktop_bottom ) && '' != $footer_desktop_bottom ) {
                $css .= '.site-footer {'. $footer_desktop_padding_css .'}';
            }

            //Footer tablet top padding
            if ( isset( $footer_tablet_top ) && '' != $footer_tablet_top ) {
                $footer_tablet_padding_css .= 'padding-top:'. $footer_tablet_top .'px;';
            }            

            //Footer tablet bottom padding
            if ( isset( $footer_tablet_bottom ) && '' != $footer_tablet_bottom ) {
                $footer_tablet_padding_css .= 'padding-bottom:'. $footer_tablet_bottom .'px;';
            }

            // Footer tablet padding css
            if ( isset( $footer_tablet_top ) && '' != $footer_tablet_top
                || isset( $footer_tablet_bottom ) && '' != $footer_tablet_bottom ) {
                $css .= '@media (max-width: 768px){ .site-footer {'. $footer_tablet_padding_css .'}}';
            }

            //Footer mobile top padding
            if ( isset( $footer_mobile_top ) && '' != $footer_mobile_top ) {
                $footer_mobile_padding_css .= 'padding-top:'. $footer_mobile_top .'px;';
            }            

            //Footer mobile bottom padding
            if ( isset( $footer_mobile_bottom ) && '' != $footer_mobile_bottom ) {
                $footer_mobile_padding_css .= 'padding-bottom:'. $footer_mobile_bottom .'px;';
            }

            //Footer mobile padding css
            if ( isset( $footer_mobile_top ) && '' != $footer_mobile_top
                || isset( $footer_mobile_bottom ) && '' != $footer_mobile_bottom ) {
                $css .= '@media (max-width: 480px){ .site-footer {'. $footer_mobile_padding_css .'}}';
            }

            //Logo Width Width
            if( Techt_Utility::theme_options('logo_max_width') ) { 
                $css .= '.site-branding .custom-logo { max-width: '. Techt_Utility::theme_options(array('logo_max_width', 215)) .'px; }';
            }               

            //Dropdown Menu Width
            if( Techt_Utility::theme_options('dropdown_menu_width') ) { 
                $css .= '@media only screen and (min-width: 1199px) { .mainmenu .sub-menu { min-width: '. Techt_Utility::theme_options(array('dropdown_menu_width', '220px')) .'; } }';
            }    

            // CSS From Post Meta
            $page_top_pd = Techt_Utility::meta_options('content_padding_top');
            $page_bottom_pd = Techt_Utility::meta_options('content_padding_bottom');
            $article_top_pd = Techt_Utility::meta_options('article_spacing_top');
            $article_bottom_pd = Techt_Utility::meta_options('article_spacing_bottom');
            $menu_active_color = Techt_Utility::meta_options('menu_active_colors');
            if( isset( $page_top_pd ) && '' != $page_top_pd  ) { 
                $css .= '.page-content-main { padding-top: '. $page_top_pd .' !important;  }';
            }          

            if( isset( $page_bottom_pd ) && '' != $page_bottom_pd  ) { 
                $css .= '.page-content-main { padding-bottom: '. $page_bottom_pd .' !important;  }';
            }            

            if( isset( $article_top_pd ) && '' != $article_top_pd ) { 
                $css .= '.blog-single-page .post { margin-top: '. $article_top_pd .' !important;  }';
            }            

            if( isset( $article_bottom_pd ) && '' != $article_bottom_pd ) { 
                $css .= '.blog-single-page .post { margin-bottom: '. $article_bottom_pd .' !important;  }';
            } 

            // Link Hover color
            if($techt_link_hover_color) { 
                $css .= 'a:not(.post-link, article .post-category > a, .elementor-button, .btn, a.techt-social-share-link, .techt-filter, .techt-slider__button):hover, article .grid-layout .post-meta .entry-author a, .blog-block-single .entry-content a:hover, .post .entry-title a:hover, .post .grid-layout .entry-title:hover a, .blog-latest-items article.page .entry-title:hover a, .single-post-pagination .more-link-wrap h3:hover, ul.products > li.product .product-title-link:hover { color: '. $techt_link_hover_color .'c9;  }';
                $css .= 'article .post-category > a:hover,.blog-single-page .blog-tag .tagcloud a:hover, .comment-respond #submit:hover, .comment-respond .submit:hover,  widget.widget_search .btn:hover, .techt-scroll-top:hover, .techt-social-share-link:hover { background-color: '. $techt_link_hover_color .'c9;  }';
            }
            
            // Link Hover color
            if($techt_cover_color) {
                $css .= 'article .grid-layout .post-thumb a:before, .techt-team-member__cover::before { background: '. $techt_cover_color .'c4;  }';
                $css .= '.portfolio-boxes .portfolio-box:hover::before, .techt-team-member__cover:before{ background-color: '. $techt_cover_color .'c4;  }';
            }

            if( isset( $menu_active_color ) && '' != $menu_active_color ) {
                $css .= '@media only screen and (min-width: 993px) { header.site-header .navigation .mainmenu>li>a:after{ background: '. $menu_active_color .'; } }';
            } else {
                $css .= '@media only screen and (min-width: 993px) { header.site-header .navigation .mainmenu>li>a:after{ background: '. $techt_link_hover_color .'; } }';
            }         

            // Main theme color
            if(  $techt_color ) {
                $css .= '.btn, .comment-respond #submit, .comment-respond .submit { background: '. $techt_color .'  }';
                $css .= '.widget .widget-title:after, .related-post-content .post-section-title:after, .comment-respond .comment-reply-title:after, .comments-area .comments-title:after { background: '.$techt_color .'  }';
                $css .= '.techt-scroll-top { background-color: '. $techt_color .' ; } ';
                $css .= '.no-results.not-found .page-title:after { background: '.$techt_color .'  }';
                $css .= '.no-results.not-found .page-not-found-icon i { color: '.$techt_color .'  }';
                $css .= '.widget.widget_search .btn, .widget.widget_search .btn:focus, .no-results.not-found .btn-default, .no-results.not-found .btn-default:hover, .no-results.not-found .btn-default:focus { background: '. $techt_color .'; }';
                $css .= 'pre, blockquote { background: '. $techt_color .'80; }';
                $css .= '.shop-single-contents div.product form.cart .button:hover,#review_form_wrapper .comment-respond .comment-form .form-submit input#submit:hover, .posts-loadmore a:hover { background: '. $techt_color .'; }';
                
                $css .= '.woocommerce-checkout span.woocommerce-input-wrapper input, .woocommerce-checkout span.woocommerce-input-wrapper textarea, .select2-container--default .select2-selection--single { border-color: '. $techt_color .' }';
                $css .= '.select2-container--default .select2-selection--single, .select2-dropdown { background: '. $techt_color .' }';
                
                $css .= '.post .list-layout .post-category a, .blog-latest-items article.page .list-layout .post-category a, article .grid-featurs-layout .post-category a { background: '. $techt_color .'99; }';
                $css .= '.pagination-link>li a { background: '. $techt_color .'99; }';
                $css .= '.heading-border { background: '. $techt_color .'; }';
                $css .= '.widget .widget-title:before { background: '. $techt_color .'; }';
                // $css .= '.comment-respond #submit:hover, .comment-respond .submit:hover { border-color: '. $techt_color .'; color: '. $techt_color .'; }';
                $css .= '.woocommerce-form-login input[type="text"], .woocommerce-form-login input[type="password"] { border-color: '. $techt_color .'; }';
                
                
                // $css .= '.tagcloud a:hover,.single-post-pagination a:hover { border-color: '. $techt_color .'; color: '. $techt_color .'; }';
                $css .= '#add_payment_method #payment, .woocommerce-cart #payment, .woocommerce-checkout #payment { background: '. $techt_color .'; }';
                $css .= '.woocommerce-error, .woocommerce-info, .woocommerce-message { background-color: '. $techt_color .'; }';
                $css .= '.wc-proceed-to-checkout .checkout-button.button{ background: '.$techt_color .' !important; } ';
                $css .= '.woocommerce #payment #place_order, .woocommerce-page #payment #place_order{ background: '.$techt_color .' !important; } ';
                $css .= '.woocommerce-form-coupon button[name="apply_coupon"], .woocommerce-form-coupon input[name="apply_coupon"][type="button"], .woocommerce-form-coupon input[name="apply_coupon"][type="reset"], .woocommerce-form-coupon input[name="apply_coupon"][type="submit"] { background: '.$techt_color .' !important; } ';
                $css .= '.return-to-shop a { background: '.$techt_color .' !important; } ';
                // $css .= '.added_to_cart.wc-forward, .woocommerce-button.button, .woocommerce-MyAccount-content .woocommerce-Button.button { background: '.$techt_color .' !important; } ';
                $css .= '.added_to_cart.wc-forward, .woocommerce-button.button, .woocommerce-Button.button { background: '.$techt_color .' !important; } ';
                $css .= '.woocommerce-error, .woocommerce-info, .woocommerce-message{ border-top-color: '.$techt_color .' } ';
                $css .= '.woocommerce-error::before, .woocommerce-info::before, .woocommerce-message::before { color: '.$techt_color .' } ';
                $css .= '.cart-contents span.count { background: '.$techt_color .' } ';
                $css .= '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt { background: '.$techt_color .' } ';
                $css .= '.elementor-button { background-color: '.$techt_color .' ; } ';
                $css .= '.posts-loadmore a:hover, .techt-portfolio-details-box-title h2, ul.products > li.product a:hover .woocommerce-loop-product__title, .woocommerce ul.products li.product .price { color: '.$techt_color .' !important; }';
            } 

            if( $techt_text_color ) {
                $css .= '.post .list-layout .post-category a, .blog-latest-items article.page .list-layout .post-category a, article .grid-featurs-layout .post-category a, .post .grid-featurs-layout .more-link, .blog-latest-items article.page .grid-featurs-layout .more-link, .post .list-layout .more-link, .blog-latest-items article.page .list-layout .more-link { color: '. $techt_text_color .' !important; }';
            }

            // Secondary Color Elements
            if( $techt_secondary_color ) { 
                $css .= '.btn:hover, .comment-respond #submit:hover, .comment-respond .submit:hover { background: '. $techt_secondary_color .'  }';
                $css .= '.post .list-layout .more-link:hover, .blog-latest-items article.page .list-layout .more-link:hover, .post .grid-featurs-layout .more-link:hover, .blog-latest-items article.page .grid-featurs-layout .more-link:hover{ background: '.$techt_secondary_color .'  }';
                // $css .= '.sidebar-block .widget_search .btn, .no-results.not-found .btn-default { border-color: '. $techt_secondary_color .'; }';
                
                $css .= '.comment-reply-link { background: '. $techt_secondary_color .'; border-color: '. $techt_secondary_color .'; }';
                $css .= '.post .grid-featurs-layout .post-category a:hover, .blog-latest-items article.page .grid-featurs-layout .post-category a:hover, .post .list-layout .post-category a:hover, .blog-latest-items article.page .list-layout .post-category a:hover { background: '.$techt_secondary_color .'  }';
                $css .= '.pagination-link>li.active a { background: '.$techt_secondary_color .'  }';
                $css .= 'article .post-category>a, .blog-single-page .blog-tag .tagcloud a  { background: '.$techt_secondary_color.'  }';
                $css .= '.techt-recent-posts-item a::after {background: '.$techt_secondary_color .'90;' .'}';
                // if(Techt_Utility::theme_options('theme_background_status') == 'light'){
                //     $css .= '.related-post-content .post-section-title:after, .comment-respond .comment-reply-title:after, .comments-area .comments-title:after { background: '.$techt_secondary_color .'  }';
                // } elseif(Techt_Utility::theme_options('theme_background_status') == 'dark'){
                //     $css .= '.related-post-content .post-section-title:after, .comment-respond .comment-reply-title:after, .comments-area .comments-title:after { background: white}';
                // }
                $css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active { background: '. $techt_secondary_color .'; }';
                $css .= '.comment-reply-link:hover { border:  1px solid '.$techt_secondary_color .' !important; background: '.$techt_secondary_color .'}';
                $css .= '.shop-single-contents div.product form.cart .button, .posts-loadmore a { background: '.$techt_secondary_color .' } ';
                $css .= '.wc-proceed-to-checkout .checkout-button.button:hover { background: '. $techt_secondary_color .'!important; }';
                $css .= '.woocommerce #payment #place_order:hover, .woocommerce-page #payment #place_order:hover { background: '. $techt_secondary_color .' !important; }';
                $css .= '.woocommerce-form-coupon button[name="apply_coupon"]:hover, .woocommerce-form-coupon input[name="apply_coupon"][type="button"]:hover, .woocommerce-form-coupon input[name="apply_coupon"][type="reset"]:hover, .woocommerce-form-coupon input[name="apply_coupon"][type="submit"]:hover, .added_to_cart.wc-forward:hover { background: '. $techt_secondary_color .' !important; }';
                // $css .= '.return-to-shop a:hover, .woocommerce-button.button.woocommerce-form-login__submit:hover, .woocommerce-form-register .woocommerce-button.button.woocommerce-form-register__submit:hover, .woocommerce-MyAccount-content .woocommerce-Button.button:hover  { background: '. $techt_secondary_color .' !important; }';
                $css .= '.return-to-shop a:hover, .woocommerce-button.button:hover, .woocommerce-Button.button:hover { background: '. $techt_secondary_color .' !important; }';
                $css .= '.products .button.add_to_cart_button, .products .button.product_type_grouped, .products .button.product_type_external, .products .added_to_cart.wc-forward { background: '. $techt_secondary_color .' !important; }';
            }           

            // Portfolio Details Box Background Color
            if($techt_portfolio_details_bg_color){
                $css .= '.techt-portfolio-details-box {background-color: '.$techt_portfolio_details_bg_color .' ; } ';
            }
            // Return CSS
            if ( ! empty( $css ) ) {
                wp_add_inline_style( 'petrona-main-style', Techt_Utility::minify_css( $css ) );
            }
        }
    }
}

Techt_CSS_Helpers::instance();