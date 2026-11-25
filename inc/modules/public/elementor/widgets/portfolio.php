<?php
namespace Elementor;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Techt Masonry Portfolio Widget.
 *
 * @since 1.0
 */

class Techt_Portfolio_Widget extends Techt_Base {

	public function get_name() {
		return 'techt-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Portfolio', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	public function get_script_depends() {
		return [ 'infinite-scroll', 'scrolla' ];
	}

	/**
	 * Register Portfolio widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_shortings',
			[
				'label' => esc_html__( 'Query', 'petrona' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_types',
			[
				'label' => esc_html__( 'Choose Post Type', 'petrona' ),
				'type' => Controls_Manager::SELECT2,
				'default' => 'portfolio',
				'options' => \Techt_Core_Utility::get_post_type(),
				'multiple' => true,
			]
		);

		$this->add_control(
		    'tax_query',
		    [
		        'label' => esc_html__('Taxonomies', 'petrona'),
		        'type' => Controls_Manager::SELECT2,
		        'options' => \Techt_Core_Utility::get_taxonomy(),
		        'multiple' => true,
		        'label_block' => true
		    ]
		);

		$this->add_control(
		    'post_in',
		    [
		        'label' => esc_html__('Portfolio In', 'petrona'),
		        'description' => esc_html__('Provide a comma separated list of Post IDs to display in the grid.', 'petrona'),
		        'type' => Controls_Manager::TEXT,
		        'label_block' => true
		    ]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Total Post', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 12,
			]
		);

		$this->add_control(
		    'portfolio_order_heading',
		    [
		        'label' => esc_html__('Order Portfolio', 'petrona'),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
		    ]
		);		

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'none' => esc_html__('No order', 'petrona'),
					'ID' => esc_html__('Post ID', 'petrona'),
					'author' => esc_html__('Author', 'petrona'),
					'title' => esc_html__('Title', 'petrona'),
					'date' => esc_html__('Published date', 'petrona'),
					'modified' => esc_html__('Modified date', 'petrona'),
					'parent' => esc_html__('By parent', 'petrona'),
					'rand' => esc_html__('Random order', 'petrona'),
					'comment_count' => esc_html__('Comment count', 'petrona'),
					'menu_order' => esc_html__('Menu order', 'petrona'),
					'post__in' => esc_html__('By include order', 'petrona'),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__( 'ASC', 'petrona' ),
					'DESC' => esc_html__( 'DESC', 'petrona' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section',
			[
				'label' => esc_html__( 'Layout Settings', 'petrona' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);		

		$this->add_control(
			'portfolio_layout',
			[
				'label' => esc_html__( 'Portfolio Layout', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'  => esc_html__( 'Grid Layout', 'petrona' ),
					'carousel' => esc_html__( 'Carousel Layout', 'petrona' ),
				],
				'frontend_available' => true,
				'style_transfer' => true,
				'render' => 'none',
			]
		);		

		$this->add_control(
			'number_grids',
			[
				'label' => esc_html__( 'Number Of Grids', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 3,
				'options' => [
					1  => esc_html__( '1 Columns', 'petrona' ),
					2 => esc_html__( '2 Columns', 'petrona' ),
					3 => esc_html__( '3 Columns', 'petrona' ),
					4 => esc_html__( '4 Columns', 'petrona' ),
				],
				'condition'	=> [
					'portfolio_layout' => 'grid',
				]
			]
		);

		$this->add_control(
		    'masonry_layout',
		    [
		        'label' => esc_html__( 'Masonry Layout', 'petrona' ),
		        'type' => Controls_Manager::SELECT,
		        'options' => [
					'justify'=> esc_html__( 'Justify', 'petrona' ),
		            'even' => esc_html__( 'Even', 'petrona' ),
		            'fitRows' => esc_html__( 'Fit Rows', 'petrona' ),
		            'masonry' => esc_html__( 'Masonry', 'petrona' ),
		            'packery' => esc_html__( 'Packery', 'petrona' ),
		        ],
		        'default' => 'masonry',
		        'render' => 'none',
		        'frontend_available' => true,
		        'prefix_class' => 'techt-portfolio-grid-layout-',
		        'style_transfer' => true,
		        'condition'	=> [
		        	'portfolio_layout' => 'grid',
		        ]
		    ]
		);		

		$this->add_control(
			'custom_img_dimension',
			[
				'label' => esc_html__( 'Image Dimension', 'petrona' ),
				'type' =>  Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. unit works only (px)', 'petrona' ),
				'default' => [
					'width' => '',
					'height' => '',
				],
			]
		);
	
		$this->add_control(
			'show_feature',
			[
				'label' => esc_html__( 'Show First Item as Feature', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'feature_img_dimension',
			[
				'label' => esc_html__( 'Feature Item Image Dimension', 'petrona' ),
				'type' =>  Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. unit works only (px)', 'petrona' ),
				'default' => [
					'width' => '',
					'height' => '',
				],
				'condition'	=> [
		        	'show_feature' => 'yes',
		        ]
			]
		);

		$this->add_control(
			'show_icons',
			[
				'label' => esc_html__( 'Show Item Icon', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'show_cate',
			[
				'label' => esc_html__( 'Show Item Categories', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'show_desc',
			[
				'label' => esc_html__( 'Show Item Description', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'show_location',
			[
				'label' => esc_html__( 'Show Portfolio Location', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
		    'alignment_headings',
		    [
		        'label' => esc_html__('Content Alignment', 'petrona'),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
		    ]
		);	

		$this->add_control(
			'content_alignment',
			[
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'label' => esc_html__( 'Alignment', 'petrona' ),
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors'  => array(
					'{{WRAPPER}} .wrap ' => 'text-align: {{VALUE}};',
				),
			]
		);

		$this->add_control(
		    'pagination_headings',
		    [
		        'label' => esc_html__('Pagination Content', 'petrona'),
		        'type' => Controls_Manager::HEADING,
		        'separator' => 'before',
		        'condition'	=> [
		        	'portfolio_layout' => 'grid',
		        ]
		    ]
		);	

		$this->add_control(
			'pagination_types',
			[
				'label' => esc_html__( 'Pagination Type', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'  => esc_html__( 'None', 'petrona' ),
					'load_more_ajax' => esc_html__( 'Load More Ajax', 'petrona' ),
					'pagi_numbers' => esc_html__( 'Pagination', 'petrona' ),
					'custom_button' => esc_html__( 'Custom Button', 'petrona' ),
				],
				'frontend_available' => true,
				'condition'	=> [
					'portfolio_layout' => 'grid',
				]
			]
		);

		$this->add_control(
			'more_work_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Load More', 'petrona' ),
				'placeholder' => esc_html__( 'Enter Button Text', 'petrona' ),
				'condition'	=> [
					'pagination_types' => ['load_more_ajax', 'custom_button'],
				]
			]
		);

		$this->add_control(
			'more_works_btn_link',
			[
				'label' => esc_html__( 'Button URL', 'petrona' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'petrona' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition'	=> [
					'pagination_types' => ['custom_button'],
				]
			]
		);		

		$this->end_controls_section();

		/**
		 * Carousel Settings
		 */
		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'petrona' ),
				'condition'	=> [
					'portfolio_layout' => 'carousel',
				]
			]
		);

        $this->add_responsive_control(
            'items',
            [
                'label'  => __( 'Visible Items', 'petrona' ),
                'type' => Controls_Manager::SLIDER,
                'default'  => [ 'size' => 3 ],
                'range' => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 10,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
            ]
        );        

        $this->add_responsive_control(
            'margin',
            [
                'label'  => __( 'Item gap', 'petrona' ),
                'type' => Controls_Manager::SLIDER,
                'default'  => [ 'size' => 10 ],
                'range' => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'                 => __( 'Autoplay', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'petrona' ),
                'label_off'             => __( 'No', 'petrona' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'                 => __( 'Autoplay Speed', 'petrona' ),
                'type'                  => Controls_Manager::TEXT,
                'default'               => '2400',
                'title'                 => __( 'Enter carousel speed', 'petrona' ),
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label'                 => __( 'Infinite Loop', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'petrona' ),
                'label_off'             => __( 'No', 'petrona' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'grab_cursor',
            [
                'label'                 => __( 'Grab Cursor', 'petrona' ),
                'description'           => __( 'Shows grab cursor when you hover over the slider', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'          => __( 'Show', 'petrona' ),
                'label_off'         => __( 'Hide', 'petrona' ),
                'return_value'      => 'yes',
            ]
        );        

        $this->add_control(
            'mouse_wheal',
            [
                'label'                 => __( 'Mouse Wheal', 'petrona' ),
                'description'           => __( 'Enable Mouse Wheal', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'          => __( 'Show', 'petrona' ),
                'label_off'         => __( 'Hide', 'petrona' ),
                'return_value'      => 'yes',
            ]
        );        

        $this->add_control(
            'center_slides',
            [
                'label'                 => __( 'Center Slide', 'petrona' ),
                'description'           => __( 'Enable Center Slide', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => '',
                'label_on'          => __( 'Show', 'petrona' ),
                'label_off'         => __( 'Hide', 'petrona' ),
                'return_value'      => 'yes',
            ]
        );
        
        $this->add_control(
            'navigation_heading',
            [
                'label'                 => __( 'Navigation', 'petrona' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
            ]
        );

        $this->add_control(
            'arrows',
            [
                'label'                 => __( 'Arrows', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'petrona' ),
                'label_off'             => __( 'No', 'petrona' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'dots',
            [
                'label'                 => __( 'Pagination', 'petrona' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'petrona' ),
                'label_off'             => __( 'No', 'petrona' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label'                 => __( 'Pagination Type', 'petrona' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'bullets',
                'options'               => [
                    'bullets'       => __( 'Dots', 'petrona' ),
                    'fraction'      => __( 'Fraction', 'petrona' ),
                ],
                'condition'             => [
                    'dots'          => 'yes',
                ],
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'                 => __( 'Direction', 'petrona' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'left',
                'options'               => [
                    'left'       => __( 'Left', 'petrona' ),
                    'right'      => __( 'Right', 'petrona' ),
                ],
				'separator'             => 'before',
            ]
        );

		$this->end_controls_section();

		/**
		 * Filter Settings
		 */
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Filter Settings', 'petrona' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'	=> [
					'portfolio_layout' => 'grid',
				]
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label' => esc_html__( 'Show Filter', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);		

		$this->add_control(
			'show_filter_count',
			[
				'label' => esc_html__( 'Show Count', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'petrona' ),
				'label_off' => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'condition'	=> [
					'show_filter' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		/**
		 * Portfolio Filter Styling
		 */
		$this->start_controls_section(
			'content_filter_styling',
			[
				'label' => esc_html__( 'Portfolio Filter', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_filter' => 'yes',
					'portfolio_layout' => 'grid',
				]
			]
		);


		$this->add_responsive_control(
			'filter_padding',
			[
				'label' => esc_html__( 'Content Spacing', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->add_responsive_control(
			'filter_elemets_padding',
			[
				'label' => esc_html__( 'Items Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-filters li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'filter_elemets_margin',
			[
				'label' => esc_html__( 'Items Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-filters li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'filter_stuatus_device',
			[
				'label' => esc_html__( 'Filter Type', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => [
					'inline'  => __( 'Inline', 'petrona' ),
					'block' => __( 'Block', 'petrona' ),
					'inscroll' => __( 'Inline Scroll', 'petrona' ),
				],
				'prefix_class' => 'filter-stauts%s-',
			]
		);

		$this->add_responsive_control(
			'align_filter',
			[
				'label'   => esc_html__( 'Filter Alignment', 'petrona' ),
				'label_block' => true,
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'filter-align%s-',
				'condition'	=> [
					'show_filter' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_elemets_typo',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .portfolio-filters li a',
			]
		);

		$this->start_controls_tabs(
		    'tabs_filter_normal',
		    [
		        'separator' => 'before'
		    ]
		);
			//Filter Normal Tab
			$this->start_controls_tab(
			    'tab_filter_effects_normal',
			    [
			        'label' => __( 'Normal', 'petrona' ),
			    ]
			);

			$this->add_control(
				'filter_elemets_txt_color',
				[
					'label' => esc_html__( 'Text Color', 'petrona' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_SECONDARY,
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'filter_elemets_bg',
				[
					'label' => esc_html__( 'Background Color', 'petrona' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_ACCENT,
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a' => 'background: {{VALUE}};',
					],
				]
			);

	        $this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'filter_elemets_border',
					'label' => esc_html__( 'Border', 'petrona' ),
					'selector' => '{{WRAPPER}} .portfolio-filters li a',
				]
			); 

	        $this->add_control(
				'filter_elemets_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'petrona' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();			

			//Filter Hover Tab
			$this->start_controls_tab(
			    'tab_filter_effects_hover',
			    [
			        'label' => __( 'Hover', 'petrona' ),
			    ]
			);

			$this->add_control(
				'filter_elemets_hover_txt_color',
				[
					'label' => esc_html__( 'Text Color', 'petrona' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_SECONDARY,
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a' => '-webkit-transition:all 0.3s ease 0s;-moz-transition:all 0.3s ease 0s;-ms-transition:all 0.3s ease 0s;-o-transition:all 0.3s ease 0s;transition:all 0.3s ease 0s;',
						'{{WRAPPER}} .portfolio-filters li a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'filter_elemets_hover_bg',
				[
					'label' => esc_html__( 'Background Color', 'petrona' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_ACCENT,
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a' => '-webkit-transition:all 0.3s ease 0s;-moz-transition:all 0.3s ease 0s;-ms-transition:all 0.3s ease 0s;-o-transition:all 0.3s ease 0s;transition:all 0.3s ease 0s;',
						'{{WRAPPER}} .portfolio-filters li a:hover' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'filter_elemets_border_hover',
					'label' => esc_html__( 'Border', 'petrona' ),
					'selector' => '{{WRAPPER}} .portfolio-filters li a:hover',
				]
			);	

	        $this->add_control(
				'filter_elemets__hover_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'petrona' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

			//Filter Active Element
			$this->start_controls_tab(
			    'tab_filter_active_effects_hover',
			    [
			        'label' => __( 'Active', 'petrona' ),
			    ]
			);

			$this->add_control(
				'filter_elemets_active_txt_color',
				[
					'label' => esc_html__( 'Text Color', 'petrona' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_SECONDARY,
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a.active' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'filter_elemets_active_bg',
				[
					'label' => esc_html__( 'Background Color', 'petrona' ),
					'type' => Controls_Manager::COLOR,
					'global' => [
						'default' => Global_Colors::COLOR_ACCENT,
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a.active' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'filter_elemets_border_active',
					'label' => esc_html__( 'Button Border Active', 'petrona' ),
					'selector' => '{{WRAPPER}} .portfolio-filters li a.active',
				]
			);

	        $this->add_control(
				'filter_elemets__active_border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'petrona' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .portfolio-filters li a.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

		$this->end_controls_tabs();
	
		$this->end_controls_section();		

		/**
		 * Portfolio Element Styling
		 */
		$this->start_controls_section(
			'content_items',
			[
				'label' => esc_html__( 'Portfolio Element', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'petrona' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => __( 'Opacity', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'petrona' ),
			]
		);

		$this->add_control(
			'opacity_hover',
			[
				'label' => __( 'Opacity', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box:hover img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'align_content',
			[
				'label'   => esc_html__( 'Details Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Item Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .portfolio-grid .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'style_transfer' => true,
				'condition'	=> [
					'portfolio_layout' => 'grid',
				]
			]
		);			

		$this->add_responsive_control(
			'item_margin',
			[
				'label' => esc_html__( 'Item Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'	=> [
					'portfolio_layout' => 'grid',
				]
			]
		);

		$this->add_responsive_control(
			'item_radius',
			[
				'label' => esc_html__( 'Border Radius', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfolio_elemets_title_typo',
				'label' => esc_html__( 'Title Typography', 'petrona' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .portfolio-box .wrap .title',
			]
		);
		$this->add_control(
			'items_title_color',
			[
				'label' => esc_html__( 'Title Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .wrap .title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfolio_elemets_desc_typo',
				'label' => esc_html__( 'Description Typography', 'petrona' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .portfolio-box .wrap .excerpt',
			]
		);

		$this->add_control(
			'items_desc_color',
			[
				'label' => esc_html__( 'Description Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .wrap .excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfolio_elemets_cate_typo',
				'label' => esc_html__( 'Category Typography', 'petrona' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .portfolio-box .cate-name',
			]
		);		
		$this->add_control(
			'items_cate_color',
			[
				'label' => esc_html__( 'Category Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .cate-name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'items_cate_size',
			[
				'label' => __( 'Category Icon Size', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
						'min' => 1,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .techt-icon-category' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'items_cate_icon_color',
			[
				'label' => esc_html__( 'Category Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fe651f',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .techt-icon-category' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'items_details_location_icon_color',
			[
				'label' => esc_html__( 'Location Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fe651f',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .wrap .location-icon' => 'color: {{VALUE}};',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'portfolio_elemets_location_typo',
				'label' => esc_html__( 'Location Typography', 'petrona' ),
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .portfolio-box .wrap .location',
			]
		);		

		$this->add_control(
			'items_details_location_color',
			[
				'label' => esc_html__( 'Location Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-box .wrap .location' => 'color: {{VALUE}};',
				],
			]
		);	
		$this->end_controls_section();		

		/**
		 * Portfolio Overlay Styling
		 */
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Portfolio Overlay', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'portfolio_overlay_background',
			[
				'label' => esc_html__( 'Overlay Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box:hover::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box:hover::after' => 'background-color: {{VALUE}};'
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);	
	

		$this->add_control(
			'portfolio_indicator_bg',
			[
				'label' => esc_html__( 'Icon Background', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box .icon' => 'background: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'condition'	=> [
					'show_icons' => 'yes',
				]
			]
		);				

		$this->add_control(
			'portfolio_indicator_icons_color',
			[
				'label' => esc_html__( 'Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .section.section-portfolio .portfolio-boxes .portfolio-box .icon' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'condition'	=> [
					'show_icons' => 'yes',
				]
			]
		);		

		$this->end_controls_section();

		/**
		 * Portfolio More Works Styling
		 */
		$this->start_controls_section(
			'content_more_works_button',
			[
				'label' => esc_html__( 'More Button', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'pagination_types!' => ['pagi_numbers','none'],
				]
			]
		);

		$this->add_responsive_control(
			'load_more_btn_elemets_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'load_more_btn_elemets_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'load_more_btn_elemets_typo',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .btn-more-works',
			]
		);
		
		$this->start_controls_tabs( 'tabs_load_more_btn_style' );
		$this->start_controls_tab( 'load_more_btn_normal',
			[
				'label' => __( 'Normal', 'petrona' ),
			]
		);

		$this->add_control(
			'load_more_btn_elemets_txt_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_btn_elemets_bg',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'load_more_btn_elemets_border',
				'label' => esc_html__( 'Button Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .btn-more-works',
			]
		);  

		$this->end_controls_tab();

		$this->start_controls_tab( 'load_more_btn_hover',
			[
				'label' => __( 'Hover', 'petrona' ),
			]
		);

		$this->add_control(
			'load_more_btn_elemets_hover_txt_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => '-webkit-transition:all 0.3s ease 0s;-moz-transition:all 0.3s ease 0s;-ms-transition:all 0.3s ease 0s;-o-transition:all 0.3s ease 0s;transition:all 0.3s ease 0s;',
					'{{WRAPPER}} .btn-more-works:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .btn-more-works.active' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'load_more_btn_elemets_hover_bg',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => '-webkit-transition:all 0.3s ease 0s;-moz-transition:all 0.3s ease 0s;-ms-transition:all 0.3s ease 0s;-o-transition:all 0.3s ease 0s;transition:all 0.3s ease 0s;',
					'{{WRAPPER}} .btn-more-works:hover' => 'background: {{VALUE}};',
					'{{WRAPPER}} .btn-more-works.active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'load_more_btn_elemets_border_hover',
				'label' => esc_html__( 'Button Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .btn-more-works:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

        $this->add_control(
			'load_more_btn_elemets_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .btn-more-works' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		

		$this->end_controls_section();

		/**
		 * Portfolio Pagination Styling
		 */

		$this->start_controls_section(
			'content_pagination_style',
			[
				'label' => esc_html__( 'Pagination', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'pagination_types' => 'pagi_numbers',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'paginationbtn_btn_elemets_typo',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .custom-pagination .page-numbers li>*',
			]
		);

		$this->start_controls_tabs( 'tabs_content_pagination_style' );
		$this->start_controls_tab( 'content_pagination_normal',
			[
				'label' => __( 'Normal', 'petrona' ),
			]
		);

		$this->add_control(
			'paginationbtn_elemets_txt_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .custom-pagination .page-numbers li>*' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'paginationbtn_elemets_bg',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .custom-pagination .page-numbers li>*' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'content_pagination_hover',
			[
				'label' => __( 'Hover', 'petrona' ),
			]
		);

		$this->add_control(
			'paginationbtn_elemets_hover_txt_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .custom-pagination .page-numbers li>*' => '-webkit-transition:all 0.3s ease 0s;-moz-transition:all 0.3s ease 0s;-ms-transition:all 0.3s ease 0s;-o-transition:all 0.3s ease 0s;transition:all 0.3s ease 0s;',
					'{{WRAPPER}} .custom-pagination .page-numbers li>*:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .custom-pagination .page-numbers li>*.current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'paginationbtn_elemets_hover_bg',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => [
					'{{WRAPPER}} .custom-pagination .page-numbers li>*' => '-webkit-transition:all 0.3s ease 0s;-moz-transition:all 0.3s ease 0s;-ms-transition:all 0.3s ease 0s;-o-transition:all 0.3s ease 0s;transition:all 0.3s ease 0s;',
					'{{WRAPPER}} .custom-pagination .page-numbers li>*:hover' => 'background: {{VALUE}};',
					'{{WRAPPER}} .custom-pagination .page-numbers li>*.current' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

        /**
         * Style Tab: Arrows
         */
        $this->start_controls_section(
            'section_arrows_style',
            [
                'label'                 => __( 'Arrows', 'petrona' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'arrows'       => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'arrow',
            [
                'label'                 => __( 'Choose Arrow', 'petrona' ),
                'type'                  => Controls_Manager::SELECT,
                'label_block'           => false,
                'default'               => 'fa fa-angle-right',
                'options'               => [
                    'fa fa-angle-right'             => __( 'Angle', 'petrona' ),
                    'fa fa-angle-double-right'      => __( 'Double Angle', 'petrona' ),
                    'fa fa-chevron-right'           => __( 'Chevron', 'petrona' ),
                    'fa fa-chevron-circle-right'    => __( 'Chevron Circle', 'petrona' ),
                    'fa fa-arrow-right'             => __( 'Arrow', 'petrona' ),
                    'fa fa-long-arrow-right'        => __( 'Long Arrow', 'petrona' ),
                    'fa fa-caret-right'             => __( 'Caret', 'petrona' ),
                    'fa fa-caret-square-o-right'    => __( 'Caret Square', 'petrona' ),
                    'fa fa-arrow-circle-right'      => __( 'Arrow Circle', 'petrona' ),
                    'fa fa-arrow-circle-o-right'    => __( 'Arrow Circle O', 'petrona' ),
                    'fa fa-hand-o-right'            => __( 'Hand', 'petrona' ),
                ],
            ]
        );
        
        $this->add_responsive_control(
            'arrows_size',
            [
                'label'                 => __( 'Arrows Size', 'petrona' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [ 'size' => '22' ],
                'range'                 => [
                    'px' => [
                        'min'   => 15,
                        'max'   => 100,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'             => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'left_arrow_position',
            [
                'label'                 => __( 'Align Left Arrow', 'petrona' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'         => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
            ]
        );
        
        $this->add_responsive_control(
            'right_arrow_position',
            [
                'label'                 => __( 'Align Right Arrow', 'petrona' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => -100,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => [ 'px' ],
				'selectors'         => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
            ]
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_arrows_normal',
            [
                'label'                 => __( 'Normal', 'petrona' ),
            ]
        );

        $this->add_control(
            'arrows_bg_color_normal',
            [
                'label'                 => __( 'Background Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_normal',
            [
                'label'                 => __( 'Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => __( 'Border', 'petrona' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i'
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'petrona' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_arrows_hover',
            [
                'label'                 => __( 'Hover', 'petrona' ),
            ]
        );

        $this->add_control(
            'arrows_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i:hover, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label'                 => __( 'Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next:hover i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next:hover i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev:hover i' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'                 => __( 'Padding', 'petrona' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-button-next i, {{WRAPPER}} .techt-portfolio-wrapper .swiper-button-prev i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'separator'             => 'before',
			]
		);
        
        $this->end_controls_section();
        
        /**
         * Style Tab: Pagination: Dots
         */
        $this->start_controls_section(
            'section_dots_style',
            [
                'label'                 => __( 'Pagination: Dots', 'petrona' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label'                 => __( 'Position', 'petrona' ),
                'type'                  => Controls_Manager::SELECT,
                'options'               => [
                   'inside'     => __( 'Inside', 'petrona' ),
                   'outside'    => __( 'Outside', 'petrona' ),
                ],
                'default'               => 'outside',
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_size',
            [
                'label'                 => __( 'Size', 'petrona' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 2,
                        'max'   => 40,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'dots_spacing',
            [
                'label'                 => __( 'Spacing', 'petrona' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'min'   => 1,
                        'max'   => 30,
                        'step'  => 1,
                    ],
                ],
                'size_units'            => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'tab_dots_normal',
            [
                'label'                 => __( 'Normal', 'petrona' ),
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_color_normal',
            [
                'label'                 => __( 'Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'active_dot_color_normal',
            [
                'label'                 => __( 'Active Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dots_border_normal',
				'label'                 => __( 'Border', 'petrona' ),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet',
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
			]
		);

		$this->add_control(
			'dots_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'petrona' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
			]
		);

		$this->add_responsive_control(
			'dots_margin',
			[
				'label'                 => __( 'Margin', 'petrona' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
                'allowed_dimensions'    => 'vertical',
				'placeholder'           => [
					'top'      => '',
					'right'    => 'auto',
					'bottom'   => '',
					'left'     => 'auto',
				],
				'selectors'             => [
					'{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
			]
		);
        
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            [
                'label'                 => __( 'Hover', 'petrona' ),
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_color_hover',
            [
                'label'                 => __( 'Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'dots_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'petrona' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .techt-portfolio-wrapper .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
                ],
                'condition'             => [
                    'dots'              => 'yes',
                    'pagination_type'   => 'bullets',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();
	}

	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Slider Settings.
	 *
	 * @access public
	 */
	public function slider_settings() {
        $settings = $this->get_settings();
        
        $slider_options = [
			'direction'              => 'horizontal',
			'speed'                  => 400,
			'slidesPerView'          => ( $settings['items']['size'] !== '' ) ? absint( $settings['items']['size'] ) : 3,
			'spaceBetween'           => ( $settings['margin']['size'] !== '' ) ? $settings['margin']['size'] : 10,
			'grabCursor'             => ( $settings['grab_cursor'] === 'yes' ),
			'autoHeight'             => true,
			'loop'                   => ( $settings['infinite_loop'] === 'yes' ),
			'mousewheel'             => ( $settings['mouse_wheal'] === 'yes' ),
			'centeredSlides'             => ( $settings['center_slides'] === 'yes' ),
		];
        
        if ( $settings['autoplay'] == 'yes' && ! empty( $settings['autoplay_speed'] ) ) {
            $autoplay_speed = $settings['autoplay_speed'];
        } else {
            $autoplay_speed = 999999;
        }

        /**
         * @since 1.0
         */
        if ( techt_is_elementor_version( '>=', '2.9.0' ) ) {
        	$slider_options['handleElementorBreakpoints'] = true;
        }
        
        $slider_options['autoplay'] = [
            'delay'                  => $autoplay_speed
        ];
        
        if ( $settings['dots'] == 'yes' ) {
            $slider_options['pagination'] = [
                'el'                 => '.swiper-pagination-'.esc_attr( $this->get_id() ),
                'type'               => $settings['pagination_type'],
                'clickable'          => true,
            ];
        }
        
        if ( $settings['arrows'] == 'yes' ) {
            $slider_options['navigation'] = [
                'nextEl'             => '.swiper-button-next-'.esc_attr( $this->get_id() ),
                'prevEl'             => '.swiper-button-prev-'.esc_attr( $this->get_id() ),
            ];
        }
        
        $slider_options['breakpoints'] = [
			\Elementor\Plugin::$instance->breakpoints->get_breakpoints()['tablet']->get_value() => [
				'slidesPerView'      => isset($settings['items_tablet']['size']) ? absint($settings['items_tablet']['size']) : 2,
				'spaceBetween'       => isset($settings['margin_tablet']['size']) ? $settings['margin_tablet']['size'] : 10,
			],
			\Elementor\Plugin::$instance->breakpoints->get_breakpoints()['mobile']->get_value() => [
				'slidesPerView'      => isset($settings['items_mobile']['size']) ? absint($settings['items_mobile']['size']) : 1,
				'spaceBetween'       => isset($settings['margin_mobile']['size']) ? $settings['margin_mobile']['size'] : 10,
			],
		];
        
        $this->add_render_attribute(
			'portfolio-feed-container',
			[
				'data-slider-settings' => wp_json_encode( $slider_options ),
			]
		);
    }

    /**
	 * Render insta feed carousel dots output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_dots() {
        $settings = $this->get_settings();

        if ( $settings['dots'] == 'yes' ) { ?>
            <!-- Add Pagination -->
            <div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ); ?>"></div>
        <?php }
    }

    /**
	 * Render portfolio carousel arrows output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
    protected function render_arrows() {
        $settings = $this->get_settings();

        if ( $settings['arrows'] == 'yes' ) { ?>
            <?php
                if ( $settings['arrow'] ) {
                    $techt_next_arrow = $settings['arrow'];
                    $techt_prev_arrow = str_replace("right","left",$settings['arrow']);
                }
                else {
                    $techt_next_arrow = 'fa fa-angle-right';
                    $techt_prev_arrow = 'fa fa-angle-left';
                }
            ?>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $techt_next_arrow ); ?>"></i>
            </div>
            <div class="swiper-button-prev swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $techt_prev_arrow ); ?>"></i>
            </div>
        <?php }
    }

	protected function get_overlay_contents( $settings ) {
		$settings = $this->get_settings_for_display();
		$portfilio_cats = [];
		$portfilio_cat_names = [];
		?>
		<div class="title-cate-wrap">
			<h2 class="title"><?php echo esc_html( get_the_title() ); ?></h2>
			<?php if($settings['show_cate']){
				$portfilio_cats = get_the_terms(get_the_ID(), 'portfolio-category'); 
				if(!empty($portfilio_cats)) {
					$portfilio_cat_names = wp_list_pluck( $portfilio_cats, 'name' );
				}
				?>
				<div class="cate">
					<span class="cate-icon">
						<i class="techt-icon-category"></i>
					</span><!--  /.icon -->
					<?php 
					
					if(!empty($portfilio_cats)) { ?>
						<span class="cate-name">
						<?php
							echo implode(', ', $portfilio_cat_names);
						?>
						</span>
					<?php } ?>
				</div><!--  /.cate -->
			<?php } ?>
		</div>
		<div class="wrap">
            <h2 class="title"><?php echo esc_html( get_the_title() ); ?></h2>
			<?php if($settings['show_desc']){?>
				<p class="excerpt">
					<?php
						if(has_excerpt()){
							?>
								<?php echo get_the_excerpt(); ?>
							<?php
						}
					?>
				</p>
			<?php } ?>
			<?php 
			$portfolio_location = \Techt_Utility::meta_options('portfolio_location');
			if($settings['show_location'] && $portfolio_location){?>
				<div class="portfolio-details">
					<span class="location-icon">
						<i class="techt-icon-location-pin"></i>
					</span><!--  /.icon -->
					<span class="location">
						<?php echo \Techt_Utility::meta_options('portfolio_location') ?>
					</span>
				</div>
			<?php } ?>
        </div>
	<?php }

	/**
	 * Render Portfolio widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() { 
		$settings = $this->get_settings_for_display();
		if( $settings['number_grids'] == 1 ) {
			$grid_no = 'col-lg-12';
		} elseif( $settings['number_grids'] == 2 ) {
			$grid_no = 'col-md-6 col-lg-6';
		} elseif( $settings['number_grids'] == 3 ) {
			$grid_no = 'col-sm-6 col-md-6 col-lg-4';
		} else {
			$grid_no = 'col-md-6 col-lg-3';
		} 

		$terms = get_terms( array(
		    'taxonomy' => \Techt_Utility::theme_options(array('portfolio_cat_rewrite_slug', 'portfolio-category')),
		    'hide_empty' => false,
		) );

		$query_args = \Techt_Core_Utility::query_args($settings); 
		$portfolio_query = new \WP_Query($query_args);
		
		if( $settings['portfolio_layout'] == 'grid' ) {
			require $this->get_widget_template( 'image-content' );
			require $this->get_widget_template( 'portfolio-load-more' );
		} else {
			require $this->get_widget_template( 'carousel-content' );
		}
		
		/**
		 * isotope hack.
		 *
		 * This piece of code may seem unnecessary to you
		 * but it saved me from hell!!!
		 */
		if ( Plugin::$instance->editor->is_edit_mode() ) :
			$origin_left = is_rtl() ? 'false' : 'true';
			
			if( $settings['portfolio_layout'] == 'grid' ) :
		    	printf( '<script>jQuery(".portfolio-grid-%s").isotope({originLeft: %s});</script>', $this->get_id(), $origin_left );
			endif;
		endif;
	}
}

Plugin::instance()->widgets_manager->register( new Techt_Portfolio_Widget() );