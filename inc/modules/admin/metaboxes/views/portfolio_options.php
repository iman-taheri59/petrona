<?php $this->nonce_field(); ?>
<ul class="techt_metabox_tabs">
	<li class="active"><a href="#post"><?php echo esc_html__( "Common", 'petrona' ) ?></a></li>
	<li><a href="#portfolio_general_details"><?php echo esc_html__( "General Details", 'petrona' ) ?></a></li>
	<li><a href="#portfolio_page"><?php echo esc_html__( "Single Layout", 'petrona' ) ?></a></li>
	<li><a href="#header"><?php echo esc_html__( "Header", 'petrona' ) ?></a></li>
	<li><a href="#footer"><?php echo esc_html__( "Footer", 'petrona' ) ?></a></li>
</ul>
<div class='techt_metabox'>
	<div class="techt_metabox_tab active" id="techt_tab_post">
		<?php
		$this->select ( 'portfolio_sources', esc_html__( 'Portfolio Content Type', 'petrona' ), array (
			'' => esc_html__( 'Default', 'petrona' ),
			'image' => esc_html__( 'Image', 'petrona' ),
            'video' => esc_html__( 'Video', 'petrona' ),
            'audio' => esc_html__( 'Audio', 'petrona' ),
            'gallery' => esc_html__( 'Gallery', 'petrona' ),
            'links' => esc_html__( 'Custom URL', 'petrona' ),
		), esc_html__( 'Select image source for display image/gallery/video at portfolio widget at elementor', 'petrona' ) );

		// Video Options
		$this->subsection_start( esc_html__( 'Video', 'petrona' ), array(
		    'option' => 'portfolio_sources',
		    'value' => 'video',
		    'background' => get_post_meta( get_the_ID(), 'petrona_portfolio_sources', true),
		) );

		$this->text ( 'video_url',  
			esc_html__( 'Enter Video URL', 'petrona' ),  
			esc_html__( 'Put Embed url for the video. Here featured image are using for video cover image.', 'petrona' ) 
		);
		
		$this->subsection_end();
		// End Video Options

		// Audio Option
		$this->subsection_start( esc_html__( 'Audio', 'petrona' ), array(
		    'option' => 'portfolio_sources',
		    'value' => 'audio',
		    'background' => get_post_meta( get_the_ID(), 'petrona_portfolio_sources', true),
		) );

		$this->textarea ( 'audio_embed_code',  
			esc_html__( 'Enter Audio URL', 'petrona' ),  
			esc_html__( 'Put Embed url for the audio. Here featured image are using for audio cover image at portfolio elementor widget.', 'petrona' ) 
		);

		$this->subsection_end();
		// End Audio Options 

		// Gallery Source Code
		$this->subsection_start( esc_html__( 'Gallery', 'petrona' ), array(
		    'option' => 'portfolio_sources',
		    'value' => 'gallery',
		    'background' => get_post_meta( get_the_ID(), 'petrona_portfolio_sources', true),
		) );

		$this->multiple_images('portfolio_gallery_images', esc_html__( 'Gallery Images', 'petrona' ), esc_html__( 'Leave it empty if not want gallery. Here featured image are using for display at elementor portfolio widget.', 'petrona' ) );

		$this->subsection_end();

		// Link Option
		$this->subsection_start( esc_html__( 'Links', 'petrona' ), array(
		    'option' => 'portfolio_sources',
		    'value' => 'links',
		    'background' => get_post_meta( get_the_ID(), 'petrona_portfolio_sources', true),
		) );

		$this->text ( 'custom_urls',  
			esc_html__( 'Enter URL', 'petrona' ),  
			esc_html__( 'Put your custom url. So that it will open automatically', 'petrona' ) );

		$this->select ( 'open_links', esc_html__( 'URL Open Type', 'petrona' ), array (
		    '' => esc_html__( 'Default', 'petrona' ),
		    'blank' => esc_html__( 'Blank Page', 'petrona' ),
		    'self' => esc_html__( 'Self Page', 'petrona' ),
		), esc_html__( 'Choose for how you want to opens links.', 'petrona' ) );

		$this->select ( 'nofollow_links', esc_html__( 'Add nofollow', 'petrona' ), array (
		    '' => esc_html__( 'Default', 'petrona' ),
		    'nofollow' => esc_html__( 'Add nofollow', 'petrona' ),
		), esc_html__( 'Choose Add nofollow option if you want add nofallow links.', 'petrona' ) );

		$this->subsection_end();
		// Link Option
		?>
	</div>
	<div class="techt_metabox_tab" id="techt_tab_portfolio_general_details">
		<?php
		$this->select ( 'portfolio_status', esc_html__( 'Portfolio Status', 'petrona' ), array (
			'' => esc_html__( 'Select Option', 'petrona' ),
			'complated' => esc_html__( 'Complated', 'petrona' ),
			'doing' => esc_html__( 'Doing', 'petrona' ),
            'canceled' => esc_html__( 'Canceled', 'petrona' ),
		), esc_html__( 'Select Portfolio Status', 'petrona' ) );
		$this->text ( 'portfolio_year',  
			esc_html__( 'Enter Portfolio Year', 'petrona' ),  
			esc_html__( 'Enter Portfolio Year.', 'petrona' ) 
		);
		$this->text ( 'portfolio_location',  
			esc_html__( 'Enter Portfolio Location', 'petrona' ),  
			esc_html__( 'Enter Portfolio Location.', 'petrona' ) 
		);
		$this->text ( 'portfolio_client',  
			esc_html__( 'Enter Portfolio Client', 'petrona' ),  
			esc_html__( 'Enter Portfolio Client.', 'petrona' ) 
		);
		?>
	</div>
	<div class="techt_metabox_tab" id="techt_tab_portfolio_page">
		<?php 
		$this->select ( 'enable_stretched_content_layout', esc_html__( 'Enable Stretched Content Layout', 'petrona' ), array (
		    '' => esc_html__( 'Default', 'petrona' ),
		    'yes' => esc_html__( 'Yes', 'petrona' ),
			'no' => esc_html__( 'No', 'petrona' ),
		), esc_html__( 'Choose to enable stretched content layout.', 'petrona' ) );

		$this->select ( 'show_hero_image', esc_html__( 'Show hero image in the content', 'petrona' ), array (
			'' => esc_html__( 'Default', 'petrona' ),
			'yes' => esc_html__( 'Yes', 'petrona' ),
			'no' => esc_html__( 'No', 'petrona' )
		), esc_html__( 'If you want to show/hide hero image at portfolio single page, then select option for here.', 'petrona' ) );

		$this->select ( 'show_featured_image_in_content', esc_html__( 'Show featured image in the content', 'petrona' ), array (
				'' => esc_html__( 'Default', 'petrona' ),
				'yes' => esc_html__( 'Yes', 'petrona' ),
				'no' => esc_html__( 'No', 'petrona' )
			), esc_html__( 'If you want to show/hide featured image at portfolio single page, then select option for here.', 'petrona' ) );
		
		$this->select ( 'show_portfolio_details', esc_html__( 'Show portfolio details in the content', 'petrona' ), array (
				'' => esc_html__( 'Default', 'petrona' ),
				'yes' => esc_html__( 'Yes', 'petrona' ),
				'no' => esc_html__( 'No', 'petrona' )
			), esc_html__( 'If you want to show/hide details at portfolio single page, then select option for here.', 'petrona' ) );
	
		$this->select ( 'show_page_title', esc_html__( 'Show Portfolio Title', 'petrona' ), array (
				'' => esc_html__( 'Default', 'petrona' ),
				'yes' => esc_html__( 'Yes', 'petrona' ),
				'no' => esc_html__( 'No', 'petrona' )
			), esc_html__( 'If you want to show/hide title at portfolio single page, then select option for here.', 'petrona' ) );

		$this->text ( 'content_padding_top',  
		    esc_html__( 'Spacing Top', 'petrona' ),  
		    esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
		$this->text ( 'content_padding_bottom',  
		    esc_html__( 'Spacing Bottom', 'petrona' ),  
		    esc_html__( 'Enter value with px, for example 10px. Leave it empty for default.', 'petrona' ) );
		?>
	</div>

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
	    );   ?>
	</div>
</div>
<div class="clear"></div>