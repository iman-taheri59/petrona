<?php
/**
 * Slider template
 */
// $this->add_render_attribute('wrapper', 'class', 'techt-slider');


$settings = $this->get_settings_for_display();
$data_settings = $this->generate_setting_json();

$classes_list[] = 'techt-slider-wrapper';
$classes = implode( ' ', $classes_list );
?>

<div class="<?php echo $classes; ?>" <?php echo $data_settings; ?>>
	<?php $this->get_looped_template( 'slider', 'item_list' ); ?>
	<?php
		// if($settings['skin_mode'] == 'slide_show'){
		// 	$this->get_looped_template( 'slider-thumbs', 'item_list' );
		// }
	?>
</div>
