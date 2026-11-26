<?php $this->nonce_field(); ?>
<ul class="techt_metabox_tabs">
    <li class="active"><a href="#header"><?php echo esc_html__( "Header", 'petrona' ) ?></a></li>
    <li><a href="#menu"><?php echo esc_html__( "Menu", 'petrona' ) ?></a></li>
    <li><a href="#contents"><?php echo esc_html__( "Content Area", 'petrona' ) ?></a></li>
    <li><a href="#sidebars"><?php echo esc_html__( "Sidebars", 'petrona' ) ?></a></li>
	<li><a href="#footer"><?php echo esc_html__( "Footer", 'petrona' ) ?></a></li>
    <li><a href="#preloader"><?php echo esc_html__( "Preloader", 'petrona' ) ?></a></li>
</ul>
<div class="techt_metabox">
    <div class="techt_metabox_tab" id="techt_tab_header">
        <?php      
        $this->select ( 'header_show_header', esc_html__( 'Show header', 'petrona' ), array (
            ''   => esc_html__( 'Theme Setting', 'petrona' ),
            'yes'       => esc_html__( 'Yes', 'petrona' ),
            'no'        => esc_html__( 'No', 'petrona' ),
        ), esc_html__( 'Choose to show or hide the header.', 'petrona' ) );

        $this->select ( 'header_type', esc_html__( 'Select Header Type', 'petrona' ), array (
            ''   => esc_html__( 'Theme Setting', 'petrona' ),
            'custom_header'   => esc_html__( 'Custom Header', 'petrona' ),
            'elementor_header' => esc_html__( 'Custom Template', 'petrona' ),
        ), esc_html__( 'Choose your header types.', 'petrona' ) );

        $this->select ( 'transparent_header', esc_html__( 'Transparent Header', 'petrona' ), array (
            '' => esc_html__( 'Theme Setting', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'no' => esc_html__( 'No', 'petrona' )
        ), esc_html__( 'Choose to make transparent your header.', 'petrona' ) );

        $this->select ( 'enable_sticky_header', esc_html__( 'Sticky Header', 'petrona' ), array (
            '' => esc_html__( 'Theme Setting', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'No'=> esc_html__( 'No', 'petrona' ),
        ), esc_html__( 'Enable Sticky Header.', 'petrona' ) );  

        /* Start Header Background Status */

        $this->subsection_start( esc_html__( 'Header Template', 'petrona' ), array(
            'option' => 'header_type',
            'value' => 'elementor_header',
            'background' => get_post_meta( get_the_ID(), 'petrona_header_type', true),
        ) );

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
                $header_template[''] = esc_html__('Default', 'petrona');
                $header_template[$value->ID] = $value->post_title;
            }
        } else {
            $header_template[''] = esc_html__('Default', 'petrona');
        }

        $this->select ( 'header_template', esc_html__( 'Select Header Template', 'petrona' ), $header_template, esc_html__( 'Choose your header template.', 'petrona' ) );

        // End Header Template

        $this->subsection_end(); 

         
        /**
         *  Start Sticky Header template
         *
         * @package Petrona
         * @since 1.0
        */

        $this->subsection_start( esc_html__( 'Sticky Header Template', 'petrona' ), array(
            'option' => 'enable_sticky_header',
            'value' => 'yes',
            'background' => get_post_meta( get_the_ID(), 'petrona_header_sticky_template', true)
        ) );

        $this->select ( 'header_sticky_template', esc_html__( 'Select Sticky Header Template', 'petrona' ), $header_template, esc_html__( 'Choose your sticky header template.', 'petrona' ) );

        // End Sticky Header Template
        $this->subsection_end();
         
        $this->subsection_start( esc_html__( 'Header Template', 'petrona' ), array(
            'option' => 'header_type',
            'value' => 'custom_header',
            'background' => get_post_meta( get_the_ID(), 'petrona_header_type', true),
        ) );

        $this->upload ( 'header_logo_main', esc_html__( 'Header Main Logo', 'petrona' ),esc_html__( 'Choose Page Header Main Logo.', 'petrona' ) );

        $this->color('custom_header_bg', esc_html__('Header Background', 'petrona'), 
            esc_html__('Add your Header Background Color', 'petrona')
        ); 

        $this->color('custom_header_border_color', esc_html__('Header Border Color', 'petrona'), 
            esc_html__('Change your Header Border Color', 'petrona')
        ); 

        $this->select ( 'full_width_header', esc_html__( 'Full Width Header', 'petrona' ), array (
            '' => esc_html__( 'Theme Setting', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'no' => esc_html__( 'No', 'petrona' )
        ), esc_html__( 'Choose to header full width.', 'petrona' ) );      

        $this->subsection_end(); 

        ?>
    </div>

    <div class="techt_metabox_tab" id="techt_tab_menu">
        <?php
        $menus = wp_get_nav_menus();
        $menuName = array();
        foreach ( $menus as $menu  ) : 
            $menuName[0] = esc_html__( 'Default', 'petrona' );
            $menuName[$menu->term_id] = $menu->name;
        endforeach;
        $this->description(esc_html__('Note: Some of these settings will not be applied to Headers created by Template builder.', 'petrona'));
        $this->select ( 'header_page_menu', esc_html__( 'Select Menu For Page', 'petrona' ), $menuName , esc_html__( 'Show Diffrent Menu at diffrent pages.', 'petrona' ) );
 
        $this->select_font_family ( 'menu_font', esc_html__( 'Font Family', 'petrona' ), esc_html__( 'Choose font family for menu.', 'petrona' ) );

        $this->text ( 'menu_font_size',  
            esc_html__( 'Font Size', 'petrona' ),  
            esc_html__( 'Add Font Size. Include the value like - px, em, rem with font size', 'petrona' ) );

        $this->select ( 'menu_font_weight', esc_html__( 'Font Weight', 'petrona' ), array (
            '' => esc_html__( 'Default', 'petrona' ),
            '100' => esc_html__( 'Thin: 100', 'petrona' ),
            '200' => esc_html__( 'Light: 200', 'petrona' ),
            '300' => esc_html__( 'Book: 300', 'petrona' ),
            '400' => esc_html__( 'Normal: 400', 'petrona' ),
            '500' => esc_html__( 'Medium: 500', 'petrona' ),
            '600' => esc_html__( 'Semibold: 600', 'petrona' ),
            '700' => esc_html__( 'Bold: 700', 'petrona' ),
            '800' => esc_html__( 'Extra Bold: 800', 'petrona' ),
            '900' => esc_html__( 'Black: 900', 'petrona' ),
        ), esc_html__( 'Choose font weight.', 'petrona' ) );       

        $this->select ( 'menu_font_style', esc_html__( 'Font Style', 'petrona' ), array (
            '' => esc_html__( 'Default', 'petrona' ),
            'normal' => esc_html__( 'Normal', 'petrona' ),
            'italic' => esc_html__( 'Italic', 'petrona' ),
        ), esc_html__( 'Choose font weight.', 'petrona' ) );        

        $this->select ( 'menu_font_transform', esc_html__( 'Font Style', 'petrona' ), array (
            '' => esc_html__( 'Default', 'petrona' ),
            'capitalize' => esc_html__( 'Capitalize', 'petrona' ),
            'lowercase'=> esc_html__( 'Lowercase', 'petrona' ),
            'uppercase' => esc_html__( 'Uppercase', 'petrona' ),
        ), esc_html__( 'Choose font weight.', 'petrona' ) );

        $this->text ( 'menu_font_line_height',  
            esc_html__( 'Line Height', 'petrona' ),  
            esc_html__( 'Add Line Height. Include the value like - px, em, rem with line-height', 'petrona' ) );        

        $this->text ( 'menu_font_latter_spacing',  
            esc_html__( 'Later Spacing', 'petrona' ),  
            esc_html__( 'Add Later Spacing. Include the value like - px, em, rem with later-spacing', 'petrona' ) );

        $this->color('menu_colors', esc_html__('Menu Item Color', 'petrona'), 
            esc_html__('Change your menu items Color', 'petrona')
        );         

        $this->color('menu_active_colors', esc_html__('Menu Active Indicator Color', 'petrona'), 
            esc_html__('Change your menu active indicator color', 'petrona')
        ); ?>
    </div>

    <div class="techt_metabox_tab" id="techt_tab_contents">
        <?php
        $this->select ( 'show_page_title', esc_html__( 'Show Page Title', 'petrona' ), array (
            '' => esc_html__( 'Select to display title', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'no' => esc_html__( 'No', 'petrona' )
        ), esc_html__( 'Choose to show or hide the page title.', 'petrona' ) );

        $this->select ( 'show_featured_image_in_content', esc_html__( 'Show featured image in the content', 'petrona' ), array (
            '' => esc_html__( 'Select to display Featured Image', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'no' => esc_html__( 'No', 'petrona' )
        ), esc_html__( 'Choose no to hide featured image in the content area.', 'petrona' ) );

        $this->select ( 'enable_dark_background', esc_html__( 'Enable Dark Background', 'petrona' ), array (
            ''   => esc_html__( 'Select to enable dark background', 'petrona' ),
            'yes'       => esc_html__( 'Yes', 'petrona' ),
            'no'        => esc_html__( 'No', 'petrona' ),
        ), esc_html__( 'Choose to enable dark background.', 'petrona' ) );

        $this->color('body_bg_colors', esc_html__('Background Color', 'petrona'), 
            esc_html__('Change your Page Background Color', 'petrona')
        );

        $this->text ( 'content_padding_top',  
            esc_html__( 'Spacing Top', 'petrona' ),  
            esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
        $this->text ( 'content_padding_bottom',  
            esc_html__( 'Spacing Bottom', 'petrona' ),  
            esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
        $this->text ( 'article_spacing_top',  
            esc_html__( 'Article Spacing Top', 'petrona' ),  
            esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
        $this->text ( 'article_spacing_bottom',  
            esc_html__( 'Article Spacing Bottom', 'petrona' ),  
            esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
        ?>
    </div>
    <div class="techt_metabox_tab" id="techt_tab_sidebars">
        <?php
        $this->select ( 'sidebar_position', esc_html__( 'Sidebar Position', 'petrona' ),
            array (
                '' => esc_html__( 'Theme Setting', 'petrona' ),
                'right' => esc_html__( 'Right', 'petrona' ),
                'left' => esc_html__( 'Left', 'petrona' ),
                'full' => esc_html__( 'Full Width', 'petrona' ),
            ), esc_html__( 'Select the sidebar position.', 'petrona' ) );        

        $this->select ( 'sidebar_status', esc_html__( 'Sidebar Status', 'petrona' ),
            array (
                '' => esc_html__( 'Theme Setting', 'petrona' ),
                'normal' => esc_html__( 'Normal', 'petrona' ),
                'sticky' => esc_html__( 'Sticky', 'petrona' ),
            ), esc_html__( 'Select the sidebar status.', 'petrona' ) );
        ?>
    </div>
    <div class="techt_metabox_tab" id="techt_tab_footer">
        <?php
        $this->select ( 'footer_show_footer', esc_html__( 'Show footer', 'petrona' ), array (
            '' => esc_html__( 'Theme Setting', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'no' => esc_html__( 'No', 'petrona' ),
        ), esc_html__( 'Choose to show or hide the footer.', 'petrona' ) );        

        $this->select ( 'footer_type', esc_html__( 'Footer Type', 'petrona' ), array (
            '' => esc_html__( 'Theme Setting', 'petrona' ),
            'custom_template' => esc_html__( 'Custom Template', 'petrona' ),
        ), esc_html__( 'Choose type of footer.', 'petrona' ) );

        $this->subsection_start( esc_html__( 'Footer Template', 'petrona' ), array(
            'option' => 'footer_type',
            'value' => 'custom_template',
            'background' => get_post_meta( get_the_ID(), 'petrona_footer_type', true),
        ) );

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
                $footer_template[''] = esc_html__('Default', 'petrona');
                $footer_template[$value->ID] = $value->post_title;
            }
        } else {
            $footer_template[''] = esc_html__('Default', 'petrona');
        }

        $this->select ( 'footer_template', esc_html__( 'Select Footer Template', 'petrona' ), $footer_template , esc_html__( 'Show Diffrent Footer at diffrent pages.', 'petrona' ) );
        // End Footer Templates Query

        $this->subsection_end(); 

        $this->select ( 'fixed_footer', esc_html__( 'Fixed Footer', 'petrona' ), array (
            '' => esc_html__( 'Theme Setting', 'petrona' ),
            'yes' => esc_html__( 'Yes', 'petrona' ),
            'no' => esc_html__( 'No', 'petrona' )
        ), esc_html__( 'Choose to make fixed your footer.', 'petrona' ) );

        $this->color('footer_background', esc_html__('Footer Background Color', 'petrona'), 
            esc_html__('Change your footer background color', 'petrona')
        );         

        $this->color('footer_text', esc_html__('Footer Text Color', 'petrona'), 
            esc_html__('Change your footer text color', 'petrona')
        );         

        $this->color('footer_link_color', esc_html__('Footer Link Color', 'petrona'), 
            esc_html__('Change your footer link color', 'petrona')
        ); 

        $this->color('footer_link_hover_color', esc_html__('Footer Link Hover Color', 'petrona'), 
            esc_html__('Change your footer link hover color', 'petrona')
        );  ?>
    </div>
    <div class="techt_metabox_tab" id="techt_tab_preloader">
        <?php      
        $this->select ( 'preloader_show_preloader', esc_html__( 'Show preloader', 'petrona' ), array (
            ''   => esc_html__( 'Theme Setting', 'petrona' ),
            'yes'       => esc_html__( 'Yes', 'petrona' ),
            'no'        => esc_html__( 'No', 'petrona' ),
        ), esc_html__( 'Choose to show or hide the preloader.', 'petrona' ) );

        $this->select ( 'preloader_type', esc_html__( 'Select Preloader Type', 'petrona' ), array (
            ''   => esc_html__( 'Theme Setting', 'petrona' ),
            'custom_preloader'   => esc_html__( 'Custom Preloader', 'petrona' ),
            'elementor_preloader' => esc_html__( 'Custom Template', 'petrona' ),
        ), esc_html__( 'Choose your preloader types.', 'petrona' ) );

        $this->subsection_start( esc_html__( 'Preloader Template', 'petrona' ), array(
            'option' => 'preloader_type',
            'value' => 'elementor_preloader',
            'background' => get_post_meta( get_the_ID(), 'petrona_preloader_type', true),
        ) );

        // Preloader Template
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
                $preloader_template[''] = esc_html__('Default', 'petrona');
                $preloader_template[$value->ID] = $value->post_title;
            }
        } else {
            $preloader_template[''] = esc_html__('Default', 'petrona');
        }

        $this->select ( 'header_template', esc_html__( 'Select Preloader Template', 'petrona' ), $header_template, esc_html__( 'Choose your preloader template.', 'petrona' ) );

        // End Preloader Template

        $this->subsection_end(); 

        $this->select ( 'preloader_colors', esc_html__( 'Select Preloader Colors', 'petrona' ), array (
            ''   => esc_html__( 'Theme Setting', 'petrona' ),
            'custom'   => esc_html__( 'Custom', 'petrona' ),
        ), esc_html__( 'Choose your preloader colors.', 'petrona' ) );

        /* Start Preloader Background Status */

        $this->subsection_start( esc_html__( 'Preloader Colors', 'petrona' ), array(
            'option' => 'preloader_colors',
            'value' => 'custom',
            'background' => get_post_meta( get_the_ID(), 'petrona_preloader_colors', true),
        ) );
        $this->color('preloader_bg', esc_html__('Preloader background', 'petrona'), 
            esc_html__('Change your Preloader background color', 'petrona')
        ); 

        $this->color('preloader_color_1', esc_html__('Preloader Color 1', 'petrona'), 
            esc_html__('Change your Preloader color 1', 'petrona')
        );

        $this->color('preloader_color_2', esc_html__('Preloader Color 2', 'petrona'), 
            esc_html__('Change your Preloader color 2', 'petrona')
        );

        $this->color('preloader_color_3', esc_html__('Preloader Color 3', 'petrona'), 
            esc_html__('Change your Preloader color 3', 'petrona')
        );

        // End Preloader Template

        $this->subsection_end();
    ?>
    </div>
</div>
<div class="clear"></div>