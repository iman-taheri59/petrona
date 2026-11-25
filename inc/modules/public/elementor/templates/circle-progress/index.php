<?php
/**
 * Circle progress template
 */
$perc_position   = $this->get_settings_for_display( 'percent_position' );
$labels_position = $this->get_settings_for_display( 'labels_position' );

$this->add_render_attribute( 'circle-wrap', array(
	'class'         => 'techt-circle-progress-wrap',
	'data-duration' => $this->get_settings_for_display( 'duration' ),
) );

$this->add_render_attribute( 'circle-bar', array(
	'class' => 'techt-circle-progress-bar',
) );

?>
<div <?php echo $this->get_render_attribute_string( 'circle-wrap' ); ?>>
	<div <?php echo $this->get_render_attribute_string( 'circle-bar' ); ?>>
	<?php
		require $this->get_widget_template('circle');
		if ( 'in-circle' === $perc_position || 'in-circle' === $labels_position ) {
			echo '<div class="position-in-circle">';
			$this->_processed_item = 'in-circle';
			require $this->get_widget_template('counter');
			echo '</div>';
		}
	?>
	</div>
	<?php
		if ( 'out-circle' === $perc_position || 'out-circle' === $labels_position ) {
			echo '<div class="position-below-circle">';
			$this->_processed_item = 'out-circle';
			require $this->get_widget_template('counter');
			echo '</div>';
		}

		$this->_processed_item = false;
	?>
</div>