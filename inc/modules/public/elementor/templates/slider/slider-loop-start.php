<?php
/**
 * Slider start template
 */
$swiper_class = $this->_swiper_container_class();
$this->add_render_attribute('slider-container', 'class', [
	// $swiper_class,
	'tecSlider_wrap',
]);

$settings = $this->get_settings_for_display();
$this->add_render_attribute('slider-container', 'data-animation', [
	$settings['content_animation']
]);
// if($settings['content_animation']){
	// $this->add_render_attribute('slider-container', 'data-animation', [
	// 	$settings['content_animation']
	// ]);
// }


if ($settings['pagination_position']) {
	$this->add_render_attribute('slider-container', 'class', 'tecSlider-container-wrap-dots-' . $settings['pagination_position']);
}

$class_array[] = 'techt-slider__items';
// $class_array[] = 'swiper-wrapper';
// $class_array[] = 'elementor-slides';

$classes = implode( ' ', $class_array );

?>

<div <?php echo $this->get_render_attribute_string('slider-container'); ?> id="tecSlider_wrap_<?php echo $this->get_id() ?>">
