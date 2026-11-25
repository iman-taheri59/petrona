<?php
/**
 * Service Pricing heading template
 */

$settings      = $this->get_settings_for_display();
$icon_position = ! empty( $settings['icon_position'] ) ? $settings['icon_position'] : 'inside';
$title_tag     = isset( $settings['title_html_tag'] ) ? $settings['title_html_tag'] : 'h2';
$subtitle_tag  = isset( $settings['subtitle_html_tag'] ) ? $settings['subtitle_html_tag'] : 'h4';

?>
<div class="service-pricing__heading">
	<?php if ( 'inside' === $icon_position ) {
		$this->_icon( 'icon', '<div class="service-pricing__icon"><div class="service-pricing__icon-box"><span class="techt-icon">%s</span></div></div>' );
	} ?>
	<?php $this->_html( 'title', '<' . $title_tag . ' class="service-pricing__title">%s</' . $title_tag . '>' ); ?>
	<?php $this->_html( 'subtitle', '<' . $subtitle_tag . ' class="service-pricing__subtitle">%s</' . $subtitle_tag . '>' ); ?>
</div>