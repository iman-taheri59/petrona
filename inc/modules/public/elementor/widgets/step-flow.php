<?php

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Fun Facts widget.
 *
 * Elementor widget that displays an escalating progressbar bar.
 *
 * @since 1.0.0
 */
class Techt_Step_Flow extends Widget_Base
{

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
	public function get_name()
	{
		return 'techt-step-flow';
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
	public function get_title()
	{
		return esc_html__('Step Flow', 'petrona');
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
	public function get_icon()
	{
		return 'eicon-flow';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

	/**
	 * Register progressbar widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_funfacts',
			[
				'label' => esc_html__('Step Flow', 'petrona'),
			]
		);

		$this->add_control(
			'layout_style',
			[
				'label' => esc_html__( 'Select Layout', 'petrona' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'techt-step-layout-1',
				'options' => [
					'techt-step-layout-1' => esc_html__( 'Layout 1', 'petrona' ),
					'techt-step-layout-2' => esc_html__( 'Layout 2', 'petrona' ),
				],
			]
		);
		$this->add_control(
			'selected_icon',
			[
				'label' => __('Icon', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid'
				]
			]
		);

		$this->add_control(
			'badge',
			[
				'label' => __('Badge', 'petrona'),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Badge', 'petrona'),
				'description' => __('Keep it blank, if you want to remove the Badge', 'petrona'),
				'default' => __('Step 1', 'petrona'),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Title & Description', 'petrona'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __('Title', 'petrona'),
				'default' => __('Start Marketing', 'petrona'),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __('Description', 'petrona'),
				'show_label' => false,
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __('Description', 'petrona'),
				'default' => __('consectetur adipiscing elit, sed do<br>eiusmod Lorem ipsum dolor sit amet,<br> consectetur.', 'petrona'),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'petrona'),
				'type' => Controls_Manager::URL,
				'placeholder' => '#',
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __('Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
				'separator' => 'before',
				'options' => [
					'left' => [
						'title' => __('Left', 'petrona'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'petrona'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __('Right', 'petrona'),
						'icon' => 'fa fa-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}};'
				]
			]
		);


		$this->add_control(
			'show_indicator',
			[
				'label' => __('Show Direction', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'petrona'),
				'label_off' => __('No', 'petrona'),
				'return_value' => 'yes',
				'default' => 'yes',
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'show_indicator_mobile',
			[
				'label' => __('Show Direction on Mobile?', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'petrona'),
				'label_off' => __('No', 'petrona'),
				'return_value' => 'yes',
				'default' => 'no',
				'style_transfer' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'box_style',
			[
				'label' => __('Box', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'box_padding',
			[
				'label' => __('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .techt-step-flow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => __('Icon', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Size', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-steps-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label' => __('Padding', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __('Bottom Spacing', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'icon_border',
				'label' => __('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .techt-steps-icon',
			]
		);

		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} .techt-steps-icon',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-steps-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .techt-steps-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_color',
			[
				'label' => __('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-steps-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => __('Badge', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'badge!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => __('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'badge!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'badge_offset_toggle',
			[
				'label' => __('Offset', 'petrona'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __('None', 'petrona'),
				'label_on' => __('Custom', 'petrona'),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'badge_offset_y',
			[
				'label' => __('Vertical Offset', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 400,
						'step' => 1,
					],
					'%' => [
						'min' => -50,
						'max' => 150,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .techt-steps-label' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_offset_x',
			[
				'label' => __('Horizontal Offset', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 400,
						'step' => 1,
					],
					'%' => [
						'min' => -50,
						'max' => 150,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .techt-steps-label' => is_rtl() ? 'right: {{SIZE}}{{UNIT}};' : 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'badge_border',
				'label' => __('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .techt-steps-label',
				'condition' => [
					'badge!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'condition' => [
					'badge!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => __('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'badge!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background_color',
			[
				'label' => __('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'badge!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-label' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'selector' => '{{WRAPPER}} .techt-steps-label',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'condition' => [
					'badge!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_title_style',
			[
				'label' => __('Title & Description', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'_heading_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Title', 'petrona'),
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __('Bottom Spacing', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-steps-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_link_color',
			[
				'label' => __('Link Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'link[url]!' => ''
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => __('Hover Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'link[url]!' => ''
				],
				'selectors' => [
					'{{WRAPPER}} .techt-steps-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .techt-steps-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .techt-steps-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'heading_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Description', 'petrona'),
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'description_padding',
			[
				'label' => __('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .techt-step-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-step-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'description_shadow',
				'selector' => '{{WRAPPER}} .techt-step-description',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .techt-step-description',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_direction_style',
			[
				'label' => __('Direction', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'direction_style',
			[
				'label' => __('Style', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => __('Solid', 'petrona'),
					'dotted' => __('Dotted', 'petrona'),
					'dashed' => __('Dashed', 'petrona'),
				],
				'selectors' => [
					'{{WRAPPER}} .techt-step-arrow, {{WRAPPER}} .techt-step-arrow:after' => 'border-top-style: {{VALUE}};',
					'{{WRAPPER}} .techt-step-arrow:after' => is_rtl() ? 'border-left-style: {{VALUE}};' : 'border-right-style: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'direction_width',
			[
				'label' => __('Width', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .techt-step-arrow' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'direction_offset_toggle',
			[
				'label' => __('Offset', 'petrona'),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __('None', 'petrona'),
				'label_on' => __('Custom', 'petrona'),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'direction_offset_y',
			[
				'label' => __('Vertical Offset', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 400,
						'step' => 1,
					],
					'%' => [
						'min' => -50,
						'max' => 150,
					],
				],
				'condition' => [
					'direction_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .techt-step-arrow' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'direction_offset_x',
			[
				'label' => __('Horizontal Offset', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 400,
						'step' => 1,
					],
					'%' => [
						'min' => -50,
						'max' => 150,
					],
				],
				'condition' => [
					'direction_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .techt-step-layout-1 .techt-step-arrow' => is_rtl() ? 'right: {{SIZE}}{{UNIT}};' : 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .techt-step-layout-2 .techt-step-arrow' => is_rtl() ? 'right: calc( 100% + {{SIZE}}{{UNIT}} );' : 'left: calc( 100% + {{SIZE}}{{UNIT}} );',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'direction_color',
			[
				'label' => __('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .techt-step-arrow' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .techt-step-arrow:after' => 'border-color: {{VALUE}};',
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
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$layout = $settings['layout_style'];
		$hide_arrow_on_mobile = $settings['show_indicator_mobile'] === 'no' ? ' d-none d-sm-block' : '';
		$this->add_inline_editing_attributes('title', 'basic');
		$this->add_render_attribute('title', 'class', 'techt-steps-title');

		$this->add_inline_editing_attributes('description', 'intermediate');
		$this->add_render_attribute('description', 'class', 'techt-step-description');

		$this->add_render_attribute('badge', 'class', 'techt-steps-label');
		$this->add_inline_editing_attributes('badge', 'none');

		if ($settings['link']['url']) {
			$this->add_inline_editing_attributes('link', 'basic', 'title');
			$this->add_render_attribute('link', 'href', esc_url($settings['link']['url']));
			if (!empty($settings['link']['is_external'])) {
				$this->add_render_attribute('link', 'target', '_blank');
			}
			if (!empty($settings['link']['nofollow'])) {
				$this->set_render_attribute('link', 'rel', 'nofollow');
			}
		} else {
			$this->add_inline_editing_attributes('title', 'basic');
		}
		?>
		<div class="techt-step-flow-wrapper <?php echo $layout; ?>" data-animate="hg-fadeInUp">
		<?php
		if($layout == 'techt-step-layout-1'){
			?>
			<div class="techt-step-flow">
				<?php if ($settings['badge']) : ?>
					<span <?php $this->print_render_attribute_string('badge'); ?>><?php echo esc_html($settings['badge']); ?></span>
				<?php endif; ?>
				<div class="techt-steps-icon elementor-icon">
					<?php if (!empty($settings['selected_icon'])) :
						// \Techt_Core_Utility::render_icon($settings, 'selected_icon');
						\Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
					endif; ?>
				</div>
				<div class="techt-step-content">
					<h2 <?php $this->print_render_attribute_string('title'); ?>>
						<?php if (!empty($settings['link']['url'])) : ?>
							<a <?php $this->print_render_attribute_string('link'); ?>><?php echo wp_kses_post($settings['title']); ?></a>
						<?php else : ?>
							<?php echo wp_kses_post($settings['title']); ?>
						<?php endif; ?>
					</h2>

					<?php if ($settings['description']) : ?>
						<p <?php $this->print_render_attribute_string('description'); ?>><?php echo wp_kses_post($settings['description']); ?></p>
					<?php endif; ?>
				</div>
				<?php if ($settings['show_indicator'] === 'yes') : ?>
					<div class="techt-step-arrow <?php echo $hide_arrow_on_mobile; ?>"></div>
				<?php endif; ?>
			</div>
				
			<?php
		}elseif($layout == 'techt-step-layout-2'){
			?>
				<div class="techt-steps-icon">
					<?php if ($settings['show_indicator'] === 'yes') : ?>
						<div class="techt-step-arrow <?php echo $hide_arrow_on_mobile; ?>"></div>
					<?php endif; ?>

					<?php if (!empty($settings['selected_icon'])) :
						\Techt_Core_Utility::render_icon($settings, 'selected_icon');
					endif; ?>

					<?php if ($settings['badge']) : ?>
						<span <?php $this->print_render_attribute_string('badge'); ?>><?php echo esc_html($settings['badge']); ?></span>
					<?php endif; ?>
				</div>

				<h2 <?php $this->print_render_attribute_string('title'); ?>>
					<?php if (!empty($settings['link']['url'])) : ?>
						<a <?php $this->print_render_attribute_string('link'); ?>><?php echo wp_kses_post($settings['title']); ?></a>
					<?php else : ?>
						<?php echo wp_kses_post($settings['title']); ?>
					<?php endif; ?>
				</h2>

				<?php if ($settings['description']) : ?>
					<p <?php $this->print_render_attribute_string('description'); ?>><?php echo wp_kses_post($settings['description']); ?></p>
				<?php endif; ?>
			<?php
		}
		?>
		</div>
		<?php
	}
} // end class

Plugin::instance()->widgets_manager->register(new Techt_Step_Flow());
