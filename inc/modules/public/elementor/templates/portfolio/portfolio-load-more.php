<div class="d-flex">
   	<div class="col-md-12 text-center">
   		<?php
   		if( $settings['pagination_types'] == 'pagi_numbers' ) {
   			Techt_Core_Utility::pagination($portfolio_query, $settings);  
   		} else {
   			if( $settings['more_works_btn_link'] ) {		
	   			$target = $settings['more_works_btn_link']['is_external'] ? ' target="_blank" rel="noopener noreferrer"' : '';
	   			$nofollow = $settings['more_works_btn_link']['nofollow'] ? ' rel="nofollow"' : '';
   			} 
   		?>
   		<?php if( $settings['pagination_types'] == 'load_more_ajax' ) { ?>
		<div class="infinite-scroll-status">
			<div class="loader-ellips">
			  <span class="loader-ellips__dot"></span>
			  <span class="loader-ellips__dot"></span>
			  <span class="loader-ellips__dot"></span>
			  <span class="loader-ellips__dot"></span>
			</div>
		</div><!--  /.infinite-scroll-status -->
		<?php } ?>

		<?php if( $settings['pagination_types'] == 'custom_button' ) { ?>
       	<a href="<?php echo esc_url( $settings['more_works_btn_link']['url'] ); ?>" class="btn btn-defult btn-more-works" <?php echo( $settings['more_works_btn_link']['url'] ) ? ( $target .' '. $nofollow ) : ''; ?>><?php echo esc_html( $settings['more_work_btn_text'] ); ?></a>
       	<?php } ?>
       	
		<?php if( $settings['pagination_types'] == 'load_more_ajax' ) {
			Techt_Core_Utility::pagination($portfolio_query, $settings);
		} }?>
   	</div><!--  /.col-md-12 -->
</div><!--  /.row -->