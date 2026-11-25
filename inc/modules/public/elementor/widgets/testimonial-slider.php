<?php
namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Techt Testimonial Widget.
 *
 * Techt widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0
 */
class Techt_Testimonials_Slider_Widget extends Techt_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve testimonial widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'techt-testimonial-slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve testimonial widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Testimonial Slider', 'petrona' );
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve testimonial widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-blockquote';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'testimonial', 'blockquote', 'slider' ];
	}

	/**
	 * Register testimonial widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_testimonial',
			[
				'label' => esc_html__( 'Testimonial', 'petrona' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'testimonial_image',
			[
				'label' => esc_html__( 'Choose Image', 'petrona' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'testimonial_content',
			[
				'label' => esc_html__( 'Content', 'petrona' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'rows' => '10',
			]
		);

		$repeater->add_control(
			'testimonial_name',
			[
				'label' => esc_html__( 'Name', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'John Doe',
			]
		);

		$repeater->add_control(
			'testimonial_job',
			[
				'label' => esc_html__( 'Position', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'petrona' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'petrona' ),
			]
		);

		$this->add_control(
			'testimonial_items',
			[
				'label' => __( 'Testimonial Items', 'petrona' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'testimonial_name' => __( 'John Smiths', 'petrona' ),
						'testimonial_content' => __( 'Item content. Click the edit button to change this text.', 'petrona' ),
					],
					[
						'testimonial_name' => __( 'Johan Williams', 'petrona' ),
						'testimonial_content' => __( 'Item content. Click the edit button to change this text.', 'petrona' ),
					],
				],
				'title_field' => '{{{ testimonial_name }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'testimonial_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
				'default' => 'thumbnail',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'testimonial_layouts',
			[
				'label' => __( 'Layout', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'layout_1',
				'options' => [
					'layout_1'  => __( 'Layout 1', 'petrona' ),
					'layout_2' => __( 'Layout 2', 'petrona' ),
				],
			]
		);		

		$this->add_control(
			'testimonial_image_positions',
			[
				'label' => __( 'Image Position', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top_content',
				'options' => [
					'top_content'  => __( 'Top', 'petrona' ),
					'after_content' => __( 'After Content', 'petrona' ),
					'after_author' => __( 'After Client Info', 'petrona' ),
					'none' => __( 'None', 'petrona' ),
				],
				'condition' => [
				    'testimonial_layouts' => 'layout_1',
				],
			]
		);

		$this->add_control(
			'testimonial_alignment',
			[
				'label' => esc_html__( 'Alignment', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'prefix_class' => 'testimonial-align-',
				'label_block' => false,
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'petrona' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'petrona' ),
			]
		);

        $this->add_responsive_control(
            'items',
            [
                'label'  => __( 'Visible Items', 'petrona' ),
                'type' => Controls_Manager::SLIDER,
                'default'  => [ 'size' => 1 ],
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

		// Content.
		$this->start_controls_section(
			'section_style_testimonial_content',
			[
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-testimonial-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'content_text_alignment',
			[
				'label' => esc_html__( 'Text Alignment', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-content' => 'text-align: {{VALUE}};',
				],
				'label_block' => false,
			]
		);
		$this->add_control(
			'content_alignment',
			[
				'label' => esc_html__( 'Alignment', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors_dictionary' => [
					'right'		=> 'margin-left: auto',
					'center' 	=> 'margin-left: auto; margin-right: auto',
					'left' 		=> 'margin-right: auto',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .techt-testimonial-content' => '{{VALUE}}',
				],
				'label_block' => false,
				'style_transfer' => true,
			]
		);
		$this->add_control(
			'content_width',
			[
				'label' => __( 'Width', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'content_content_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .techt-testimonial-content',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'content_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .techt-testimonial-content',
			)
		);
		$this->end_controls_section();

		// Image.
		$this->start_controls_section(
			'section_style_testimonial_image',
			[
				'label' => esc_html__( 'Image', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-testimonial-wrapper .techt-testimonial-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-testimonial-wrapper .techt-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'image_alignment',
			[
				'label' => esc_html__( 'Alignment', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors_dictionary' => [
					'right'		=> 'margin-left: auto',
					'center' 	=> 'margin-left: auto; margin-right: auto',
					'left' 		=> 'margin-right: auto',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .techt-testimonial-image' => '{{VALUE}}',
				],
				'label_block' => false,
				'style_transfer' => true,
			]
		);
		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 200,
					],			
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 105,
				],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-wrapper .techt-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .techt-testimonial-wrapper .techt-testimonial-image img',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
					'isLinked' => true,
					'size_units' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-wrapper .techt-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Name.
		$this->start_controls_section(
			'section_style_testimonial_name',
			[
				'label' => esc_html__( 'Name', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'name_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'name_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'name_alignment',
			[
				'label' => esc_html__( 'Alignment', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-name' => 'text-align: {{VALUE}};',
				],
				'label_block' => false,
			]
		);
		$this->add_control(
			'name_text_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .techt-testimonial-name',
			]
		);

		$this->end_controls_section();

		// Job.
		$this->start_controls_section(
			'section_style_testimonial_job',
			[
				'label' => esc_html_x( 'Position', 'Position at work', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'job_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-job' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'job_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'job_alignment',
			[
				'label' => esc_html__( 'Alignment', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-job' => 'text-align: {{VALUE}};',
				],
				'label_block' => false,
			]
		);

		$this->add_control(
			'job_text_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .techt-testimonial-job' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'job_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
				'selector' => '{{WRAPPER}} .techt-testimonial-job',
			]
		);

		$this->end_controls_section();

		// Item Style.
		$this->start_controls_section(
			'section_style_testimonial_items',
			[
				'label' => esc_html__( 'Items', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-carousel-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'content_bg',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .testimonial-carousel-item',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'size' => ['default' => 'cover'],
					'position' => ['default' => 'center center'],
					'repeat' => ['default' => 'no-repeat'],
					'color' => ['default' => '#f7f7f7'],
				],
			]
		);
		// $this->add_control(
		// 	'item_bg',
		// 	[
		// 		'label' => esc_html__( 'Background Color', 'petrona' ),
		// 		'default' => 'rgba(0,0,0,0)',
		// 		'type' => Controls_Manager::COLOR,
		// 		'global' => [
		// 			'default' => Global_Colors::COLOR_TEXT,
		// 		],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .testimonial-carousel-item' => 'background: {{VALUE}};',
		// 		],
		// 	]
		// );		

		$this->add_control(
			'item_bg_center',
			[
				'label' => esc_html__( 'Center Item Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .testimonial-carousel-item.swiper-slide-active' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow',
				'label' => __( 'Item Box Shadow', 'petrona' ),
				'selector' => '{{WRAPPER}} .testimonial-carousel-item',
			]
		);		

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_shadow_center',
				'label' => __( 'Center Item Box Shadow', 'petrona' ),
				'selector' => '{{WRAPPER}} .testimonial-carousel-item.swiper-slide-active',
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .testimonial-carousel-item',
			]
		);

        $this->add_control(
			'item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .testimonial-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'center_item_z_index',
			[
				'label' => __( 'Z-Index Center Item', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 1000,
				'step' => 1,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .testimonial-carousel-item.swiper-slide-active' => 'z-index: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'meta_alignment',
			array(
				'label'   => esc_html__( 'Meta Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Start', 'petrona' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'End', 'petrona' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-testimonial-meta-inner' => 'justify-content: {{VALUE}};',
				),
			)
		);
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
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i' => 'color: {{VALUE}};',
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
				'selector'              => '{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i'
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __( 'Border Radius', 'petrona' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i:hover, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i:hover, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i:hover' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i:hover, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-button-next i, {{WRAPPER}} .techt-testimonial-wrapper .swiper-button-prev i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet' => 'background: {{VALUE}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
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
				'selector'              => '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet',
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
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
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
                    '{{WRAPPER}} .techt-testimonial-wrapper .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
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
	 * Slider Settings.
	 *
	 * @access public
	 */
	public function slider_settings() {
        $settings = $this->get_settings();
        
        $slider_options = [
			'direction'              => 'horizontal',
			'speed'                  => 400,
			'slidesPerView'          => ( $settings['items']['size'] !== '' ) ? absint( $settings['items']['size'] ) : 1,
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
        
        $slider_options['autoplay'] = [
            'delay'                  => $autoplay_speed
        ];

        /**
         * @since 1.0.0
         */
        if ( techt_is_elementor_version( '>=', '2.9.0' ) ) {
        	$slider_options['handleElementorBreakpoints'] = true;
        }
        
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
			'testimonial-feed-container',
			[
				'data-slider-settings' => wp_json_encode( $slider_options ),
			]
		);
    }

	/**
	 * Render testimonial widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'techt-testimonial-wrapper' );
		// $this->add_render_attribute( 'image', 'class', 'techt-testimonial-image-wrap' );
		// if ( $settings['testimonial_alignment'] ) {
		// 	$this->add_render_attribute( 'wrapper', 'class', 'text-' . $settings['testimonial_alignment'] );
		// 	$this->add_render_attribute( 'image', 'class', 'image-' . $settings['testimonial_alignment'] );
		// }
		$swiper_class = $this->_swiper_container_class();
		$this->add_render_attribute( 'testimonial-feed-container', 'class', [
		    $swiper_class,
		    'swiper-container-' . esc_attr( $this->get_id() )
		] );

		$this->add_render_attribute( 'item-feed', [
		    'id'        => 'testimonial-feed-' . esc_attr( $this->get_id() ),
		    'class'     => 'testimonial-feed-grid'
		] );

		if ( $settings['dots_position'] ) {
		    $this->add_render_attribute( 'testimonial-feed-container', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position'] );
		}

		$this->add_render_attribute( 'item-feed', 'class', 'swiper-wrapper' );

		$this->slider_settings();
		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'testimonial-feed-container' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'item-feed' ); ?>>
				<?php foreach ($settings['testimonial_items'] as $key => $value) {
					$this->add_render_attribute( 'meta', 'class', 'techt-testimonial-meta' );

					if ( $value['testimonial_image']['url'] ) {
						$this->add_render_attribute( 'meta', 'class', 'techt-has-image' );
					}

					$has_content = ! ! $value['testimonial_content'];
					$has_image = ! ! $value['testimonial_image']['url'];
					$has_name = ! ! $value['testimonial_name'];
					$has_job = ! ! $value['testimonial_job'];

					if ( ! $has_content && ! $has_image && ! $has_name && ! $has_job ) {
						return;
					}

					if ( ! empty( $value['link']['url'] ) ) {
						$this->add_render_attribute( 'link', 'href', $value['link']['url'] );

						if ( $value['link']['is_external'] ) {
							$this->add_render_attribute( 'link', 'target', '_blank' );
						}

						if ( ! empty( $value['link']['nofollow'] ) ) {
							$this->add_render_attribute( 'link', 'rel', 'nofollow' );
						}
					} ?>

					<div class="testimonial-carousel-item swiper-slide">
						<?php if( $settings['testimonial_layouts'] == 'layout_1' ) { ?>
							<div class="testimonial-one-block">							
								<?php if( $settings['testimonial_image_positions'] == 'top_content' ) { ?>
								<?php if ( $has_image ) : ?>
									<div class="techt-testimonial-image-wrap">
										<div class="techt-testimonial-image">
											<?php
											$image_html = Group_Control_Image_Size::get_attachment_image_html( $value, 'testimonial_image' );
											if ( ! empty( $value['link']['url'] ) ) :
												$image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
											endif;
											echo $image_html;
											?>
										</div>
									</div>
								<?php endif; ?>
								<?php } ?>

								<?php if ( $has_content ) :
									$this->add_render_attribute( 'testimonial_content', 'class', 'techt-testimonial-content' );

									$this->add_inline_editing_attributes( 'testimonial_content' );
									?>
									<div <?php echo $this->get_render_attribute_string( 'testimonial_content' ); ?>>
										<span class="quote-indicator before">&ldquo;</span>
										<span class="quote-contents"><?php echo $value['testimonial_content']; ?></span>
										<span class="quote-indicator after">&rdquo;</span>
									</div>
								<?php endif; ?>

								<?php if ( $has_image || $has_name || $has_job ) : ?>
								<div <?php echo $this->get_render_attribute_string( 'meta' ); ?>>
									<div class="techt-testimonial-meta-inner">
										<?php if( $settings['testimonial_image_positions'] == 'after_content' ) { ?>
										<?php if ( $has_image ) : ?>
											<div class="techt-testimonial-image">
												<?php
												$image_html = Group_Control_Image_Size::get_attachment_image_html( $value, 'testimonial_image' );
												if ( ! empty( $value['link']['url'] ) ) :
													$image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
												endif;
												echo $image_html;
												?>
											</div>
										<?php endif; ?>
										<?php } ?>

										<?php if ( $has_name || $has_job ) : ?>
										<div class="techt-testimonial-details">
											<?php
											if ( $has_name ) :
												$this->add_render_attribute( 'testimonial_name', 'class', 'techt-testimonial-name' );

												$this->add_inline_editing_attributes( 'testimonial_name', 'none' );

												$testimonial_name_html = $value['testimonial_name'];
												if ( ! empty( $value['link']['url'] ) ) :
													$testimonial_name_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $testimonial_name_html . '</a>';
												endif;
												?>
												<div <?php echo $this->get_render_attribute_string( 'testimonial_name' ); ?>><?php echo $testimonial_name_html; ?></div>
											<?php endif; ?>
											<?php
											if ( $has_job ) :
												$this->add_render_attribute( 'testimonial_job', 'class', 'techt-testimonial-job' );

												$this->add_inline_editing_attributes( 'testimonial_job', 'none' );

												$testimonial_job_html = $value['testimonial_job'];
												if ( ! empty( $value['link']['url'] ) ) :
													$testimonial_job_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $testimonial_job_html . '</a>';
												endif;
												?>
												<div <?php echo $this->get_render_attribute_string( 'testimonial_job' ); ?>><?php echo $testimonial_job_html; ?></div>
											<?php endif; ?>
										</div>
										<?php endif; ?>

										<?php if( $settings['testimonial_image_positions'] == 'after_author' ) { ?>
										<?php if ( $has_image ) : ?>
											<div class="techt-testimonial-image mrt-30">
												<?php
												$image_html = Group_Control_Image_Size::get_attachment_image_html( $value, 'testimonial_image' );
												if ( ! empty( $value['link']['url'] ) ) :
													$image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
												endif;
												echo $image_html;
												?>
											</div>
										<?php endif; ?>
										<?php } ?>
									</div>
								</div>
								<?php endif; ?>
							</div><!--  /.testimonial-two-block -->
						<?php } else { ?>
							<div class="testimonial-two-block">
								<div class="row align-items-center">
									<?php if ( $has_image ) : ?>
									<div class="techt-testimonial-image-wrap">
										<div class="techt-testimonial-image">
											<?php
											$image_html = Group_Control_Image_Size::get_attachment_image_html( $value, 'testimonial_image' );
											if ( ! empty( $value['link']['url'] ) ) :
												$image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $image_html . '</a>';
											endif;
											echo $image_html;
											?>
										</div>
									</div><!--  /.col-lg-4 -->
									<?php endif; ?>
									<div class="techt-testimonial-content-wrap <?php echo esc_attr( $has_image ? ' col-8' : ' col-lg-12' ) ?>">
										<?php if ( $has_content ) :
											$this->add_render_attribute( 'testimonial_content', 'class', 'techt-testimonial-content' );

											$this->add_inline_editing_attributes( 'testimonial_content' );
											?>
											<!-- <div class="quote-indicator before"><i class="fas fa-quote-left"></i></div> -->
											<div <?php echo $this->get_render_attribute_string( 'testimonial_content' ); ?>><?php echo $value['testimonial_content']; ?></div>
										<?php endif; ?>
										<?php if ( $has_name || $has_job ) : ?>
										<div <?php echo $this->get_render_attribute_string( 'meta' ); ?>>
											<div class="techt-testimonial-meta-inner">
												<?php if ( $has_name || $has_job ) : ?>
												<div class="techt-testimonial-details">
													<?php
													if ( $has_name ) :
														$this->add_render_attribute( 'testimonial_name', 'class', 'techt-testimonial-name' );

														$this->add_inline_editing_attributes( 'testimonial_name', 'none' );

														$testimonial_name_html = $value['testimonial_name'];
														if ( ! empty( $value['link']['url'] ) ) :
															$testimonial_name_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $testimonial_name_html . '</a>';
														endif;
														?>
														<div <?php echo $this->get_render_attribute_string( 'testimonial_name' ); ?>><?php echo $testimonial_name_html; ?></div>
													<?php endif; ?>
													<?php
													if ( $has_job ) :
														$this->add_render_attribute( 'testimonial_job', 'class', 'techt-testimonial-job' );

														$this->add_inline_editing_attributes( 'testimonial_job', 'none' );

														$testimonial_job_html = $value['testimonial_job'];
														if ( ! empty( $value['link']['url'] ) ) :
															$testimonial_job_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $testimonial_job_html . '</a>';
														endif;
														?>
														<div <?php echo $this->get_render_attribute_string( 'testimonial_job' ); ?>><?php echo $testimonial_job_html; ?></div>
													<?php endif; ?>
												</div>
												<?php endif; ?>
											</div>
										</div>
										<?php endif; ?>
									</div><!--  /.col-lg-8 -->
								</div><!--  /.row -->
							</div><!--  /.testimonial-two-block -->
						<?php } ?>
					</div>
				<?php } ?>
				</div>
				<?php $this->render_dots(); ?>
			</div>
			<?php $this->render_arrows(); ?>		
		</div>		
		<?php
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
	 * Render insta feed carousel arrows output on the frontend.
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
            <div class="elementor-swiper-button elementor-swiper-button-next swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $techt_next_arrow ); ?>"></i>
            </div>
            <div class="elementor-swiper-button elementor-swiper-button-prev swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
                <i class="<?php echo esc_attr( $techt_prev_arrow ); ?>"></i>
            </div>
        <?php }
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

}

Plugin::instance()->widgets_manager->register( new Techt_Testimonials_Slider_Widget() );