<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Techt_Accordion extends Techt_Base {

    public function get_name() {
        return 'techt-accordion';
    }

    public function get_title() {
        return __( 'Accordion', 'petrona' );
    }
    public function get_categories() {
        return ['techt-category'];
    }

    public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_keywords() {
        return [ 'accordion', 'tabs', 'toggle' ];
	}

    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Accordion', 'petrona' ),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'   => __( 'Accordion Items', 'petrona' ),
                'type'    => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'tab_title'   => __( 'Item #1', 'petrona' ),
                        'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'petrona' ),
                    ],
                    [
                        'tab_title'   => __( 'Item #2', 'petrona' ),
                        'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'petrona' ),
                    ],
                    [
                        'tab_title'   => __( 'Item #3', 'petrona' ),
                        'tab_content' => __( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'petrona' ),
                    ],
                ],
                'fields' => [
                    [
                        'name'        => 'tab_title',
                        'label'       => __( 'Title & Content', 'petrona' ),
                        'type'        => Controls_Manager::TEXT,
                        'dynamic'     => [ 'active' => true ],
                        'default'     => __( 'Title' , 'petrona' ),
                        'label_block' => true,
                    ],
                    [
                        'name'       => 'tab_content',
                        'label'      => __( 'Content', 'petrona' ),
                        'type'       => Controls_Manager::WYSIWYG,
                        'dynamic'    => [ 'active' => true ],
                        'default'    => __( 'Content', 'petrona' ),
                        'show_label' => false,
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __( 'View', 'petrona' ),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'title_html_tag',
            [
                'label'   => __( 'Title HTML Tag', 'petrona' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_available_title_html_tags(),
                'default' => 'div',
            ]
        );

        $this->add_control(
            'accordion_icon',
            [
                'label'       => __( 'Icon', 'petrona' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'accordion_active_icon',
            [
                'label'       => __( 'Active Icon', 'petrona' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon_active',
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'accordion_icon[value]!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_additional',
            [
                'label' => __( 'Additional', 'petrona' ),
            ]
        );

        $this->add_control(
            'multiple',
            [
                'label' => __( 'Multiple Open', 'petrona' ),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'active_item',
            [
                'label' => __( 'Active Item No', 'petrona' ),
                'type'  => Controls_Manager::NUMBER,
                'min'   => 1,
                'max'   => 20,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => __( 'Item', 'petrona' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'   => __( 'Alignment', 'petrona' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'petrona' ),
                        'icon'  => 'fas fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'petrona' ),
                        'icon'  => 'fas fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'petrona' ),
                        'icon'  => 'fas fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-title'   => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .techt-accordion .techt-accordion-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_spacing',
            [
                'label' => __( 'Item Spacing', 'petrona' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-item + .techt-accordion-item' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style_title',
            [
                'label' => __( 'Title', 'petrona' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __( 'Normal', 'petrona' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'title_background',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .techt-accordion .techt-accordion-title',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Color', 'petrona' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'title_shadow',
                'selector' => '{{WRAPPER}} .techt-accordion .techt-accordion-item .techt-accordion-title',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => __( 'Padding', 'petrona' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'title_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .techt-accordion .techt-accordion-item .techt-accordion-title',
            ]
        );

        $this->add_control(
            'title_radius',
            [
                'label'      => __( 'Border Radius', 'petrona' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-item .techt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .techt-accordion .techt-accordion-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __( 'Active', 'petrona' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'active_title_background',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-title',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'active_title_color',
            [
                'label'     => __( 'Color', 'petrona' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'active_title_shadow',
                'selector' => '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'active_title_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-title',
            ]
        );

        $this->add_control(
            'active_title_radius',
            [
                'label'      => __( 'Border Radius', 'petrona' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style_icon',
            [
                'label'     => __( 'Icon', 'petrona' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'accordion_icon[value]!' => '',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_icon_style' );

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __( 'Normal', 'petrona' ),
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'   => __( 'Alignment', 'petrona' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => is_rtl() ? __( 'End', 'petrona' ) : __( 'Start', 'petrona' ),
                        'icon'  => is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => is_rtl() ? __( 'Start', 'petrona' ) : __( 'End', 'petrona' ),
                        'icon'  => is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
                    ],
                ],
                'default'     => is_rtl() ? 'left' : 'right',
                'toggle'      => false,
                'label_block' => false,
            ]
        );

        // $this->add_control(
        //     'icon_align_reverse',
        //     [
        //         'label'   => __( 'Reverse', 'petrona' ),
        //         'type'    => Controls_Manager::SWITCHER,
        //         'default' => 'no',
        //     ]
        // );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Color', 'petrona' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .techt-accordion .techt-accordion-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => __( 'Spacing', 'petrona' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-icon.techt-accordion-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .techt-accordion .techt-accordion-icon.techt-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_padding',
            [
                'label'      => __( 'Padding', 'petrona' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_active',
            [
                'label' => __( 'Active', 'petrona' ),
            ]
        );

        $this->add_control(
            'icon_active_color',
            [
                'label'     => esc_html__( 'Color', 'petrona' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .techt-accordion .techt-accordion-item.techt-open .techt-accordion-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'petrona' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style_content',
            [
                'label'     => __( 'Content', 'petrona' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'content_background_color',
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .techt-accordion .techt-accordion-content',
                'separator' => 'after',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __( 'Color', 'petrona' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-content' => 'color: {{VALUE}};',
                    'separator' => 'before',
                ],
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label'      => __( 'Border Radius', 'petrona' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __( 'Padding', 'petrona' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_spacing',
            [
                'label' => __( 'Spacing', 'petrona' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .techt-accordion .techt-accordion-content' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .techt-accordion .techt-accordion-content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id       = 'techt-accordion-' . $this->get_id();


        $this->add_render_attribute(['accordion' => ['id' => $id, 'class' => 'techt-accordion',]]);

        $id_int = substr( $this->get_id_int(), 0, 3 );

        $migrated = isset( $settings['__fa4_migrated']['accordion_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        $active_migrated  = isset( $settings['__fa4_migrated']['accordion_active_icon'] );
        $active_is_new    = empty( $settings['icon_active'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div class="techt-accordion-container">
            <div <?php echo $this->get_render_attribute_string( 'accordion' ); ?>>
                <?php foreach ( $settings['tabs'] as $index => $item ) :
                $acc_count = $index + 1;
                
                $tab_item_setting_key = $this->get_repeater_setting_key( 'tab_item', 'tabs', $index );

                $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

                $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

                $this->add_render_attribute( $tab_title_setting_key, ['class' => [ 'techt-accordion-title' ],]);

                // $this->add_render_attribute( $tab_title_setting_key, 'class', ( 'right' == $settings['icon_align'] ) ? 'justify-content-between' : '' );

                // $this->add_render_attribute( $tab_item_setting_key, 'class', ( 'yes' == $settings['icon_align_reverse'] ) ? 'flex-row-reverse' : '' );

                $this->add_render_attribute( $tab_item_setting_key, 'class', 'techt-accordion-item' );

                $this->add_render_attribute( $tab_item_setting_key, 'class', ( $acc_count === $settings['active_item']) ? 'techt-open' : '' );

                if (true == $settings['multiple']){
                    $this->add_render_attribute( $tab_item_setting_key, ['class' => [ 'multiple' ],]);
                }

                $this->add_render_attribute( $tab_content_setting_key, [
                    'class' => [ 'techt-accordion-content' ],
                ]);

                $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
                ?>
                <div <?php echo $this->get_render_attribute_string( $tab_item_setting_key ); ?>>
                    <?php if ( $settings['accordion_icon']['value'] ) : ?>
                        <span class="techt-accordion-icon techt-accordion-icon-<?php echo esc_attr( $settings['icon_align'] ); ?>" aria-hidden="true">

								<?php if ( $is_new || $migrated ) : ?>
                                    <span class="techt-accordion-icon-closed">

									<?php Icons_Manager::render_icon( $settings['accordion_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
									</span>
                                <?php else : ?>
                                    <i class="techt-accordion-icon-closed <?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                                <?php endif; ?>

                            <?php if ( $active_is_new || $active_migrated ) : ?>
                                <span class="techt-accordion-icon-opened">
									<?php Icons_Manager::render_icon( $settings['accordion_active_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
                                </span>
                            <?php else : ?>
                                <i class="techt-accordion-icon-opened <?php echo esc_attr( $settings['icon_active'] ); ?>" aria-hidden="true"></i>
                            <?php endif; ?>

							</span>
                    <?php endif; ?>
                    <<?php echo $settings['title_html_tag']; ?> <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
                        <?php echo esc_html($item['tab_title']); ?>
                    </<?php echo esc_html($settings['title_html_tag']); ?>>
                    
                <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        </div>
        <?php
    }
    
}
Plugin::instance()->widgets_manager->register( new Techt_Accordion() );