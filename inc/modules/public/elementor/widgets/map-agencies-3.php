<?php
/**
* Techt Map Agencies widget.
*
* @package Techt
*/

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Techt_Map_Agencies_3 extends Widget_Base {

    public function get_name() {
        return 'techt-map-agencies-3';
    }

    public function get_title()
	{
		return esc_html__('Map & Agencies 3', 'petrona');
	}

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return ['techt-category'];
    }

    public function get_script_depends() {
        return ['highcharts', 'highcharts-map', 'highcharts-iran-map'];
    }

    protected function _register_controls() {
        // بخش تنظیمات عمومی
        $this->start_controls_section(
            'section_map_settings',
            [
                'label' => __('Map Settings', 'petrona'),
            ]
        );

        $this->add_control(
            'map_title',
            [
                'label' => __('Map Title', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Iran Provinces Map', 'petrona'),
            ]
        );

        $this->add_responsive_control(
			'map_height',
            [
                'label' => __('Map Height (px)', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .map-container' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .agencies-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'map_zoom',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Default Zoom Level', 'petrona' ),
				'range' => [
					'level' => [
						'min'  => 0,
						'max'  => 10,
                        'step' => 0.5
					],
				],
				'default' => [
					'size' => 0,
					'unit' => 'px',
				]
			]
		);

        $this->add_control(
            'active_province',
            [
                'label' => __('Active Province', 'petrona'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_provinces_options(),
                'default' => 'ir-th',
            ]
        );

        $this->end_controls_section();

        // بخش رنگ‌ها
        // $this->start_controls_section(
        //     'section_colors',
        //     [
        //         'label' => __('Colors', 'petrona'),
        //     ]
        // );

        

        // $this->add_control(
        //     'border_color',
        //     [
        //         'label' => __('Border Color', 'petrona'),
        //         'type' => Controls_Manager::COLOR,
        //         // 'default' => '#ffffff',
        //     ]
        // );

        // $this->add_control(
        //     'text_color',
        //     [
        //         'label' => __('Text Color', 'petrona'),
        //         'type' => Controls_Manager::COLOR,
        //         'default' => '#333333',
        //     ]
        // );

        // $this->end_controls_section();

        // بخش نمایندگی‌ها
        $this->start_controls_section(
            'section_agencies',
            [
                'label' => __('Agencies', 'petrona'),
            ]
        );

        $this->add_control(
            'agencies_title',
            [
                'label' => __('Agencies Section Title', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Agencies', 'petrona'),
            ]
        );

        $this->add_control(
            'no_agencies_text',
            [
                'label' => __('No Agencies Text', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Select a province to see agencies', 'petrona'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'province',
            [
                'label' => __('Province', 'petrona'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_provinces_options(),
                'default' => '',
            ]
        );

        $repeater->add_control(
            'agency_name',
            [
                'label' => __('Agency Name', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'agency_address',
            [
                'label' => __('Agency Address', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'agency_phone',
            [
                'label' => __('Phone Number', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'agency_email',
            [
                'label' => __('Email', 'petrona'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $this->add_control(
            'agencies_list',
            [
                'label' => __('Agencies List', 'petrona'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ agency_name }}} - {{{ province }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_markers',
            [
                'label' => __('Markers', 'petrona'),
            ]
        );

        $this->add_control(
            'show_markers',
            [
                'label' => __('Show Markers', 'petrona'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'petrona'),
                'label_off' => __('No', 'petrona'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'marker_color',
            [
                'label' => __('Marker Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0000ff',
                'condition' => [
                    'show_markers' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'marker_size',
            [
                'label' => __('Marker Size', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 7,
                ],
                'condition' => [
                    'show_markers' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // بخش استایل نقشه
        $this->start_controls_section(
            'section_map_style',
            [
                'label' => __('Map Style', 'petrona'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // کنترل‌های border نقشه
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'map_border',
                'label' => __('Map Border', 'petrona'),
                'selector' => '{{WRAPPER}} .map-container .highcharts-container',
            ]
        );

        $this->add_control(
            'map_border_radius',
            [
                'label' => __('Border Radius', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // کنترل box-shadow نقشه
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'map_box_shadow',
                'label' => __('Box Shadow', 'petrona'),
                'selector' => '{{WRAPPER}} .map-container .highcharts-container',
            ]
        );

        // کنترل background نقشه
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'map_background',
                'label' => __('Map Background', 'petrona'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .map-container .highcharts-container',
            ]
        );

        // کنترل‌های متن و label نقشه
        $this->add_control(
            'map_text_heading',
            [
                'label' => __('Text & Labels', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'map_text_color',
            [
                'label' => __('Text Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-text' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .map-container .highcharts-title' => 'fill: {{VALUE}} !important;',
                ],
                'default' => '#202020',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'map_label_typography',
                'label' => __('Label Typography', 'petrona'),
                'selector' => '{{WRAPPER}} .map-container .highcharts-text',
            ]
        );

        // کنترل‌های رنگ استان‌ها
        $this->add_control(
            'map_colors_heading',
            [
                'label' => __('Province Colors', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'map_default_color',
            [
                'label' => __('Default Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e6e6e6',
                // 'selectors' => [
                //     '{{WRAPPER}} .map-container .highcharts-map-series .highcharts-point:not(.highcharts-color-1):not(.highcharts-color-2)' => 'fill: {{VALUE}} !important;',
                // ],
            ]
        );

        $this->add_control(
            'map_has_agency_color',
            [
                'label' => __('Has Agency Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f2b500',
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-map-series .highcharts-color-1' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'map_active_color',
            [
                'label' => __('Active Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fe651f',
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-map-series .highcharts-point-select' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'map_hover_color',
            [
                'label' => __('Hover Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f2b500',
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-map-series .highcharts-point-hover' => 'fill: {{VALUE}} !important;',
                ],
            ]
        );

        // کنترل border استان‌ها
        $this->add_control(
            'map_province_border_color',
            [
                'label' => __('Province Border Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'default' => '#e7e7e7',
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-map-series .highcharts-point' => 'stroke: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'map_province_border_width',
            [
                'label' => __('Province Border Width', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'size' => 1.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .map-container .highcharts-map-series .highcharts-point' => 'stroke-width: {{SIZE}}px !important;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_agencies_style',
            [
                'label' => __('Agencies Box Style', 'petrona'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // کنترل‌های پدینگ و مارجین
        $this->add_responsive_control(
            'agencies_padding',
            [
                'label' => __('Padding', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .agencies-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'agencies_margin',
            [
                'label' => __('Margin', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .agencies-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // کنترل‌های border
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'agencies_border',
                'label' => __('Border', 'petrona'),
                'selector' => '{{WRAPPER}} .agencies-container',
            ]
        );

        $this->add_responsive_control(
            'agencies_border_radius',
            [
                'label' => __('Border Radius', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .agencies-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // کنترل‌های سایه و پس‌زمینه
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'agencies_box_shadow',
                'label' => __('Box Shadow', 'petrona'),
                'selector' => '{{WRAPPER}} .agencies-container',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'agencies_background',
                'label' => __('Background', 'petrona'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .agencies-container',
            ]
        );

        // کنترل‌های تایپوگرافی عنوان بخش
        $this->add_control(
            'agencies_title_heading',
            [
                'label' => __('Title Style', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'agencies_title_typography',
                'label' => __('Typography', 'petrona'),
                'selector' => '{{WRAPPER}} .agencies-container h3',
            ]
        );

        $this->add_control(
            'agencies_title_color',
            [
                'label' => __('Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agencies-container h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'agencies_title_spacing',
            [
                'label' => __('Spacing', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .agencies-container h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // بخش استایل آیتم‌های نمایندگی
        $this->start_controls_section(
            'section_agency_items_style',
            [
                'label' => __('Agency Items Style', 'petrona'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // کنترل‌های عمومی آیتم‌ها
        $this->add_responsive_control(
            'agency_items_spacing',
            [
                'label' => __('Items Spacing', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .agency-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .agency-item:last-child' => 'margin-bottom: 0;',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'agency_item_background',
                'label' => __('Background', 'petrona'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .agency-item',
            ]
        );

        $this->add_responsive_control(
            'agency_item_padding',
            [
                'label' => __('Padding', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .agency-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'agency_item_border',
                'label' => __('Border', 'petrona'),
                'selector' => '{{WRAPPER}} .agency-item',
            ]
        );

        $this->add_responsive_control(
            'agency_item_border_radius',
            [
                'label' => __('Border Radius', 'petrona'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .agency-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'agency_item_box_shadow',
                'label' => __('Box Shadow', 'petrona'),
                'selector' => '{{WRAPPER}} .agency-item',
            ]
        );

        // کنترل‌های hover
        $this->add_control(
            'agency_item_hover_heading',
            [
                'label' => __('Hover Style', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'agency_item_hover_background',
            [
                'label' => __('Background', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'agency_item_hover_border_color',
            [
                'label' => __('Border Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'agency_item_hover_box_shadow',
                'label' => __('Box Shadow', 'petrona'),
                'selector' => '{{WRAPPER}} .agency-item:hover',
            ]
        );

        $this->add_control(
            'agency_item_hover_transition',
            [
                'label' => __('Transition Duration', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .agency-item' => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        // کنترل‌های تایپوگرافی آیتم‌ها
        $this->add_control(
            'agency_item_text_heading',
            [
                'label' => __('Text Style', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // استایل نام نمایندگی
        $this->add_control(
            'agency_name_heading',
            [
                'label' => __('Agency Name', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'agency_name_typography',
                'label' => __('Typography', 'petrona'),
                'selector' => '{{WRAPPER}} .agency-item strong',
            ]
        );

        $this->add_control(
            'agency_name_color',
            [
                'label' => __('Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-item strong' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'agency_name_hover_color',
            [
                'label' => __('Hover Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-item:hover strong' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'agency_name_spacing',
            [
                'label' => __('Spacing', 'petrona'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .agency-item strong' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // استایل آدرس نمایندگی
        $this->add_control(
            'agency_contact_heading',
            [
                'label' => __('Contact Info', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'agency_contact_typography',
                'label' => __('Typography', 'petrona'),
                'selector' => '{{WRAPPER}} .agency-item p',
            ]
        );

        $this->add_control(
            'agency_contact_color',
            [
                'label' => __('Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-item p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'agency_contact_hover_color',
            [
                'label' => __('Hover Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-item:hover p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // استایل اطلاعات تماس
        $this->add_control(
            'agency_contact_heading',
            [
                'label' => __('Contact Info', 'petrona'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'agency_contact_typography',
                'label' => __('Typography', 'petrona'),
                'selector' => '{{WRAPPER}} .agency-address, {{WRAPPER}} .agency-phone, {{WRAPPER}} .agency-email',
            ]
        );

        $this->add_control(
            'agency_contact_color',
            [
                'label' => __('Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-address, {{WRAPPER}} .agency-phone, {{WRAPPER}} .agency-email' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'agency_icon_color',
            [
                'label' => __('Icon Color', 'petrona'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .agency-address, {{WRAPPER}} .agency-phone .dashicons, {{WRAPPER}} .agency-email .dashicons' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_provinces_options() {
        // لیست استان‌ها با کلیدهای hc-key مطابق ir-all.js
        return [
            'ir-ea' => __('East Azerbaijan', 'petrona'), // آذربایجان شرقی
            'ir-wa' => __('West Azerbaijan', 'petrona'), // آذربایجان غربی
            'ir-ar' => __('Ardabil', 'petrona'), // اردبیل
            'ir-es' => __('Isfahan', 'petrona'), // اصفهان
            'ir-al' => __('Alborz', 'petrona'), // البرز
            'ir-il' => __('Ilam', 'petrona'), // ایلام
            'ir-bs' => __('Bushehr', 'petrona'), // بوشهر
            'ir-th' => __('Tehran', 'petrona'), // تهران
            'ir-cm' => __('Chaharmahal and Bakhtiari', 'petrona'), // چهارمحال و بختیاری
            'ir-kj' => __('South Khorasan', 'petrona'), // خراسان جنوبی
            'ir-kv' => __('Razavi Khorasan', 'petrona'), // خراسان رضوی
            'ir-ks' => __('North Khorasan', 'petrona'), // خراسان شمالی
            'ir-kz' => __('Khuzestan', 'petrona'), // خوزستان
            'ir-za' => __('Zanjan', 'petrona'), // زنجان
            'ir-sm' => __('Semnan', 'petrona'), // سمنان
            'ir-sb' => __('Sistan and Baluchestan', 'petrona'), // سیستان و بلوچستان
            'ir-fa' => __('Fars', 'petrona'), // فارس
            'ir-qz' => __('Qazvin', 'petrona'), // قزوین
            'ir-qm' => __('Qom', 'petrona'), // قم
            'ir-kd' => __('Kurdistan', 'petrona'), // کردستان
            'ir-ke' => __('Kerman', 'petrona'), // کرمان
            'ir-bk' => __('Kermanshah', 'petrona'), // کرمانشاه
            'ir-kb' => __('Kohgiluyeh and Boyer-Ahmad', 'petrona'), // کهگیلویه و بویراحمد
            'ir-go' => __('Golestan', 'petrona'), // گلستان
            'ir-gi' => __('Gilan', 'petrona'), // گیلان
            'ir-lo' => __('Lorestan', 'petrona'), // لرستان
            'ir-mn' => __('Mazandaran', 'petrona'), // مازندران
            'ir-mk' => __('Markazi', 'petrona'), // مرکزی
            'ir-hg' => __('Hormozgan', 'petrona'), // هرمزگان
            'ir-hd' => __('Hamadan', 'petrona'), // همدان
            'ir-ya' => __('Yazd', 'petrona'), // یزد
        ];
    }

    // تابع جدید برای تولید HTML نمایندگی‌ها
    private function generate_agencies_html($province_code, $agencies_by_province, $provinces_names) {
        $agencies = $agencies_by_province[$province_code] ?? [];
        $province_name = $provinces_names[$province_code] ?? $province_code;
        
        if (empty($agencies)) {
            return '<p class="no-agency">' . __('No agencies available for this province', 'petrona') . '</p>';
        }
        
        $html = '<h4>' . esc_html($province_name) . '</h4>';
        $html .= '<ul class="agency-items">';
        
        foreach ($agencies as $agency) {
            $html .= '<li class="agency-item" data-province="' . esc_attr($province_code) . '">';
            $html .= '<strong>' . esc_html($agency['name']) . '</strong>';
            $html .= '<p class="agency-address"><span class="dashicons dashicons-location"></span> ' . esc_html($agency['address']) . '</p>';
            
            if (!empty($agency['phone'])) {
                $html .= '<p class="agency-phone"><span class="dashicons dashicons-phone"></span> ' . esc_html($agency['phone']) . '</p>';
            }
            
            if (!empty($agency['email'])) {
                $html .= '<p class="agency-email"><span class="dashicons dashicons-email-alt"></span> ' . esc_html($agency['email']) . '</p>';
            }
            
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        return $html;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // سازماندهی نمایندگی‌ها بر اساس استان
        $agencies_by_province = [];
        $agencies_by_province = [];
        $provinces_with_agencies = [];

        foreach ($settings['agencies_list'] as $agency) {
            $province_code = $agency['province'];
            if (!isset($agencies_by_province[$province_code])) {
                $agencies_by_province[$province_code] = [];
                $provinces_with_agencies[] = $province_code;
            }
            $agencies_by_province[$province_code][] = [
                'name' => $agency['agency_name'],
                'address' => $agency['agency_address'],
                'phone' => $agency['agency_phone'],
                'email' => $agency['agency_email'],
            ];
        }
        
        // ترجمه نام استان‌ها بر اساس زبان سایت
        $provinces_names = [];
        foreach ($this->get_provinces_options() as $code => $name) {
            $provinces_names[$code] = __($name, 'petrona');
        }
        
        // تعیین استان فعال - اگر کاربر انتخاب نکرده باشد، اولین استان دارای نمایندگی را انتخاب می‌کنیم
        $active_province = $settings['active_province'];
        if (empty($active_province) && !empty($agencies_by_province)) {
            $active_province = array_key_first($agencies_by_province);
        }
        
        // تنظیمات برای اسکریپت
        $map_config = [
            'mapTitle' => $settings['map_title'],
            'agenciesTitle' => $settings['agencies_title'],
            'noAgenciesText' => $settings['no_agencies_text'],
            'zoomLevel' => $settings['map_zoom']['size'],
            'activeProvince' => $active_province,
            'activeColor' => isset($settings['map_active_color']) ? $settings['map_active_color'] : '#fe651f',
            'hoverColor' => isset($settings['map_hover_color']) ? $settings['map_hover_color'] : '#f2b500',
            'defaultColor' => $settings['map_default_color'],
            'hasAgencyColor' => isset($settings['map_has_agency_color']) ? $settings['map_has_agency_color'] : '#5b9bd5',
            'borderColor' => isset($settings['map_province_border_color']) ? $settings['map_province_border_color'] : '#e7e7e7',
            'textColor' => isset($settings['map_text_color']) ? $settings['map_text_color'] : '#202020',
            'agencies' => $agencies_by_province,
            'provincesNames' => $provinces_names,
            'showMarkers' => $settings['show_markers'] === 'yes',
            'markerColor' => isset($settings['marker_color']) ? $settings['marker_color'] : '#0000ff',
            'markerSize' => isset($settings['marker_size']) ? $settings['marker_size']['size'] : 7,
            'provincesWithAgencies' => $provinces_with_agencies,
        ];
        
        // شناسه منحصر به فرد برای این ویجت
        $widget_id = 'iran-map-pro-' . $this->get_id();
        
        $map_config_json = htmlspecialchars(json_encode($map_config), ENT_QUOTES,'UTF-8');
        // محتوای اولیه نمایندگی‌ها
        $initial_agencies_html = '<p class="no-agency">' . esc_html($settings['no_agencies_text']) . '</p>';
        if (!empty($active_province) && !empty($agencies_by_province[$active_province])) {
            $initial_agencies_html = $this->generate_agencies_html($active_province, $agencies_by_province, $provinces_names);
        }
        ?>
        
        <div class="techt-map-container" id="<?php echo esc_attr($widget_id); ?>" data-config="<?php echo $map_config_json; ?>">
            <div class="techt-map-wrapper">
                <div class="map-container" style="width: 70%; float: left;"></div>
                <div class="agencies-container" style="width: 30%; float: left; padding: 15px;">
                    <h3><?php echo esc_html($settings['agencies_title']); ?></h3>
                    <div class="agencies-list">
                        <?php echo $initial_agencies_html; ?>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        
        <?php
        // add_action('wp_footer', function() use ($map_config, $widget_id) {
        //     $configs = array(
		// 		'config'      => wp_json_encode($map_config),
        //         'widgeId'     => esc_js($widget_id)
		// 	);

        //     wp_add_inline_script('elementor-frontend', 'if(typeof elementorFrontend !== "undefined"){elementorFrontend.config.configs=' . wp_json_encode($configs) . ';}');

        //     wp_add_inline_script('elementor-frontend', 'window.mAgencyWidgetFallbackConfig=' . wp_json_encode($configs) . ';');
        
        // });
        // $techt_map_agencies = apply_filters(
		// 	'techt_map_agencies_js_localize',
		// 	array(
		// 		'config'        => wp_json_encode($map_config),
        //         'widgeId'     => esc_js($widget_id)
		// 	)
		// );
		// wp_localize_script( 'techt-frontend-widget-scripts', 'techt_map_agencies_congigs', $techt_map_agencies );
    }

}

// اضافه کردن اسکریپت‌ها و استایل‌های لازم
// function enqueue_iran_map_highcharts_scripts_pro() {
//     // Highcharts و نقشه ایران
//     wp_register_script('highcharts', TECHT_MADULES_URL . '/public/assets/js/highcharts.js', [], false, true);
// 	wp_register_script('highcharts-map', TECHT_MADULES_URL . '/public/assets/js/map.js', ['highcharts'], false, true);
// 	wp_register_script('highcharts-iran-map', TECHT_MADULES_URL . '/public/assets/js/ir-all.js', ['highcharts-map'], false, true);
    
//     // اسکریپت اختصاصی ما
//     wp_enqueue_script('iran-map-highcharts-pro', plugin_dir_url(__FILE__) . 'assets/js/iran-map-highcharts-pro.js', ['jquery', 'highcharts', 'highcharts-map', 'iran-map-data'], '1.1', true);
    
//     // استایل‌ها
//     wp_enqueue_style('iran-map-highcharts-pro', plugin_dir_url(__FILE__) . 'assets/css/iran-map-highcharts-pro.css', [], '1.1');
// }
// add_action('wp_enqueue_scripts', 'enqueue_iran_map_highcharts_scripts_pro');

Plugin::instance()->widgets_manager->register(new Techt_Map_Agencies_3());