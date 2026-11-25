<?php
/**
 * Popup template
 */
$settings = $this->get_settings();

$this->add_render_attribute( 'techt-search-popup', 'class', 'techt-search__popup' );

if ( isset( $settings['full_screen_popup'] ) && 'true' === $settings['full_screen_popup'] ) {
	$this->add_render_attribute( 'techt-search-popup', 'class', 'techt-search__popup--full-screen' );
}

if ( isset( $settings['popup_show_effect'] ) ) {
	$this->add_render_attribute( 'techt-search-popup', 'class', sprintf( 'techt-search__popup--%s-effect', $settings['popup_show_effect'] ) );
}
?>
<div <?php $this->print_render_attribute_string( 'techt-search-popup' ); ?>>
	<div class="techt-search__popup-content"><?php
		require $this->get_widget_template( 'form' );
		require $this->get_widget_template( 'popup-close' );
	?></div>
</div>
<?php require $this->get_widget_template( 'popup-trigger' ); ?>