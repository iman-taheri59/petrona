<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Search_Box extends Techt_Base {

	public function get_name() {
		return 'techt-search-box';
	}

	public function get_title() {
		return esc_html__( 'Search', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-site-search';
	}

	public function get_categories() {
		return array( 'techt-category' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_search_general_settings',
			array(
				'label' => esc_html__( 'General Settings', 'petrona' ),
			)
		);

		$this->add_control(
			'search_placeholder',
			array(
				'label'   => esc_html__( 'Search Placeholder', 'petrona' ),
				'default' => esc_html__( 'Search &hellip;', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'show_search_submit',
			array(
				'label'        => esc_html__( 'Show Submit Button', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'search_submit_label',
			array(
				'label'     => esc_html__( 'Submit Button Label', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'show_search_submit' => 'true',
				),
			)
		);

		$this->add_advanced_icon_control(
			'search_submit_icon',
			array(
				'label'     => esc_html__( 'Submit Button Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'file'        => '',
				'skin'        => 'inline',
				'default'     => 'fa fa-search',
				'fa5_default' => array(
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'show_search_submit' => 'true',
				),
			)
		);

		$this->add_control(
			'show_search_in_popup',
			array(
				'label'        => esc_html__( 'Show Search Form in Popup', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'full_screen_popup',
			array(
				'label'        => esc_html__( 'Full Screen Popup', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => '',
				'condition' => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_advanced_icon_control(
			'search_popup_trigger_icon',
			array(
				'label'       => esc_html__( 'Popup Trigger Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'file'        => '',
				'skin'        => 'inline',
				'default'     => 'fa fa-search',
				'fa5_default' => array(
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_advanced_icon_control(
			'search_close_icon',
			array(
				'label'     => esc_html__( 'Popup Close Button Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'file'        => '',
				'skin'        => 'inline',
				'default'     => 'fa fa-times',
				'fa5_default' => array(
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_control(
			'popup_show_effect',
			array(
				'label'   => esc_html__( 'Show Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'      => esc_html__( 'None', 'petrona' ),
					'fade'      => esc_html__( 'Fade', 'petrona' ),
					'scale'     => esc_html__( 'Scale', 'petrona' ),
					'move-up'   => esc_html__( 'Move Up', 'petrona' ),
					'move-down' => esc_html__( 'Move Down', 'petrona' ),
				),
				'default' => 'move-up',
				'condition' => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_control(
			'is_product_search',
			array(
				'label'        => esc_html__( 'Is Product Search', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'techt-elements/search/css-scheme',
			array(
				'form'                    => '.techt-search__form',
				'form_input'              => '.techt-search__field',
				'form_submit'             => '.techt-search__submit',
				'form_submit_icon'        => '.techt-search__submit-icon',
				'popup'                   => '.techt-search__popup',
				'popup_full_screen'       => '.techt-search__popup--full-screen',
				'popup_content'           => '.techt-search__popup-content',
				'popup_close'             => '.techt-search__popup-close',
				'popup_close_icon'        => '.techt-search__popup-close-icon',
				'popup_trigger_container' => '.techt-search__popup-trigger-container',
				'popup_trigger'           => '.techt-search__popup-trigger',
				'popup_trigger_icon'      => '.techt-search__popup-trigger-icon',
			)
		);

		$this->start_controls_section(
			'section_form_style',
			array(
				'label' => esc_html__( 'Form', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'form_input_style',
			array(
				'label'     => esc_html__( 'Input Field', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'form_input_typography',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['form_input'],
			)
		);

		$this->start_controls_tabs( 'form_input_tabs' );

		$this->start_controls_tab(
			'form_input_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'form_input_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_input_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_input_placeholder_color',
			array(
				'label'  => esc_html__( 'Placeholder Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] . '::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . '::-moz-placeholder'          => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':-ms-input-placeholder'      => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'form_input_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_input'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'form_input_tab_focus',
			array(
				'label' => esc_html__( 'Focus', 'petrona' ),
			)
		);

		$this->add_control(
			'form_input_bg_color_focus',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_input_color_focus',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_input_placeholder_color_focus',
			array(
				'label'  => esc_html__( 'Placeholder Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus::-moz-placeholder'          => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus:-ms-input-placeholder'      => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_input_border_color_focus',
			array(
				'label'  => esc_html__( 'Border Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'form_input_border_border!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'form_input_box_shadow_focus',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'form_input_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['form_input'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'form_input_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['form_input'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'form_input_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['form_input'],
			)
		);

		$this->add_responsive_control(
			'form_input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['form_input'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'form_submit_style',
			array(
				'label'     => esc_html_x( 'Submit Button', 'for Search Elementor Widget', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'form_submit_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_submit'],
			)
		);

		$this->add_responsive_control(
			'form_submit_icon_size',
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
					'{{WRAPPER}} ' . $css_scheme['form_submit_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_form_submit_style' );

		$this->start_controls_tab(
			'tab_form_submit_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'form_submit_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_submit'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_submit_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_submit'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_form_submit_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'form_submit_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_submit'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_submit_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_submit'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_submit_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'form_submit_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form_submit'] . ':hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'form_submit_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['form_submit'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'form_submit_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['form_submit'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'form_submit_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['form_submit'],
			)
		);

		$this->add_responsive_control(
			'form_submit_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['form_submit'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'form_submit_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_submit'],
			)
		);

		$this->add_control(
			'form_style',
			array(
				'label'     => esc_html__( 'Form Style', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'form_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['form'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'form_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['form'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'form_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['form'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'form_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['form'],
			)
		);

		$this->add_responsive_control(
			'form_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['form'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'form_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_style',
			array(
				'label'      => esc_html__( 'Popup Box', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_responsive_control(
			'popup_width',
			array(
				'label' => esc_html__( 'Popup Content Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] . ':not(' . $css_scheme['popup_full_screen'] . ')' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['popup_full_screen'] . ' ' . $css_scheme['popup_content'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'popup_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'popup_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['popup'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'popup_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['popup'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'popup_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['popup'],
			)
		);

		$this->add_responsive_control(
			'popup_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'popup_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['popup'],
			)
		);

		$this->add_control(
			'popup_position',
			array(
				'label'     => esc_html__( 'Popup Position', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'full_screen_popup' => '',
				),
			)
		);

		$this->add_control(
			'popup_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Postition by', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'petrona' ),
					'bottom' => esc_html__( 'Bottom', 'petrona' ),
				),
				'condition' => array(
					'full_screen_popup' => '',
				),
			)
		);

		$this->add_responsive_control(
			'popup_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'popup_vert_position' => 'top',
					'full_screen_popup'   => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'popup_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'popup_vert_position' => 'bottom',
					'full_screen_popup'   => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'popup_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Position by', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
				),
				'condition' => array(
					'full_screen_popup' => '',
				),
			)
		);

		$this->add_responsive_control(
			'popup_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'popup_hor_position' => 'left',
					'full_screen_popup'  => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'popup_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'popup_hor_position' => 'right',
					'full_screen_popup'  => '',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_trigger_style',
			array(
				'label'      => esc_html__( 'Popup Trigger', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_responsive_control(
			'popup_trigger_icon_size',
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
					'{{WRAPPER}} ' . $css_scheme['popup_trigger_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_popup_trigger_style' );

		$this->start_controls_tab(
			'tab_popup_trigger_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'popup_trigger_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'popup_trigger_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_popup_trigger_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'popup_trigger_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'popup_trigger_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'popup_trigger_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'popup_trigger_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] . ':hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'popup_trigger_alignment',
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
				'selectors' => array(
					'{{WRAPPER}} '  . $css_scheme['popup_trigger_container'] => 'justify-content: {{VALUE}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'popup_trigger_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['popup_trigger'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'popup_trigger_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['popup_trigger'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'popup_trigger_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['popup_trigger'],
			)
		);

		$this->add_responsive_control(
			'popup_trigger_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'popup_trigger_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['popup_trigger'],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_close_style',
			array(
				'label'      => esc_html__( 'Popup Close', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => array(
					'show_search_in_popup' => 'true',
				),
			)
		);

		$this->add_responsive_control(
			'popup_close_icon_size',
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
					'{{WRAPPER}} ' . $css_scheme['popup_close_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_popup_close_style' );

		$this->start_controls_tab(
			'tab_popup_close_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'popup_close_bg_color',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_close'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'popup_close_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_close'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_popup_close_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'popup_close_bg_color_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_close'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'popup_close_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_close'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'popup_close_hover_border_color',
			array(
				'label' => esc_html__( 'Border Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'popup_close_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['popup_close'] . ':hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'popup_close_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['popup_close'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'popup_close_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['popup_close'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'popup_close_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['popup_close'],
			)
		);

		$this->add_responsive_control(
			'popup_close_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['popup_close'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'popup_close_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['popup_close'],
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->_context = 'render';

		$this->_open_wrap();
		require $this->get_widget_template( 'index' );
		$this->_close_wrap();
	}
	
}
Plugin::instance()->widgets_manager->register( new Techt_Search_Box() );