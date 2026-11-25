<?php
namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 * Techt Bubble Header
 *
 * widget that insert an embeddable content into the page, from any given URL.
 *
 * @since 1.0
 */
class Techt_Stocks_heading_Widget extends Widget_Base {

	public function get_name() {
		return 'techt-stock-headings';
	}

	public function get_title() {
		return esc_html__( 'Stock Headings', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-heading';
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
			'main_heading',
			[
				'label'       => esc_html__( 'Heading', 'petrona' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'Enter your main heading here', 'petrona' ),
				'default'     => esc_html__( 'Heading', 'petrona' ),
			]
		);

		$this->add_control(
			'heading_type',
			[
				'label' => esc_html__( 'Heading Type', 'petrona' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'heading_shadow',
				'options' => [
					'heading_shadow'  => esc_html__( 'Shadow', 'petrona' ),
					'stock_shadow' => esc_html__( 'Stock Shadow', 'petrona' ),
					'halftone_normal' => esc_html__( 'Halftone', 'petrona' ),
					'halftone_color' => esc_html__( 'Halftone Color', 'petrona' ),
				],
			]
		);	


		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
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
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_main_heading',
			[
				'label'     => esc_html__( 'Main Heading', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'main_heading!' => '',
				],
			]
		);

		$this->add_control(
			'titles_colors',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0)',
				'selectors' => [
					'{{WRAPPER}} .techt-stock-headings' => 'color: {{VALUE}}',
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
				'selector' => '{{WRAPPER}} .techt-stock-headings',
			]
		);

		$this->add_control(
			'titles_stock_colors',
			[
				'label' => esc_html__( 'Text Stock Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0d1b1e',
				'selectors' => [
					'{{WRAPPER}} .techt-stock-headings' => '-webkit-text-stroke-color: {{VALUE}}; -moz-text-stroke-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_inputs_size',
			[
				'label' => esc_html__( 'Stock Width', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 5,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-stock-headings' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}}; -moz-text-stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => esc_html__( 'Text Shadow', 'petrona' ),
				'selector' => '{{WRAPPER}} .techt-stock-headings',
				'condition'	=> [
					'heading_type' => ['stock_shadow', 'heading_shadow'],
				]
			]
		);

		$this->add_control(
			'halftone_color_bg',
			[
				'label' => esc_html__( 'Halftone Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-stock-headings.heading-halftone.heading-halftone-color:after' => 'background-color: {{VALUE}};',
				],
				'condition'	=> [
					'heading_type' => 'halftone_color',
				]
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
		$settings = $this->get_settings_for_display();
		$alignHeadings = $settings['align'];

		if( $alignHeadings == 'left' ) {
			$alignClass = 'text-left';
		} elseif ( $alignHeadings == 'center'  ) {
			$alignClass = 'text-center';
		} elseif ( $alignHeadings == 'right' ) {
			$alignClass = 'text-right';
		} else {
			$alignClass = 'text-center';
		} 

		if( $settings['heading_type'] == 'stock_shadow'  ) {
			$heading_class = 'stroke-shadow';
			$data_content = ''; 
		} elseif( $settings['heading_type'] == 'halftone_normal'  ) {
			$heading_class = 'heading-halftone';
			$data_content = $settings['main_heading']; 
		} elseif( $settings['heading_type'] == 'halftone_color'  ) {
			$heading_class = 'heading-halftone heading-halftone-color';
			$data_content = $settings['main_heading']; 
		} else {
			$heading_class = 'heading-shadow';
			$data_content = ''; 
		} ?>
		<div class="techt-stock-title techt-title-heading <?php echo esc_attr( $alignClass ); ?>">
		    <h2 class="techt-stock-headings techt-title <?php echo esc_attr( $heading_class ); ?>" data-content="<?php echo esc_attr($data_content); ?>"><?php echo esc_html( $settings['main_heading'] ); ?></h2>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Techt_Stocks_heading_Widget() );