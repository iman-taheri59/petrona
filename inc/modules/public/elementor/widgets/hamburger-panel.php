<?php
/**
 * Name: Hamburger Panel
 */

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Utils;
use Oxin_Core_Utility;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Hamburger_Panel extends Techt_Base {

	public function get_name() {
		return 'techt-hamburger-panel';
	}

	public function get_title() {
		return esc_html__( 'Hamburger Panel', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-menu-bar';
	}

	public function get_categories() {
		return ['techt-category'];
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'techt/hamburger-panel/css-scheme',
			array(
				'panel'    => '.techt-hamburger-panel',
				'instance' => '.techt-hamburger-panel__instance',
				'cover'    => '.techt-hamburger-panel__cover',
				'inner'    => '.techt-hamburger-panel__inner',
				'content'  => '.techt-hamburger-panel__content',
				'close'    => '.techt-hamburger-panel__close-button',
				'toggle'   => '.techt-hamburger-panel__toggle',
				'icon'     => '.techt-hamburger-panel__icon',
				'label'    => '.techt-hamburger-panel__toggle-label',
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'petrona' ),
			)
		);

		$this->_add_advanced_icon_control(
			'panel_toggle_icon',
			array(
				'label'       => esc_html__( 'Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default'     => 'techt-icon-align-justify-1',
				'fa5_default' => array(
					'value'   => 'techt-icon-align-justify-1',
					'library' => 'techt-icons',
				),
			)
		);
		$this->_add_advanced_icon_control(
			'panel_toggle_active_icon',
			array(
				'label'       => esc_html__( 'Active Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default'     => 'techt-icon-cancel',
				'fa5_default' => array(
					'value'   => 'techt-icon-cancel',
					'library' => 'techt-icons',
				),
			)
		);
		$this->_add_advanced_icon_control(
			'panel_close_icon',
			array(
				'label'       => esc_html__( 'Close Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default'     => 'techt-icon-cancel',
				'fa5_default' => array(
					'value'   => 'techt-icon-cancel',
					'library' => 'techt-icons',
				),
			)
		);
		// $this->add_control(
		// 	'panel_toggle_icon',
		// 	[
		// 		'label' => __( 'Icon', 'petrona' ),
		// 		'type' => Controls_Manager::ICONS,
		// 		'label_block' => false,
		// 		'skin'        => 'inline',
		// 		'default' => [
		// 			'value' => 'techt-icon-align-justify-1',
		// 			'library' => 'techt-icons'
		// 		],
		// 	]
		// );

		// $this->add_control(
		// 	'panel_toggle_active_icon',
		// 	array(
		// 		'label'       => esc_html__( 'Active Icon', 'petrona' ),
		// 		'type'        => Controls_Manager::ICONS,
		// 		'label_block' => false,
		// 		'skin'        => 'inline',
		// 		'file'        => '',
		// 		'default' => [
		// 			'value' => 'techt-icon-cancel',
		// 			'library' => 'techt-icons'
		// 		],
		// 	)
		// );

		// $this->add_control(
		// 	'panel_close_icon',
		// 	array(
		// 		'label'       => esc_html__( 'Close Icon', 'petrona' ),
		// 		'type'        => Controls_Manager::ICONS,
		// 		'label_block' => false,
		// 		'skin'        => 'inline',
		// 		'file'        => '',
		// 		'default' => [
		// 			'value' => 'techt-icon-cancel',
		// 			'library' => 'techt-icons'
		// 		],
		// 	)
		// );
		$this->add_control(
			'panel_toggle_label',
			array(
				'label'   => esc_html__( 'Label', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'More', 'petrona' ),
			)
		);

		$this->add_responsive_control(
			'panel_toggle_label_alignment',
			array(
				'label'   => esc_html__( 'Toggle Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['panel'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'panel_template_id',
			[
				'label' => esc_html__('Choose Template', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => $this->get_techt_templates(),
				'edit_button' => array(
					'active' => true,
					'label'  => __( 'Edit Template', 'petrona' ),
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'petrona' ),
			)
		);

		$this->add_control(
			'position',
			array(
				'label'       => esc_html__( 'Position', 'petrona' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'right',
				'options' => array(
					'right' => esc_html__( 'Right', 'petrona' ),
					'left'  => esc_html__( 'Left', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'animation_effect',
			array(
				'label'       => esc_html__( 'Effect', 'petrona' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'slide',
				'options' => array(
					'slide' => esc_html__( 'Slide', 'petrona' ),
					'fade'  => esc_html__( 'Fade', 'petrona' ),
					'zoom'  => esc_html__( 'Zoom', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'z_index',
			array(
				'label'   => esc_html__( 'Z-Index', 'petrona' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100000,
				'step'    => 1,
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'z-index: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ajax_template',
			array(
				'label'        => esc_html__( 'Use Ajax Loading for Template', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'petrona' ),
				'label_off'    => esc_html__( 'Off', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'ajax_template_cache',
			array(
				'label'        => esc_html__( 'Use Cache for Template', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'petrona' ),
				'label_off'    => esc_html__( 'Off', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'ajax_template' => 'yes',
				)
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_panel_style',
			array(
				'label'      => esc_html__( 'Panel', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'panel_width',
			array(
				'label'      => esc_html__( 'Panel Width', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 250,
						'max' => 800,
					),
					'%' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'panel_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'panel_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'panel_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['inner'],
			)
		);

		$this->add_control(
			'panel_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'panel_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['inner'],
			)
		);

		$this->add_control(
			'cover_style_heading',
			array(
				'label'     => esc_html__( 'Cover', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'cover_bg_color',
			array(
				'label' => esc_html__( 'Background color', 'petrona' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'close_button_style_heading',
			array(
				'label'     => esc_html__( 'Close Button', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'close_button_styles' );

		$this->start_controls_tab(
			'close_button_control',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Close Icon', 'petrona' ),
				'name'     => 'close_icon_box',
				'selector' => '{{WRAPPER}} ' . $css_scheme['close'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'close_button_control_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Close Icon', 'petrona' ),
				'name'     => 'close_icon_box_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['close'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'content_loader_style_heading',
			array(
				'label'     => esc_html__( 'Loader Styles', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'ajax_template' => 'yes',
				)
			)
		);

		$this->add_control(
			'content_loader_color',
			array(
				'label' => esc_html__( 'Loader color', 'petrona' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['content'] . ' .techt-hamburger-panel-loader' => 'border-color: {{VALUE}}; border-top-color: white;',
				),
				'condition' => array(
					'ajax_template' => 'yes',
				)
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_panel_toggle_style',
			array(
				'label'      => esc_html__( 'Toggle', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'toggle_styles' );

		$this->start_controls_tab(
			'toggle_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_background',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_PRIMARY,
						),
					),
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'toggle_background_hover',
				'fields_options' => array(
					'color' => array(
						'global' => array(
							'default' => Global_Colors::COLOR_PRIMARY,
						),
					),
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'toggle_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'toggle_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['toggle'],
			)
		);

		$this->add_control(
			'toggle_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'toggle_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'],
			)
		);

		$this->add_control(
			'toggle_icon_style_heading',
			array(
				'label'     => esc_html__( 'Icon Styles', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'toggle_icon_styles' );

		$this->start_controls_tab(
			'toggle_icon_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Toggle Icon', 'petrona' ),
				'name'     => 'toggle_icon_box',
				'selector' => '{{WRAPPER}} ' . $css_scheme['icon'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_icon_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_group_control(
			\Techt_Group_Control_Box_Style::get_type(),
			array(
				'label'    => esc_html__( 'Toggle Icon', 'petrona' ),
				'name'     => 'toggle_icon_box_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover ' . $css_scheme['icon'],
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'toggle_label_style_heading',
			array(
				'label'     => esc_html__( 'Label Styles', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'toggle_label_styles' );

		$this->start_controls_tab(
			'toggle_label_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'toggle_control_label_color',
			array(
				'label'     => esc_html__( 'Label Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'toggle_label_typography',
				'selector' => '{{WRAPPER}} '. $css_scheme['label'],
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'toggle_label_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'toggle_control_label_color_hover',
			array(
				'label'     => esc_html__( 'Label Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover ' . $css_scheme['label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'toggle_label_typography_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['toggle'] . ':hover ' . $css_scheme['label'],
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function render() {

		$this->_context = 'render';

		$panel_settings = $this->get_settings();

		$template_id          = isset( $panel_settings['panel_template_id'] ) ? $panel_settings['panel_template_id'] : '0';
		$position             = isset( $panel_settings['position'] ) ? $panel_settings['position'] : 'right';
		$animation_effect     = isset( $panel_settings['animation_effect'] ) ? $panel_settings['animation_effect'] : 'slide';
		$ajax_template        = isset( $panel_settings['ajax_template'] ) ? filter_var( $panel_settings['ajax_template'], FILTER_VALIDATE_BOOLEAN ) : false;
		$ajax_template_cache  = isset( $panel_settings['ajax_template_cache'] ) ? filter_var( $panel_settings['ajax_template_cache'], FILTER_VALIDATE_BOOLEAN ) : false;

		$widget_id = $this->get_id();
		$secret = defined( 'NONCE_KEY' ) ? NONCE_KEY : '';
		$signature = md5( $template_id . $widget_id . $secret );

		$settings = array(
			'position'          => $position,
			'ajaxTemplate'      => $ajax_template,
			'ajaxTemplateCache' => $ajax_template_cache,
			'widget_id'         => $widget_id,
			'signature'         => $signature,
		);

		if ( true === $ajax_template && true != $ajax_template_cache ) {
			add_filter( 'techt/rest/endpoint/elementor-template/cached', array( $this, 'disable_template_cache' ) );
		}

		$this->add_render_attribute( 'instance', array(
			'class' => array(
				'techt-hamburger-panel',
				'techt-hamburger-panel-' . $position . '-position',
				'techt-hamburger-panel-' . $animation_effect . '-effect',
			),
			'data-settings' => json_encode( $settings ),
		) );

		$close_button_html = $this->_get_icon( 'panel_close_icon', '<div class="techt-hamburger-panel__close-button techt-icon">%s</div>', '', false );

		$toggle_control_html = '';
		$toggle_icon        = $this->_get_icon( 'panel_toggle_icon', '<span class="techt-hamburger-panel__icon icon-normal techt-icon">%s</span>', '', false );
		$toggle_active_icon = $this->_get_icon( 'panel_toggle_active_icon', '<span class="techt-hamburger-panel__icon icon-active techt-icon">%s</span>', '', false );

		if ( ! empty( $toggle_icon ) && ! empty( $toggle_active_icon ) ) {
			$toggle_control_html .= sprintf( '<div class="techt-hamburger-panel__toggle-icon">%1$s%2$s</div>', $toggle_icon, $toggle_active_icon );
		}

		$toggle_label_html = '';

		if ( ! empty( $panel_settings['panel_toggle_label'] ) ) {
			$toggle_label_html .= sprintf( '<div class="techt-hamburger-panel__toggle-label"><span>%1$s</span></div>', esc_html( $panel_settings['panel_toggle_label'] ) );
		}

		$toggle_html = sprintf(
			'<div class="techt-hamburger-panel__toggle" role="button" tabindex="0" aria-label="%1$s">%2$s%3$s</div>',
			! empty( $panel_settings['panel_toggle_label'] ) ? esc_attr( $panel_settings['panel_toggle_label'] ) : esc_html__( 'Toggle Panel', 'petrona' ),
			$toggle_control_html,
			$toggle_label_html
		);

		?>
		<div <?php echo $this->get_render_attribute_string( 'instance' ); ?>>
			<?php echo $toggle_html; ?>
			<div class="techt-hamburger-panel__instance">
				<div class="techt-hamburger-panel__cover"></div>
				<div class="techt-hamburger-panel__inner">
					<?php
						echo $close_button_html;

						if ( ! empty( $template_id ) ) {
							$link = add_query_arg(
								array(
									'elementor' => '',
								),
								get_permalink( $template_id )
							);

							if ( $this->in_elementor() ) {
								echo sprintf( '<div class="techt__edit-cover" data-template-edit-link="%s"><i class="eicon-edit"></i><span>%s</span></div>', $link, esc_html__( 'Edit Template', 'petrona' ) );
							}
						}

						$this->add_render_attribute( 'techt-hamburger-panel__content', array(
							'class'            => 'techt-hamburger-panel__content',
							'data-template-id' => ! empty( $template_id ) ? $template_id : 'false',
						) );

						$content_html = '';

						if ( ! empty( $template_id ) && ! $ajax_template ) {
							$content_html .= $this->get_template_content( $template_id );
						} else if ( ! $ajax_template ) {
							$content_html = $this->no_templates_message();
						} else {
							$content_html .= '<div class="techt-hamburger-panel-loader"></div>';
						}

						echo sprintf( '<div %1$s>%2$s</div>', $this->get_render_attribute_string( 'techt-hamburger-panel__content' ), $content_html );
					?>
				</div>
			</div>
		</div>
		<?php
		$techt_hamburger_panel = apply_filters(
			'techt_hamburger_panel_js_localize',
			array(
				'ajaxurl'        => esc_url( admin_url( 'admin-ajax.php' ) ),
				'isMobile'       => filter_var( wp_is_mobile(), FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
				// 'templateApiUrl' => $rest_api_url . 'jet-blocks-api/v1/elementor-template',
				'devMode'        => is_user_logged_in() ? 'true' : 'false',
				'restNonce'      => wp_create_nonce( 'wp_rest' ),
				// Nonce consumed by check_ajax_referer( 'techt-addons' ) on the server.
				'addonsNonce'    => wp_create_nonce( 'techt-addons' ),
			)
		);
		wp_localize_script( 'techt-frontend-widget-scripts', 'techt_hamburger_panel_settings', $techt_hamburger_panel );
	}

	public function disable_template_cache() {
		return false;
	}

	/**
	 * Empty templates message description
	 *
	 * @return string
	 */
	public function empty_templates_message() {
		return '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . esc_html__( 'You Haven’t Saved Templates Yet.', 'petrona' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer">' . esc_html__( 'What is Library?', 'petrona' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Read our tutorial on using Library templates.', 'petrona' ) . '</a></div>
				</div>';
	}

	/**
	 * No templates message
	 *
	 * @return string
	 */
	public function no_templates_message() {
		$message = '<span>' . esc_html__( 'Template is not defined. ', 'petrona' ) . '</span>';

		$url = add_query_arg(
			array(
				'post_type'     => 'elementor_library',
				'action'        => 'elementor_new_post',
				'_wpnonce'      => wp_create_nonce( 'elementor_action_new_post' ),
				'template_type' => 'section',
			),
			esc_url( admin_url( '/edit.php' ) )
		);

		$new_link = '<span>' . esc_html__( 'Select an existing template or create a ', 'petrona' ) . '</span><a class="techt-new-template-link elementor-clickable" href="' . $url . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'new one', 'petrona' ) . '</a>' ;

		return sprintf(
			'<div class="techt-no-template-message">%1$s%2$s</div>',
			$message,
			$this->in_elementor() ? $new_link : ''
		);
	}

}

Plugin::instance()->widgets_manager->register( new Techt_Hamburger_Panel() );


