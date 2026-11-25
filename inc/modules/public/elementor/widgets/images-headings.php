<?php

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Techt Bubble Header
 *
 * widget that insert an embeddable content into the page, from any given URL.
 *
 * @since 1.0
 */
class Techt_Image_heading_Widget extends Widget_Base
{

	public function get_name()
	{
		return 'techt-image-headings';
	}

	public function get_title()
	{
		return esc_html__('Image Headings', 'petrona');
	}

	public function get_icon()
	{
		return 'eicon-heading';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

	/**
	 * Register Edu_Exp widget controls.
	 *
	 * @since 1.0
	 */
	protected function register_controls()
	{

		$this->start_controls_section(
			'social_info_section',
			[
				'label' => esc_html__('Headings', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'main_heading',
			[
				'label'       => esc_html__('Heading', 'petrona'),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => ['active' => true],
				'placeholder' => esc_html__('Enter your main heading here', 'petrona'),
				'default'     => esc_html__('Heading', 'petrona'),
			]
		);

		$this->add_control(
			'heading_backgrounds',
			[
				'label'       => esc_html__('Heading Background', 'petrona'),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_main_heading',
			[
				'label'     => esc_html__('Main Heading', 'petrona'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'main_heading!' => '',
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
				'selector' => '{{WRAPPER}} .techt-image-headings',
			]
		);
		$this->add_control(
			'mouse_effects',
			[
				'label' => esc_html__('Mouse Effects', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes', 'petrona'),
				'label_off' => esc_html__('No', 'petrona'),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'   => esc_html__('Alignment', 'petrona'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'petrona'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'petrona'),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'petrona'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Render Edu_Exp widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$alignHeadings = $settings['align'];

		if ($alignHeadings == 'left') {
			$alignClass = 'text-left';
		} elseif ($alignHeadings == 'center') {
			$alignClass = 'text-center';
		} elseif ($alignHeadings == 'right') {
			$alignClass = 'text-right';
		} else {
			$alignClass = 'text-center';
		} ?>
		<div class="techt-image-title techt-title-heading <?php echo esc_attr($alignClass); ?>" data-mouse="<?php echo esc_attr($settings['mouse_effects']); ?>">
			<h2 class="techt-image-headings techt-title" style="background-image: url(<?php echo esc_url($settings['heading_backgrounds']['url']); ?>)"><?php echo esc_html($settings['main_heading']); ?></h2>
		</div>
<?php
	}
}

Plugin::instance()->widgets_manager->register(new Techt_Image_heading_Widget());
