<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Techt Bubble Header
 * @since 1.0
 */
class Techt_Video_Popup_btn_Widget extends Techt_Base {

	public function get_name() {
		return 'techt-video-popup-btn';
	}

	public function get_title() {
		return esc_html__( 'Video Popup Button', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-play-o';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	/**
	 * Register Edu_Exp widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'social_info_section',
			[
				'label' => esc_html__( 'Headings', 'petrona' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_link',
			[
				'label'       => esc_html__( 'Video URL', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Video URL', 'petrona' ),
				'default'     => 'https://www.aparat.com/embed/QZfUu',
			]
		);

		$this->add_control(
			'video_btn_icon',
			[
				'label' => esc_html__( 'Button Icon', 'petrona' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'techt-icon-play',
					'library' => 'petrona',
				],
			]
		);

		$this->add_responsive_control(
			'align_content',
			[
				'label'   => esc_html__( 'Details Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'prefix_class' => 'elementor-align%s-',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => esc_html__( 'Button', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => esc_html__( 'Button Background', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video-box .overlay-box span' => 'background-color: {{VALUE}}',
				],
			]
		);			
		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => esc_html__( 'Button Hover Background', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video-box .overlay-box span:hover' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'petrona' ),
				'selector' =>'{{WRAPPER}} .video-box .ripple, .video-box .ripple::before, .video-box .ripple::after',
			]
		);	

		$this->add_responsive_control(
			'button_size',
			[
				'label' => esc_html__( 'Button Size', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70,
				],
				'selectors' => [
					'{{WRAPPER}} .video-box .overlay-box span' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .video-box .overlay-box span',
			]
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Button Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .video-box .overlay-box span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		// $this->add_control(
		// 	'ripple_colors',
		// 	[
		// 		'label' => esc_html__( 'Ripple Color', 'petrona' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'default' => '#ffffff',
		// 		'selectors' => [
		// 			'{{WRAPPER}} .video-box .ripple, .video-box .ripple:before, .video-box .ripple:after' => 'color: {{VALUE}}',
		// 		],
		// 	]
		// );	
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video-box .overlay-box span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .video-box .overlay-box span svg' => 'fill: {{VALUE}}',
				],
			]
		);	

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .video-box .overlay-box span:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .video-box .overlay-box span:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .video-box .overlay-box span' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .video-box .overlay-box span svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
	protected function render() { 
		$settings = $this->get_settings_for_display(); ?>
		<?php if( $settings['video_link'] ) { ?>
			<div class="video-box">		
				<a href="<?php echo esc_url( $settings['video_link'] ); ?>" class="lightbox-image overlay-box"><span class="flaticon-media-play-symbol"><?php Icons_Manager::render_icon( $settings['video_btn_icon'], [ 'aria-hidden' => 'true' ] ); ?><i class="ripple"></i></span></a>
			</div><!--  /.video-box -->
		<?php } ?>
		
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Techt_Video_Popup_btn_Widget() );