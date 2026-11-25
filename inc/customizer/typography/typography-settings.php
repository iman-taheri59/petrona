<?php
/**
 * Typography settings
 *
 * @package Petrona
 * @since 1.0
 */
/**
 * Include functions file for Font Family controls.
 */
get_template_part('inc/customizer/customizer-font-selector/font-functions');
get_template_part('inc/customizer/customizer-font-selector/class/class-font-selector');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since 1.0
 */
function techt_customize_preview() {
	wp_enqueue_script( 'techt-typo-customizer', get_theme_file_uri( '/inc/customizer/typography/js/typo-customizer.js' ), array( 'customize-preview' ), '1.0', true );
}

add_action( 'customize_preview_init', 'techt_customize_preview' );

/**
 * Customizer controls for typography settings.
 *
 * @param WP_Customize_Manager $wp_customize Customize manager.
 *
 * @since 1.0
 */
function techt_typography_settings( $wp_customize ) {
	/**
	 * Main typography panel
	 */
	$wp_customize->add_panel(
		'petrona_typography_settings', array(
			'priority' => 25,
			'title'    => esc_html__( 'Typography Settings', 'petrona' ),
		)
	);

	$wp_customize->add_section(
		'petrona_typography', array(
			'title'    => esc_html__( 'Font Family', 'petrona' ),
			'panel'    => 'petrona_typography_settings',
			'priority' => 25,
		)
	);	

	/**
	 * Main typography Size
	 */
	$wp_customize->add_section(
		'petrona_typography_size', array(
			'title'    => esc_html__( 'Font Size', 'petrona' ),
			'panel'    => 'petrona_typography_settings',
			'priority' => 25,
		)
	);

	/**
	 * Main typography Colors
	 */
	$wp_customize->add_section(
		'petrona_typography_color', array(
			'title'    => esc_html__( 'Font Color', 'petrona' ),
			'panel'    => 'petrona_typography_settings',
			'priority' => 25,
		)
	);	

	$wp_customize->add_setting(
	    'petrona_options[body_font_color]', array(
	        'capability' => 'edit_theme_options',
	        'sanitize_callback' => 'sanitize_hex_color',
	        'type'      =>  'theme_mod',
	        'transport'   => 'postMessage',
	        'default' => '#434343',
	    )
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'petrona_options[body_font_color]', array(
	        	'label' => esc_html__('Body Font Color','petrona'), 
	            'section' => 'petrona_typography_color',
	        )
	    )
	);	
	$wp_customize->add_setting(
	    'petrona_options[heading_font_color]', array(
	        'capability' => 'edit_theme_options',
	        'sanitize_callback' => 'sanitize_hex_color',
	        'type'      =>  'theme_mod',
	        'transport'   => 'postMessage',
	        'default' => '#101010',
	    )
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'petrona_options[heading_font_color]', array(
	        	'label' => esc_html__('Headings Font Color','petrona'), 
	            'section' => 'petrona_typography_color',
	        )
	    )
	);

	/**
	 * ------------------
	 * 1. Font Family tab
	 * ------------------
	 */
	if ( class_exists( 'Techt_Font_Selector' ) ) {
		/**
		 * ---------------------------------
		 * 1.a. Headings font family control
		 * This control allows the user to choose a font family for all Headings used in the theme ( h1 - h6 )
		 * --------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[headings_font]', array(
				'type' => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => is_rtl() ? 'Vazir': 'Poppins',
			)
		);
		$wp_customize->add_control(
			new Techt_Font_Selector(
				$wp_customize, 'petrona_options[headings_font]', array(
					'label'    => esc_html__( 'Headings font family', 'petrona' ),
					'section' => 'petrona_typography',
					'priority' => 5,
					'type'     => 'select',
				)
			)
		);

		/**
		 * ---------------------------------
		 * 1.b. Body font family control
		 * This control allows the user to choose a font family for all elements in the body tag
		 * --------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[body_font]', array(
				'type' => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => is_rtl() ? 'Vazir' : 'Roboto Slab',
			)
		);

		$wp_customize->add_control(
			new Techt_Font_Selector(
				$wp_customize, 'petrona_options[body_font]', array(
					'label'    => esc_html__( 'Body font family', 'petrona' ),
					'section' => 'petrona_typography',
					'priority' => 10,
					'type'     => 'select',
				)
			)
		);

		/**
		 * ---------------------------------
		 * Form Typography
		 * This control allows the user to choose a font family for all elements in the body tag
		 * --------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[input_form]', array(
				'type' => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => is_rtl() ? 'Vazir' : 'Roboto Slab',
			)
		);

		$wp_customize->add_control(
			new Techt_Font_Selector(
				$wp_customize, 'petrona_options[input_form]', array(
					'label'    => esc_html__( 'Form ( Input )', 'petrona' ),
					'section' => 'petrona_typography',
					'priority' => 10,
					'type'     => 'select',
				)
			)
		);

		/**
		 * ---------------------------------
		 * Form Typography
		 * This control allows the user to choose a font family for all elements in the body tag
		 * --------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[button_typo]', array(
				'type' => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => is_rtl() ? 'Vazir': 'Poppins',
			)
		);

		$wp_customize->add_control(
			new Techt_Font_Selector(
				$wp_customize, 'petrona_options[button_typo]', array(
					'label'    => esc_html__( 'Button', 'petrona' ),
					'section' => 'petrona_typography',
					'priority' => 10,
					'type'     => 'select',
				)
			)
		);

		/**
		 * ---------------------------------
		 * 1.b. Body font family control
		 * This control allows the user to choose a font family for all elements in the body tag
		 * --------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[site_title_font]', array(
				'type' => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => is_rtl() ? 'Vazir': 'Poppins',
			)
		);

		$wp_customize->add_control(
			new Techt_Font_Selector(
				$wp_customize, 'petrona_options[site_title_font]', array(
					'label'    => esc_html__( 'Site Title/Logo Font Family', 'petrona' ),
					'section' => 'petrona_typography',
					'priority' => 10,
					'type'     => 'select',
				)
			)
		);

		/**
		 * ---------------------------------
		 * 1.b. Breadcrumb font family control
		 * This control allows the user to choose a font family for all elements in the body tag
		 * --------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[breadcrumb_font]', array(
				'type' => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default' => is_rtl() ? 'VazirFD': 'Poppins',
			)
		);

		$wp_customize->add_control(
			new Techt_Font_Selector(
				$wp_customize, 'petrona_options[breadcrumb_font]', array(
					'label'    => esc_html__( 'Breadcrumb Font Family', 'petrona' ),
					'section' => 'petrona_typography',
					'priority' => 10,
					'type'     => 'select',
				)
			)
		);
	} // End if().

	if ( class_exists( 'Techt_Select_Multiple' ) && !is_rtl() ) {
		/**
		 * --------------------
		 * 1.c. Font Subsets control
		 * This control allows the user to choose a subset for the font family ( for e.g. lating, cyrillic etc )
		 * --------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[font_subsets]', array(
				'sanitize_callback' => 'techt_sanitize_multiselect',
				'default'           => is_rtl() ? '' : array( 'latin' ),
			)
		);

		$wp_customize->add_control(
			new Techt_Select_Multiple(
				$wp_customize, 'petrona_options[font_subsets]', array(
					'section' => 'petrona_typography',
					'label'    => esc_html__( 'Font Subsets', 'petrona' ),
					'choices'  => array(
						'latin'        => 'latin',
						'latin-ext'    => 'latin-ext',
						'cyrillic'     => 'cyrillic',
						'cyrillic-ext' => 'cyrillic-ext',
						'greek'        => 'greek',
						'greek-ext'    => 'greek-ext',
						'vietnamese'   => 'vietnamese',
					),
					'priority' => 45,
				)
			)
		);
	} // End if().

	/**
	 * ------------------
	 * 2. Font Size tab
	 * ------------------
	 */
	if ( class_exists( 'Techt_Customizer_Range_Value_Control' ) ) {
		/**
		 * --------------------------------------------------------------------------
		 * 2.b. Font size controls for Posts & Pages
		 * --------------------------------------------------------------------------
		 *
		 * Title control [Posts & Pages]
		 * This control allows the user to choose a font size for the main titles
		 * that appear in the header for pages and posts.
		 *
		 * The values area between 0 and 60 rem.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[body_font_size]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 16,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[body_font_size]', array(
					'label'       => esc_html__( 'Body Font Size(px):', 'petrona' ),
					'description' => esc_html__('This font size is px based. So please use slider to increase font size', 'petrona'),
					'section'     => 'petrona_typography_size',
					'type'        => 'range-value',
					'input_attr'  => array(
						'min'  => 0,
						'max'  => 60,
						'step' => 1,
					),
					'priority'    => 110,
					'sum_type'    => false,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * Headings control [Posts & Pages]
		 *
		 * This control allows the user to choose a font size for all headings
		 * ( h1 - h6 ) from pages and posts.
		 *
		 * The values area between 0 and 60 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[site_title_font_size]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 20,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[site_title_font_size]', array(
					'label'      => esc_html__( 'Site Logo/Title(px):', 'petrona' ),
					'section'    => 'petrona_typography_size',
					'description' => esc_html__('This font size is px based. So please use slider to increase font size', 'petrona'),
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 60,
						'step' => 1,
					),
					'priority'   => 112,
					'sum_type'    => false,
				)
			)
		);		

		/**
		 * --------------------------------------------------------------------------
		 * Headings control [Posts & Pages]
		 *
		 * This control allows the user to choose a font size for all headings
		 * ( h1 - h6 ) from pages and posts.
		 *
		 * The values area between 0 and 60 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[menu_font_size]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 16,
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[menu_font_size]', array(
					'label'      => esc_html__( 'Menu Font Size(px):', 'petrona' ),
					'section'    => 'petrona_typography_size',
					'description' => esc_html__('This font size is px based. So please use slider to increase font size', 'petrona'),
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 60,
						'step' => 1,
					),
					'priority'   => 115,
					'sum_type'    => false,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * Content control [Posts & Pages]
		 *
		 * This control allows the user to choose a font size for the main content
		 * area in pages and posts.
		 *
		 * The values area between -25 and +25 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[post_title_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 20,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[post_title_content]', array(
					'label'      => esc_html__( 'Post Title Font Size(px):', 'petrona' ),
					'description' => esc_html__('This font size is px based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 90,
						'step' => 1,
					),
					'priority'   => 120,
					'sum_type'    => false,
				)
			)
		);

		$wp_customize->add_setting(
			'petrona_options[post_single_title_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 24,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[post_single_title_content]', array(
					'label'      => esc_html__( 'Post Single Title Font Size(px):', 'petrona' ),
					'description' => esc_html__('This font size is PX based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 90,
						'step' => 1,
					),
					'priority'   => 120,
					'sum_type'    => false,
				)
			)
		);

		$wp_customize->add_setting(
			'petrona_options[widget_title_font_size]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 16,
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[widget_title_font_size]', array(
					'label'      => esc_html__( 'Sidebar Widget Title Font Size(px):', 'petrona' ),
					'description' => esc_html__('This font size is PX based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 90,
						'step' => 1,
					),
					'priority'   => 120,
					'sum_type'    => false,
				)
			)
		);

		$wp_customize->add_setting(
			'petrona_options[breadcrumb_font_size]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				'default'           => 16,
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[breadcrumb_font_size]', array(
					'label'      => esc_html__( 'Breadcrumb Font Size(px):', 'petrona' ),
					'description' => esc_html__('This font size is PX based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 40,
						'step' => 1,
					),
					'priority'   => 120,
					'sum_type'    => false,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * 2.c. Font size controls for Frontpage
		 * --------------------------------------------------------------------------
		 * Big Title Section / Header Slider font size control. [Frontpage Sections]
		 *
		 * This is changing the big title/slider titles, the
		 * subtitle and the button in the big title section.
		 *
		 * The values are between 0 and 120 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[heading_one_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				// 'default'           => 2,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[heading_one_content]', array(
					'label'      =>  esc_html__( 'H1:', 'petrona' ),
					'description' => esc_html__('All Heading font size is EM based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 120,
						'step' => 0.1,
					),
					'priority'   => 210,
					'sum_type'    => false,
				)
			)
		);

		/**
		 * --------------------------------------------------------------------------
		 * Section Title [Frontpage Sections]
		 *
		 * This control is changing sections titles and card titles
		 * The values are between 0 and 120 px.
		 * --------------------------------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[heading_two_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				// 'default'           => 1.5,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[heading_two_content]', array(
					'label'      => esc_html__( 'H2:', 'petrona' ),
					'description' => esc_html__('All Heading font size is EM based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 120,
						'step' => 0.1,
					),
					'priority'   => 215,
					'sum_type'    => false,
				)
			)
		);

		/**
		 * -----------------------------------------------------
		 * Subtitles control [Frontpage Sections]
		 * This control allows the user to choose a font size
		 * for all Subtitles on Frontpage sections.
		 * The values area between 0 and 105 px.
		 * -----------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[heading_three_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				// 'default'           => 1.17,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[heading_three_content]', array(
					'label'      => esc_html__( 'H3:', 'petrona' ),
					'description' => esc_html__('All Heading font size is EM based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 105,
						'step' => 0.1,
					),
					'priority'   => 220,
					'sum_type'    => false,
				)
			)
		);

		/**
		 * -----------------------------------------------------
		 * Content control [Frontpage Sections]
		 * This control allows the user to choose a font size
		 * for the Main content for Frontpage Sections
		 * The values area between 0 and 90 px.
		 * -----------------------------------------------------
		 */
		$wp_customize->add_setting(
			'petrona_options[heading_four_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				// 'default'           => 1,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[heading_four_content]', array(
					'label'      => esc_html__( 'H4:', 'petrona' ),
					'description' => esc_html__('All Heading font size is EM based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 90,
						'step' => 0.1,
					),
					'priority'   => 225,
					'sum_type'    => false,
				)
			)
		);

		$wp_customize->add_setting(
			'petrona_options[heading_five_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				//'default'           => 0.83,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[heading_five_content]', array(
					'label'      => esc_html__( 'H5:', 'petrona' ),
					'description' => esc_html__('All Heading font size is EM based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 75,
						'step' => 0.1,
					),
					'priority'   => 226,
					'sum_type'    => false,
				)
			)
		);

		$wp_customize->add_setting(
			'petrona_options[heading_six_content]', array(
				'sanitize_callback' => 'techt_sanitize_number_range',
				// 'default'           => 0.67,
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new Techt_Customizer_Range_Value_Control(
				$wp_customize, 'petrona_options[heading_six_content]', array(
					'label'      => esc_html__( 'H6:', 'petrona' ),
					'description' => esc_html__('All Heading font size is EM based. So please use slider to increase font size', 'petrona'),
					'section'    => 'petrona_typography_size',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 60,
						'step' => 0.1,
					),
					'priority'   => 227,
					'sum_type'    => false,
				)
			)
		);
	} // End if().
}

add_action( 'customize_register', 'techt_typography_settings', 20 );