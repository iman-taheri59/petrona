<?php
/**
 *  Petrona Besic Theme Settings
 *
 * @since Petrona 1.0
 *
 * @return array techt_customize_register
 *
*/

function techt_customize_register( $wp_customize ) {

    //Basic Post Message Settings
    $wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
    $wp_customize->get_section( 'title_tagline' )->title         = esc_html__( 'Logo & Site Identity', 'petrona' );

    // Changing for site Identity
    $wp_customize->selective_refresh->add_partial( 'blogname', array(
        'selector' => '.site-title a',
        'render_callback' => 'techt_customize_partial_blogname',
    ));
    $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
        'selector' => '.site-description',
        'render_callback' => 'techt_customize_partial_blogdescription',
    ));

    /* 2X Header Logo ---------------- */
    $wp_customize->add_setting(
        'retina_logo',
        array(
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'retina_logo',
        array(
            'type'        => 'checkbox',
            'section'     => 'title_tagline',
            'priority'    => 8,
            'label'       => esc_html__( 'Retina logo', 'petrona' ),
        )
    );

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {

        $wp_customize->get_section('colors')->description = esc_html__('Note: These settings are specific to the Default Pages or Sections and will not be applied to other sections created by Template Builder.', 'petrona');

        $wp_customize->add_setting( 'petrona_options[theme_header_background_colors]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['header_background_colors'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_header_background_colors]',
                array(
                    'label'     => esc_html__( 'Header Background Color', 'petrona' ),
                    'description' => esc_html__( 'Change the header background Color.', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[theme_header_border_colors]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['header_border_colors'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_header_border_colors]',
                array(
                    'label'     => esc_html__( 'Header Border Color', 'petrona' ),
                    'description' => esc_html__( 'Change the border colors of header bottom.', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        );         

        $wp_customize->add_setting( 'petrona_options[theme_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_color]',
                array(
                    'label'     => esc_html__( 'Theme Color', 'petrona' ),
                    'description' => esc_html__( 'Theme color option used mainly in button, widget title background, post category background etc.', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        );         

        $wp_customize->add_setting( 'petrona_options[theme_text_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_text_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_text_color]',
                array(
                    'label'     => esc_html__( 'Theme Text Color', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[theme_secondary_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_secondary_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_secondary_color]',
                array(
                    'label'     => esc_html__( 'Theme Secondary Color', 'petrona' ),
                    'description' => esc_html__( 'Theme secondary color mainly option used in button, tag, links hover effects.', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        );         

        $wp_customize->add_setting( 'petrona_options[theme_link_hover]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_link_hover'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_link_hover]',
                array(
                    'label'     => esc_html__( 'Theme Links Hover Color', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        ); 
        
        $wp_customize->add_setting( 'petrona_options[theme_cover_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_cover_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_cover_color]',
                array(
                    'label'     => esc_html__( 'Theme Covers Color', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        );    

        $wp_customize->add_setting( 'petrona_options[theme_input_border]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_input_border'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_input_border]',
                array(
                    'label'     => esc_html__( 'Input Border Color', 'petrona' ),
                    'description' => esc_html__( 'Input Border color is for all form input field, textarea, widget list item border colors.', 'petrona' ),
                    'section'   => 'colors',
                )
            )
        ); 
    }
 
    /**
     * Petrona WordPress Theme General Settings
     */  
    $wp_customize->add_panel(
        'petrona_general_options', array(
            'priority' => 25,
            'title'    => esc_html__( 'General Settings', 'petrona' ),
        )
    );

    $wp_customize->add_section( 'petrona_general_settings' , array(
        'title'      => esc_html__( 'General', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_general_options',
    ) );

    if ( class_exists( 'Techt_Toggle_Control' ) ) {

        $wp_customize->add_setting( 'petrona_options[combine_resource]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[combine_resource]', 
            array(
                'label'  => esc_html__( 'Combine Resource:', 'petrona' ),
                'type'   => 'ios',
                'description' => esc_html__('Combine All Theme CSS/JS into one', 'petrona'),
                'section'  => 'petrona_general_settings',
                'priority' => 10, 
                
            ) 
        ));           

        $wp_customize->add_setting( 'petrona_options[schema_markup]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[schema_markup]', 
            array(
                'label'  => esc_html__( 'Schema Markup:', 'petrona' ),
                'type'   => 'ios',
                'description' => esc_html__('Enable Schema Markup', 'petrona'),
                'section'  => 'petrona_general_settings',
                'priority' => 10, 
                
            ) 
        ));         

        $wp_customize->add_setting( 'petrona_options[custom_scrollbar]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[custom_scrollbar]', 
            array(
                'label'  => esc_html__( 'Custom Scrollbar:', 'petrona' ),
                'type'   => 'ios',
                'description' => esc_html__('Enable Custom Scrollbar at full site', 'petrona'),
                'section'  => 'petrona_general_settings',
                'priority' => 10, 
                
            ) 
        )); 
        
        $wp_customize->add_setting( 'petrona_options[enable_breadcrumb]', array(
            'default'     => true,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[enable_breadcrumb]', 
            array(
                'label'  => esc_html__( 'Breadcrumb:', 'petrona' ),
                'type'   => 'ios',
                'description' => esc_html__('Enable Breadcrumb at site', 'petrona'),
                'section'  => 'petrona_general_settings',
                'priority' => 10, 
                
            ) 
        ));
        
        $wp_customize->add_setting( 'petrona_options[enable_scroll_top]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[enable_scroll_top]', 
            array(
                'label'  => esc_html__( 'Scroll Top:', 'petrona' ),
                'type'   => 'ios',
                'description' => esc_html__('Enable Scroll Top at site', 'petrona'),
                'section'  => 'petrona_general_settings',
                'priority' => 10, 
                
            ) 
        ));   
    }


    if ( class_exists( 'Techt_Toggle_Control' ) ) {
        $wp_customize->add_setting( 'petrona_options[preloader]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[preloader]', 
            array(
                'label'  => esc_html__( 'Preloader:', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_general_settings',
                'priority' => 10, 
                
            ) 
        ));                     
    }

    $wp_customize->add_setting( 'petrona_options[preloader_type]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'techt_sanitize_select',
        'default' => 'predefine_preloader',
    ));

    $wp_customize->add_control( 'petrona_options[preloader_type]', array(
        'label' => esc_html__( 'Preloader Type ', 'petrona' ),
        'section' => 'petrona_general_settings',
        'type' => 'select',
        'active_callback' => 'techt_preloader_type_callback',
        'priority' => 10,
        'choices' => array(
            'predefine_preloader'  => esc_html__( 'Predefine Preloader', 'petrona' ),
            'custom_preloader'   => esc_html__( 'Custom Preloader', 'petrona' ),
        ),
    ));

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {
        $wp_customize->add_setting( 'petrona_options[theme_preloader_bg]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_preloader_bg'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_preloader_bg]',
                array(
                    'label'     => esc_html__( 'Preloader background', 'petrona' ),
                    'section'   => 'petrona_general_settings',
                    'active_callback' => 'techt_preloader_type_callback',
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[theme_preloader_color_1]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_preloader_color_1'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',            
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_preloader_color_1]',
                array(
                    'label'     => esc_html__( 'Preloader Color 1', 'petrona' ),
                    'section'   => 'petrona_general_settings',
                    'active_callback' => 'techt_preloader_predefine_type_callback',
                )
            )
        );
        
        $wp_customize->add_setting( 'petrona_options[theme_preloader_color_2]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_preloader_color_2'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',            
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_preloader_color_2]',
                array(
                    'label'     => esc_html__( 'Preloader Color 2', 'petrona' ),
                    'section'   => 'petrona_general_settings',
                    'active_callback' => 'techt_preloader_predefine_type_callback',
                )
            )
        );
        
        $wp_customize->add_setting( 'petrona_options[theme_preloader_color_3]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_preloader_color_3'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',            
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_preloader_color_3]',
                array(
                    'label'     => esc_html__( 'Preloader Color 3', 'petrona' ),
                    'section'   => 'petrona_general_settings',
                    'active_callback' => 'techt_preloader_predefine_type_callback',
                )
            )
        );     
    }  

    if( class_exists('Techt_Elementor_Widget') ) {
        // Header Template
        $preloader_args = array( 
            'post_type' => 'petrona_templates', 
            'posts_per_page' => -1,
            'meta_key' => 'petrona_template_types',
            'meta_value'  => 'preloader',
            'meta_compare' => '>=',
            'orderby'      => 'meta_value',
            'order'        => 'ASC',
            'meta_query'   => array(
                'relation' => 'OR',
                array(
                    'key'     => 'petrona_template_types',
                    'value'   => 'preloader',
                    'compare' => '==',
                    'type'    => 'page',
                ),
            ),
        );
        
        $get_preloader = get_posts($preloader_args);
        $preloader_template = array();
        if( $get_preloader ) {
            foreach ($get_preloader as $value) {
                $preloader_template['default'] = esc_html__('Default', 'petrona');
                $preloader_template[$value->ID] = $value->post_title;
            }
        } else {
            $preloader_template['default'] = esc_html__('Default', 'petrona');
        }

        $wp_customize->add_setting( 'petrona_options[preloader_templates]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_select',
            'default' => 'default',
        ));

        $wp_customize->add_control( 'petrona_options[preloader_templates]', array(
            'label' => esc_html__( 'Custom Preloader Template', 'petrona' ),
            'section' => 'petrona_general_settings',
            'type' => 'select',
            'priority' => 10,
            'choices' => $preloader_template,
            'active_callback' => 'techt_preloader_customs_type_callback',
        ));
    }


    //Container Settings
    $wp_customize->add_section( 'petrona_container_settings' , array(
        'title'      => esc_html__( 'Page Layout', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_general_options',
    ) );

    // Page Layout

    if ( class_exists( 'Techt_Customize_Control_Radio_Image' ) ) { 
        $page_sidebar_choices = array(
            'full'    => array(
                'url'   =>  get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/full-width.png' ),
                'label' => esc_html__( 'Full Width', 'petrona' ),
            ),
            'left'  => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-left.png' ),
                'label' => esc_html__( 'Left Sidebar', 'petrona' ),
            ),
            'right' => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-right.png' ),
                'label' => esc_html__( 'Right Sidebar', 'petrona' ),
            ),
        );

        $wp_customize->add_setting( 'petrona_options[page_sidebar_display]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_key',
            'type'      =>  'theme_mod',
            'default' => 'full',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Control_Radio_Image(
                $wp_customize, 'petrona_options[page_sidebar_display]', array(
                    'label'    => esc_html__( 'Sidebar Layout', 'petrona' ),
                    'section'  => 'petrona_container_settings',
                    'priority' => 20,
                    'choices'  => $page_sidebar_choices,
                )
            )
        );
    }

    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Page Padding
         */
        $wp_customize->add_setting( 'petrona_options[page_content_top_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 110,
        ) );
        $wp_customize->add_setting( 'petrona_options[page_content_bottom_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 75,
        ) );

        $wp_customize->add_setting( 'petrona_options[page_content_tablet_top_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 110,
        ) );
        $wp_customize->add_setting( 'petrona_options[page_content_tablet_bottom_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 75,
        ) );

        $wp_customize->add_setting( 'petrona_options[page_content_mobile_top_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 90,
        ) );
        $wp_customize->add_setting( 'petrona_options[page_content_mobile_bottom_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 60,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[page_content_padding]', array(
            'label'                 => esc_html__( 'Content Padding (px)', 'petrona' ),
            'section'               => 'petrona_container_settings',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[page_content_top_padding]',
                'desktop_bottom'    => 'petrona_options[page_content_bottom_padding]',
                'tablet_top'        => 'petrona_options[page_content_tablet_top_padding]',
                'tablet_bottom'     => 'petrona_options[page_content_tablet_bottom_padding]',
                'mobile_top'        => 'petrona_options[page_content_mobile_top_padding]',
                'mobile_bottom'     => 'petrona_options[page_content_mobile_bottom_padding]',
            ),
            'priority'              => 20,
            'input_attrs'           => array(
                'min'   => 0,
                'max'   => 100,
                'step'  => 1,
            ),
        ) ) );
    }


    //Theme Color
    $wp_customize->add_section( 'petrona_themecolor_settings' , array(
        'title'      => esc_html__( 'Theme Color Mode', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_general_options',
    ) );

    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_theme_chooser_heading', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_theme_chooser_heading', array(
            'label'     => esc_html__( 'Theme Mode', 'petrona' ),
            'section'   => 'petrona_themecolor_settings',
            'priority'  => 10,
        ) ) );
    } 

    if ( class_exists( 'Techt_Customize_Control_Radio_Image' ) ) { 
        $theme_version = array(
            'light'    => array(
                'url'   =>  get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/theme-light.png' ),
                'label' => esc_html__( 'Light', 'petrona' ),
            ),
            'dark'  => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/theme-dark.png' ),
                'label' => esc_html__( 'Dark', 'petrona' ),
            ),
        );

        $wp_customize->add_setting( 'petrona_options[theme_background_status]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_key',
            'type'      =>  'theme_mod',
            'default' => 'light',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Control_Radio_Image(
                $wp_customize, 'petrona_options[theme_background_status]', array(
                    'label'    => esc_html__( 'Theme Status', 'petrona' ),
                    'section'  => 'petrona_themecolor_settings',
                    'priority' => 10,
                    'choices'  => $theme_version,
                )
            )
        );
    }  

    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_theme_chooser_light_heading', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_theme_chooser_light_heading', array(
            'label'     => esc_html__( 'Light Version', 'petrona' ),
            'section'   => 'petrona_themecolor_settings',
            'priority'  => 10,
        ) ) );
    } 

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {

        $wp_customize->add_setting( 'petrona_options[theme_background_light_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_background_light_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_background_light_color]',
                array(
                    'label'     => esc_html__( 'Theme Background Color', 'petrona' ),
                    'section'   => 'petrona_themecolor_settings',
                )
            )
        );        
    } 

    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_theme_chooser_dark_heading', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_theme_chooser_dark_heading', array(
            'label'     => esc_html__( 'Dark Version', 'petrona' ),
            'section'   => 'petrona_themecolor_settings',
            'priority'  => 10,
        ) ) );
    } 

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {

        $wp_customize->add_setting( 'petrona_options[theme_background_dark_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['theme_background_dark_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[theme_background_dark_color]',
                array(
                    'label'     => esc_html__( 'Theme Background Color', 'petrona' ),
                    'section'   => 'petrona_themecolor_settings',
                )
            )
        );        
    } 

    /**
     * Header panel
     */
    $wp_customize->add_panel(
        'petrona_header_settings', array(
            'priority' => 25,
            'title'    => esc_html__( 'Header Settings', 'petrona' ),
        )
    );

    // Logo Section
    $wp_customize->add_section(
        'petrona_logo_section', array(
            'title'    => esc_html__( 'Logo Settings', 'petrona' ),
            'panel'    => 'petrona_header_settings',
            'priority' => 10,
            'description' => esc_html__('Note: These settings are specific to the Default Header and will not be applied to headers created by Template Builder.', 'petrona'),
        )
    );

    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Blog Padding
         */
        $wp_customize->add_setting( 'petrona_options[logo_top_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[logo_bottom_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[logo_tablet_top_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[logo_tablet_bottom_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[logo_mobile_top_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[logo_mobile_bottom_padding]', array(
            'transport'             => 'postMessage',
            'capability'            => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[logo_padding]', array(
            'label'                 => esc_html__( 'Logo Padding (px)', 'petrona' ),
            'section'               => 'petrona_logo_section',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[logo_top_padding]',
                'desktop_bottom'    => 'petrona_options[logo_bottom_padding]',
                'tablet_top'        => 'petrona_options[logo_tablet_top_padding]',
                'tablet_bottom'     => 'petrona_options[logo_tablet_bottom_padding]',
                'mobile_top'        => 'petrona_options[logo_mobile_top_padding]',
                'mobile_bottom'     => 'petrona_options[logo_mobile_bottom_padding]',
            ),
            'priority'              => 10,
            'input_attrs'           => array(
                'min'   => 0,
                'max'   => 100,
                'step'  => 1,
            ),
        ) ) );
    }

    if ( class_exists( 'Techt_Customizer_Range_Value_Control' ) ) {
        $wp_customize->add_setting(
            'petrona_options[logo_max_width]', array(
                'sanitize_callback' => 'techt_sanitize_number_range',
                'default'           => 156,
            )
        );

        $wp_customize->add_control(
            new Techt_Customizer_Range_Value_Control(
                $wp_customize, 'petrona_options[logo_max_width]', array(
                    'label'       => esc_html__( 'Set Logo Max Width:', 'petrona' ),
                    'description' => esc_html__('Select your logo max width from here.', 'petrona'),
                    'section'     => 'petrona_logo_section',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 550,
                        'step' => 1,
                    ),
                    'priority'    => 10,
                    'sum_type'    => false,
                )
            )
        );        

        $wp_customize->add_setting(
            'petrona_options[header_heights]', array(
                'sanitize_callback' => 'techt_sanitize_number_range',
                'default'           => 130,
            )
        );

        $wp_customize->add_control(
            new Techt_Customizer_Range_Value_Control(
                $wp_customize, 'petrona_options[header_heights]', array(
                    'label'       => esc_html__( 'Set Header Hight:', 'petrona' ),
                    'description' => esc_html__('Select your header hight from here from here.', 'petrona'),
                    'section'     => 'petrona_logo_section',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 550,
                        'step' => 1,
                    ),
                    'priority'    => 10,
                    'sum_type'    => false,
                )
            )
        );
    } 

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {
        $wp_customize->add_setting( 'petrona_options[site_branding_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['site_branding_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[site_branding_color]',
                array(
                    'label'     => esc_html__( 'Site Title Color', 'petrona' ),
                    'section'   => 'petrona_logo_section',
                    'priority'  => 20,
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[site_description_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['site_description_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[site_description_color]',
                array(
                    'label'     => esc_html__( 'Site Description Color', 'petrona' ),
                    'section'   => 'petrona_logo_section',
                    'priority'  => 20,
                )
            )
        );
    } 

    $wp_customize->add_section(
        'petrona_menu_section', array(
            'title'    => esc_html__( 'Menu Settings', 'petrona' ),
            'panel'    => 'petrona_header_settings',
            'description' => esc_html__('Note: These settings are specific to the Default Header and will not be applied to Custom Headers created by Template Builder.', 'petrona'),
            'priority' => 15,
        )
    );

    // Main Menu 
    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {
        $wp_customize->add_setting( 'petrona_options[menu_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['menu_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[menu_color]',
                array(
                    'label'     => esc_html__( 'Main Menu Color', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[main_menu_hover_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['main_menu_hover_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[main_menu_hover_color]',
                array(
                    'label'     => esc_html__( 'Main Menu Hover Color', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[main_menu_separator_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['main_menu_separator_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[main_menu_separator_color]',
                array(
                    'label'     => esc_html__( 'Menu Active Dot Color', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        );
    } 

    // Sub dropdown Heading 
    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_menu_main_styling_heading', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_menu_main_styling_heading', array(
            'label'                 => esc_html__( 'Dropdown Styling', 'petrona' ),
            'section'               => 'petrona_menu_section',
            'priority'              => 20,
        ) ) );
    }

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {
        $wp_customize->add_setting( 'petrona_options[dropdown_menu_bg]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['dropdown_menu_bg'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[dropdown_menu_bg]',
                array(
                    'label'     => esc_html__( 'Sub Menu Background', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[dropdown_menu_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['dropdown_menu_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[dropdown_menu_color]',
                array(
                    'label'     => esc_html__( 'Sub Menu Text Color', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        ); 
    }

    if ( class_exists( 'Techt_Customizer_Range_Value_Control' ) ) {
        $wp_customize->add_setting(
            'petrona_options[dropdown_menu_width]', array(
                'sanitize_callback' => 'techt_sanitize_number_range',
                'default'           => 240,
            )
        );

        $wp_customize->add_control(
            new Techt_Customizer_Range_Value_Control(
                $wp_customize, 'petrona_options[dropdown_menu_width]', array(
                    'label'       => esc_html__( 'Dropdown Menu Width:', 'petrona' ),
                    'description' => esc_html__('Select your dropdown menu width', 'petrona'),
                    'section'     => 'petrona_menu_section',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 550,
                        'step' => 0.1,
                    ),
                    'priority'    => 20,
                    'sum_type'    => false,
                )
            )
        );
    } 

    // Sub dropdown Heading 
    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_mobile_main_styling_heading', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_mobile_main_styling_heading', array(
            'label'                 => esc_html__( 'Mobile Menu Styling', 'petrona' ),
            'section'               => 'petrona_menu_section',
            'priority'              => 20,
        ) ) );
    }

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {
        $wp_customize->add_setting( 'petrona_options[mobile_menu_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['mobile_menu_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[mobile_menu_color]',
                array(
                    'label'     => esc_html__( 'Menu Color', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        );        

        $wp_customize->add_setting( 'petrona_options[mobile_menu_bg]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['mobile_menu_bg'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[mobile_menu_bg]',
                array(
                    'label'     => esc_html__( 'Menu Background', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        );         

        $wp_customize->add_setting( 'petrona_options[mobile_menu_hamburger_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['mobile_menu_hamburger_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Alpha_Color_Control(
                $wp_customize,
                'petrona_options[mobile_menu_hamburger_color]',
                array(
                    'label'     => esc_html__( 'Hamburger Indicator Color', 'petrona' ),
                    'section'   => 'petrona_menu_section',
                    'priority'  => 20,
                )
            )
        ); 
    }

    $wp_customize->add_section(
        'petrona_header_content_section', array(
            'title'    => esc_html__( 'Content Settings', 'petrona' ),
            'panel'    => 'petrona_header_settings',
            'priority' => 15,
        )
    );

    if ( class_exists( 'Techt_Toggle_Control' ) ) {      
        $wp_customize->add_setting( 'petrona_options[header_full_width]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[header_full_width]', 
            array(
                'label'  => esc_html__( 'Header Full Width:', 'petrona' ),
                'description' => esc_html__( 'If you want to make your header full width then enable this options.', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_header_content_section',
                'priority' => 10, 
                
            ) 
        ));   
    }

    if ( class_exists( 'Techt_Toggle_Control' ) ) {    

        $wp_customize->add_setting( 'petrona_options[enable_sticky_headers]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[enable_sticky_headers]', 
            array(
                'label'  => esc_html__( 'Sticky Header:', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_header_content_section',
                'priority' => 10, 
                
            ) 
        )); 

        $wp_customize->add_setting( 'petrona_options[transparent_header]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[transparent_header]', 
            array(
                'label'  => esc_html__( 'Transparent Header:', 'petrona' ),
                'description' => esc_html__( 'If you want to make your header transparent then enable this options.', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_header_content_section',
                'priority' => 10, 
                
            ) 
        ));  
    }

    $wp_customize->add_setting( 'petrona_options[header_type]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'techt_sanitize_select',
        'default' => 'predefine_header',
    ));

    $wp_customize->add_control( 'petrona_options[header_type]', array(
        'label' => esc_html__( 'Header Type ', 'petrona' ),
        'description' => esc_html__( 'We had predefine header and header builder as well. if you don\'t like our header then you can build your header from switching Custom Header.', 'petrona' ),
        'section' => 'petrona_header_content_section',
        'type' => 'select',
        'priority' => 10,
        'choices' => array(
            'predefine_header'  => esc_html__( 'Predefine Header', 'petrona' ),
            'custom_header'   => esc_html__( 'Custom Header', 'petrona' ),
        ),
    ));


    if( class_exists('Techt_Elementor_Widget') ) {
        // Header Template
        $header_args = array( 
            'post_type' => 'petrona_templates', 
            'posts_per_page' => -1,
            'meta_key' => 'petrona_template_types',
            'meta_value'  => 'header',
            'meta_compare' => '>=',
            'orderby'      => 'meta_value',
            'order'        => 'ASC',
            'meta_query'   => array(
                'relation' => 'OR',
                array(
                    'key'     => 'petrona_template_types',
                    'value'   => 'header',
                    'compare' => '==',
                    'type'    => 'page',
                ),
            ),
        );
        
        $get_header = get_posts($header_args);
        $header_template = array();
        if( $get_header ) {
            foreach ($get_header as $value) {
                $header_template['default'] = esc_html__('Default', 'petrona');
                $header_template[$value->ID] = $value->post_title;
            }
        } else {
            $header_template['default'] = esc_html__('Default', 'petrona');
        }

        $wp_customize->add_setting( 'petrona_options[header_templates]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_select',
            'default' => 'default',
        ));

        $wp_customize->add_control( 'petrona_options[header_templates]', array(
            'label' => esc_html__( 'Custom Template', 'petrona' ),
            'section' => 'petrona_header_content_section',
            'type' => 'select',
            'priority' => 10,
            'choices' => $header_template,
            'active_callback' => 'techt_header_type_callback',
        ));

        $wp_customize->add_setting( 'petrona_options[header_sticky_templates]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_select',
            'default' => 'default',
        ));

        $wp_customize->add_control( 'petrona_options[header_sticky_templates]', array(
            'label' => esc_html__( 'Sticky Header Template', 'petrona' ),
            'section' => 'petrona_header_content_section',
            'type' => 'select',
            'priority' => 10,
            'choices' => $header_template,
            'active_callback' => 'techt_sticky_header_type_callback',
        ));
    }
    //End Header 

    /**
     * Petrona WordPress Theme Blog Settings
     */ 
    $wp_customize->add_panel(
        'petrona_blog_options', array(
            'priority' => 50,
            'title'    => esc_html__( 'Blog Settings', 'petrona' ),
        )
    );

    $wp_customize->add_section( 'petrona_blog_entries_settings' , array(
        'title'      => esc_html__( 'Blog Entries', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_blog_options',
    ) );

    $wp_customize->add_section( 'petrona_blog_single_settings' , array(
        'title'      => esc_html__( 'Blog Single', 'petrona' ),
        'priority'   => 10,  
        'panel'    => 'petrona_blog_options', 
    ));    

    $wp_customize->add_setting(
        'petrona_options[blog_title_info]', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_adtecht_html',
            'type'      =>  'theme_mod',
            'default'   => esc_html__( 'Latest Articles', 'petrona' ),
        )
    );

    $wp_customize->add_control(
        'petrona_options[blog_title_info]', array(
            'label' => esc_html__( 'Blog Title:', 'petrona' ),
            'type' => 'text',
            'priority' => 10,
            'section' => 'petrona_blog_entries_settings',
        )
    );    

    if ( class_exists( 'Techt_Customize_Control_Radio_Image' ) ) { 
        $sidebar_choices = array(
            'full'    => array(
                'url'   =>  get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/full-width.png' ),
                'label' => esc_html__( 'Full Width', 'petrona' ),
            ),
            'left'  => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-left.png' ),
                'label' => esc_html__( 'Left Sidebar', 'petrona' ),
            ),
            'right' => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-right.png' ),
                'label' => esc_html__( 'Right Sidebar', 'petrona' ),
            ),
        );

        $wp_customize->add_setting( 'petrona_options[blog_sidebar_display]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_key',
            'type'      =>  'theme_mod',
            'default' => 'left',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Control_Radio_Image(
                $wp_customize, 'petrona_options[blog_sidebar_display]', array(
                    'label'    => esc_html__( 'Sidebar Layout', 'petrona' ),
                    'section'  => 'petrona_blog_entries_settings',
                    'priority' => 10,
                    'choices'  => $sidebar_choices,
                )
            )
        );        
    }

    $wp_customize->add_setting( 'petrona_options[blog_sidebar_status]', array(
        'capability' => 'edit_theme_options',
        'default' => 'normal',
        'sanitize_callback' => 'techt_sanitize_select',
    ) );

    $wp_customize->add_control( 'petrona_options[blog_sidebar_status]', array(
        'type' => 'radio',
        'section' => 'petrona_blog_entries_settings', // Add a default or your own section
        'label' => esc_html__( 'Sidebar Status', 'petrona' ),
        'priority' => 10,
        'choices' => array(
            'normal' => esc_html__( 'Normal', 'petrona' ),
            'sticky' => esc_html__( 'Sticky', 'petrona' ),
        ),
        'active_callback' => 'techt_blog_layout_sidebar_callback',
    ) );

    if( class_exists('Techt_Customizer_Sortable_Control') ) {  
        $wp_customize->add_setting( 'petrona_options[blog_enries_content]', array(
            'default' => array( 'featured_image', 'category', 'title', 'content', 'post_meta' ),
            'capability' => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_multi_choices',
        ) );

        $wp_customize->add_control( 
            new Techt_Customizer_Sortable_Control( $wp_customize, 'petrona_options[blog_enries_content]', array(
            'label'                 => esc_html__( 'Elements Positioning', 'petrona' ),
            'description'           => esc_html__( 'Some elements are not works at some layout. Please reload interface after change the blog layout', 'petrona' ),
            'section'               => 'petrona_blog_entries_settings',
            'settings'              => 'petrona_options[blog_enries_content]',
            'priority'              => 20,
            'choices'               => techt_blog_entries_elements(),
        ) ) );
    }

    $wp_customize->add_setting( 'petrona_options[pagination_types]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'techt_sanitize_select',
        'default' => 'page_number',
    ));

    $wp_customize->add_control( 'petrona_options[pagination_types]', array(
        'label' => esc_html__( 'Pagination Type ', 'petrona' ),
        'section' => 'petrona_blog_entries_settings',
        'type' => 'select',
        'priority' => 20,
        'choices' => array(
            'load_more'  => esc_html__( 'Load More', 'petrona' ),
            'page_number'   => esc_html__( 'Page Number', 'petrona' ),
        ),
    ));

    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Blog Padding
         */
        $wp_customize->add_setting( 'petrona_options[top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 90,
        ) );
        $wp_customize->add_setting( 'petrona_options[bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 60,
        ) );

        $wp_customize->add_setting( 'petrona_options[tablet_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 90,
        ) );
        $wp_customize->add_setting( 'petrona_options[tablet_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 60,
        ) );

        $wp_customize->add_setting( 'petrona_options[mobile_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 90,
        ) );
        $wp_customize->add_setting( 'petrona_options[mobile_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 60,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[blog_padding]', array(
            'label'                 => esc_html__( 'Spacing (px)', 'petrona' ),
            'section'               => 'petrona_blog_entries_settings',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[top_padding]',
                'desktop_bottom'    => 'petrona_options[bottom_padding]',
                'tablet_top'        => 'petrona_options[tablet_top_padding]',
                'tablet_bottom'     => 'petrona_options[tablet_bottom_padding]',
                'mobile_top'        => 'petrona_options[mobile_top_padding]',
                'mobile_bottom'     => 'petrona_options[mobile_bottom_padding]',
            ),
            'priority'              => 20,
            'input_attrs'           => array(
                'min'   => 0,
                'max'   => 400,
                'step'  => 1,
            ),
        ) ) );
    }

    $wp_customize->add_setting( 'petrona_options[excerpt_length]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        'type'      =>  'theme_mod',
        'default' => 25,
    ));

    $wp_customize->add_control( 'petrona_options[excerpt_length]', array(
        'label' => esc_html__( 'Excerpt Length: ', 'petrona' ),
        'description' => esc_html__( 'How many words want to show per page?', 'petrona' ),
        'section' => 'petrona_blog_entries_settings',
        'type'        => 'number',
        'priority' => 20,
        'input_attrs' => array(
            'min'  => 1,
            'max'   => 100,
            'step' => 1,
        ),
    ));


    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Blog Padding
         */
        $wp_customize->add_setting( 'petrona_options[blog_single_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[blog_single_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[blog_single_tablet_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[blog_single_tablet_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[blog_single_mobile_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[blog_single_mobile_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[blog_single_padding]', array(
            'label'                 => esc_html__( 'Spacing (px)', 'petrona' ),
            'section'               => 'petrona_blog_single_settings',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[blog_single_top_padding]',
                'desktop_bottom'    => 'petrona_options[blog_single_bottom_padding]',
                'tablet_top'        => 'petrona_options[blog_single_tablet_top_padding]',
                'tablet_bottom'     => 'petrona_options[blog_single_tablet_bottom_padding]',
                'mobile_top'        => 'petrona_options[blog_single_mobile_top_padding]',
                'mobile_bottom'     => 'petrona_options[blog_single_mobile_bottom_padding]',
            ),
            'priority'              => 10,
            'input_attrs'           => array(
                'min'   => 0,
                'max'   => 400,
                'step'  => 1,
            ),
        ) ) );
    }
    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Blog Padding
         */
        $wp_customize->add_setting( 'petrona_options[blog_single_top_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[blog_single_bottom_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[blog_single_tablet_top_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[blog_single_tablet_bottom_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[blog_single_mobile_top_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[blog_single_mobile_bottom_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[blog_single_margin]', array(
            'label'                 => esc_html__( 'Blog Content Margin (px)', 'petrona' ),
            'section'               => 'petrona_blog_single_settings',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[blog_single_top_margin]',
                'desktop_bottom'    => 'petrona_options[blog_single_bottom_margin]',
                'tablet_top'        => 'petrona_options[blog_single_tablet_top_margin]',
                'tablet_bottom'     => 'petrona_options[blog_single_tablet_bottom_margin]',
                'mobile_top'        => 'petrona_options[blog_single_mobile_top_margin]',
                'mobile_bottom'     => 'petrona_options[blog_single_mobile_bottom_margin]',
            ),
            'priority'              => 10,
            'input_attrs'           => array(
                'min'   => -400,
                'max'   => 400,
                'step'  => 1,
            ),
        ) ) );
    }

    if ( class_exists( 'Techt_Customize_Control_Radio_Image' ) ) { 
        $sidebar_single_choices = array(
            'full'    => array(
                'url'   =>  get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/full-width.png' ),
                'label' => esc_html__( 'Full Width', 'petrona' ),
            ),
            'left'  => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-left.png' ),
                'label' => esc_html__( 'Left Sidebar', 'petrona' ),
            ),
            'right' => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-right.png' ),
                'label' => esc_html__( 'Right Sidebar', 'petrona' ),
            ),
        );

        $wp_customize->add_setting( 'petrona_options[blog_single_sidebar_display]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_key',
            'type'      =>  'theme_mod',
            'default' => 'left',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Control_Radio_Image(
                $wp_customize, 'petrona_options[blog_single_sidebar_display]', array(
                    'label'    => esc_html__( 'Sidebar Layout', 'petrona' ),
                    'section'  => 'petrona_blog_single_settings',
                    'priority' => 10,
                    'choices'  => $sidebar_single_choices,
                )
            )
        );
    }

    $wp_customize->add_setting( 'petrona_options[sidebar_status]', array(
        'capability' => 'edit_theme_options',
        'default' => 'normal',
        'sanitize_callback' => 'techt_sanitize_select',
    ) );

    $wp_customize->add_control( 'petrona_options[sidebar_status]', array(
        'type' => 'radio',
        'section' => 'petrona_blog_single_settings', // Add a default or your own section
        'label' => esc_html__( 'Sidebar Status', 'petrona' ),
        'priority' => 10,
        'choices' => array(
            'normal' => esc_html__( 'Normal', 'petrona' ),
            'sticky' => esc_html__( 'Sticky', 'petrona' ),
        ),
        'active_callback' => 'techt_blog_single_sidebar_stauts_callback',
    ) );

    $wp_customize->add_setting( 'petrona_options[blog_single_feature_image_status]', array(
        'capability' => 'edit_theme_options',
        'default' => 'normal',
        'sanitize_callback' => 'techt_sanitize_select',
    ) );

    $wp_customize->add_control( 'petrona_options[blog_single_feature_image_status]', array(
        'type' => 'radio',
        'section' => 'petrona_blog_single_settings', // Add a default or your own section
        'label' => esc_html__( 'Featured Image Wide', 'petrona' ),
        'priority' => 10,
        'choices' => array(
            'normal' => esc_html__( 'Normal', 'petrona' ),
            'wide' => esc_html__( 'Wide', 'petrona' ),
            'full' => esc_html__( 'Full', 'petrona' ),
        ),
        'active_callback' => 'techt_blog_single_featured_image_callback',
    ) );

    $wp_customize->add_setting( 'petrona_options[blog_single_content_width_status]', array(
        'capability' => 'edit_theme_options',
        'default' => 'wide',
        'sanitize_callback' => 'techt_sanitize_select',
    ) );

    $wp_customize->add_control( 'petrona_options[blog_single_content_width_status]', array(
        'type' => 'radio',
        'section' => 'petrona_blog_single_settings', // Add a default or your own section
        'label' => esc_html__( 'Content Width Status', 'petrona' ),
        'priority' => 10,
        'choices' => array(
            'normal' => esc_html__( 'Normal', 'petrona' ),
            'wide' => esc_html__( 'Wide', 'petrona' ),
        ),
        'active_callback' => 'techt_blog_single_featured_image_callback',
    ) );

    $wp_customize->add_setting( 'petrona_options[blog_single_title_in_hero]', array(
        'default'     => true,
        'sanitize_callback' => 'techt_sanitize_checkbox',
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
        'petrona_options[blog_single_title_in_hero]', 
        array(
            'label'  => esc_html__( 'Title in Hero Image:', 'petrona' ),
            'type'   => 'ios',
            'description' => esc_html__('Enable Show Title in Hero Image', 'petrona'),
            'section'  => 'petrona_blog_single_settings',
            'priority' => 10, 
            
        ) 
    )); 
    if( class_exists('Techt_Customizer_Sortable_Control') ) {  
        $wp_customize->add_setting( 'petrona_options[blog_single_enries_content]', array(
            'default' => array( 'featured_image', 'category', 'title', 'post_meta', 'content', 'tag', 'social_share' ),
            'capability' => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_multi_choices',
        ) );

        $wp_customize->add_control( 
            new Techt_Customizer_Sortable_Control( $wp_customize, 'petrona_options[blog_single_enries_content]', array(
            'label'                 => esc_html__( 'Content Elements Positioning', 'petrona' ),
            'description'           => esc_html__( 'Enable or disable content if you don\'t want it. Or move content position by drag and drop.', 'petrona' ),
            'section'               => 'petrona_blog_single_settings',
            'settings'              => 'petrona_options[blog_single_enries_content]',
            'priority'              => 10,
            'choices'               => techt_blog_single_entries_elements(),
        ) ) );       

        $wp_customize->add_setting( 'petrona_options[blog_single_sections_content]', array(
            'default' => array( 'blog_content', 'related_posts', 'comments', 'post_pagination' ),
            'capability' => 'edit_theme_options',
            'sanitize_callback'     => 'techt_sanitize_multi_choices',
        ) );

        $wp_customize->add_control( 
            new Techt_Customizer_Sortable_Control( $wp_customize, 'petrona_options[blog_single_sections_content]', array(
            'label'                 => esc_html__( 'Section Positioning', 'petrona' ),
            'description'           => esc_html__( 'Enable or disable content if you don\'t want it. Or move content position by drag and drop.', 'petrona' ),
            'section'               => 'petrona_blog_single_settings',
            'settings'              => 'petrona_options[blog_single_sections_content]',
            'priority'              => 10,
            'choices'               => techt_blog_single_sections_elements(),
        ) ) );
    }

    $wp_customize->add_setting( 'petrona_options[related_posts_query_type]', array(
        'capability' => 'edit_theme_options',
        'default' => 'category',
        'sanitize_callback' => 'techt_sanitize_select',
    ) );

    $wp_customize->add_control( 'petrona_options[related_posts_query_type]', array(
        'type' => 'radio',
        'section' => 'petrona_blog_single_settings', // Add a default or your own section
        'label' => esc_html__( 'Related Post Query', 'petrona' ),
        'priority' => 10,
        'choices' => array(
            'category' => esc_html__( 'Categories', 'petrona' ),
            'tag' => esc_html__( 'Tags', 'petrona' ),
        ),
    ) );

    $wp_customize->add_setting( 'petrona_options[related_posts_number]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
        'type'      =>  'theme_mod',
        'default' => 2,
    ));

    $wp_customize->add_control( 'petrona_options[related_posts_number]', array(
        'label' => esc_html__( 'Show Related Posts Items: ', 'petrona' ),
        'description' => esc_html__( 'How many related post want to show per page?', 'petrona' ),
        'section' => 'petrona_blog_single_settings',
        'type'        => 'number',
        'priority' => 10,
        'input_attrs' => array(
            'min'  => 1,
            'max'   => 100,
            'step' => 1,
        ),
    ));

    $wp_customize->add_section(
        'petrona_woocommerce_setting', array(
            'priority' => 100,
            'title'    => esc_html__( 'Petrona WooCommerce', 'petrona' ),
            'panel'    => 'woocommerce',
        )
    );

    if ( class_exists( 'Techt_Customize_Control_Radio_Image' ) ) { 
        $woo_sidebar_choices = array(
            'full'    => array(
                'url'   =>  get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/full-width.png' ),
                'label' => esc_html__( 'Full Width', 'petrona' ),
            ),
            'left'  => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-left.png' ),
                'label' => esc_html__( 'Left Sidebar', 'petrona' ),
            ),
            'right' => array(
                'url'   => get_theme_file_uri( '/inc/customizer/customizer-radio-image/img/sidebar-right.png' ),
                'label' => esc_html__( 'Right Sidebar', 'petrona' ),
            ),
        );

        $wp_customize->add_setting( 'petrona_options[woo_sidebar_display]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_key',
            'type'      =>  'theme_mod',
            'default' => 'full',
        ));

        $wp_customize->add_control(
            new Techt_Customize_Control_Radio_Image(
                $wp_customize, 'petrona_options[woo_sidebar_display]', array(
                    'label'    => esc_html__( 'Archive Sidebar Layout', 'petrona' ),
                    'section'  => 'petrona_woocommerce_setting',
                    'priority' => 10,
                    'choices'  => $woo_sidebar_choices,
                )
            )
        );
    }


    /**
     * End Petrona WordPress Theme Footer Control Panel
     */
    $wp_customize->add_panel(
        'petrona_footer', array(
            'priority' => 100,
            'title'    => esc_html__( 'Footer Settings', 'petrona' ),
        )
    );

    $wp_customize->add_section( 'petrona_footer_general' , array(
        'title'      => esc_html__( 'General', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_footer',
    ) );

    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Footer Padding
         */
        $wp_customize->add_setting( 'petrona_options[footer_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[footer_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[footer_tablet_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[footer_tablet_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[footer_mobile_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[footer_mobile_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[footer_padding]', array(
            'label'                 => esc_html__( 'Spacing (px)', 'petrona' ),
            'section'               => 'petrona_footer_general',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[footer_top_padding]',
                'desktop_bottom'    => 'petrona_options[footer_bottom_padding]',
                'tablet_top'        => 'petrona_options[footer_tablet_top_padding]',
                'tablet_bottom'     => 'petrona_options[footer_tablet_bottom_padding]',
                'mobile_top'        => 'petrona_options[footer_mobile_top_padding]',
                'mobile_bottom'     => 'petrona_options[footer_mobile_bottom_padding]',
            ),
            'priority'              => 5,
            'input_attrs'           => array(
                'min'   => 0,
                'max'   => 400,
                'step'  => 1,
            ),
        ) ) );
    }

    if ( class_exists( 'Techt_Toggle_Control' ) ) {
        $wp_customize->add_setting( 'petrona_options[full_footer_content]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[full_footer_content]', 
            array(
                'label'  => esc_html__( 'Full Width Footer:', 'petrona' ),
                'description' => esc_html__( 'If you want to make your footer full width then enable this options.', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_footer_general',                
            ) 
        ));          

        $wp_customize->add_setting( 'petrona_options[fixed_footer]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[fixed_footer]', 
            array(
                'label'  => esc_html__( 'Fixed Footer:', 'petrona' ),
                'description' => esc_html__( 'If you want to make your footer fixed then enable this options.', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_footer_general',                
            ) 
        ));  
    }

    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_theme_footer_colors', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_theme_footer_colors', array(
            'label'     => esc_html__( 'Footer Color Settings', 'petrona' ),
            'section'   => 'petrona_footer_general',
            'description' => esc_html__('Note: These settings will not be applied to Footers created by Template builder.', 'petrona'),
            'priority'  => 10,
        ) ) );
    } 

    if( class_exists('Techt_Customize_Alpha_Color_Control') ) {
        $wp_customize->add_setting( 'petrona_options[footer_bg_colors]' , array(
            'sanitize_callback' => 'techt_sanitize_rgba',
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_bg_colors'],
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_bg_colors]', array(
               'label'    => esc_html__( 'Background Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));         

        $wp_customize->add_setting( 'petrona_options[footer_top_border_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_top_border_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_top_border_color]', array(
               'label'    => esc_html__( 'Top Border Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        )); 

        $wp_customize->add_setting( 'petrona_options[footer_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_color]', array(
               'label'    => esc_html__( 'Text Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));          

        $wp_customize->add_setting( 'petrona_options[footer_widget_title]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_widget_title'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_widget_title]', array(
               'label'    => esc_html__( 'Widget Title Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));            

        $wp_customize->add_setting( 'petrona_options[footer_link_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_link_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_link_color]', array(
               'label'    => esc_html__( 'Link Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));        

        $wp_customize->add_setting( 'petrona_options[footer_link_hover_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_link_hover_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_link_hover_color]', array(
               'label'    => esc_html__( 'Link Hover Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));        

        $wp_customize->add_setting( 'petrona_options[footer_copy_color]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_copy_color'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_copy_color]', array(
               'label'    => esc_html__( 'Copyright Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));

        $wp_customize->add_setting( 'petrona_options[footer_copy_border_top]' , array(
            'default'     => Techt_CSS_Helpers::$petrona_colors['footer_copy_border_top'],
            'sanitize_callback' => 'techt_sanitize_rgba',
            'capability' => 'edit_theme_options',
            'type'      =>  'theme_mod',
        ));

        $wp_customize->add_control( 
            new Techt_Customize_Alpha_Color_Control( $wp_customize, 'petrona_options[footer_copy_border_top]', array(
               'label'    => esc_html__( 'Copyright Border Top Color: ', 'petrona' ),
               'section'  => 'petrona_footer_general',
            ) 
        ));
    }

    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_theme_footer_template', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_theme_footer_template', array(
            'label'     => esc_html__( 'Footer Template', 'petrona' ),
            'section'   => 'petrona_footer_general',
            'priority'  => 10,
        ) ) );
    } 

    $wp_customize->add_setting( 'petrona_options[footer_type]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'techt_sanitize_select',
        'default' => 'predefine_footer',
    ));

    $wp_customize->add_control( 'petrona_options[footer_type]', array(
        'label' => esc_html__( 'Footer Type ', 'petrona' ),
        'description' => esc_html__( 'We had predefine footer and footer builder as well. if you don\'t like our footer then you can build your footer from switching Custom Footer.', 'petrona' ),
        'section' => 'petrona_footer_general',
        'type' => 'select',
        'priority' => 20,
        'choices' => array(
            'predefine_footer'  => esc_html__( 'Predefine Footer', 'petrona' ),
            'custom_footer'   => esc_html__( 'Custom Footer', 'petrona' ),
        ),
    ));

    if( class_exists('Techt_Elementor_Widget') ) {
        // Footer Templates Query
        $footer_args = array( 
            'post_type' => 'petrona_templates', 
            'posts_per_page' => -1,
            'meta_key' => 'petrona_template_types',
            'meta_value'  => 'footer',
            'meta_compare' => '>=',
            'orderby'      => 'meta_value',
            'order'        => 'ASC',
            'meta_query'   => array(
                'relation' => 'OR',
                array(
                    'key'     => 'petrona_template_types',
                    'value'   => 'footer',
                    'compare' => '==',
                    'type'    => 'page',
                ),
            ),
        );

        $get_footer = get_posts($footer_args);
        $footer_template = array();
        if( $get_footer ) {
            foreach ($get_footer as $value) {
                $footer_template['default'] = esc_html__('Default', 'petrona');
                $footer_template[$value->ID] = $value->post_title;
            }
        } else {
            $footer_template['default'] = esc_html__('Default', 'petrona');
        }

        $wp_customize->add_setting( 'petrona_options[footer_templates]' , array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_select',
            'default' => 'default',
        ));

        $args = array( 'post_type' => 'petrona_templates');

        $wp_customize->add_control( 'petrona_options[footer_templates]', array(
            'label' => esc_html__( 'Custom Template', 'petrona' ),
            'section' => 'petrona_footer_general',
            'type' => 'select',
            'priority' => 20,
            'choices' => $footer_template,
            'active_callback' => 'techt_footer_type_callback',
        ));
    }


    $wp_customize->add_section( 'petrona_footer_widgets' , array(
        'title'      => esc_html__( 'Widget Settings', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_footer',
        'description' => esc_html__('Note: These settings will not be applied to Footers created by Elementor page builder.', 'petrona'),
    ) );


    if ( class_exists( 'Techt_Columns_Customize_Range_Control' ) ) {
        $wp_customize->add_setting( 'petrona_options[footer_widgets_layout]', array( 
            'default' => '[3,6,9]',
            'sanitize_callback' => 'techt_sanitize_text_or_array_field',
        ) );

        // Section: section_footer
        $wp_customize->add_control( new Techt_Columns_Customize_Range_Control(
            $wp_customize,
            'petrona_options[footer_widgets_layout]',
            array(
                'priority'    => 10,
                'label'       => esc_html_x( 'Footer widgets layout', 'backend', 'petrona' ),
                'description' => esc_html_x( 'Select number of widget you want in the footer and then with the slider rearrange the layout', 'backend', 'petrona' ),
            'section'   => 'petrona_footer_widgets',
                'section'     => 'petrona_footer_widgets',
                'input_attrs' => array(
                    'min'     => 0,
                    'max'     => 12,
                    'step'    => 1,
                    'maxCols' => 6,
                )
            )
        ) );
    }

    if( class_exists('Techt_Customizer_Heading_Control') ) {    
        $wp_customize->add_setting( 'techt_theme_footer_widget_typo', array(
            'sanitize_callback'     => 'wp_kses',
        ) );

        $wp_customize->add_control( new Techt_Customizer_Heading_Control( $wp_customize, 'techt_theme_footer_widget_typo', array(
            'label'     => esc_html__( 'Footer Widget Typography', 'petrona' ),
            'section'   => 'petrona_footer_widgets',
            'priority'  => 10,
        ) ) );
    } 

    if ( class_exists( 'Techt_Customizer_Range_Value_Control' ) ) {
        $wp_customize->add_setting(
            'petrona_options[footer_widget_title_font_size]', array(
                'sanitize_callback' => 'techt_sanitize_number_range',
                'default'           => 20,
            )
        );

        $wp_customize->add_control(
            new Techt_Customizer_Range_Value_Control(
                $wp_customize, 'petrona_options[footer_widget_title_font_size]', array(
                    'label'       => esc_html__( 'Widget Title Font Size (px):', 'petrona' ),
                    'description' => esc_html__('All font size is px based. So please use slider to increase font size', 'petrona'),
                    'section'     => 'petrona_footer_widgets',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ),
                    'priority'    => 10,
                    'sum_type'    => false,
                )
            )
        );        

        $wp_customize->add_setting(
            'petrona_options[footer_widget_content_font_size]', array(
                'sanitize_callback' => 'techt_sanitize_number_range',
                'default'           => 16,
            )
        );

        $wp_customize->add_control(
            new Techt_Customizer_Range_Value_Control(
                $wp_customize, 'petrona_options[footer_widget_content_font_size]', array(
                    'label'       => esc_html__( 'Widget Content Font Size (px):', 'petrona' ),
                    'description' => esc_html__('All font size is px based. So please use slider to increase font size', 'petrona'),
                    'section'     => 'petrona_footer_widgets',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1,
                    ),
                    'priority'    => 10,
                    'sum_type'    => false,
                )
            )
        );        

        $wp_customize->add_setting(
            'petrona_options[footer_widget_content_font_line_height]', array(
                'sanitize_callback' => 'techt_sanitize_number_range',
                'default'           => 1.65,
            )
        );

        $wp_customize->add_control(
            new Techt_Customizer_Range_Value_Control(
                $wp_customize, 'petrona_options[footer_widget_content_font_line_height]', array(
                    'label'       => esc_html__( 'Widget Content line height:', 'petrona' ),
                    'section'     => 'petrona_footer_widgets',
                    'type'        => 'range-value',
                    'input_attr'  => array(
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 0.1,
                    ),
                    'priority'    => 10,
                    'sum_type'    => false,
                )
            )
        );
    }


    $wp_customize->add_section( 'petrona_footer_copyright' , array(
        'title'      => esc_html__( 'Copyright', 'petrona' ),
        'priority'   => 10,
        'panel'    => 'petrona_footer',
        'description' => esc_html__('Note: These settings will not be applied to Footers created by Elementor page builder.', 'petrona'),
    ) );


    $wp_customize->add_setting(
        'petrona_options[footer_copyright_info]', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_adtecht_html',
            'type'      =>  'theme_mod',
            'transport' => 'postMessage',
            'default'   => __('Created With By <a href="#">Technotheme</a>','petrona'),
        )
    );

    $wp_customize->add_control(
        'petrona_options[footer_copyright_info]', array(
            'label' => esc_html__( 'Footer Copyright Text:', 'petrona' ),
            'type' => 'text',
            'priority' => 20,
            'section' => 'petrona_footer_copyright',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'petrona_options[footer_copyright_info]', array(
        'selector' => '.copyright-text', 
    ) );

    /**
     * End Petrona WordPress Theme Footer Control Panel
     */ 
    
     /**
     * Petrona WordPress Theme Portfolio Settings
     */
    $wp_customize->add_panel(
        'petrona_portfolio_options', array(
            'priority' => 110,
            'title'    => esc_html__( 'Project Settings', 'petrona' ),
        )
    );
    $wp_customize->add_section( 'petrona_portfolio_permalinks_settings' , array(
        'title'      => esc_html__( 'Permalinks', 'petrona' ),
        'priority'   => 10,
        'panel'      => 'petrona_portfolio_options',
    ) );
    $wp_customize->add_section( 'petrona_single_portfolio_settings' , array(
        'title'      => esc_html__( 'Single Project', 'petrona' ),
        'priority'   => 10,
        'panel'      => 'petrona_portfolio_options',
        'description' => esc_html__('Note: These settings will not be applied to projects created by Elementor page builder.', 'petrona'),
    ) );

    $wp_customize->add_setting(
        'petrona_options[portfolio_rewrite_slug]', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_text_or_array_field',
            'type'      =>  'theme_mod',
            'default'   => 'projects',
        )
    );
    $wp_customize->add_control(
        'petrona_options[portfolio_rewrite_slug]', array(
            'label' => esc_html__( 'Project Rewrite URL:', 'petrona' ),
            'description' => esc_html__('You can set your own structure for Project slug; for example instead of https://your-site.com/projects/project_1 you can use this https://your-site.com/portfolios/project_1  ', 'petrona'),
            'type' => 'text',
            'priority' => 15,
            'section' => 'petrona_portfolio_permalinks_settings',
        )
    );

    $wp_customize->add_setting(
        'petrona_options[portfolio_cat_rewrite_slug]', array(
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'techt_sanitize_text_or_array_field',
            'type'      =>  'theme_mod',
            'default'   => 'project-category',
        )
    );
    $wp_customize->add_control(
        'petrona_options[portfolio_cat_rewrite_slug]', array(
            'label' => esc_html__( 'Project Category Rewrite URL:', 'petrona' ),
            'type' => 'text',
            'priority' => 15,
            'section' => 'petrona_portfolio_permalinks_settings',
        )
    );

    // Single Portfolio
    $wp_customize->add_setting( 'petrona_options[portfolio_single_content_layout]' , array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'techt_sanitize_select',
    ));

    $wp_customize->add_control( 'petrona_options[portfolio_single_content_layout]', array(
        'label' => esc_html__( 'Content Layout', 'petrona' ),
        'section' => 'petrona_single_portfolio_settings',
        'type' => 'select',
        'priority' => 10,
        'choices' => array(
            '' => esc_html__( 'Default', 'petrona' ),
		    'contained' => esc_html__( 'Full Width/Contained', 'petrona' ),
		    'stretched' => esc_html__( 'Full Width/Stretched', 'petrona' ),
        ),
    ));

    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Padding
         */
        $wp_customize->add_setting( 'petrona_options[portfolio_single_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[portfolio_single_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[portfolio_single_tablet_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[portfolio_single_tablet_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[portfolio_single_mobile_top_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[portfolio_single_mobile_bottom_padding]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[portfolio_single_padding]', array(
            'label'                 => esc_html__( 'Spacing (px)', 'petrona' ),
            'section'               => 'petrona_single_portfolio_settings',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[portfolio_single_top_padding]',
                'desktop_bottom'    => 'petrona_options[portfolio_single_bottom_padding]',
                'tablet_top'        => 'petrona_options[portfolio_single_tablet_top_padding]',
                'tablet_bottom'     => 'petrona_options[portfolio_single_tablet_bottom_padding]',
                'mobile_top'        => 'petrona_options[portfolio_single_mobile_top_padding]',
                'mobile_bottom'     => 'petrona_options[portfolio_single_mobile_bottom_padding]',
            ),
            'priority'              => 10,
            'input_attrs'           => array(
                'min'   => 0,
                'max'   => 400,
                'step'  => 1,
            ),
        ) ) );
    }
    if( class_exists('Techt_Customizer_Dimensions_Control') ) {
        /**
         * Portfolio Single Padding
         */
        $wp_customize->add_setting( 'petrona_options[portfolio_single_top_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[portfolio_single_bottom_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[portfolio_single_tablet_top_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[portfolio_single_tablet_bottom_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_setting( 'petrona_options[portfolio_single_mobile_top_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );
        $wp_customize->add_setting( 'petrona_options[portfolio_single_mobile_bottom_margin]', array(
            'transport'             => 'postMessage',
            'sanitize_callback'     => 'techt_sanitize_number_blank',
            'default'               => 0,
        ) );

        $wp_customize->add_control( new Techt_Customizer_Dimensions_Control( $wp_customize, 'petrona_options[portfolio_single_margin]', array(
            'label'                 => esc_html__( 'Project Content Margin (px)', 'petrona' ),
            'section'               => 'petrona_single_portfolio_settings',             
            'settings'   => array(
                'desktop_top'       => 'petrona_options[portfolio_single_top_margin]',
                'desktop_bottom'    => 'petrona_options[portfolio_single_bottom_margin]',
                'tablet_top'        => 'petrona_options[portfolio_single_tablet_top_margin]',
                'tablet_bottom'     => 'petrona_options[portfolio_single_tablet_bottom_margin]',
                'mobile_top'        => 'petrona_options[portfolio_single_mobile_top_margin]',
                'mobile_bottom'     => 'petrona_options[portfolio_single_mobile_bottom_margin]',
            ),
            'priority'              => 10,
            'input_attrs'           => array(
                'min'   => -400,
                'max'   => 400,
                'step'  => 1,
            ),
        ) ) );
    }

    if ( class_exists( 'Techt_Toggle_Control' ) ) {    

        $wp_customize->add_setting( 'petrona_options[enable_portfolio_stretched_content]', array(
            'default'     => false,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[enable_portfolio_stretched_content]', 
            array(
                'label'  => esc_html__( 'Stretched Content:', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_single_portfolio_settings',
                'priority' => 10, 
            ) 
        )); 

        $wp_customize->add_setting( 'petrona_options[show_portfolio_details_box]', array(
            'default'     => true,
            'sanitize_callback' => 'techt_sanitize_checkbox',
            'capability' => 'edit_theme_options',
        ));

        $wp_customize->add_control( new Techt_Toggle_Control( $wp_customize, 
            'petrona_options[show_portfolio_details_box]', 
            array(
                'label'  => esc_html__( 'Details Box:', 'petrona' ),
                'type'   => 'ios',
                'section'  => 'petrona_single_portfolio_settings',
                'priority' => 10, 
            ) 
        )); 
    }

    $wp_customize->add_setting( 'petrona_options[portfolio_details_bg_color]' , array(
        'default'     => Techt_CSS_Helpers::$petrona_colors['portfolio_details_bg_color'],
        'sanitize_callback' => 'techt_sanitize_rgba',
        'capability' => 'edit_theme_options',
        'type'      =>  'theme_mod',
    ));
    $wp_customize->add_control(
        new Techt_Customize_Alpha_Color_Control(
            $wp_customize,
            'petrona_options[portfolio_details_bg_color]',
            array(
                'label'     => esc_html__( 'Project Details Box Background Color', 'petrona' ),
                'description' => esc_html__( 'Change the Project Details Box background Color in Project Single Page.', 'petrona' ),
                'section'   => 'petrona_single_portfolio_settings',
            )
        )
    );    
    $wp_customize->add_setting( 'petrona_options[portfolio_details_title_color]' , array(
        'default'     => Techt_CSS_Helpers::$petrona_colors['portfolio_details_title_color'],
        'sanitize_callback' => 'techt_sanitize_rgba',
        'capability' => 'edit_theme_options',
        'type'      =>  'theme_mod',
    ));
    $wp_customize->add_control(
        new Techt_Customize_Alpha_Color_Control(
            $wp_customize,
            'petrona_options[portfolio_details_title_color]',
            array(
                'label'     => esc_html__( 'Project Details Title Color', 'petrona' ),
                'description' => esc_html__( 'Change the Project Details Title Color in Project Single Page.', 'petrona' ),
                'section'   => 'petrona_single_portfolio_settings',
            )
        )
    );  
    
}
add_action( 'customize_register', 'techt_customize_register' );