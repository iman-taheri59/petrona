<ul class="techt_metabox_tabs">
	<li class="active"><a href="#header"><?php echo esc_html__( "Header", 'petrona' ) ?></a></li>
	<li><a href="#sidebars"><?php echo esc_html__( "Sidebars", 'petrona' ) ?></a></li>
    <li><a href="#contents"><?php echo esc_html__( "Content Area", 'petrona' ) ?></a></li>
	<li><a href="#footer"><?php echo esc_html__( "Footer", 'petrona' ) ?></a></li>
</ul>
<div class='techt_metabox'>
    <div class="techt_metabox_tab active" id="techt_tab_header">
        <?php
        $this->select ( 'header_show_header', esc_html__( 'Show header', 'petrona' ), array (
            ''   => esc_html__( 'Theme Setting', 'petrona' ),
            'yes'       => esc_html__( 'Yes', 'petrona' ),
            'no'        => esc_html__( 'No', 'petrona' )
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
         *  Start Sticky Header Background Status
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
    <div class="techt_metabox_tab" id="techt_tab_contents">
        <?php 
        $this->text ( 'content_padding_top',  
            esc_html__( 'Padding Top', 'petrona' ),  
            esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );

        $this->text ( 'content_padding_bottom',  
            esc_html__( 'Padding Bottom', 'petrona' ),  
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
</div>
<div class="clear"></div>