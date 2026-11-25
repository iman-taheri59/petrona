<?php
$this->add_render_attribute('wrapper', 'class', 'techt-blog-wrapper');
$swiper_class = $this->_swiper_container_class();
$meta_location = $settings['post_meta_locatin'];
$this->add_render_attribute('blog-feed-container', 'class', [
	$swiper_class,
	'swiper-container-' . esc_attr($this->get_id())
]);

$this->add_render_attribute('item-feed', [
	'id'        => 'blog-feed-' . esc_attr($this->get_id()),
	'class'     => 'blog-feed-grid'
]);

if ($settings['dots_position']) {
	$this->add_render_attribute('blog-feed-container', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position']);
}
$this->add_render_attribute('item-feed', 'class', 'swiper-wrapper');
$this->slider_settings();
?>

<div class="blog-latest-items">
	<div class="blog-row">
		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
			<div <?php echo $this->get_render_attribute_string('blog-feed-container'); ?>>
				<div <?php echo $this->get_render_attribute_string('item-feed'); ?>>
					<?php
					while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
						<?php if ($settings['post_layout'] == 'one') { ?>
							<div class="blog-carousel-item swiper-slide">
								<article id="post-<?php the_ID(); ?>" class="post">
									<div class="grid-layout">
										<?php if ($meta_location == 'before_image'){
											$this->render_mata();
										} ?>
										<?php if ($settings['show_featured_image'] == 'yes' && has_post_thumbnail()) { ?>
											<div class="post-thumb">
												<a class="post-link techt-shutter-effect" href="<?php the_permalink(); ?>">
													<?php
													if (!empty($settings['custom_img_dimension']['width']) || !empty($settings['custom_img_dimension']['height'])) {
														$width = $settings['custom_img_dimension']['width'];
														$height = $settings['custom_img_dimension']['height'];
														Techt_Utility::featured_image($width, $height, true, false);
													} else {
														Techt_Utility::featured_image(400, 260, true, false);
													} ?>
													<figure class="icon elementor-icon">
														<?php \Elementor\Icons_Manager::render_icon( $settings['link_icon'], [ 'aria-hidden' => 'true' ] ); ?>
													</figure>
												</a>
											</div><!-- /.post-thumb -->
										<?php } ?>
										<div class="post-content">
											<?php if ($settings['show_cate'] == 'yes') { ?>
												<div class="post-category">
													<?php the_category(' '); ?>
												</div><!--  /.post-category -->
											<?php }
											if ($meta_location == 'before_title'){
												$this->render_mata();
											}
											if ($settings['show_title'] == 'yes') {
												/* translators: %s: Permalinks of Posts */
												the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
											}
											if ($meta_location == 'before_excerpt'){
												$this->render_mata();
											}
											if ($settings['show_content'] == 'yes') { ?>
												<div class="entry-content"><?php echo Techt_Utility::postexcerpt($settings['content_words']); ?></div><!--  /.entry-content -->
											<?php }
											if ($meta_location == 'after_excerpt'){
												$this->render_mata();
											}
											if ($settings['show_read_more'] == 'yes') { ?>
												<div class="read-more-wrap">
													<a class="btn-read-more" href="<?php the_permalink(); ?>"><?php echo $settings['read_more_text']; ?></a>
												</div>
											<?php } ?>
										</div><!-- /post-content -->
									</div>
								</article>
							</div><!--  /.col-lg-4 -->
						<?php } elseif($settings['post_layout'] == 'two') { ?>
							<div class="blog-carousel-item swiper-slide">
								<article id="post-<?php the_ID(); ?>" class="post post-layout-2">
									<div class="grid-layout">
										<div class="row align-items-center">
											<div class="col-lg-6">
												<?php if ($settings['show_featured_image'] == 'yes' && has_post_thumbnail()) { ?>
													<div class="post-thumb">
														<a class="post-link" href="<?php the_permalink(); ?>">
															<?php
															if (!empty($settings['custom_img_dimension']['width']) || !empty($settings['custom_img_dimension']['height'])) {
																$width = $settings['custom_img_dimension']['width'];
																$height = $settings['custom_img_dimension']['height'];
																Techt_Utility::featured_image($width, $height, true, false);
															} else {
																Techt_Utility::featured_image(400, 260, true, false);
															} ?>
														</a>
													</div><!-- /.post-thumb -->
												<?php } ?>
											</div>

											<div class="col-lg-6">
												<?php if ($settings['show_cate'] == 'yes') { ?>
													<div class="post-category">
														<?php the_category(' '); ?>
													</div><!--  /.post-category -->
												<?php } ?>

												<?php if ($settings['show_title'] == 'yes') {
													/* translators: %s: Permalinks of Posts */
													the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
												} ?>

												<?php if ($settings['show_content'] == 'yes') { ?>
													<div class="entry-content"><?php echo Techt_Utility::postexcerpt($settings['content_words']); ?></div><!--  /.entry-content -->
												<?php } ?>

												<?php if ($settings['show_post_meta'] == 'yes') {
													$this->render_mata();
												} ?>

											</div>
										</div>
									</div>
								</article>
							</div><!--  /.col-lg-4 -->
						<?php }
					endwhile; ?> <?php wp_reset_postdata(); ?>
				</div>
				<?php $this->render_dots(); ?>
			</div>
			<?php $this->render_arrows(); ?>
		</div>
	</div><!--  /.row -->
</div><!--  /.blog-list-content -->