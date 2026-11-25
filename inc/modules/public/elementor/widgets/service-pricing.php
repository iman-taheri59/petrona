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
use Elementor\Modules\DynamicTags\Module as TagsModule;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Service_Pricing extends Techt_Base {

	public function get_name() {
		return 'techt-service-pricing';
	}

	public function get_title() {
		return esc_html__( 'Service Pricing', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_script_depends() {

		if ( isset( $_GET['elementor-preview'] ) && 'wp_enqueue_scripts' === current_filter() ) {
			return array( 'tippy', 'techt-anime-js' );
		}

		$scripts = array();

		if ( $this->_pricing_features_items_tooltips_check() ) {
			$scripts[] = 'tippy';
		}

		if ( $this->_is_fold_enabled() ) {
			$scripts[] = 'techt-anime-js';
		}

		return $scripts;
	}

	
	public function get_categories() {
		return array( 'techt-category' );
	}

	protected function register_controls() {

		$css_scheme = apply_filters(
			'techt/service-pricing/css-scheme',
			array(
				'table'            => '.service-pricing',
				'header'           => '.service-pricing__heading',
				'icon_wrap'        => '.service-pricing__icon',
				'icon_box'         => '.service-pricing__icon-box',
				'icon'             => '.service-pricing__icon-box > *',
				'title'            => '.service-pricing__title',
				'subtitle'         => '.service-pricing__subtitle',
				'price'            => '.service-pricing__price',
				'price_prefix'     => '.service-pricing__price-prefix',
				'price_value'      => '.service-pricing__price-val',
				'price_suffix'     => '.service-pricing__price-suffix',
				'price_desc'       => '.service-pricing__price-desc',
				'features'         => '.service-pricing__features',
				'features_item'    => '.pricing-feature',
				'included_item'    => '.pricing-feature.item-included',
				'excluded_item'    => '.pricing-feature.item-excluded',
				'action'           => '.service-pricing__action',
				'button'           => '.service-pricing__action .service-pricing-button',
				'button_icon'      => '.service-pricing__action .button-icon',
				'tooltip'          => '.tippy-tooltip',
				'fold_button'      => '.service-pricing__fold-button',
				'fold_button_icon' => '.service-pricing__fold-button-icon',
				'fold_button_text' => '.service-pricing__fold-button-text',
				'fold_trigger'     => '.service-pricing__fold-trigger',
			)
		);

		$this->start_controls_section(
			'section_general',
			array(
				'label' => esc_html__( 'General', 'petrona' ),
			)
		);

		$this->add_advanced_icon_control(
			'icon',
			array(
				'label'       => esc_html__( 'Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => array(
					'inside'  => esc_html__( 'Inside Header', 'petrona' ),
					'outside' => esc_html__( 'Outside Header', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'     => esc_html__( 'Title', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Title', 'petrona' ),
				'dynamic'   => array( 'active' => true ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_available_title_html_tags(),
				'default' => 'h2',
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'     => esc_html__( 'Subtitle', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Subtitle', 'petrona' ),
				'dynamic'   => array( 'active' => true ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'subtitle_html_tag',
			array(
				'label'   => esc_html__( 'Subtitle HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->get_available_title_html_tags(),
				'default' => 'h4',
			)
		);

		$this->add_control(
			'featured',
			array(
				'label'        => esc_html__( 'Is Featured?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'featured_badge',
			array(
				'label'   => esc_html__( 'Featured Badge', 'petrona' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => TECHT_MADULES_URL . '/public/assets/images/placeholder-badge.svg',
				),
				'condition' => array(
					'featured' => 'yes',
				),
			)
		);

		$this->add_control(
			'featured_position',
			array(
				'label'   => esc_html__( 'Featured Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
				),
				'condition' => array(
					'featured' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'featured_left',
			array(
				'label'      => esc_html__( 'Left Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
					'%' => array(
						'min' => -50,
						'max' => 50,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'featured_position' => 'left',
					'featured' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-pricing__badge' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'featured_right',
			array(
				'label'      => esc_html__( 'Right Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
					'%' => array(
						'min' => -50,
						'max' => 50,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'featured_position' => 'right',
					'featured' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-pricing__badge' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'featured_top',
			array(
				'label'      => esc_html__( 'Top Indent', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
					'%' => array(
						'min' => -50,
						'max' => 50,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .service-pricing__badge' => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'featured' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price',
			array(
				'label' => esc_html__( 'Price', 'petrona' ),
			)
		);

		$this->add_control(
			'price_prefix',
			array(
				'label'   => esc_html__( 'Price Prefix', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '$', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'price',
			array(
				'label'   => esc_html__( 'Price Value', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '100', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'price_suffix',
			array(
				'label'   => esc_html__( 'Price Suffix', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( '/per month', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'price_desc',
			array(
				'label'   => esc_html__( 'Price Description', 'petrona' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features',
			array(
				'label' => esc_html__( 'Features', 'petrona' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			array(
				'label'   => esc_html__( 'Text', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Feature', 'petrona' ),
				'dynamic' => array( 'active' => true ),
			)
		);

		$repeater->add_control(
			'item_included',
			array(
				'label'   => esc_html__( 'Is Included?', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'item-included',
				'options' => array(
					'item-included' => esc_html__( 'Included', 'petrona' ),
					'item-excluded' => esc_html__( 'Excluded', 'petrona' ),
				),
			)
		);

		$repeater->add_control(
			'item_tooltip',
			array(
				'label'   => esc_html__( 'Tooltip', 'petrona' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => '',
				'dynamic' => array( 'active' => true ),
			)
		);

		$this->add_control(
			'features_list',
			array(
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array(
						'item_text'     => esc_html__( 'Feature #1', 'petrona' ),
						'item_included' => 'item-included',
					),
					array(
						'item_text'     => esc_html__( 'Feature #2', 'petrona' ),
						'item_included' => 'item-included',
					),
					array(
						'item_text'     => esc_html__( 'Feature #3', 'petrona' ),
						'item_included' => 'item-excluded',
					),
					array(
						'item_text'     => esc_html__( 'Feature #4', 'petrona' ),
						'item_included' => 'item-excluded',
					),
				),
				'title_field' => '{{{ item_text }}}',
			)
		);

		$this->add_advanced_icon_control(
			'included_bullet_icon',
			array(
				'label'       => esc_html__( 'Included Bullet Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default'     => 'fa fa-check',
				'fa5_default' => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'separator'   => 'before',
			)
		);

		$this->add_advanced_icon_control(
			'excluded_bullet_icon',
			array(
				'label'       => esc_html__( 'Excluded Bullet Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default'     => 'fa fa-times',
				'fa5_default' => array(
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_action',
			array(
				'label' => esc_html__( 'Action Button', 'petrona' ),
			)
		);

		$this->add_control(
			'button_before',
			array(
				'label'   => esc_html__( 'Text Before Action Button', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy', 'petrona' ),
			)
		);

		$this->add_control(
			'button_url',
			array(
				'label'   => esc_html__( 'Button URL', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '#',
				'dynamic' => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
			)
		);

		$this->add_control(
			'button_is_external',
			array(
				'label'     => esc_html__( 'Open in new window', 'petrona' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'button_url!' => '',
				),
			)
		);

		$this->add_control(
			'button_nofollow',
			array(
				'label'     => esc_html__( 'Add nofollow', 'petrona' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => array(
					'button_url!' => '',
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
				'default'      => '',
			)
		);

		$this->add_advanced_icon_control(
			'button_icon',
			array(
				'label'       => esc_html__( 'Icon', 'petrona' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => false,
				'skin'        => 'inline',
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
					'left'  => esc_html__( 'Before Text', 'petrona' ),
					'right' => esc_html__( 'After Text', 'petrona' ),
				),
				'default'     => 'left',
				'render_type' => 'template',
				'condition'   => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_after',
			array(
				'label'   => esc_html__( 'Text After Action Button', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tooltip',
			array(
				'label' => esc_html__( 'Tooltips', 'petrona' ),
			)
		);

		$this->add_control(
			'tooltip_placement',
			array(
				'label'   => esc_html__( 'Placement', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'petrona' ),
					'bottom' => esc_html__( 'Bottom', 'petrona' ),
					'left'   => esc_html__( 'Left', 'petrona' ),
					'right'  => esc_html__( 'Right', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'tooltip_trigger',
			array(
				'label'   => esc_html__( 'Trigger', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'mouseenter',
				'options' => array(
					'mouseenter' => esc_html__( 'Hover', 'petrona' ),
					'click'      => esc_html__( 'Click', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'tooltip_animation',
			array(
				'label'   => esc_html__( 'Animation', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => array(
					'shift-away'   => 'Shift-Away',
					'shift-toward' => 'Shift-Toward',
					'fade'         => 'Fade',
					'scale'        => 'Scale',
					'perspective'  => 'Perspective',
				),
			)
		);

		$this->add_control(
			'tooltip_arrow',
			array(
				'label'        => esc_html__( 'Use Arrow', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'tooltip_arrow_type',
			array(
				'label'   => esc_html__( 'Arrow Type', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sharp',
				'options' => array(
					'sharp' => esc_html__( 'Sharp', 'petrona' ),
					'round' => esc_html__( 'Round', 'petrona' ),
				),
				'condition' => array(
					'tooltip_arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'tooltip_arrow_size',
			array(
				'label'   => esc_html__( 'Arrow Size', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scale(1)',
				'options' => array(
					'scale(1)'     => esc_html__( 'Normal', 'petrona' ),
					'scale(0.75)'  => esc_html__( 'Small', 'petrona' ),
					'scaleX(0.75)' => esc_html__( 'Skinny', 'petrona' ),
					'scale(1.5)'   => esc_html__( 'Large', 'petrona' ),
					'scaleX(1.5)'  => esc_html__( 'Wide', 'petrona' ),
				),
				'condition' => array(
					'tooltip_arrow' => 'yes',
				),
			)
		);

		$this->add_control(
			'tooltip_show_duration',
			array(
				'label'      => esc_html__( 'Show Duration', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range' => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 1000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 500,
					'unit' => 'ms',
				),
			)
		);

		$this->add_control(
			'tooltip_hide_duration',
			array(
				'label'      => esc_html__( 'Hide Duration', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range' => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 1000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 300,
					'unit' => 'ms',
				),
			)
		);

		$this->add_control(
			'tooltip_delay',
			array(
				'label'      => esc_html__( 'Delay', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'ms',
				),
				'range' => array(
					'ms' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 0,
					'unit' => 'ms',
				),
			)
		);

		$this->add_control(
			'tooltip_distance',
			array(
				'label'      => esc_html__( 'Distance', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px',
				),
				'range' => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
					),
				),
				'default' => array(
					'size' => 15,
					'unit' => 'px',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fold',
			array(
				'label' => esc_html__( 'Fold Settings', 'petrona' ),
			)
		);

		$this->add_control(
			'fold_enabled',
			array(
				'label'        => esc_html__( 'Fold Enabled', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'fold_items_show',
			array(
				'label'     => esc_html__( 'Number of Visible Items', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 100,
				'step'      => 1,
				'default'   => 1,
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_control(
			'fold_state_heading',
			array(
				'label'     => esc_html__( 'Fold State Styles', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_settings' );

		$this->start_controls_tab(
			'tab_unfold_settings',
			array(
				'label'     => esc_html__( 'Unfold', 'petrona' ),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_control(
			'unfold_duration',
			array(
				'label'      => esc_html__( 'Duration', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'ms' ),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 3000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 500,
					'unit' => 'ms',
				),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_control(
			'unfold_easing',
			array(
				'label'       => esc_html__( 'Easing', 'petrona' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'easeOutBack',
				'options'     => array(
					'linear'        => 'Linear',
					'easeOutSine'   => 'Sine',
					'easeOutExpo'   => 'Expo',
					'easeOutCirc'   => 'Circ',
					'easeOutBack'   => 'Back',
					'easeInOutSine' => 'InOutSine',
					'easeInOutExpo' => 'InOutExpo',
					'easeInOutCirc' => 'InOutCirc',
					'easeInOutBack' => 'InOutBack',
				),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_fold_settings',
			array(
				'label'     => esc_html__( 'Fold', 'petrona' ),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_control(
			'fold_duration',
			array(
				'label'      => esc_html__( 'Duration', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'ms' ),
				'range'      => array(
					'ms' => array(
						'min'  => 100,
						'max'  => 3000,
						'step' => 100,
					),
				),
				'default' => array(
					'size' => 300,
					'unit' => 'ms',
				),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_control(
			'fold_easing',
			array(
				'label'       => esc_html__( 'Easing', 'petrona' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'easeOutSine',
				'options'     => array(
					'linear'        => 'Linear',
					'easeOutSine'   => 'Sine',
					'easeOutExpo'   => 'Expo',
					'easeOutCirc'   => 'Circ',
					'easeOutBack'   => 'Back',
					'easeInOutSine' => 'InOutSine',
					'easeInOutExpo' => 'InOutExpo',
					'easeInOutCirc' => 'InOutCirc',
					'easeInOutBack' => 'InOutBack',
				),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fold_button',
			array(
				'label'     => esc_html__( 'Fold Button', 'petrona' ),
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_responsive_control(
			'fold_button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['fold_trigger'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fold_button_icon_position',
			array(
				'label'   => esc_html__( 'Icon position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Before Text', 'petrona' ),
					'right' => esc_html__( 'After Text', 'petrona' ),
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button' );

		$this->start_controls_tab(
			'tab_fold_button',
			array(
				'label' => esc_html__( 'Fold', 'petrona' ),
			)
		);

		$this->add_control(
			$this->_new_icon_prefix . 'button_fold_icon',
			array(
				'label'            => esc_html__( 'Fold Icon', 'petrona' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => false,
				'skin'             => 'inline',
				'fa4compatibility' => 'button_unfold_icon',
				'default'          => array(
					'value'   => 'fas fa-chevron-up',
					'library' => 'fa-solid',
				),
				'render_type'      => 'template',
			)
		);

		$this->add_control(
			'button_fold_text',
			array(
				'label'   => esc_html__( 'Fold Text', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hide', 'petrona' ),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_unfold_button',
			array(
				'label' => esc_html__( 'Unfold', 'petrona' ),
			)
		);

		$this->add_control(
			$this->_new_icon_prefix . 'button_unfold_icon',
			array(
				'label'            => esc_html__( 'Unfold Icon', 'petrona' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => false,
				'skin'             => 'inline',
				'fa4compatibility' => 'button_fold_icon',
				'default'          => array(
					'value'   => 'fas fa-chevron-down',
					'library' => 'fa-solid',
				),
				'render_type'      => 'template',
			)
		);

		$this->add_control(
			'button_unfold_text',
			array(
				'label'   => esc_html__( 'Unfold Text', 'petrona' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Show', 'petrona' ),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_style',
			array(
				'label'      => esc_html__( 'Table', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'table_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table'],
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width'  => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color'  => array(
						'global' => [
							'default' => Global_Colors::COLOR_TEXT,
						],
					),
				),
			)
		);

		$this->add_responsive_control(
			'table_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'table_padding',
			array(
				'label'      => esc_html__( 'Table Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['table'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'table_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
			)
		);

		$this->add_control(
			'order_heading',
			array(
				'label'     => esc_html__( 'Order', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'header_order',
			array(
				'label'     => esc_html__( 'Header Order', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_order',
			array(
				'label'     => esc_html__( 'Icon Order', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'order: {{VALUE}};',
				),
				'condition' => array(
					'icon_position' => 'outside',
				),
			)
		);

		$this->add_control(
			'pricing_order',
			array(
				'label'     => esc_html__( 'Pricing Order', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'features_order',
			array(
				'label'     => esc_html__( 'Features Order', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'action_box_order',
			array(
				'label'     => esc_html__( 'Action Box Order', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['action'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			array(
				'label'      => esc_html__( 'Header', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'header_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'header_title_style',
			array(
				'label'     => esc_html__( 'Title', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'  => esc_html__( 'Title Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_control(
			'header_subtitle_style',
			array(
				'label'     => esc_html__( 'Subtitle', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'  => esc_html__( 'Subtitle Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['subtitle'],
			)
		);

		$this->add_responsive_control(
			'header_padding',
			array(
				'label'      => esc_html__( 'Header Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} '  . $css_scheme['header'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'header_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['header'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'header_border',
				'label'          => esc_html__( 'Border', 'petrona' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->add_responsive_control(
			'header_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			array(
				'label'      => esc_html__( 'Icon', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			'techt-box-style',
			array(
				'name'           => 'icon_style',
				'label'          => esc_html__( 'Icon Style', 'petrona' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['icon'],
				'fields_options' => array(
					'box_font_color' => array(
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					),
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'icon_position' => 'outside',
				),
			)
		);

		$this->add_responsive_control(
			'icon_wrap_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'icon_box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_style',
			array(
				'label'      => esc_html__( 'Pricing', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'price_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'price_prefix_style',
			array(
				'label'     => esc_html__( 'Prefix', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_prefix_color',
			array(
				'label'  => esc_html__( 'Price Prefix Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_prefix_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['price_prefix'],
			)
		);

		$this->add_control(
			'price_prefix_vertical_align',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->verrtical_align_attr(),
				'default' => 'baseline',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'vertical-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_prefix_dispaly',
			array(
				'label'   => esc_html__( 'Prefix Display', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inline-block' => esc_html__( 'Inline', 'petrona' ),
					'block'        => esc_html__( 'Block', 'petrona' ),
				),
				'default' => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_val_style',
			array(
				'label'     => esc_html__( 'Price Value', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'  => esc_html__( 'Price Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_value'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'price_typography',
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selector'  => '{{WRAPPER}}  ' . $css_scheme['price_value'],
			)
		);

		$this->add_control(
			'price_suffix_style',
			array(
				'label'     => esc_html__( 'Suffix', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_suffix_color',
			array(
				'label'  => esc_html__( 'Price Suffix Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_suffix_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['price_suffix'],
			)
		);

		$this->add_control(
			'price_suffix_vertical_align',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $this->verrtical_align_attr(),
				'default' => 'baseline',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'vertical-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_suffix_dispaly',
			array(
				'label'   => esc_html__( 'Suffix Display', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inline-block' => esc_html__( 'Inline', 'petrona' ),
					'block'        => esc_html__( 'Block', 'petrona' ),
				),
				'default'   => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_desc_style',
			array(
				'label'     => esc_html__( 'Description', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_desc_color',
			array(
				'label' => esc_html__( 'Price Description Color', 'petrona' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_desc_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['price_desc'],
			)
		);

		$this->add_control(
			'price_desc_gap',
			array(
				'label' => esc_html__( 'Gap', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_desc'] => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_padding',
			array(
				'label'      => esc_html__( 'Pricing Block Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'price_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['price'],
			)
		);

		$this->add_responsive_control(
			'price_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features_style',
			array(
				'label'      => esc_html__( 'Features', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'features_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'features_padding',
			array(
				'label'      => esc_html__( 'Features Block Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'features_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['features'],
			)
		);

		$this->add_responsive_control(
			'features_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['features_item'],
			)
		);

		$this->add_responsive_control(
			'features_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['features'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_included_feature_style',
			array(
				'label'     => esc_html__( 'Included Feature', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'inc_features_color',
			array(
				'label'  => esc_html__( 'Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['included_item'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'inc_bullet_icon_size',
			array(
				'label'   => esc_html__( 'Icon Size', 'petrona' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'inc_bullet_color',
			array(
				'label'  => esc_html__( 'Bullet Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['included_item'] . ' .item-bullet' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_excluded_feature_style',
			array(
				'label'     => esc_html__( 'Excluded Feature', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'exc_features_color',
			array(
				'label'  => esc_html__( 'Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excluded_item'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'exc_bullet_icon_size',
			array(
				'label'   => esc_html__( 'Icon Size', 'petrona' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'exc_bullet_color',
			array(
				'label'  => esc_html__( 'Bullet Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .item-bullet' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'exc_text_decoration',
			array(
				'label'   => esc_html__( 'Text Decoration', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => array(
					'none'         => esc_html__( 'None', 'petrona' ),
					'line-through' => esc_html__( 'Line Through', 'petrona' ),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['excluded_item'] . ' .pricing-feature__text' => 'text-decoration: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'features_divider_style',
			array(
				'label'     => esc_html__( 'Features Divider', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'features_divider',
			array(
				'label'        => esc_html__( 'Divider', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'features_divider_line',
			array(
				'label'   => esc_html__( 'Style', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'solid'  => esc_html__( 'Solid', 'petrona' ),
					'double' => esc_html__( 'Double', 'petrona' ),
					'dotted' => esc_html__( 'Dotted', 'petrona' ),
					'dashed' => esc_html__( 'Dashed', 'petrona' ),
				),
				'default' => 'solid',
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-style: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'features_divider_color',
			array(
				'label'  => esc_html__( 'Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'features_divider_weight',
			array(
				'label'   => esc_html__( 'Weight', 'petrona' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 1,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'features_divider_width',
			array(
				'label'     => esc_html__( 'Width', 'petrona' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'width: {{SIZE}}%',
				),
			)
		);

		$this->add_control(
			'features_divider_gap',
			array(
				'label'   => esc_html__( 'Gap', 'petrona' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 15,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} ' . $css_scheme['features_item'] => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .service-pricing-unfold-state .fold_visible_last' => 'margin-bottom: {{SIZE}}{{UNIT}} !important',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_actions_style',
			array(
				'label'      => esc_html__( 'Action Box', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'action_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['action'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'action_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['action'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'action_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['action'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'action_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['action'],
			)
		);

		$this->add_responsive_control(
			'action_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['action'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'action_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}}  ' . $css_scheme['action'],
			)
		);

		$this->add_responsive_control(
			'action_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
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
					'{{WRAPPER}} ' . $css_scheme['action'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_action_button_style',
			array(
				'label'      => esc_html__( 'Action Button', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'   => esc_html__( 'Size', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => array(
					'auto' => esc_html__( 'auto', 'petrona' ),
					'full' => esc_html__( 'full', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'button_icon_heading',
			array(
				'label'     => esc_html__( 'Icon', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_size',
			array(
				'label' => esc_html__( 'Icon Size', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
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
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'condition'  => array(
					'add_button_icon' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'after',
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
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color' => array(
						'label'  => _x( 'Background Color', 'Background Control', 'petrona' ),
						'global' => [
							'default' => Global_Colors::COLOR_PRIMARY,
						],
					),
					'color_b' => array(
						'label' => _x( 'Second Background Color', 'Background Control', 'petrona' ),
					),
				),
				'exclude' => array(
					'image',
					'position',
					'attachment',
					'attachment_alert',
					'repeat',
					'size',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
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
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
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
				'name'     => 'button_hover_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color' => array(
						'label' => _x( 'Background Color', 'Background Control', 'petrona' ),
					),
					'color_b' => array(
						'label' => _x( 'Second Background Color', 'Background Control', 'petrona' ),
					),
				),
				'exclude' => array(
					'image',
					'position',
					'attachment',
					'attachment_alert',
					'repeat',
					'size',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
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
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Tooltips Style Section
		 */
		$this->start_controls_section(
			'section_tooltips_style',
			array(
				'label' => esc_html__( 'Tooltips', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'tooltip_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tooltip_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'],
			)
		);

		$this->add_control(
			'tooltip_text_align',
			array(
				'label'   => esc_html__( 'Text Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'petrona' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tooltip_arrow_color',
			array(
				'label'     => esc_html__( 'Arrow Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' .tippy-popper[x-placement^=left] ' . $css_scheme['tooltip'] . ' .tippy-arrow'=> 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['table'] . ' .tippy-popper[x-placement^=right] ' . $css_scheme['tooltip'] . ' .tippy-arrow'=> 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['table'] . ' .tippy-popper[x-placement^=top] ' . $css_scheme['tooltip'] . ' .tippy-arrow'=> 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['table'] . ' .tippy-popper[x-placement^=bottom] ' . $css_scheme['tooltip'] . ' .tippy-arrow'=> 'border-bottom-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'tooltip_wrapper_style_heading',
			array(
				'label'     => esc_html__( 'Wrapper Styles', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'tooltip_width',
			array(
				'label'      => esc_html__( 'Width', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 500,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'] => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['table'] . ' .tippy-popper' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'tooltip_background',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'tooltip_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'tooltip_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'],
			)
		);

		$this->add_responsive_control(
			'tooltip_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'tooltip_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'] . ' ' . $css_scheme['tooltip'],
			)
		);

		$this->end_controls_section();

		/**
		 * `Fold Button` style section
		 */
		$this->start_controls_section(
			'fold_button_section_style',
			array(
				'label'     => __( 'Fold Button', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'fold_enabled' => 'true',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'fold_button_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['fold_button'],
			)
		);

		$this->start_controls_tabs( 'tabs_fold_button_style' );

		$this->start_controls_tab(
			'tab_fold_button_normal',
			array(
				'label' => __( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'fold_button_icon_color',
			array(
				'label'     => __( 'Icon Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button_icon'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fold_button_text_color',
			array(
				'label'     => __( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button_text'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fold_button_background_color',
			array(
				'label'     => __( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_fold_button_hover',
			array(
				'label' => __( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'fold_button_hover_icon_color',
			array(
				'label'     => __( 'Icon Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] . ':hover ' . $css_scheme['fold_button_icon'] . ', {{WRAPPER}} ' . $css_scheme['fold_button'] . ':focus ' . $css_scheme['fold_button_icon'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fold_button_hover_text_color',
			array(
				'label'     => __( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] . ':hover ' . $css_scheme['fold_button_text'] . ', {{WRAPPER}} ' . $css_scheme['fold_button'] . ':focus ' . $css_scheme['fold_button_text'] => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fold_button_background_hover_color',
			array(
				'label'     => __( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] . ':hover, {{WRAPPER}} ' . $css_scheme['fold_button'] . ':focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'fold_button_hover_border_color',
			array(
				'label'     => __( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'fold_button_border_border!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] . ':hover, {{WRAPPER}} ' . $css_scheme['fold_button'] . ':focus' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'fold_button_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_responsive_control(
			'fold_button_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fold_trigger'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'fold_button_icon_size',
			array(
				'label'   => esc_html__( 'Icon Size', 'petrona' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'fold_button_icon_margin',
			array(
				'label'      => __( 'Icon margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'fold_button_border',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['fold_button'],
				'separator' => 'before',
			)
		);

		$this->add_control(
			'fold_button_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['fold_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'fold_button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['fold_button'],
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

	protected function content_template() {}

	public function _pricing_feature_icon() {
		return call_user_func( array( $this, sprintf( '_pricing_feature_icon_%s', $this->_context ) ) );
	}

	public function _pricing_feature_icon_render() {

		$item = $this->_processed_item;

		switch ( $item['item_included'] ) {
			case 'item-excluded':
				$icon_setting = 'excluded_bullet_icon';
				break;

			default:
				$icon_setting = 'included_bullet_icon';
				break;
		}

		$this->_processed_item = false;

		$icon = $this->_icon( $icon_setting, '<span class="item-bullet techt-icon">%s</span>' );

		$this->_processed_item = $item;

		return $icon;
	}

	public function _pricing_features_items_tooltips_check() {
		$settings = $this->get_settings();

		if ( isset( $settings['features_list'] ) && is_array( $settings['features_list'] ) ) {

			$features_list = $settings['features_list'];
			$check         = false;

			foreach ( $features_list as $item ) {
				if ( ! empty( $item['item_tooltip'] ) ) {
					$check = true;
				}
			}

			return $check;
		}

		return false;
	}

	public function _is_fold_enabled() {
		$settings           = $this->get_settings_for_display();
		$fold_enabled       = isset( $settings['fold_enabled'] ) ? filter_var( $settings['fold_enabled'], FILTER_VALIDATE_BOOLEAN ) : false;
		$fold_visible_items = isset( $settings['fold_items_show'] ) ? $settings['fold_items_show'] : 1;
		$features_count     = count( $settings['features_list'] );

		if ( $fold_enabled && $features_count > $fold_visible_items ) {
			return true;
		}

		return false;
	}

	public function _pricing_feature_icon_edit() {
		?>
		<# if ( 'item-excluded' === item.item_included ) { #>
			<# if ( settings.excluded_bullet_icon ) { #>
				<i class="item-bullet {{{ settings.excluded_bullet_icon }}}"></i>
			<# } #>
		<# } else { #>
			<# if ( settings.included_bullet_icon ) { #>
				<i class="item-bullet {{{ settings.included_bullet_icon }}}"></i>
			<# } #>
		<# } #>
		<?php
	}
	
	public function _get_badge_image() {
		$badge = $this->get_settings_for_display( 'featured_badge' );
		
		if ( ! isset( $badge['url'] ) ) {
			return;
		}
		
		return $this->get_image_by_url( $badge['url'], array( 'class' => 'service-pricing__badge', 'alt' => esc_attr( Control_Media::get_image_alt( $badge ) ) ) );
	}

   
	public function get_image_by_url( $url = null, $attr = array() ) {
		$url = esc_url( $url );
		if ( empty( $url ) ) {
			return;
		}
		$ext  = pathinfo( $url, PATHINFO_EXTENSION );
		$attr = array_merge( array( 'alt' => '' ), $attr );
		if ( 'svg' !== $ext ) {
			return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
		}
		$base_url = site_url( '/' );
		$svg_path = str_replace( $base_url, ABSPATH, $url );
		$key      = md5( $svg_path );
		$svg      = get_transient( $key );
		if ( ! $svg ) {
			$svg = file_get_contents( $svg_path );
		}
		if ( ! $svg ) {
			return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
		}
		set_transient( $key, $svg, DAY_IN_SECONDS );
		unset( $attr['alt'] );
		return sprintf( '<div%2$s>%1$s</div>', $svg, $this->get_attr_string( $attr ) );
	}
	
	public function get_attr_string( $attr = array() ) {
		if ( empty( $attr ) || ! is_array( $attr ) ) {
			return;
		}
		$result = '';
		foreach ( $attr as $key => $value ) {
			$result .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
		}
		return $result;
	}

	
	public function _get_looped_template( $name = null, $setting = null, $callback = null ) {

		$templates = array(
			'start' => $this->get_widget_template( $name . '-loop-start' ),
			'loop'  => $this->get_widget_template( $name . '-loop-item' ),
			'end'   => $this->get_widget_template( $name . '-loop-end' ),
		);

		call_user_func(
			array( $this, sprintf( '_get_%s_looped_template', $this->_context ) ), $templates, $setting, $callback
		);

	}

	public function _get_render_looped_template( $templates = array(), $setting = null, $callback = null ) {

		$loop = $this->get_settings_for_display( $setting );
		$loop = apply_filters( 'techt/widget/loop-items', $loop, $setting, $this );

		if ( empty( $loop ) ) {
			return;
		}

		if ( $callback && is_callable( $callback ) ) {
			$loop = call_user_func( $callback, $loop );
		}

		if ( ! empty( $templates['start'] ) ) {
			include $templates['start'];
		}

		foreach ( $loop as $item ) {

			$this->_processed_item = $item;

			if ( ! empty( $templates['loop'] ) ) {
				include $templates['loop'];
			}
			$this->_processed_index++;
		}

		$this->_processed_item = false;
		$this->_processed_index = 0;

		if ( ! empty( $templates['end'] ) ) {
			include $templates['end'];
		}

	}
}
Plugin::instance()->widgets_manager->register( new Techt_Service_Pricing() );