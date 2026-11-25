<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Petrona
 * @since 1.0
 */
get_header(); ?> 

<!-- Error  Block
================================================== -->
<section class="error-page-block error-page-block">
    <div class="container error-content">
        <div class="row align-items-center error-row height-100 pd-t-105 pd-b-105">
            <div class="col-md-12 text-center">        
                <div class="error-right-blocks text-center">
                    <img src="<?php echo esc_url( get_theme_file_uri('/assets/images/404.png') ) ?>" alt="<?php esc_attr_e('Nothing Found', 'petrona') ?>" />
                </div>
                <div class="error-text-blocks text-center mrt-45">
                	<h2 class="error-title text-uppercase w-700 fts-30"><?php esc_html_e('Looks Like You\'re Lost', 'petrona') ?></h2><!--  /.error-title -->
                	<p class="error-description fts-16"><?php esc_html_e('The page you are looking for is currently unavailable!', 'petrona') ?></p>
                	<div class="clear">
                		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-defult btn-more-works w-700"><?php esc_html_e('Back To Home', 'petrona'); ?></a>
                	</div><!--  /.clear -->
                </div><!--  /.error-text-blocks -->
            </div><!--  /.col-md-7 -->
        </div><!--  /.row -->
    </div><!-- /.container -->
</section><!-- /.blog-block -->

<?php get_footer(); ?>