<?php
namespace Elementor;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/**
 *
 * @since 1.0
 */

class Techt_Coming_Soon_Counter_Widget extends Widget_Base {

	public function get_name() {
		return 'techt-coming-soon-counter';
	}

	public function get_title() {
		return esc_html__( 'Count Down Timer', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-clock';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	/**
	 * Register Service widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'years', [
				'label' => esc_html__( 'Year', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);		

		$this->add_control(
			'months', [
				'label' => esc_html__( 'Months', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);			

		$this->add_control(
			'days', [
				'label' => esc_html__( 'Days', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'hours', [
				'label' => esc_html__( 'Hours', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);	

		$this->add_control(
			'minutes', [
				'label' => esc_html__( 'Minutes', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
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
			'number_section_style',
			[
				'label' => esc_html__( 'Numbers Style', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'numbers_color',
			[
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .commingsoon-count .tab-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_numbers_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .commingsoon-count .tab-val',
			]
		);

		$this->add_responsive_control(
			'numbers_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .commingsoon-count .timer-body-block .table-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_section_style',
			[
				'label' => esc_html__( 'Text Style', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .commingsoon-count .tab-unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_text_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector' => '{{WRAPPER}} .commingsoon-count .tab-unit',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render Service widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render() { 
		$settings = $this->get_settings_for_display(); 
		$lang = is_rtl() ? 'per' : 'eng';
		?>
		<div class="commingsoon-count pd-t-10 pd-b-60" data-lang="<?php echo $lang ?>" data-year="<?php echo esc_attr( $settings['years'] ); ?>" data-month="<?php echo esc_attr( $settings['months'] ); ?>" data-day="<?php echo esc_attr( $settings['days'] ); ?>" data-hour="<?php echo esc_attr( $settings['hours'] ); ?>" data-minutes="<?php echo esc_attr( $settings['minutes'] ); ?>"></div><!-- /.defaultCountdown -->

	<?php }
}

Plugin::instance()->widgets_manager->register( new Techt_Coming_Soon_Counter_Widget() );