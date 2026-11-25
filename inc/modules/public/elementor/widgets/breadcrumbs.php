<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Techt_Breadcrumbs_Widget extends Widget_Base {

	public function get_name() {
		return 'techt-breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Breadcrumbs', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
        return [ 'techt-category' ];
	}

	protected function register_controls() {
        $this->start_controls_section(
            'breadcrumbs_content',
            [
                'label' => esc_html__( 'Breadcrumbs', 'petrona' ),
                'description'   => esc_html__('Note: The content displayed in the editor may differ from the actual content.', 'petrona'),
            ]
        );

        $this->add_control(
            'alert',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__('Note: The content displayed in the editor may differ from the actual content.', 'petrona'),
                'separator' => 'after',
                
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'petrona' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'petrona' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'petrona' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'petrona' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => '',
                'selectors'  => array(
                    '{{WRAPPER}} .techt-breadcrumbs' => 'text-align: {{VALUE}};',
                )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'breadcrumbs_style',
            [
                'label' => esc_html__( 'Breadcrumbs', 'petrona' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs__link breadcrumbs__current',
                    '{{WRAPPER}} .breadcrumbs__current',
                ],
                
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'petrona' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .separator-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_color',
            [
                'label' => esc_html__( 'Link Color', 'petrona' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs__link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__( 'Link Hover Color', 'petrona' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs__link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'color_breadcrumb_active',
            [
                'label' => __( 'Current Breadcrumb Color', 'petrona' ),
                'type' => Controls_Manager::COLOR,
                'separator'    => 'before',
                'selectors' => [
                    '{{WRAPPER}} .breadcrumbs__current' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
	}

	public function render() {
        return \Techt_Core_Utility::techt_breadcrumbs();
	}
}
Plugin::instance()->widgets_manager->register( new Techt_Breadcrumbs_Widget );