<?php

namespace Elementor;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Advance Heading Widget.
 *
 *
 * @since 1.0
 */
class Techt_Headings_Widget extends Widget_Base
{

	public function get_name()
	{
		return 'petrona-advance-headings';
	}

	public function get_title()
	{
		return esc_html__('Advance Headings', 'petrona');
	}

	public function get_icon()
	{
		return 'eicon-heading';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

	/**
	 * Register Edu_Exp widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls()
	{

		$this->start_controls_section(
			'social_info_section',
			[
				'label' => esc_html__('Headings', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'main_heading',
			[
				'label'       => esc_html__('Main Heading', 'petrona'),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => ['active' => true],
				'placeholder' => esc_html__('Enter your main heading here', 'petrona'),
				'default'     => esc_html__('I am Advance Heading', 'petrona'),
			]
		);

		$this->add_control(
			'header_size',
			[
				'label'   => esc_html__('HTML Tag', 'petrona'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => esc_html__('H1', 'petrona'),
					'h2'   => esc_html__('H2', 'petrona'),
					'h3'   => esc_html__('H3', 'petrona'),
					'h4'   => esc_html__('H4', 'petrona'),
					'h5'   => esc_html__('H5', 'petrona'),
					'h6'   => esc_html__('H6', 'petrona'),
					'div'  => esc_html__('div', 'petrona'),
					'span' => esc_html__('span', 'petrona'),
					'p'    => esc_html__('p', 'petrona'),
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__('Link', 'petrona'),
				'type'        => Controls_Manager::URL,
				'dynamic'     => ['active' => true],
				'placeholder' => 'http://your-link.com',
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'       => esc_html__('Sub Heading', 'petrona'),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => ['active' => true],
				'placeholder' => esc_html__('Enter your prefix title', 'petrona'),
				'default'     => esc_html__('SUB HEADING HERE', 'petrona'),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__('Alignment', 'petrona'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'right' => [
						'title' => __( 'Start', 'petrona' ),
						'icon' => 'eicon-h-align-'. ( is_rtl() ? 'right' : 'left' ),
					],
					'center' => [
						'title' => __( 'Center', 'petrona' ),
						'icon' => 'eicon-h-align-center',
					],
					'left' => [
						'title' => __( 'End', 'petrona' ),
						'icon' => 'eicon-h-align-' . ( is_rtl() ? 'left' : 'right' ),
					],
				],
				'default' => 'center',
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_advance_heading',
			[
				'label' => esc_html__('Advance Heading', 'petrona'),
			]
		);
		$this->add_control(
			'advance_heading',
			[
				'label'       => esc_html__('Advance Heading', 'petrona'),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => ['active' => true],
				'placeholder' => esc_html__('Enter your advance heading', 'petrona'),
				'description' => esc_html__('This heading will show as style as background and you can move and style many way.', 'petrona'),
				'default'     => esc_html__("Advance Heading", 'petrona'),
			]
		);

		$this->add_responsive_control(
			'advance_heading_align',
			[
				'label'   => esc_html__('Alignment', 'petrona'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'petrona'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'petrona'),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'petrona'),
						'icon'  => 'fa fa-align-right',
					],
				],
			]
		);


		$this->add_responsive_control(
			'advance_heading_x_position',
			[
				'label'   => esc_html__('X Offset', 'petrona'),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
				],
			]
		);

		$this->add_responsive_control(
			'advance_heading_y_position',
			[
				'label'   => esc_html__('Y Offset', 'petrona'),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 10,
				],
				'mobile_default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => -800,
						'max' => 800,
					],
				],
			]
		);

		$this->add_responsive_control(
			'advance_heading_rotate',
			[
				'label'   => esc_html__('Rotate', 'petrona'),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'tablet_default' => [
					'size' => 0,
				],
				'mobile_default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => -180,
						'max'  => 180,
						'step' => 5,
					],
				],
				'selectors' => [
					'(desktop){{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'transform: translate({{advance_heading_x_position.SIZE}}px, {{advance_heading_y_position.SIZE}}px) rotate({{SIZE}}deg);',
					'(tablet){{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'transform: translate({{advance_heading_x_position_tablet.SIZE}}px, {{advance_heading_y_position_tablet.SIZE}}px) rotate({{SIZE}}deg);',
					'(mobile){{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'transform: translate({{advance_heading_x_position_mobile.SIZE}}px, {{advance_heading_y_position_mobile.SIZE}}px) rotate({{SIZE}}deg);',
				],
			]
		);

		$this->add_control(
			'advance_heading_origin',
			[
				'label'       => esc_html__('Rotate Origin', 'petrona'),
				'description' => esc_html__('Origin work when you set rotate value', 'petrona'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'center',
				'options'     => [
					''         => esc_html__('Default', 'petrona'),
					'top-left'      => esc_html__('Top Left', 'petrona'),
					'top-center'    => esc_html__('Top Center', 'petrona'),
					'top-right'     => esc_html__('Top Right', 'petrona'),
					'center'        => esc_html__('Center', 'petrona'),
					'center-left'   => esc_html__('Center Left', 'petrona'),
					'center-right'  => esc_html__('Center Right', 'petrona'),
					'bottom-left'   => esc_html__('Bottom Left', 'petrona'),
					'bottom-center' => esc_html__('Bottom Center', 'petrona'),
					'bottom-right'  => esc_html__('Bottom Right', 'petrona'),
				],
			]
		);


		$this->add_control(
			'advance_heading_hide',
			[
				'label'       => esc_html__('Hide at', 'petrona'),
				'description' => esc_html__('Some cases you need to hide it because when you set heading at outer position mobile device can show wrong width in that case you can hide it at mobile or tablet device. if you set overflow hidden on section or body so you don\'t need it.', 'petrona'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => [
					''  => esc_html__('Nothing', 'petrona'),
					'd-none d-lg-block' => esc_html__('Tablet and Mobile ', 'petrona'),
					'd-sm-none d-md-block' => esc_html__('Mobile', 'petrona'),
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main_heading',
			[
				'label'     => esc_html__('Main Heading', 'petrona'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'main_heading!' => '',
				],
			]
		);

		$this->add_control(
			'main_heading_advance_color',
			[
				'label'        => esc_html__('Advance Style', 'petrona'),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'techt-ep-main-color-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'main_heading_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading' => 'color: {{VALUE}};',
				],
				'condition' => [
					'main_heading_advance_color!' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'main_heading_advance_color',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .techt-advance-heading .techt-main-heading',
				'condition' => [
					'main_heading_advance_color' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'main_heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .techt-advance-heading .techt-main-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'main_heading_shadow',
				'selector' => '{{WRAPPER}} .techt-advance-heading .techt-main-heading',
			]
		);

		$this->add_control(
			'main_heading_style',
			[
				'label'   => esc_html__('Style', 'petrona'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__('None', 'petrona'),
					'line' => esc_html__('Line', 'petrona'),
					'arrow' => esc_html__('Arrow', 'petrona'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'main_heading_style_color',
			[
				'label'     => esc_html__('Style Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fe651f',
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .line:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .arrow:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .arrow:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_width',
			[
				'label' => __('Width', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-main-heading .line:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-main-heading .arrow.techt-button-icon-align-right:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-main-heading .arrow.techt-button-icon-align-left:before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-main-heading .arrow.techt-button-icon-align-bottom:before' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_height',
			[
				'label' => __('Height', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .line:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'main_heading_style' => 'line',
				],
			]
		);

		$this->add_control(
			'main_heading_style_align',
			[
				'label'   => esc_html__('Style Position', 'petrona'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'right'      => esc_html__('After', 'petrona'),
					'left'       => esc_html__('Before', 'petrona'),
					'left-right' => esc_html__('After and Before', 'petrona'),
					'bottom'     => esc_html__('Bottom', 'petrona'),
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
			]
		);

		$this->add_responsive_control(
			'main_heading_style_indent',
			[
				'label'   => esc_html__('Style Spacing', 'petrona'),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 6,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .techt-button-icon-align-right'  => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .techt-button-icon-align-left'   => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-advance-heading .techt-main-heading .techt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_heading',
			[
				'label'     => esc_html__('Sub Heading', 'petrona'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'sub_heading!' => '',
				]
			]
		);

		$this->add_responsive_control(
			'sub_heading_vertical_position',
			[
				'label' => __('Top Space', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-sub-heading' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'sub_heading_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-sub-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .techt-advance-heading .techt-sub-heading',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'sub_heading_shadow',
				'selector' => '{{WRAPPER}} .techt-advance-heading .techt-sub-heading',
			]
		);

		$this->add_control(
			'sub_heading_style',
			[
				'label'   => esc_html__('Style', 'petrona'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => esc_html__('None', 'petrona'),
					'line' => esc_html__('Line', 'petrona'),
					'arrow' => esc_html__('Arrow', 'petrona'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sub_heading_style_color',
			[
				'label'     => esc_html__('Style Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-sub-heading .line:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .techt-advance-heading .techt-sub-heading .arrow:before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .techt-advance-heading .techt-sub-heading .arrow:after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_width',
			[
				'label' => __('Width', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-sub-heading .line:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-sub-heading .arrow.techt-button-icon-align-right:after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-sub-heading .arrow.techt-button-icon-align-left:before' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-sub-heading .arrow.techt-button-icon-align-bottom:before' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_height',
			[
				'label' => __('Height', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-sub-heading .line:after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'sub_heading_style' => 'line',
				],
			]
		);

		$this->add_control(
			'sub_heading_style_align',
			[
				'label'   => esc_html__('Style Position', 'petrona'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => [
					'right'      => esc_html__('After', 'petrona'),
					'left'       => esc_html__('Before', 'petrona'),
					'left-right' => esc_html__('After and Before', 'petrona'),
					'bottom'     => esc_html__('Bottom', 'petrona'),
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
			]
		);

		$this->add_responsive_control(
			'sub_heading_style_indent',
			[
				'label'   => esc_html__('Style Spacing', 'petrona'),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 8,
				],
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'main_heading_style' => ['line', 'arrow']
				],
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-button-icon-align-right'  => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-advance-heading .techt-button-icon-align-left'   => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-advance-heading .techt-button-icon-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		
		$this->start_controls_section(
			'section_style_advance_heading',
			[
				'label'     => esc_html__('Advance Heading', 'petrona'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'advance_heading!' => '',
				],
			]
		);

		$this->add_control(
			'advance_heading_advance_color',
			[
				'label'        => esc_html__('Advance Style', 'petrona'),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'techt-ep-advance-color-',
				'render_type'  => 'template',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'advance_heading_advance_color',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div',
				'condition' => [
					'advance_heading_advance_color' => 'yes',
				],
			]
		);

		$this->add_control(
			'advance_heading_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'color: {{VALUE}};',
				],
				'condition' => [
					'advance_heading_advance_color!' => 'yes',
				],
			]
		);

		$this->add_control(
			'advance_heading_background_color',
			[
				'label'     => esc_html__('Background Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'advance_heading_advance_color!' => 'yes',
				],
			]
		);

		$this->add_control(
			'advance_heading_padding',
			[
				'label'      => esc_html__('Padding', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'advance_heading_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'advance_heading_shadow',
				'selector' => '{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div',
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'advance_heading_border',
				'label'       => esc_html__('Border', 'petrona'),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'advance_heading_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'advance_heading_box_shadow',
				'selector' => '{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div',
			]
		);

		$this->add_control(
			'advance_heading_opacity',
			[
				'label' => esc_html__('Opacity', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 0.05,
						'max'  => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-advance-heading .techt-advance-heading-content > div' => 'opacity: {{SIZE}};',
				],
			]
		);


		$this->end_controls_section();
	}


	/**
	 * Render Edu_Exp widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render()
	{
		$settings         = $this->get_settings_for_display();
		$id               = $this->get_id();
		$heading_html     = [];
		$advance_heading = '';
		$sub_heading      = '';
		$main_heading     = '';

		if (empty($settings['sub_heading']) and empty($settings['advance_heading']) and empty($settings['main_heading'])) {
			return;
		}

		$this->add_render_attribute('heading', 'class', 'techt-heading-tag');


		if ($settings['sub_heading']) {
			$subh_style = '';
			if ('line' === $settings['sub_heading_style']) {
				if ('left-right' === $settings['sub_heading_style_align']) {
					$subh_style = '<div class="line techt-button-icon-align-left"></div><div class="line techt-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['sub_heading_style_align']) {
					$subh_style = '<div class="line techt-button-icon-align-' . $settings['sub_heading_style_align'] . '"></div>';
				} else {
					$subh_style = '<div class="line techt-button-icon-align-' . $settings['sub_heading_style_align'] . '"></div>';
				}
			}

			$sub_heading = '<div class="techt-sub-heading"><div class="techt-sub-heading-content">' . $settings['sub_heading'] . '</div>' . $subh_style . '</div> ';
		}

		if ($settings['advance_heading']) {
			$avd_hclass   = ['techt-advance-heading-content'];
			$avd_hclass[] = ($settings['advance_heading_align']) ? 'techt-text-' . $settings['advance_heading_align'] : '';
			$avd_hclass[] = ($settings['advance_heading_hide']) ? 'techt-visible ' . $settings['advance_heading_hide'] : '';
			$avd_hcclass  = ($settings['advance_heading_origin']) ? 'techt-transform-origin-' . $settings['advance_heading_origin'] : '';


			$advance_heading = '<div class="' . implode(" ", $avd_hclass) . '"><div class="' . $avd_hcclass . '">' . $settings['advance_heading'] . '</div></div>';
		}

		if ($settings['main_heading']) :

			$mainh_style = '';
			if ('line' === $settings['main_heading_style']) {
				if ('left-right' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="line techt-button-icon-align-left"></div><div class="line techt-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="line techt-button-icon-align-' . $settings['main_heading_style_align'] . '"></div>';
				} else {
					$mainh_style = '<div class="line techt-button-icon-align-' . $settings['main_heading_style_align'] . '"></div>';
				}
			}
			if ('arrow' === $settings['main_heading_style']) {
				if ('left-right' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="arrow techt-button-icon-align-left"></div><div class="arrow techt-button-icon-align-right"></div>';
				} elseif ('bottom' === $settings['main_heading_style_align']) {
					$mainh_style = '<div class="arrow techt-button-icon-align-' . $settings['main_heading_style_align'] . '"></div>';
				} else {
					$mainh_style = '<div class="arrow techt-button-icon-align-' . $settings['main_heading_style_align'] . '"></div>';
				}
			}
			$main_heading = '<div class="techt-main-heading">' . $settings['main_heading'] . $mainh_style . '</div>';
			// $main_heading = '<div class="techt-main-heading">' . $settings['main_heading'] . $mainh_style . '</div>';
			// $main_heading = sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('heading'), $main_heading);
		endif;


		if (!empty($settings['link']['url'])) {
			$this->add_render_attribute('url', 'href', $settings['link']['url']);

			if ($settings['link']['is_external']) {
				$this->add_render_attribute('url', 'target', '_blank');
			}

			if (!empty($settings['link']['nofollow'])) {
				$this->add_render_attribute('url', 'rel', 'nofollow');
			}

			$main_heading = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $main_heading);
		}

		$heading_html[] = '<div id ="' . $id . '" class="techt-advance-heading">';


		$heading_html[] = $advance_heading;
		$heading_html[] = sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('heading'), $main_heading);
		$heading_html[] = $sub_heading;
		$heading_html[] = '</div>';

		echo implode("", $heading_html);
	}

	/**
	 * Render Social Info widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template()
	{
?>
		<!-- <# var main_heading=settings.main_heading; var subh_style='' ; var mainh_style='' ; if ( '' !==settings.link.url ) { main_heading='<a href="' + settings.link.url + '">' + main_heading + '</a>' ; } view.addRenderAttribute( 'main_heading' , 'class' , [ 'techt-heading-tag' , 'elementor-size-' + settings.size ] ); view.addInlineEditingAttributes( 'main_heading' ); view.addRenderAttribute('advance_heading_content', 'class' , ['techt-advance-heading-content'] ); view.addRenderAttribute('advance_heading', 'class' , 'techt-transform-origin-' + settings.advance_heading_origin ); if ('' !==settings.advance_heading_align) { view.addRenderAttribute('advance_heading_content', 'class' , 'techt-text-' + settings.advance_heading_align ); } view.addInlineEditingAttributes( 'advance_heading' ); var avdh_content_print=view.getRenderAttributeString( 'advance_heading_content' ); var avdh_transform_print=view.getRenderAttributeString( 'advance_heading' ); if ( 'line'===settings.sub_heading_style ) { if ('left-right'===settings.sub_heading_style_align) { subh_style='<div class="line techt-button-icon-align-left"></div><div class="line techt-button-icon-align-right"></div>' ; } else if ('bottom'===settings.sub_heading_style_align) { subh_style='<div class="line techt-button-icon-align-' + settings.sub_heading_style_align + '"></div>' ; } else { subh_style='<div class="line techt-button-icon-align-' + settings.sub_heading_style_align + '"></div>' ; } } if ( 'line'===settings.main_heading_style ) { if ('left-right'===settings.main_heading_style_align) { mainh_style='<div class="line techt-button-icon-align-left"></div><div class="line techt-button-icon-align-right"></div>' ; } else if ('bottom'===settings.main_heading_style_align) { mainh_style='<div class="line techt-button-icon-align-' + settings.main_heading_style_align + '"></div>' ; } else { mainh_style='<div class="line techt-button-icon-align-' + settings.main_heading_style_align + '"></div>' ; } } #> -->
		<# var main_heading=settings.main_heading; var subh_style='' ; var mainh_style='' ; if ( '' !==settings.link.url ) { main_heading='<a href="' + settings.link.url + '">' + main_heading + '</a>' ; } view.addRenderAttribute( 'main_heading' , 'class' , [ 'techt-heading-tag' , 'elementor-size-' + settings.size ] ); view.addInlineEditingAttributes( 'main_heading' ); view.addRenderAttribute('advance_heading_content', 'class' , ['techt-advance-heading-content'] ); view.addRenderAttribute('advance_heading', 'class' , 'techt-transform-origin-' + settings.advance_heading_origin ); if ('' !==settings.advance_heading_align) { view.addRenderAttribute('advance_heading_content', 'class' , 'techt-text-' + settings.advance_heading_align ); } view.addInlineEditingAttributes( 'advance_heading' ); var avdh_content_print=view.getRenderAttributeString( 'advance_heading_content' ); var avdh_transform_print=view.getRenderAttributeString( 'advance_heading' ); if ( 'line'===settings.sub_heading_style ) { if ('left-right'===settings.sub_heading_style_align) { subh_style='<div class="line techt-button-icon-align-left"></div><div class="line techt-button-icon-align-right"></div>' ; } else if ('bottom'===settings.sub_heading_style_align) { subh_style='<div class="line techt-button-icon-align-' + settings.sub_heading_style_align + '"></div>' ; } else { subh_style='<div class="line techt-button-icon-align-' + settings.sub_heading_style_align + '"></div>' ; } } if ( 'line'===settings.main_heading_style ) { if ('left-right'===settings.main_heading_style_align) { mainh_style='<div class="line techt-button-icon-align-left"></div><div class="line techt-button-icon-align-right"></div>' ; } else if ('bottom'===settings.main_heading_style_align) { mainh_style='<div class="line techt-button-icon-align-' + settings.main_heading_style_align + '"></div>' ; } else { mainh_style='<div class="line techt-button-icon-align-' + settings.main_heading_style_align + '"></div>' ; } } 
		if ( 'arrow'===settings.sub_heading_style ) {
				if ('left-right'===settings.sub_heading_style_align) {
					subh_style='<div class="arrow techt-button-icon-align-left"></div><div class="arrow techt-button-icon-align-right"></div>' ;
				} else if ('bottom'===settings.sub_heading_style_align) {
					subh_style='<div class="arrow techt-button-icon-align-' + settings.sub_heading_style_align + '"></div>' ; 
				} else { 
					subh_style='<div class="arrow techt-button-icon-align-' + settings.sub_heading_style_align + '"></div>' ; 
				} 
			} 
			if ( 'arrow'===settings.main_heading_style ) {
				if ('left-right'===settings.main_heading_style_align) {
					mainh_style='<div class="arrow techt-button-icon-align-left"></div><div class="arrow techt-button-icon-align-right"></div>' ; 
				}else if ('bottom'===settings.main_heading_style_align) { 
					mainh_style='<div class="arrow techt-button-icon-align-' + settings.main_heading_style_align + '"></div>' ; 
				} else {
					mainh_style='<div class="arrow techt-button-icon-align-' + settings.main_heading_style_align + '"></div>' ;
				}
			} #>
			<div class="techt-advance-heading">
				<div <# print(avdh_content_print) #> >
					<div <# print(avdh_transform_print) #>>
						<# print(settings.advance_heading) #>
					</div>
				</div>

				<{{settings.header_size}} <# print(view.getRenderAttributeString( 'main_heading' )) #> >
					<div class="techt-main-heading"> {{main_heading}}
						<# print(mainh_style); #>
					</div>
				</{{settings.header_size}}>
				
				<div class="techt-sub-heading">
					<div class="techt-sub-heading-content">
						<# print(settings.sub_heading); #>
					</div>
					<# print(subh_style); #>
				</div>
			</div>
	<?php
	}
}

Plugin::instance()->widgets_manager->register(new Techt_Headings_Widget());
