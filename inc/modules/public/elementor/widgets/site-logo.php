<?php
namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Techt_Site_Logo extends Techt_Base {

	public function get_name() {
		return 'techt-site-logo';
	}

	public function get_title() {
		return esc_html__( 'Site Logo', 'petrona' );
	}

	public function get_icon() {
		return 'eicon-site-logo';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'petrona' ),
			)
		);

		$this->add_control(
			'logo_type',
			array(
				'type'    => 'select',
				'label'   => esc_html__( 'Logo Type', 'petrona' ),
				'default' => 'text',
				'options' => array(
					'text'  => esc_html__( 'Text', 'petrona' ),
					'image' => esc_html__( 'Image', 'petrona' ),
					'both'  => esc_html__( 'Both Text and Image', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'logo_image_from',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Logo Image From', 'petrona' ),
				'default'    => 'theme_options',
				'options'    => array(
					'theme_options' => esc_html__( 'Theme Options', 'petrona' ),
					'custom'    => esc_html__( 'Custom', 'petrona' ),
				),
				'condition' => array(
					'logo_type!' => 'text',
				),
			)
		);

		$this->add_control(
			'logo_image',
			array(
				'label'     => esc_html__( 'Logo Image', 'petrona' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'logo_type!' => 'text',
					'logo_image_from' => 'custom',
				),
			)
		);

		$this->add_control(
			'retina_logo_from',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Retina Logo From', 'petrona' ),
				'default'    => 'theme_options',
				'options'    => array(
					'theme_options' => esc_html__( 'Theme Options', 'petrona' ),
					'custom'    => esc_html__( 'Custom', 'petrona' ),
				),
				'condition' => array(
					'logo_type!' => 'text',
				),
			)
		);

		$this->add_control(
			'logo_image_retina',
			array(
				'label'     => esc_html__( 'Retina Logo Image', 'petrona' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'logo_type!' => 'text',
					'retina_logo_from' => 'custom',
				),
			)
		);

		$this->add_control(
			'logo_text_from',
			array(
				'type'       => 'select',
				'label'      => esc_html__( 'Logo Text From', 'petrona' ),
				'default'    => 'site_name',
				'options'    => array(
					'site_name' => esc_html__( 'Site Name', 'petrona' ),
					'custom'    => esc_html__( 'Custom', 'petrona' ),
				),
				'condition' => array(
					'logo_type!' => 'image',
				),
			)
		);

		$this->add_control(
			'logo_text',
			array(
				'label'     => esc_html__( 'Custom Logo Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'logo_text_from' => 'custom',
					'logo_type!'     => 'image',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'petrona' ),
			)
		);

		$this->add_control(
			'linked_logo',
			array(
				'label'        => esc_html__( 'Linked Logo', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'remove_link_on_front',
			array(
				'label'        => esc_html__( 'Remove Link on Front Page', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'logo_display',
			array(
				'type'        => 'select',
				'label'       => esc_html__( 'Display Logo Image and Text', 'petrona' ),
				'label_block' => true,
				'default'     => 'block',
				'options'     => array(
					'inline' => esc_html__( 'Inline', 'petrona' ),
					'block'  => esc_html__( 'Text Below Image', 'petrona' ),
				),
				'condition' => array(
					'logo_type' => 'both',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'logo_style',
			array(
				'label'      => esc_html__( 'Logo', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'logo_alignment',
			array(
				'label'   => esc_html__( 'Logo Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Start', 'petrona' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'End', 'petrona' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-logo' => 'justify-content: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'vertical_logo_alignment',
			array(
				'label'       => esc_html__( 'Image and Text Vertical Alignment', 'petrona' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'center',
				'label_block' => true,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'petrona' ),
						'icon' => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Middle', 'petrona' ),
						'icon' => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'petrona' ),
						'icon' => 'eicon-v-align-bottom',
					),
					'baseline' => array(
						'title' => esc_html__( 'Baseline', 'petrona' ),
						'icon' => 'eicon-v-align-bottom',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-logo__link' => 'align-items: {{VALUE}}',
				),
				'condition' => array(
					'logo_type'    => 'both',
					'logo_display' => 'inline',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_logo_style',
			array(
				'label'      => esc_html__( 'Text', 'petrona' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'text_logo_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'global' => [
					'default' => Global_Colors::COLOR_ACCENT,
				],
				'selectors' => array(
					'{{WRAPPER}} .techt-logo__text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_logo_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .techt-logo__text',
			)
		);

		$this->add_control(
			'text_logo_gap',
			array(
				'label'      => esc_html__( 'Gap', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 5,
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .techt-logo-display-block .techt-logo__img'  => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .techt-logo-display-inline .techt-logo__img' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'logo_type' => 'both',
				),
			)
		);

		$this->add_responsive_control(
			'text_logo_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'petrona' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .techt-logo__text' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'logo_type'    => 'both',
					'logo_display' => 'block',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->_context = 'render';

		$this->_open_wrap();
		require $this->get_widget_template('index');
		$this->_close_wrap();
	}

	/**
	 * Check if logo is linked
	 * @return [type] [description]
	 */
	public function _is_linked() {

		$settings = $this->get_settings();

		if ( empty( $settings['linked_logo'] ) ) {
			return false;
		}

		if ( 'true' === $settings['remove_link_on_front'] && is_front_page() ) {
			return false;
		}

		return true;

	}

	/**
	 * Returns logo text
	 *
	 * @return string Text logo HTML markup.
	 */
	public function _get_logo_text() {

		$settings    = $this->get_settings();
		$type        = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
		$text_from   = isset( $settings['logo_text_from'] ) ? esc_attr( $settings['logo_text_from'] ) : 'site_name';
		$custom_text = isset( $settings['logo_text'] ) ? wp_kses_post( $settings['logo_text'] ) : '';

		if ( 'image' === $type ) {
			return;
		}

		if ( 'site_name' === $text_from ) {
			$text = get_bloginfo( 'name' );
		} else {
			$text = $custom_text;
		}

		$format = apply_filters(
			'techt-elements/widgets/logo/text-foramt',
			'<div class="techt-logo__text">%s</div>'
		);

		return sprintf( $format, $text );
	}

	/**
	 * Returns logo classes string
	 *
	 * @return string
	 */
	public function _get_logo_classes() {

		$settings = $this->get_settings();

		$classes = array(
			'techt-logo',
			'techt-logo-type-' . $settings['logo_type'],
			'techt-logo-display-' . $settings['logo_display'],
		);

		return implode( ' ', $classes );
	}

	/**
	 * Returns logo image
	 *
	 * @return string Image logo HTML markup.
	 */
	public function _get_logo_image() {

		$settings = $this->get_settings();
		$type     = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
		$logo_from   = isset( $settings['logo_image_from'] ) ? esc_attr( $settings['logo_image_from'] ) : 'theme_options';
		$retina_logo_from   = isset( $settings['retina_logo_from'] ) ? esc_attr( $settings['retina_logo_from'] ) : 'theme_options';
		$custom_image    = isset( $settings['logo_image'] ) ? $settings['logo_image'] : false;
		$custom_image_retina = isset( $settings['logo_image_retina'] ) ? $settings['logo_image_retina'] : false;
		$image_retina = [];
		if ( 'text' === $type ) {
			return;
		}
		$image = [];
		if ( 'theme_options' === $logo_from ) {
			
			$logo_id = get_theme_mod( 'custom_logo' );
			$logo_url = wp_get_attachment_url($logo_id);
			$image = ['id' => $logo_id, 'url' => $logo_url];
		} else {
			$image = $custom_image;
		}

		if ( 'custom' === $retina_logo_from ) {
			$image_retina = $custom_image_retina;
		}

		$image_src    = $this->_get_logo_image_src( $image );
		$image_retina_src = $this->_get_logo_image_src( $image_retina );

		if ( empty( $image_src ) && empty( $image_retina_src ) ) {
			return;
		}

		$format = apply_filters(
			'techt-elements/widgets/logo/image-format',
			'<img loading="lazy" src="%1$s" class="techt-logo__img" alt="%2$s"%3$s>'
		);

		$image_data = ! empty( $image['id'] ) ? wp_get_attachment_image_src( $image['id'], 'full' ) : array();
		$width      = isset( $image_data[1] ) ? $image_data[1] : false;
		$height     = isset( $image_data[2] ) ? $image_data[2] : false;

		$attrs = sprintf(
			'%1$s%2$s%3$s',
			$width ? ' width="' . $width . '"' : '',
			$height ? ' height="' . $height . '"' : '',
			( ! empty( $image_retina_src ) ? ' srcset="' . esc_url( $image_retina_src ) . ' 2x"' : '' )
		);

		return sprintf( $format, esc_url( $image_src ), get_bloginfo( 'name' ), $attrs );
	}

	public function _get_logo_image_src( $args = array() ) {

		if ( ! empty( $args['id'] ) ) {
			$img_data = wp_get_attachment_image_src( $args['id'], 'full' );

			return ! empty( $img_data[0] ) ? $img_data[0] : false;
		}

		if ( ! empty( $args['url'] ) ) {
			return $args['url'];
		}

		return false;
	}

}
Plugin::instance()->widgets_manager->register( new Techt_Site_Logo() );