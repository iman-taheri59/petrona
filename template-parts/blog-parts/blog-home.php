<?php
/**
 * This template for displaying default layout
 *
 * @package Petrona
 * @since 1.0
 */
$theme_color_version = Techt_Utility::theme_options('theme_background_status');
$hero_class = array('hero-block');
get_header_image() ? $hero_class[] = 'bg-image' : $hero_class[] = 'bg-soft-black';
if( techt_header_transparent() !== '' ) {
    $hero_class[] = techt_header_transparent();
}

$sidebar_position = '';
$post_columns_class = '';
$sidebar_columns_class = '';
$sidebar_id = 'sidebar-blog';
$content_grid_class = '';
$featured_image_width = 0;
$featured_image_height = 0;
$elements = techt_blog_entries_positioning();
$args = [];

$post_layouts = techt_post_columns_functions('sidebar_position', 'blog_sidebar_display', $sidebar_id);

if ( !is_active_sidebar( $sidebar_id ) ) {         
    $sidebar_position = "full";
    $post_columns_class = $post_layouts['content_col_classes'];
} else {
    $sidebar_position = $post_layouts['sidebar_position'];
    $post_columns_class = $post_layouts['content_col_classes'];
    $sidebar_columns_class = $post_layouts['sidebar_col_classes'];
}

if ( $sidebar_position == 'full' ) {
    $content_grid_class = 'col-lg-4';
    $featured_image_width = 540;
    $featured_image_height = 405;
} elseif ( $sidebar_position == 'left' ||  $sidebar_position == 'right') {
    $content_grid_class = 'col-lg-6';
    $featured_image_width = 415;
    $featured_image_height = 245;
}
$args = array(
    'page_type'         => "archive",
    'sidebar_position'  => $sidebar_position,
    'content_class'     => $content_grid_class,
    'image_width'       => $featured_image_width,
    'image_height'      => $featured_image_height,
    'content_elements'  => $elements
);
?>

<!-- Hero Block
================================================== -->
<section class="<?php echo esc_attr( join(' ',$hero_class) ); ?>" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <div class="pd-t-120 pd-b-120">
                <?php if ( is_archive() || is_search() ): ?>
                    <?php if ( is_archive() ) {
                        techt_archive_title( '<h1 class="techt-title">', '</h1>' );
                        ?><?php 
                    } elseif ( is_search() ) { ?>
                        <h1 class="techt-title"><span><?php esc_html_e( 'Search Results for : ', 'petrona' ) ?></span><?php echo esc_html( get_search_query() ); ?></h1><!--  /.techt-title -->
                    <?php } ?>
                <?php else: ?>
                    <h1 class="techt-title" <?php techt_schema_markup('headline') ?>><?php echo wp_kses( Techt_Utility::theme_options( array('blog_title_info', __('Latest Articles','petrona') ) ), Techt_Static::html_allow() ); ?></h1>
                <?php endif; ?>
                <?php techt_enable_breadcrumb() === 'yes' ? \Techt_Core_Utility::techt_breadcrumbs() : ''; ?>
                </div>
            </div><!--  /.col-md-12 -->
        </div><!--  /.row -->
        <div></div>
    </div><!--  /.container -->
</section><!--  /.hero-block -->
<!-- Blog Page Block
================================================== -->
<main class="blog-block" id="main"<?php techt_schema_markup('main') ?>>
    <div class="container-xl">
        <!-- Content Row -->
        <div class="row">
            <div class="<?php echo esc_attr( $post_columns_class ); ?>">
                <!-- Blog Items -->
                <div class="blog-latest-items">
                    <div class="row">                    
                        <?php
                            if ( have_posts() ) :
                                $i = 0;
                                while ( have_posts() ) : the_post();
                                    get_template_part( 'template-parts/post/content','post', $args );
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

            <?php if ( is_active_sidebar( $sidebar_id ) && 'grid_features' !== Techt_Utility::theme_options( 'blog_layout_display' ) && 'full' !== $sidebar_position ) : ?>
                <div class="<?php echo esc_attr( $sidebar_columns_class ); ?>">
                    <?php get_sidebar(); ?>
                </div><!-- /.col-lg-4 -->
            <?php endif; ?>
        </div><!--  /.row -->
    </div><!--  /.container -->  
</main><!-- /.blog-block -->