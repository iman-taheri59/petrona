<?php
/**
 * Slide item template
 */
$settings      = $this->get_settings_for_display();
$item_settings = $this->_processed_item;

$container_width = $settings['slider_container_width']['size'];
$container_width = ( '%' === $settings['slider_container_width']['unit'] ) ? $container_width . $settings['slider_container_width']['unit'] : $container_width;

$content_type = ! empty( $item_settings['item_content_type'] ) ? $item_settings['item_content_type'] : 'default';

$show_transition = ! empty( $settings['content_show_transition'] ) ? $settings['content_show_transition'] : 'up';
$item_techt_effect = $item_settings['item_effect_type'] !== 'none' ?  $this->_render_loop_item( array( 'item_effect_type' ), ' data-fx="%s"' ) : '';

$desc_animation = $this->_render_loop_item( array( 'item_desc_animation' ), ' data-animation="%s"' );
$button_animation = $this->_render_loop_item( array( 'item_button_animation' ), ' data-animation="%s"' );
$target_primary   = $this->_render_loop_item( array( 'item_button_primary_target' ), ' target="%s"' );
$rel_primary      = $this->_render_loop_item( array( 'item_button_primary_rel' ), ' rel="%s"' );
$target_secondary = $this->_render_loop_item( array( 'item_button_secondary_target' ), ' target="%s"' );
$rel_secondary    = $this->_render_loop_item( array( 'item_button_secondary_rel' ), ' rel="%s"' );
$title_tag        = $this->_render_loop_item( array( 'item_title_html_tag' ), '%s' );
$title_tag        = $this->validate_html_tag( $title_tag );
$subtitle_tag     = $this->_render_loop_item( array( 'item_subtitle_html_tag' ), '%s' );
$subtitle_tag     = $this->validate_html_tag( $subtitle_tag );
$title_tag        = ! empty( $title_tag ) ? $title_tag : 'h1';
$title_animation  =  $this->_render_loop_item( array( 'item_title_animation' ), ' data-animation="%s"' );
$subtitle_tag     = ! empty( $subtitle_tag ) ? $subtitle_tag : 'h3';
$subtitle_animation  =  $this->_render_loop_item( array( 'item_subtitle_animation' ), ' data-animation="%s"' );
$title_format     = '<' . $title_tag . ' class="techt-slider__title"'.$title_animation.'>%s</' . $title_tag . '>';
$subtitle_format  = '<' . $subtitle_tag . ' class="techt-slider__subtitle"'.$subtitle_animation.'>%s</' . $subtitle_tag . '>';
$slide_id         = ! empty( $item_settings['slide_id'] ) ? 'id="' . $item_settings['slide_id'] . '"' : '';

$item_horizental_position_class = '';
$item_vertical_position_class = '';
$item_image_url = $item_settings['item_image']['url'];
$item_thumb_url = wp_get_attachment_image_src($item_settings['item_image']['id'], 'thumbnail')[0];
?><div <?php echo $slide_id; ?> class="elementor-repeater-item-<?php echo $item_settings['_id'] . $item_horizental_position_class . $item_vertical_position_class ?> techt-slider__item" <?php echo $item_techt_effect; ?> data-thumb="<?php echo $item_thumb_url; ?>" data-src="<?php echo $item_image_url; ?>"><?php
	// echo $this->_loop_item_bg_tag();
		
	?><div class="techt-slider__content slider-layer tecSlider_caption elementor-repeater-item-<?php echo $item_settings['_id']; ?>">
		<div class="tecSlider-slide-inner d-flex">
			<div class="tecSlider-slide-contents"><?php
				echo $this->_render_loop_item( array( 'item_title' ), $title_format );
				echo $this->_render_loop_item( array( 'item_subtitle' ), $subtitle_format );
				echo $this->_render_loop_item( array( 'item_desc' ), '<div class="techt-slider__desc"'.$desc_animation.'>%s</div>' );?>
				<div class="techt-slider__button-wrapper" <?php echo $button_animation ?>><?php
					echo $this->_loop_button_item( array( 'item_button_primary_url', 'item_button_primary_text' ), '<a class="elementor-size-md techt-slider__button techt-slider__button--primary" href="%1$s"' . $target_primary . $rel_primary . '>%2$s</a>' );
					echo $this->_loop_button_item( array( 'item_button_secondary_url', 'item_button_secondary_text' ), '<a class="elementor-size-md techt-slider__button techt-slider__button--secondary" href="%1$s"' . $target_secondary . $rel_secondary . '>%2$s</a>' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>

