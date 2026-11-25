<?php
/**
 * Counter number template
 */
$value = 0;
$settings = $this->get_settings_for_display();
if ( 'percent' === $settings['values_type'] ) {
	$value = $settings['percent_value']['size'];
} else {
	$value  = $settings['absolute_value_curr'];
}

$this->add_render_attribute( 'techt-circle-counter', array(
	'class'         => 'techt-circle-counter__number',
	'data-to-value' => $value,
) );

if ( ! empty( $settings['thousand_separator'] ) ) {
	$this->add_render_attribute( 'techt-circle-counter', 'data-delimiter', ',' );
}
?>
<span <?php echo $this->get_render_attribute_string( 'techt-circle-counter' ); ?>>0</span>