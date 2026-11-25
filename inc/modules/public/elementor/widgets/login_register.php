<?php

namespace Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly


class Techt_Login_Register extends Techt_Base
{

	public function get_name()
	{
		return 'techt-login-register';
	}

	public function get_title()
	{
		return esc_html__('Login & Register', 'petrona');
	}

	public function get_icon()
	{
		return 'eicon-lock-user';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

	protected function register_controls()
	{
		$this->start_controls_section(
			'section_forms_layout',
			[
				'label' => esc_html__('Forms Layout', 'petrona'),
			]
		);
		$this->add_control(
			'form_selection',
			[
				'label' => esc_html__('Type', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'ox_login',
				'options' => [
					'ox_login'  => esc_html__('Login', 'petrona'),
					'ox_register'  => esc_html__('Register', 'petrona'),
					'ox_login_register'  => esc_html__('Login and Register', 'petrona'),
					'ox_forgot_password'  => esc_html__('Forgot Password', 'petrona'),
				],
			]
		);

		$this->add_control(
			'_skin',
			[
				'label' => esc_html__('Layout', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__('Standard Form', 'petrona'),
					'ox-dropdown'  => esc_html__('Button Hover', 'petrona'),
					'ox-modal'  => esc_html__('Button Click', 'petrona'),
					'ox-popup'  => esc_html__('Button Popup', 'petrona'),
				],
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
				],
			]
		);

		$this->add_responsive_control(
			'layout_start_from',
			[
				'label' => esc_html__('Drop Down Alignment', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'ox-lrfp-lyot-con-left',
				'options' => [
					'ox-lrfp-lyot-con-left'  => esc_html__('Left', 'petrona'),
					'ox-lrfp-lyot-con-right'  => esc_html__('Right', 'petrona'),
					'ox-lrfp-lyot-con-center'  => esc_html__('Center', 'petrona'),
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'form_selection',
							'operator' => '!==',
							'value' => 'ox_forgot_password',
						],
						[
							'name' => '_skin',
							'operator' => '!==',
							'value' => 'default',
						],
						[
							'name' => '_skin',
							'operator' => '!==',
							'value' => 'ox-popup',
						],
					],
				],
			]
		);
		$this->add_control(
			'f_p_opt',
			[
				'label' => esc_html__('Password Reset Page', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__('Default', 'petrona'),
					'f_p_frontend'  => esc_html__('Custom', 'petrona'),
				],
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['ox_forgot_password'],
				],
			]
		);
		$this->add_control(
			'f_p_opt_cst_desc',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__('Note : You can choose custom Password Reset page using this option.', 'petrona'),
				'content_classes' => 'ox-widget-description',
				'condition' => [
					'form_selection' => ['ox_forgot_password'],
					'f_p_opt' => ['f_p_frontend'],
				],
			]
		);
		$this->add_control(
			'reset_pass_url',
			[
				'label' => esc_html__('Select Page', 'petrona'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => [],
				'options'     => $this->techt_get_term_options(),
				'condition' => [
					'form_selection' => ['ox_forgot_password'],
					'f_p_opt' => 'f_p_frontend',
				],
			]
		);
		$this->add_control(
			'hcp_button_align',
			[
				'label' => esc_html__('Button Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'petrona'),
						'icon' => ! is_rtl() ? 'fa fa-align-left' : 'fa fa-align-right',
					],
					'center' => [
						'title' => esc_html__('Center', 'petrona'),
						'icon' => 'fa fa-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'petrona'),
						'icon' => ! is_rtl() ? 'fa fa-align-right' : 'fa fa-align-left',
					],
				],
				'separator' => 'before',
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf:not(.ox-ursp-page-wrapper)' => 'text-align: {{VALUE}};'
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'form_selection',
							'operator' => '!==',
							'value' => 'ox_forgot_password',
						],
						[
							'name' => '_skin',
							'operator' => '!==',
							'value' => 'default',
						],
					],
				],

			]
		);
		$this->add_control(
			'form_align',
			[
				'label' => esc_html__('Content Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => esc_html__('Start', 'petrona'),
						'icon' => ! is_rtl() ? 'fa fa-align-left' : 'fa fa-align-right',
					],
					'center' => [
						'title' => esc_html__('Center', 'petrona'),
						'icon' => 'fa fa-align-center',
					],
					'end' => [
						'title' => esc_html__('End', 'petrona'),
						'icon' => ! is_rtl() ? 'fa fa-align-right' : 'fa fa-align-left',
					],
				],
				'separator' => 'before',
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					 '{{WRAPPER}} .ox-form-stacked,
					 {{WRAPPER}} .ox-form-stacked-fp,
					 {{WRAPPER}} .ox-wp-lrcf input,{{WRAPPER}} .ox-wp-lrcf input::placeholder' => 'text-align: {{VALUE}};',
				],

			]
		);
		$this->end_controls_section();
		/*form content end*/

		/*Login Options start*/
		$this->start_controls_section(
			'section_forms_login_additional_options',
			[
				'label' => esc_html__('Login Options', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'tab_com_login',
			[
				'label'   => esc_html__('Login Tab Title', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Login', 'petrona'),
				'separator' => 'after',
				'condition' => [
					'form_selection' => 'ox_login_register',
				],
			]
		);

		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__('Labels', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
				],
			]
		);
		/*login custom label*/
		$this->add_control(
			'custom_labels',
			[
				'label'     => esc_html__('Custom Labels', 'petrona'),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'show_labels' => 'yes',
				],
			]
		);
		$this->add_control(
			'user_label',
			[
				'label'     => esc_html__('Username', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Username or Email', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);
		$this->add_control(
			'password_label',
			[
				'label'     => esc_html__('Password', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Password', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'show_labels'   => 'yes',
					'custom_labels' => 'yes',
				],
			]
		);
		$this->add_control(
			'custom_placeholder_l',
			[
				'label'     => esc_html__('Custom Placeholders', 'petrona'),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'user_placeholder',
			[
				'label'     => esc_html__('Username', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Username or Email', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'custom_placeholder_l' => 'yes',
				],
			]
		);
		$this->add_control(
			'password_placeholder',
			[
				'label'     => esc_html__('Password', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Password', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'custom_placeholder_l' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text',
			[
				'label'   => esc_html__('Login Button Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Log In', 'petrona'),
				'separator' => 'before',
				'condition' => [
					'form_selection!' => ['ox_register', 'ox_forgot_password'],
				],
			]
		);
		$this->add_control(
			'show_remember_me',
			[
				'label'   => esc_html__('Remember Me', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'remember_me_text',
			[
				'label'   => esc_html__('Content', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Remember Me', 'petrona'),
				'condition' => [
					'show_remember_me' => 'yes',
				],
			]
		);
		/*login custom label*/
		$this->add_control(
			'show_lost_password',
			[
				'label'   => esc_html__('Lost password', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'bottom_lost_pass_text',
			[
				'label'     => esc_html__('Content', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Lost Password', 'petrona'),
				'condition' => [
					'show_lost_password' => 'yes',
				],
			]
		);
		if (get_option('users_can_register')) {
			$this->add_control(
				'show_register',
				[
					'label'   => esc_html__('Register', 'petrona'),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
					'separator' => 'before',
				]
			);
		}
		$this->add_control(
			'bottom_register_text',
			[
				'label'     => esc_html__('Text', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Register', 'petrona'),
				'condition' => [
					'show_register' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_register_opt',
			[
				'label' => esc_html__('Link', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__('Default', 'petrona'),
					'custom'  => esc_html__('Custom', 'petrona'),
				],
				'condition' => [
					'show_register' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_register_opt_link',
			[
				'label' => esc_html__('Link', 'petrona'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('https://www.demo-link.com', 'petrona'),
				'default' => [
					'url' => '#',
				],
				'show_external' => false,
				'condition' => [
					'show_register' => 'yes',
					'show_register_opt' => 'custom',
				],
			]
		);
		$this->add_control(
			'redirect_after_login',
			[
				'label' => esc_html__('Redirect After Login', 'petrona'),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'redirect_url',
			[
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'separator'     => false,
				'placeholder'   => 'http://your-link.com/',
				'description'   => esc_html__('Note: Because of security reasons, you can ONLY use your current domain here.', 'petrona'),
				'condition'     => [
					'redirect_after_login' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*login option end*/

		/*register option start*/
		$this->start_controls_section(
			'section_forms_register_options',
			[
				'label' => esc_html__('Register Options', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'tab_com_signup',
			[
				'label'   => esc_html__('Register Tab Title', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Sign Up', 'petrona'),
				'condition' => [
					'form_selection' => 'ox_login_register',
				],
			]
		);
		$this->add_control(
			'show_labels_reg',
			[
				'label'   => esc_html__('Labels', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
				],
			]
		);
		/*register custom label*/
		$this->add_control(
			'custom_labels_reg',
			[
				'label'     => esc_html__('Custom Labels', 'petrona'),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'show_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'first_name_label',
			[
				'label'     => esc_html__('First Name', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('First Name', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'last_name_label',
			[
				'label'     => esc_html__('Last Name', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Last Name', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'user_name_label',
			[
				'label'     => esc_html__('User Name', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('User Name', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'show_labels_reg'   => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'email_label',
			[
				'label'     => esc_html__('Email', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Email', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'show_labels_reg' => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_password_label',
			[
				'label'     => esc_html__('Password', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Password', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_dis_pass_field' => 'yes',
					'show_labels_reg' => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_conf_password_label',
			[
				'label'     => esc_html__('Confirm Password', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Confirm Password', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_dis_pass_field' => 'yes',
					'show_labels_reg' => 'yes',
					'custom_labels_reg' => 'yes',
				],
			]
		);
		
		/*register custom label*/

		/*register custom placeholder*/
		$this->add_control(
			'custom_placeholder_reg',
			[
				'label'     => esc_html__('Custom Placeholders', 'petrona'),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'first_name_placeholder',
			[
				'label'     => esc_html__('First Name', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('First Name', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'custom_placeholder_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'last_name_placeholder',
			[
				'label'     => esc_html__('Last Name', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Last Name', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'custom_placeholder_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'user_name_placeholder',
			[
				'label'     => esc_html__('User Name', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('User Name', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'custom_placeholder_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'email_placeholder',
			[
				'label'     => esc_html__('Email', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('example@email.com', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'custom_placeholder_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_password_placeholder',
			[
				'label'     => esc_html__('Password', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('****', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_dis_pass_field' => 'yes',
					'custom_placeholder_reg' => 'yes',
				],
			]
		);
		$this->add_control(
			'r_conf_password_placeholder',
			[
				'label'     => esc_html__('Confirm Password', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('****', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_dis_pass_field' => 'yes',
					'custom_placeholder_reg' => 'yes',
				],
			]
		);
		/*register custom placeholder*/

		$this->add_control(
			'redirect_after_register',
			[
				'label' => esc_html__('Redirect After Register', 'petrona'),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'redirect_url_reg',
			[
				'type'          => Controls_Manager::URL,
				'show_label'    => false,
				'show_external' => false,
				'separator'     => false,
				'placeholder'   => 'http://your-link.com/',
				'description'   => esc_html__('Note: Because of security reasons, you can ONLY use your current domain here.', 'petrona'),
				'condition'     => [
					'redirect_after_register' => 'yes',
				],
			]
		);
		$this->add_control(
			'auto_loggedin',
			[
				'label' => esc_html__('Auto Login After Register ', 'petrona'),
				'type'  => Controls_Manager::SWITCHER,
				'condition'     => [
					'ox_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_login',
			[
				'label' => esc_html__('Login', 'petrona'),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'bottom_login_text',
			[
				'label'     => esc_html__('Text', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Login', 'petrona'),
				'condition' => [
					'show_login' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_login_opt',
			[
				'label' => esc_html__('Link', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__('Default', 'petrona'),
					'custom' => esc_html__('Custom', 'petrona'),
				],
				'condition'     => [
					'show_login' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_login_opt_link',
			[
				'label' => esc_html__('Link', 'petrona'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('https://www.demo-link.com', 'petrona'),
				'default' => [
					'url' => '#',
				],
				'show_external' => false,
				'condition' => [
					'show_login' => 'yes',
					'show_login_opt' => 'custom',
				],
			]
		);
		$this->add_control(
			'login_before_text',
			[
				'label'     => esc_html__('Before Text', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Already have an account?', 'petrona'),
				'condition' => [
					'show_login' => 'yes',
				],
			]
		);
		$this->add_control(
			'show_logged_in_message_reg',
			[
				'label'   => esc_html__('My Account Menu', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'show_additional_message',
			[
				'label' => esc_html__('Bottom Message', 'petrona'),
				'type'  => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'additional_message',
			[
				'label'     => esc_html__('Message', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Note: Your password will be generated automatically and sent to your email address.', 'petrona'),
				'condition' => [
					'show_additional_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text_reg',
			[
				'label'   => esc_html__('Register Button Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Register', 'petrona'),
				'separator' => 'before',
				'condition' => [
					'form_selection!' => ['ox_login', 'ox_forgot_password'],
				],
			]
		);
		$this->end_controls_section();

		/*Register Extra Options start*/
		$this->start_controls_section(
			'section_signup_extra_options',
			[
				'label' => esc_html__('Register Extra Options', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'ox_dis_name_field',
			[
				'label' => esc_html__('Name Field', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'ox_dis_fname_field',
			[
				'label' => esc_html__('First Name Field', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
				'condition' => [
					'ox_dis_name_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_dis_lname_field',
			[
				'label' => esc_html__('Last Name Field', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
				'condition' => [
					'ox_dis_name_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_dis_username_field',
			[
				'label' => esc_html__('User Name Field', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'ox_dis_pass_field',
			[
				'label' => esc_html__('Password Field', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'ox_dis_conf_pass_field',
			[
				'label' => esc_html__('Confirm Password Field', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_dis_show_pass_icon',
			[
				'label' => esc_html__('Show/Hide Password Toggle', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'showicon',
			[
				'label' => esc_html__('Show Icon', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-eye',
					'library' => 'solid',
				],
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_show_pass_icon' => 'yes',
				],
			]
		);
		$this->add_control(
			'hideicon',
			[
				'label' => esc_html__('Hide Icon', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-eye-slash',
					'library' => 'solid',
				],
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_show_pass_icon' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_dis_pass_field_strong',
			[
				'label' => esc_html__('Strong Password', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_dis_pass_pattern',
			[
				'label' => esc_html__('Pattern', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'pattern-1',
				'options' => [
					'pattern-1'  => esc_html__('Pattern 1', 'petrona'),
					'pattern-2'  => esc_html__('Pattern 2', 'petrona'),
					'pattern-3'  => esc_html__('Pattern 3', 'petrona'),
					'pattern-4'  => esc_html__('Pattern 4', 'petrona'),
					'pattern-5'  => esc_html__('Pattern 5', 'petrona'),
				],
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
				],
			]
		);
		$this->add_control(
			'pattern_desc_1',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__('Minimum eight characters, at least one letter, one number and one special character', 'petrona'),
				'content_classes' => 'ox-widget-description',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_pattern' => 'pattern-1',
				],
			]
		);
		$this->add_control(
			'pattern_desc_2',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__('Minimum four and Maximum eight characters, at least one numeric digit', 'petrona'),
				'content_classes' => 'ox-widget-description',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_pattern' => 'pattern-2',
				],
			]
		);
		$this->add_control(
			'pattern_desc_3',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__('Minimum six characters, at least one letter and one number', 'petrona'),
				'content_classes' => 'ox-widget-description',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_pattern' => 'pattern-3',
				],
			]
		);
		$this->add_control(
			'pattern_desc_4',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__('Minimum eight characters long. - At least one uppercase, one lowercase, one digit OR one 1 alphanumeric', 'petrona'),
				'content_classes' => 'ox-widget-description',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_pattern' => 'pattern-4',
				],
			]
		);
		$this->add_control(
			'pattern_desc_5',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__('Minimum eight characters long. - At least one capital letter, one lowercase, one number OR special character', 'petrona'),
				'content_classes' => 'ox-widget-description',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_pattern' => 'pattern-5',
				],
			]
		);
		$this->add_control(
			'ox_dis_pass_hint',
			[
				'label' => esc_html__('Password Hint', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
				],
			]
		);
		$this->add_control(
			'dis_pass_hint_on',
			[
				'label' => esc_html__('Visibility On', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'pshd',
				'options' => [
					'pshd'  => esc_html__('Default', 'petrona'),
					'pshf'  => esc_html__('Focus', 'petrona'),
					'pshc'  => esc_html__('Click', 'petrona'),
				],
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_hint' => 'yes',
				],
			]
		);
		$this->add_control(
			'dis_pass_hint_layout',
			[
				'label' => esc_html__('Hint Layout', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'phdefault',
				'options' => [
					'phdefault'  => esc_html__('Default', 'petrona'),
					'phinline'  => esc_html__('Inline', 'petrona'),
				],
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_hint' => 'yes',
				],
			]
		);
		$this->add_control(
			'showiconh',
			[
				'label' => esc_html__('Click Icon', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-info-circle',
					'library' => 'solid',
				],
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_hint' => 'yes',
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_control(
			'ox_dis_pass_meter',
			[
				'label' => esc_html__('Password Strength Meter', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'display_captcha_swtch',
			[
				'label' => esc_html__('reCAPTCHA v3', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'description'   => esc_html__('Note : Add recaptcha key in Petrona Settings to activate it.', 'petrona'),
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'ox_terms_condition_opt',
			[
				'label' => esc_html__('Terms & Conditions', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'r_terms_conition_label',
			[
				'label'     => esc_html__('Terms & Conditions', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('I agree, With Terms and Conditions.', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_terms_condition_opt' => 'yes',
				],
			]
		);
		$this->add_control(
			'user_role',
			[
				'label' => esc_html__('New User Role', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'subscriber',
				'options' => $this->ox_lr_user_role(),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'ox_cst_email_opt',
			[
				'label' => esc_html__('Custom Email', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$EMtitle = get_option('blogname');
		$subject = sprintf(__('Thank you for registering with %s!', 'petrona'), $EMtitle);

		$this->add_control(
			'ox_cst_email_subject',
			[
				'label'       => __('Email Subject', 'petrona'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => $subject,
				'default'     => $subject,
				'label_block' => true,
				'render_type' => 'none',
				'condition' => [
					'ox_cst_email_opt' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_cst_email_message',
			[
				'label' => esc_html__('Email Message', 'petrona'),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => __('Enter Email Message', 'petrona'),
				'default'     => sprintf(__('Dear User,<br/>You have successfully created your %1$s account. Thank you for registering with us! <br/>And here\'s the password [ox_password] to log in to the account.', 'petrona'), $EMtitle),
				'description' => 'Fields : [ox_firstname] , [ox_lastname] , [ox_username] , [ox_email] ,[ox_password]',
				'label_block' => true,
				'render_type' => 'none',
				'condition' => [
					'ox_cst_email_opt' => 'yes',
				]
			]
		);
		$this->end_controls_section();
		/*Register Extra Options end*/

		/*template select start*/
		$this->start_controls_section(
			'section_forms_layout_left_temp',
			[
				'label' => esc_html__('Left Side Template', 'petrona'),
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'and',
							'terms'    => [
								[
									'name'     => 'form_selection', 'operator' => '==', 'value'    => 'ox_login_register',
								],
								[
									'name'     => '_skin', 'operator' => '!==', 'value'    => 'default',
								],
							],
						],
					],
				],
			]
		);
		$this->add_control(
			'select_template',
			[
				'label' => esc_html__('Left Side Template', 'petrona'),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => [],
				'separator' => 'before',
				'options'     => $this->techt_elementor_templates(),
			]
		);
		$this->end_controls_section();
		/*template select end*/

		/*Click/Hover/Popup Button start*/
		$this->start_controls_section(
			'section_dropdown_button',
			[
				'label' => esc_html__('Button', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'or',
							'terms'    => [
								[
									'terms' => [
										['name'  => 'form_selection', 'operator' => '==', 'value' => 'ox_login'],
										['name'  => '_skin', 'operator' => '!=', 'value' => 'default',],
									],
								],
								[
									'terms' => [
										['name'  => 'form_selection', 'operator' => '==', 'value' => 'ox_register'],
										['name'  => '_skin', 'operator' => '!=', 'value' => 'default',],
									],
								],
								[
									'terms' => [
										['name'  => 'form_selection', 'operator' => '==', 'value' => 'ox_login_register',],
										['name'  => '_skin', 'operator' => '!=', 'value' => 'default',],
									],
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'dropdown_button_text',
			[
				'label'   => esc_html__('Button Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Login/Signup', 'petrona'),
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
					'_skin!' => 'default',
				],
			]
		);
		$this->add_control(
			'loop_icon_fontawesome',
			[
				'label' => esc_html__('Icon', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-user',
					'library' => 'solid',
				],
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
					'_skin!' => 'default',
				],

			]
		);
		$this->add_control(
			'modal_close_button',
			[
				'label'   => esc_html__('Close Icon', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'_skin!' => 'ox-dropdown',
				],

			]
		);
		$this->add_control(
			'modal_close_button_icon',
			[
				'label' => esc_html__('Choose Icon', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value'		=> 'techt-icon-close',
					'library' 	=> 'petrona',
				],
				'condition' => [
					'_skin!' => 'ox-dropdown',
					'modal_close_button' => 'yes',
				],

			]
		);
		$this->end_controls_section();
		/*Click/Hover/Popup Button end*/

		/*form heading start*/
		$this->start_controls_section(
			'section_forms_heading_options',
			[
				'label' => esc_html__('Form Heading', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'modal_header',
			[
				'label'   => esc_html__('Heading Content', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);
		$this->add_control(
			'modal_header_description_log',
			[
				'label' => esc_html__('Login Heading', 'petrona'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__('Heading Description', 'petrona'),
				'placeholder' => esc_html__('Type your description here', 'petrona'),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'modal_header' => 'yes',
				],
			]
		);
		$this->add_control(
			'modal_header_description_reg',
			[
				'label' => esc_html__('Registration Heading', 'petrona'),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__('Heading Description', 'petrona'),
				'placeholder' => esc_html__('Type your description here', 'petrona'),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'modal_header' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*form heading end*/

		/*Password Strength Meter start*/
		$this->start_controls_section(
			'content_password_strength_meter',
			[
				'label' => esc_html__('Password Strength Meter', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_meter' => 'yes',
				],
			]
		);
		$this->add_control(
			'psm_style',
			[
				'label' => esc_html__('Style', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__('Style 1', 'petrona'),
					'style-2'  => esc_html__('Style 2', 'petrona'),
				],
			]
		);
		$this->add_control(
			'psm_style2_in',
			[
				'label' => esc_html__('Layout', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'after-label',
				'options' => [
					'after-label'  => esc_html__('Default', 'petrona'),
					'after-field'  => esc_html__('Bottom', 'petrona'),
					'inline-filed'  => esc_html__('Inline', 'petrona'),
				],
				'condition' => [
					'psm_style' => 'style-2',
				],
			]
		);
		$this->add_control(
			'psm_text_switch',
			[
				'label' => esc_html__('Label', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'psm_text',
			[
				'label'     => esc_html__('Label Text', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Password Strength : ', 'petrona'),
				'placeholder'   => esc_html__('Enter Label', 'petrona'),
				'condition' => [
					'psm_text_switch' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*Password Strength Meter end*/

		/*reset password start*/
		$this->start_controls_section(
			'content_reset_pass_section',
			[
				'label' => esc_html__('Reset Password', 'petrona'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'form_selection' => ['ox_forgot_password'],
					'f_p_opt' => 'f_p_frontend',
				],
			]
		);
		$this->add_control(
			'res_pass_label_switch',
			[
				'label' => esc_html__('Label', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'res_pass_label',
			[
				'label'     => esc_html__('Label', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Reset Password', 'petrona'),
				'condition' => [
					'res_pass_label_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'res_pass_placeholder',
			[
				'label'     => esc_html__('Placeholder', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('****', 'petrona'),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'res_conf_pass_placeholder',
			[
				'label'     => esc_html__('Confirm Password Placeholder', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('****', 'petrona'),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'reset_pass_btn',
			[
				'label'   => esc_html__('Password Button Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Reset Password', 'petrona'),
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*reset password end*/

		/*forgot password start*/
		$this->start_controls_section(
			'section_forms_loast_pass_options',
			[
				'label' => esc_html__('Lost Password Options', 'petrona'),
				'conditions'   => [
					'terms' => [
						[
							'relation' => 'or',
							'terms'    => [
								[
									'name'     => 'form_selection', 'operator' => '==', 'value'    => 'ox_forgot_password',
								],
								[
									'name'     => 'show_lost_password', 'operator' => '==', 'value'    => 'yes',
								],
							],
						],
					],
				],
			]
		);
		$this->add_control(
			'lost_pass_label_switch',
			[
				'label' => esc_html__('Label', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'lost_pass_label',
			[
				'label'     => esc_html__('Label', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Username/Email', 'petrona'),
				'condition' => [
					'lost_pass_label_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'lost_pass_placeholder',
			[
				'label'     => esc_html__('Placeholder', 'petrona'),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__('Username/Email', 'petrona'),
			]
		);
		$this->add_control(
			'forgot_pass_btn',
			[
				'label'   => esc_html__('Button Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Email Reset Link', 'petrona'),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'lost_password_heading_desc',
			[
				'label' => esc_html__('Heading', 'petrona'),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'rows' => 10,
				'default' => esc_html__('Lost your password?', 'petrona'),
				'placeholder' => esc_html__('Type your Lost password description here', 'petrona'),
			]
		);

		$this->add_control(
			'ox_cst_email_lost_opt',
			[
				'label' => esc_html__('Custom Email', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$EMtitle1 = get_option('blogname');
		$subject1 = sprintf(__('Someone has requested a password reset for the following account from %s!', 'petrona'), $EMtitle1);

		$this->add_control(
			'ox_cst_email_lost_subject',
			[
				'label'       => __('Email Subject', 'petrona'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => $subject1,
				'default'     => $subject1,
				'label_block' => true,
				'render_type' => 'none',
				'condition' => [
					'ox_cst_email_lost_opt' => 'yes',
				],
			]
		);
		$this->add_control(
			'ox_cst_email_lost_message',
			[
				'label' => esc_html__('Email Message', 'petrona'),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => __('Enter Email Message', 'petrona'),
				'default'     => sprintf(__('Dear [oxlr_username],<br/>Someone has requested a password reset for the following %1$s account.<br/>If this was a mistake, just ignore this email and nothing will happen.<br/>To reset your password, visit the following address:<br/> [oxlr_link]', 'petrona'), $EMtitle1),
				'description' => 'Fields : [oxlr_sitename] , [oxlr_username] , [oxlr_link]',
				'label_block' => true,
				'render_type' => 'none',
				'condition' => [
					'ox_cst_email_lost_opt' => 'yes',
				]
			]
		);
		$this->end_controls_section();
		/*forgot password end*/

		/*My Account Menu*/
		$this->start_controls_section(
			'section_forms_after_login_panel_options',
			[
				'label' => esc_html__('My Account Menu', 'petrona'),
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
				],
			]
		);
		$this->add_control(
			'show_logged_in_message',
			[
				'label'   => esc_html__('My Account Menu', 'petrona'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'description'   => esc_html__('Note : This feature will not work in backend. Only logged-in users of your website will be able to see that at frontend.', 'petrona'),
			]
		);
		$this->add_control(
			'after_login_panel_align',
			[
				'label' => esc_html__('Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__('Start', 'petrona'),
						'icon' => ! is_rtl() ? 'fa fa-align-left' : 'fa fa-align-right',
					],
					'center' => [
						'title' => esc_html__('Center', 'petrona'),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => esc_html__('End', 'petrona'),
						'icon' => ! is_rtl() ? 'fa fa-align-right' : 'fa fa-align-left',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf.aflp' => 'justify-content: {{VALUE}};display:flex',
				],
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'standard_layout',
			[
				'label' => esc_html__('Inline Layout', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'hide_u_avtar',
			[
				'label' => esc_html__('User Avatar', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);

		$this->add_control(
			'pre_u_name',
			[
				'label' => esc_html__('Prefix User Name', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);

		$this->add_control(
			'pre_u_name_text',
			[
				'label'   => esc_html__('Prefix User Name Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_logged_in_message' => 'yes',
					'pre_u_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'hide_u_name',
			[
				'label' => esc_html__('User Name', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'suf_u_name',
			[
				'label' => esc_html__('Suffix User Name', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'suf_u_name_text',
			[
				'label'   => esc_html__('Suffix User Name Text', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'condition' => [
					'show_logged_in_message' => 'yes',
					'suf_u_name' => 'yes',
				],
			]
		);
		$this->add_control(
			'user_text_switch',
			[
				'label' => esc_html__('User Name on Mobile', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'edit_profile_text_switch',
			[
				'label' => esc_html__('Edit Profile', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'edit_profile_text',
			[
				'label'   => esc_html__('Title', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Edit Profile', 'petrona'),
				'condition' => [
					'show_logged_in_message' => 'yes',
					'edit_profile_text_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text_logout_switch',
			[
				'label' => esc_html__('Logout', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_text_logout',
			[
				'label'   => esc_html__('Title', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Logout', 'petrona'),
				'condition' => [
					'show_logged_in_message' => 'yes',
					'button_text_logout_switch' => 'yes',
				],
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'loop_title',
			[
				'label' => esc_html__('Title', 'petrona'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Download', 'petrona'),
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'loop_url_link',
			[
				'label' => esc_html__('Link', 'petrona'),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://your-link.com', 'petrona'),
				'show_external' => true,
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$this->add_control(
			'loop_content',
			[
				'label' => esc_html__('Extra Menu', 'petrona'),
				'type' => Controls_Manager::REPEATER,
				'separator' => 'before',
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ loop_title }}}',
				'condition' => [
					'show_logged_in_message' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*my account panel end*/

		/*notification start*/
		$this->start_controls_section(
			'section_msg_options',
			[
				'label' => esc_html__('Notification Message', 'petrona'),
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
				],
			]
		);
		$this->add_control(
			'login_msg',
			[
				'label' => esc_html__('Login Message Option', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_loading_txt',
			[
				'label' => esc_html__('Loading text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Please Wait...', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_success',
			[
				'label' => esc_html__('Success text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Login successful.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_validation',
			[
				'label' => esc_html__('Validation text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Ops! Wrong username or password!', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'login_msg_error',
			[
				'label' => esc_html__('Error text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Something went wrong. Please try again.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'register_msg',
			[
				'label' => esc_html__('Register Message Option', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'reg_msg_loading',
			[
				'label' => esc_html__('Loading text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Please wait...', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);

		$this->add_control(
			'reg_msg_success',
			[
				'label' => esc_html__('Success text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Registration Successful.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'reg_msg_email_duplication',
			[
				'label' => esc_html__('Email Validate', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('An account already exists with this email address.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'reg_msg_error',
			[
				'label' => esc_html__('Error Text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Something went wrong. Please try again.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);

		$this->add_control(
			'forgot_msg',
			[
				'label' => esc_html__('Lost Password Message Option', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'fp_msg_loading',
			[
				'label' => esc_html__('Loading text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Please wait...', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
			]
		);
		$this->add_control(
			'fp_msg_success',
			[
				'label' => esc_html__('Success text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Mail sent. Please check your mailbox.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
			]
		);
		$this->add_control(
			'fp_msg_error',
			[
				'label' => esc_html__('Error text', 'petrona'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Something went wrong. Please try again.', 'petrona'),
				'placeholder' => esc_html__('Type here', 'petrona'),
			]
		);
		$this->end_controls_section();
		/*section  end*/

		/*Layout width option login start*/
		$this->start_controls_section(
			'log_section_layout_size_options',
			[
				'label' => esc_html__('Login Fields Width', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
				],
			]
		);
		$this->add_responsive_control(
			'l_ls_user_name',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('User Name', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-l-lr-user-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'l_ls_password',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Password', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-l-lr-password' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'l_ls_rememberme',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Remember Me', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-remember-me' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*Layout width option login end*/

		/*Layout width option register start*/
		$this->start_controls_section(
			'section_layout_size_options',
			[
				'label' => esc_html__('Register Fields Width', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_responsive_control(
			'ls_fisrt_name',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('First Name', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-first-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ls_last_name',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Last Name', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-last-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ls_user_name',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('User Name', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-user-name' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ls_email_field',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Email', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-email' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ls_password_field',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Password', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-user-pass,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-user-conf-pass' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_responsive_control(
			'ls_terms_condition_field',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Terms & Conditions', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-tac' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ls_aditional_msg_field',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Additional Message', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked .ox-lr-f-add-msg' => 'width: {{SIZE}}%;display: inline-flex;flex-direction: column;',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*Layout width option end*/

		/*custom validation reg form start*/
		$this->start_controls_section(
			'section_cst_validation_options',
			[
				'label' => esc_html__('Validation Error Messages', 'petrona'),
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
				],
			]
		);
		$this->add_control(
			'cst_validation_switch',
			[
				'label' => esc_html__('Override Validation Error Message', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'v_efn',
			[
				'label'   => esc_html__('First Name', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Invalid First Name Value.', 'petrona'),
				'condition' => [
					'cst_validation_switch' => 'yes',
					'ox_dis_name_field' => 'yes',
					'ox_dis_fname_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'v_eln',
			[
				'label'   => esc_html__('Last Name', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Invalid Last Name Value.', 'petrona'),
				'condition' => [
					'cst_validation_switch' => 'yes',
					'ox_dis_name_field' => 'yes',
					'ox_dis_lname_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'v_eun',
			[
				'label'   => esc_html__('User Name', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Enter User Name', 'petrona'),
				'condition' => [
					'cst_validation_switch' => 'yes',
					'ox_dis_username_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'v_eemail',
			[
				'label'   => esc_html__('Email', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Invalid Email Address.', 'petrona'),
				'condition' => [
					'cst_validation_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'v_epass',
			[
				'label'   => esc_html__('Password', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Password doesn\'t pass required criteria.',
				'condition' => [
					'cst_validation_switch' => 'yes',
					'ox_dis_pass_field' => 'yes',
				],
			]
		);
		$this->add_control(
			'v_erepass',
			[
				'label'   => esc_html__('Confirm Password', 'petrona'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Enter Confirm Password', 'petrona'),
				'condition' => [
					'cst_validation_switch' => 'yes',
					'ox_dis_pass_field' => 'yes',
					'ox_dis_conf_pass_field' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*custom validation reg form end*/

		/*Reset Password start*/
		$this->start_controls_section(
			'section_reset_pass_options',
			[
				'label' => esc_html__('Reset Password Option', 'petrona'),
			]
		);
		$this->add_control(
			'ox_dp_reset_field_strong',
			[
				'label' => esc_html__('Strong Password Required', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'petrona'),
				'label_off' => esc_html__('Disable', 'petrona'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'ox_convert_rest_form',
			[
				'label' => esc_html__('Login/Register Form Override', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'yes',
			]
		);
		$this->end_controls_section();
		/*Layout width option login end*/

		/*style start*/
		/*label style start*/
		$this->start_controls_section(
			'section_label_style',
			[
				'label' => esc_html__('Form Label', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .ox-field-group .ox-form-label,{{WRAPPER}} .ox-form-stacked-fp .ox-form-label,
				{{WRAPPER}} .ox-form-stacked-reset .ox-form-label',
			]
		);
		$this->add_control(
			'label_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '#888',
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-form-label,{{WRAPPER}} .ox-form-stacked-fp .ox-form-label,
				{{WRAPPER}} .ox-form-stacked-reset .ox-form-label' => 'color:{{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*label style end*/

		/*field style start*/
		$this->start_controls_section(
			'section_field_style',
			[
				'label' => esc_html__('Form Input Fields', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'selector' => '{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input',
			]
		);
		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__('Placeholder Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input::placeholder,
					{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input::placeholder,
					{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input::placeholder' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_responsive_control(
			'input_inner_padding',
			[
				'label' => esc_html__('Inner Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'input_inner_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs('tabs_input_field_style');
		$this->start_controls_tab(
			'tab_input_field_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'input_field_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_input_field_focus',
			[
				'label' => esc_html__('Focus', 'petrona'),
			]
		);
		$this->add_control(
			'input_field_focus_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input:focus,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input:focus,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_focus_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input:focus,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input:focus,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'input_border_options',
			[
				'label' => esc_html__('Border Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'box_border',
			[
				'label' => esc_html__('Box Border', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
			]
		);

		$this->add_control(
			'border_style',
			[
				'label' => esc_html__('Border Style', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => $this->techt_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'border-style: {{VALUE}} !important;',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'box_border_width',
			[
				'label' => esc_html__('Border Width', 'petrona'),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs('tabs_border_style');
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__('Focus', 'petrona'),
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input:focus,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input:focus,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input:focus' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input:focus,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input:focus,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'shadow_options',
			[
				'label' => esc_html__('Box Shadow Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs('tabs_shadow_style');
		$this->start_controls_tab(
			'tab_shadow_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_shadow_hover',
			[
				'label' => esc_html__('Focus', 'petrona'),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_active_shadow',
				'selector' => '{{WRAPPER}} .ox-field-group .ox-form-controls .ox-input:focus,{{WRAPPER}} .ox-form-stacked-fp .ox-ulp-input-group .ox-input:focus,{{WRAPPER}} .ox-form-stacked-reset .ox-ulp-input-group .ox-input:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*field style end*/

		/*button style start*/
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__('Form Button', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_align',
			[
				'label' => esc_html__('Button Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
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
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .elementor-field-type-submit.ox-field-group' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_text_align',
			[
				'label' => esc_html__('Text Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
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
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .elementor-field-type-submit.ox-field-group .ox-button,
					{{WRAPPER}} .ox-forg-pass-form .ox-form-stacked-fp button.ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'button_max_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'petrona'),
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,
					{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'max-width: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass',
			]
		);
		$this->add_responsive_control(
			'button_inner_padding',
			[
				'label' => esc_html__('Inner Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs('tabs_button_style');
		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__('Text Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__('Text Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button:hover,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp:hover,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button:hover,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp:hover,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_border_options',
			[
				'label' => esc_html__('Border Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'button_box_border',
			[
				'label' => esc_html__('Box Border', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
			]
		);

		$this->add_control(
			'button_border_style',
			[
				'label' => esc_html__('Border Style', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => $this->techt_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'border-style: {{VALUE}} !important;',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_box_border_width',
			[
				'label' => esc_html__('Border Width', 'petrona'),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs('tabs_button_border_style');
		$this->start_controls_tab(
			'tab_button_border_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'button_box_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_border_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_control(
			'button_box_border_hover_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button:hover,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp:hover,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass:hover' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_border_hover_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button:hover,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp:hover,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_shadow_options',
			[
				'label' => esc_html__('Box Shadow Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs('tabs_button_shadow_style');
		$this->start_controls_tab(
			'tab_button_shadow_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_shadow_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .ox-form-stacked .elementor-field-type-submit .ox-button:hover,{{WRAPPER}} .ox-form-stacked-fp  .ox-button-fp:hover,{{WRAPPER}} .ox-reset-pass-form .ox-form-stacked-reset button.ox-button-reset-pass:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*button style end*/

		/*hover/click/popup style start*/
		$this->start_controls_section(
			'section_hover_click_popup_style',
			[
				'label' => esc_html__('Hover/Click/Popup Button', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
					'_skin!' => 'default',
				],
			]
		);
		$this->add_responsive_control(
			'tab_icon_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Right Padding', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
				    '{{WRAPPER}} .ox-wp-lrcf .elementor-button-content-wrapper i,
                    {{WRAPPER}} .ox-wp-lrcf .elementor-button-content-wrapper svg,
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap .ox-ursp-btn i' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'tab_icon_size_font',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .elementor-button-content-wrapper i,
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap .ox-ursp-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ox-wp-lrcf .elementor-button-content-wrapper svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}'
				],
			]
		);
		$this->add_control(
			'tab_icon_color_n',
			[
				'label' => esc_html__('Normal Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .elementor-button-content-wrapper i,
					    {{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap .ox-ursp-btn i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ox-wp-lrcf .elementor-button-content-wrapper svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tab_icon_color_h',
			[
				'label' => esc_html__('Hover Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf a:hover .elementor-button-content-wrapper i,
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap .ox-ursp-btn:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .ox-wp-lrcf a:hover .elementor-button-content-wrapper svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'hcp_button_max_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'petrona'),
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'max-width: {{SIZE}}{{UNIT}} !important;width: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'hcp_button_typography',
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn',
			]
		);
		$this->add_responsive_control(
			'hcp_button_inner_padding',
			[
				'label' => esc_html__('Inner Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'hcp_button_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs('tabs_hcp_button_style');
		$this->start_controls_tab(
			'tab_hcp_button_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'hcp_button_color',
			[
				'label'     => esc_html__('Text Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hcp_button_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_hcp_button_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_control(
			'hcp_button_hover_color',
			[
				'label'     => esc_html__('Text Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn:hover,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hcp_button_hover_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn:hover,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown:hover,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn:hover,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn:hover,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown:hover,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn:hover,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn:hover,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown:hover,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'hcp_button_border_options',
			[
				'label' => esc_html__('Border Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'hcp_button_box_border',
			[
				'label' => esc_html__('Box Border', 'petrona'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Show', 'petrona'),
				'label_off' => esc_html__('Hide', 'petrona'),
				'default' => 'no',
			]
		);

		$this->add_control(
			'hcp_button_border_style',
			[
				'label' => esc_html__('Border Style', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => $this->techt_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'border-style: {{VALUE}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'hcp_button_box_border_width',
			[
				'label' => esc_html__('Border Width', 'petrona'),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs('tabs_hcp_button_border_style');
		$this->start_controls_tab(
			'tab_hcp_button_border_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'hcp_button_box_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'hcp_button_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_hcp_button_border_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_control(
			'hcp_button_box_border_hover_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn:hover,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn:hover' => 'border-color: {{VALUE}} !important;',
				],
				'condition' => [
					'hcp_button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'hcp_button_border_hover_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn:hover,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown:hover,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'hcp_button_shadow_options',
			[
				'label' => esc_html__('Box Shadow Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs('tabs_hcp_button_shadow_style');
		$this->start_controls_tab(
			'tab_hcp_button_shadow_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hcp_button_shadow',
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown,
							{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown,
							{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown,
							{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_hcp_button_shadow_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hcp_button_hover_shadow',
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-lr-model-btn:hover,
						{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .ox-button-dropdown:hover,
						{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-ulsp-btn:hover,
						{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-lr-model-btn:hover,
						{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .ox-button-dropdown:hover,
						{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-ursp-btn:hover,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-btn:hover,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-button-dropdown:hover,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*hover/click/popup style end*/

		/*close image option start*/
		$this->start_controls_section(
			'section_close_img_style',
			[
				'label' => esc_html__('Close Button', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'_skin' => ['ox-modal', 'ox-popup'],
				],
			]
		);

		$this->add_responsive_control(
			'close_icon_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'close_icon_size',
			[
				'label' => esc_html__('Width', 'petrona'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs('tabs_close_button_style');
		$this->start_controls_tab(
			'tab_close_button_normal',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'close_button_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'close_button_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => 
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_close_button_hover',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_control(
			'close_button_hover_color',
			[
				'label'     => esc_html__('Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'close_button_hover_bg',
				'types'     => ['classic', 'gradient'],
				'selector' => 
							'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'close_icon_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img',
			]
		);
		$this->add_responsive_control(
			'close_icon_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'close_icon_box_shadow',
				'label' => esc_html__('Box Shadow', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-modal .lr-close-custom_img,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .lr-close-custom_img',
			]
		);

		$this->end_controls_section();
		/*close image option end*/

		/*form heading option start*/
		$this->start_controls_section(
			'section_form_heading_style',
			[
				'label' => esc_html__('Heading Option', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_heading_typography',
				'selector' => '{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-header h2,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-popup-header h2,
					{{WRAPPER}} .ox-l-r-main-wrapper .ox-tab-content-inner.tab-signup .ox-popup-header h2,
					{{WRAPPER}} .ox-user-login ox-user-login-skin-modal .ox-modal-header h2,
					{{WRAPPER}} .ox-user-login ox-user-login-skin-popup .ox-popup-header h2,
					{{WRAPPER}} .ox-l-r-main-wrapper .ox-tab-content-inner.tab-login .ox-popup-header h2,
					{{WRAPPER}} .ox-form-stacked-fp .ox-forgot-password-label,
					{{WRAPPER}} .ox-form-stacked-fp .ox-forgot-password-label p,
					{{WRAPPER}} .ox-wp-lrcf .ox-modal-title,{{WRAPPER}} .ox-wp-lrcf .ox-modal-title p,
					{{WRAPPER}} .ox-wp-lrcf .ox-popup-header,{{WRAPPER}} .ox-wp-lrcf .ox-popup-header p',
			]
		);
		$this->add_control(
			'form_heading_color',
			[
				'label' => esc_html__('Heading Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-header h2,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-popup-header h2,
					{{WRAPPER}} .ox-l-r-main-wrapper .ox-tab-content-inner.tab-signup .ox-popup-header h2,
					{{WRAPPER}} .ox-user-login ox-user-login-skin-modal .ox-modal-header h2,
					{{WRAPPER}} .ox-user-login ox-user-login-skin-popup .ox-popup-header h2,
					{{WRAPPER}} .ox-l-r-main-wrapper .ox-tab-content-inner.tab-login .ox-popup-header h2,
					{{WRAPPER}} .ox-form-stacked-fp .ox-forgot-password-label,
					{{WRAPPER}} .ox-form-stacked-fp .ox-forgot-password-label p,
					{{WRAPPER}} .ox-wp-lrcf .ox-modal-title,{{WRAPPER}} .ox-wp-lrcf .ox-modal-title p,
					{{WRAPPER}} .ox-wp-lrcf .ox-popup-header,{{WRAPPER}} .ox-wp-lrcf .ox-popup-header p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*form heading option end*/

		/*register  Additional msg option start*/
		$this->start_controls_section(
			'section_form_reg_adi_msg_style',
			[
				'label' => esc_html__('Register Additional Message', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_additional_message' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_reg_adi_msg_typography',
				'selector' => '{{WRAPPER}} .ox-field-group .ox-register-additional-message',
			]
		);
		$this->add_control(
			'form_reg_adi_msgcolor',
			[
				'label' => esc_html__('Heading Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .ox-register-additional-message' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*register  Additional msg option end*/

		/*rememberme start*/
		$this->start_controls_section(
			'section_remember_me_style',
			[
				'label' => esc_html__('Remember Me', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['ox_login', 'ox_login_register'],
					'show_remember_me' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'checkbox_typography',
				'selector' => '{{WRAPPER}} .ox-field-group.ox-remember-me .ox-form-label .remember-me-label',
			]
		);
		$this->add_control(
			'checked_txt_color',
			[
				'label'     => esc_html__('Remember Me color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group.ox-remember-me .ox-form-label .remember-me-label' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'unchecked_field_bgcolor',
			[
				'label'     => esc_html__('UnChecked Bg Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group.ox-remember-me [type="checkbox"]:checked + label:before,
					{{WRAPPER}} .ox-field-group.ox-remember-me [type="checkbox"]:not(:checked) + label:before' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'checked_field_bgcolor',
			[
				'label'     => esc_html__('Checked Color', 'petrona'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group.ox-remember-me [type="checkbox"]:checked + label:after,
					{{WRAPPER}} .ox-field-group.ox-remember-me [type="checkbox"]:not(:checked) + label:after' => 'background: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*remember me end*/

		/*show/hide password start*/
		$this->start_controls_section(
			'section_shp_style',
			[
				'label' => esc_html__('Show Hide Password Toggle', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_dis_show_pass_icon' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'sphsize',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Size', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-show i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'sphcolor',
			[
				'label' => esc_html__('Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-show i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'sphtopoffset',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Top Offset', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-show' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			'sphrightffset',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Right Offset', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-show' => 'right: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'sphtraN',
			[
				'label' => esc_html__('Transform css Normal', 'petrona'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('skew(-25deg)', 'petrona'),
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-show' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};'
				],
			]
		);
		$this->add_control(
			'sphtraH',
			[
				'label' => esc_html__('Transform css Hover', 'petrona'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__('skew(-25deg)', 'petrona'),
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-show:hover' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};'
				],
			]
		);
		$this->end_controls_section();
		/*show/hide password start*/

		/*Lost Password/Register Text Styling option start*/
		$this->start_controls_section(
			'section_extra_link_opt_style',
			[
				'label' => esc_html__('Lost Password/Register Text', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_extra_link_typography',
				'selector' => '{{WRAPPER}} .ox-user-login-password .ox-lost-password,
				{{WRAPPER}} .ox-user-login-password .ox-register,
				{{WRAPPER}} .ox-user-register-password .ox-login',
			]
		);
		$this->add_control(
			'form_extra_link_color',
			[
				'label' => esc_html__('Text color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-login-password .ox-lost-password,
				{{WRAPPER}} .ox-user-login-password .ox-register,
				{{WRAPPER}} .ox-user-register-password .ox-login' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'form_extra_link_space',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Right Space', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-login-password .ox-lost-password,
				{{WRAPPER}} .ox-user-login-password .ox-register,
				{{WRAPPER}} .ox-user-register-password .ox-login' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'form_extra_link_before_text',
			[
				'label' => __('Before Text Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_extra_link_before_text_typography',
				'selector' => '{{WRAPPER}} .ox-field-group .login-before-text',
			]
		);
		$this->add_control(
			'form_extra_link_before_text_color',
			[
				'label' => esc_html__('Text color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-field-group .login-before-text' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*Lost Password/Register Text Styling option end*/

		/*Lost Password Back Arrow Styling start*/
		$this->start_controls_section(
			'section_lost_pass_btn_style',
			[
				'label' => esc_html__('Lost Password Back Arrow', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection!' => ['ox_forgot_password'],
					'show_lost_password' => 'yes',
				],
			]
		);
		$this->add_control(
			'lpba_icon',
			[
				'label' => esc_html__('Back Arrow', 'petrona'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => is_rtl() ? 'fa fa-arrow-circle-right' : 'fa fa-arrow-circle-left',
					'library' => 'solid',
				],
			]
		);
		$this->add_responsive_control(
			'lost_pass_btn_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 300,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked-fp .ox-lpu-back i:before' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_control(
			'lost_pass_btn_color',
			[
				'label' => esc_html__('Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ox-form-stacked-fp .ox-lpu-back i:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*Lost Password Back Arrow Styling end*/

		/*password hint start*/
		$this->start_controls_section(
			'section_pass_hint_style',
			[
				'label' => esc_html__('Password Hint', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_hint' => 'yes',
				],
			]
		);
		$this->add_control(
			'ph_click_icon_h',
			[
				'label' => esc_html__('Click Icon Styling', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'condition' => [
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_responsive_control(
			'ph_click_icon_topoffset',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Top Offset', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-showh' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_responsive_control(
			'ph_click_icon_rightoffset',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Right Offset', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-showh' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_responsive_control(
			'ph_click_icon_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-showh' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_control(
			'ph_click_icon_n',
			[
				'label' => esc_html__('Icon Normal Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-showh' => 'color: {{VALUE}};',
				],
				'condition' => [
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_control(
			'ph_click_icon_s',
			[
				'label' => esc_html__('Icon Success Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-lr-f-user-pass .ox-password-field-showh.ox-done' => 'color: {{VALUE}};',
				],
				'condition' => [
					'dis_pass_hint_on' => 'pshc',
				],
			]
		);
		$this->add_control(
			'ph_list_h',
			[
				'label' => esc_html__('List Styling', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ph_list_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'ph_list_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ph_list_typography',
				'selector' => '{{WRAPPER}} .ox-user-register .ox-pass-indicator li',
			]
		);
		$this->add_control(
			'ph_list_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator li' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'ph_listicon_color',
			[
				'label' => esc_html__('Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator li .ox-pass-success-ind' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'ph_listfill_color',
			[
				'label' => esc_html__('Success Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator li .ox-pass-success-ind' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'ph_list_background',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .ox-user-register .ox-pass-indicator li',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'ph_list_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-register .ox-pass-indicator li',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ph_list_br',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ph_list_shadow',
				'selector' => '{{WRAPPER}} .ox-user-register .ox-pass-indicator li',
			]
		);
		$this->add_control(
			'ph_list_box_h',
			[
				'label' => esc_html__('List Box Styling', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_field_strong' => 'yes',
					'ox_dis_pass_hint' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'ph_listb_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'ph_listb_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'ph_listb_background',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .ox-user-register .ox-pass-indicator',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'ph_listb_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-register .ox-pass-indicator',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'ph_listb_br',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-register .ox-pass-indicator' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ph_listb_shadow',
				'selector' => '{{WRAPPER}} .ox-user-register .ox-pass-indicator',
			]
		);
		$this->end_controls_section();
		/*password hint end*/

		/*terms & condition style start*/
		$this->start_controls_section(
			'section_t_a_c_style',
			[
				'label' => esc_html__('Terms & Conditions', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ox_terms_condition_opt' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tac_typography',
				'selector' => '{{WRAPPER}} .ox-wp-lrcf .ox-lr-f-tac .ox-form-label',
			]
		);
		$this->add_control(
			'tac_dyn_color',
			[
				'label' => esc_html__('Text Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '#888',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-lr-f-tac .ox-form-label' => 'color:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tac_chk_box_opt',
			[
				'label' => __('Checkbox Options', 'petrona'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs('tac_ckhbox_tabs');
		$this->start_controls_tab(
			'tac_unchk_tab',
			[
				'label' => esc_html__('Uncheck', 'petrona'),
			]
		);
		$this->add_control(
			'tac_unchk_bg',
			[
				'label' => esc_html__('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .user_tac_checkbox' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'tac_unchk_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .user_tac_checkbox' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tac_chk_tab',
			[
				'label' => esc_html__('Check', 'petrona'),
			]
		);
		$this->add_control(
			'tac_chk_bg',
			[
				'label' => esc_html__('Check Icon Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .user_tac_checkbox:before,{{WRAPPER}} .ox-wp-lrcf .user_tac_checkbox:after' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*LR combo style start*/
		$this->start_controls_section(
			'section_lr_tabbing_style',
			[
				'label' => esc_html__('Login/Register Tabbing', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => 'ox_login_register',
				],
			]
		);
		$this->add_responsive_control(
			'lr_tabbing_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lr_tabbing_typo',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_tabbing_max_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'petrona'),
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab' => 'max-width: {{SIZE}}{{UNIT}} !important;min-width: {{SIZE}}{{UNIT}} !important',
				],
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs('lr_combo_tabs');
		$this->start_controls_tab(
			'lr_combo_normal_tab',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'lr_combo_color_normal',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_combo_bg_normal',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lr_combo_border_normal',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_combo_border_radious_normal',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_combo_shadow_normal',
				'selector' => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'lr_combo_active_tab',
			[
				'label' => esc_html__('Active', 'petrona'),
			]
		);
		$this->add_control(
			'lr_combo_color_active',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab.active' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_combo_bg_active',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab.active',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lr_combo_border_active',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab.active',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_combo_border_radious_active',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_combo_shadow_active',
				'selector' => '{{WRAPPER}} .ox-lr-cl-100per .ox-l-r-main-wrapper .ox-l-r-tab.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
		/*LR combo style start*/

		/*Notification Message style start*/
		$this->start_controls_section(
			'section_ajax_msg_option_style',
			[
				'label' => esc_html__('Notification Message Option', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ajax_msg_typography',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .techt-notification.active .ox-lr-response',
			]
		);
		$this->add_control(
			'ajax_msg_color',
			[
				'label' => esc_html__('Text Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .techt-notification.active .ox-lr-response' => 'color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ajax_bg',
				'label' => esc_html__('Notification Background', 'petrona'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .techt-notification.active',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*Notification Message style END*/

		/*Custom Validation Styling start*/
		$this->start_controls_section(
			'section_custom_validation_style',
			[
				'label' => esc_html__('Custom Validation', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'cst_validation_switch' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'rcv_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-form-stacked .ox-reg-form-error-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'rcv_offset',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Offset', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'separator' => 'after',
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-form-stacked .ox-reg-form-error-field' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rcv_typography',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-wp-lrcf .ox-form-controls .ox-reg-form-error-field',
			]
		);
		$this->add_control(
			'rcv_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ox-wp-lrcf .ox-form-controls .ox-reg-form-error-field' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rcv_bg_color',
			[
				'label' => esc_html__('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .ox-form-stacked .ox-reg-form-error-field' => 'background: {{VALUE}}',
					'{{WRAPPER}} .ox-user-register .ox-form-stacked .ox-reg-form-error-field:before' => 'border-color: {{VALUE}}  transparent transparent transparent',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'rcv_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-register .ox-form-stacked .ox-reg-form-error-field',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'rcv_br',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-register .ox-form-stacked .ox-reg-form-error-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		/*Custom Validation Styling end*/

		/*Reset mail Message style start*/
		$this->start_controls_section(
			'section_reset_mail_option_style',
			[
				'label' => esc_html__('Reset Mail Expired/Invalid', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['ox_forgot_password'],
					'f_p_opt' => 'f_p_frontend',
				],
			]
		);
		$this->add_responsive_control(
			'rmt_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-invalid-expired-key' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'rmt_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-invalid-expired-key' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'rmt_alignment',
			[
				'label' => esc_html__('Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
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
				'default' => 'left',
				'selectors'  => [
					'{{WRAPPER}} .ox-invalid-expired-key' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'rmt_typography',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-invalid-expired-key',
			]
		);
		$this->add_control(
			'rmt_msg_color',
			[
				'label' => esc_html__('Text Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ox-invalid-expired-key' => 'color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'rmt_bg',
				'label' => esc_html__('Background', 'petrona'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-invalid-expired-key',
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'rmt_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-invalid-expired-key',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'rmt_radius',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-invalid-expired-key' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'rmt_shadow',
				'selector' => '{{WRAPPER}} .ox-invalid-expired-key',
			]
		);
		$this->end_controls_section();
		/*reset mail Message style END*/

		/*password strength start*/
		$this->start_controls_section(
			'section_psm_style',
			[
				'label' => esc_html__('Password Strength Meter', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => ['ox_register', 'ox_login_register'],
					'ox_dis_pass_field' => 'yes',
					'ox_dis_pass_meter' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'psm_margin_box',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'psm_label_heading',
			[
				'label' => 'Label Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'psm_label_typography',
				'selector' => '{{WRAPPER}} .ox-user-register .password-strength-wrapper',
			]
		);
		$this->add_control(
			'psm_label_color_n',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'psm_label_background',
				'label' => esc_html__('Background', 'petrona'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .ox-user-register .password-strength-wrapper',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'psm_label_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-register .password-strength-wrapper',
			]
		);
		$this->add_responsive_control(
			'psm_label_br',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'psm_label_shadow',
				'selector' => '{{WRAPPER}} .ox-user-register .password-strength-wrapper',
			]
		);
		$this->add_control(
			'psm_message_heading',
			[
				'label' => 'Message Common Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'psm_c_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'psm_c_typography',
				'selector' => '{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength',
			]
		);
		$this->add_control(
			'psm_c_border_style',
			[
				'label' => esc_html__('Border Type', 'petrona'),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__('None', 'petrona'),
					'solid' => esc_html__('Solid', 'petrona'),
					'dashed' => esc_html__('Dashed', 'petrona'),
					'dotted' => esc_html__('Dotted', 'petrona'),
					'groove' => esc_html__('Groove', 'petrona'),
					'inset' => esc_html__('Inset', 'petrona'),
					'outset' => esc_html__('Outset', 'petrona'),
					'ridge' => esc_html__('Ridge', 'petrona'),
				],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'psm_c_border_width',
			[
				'label' => esc_html__('Border Width', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'psm_short_heading',
			[
				'label' => 'Short Message Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'psm_short_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.short' => 'color:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_short_bg',
			[
				'label' => esc_html__('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.short' => 'background:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_short_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.short' => 'border-color:{{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'psm_short_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.short' => 'width: {{SIZE}}%;',
				],
			]
		);
		$this->add_control(
			'psm_bad_heading',
			[
				'label' => 'Bad Message Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'psm_bad_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.bad' => 'color:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_bad_bg',
			[
				'label' => esc_html__('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.bad' => 'background:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_bad_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.bad' => 'border-color:{{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'psm_bad_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.bad' => 'width: {{SIZE}}%;',
				],
			]
		);
		$this->add_control(
			'psm_good_heading',
			[
				'label' => 'Good Message Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'psm_good_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.good' => 'color:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_good_bg',
			[
				'label' => esc_html__('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.good' => 'background:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_good_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.good' => 'border-color:{{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'psm_good_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.good' => 'width: {{SIZE}}%;',
				],
			]
		);
		$this->add_control(
			'psm_strong_heading',
			[
				'label' => 'Strong Message Option',
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'psm_strong_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.strong' => 'color:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_strong_bg',
			[
				'label' => esc_html__('Background Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.strong' => 'background:{{VALUE}};',
				],
			]
		);
		$this->add_control(
			'psm_strong_border_color',
			[
				'label' => esc_html__('Border Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.strong' => 'border-color:{{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'psm_strong_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'petrona'),
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-user-register .password-strength-wrapper.show #password-strength.strong' => 'width: {{SIZE}}%;',
				],
			]
		);
		$this->end_controls_section();
		/*password strength end*/

		/*logoutstyle start*/
		$this->start_controls_section(
			'section_logout_style',
			[
				'label' => esc_html__('My Account Menu', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'after_login_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .ox-user-login' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'after_login_panel_text_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'petrona'),
				'size_units' => ['px', 'vw'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 300,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .ox-user-login' => 'width: {{SIZE}}{{UNIT}};',
				],
				
			]
		);
		$this->add_responsive_control(
			'after_login_panel_position',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Position', 'petrona'),
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .ox-user-login' => is_rtl() ? 'left: {{SIZE}}{{UNIT}};' : 'right: {{SIZE}}{{UNIT}};',
				],
				
			]
		);
		$this->add_responsive_control(
			'after_login_panel_text',
			[
				'label' => esc_html__('Alignment', 'petrona'),
				'type' => Controls_Manager::CHOOSE,
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
					'justify' => [
						'title' => esc_html__('Justify', 'petrona'),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .ox-user-login ul li' => 'text-align: {{VALUE}};justify-content: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'after_login_typography',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper *,
						{{WRAPPER}} .after_login_btn_wrapper .ox-user-login .ox-list .ox-user-logged-out .ox-button,
						{{WRAPPER}} .after_login_btn_wrapper .ox-user-login ul .ox-user-name a,
						{{WRAPPER}} .after_login_btn_wrapper .ox-user-login ul .after_login_panel_link a',
			]
		);
		$this->add_control(
			'after_login_color',
			[
				'label' => esc_html__('Text Color', 'petrona'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper *,
						{{WRAPPER}} .after_login_btn_wrapper .ox-user-login .ox-list .ox-user-logged-out .ox-button,
						{{WRAPPER}} .after_login_btn_wrapper .ox-user-login ul .ox-user-name a,
						{{WRAPPER}} .after_login_btn_wrapper .ox-user-login ul .after_login_panel_link a' => 'color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'after_login_bg',
				'label' => esc_html__('Background', 'petrona'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .ox-user-login',
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'after_login_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .ox-user-login',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'after_login_border_radious',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .after_login_btn_wrapper .ox-user-login' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'after_login_shadow',
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .ox-user-login',
			]
		);
		$this->add_control(
			'lr_al_img_head',
			[
				'label' => esc_html__('Image Style', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_img_margin_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Right Offset', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span .avatar' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'lr_al_img_size',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Image Size', 'petrona'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span .avatar' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lr_al_img_border_n',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-wp-lrcf .after_login_btn_wrapper .elementor-button-text .avatar',
			]
		);
		$this->add_responsive_control(
			'lr_al_img_border_radius_n',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-wp-lrcf .after_login_btn_wrapper .elementor-button-text .avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_al_img_shadow_n',
				'selector' => '{{WRAPPER}} .ox-wp-lrcf .after_login_btn_wrapper .elementor-button-text .avatar',
			]
		);
		$this->add_control(
			'lr_al_head',
			[
				'label' => esc_html__('Button', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lr_al_typo',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span',
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs('lr_al_tabs');
		$this->start_controls_tab(
			'lr_al_normal_tab',
			[
				'label' => esc_html__('Normal', 'petrona'),
			]
		);
		$this->add_control(
			'lr_al_color_normal',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_al_bg_normal',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lr_al_border_normal',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_border_radious_normal',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_al_shadow_normal',
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'lr_al_hover_tab',
			[
				'label' => esc_html__('Hover', 'petrona'),
			]
		);
		$this->add_control(
			'lr_al_color_active',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover  span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'lr_al_bg_active',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'lr_al_border_active',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_border_radious_active',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'lr_al_shadow_active',
				'selector' => '{{WRAPPER}} .after_login_btn_wrapper .after_login_btn_main:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'lr_al_pre_u_head',
			[
				'label' => esc_html__('Prefix User Name', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_pre_u_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .pre-u-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lr_al_pre_u_typo',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .pre-u-name',
			]
		);
		$this->add_control(
			'lr_al_pre_u_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pre-u-name' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'lr_al_u_head',
			[
				'label' => esc_html__('User Name', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_u_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .u-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lr_al_u_typo',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .u-name',
			]
		);
		$this->add_control(
			'lr_al_u_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .u-name' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'lr_al_suf_u_head',
			[
				'label' => esc_html__('Suffix User Name', 'petrona'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'lr_al_suf_u_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .suf-u-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lr_al_suf_u_typo',
				'label' => esc_html__('Typography', 'petrona'),
				'selector' => '{{WRAPPER}} .suf-u-name',
			]
		);
		$this->add_control(
			'lr_al_suf_u_color',
			[
				'label' => esc_html__('Color', 'petrona'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .suf-u-name' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*logout style END*/
		/*box content login register forgot option start*/
		$this->start_controls_section(
			'section_box_content_lrf_option_style',
			[
				'label' => esc_html__('Box Content Option', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection!' => ['ox_login_register'],
				],
			]
		);
		$this->add_responsive_control(
			'bc_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div  .ox-form-stacked-fp,	
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-modal,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-register-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-modal,
					{{WRAPPER}} .ox-wp-lrcf .ox-forg-pass-form .ox-form-stacked-fp,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked-reset' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'bc_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div  .ox-form-stacked-fp,		
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-modal,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-register-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-modal,
					{{WRAPPER}} .ox-wp-lrcf .ox-forg-pass-form .ox-form-stacked-fp,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked-reset' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'bc_bg',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div  .ox-form-stacked-fp,	
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-modal,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-register-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-modal,
					{{WRAPPER}} .ox-wp-lrcf .ox-forg-pass-form .ox-form-stacked-fp,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked-reset',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bc_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-modal,
					{{WRAPPER}} .ox-user-register-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-modal,
					{{WRAPPER}} .ox-wp-lrcf .ox-forg-pass-form .ox-form-stacked-fp,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked-reset',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'bc_border_radious',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked,
						{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-modal,
					{{WRAPPER}} .ox-user-register-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-modal,
					{{WRAPPER}} .ox-wp-lrcf .ox-forg-pass-form .ox-form-stacked-fp,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked-reset' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bc_shadow',
				'selector' => '{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div,{{WRAPPER}} .ox-user-login.ox-user-login-skin-dropdown .lr-extra-div  .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login-skin-default .ox-form-stacked-fp,		
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-modal .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-modal,
					{{WRAPPER}} .ox-user-login.ox-user-login-skin-popup .ox-form-stacked-fp,
					{{WRAPPER}} .ox-user-register-skin-default .ox-form-stacked,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-dropdown .lr-extra-div,	
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-modal .ox-modal-dialog,
					{{WRAPPER}} .ox-user-register.ox-user-register-skin-popup .ox-modal,
					{{WRAPPER}} .ox-wp-lrcf .ox-forg-pass-form .ox-form-stacked-fp,{{WRAPPER}} .ox-wp-lrcf .ox-form-stacked-reset',
			]
		);
		$this->end_controls_section();
		/*box content login register forgot option end*/

		/*box content login register combo option start*/
		$this->start_controls_section(
			'section_box_content_lrcom_option_style',
			[
				'label' => esc_html__('Box Content Option', 'petrona'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_selection' => 'ox_login_register',
				],
			]
		);
		$this->add_responsive_control(
			'lrcom_max_width',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'petrona'),
				'size_units' => ['px', 'vw'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per' => 'max-width: {{SIZE}}{{UNIT}} !important;min-width: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'_skin!' => 'default',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'lrcom_max_height',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Height', 'petrona'),
				'size_units' => ['px', 'vh'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per' => 'max-height: {{SIZE}}{{UNIT}} !important;min-height: {{SIZE}}{{UNIT}} !important',
				],
				'condition' => [
					'_skin!' => 'default',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'bc_com_padding',
			[
				'label' => esc_html__('Padding', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per .ox-form-stacked-fp,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per .ox-form-stacked-fp,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal .ox-form-stacked-fp,
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per,
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per .ox-form-stacked-fp' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'bc_com_margin',
			[
				'label' => esc_html__('Margin', 'petrona'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em'],
				'selectors' => [
					'{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per .ox-form-stacked-fp,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per .ox-form-stacked-fp,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
					{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal .ox-form-stacked-fp,
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per, 
					{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per .ox-form-stacked-fp' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'bc_com_bg',
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per,
				{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per .ox-form-stacked-fp,
				{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
				{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per .ox-form-stacked-fp,
				{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
				{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal .ox-form-stacked-fp,
				{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per,
				{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per .ox-form-stacked-fp',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bc_com_border',
				'label' => esc_html__('Border', 'petrona'),
				'selector' => '{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
						{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per',
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'bc_com_border_radious',
			[
				'label'      => esc_html__('Border Radius', 'petrona'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
						{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'bc_com_shadow',
				'selector' => '{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per,
						{{WRAPPER}} .ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal,
						{{WRAPPER}} .ox-wp-lrcf .ox-lr-comm-wrap:not(.ox-lr-combo) .ox-lr-cl-100per',
			]
		);
		$this->end_controls_section();
		/*box content login register combo option end*/

		/*Style Sart*/
	}

	public function form_fields_render_attributes()
	{
		$settings = $this->get_settings();
		$id       = 'lr' . $this->get_id();

		$this->add_render_attribute(
			[
				'submit-group' => [
					'class' => [
						'elementor-field-type-submit',
						'ox-field-group',
					],
				],
				'dropdown-button-settings' => [
					'class' => [
						'elementor-button',
						'ox-button-dropdown',
					],
					'href' => 'javascript:void(0)',
				],
				'modal-button' => [
					'class' => [
						'elementor-button',
						'ox-button-modal',
					],
				],
			]
		);

		if (!$settings['show_labels'] || !$settings['show_labels_reg']) {
			$this->add_render_attribute('label', 'class', 'elementor-screen-only');
		}

		$this->add_render_attribute('field-group', 'class')
			->add_render_attribute('input', 'required', true)
			->add_render_attribute('input', 'aria-required', 'true');
	}

	protected function render_icon_text()
	{
		$settings    = $this->get_settings();
		$list_img = '';
		if (!empty($settings['loop_icon_fontawesome'])) {
			ob_start();
			\Elementor\Icons_Manager::render_icon($settings['loop_icon_fontawesome'], ['aria-hidden' => 'true']);
			$list_img = ob_get_contents();
			ob_end_clean();
		}

		if (is_user_logged_in() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			$button_text = esc_html__($settings['button_text_logout'], 'petrona');
		} else {
			$button_text = $settings['dropdown_button_text'];
		}

	    ?>
		<span class="elementor-button-content-wrapper">
			<span class="elementor-button-text">
				<?php echo $list_img . esc_html($button_text); ?>
			</span>
		</span>
	    <?php
	}

	public function render()
	{
		$settings = $this->get_settings_for_display();
		$settings['hide_form'] = 'no';
		$current_url = remove_query_arg('fake_arg');
		$id          = 'lr' . $this->get_id();
		$list_img = '';
		if (!empty($settings['loop_icon_fontawesome'])) {
			ob_start();
			\Elementor\Icons_Manager::render_icon($settings['loop_icon_fontawesome'], ['aria-hidden' => 'true']);
			$list_img = ob_get_contents();
			ob_end_clean();
		}


		if ($settings['redirect_after_login'] && !empty($settings['redirect_url']['url'])) {
			$redirect_url = $settings['redirect_url']['url'];
		} else {
			$redirect_url = $current_url;
		}


		if ($settings['form_selection'] == 'ox_login_register') {

			$ox_login_registe_script = '<script>';
			$ox_login_registe_script .= 'jQuery(document).ready(function(){
							jQuery("#' . esc_attr($id) . '.ox-l-r-main-wrapper .ox-l-r-tab").on("click", function(event) {
								event.preventDefault();							
								jQuery("#' . esc_attr($id) . '.ox-l-r-main-wrapper .ox-l-r-tab").removeClass("active");
								jQuery(this).addClass("active");
								var active = jQuery(this).data("active");
								jQuery(this).closest(".ox-l-r-main-wrapper").find(".ox-tab-content-inner").removeClass("active");
								jQuery(this).closest(".ox-l-r-main-wrapper").find(".ox-tab-content-inner.tab-"+active).addClass("active");
							});	
							
							/*hover*/
					jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-hover").on( "mouseenter",function() {
						jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per").show("slow")
					}).on( "mouseleave",function() {
							setTimeout(function() {
							if(!(jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-hover:hover").length > 0))
								jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-hover .ox-lr-cl-100per").hide("slow");
							}, 200);
						});				
							/*hover*/
							
							/*click*/
							jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-model-btn").on("click",function(){
							jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per").toggle("slow");
					});
							/*close icon*/
					jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-click  .lr-close-custom_img").on("click",function(){					
						jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-click .ox-lr-cl-100per").toggle("slow");
					});				
					/*close icon*/
							/*click*/
							
							/*popup*/
						jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-trigger").on("click",function(event) {
							event.preventDefault();	
							jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-popup .ox-modal-wrapper").toggleClass("open");
							jQuery("#' . esc_attr($id) . '.ox-lr-combo.ox-lr-comnbo-skin-popup .ox-ursp-page-wrapper").toggleClass("blur");
							return false;
						});
					/*popup*/
						
					});';
			$ox_login_registe_script .= '</script>';

			echo $ox_login_registe_script;
		}

		$aflp = '';
		if (is_user_logged_in() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
			$aflp = 'aflp';
		}
		echo '<div class="ox-wp-lrcf ' . $aflp . '">';

		$current_user = wp_get_current_user();
		$pre_user_name = "";
		$user_name = "";
		$suf_user_name = "";
		$hide_on_mobile = empty($settings['user_text_switch']) && $settings['user_text_switch'] != 'yes' ? 'd-none d-lg-block' : '';
		$after_login_panel = '<div class="after_login_btn_wrapper">';
		if ((!empty($settings['hide_u_avtar']) && $settings['hide_u_avtar'] == 'yes') || (!empty($settings['hide_u_name']) && $settings['hide_u_name'] == 'yes')) {
			$after_login_panel .= '<a class="after_login_btn_main"  aria-expanded="true">
								<span class="elementor-button-text">';
			if (!empty($settings['hide_u_avtar']) && $settings['hide_u_avtar'] == 'yes') {
				$after_login_panel .= get_avatar($current_user->user_email, 128);
			}

			if (!empty($settings['pre_u_name_text']) && $settings['pre_u_name'] == 'yes') {
				$pre_user_name = sprintf('<span class="pre-u-name %1$s">%2$s</span> ',$hide_on_mobile, $settings['pre_u_name_text']);
			}
			if (!empty($settings['hide_u_name']) && $settings['hide_u_name'] == 'yes') {
				$user_name = sprintf('<span class="u-name %1$s">%2$s</span> ',$hide_on_mobile, $current_user->display_name);
			}
			if (!empty($settings['suf_u_name_text']) && $settings['suf_u_name'] == 'yes') {
				$suf_user_name = sprintf('<span class="suf-u-name %1$s">%2$s</span>',$hide_on_mobile, $settings['suf_u_name_text']);
			}
			$after_login_panel .= sprintf('%1$s %2$s %3$s', $pre_user_name, $user_name, $suf_user_name);
			$after_login_panel .= '</span>
								</a>';
		}

		if ((!empty($settings['show_logged_in_message']) && $settings['show_logged_in_message'] == 'yes') &&
			((!empty($settings['edit_profile_text_switch']) && $settings['edit_profile_text_switch'] == 'yes') ||
				(!empty($settings['button_text_logout_switch']) && $settings['button_text_logout_switch'] == 'yes') ||
				(!empty($settings["loop_content"])))
		) {
			$after_login_panel .= '<div class="ox-user-login ' . $settings['layout_start_from'] . '"';
			if ((!empty($settings['standard_layout']) && $settings['standard_layout'] == 'yes')) {
				$after_login_panel .= ' style="display: block"';
			}

			$after_login_panel .= ' >
							<ul class="ox-list">';
		}
		if (!empty($settings['edit_profile_text_switch']) && $settings['edit_profile_text_switch'] == 'yes') {
			$after_login_panel .= '<li class="ox-user-name"><a href="' . get_edit_user_link() . '" class="ox-text-bold">' . esc_html__($settings['edit_profile_text'], 'petrona') . '</a>
								</li>';
		}
		$i = 0;
		if (!empty($settings["loop_content"])) {
			foreach ($settings["loop_content"] as $item) {
				if (!empty($item['loop_url_link']['url'])) {
					$this->add_render_attribute('loop_box_link' . $i, 'href', $item['loop_url_link']['url']);
					if ($item['loop_url_link']['is_external']) {
						$this->add_render_attribute('loop_box_link' . $i, 'target', '_blank');
					}
					if ($item['loop_url_link']['nofollow']) {
						$this->add_render_attribute('loop_box_link' . $i, 'rel', 'nofollow');
					}
				}

				$title_a_start = $title_a_end = '';
				if (!empty($item['loop_title'])) {
					if (!empty($item['loop_url_link']['url'])) {
						$title_a_start = '<a ' . $this->get_render_attribute_string("loop_box_link" . $i) . '>';
						$title_a_end = '</a>';
					}
					$after_login_panel .= '<li class="after_login_panel_link">' . $title_a_start . ' ' . $item['loop_title'] . ' ' . $title_a_end . '</li>';
				}
				$i++;
			}
		}
		if (!empty($settings['button_text_logout_switch']) && $settings['button_text_logout_switch'] == 'yes') {
			$after_login_panel .= '<li class="ox-user-logged-out">
													<a href="' . wp_logout_url($current_url) . '" class="ox-button ox-button-primary">
													' . esc_html__($settings['button_text_logout'], 'petrona') . '</a>
											   </li>';
		}
		if ((!empty($settings['show_logged_in_message']) && $settings['show_logged_in_message'] == 'yes') &&
			((!empty($settings['edit_profile_text_switch']) && $settings['edit_profile_text_switch'] == 'yes') ||
				(!empty($settings['button_text_logout_switch']) && $settings['button_text_logout_switch'] == 'yes') ||
				(!empty($settings["loop_content"])))
		) {
			$after_login_panel .= '</ul>
				</div>';
		}
		$after_login_panel .= '</div></div>';

		if ((empty($_GET['action'])) || (!empty($_GET['action']) && $_GET['action'] != 'techtrpf')) {
			if (!empty($settings['form_selection']) && ($settings['form_selection'] == 'ox_login' || $settings['form_selection'] == 'ox_login_register')) {

				if (is_user_logged_in() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
					if ($settings['show_logged_in_message']) {
						echo $after_login_panel;
					}
					return;
				}


				$this->form_fields_render_attributes();

				if ($settings['_skin'] == 'default' && $settings['form_selection'] == 'ox_login') { ?>

					<div id="<?php echo esc_attr($id); ?>" class="ox-user-login ox-user-login-skin-default">
						<div class="elementor-form-fields-wrapper">
							<?php if ($settings['modal_header'] == 'yes' && (!empty($settings['hide_form']) && $settings['hide_form'] == 'no')) : ?>
								<div class="ox-modal-header">
									<h2 class="ox-modal-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
								</div>
							<?php endif; ?>
							<?php $this->user_login_form(); ?>
						</div>
					</div>
				<?php } else if ($settings['_skin'] == 'ox-dropdown'  && $settings['form_selection'] == 'ox_login') { ?>
					<div id="<?php echo esc_attr($id); ?>" class="ox-user-login ox-user-login-skin-dropdown">
						<a <?php echo $this->get_render_attribute_string('dropdown-button-settings'); ?>>
							<?php $this->render_icon_text(); ?>
						</a>
						<div <?php echo $this->get_render_attribute_string('dropdown-settings'); ?>>
							<div class="elementor-form-fields-wrapper">
								<div class="lr-extra-div <?php echo $settings['layout_start_from']; ?>">
									<?php if ($settings['modal_header'] == 'yes') : ?>
										<div class="ox-modal-header">
											<h2 class="ox-modal-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
										</div>
									<?php endif; ?>
									<?php $this->user_login_form(); ?>
								</div>
							</div>

						</div>
					</div>

				<?php } else if ($settings['_skin'] == 'ox-modal' && $settings['form_selection'] == 'ox_login') { ?>

					<div id="<?php echo esc_attr($id); ?>" class="ox-user-login ox-user-login-skin-modal">
						<a class="ox-lr-model-btn" <?php echo $this->get_render_attribute_string('modal-button-settings'); ?>>
							<?php $this->render_icon_text(); ?>
						</a>

						<div id="<?php echo esc_attr($id); ?>" class="ox-user-login-modal">
							<div class="ox-modal-dialog <?php echo $settings['layout_start_from']; ?>">
								<?php if ($settings['modal_close_button'] == 'yes') : ?>
									<span class="lr-close-custom_img"><?php Icons_Manager::render_icon( $settings['modal_close_button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
								<?php endif; ?>

								<div class="elementor-form-fields-wrapper ox-modal-body">
									<?php if ($settings['modal_header'] == 'yes') : ?>
										<div class="ox-modal-header">
											<h2 class="ox-modal-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
										</div>
									<?php endif; ?>
									<?php $this->user_login_form(); ?>
								</div>
							</div>
						</div>
					</div>

				<?php } else if ($settings['_skin'] == 'ox-popup' && $settings['form_selection'] == 'ox_login') { ?>

					<div id="<?php echo esc_attr($id); ?>" class="ox-user-login ox-user-login-skin-popup">
						<div class="ox-ulsp-page-wrapper">
							<a class="ox-ulsp-btn ox-ulsp-trigger" href="javascript:;">
								<?php $this->render_icon_text(); ?>
							</a>
						</div>

						<div class="ox-modal-wrapper">
							<div class="ox-modal">
								<a class="ox-ulsp-btn-close ox-ulsp-trigger" href="javascript:;"><span class="lr-close-custom_img"><?php Icons_Manager::render_icon( $settings['modal_close_button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span></a>
								<div class="ox-ulsp-content">
									<div class="elementor-form-fields-wrapper ox-popup-body">
										<?php if ($settings['modal_header'] == 'yes') : ?>
											<div class="ox-popup-header">
												<h2 class="ox-popup-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
											</div>
										<?php endif; ?>
										<?php $this->user_login_form(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php }
			}
		} else if ((isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'techtrpf') && (!empty($settings['ox_convert_rest_form']) && $settings['ox_convert_rest_form'] == 'yes')) {
			$this->user_reset_password_form();
		}

		if (!empty($settings['form_selection']) && ($settings['form_selection'] == 'ox_forgot_password')) {
			if ((empty($_GET['action'])) || (!empty($_GET['action']) && $_GET['action'] != 'techtrpf')) {
				$this->user_lost_password_form('login-time-fp');
			}
			/*if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='techtrpf'){
				$this->user_reset_password_form(); 
			}*/
		}

		if ((empty($_GET['action'])) || (!empty($_GET['action']) && $_GET['action'] != 'techtrpf')) {
			if (!empty($settings['form_selection']) && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {

				if (is_user_logged_in() && !\Elementor\Plugin::$instance->editor->is_edit_mode()) {
					if ($settings['show_logged_in_message_reg']) {
						echo $after_login_panel;
					}

					return;
				} elseif (!get_option('users_can_register')) {
				?>
					<div class="ox-alert ox-alert-warning" ox-alert>
						<a class="ox-alert-close" ox-close></a>
						<p><?php esc_html_e('Registration option not enbled in your general settings.', 'petrona'); ?></p>
					</div>
				<?php
					return;
				}


				$this->form_fields_render_attributes();


				if ($settings['_skin'] == 'default' && $settings['form_selection'] == 'ox_register') {	?>
					<div class="ox-user-register ox-user-register-skin-default">
						<div class="elementor-form-fields-wrapper">
							<?php if ($settings['modal_header'] == 'yes' && (!empty($settings['hide_form']) && $settings['hide_form'] == 'no')) : ?>
								<div class="ox-modal-header">
									<h2 class="ox-modal-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
								</div>
							<?php endif; ?>
							<?php $this->user_register_form(); ?>
						</div>
					</div>
				<?php

				} else if ($settings['_skin'] == 'ox-dropdown' && $settings['form_selection'] == 'ox_register') {
				?>
					<div id="<?php echo esc_attr($id); ?>" class="ox-user-register ox-user-register-skin-dropdown">
						<a <?php echo $this->get_render_attribute_string('dropdown-button-settings'); ?>>
							<?php $this->render_icon_text(); ?>
						</a>

						<div <?php echo $this->get_render_attribute_string('dropdown-settings'); ?>>
							<div class="elementor-form-fields-wrapper">
								<div class="lr-extra-div <?php echo $settings['layout_start_from']; ?>">
									<?php if ($settings['modal_header'] == 'yes') : ?>
										<div class="ox-modal-header">
											<h2 class="ox-modal-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
										</div>
									<?php endif; ?>
									<?php $this->user_register_form(); ?>
								</div>
							</div>
						</div>
					</div>

				<?php }


				if ($settings['_skin'] == 'ox-modal' && $settings['form_selection'] == 'ox_register') { ?>

					<div id="<?php echo esc_attr($id); ?>" class="ox-user-register ox-user-register-skin-modal">
						<a class="ox-lr-model-btn" <?php echo $this->get_render_attribute_string('modal-button-settings'); ?>>
							<?php $this->render_icon_text(); ?>
						</a>
						<div id="<?php echo esc_attr($id); ?>" class="ox-user-register-modal">
							<div class="ox-modal-dialog <?php echo $settings['layout_start_from']; ?>">
								<?php if ($settings['modal_close_button'] == 'yes') : ?>
									<span class="lr-close-custom_img"><?php Icons_Manager::render_icon( $settings['modal_close_button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
								<?php endif; ?>

								<div class="elementor-form-fields-wrapper ox-modal-body">
									<?php if ($settings['modal_header'] == 'yes') : ?>
										<div class="ox-modal-header">
											<h2 class="ox-modal-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
										</div>
									<?php endif; ?>
									<?php $this->user_register_form(); ?>
								</div>
							</div>
						</div>
					</div>
				<?php


				} else if ($settings['_skin'] == 'ox-popup' && $settings['form_selection'] == 'ox_register') { ?>

					<div id="<?php echo esc_attr($id); ?>" class="ox-user-register ox-user-register-skin-popup">
						<div class="ox-ursp-page-wrapper">
							<a class="ox-ursp-btn ox-ursp-trigger" href="javascript:;">
								<?php $this->render_icon_text(); ?>
							</a>
						</div>
						<div class="ox-modal-wrapper">
							<div class="ox-modal">
								<a class="ox-ursp-btn-close ox-ursp-trigger" href="javascript:;"><span class="lr-close-custom_img"><?php Icons_Manager::render_icon( $settings['modal_close_button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span></a>
								<div class="ox-ursp-content">
									<div class="elementor-form-fields-wrapper ox-popup-body">
										<?php if ($settings['modal_header'] == 'yes') : ?>
											<div class="ox-popup-header">
												<h2 class="ox-popup-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
											</div>
										<?php endif; ?>
										<?php $this->user_register_form(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php }

				$lr_popup_btn_close = $settings['_skin'] != 'ox-dropdown' ? '<a class="ox-ursp-btn-close ox-ursp-trigger" href="javascript:;"><span class="lr-close-custom_img">'. Icons_Manager::render_icon( $settings['modal_close_button_icon'], [ 'aria-hidden' => 'true' ] ) . '</span></a>' : "";
				$lr_popup_start = '<div id="' . esc_attr($id) . '" class="ox-lr-comm-wrap ox-lr-combo ox-lr-comnbo-skin-popup">
									<div class="ox-ursp-page-wrapper">
										<a class="ox-ursp-btn ox-ursp-trigger" href="javascript:;">' . $list_img . ' ' . $settings['dropdown_button_text'] . '</a>
									</div>
							<div class="ox-modal-wrapper">
								<div class="ox-modal">' . $lr_popup_btn_close .	'<div class="ox-ursp-content">';					

				$lr_popup_close = '</div>
							</div>
					  </div>
					</div>';

				$lr_hover_start = '<div id="' . esc_attr($id) . '" class="ox-lr-comm-wrap ox-lr-combo ox-lr-comnbo-skin-hover">
								<a class="elementor-button ox-button-dropdown" href="javascript:void(0)">
									<span class="elementor-button-content-wrapper">				
										' . $list_img . '<span class="elementor-button-text">' . $settings['dropdown_button_text'] . '</span>
									</span>
								</a>';
				$lr_hover_close = '</div>';

				$lr_click_start = '<div id="' . esc_attr($id) . '" class="ox-lr-comm-wrap ox-lr-combo ox-lr-comnbo-skin-click">
								<a class="ox-lr-model-btn">
									<span class="elementor-button-content-wrapper">				
										' . $list_img . '<span class="elementor-button-text">' . $settings['dropdown_button_text'] . '</span>
									</span>
								</a>';
				$lr_click_close = '</div>';


				if (!empty($settings['form_selection']) && $settings['form_selection'] == 'ox_login_register') {
					if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-popup') {
						echo $lr_popup_start;
					}
					if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-dropdown') {
						echo $lr_hover_start;
					}
					if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-modal') {
						echo $lr_click_start;
					}

					if (!empty($settings['_skin']) && $settings['_skin'] == 'default') {
						echo '<div class="ox-lr-comm-wrap">';
					}
				?>
					<div id="<?php echo esc_attr($id); ?>" class="ox-lr-cl-100per <?php echo $settings['layout_start_from']; ?>">
						<?php if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-modal') {
							if ($settings['modal_close_button'] == 'yes') : ?>
								<span class="lr-close-custom_img"><?php Icons_Manager::render_icon( $settings['modal_close_button_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
						<?php endif;
						} ?>

						<?php if (!empty($settings['select_template'])) { ?>
							<div class="cl-50per">
								<?php
								echo '<div class="temp">' . \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($settings['select_template']) . '</div>';
								?>
							</div>
							<div class="cl-50per">
							<?php } else { ?>
								<div class="cl-100per">
								<?php } ?>
								<div id="<?php echo esc_attr($id); ?>" class="ox-l-r-main-wrapper">
									<ul id="<?php echo esc_attr($id); ?>" class="ox-l-r-tab-group">
										<li class="ox-l-r-tab active" data-active="login"><?php echo $settings['tab_com_login']; ?></li>
										<li class="ox-l-r-tab" data-active="signup"><?php echo $settings['tab_com_signup']; ?></li>
									</ul>

									<div class="ox-l-r-tab-content">
										<div class="ox-tab-content-inner tab-login active">
											<?php if ($settings['modal_header'] == 'yes') : ?>
												<div class="ox-popup-header">
													<h2 class="ox-popup-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_log']; ?></h2>
												</div>
											<?php endif; ?>
											<?php $this->user_login_form(); ?>
										</div>
										<div class="ox-tab-content-inner tab-signup">
											<?php if ($settings['modal_header'] == 'yes') : ?>
												<div class="ox-popup-header">
													<h2 class="ox-popup-title"><span ox-icon="user"></span> <?php echo $settings['modal_header_description_reg']; ?></h2>
												</div>
											<?php endif; ?>
											<?php $this->user_register_form(); ?>
										</div>
									</div>
								</div>
								</div>
							</div>
				<?php

					if (!empty($settings['_skin']) && $settings['_skin'] == 'default') {
						echo '</div>';
					}
					if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-popup') {
						echo $lr_popup_close;
					}
					if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-dropdown') {
						echo $lr_hover_close;
					}
					if (!empty($settings['_skin']) && $settings['_skin'] == 'ox-modal') {
						echo $lr_click_close;
					}
				}
			}
		}
		if (!empty($settings['form_selection']) && $settings['form_selection'] == 'ox_login') {
			$this->user_login_ajax_script();
		} else if (!empty($settings['form_selection']) && $settings['form_selection'] == 'ox_register') {
			$this->user_register_ajax_script();
		} else if (!empty($settings['form_selection']) && $settings['form_selection'] == 'ox_login_register') {
			$this->user_login_ajax_script();
			$this->user_register_ajax_script();
		}
				?>
					</div>
				<?php

			}

			/*User Forgot Password Form*/
			public function user_lost_password_form($value = '')
			{

				$settings    = $this->get_settings();
				$current_url = remove_query_arg('fake_arg');
				$id          = 'lr' . $this->get_id();
				if ($settings['form_selection'] == 'ox_forgot_password') {
					echo '<div class="ox-forg-pass-form">';
				}


				if (!empty($_GET['expired']) && $_GET['expired'] == 'expired') {
					$key_msg = 'The entered key has expired. Please start reset process again.';
				} else if (!empty($_GET['invalid']) && $_GET['invalid'] == 'invalid') {
					$key_msg = 'The entered key is invalid. Please start reset process again.';
				} else {
					$key_msg = '';
				}
				if (!empty($key_msg)) {
					echo '<div class="ox-invalid-expired-key">' . esc_html($key_msg) . '</div>';
				}

				$tceol = array();
				if (!empty($settings['ox_cst_email_lost_opt']) && $settings['ox_cst_email_lost_opt'] == 'yes') {
					$oxces = !empty($settings['ox_cst_email_lost_subject']) ? $settings['ox_cst_email_lost_subject'] : '';
					$oxcem = !empty($settings['ox_cst_email_lost_message']) ? $settings['ox_cst_email_lost_message'] : '';

					$tceol["ox_cst_email_lost_opt"] = $settings['ox_cst_email_lost_opt'];
					$tceol["ox_cst_email_lost_subject"] = $oxces;
					$tceol["ox_cst_email_lost_message"] = $oxcem;
				}
				$data_tceol = json_encode($tceol);
				?>
					<form id="ox-user-lost-password<?php echo esc_attr($id); ?>" class="ox-form-stacked-fp" method="post" action="forgot-password" data-f_p_opt="<?php echo $settings['f_p_opt']; ?>" data-tceol="<?php echo htmlspecialchars($data_tceol, ENT_QUOTES, 'UTF-8'); ?>">
						<?php if (function_exists('wp_nonce_field'))
							wp_nonce_field('ox_user_lost_password_action', 'ox_user_lost_password_nonce'); ?>
						<?php
						$lpba_icon = '';
						if (!empty($settings['lpba_icon'])) {
							ob_start();
							\Elementor\Icons_Manager::render_icon($settings['lpba_icon'], ['aria-hidden' => 'true']);
							$lpba_icon = ob_get_contents();
							ob_end_clean();
						}

						if (!empty($settings['form_selection']) && $settings['form_selection'] !== 'ox_forgot_password') {
							echo '<a class="ox-lpu-back">' . $lpba_icon . '</a>';
						}
						?>
						<?php
						if (!empty($value) && $value == 'login-time-fp') {
							echo '<span class="ox-forgot-password-label">';
							echo $settings['lost_password_heading_desc'];
							echo '</span>';
						}
						if ((!empty($settings['lost_pass_label_switch']) && $settings['lost_pass_label_switch'] == 'yes') && !empty($settings['lost_pass_label'])) {
						?>
							<label for="user_login<?php echo esc_attr($id); ?>" class="ox-form-label"><?php echo $settings['lost_pass_label']; ?></label>
						<?php } ?>
						<div class="ox-ulp-input-group">
							<input type="text" name="user_login" id="user_login<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($settings['lost_pass_placeholder']); ?>" class="ox-input" required>
						</div>
						<?php do_action('lostpassword_form'); ?>
						<input type="hidden" name="_ox_login_form" value="lostPassword">
						<div class="elementor-field-type-submit ox-field-group elementor-field-type-submit ox-field-group">
							<button type="submit" class="ox-button-fp">
								<span><?php echo $settings['forgot_pass_btn']; ?></span>
							</button>
						</div>
						<div class="techt-notification">
							<div class="ox-lr-response"></div>
						</div>

					</form>

				<?php
				if ($settings['form_selection'] == 'ox_forgot_password') {
					echo '</div>';
				}

				$this->user_forgot_pass_ajax_script();
			}
			/*User Forgot Password Form*/

			/*User Reset Password Form*/
			public function user_reset_password_form()
			{

				$settings    = $this->get_settings();
				$id          = 'lr' . $this->get_id();
				$attributes = array();
				if (is_user_logged_in()) {
					echo  __('You are already signed in.', 'petrona');
				} else {
					if (isset($_REQUEST['login']) && isset($_REQUEST['key'])) {
						$attributes['login'] = $_REQUEST['login'];
						$attributes['key'] = $_REQUEST['key'];
						$attributes['forgoturl'] = $_REQUEST['forgoturl'];
					}
				}
				if (!empty($attributes)) {
					$pattern_pass_reset = '';
					$ox_dp_reset_field_strong = ($settings['ox_dp_reset_field_strong'] == 'yes') ? 'yes' : 'no';
					if (!empty($ox_dp_reset_field_strong) && $ox_dp_reset_field_strong == 'yes') {
						$pattern_pass_reset = 'pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"';
					}
				?>
					<div class="ox-reset-pass-form">
						<form id="ox-user-reset-password<?php echo esc_attr($id); ?>" class="ox-form-stacked-reset" method="post">
							<input type="hidden" id="ox-reset-login-user<?php echo esc_attr($id); ?>" name="ox_login" value="<?php echo esc_attr($attributes['login']); ?>" autocomplete="off" />
							<input type="hidden" id="ox-reset-forgot-url<?php echo esc_attr($id); ?>" name="ox_forgot_url" value="<?php echo esc_attr($attributes['forgoturl']); ?>" autocomplete="off" />
							<input type="hidden" id="ox-reset-user-key<?php echo esc_attr($id); ?>" name="ox_key" value="<?php echo esc_attr($attributes['key']); ?>" />
							<?php
							if ((!empty($settings['res_pass_label_switch']) && $settings['res_pass_label_switch'] == 'yes') && !empty($settings['res_pass_label'])) {
							?>
								<label for="user_login<?php echo esc_attr($id); ?>" class="ox-form-label"><?php echo $settings['res_pass_label']; ?></label>
							<?php } ?>
							<div class="ox-ulp-input-group">
								<input type="password" name="user_reset_pass" id="user_reset_pass<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($settings['res_pass_placeholder']); ?>" class="ox-input" required <?php echo $pattern_pass_reset; ?> style="margin-bottom:15px">
							</div>
							<div class="ox-ulp-input-group">
								<input type="password" name="user_reset_pass_conf" id="user_reset_pass_conf<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_attr($settings['res_conf_pass_placeholder']); ?>" class="ox-input" required>
							</div>
							<?php if (function_exists('wp_nonce_field')) {
								wp_nonce_field('ox_reset_pass', 'ox_reset_pass');
							} ?>
							<button type="submit" class="ox-button-reset-pass"><?php echo $settings['reset_pass_btn']; ?></button>
							<div class="techt-notification">
								<div class="ox-lr-response"></div>
							</div>
						</form>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							var reset_pass_form = 'form#ox-user-reset-password<?php echo esc_attr($id); ?>';
							var fp_loading = '<span class="loading-spinner-reg"><i class="far fa-times-circle" aria-hidden="true"></i></span>';
							var forgot_url = $(reset_pass_form + ' #ox-reset-forgot-url<?php echo esc_attr($id); ?>').val();
							$(reset_pass_form).on('submit', function(e) {
								$.ajax({
									type: 'POST',
									dataType: 'json',
									url: techt_ajax_url,
									data: {
										'action': 'techt_ajax_reset_password',
										'user_login': $(reset_pass_form + ' #ox-reset-login-user<?php echo esc_attr($id); ?>').val(),
										'user_key': $(reset_pass_form + ' #ox-reset-user-key<?php echo esc_attr($id); ?>').val(),
										'user_pass': $(reset_pass_form + ' #user_reset_pass<?php echo esc_attr($id); ?>').val(),
										'user_pass_conf': $(reset_pass_form + ' #user_reset_pass_conf<?php echo esc_attr($id); ?>').val(),
										//'redirecturl': '<?php echo get_the_permalink(); ?>',
										'nonce': $(reset_pass_form + ' #ox_reset_pass_nonce').val()
									},
									beforeSend: function() {
										$("#ox-user-reset-password<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
										$("#ox-user-reset-password<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html('Please Wait...');
									},
									success: function(data) {
										$("#ox-user-reset-password<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
										$("#ox-user-reset-password<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(fp_loading + data.message);
										if (data.reset_pass == 'success') {
											if (forgot_url != '') {
												window.location = forgot_url;
											}
										}
										if (data.reset_pass == 'empty') {
											$(reset_pass_form + ' #user_reset_pass<?php echo esc_attr($id); ?>').value = '';
											$(reset_pass_form + ' #user_reset_pass_conf<?php echo esc_attr($id); ?>').value = '';
										}
										if (data.reset_pass == 'mismatch') {
											$(reset_pass_form + ' #user_reset_pass_conf<?php echo esc_attr($id); ?>').value = '';
										}
										if (data.reset_pass == 'expire') {
											if (forgot_url != '') {
												window.location = forgot_url;
											}
										}
										if (data.reset_pass == 'invalid') {
											if (forgot_url != '') {
												window.location = forgot_url;
											}
										}
									},
									complete: function() {
										setTimeout(function() {
											$("#ox-user-reset-password<?php echo esc_attr($id); ?> .techt-notification").removeClass("active");
										}, 3200);
									}
								});
									e.preventDefault();
								});
							});
						</script>
					<?php
				}
			}
			/*User Reset Password Form*/

			/*User Login Form*/
			public function user_login_form()
			{

				$settings = $this->get_settings();
				$current_url = remove_query_arg('fake_arg');
				$id = 'lr' . $this->get_id();
				if ($settings['redirect_after_login'] && !empty($settings['redirect_url']['url'])) {
					$redirect_url = $settings['redirect_url']['url'];
				} else {
					$redirect_url = $current_url;
				}
				$hide_form = 'no';
				//($settings['hide_form'] == 'yes') ? 'yes' : 'no';	
				if (!empty($hide_form) && $hide_form != 'yes') {?>
					<form id="ox-user-login<?php echo esc_attr($id); ?>" class="ox-form-stacked " method="post" action="login">
						<div class="ox-user-login-status"></div>
						<div class="ox-field-group ox-l-lr-user-name">
							<?php 
								if ($settings['show_labels'] == 'yes' && ($settings['form_selection'] == 'ox_login' || $settings['form_selection'] == 'ox_login_register')) {
									echo '<label for="user' . esc_attr($id) . '" class="ox-form-label">' . $settings['user_label'] . '</label>';
								}
								?>
								<div class="ox-form-controls">
									<input type="text" name="log" id="user<?php echo esc_attr($id); ?>" placeholder="<?php echo esc_html($settings['user_placeholder'], 'petrona'); ?>" class="ox-input" required>
								</div>
						</div>
						<div class="ox-field-group ox-l-lr-password">
							<?php
								if ($settings['show_labels'] == 'yes' && ($settings['form_selection'] == 'ox_login' || $settings['form_selection'] == 'ox_login_register')) :
									echo '<label for="password' . esc_attr($id) . '" class="ox-form-label">' . $settings['password_label'] . '</label>';
								endif;
								echo '<div class="ox-form-controls">';
								echo '<input type="password" name="pwd" id="password' . esc_attr($id) . '" placeholder="' . $settings['password_placeholder'] . '" class="ox-input" required>';
								echo '</div>';
							?>
						</div>
						<?php if ($settings['show_remember_me'] == 'yes') : ?>
							<div class="ox-field-group ox-remember-me">
								<label for="remember-me-<?php echo esc_attr($id); ?>" class="ox-form-label">
									<input type="checkbox" id="remember-me-<?php echo esc_attr($id); ?>" class="ox-checkbox" name="rememberme" value="forever">
									<label class="remember-me-label" for="remember-me-<?php echo esc_attr($id); ?>"><?php echo esc_html($settings['remember_me_text']); ?>
									</label>	
								</label>
							</div>
						<?php endif; ?>
						<div <?php echo $this->get_render_attribute_string('submit-group'); ?>>
							<button type="submit" class="ox-button" name="wp-submit">
								<?php if (!empty($settings['button_text'])) : ?>
									<span><?php echo $settings['button_text']; ?></span>
								<?php endif; ?>
							</button>
						</div>
						<?php
						$show_lost_password = $settings['show_lost_password'];
						$show_register = get_option('users_can_register') && $settings['show_register'];
						if ($show_lost_password || $show_register) : ?>
							<div class="ox-field-group  ox-user-login-password">
								<?php if ($show_lost_password == 'yes') : ?>
									<a href="#" class="ox-lost-password"><?php echo esc_html($settings['bottom_lost_pass_text']); ?></a>
								<?php endif; ?>
								<?php if ($show_register == 'yes') : ?>
									<a class="ox-register" href="<?php
										if ($settings['show_register_opt'] == 'default') {
											echo wp_registration_url();																	
										} 
										else if ($settings['show_register_opt'] == 'custom') {
											if (!empty($settings['show_register_opt_link']['url'])) {
												echo $settings['show_register_opt_link']['url'];
											}
										}																	
									?>">
									<?php echo esc_html($settings['bottom_register_text']); ?></a>
								<?php endif; ?>							
							</div>
						<?php endif; ?>						
						<?php wp_nonce_field('ajax-login-nonce', 'ox-user-login-sc');						
						echo '<div class="techt-notification"><div class="ox-lr-response"></div></div>'; ?>					
					</form>
				<?php }					
				// $this->user_social_log_reg('login');

				if (!empty($settings['show_lost_password']) && $settings['show_lost_password'] == 'yes') {
					if ((empty($_GET['action'])) || (!empty($_GET['action']) && $_GET['action'] != 'techtrpf')) {
						$this->user_lost_password_form('login-time-fp');
					}
					if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'techtrpf') {
						$this->user_reset_password_form();
					}
				}
			}
			/*User Login Form*/

			/*User Register Form*/
			public function user_register_form()
			{
				$settings    = $this->get_settings();
				$id          = 'lr' . $this->get_id();
				$current_url = remove_query_arg('fake_arg');
				if ($settings['redirect_after_register'] && !empty($settings['redirect_url_reg']['url'])) {
					$redirect_url_reg = $settings['redirect_url_reg']['url'];
				} else {
					$redirect_url_reg = $current_url;
				}
				$dis_cap = ($settings['display_captcha_swtch'] == 'yes') ? 'yes' : 'no';
				$hide_form = 'no';//($settings['hide_form'] == 'yes') ? 'yes' : 'no';
				$dis_password = ($settings['ox_dis_pass_field'] == 'yes') ? 'yes' : 'no';
				$dis_password_conf = ($settings['ox_dis_conf_pass_field'] == 'yes') ? 'yes' : 'no';
				$widget_id = $this->get_id();
				$page_id = '';
				if (null !== \Elementor\Plugin::$instance->documents->get_current()) {
					$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
				}
				$dis_cap = ($settings['display_captcha_swtch'] == 'yes') ? 'yes' : 'no';
				$tceo = array();
				if (!empty($settings['ox_cst_email_opt']) && $settings['ox_cst_email_opt'] == 'yes') {
					$oxces = !empty($settings['ox_cst_email_subject']) ? $settings['ox_cst_email_subject'] : '';
					$oxcem = !empty($settings['ox_cst_email_message']) ? $settings['ox_cst_email_message'] : '';
					$tceo["ox_cst_email_opt"] = $settings['ox_cst_email_opt'];
					$tceo["ox_cst_email_subject"] = $oxces;
					$tceo["ox_cst_email_message"] = $oxcem;
				}
				$data_tceo = json_encode($tceo);
				$redirect_url_reg = $settings['redirect_url_reg']['url']  ? $settings['redirect_url_reg']['url'] : '';
				?>
				<form id="ox-user-register<?php echo esc_attr($id); ?>" name="ox-user-registration" class="ox-form-stacked " method="post" action="" data-dis_cap="<?php echo $dis_cap; ?>" ' data-tceo="<?php echo htmlspecialchars($data_tceo, ENT_QUOTES, 'UTF-8'); ?>" data-dis_password="<?php echo $dis_password; ?>" data-dis_password_conf="<?php echo $dis_password_conf; ?>" data-after_reg_redirect="<?php echo $redirect_url_reg; ?>" data-widget_id="<?php echo esc_attr($widget_id); ?>" data-page_id="<?php echo esc_attr($page_id); ?>">
			
				<?php if (!empty($hide_form) && $hide_form != 'yes') {
					if (!empty($settings['ox_dis_name_field']) && $settings['ox_dis_name_field'] == 'yes') {
						if (!empty($settings['ox_dis_fname_field']) && $settings['ox_dis_fname_field'] == 'yes') {?>
							<div class="ox-field-group ox-lr-f-first-name">
								<?php if ($settings['show_labels_reg'] == 'yes' && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {
										echo '<label for="first_name' . esc_attr($id) . '" class="ox-form-label">' . $settings['first_name_label'] . '</label>';
									}
									echo '<div class="ox-form-controls">';
									echo '<input type="text" name="first_name" id="first_name' . esc_attr($id) . '" placeholder="' . $settings['first_name_placeholder'] . '" class="ox-input ox-reg-f-load" required>';
									echo '</div>';
								?>
							</div>
						<?php }
						if (!empty($settings['ox_dis_lname_field']) && $settings['ox_dis_lname_field'] == 'yes') { 	?>
							<div class="ox-field-group ox-lr-f-last-name">
								<?php
									if ($settings['show_labels_reg'] == 'yes' && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {
										echo '<label for="last_name' . esc_attr($id) . '" class="ox-form-label">' . $settings['last_name_label'] . '</label>';
									}
									echo '<div class="ox-form-controls">';
									echo '<input type="text" name="last_name" id="last_name' . esc_attr($id) . '" placeholder="' . $settings['last_name_placeholder'] . '" class="ox-input ox-reg-f-load" required>';
									echo '</div>';
								?>
							</div>
						<?php }
					}

					/*username field start*/
					if (!empty($settings['ox_dis_username_field']) && $settings['ox_dis_username_field'] == 'yes') {
						echo '<div class="ox-field-group ox-lr-f-user-name">';
						if ($settings['show_labels_reg'] == 'yes' && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {
							echo '<label for="user_login' . esc_attr($id) . '" class="ox-form-label">' . $settings['user_name_label'] . '</label>';
						}
						echo '<div class="ox-form-controls">';
						echo '<input type="text" name="user_login" id="user_login' . esc_attr($id) . '" placeholder="' . $settings['user_name_placeholder'] . '" class="ox-input ox-reg-f-load" required>';
						echo '</div>';
						echo '</div>';
					}
					/*username field end*/
					?>
			
			<div class="ox-field-group ox-lr-f-email">
				<?php
						if ($settings['show_labels_reg'] == 'yes' && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {
							echo '<label for="user_email' . esc_attr($id) . '" class="ox-form-label">' . $settings['email_label'] . '</label>';
						}
						echo '<div class="ox-form-controls">';
						echo '<input type="email" name="user_email" id="user_email' . esc_attr($id) . '" placeholder="' . $settings['email_placeholder'] . '" class="ox-input ox-reg-f-load" required>';
						echo '</div>';
				?>
			</div>
			
			<?php
						/*password field start*/

						if (!empty($settings['ox_dis_pass_field']) && $settings['ox_dis_pass_field'] == 'yes') {

							$pattern_pass_reg = '';
							$ox_dis_pass_field_strong = ($settings['ox_dis_pass_field_strong'] == 'yes') ? 'yes' : 'no';
							if (!empty($ox_dis_pass_field_strong) && $ox_dis_pass_field_strong == 'yes') {
								if (!empty($settings['ox_dis_pass_pattern'])) {
									if ($settings['ox_dis_pass_pattern'] == 'pattern-1') {
										$pattern_pass_reg = 'pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"';
									} else if ($settings['ox_dis_pass_pattern'] == 'pattern-2') {
										$pattern_pass_reg = 'pattern="^(?=.*\d).{4,8}$"';
									} else if ($settings['ox_dis_pass_pattern'] == 'pattern-3') {
										$pattern_pass_reg = 'pattern="^(?=.*[0-9]+.*)(?=.*[a-zA-Z]+.*)[0-9a-zA-Z]{6,}$"';
									} else if ($settings['ox_dis_pass_pattern'] == 'pattern-4') {
										//$pattern_pass_reg='pattern="(?-i)(?=^.{8,}$)((?!.*\s)(?=.*[A-Z])(?=.*[a-z]))(?=(1)(?=.*\d)|.*[^A-Za-z0-9])^.*$"';
										$pattern_pass_reg = 'pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z0-9]+.*).{8,}"';
									} else if ($settings['ox_dis_pass_pattern'] == 'pattern-5') {
										//$pattern_pass_reg='pattern="(?-i)(?=^.{8,}$)((?!.*\s)(?=.*[A-Z])(?=.*[a-z]))((?=(.*\d){1,})|(?=(.*\W){1,}))^.*$"';
										$pattern_pass_reg = 'pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"';
									}
								}
							}

							$dpm_div = '';
							if (!empty($settings['ox_dis_pass_meter']) && $settings['ox_dis_pass_meter'] == 'yes') {
								$dpm_div = '<div class="password-strength-wrapper ' . $settings['psm_style'] . ' ' . $settings['psm_style2_in'] . '">';
								if ((!empty($settings['psm_text_switch']) && $settings['psm_text_switch'] == 'yes') && !empty($settings['psm_text'])) {
									$dpm_div .= esc_html($settings['psm_text']);
								}
								$dpm_div .= '<span id="password-strength"></span></div>';
							}
			?>			
									
			<div class="ox-field-group ox-lr-f-user-pass">
				<?php
							if ($settings['show_labels_reg'] == 'yes' && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {
								echo '<label for="user_password' . esc_attr($id) . '" class="ox-form-label">' . $settings['r_password_label'] . '</label>';
								if ((!empty($settings['psm_style']) && $settings['psm_style'] == 'style-2') && (!empty($settings['psm_style2_in']) && $settings['psm_style2_in'] == 'after-label')) {
									echo $dpm_div;
								}
							}
							$rfpm_class = '';
							if ((!empty($settings['psm_style']) && $settings['psm_style'] == 'style-2') && (!empty($settings['psm_style2_in']) && ($settings['psm_style2_in'] == 'inline-filed'))) {
								$rfpm_class = 'ox-form-rf-meter';
							}
							echo '<div class="ox-form-controls ' . $rfpm_class . '">';
							echo '<input type="password" name="user_password" id="user_password' . esc_attr($id) . '" placeholder="' . $settings['r_password_placeholder'] . '" class="ox-input ox-reg-f-load ox-reg-pass-hint" required ' . $pattern_pass_reg . '>';

							$passshowicon = $passhideicon = '';
							if (!empty($settings['ox_dis_show_pass_icon']) && $settings['ox_dis_show_pass_icon'] == 'yes') {
								if (!empty($settings['showicon'])) {
									ob_start();
									\Elementor\Icons_Manager::render_icon($settings['showicon'], ['aria-hidden' => 'true']);
									$passshowicon = ob_get_contents();
									ob_end_clean();
								}
								if (!empty($settings['hideicon'])) {
									ob_start();
									\Elementor\Icons_Manager::render_icon($settings['hideicon'], ['aria-hidden' => 'true']);
									$passhideicon = ob_get_contents();
									ob_end_clean();
								}
								echo '<span toggle="#user_password' . esc_attr($id) . '" class="ox-password-field-show oxsi" data-passshowicon="' . esc_html($passshowicon) . '" data-passhideicon="' . esc_html($passhideicon) . '">' . $passshowicon . '</span>';
							}
							//hint
							$passshowiconh = '';
							if ((!empty($settings['ox_dis_pass_pattern'])) && (!empty($settings['ox_dis_pass_hint']) && $settings['ox_dis_pass_hint'] == 'yes') && !empty($settings['dis_pass_hint_on']) && $settings['dis_pass_hint_on'] == 'pshc') {
								if (!empty($settings['showiconh'])) {
									ob_start();
									\Elementor\Icons_Manager::render_icon($settings['showiconh'], ['aria-hidden' => 'true']);
									$passshowiconh = ob_get_contents();
									ob_end_clean();
								}
								echo '<span toggle="#user_password' . esc_attr($id) . '" class="ox-password-field-showh oxsi">' . $passshowiconh . '</span>';
							}

							if ((!empty($settings['psm_style']) && $settings['psm_style'] == 'style-2') && (!empty($settings['psm_style2_in']) && ($settings['psm_style2_in'] == 'inline-filed' || $settings['psm_style2_in'] == 'after-field'))) {
								echo $dpm_div;
							}
							echo '</div>';
				?>
			</div>
			<?php
							if ((!empty($settings['ox_dis_pass_pattern'])) && (!empty($settings['ox_dis_pass_hint']) && $settings['ox_dis_pass_hint'] == 'yes') && !empty($settings['dis_pass_hint_on'])) {
								echo '<ul class="ox-pass-indicator ' . $settings['dis_pass_hint_on'] . ' ' . $settings['ox_dis_pass_pattern'] . ' ' . $settings['dis_pass_hint_layout'] . '">';
								if ($settings['ox_dis_pass_pattern'] == 'pattern-1' || $settings['ox_dis_pass_pattern'] == 'pattern-4' || $settings['ox_dis_pass_pattern'] == 'pattern-5') {
									echo '<li><span class="ox-min-eight-character"><i class="fas fa-question-circle" aria-hidden="true"></i></span>Minimum eight characters</li>';
								}
								if ($settings['ox_dis_pass_pattern'] == 'pattern-1' || $settings['ox_dis_pass_pattern'] == 'pattern-2' || $settings['ox_dis_pass_pattern'] == 'pattern-3') {
									echo '<li><span class="ox-one-number"><i class="fas fa-question-circle" aria-hidden="true"></i></span>1 number (0-9)</li>';
								}
								if ($settings['ox_dis_pass_pattern'] == 'pattern-1' || $settings['ox_dis_pass_pattern'] == 'pattern-3') {
									echo '<li><span class="ox-low-lat-case"><i class="fas fa-question-circle" aria-hidden="true"></i></span>1 letter (Aa-Zz)</li>';
								}

								if ($settings['ox_dis_pass_pattern'] == 'pattern-1') {
									echo '<li><span class="ox-one-special-char"><i class="fas fa-question-circle" aria-hidden="true"></i></span>1 Special Character (!@#$%^&*)</li>';
								}

								if ($settings['ox_dis_pass_pattern'] == 'pattern-2') {
									echo '<li class=""><span class="ox-four-eight-character"><i class="fas fa-question-circle" aria-hidden="true"></i></span>Four to eight characters</li>';
								}

								if ($settings['ox_dis_pass_pattern'] == 'pattern-3') {
									echo '<li class=""><span class="ox-min-six-character"><i class="fas fa-question-circle" aria-hidden="true"></i></span>Minimum six characters</li>';
								}

								if ($settings['ox_dis_pass_pattern'] == 'pattern-4' || $settings['ox_dis_pass_pattern'] == 'pattern-5') {
									echo '<li><span class="ox-low-upper-case"><i class="fas fa-question-circle" aria-hidden="true"></i></span>1 lowercase(a-z) & 1 uppercase(A-Z)</li>';
								}
								if ($settings['ox_dis_pass_pattern'] == 'pattern-4') {
									echo '<li><span class="ox-digit-alpha"><i class="fas fa-question-circle" aria-hidden="true"></i></span>1 alphanumeric (1Aa-9Zz)</li>';
								}

								if ($settings['ox_dis_pass_pattern'] == 'pattern-5') {
									echo '<li><span class="ox-number-special"><i class="fas fa-question-circle" aria-hidden="true"></i></span>1 number(0-9) Or 1 special character  (!@#$%^&*)</li>';
								}

								echo '</ul>';
							}

							if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') {
			?>
				<div class="ox-field-group ox-lr-f-user-conf-pass">
					<?php
								if ($settings['show_labels_reg'] == 'yes' && ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register')) {
									echo '<label for="user_conf_password' . esc_attr($id) . '" class="ox-form-label">' . $settings['r_conf_password_label'] . '</label>';
								}
								echo '<div class="ox-form-controls">';
								echo '<input type="password" name="user_conf_password" id="user_conf_password' . esc_attr($id) . '" placeholder="' . $settings['r_conf_password_placeholder'] . '" class="ox-input ox-reg-f-load" required >';
								
								echo '</div>';
					?>
				</div>			
			<?php
							}

							if ((!empty($settings['psm_style']) && $settings['psm_style'] == 'style-1')) {
								echo $dpm_div;
							}
							if (!empty($settings['ox_dis_pass_meter']) && $settings['ox_dis_pass_meter'] == 'yes') {
								wp_enqueue_script('password-strength-meter'); ?>
				
				<script>
				jQuery( document ).ready( function( $ ) {
					var rflm = ' form#ox-user-register<?php echo esc_attr($id); ?>'; $( 'body' ).on( 'keyup' , 'form#ox-user-register<?php echo esc_attr($id); ?> input[name=user_password]<?php if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') { ?>, form#ox-user-register<?php echo esc_attr($id); ?> input[name=user_conf_password] <?php } ?>' , function( event ) { wdmChkPwdStrength( $('form#ox-user-register<?php echo esc_attr($id); ?> input[name=user_password]'), <?php if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') { ?> $('form#ox-user-register<?php echo esc_attr($id); ?> input[name=user_conf_password]'), <?php } ?> $('form#ox-user-register<?php echo esc_attr($id); ?> #password-strength'), $('input[type=submit]'), ['admin', 'happy' , 'hello' , '1234' ] ); }); <?php if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') { ?> function wdmChkPwdStrength( $pwd, $confirmPwd, $strengthStatus, $submitBtn, blacklistedWords ) { <?php } else { ?> function wdmChkPwdStrength( $pwd,$strengthStatus, $submitBtn, blacklistedWords ) { <?php } ?> var pwd=$pwd.val(); <?php if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') { ?> var confirmPwd=$confirmPwd.val(); <?php } ?> blacklistedWords=blacklistedWords.concat( wp.passwordStrength.userInputDisallowedList() ) $submitBtn.attr( 'disabled' , 'disabled' ); $strengthStatus.removeClass( 'short bad good strong' ); <?php if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') { ?> var pwdStrength=wp.passwordStrength.meter( pwd, blacklistedWords, confirmPwd ); <?php } else { ?> var pwdStrength=wp.passwordStrength.meter( pwd, blacklistedWords ); <?php } ?> switch ( pwdStrength ) { case 2: $strengthStatus.addClass( 'bad' ).html( pwsL10n.bad ); $strengthStatus.closest('.ox-user-register').find('.password-strength-wrapper').addClass( 'show' ); break; case 3: $strengthStatus.addClass( 'good' ).html( pwsL10n.good ); $strengthStatus.closest('.ox-user-register').find('.password-strength-wrapper').addClass( 'show' ); break; case 4: $strengthStatus.addClass( 'strong' ).html( pwsL10n.strong ); $strengthStatus.closest('.ox-user-register').find('.password-strength-wrapper').addClass( 'show' ); break; case 5: $strengthStatus.addClass( 'short' ).html( pwsL10n.mismatch ); $strengthStatus.closest('.ox-user-register').find('.password-strength-wrapper').addClass( 'show' ); default: $strengthStatus.addClass( 'short' ).html( pwsL10n.short ); $strengthStatus.closest('.ox-user-register').find('.password-strength-wrapper').addClass( 'show' ); } <?php if (!empty($settings['ox_dis_conf_pass_field']) && $settings['ox_dis_conf_pass_field'] == 'yes') { ?> if ( (4===pwdStrength && '' !==confirmPwd.trim()) ) { $submitBtn.removeAttr( 'disabled' ); } <?php } else { ?> if (4===pwdStrength) { $submitBtn.removeAttr( 'disabled' ); } <?php } ?> return pwdStrength; } }); </script>
					<?php
							}
						}	/*password field end*/ ?>
					<?php if ($settings['show_additional_message']) : ?>
					<div class="ox-field-group ox-lr-f-add-msg">
						<span class="ox-register-additional-message"><?php echo $settings['additional_message']; ?></span>
					</div>
					<?php endif;
						$id = 'lr' . $this->get_id();

						if (!empty($settings['form_selection']) && (($settings['form_selection'] == 'ox_register' && (!empty($settings['display_captcha_swtch']) && $settings['display_captcha_swtch'] == 'yes'))
							|| ($settings['form_selection'] == 'ox_login_register' && (!empty($settings['display_captcha_swtch']) && $settings['display_captcha_swtch'] == 'yes')))) {

							$options = get_option('petrona_options');
							if (!empty($options['site_key_recaptcha'])) {
								$site_key_captcha = $options['site_key_recaptcha'];
								?>
								<div class="techt-re-captcha ox-lrfp-ff-<?php echo $settings['form_align']; ?>">
								<div id="inline-badge-<?php echo esc_attr($id); ?>"></div>
								<script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=plus_onLoadReCaptcha<?php echo esc_attr($id); ?>"></script>
								<script>
								window.plus_onLoadReCaptcha<?php echo esc_attr($id); ?> = function() {
									var clientId = grecaptcha.render('inline-badge-<?php echo esc_attr($id); ?>', {
										'sitekey': '<?php echo $site_key_captcha; ?>',
										'badge': 'inline',
										'size': 'invisible'
									});
									grecaptcha.ready(function() {
										grecaptcha.execute(clientId, {
												action: 'register'
											})
											.then(function(token) {
												jQuery('#ox-user-register<?php echo esc_attr($id); ?>').prepend('<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response-<?php echo esc_attr($id); ?>" value="' + token + '">');
											});
									});
								}
								</script>

								</div>
							<?php }
						} ?>
						<?php
						/*Terms of Conditions start*/
						
						if (!empty($settings['ox_terms_condition_opt']) && $settings['ox_terms_condition_opt'] == 'yes') {
							?>
						<div class="ox-field-group ox-lr-f-tac ox-lrfp-ff-<?php echo $settings['form_align']; ?>">
						<?php
							echo '<div class="ox-form-controls " style="display: flex;">';
							echo '<input type="checkbox" name="user_tac" id="user_tac' . esc_attr($id) . '" class="ox-input" required>';
							if (!empty($settings['form_align']) && $settings['form_align'] == 'left' || !empty($settings['form_align']) && $settings['form_align'] == 'center') {
								echo '<label class="user_tac_checkbox" for="user_tac' . esc_attr($id) . '"></label>';
							}
							if ($settings['form_selection'] == 'ox_register' || $settings['form_selection'] == 'ox_login_register') {
								echo '<label class="ox-form-label" for="user_tac' . esc_attr($id) . '">' . $settings['r_terms_conition_label'] . '</label>';
							}
							if (!empty($settings['form_align']) && $settings['form_align'] == 'right') {
								echo '<label class="user_tac_checkbox" for="user_tac' . esc_attr($id) . '" style="padding-left:15px;margin-left:15px;"></label>';
							}
							echo '</div>';
							echo '</div>';
						}
						/*Terms of Conditions end*/
						?>


						<div <?php echo $this->get_render_attribute_string('submit-group'); ?>>
							<button type="submit" class="ox-button" name="wp-submit">
								<?php if (!empty($settings['button_text_reg'])) : ?>
									<span><?php echo $settings['button_text_reg']; ?></span>
								<?php endif; ?>
							</button>
						</div>

						<?php
						$show_login = $settings['show_login'];
						if ($show_login) : ?>

							<div class="ox-field-group ox-user-register-password">
								<?php if (!empty($show_login) && $show_login == 'yes') :
									if (!empty($settings['login_before_text'])) {
										echo '<div class="login-before-text">' . $settings['login_before_text'] . '</div>';
									}
								?><a class="ox-login" href="<?php
														if ($settings['show_login_opt'] == 'default') {
															echo wp_login_url();
														} else if ($settings['show_login_opt'] == 'custom') {
															if (!empty($settings['show_login_opt_link']['url'])) {
																echo $settings['show_login_opt_link']['url'];
															}
														}
														?>">
										<?php echo esc_html($settings['bottom_login_text']); ?>
									</a>
								<?php endif; ?>
							</div>

						<?php endif; ?>

						<?php wp_nonce_field('ajax-login-nonce', 'ox-user-register-sc');
						echo '<div class="techt-notification"><div class="ox-lr-response"></div></div>';
					}
				    ?>
					</form>

					<?php

					// $this->user_social_log_reg('register');
				}
				/*User Register Form*/

				/*Login Ajax*/
				public function user_login_ajax_script()
				{

					$settings    = $this->get_settings();
					$current_url = remove_query_arg('fake_arg');
					$id          = 'lr' . $this->get_id();

					if ($settings['redirect_after_login'] && !empty($settings['redirect_url']['url'])) {
						$redirect_url = $settings['redirect_url']['url'];
					} else {
						$redirect_url = $current_url;
					}
				    ?>

					<script type="text/javascript">
						jQuery(document).ready(function($) {
							//login start
							var login_form = 'form#ox-user-login<?php echo esc_attr($id); ?>';
							var loading_text = '<span class="loading-spinner-log"><i class="fas fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["login_msg_loading_txt"]); ?>';
							var notverify = '<span class="loading-spinner-log"><i class="far fa-times-circle" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_validation"]); ?>';
							var incorrect_text = '<span class="loading-spinner-log"><i class="far fa-times-circle" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_error"]); ?>';
							var correct_text = '<span class="loading-spinner-log"><i class="far fa-envelope" aria-hidden="true"></i></span><?php echo esc_html($settings["login_msg_success"]); ?>';


							$(login_form).on('submit', function(e) {
								$.ajax({
									type: 'POST',
									dataType: 'json',
									url: techt_ajax_url,
									data: {
										'action': 'techt_ajax_login',
										'username': $(login_form + ' #user<?php echo esc_attr($id); ?>').val(),
										'password': $(login_form + ' #password<?php echo esc_attr($id); ?>').val(),
										'security': $(login_form + ' #ox-user-login-sc').val()
									},
									beforeSend: function() {
										$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
										$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(loading_text);
									},
									success: function(data) {
										if (data.loggedin == true) {
											$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
											$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(correct_text);
											document.location.href = '<?php echo esc_url($redirect_url); ?>';
										} else {
											$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
											$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(notverify);
										}
									},
									error: function(data) {
										$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
										$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(incorrect_text);
									},
									complete: function() {
										setTimeout(function() {
											$("#ox-user-login<?php echo esc_attr($id); ?> .techt-notification").removeClass("active");
										}, 1500);
									}
								});
								e.preventDefault();

							});

							/*hover*/
							$("#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-dropdown,#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-dropdown .lr-extra-div").on("mouseenter", function() {
								$('#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-dropdown .lr-extra-div').show('slow')
							}).on("mouseleave", function() {
								setTimeout(function() {
									if (!($('#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-dropdown:hover').length > 0))
										$('#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-dropdown .lr-extra-div').hide('slow');
								}, 200);
							});
							/*hover*/
							/*click popup*/
							$("#<?php echo esc_attr($id); ?>.ox-user-login .ox-lr-model-btn").on("click", function() {
								$("#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-modal .ox-modal-dialog").toggle('slow');
							});
							/*close icon*/
							$("#<?php echo esc_attr($id); ?>.ox-user-login .lr-close-custom_img").on("click", function() {
								$("#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-modal .ox-modal-dialog").toggle('slow');
							});

							/*close icon*/
							/*click popup*/
							/*popup*/
							$('#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-popup .ox-ulsp-trigger').on("click", function(e) {
								$('#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-popup .ox-modal-wrapper').toggleClass('open');
								$('#<?php echo esc_attr($id); ?>.ox-user-login.ox-user-login-skin-popup .ox-ulsp-page-wrapper').toggleClass('blur');
								$('body').toggleClass('techt-body-no-scroll');
								return false;
							});
							/*popup*/

							/*lost password*/
							$("#ox-user-login<?php echo esc_attr($id); ?> .ox-lost-password").on("click", function() {
								$("#ox-user-lost-password<?php echo esc_attr($id); ?>.ox-form-stacked-fp ").toggle();
							});

							/*back*/
							$("#ox-user-lost-password<?php echo esc_attr($id); ?>.ox-form-stacked-fp .ox-lpu-back").on("click", function() {
								$("#ox-user-lost-password<?php echo esc_attr($id); ?>.ox-form-stacked-fp").hide();
							});
							/*back*/
							/*lost password*/
						});
					</script>
				<?php
				}
				/*Login Ajax*/

				/*Register Ajax*/
				public function user_register_ajax_script()
				{

					$settings = $this->get_settings();
					$id       = 'lr' . $this->get_id();
					if (!empty($settings['auto_loggedin']) && $settings['auto_loggedin'] == 'yes' && $settings['ox_dis_pass_field'] == 'yes') {
						$auto_loggedin = true;
					} else {
						$auto_loggedin = false;
					}

					$widget_id = $this->get_id();
					$page_id = '';
					if (null !== \Elementor\Plugin::$instance->documents->get_current()) {
						$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
					}

					if (!empty($settings['redirect_after_register']) && $settings['redirect_after_register'] == 'yes' && !empty($settings['redirect_url_reg']['url'])) {
						$reg_redirect_page = $settings['redirect_url_reg']['url'];
					} else {
						$reg_redirect_page = '';
					}

				    ?>

					<script type="text/javascript">
						jQuery(document).ready(function($) {
							//register start
							var register_form = 'form#ox-user-register<?php echo esc_attr($id); ?>';
							var reg_loading_text = '<span class="loading-spinner-reg"><i class="fas fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["reg_msg_loading"]); ?>';
							var reg_email_duplicate = '<span class="loading-spinner-reg"><i class="far fa-times-circle" aria-hidden="true"></i></span><?php echo esc_html($settings["reg_msg_email_duplication"]); ?>';
							var reg_incorrect_text = '<span class="loading-spinner-reg"><i class="far fa-times-circle" aria-hidden="true"></i></span><?php echo esc_html($settings["reg_msg_error"]); ?>';
							var reg_correct_text = '<span class="loading-spinner-reg"><i class="far fa-envelope" aria-hidden="true"></i></span><?php echo esc_html($settings["reg_msg_success"]); ?>';
							var reg_redirect_page = "<?php echo $reg_redirect_page; ?>";

							<?php if ((!empty($settings['cst_validation_switch']) && $settings['cst_validation_switch'] == 'yes')) {
								if (!empty($settings['ox_dis_name_field']) && $settings['ox_dis_name_field'] == 'yes') {
									if (!empty($settings['ox_dis_fname_field']) && $settings['ox_dis_fname_field'] == 'yes') { ?>
										$(register_form + ' #first_name<?php echo esc_attr($id); ?>').keyup(function() {
											var first_name = $(this).val();
											if ($(this).hasClass('ox-reg-f-load')) {
												$(this).removeClass("ox-reg-f-load");
											}
											$(".ox-reg-form-fn-error").remove();
											if (first_name == '' || first_name == undefined) {
												$(this).after('<span class="ox-reg-form-fn-error ox-reg-form-error-field"><?php echo esc_html($settings["v_efn"]); ?></span>');
											}
										});
									<?php }
									if (!empty($settings['ox_dis_lname_field']) && $settings['ox_dis_lname_field'] == 'yes') { ?>
										$(register_form + ' #last_name<?php echo esc_attr($id); ?>').keyup(function() {
											var last_name = $(this).val();
											$(".ox-reg-form-ln-error").remove();
											if ($(this).hasClass('ox-reg-f-load')) {
												$(this).removeClass("ox-reg-f-load");
											}
											if (last_name == '' || last_name == undefined) {
												$(this).after('<span class="ox-reg-form-ln-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eln"]); ?></span>');
											}
										});
									<?php }
								}

								if (!empty($settings['ox_dis_username_field']) && $settings['ox_dis_username_field'] == 'yes') { ?>
									$(register_form + ' #user_login<?php echo esc_attr($id); ?>').keyup(function() {
										var user_login = $(this).val();
										$(".ox-reg-form-un-error").remove();
										if ($(this).hasClass('ox-reg-f-load')) {
											$(this).removeClass("ox-reg-f-load");
										}
										if (user_login == '' || user_login == undefined) {
											$(this).after('<span class="ox-reg-form-un-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eun"]); ?></span>');
										}
									});
								<?php }

								if (!empty($settings['ox_dis_pass_field']) && $settings['ox_dis_pass_field'] == 'yes') { ?>
									$(register_form + ' #user_password<?php echo esc_attr($id); ?>').keyup(function() {
										var user_password = $(this).val();
										$(".ox-reg-form-pass-error").remove();
										if ($(this).hasClass('ox-reg-f-load')) {
											$(this).removeClass("ox-reg-f-load");
										}
										if (user_password == '' || user_password == undefined) {
											$(this).after('<span class="ox-reg-form-pass-error ox-reg-form-error-field"><?php echo esc_html($settings["v_epass"]); ?></span>');
										}
									});
									<?php if (!empty($settings['ox_dis_pass_field']) && $settings['ox_dis_pass_field'] == 'yes') { ?>
										$(register_form + ' #user_conf_password<?php echo esc_attr($id); ?>').keyup(function() {
											var user_conf_password = $(this).val();
											$(".ox-reg-form-repass-error").remove();
											if ($(this).hasClass('ox-reg-f-load')) {
												$(this).removeClass("ox-reg-f-load");
											}
											if (user_conf_password == '' || user_conf_password == undefined) {
												$(this).after('<span class="ox-reg-form-repass-error ox-reg-form-error-field"><?php echo esc_html($settings["v_erepass"]); ?></span>');
											}
										});
									<?php } ?>
								<?php } ?>


								$(register_form + ' #user_email<?php echo esc_attr($id); ?>').keyup(function() {
									var mailformat = /^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/;
									var user_email = $(this).val();
									$(".ox-reg-form-email-error").remove();
									if ($(this).hasClass('ox-reg-f-load')) {
										$(this).removeClass("ox-reg-f-load");
									}
									if (user_email == '' || user_email == undefined) {
										$(this).after('<span class="ox-reg-form-email-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eemail"]); ?></span>');
									} else if (!user_email.match(mailformat)) {
										$(this).after('<span class="ox-reg-form-email-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eemail"]); ?></span>');
									}
								});


							<?php } ?>

							$(register_form).on('submit', function(e) {

								var validate = true;

								<?php if ((!empty($settings['cst_validation_switch']) && $settings['cst_validation_switch'] == 'yes')) {

								?>

									var first_name = $(register_form + ' #first_name<?php echo esc_attr($id); ?>').val();
									var last_name = $(register_form + ' #last_name<?php echo esc_attr($id); ?>').val();
									var user_login = $(register_form + ' #user_login<?php echo esc_attr($id); ?>').val();
									var user_email = $(register_form + ' #user_email<?php echo esc_attr($id); ?>').val();
									var user_password = $(register_form + ' #user_password<?php echo esc_attr($id); ?>').val();
									var user_conf_password = $(register_form + ' #user_conf_password<?php echo esc_attr($id); ?>').val();

									<?php if (!empty($settings['ox_dis_name_field']) && $settings['ox_dis_name_field'] == 'yes') {
										if (!empty($settings['ox_dis_fname_field']) && $settings['ox_dis_fname_field'] == 'yes') {  ?>
											$(".ox-reg-form-fn-error").remove();
											if ($(this).hasClass('ox-reg-f-load')) {
												$(this).removeClass("ox-reg-f-load");
											}
											if (first_name == '' || first_name == undefined) {
												validate = false;
												$('#first_name<?php echo esc_attr($id); ?>').after('<span class="ox-reg-form-fn-error ox-reg-form-error-field"><?php echo esc_html($settings["v_efn"]); ?></span>');
											}
										<?php }
										if (!empty($settings['ox_dis_lname_field']) && $settings['ox_dis_lname_field'] == 'yes') { ?>
											$(".ox-reg-form-ln-error").remove();
											if ($(this).hasClass('ox-reg-f-load')) {
												$(this).removeClass("ox-reg-f-load");
											}
											if (last_name == '' || last_name == undefined) {
												validate = false;
												$('#last_name<?php echo esc_attr($id); ?>').after('<span class="ox-reg-form-ln-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eln"]); ?></span>');
											}
										<?php }
									}

									if (!empty($settings['ox_dis_username_field']) && $settings['ox_dis_username_field'] == 'yes') { ?>
										$(".ox-reg-form-un-error").remove();
										if ($(this).hasClass('ox-reg-f-load')) {
											$(this).removeClass("ox-reg-f-load");
										}
										if (user_login == '' || user_login == undefined) {
											validate = false;
											$('#user_login<?php echo esc_attr($id); ?>').after('<span class="ox-reg-form-un-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eun"]); ?></span>');
										}
									<?php } ?>

									var mailformat = /^w+([.-]?w+)*@w+([.-]?w+)*(.w{2,3})+$/;
									$(".ox-reg-form-email-error").remove();
									if ($(this).hasClass('ox-reg-f-load')) {
										$(this).removeClass("ox-reg-f-load");
									}
									if (user_email == '' || user_email == undefined) {
										validate = false;
										$('#user_email<?php echo esc_attr($id); ?>').after('<span class="ox-reg-form-email-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eemail"]); ?></span>');
									} else if (!user_email.match(mailformat)) {
										$(this).after('<span class="ox-reg-form-email-error ox-reg-form-error-field"><?php echo esc_html($settings["v_eemail"]); ?></span>');
									}

									<?php if (!empty($settings['ox_dis_pass_field']) && $settings['ox_dis_pass_field'] == 'yes') { ?>
										$(".ox-reg-form-pass-error").remove();
										if ($(this).hasClass('ox-reg-f-load')) {
											$(this).removeClass("ox-reg-f-load");
										}
										if (user_password == '' || user_password == undefined) {
											validate = false;
											$('#user_password<?php echo esc_attr($id); ?>').after('<span class="ox-reg-form-pass-error ox-reg-form-error-field"><?php echo esc_html($settings["v_epass"]); ?></span>');
										}

										$(".ox-reg-form-repass-error").remove();
										if ($(this).hasClass('ox-reg-f-load')) {
											$(this).removeClass("ox-reg-f-load");
										}
										if (user_conf_password == '' || user_conf_password == undefined) {
											validate = false;
											$('#user_conf_password<?php echo esc_attr($id); ?>').after('<span class="ox-reg-form-repass-error ox-reg-form-error-field"><?php echo esc_html($settings["v_erepass"]); ?></span>');
										}
								<?php }
								} ?>

								if (validate) {
									$(register_form + ' button.ox-button').attr("disabled", true);
									$.ajax({
										type: 'POST',
										dataType: 'json',
										url: techt_ajax_url,
										data: {
											'action': 'techt_ajax_register', //calls wp_ajax_nopriv
											'first_name': $(register_form + ' #first_name<?php echo esc_attr($id); ?>').val(),
											'last_name': $(register_form + ' #last_name<?php echo esc_attr($id); ?>').val(),
											'user_login': $(register_form + ' #user_login<?php echo esc_attr($id); ?>').val(),
											'email': $(register_form + ' #user_email<?php echo esc_attr($id); ?>').val(),
											'password': $(register_form + ' #user_password<?php echo esc_attr($id); ?>').val(),
											'conf_password': $(register_form + ' #user_conf_password<?php echo esc_attr($id); ?>').val(),
											'security': $(register_form + ' #ox-user-register-sc').val(),
											'token': $(register_form + ' .g-recaptcha-response-<?php echo esc_attr($id); ?>').val(),
											'dis_cap': $(register_form).data('dis_cap'),
											'tceo': $(register_form).data('tceo'),
											'dis_password': $(register_form).data('dis_password'),
											'dis_password_conf': $(register_form).data('dis_password_conf'),
											'auto_loggedin': '<?php echo $auto_loggedin; ?>',
											'widget_id': '<?php echo $widget_id; ?>',
											'page_id': '<?php echo $page_id; ?>',
										},
										beforeSend: function() {
											$(register_form + " .techt-notification").addClass("active");
											$(register_form + " .techt-notification .ox-lr-response").html(reg_loading_text);
										},
										success: function(data) {
											if (data.registered == true) {
												$(register_form + " .techt-notification").addClass("active");
												$(register_form + " .techt-notification .ox-lr-response").html(reg_correct_text);
												if (reg_redirect_page != '' && reg_redirect_page != undefined) {
													document.location.href = reg_redirect_page;
												} else {
													location.reload(true);
												}
											} else if (data.registered == false) {
												$(register_form + " .techt-notification").addClass("active");
												$(register_form + " .techt-notification .ox-lr-response").html(data.message);
											}
											$(register_form + ' button.ox-button').removeAttr("disabled");
										},
										error: function(data) {
											$(register_form + " .techt-notification").addClass("active");
											$(register_form + " .techt-notification .ox-lr-response").html(reg_incorrect_text);
										},
										complete: function() {
											setTimeout(function() {
												$(register_form + " .techt-notification").removeClass("active");
											}, 1500);
										}
									});
								}
								e.preventDefault();

							});

							/*hover*/
							$("#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-dropdown,#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-dropdown .lr-extra-div").on("mouseenter", function() {
								$('#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-dropdown .lr-extra-div').show('slow')
							}).on("mouseleave", function() {
								setTimeout(function() {
									if (!($('#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-dropdown:hover').length > 0))
										$('#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-dropdown .lr-extra-div').hide('slow');
								}, 200);
							});
							/*hover*/

							/*click popup*/
							$("#<?php echo esc_attr($id); ?>.ox-user-register .ox-lr-model-btn").on("click", function() {
								$("#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-modal .ox-modal-dialog").toggle('slow');
							});
							/*close icon*/
							$("#<?php echo esc_attr($id); ?>.ox-user-register .lr-close-custom_img").on("click", function() {
								$("#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-modal .ox-modal-dialog").toggle('slow');
							});

							/*close icon*/
							/*click popup*/

							/*popup*/
							$('#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-popup .ox-ursp-trigger').on("click", function() {
								$('#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-popup .ox-modal-wrapper').toggleClass('open');
								$('#<?php echo esc_attr($id); ?>.ox-user-register.ox-user-register-skin-popup .ox-ursp-page-wrapper').toggleClass('blur');
								return false;
							});
							/*popup*/

							/*lost password*/
							$("#ox-user-register<?php echo esc_attr($id); ?> .ox-lost-password").on("click", function() {
								$("#ox-user-lost-password<?php echo esc_attr($id); ?>.ox-form-stacked-fp ").toggle();
							});
							/*back*/
							$("#ox-user-lost-password<?php echo esc_attr($id); ?>.ox-form-stacked-fp .ox-lpu-back").on("click", function() {
								$("#ox-user-lost-password<?php echo esc_attr($id); ?>.ox-form-stacked-fp").hide();
							});
							/*back*/
							/*lost password*/
						});
					</script>
					<?php
				}
				/*Register Ajax*/

				/*social login start*/
				public function user_social_log_reg($type = '')
				{
					$settings = $this->get_settings();
					/*condition*/
					$id          = 'lr' . $this->get_id();
					$gid = '';
					if ($type == 'login') {
						$action = 'techt_ajax_facebook_login';
						$gid = 'login' . $this->get_id();
					} else if ($type == 'register') {
						$action = 'techt_ajax_facebook_login';
						$gid = 'register' . $this->get_id();
					}

					$widget_id = $this->get_id();
					$page_id = '';
					if (null !== \Elementor\Plugin::$instance->documents->get_current()) {
						$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
					}

					if (((!empty($settings['ox_sl_facebook']) && $settings['ox_sl_facebook'] == "yes") || (!empty($settings['ox_sl_google']) && $settings['ox_sl_google'] == "yes"))) {

						if (!empty($settings['ox_sl_layout_opt']) && $settings['ox_sl_layout_opt'] == 'ox_sl_layout_opt_1') {
							echo '<style>div#g-signin2-' . $gid . ' .abcRioButton,div#g-signin2-' . $gid . ' .abcRioButton{height:24px!important;width:70px!important}div#g-signin2-' . $gid . ' .abcRioButton .abcRioButtonIcon,div#g-signin2-' . $gid . ' .abcRioButton .abcRioButtonIcon{padding:5px!important}div#g-signin2-' . $gid . ' .abcRioButton .abcRioButtonIcon .abcRioButtonSvgImageWithFallback,div#g-signin2-' . $gid . ' .abcRioButton .abcRioButtonIcon .abcRioButtonSvgImageWithFallback{width:16px!important;height:16px!important}div#g-signin2-' . $gid . ' .abcRioButtonContentWrapper .abcRioButtonContents,div#g-signin2-' . $gid . ' .abcRioButtonContentWrapper .abcRioButtonContents{font-size:11px!important;line-height:1!important;margin:0}div#g-signin2-' . $gid . ' .abcRioButtonContentWrapper,div#g-signin2-' . $gid . ' .abcRioButtonContentWrapper{display:flex;align-items:center}div#g-signin2-' . $gid . ',div#g-signin2-' . $gid . '{margin-left:15px;border-radius:3px!important;overflow:hidden}</style>';
						}
						if (!empty($settings['ox_sl_layout_opt']) && $settings['ox_sl_layout_opt'] == 'ox_sl_layout_opt_2') {
							echo '<style>.ox-social-login-wrapper > div{margin-right: 10px;}.ox-wp-lrcf .ox-social-login-wrapper{margin-top:10px;}</style>';
						}

						$widget_id = $this->get_id();
						$page_id = '';
						if (null !== \Elementor\Plugin::$instance->documents->get_current()) {
							$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
						}

						echo '<div class="ox-social-login-wrapper">';
						if ((!empty($settings['ox_sl_facebook']) && $settings['ox_sl_facebook'] == 'yes')) {
							$check_fb_appid = get_option('techt_api_connection_data');
							$facebook_appid = (!empty($check_fb_appid['techt_facebook_app_id'])) ? $check_fb_appid['techt_facebook_app_id'] : '';
							$nonce = wp_create_nonce('ajax-login-nonce');
					        ?>
							<script>
								function statusChangeCallback(response, type = '') {
									if (response.status === 'connected') {
										facebook_fetch_info(response, type);
									} else {}
								}

								function checkloginstatus(type = '') {
									FB.login(function(e) {
										e.authResponse && statusChangeCallback(e, type);
									}, {
										scope: "email"
									});
									/*FB.getLoginStatus(function(response) {
									  statusChangeCallback(response,type);
									});*/
								}


								window.fbAsyncInit = function() {
									FB.init({
										appId: '<?php echo $facebook_appid; ?>',
										cookie: true,
										xfbml: true,
										version: 'v7.0'
									});
									FB.login(function(e) {
										e.authResponse && statusChangeCallback(e);
									}, {
										scope: "email"
									});
									/*FB.getLoginStatus(function(response) {   
									  statusChangeCallback(response);        
									});*/
								};
								(function(d, s, id) {
									var js, fjs = d.getElementsByTagName(s)[0];
									if (d.getElementById(id)) return;
									js = d.createElement(s);
									js.id = id;
									js.src = "//connect.facebook.net/en_US/sdk.js";
									fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));

								function facebook_fetch_info(response, type) {
									FB.api('/me', {
										fields: 'id, name, first_name, last_name, email, link, gender, locale, picture'
									}, function(res) {
										var action = 'techt_ajax_facebook_login';
										if (response.authResponse.accessToken && res.id && res.email && action) {
											var facebook_fetch_data = {
												'action': action,
												'accessToken': response.authResponse.accessToken,
												'id': res.id,
												'name': res.name,
												'first_name': res.first_name,
												'last_name': res.last_name,
												'email': res.email,
												'link': res.link,
												'widget_id': "<?php echo $widget_id; ?>",
												'page_id': "<?php echo $page_id; ?>",
												'nonce': "<?php echo $nonce; ?>",
											};
											jQuery.ajax({
												type: 'POST',
												dataType: 'json',
												url: techt_ajax_url,
												data: facebook_fetch_data,
												success: function(data) {
													if (data.loggedin === true || data.registered === true) {
														//$scope.find( '.status' ).addClass( 'success' ).text( 'Thanks for logging in, ' + res.name + '!' );
														if ('<?php echo $settings['redirect_url_social']['url'] != ''; ?>') {
															window.location = '<?php echo $settings['redirect_url_social']['url']; ?>';
														} else {
															location.reload();
														}
													}
												}
											});
										}
									});

								}
							</script>
							<?php
							if (!empty($settings['ox_sl_layout_opt']) && $settings['ox_sl_layout_opt'] == 'ox_sl_layout_opt_2') { ?>
								<div class="fb-login-button" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width="" data-height="200px" onlogin="checkloginstatus('<?php echo $type; ?>');"></div>
							<?php } else { ?>
								<fb:login-button scope="public_profile,email" onlogin="checkloginstatus('<?php echo $type; ?>');"></fb:login-button>
							<?php } ?>
							<div id="status"></div>
						    <?php
						}
						/*facebook login end*/

						/*google login start*/
						if ((!empty($settings['ox_sl_google']) && $settings['ox_sl_google'] == 'yes') && !is_user_logged_in()) {
							$check_g_appid = get_option('techt_api_connection_data');
							$google_clint_id = (!empty($check_g_appid['techt_google_client_id'])) ? $check_g_appid['techt_google_client_id'] : '';
							$nonce = wp_create_nonce('ajax-login-nonce');

							if ($type == 'login') {
								$action = 'techt_google_ajax_register';
								$form_id = 'ox-user-login' . esc_attr($id);
							} else if ($type == 'register') {
								$action = 'techt_google_ajax_register';
								$form_id = 'ox-user-register' . esc_attr($id);
							}

							$ox_sl_layout_opt = $settings['ox_sl_layout_opt'];
							$ox_sl_google_theme = $settings['ox_sl_google_theme'];
							$ox_sl_google_longtitle = $settings['ox_sl_google_longtitle'];


						    ?>
							<script src="https://apis.google.com/js/platform.js?onload=init"></script>
							<script>
								var redirect_page = "<?php echo $settings['redirect_url_social']['url']; ?>";
								var fp_loading = '<span class="loading-spinner-reg"><i class="far fa-times-circle" aria-hidden="true"></i></span>';
								gapi.load('auth2', function() {
									gapi.signin2.render('g-signin2-<?php echo esc_attr($gid); ?>', {
										'scope': 'profile email',
										'longtitle': '<?php echo $ox_sl_google_longtitle; ?>',
										'theme': '<?php echo $ox_sl_google_theme; ?>',
										'height': 40,
									});
									auth2 = gapi.auth2.init({
										client_id: '<?php echo $google_clint_id; ?>',
										cookiepolicy: 'single_host_origin',
									});
									auth2.attachClickHandler('g-signin2-<?php echo esc_attr($gid); ?>', {},

										function(googleUser) {
											var profile = googleUser.getBasicProfile();
											var name = profile.getName();
											var email = profile.getEmail();
											var id_token = googleUser.getAuthResponse().id_token;

											var google_data = {
												'nonce': "<?php echo $nonce; ?>",
												'action': "<?php echo $action; ?>",
												'name': name,
												'email': email,
												'id_token': id_token,
												'widget_id': "<?php echo $widget_id; ?>",
												'page_id': "<?php echo $page_id; ?>",
											};

											jQuery.ajax({
												url: techt_ajax_url,
												method: 'post',
												data: google_data,
												dataType: 'json',

												success: function(data) {
													if (data.loggedin === true) {
														if (redirect_page != '') {
															window.location = redirect_page;
														} else {
															location.reload();
														}
													} else if (data.loggedin === false) {
														jQuery("#<?php echo esc_attr($form_id); ?> .techt-notification").addClass("active");
														jQuery("#<?php echo esc_attr($form_id); ?> .techt-notification .ox-lr-response").html(fp_loading + data.message);
													}
												},
												complete: function() {
													setTimeout(function() {
														jQuery("#<?php echo esc_attr($form_id); ?> .techt-notification").removeClass("active");
													}, 3200);
												}
											});

										},
										function(error) {
											console.log(JSON.stringify(error, undefined, 2));
										}
									);

								});
							</script>
							<div class="g-signin2-<?php echo esc_attr($gid); ?>" id="g-signin2-<?php echo esc_attr($gid); ?>" data-width="300" data-height="200" data-longtitle="true" data-onsuccess="onSignIn"></div>
					        <?php
						}
						/*google login end*/
						echo '</div>';
					}
				}
				/*social login end*/

				/*Forgot Password Ajax*/
				public function user_forgot_pass_ajax_script()
				{

					$settings = $this->get_settings();
					$id       = 'lr' . $this->get_id();

					if (!empty($settings['reset_pass_url'])) {
						$reset_page_url = get_permalink($settings['reset_pass_url']);
						$forgot_page_url = get_the_permalink();
					} else {
						$reset_page_url = get_the_permalink();
						$forgot_page_url = get_the_permalink();
					}
					?>
					<script type="text/javascript">
						jQuery(document).ready(function($) {

							var forgot_pass_form = 'form#ox-user-lost-password<?php echo esc_attr($id); ?>';
							var fp_loading_text = '<span class="loading-spinner-fp"><i class="fas fa-spinner fa-pulse fa-3x fa-fw"></i></span><?php echo esc_html($settings["fp_msg_loading"]); ?>';
							var fp_loading = '<span class="loading-spinner-reg"><i class="far fa-times-circle" aria-hidden="true"></i></span>';
							var fp_correct_email = '<span class="loading-spinner-reg"><i class="far fa-envelope" aria-hidden="true"></i></span><?php echo esc_html($settings["fp_msg_success"]); ?>';
							var fp_err_msg = '<span class="loading-spinner-reg"><i class="far fa-envelope" aria-hidden="true"></i></span><?php echo esc_html($settings["fp_msg_error"]); ?>';

							$(forgot_pass_form).on('submit', function(e) {
								$.ajax({
									type: 'POST',
									dataType: 'json',
									url: techt_ajax_url,
									data: {
										'action': 'techt_ajax_forgot_password',
										'user_login': $(forgot_pass_form + ' #user_login<?php echo esc_attr($id); ?>').val(),
										'f_p_opt': $(forgot_pass_form).data('f_p_opt'),
										'resetpageurl': '<?php echo $reset_page_url; ?>',
										'forgotpageurl': '<?php echo $forgot_page_url; ?>',
										'tceol': $(forgot_pass_form).data('tceol'),
										'nonce': $(forgot_pass_form + ' #ox_user_lost_password_nonce').val()
									},
									beforeSend: function() {
										$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
										$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(fp_loading_text);
									},
									success: function(data) {

										if (data.message) {
											$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
											$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(fp_loading + data.message);
										} else {
											$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification").addClass("active");
											$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification .ox-lr-response").html(fp_loading + 'Is Not Working Server Issue...');
										}
									},
									complete: function() {
										setTimeout(function() {
											$("#ox-user-lost-password<?php echo esc_attr($id); ?> .techt-notification").removeClass("active");
										}, 3200);
									}
								});
								e.preventDefault();

							});

						});
					</script>
			        <?php
		        }
}

Plugin::instance()->widgets_manager->register(new Techt_Login_Register());
