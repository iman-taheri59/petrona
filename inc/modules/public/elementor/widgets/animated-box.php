<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Animated_Box extends Techt_Base {

	public function get_name() {
		return 'techt-animated-box';
	}

	public function get_title() {
		return esc_html__( 'Animated Box', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'techt/animated-box/css-scheme',
			array(
				'animated_box'                => '.techt-animated-box',
				'animated_box_inner'          => '.techt-animated-box__inner',
				'animated_box_front'          => '.techt-animated-box__front',
				'animated_box_back'           => '.techt-animated-box__back',
				'animated_box_icon'           => '.techt-animated-box__icon',
				'animated_box_icon_box'       => '.techt-animated-box__icon-box',
				'animated_box_title'          => '.techt-animated-box__title',
				'animated_box_subtitle'       => '.techt-animated-box__subtitle',
				'animated_box_description'    => '.techt-animated-box__description',
				'animated_box_button'         => '.techt-animated-box__button',
				'animated_box_button_icon'    => '.techt-animated-box__button-icon',
				'animated_box_icon_front'     => '.techt-animated-box__icon--front',
				'animated_box_icon_back'      => '.techt-animated-box__icon--back',
				'animated_box_title_front'    => '.techt-animated-box__title--front',
				'animated_box_title_back'     => '.techt-animated-box__title--back',
				'animated_box_subtitle_front' => '.techt-animated-box__subtitle--front',
				'animated_box_subtitle_back'  => '.techt-animated-box__subtitle--back',
				'animated_box_desc_front'     => '.techt-animated-box__description--front',
				'animated_box_desc_back'      => '.techt-animated-box__description--back',
				'animated_box_toggle'         => '.techt-animated-box__toggle',
				'animated_box_toggle_front'   => '.techt-animated-box__toggle--front',
				'animated_box_toggle_back'    => '.techt-animated-box__toggle--back',
				'animated_box_canvas'         => '.techt-animated-box canvas',
			)
		);

		$this->start_controls_section(
			'section_front_content',
			array(
				'label' => esc_html__( 'Front Side Content', 'petrona' ),
			)
		);

		$this->add_advanced_icon_control(
			'front_side_icon',
			array(
				'label'       => esc_html__( 'Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
			)
		);

		$this->add_control(
			'front_side_title',
			array(
				'label'   => esc_html__( 'Title', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'front_side_subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Animated Box', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'front_side_description',
			array(
				'label'   => esc_html__( 'Description', 'petrona' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Easily add or remove any text on your animated box!', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_advanced_icon_control(
			'front_side_toggle_icon',
			array(
				'label'       => esc_html__( 'Toggle Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-angle-right',
				'fa5_default' => array(
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'switch_event_type' => 'toggle',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_back_content',
			array(
				'label' => esc_html__( 'Back Side Content', 'petrona' ),
			)
		);

		$this->add_advanced_icon_control(
			'back_side_icon',
			array(
				'label'       => esc_html__( 'Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => '',
			)
		);

		$this->add_control(
			'back_side_title',
			array(
				'label'   => esc_html__( 'Title', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Back Side', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'back_side_subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'back_side_description',
			array(
				'label'   => esc_html__( 'Description', 'petrona' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Easily add or remove any text on your animated box!', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'back_side_button_text',
			array(
				'label'   => esc_html__( 'Button text', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'petrona' ),
			)
		);

		$this->add_control(
			'back_side_button_link',
			array(
				'label'       => esc_html__( 'Button Link', 'petrona' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => array(
					'url' => '#',
				),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_advanced_icon_control(
			'back_side_toggle_icon',
			array(
				'label'       => esc_html__( 'Toggle Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-times',
				'fa5_default' => array(
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'switch_event_type' => 'toggle',
				),
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
			'box_height',
			array(
				'label'      => esc_html__( 'Height', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'rem', 'vh' ),
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
					'rem' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'default' => array(
					'size' => 250,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'switch_event_type',
			array(
				'label'   => esc_html__( 'Switch Type', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'hover',
				'options' => array(
					'hover'        => esc_html__( 'Hover', 'petrona' ),
					'click'        => esc_html__( 'Click', 'petrona' ),
					'toggle'       => esc_html__( 'Toggle Button', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'scratch_fill_percent',
			array(
				'label'      => esc_html__( 'Fill percent for reveal full image', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range' => array(
					'%' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 75,
					'unit' => '%',
				),
				'condition' => array(
					'switch_event_type' => 'scratch',
				),
			)
		);

		$this->add_control(
			'animation_effect',
			array(
				'label'   => esc_html__( 'Animation Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'techt-box-effect-1',
				'groups'  => array(
					'simple' => array(
						'label'   => esc_html__( 'Simple', 'petrona' ),
						'options' => array(
							'techt-box-effect-9'  => esc_html__( 'Fade', 'petrona' ),
							'techt-box-effect-18' => esc_html__( 'Blur', 'petrona' ),
						),
					),
					'zoom'     => array(
						'label'   => esc_html__( 'Zoom', 'petrona' ),
						'options' => array(
							'techt-box-effect-10' => esc_html__( 'Zoom In', 'petrona' ),
							'techt-box-effect-11' => esc_html__( 'Zoom Out', 'petrona' ),
						),
					),
					'pull'     => array(
						'label'   => esc_html__( 'Pull', 'petrona' ),
						'options' => array(
							'techt-box-effect-14' => esc_html__( 'Pull Left', 'petrona' ),
							'techt-box-effect-15' => esc_html__( 'Pull Up', 'petrona' ),
							'techt-box-effect-6'  => esc_html__( 'Pull Right', 'petrona' ),
							'techt-box-effect-5'  => esc_html__( 'Pull Down', 'petrona' ),
						),
					),
					'slide'     => array(
						'label'   => esc_html__( 'Slide', 'petrona' ),
						'options' => array(
							'techt-box-effect-16' => esc_html__( 'Slide Left', 'petrona' ),
							'techt-box-effect-13' => esc_html__( 'Slide Top', 'petrona' ),
							'techt-box-effect-12' => esc_html__( 'Slide Right', 'petrona' ),
							'techt-box-effect-17' => esc_html__( 'Slide Bottom', 'petrona' ),
						),
					),
					'3d'     => array(
						'label'   => esc_html__( '3d', 'petrona' ),
						'options' => array(
							'techt-box-effect-1'  => esc_html__( 'Flip Horizontal', 'petrona' ),
							'techt-box-effect-2'  => esc_html__( 'Flip Vertical', 'petrona' ),
							'techt-box-effect-3'  => esc_html__( 'Fall Up', 'petrona' ),
							'techt-box-effect-4'  => esc_html__( 'Fall Right', 'petrona' ),
							'techt-box-effect-7'  => esc_html__( 'Flip Horizontal 3D', 'petrona' ),
							'techt-box-effect-8'  => esc_html__( 'Flip Vertical 3D', 'petrona' ),
						),
					),
				),
				'condition' => array(
					'switch_event_type' => array( 'hover', 'click', 'toggle' ),
				),
			)
		);

		$this->add_control(
			'paper_fold_direction',
			array(
				'label'   => esc_html__( 'Paper Fold Direction', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'   => esc_html__( 'Left', 'petrona' ),
					'top'    => esc_html__( 'Top', 'petrona' ),
					'right'  => esc_html__( 'Right', 'petrona' ),
					'bottom' => esc_html__( 'Bottom', 'petrona' ),
				),
				'condition' => array(
					'switch_event_type' => 'fold',
				),
			)
		);

		$this->add_control(
			'slide_out_direction',
			array(
				'label'   => esc_html__( 'Slide Out Direction', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'   => esc_html__( 'Left', 'petrona' ),
					'top'    => esc_html__( 'Top', 'petrona' ),
					'right'  => esc_html__( 'Right', 'petrona' ),
					'bottom' => esc_html__( 'Bottom', 'petrona' ),
				),
				'condition' => array(
					'switch_event_type' => 'slide-out',
				),
			)
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_available_title_html_tags(),
				'default' => 'h3',
			)
		);

		$this->add_control(
			'sub_title_html_tag',
			array(
				'label'   => esc_html__( 'Subtitle HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_available_title_html_tags(),
				'default' => 'h4',
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_animated_box_general_style',
			array(
				'label'      => esc_html__( 'General', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'general_style_tabs' );

		$this->start_controls_tab(
			'tab_front_general_styles',
			array(
				'label' => esc_html__( 'Front', 'petrona' ),
			)
		);

		$this->add_control(
			'front_vertical_alignment',
			array(
				'label'   => esc_html__( 'Content Alignment', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'petrona' ),
					'center'        => esc_html__( 'Center', 'petrona' ),
					'flex-end'      => esc_html__( 'Bottom', 'petrona' ),
					'space-between' => esc_html__( 'Space Between', 'petrona' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['animated_box_front'] . ' .techt-animated-box__inner' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'front_side_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_front'],
				'fields_options' => array(
					'color' => array(
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
						'opacity' => 0.4,
					),
				),
			)
		);

		$this->add_responsive_control(
			'front_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_front'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'front_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['animated_box_front'],
			)
		);

		$this->add_responsive_control(
			'front_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_front'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['animated_box_front'] . ' .techt-animated-box__overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['animated_box_canvas'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['animated_box'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'front_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_front'],
			)
		);

		$this->add_control(
			'front_overlay_styles_heading',
			array(
				'label'     => esc_html__( 'Overlay', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'front_overlay_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_front'] . ' .techt-animated-box__overlay',
			)
		);
		$this->add_responsive_control(
			'front_overlay_opacity',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Opacity', 'petrona' ),
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['animated_box_front'] . ' .techt-animated-box__overlay' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->add_control(
			'front_order_heading',
			array(
				'label'     => esc_html__( 'Order', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$this->add_control(
			'front_side_icon_order',
			array(
				'label'   => esc_html__( 'Icon Order', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['animated_box_icon_front'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'front_side_content_order',
			array(
				'label'   => esc_html__( 'Content Order', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['animated_box_front'] . ' .techt-animated-box__content' => 'order: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_back_general_styles',
			array(
				'label' => esc_html__( 'Back', 'petrona' ),
			)
		);

		$this->add_control(
			'back_vertical_alignment',
			array(
				'label'   => esc_html__( 'Content Alignment', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'petrona' ),
					'center'        => esc_html__( 'Center', 'petrona' ),
					'flex-end'      => esc_html__( 'Bottom', 'petrona' ),
					'space-between' => esc_html__( 'Space Between', 'petrona' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['animated_box_back'] . ' .techt-animated-box__inner' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'back_side_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_back'],
				'fields_options' => array(
					'color' => array(
						'global' => [
							'default' => Global_Colors::COLOR_SECONDARY,
						],
					),
				),
			)
		);

		$this->add_responsive_control(
			'back_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_back'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'back_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['animated_box_back'],
			)
		);

		$this->add_responsive_control(
			'back_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_back'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['animated_box_back'] . ' .techt-animated-box__overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'    => 'back_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_back'],
			)
		);

		$this->add_control(
			'back_overlay_styles_heading',
			array(
				'label'     => esc_html__( 'Overlay', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'back_overlay_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_back'] . ' .techt-animated-box__overlay',
			)
		);

		$this->add_responsive_control(
			'back_overlay_opacity',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Opacity', 'petrona' ),
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['animated_box_back'] . ' .techt-animated-box__overlay' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'back_order_heading',
			array(
				'label'     => esc_html__( 'Order', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$this->add_control(
			'back_side_icon_order',
			array(
				'label'   => esc_html__( 'Icon Order', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['animated_box_icon_back'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'back_side_content_order',
			array(
				'label'   => esc_html__( 'Content Order', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 2,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['animated_box_back'] . ' .techt-animated-box__content' => 'order: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_button_heading',
			array(
				'label'     => esc_html__( 'Toggle Button', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			)
		);

		$this->start_controls_tabs( 'toggle_style_tabs' );

		$this->start_controls_tab(
			'tab_toggle_icon_styles',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'     => 'toggle_button_style',
				'label'    => esc_html__( 'Toggle Styles', 'petrona' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_toggle'],
				'exclude' => array(
					'box_size_width',
					'box_size_height',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_icon_hover_styles',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'name'     => 'toggle_button_hover_style',
				'label'    => esc_html__( 'Toggle Styles', 'petrona' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_toggle'] . ':hover',
				'exclude' => array(
					'box_size_width',
					'box_size_height',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Icon Style Section
		 */
		$this->start_controls_section(
			'section_animated_box_icon_style',
			array(
				'label'      => esc_html__( 'Icon', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'icon_style_tabs' );

		$this->start_controls_tab(
			'tab_front_icon_styles',
			array(
				'label' => esc_html__( 'Front', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'front_icon_box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'front_icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' i:before' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'front_icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' .techt-animated-box-icon-inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'front_icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' .techt-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'front_icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' .techt-animated-box-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_icon_box_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front']. ' .techt-animated-box-icon-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'front_icon_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' .techt-animated-box-icon-inner',
			)
		);

		$this->add_control(
			'front_icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' .techt-animated-box-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'front_icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_icon_front'] . ' .techt-animated-box-icon-inner',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_back_icon_styles',
			array(
				'label' => esc_html__( 'Back', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'back_icon_box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'back_icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' i:before' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'back_icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-animated-box-icon-inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'back_icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'back_icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-animated-box-icon-inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_icon_box_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-animated-box-icon-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'back_icon_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-animated-box-icon-inner',
			)
		);

		$this->add_control(
			'back_icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-animated-box-icon-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'back_icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_icon_back'] . ' .techt-animated-box-icon-inner',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'section_animated_box_title_style',
			array(
				'label'      => esc_html__( 'Title', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'title_style_tabs' );

		$this->start_controls_tab(
			'tab_front_title_styles',
			array(
				'label' => esc_html__( 'Front', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'front_title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_front'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_title_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_front'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'front_title_color',
			array(
				'label'  => esc_html__( 'Title Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_front'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'front_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_title_front'],
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'front_title_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_title_front'],
			)
		);

		$this->add_responsive_control(
			'front_title_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_front'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_title_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_front'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_back_title_styles',
			array(
				'label' => esc_html__( 'Back', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'back_title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_back'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_title_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_back'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'back_title_color',
			array(
				'label'  => esc_html__( 'Title Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_back'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'back_title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_title_back'],
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'back_title_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_title_back'],
			)
		);

		$this->add_responsive_control(
			'back_title_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_back'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_title_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_title_back'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Subtitle Style Section
		 */
		$this->start_controls_section(
			'section_animated_box_subtitle_style',
			array(
				'label'      => esc_html__( 'Subtitle', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'subtitle_style_tabs' );

		$this->start_controls_tab(
			'tab_front_subtitle_styles',
			array(
				'label' => esc_html__( 'Front', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'front_subtitle_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_subtitle_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'front_subtitle_color',
			array(
				'label'  => esc_html__( 'Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'front_subtitle_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'],
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'front_subtitle_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'],
			)
		);

		$this->add_responsive_control(
			'front_subtitle_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_subtitle_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_front'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_back_subtitle_styles',
			array(
				'label' => esc_html__( 'Back', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'back_subtitle_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_subtitle_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'back_subtitle_color',
			array(
				'label'  => esc_html__( 'Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'back_subtitle_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'],
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'back_subtitle_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'],
			)
		);

		$this->add_responsive_control(
			'back_subtitle_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_subtitle_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_subtitle_back'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Description Style Section
		 */
		$this->start_controls_section(
			'section_animated_box_description_style',
			array(
				'label'      => esc_html__( 'Description', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'description_style_tabs' );

		$this->start_controls_tab(
			'tab_front_description_styles',
			array(
				'label' => esc_html__( 'Front', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'front_description_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_front'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'front_description_color',
			array(
				'label'  => esc_html__( 'Description Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_front'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'front_description_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_desc_front'],
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'front_description_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_desc_front'],
			)
		);

		$this->add_responsive_control(
			'front_description_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_front'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'front_description_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_front'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_back_description_styles',
			array(
				'label' => esc_html__( 'Back', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'back_description_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_back'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'back_description_color',
			array(
				'label'  => esc_html__( 'Description Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_back'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'back_description_typography',
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_desc_back'],
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'back_description_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_desc_back'],
			)
		);


		$this->add_responsive_control(
			'back_description_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_back'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'back_description_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_desc_back'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Action Button Style Section
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
			'back_button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'add_button_icon',
			array(
				'label'        => esc_html__( 'Add Icon', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_advanced_icon_control(
			'button_icon',
			array(
				'label'       => esc_html__( 'Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'condition'   => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'before'  => esc_html__( 'Before Text', 'petrona' ),
					'after' => esc_html__( 'After Text', 'petrona' ),
				),
				'default'     => 'after',
				'render_type' => 'template',
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_size',
			array(
				'label' => esc_html__( 'Icon Size', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 7,
						'max' => 90,
					),
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['animated_box_button'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['animated_box_button'],
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['animated_box_button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['animated_box_button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['animated_box_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['animated_box_button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {

		$this->_context = 'render';

		$this->_open_wrap();
		include $this->get_widget_template( 'index' );
		$this->_close_wrap();
	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$settings = $this->get_settings();

		$instance_settings = array(
			'widgetId'           => $this->get_id(),
			'switchEventType'    => $settings['switch_event_type'],
			'paperFoldDirection' => isset( $settings['paper_fold_direction'] ) ? $settings['paper_fold_direction'] : 'left',
			'slideOutDirection'  => isset( $settings['slide_out_direction'] ) ? $settings['slide_out_direction'] : 'left',
		);

		if ( 'scratch' === $settings['switch_event_type'] ) {
			$instance_settings['scratchFillPercent'] = ! empty( $settings['scratch_fill_percent']['size'] ) ? $settings['scratch_fill_percent']['size'] : 75;
		}

		$instance_settings = json_encode( $instance_settings );

		return sprintf( 'data-settings=\'%1$s\'', $instance_settings );
	}

}
Plugin::instance()->widgets_manager->register( new Techt_Animated_Box() );