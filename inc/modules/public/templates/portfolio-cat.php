<?php
/**
 * This template for displaying default layout
 *
 * @package Petrona
 * @since 1.0
 */
get_header();
$hero_class = array('hero-block');
get_header_image() ? $hero_class[] = 'bg-image' : $hero_class[] = 'bg-soft-black';
if( techt_header_transparent() !== '' ) {
    $hero_class[] = techt_header_transparent();
} 
?>

<!-- Hero Block
================================================== -->
<section class="<?php echo esc_attr( join(' ',$hero_class) ); ?>" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if ( is_archive() || is_search() ): ?>
                    <div class="pd-t-120 pd-b-120">
                    <?php if ( is_archive() ) {
                        techt_archive_title( '<h1 class="techt-title">', '</h1>' );
                        ?><?php 
                    } elseif ( is_search() ) { ?>
                        <h1 class="techt-title"><span><?php esc_html_e( 'Search Results for : ', 'petrona' ) ?></span><?php echo get_search_query(); ?></h1><!--  /.techt-title -->
                    <?php } ?>
                    </div>
                <?php else: ?>
                    <div class="pd-t-120 pd-b-120">
                    <h1 class="techt-title" <?php techt_schema_markup('headline') ?>><?php echo wp_kses( Techt_Utility::theme_options( array('blog_title_info', __('Portfolios', 'petrona') ) ), Techt_Static::html_allow() ); ?></h1>
                    </div>
                <?php endif; ?>
            </div><!--  /.col-md-12 -->
        </div><!--  /.row -->
    </div><!--  /.container -->
</section><!--  /.hero-block -->
<?php techt_enable_breadcrumb() === 'yes' ? \Techt_Core_Utility::techt_breadcrumbs() : ''; ?>
<!-- Blog Page Block
================================================== -->
<main class="blog-block" id="main"<?php techt_schema_markup('main') ?>>
    <div class="container">
        <!-- Content Row -->
        <div class="row">
            <?php
                ( isset($_GET["blog_sidebar"]) ) ? $blog_sidebar = $_GET["blog_sidebar"]  : $blog_sidebar = "" ;
                ($blog_sidebar) ? $sidebar_position = $blog_sidebar : $sidebar_position = Techt_Utility::theme_options('blog_sidebar_display');

                if( Techt_Utility::theme_options('blog_sidebar_status') == 'sticky' ) {
                    $sidebar_sticky = 'sticky-content';
                } else {
                    $sidebar_sticky = '';
                }

                if ( !is_active_sidebar( 'sidebar-blog' ) ) {         
                    $post_columns_class = 'col-lg-12';
                    $sidebar_columns_class = '';       
                } else {
                    $right = 'order-lg-first';
                    $left = 'order-lg-last';
                    if ( $sidebar_position == 'full' || Techt_Utility::theme_options('blog_layout_display') == 'grid_features' ) {
                        $post_columns_class = 'col-lg-12';
                        $sidebar_columns_class = '';
                    } elseif ( $sidebar_position == 'left' ) {
                        $post_columns_class = sprintf('col-lg-9 %s layout-content', $right);
                        $sidebar_columns_class = sprintf('col-lg-3 %1$s layout-sidebar %2$s', $left, $sidebar_sticky);
                    } else {
                        $post_columns_class = sprintf('col-lg-9 %s layout-content', $left);
                        $sidebar_columns_class = sprintf('col-lg-3 %1$s layout-sidebar %2$s', $right, $sidebar_sticky);
                    }
                }
            ?>
            <div class="<?php echo esc_attr( $post_columns_class ); ?>">
                <!-- Blog Items -->
                <div class="blog-latest-items">
                    <div class="row">                    
                        <?php
                        
                            $args = array(
                                'post_type' => 'portfolio',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'portfolio-category',
                                        'field'    => 'slug',
                                        'terms'    => get_queried_object()->name,
                                    ),
                                ),
                            );
                            $query = new WP_Query( $args );
                            if ( $query->have_posts() ) :
                                $i = 0;
                                while ( $query->have_posts() ) : $query->the_post();
                                    get_template_part( 'template-parts/post/content' );
                                endwhile;  
                            else :  
                                get_template_part( 'template-parts/post/content', 'none' ); 
                            endif; 
                        ?>  
                    </div><!--  /.row -->
                </div><!--  /.blog-latest-items -->
            
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php 
                        if( Techt_Utility::theme_options('pagination_types') == 'load_more') {
                            if( function_exists('techt_theme_load_more_post') ) {
                                echo techt_theme_load_more_post();
                            }
                        } else {
                            techt_posts_pagination_nav(); 
                        } ?>
                    </div><!--  /.col-md-12 -->
                </div><!--  /.row -->
            </div><!--  /.col-lg-8 -->

            <?php if( 'grid_features' !== Techt_Utility::theme_options('blog_layout_display') && $sidebar_position !=='full' || !is_active_sidebar( 'sidebar-blog' ) ) { ?>
            <div class="<?php echo esc_attr( $sidebar_columns_class ); ?>">
                <?php get_sidebar(); ?>
            </div><!-- /.col-lg-4 -->
            <?php } ?>
        </div><!--  /.row -->
    </div><!--  /.container -->  
</main><!-- /.blog-block -->
<?php
get_footer();