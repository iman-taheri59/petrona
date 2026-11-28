<?php

namespace Elementor;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Breakpoints\Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Pinto Portfolio Widget.
 *
 * Pinto widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0
 */

class Techt_Blog_Grids_Widget extends Techt_Base
{

	public function get_name()
	{
		return 'techt-blog-grids';
	}

	public function get_title()
	{
		return esc_html__('Blog Posts', 'petrona');
	}

	public function get_icon()
	{
		return 'eicon-gallery-grid';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

	/**
	 * Register Portfolio widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls()
	{

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__('Common Settings', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'number',
			[
				'label' => esc_html__('Total Post', 'petrona'),
				'type' => Controls_Manager::NUMBER,
				'default' => 12,
			]
		);

		$this->add_control(
			'number_grids',
			[
				'label' => esc_html__('Number Of Grids', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'three',
				'options' => [
					'one'  => esc_html__('One Grid', 'petrona'),
					'two' => esc_html__('Two Grid', 'petrona'),
					'three' => esc_html__('Three Grid', 'petrona'),
					'four' => esc_html__('Four Grid', 'petrona'),
				],
				'condition'	=> [
					'post_layout' => 'one',
				]
			]
		);

		$this->add_control(
			'layout_headings',
			[
				'label' => esc_html__('Layout Control', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_display_type',
			[
				'label' => esc_html__('Post Display', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'grid'  => esc_html__('Grid', 'petrona'),
					'carousel' => esc_html__('Carousel', 'petrona'),
				],
				'frontend_available' => true,
				'style_transfer' => true,
				'render' => 'none',
			]
		);

		$this->add_control(
			'post_layout',
			[
				'label' => esc_html__('Post Layout', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'one',
				'options' => [
					'one'  => esc_html__('Layout One', 'petrona'),
					'two' => esc_html__('Layout Two', 'petrona'),
				],
			]
		);

		$this->add_control(
			'show_featured_image',
			[
				'label' => esc_html__('Show Featured Images', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link_icon',
			[
				'label' => __( 'Link Icon', 'petrona' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'techt-icon-new-window',
					'library' => 'techt-icons'
				],
				'condition'	=> [
					'show_featured_image' => 'yes',
				]
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__('Show Title', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cate',
			[
				'label' => esc_html__('Show Category', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'show_content',
			[
				'label' => esc_html__('Show Content', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'content_words',
			[
				'label' => esc_html__('Display Words', 'petrona'),
				'type' => Controls_Manager::NUMBER,
				'default' => 40,
				'condition'	=> [
					'show_content' => 'yes',
				]
			]
		);

		$this->add_control(
			'show_post_meta',
			[
				'label' => esc_html__('Show Post Meta', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'post_meta_locatin',
			[
				'label' => esc_html__('Post Meta Location', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'after_excerpt',
				'options' => [
					'before_image'  => esc_html__('Before Feature Image', 'petrona'),
					'before_title' => esc_html__('Before Title', 'petrona'),
					'before_excerpt' => esc_html__('Before Excerpt', 'petrona'),
					'after_excerpt' => esc_html__('After Excerpt', 'petrona'),
				],
				'condition'	=> [
					'show_post_meta' => 'yes',
					'post_layout' => 'one',
				]
			]
		);
		$this->add_control(
			'author_icon',
			[
				'label' => __( 'Post Author Icon', 'petrona' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'techt-icon-user',
					'library' => 'techt-icons'
				],
				'condition'	=> [
					'show_post_meta' => 'yes',
				]
			]
		);
		$this->add_control(
			'date_icon',
			[
				'label' => __( 'Post Date Icon', 'petrona' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'techt-icon-calendar',
					'library' => 'techt-icons'
				],
				'condition'	=> [
					'show_post_meta' => 'yes',
				]
			]
		);
		$this->add_control(
			'show_read_more',
			[
				'label' => esc_html__('Show Read More Button', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition'	=> [
					'post_layout' => 'one',
				]
			]
		);
		$this->add_control(
			'read_more_text',
			[
				'label' => esc_html__( 'Read More Button Text', 'petrona' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read...', 'petrona' ),
				'condition'	=> [
					'show_read_more' => 'yes',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_shortings',
			[
				'label' => esc_html__('Query', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_types',
			[
				'label' => esc_html__('Choose Post Type', 'petrona'),
				'type' => Controls_Manager::SELECT2,
				'default' => 'post',
				'options' => \Techt_Core_Utility::get_post_type(),
				'multiple' => true,
			]
		);

		$this->add_control(
			'tax_query',
			[
				'label' => esc_html__('Taxonomies', 'petrona'),
				'type' => Controls_Manager::SELECT2,
				'options' => \Techt_Core_Utility::get_taxonomy(),
				'multiple' => true,
				'label_block' => true
			]
		);

		$this->add_control(
			'post_in',
			[
				'label' => esc_html__('Post In', 'petrona'),
				'description' => esc_html__('Provide a comma separated list of Post IDs to display in the grid.', 'petrona'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'advanced',
			[
				'label' => esc_html__('Advanced', 'petrona'),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__('Order By', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'none' => esc_html__('No order', 'petrona'),
					'ID' => esc_html__('Post ID', 'petrona'),
					'author' => esc_html__('Author', 'petrona'),
					'title' => esc_html__('Title', 'petrona'),
					'date' => esc_html__('Published date', 'petrona'),
					'modified' => esc_html__('Modified date', 'petrona'),
					'parent' => esc_html__('By parent', 'petrona'),
					'rand' => esc_html__('Random order', 'petrona'),
					'comment_count' => esc_html__('Comment count', 'petrona'),
					'menu_order' => esc_html__('Menu order', 'petrona'),
					'post__in' => esc_html__('By include order', 'petrona'),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__('Order', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__('ASC', 'petrona'),
					'DESC' => esc_html__('DESC', 'petrona'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'around_style',
			[
				'label' => esc_html__( 'Around', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'item_bg',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .grid-layout',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .grid-layout'
			]
		);
		$this->add_responsive_control(
			'item_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .grid-layout' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .grid-layout',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'image_style',
			[
				'label' => esc_html__( 'Feature Image', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_featured_image' => 'yes',
				]
			]
		);
		
		$this->add_responsive_control(
			'image_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-thumb img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-thumb img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    =>'{{WRAPPER}} .grid-layout .post-thumb img',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} article .grid-layout .post-thumb a:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			)
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'service_overlay_style',
			[
				'label' => esc_html__( 'Cover', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'link_icon_color',
			[
				'label' => esc_html__( 'Link Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon svg' => 'fill: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'link_icon_bg_color',
			[
				'label' => esc_html__( 'Link Icon Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_around_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Link Icon Box Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Link Icon Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'link_icon_horiz_position',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Horizontal Position', 'petrona' ),
				'size_units' => [ 'px', '%'],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon' => 'left: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'link_icon_vertical_position',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Vertical Position', 'petrona' ),
				'size_units' => [ 'px', '%'],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'link_icon_border',
				'label' => esc_html__( 'Link Icon Border', 'petrona' ),
				'selector' => '{{WRAPPER}} .grid-layout .post-thumb a > .icon',
			]
		);
		$this->add_responsive_control(
			'link_icon_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-thumb a > .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background_color',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'fields_options' => [
					'background' => [
						'label' => __('Cover Color', 'petrona'),
					],
        		],
				'selector' => '{{WRAPPER}} article .grid-layout .post-thumb a:before',
			]
		);

		$this->end_controls_section();

		$condition = ['show_title' => 'yes'];
		$this->techt_basic_style_controls('title_style', __( 'Title', 'petrona' ),'.grid-layout .entry-title', $condition );

		$this->start_controls_section(
			'cate_style',
			[
				'label' => esc_html__( 'Category', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_cate' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'cate_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-category > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cate_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-category > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'cate_vertical_position',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Vertical Position', 'petrona' ),
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-category' => 'top: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'cate_horiz_position',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Horizontal Position', 'petrona' ),
				'size_units' => [ 'px', '%'],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 400,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-category' => 'right: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cate_typography',
				'selector' => '{{WRAPPER}} .grid-layout .post-category > a',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'cate_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    =>'{{WRAPPER}} .grid-layout .post-category > a',
			)
		);

		$this->add_responsive_control(
			'cate_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-category > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'cate_box_shadow',
				'selector' => '{{WRAPPER}} .grid-layout .post-category > a',
			)
		);
		$this->start_controls_tabs(
		    'tabs_cate_colors',
		    [
		        'separator' => 'before'
		    ]
		);
		$this->start_controls_tab(
			'tab_cate_normal',
			[
				'label' => __( 'Normal', 'petrona' ),
			]
		);
		$this->add_control(
			'cate_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-category > a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'cate_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-category > a' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_cate_hover',
			[
				'label' => __( 'Hover', 'petrona' ),
			]
		);
		$this->add_control(
			'cate_color_hover',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-category > a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'cate_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-category > a:hover' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$condition = ['show_content' => 'yes'];
		$this->techt_basic_style_controls('desciption_style', __( 'Description', 'petrona' ),'.grid-layout .entry-content', $condition );

		$this->start_controls_section(
			'meta_style',
			[
				'label' => esc_html__( 'Post Meta', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_post_meta' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'meta_content_align',
			[
				'label'   => esc_html__('Content Alignment', 'petrona'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta' => 'justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'meta_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'meta_width',
			array(
				'label'      => __( 'Width', 'petrona' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-meta' => 'width: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_control(
			'meta_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'meta_box_shadow',
				'selector' => '{{WRAPPER}} .grid-layout .post-meta',
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'meta_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector' 	  => '{{WRAPPER}} .grid-layout .post-meta',
			)
		);

		$this->add_responsive_control(
			'meta_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'meta_before_image_space',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Bottom Space', 'petrona' ),
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'post_meta_locatin' => 'before_image',
					'post_layout' => 'one',
				]
			]
		);
		$this->add_responsive_control(
			'meta_before_title_space',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Up Space', 'petrona' ),
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'post_meta_locatin' => 'before_title',
					'post_layout' => 'one',
				]
			]
		);
		$this->add_control(
			'meta_author',
			[
				'label' => esc_html__('Meta Author', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
			
		);
		$this->add_responsive_control(
			'meta_author_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-meta .entry-author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'meta_author_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta .entry-author i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .grid-layout .post-meta .entry-author svg' => 'fill: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'meta_author_icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .entry-author i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .grid-layout .entry-author svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'meta_author_icon_spacing',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Spacing', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .entry-author i' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .grid-layout .entry-author svg' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_author_typography',
				'selector' => '{{WRAPPER}} .grid-layout .entry-author > span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->add_control(
			'meta_author_color',
			[
				'label' => esc_html__( 'Name Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .entry-author > span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'meta_date',
			[
				'label' => esc_html__('Meta Date', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'meta_date_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .post-meta .entry-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_control(
			'meta_date_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta .entry-date i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .grid-layout .post-meta .entry-date svg' => 'fill: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'meta_date_icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta .entry-date i' => 'font-size: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .grid-layout .post-meta .entry-date svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'meta_date_icon_spacing',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Icon Spacing', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .post-meta .entry-date i' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .grid-layout .post-meta .entry-date svg' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_date_typography',
				'selector' => '{{WRAPPER}} .grid-layout .entry-date > span',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->add_control(
			'meta_date_color',
			[
				'label' => esc_html__( 'Date Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .entry-date > span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'meta_spacer',
			[
				'label' => esc_html__('Spacer', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'show_meta_spacer',
			[
				'label' => esc_html__('Show Spacer', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_responsive_control(
			'meta_spacer_width',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Width', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .meta-spacer' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'show_meta_spacer' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'meta_spacer_height',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Height', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 40,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .meta-spacer' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition'	=> [
					'show_meta_spacer' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'meta_spacer_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .meta-spacer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'	=> [
					'show_meta_spacer' => 'yes',
				]
			)
		);
		$this->add_control(
			'meta_spacer_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .meta-spacer' => 'background-color: {{VALUE}};',
				],
				'condition'	=> [
					'show_meta_spacer' => 'yes',
				]
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'read_more_style',
			[
				'label' => esc_html__( 'Read More Button', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'	=> [
					'show_read_more' => 'yes',
				]
			]
		);
		$this->add_responsive_control(
			'read_more_align',
			[
				'label'   => esc_html__('Alignment', 'petrona'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .grid-layout .read-more-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'read_more_padding',
			array(
				'label'      => __( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .btn-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'read_more_margin',
			array(
				'label'      => __( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .read-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'read_more_typography',
				'selector' => '{{WRAPPER}} .grid-layout .btn-read-more',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'read_more_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .grid-layout .btn-read-more',
			)
		);

		$this->add_responsive_control(
			'read_more_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .grid-layout .btn-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'read_more_box_shadow',
				'selector' => '{{WRAPPER}} .grid-layout .btn-read-more',
			)
		);
		$this->start_controls_tabs(
		    'tabs_read_more_colors',
		    [
		        'separator' => 'before'
		    ]
		);
		$this->start_controls_tab(
			'tab_read_more_normal',
			[
				'label' => __( 'Normal', 'petrona' ),
			]
		);
		$this->add_control(
			'read_more_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .btn-read-more' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'read_more_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .btn-read-more' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'read_more_cate_hover',
			[
				'label' => __( 'Hover', 'petrona' ),
			]
		);
		$this->add_control(
			'read_more_color_hover',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .btn-read-more:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'read_more_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .grid-layout .btn-read-more:hover' => 'background-color: {{VALUE}};'
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		/**
		 * Carousel Settings
		 */
		$this->start_controls_section(
			'carousel_settings',
			[
				'label' => esc_html__('Carousel Settings', 'petrona'),
				'condition'	=> [
					'post_display_type' => 'carousel',
				]
			]
		);

		$this->add_control(
			'custom_img_dimension',
			[
				'label' => esc_html__('Image Dimension', 'petrona'),
				'type' =>  Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__('Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. unit works only (px)', 'petrona'),
				'default' => [
					'width' => '',
					'height' => '',
				],
			]
		);

		$this->add_responsive_control(
			'items',
			[
				'label'  => __('Visible Items', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'default'  => ['size' => 3],
				'range' => [
					'px' => [
						'min'   => 1,
						'max'   => 10,
						'step'  => 1,
					],
				],
				'size_units'            => '',
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label'  => __('Item gap', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'default'  => ['size' => 10],
				'range' => [
					'px' => [
						'min'   => 1,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => '',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'                 => __('Autoplay', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => __('Yes', 'petrona'),
				'label_off'             => __('No', 'petrona'),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'                 => __('Autoplay Speed', 'petrona'),
				'type'                  => Controls_Manager::TEXT,
				'default'               => '2400',
				'title'                 => __('Enter carousel speed', 'petrona'),
			]
		);

		$this->add_control(
			'infinite_loop',
			[
				'label'                 => __('Infinite Loop', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => __('Yes', 'petrona'),
				'label_off'             => __('No', 'petrona'),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'grab_cursor',
			[
				'label'                 => __('Grab Cursor', 'petrona'),
				'description'           => __('Shows grab cursor when you hover over the slider', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'          => __('Show', 'petrona'),
				'label_off'         => __('Hide', 'petrona'),
				'return_value'      => 'yes',
			]
		);

		$this->add_control(
			'mouse_wheal',
			[
				'label'                 => __('Mouse Wheal', 'petrona'),
				'description'           => __('Enable Mouse Wheal', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'          => __('Show', 'petrona'),
				'label_off'         => __('Hide', 'petrona'),
				'return_value'      => 'yes',
			]
		);

		$this->add_control(
			'center_slides',
			[
				'label'                 => __('Center Slide', 'petrona'),
				'description'           => __('Enable Center Slide', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'          => __('Show', 'petrona'),
				'label_off'         => __('Hide', 'petrona'),
				'return_value'      => 'yes',
			]
		);

		$this->add_control(
			'navigation_heading',
			[
				'label'                 => __('Navigation', 'petrona'),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'arrows',
			[
				'label'                 => __('Arrows', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => __('Yes', 'petrona'),
				'label_off'             => __('No', 'petrona'),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'                 => __('Pagination', 'petrona'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'label_on'              => __('Yes', 'petrona'),
				'label_off'             => __('No', 'petrona'),
				'return_value'          => 'yes',
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label'                 => __('Pagination Type', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'bullets',
				'options'               => [
					'bullets'       => __('Dots', 'petrona'),
					'fraction'      => __('Fraction', 'petrona'),
				],
				'condition'             => [
					'dots'          => 'yes',
				],
			]
		);

		$this->add_control(
			'direction',
			[
				'label'                 => __('Direction', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'left',
				'options'               => [
					'left'       => __('Left', 'petrona'),
					'right'      => __('Right', 'petrona'),
				],
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Arrows
		 */
		$this->start_controls_section(
			'section_arrows_style',
			[
				'label'                 => __('Arrows', 'petrona'),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'arrows'       => 'yes',
				],
			]
		);

		$this->add_control(
			'arrow',
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
			]
		);
		// $this->add_control(
		// 	'arrow',
		// 	[
		// 		'label'                 => __('Choose Arrow', 'petrona'),
		// 		'type'                  => Controls_Manager::SELECT,
		// 		'label_block'           => false,
		// 		'default'               => 'fa fa-angle-right',
		// 		'options'               => [
		// 			'fa fa-angle-right'             => __('Angle', 'petrona'),
		// 			'fa fa-angle-double-right'      => __('Double Angle', 'petrona'),
		// 			'fa fa-chevron-right'           => __('Chevron', 'petrona'),
		// 			'fa fa-chevron-circle-right'    => __('Chevron Circle', 'petrona'),
		// 			'fa fa-arrow-right'             => __('Arrow', 'petrona'),
		// 			'fa fa-long-arrow-right'        => __('Long Arrow', 'petrona'),
		// 			'fa fa-caret-right'             => __('Caret', 'petrona'),
		// 			'fa fa-caret-square-o-right'    => __('Caret Square', 'petrona'),
		// 			'fa fa-arrow-circle-right'      => __('Arrow Circle', 'petrona'),
		// 			'fa fa-arrow-circle-o-right'    => __('Arrow Circle O', 'petrona'),
		// 			'fa fa-hand-o-right'            => __('Hand', 'petrona'),
		// 		],
		// 	]
		// );

		$this->add_responsive_control(
			'arrows_size',
			[
				'label'                 => __('Arrows Size', 'petrona'),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => ['size' => '22'],
				'range'                 => [
					'px' => [
						'min'   => 15,
						'max'   => 100,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'left_arrow_position',
			[
				'label'                 => __('Horizental Align Left Arrow', 'petrona'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => -100,
						'max'   => 40,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'selectors'         => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'right_arrow_position',
			[
				'label'                 => __('Horizental Align Right Arrow', 'petrona'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => -100,
						'max'   => 40,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'selectors'         => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_vertical_position',
			[
				'label'   => __('Vertical Align Arrows', 'petrona'),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'range'   => [
					'%' => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					],
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
				],
				'size_units' => ['%', 'px'],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors'         => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_arrows_style');

		$this->start_controls_tab(
			'tab_arrows_normal',
			[
				'label'                 => __('Normal', 'petrona'),
			]
		);

		$this->add_control(
			'arrows_bg_color_normal',
			[
				'label'                 => __('Background Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_color_normal',
			[
				'label'                 => __('Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'arrows_border_normal',
				'label'                 => __('Border', 'petrona'),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button'
			]
		);

		$this->add_control(
			'arrows_border_radius_normal',
			[
				'label'                 => __('Border Radius', 'petrona'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%'],
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			[
				'label'                 => __('Hover', 'petrona'),
			]
		);

		$this->add_control(
			'arrows_bg_color_hover',
			[
				'label'                 => __('Background Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_color_hover',
			[
				'label'                 => __('Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_border_color_hover',
			[
				'label'                 => __('Border Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			[
				'label'                 => __('Padding', 'petrona'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%'],
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .elementor-swiper-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Pagination: Dots
		 */
		$this->start_controls_section(
			'section_dots_style',
			[
				'label'                 => __('Pagination: Dots', 'petrona'),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label'                 => __('Position', 'petrona'),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'inside'     => __('Inside', 'petrona'),
					'outside'    => __('Outside', 'petrona'),
				],
				'default'               => 'outside',
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_responsive_control(
			'dots_size',
			[
				'label'                 => __('Size', 'petrona'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 2,
						'max'   => 40,
						'step'  => 1,
					],
				],
				'size_units'            => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_responsive_control(
			'dots_spacing',
			[
				'label'                 => __('Spacing', 'petrona'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 1,
						'max'   => 30,
						'step'  => 1,
					],
				],
				'size_units'            => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->start_controls_tabs('tabs_dots_style');

		$this->start_controls_tab(
			'tab_dots_normal',
			[
				'label'                 => __('Normal', 'petrona'),
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_control(
			'dots_color_normal',
			[
				'label'                 => __('Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_control(
			'active_dot_color_normal',
			[
				'label'                 => __('Active Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'dots_border_normal',
				'label'                 => __('Border', 'petrona'),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet',
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_control(
			'dots_border_radius_normal',
			[
				'label'                 => __('Border Radius', 'petrona'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%'],
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_responsive_control(
			'dots_margin',
			[
				'label'                 => __('Margin', 'petrona'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em', '%'],
				'allowed_dimensions'    => 'vertical',
				'placeholder'           => [
					'top'      => '',
					'right'    => 'auto',
					'bottom'   => '',
					'left'     => 'auto',
				],
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullets' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			[
				'label'                 => __('Hover', 'petrona'),
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_control(
			'dots_color_hover',
			[
				'label'                 => __('Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->add_control(
			'dots_border_color_hover',
			[
				'label'                 => __('Border Color', 'petrona'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .techt-blog-wrapper .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
				],
				'condition'             => [
					'dots'              => 'yes',
					'pagination_type'   => 'bullets',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function techt_basic_style_controls($control_id = null, $control_name = null, $control_selector = null, $condition = [] ){
        $this->start_controls_section(
            'techt_' . $control_id . '_styling',
            [
                'label' => esc_html__($control_name, 'petrona'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'	=> $condition,
            ]
        );
        $this->add_control(
            'techt_' . $control_id . '_color',
            [
                'label' => esc_html__('Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'techt_' . $control_id . '_bg_color',
            [
                'label' => esc_html__('Background Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'techt_' . $control_id . '_typography',
                'label' => esc_html__('Typography', 'petrona'),
                'selector' => '{{WRAPPER}} ' . $control_selector,
            ]
        );
        $this->add_responsive_control(
            'techt_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'petrona'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'techt_' . $control_id . '_margin',
            [
                'label' => esc_html__('Margin', 'petrona'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'techt_' . $control_id . '_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $control_selector,
			)
		);

		$this->add_responsive_control(
			'techt_' . $control_id . '_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $control_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'techt_' . $control_id . '_align',
			[
				'label'   => esc_html__('Alignment', 'petrona'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $control_selector => 'text-align: {{VALUE}};',
				],
			]
		);
        $this->end_controls_section();
    }
	/**
	 * Slider Settings.
	 *
	 * @access public
	 */
	public function slider_settings()
	{
		$settings = $this->get_settings();

		$slider_options = [
			'direction'              => 'horizontal',
			'speed'                  => 400,
			'slidesPerView'          => ($settings['items']['size'] !== '') ? absint($settings['items']['size']) : 3,
			'spaceBetween'           => ($settings['margin']['size'] !== '') ? $settings['margin']['size'] : 10,
			'grabCursor'             => ($settings['grab_cursor'] === 'yes'),
			'autoHeight'             => true,
			'loop'                   => ($settings['infinite_loop'] === 'yes'),
			'mousewheel'             => ($settings['mouse_wheal'] === 'yes'),
			'centeredSlides'         => ($settings['center_slides'] === 'yes'),
		];

		if ($settings['autoplay'] == 'yes' && !empty($settings['autoplay_speed'])) {
			$autoplay_speed = $settings['autoplay_speed'];
		} else {
			$autoplay_speed = 999999;
		}

		/**
		 * @since 1.0
		 */
		if (techt_is_elementor_version('>=', '2.9.0')) {
			$slider_options['handleElementorBreakpoints'] = true;
		}

		$slider_options['autoplay'] = [
			'delay'                  => $autoplay_speed
		];

		if ($settings['dots'] == 'yes') {
			$slider_options['pagination'] = [
				'el'                 => '.swiper-pagination-' . esc_attr($this->get_id()),
				'type'               => $settings['pagination_type'],
				'clickable'          => true,
			];
		}

		if ($settings['arrows'] == 'yes') {
			$slider_options['navigation'] = [
				'nextEl'             => '.swiper-button-next-' . esc_attr($this->get_id()),
				'prevEl'             => '.swiper-button-prev-' . esc_attr($this->get_id()),
			];
		}
		
		$slider_options['breakpoints'] = [
			\Elementor\Plugin::$instance->breakpoints->get_breakpoints()['tablet']->get_value() => [
				'slidesPerView'      => isset($settings['items_tablet']['size']) ? absint($settings['items_tablet']['size']) : 2,
				'spaceBetween'       => isset($settings['margin_tablet']['size']) ? $settings['margin_tablet']['size'] : 10,
			],
			\Elementor\Plugin::$instance->breakpoints->get_breakpoints()['mobile']->get_value() => [
				'slidesPerView'      => isset($settings['items_mobile']['size']) ? absint($settings['items_mobile']['size']) : 1,
				'spaceBetween'       => isset($settings['margin_mobile']['size']) ? $settings['margin_mobile']['size'] : 10,
			],
		];

		$this->add_render_attribute(
			'blog-feed-container',
			[
				'data-slider-settings' => wp_json_encode($slider_options),
			]
		);
	}

	/**
	 * Render insta feed carousel dots output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_dots()
	{
		$settings = $this->get_settings();

		if ($settings['dots'] == 'yes') { ?>
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

		if ($settings['arrows'] == 'yes') { ?>
			<?php
			if ($settings['arrow']) {
				$techt_next_arrow = $settings['arrow'];
				$techt_prev_arrow = str_replace("right", "left", $settings['arrow']);
			} else {
				$techt_next_arrow = 'fa fa-angle-right';
				$techt_prev_arrow = 'fa fa-angle-left';
			}
			?>
			<!-- Add Arrows -->
			<div class="elementor-swiper-button swiper-button-next swiper-button-next-<?php echo esc_attr($this->get_id()); ?>">
				<i class="<?php echo esc_attr($techt_next_arrow); ?>"></i>
			</div>
			<div class="elementor-swiper-button swiper-button-prev swiper-button-prev-<?php echo esc_attr($this->get_id()); ?>">
				<i class="<?php echo esc_attr($techt_prev_arrow); ?>"></i>
			</div>
		<?php }
	}
	protected function render_mata(){
		$settings = $this->get_settings_for_display();
		if($settings['show_post_meta'] == 'yes'){ ?>
			<div class="post-meta">
				<div class="entry-author">
					<?php \Elementor\Icons_Manager::render_icon( $settings['author_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<span><?php the_author_meta('display_name'); ?></span>
				</div>
				<?php if($settings['show_meta_spacer'] == 'yes'){ ?>
					<span class="meta-spacer"></span>
				<?php } ?>
				<div class="entry-date">
				<?php \Elementor\Icons_Manager::render_icon( $settings['date_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					<span><?php the_time(get_option('date_format')); ?></span>
				</div>
			</div><!-- /post-meta -->

		<?php }
	}

	/**
	 * Render Portfolio widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if ($settings['number_grids'] == 'one') {
			$grid_no = 'col-md-12';
		} elseif ($settings['number_grids'] == 'two') {
			$grid_no = 'col-md-6';
		} elseif ($settings['number_grids'] == 'three') {
			$grid_no = 'col-lg-4 col-md-6';
		} else {
			$grid_no = 'col-lg-3 col-md-6';
		}

		$query_args = \Techt_Core_Utility::query_args($settings);
		$blog_query = new \WP_Query($query_args);
		if ($blog_query->have_posts()) {
			if ($settings['post_display_type'] == 'grid') {
				require $this->get_widget_template( 'blog-normal' );
			} else {
				require $this->get_widget_template( 'blog-slider' );
			}
		}
	}
}

Plugin::instance()->widgets_manager->register(new Techt_Blog_Grids_Widget());
