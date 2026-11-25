<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
class Techt_Mega_Menu_Section_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'techt-mega-menu-section';
    }

    public function get_title()
    {
        return esc_html__('Mega Menu Section', 'petrona');
    }

    public function get_icon()
    {
        return 'eicon-archive-posts';
    }

    public function get_script_depends() {
		return array( 'hoverIntent' );
	}

    public function get_categories()
    {
        return ['techt-category'];
    }

    public function get_keywords()
    {
        return ['custom menu', 'nav', 'megamenu item', 'menu', 'header', 'petrona'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'general_section',
            [
                'label' => esc_html__('General', 'petrona'),
            ]
        );

        $this->add_control(
			'widget_title',
			[
				'label' => esc_html__( 'Title', 'petrona' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'petrona' ),
				'placeholder' => esc_html__( 'Type your title here', 'petrona' ),
			]
		);

        $repeater = new Repeater();
        $repeater->add_control(
           'icon',
            [
               'label' => esc_html__( 'Section Icon', 'petrona' ),
               'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        
        $repeater->add_control(
            'label', [
                'label' => __( 'Label', 'petrona' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'url', [
                'label' => __( 'URL (link)', 'petrona' ),
                'type' => Controls_Manager::TEXT,
                'default' => '#',
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'target',
            [
                'label' => esc_html__( 'Open in new window', 'petrona' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'petrona' ),
                'label_off' => esc_html__( 'Hide', 'petrona' ),
                'return_value' => 'yes',
                'label_on' => __( 'Yes', 'petrona' ),
                'label_off' => __( 'No', 'petrona' ),
                'default' => '',
            ]
        );

        $repeater->add_control(
            'badge', [
                'label' => __( 'Badge', 'petrona' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __( 'Items', 'petrona' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ label }}}',
                'separator' => 'before',
            ]
        );

        // $this->add_responsive_control(
        //     'links_padding',
        //     [
        //         'label' => __( 'Links padding', 'petrona' ),
        //         'type' => Controls_Manager::DIMENSIONS,
        //         'size_units' => [ 'px', 'em', '%' ],
        //         'selectors' => [
        //             '{{WRAPPER}} .custom-menu-item > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
        //         ]
        //     ]
        // );

        // $this->add_control(
        //     'links_border_radius',
        //     [
        //         'label' => __( 'Links border radius', 'petrona' ),
        //         'type' => Controls_Manager::DIMENSIONS,
        //         'size_units' => [ 'px', '%', 'em' ],
        //         'selectors' => [
        //             '{{WRAPPER}} .custom-menu-item > li > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //     ]
        // );

        // $this->add_control(
        //     'links_bg_color',
        //     [
        //         'label' => esc_html__('Background Color (Hover)', 'petrona'),
        //         'type' => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}} .custom-menu-item > li > a:hover' => 'background: {{VALUE}} !important;',
        //         ],
        //     ]
        // );
        

        $this->end_controls_section();

        // $this->techt_basic_style_controls('menu_typography', 'Typography & Color', '.mega-menu-item li a');

        $this->start_controls_section(
            'title_styling',
            [
                'label' => esc_html__('Title', 'petrona'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-short-title' => 'color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__('Background Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-short-title' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'petrona'),
                'selector' => '{{WRAPPER}} .techt-short-title',
            ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'petrona'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .techt-short-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'petrona'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .techt-short-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'title_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .techt-short-title',
			)
		);

		$this->add_responsive_control(
			'title_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .techt-short-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'title_align',
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
					'{{WRAPPER}} .techt-short-title' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'nav_items_style',
			array(
				'label'      => esc_html__( 'Items', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

        $this->add_responsive_control(
            'items_alignment',
            [
                'label' => __( 'Alignment', 'petrona' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'petrona' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'petrona' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'petrona' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mega-menu-item li a' => 'justify-content: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_spacing',
            [
                'label' => __( 'Links space bottom', 'petrona' ),
                'description' => __( 'Space between items', 'petrona' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mega-menu-item li:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mega-menu-item li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'nav_items_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'nav_items_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'nav_items_typography',
				'selector' => '{{WRAPPER}} .mega-menu-item li a > .title',
			)
		);

        $this->start_controls_tabs( 'tabs_nav_items_style' );

		$this->start_controls_tab(
			'nav_items_normal',
			array(
				'label' => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'nav_items_color',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a' => 'color: {{VALUE}}',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'nav_items_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .mega-menu-item li a',
			)
		);

		$this->add_responsive_control(
			'nav_items_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

        $this->add_control(
			'nav_items_bg',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'nav_items_icon_color',
			array(
				'label'  => esc_html__( 'Icon Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a > i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mega-menu-item li a > svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'nav_items_hover',
			array(
				'label' => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'nav_items_color_hover',
			array(
				'label'  => esc_html__( 'Text Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a:hover' => 'color: {{VALUE}}',
				),
			)
		);

        $this->add_control(
			'nav_items_bg_hover',
			array(
				'label'  => esc_html__( 'Background Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a:hover' => 'background: {{VALUE}}',
				),
			)
		);
		
        $this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'nav_items_border_hover',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .mega-menu-item li a:hover',
			)
		);

		$this->add_responsive_control(
			'nav_items_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item li a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'nav_items_icon_color_hover',
			array(
				'label'  => esc_html__( 'Icon Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a:hover > i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mega-menu-item li a:hover > svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'nav_items_icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item li a > i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mega-menu-item li a > svg' => 'width: {{SIZE}}{{UNIT}};',
				),
                'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'nav_items_icon_spacing',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 20,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item li a > i, {{WRAPPER}} .mega-menu-item li a > svg' => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

        $this->add_control(
			'badge_options',
			[
				'label' => esc_html__( 'Badge', 'petrona' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_responsive_control(
			'badge_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item .rbt-badge-card' => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);
        $this->add_responsive_control(
			'badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item .rbt-badge-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .mega-menu-item .rbt-badge-card',
			)
		);
        $this->add_control(
			'badge_color',
			array(
				'label'  => esc_html__( 'Color', 'petrona' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mega-menu-item .rbt-badge-card' => 'color: {{VALUE}}',
				),
			)
		);

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'badge_bg_color',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .mega-menu-item .rbt-badge-card:before',
			]
		);

        $this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'badge_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} .mega-menu-item .rbt-badge-card, {{WRAPPER}} .mega-menu-item .rbt-badge-card:after',
			)
		);

		$this->add_responsive_control(
			'badge_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .mega-menu-item .rbt-badge-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mega-menu-item .rbt-badge-card:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

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
    protected function render($instance = [])
    {
        $settings = $this->get_settings_for_display();
        $items = $settings['items'];

        $ul_classes = array(
            'mega-menu-item ps-0 mb-0'
        );
        ?>
        <div class="rbt-mega-menu-list">
            <?php if(!empty($settings['widget_title'])) : ?>
                <h3 class="techt-short-title"><?php echo esc_html($settings['widget_title']); ?></h3>
            <?php endif; ?>
            <ul class="<?php echo esc_attr( implode( ' ', $ul_classes ) ); ?>">
                <?php
                    foreach ( $items as $item ) {
                        if (empty($item['url'])) {
                            continue;
                        }
                        ?>
                        <li>
                            <a href="<?php echo esc_url( $item['url'] ) ?>" target="<?php echo esc_attr( $item['target'] === 'yes' ? '_blank' : '_self' ) ?>">
                               
                                <?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'class' =>'icon' ,'aria-hidden' => 'true' ] ); ?>
                                <span class="title" ><?php echo $item['label']; ?></span>
                                <?php if( !empty( $item['badge'] ) ) { ?>
                                    <span class="rbt-badge-card"> <?php echo esc_html($item['badge']); ?> </span><?php
                                } ?>
                            </a>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Techt_Mega_Menu_Section_Widget() );