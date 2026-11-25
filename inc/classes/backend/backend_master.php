<?php 
if ( ! defined( 'ABSPATH' ) ) die( esc_html__( 'Direct access forbidden.', 'petrona' ) );

class Techt_Backend_Master {

    /**
     * Call all loading functions for the theme. They will be started right after theme setup.
     * 
     * @since v1.0
     */
    public function __construct() { 
        // Run after instalation setup.
        $this->theme_setup();

        // Register actions using add_actions() custom function.
        $this->add_actions();
    }

    /**
     * Initial theme setup
     * 
     * Loading scripts and stylesheets. Register custom elements
     * and functionality in the theme.
     * 
     * @uses get_template_directory_uri()
     * @uses add_theme_support()
     * @since v1.0
     */
    public function theme_setup() {

        // Add after_setup_theme() for specific functions.
        // The action call is here, because it fits more just for the theme
        // setup, instead for all other actions during using of Subtle.
        add_action( 'after_setup_theme', array( $this, 'theme_setup_core' ) );

    }

    /**
     * The core functionality that has to be registred after the theme is setted up
     * 
     * @since v1.0
     */
    public function theme_setup_core() {
        get_template_part('inc/classes/backend/partials/action_after_setup_theme');
    }

    /**
     * Add actions and filters in WordPress theme. All the actions will be here.
     * 
     * @uses add_action()
     * @uses add_filter()
     * @since v1.0
     */
    public function add_actions() {

        // Disables the block editor from managing widgets.
        add_filter( 'use_widgets_block_editor', '__return_false' );

        // Register our Widgets
        add_action( 'widgets_init', array( $this, 'widgets_init' ) );

        //Remove p tag from contact form 7 forms
        add_filter('wpcf7_autop_or_not', '__return_false'); 

        //Load Perian Fonts
        add_action('admin_enqueue_scripts', array( $this, 'load_admin_persian_fonts' ), 999);

        add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'load_elementor_editor_persian_fonts' ));
        // Register all wp scripts and styles
        // add_action( 'admin_enqueue_scripts', array($this, 'load_admin_scripts_and_styles') );
    }

    /**
    * Loading scripts and stylesheets for Innocence
    * The order of initialising bootstrap css files is important
    * for the theme responsivness work proerly.
    * 
    * @uses custom widgets()
    * @since v1.0
    */
    public function widgets_init() {
        get_template_part('inc/classes/backend/partials/action_widgets_init');

        get_template_part('inc/classes/backend/widgets/class-techt-widget-recent-posts');

        if ( class_exists( 'Techt_Widget_Recent_Posts' ) ){
            register_widget( 'Techt_Widget_Recent_Posts' );
        }
        
    }

    public function load_admin_persian_fonts(){
        $url = get_theme_file_uri( '/assets/css/persian-fonts.css' );
        // Enqueue style
        if(! wp_style_is('techt-persian-font-vazir')){
            wp_enqueue_style( 'techt-persian-font-vazir', $url, array(), false );
        }
        
        wp_add_inline_style(
            'techt-persian-font-vazir',
            'body.rtl,body.rtl .press-this a.wp-switch-editor,body.rtl.wp-customizer h3, .rtl h1, .rtl h2, .rtl h3, .rtl h4, .rtl h5, .rtl h6,.rtl .e-notice{font-family: "Vazir", Arial, sans-serif;}
            .rtl p, .rtl .wp-die-message {font-size: 14px;}'
        );
    }

    public function load_elementor_editor_persian_fonts(){
        $url = get_theme_file_uri( '/assets/css/persian-fonts.css' );
        // Enqueue style
        if(! wp_style_is('techt-persian-font-vazir')){
            wp_enqueue_style( 'techt-persian-font-vazir', $url, array(), false );
        }

        wp_add_inline_style(
            'techt-persian-font-vazir',
            'body.rtl .elementor-panel,body.rtl .elementor-panel .elementor-element,body.rtl .elementor-panel-heading-title,body.rtl .MuiTypography-root,body.rtl .MuiButtonBase-root{font-family: "Vazir", Arial, sans-serif;}'
        );
    }
    public function load_admin_scripts_and_styles() {
        // get_template_part('inc/classes/backend/partials/action_admin_enqueue_scripts');
       
    } 

}

new Techt_Backend_Master; 
