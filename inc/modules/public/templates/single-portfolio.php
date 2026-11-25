<?php
/**
 * The template for displaying Portfolio Details
 *
 * This is the template that displays all Portfolio.
 *
 * @package Petrona Portfolio Single Pages
 */
get_header();
$hero_classes = array('hero-block');
$hero_classes[] = get_header_image() ?  'bg-image' : 'bg-soft-black';

$portfolio_single = array('portfolio-block-single');
$portfolio_single[] = 'page-content-main';

$is_stretched_content_layout = Techt_Utility::meta_options('enable_stretched_content_layout') ? Techt_Utility::meta_options('enable_stretched_content_layout') : Techt_Utility::theme_options(['enable_portfolio_stretched_content', false]);
$show_portfolio_details = Techt_Utility::meta_options('show_portfolio_details');
if($show_portfolio_details != "no" && Techt_Utility::theme_options(['show_portfolio_details_box', true])){
	$show_portfolio_details = true;
}elseif($show_portfolio_details == "no" || ! Techt_Utility::theme_options('show_portfolio_details_box')){
	$show_portfolio_details = false;
}
if( techt_header_transparent() !== '' ) {
	$hero_classes[] = techt_header_transparent();
	$portfolio_single[] = techt_header_transparent();
}
$general_meta_details = techt_get_portfolio_general_details();
if( Techt_Utility::meta_options('show_hero_image') !== 'no' ) { ?>
	<!-- Hero Block
	================================================== -->
	<section class="<?php echo esc_attr( join(' ',$hero_classes) ); ?>" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="pd-t-150 pd-b-150">
						<?php 
						if( Techt_Utility::meta_options('show_page_title') !== 'no' ) { ?>
							<h1 class="entry-title" <?php techt_schema_markup('headline') ?>><?php the_title(); ?></h1>
						<?php } ?>
						<?php techt_enable_breadcrumb() === 'yes' ? \Techt_Core_Utility::techt_breadcrumbs() : ''; ?>
					</div>
				</div><!--  /.col-md-12 -->
			</div><!--  /.row -->
		</div><!--  /.container -->
	</section><!--  /.hero-block -->
<?php } ?>
<!-- Blog Page Block
================================================== -->
<div id="main" class="<?php echo esc_attr( join(' ',$portfolio_single) ); ?>" <?php techt_schema_markup('main') ?>>
    <div class="<?php echo esc_attr( $is_stretched_content_layout ? 'container-fluid' : 'container' ); ?>">
        <!-- Content Row -->
        <div class="row no-gutters">
        	<div class="col-lg-12">    		
	            <div class="techt-portfolio-single-page">
	                <!-- Blog Items -->
	                <?php //while ( have_posts() ) : the_post(); ?>
	                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	                    <div class="grid-layout">
	                    	<?php 
	                    	if( Techt_Utility::meta_options('show_featured_image_in_content') !== 'no' ) {
	                    	    if ( has_post_thumbnail() ) { ?>
		                            <figure class="post-thumb"<?php techt_schema_markup('image') ?>>
		                                <?php Techt_Utility::featured_image(1200, 800, true, false); ?> 
		                            </figure><!-- /.post-thumb -->
		                        <?php }
	                    	} ?>
							<?php if($show_portfolio_details && !empty($general_meta_details)){ ?>
								<div class="techt-portfolio-details">
									<div class="portfolio-single-details-area">
										<div class="techt-portfolio-details-box">
											<div class="techt-portfolio-details-box-title">
												<h2><?php echo esc_html__('Project Details: ', 'petrona'); ?> </h2>
											</div>
											<div class="techt-portfolio-details-box-inner">
												<ul class="techt-portfolio-details-list"> 
														<?php foreach($general_meta_details as $key => $value){
															switch ($key) {
																case 'status':
																	?>
																	<li class="portfolio-details-item">
																		<i class="portfolio-details-icon techt-icon-clipboard"></i>
																		<span class="portfolio-details-label">
																			<?php echo esc_html__('Status', 'petrona'); ?>
																		</span>
																		<span class="portfolio-details-value">
																			<?php if($value == 'complated'){
																				echo esc_html__('Complated', 'petrona');
																			}elseif($value == 'doing'){
																				echo esc_html__('Doing', 'petrona');
																			}elseif($value == 'canceled'){
																				echo esc_html__('Canceled', 'petrona');
																			}?>
																		</span>
																	</li>
																	<?php break;
																case 'year':
																	?>
																	<li class="portfolio-details-item">
																		<i class="portfolio-details-icon techt-icon-calendar"></i>
																		<span class="portfolio-details-label">
																			<?php echo esc_html__('Activation Year', 'petrona'); ?>
																		</span>
																		<span class="portfolio-details-value">
																			<?php echo $value; ?>
																		</span>
																	</li>
																	<?php break;
																case 'location':
																	?>
																	<li class="portfolio-details-item">
																		<i class="portfolio-details-icon techt-icon-location-pin"></i>
																		<span class="portfolio-details-label">
																			<?php echo esc_html__('Location', 'petrona'); ?>
																		</span>
																		<span class="portfolio-details-value">
																			<?php echo $value; ?>
																		</span>
																	</li>
																	<?php break;
																case 'client':
																	?>
																	<li class="portfolio-details-item">
																		<i class="portfolio-details-icon techt-icon-user"></i>
																		<span class="portfolio-details-label">
																			<?php echo esc_html__('Client', 'petrona'); ?>
																		</span>
																		<span class="portfolio-details-value">
																			<?php echo $value; ?>
																		</span>
																	</li>
																	<?php break;
															}
														} ?> 
												</ul>
											</div>
											<div class="social-share">
												<span class="techt-share-title"><?php echo esc_html__('Share Content: ', 'petrona') ?></span>
											    <?php techt_social_share_link() ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
	                        <div class="entry-content pd-t-70" <?php techt_schema_markup('entry_content') ?>>
	                            <?php 
	                                the_content(); 
	                                techt_wp_link_pages(); 
	                            ?>
	                        </div><!--  /.entry-content -->
	                    </div>
	                </article><!--  /.post -->
	                <?php //endwhile; ?>
	            </div><!--  /.col-lg-8 -->
        	</div><!--  /.col-lg-12 -->
        </div><!--  /.row -->
    </div><!--  /.container -->
</div><!--  /.blog-page-block -->
<?php get_footer(); ?>