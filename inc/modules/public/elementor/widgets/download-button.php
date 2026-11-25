<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Download_Button extends Techt_Base {

	public function get_name() {
		return 'techt-download-button';
	}

	public function get_title() {
		return esc_html__( 'Download Button', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-download-bold';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'petrona' ),
			)
		);

		$this->add_control(
			'download_file',
			array(
				'label'       => esc_html__( 'Download ID', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array( 'active' => true, ),
				'description' => esc_html__( 'Here you can specify ID of media library element which will be downloaded on button click', 'petrona' ),
				'default'     => array(),
			)
		);

		$this->add_control(
			'download_label',
			array(
				'label'       => esc_html__( 'Download Link Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Download', 'petrona' ),
				'description' => esc_html__( 'You can use %size% placeholder to show formatted file size in label', 'petrona' ),
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'download_sub_label',
			array(
				'label'       => esc_html__( 'Download Link Sub Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '%size%',
				'description' => esc_html__( 'You can use %size% placeholder to show formatted file size in label', 'petrona' ),
			)
		);

		$this->add_control(
			'download_link_rel',
			array(
				'label'        => esc_html__( 'Add nofollow', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'nofollow',
			)
		);

		$this->add_advanced_icon_control(
			'download_icon',
			array(
				'label'       => esc_html__( 'Download Link Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'fa4compatibility' => 'icon',
				'fa5_default' => [
					'value' => 'fas fa-download',
					'library' => 'fa-solid',
				],
			)
		);

		$this->end_controls_section();

		$css_scheme = apply_filters(
			'techt-element/download-button/css-scheme',
			array(
				'button'          => '.techt-download',
				'icon'            => '.techt-download__icon',
				'button_label'    => '.techt-download__label',
				'button_sublabel' => '.techt-download__sub-label',
			)
		);

		$this->start_controls_section(
			'section_action_button_style',
			array(
				'label'      => esc_html__( 'General', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'button_self_alignment',
			array(
				'label'   => esc_html__( 'Button Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => '',
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
					'justify' => array(
						'title' => esc_html__( 'Justified', 'petrona' ),
						'icon'  => 'eicon-h-align-stretch',
					),
				),
				'prefix_class' => 'elementor%s-align-',
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
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
					'{{WRAPPER}} ' . $css_scheme['button'] . ', {{WRAPPER}} .techt-download__text' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_icon_heading',
			array(
				'label'     => esc_html__( 'Button Icon', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i'=> 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' svg'=> 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'download_icon_position',
			array(
				'label'   => esc_html__( 'Download Link Icon', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'left'   => esc_html__( 'Left', 'petrona' ),
					'right'  => esc_html__( 'Right', 'petrona' ),
					'top'    => esc_html__( 'Top', 'petrona' ),
					'bottom' => esc_html__( 'Bottom', 'petrona' ),
				),
				'default' => 'left',
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_action_button_states',
			array(
				'label'      => esc_html__( 'Button', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'     => esc_html__( 'Button Icon', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' svg'	=> 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_label',
			array(
				'label'     => esc_html__( 'Button Label', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_label'] => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button_label'],
			)
		);

		$this->add_control(
			'button_sublabel',
			array(
				'label'     => esc_html__( 'Button Sub-label', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_sub_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_sublabel'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_sub_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button_sublabel'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_bg_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_control(
			'button_icon_hover',
			array(
				'label'     => esc_html__( 'Button Icon', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_hover_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_label_hover',
			array(
				'label'     => esc_html__( 'Button Label', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['button_label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['button_label'],
			)
		);

		$this->add_control(
			'button_hover_sublabel',
			array(
				'label'     => esc_html__( 'Button Sub-label', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_hover_sub_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' . $css_scheme['button_sublabel'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_sub_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover '. $css_scheme['button_sublabel'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Replace placeholders in label
	 *
	 * @param  string $text Input text.
	 * @return string
	 */
	protected function _format_label( $text = '', $id = 0 ) {

		if ( ! $id ) {
			return $text;
		}

		if ( false !== strpos( $text, '%size%' ) ) {
			$size = techt_download_handler()->get_file_size( $id );
			$text = str_replace( '%size%', $size, $text );
		}

		return $text;
	}

	protected function render() {

		$this->_context = 'render';

		$this->_open_wrap();
		require $this->get_widget_template('index');
		$this->_close_wrap();
	}

}
Plugin::instance()->widgets_manager->register( new Techt_Download_Button() );