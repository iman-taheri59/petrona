<?php

namespace Elementor;

use Elementor\Includes\Widgets\Traits\Button_Trait;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Advance Heading Widget.
 *
 *
 * @since 1.0
 */
class Techt_Advance_Button_Widget extends Widget_Button
{
	use Button_Trait;
    public function get_name()
	{
		return 'petrona-advance-button';
	}

	public function get_title()
	{
		return esc_html__('Advance Button', 'petrona');
	}

	public function get_icon()
	{
		return 'eicon-button';
	}

	public function get_categories()
	{
		return ['techt-category'];
	}

    /**
	 * Render widget output on the frontend.
	 *
	 * @since 1.0
	 */
	protected function render()
	{
		if ( empty( $instance ) ) {
			$instance = $this;
		}

		$settings = $instance->get_settings_for_display();

		$instance->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$instance->add_link_attributes( 'button', $settings['link'] );
			$instance->add_render_attribute( 'button', 'class', 'elementor-button-link' );
		}

		$instance->add_render_attribute( 'button', ['class'=>['elementor-button', 'techt-advance-button', 'petrona-line-effect']] );
		$instance->add_render_attribute( 'button', 'role', 'button' );
		if ( ! empty( $settings['button_css_id'] ) ) {
			$instance->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$instance->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( ! empty( $settings['hover_animation'] ) ) {
			$instance->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}
		$instance->add_render_attribute( 'button', 'role', 'button' );
		?>
		<div <?php $instance->print_render_attribute_string( 'wrapper' ); ?>>
			<a <?php $instance->print_render_attribute_string( 'button' ); ?>>
				<?php $this->render_text( $instance ); ?>
				<div class="petrona-line vertical"></div>
  				<div class="petrona-line horizontal"></div>
			</a>
		</div>
		<?php
    }
	protected function content_template() {
		?>
		<#
		view.addRenderAttribute( 'text', 'class', 'elementor-button-text' );
		view.addInlineEditingAttributes( 'text', 'none' );
		var iconHTML = elementor.helpers.renderIcon( view, settings.selected_icon, { 'aria-hidden': true }, 'i' , 'object' ),
		migrated = elementor.helpers.isIconMigrated( settings, 'selected_icon' );
		#>
		<div class="elementor-button-wrapper">
			<a id="{{ settings.button_css_id }}" class="elementor-button techt-advance-button elementor-size-{{ settings.size }} elementor-animation-{{ settings.hover_animation }}" href="{{ settings.link.url }}" role="button">
				<span class="elementor-button-content-wrapper">
					<# if ( settings.icon || settings.selected_icon ) { #>
					<span class="elementor-button-icon elementor-align-icon-{{ settings.icon_align }}">
						<# if ( ( migrated || ! settings.icon ) && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
						<# } else { #>
							<i class="{{ settings.icon }}" aria-hidden="true"></i>
						<# } #>
					</span>
					<# } #>
					<span {{{ view.getRenderAttributeString( 'text' ) }}}>{{{ settings.text }}}</span>
				</span>
				<div class="line vertical"></div>
  				<div class="line horizontal"></div>
			</a>
		</div>
		<?php
	}
	
}
Plugin::instance()->widgets_manager->register(new Techt_Advance_Button_Widget());