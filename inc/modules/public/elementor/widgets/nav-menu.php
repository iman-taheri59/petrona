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

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Nav_Menu extends Techt_Base {

	public $__new_icon_prefix  = 'selected_';
	public $__context = 'render';
	public $__processed_item   = false;

	public function get_name() {
		return 'techt-nav-menu';
	}

	public function get_title() {
		return esc_html__( 'Nav Menu', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-nav-menu';
	}

	public function get_script_depends() {
		return array( 'hoverIntent' );
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_menu',
			array(
				'label' => esc_html__( 'Menu', 'petrona' ),
			)
		);

		$menus   = $this->get_available_menus();
		$default = '';

		if ( ! empty( $menus ) ) {
			$ids     = array_keys( $menus );
			$default = $ids[0];
		}

		$this->add_control(
			'nav_menu',
			array(
				'label'   => esc_html__( 'Select Menu', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => $default,
				'options' => $menus,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'horizontal' => esc_html__( 'Horizontal', 'petrona' ),
					'vertical'   => esc_html__( 'Vertical', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'dropdown_position',
			array(
				'label'   => esc_html__( 'Dropdown Placement', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right-side',
				'options' => array(
					'left-side'  => esc_html__( 'Left Side', 'petrona' ),
					'right-side' => esc_html__( 'Right Side', 'petrona' ),
					'bottom'     => esc_html__( 'At the bottom', 'petrona' ),
				),
				'condition' => array(
					'layout' => 'vertical',
				)
			)
		);

		$this->add_control(
			'dropdown_icon',
			array(
				'label'   => esc_html__( 'Dropdown Icon', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-down',
				'options' => $this->dropdown_arrow_icons_list(),
			)
		);

		$this->add_control(
			'show_items_desc',
			array(
				'label'   => esc_html__( 'Show Items Description', 'petrona' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'nav_items_indicator',
			array(
				'label'   => esc_html__('Show Items Indicator', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			)
		);

		$this->add_responsive_control(
			'menu_alignment',
			array(
				'label'   => esc_html__( 'Menu Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
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
					'space-between' => array(
						'title' => esc_html__( 'Justified', 'petrona' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'selectors_dictionary' => array(
					'flex-start'    => 'justify-content: flex-start; text-align: left;',
					'center'        => 'justify-content: center; text-align: center;',
					'flex-end'      => 'justify-content: flex-end; text-align: right;',
					'space-between' => 'justify-content: space-between; text-align: left;',
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav--horizontal' => '{{VALUE}}',
					'{{WRAPPER}} .techt-nav--vertical .menu-item-link-top' => '{{VALUE}}',
					'{{WRAPPER}} .techt-nav--vertical-sub-bottom .menu-item-link-sub' => '{{VALUE}}',

					'(mobile){{WRAPPER}} .techt-mobile-menu .menu-item-link' => '{{VALUE}}',
				),
				'prefix_class' => 'techt-nav%s-align-',
			)
		);

		$this->add_control(
			'menu_alignment_style',
			array(
				'type'       => Controls_Manager::HIDDEN,
				'default'    => 'style',
				'selectors'  => array(
					'body:not(.rtl) {{WRAPPER}} .techt-nav--horizontal .techt-nav__sub' => 'text-align: left;',
					'body.rtl {{WRAPPER}} .techt-nav--horizontal .techt-nav__sub' => 'text-align: right;',
				),
				'condition' => array(
					'layout' => 'horizontal',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_visible',
			array(
				'label'     => esc_html__( 'Enable Mobile Trigger', 'petrona' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'mobile_trigger_alignment',
			array(
				'label'   => esc_html__( 'Mobile Trigger Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Start', 'petrona' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'End', 'petrona' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'condition' => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->_add_advanced_icon_control(
			'mobile_trigger_icon',
			array(
				'label'       => esc_html__( 'Mobile Trigger Icon', 'petrona' ),
				'label_block' => true,
				'type'        => Controls_Manager::ICON,
				'default'     => 'fa fa-bars',
				'fa5_default' => array(
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->__add_advanced_icon_control(
			'mobile_trigger_close_icon',
			array(
				'label'       => esc_html__( 'Mobile Trigger Close Icon', 'petrona' ),
				'label_block' => true,
				'type'        => Controls_Manager::ICON,
				'default'     => 'fa fa-times',
				'fa5_default' => array(
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->add_control(
			'mobile_menu_layout',
			array(
				'label' => esc_html__( 'Mobile Menu Layout', 'petrona' ),
				'label_block' => true,
				'type'  => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'    => esc_html__( 'Default', 'petrona' ),
					'full-width' => esc_html__( 'Full Width', 'petrona' ),
					'left-side'  => esc_html__( 'Slide From The Left Side ', 'petrona' ),
					'right-side' => esc_html__( 'Slide From The Right Side ', 'petrona' ),
				),
				'condition' => array(
					'mobile_trigger_visible' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'nav_items_style',
			array(
				'label'      => esc_html__( 'Top Level Items', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'nav_vertical_menu_width',
			array(
				'label' => esc_html__( 'Vertical Menu Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav-wrap' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'layout' => 'vertical',
				),
			)
		);

		$this->add_responsive_control(
			'nav_vertical_menu_align',
			array(
				'label'       => esc_html__( 'Vertical Menu Alignment', 'petrona' ),
				'label_block' => true,
				'type'        => Controls_Manager::CHOOSE,
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
				'selectors_dictionary' => array(
					'left'   => 'margin-left: 0; margin-right: auto;',
					'center' => 'margin-left: auto; margin-right: auto;',
					'right'  => 'margin-left: auto; margin-right: 0;',
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav-wrap' => '{{VALUE}}',
				),
				'condition'  => array(
					'layout' => 'vertical',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_nav_items_style' );

		$this->start_controls_tab(
			'nav_items_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'nav_items_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_bg_color',
			array(
				'label'  => esc_html__( 'Text Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top .techt-nav-link-text' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'nav_items_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .menu-item-link-top',
			)
		);

		$this->add_responsive_control(
			'nav_items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'nav_items_text_icon_color',
			array(
				'label'  => esc_html__( 'Dropdown Icon Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top .techt-nav-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography',
				'selector' => '{{WRAPPER}} .menu-item-link-top .techt-nav-link-text',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'nav_items_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'nav_items_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_bg_color_hover',
			array(
				'label'  => esc_html__( 'Text Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top .techt-nav-link-text' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'nav_items_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .menu-item-link-top:hover',
			)
		);

		$this->add_responsive_control(
			'nav_items_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'nav_items_text_icon_color_hover',
			array(
				'label'  => esc_html__( 'Dropdown Icon Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-top .techt-nav-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography_hover',
				'selector' => '{{WRAPPER}} .menu-item:hover > .menu-item-link-top .techt-nav-link-text',
			)
		);

		$this->add_control(
			'nav_items_indicator_hover',
			array(
				'label'   => esc_html__('Show Indicator', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
			)
		);

		$this->add_control(
			'nav_items_indicator_color',
			[
				'label'     => esc_html__('Indicator Color', 'petrona'),
				'default' => '#fe651f',
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .menu-item-link-top:hover::after' => 'background-color: {{VALUE}};',

				],
				'condition' => [
					'nav_items_indicator_hover' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'nav_items_active',
			array(
				'label' => esc_html__( 'Active', 'petrona' ),
			)
		);

		$this->add_control(
			'nav_items_bg_color_active',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_color_active',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_text_bg_color_active',
			array(
				'label'  => esc_html__( 'Text Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .techt-nav-link-text' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'nav_items_active_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top',
			)
		);

		$this->add_responsive_control(
			'nav_items_active_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'nav_items_text_icon_color_active',
			array(
				'label'  => esc_html__( 'Dropdown Icon Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .techt-nav-arrow' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography_active',
				'selector' => '{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top .techt-nav-link-text',
			)
		);

		$this->add_control(
			'nav_items_indicator_active',
			array(
				'label'   => esc_html__('Show Indicator', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
			)
		);

		$this->add_control(
			'nav_items_indicator_color_active',
			[
				'label'     => esc_html__('Indicator Color', 'petrona'),
				'default' => '#fe651f',
				'type' => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top::after' => 'background-color: {{VALUE}}; ',
				],
				'condition' => [
					'nav_items_indicator_active' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'nav_items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'nav_items_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav > .techt-nav__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_items_icon_size',
			array(
				'label'      => esc_html__( 'Dropdown Icon Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'condition' => array(
					'dropdown_icon!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-top .techt-nav-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_items_icon_gap',
			array(
				'label'      => esc_html__( 'Gap Before Dropdown Icon', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'condition' => array(
					'dropdown_icon!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-top .techt-nav-arrow' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-nav--vertical-sub-left-side .menu-item-link-top .techt-nav-arrow' =>  is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;' : 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

					'(mobile){{WRAPPER}} .techt-mobile-menu .techt-nav--vertical-sub-left-side .menu-item-link-top .techt-nav-arrow' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;' : 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				),
			)
		);

		$this->add_control(
			'nav_items_desc_heading',
			array(
				'label'     => esc_html__( 'Description', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_items_desc' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'nav_items_desc_typography',
				'selector'  => '{{WRAPPER}} .menu-item-link-top .techt-nav-item-desc',
				'condition' => array(
					'show_items_desc' => 'yes',
				),
			)
		);

		$this->add_control(
			'nav_items_indicator_heading',
			array(
				'label'     => esc_html__( 'Indicator', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'nav_items_indicator' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'nav_items_indicator_width',
			[
				'label' => __('Indicator Width', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .menu-item-link-top:hover::after' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top::after' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'nav_items_indicator_height',
			[
				'label' => __('Indicator Height', 'petrona'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 48,
					],
				],
				
				'selectors' => [
					'{{WRAPPER}} .menu-item-link-top:hover::after' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .menu-item.current-menu-item .menu-item-link-top::after' => 'height: {{SIZE}}{{UNIT}};',
					
				],
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
			]
		);

		$this->add_control(
			'nav_items_indicator_transition',
			array(
				'label'   => esc_html__( 'Select Indicator Transition', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'opacity 0.6 ease',
				'options' => [
					'opacity 0.6s ease' => esc_html__('Opacity', 'petrona'),
					'width 0.6s ease'   => esc_html__('Width', 'petrona'),
					'height 0.6s ease'  => esc_html__('Height', 'petrona'),
					'all 0.6s ease'  => esc_html__('All', 'petrona'),
				],
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .menu-item-link-top::after' => 'transition: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'nav_items_indicator_align',
			[
				'label'   => esc_html__('Indicator Position', 'petrona'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom',
				'options' => [
					'bottom'      => esc_html__('Up', 'petrona'),
					'top'     => esc_html__('Bottom', 'petrona'),
				],
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'nav_items_indicator_space',
			[
				'label'   => esc_html__('Indicator Spacing', 'petrona'),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'default' => [
					'unit' => '%',
					'size' => 1,
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition' => [
					'nav_items_indicator' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .menu-item-link-top::after' => '{{nav_items_indicator_align.VALUE}}: calc({{SIZE}}{{UNIT}} + 50{{UNIT}});',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'sub_items_style',
			array(
				'label'      => esc_html__( 'Dropdown', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'sub_items_container_style_heading',
			array(
				'label' => esc_html__( 'Container Styles', 'petrona' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_responsive_control(
			'sub_items_container_width',
			array(
				'label'      => esc_html__( 'Container Width', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__sub' => 'width: {{SIZE}}{{UNIT}};',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
							'name'     => 'layout',
							'operator' => '===',
							'value'    => 'horizontal',
						),
						array(
							'relation' => 'and',
							'terms' => array(
								array(
									'name'     => 'layout',
									'operator' => '===',
									'value'    => 'vertical',
								),
								array(
									'name'     => 'dropdown_position',
									'operator' => '!==',
									'value'    => 'bottom',
								)
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'sub_items_container_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'sub_items_container_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .techt-nav__sub',
			)
		);

		$this->add_responsive_control(
			'sub_items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav__sub' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .techt-nav__sub > .menu-item:first-child > .menu-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
					'{{WRAPPER}} .techt-nav__sub > .menu-item:last-child > .menu-item-link' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'sub_items_container_box_shadow',
				'selector' => '{{WRAPPER}} .techt-nav__sub',
			)
		);


		$this->add_responsive_control(
			'sub_items_container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav__sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_container_top_gap',
			array(
				'label'      => esc_html__( 'Gap Before 1st Level Sub', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav--horizontal .techt-nav-depth-0' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-nav--vertical-sub-left-side .techt-nav-depth-0' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-nav--vertical-sub-right-side .techt-nav-depth-0' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
							'name'     => 'layout',
							'operator' => '===',
							'value'    => 'horizontal',
						),
						array(
							'relation' => 'and',
							'terms' => array(
								array(
									'name'     => 'layout',
									'operator' => '===',
									'value'    => 'vertical',
								),
								array(
									'name'     => 'dropdown_position',
									'operator' => '!==',
									'value'    => 'bottom',
								)
							),
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_container_left_gap',
			array(
				'label'      => esc_html__( 'Gap Before 2nd Level Sub', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav-depth-0 .techt-nav__sub' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-nav--vertical-sub-left-side .techt-nav-depth-0 .techt-nav__sub' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				),
				'conditions' => array(
					'relation' => 'or',
					'terms' => array(
						array(
							'name'     => 'layout',
							'operator' => '===',
							'value'    => 'horizontal',
						),
						array(
							'relation' => 'and',
							'terms' => array(
								array(
									'name'     => 'layout',
									'operator' => '===',
									'value'    => 'vertical',
								),
								array(
									'name'     => 'dropdown_position',
									'operator' => '!==',
									'value'    => 'bottom',
								)
							),
						),
					),
				),
			)
		);

		$this->add_control(
			'sub_items_style_heading',
			array(
				'label'     => esc_html__( 'Items Styles', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sub_items_typography',
				'selector' => '{{WRAPPER}} .menu-item-link-sub .techt-nav-link-text',
			)
		);

		$this->start_controls_tabs( 'tabs_sub_items_style' );

		$this->start_controls_tab(
			'sub_items_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'sub_items_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sub_items_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_items_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'sub_items_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sub_items_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item:hover > .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'sub_items_active',
			array(
				'label' => esc_html__( 'Active', 'petrona' ),
			)
		);

		$this->add_control(
			'sub_items_bg_color_active',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'sub_items_color_active',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .menu-item.current-menu-item > .menu-item-link-sub' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'sub_items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-sub' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'sub_items_icon_size',
			array(
				'label'      => esc_html__( 'Dropdown Icon Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'condition' => array(
					'dropdown_icon!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .menu-item-link-sub .techt-nav-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sub_items_icon_gap',
			array(
				'label'      => esc_html__( 'Gap Before Dropdown Icon', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'condition' => array(
					'dropdown_icon!' => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} .menu-item-link-sub .techt-nav-arrow' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-nav--vertical-sub-left-side .menu-item-link-sub .techt-nav-arrow' => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;' : 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

					'(mobile){{WRAPPER}} .techt-mobile-menu .techt-nav--vertical-sub-left-side .menu-item-link-sub .techt-nav-arrow' => is_rtl() ?  'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;' : 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				),
			)
		);

		$this->add_control(
			'sub_items_divider_heading',
			array(
				'label'     => esc_html__( 'Divider', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'sub_items_divider',
				'selector' => '{{WRAPPER}} .techt-nav__sub > .techt-nav-item-sub:not(:last-child)',
				'exclude'  => array( 'width' ),
			)
		);

		$this->add_control(
			'sub_items_divider_width',
			array(
				'label' => esc_html__( 'Divider Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'max' => 50,
					),
				),
				'default' => array(
					'size' => 1,
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__sub > .techt-nav-item-sub:not(:last-child)' => 'border-width: 0; border-bottom-width: {{SIZE}}{{UNIT}}',
				),
				'condition' => array(
					'sub_items_divider_border!' => '',
				),
			)
		);

		$this->add_control(
			'sub_items_desc_heading',
			array(
				'label'     => esc_html__( 'Description', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_items_desc' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'sub_items_desc_typography',
				'selector'  => '{{WRAPPER}} .menu-item-link-sub .techt-nav-item-desc',
				'condition' => array(
					'show_items_desc' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_trigger_styles',
			array(
				'label'      => esc_html__( 'Mobile Trigger', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_mobile_trigger_style' );

		$this->start_controls_tab(
			'mobile_trigger_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'mobile_trigger_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mobile_trigger_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'mobile_trigger_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'mobile_trigger_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'mobile_trigger_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .techt-nav__mobile-trigger',
				'separator'   => 'before',
			)
		);

		$this->add_control(
			'mobile_trigger_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_width',
			array(
				'label'      => esc_html__( 'Width', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
					'%' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger' => 'width: {{SIZE}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'mobile_trigger_height',
			array(
				'label'      => esc_html__( 'Height', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'mobile_trigger_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-nav__mobile-trigger' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mobile_menu_styles',
			array(
				'label' => esc_html__( 'Mobile Menu', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'mobile_menu_width',
			array(
				'label' => esc_html__( 'Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range' => array(
					'px' => array(
						'min' => 150,
						'max' => 400,
					),
					'%' => array(
						'min' => 30,
						'max' => 100,
					),
				),
				'selectors' => array(
					'(mobile){{WRAPPER}} .techt-nav' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'mobile_menu_layout' => array(
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->add_control(
			'mobile_menu_max_height',
			array(
				'label' => esc_html__( 'Max Height', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh' ),
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 500,
					),
					'vh' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'(mobile){{WRAPPER}} .techt-nav' => 'max-height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'mobile_menu_layout' => 'full-width',
				),
			)
		);

		$this->add_control(
			'mobile_menu_bg_color',
			array(
				'label' => esc_html__( 'Background color', 'petrona' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .techt-nav' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'mobile_menu_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'(mobile){{WRAPPER}} .techt-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'mobile_menu_text_color',
			array(
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'(mobile){{WRAPPER}} .techt-mobile-menu .menu-item-link' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'mobile_menu_box_shadow',
				'selector' => '(mobile){{WRAPPER}} .techt-mobile-menu-active .techt-nav',
			)
		);

		$this->add_control(
			'mobile_close_icon_heading',
			array(
				'label' => esc_html__( 'Close icon', 'petrona' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'mobile_menu_layout' => array(
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->add_control(
			'mobile_close_icon_color',
			array(
				'label' => esc_html__( 'Color', 'petrona' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-close-btn' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'mobile_menu_layout' => array(
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->add_control(
			'mobile_close_icon_font_size',
			array(
				'label' => esc_html__( 'Font size', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range' => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-nav__mobile-close-btn' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'mobile_menu_layout' => array(
						'left-side',
						'right-side',
					),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Returns available icons for dropdown list
	 *
	 * @return array
	 */
	public function dropdown_arrow_icons_list() {

		return apply_filters( 'techt-elements/nav-menu/dropdown-icons', array(
			'fa fa-angle-down'          => esc_html__( 'Angle', 'petrona' ),
			'fa fa-angle-double-down'   => esc_html__( 'Angle Double', 'petrona' ),
			'fa fa-chevron-down'        => esc_html__( 'Chevron', 'petrona' ),
			'fa fa-chevron-circle-down' => esc_html__( 'Chevron Circle', 'petrona' ),
			'fa fa-caret-down'          => esc_html__( 'Caret', 'petrona' ),
			'fa fa-plus'                => esc_html__( 'Plus', 'petrona' ),
			'fa fa-plus-square-o'       => esc_html__( 'Plus Square', 'petrona' ),
			'fa fa-plus-circle'         => esc_html__( 'Plus Circle', 'petrona' ),
			''                          => esc_html__( 'None', 'petrona' ),
		) );

	}

	/**
	 * Get available menus list
	 *
	 * @return array
	 */
	public function get_available_menus() {

		$raw_menus = wp_get_nav_menus();
		$menus     = wp_list_pluck( $raw_menus, 'name', 'term_id' );

		return $menus;
	}

	 /**
	 * Add icon control
	 *
	 * @param string $id
	 * @param array  $args
	 * @param object $instance
	 */
	public function __add_advanced_icon_control( $id, array $args = array(), $instance = null ) {

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {

			$_id = $id; // old control id
			$id  = $this->__new_icon_prefix . $id;

			$args['type'] = Controls_Manager::ICONS;
			$args['fa4compatibility'] = $_id;

			unset( $args['file'] );
			unset( $args['default'] );

			if ( isset( $args['fa5_default'] ) ) {
				$args['default'] = $args['fa5_default'];
			}
		} else {
			$args['type'] = Controls_Manager::ICON;
		}

		unset( $args['fa5_default'] );

		if ( null !== $instance ) {
			$instance->add_control( $id, $args );
		} else {
			$this->add_control( $id, $args );
		}
	}

	/**
	 * Print HTML icon template
	 *
	 * @param  array  $setting
	 * @param  string $format
	 * @param  string $icon_class
	 * @param  bool   $echo
	 *
	 * @return void|string
	 */
	public function __render_icon( $setting = null, $format = '%s', $icon_class = '', $echo = true ) {

		if ( false === $this->__processed_item ) {
			$settings = $this->get_settings_for_display();
		} else {
			$settings = $this->__processed_item;
		}

		$new_setting = $this->__new_icon_prefix . $setting;

		$migrated = isset( $settings['__fa4_migrated'][ $new_setting ] );
		$is_new   = empty( $settings[ $setting ] ) && class_exists( 'Elementor\Icons_Manager' ) && Icons_Manager::is_migration_allowed();

		$icon_html = '';

		if ( $is_new || $migrated ) {

			$attr = array( 'aria-hidden' => 'true' );

			if ( ! empty( $icon_class ) ) {
				$attr['class'] = $icon_class;
			}

			if ( isset( $settings[ $new_setting ] ) ) {
				ob_start();
				Icons_Manager::render_icon( $settings[ $new_setting ], $attr );

				$icon_html = ob_get_clean();
			}

		} else if ( ! empty( $settings[ $setting ] ) ) {

			if ( empty( $icon_class ) ) {
				$icon_class = $settings[ $setting ];
			} else {
				$icon_class .= ' ' . $settings[ $setting ];
			}

			$icon_html = sprintf( '<i class="%s" aria-hidden="true"></i>', $icon_class );
		}

		if ( empty( $icon_html ) ) {
			return;
		}

		if ( ! $echo ) {
			return sprintf( $format, $icon_html );
		}

		printf( $format, $icon_html );
	}

	/**
	 * Returns HTML icon markup
	 *
	 * @param  array $setting
	 * @param  string $format
	 * @param  string $icon_class
	 * @return string
	 */
	public function __get_icon( $setting = null, $format = '%s', $icon_class = '' ) {
		return $this->__render_icon( $setting, $format, $icon_class, false );
	}

	/**
	 * Print HTML icon markup
	 *
	 * @param  array $setting
	 * @param  string $format
	 * @param  string $icon_class
	 * @return void
	 */
	public function __icon( $setting = null, $format = '%s', $icon_class = '' ) {
		call_user_func( array( $this, sprintf( '__%s_icon', $this->__context ) ), $setting, $format, $icon_class );
	}


	protected function render() {

		$settings = $this->get_settings();

		if ( ! $settings['nav_menu'] ) {
			return;
		}
		
		$trigger_visible = filter_var( $settings['mobile_trigger_visible'], FILTER_VALIDATE_BOOLEAN );
		$trigger_align   = $settings['mobile_trigger_alignment'];

		require_once untrailingslashit( TECHT_MADULES_PATH ) . '/includes/class-techt-nav-walker.php';

		$this->add_render_attribute( 'nav-wrapper', 'class', 'techt-nav-wrap' );

		if ( $trigger_visible ) {
			$this->add_render_attribute( 'nav-wrapper', 'class', 'techt-mobile-menu' );

			if ( isset( $settings['mobile_menu_layout'] ) ) {
				$this->add_render_attribute( 'nav-wrapper', 'class', sprintf( 'techt-mobile-menu--%s', esc_attr( $settings['mobile_menu_layout'] ) ) );
				$this->add_render_attribute( 'nav-wrapper', 'data-mobile-layout', esc_attr( $settings['mobile_menu_layout'] ) );
			}
		}

		$this->add_render_attribute( 'nav-menu', 'class', 'techt-nav' );

		if ( isset( $settings['layout'] ) ) {
			$this->add_render_attribute( 'nav-menu', 'class', 'techt-nav--' . esc_attr( $settings['layout'] ) );

			if ( 'vertical' === $settings['layout'] && isset( $settings['dropdown_position'] ) ) {
				$this->add_render_attribute( 'nav-menu', 'class', 'techt-nav--vertical-sub-' . esc_attr( $settings['dropdown_position'] ) );
			}
		}
		
		$menu_html = '<div ' . $this->get_render_attribute_string( 'nav-menu' ) . '>%3$s</div>';

		if ( $trigger_visible && in_array( $settings['mobile_menu_layout'], array( 'left-side', 'right-side' ) ) ) {
			$close_btn = $this->__get_icon( 'mobile_trigger_close_icon', '<div class="techt-nav__mobile-close-btn techt-elements-icon">%s</div>' );

			$menu_html = '<div ' . $this->get_render_attribute_string( 'nav-menu' ) . '>%3$s' . $close_btn . '</div>';
		}

		if( is_singular( array('page', 'attachment', 'post') ) ){
			$current_obj = get_queried_object();
			$menu = \Techt_Utility::meta_options(['header_page_menu', $current_obj->ID]) ? \Techt_Utility::meta_options(['header_page_menu', $current_obj->ID]) : $settings['nav_menu'];
		}else{
			$menu = $settings['nav_menu'];
		}

		$args = array(
			'menu'            => $menu,
			'fallback_cb'     => '',
			'items_wrap'      => $menu_html,
			'walker'          => new \Techt_Nav_Walker,
			'widget_settings' => array(
				'dropdown_icon'   => $settings['dropdown_icon'],
				'show_items_desc' => $settings['show_items_desc'],
			),
		);
		
		echo '<div ' . $this->get_render_attribute_string( 'nav-wrapper' ) . '>';
			if ( $trigger_visible ) {
				include untrailingslashit( TECHT_MADULES_PATH ) . '/public/elementor/templates/nav-menu/mobile-trigger.php';
			}
			wp_nav_menu( $args );
		echo '</div>';	
	}
}
Plugin::instance()->widgets_manager->register( new Techt_Nav_Menu() );