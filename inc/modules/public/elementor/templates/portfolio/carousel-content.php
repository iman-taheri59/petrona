<?php 
	$this->add_render_attribute( 'wrapper', 'class', 'techt-portfolio-wrapper' );
	$swiper_class = $this->_swiper_container_class();
	$this->add_render_attribute( 'portfolio-feed-container', 'class', [
	    $swiper_class,
	    'swiper-container-' . esc_attr( $this->get_id() )
	] );

	$this->add_render_attribute( 'item-feed', [
	    'id'        => 'portfolio-feed-' . esc_attr( $this->get_id() ),
	    'class'     => 'portfolio-feed-grid'
	] );

	if ( $settings['dots_position'] ) {
	    $this->add_render_attribute( 'portfolio-feed-container', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position'] );
	}
	$this->add_render_attribute( 'item-feed', 'class', 'swiper-wrapper' );
	$this->slider_settings();

?>
<div class="section section-portfolio">
	<div class="portfolio-boxes">	
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'portfolio-feed-container' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'item-feed' ); ?>>
					<?php
					while ($portfolio_query->have_posts()) : $portfolio_query->the_post(); 
					if ( has_post_thumbnail() ) { ?>
					<div class="portfolio-carousel-item swiper-slide">
						<?php
							$post_status = Techt_Utility::meta_options('portfolio_sources'); 
							if ($post_status  == 'image') {
								$icon_code = 'techt-icon-image';
							} elseif ($post_status  == 'video') {
								$icon_code = 'techt-icon-control-play';
							} elseif ($post_status  == 'audio') {
								$icon_code = 'techt-icon-music-alt';
							} elseif ($post_status  == 'gallery') {
								$icon_code = 'techt-icon-gallery';
							} elseif ($post_status  == 'links') {
								$icon_code = 'techt-icon-link';
							} else {
								$icon_code = 'techt-icon-new-window';
							}

							if ($post_status  == 'links') {
								$item_url = Techt_Utility::meta_options('custom_urls');
								$target = (Techt_Utility::meta_options('open_links') ? 'target="' . Techt_Utility::meta_options('open_links') . '" ' : '');
								$nofollow = (Techt_Utility::meta_options('nofollow_links') ? ' rel="' . Techt_Utility::meta_options('nofollow_links') . '" ' : '');
								$popup_class = 'custom-url';
							} elseif ($post_status  == 'video') {
								$item_url = Techt_Utility::meta_options('video_url');
								$target = '';
								$nofollow = (Techt_Utility::meta_options('nofollow_links') ? ' rel="' . Techt_Utility::meta_options('nofollow_links') . '" ' : '');
								$popup_class = 'techt-js-video-popup';
							} elseif ($post_status  == 'audio') {
								$item_url = Techt_Utility::meta_options('audio_embed_code');
								$target = '';
								$nofollow = (Techt_Utility::meta_options('nofollow_links') ? ' rel="' . Techt_Utility::meta_options('nofollow_links') . '" ' : '');
								$popup_class = 'techt-js-video-popup';
							} elseif ($post_status  == 'image') {
								$item_url = get_the_post_thumbnail_url(get_the_ID(), 'full');;
								$target = '';
								$popup_class = 'techt-js-popup';
							} elseif ($post_status  == 'gallery') {
								$item_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
								$target = '';
								$popup_class = 'techt-js-gallery-popup';
							} else {
								$item_url = get_the_permalink();
								$target = '';
								$popup_class = 'single-url';
							}
						?>
						<a class="<?php echo esc_attr( $popup_class ); ?>" href="<?php echo ( $item_url ); ?>" <?php echo ($target . $nofollow)?>>
							<div class="portfolio-box">
			    	            <?php 
				            	if( !empty( $settings['custom_img_dimension']['width'] ) || !empty($settings['custom_img_dimension']['height']) ) {
				            		$width = $settings['custom_img_dimension']['width'];
				            		$height = $settings['custom_img_dimension']['height'];
				            		Techt_Utility::featured_image($width, $height, true, false);
				            	} else {
				            		Techt_Utility::featured_image(650, 450, true, false);
				            	} ?>
				            	
								<?php $this->get_overlay_contents( $settings ); ?>  

					    		<?php if( $settings['show_icons'] == 'yes' && !empty($icon_code) ) { ?>
									<div class="icon">
										<i class="<?php echo esc_attr( $icon_code ); ?>"></i>
									</div><!--  /.icon -->
					    		<?php } ?>
							</div><!--  /.portfolio-box -->
						</a>
						<?php if( $post_status  == 'gallery' ) { ?>
						<div class="portfolio-gallery-content">
							<a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"></a>
							<?php foreach ( Techt_Utility::meta_options('portfolio_gallery_images') as $key => $value) { ?>
								<?php if( $key !== 0 ) { ?>
									<a href="<?php echo esc_url( wp_get_attachment_url( $value ,'full' ) ); ?>"></a>
								<?php } ?>
							<?php } ?>    
						</div><!--  /.portfolio-gallery-content -->
						<?php } ?>
					</div>
					<?php } ?>
				    <?php endwhile; ?> <?php wp_reset_postdata(); ?>
				</div>
				<?php $this->render_dots(); ?>
			</div>
			<?php $this->render_arrows(); ?>
		</div>
	</div><!--  /.portfolio-boxes -->
</div>