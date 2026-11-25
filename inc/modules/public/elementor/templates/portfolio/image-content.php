<div class="section section-portfolio">
	<!-- Filter Content -->
	<?php if ($settings['show_filter'] == 'yes') { ?>
		<ul class="portfolio-filters">
			<li><a id="all" href="#" data-filter="*" class="techt-filter active"><?php esc_html_e('ALL', 'petrona') ?><?php if ($settings['show_filter_count'] == 'yes') { ?><span><?php echo esc_html($portfolio_query->post_count); ?></span><?php } ?></a></li>
			<?php foreach ($terms as $term) { ?>
				<li><a href="#" data-filter=".<?php echo esc_attr($term->term_id); ?>" class="techt-filter"><?php echo esc_html($term->name); ?><?php if ($settings['show_filter_count'] == 'yes') { ?><span>0</span><?php } ?></a></li>
			<?php }  ?>
		</ul>
	<?php } ?>

	<div class="portfolio-boxes">
		<div class="portfolio-grid portfolio-grid-<?php echo esc_attr($this->get_id()); ?>">
			<?php
			$no = 0;
			while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
				if (has_post_thumbnail()) { 
					$feature_portfolio = $no == 0 && $settings['show_feature'] == 'yes' ? ' feature' : '';
					?>
					<div class="<?php echo esc_attr($grid_no) . $feature_portfolio; ?> item <?php $portfilio_cats = get_the_terms(get_the_ID(), 'portfolio-category');
						$nofollow = '';
						if (get_the_terms(get_the_ID(), 'portfolio-category')) {
							foreach ($portfilio_cats as $cat_name) {
								echo esc_attr($cat_name->term_id) . ' ';
							}
						} ?>">
						<div class="portfolio-main-content" data-animate="hg-zoomIn">
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
							<a class="<?php echo esc_attr($popup_class); ?>" href="<?php echo ($item_url); ?>" <?php echo ($target . $nofollow)?>>
								<div class="portfolio-box techt-shutter-effect petrona-line-effect">
									<?php
									if (!empty($settings['custom_img_dimension']['width']) || !empty($settings['custom_img_dimension']['height'])) {
										$width = $settings['custom_img_dimension']['width'];
										$height = $settings['custom_img_dimension']['height'];
										Techt_Utility::featured_image($width, $height, true, false);
										if($settings['show_feature'] == 'yes'){
											if($no == 0){
												if (!empty($settings['feature_img_dimension']['width']) || !empty($settings['feature_img_dimension']['height'])) {
													$width = $settings['feature_img_dimension']['width'];
													$height = $settings['feature_img_dimension']['height'];
													Techt_Utility::featured_image($width, $height, true, false);
												}
											}else{
												Techt_Utility::featured_image($width, $height, true, false);
											}
										}
										
									} else {
										if($settings['masonry_layout']=="justify"){

											if($settings['show_feature'] == 'yes'){
												if($no == 0){
													if (!empty($settings['feature_img_dimension']['width']) || !empty($settings['feature_img_dimension']['height'])) {
														$width = $settings['feature_img_dimension']['width'];
														$height = $settings['feature_img_dimension']['height'];
														Techt_Utility::featured_image($width, $height, true, false);
													}else{
														the_post_thumbnail();
													}
												}else{
													Techt_Utility::featured_image(450, 280, true, false);
												}
											}else{
												Techt_Utility::featured_image(450, 280, true, false);
											}
											
										} else {
											the_post_thumbnail();
										}
										
									} ?>

									<?php $this->get_overlay_contents($settings); ?>

									<?php if ($settings['show_icons'] == 'yes' && !empty($icon_code)) { ?>
										<div class="icon">
											<i class="<?php echo esc_attr($icon_code); ?>"></i>
										</div><!--  /.icon -->
									<?php } ?>
								</div><!--  /.portfolio-box -->
							</a>
							<?php if ($post_status  == 'gallery') { ?>
								<div class="portfolio-gallery-content">
									<a href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"></a>
									<?php foreach (Techt_Utility::meta_options('portfolio_gallery_images') as $key => $value) { ?>
										<?php if ($key !== 0) { ?>
											<a href="<?php echo esc_url(wp_get_attachment_url($value, 'full')); ?>"></a>
										<?php } ?>
									<?php } ?>
								</div><!--  /.portfolio-gallery-content -->
							<?php } ?>
						</div><!--  /.portfolio-main-content -->
					</div><!-- /.col-lg-4 -->
				<?php $no++;
				} ?>
			<?php endwhile; ?> <?php wp_reset_postdata(); ?>
		</div>
	</div><!--  /.portfolio-boxes -->
</div>