<?php
	$settings = $this->get_settings_for_display();
	$position = isset( $settings['download_icon_position'] ) ? $settings['download_icon_position'] : 'right';
	$rel      = $this->_get_html( 'download_link_rel', ' rel="%s"' );

?><a class="elementor-button elementor-size-md techt-download techt-download-icon-position-<?php echo $position; ?>" href="<?php echo techt_download_handler()->get_download_link( $settings['download_file'] ); ?>" <?php echo $rel; ?>><?php

	$icon_format = '<span class="techt-download__icon techt-download-icon-' . $position . ' techt-element-icon">%s</span>';

	$this->_icon( 'download_icon', $icon_format );

	$label    = $this->_get_html( 'download_label' );
	$sublabel = $this->_get_html( 'download_sub_label' );

	if ( $label || $sublabel ) {

		echo '<span class="techt-download__text">';

		printf(
			'<span class="techt-download__label">%s</span>',
			$this->_format_label( $label, $settings['download_file'] )
		);

		printf(
			'<small class="techt-download__sub-label">%s</small>',
			$this->_format_label( $sublabel, $settings['download_file'] )
		);

		echo '</span>';
	}

?></a>
