<?php

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Border;

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
class Techt_Social_Share extends Widget_Base
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
		return 'techt-social-share';
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
		return esc_html__('Social Share', 'petrona');
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
		return 'eicon-social-icons';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

    protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'petrona' ),
			)
		);

		$this->add_control(
			'share_title',
			array(
				'label'     => esc_html__( 'Share Title', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
			)
		);

        $this->add_responsive_control(
			'share_title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-share-title' => 'text-align: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			array(
				'label'      => esc_html__( 'Title', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .techt-share-title',
			)
		);	
        $this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => array(
					'{{WRAPPER}} .techt-share-title' => 'color: {{VALUE}}',
				),
			)
		);
        $this->add_control(
			'title_gap',
			array(
				'label'      => esc_html__( 'Gap', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-share-title' => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}}' : 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'social_icons_style',
			array(
				'label'      => esc_html__( 'Social Icons', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'social_icon_normal_color',
			array(
				'label'     => esc_html__( 'Normal Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-social-share-link' => 'color: {{VALUE}}',
				),
			)
		);
        $this->add_control(
			'social_icon_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => array(
					'{{WRAPPER}} .techt-social-share-link:hover' => 'color: {{VALUE}}',
				),
			)
		);
        $this->add_control(
			'social_icon_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-social-share-link' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);
        $this->add_control(
			'buttons_gap',
			array(
				'label'      => esc_html__( 'Gap', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-social-share-link' => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}}' : 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);
		
		$this->end_controls_section();

        $this->start_controls_section(
			'buttons_style',
			array(
				'label'      => esc_html__( 'Buttons', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

        $this->add_responsive_control(
			'button_width',
			array(
				'label'      => esc_html__( 'Width', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 15,
						'max' => 60,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-social-share-link' => 'width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .techt-social-share-link' => 'height: {{SIZE}}{{UNIT}}'
				),
			)
		);
        $this->add_control(
			'buttons_normal_bg_color',
			array(
				'label'     => esc_html__( 'Normal Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => array(
					'{{WRAPPER}} .techt-social-share-link' => 'background: {{VALUE}}',
				),
			)
		);
        $this->add_control(
			'buttons_hover_bg_color',
			array(
				'label'     => esc_html__( 'Hover Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .techt-social-share-link:hover' => 'background: {{VALUE}}'
				),
			)
		);
        $this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'buttons_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'selector'    => '{{WRAPPER}} .techt-social-share-link',
			)
		);
        $this->add_control(
			'buttons_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-social-share-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
	protected function render()
	{
        $settings = $this->get_settings_for_display();

        ?>
        <div class="social-share">
			<span class="techt-share-title"><?php echo $settings['share_title'] ?></span>
			<?php techt_social_share_link() ?>
        </div>
        <?php
    }

}

Plugin::instance()->widgets_manager->register(new Techt_Social_Share());