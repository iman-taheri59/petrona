<?php
/**
 * Circle progress counter template
 */

$perc_position   = $this->get_settings_for_display( 'percent_position' );
$labels_position = $this->get_settings_for_display( 'labels_position' );

?>
<div class="techt-circle-counter">
	<?php if ( $perc_position === $this->_processed_item ) { ?>
	<div class="circle-val"><?php
		$this->_html( 'prefix', '<span class="techt-circle-counter__prefix">%s</span>' );
		require $this->get_widget_template('counter-number');
		$this->_html( 'suffix', '<span class="techt-circle-counter__suffix">%s</span>' );
	?></div>
	<?php } ?>
	<?php if ( $labels_position === $this->_processed_item ) { ?>
	<div class="techt-circle-counter__content">
		<?php $this->_html( 'title', '<div class="techt-circle-counter__title">%s</div>' ); ?>
		<?php $this->_html( 'subtitle', '<div class="techt-circle-counter__subtitle">%s</div>' ); ?>
	</div>
	<?php } ?>
</div>