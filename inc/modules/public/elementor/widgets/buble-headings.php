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
class Techt_Buble_heading_Widget extends Widget_Base {

	public function get_name() {
		return 'techt-buble-headings';
	}

	public function get_title() {
		return esc_html__( 'Bubble Headings', 'petrona' );
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
			'main_heading_color',
			[
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .techt-bubble-border-title' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .techt-bubble-border-title',
			]
		);

		$this->add_control(
			'devider_colors',
			[
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .techt-title .title-divider:before' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .techt-title .title-divider:after' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .techt-title .title-divider span:nth-child(1)' => 'border-right-color: {{VALUE}} !important;',
					'{{WRAPPER}} .techt-title .title-divider span:nth-child(2)' => 'border-right-color: {{VALUE}} !important;',
					'{{WRAPPER}} .techt-title .techt-bubble-border i' => 'background-color: {{VALUE}} !important;',
					'{{WRAPPER}} .techt-title .techt-bubble-border i:nth-child(5):after' => 'border-color: {{VALUE}} transparent transparent transparent !important;',
				],
				'condition' => [
					'main_heading!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'filter_elemets_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-bubble-border' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		} ?>
		<div class="techt-title-heading techt-title <?php echo esc_attr( $alignClass ); ?>">
		    <h2 class="techt-bubble-border techt-bubble-border-title"><?php echo esc_html( $settings['main_heading'] ); ?></h2>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Techt_Buble_heading_Widget() );