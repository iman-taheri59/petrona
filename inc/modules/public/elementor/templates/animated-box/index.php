<?php
/**
 * Loop item template
 */

$widget_id     = $this->get_id();
$settings      = $this->get_settings();
$title_tag     = $this->_get_html( 'title_html_tag', '%s' );
$sub_title_tag = $this->_get_html( 'sub_title_html_tag', '%s' );

$animation_class = $settings['animation_effect'];

?><div id="techt-animated-box-<?php echo $widget_id; ?>" class="techt-animated-box <?php echo $animation_class; ?>" <?php echo $this->generate_setting_json(); ?>>
	<div id="techt-animated-box__front-<?php echo $widget_id; ?>" class="techt-animated-box__front">
		<div class="techt-animated-box__inner"><?php
			$this->_icon( 'front_side_icon', '<div class="techt-animated-box__icon techt-animated-box__icon--front"><div class="techt-animated-box-icon-inner"><span class="techt-icon">%s</span></div></div>');
			?><div class="techt-animated-box__content"><?php
				$this->_html( 'front_side_title', '<' . $title_tag . ' class="techt-animated-box__title techt-animated-box__title--front">%s</' . $title_tag . '>' );
				$this->_html( 'front_side_subtitle', '<' . $sub_title_tag . ' class="techt-animated-box__subtitle techt-animated-box__subtitle--front">%s</' . $sub_title_tag . '>' );
				$this->_html( 'front_side_description', '<p class="techt-animated-box__description techt-animated-box__description--front">%s</p>' );
			?></div><?php
			
		?></div>
		<div class="techt-animated-box__overlay"></div><?php

		if( 'toggle' === $settings['switch_event_type'] ) {
			?><div class="techt-animated-box__toggle techt-animated-box__toggle--front"><?php
				$this->_icon( 'front_side_toggle_icon', '<div class="techt-animated-box__toggle-icon"><span class="techt-icon">%s</span></div>' );
			?></div><?php
		}
	?></div>
	<div id="techt-animated-box__back-<?php echo $widget_id; ?>" class="techt-animated-box__back">
		<div class="techt-animated-box__inner"><?php
			$this->_icon( 'back_side_icon', '<div class="techt-animated-box__icon techt-animated-box__icon--back"><div class="techt-animated-box-icon-inner"><span class="techt-icon">%s</span></div></div>' );
			?><div class="techt-animated-box__content"><?php
				$this->_html( 'back_side_title', '<' . $title_tag . ' class="techt-animated-box__title techt-animated-box__title--back">%s</' . $title_tag . '>' );
				$this->_html( 'back_side_subtitle', '<' . $sub_title_tag . ' class="techt-animated-box__subtitle techt-animated-box__subtitle--back">%s</' . $sub_title_tag . '>' );
				$this->_html( 'back_side_description', '<p class="techt-animated-box__description techt-animated-box__description--back">%s</p>' );
				$this->_glob_inc_if( 'action-button', array( 'back_side_button_link', 'back_side_button_text' ) );
			?></div><?php
		?></div>
		<div class="techt-animated-box__overlay"></div><?php

		if( 'toggle' === $settings['switch_event_type'] ) {
			?><div class="techt-animated-box__toggle techt-animated-box__toggle--back"><?php
				$this->_icon( 'back_side_toggle_icon', '<div class="techt-animated-box__toggle-icon"><span class="techt-icon">%s</span></div>' );
			?></div><?php
		}
	?></div>
</div>
