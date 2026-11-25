<?php
/**
 * Main template
 */
$settings = $this->get_settings();
?>
<div class="techt-search"><?php
	if ( 'true' === $settings['show_search_in_popup'] ) {
		require $this->get_widget_template( 'popup' );
	} else {
		require $this->get_widget_template( 'form' );
	}
?></div>