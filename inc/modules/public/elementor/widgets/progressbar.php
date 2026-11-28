<?php
namespace Elementor;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor progressbar widget.
 *
 * Elementor widget that displays an escalating progressbar bar.
 *
 * @since 1.0.0
 */
class Techt_Progressbar extends Widget_Base {

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
		return 'techt-progressbar';
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
		return esc_html__( 'Progress Bar', 'petrona' );
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
		return 'eicon-skill-bar';
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
			'section_progressbar',
			[
				'label' => esc_html__( 'Progress Bar', 'petrona' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'petrona' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'petrona' ),
				'default' => esc_html__( 'Design', 'petrona' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'percent',
			[
				'label' => esc_html__( 'Percentage', 'petrona' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'show_percent',
			[
				'label' => __( 'Show Percent Sign', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'petrona' ),
				'label_off' => __( 'Hide', 'petrona' ),
				'return_value' => 'true',
				'default' => 'true',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'progress_style',
			[
				'label' => esc_html__( 'Progress Bar', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bar_height',
			[
				'label' => __( 'Height', 'petrona' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 5,
				'selectors' => [
					'{{WRAPPER}} .progress .progress-bar' => 'height: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'bar_bg_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '#fe651f',
				'selectors' => [
					'{{WRAPPER}} .progress .progress-bar' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'progress_value_style',
			[
				'label' => esc_html__( 'Value', 'petrona' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'value_margin',
			[
				'label' => esc_html__( 'Margin', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .progress .techt-progress-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'value_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .progress .techt-progress-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'value_color',
			[
				'label' => esc_html__( 'Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress .techt-progress-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'selector' => '{{WRAPPER}} .progress .techt-progress-value',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'progress_var_title',
			[
				'label' => esc_html__( 'Title', 'petrona' ),
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
					'{{WRAPPER}} .progress .techt-progress-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'petrona' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .progress .techt-progress-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'progress_bar_title_color',
			[
				'label' => esc_html__( 'Text Color', 'petrona' ),
				'type' => Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .techt-progress-title' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .techt-progress-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
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
		$sign = '%';
		if($settings['show_percent'] != 'true'){
			$sign = '';
		}
		?>
		<div class="progress" data-progress-value=<?php echo esc_attr( $settings['percent']['size'] ); echo $sign;?> data-progress-width="<?php echo esc_attr( $settings['percent']['size'] );?>%">
			<?php if ( ! empty( $settings['title'] ) ) { ?>
            <h3 class="techt-progress-title"><?php echo esc_html($settings['title']); ?></h3>
            <?php } ?>
            <figure class="techt-progress-value"></figure>
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?php echo esc_attr( $settings['percent']['size'] ); ?>"></div>
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
		?>
			<# var sign = '%';
				if(settings.show_percent !== 'true'){
					sign = '';
				}
			#>
			<div class="progress" data-progress-value="{{settings.percent.size}}{{sign}}" data-progress-width="{{ settings.percent.size }}%">
				<# if( settings.title ) { #>
	            <h3 class="techt-progress-title">{{{ settings.title }}}</h3>
	            <# } #>
	            <figure class="techt-progress-value"></figure>
	            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="{{ settings.percent.size }}%"></div>
	        </div>

		<?php
	}

} // end class

Plugin::instance()->widgets_manager->register( new Techt_Progressbar() );
