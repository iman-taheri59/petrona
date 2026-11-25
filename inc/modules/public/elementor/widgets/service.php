<?php
namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Techt Service Widget.
 *
 * Techt widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0
 */

class Techt_Service_Widget extends Techt_Base {

	public function get_name() {
		return 'techt-service';
	}

	public function get_title() {
		return esc_html__( 'Service', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	/**
	 * Register Service widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

		$active_breakpoints = Plugin::$instance->breakpoints->get_active_breakpoints();

		$rotate_device_args = [];

		$rotate_device_settings = [
			'default' => [
				'unit' => 'deg',
			],
		];

		foreach ( $active_breakpoints as $breakpoint_name => $breakpoint ) {
			$rotate_device_args[ $breakpoint_name ] = $rotate_device_settings;
		}

		$this->start_controls_section(
			'service_content',
			[
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);
		// $repeater = new Repeater();
		$this->add_control(
			'service_layout',
			[
				'label' => esc_html__( 'Layout Style', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'layout-1' => esc_html__( 'Layout 1', 'petrona' ),
					'layout-2' => esc_html__( 'Layout 2', 'petrona' ),
				],
				'default' => 'layout-1',
			]
		);
		$this->add_control(
			'service_image',
			[
				'label' => esc_html__( 'Choose Image', 'petrona' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition'	=> [
					'service_layout' => 'layout-2',
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
				'condition'	=> [
					'service_layout' => 'layout-2',
				]
			]
		);
		$this->add_control(
			'service_link_icon',
			[
				'label' => __( 'Link Icon', 'petrona' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => is_rtl() ? 'techt-icon-arrow-top-left' : 'techt-icon-arrow-top-right',
					'library' => 'techt-icons'
				],
				'condition'	=> [
					'service_layout' => 'layout-2',
				]
			]
		);
		$this->add_control(
			'service_icon',
			[
				'label' => __( 'Service Icon', 'petrona' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid'
				]
			]
		);

		$this->add_control(
			'service_title',
			[
				'label' => esc_html__( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'separator' => 'before',
				'ai' => [
					'type' => 'text',
				],
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __( 'Type your title here', 'petrona' ),
				'default' => esc_html__( 'Add Your Heading Text Here', 'elementor' ),
			]
		);
		$this->add_control(
			'service_title_heading',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h4',
			]
		);
		$this->add_control(
			'service_desc',
			[
				'label' => esc_html__( 'Description', 'elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Default description', 'petrona' ),
				'placeholder' => esc_html__( 'Type your description here', 'petrona' ),
				'rows' => 10,
			]
		);

		$this->add_control(
			'service_morelink_text',
			[
				'label' => esc_html__( 'Read More Text', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
				'default' => esc_html__('Read More', 'petrona' ),
				'condition'	=> [
					'service_layout' => 'layout-1',
				]
			]
		);
		$this->add_control(
			'service_link',
			[
				'label' => esc_html__( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
					// 'custom_attributes' => '',
				],
				'dynamic' => [
					'active' => true,
				],
				
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'service_around_style',
			[
				'label' => esc_html__( 'Around', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_responsive_control(
			'service_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .techt-service' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .techt-service' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'service_bg',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .techt-service',
				'condition'	=> [
					'service_layout' => 'layout-1',
				]
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'service_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .techt-service'
			]
		);
		$this->add_responsive_control(
			'service_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .techt-service' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'service_box_shadow',
				'selector' => '{{WRAPPER}} .techt-service',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'service_image_style',
			[
				'label' => esc_html__( 'Image', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'service_layout' => 'layout-2',
				]
			]
		);
		$this->start_controls_tabs(
		    'tabs_image_normal',
		    [
		        'separator' => 'before'
		    ]
		);
		$this->start_controls_tab(
			'service_image_normal',
			[
				'label' => __( 'Normal', 'petrona' ),
			]
		);
		$this->add_responsive_control(
			'service_image_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-service.layout-2 .service-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'service_image_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-service.layout-2 .service-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'service_image_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .techt-service.layout-2 img',
			)
		);

		$this->add_responsive_control(
			'service_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-service.layout-2 img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'service_image_box_shadow',
				'selector' => '{{WRAPPER}} .techt-service.layout-2 .service-image',
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'service_image_hover',
			[
				'label' => __( 'Hover', 'petrona' ),
			]
		);
		$this->add_responsive_control(
			'service_image_padding_hover',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-service.layout-2:hover .service-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'service_image_margin_hover',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-service.layout-2:hover .service-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'service_image_border_hover',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} .techt-service.layout-2:hover img',
			)
		);

		$this->add_responsive_control(
			'service_image_border_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-service.layout-2:hover img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'service_image_box_shadow_hover',
				'selector' => '{{WRAPPER}} .techt-service.layout-2:hover .service-image',
			)
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'service_overlay_style',
			[
				'label' => esc_html__( 'Cover', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'service_layout' => 'layout-2',
				]
			]
		);

		$this->add_control(
			'link_icon_color',
			[
				'label' => esc_html__( 'Link Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-image .icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .service-image .icon svg' => 'fill: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'link_icon_bg_color',
			[
				'label' => esc_html__( 'Link Icon Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-image .icon' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_around_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Link Icon Box Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .techt-service.layout-2:hover .service-image .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Link Icon Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .techt-service.layout-2 .service-image .icon i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .techt-service.layout-2 .service-image .icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_rotate',
			[
				'label' => esc_html__( 'Rotate', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
				'default' => [
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
				'device_args' => $rotate_device_args,
				'selectors' => [
					'{{WRAPPER}} .techt-service.layout-2 .service-image .icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'link_icon_horiz_position',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Horizontal Position', 'petrona' ),
				'size_units' => [ 'px', '%'],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .techt-service.layout-2 .service-image .icon' => 'left: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_vertical_position',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Vertical Position', 'petrona' ),
				'size_units' => [ 'px', '%'],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .techt-service.layout-2 .service-image .icon' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'link_icon_border',
				'label' => esc_html__( 'Link Icon Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .service-image .icon',
			]
		);
		$this->add_responsive_control(
			'link_icon_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .service-image .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background_color',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'fields_options' => [
					'background' => [
						'label' => __('Cover Color', 'petrona'),
					],
        		],
				'selector' => '{{WRAPPER}} .service-image:before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'service_icon_style',
			[
				'label' => esc_html__( 'Icon', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'service_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-header .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-header .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_icon_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'right'    => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-header' => 'text-align: {{VALUE}}',
				)
			)
		);
		$this->add_control(
			'service_icon_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-header .icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .service-header .icon svg' => 'fill: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'service_icon_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-header .icon' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_responsive_control(
			'service_icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .service-header .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .service-header .icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'service_icon_rotate',
			[
				'label' => esc_html__( 'Rotate', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg', 'grad', 'rad', 'turn', 'custom' ],
				'default' => [
					'unit' => 'deg',
				],
				'tablet_default' => [
					'unit' => 'deg',
				],
				'mobile_default' => [
					'unit' => 'deg',
				],
				'device_args' => $rotate_device_args,
				'selectors' => [
					'{{WRAPPER}} .service-header .icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'service_icon_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .service-header .icon'
			]
		);
		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .service-header .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'service_content_style',
			[
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'service_icon_position',
			array(
				'label'   => esc_html__( 'Icon Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'row'    => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'eicon-h-align-right',
					),
					'column' => array(
						'title' => esc_html__( 'Up', 'petrona' ),
						'icon'  => 'eicon-v-align-top',
					),
					'row-reverse' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'eicon-h-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-content' => 'flex-direction: {{VALUE}}',
				),
				'condition'	=> [
					'service_layout' => 'layout-1',
				]
			)
		);

        $this->add_responsive_control(
			'icon_alignment_2',
			array(
				'label'   => esc_html__( 'Icon Vertical Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'end' => array(
						'title' => esc_html__( 'End', 'petrona' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'start' => array(
						'title' => esc_html__( 'Start', 'petrona' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-content' => 'align-items: {{VALUE}};',
				),
				'condition'	=> [
					'service_layout' => 'layout-1',
				]
			)
		);

		$this->add_responsive_control(
			'service_content_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_content_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'service_content_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .service-content'
			]
		);
		$this->add_responsive_control(
			'service_content_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .service-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'service_content_box_shadow',
				'selector' => '{{WRAPPER}} .service-content',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'service_title_style',
			[
				'label' => esc_html__( 'Title', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'service_title_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_title_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_title_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'right'    => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-title' => 'text-align: {{VALUE}}',
				)
			)
		);
		$this->add_control(
			'service_title_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .service-title' => 'color: {{VALUE}};'
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .service-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'service_description_style',
			[
				'label' => esc_html__( 'Description', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'service_description_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_description_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'justify'    => array(
						'title' => esc_html__( 'Justify', 'petrona' ),
						'icon' => 'eicon-text-align-justify',
					),
					'right'    => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-description p' => 'text-align: {{VALUE}}',
				)
			) 
		);
		$this->add_responsive_control(
			'service_description_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-description p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_description_width',
			[
				'label' => esc_html__( 'Width', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 5
					],
					'%' => [
						'min' => 0,
						'max' => 100
					],
				],
				'selectors' => [
					'{{WRAPPER}} .service-description p' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);
		$this->add_control(
			'service_description_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				// 'default' => '#999999',
				'selectors' => [
					'{{WRAPPER}} .service-description p' => 'color: {{VALUE}};'
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);			
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .service-description p',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'description_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .service-description p'
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'service_morelink_style',
			[
				'label' => esc_html__( 'Read More', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'service_layout' => 'layout-1',
					'service_morelink_text!' => '',
				]
			]
		);
		$this->add_responsive_control(
			'service_morelink_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_responsive_control(
			'service_morelink_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .service-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_control(
			'service_morelink_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fe651f',
				'selectors' => [
					'{{WRAPPER}} .link-arrow-effect' => 'color: {{VALUE}};',
					'{{WRAPPER}} .link-arrow-effect:before' => 'background-color: {{VALUE}};'
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);		

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'morelink_typography',
				'selector' => '{{WRAPPER}} .link-arrow-effect',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render Service widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() { 
		$settings = $this->get_settings_for_display();
		$has_link = ! empty( $settings['service_link']['url'] );
		$html_tag = $has_link ? 'a' : 'span';

		if ( $has_link ) {
			$this->add_link_attributes( 'link', $settings['service_link'] );
		}
		$this->add_render_attribute( 'title', 'class', 'service-title' );
		$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['service_title_heading'] ), $this->get_render_attribute_string( 'title' ), $settings['service_title'] );
		if($settings['service_layout'] == 'layout-1'){
			?>
			<div class="techt-service layout-1" data-animate="hg-zoomIn">
				<div class="service-content" <?php //echo $background; ?>>
					<div class="service-header">
						<figure class="icon elementor-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['service_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</figure>
					</div>
					<div class="service-body">
						<?php if ( ! Utils::is_empty( $settings['service_title'] ) ) : ?>
							<<?php Utils::print_validated_html_tag( $settings['service_title_heading'] ); ?> class="service-title">
								<<?php Utils::print_validated_html_tag( $html_tag ); ?> <?php $this->print_render_attribute_string( 'link' ); ?>>
									<?php $this->print_unescaped_setting( 'service_title' ); ?>
								</<?php Utils::print_validated_html_tag( $html_tag ); ?>>
							</<?php Utils::print_validated_html_tag( $settings['service_title_heading'] ); ?>>
						<?php endif; ?>
						<?php if ( ! Utils::is_empty( $settings['service_desc'] ) ) : ?>
							<div class="service-description mb-0">
								<p>
									<?php $this->print_unescaped_setting('service_desc'); ?>
								</p>
							</div>
						<?php endif; ?>
						<?php if($has_link){ ?>
							<div class="service-read-more">
								<a href="<?php echo $settings['service_link']['url']; ?>" class="link-arrow-effect" data-rel="">
									<span><?php echo $settings['service_morelink_text']; ?></span>
								</a>
							</div>
					<?php } ?>
					</div>
				</div>
			</div>
			<?php
		}elseif($settings['service_layout'] == 'layout-2'){
			?>
			<div class="techt-service layout-2" data-animate="hg-zoomIn">
				<a href="<?php echo $settings['service_link']['url']; ?>" data-rel="">
					<div class="service-image">
						<?php
							if (! empty( $settings['service_image']['url'] ) ) {
								$image_url = $settings['service_image']['url'];
								$image_id = $settings['service_image']['id'];
								$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
								if (!empty($settings['custom_img_dimension']['width']) || !empty($settings['custom_img_dimension']['height'])) {
									$width = $settings['custom_img_dimension']['width'];
									$height = $settings['custom_img_dimension']['height'];
									$image_src = \Techt_Utility::image_crop_url($image_url, $width, $height, true, true);
									?>
										<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" />
										<figure class="icon elementor-icon">
											<?php \Elementor\Icons_Manager::render_icon( $settings['service_link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</figure>
									<?php
								}else{
									$image_src = \Techt_Utility::image_crop_url($image_url, 360, 170, true, true);
									?>
										<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" />
										<figure class="icon elementor-icon">
											<?php \Elementor\Icons_Manager::render_icon( $settings['service_link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</figure>
									<?php
								}
								
							}
						?>
					</div>
				</a>
				<div class="service-content" <?php //echo $background; ?>>
					<div class="service-header d-flex justify-content-between">
						<?php if ( ! Utils::is_empty( $settings['service_title'] ) ) : ?>
							<<?php Utils::print_validated_html_tag( $settings['service_title_heading'] ); ?> class="service-title">
								<<?php Utils::print_validated_html_tag( $html_tag ); ?> <?php $this->print_render_attribute_string( 'link' ); ?>>
									<?php $this->print_unescaped_setting( 'service_title' ); ?>
								</<?php Utils::print_validated_html_tag( $html_tag ); ?>>
							</<?php Utils::print_validated_html_tag( $settings['service_title_heading'] ); ?>>
						<?php endif; ?>
						<figure class="icon elementor-icon">
							<?php \Elementor\Icons_Manager::render_icon( $settings['service_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						</figure>
					</div>
					<div class="service-body">
						<?php if ( ! Utils::is_empty( $settings['service_desc'] ) ) : ?>
							<div class="service-description mb-0">
								<p>
									<?php $this->print_unescaped_setting('service_desc'); ?>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php

		}
		
	}
}

Plugin::instance()->widgets_manager->register( new Techt_Service_Widget() );