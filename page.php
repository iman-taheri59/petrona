<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package Petrona
 */
get_header();

$elemetor = get_post_meta( get_the_ID(), '_elementor_edit_mode');
$page_builder = ( get_post_meta($post->ID, '_wpb_vc_js_status', true) == 'true' ) ? true : false;

$page_class = array('blog-block pd-b-45 page-content-main');
if( techt_header_sticky() == 'yes' ) {
    $page_class[] = 'sticky-page-content';
} 

// If Elementor Page Builder
if( $elemetor ) : 
    if ( have_posts() ) : 
        while ( have_posts() ) : the_post(); ?> 
        <div class="techt-page-builder-elementor clearfix" id="main">
            <?php the_content(); ?>
        </div>
        <?php 
        endwhile; 
    endif;
else: ?>
    <!-- Blog Block
    ================================================== -->
    <section class="<?php echo esc_attr( join(' ',$page_class) ); ?>" id="main">
        <div class="container">
            <!-- Content Row -->
            <?php
            
                $sidebar_id = 'sidebar-page';
                $columns = techt_post_columns_functions('sidebar_position', 'page_sidebar_display', $sidebar_id);
                $post_columns_class = $columns['content_col_classes'];
                $sidebar_columns_class = $columns['sidebar_col_classes'];
                $sidebar_position = Techt_Utility::theme_options('page_sidebar_display');
            ?>
            
            <div class="row">
                <?php while ( have_posts() ) : the_post(); ?>
                <div class="<?php echo esc_attr( $post_columns_class ); ?>">
                    <div class="blog-single-page">
                        <article id="post-<?php the_ID(); ?>"<?php post_class(' post '); ?> >
                            <?php if ( has_post_thumbnail() && Techt_Utility::meta_options('show_featured_image_in_content') !== 'no' ) { ?>
                                <figure class="post-thumb" <?php techt_schema_markup('image') ?>>
                                    <a class="post-link" href="<?php the_permalink(); ?>">
                                    <?php 
                                        if ( $sidebar_position == 'right' ) {
                                            Techt_Utility::featured_image(870, 500, true, false);
                                        } elseif ( $sidebar_position == 'left' ) {
                                            Techt_Utility::featured_image(870, 500, true, false);
                                        } else {
                                            Techt_Utility::featured_image(1140, 650, true, false);
                                        }
                                    ?>
                                    </a> 
                                </figure><!-- /.entry-thumb -->
                            <?php } ?>

                            <div class="post-details">
                                <?php if( Techt_Utility::meta_options('show_page_title') !== 'no' ) { ?>
                                <h2 class="entry-title mrb-20"<?php techt_schema_markup('headline') ?>><?php the_title(); ?></h2> 
                                <?php } ?> 
                                <div class="entry-content"<?php techt_schema_markup('entry_content') ?>>                            
                                    <?php 
                                        the_content(); 
                                        techt_wp_link_pages(); 
                                    ?>
                                </div><!--  /.entry-content -->
                            </div><!-- /.entry-content -->
                        </article><!-- /.post -->
                        
                        <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif; ?>
                    </div><!-- /.blog-page-content -->
                    
                </div><!-- /.col-md-9 full-content -->
                <?php endwhile; ?>
                
                <?php
                $sidebar_position = Techt_Utility::meta_options('sidebar_position');
                if( isset( $sidebar_position) && $sidebar_position !== 'full' ) { ?>
                <div class="<?php echo esc_attr( $sidebar_columns_class ); ?> " <?php techt_schema_markup('sidebar') ?>>
                    <?php get_sidebar(); ?>
                </div><!-- /.col-lg-4 -->
                <?php
                 } else {
                    if( Techt_Utility::theme_options('page_sidebar_display') !=='full' && is_active_sidebar( "sidebar-page" ) ) { ?>
                    <div class="<?php echo esc_attr( $sidebar_columns_class ); ?> "<?php techt_schema_markup('sidebar') ?>>
                        <?php get_sidebar(); ?>
                    </div><!-- /.col-lg-4 -->
                    <?php }
                } ?>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </section><!-- /.blog-block -->
<?php endif; ?>
<?php get_footer(); ?>