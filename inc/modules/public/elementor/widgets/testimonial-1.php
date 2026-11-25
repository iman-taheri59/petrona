<?php
/**
 * @author  Techno Theme
 * @since   1.0
 * @version 1.0
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;

 
if (!defined('ABSPATH')) exit; 
class techt_testimonial extends Techt_Base
{

    public function get_name()
    {
        return 'techt-testimonial-1';
    }

    public function get_title()
    {
        return __('Testimonial', 'petrona');
    }

    public function get_icon()
    {
        return 'eicon-testimonial';
    }

    public function get_categories()
    {
        return [ 'techt-category' ];
    }
    public function techt_get_img( $img )
    {
        $img = TECHT_MADULES_URL . '/public/assets/images' . $img;
        return $img;
    } 

     

    protected function register_controls(){

        // $this->techt_basic_style_controls('title_style_section', __( 'Title', 'petrona' ), '.section-title .title');
        // $this->techt_basic_style_controls('title_brfore_style_section', __( 'Before Title', 'petrona' ), '.section-title .subtitle');
        // $this->techt_basic_style_controls('title_description_style_section', __( 'Description', 'petrona' ), '.section-title .description');
        
        $this->start_controls_section(
            'testimonial_layout',
            [
                'label' => __( 'Layout', 'petrona' ),
            ]
            );
            $this->add_control(
                'style',
                [
                    'label' => __('Layout', 'petrona'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'layout-1',
                    'options' => [
                        'layout-1' => __('Style One', 'petrona'),
                    ],
                ]
            );
        $this->end_controls_section();        

        $this->start_controls_section(
            'testimonial_section_7',
            [
                'label' => __( 'Line One', 'petrona' ),
                'condition' => array( 'style' => array( 'layout-1' )),
                ]
            );        
            $repeater = new Repeater();
            $repeater->add_control(
                'client_image_7',
                [
                    'label' => __('Image', 'petrona'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
            $repeater->add_control(
                'testimonial_title_7', [
                    'label' => __('Title', 'petrona'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Martha Maldonado, CEO', 'petrona'),
                    'label_block' => true,                
                ]
            );
            $repeater->add_control(
                'testimonial_sub_title_7',
                [
                    'label' => __('Sub Title', 'petrona'),
                    'type' => Controls_Manager::TEXT,
                    'rows' => 10,
                    'default' => 'After the launch, vulputate at sapien sit amet,
                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.',
                    'placeholder' => __('Type your description here', 'petrona'),
                ]
            );  
            $repeater->add_control(
                'testimonial_description_7', [
                    'label' => __('Descripion', 'petrona'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __('Martha Maldonado, CEO', 'petrona'),
                    'label_block' => true,                
                ]
            );

            $repeater->add_control(
                'rating_display7',
                [
                    'label' => __('Rating Display', 'petrona'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('On', 'petrona'),
                    'label_off' => __('Off', 'petrona'),
                    'default' => 'yes',
                     'description' => __( 'Show or Hide Rating. Default: On', 'petrona' ),

                ]
            ); 
     

            $repeater->add_control(
                'rating7',
                [
                    'type' => Controls_Manager::SELECT,
                    'label'   => __( 'Rating', 'petrona' ),
                    'label_block' => true,  
                    'default' => '5',              
                    'options' => array(
                        '1' => __( 'Rating 1', 'petrona' ),
                        '2' => __( 'Rating 2', 'petrona' ),
                        '3' => __( 'Rating 3', 'petrona' ),
                        '4' => __( 'Rating 4', 'petrona' ),
                        '5' => __( 'Rating 5', 'petrona' ),
                    ),
                ]
            );
            $this->add_control(
                'testimonial_list_7',
                [
                    'label' => __('Info List', 'petrona'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'testimonial_title_7' => __('Martha Maldonado, CEO', 'petrona'),
                            'testimonial_sub_title_7' => __('Executive Chairman @ Google', 'petrona'),
                            'testimonial_description_7' => __('After the launch, vulputate at sapien sit amet,
                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona'),
                            'client_image_7' => [
                                'url' => $this->techt_get_img( 'person-1.jpg' ),
                            ],
                        ],
                        [
                            'testimonial_title_7' => __('Martha Maldonado, CEO', 'petrona'),
                            'testimonial_sub_title_7' => __('Executive Chairman @ Google', 'petrona'),
                            'testimonial_description_7' => __('After the launch, vulputate at sapien sit amet,
                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona'),
                            'client_image_7' => [
                                'url' => $this->techt_get_img( 'client-01.png' ),
                            ],
                        ],
                        [
                            'testimonial_title_7' => __('Martha Maldonado, CEO', 'petrona'),
                            'testimonial_sub_title_7' => __('Executive Chairman @ Google', 'petrona'),
                            'testimonial_description_7' => __('After the launch, vulputate at sapien sit amet,
                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona'),
                            'client_image_7' => [
                                'url' => $this->techt_get_img( 'person-1.jpg' ),
                            ],
                        ],
                        
                    ],
                    'title_field' => '{{{ testimonial_title_7 }}}',
                    'separator' => 'before',
                ]
            );
        $this->end_controls_section();
        $this->start_controls_section(
            'testimonial_section_8',
            [
                    'label' => __( 'Line Two', 'petrona' ),
                    'condition' => array( 'style' => array( 'layout-1' )),
                ]
            );        
            $repeater = new Repeater();
            $repeater->add_control(
                'client_image_8',
                [
                    'label' => __('Image', 'petrona'),
                    'type' => Controls_Manager::MEDIA,
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
            $repeater->add_control(
                'testimonial_title_8', [
                    'label' => __('Title', 'petrona'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Martha Maldonado, CEO', 'petrona'),
                    'label_block' => true,                
                ]
            );
            $repeater->add_control(
                'testimonial_sub_title_8',
                [
                    'label' => __('Sub Title', 'petrona'),
                    'type' => Controls_Manager::TEXT,
                    'rows' => 10,
                    'default' => __( 'After the launch, vulputate at sapien sit amet,
                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona' ),
                    'placeholder' => __('Type your description here', 'petrona'),
                ]
            );  
            $repeater->add_control(
                'testimonial_description_8', [
                    'label' => __('Descripion', 'petrona'),
                    'type' => Controls_Manager::TEXTAREA,
                    'default' => __('Martha Maldonado, CEO', 'petrona'),
                    'label_block' => true,                
                ]
            );

            $repeater->add_control(
                'rating_display8',
                [
                    'label' => __('Rating Display', 'petrona'),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __('On', 'petrona'),
                    'label_off' => __('Off', 'petrona'),
                    'default' => 'yes',
                     'description' => __( 'Show or Hide Rating. Default: On', 'petrona' ),

                ]
            ); 
     

            $repeater->add_control(
                'rating8',
                [
                    'type' => Controls_Manager::SELECT,
                    'label'   => __( 'Rating', 'petrona' ),
                    'label_block' => true,  
                    'default' => '5',              
                    'options' => array(
                        '1' => __( 'Rating 1', 'petrona' ),
                        '2' => __( 'Rating 2', 'petrona' ),
                        '3' => __( 'Rating 3', 'petrona' ),
                        '4' => __( 'Rating 4', 'petrona' ),
                        '5' => __( 'Rating 5', 'petrona' ),
                    ),
                ]
            );
            $this->add_control(
                'testimonial_list_8',
                [
                    'label' => __('Info List', 'petrona'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [
                            'testimonial_title_8' => __('Martha Maldonado, CEO', 'petrona'),
                            'testimonial_sub_title_8' => __('Executive Chairman @ Google', 'petrona'),
                            'testimonial_description_8' => __('After the launch, vulputate at sapien sit amet,
                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona'),
                            'client_image_8' => [
                                'url' => $this->techt_get_img( 'person-1.jpg' ),
                            ],
                        ],
                        [
                            'testimonial_title_8' => __('Martha Maldonado, CEO', 'petrona'),
                            'testimonial_sub_title_8' => __('Executive Chairman @ Google', 'petrona'),
                            'testimonial_description_8' => __('After the launch, vulputate at sapien sit amet,
                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona'),
                            'client_image_8' => [
                                'url' => $this->techt_get_img( 'person-1.jpg' ),
                            ],
                        ],
                        [
                            'testimonial_title_8' => __('Martha Maldonado, CEO', 'petrona'),
                            'testimonial_sub_title_8' => __('Executive Chairman @ Google', 'petrona'),
                            'testimonial_description_8' => __('After the launch, vulputate at sapien sit amet,
                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.', 'petrona'),
                            'client_image_8' => [
                                'url' => $this->techt_get_img( 'person-1.jpg' ),
                            ],
                        ],
                    ],
                    'title_field' => '{{{ testimonial_title_8 }}}',
                    'separator' => 'before',
                ]
            );
        $this->end_controls_section();

        $this->techt_basic_content_controls('testimonial_content_section', __( 'Content Area', 'petrona' ), '.techt-testimonial-area');
        $this->techt_thumb_style_controls('testimonial_thumb_section',  __( 'Image', 'petrona' ), '.techt-testimonial-box .clint-info-wrapper .thumb' );
        $this->techt_basic_style_controls('testimonial_title_section', __( 'Title', 'petrona' ), '.techt-testimonial-box .client-info .title' );
        $this->techt_basic_style_controls('testimonial_subtitle_section', __( 'Subtitle', 'petrona' ), '.techt-testimonial-box .client-info span' );
        $this->techt_basic_style_controls('testimonial_desc_section', __( 'Description', 'petrona' ), '.techt-testimonial-box .description p' );
        $this->techt_basic_rating_controls('rating_style_section', __( 'Rating', 'petrona' ), '.item-rating.rating');
    }
    
    protected function techt_basic_style_controls($control_id = null, $control_name = null, $control_selector = null ){
        $this->start_controls_section(
            'techt_' . $control_id . '_styling',
            [
                'label' => esc_html__($control_name, 'petrona'),
                'tab' => Controls_Manager::TAB_STYLE,
                

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
        $this->end_controls_section();
    }
    protected function techt_thumb_style_controls($control_id = null, $control_name = null, $control_selector = null ){
        $this->start_controls_section(
            'techt_' . $control_id . '_styling',
            [
                'label' => esc_html__($control_name, 'petrona'),
                'tab' => Controls_Manager::TAB_STYLE,
                

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
        $this->add_responsive_control(
			'techt_' . $control_id . '_width',
			[
				'label' => __( 'Width', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 70
				],
				'selectors' => [
					'{{WRAPPER}} ' . $control_selector => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'techt_' . $control_id . '_border',
				'label'       => __( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $control_selector,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'techt_' . $control_id . '_border_radius',
			array(
				'label'      => __( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $control_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $control_selector . ' img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
        $this->end_controls_section();
    }
    protected function techt_basic_rating_controls($control_id = null, $control_name = null, $control_selector = null ){
        $this->start_controls_section(
            'techt_' . $control_id . '_styling',
            [
                'label' => esc_html__($control_name, 'petrona'),
                'tab' => Controls_Manager::TAB_STYLE,
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

        $this->add_responsive_control(
            'techt_' . $control_id . '_item_margin',
            [
                'label' => esc_html__('Item Margin', 'petrona'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}}' . $control_selector . ' li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
			'techt_' . $control_id . '_item_size',
			[
				'label' => __( 'Size', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 40,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $control_selector . ' li i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_control(
            'techt_' . $control_id . '_color',
            [
                'label' => __('Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ' li i' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
    protected function techt_basic_content_controls($control_id = null, $control_name = null, $control_selector = null ){
        $this->start_controls_section(
            'techt_' . $control_id . '_styling',
            [
                'label' => esc_html__($control_name, 'petrona'),
                'tab' => Controls_Manager::TAB_STYLE,
                

            ]
        );
       
        $this->add_responsive_control(
			'techt_' . $control_id . '_items_space',
			[
				'label' => __( 'Items Space', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $control_selector . ' .single-column-20' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'techt_' . $control_id . '_rows_space',
			[
				'label' => __( 'Rows Space', 'petrona' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $control_selector . ' .scroll-animation-wrapper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
        $this->add_responsive_control(
            'techt_' . $control_id . '_padding',
            [
                'label' => esc_html__('Padding', 'petrona'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ' .inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'techt_' . $control_id . '_sides_shadow_color',
            [
                'label' => esc_html__('Sides Shadow Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ' .scroll-animation-wrapper::before,{{WRAPPER}} ' . $control_selector . ' .scroll-animation-wrapper::after' => 'background: linear-gradient(90deg, {{VALUE}} 0, hsla(0, 0%, 100%, 0));',
                ],
            ]
        );
        $this->add_control(
            'techt_' . $control_id . '_bg_color',
            [
                'label' => esc_html__('Background Color', 'petrona'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $control_selector . ' .inner' => 'background: {{VALUE}} !important;',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'techt_' . $control_id . '_border',
				'label' => esc_html__( 'Border', 'petrona' ),
				'selector' => '{{WRAPPER}} ' . $control_selector . ' .inner'
			]
		);
		$this->add_responsive_control(
			'techt_' . $control_id . '_border_radius',
			[
				'label' => __('Border Radius', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} ' . $control_selector . ' .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'techt_' . $control_id . '_box_shadow',
				'selector' => '{{WRAPPER}} ' . $control_selector . ' .inner',
			]
		);
        $this->end_controls_section();
    }
    protected function render()
    {
        $this->_context = 'render';
        $settings  = $this->get_settings();
		$this->_open_wrap();
        include $this->get_widget_template( $settings['style'] ); 
        $this->_close_wrap();
    }
}
Plugin::instance()->widgets_manager->register( new techt_testimonial() );