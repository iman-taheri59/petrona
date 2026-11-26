<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Core\Files\CSS\Post as Elementor_Post;
use Techt_Core_Utility;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Slider extends Techt_Base {

	public function get_name() {
		return 'techt-slider';
	}

	public function get_title() {
		return esc_html__( 'Slider', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}


	public function get_categories() {
		return ['techt-category'];
	}

	public function get_style_depends() {

		return array('tec-slider' );
	}

	public function get_script_depends() {
		return array('touch-events','easing', 'tec-slider' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'techt/slider/css-scheme',
			array(
				'instance'            => '.techt-slider-wrapper',
				'content_wrapper'     => '.techt-slider__content',
				'content_inner'       => '.tecSlider-slide-inner',
				'content_item'        => '.tecSlider-slide-contents',
				'main_slider'     	  => '.techt-slider-wrapper .swiper-container-main',
				'main_image'          => '.tecSlider-container-main .slider-image-container',
                'navigation_prev'     => '.techt-slider-wrapper .tecSlider_prev',
				'navigation_next'     => '.techt-slider-wrapper .tecSlider_next',
				'pagination'          => '.techt-slider-wrapper .tecSlider_pag_ul',
				'icon'                => '.techt-slider__icon',
				'title'               => '.techt-slider__title',
				'subtitle'            => '.techt-slider__subtitle',
				'desc'                => '.techt-slider__desc',
				'buttons_wrapper'     => '.techt-slider__button-wrapper',
				'buttons'             => '.techt-slider__button',
				'primary_button'      => '.techt-slider__button--primary',
				'secondary_button'    => '.techt-slider__button--secondary',
				'overlay'             => '.techt-slider-wrapper .tecSliderSlide:after',
				'thumbnails'          => '.techt-slider-wrapper .tecSlider_thumbs_cont ul li > img',
				'thumbnail_container' => '.techt-slider-wrapper .tecSlider_thumbs_cont',
			)
		);

		$animations = array(
			'none' => __( 'None', 'petrona' ),
			'hg-fadeInDown' => __( 'Down', 'petrona' ),
			'hg-fadeInUp' => __( 'Up', 'petrona' ),
			'hg-fadeInRight' => __( 'Right', 'petrona' ),
			'hg-fadeInLeft' => __( 'Left', 'petrona' ),
			'hg-zoomIn' => __( 'Zoom', 'petrona' ),
		);

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Items', 'petrona' ),
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'slides_repeater' );
		$repeater->start_controls_tab( 'content', [ 'label' => __( 'Content', 'petrona' ) ] );

		$repeater->add_control(
			'item_content_type',
			array(
				'label'   => esc_html__( 'Content Type', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'petrona' ),
					'template' => esc_html__( 'Template', 'petrona' ),
				),
			)
		);

		$repeater->add_control(
			'template_id',
			[
				'label' => esc_html__('Choose Template', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => [],
				'separator' => 'after',
				'options'     => $this->get_techt_templates(),
                'condition'   => array(
					'item_content_type' => 'template',
				),
			]
		);

		$repeater->add_control(
			'item_enable_content',
			[
				'label' => __( 'Content Enable', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => true,
				'return_value' => true,
			]
		);

		$repeater->add_control(
			'item_title',
			array(
				'label'     => esc_html__( 'Title', 'petrona' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'separator' => 'before',
				'dynamic'   => array( 'active' => true ),
				'condition'   => array(
					'item_enable_content' => true,
				),
			)
		);

		$repeater->add_control(
			'item_title_html_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_available_title_html_tags(),
				'default' => 'h1',
				'condition'   => array(
					'item_enable_content' => true,
				),
			)
		);

		$repeater->add_control(
			'item_subtitle',
			array(
				'label'     => esc_html__( 'Subtitle', 'petrona' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'separator' => 'before',
				'dynamic'   => array( 'active' => true ),
				'condition'   => array(
					'item_enable_content' => true,
				),
			)
		);

		$repeater->add_control(
			'item_subtitle_html_tag',
			array(
				'label'   => esc_html__( 'Subtitle HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_available_title_html_tags(),
				'default' => 'h2',
				'condition'   => array(
					'item_enable_content' => true,
				),
			)
		);

		$repeater->add_control(
			'item_desc',
			array(
				'label'     => esc_html__( 'Description', 'petrona' ),
				'type'      => Controls_Manager::TEXTAREA,
				'separator' => 'before',
				'dynamic'   => array( 'active' => true ),
				'condition'   => array(
					'item_enable_content' => true,
				),
			)
		);

		$repeater->add_control(
			'item_button_primary_url',
			array(
				'label'   => esc_html__( 'Primary Button URL', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'separator' => 'before',
				'default' => '',
				'dynamic' => array(
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'condition'   => array(
					'item_enable_content' => true,
				),
			)
		);

		$repeater->add_control(
			'item_button_primary_target',
			array(
				'label'        => esc_html__( 'Open link in new window', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => '_blank',
				'condition'    => array(
					'item_enable_content' 	=> true,
					'item_button_primary_url!' => '',
				),
			)
		);

		$repeater->add_control(
			'item_button_primary_rel',
			array(
				'label'        => esc_html__( 'Add nofollow', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'nofollow',
				'condition'    => array(
					'item_button_primary_url!' => '',
					'item_enable_content' 	=> true,
				),
			)
		);

		$repeater->add_control(
			'item_button_primary_text',
			array(
				'label'     => esc_html__( 'Primary Button Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'More', 'petrona' ),
				'dynamic'   => array( 'active' => true ),
				'condition' => array(
					'item_enable_content' 	=> true,
				),
			)
		);

		$repeater->add_control(
			'item_button_secondary_url',
			array(
				'label'   => esc_html__( 'Secondary Button URL', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array(
					'active' => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'condition' => array(
					'item_enable_content' 	=> true,
				),
			)
		);

		$repeater->add_control(
			'item_button_secondary_target',
			array(
				'label'        => esc_html__( 'Open link in new window', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => '_blank',
				'condition'    => array(
					'item_button_secondary_url!' => '',
					'item_enable_content' 	=> true,
				),
			)
		);

		$repeater->add_control(
			'item_button_secondary_rel',
			array(
				'label'        => esc_html__( 'Add nofollow', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'nofollow',
				'condition'    => array(
					'item_button_secondary_url!' => '',
					'item_enable_content' 	=> true,
				),
			)
		);

		$repeater->add_control(
			'item_button_secondary_text',
			array(
				'label'     => esc_html__( 'Secondary Button Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'More', 'petrona' ),
				'dynamic'   => array( 'active' => true ),
				'condition' => array(
					'item_enable_content' 	=> true,
				),
			)
		);

		$repeater->end_controls_tab();
		$repeater->start_controls_tab( 'image', [ 'label' => __( 'Image', 'petrona' ) ] );

		$repeater->add_control(
			'item_image',
			[
				'label' => esc_html__( 'Choose Image', 'petrona' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'item_content_type' => 'default',
				],
			]
		);
		// $repeater->add_group_control(
		// 	\Elementor\Group_Control_Background::get_type(),
		// 	[
		// 		'name' => 'item_bg',
		// 		'types' => [ 'classic', 'gradient', 'video' ],
		// 		'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .slider-image-container',
		// 		'fields_options' => [
		// 			'background' => [
		// 				'default' => 'classic',
		// 			],
		// 			'image' => [
		// 				'default' => ['url'	=> Utils::get_placeholder_image_src()],
		// 			],
		// 			'size' => ['default' => 'cover'],
		// 			'position' => ['default' => 'center center'],
		// 			'repeat' => ['default' => 'no-repeat'],
		// 			'color' => ['default' => '#bbbbbb'],
		// 		],
		// 		'condition' => array(
		// 			'item_content_type' => 'default',
		// 		),
		// 	]
		// );

		// $repeater->add_control(
		// 	'item_bg_ken_burns',
		// 	[
		// 		'label' => __( 'Ken Burns Effect', 'petrona' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'default' => 'false',
		// 		'return_value' => true,
		// 		'condition' => array(
		// 			// 'item_bg_video!'  	=> 'yes',
		// 		),
		// 	]
		// );

		// $repeater->add_control(
		// 	'item_zoom_direction',
		// 	[
		// 		'label' => __( 'Zoom Direction', 'petrona' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => 'in',
		// 		'options' => [
		// 			'in' => __( 'In', 'petrona' ),
		// 			'out' => __( 'Out', 'petrona' ),
		// 		],
		// 		'condition'   => [
		// 			'item_bg_ken_burns' => true,
		// 		],
		// 	]
		// );
		$repeater->add_control(
			'item_effect_type',
			[
				'label' => __( 'Effect Type', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' 						=> __( 'None', 'petrona'),
					'random' 					=> __( 'Random', 'petrona'),
					'simpleFade' 				=> __( 'Simple Fade', 'petrona' ),
					'curtainTopLeft' 			=> __( 'Curtain Top Left', 'petrona' ),
					'curtainTopRight' 			=> __( 'Curtain Top Right', 'petrona' ),
					'curtainBottomLeft' 		=> __( 'Curtain Bottom Left', 'petrona' ),
					'curtainBottomRight' 		=> __( 'Curtain Bottom Right', 'petrona' ),
					'curtainSliceLeft' 			=> __( 'Curtain Slice Left', 'petrona' ),
					'curtainSliceRight' 		=> __( 'Curtain Slice Right', 'petrona' ),
					'blindCurtainTopLeft' 		=> __( 'Blind Curtain Top Left', 'petrona' ),
					'blindCurtainTopRight' 		=> __( 'Blind Curtain Top Right', 'petrona' ),
					'blindCurtainBottomLeft' 	=> __( 'Blind Curtain Bottom Left', 'petrona' ),
					'blindCurtainBottomRight' 	=> __( 'Blind Curtain Bottom Right', 'petrona' ),
					'blindCurtainSliceBottom' 	=> __( 'Blind Curtain Slice Bottom', 'petrona' ),
					'blindCurtainSliceTop' 		=> __( 'Blind Curtain Slice Top', 'petrona' ),
					'stampede' 					=> __( 'Stampede', 'petrona' ),
					'mosaic' 					=> __( 'Mosaic', 'petrona' ),
					'mosaicReverse' 			=> __( 'Mosaic Reverse', 'petrona' ),
					'mosaicRandom' 				=> __( 'Mosaic Random', 'petrona' ),
					'mosaicSpiral' 				=> __( 'Mosaic Spiral', 'petrona' ),
					'mosaicSpiralReverse' 		=> __( 'Mosaic Spiral Reverse', 'petrona' ),
					'topLeftBottomRight' 		=> __( 'Top Left Bottom Right', 'petrona' ),
					'topRightBottomLeft' 		=> __( 'Top Right Bottom Left', 'petrona' ),
					'bottomRightTopLeft' 		=> __( 'Bottom Right Top Left', 'petrona' ),
					'bottomLeftTopRight' 		=> __( 'Bottom Left Top Right', 'petrona' ),
					'scrollLeft' 				=> __( 'Ccroll Left', 'petrona' ),
					'scrollRight' 				=> __( 'Scroll Right', 'petrona' ),
					'scrollHorz' 				=> __( 'Scroll Horz', 'petrona' ),
					'scrollBottom' 				=> __( 'Scroll Bottom', 'petrona' ),
					'scrollTop' 				=> __( 'Scroll Top', 'petrona' ),
				],
			]
		);

		$repeater->add_control(
			'item_overlay',
			[
				'label' => __( 'Overlay', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'false',
				'return_value' => true,
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'item_overlay_color',
				'label'    => __( 'Overlay Color', 'petrona' ),
				'types'    => [ 'classic', 'gradient'],
				'exclude'  => ['image'],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .tecSliderSlide:after',
				'fields_options' => [
					'background' => [
						'label' => __('Color', 'petrona'),
						'default' => 'classic',
					],
					'color' => ['default' => 'rgba(0,0,0,0.3)'],
				],
				'condition' => array(
					'item_overlay' => true,
				),
			]
		);
		$repeater->add_control(
			'item_overlay_opacity',
			array(
				'label'    => esc_html__( 'Opacity', 'petrona' ),
				'type'     => Controls_Manager::NUMBER,
				'default'  => 0.2,
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSliderSlide:after' => 'opacity: {{VALUE}};',
				),
				'condition' => array(
					'item_overlay' => true,
				),
			)
		);
		
		$repeater->end_controls_tab();

		$repeater->start_controls_tab( 'style', [ 'label' => __( 'Style', 'petrona' ) ] );

		$repeater->add_control(
			'slide_id',
			array(
				'label'   => esc_html__( 'Slide CSS ID', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_custom_style',
			[
				'label' => __( 'Custom', 'petrona' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => __( 'Set custom style that will only affect this specific slide.', 'petrona' ),
			]
		);

		$repeater->add_control(
			'item_content_heading',
			[
				'label' => __( 'Content', 'petrona' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			],
		);

		$repeater->add_responsive_control(
			'item_content_width',
			[
				'label' => __( 'Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 65,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);
		
		$repeater->add_responsive_control(
			'item_content_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			)
		);

		$repeater->add_responsive_control(
			'item_content_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_content_bg_color',
			[
				'label' => __( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);
		$repeater->add_responsive_control(
			'item_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1400,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .techt-slider__content' => 'inset-inline-start: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);

		$repeater->add_responsive_control(
			'item_vertical_position',
			[
				'label' => __( 'Vertical Position', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .techt-slider__content' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);
		
		$repeater->add_responsive_control(
			'item_text_alignment',
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
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents' => 'text-align: {{VALUE}}',
				),
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			)
		);
		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'item_content_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents',
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_content_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_content_box_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .tecSlider-slide-contents',
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_title_heading',
			[
				'label' => __( 'Title', 'petrona' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_title_text_align',
			[
				'label' => __( 'Text Align', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'petrona' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'] => 'text-align: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_responsive_control(
			'item_title_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_responsive_control(
			'item_title_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} ' . $css_scheme['title'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);
		$repeater->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'label' => __( 'Stroke Text', 'petrona' ),
				'name' => 'item_title_text_stroke',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);
		$repeater->add_control(
			'item_title_color',
			[
				'label' => __( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'] => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);
		$repeater->add_control(
			'item_title_bg_color',
			[
				'label' => __( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'] => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'item_title_text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_title_border',
				'label' => __( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);
	
		$repeater->add_control(
			'item_title_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_title_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['title'] => 'animation-delay: {{VALUE}}s',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_subtitle_heading',
			[
				'label' => __( 'SubTitle', 'petrona' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_subtitle_text_align',
			[
				'label' => __( 'Text Align', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'petrona' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'] => 'text-align: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_responsive_control(
			'item_subtitle_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_responsive_control(
			'item_subtitle_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_subtitle_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} ' . $css_scheme['subtitle'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);
		$repeater->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'label' => __( 'Stroke Text', 'petrona' ),
				'name' => 'item_subtitle_text_stroke',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);
		$repeater->add_control(
			'item_subtitle_color',
			[
				'label' => __( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'] => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style'      => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_subtitle_bg_color',
			[
				'label' => __( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'] => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'item_subtitle_text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_subtitle_border',
				'label' => __( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_subtitle_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_subtitle_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['subtitle'] => 'animation-delay: {{VALUE}}s',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_desc_heading',
			[
				'label' => __( 'Description', 'petrona' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_desc_text_align',
			[
				'label' => __( 'Text Align', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'petrona' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'] => 'text-align: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);
		$repeater->add_responsive_control(
			'item_desc_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_responsive_control(
			'item_desc_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_desc_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} ' . $css_scheme['desc'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_desc_color',
			[
				'label' => __( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'] => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_desc_bg_color',
			[
				'label' => __( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'] => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'item_desc_text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_desc_border',
				'label' => __( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_desc_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_desc_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['desc'] => 'animation-delay: {{VALUE}}s',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_button_heading',
			[
				'label' => __( 'Button', 'petrona' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_button_text_align',
			[
				'label' => __( 'Text Align', 'petrona' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'petrona' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'petrona' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'petrona' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'] => 'text-align: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_responsive_control(
			'item_button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons_wrapper'] => 'text-align: {{VALUE}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);
		$repeater->add_responsive_control(
			'item_button_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_responsive_control(
			'item_button_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} ' . $css_scheme['buttons'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_button_color',
			[
				'label' => __( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'] => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_button_bg_color',
			[
				'label' => __( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'] => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);


		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'item_button_text_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_button_border',
				'label' => __( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons'],
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			]
		);

		$repeater->add_control(
			'item_button_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->add_control(
			'item_button_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} '. $css_scheme['buttons_wrapper'] => 'animation-delay: {{VALUE}}s',
				),
				'condition' => [ 
					'item_custom_style' => 'yes',
				],
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();


		$this->add_control(
			'item_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_image'              => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_title'                 => esc_html__( 'Slide #1', 'petrona' ),
						'item_subtitle'              => esc_html__( 'SubTitle', 'petrona' ),
						'item_desc'                  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'petrona' ),
						'item_button_primary_url'    => '#',
						'item_button_primary_text'   => esc_html__( 'Button #1', 'petrona' ),
						'item_button_secondary_ulr'  => '#',
						'item_button_secondary_text' => esc_html__( 'Button #2', 'petrona' ),
						),
					array(
						'item_image'              => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_title'                 => esc_html__( 'Slide #2', 'petrona' ),
						'item_subtitle'              => esc_html__( 'SubTitle', 'petrona' ),
						'item_desc'                  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'petrona' ),
						'item_button_primary_url'    => '#',
						'item_button_primary_text'   => esc_html__( 'Button #1', 'petrona' ),
						'item_button_secondary_ulr'  => '#',
						'item_button_secondary_text' => esc_html__( 'Button #2', 'petrona' ),
					),
					array(
						'item_image'              => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_title'                 => esc_html__( 'Slide #3', 'petrona' ),
						'item_subtitle'              => esc_html__( 'SubTitle', 'petrona' ),
						'item_desc'                  => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'petrona' ),
						'item_button_primary_url'    => '#',
						'item_button_primary_text'   => esc_html__( 'Button #1', 'petrona' ),
						'item_button_secondary_ulr'  => '#',
						'item_button_secondary_text' => esc_html__( 'Button #2', 'petrona' ),
					),

				),
				'title_field' => '{{{ item_title }}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'label' => __( 'Slider Height', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					]
				],
				'default' => [
					'size' => 400,
				],
				'size_units' => [ 'px', '%'],
			]
		);

		$this->add_control(
			'content_animation',
			array(
				'label'   => esc_html__( 'Content Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hg-fadeInUp',
				'options' => $animations,
			)
		);

		$this->add_control(
			'slider_navigation',
			array(
				'label'        => esc_html__( 'Use navigation?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'slider_nav_on_hover',
			array(
				'label'        => esc_html__( 'Navigation on hover', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'true',
				'description'  => esc_html__( 'if active the navigation buttons will be visible on hover state only','petrona' ),
				'condition'             => [
					'slider_navigation'  => 'true',
				],
			)
		);

		$this->add_control(
			'slider_navigation_icon_arrow',
			[
				'label'                 => __('Choose Arrow', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'label_block'           => false,
				'default'               => 'techt-icon-angle-right',
				'options'               => [
					'techt-icon-angle-right-1'             => __('Angle', 'petrona'),
					'techt-icon-angle-double-right'      => __('Double Angle', 'petrona'),
					'techt-icon-angle-right'           => __('Chevron', 'petrona'),
					'techt-icon-arrow-circle-right'    => __('Chevron Circle', 'petrona'),
					'techt-icon-arrow-right'             => __('Arrow', 'petrona'),
					'techt-icon-right-thin'        => __('Long Arrow', 'petrona'),
					'techt-icon-hand-point-right'            => __('Hand', 'petrona'),
				],
				'condition'             => [
					'slider_navigation'  => 'true',
				],
			]
		);

		$this->add_control(
			'slider_pagination',
			array(
				'label'        => esc_html__( 'Use pagination?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);
		$this->add_control(
			'slider_thumbs',
			array(
				'label'        => esc_html__( 'Show Thumbnails?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'false',
				'description'  => esc_html__( 'If pagination is active, the image will be displayed with hover on the dots.', 'petrona' ),
			)
		);
		$this->add_control(
			'slider_autoplay',
			array(
				'label'        => esc_html__( 'Use autoplay?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'false',
				'separator'    => 'before',
			)
		);
		$this->add_control(
			'slider_mobile_autoplay',
			array(
				'label'        => esc_html__( 'Use autoplay on mobile?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);
		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause Auto Play on Hover?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'condition'             => [
					'slider_autoplay'  => 'true',
				],
			)
		);

		// $this->add_control(
		// 	'slider_autoplay_delay',
		// 	array(
		// 		'label'   => esc_html__( 'Autoplay delay(ms)', 'petrona' ),
		// 		'type'    => Controls_Manager::NUMBER,
		// 		'default' => 5000,
		// 		'min'     => 2000,
		// 		'max'     => 10000,
		// 		'step'    => 100,
		// 		'condition' => array(
		// 			'slider_autoplay' => true,
		// 		),
		// 	)
		// );
		$this->add_control(
			'slider_progress_type',
			[
				'label'                 => __('Choose Progress Type', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'label_block'           => false,
				'default'               => 'bar',
				'options'               => [
					'none'	=> __('None', 'petrona'),
					'bar'   => __('Bar', 'petrona'),
					'pie'   => __('Pie', 'petrona'),
				],
				'separator' => 'before',
				'condition'             => [
					'slider_autoplay'  => 'true',
				],
			]
		);
		$this->add_control(
			'slider_bar_position',
			array(
				'label'   => esc_html__( 'Progress Bar Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => array(
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
					'top'  => esc_html__( 'Top', 'petrona' ),
					'bottom'  => esc_html__( 'Bottom', 'petrona' ),
				),
				'condition' => [
					'slider_autoplay'  => 'true',
					'slider_progress_type'  => 'bar',
				],
			)
			
		);

		$this->add_control(
			'slider_bar_direction',
			array(
				'label'   => esc_html__( 'Progress Bar Direction', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'rightToLeft',
				'options' => array(
					'rightToLeft'  	=> esc_html__( 'Right to Left', 'petrona' ),
					'leftToRight'	=> esc_html__( 'Left to Right', 'petrona' ),
					'bottomToTop'  	=> esc_html__( 'Bottom to Top', 'petrona' ),
					'topToBottom'  	=> esc_html__( 'Top to Bottom', 'petrona' ),
				),
				'condition' => [
					'slider_autoplay'  => 'true',
					'slider_progress_type'  => 'bar',
				],
			)
			
		);

		$this->add_control(
			'slider_pie_position',
			array(
				'label'   => esc_html__( 'Progress Pie Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'leftTop',
				'options' => array(
					'leftTop'  => esc_html__( 'Left-Top', 'petrona' ),
					'rightTop' => esc_html__( 'Right-Top', 'petrona' ),
					'leftBottom'  => esc_html__( 'Left-Bottom', 'petrona' ),
					'rightBottom'  => esc_html__( 'Right-Bottom', 'petrona' ),
				),
				'condition' => [
					'slider_autoplay'  => 'true',
					'slider_progress_type'  => 'pie',
				],
			)
			
		);

		$this->add_control(
			'slider_effect_type',
			[
				'label' => __( 'Transition Effect Type', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' 						=> __( 'None', 'petrona'),
					'random' 					=> __( 'Random', 'petrona'),
					'simpleFade' 				=> __( 'Simple Fade', 'petrona' ),
					'curtainTopLeft' 			=> __( 'Curtain Top Left', 'petrona' ),
					'curtainTopRight' 			=> __( 'Curtain Top Right', 'petrona' ),
					'curtainBottomLeft' 		=> __( 'Curtain Bottom Left', 'petrona' ),
					'curtainBottomRight' 		=> __( 'Curtain Bottom Right', 'petrona' ),
					'curtainSliceLeft' 			=> __( 'Curtain Slice Left', 'petrona' ),
					'curtainSliceRight' 		=> __( 'Curtain Slice Right', 'petrona' ),
					'blindCurtainTopLeft' 		=> __( 'Blind Curtain Top Left', 'petrona' ),
					'blindCurtainTopRight' 		=> __( 'Blind Curtain Top Right', 'petrona' ),
					'blindCurtainBottomLeft' 	=> __( 'Blind Curtain Bottom Left', 'petrona' ),
					'blindCurtainBottomRight' 	=> __( 'Blind Curtain Bottom Right', 'petrona' ),
					'blindCurtainSliceBottom' 	=> __( 'Blind Curtain Slice Bottom', 'petrona' ),
					'blindCurtainSliceTop' 		=> __( 'Blind Curtain Slice Top', 'petrona' ),
					'stampede' 					=> __( 'Stampede', 'petrona' ),
					'mosaic' 					=> __( 'Mosaic', 'petrona' ),
					'mosaicReverse' 			=> __( 'Mosaic Reverse', 'petrona' ),
					'mosaicRandom' 				=> __( 'Mosaic Random', 'petrona' ),
					'mosaicSpiral' 				=> __( 'Mosaic Spiral', 'petrona' ),
					'mosaicSpiralReverse' 		=> __( 'Mosaic Spiral Reverse', 'petrona' ),
					'topLeftBottomRight' 		=> __( 'Top Left Bottom Right', 'petrona' ),
					'topRightBottomLeft' 		=> __( 'Top Right Bottom Left', 'petrona' ),
					'bottomRightTopLeft' 		=> __( 'Bottom Right Top Left', 'petrona' ),
					'bottomLeftTopRight' 		=> __( 'Bottom Left Top Right', 'petrona' ),
					'scrollLeft' 				=> __( 'Scroll Left', 'petrona' ),
					'scrollRight' 				=> __( 'Scroll Right', 'petrona' ),
					'scrollHorz' 				=> __( 'Scroll Horz', 'petrona' ),
					'scrollBottom' 				=> __( 'Scroll Bottom', 'petrona' ),
					'scrollTop' 				=> __( 'Scroll Top', 'petrona' ),
				],
			]
		);
		$this->add_control(
			'trans_speed',
			array(
				'label'   => esc_html__( 'Transition Speed(ms)', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1500,
				'min'     => 100,
				'max'     => 10000,
				'step'    => 100,
			)
		);
		$this->add_control(
			'slide_duration',
			array(
				'label'   => esc_html__( 'Slide Duration(ms)', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 7000,
				'min'     => 100,
				'max'     => 30000,
				'step'    => 100,
				'condition' => [
					'slider_autoplay'  => 'true',
				],
			)
		);
		$this->add_control(
			'thumbs_title',
			[
				'label' => __( 'Thumbnails', 'petrona' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'slider_thumbs' => 'true',
				),
			]
		);
		$this->add_responsive_control(
			'thumbs_height',
			[
				'label' => __( 'Thumbnails Height', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 100,
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'slider_thumbs' => 'true',
				),
			]
		);
		
		$this->add_responsive_control(
			'thumbs_distance',
			array(
				'label' => esc_html__( 'Between Thumbnails Distance', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
						'step'  => 1,
					),
				),
				'default' => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ' ul li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'slider_thumbs' => 'true',
				),
			)
		);
		// $this->add_control(
		// 	'thumbs_ratio',
		// 	[
		// 		'label' => __( 'Ratio', 'petrona' ),
		// 		'type' => Controls_Manager::SELECT,
		// 		'default' => '219',
		// 		'options' => [
		// 			'169' => '16:9',
		// 			'219' => '21:9',
		// 			'43' => '4:3',
		// 			'11' => '1:1',
		// 		],
		// 		'prefix_class' => 'elementor-aspect-ratio-',
		// 		'condition' => [
		// 			'slider_thumbs' => 'true',
		// 		],
		// 	]
		// );

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_slider_general_style',
			array(
				'label'      => esc_html__( 'General', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'overlay_heading',
			array(
				'label'     => esc_html__( 'Overlay', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'overlay_background',
				'fields_options' => array(
					'color' => array(
						'global' => [
							'default' => Global_Colors::COLOR_SECONDARY,
						],
					),
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['overlay'],
			)
		);

		$this->add_control(
			'overlay_opacity',
			array(
				'label'    => esc_html__( 'Opacity', 'petrona' ),
				'type'     => Controls_Manager::NUMBER,
				'default'  => 0.2,
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['overlay'] => 'opacity: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'widget_container_heading',
			array(
				'label'     => esc_html__( 'Widget Container', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . ' .techt-slider__item'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->end_controls_section();

		/**
		 * Content Slider Section
		 */
		$this->start_controls_section(
			'section_content_slider_style',
			array(
				'label'      => esc_html__( 'Content Wrapper', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'slides_text_alignment',
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
					'{{WRAPPER}} .tecSlider-slide-contents' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'item_horizontal_position',
			[
				'label' => __( 'Horizontal Position', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1400,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .techt-slider__content' => 'inset-inline-start: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_vertical_position',
			[
				'label' => __( 'Vertical Position', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .techt-slider__content' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'slide_content_width',
			[
				'label' => __( 'Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 65,
				],
				'selectors' => [
					'{{WRAPPER}} .tecSlider-slide-contents' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'slider_content_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_item'],
			)
		);

		$this->add_responsive_control(
			'slider_content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'slider_content_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['content_item'],
			)
		);

		$this->add_control(
			'slider_content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content_item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_content_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_item'],
			)
		);

		$this->end_controls_section();

		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'section_slider_title_style',
			array(
				'label'      => esc_html__( 'Title', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_title_color',
			array(
				'label'  => esc_html__( 'Title Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'slider_title_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_title_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'slider_title_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
			)
		);

		$this->add_control(
			'slider_title_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['title'] => 'animation-delay: {{VALUE}}s',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * SubTitle Style Section
		 */
		$this->start_controls_section(
			'section_slider_subtitle_style',
			array(
				'label'      => esc_html__( 'Subtitle', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'slider_subtitle_color',
			array(
				'label'  => esc_html__( 'Subtitle Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_subtitle_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['subtitle'],
			)
		);

		$this->add_responsive_control(
			'slider_subtitle_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_subtitle_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'slider_subtitle_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
			)
		);

		$this->add_control(
			'slider_subtitle_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['subtitle'] => 'animation-delay: {{VALUE}}s',
				),
			)
		);
		$this->end_controls_section();

		/**
		 * Desc Style Section
		 */
		$this->start_controls_section(
			'section_slider_desc_style',
			array(
				'label'      => esc_html__( 'Description', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		$this->add_responsive_control(
			'slider_desc_max_width',
			[
				'label' => __( 'Max Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range' => array(
					'%' => array(
						'min' => 20,
						'max' => 100,
					),
					'px' => array(
						'min' => 300,
						'max' => 1000,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'max-width: {{SIZE}}{{UNIT}};',
				),
			]
		);

		$this->add_responsive_control(
			'slider_desc_container_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_desc_color',
			array(
				'label'  => esc_html__( 'Description Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'slider_desc_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['desc'],
			)
		);

		$this->add_responsive_control(
			'slider_desc_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_desc_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'slider_desc_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
			)
		);

		$this->add_control(
			'slider_desc_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['desc'] => 'animation-delay: {{VALUE}}s',
				),
			)
		);
		$this->end_controls_section();

		/**
		 * Action Button #1 Style Section
		 */
		$this->start_controls_section(
			'section_action_button_style',
			array(
				'label'      => esc_html__( 'Action Button', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'slider_action_button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['buttons_wrapper'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'section_action_primary_button_heading',
			array(
				'label'     => esc_html__( 'Action Button #1', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'primary_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'primary_button_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_primary_button_style' );

		$this->start_controls_tab(
			'tab_primary_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'primary_button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'primary_button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'primary_button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['primary_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'primary_button_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['primary_button'],
			)
		);

		$this->add_responsive_control(
			'primary_button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'primary_button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['primary_button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_primary_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'primary_button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'primary_button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['primary_button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'primary_button_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'primary_button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'primary_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['primary_button'] . ':hover',
			)
		);
		
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'section_action_secondary_button_heading',
			array(
				'label'     => esc_html__( 'Action Button #2', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'secondary_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'secondary_button_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_secondary_button_style' );

		$this->start_controls_tab(
			'tab_secondary_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'secondary_button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'secondary_button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['secondary_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'secondary_button_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['secondary_button'],
			)
		);

		$this->add_responsive_control(
			'secondary_button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'secondary_button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['secondary_button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_secondary_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'secondary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'secondary_button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'secondary_button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['secondary_button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'secondary_button_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'secondary_button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'secondary_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['secondary_button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'slider_button_animation',
			array(
				'label'   => esc_html__( 'Motion Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $animations,
			)
		);

		$this->add_control(
			'slider_button_animation_delay',
			array(
				'label' => esc_html__( 'Animation Delay', 'petrona' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 2,
				'step' => 0.1,
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['buttons_wrapper'] => 'animation-delay: {{VALUE}}s',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Navigation Style Section
		 */
		$this->start_controls_section(
			'section_slider_navigation_style',
			array(
				'label'      => esc_html__( 'Navigation', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'normal_navigation_size',
			array(
				'label'      => esc_html__( 'Box Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev']  => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next']  => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'normal_navigation_box_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev']  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next']  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'navigation_style_tabs' );

		$this->start_controls_tab(
			'tab_normal_navigation_styles',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'normal_navigation_color',
			array(
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ' i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'] . ' i' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ' svg' => 'fill: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'] . ' svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'normal_navigation_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'normal_navigation_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev']  => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} ' . $css_scheme['navigation_next']  => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'normal_navigation_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'selectors'  => array(
					'{{WRAPPER}} tecSlider_prev',
					'{{WRAPPER}} tecSlider_next',
				),
			)
		);

		$this->add_control(
			'normal_navigation_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev']  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next']  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'normal_navigation_box_shadow',
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'],
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'],
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hover_navigation_styles',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'hover_navigation_color',
			array(
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ':hover i' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['navigation_next'] . ':hover i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'hover_navigation_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ':hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'hover_navigation_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ':hover' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} ' . $css_scheme['navigation_next'] . ':hover' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'hover_navigation_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '0px',
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev']  => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} ' . $css_scheme['navigation_next']  => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'hover_navigation_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'hover_navigation_box_shadow',
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['navigation_prev'] . ':hover',
                    '{{WRAPPER}} ' . $css_scheme['navigation_next'] . ':hover',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Pagination Style Section
		 */
		$this->start_controls_section(
			'section_pagination_style',
			array(
				'label'      => esc_html__( 'Pagination', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'pagination_position',
			array(
				'label'                 => __('Position', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'inside'     => __('Inside', 'petrona'),
					'outside'    => __('Outside', 'petrona'),
				],
				'default'               => 'inside',
			)
		);

        $this->add_responsive_control(
			'pagination_orientation',
			array(
				'label'                 => __('Orientation', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'row'     => __('Horizontal', 'petrona'),
					'column'       => __('Vertical', 'petrona'),
				],
				'default'               => 'row',
                // 'selectors'  => array(
				// 	'{{WRAPPER}} ' . $css_scheme['pagination'] => 'flex-direction: {{VALUE}};',
				// ),
			)
		);

		$this->add_responsive_control(
			'pagination_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'justify-content: {{VALUE}};',
				),
                'condition'  => array(
					'pagination_orientation' => 'row'
				)
			)
		);

        $this->add_responsive_control(
			'pagination_alignment_2',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'align-items: {{VALUE}};',
				),
                'condition'  => array(
					'pagination_orientation' => 'column'
				)
			)
		);

		$this->add_responsive_control(
			'pagination_container_offset',
			array(
				'label'   => esc_html__( 'Pagination Container Offset', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -600,
						'max' => 600,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => array(
					'{{WRAPPER}} .tecSlider_pag' => 'bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_dots_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['pagination'] . ' li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_pagination_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'pagination_style_cont_dots',
				'label'          => esc_html__( 'Dots Container Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['pagination'] . ' li',
				'fields_options' => array(
					'color' => array(
						'default' => '#fff',
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
					'box_size',
				),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'pagination_style_dots',
				'label'          => esc_html__( 'Dots Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['pagination'] . ' li > span',
				'fields_options' => array(
					'color' => array(
						'default' => '#fff',
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
					'box_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'pagination_style_cont_dots_hover',
				'label'          => esc_html__( 'Dots Container Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['pagination'] . ' li:hover',
				'fields_options' => array(
					'color' => array(
						'default' => Global_Colors::COLOR_PRIMARY,
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
					'box_size',
				),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'pagination_style_dots_hover',
				'label'          => esc_html__( 'Dots Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['pagination'] . ' li:hover > span',
				'fields_options' => array(
					'color' => array(
						'default' => '#fff',
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
					'box_size',
				),
			)
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_pagination_active',
			array(
				'label' => esc_html__( 'Active', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'pagination_style_cont_dots_active',
				'label'          => esc_html__( 'Dots Container Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['pagination'] . ' li.tecSlidercurrent',
				'fields_options' => array(
					'color' => array(
						'default' => Global_Colors::COLOR_PRIMARY,
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
					'box_size',
				),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'pagination_style_dots_active',
				'label'          => esc_html__( 'Dots Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['pagination'] . ' li.tecSlidercurrent > span',
				'fields_options' => array(
					'color' => array(
						'default' => '#fff',
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
					'box_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Thumbnails Style Section
		 */
		$this->start_controls_section(
			'section_thumbnails_style',
			array(
				'label'      => esc_html__( 'Thumbnails', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'thumbnail_item_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail_container'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'   => 'before',
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'thumbnails_container_offset',
			array(
				'label'   => esc_html__( 'Thumbnails Container Offset', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => -500,
				'max'     => 500,
				'step'    => 1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnails'] => 'margin-top: {{VALUE}}px;',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_thumbnails_style' );

		$this->start_controls_tab(
			'tab_thumbnails_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumbnails_normal_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'selector'  => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ' .slider-thumbnail',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnails_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumbnails_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . ' .slider-thumbnail:hover',
					 '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . '.swiper-slide-active .slider-thumbnail:hover',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbnails_active',
			array(
				'label' => esc_html__( 'Active', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'thumbnails_active_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'selector'  => '{{WRAPPER}} ' . $css_scheme['thumbnail_container'] . '.swiper-slide-active .slider-thumbnail',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fraction_style',
			array(
				'label'      => esc_html__( 'Fraction Pagination', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'pagination_type' => 'fraction'
				)
			)
		);

		$this->start_controls_tabs( 'tabs_fraction_style' );

		$this->start_controls_tab(
			'tab_fraction_current',
			array(
				'label' => esc_html__( 'Current Value', 'petrona' ),
			)
		);

		$this->add_control(
			'fraction_current_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .current' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fraction_current_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .current' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'fraction_current_padding',
			array(
				'label'       => esc_html__( 'Padding', 'petrona' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .current' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'fraction_total',
			array(
				'label' => esc_html__( 'Total Value', 'petrona' ),
			)
		);

		$this->add_control(
			'fraction_total_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .total' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fraction_total_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .total' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fraction_total_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'fraction_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-slider-wrapper .techt-slider__fraction-pagination .total' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'fraction_total_padding',
			array(
				'label'       => esc_html__( 'Padding', 'petrona' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array( 'px', '%' ),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .total' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'fraction_separator',
			array(
				'label' => esc_html__( 'Separator', 'petrona' ),
			)
		);

		$this->add_control(
			'fraction_separator_color',
			array(
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .separator' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'fraction_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Start', 'petrona' ),
						'icon'  => 'eicon-h-align-' . ( is_rtl() ? 'left' : 'right' ),
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'End', 'petrona' ),
						'icon'  => 'eicon-h-align-' . ( is_rtl() ? 'right' : 'left' ),
					),
				),
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fraction_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'separator' => 'before',
				'selector' => '{{WRAPPER}} .techt-slider__fraction-pagination span',
			)
		);

		$this->add_responsive_control(
			'fraction_gap',
			array(
				'label'   => esc_html__( 'Gap', 'petrona' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 5,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .separator' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'fraction_margin',
			array(
				'label'      => esc_html__( 'Pagination Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name' => 'fraction_border',
				'selector' => '{{WRAPPER}} .techt-slider__fraction-pagination span:not(.separator)',
			)
		);

		$this->add_control(
			'fraction_border_radius',
			array(
				'label' => esc_html__( 'Border Radius', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors' => array(
					'{{WRAPPER}} .techt-slider__fraction-pagination .current' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .techt-slider__fraction-pagination .total' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->update_controls();
	}

    	/**
	 * Render carousel dots output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_pagination()
	{
		$settings = $this->get_settings();

		if ($settings['slider_pagination'] == true) { ?>
			<!-- Add Pagination -->
			<div class="swiper-pagination swiper-pagination-<?php echo esc_attr($this->get_id()); ?>"></div>
		<?php }
	}

	/**
	 * Render blog carousel arrows output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_arrows()
	{
		$settings = $this->get_settings();
		$slider_arrows = [];

		if ($settings['slider_navigation_icon_arrow']) {
			$techt_next_arrow = $settings['slider_navigation_icon_arrow'];
			$techt_prev_arrow = str_replace("right", "left", $settings['slider_navigation_icon_arrow']);
		} else {
			$techt_next_arrow = 'techt-icon-angle-right';
			$techt_prev_arrow = 'techt-icon-left-right';
		}

		if ($settings['slider_navigation'] == true) {
	
			$slider_arrows['next_arrow'] =
			is_rtl() ? '<div class="tecSlider-buttons tecSlider_prev tecSlider-button-prev-'.esc_attr($this->get_id()).'">
				<i class="' . esc_attr($techt_next_arrow) . '"></i>
			</div>' : '<div class="tecSlider-buttons tecSlider_next tecSlider-button-next-'.esc_attr($this->get_id()).'">
				<i class="' . esc_attr($techt_next_arrow) . '"></i>
			</div>';
			$slider_arrows['prev_arrow'] = 
			is_rtl() ?  '<div class="tecSlider-buttons tecSlider_next tecSlider-button-next-' . esc_attr($this->get_id()) . '">
				<i class="' . esc_attr($techt_prev_arrow) . '"></i>
			</div>' : '<div class="tecSlider-buttons tecSlider_prev tecSlider-button-prev-' . esc_attr($this->get_id()) . '">
				<i class="' . esc_attr($techt_prev_arrow) . '"></i>
			</div>';
		}

		if ($settings['slider_thumbs'] == true) {
			$slider_arrows['thumbs_next_arrow'] =
			is_rtl() ? '<div class="tecSlider_prevThumbs tecSlider-thumbs-btn-prev-'.esc_attr($this->get_id()) . 'hideNav">
				<i class="' . esc_attr($techt_next_arrow) . '"></i>
			</div>' : '<div class="tecSlider_nextThumbs tecSlider-thumbs-btn-next-'.esc_attr($this->get_id()) . 'hideNav">
				<i class="' . esc_attr($techt_next_arrow) . '"></i>
			</div>';
			$slider_arrows['thumbs_prev_arrow'] = 
			is_rtl() ?  '<div class="tecSlider_nextThumbs tecSlider-thumbs-btn-next-' . esc_attr($this->get_id()) . 'hideNav">
				<i class="' . esc_attr($techt_prev_arrow) . '"></i>
			</div>' : '<div class="tecSlider_prevThumbs tecSlider-thumbs-btn-prev-' . esc_attr($this->get_id()) . 'hideNav">
				<i class="' . esc_attr($techt_prev_arrow) . '"></i>
			</div>';
		}
		return $slider_arrows;
	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$module_settings = $this->get_settings();
		$widget_id = $this->get_id();
		$other_options = [];

		$slider_options = array(
			// 'direction'              => 'horizontal',
			'height'				 =>  $module_settings['slider_height']['size'] . $module_settings['slider_height']['unit'],
			'transPeriod'            =>  $module_settings['trans_speed'],
			'time'            		 =>  $module_settings['slide_duration'],//milliseconds between the end of the sliding effect and the start of the next one
			'navigationHover'		 => $module_settings['slider_nav_on_hover'] ? (boolean) $module_settings['slider_nav_on_hover'] : false,
			'autoAdvance'			 => $module_settings['slider_autoplay'] ? (boolean) $module_settings['slider_autoplay'] : false,
			'mobileAutoAdvance'		 => $module_settings['slider_mobile_autoplay'] ? (boolean) $module_settings['slider_mobile_autoplay'] : false,
			'hover'					 => (boolean) $module_settings['pause_on_hover'],
			'pagination'			 => (boolean) $module_settings['slider_pagination'],
			'paginationInOut'		 => $module_settings['pagination_position'],
            'pagDirection'           => $module_settings['pagination_orientation'] == 'row' ? 'horizontal' : 'vertical',
			'navigation'			 => (boolean) $module_settings['slider_navigation'],
			'navPrevElem'			 => $this->render_arrows()['prev_arrow'] ? $this->render_arrows()['prev_arrow'] : '',
			'navNextElem'			 => $this->render_arrows()['next_arrow'] ? $this->render_arrows()['next_arrow'] : '',
			'fx'					 =>	($module_settings['slider_effect_type'] !== 'none' || $module_settings['slider_effect_type'] !== '') ? $module_settings['slider_effect_type'] : 'scrollRight',
			'loader'				 => $module_settings['slider_progress_type'] ? $module_settings['slider_progress_type'] : 'none',
			'barPosition'			 => $module_settings['slider_bar_position'] ? $module_settings['slider_bar_position'] : 'bottom',
			'barDirection'			 => $module_settings['slider_bar_direction'] ? $module_settings['slider_bar_direction'] : 'rightToLeft',
			'piePosition'			 => $module_settings['slider_pie_position'] ? $module_settings['slider_pie_position'] : 'leftTop',
			'thumbnails'			 => $module_settings['slider_thumbs'] ? (boolean) $module_settings['slider_thumbs'] : false,
			'navPrevThumbsElem'		 =>	$this->render_arrows()['thumbs_prev_arrow'] ? $this->render_arrows()['thumbs_prev_arrow'] : '',
			'navNextThumbsElem'		 => $this->render_arrows()['thumbs_next_arrow'] ? $this->render_arrows()['thumbs_next_arrow'] : '',
		);

		$this->add_render_attribute(
			'slider-container',
			[
				'data-slider-settings' => wp_json_encode($slider_options),
				'data-settings' => wp_json_encode($other_options),
				
			]
		);

	}

	/**
	 * [__loop_button_item description]
	 * @param  array  $keys   [description]
	 * @param  string $format [description]
	 * @return [type]         [description]
	 */
	protected function _loop_button_item( $keys = array(), $format = '%s' ) {
		$item = $this->_processed_item;
		$params = [];

		foreach ( $keys as $key => $value ) {

			if ( ! array_key_exists( $value, $item ) ) {
				return false;
			}

			if ( empty( $item[$value] ) ) {
				return false;
			}

			$params[] = $item[ $value ];
		}

		return vsprintf( $format, $params );
	}

	/**
	 * [__loop_item_image_tag description]
	 * @return [type] [description]
	 */
	protected function _loop_item_bg_tag() {
		$settings = $this->get_settings_for_display();
		$item  = $this->_processed_item;
		$ken_burns = $item['item_bg_ken_burns'] == true ?  sprintf('techt-ken-burns techt-ken-burns--%1$s', $item['item_zoom_direction']) : '';
		
		if ($item['item_content_type'] == 'template'){
			$template = $this-> _loop_item_template_content();
			$format = '<div class="slider-image-container techt-template %1$s">';
			$bg_tag = sprintf( $format, $ken_burns);
			$bg_tag .= $template;
			$bg_tag .= '</div>';
				
		}else if ($item['item_content_type'] == 'default'){
			if($item['item_bg_background'] == 'video'){
				$format = '<video class="slider-video-container %1$s" preload="none" muted playsinline poster="%2$s"><source src="%3$s" type="video/mp4"></video>';
				$play_on_mobile = $item['item_bg_play_on_mobile'] ? 'play-on-mobile' : '';
				$poster_image = $item['item_bg_video_fallback']['url'];
				$start_time = $item['item_bg_video_start'];
				$end_time = $item['item_bg_video_end'];
				$bg_tag = sprintf( $format, $play_on_mobile, $poster_image, $item['item_bg_video_link'] . '#t=' . $start_time . ',' . $end_time);
			}else{
				$format = '<div class="slider-image-container slider-image elementor-carousel-image %1$s"></div>';
				$bg_tag = sprintf( $format, $ken_burns);
			}
			
		}
		
		return $bg_tag;
	}

	/**
	 * Get item template content.
	 *
	 * @return string|void
	 */
	protected function _loop_item_template_content() {

		$template_id = $this->_processed_item['template_id'];

		if ( empty( $template_id ) ) {
			return;
		}

		// for multi-language plugins
		$template_id = apply_filters( 'techt/widgets/template_id', $template_id, $this );

		$args = array( 'post_type' => 'petrona_templates', 'p' => $template_id );

		$content = "";
        $loop = new \WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
			$content = Plugin::instance()->frontend->get_builder_content($template_id, true);
            endwhile;
        wp_reset_postdata();
		return $content;
	}


	private function update_controls() {
		$slider_controls = [
			'item_bg_color',
		];

		foreach ( $slider_controls as $control_id ) {
			$this->update_control(
				$control_id,
				[ 'recursive' => true ]
			);
		}

	}


	/**
	 * [render description]
	 * @return [type] [description]
	 */
	protected function render() {

		$this->_context = 'render';
		$this->_open_wrap();
		require $this->get_widget_template( 'index' );
		$this->_close_wrap();
	}

	protected function content_template() {}
}
Plugin::instance()->widgets_manager->register( new Techt_Slider() );