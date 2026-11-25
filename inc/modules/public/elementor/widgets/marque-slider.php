<?php
namespace Elementor;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor marque slider widget.
 *
 * Elementor widget that displays an escalating progressbar bar.
 *
 * @since 1.0.0
 */
class Techt_Marque_slider extends Techt_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve progressbar widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'techt-marque-slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve progressbar widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Marque Slider', 'petrona' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve progressbar widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	/**
	 * Register progressbar widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_marque',
			[
				'label' => esc_html__( 'Marque', 'petrona' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
			'title',
			array(
				'label'     => esc_html__( 'Title', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'separator' => 'before',
				'dynamic'   => array( 'active' => true ),
			)
		);
        $repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'petrona' ),
				'type' => \Elementor\Controls_Manager::ICONS,
			]
		);
		$this->add_control(
			'item_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'                 => esc_html__( 'Item #1', 'petrona' ),
					),
                    array(
						'title'                 => esc_html__( 'Item #2', 'petrona' ),
					),
                    array(
						'title'                 => esc_html__( 'Item #3', 'petrona' ),
					),
                    array(
						'title'                 => esc_html__( 'Item #4', 'petrona' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'petrona' ),
			]
		);
		$this->add_control(
			'animation_direction',
			array(
				'label'   => esc_html__( 'Select Direction', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'scroll-right-left',
				'options' => array(
					'scroll-right-left' => esc_html__('Right to Left', 'petrona' ),
					'scroll-left-right' => esc_html__('Left to Right', 'petrona' ),
				),
			)
		);
		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'petrona' ),
				'label_off' => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_style',
			[
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'content_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'content_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .techt-marque-slider-wrapper',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'marque_title_style',
			[
				'label' => esc_html__( 'Text', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .text',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .text',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .text',
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'marque_icon_style',
			[
				'label' => esc_html__( 'Icon', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

        $this->add_responsive_control(
			'icon_size',
			[
				'type' => \Elementor\Controls_Manager::SLIDER,
				'label' => esc_html__( 'Size', 'petrona' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 30,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 25,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'selector' => '{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon',
			]
		);
		
        $this->add_control(
			'icon_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-marque-slider-wrapper ul.marque-list li .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
        
		$this->end_controls_section();
	}

	/**
	 * Render progressbar widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$hover_pause_class = $settings['pause_on_hover'] ? ' hover-pause' : '';
		?>
		<div class="techt-marque-slider-wrapper">
            <?php
            if ( $settings['item_list'] ) {
                echo '<ul class="marque-list '.$settings['animation_direction']. $hover_pause_class .'">';
                foreach (  $settings['item_list'] as $item ) {
                    echo '<li class="marque-item"> ';
                    echo '<span class="icon elementor-icon">';
				    \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
			        echo '</span>';
                    echo '<span class="text">' . $item['title'] . '</span>';
                    echo '</li>';
                }
				foreach (  $settings['item_list'] as $item ) {
                    echo '<li class="marque-item"> ';
                    echo '<span class="icon elementor-icon">';
				    \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] );
			        echo '</span>';
                    echo '<span class="text">' . $item['title'] . '</span>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
	    <?php
	}

	/**
	 * Render progressbar widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		
	}

} // end class

Plugin::instance()->widgets_manager->register( new Techt_Marque_slider() );
