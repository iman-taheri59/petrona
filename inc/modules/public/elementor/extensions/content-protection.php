<?php
namespace Elementor;
use Elementor\Controls_Manager;
use Elementor\Frontend;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Content_Protection {
	private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('elementor/element/common/_section_style/after_section_end', array( $this, 'register_controls' ), 10);
        add_action('elementor/widget/render_content', array( $this, 'render_content' ), 10, 2);
    }

    public function register_controls($element) {
    	$element->start_controls_section(
    	    'techt_content_protection_section',
    	    [
    	        'label' => esc_html__('Content Protection', 'petrona'),
    	        'tab' => Controls_Manager::TAB_ADVANCED,
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection',
    	    [
    	        'label' => __('Enable Content Protection', 'petrona'),
    	        'type' => Controls_Manager::SWITCHER,
    	        'default' => 'no',
    	        'label_on' => __('Yes', 'petrona'),
    	        'label_off' => __('No', 'petrona'),
    	        'return_value' => 'yes',
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_type',
    	    [
    	        'label' => esc_html__('Protection Type', 'petrona'),
    	        'label_block' => false,
    	        'type' => Controls_Manager::SELECT,
    	        'options' => [
    	            'role' => esc_html__('User role', 'petrona'),
    	            'password' => esc_html__('Password protected', 'petrona'),
    	        ],
    	        'default' => 'role',
    	        'condition' => [
    	            'techt_content_protection' => 'yes',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_role',
    	    [
    	        'label' => __('Select Roles', 'petrona'),
    	        'type' => Controls_Manager::SELECT2,
    	        'label_block' => true,
    	        'multiple' => true,
    	        'options' => $this->techt_user_roles(),
    	        'condition' => [
    	            'techt_content_protection' => 'yes',
    	            'techt_content_protection_type' => 'role',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_password',
    	    [
    	        'label' => esc_html__('Set Password', 'petrona'),
    	        'type' => Controls_Manager::TEXT,
    	        'input_type' => 'password',
    	        'condition' => [
    	            'techt_content_protection' => 'yes',
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);
    	
    	$element->add_control(
    	    'techt_content_protection_password_placeholder',
    	    [
    	        'label' => esc_html__('Input Placehlder', 'petrona'),
    	        'type' => Controls_Manager::TEXT,
    	        'default' => esc_html__('Enter Password', 'petrona'),
    	        'condition' => [
    	            'techt_content_protection' => 'yes',
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);
    	
    	$element->add_control(
    	    'techt_content_protection_password_submit_btn_txt',
    	    [
    	        'label' => esc_html__('Submit Button Text', 'petrona'),
    	        'type' => Controls_Manager::TEXT,
    	        'default' => esc_html__('Submit', 'petrona'),
    	        'condition' => [
    	            'techt_content_protection' => 'yes',
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->start_controls_tabs(
    	    'techt_content_protection_tabs',
    	    [
    	        'condition' => [
    	            'techt_content_protection' => 'yes',
    	        ],
    	    ]
    	);

    	$element->start_controls_tab(
    	    'techt_content_protection_tab_message',
    	    [
    	        'label' => __('Message', 'petrona'),
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_message_type',
    	    [
    	        'label' => esc_html__('Message Type', 'petrona'),
    	        'label_block' => false,
    	        'type' => Controls_Manager::SELECT,
    	        'description' => esc_html__('Set a message when the content is protected.', 'petrona'),
    	        'options' => [
    	            'none' => esc_html__('None', 'petrona'),
    	            'text' => esc_html__('Message', 'petrona'),
    	        ],
    	        'default' => 'text',
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_message_text',
    	    [
    	        'label' => esc_html__('Public Text', 'petrona'),
    	        'type' => Controls_Manager::WYSIWYG,
    	        'default' => esc_html__('You do not have permission to see this content.', 'petrona'),
    	        'dynamic' => [
    	            'active' => true,
    	        ],
    	        'condition' => [
    	            'techt_content_protection_message_type' => 'text',
    	        ],
    	    ]
    	);


    	$element->end_controls_tab();

    	$element->start_controls_tab(
    	    'techt_content_protection_tab_style',
    	    [
    	        'label' => __('Style', 'petrona'),
    	    ]
    	);

    	# message
    	$element->add_control(
    	    'techt_content_protection_message_styles',
    	    [
    	        'label' => __('Message', 'petrona'),
    	        'type' => Controls_Manager::HEADING,
    	        'separator' => 'after',
    	        'condition' => [
    	            'techt_content_protection_message_type' => 'text',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_message_text_color',
    	    [
    	        'label' => esc_html__('Text Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-protected-content-message' => 'color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_message_type' => 'text',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Typography::get_type(),
    	    [
    	        'name' => 'techt_content_protection_message_text_typography',
    	        'selector' => '{{WRAPPER}} .techt-protected-content-message, {{WRAPPER}} .protected-content-error-msg',
    	        'condition' => [
    	            'techt_content_protection_message_type' => 'text',
    	        ],
    	    ]
    	);

    	$element->add_responsive_control(
    	    'techt_content_protection_message_text_alignment',
    	    [
    	        'label' => esc_html__('Text Alignment', 'petrona'),
    	        'type' => Controls_Manager::CHOOSE,
    	        'label_block' => true,
    	        'options' => [
    	            'left' => [
    	                'title' => esc_html__('Left', 'petrona'),
    	                'icon' => 'fa fa-align-left',
    	            ],
    	            'center' => [
    	                'title' => esc_html__('Center', 'petrona'),
    	                'icon' => 'fa fa-align-center',
    	            ],
    	            'right' => [
    	                'title' => esc_html__('Right', 'petrona'),
    	                'icon' => 'fa fa-align-right',
    	            ],
    	        ],
    	        'default' => 'center',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-protected-content-message-text, {{WRAPPER}} .protected-content-error-msg' => 'text-align: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_message_type' => 'text',
    	        ],
    	    ]
    	);

    	$element->add_responsive_control(
    	    'techt_content_protection_message_text_padding',
    	    [
    	        'label' => esc_html__('Padding', 'petrona'),
    	        'type' => Controls_Manager::DIMENSIONS,
    	        'size_units' => ['px', '%', 'em'],
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-protected-content-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_message_type' => 'text',
    	        ],
    	    ]
    	);

    	# password field
    	$element->add_control(
    	    'techt_content_protection_input_styles',
    	    [
    	        'label' => __('Password Field', 'petrona'),
    	        'type' => Controls_Manager::HEADING,
    	        'separator' => 'after',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_input_width',
    	    [
    	        'label' => esc_html__('Input Width', 'petrona'),
    	        'type' => Controls_Manager::SLIDER,
    	        'range' => [
    	            'px' => [
    	                'max' => 1000,
    	            ],
    	        ],
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password' => 'width: {{SIZE}}px;',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_responsive_control(
    	    'techt_content_protection_input_alignment',
    	    [
    	        'label' => esc_html__('Input Alignment', 'petrona'),
    	        'type' => Controls_Manager::CHOOSE,
    	        'label_block' => true,
    	        'options' => [
    	            'flex-start' => [
    	                'title' => esc_html__('Left', 'petrona'),
    	                'icon' => 'fa fa-align-left',
    	            ],
    	            'center' => [
    	                'title' => esc_html__('Center', 'petrona'),
    	                'icon' => 'fa fa-align-center',
    	            ],
    	            'flex-end' => [
    	                'title' => esc_html__('Right', 'petrona'),
    	                'icon' => 'fa fa-align-right',
    	            ],
    	        ],
    	        'default' => 'left',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields > form' => 'justify-content: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_responsive_control(
    	    'techt_content_protection_password_input_padding',
    	    [
    	        'label' => esc_html__('Padding', 'petrona'),
    	        'type' => Controls_Manager::DIMENSIONS,
    	        'size_units' => ['px', 'em'],
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_responsive_control(
    	    'techt_content_protection_password_input_margin',
    	    [
    	        'label' => esc_html__('Margin', 'petrona'),
    	        'type' => Controls_Manager::DIMENSIONS,
    	        'size_units' => ['px', 'em'],
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_input_border_radius',
    	    [
    	        'label' => esc_html__('Border Radius', 'petrona'),
    	        'type' => Controls_Manager::SLIDER,
    	        'range' => [
    	            'px' => [
    	                'max' => 100,
    	            ],
    	        ],
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password' => 'border-radius: {{SIZE}}px;',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_password_input_color',
    	    [
    	        'label' => esc_html__('Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#333333',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password' => 'color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_password_input_bg_color',
    	    [
    	        'label' => esc_html__('Background Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#ffffff',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password' => 'background-color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'techt_content_protection_password_input_border',
    	        'label' => esc_html__('Border', 'petrona'),
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-password',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Box_Shadow::get_type(),
    	    [
    	        'name' => 'techt_content_protection_password_input_shadow',
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-password',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	# password field hover
    	$element->add_control(
    	    'techt_content_protection_input_styles_hover',
    	    [
    	        'label' => __('Password Field Hover', 'petrona'),
    	        'type' => Controls_Manager::HEADING,
    	        'separator' => 'after',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'eael_protected_content_password_input_hover_color',
    	    [
    	        'label' => esc_html__('Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#333333',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password:hover' => 'color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'eael_protected_content_password_input_hover_bg_color',
    	    [
    	        'label' => esc_html__('Background Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#ffffff',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields input.techt-password:hover' => 'background-color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'eael_protected_content_password_input_hover_border',
    	        'label' => esc_html__('Border', 'petrona'),
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-password:hover',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Box_Shadow::get_type(),
    	    [
    	        'name' => 'eael_protected_content_password_input_hover_shadow',
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-password"hover',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	# submit button
    	$element->add_control(
    	    'techt_content_protection_submit_button_styles',
    	    [
    	        'label' => esc_html_x('Submit Button', 'content protection Submit Button', 'petrona'),
    	        'type' => Controls_Manager::HEADING,
    	        'separator' => 'after',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_submit_button_color',
    	    [
    	        'label' => esc_html__('Text Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#ffffff',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit' => 'color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_submit_button_bg_color',
    	    [
    	        'label' => esc_html__('Background Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#333333',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit' => 'background: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

		$element->add_control(
    	    'techt_content_protection_submit_border_radius',
    	    [
    	        'label' => esc_html__('Border Radius', 'petrona'),
    	        'type' => Controls_Manager::SLIDER,
    	        'range' => [
    	            'px' => [
    	                'max' => 100,
    	            ],
    	        ],
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit' =>  'border-radius: {{SIZE}}px;',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'techt_content_protection_submit_button_border',
				'label' => esc_html__('Border', 'petrona'),
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Box_Shadow::get_type(),
    	    [
    	        'name' => 'techt_content_protection_submit_button_box_shadow',
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_submit_button_styles_hover',
    	    [
    	        'label' => __('Submit Button Hover', 'petrona'),
    	        'type' => Controls_Manager::HEADING,
    	        'separator' => 'after',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_submit_button_hover_text_color',
    	    [
    	        'label' => esc_html__('Text Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#ffffff',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit:hover' => 'color: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_control(
    	    'techt_content_protection_submit_button_hover_bg_color',
    	    [
    	        'label' => esc_html__('Background Color', 'petrona'),
    	        'type' => Controls_Manager::COLOR,
    	        'default' => '#333333',
    	        'selectors' => [
    	            '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit:hover' => 'background: {{VALUE}};',
    	        ],
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Border::get_type(),
    	    [
    	        'name' => 'techt_content_protection_submit_button_hover_border',
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit:hover',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->add_group_control(
    	    Group_Control_Box_Shadow::get_type(),
    	    [
    	        'name' => 'techt_content_protection_submit_button_hover_box_shadow',
    	        'selector' => '{{WRAPPER}} .techt-password-protected-content-fields .techt-submit:hover',
    	        'condition' => [
    	            'techt_content_protection_type' => 'password',
    	        ],
    	    ]
    	);

    	$element->end_controls_tab();

    	$element->end_controls_tabs();

    	$element->end_controls_section();
    }

    # Check current user role exists inside of the roles array.
    protected function current_user_privileges($settings) {
        if (!is_user_logged_in()) {
            return;
        }

        $user_role = reset(wp_get_current_user()->roles);
        return in_array($user_role, (array) $settings['techt_content_protection_role']);
    }

    # render message
    protected function render_message($settings) {
        $html = '<div class="techt-protected-content-message">';

        if ($settings['techt_content_protection_message_type'] == 'text') {
            $html .= '<div class="techt-protected-content-message-text">' . $settings['techt_content_protection_message_text'] . '</div>';
        } elseif ($settings['techt_content_protection_message_type'] == 'template') {
            if (!empty($settings['techt_content_protection_message_template'])) {
                $template_id = $settings['techt_content_protection_message_template'];
                $frontend = new Frontend;

                $html .= $frontend->get_builder_content($template_id, true);
            }
        }
        $html .= '</div>';

        return $html;
    }

    # password input form
    public function password_protected_form($settings) {
        $html = '<div class="techt-password-protected-content-fields">
            <form method="post">
                <input type="password" name="techt_content_protection_password" class="techt-password" placeholder="' . $settings['techt_content_protection_password_placeholder'] . '">
                <input type="submit" value="' . $settings['techt_content_protection_password_submit_btn_txt'] . '" class="techt-submit">
            </form>';

        if (isset($_POST['techt_content_protection_password'])) {
            if ($settings['techt_content_protection_password'] != $_POST['techt_content_protection_password']) {
                $html .= sprintf(__('<p class="protected-content-error-msg">Password does not match.</p>', 'petrona'));
            }
        }

        $html .= '</div>';

        return $html;
    }

    public function techt_user_roles() {
        global $wp_roles;
        $all = $wp_roles->roles;
        $all_roles = array();
        if (!empty($all)) {
            foreach ($all as $key => $value) {
                $all_roles[$key] = $all[$key]['name'];
            }
        }
        return $all_roles;
    }

    public function render_content($content, $widget)  {
    	$settings = $widget->get_settings_for_display();
    	$html = '';

    	// inject element to loaded extensions
    	add_filter('techt/section/after_render', function ($extensions) {
    	    $extensions[] = 'techt-content-protection';
    	    return $extensions;
    	});

    	if ($settings['techt_content_protection'] == 'yes') {
    		if ($settings['techt_content_protection_type'] == 'role') {
    		    if ($this->current_user_privileges($settings) === true) {
    		        $html .= $content;
    		    } else {
    		        $html .= '<div class="techt-protected-content">' . $this->render_message($settings) . '</div>';
    		    }
    		} elseif ($settings['techt_content_protection_type'] == 'password') {
    		    if (empty($settings['techt_content_protection_password'])) {
    		        $html .= $content;
    		    } else {
    		        $unlocked = false;

    		        if (isset($_POST['techt_content_protection_password'])) {
    		            if ($settings['techt_content_protection_password'] == $_POST['techt_content_protection_password']) {
    		                $unlocked = true;

    		                $html .= "<script>
    		                    var expires = new Date();
    		                    expires.setTime(expires.getTime() + (1 * 60 * 60 * 1000));
    		                    document.cookie = 'techt_content_protection_password=true;expires=' + expires.toUTCString();
    		                </script>";
    		            }
    		        }

    		        if (isset($_COOKIE['techt_content_protection_password']) || $unlocked) {
    		            $html .= $content;
    		        } else {
    		            $html .= '<div class="techt-protected-content">' . $this->render_message($settings) . $this->password_protected_form($settings) . '</div>';
    		        }
    		    }
    		}
    	} else {
    		$html .= $content;
    	}

    	return $html;
    }
}
Techt_Content_Protection::instance();