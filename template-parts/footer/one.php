<?php
/**
 * This template for displaying footer part
 *
 * @package Petrona
 * @since 1.0
 */

/**
 * Footer Part show/hide condition
 *
 * @since 1.0
 */
if( Techt_Utility::meta_options('footer_show_footer') == 'no' ) {
    return;
} 
/**
 * Control Header Transparent
 * @package Petrona
 * @since 1.0
 */
$footer_fixed = '';

if( techt_fixed_footer() == 'yes' ) {
    $footer_fixed = 'footer-fixed';
} else {
    $footer_fixed = '';
} 

if(  Techt_Utility::theme_options('enable_scroll_top') == true ) {
    $scrool_top = '<a href="#top" class="techt-scroll-top btn-hide" id="scroll-top">
                    <i class="fa fa-arrow-up text-white"></i></a>';
} else {
    $scrool_top = '';
} 

?>
<!-- Custom Footer
================================================== --> 
<?php
 echo $scrool_top;
 if( Techt_Utility::theme_options('footer_type') == 'custom_footer' && Techt_Utility::theme_options('footer_templates') !== 'default' || Techt_Utility::meta_options('footer_type') == 'custom_template' && Techt_Utility::meta_options('footer_template')  ) : ?>
<footer class="techt-custom-footer <?php echo esc_attr($footer_fixed); ?>" <?php techt_schema_markup('footer') ?>>
    <?php       
        $args = array( 'post_type' => 'petrona_templates', 'p' => techt_footer_template_id() );

        $loop = new WP_Query( $args );
            while ( $loop->have_posts() ) : $loop->the_post();
                the_content();
            endwhile;
        wp_reset_postdata();
    ?>
</footer><!--  /.techt-custom-header -->
<?php else : ?>

<?php 
if(  Techt_Utility::theme_options('full_footer_content') == true ) {
    $container_name = 'container-fluid';
} else {
    $container_name = 'container';
} ?>
<!-- Predefine Footer
================================================== -->
<footer class="site-footer <?php echo esc_attr($footer_fixed); ?>"<?php techt_schema_markup('footer') ?>>
    <div class="footer-top-block">
        <?php $footer_widgets_layout = techt_footer_widgets_layout_array(); ?>
        <div class="<?php echo esc_attr($container_name); ?>">
            <?php if ( ! empty( $footer_widgets_layout ) ) : ?>
            <div class="row">
                <?php dynamic_sidebar( 'footer-widgets' ); ?>
            </div>
            <?php endif; ?>
        </div><!-- /.container -->
    </div><!--  /.container -->

    <div class="footer-bottom-block">
        <div class="<?php echo esc_attr($container_name); ?>">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="copyright-text"><?php echo wp_kses( Techt_Utility::theme_options( array('footer_copyright_info', __('Created With By <a href="#">Technotheme</a>', 'petrona') ) ), Techt_Static::html_allow() ); ?></p>
                </div><!--  /.col-md-12 -->
            </div><!--  /.row -->
        </div><!--  /.container -->
    </div><!--  /.footer-bottom-block -->
    
</footer><!--  /.site-footer -->
<?php endif; ?>