<?php
/**
 * Single Post Content
 *
 * @package Petrona
 * @since 1.0
 */
$is_title_in_hero = Techt_Utility::theme_options(['blog_single_title_in_hero', true]);
$hero_classes = array('hero-block');

$hero_classes[] = get_header_image() ?  'bg-image' : 'bg-soft-black';

$blog_main_classes = array('blog-block-single');
$blog_main_classes[] = 'blog-single-spacing';

if( techt_header_transparent() !== '' ) {
    $hero_classes[] = techt_header_transparent();
    $blog_main_classes[] = techt_header_transparent();
} 

$sidebar_position = '';
$post_content_classes = array('blog-single-page');
$sidebar_classes = [];
$sidebar_id = 'sidebar-single';
$content_grid_class = '';
$featured_image_width = 0;
$featured_image_height = 0;
$section_elements = techt_single_blog_sections_positioning();
$content_elements = techt_single_blog_positioning();
$args = [];
$post_layouts = techt_post_columns_functions('sidebar_position', 'blog_single_sidebar_display', $sidebar_id);

if ( !is_active_sidebar( $sidebar_id ) ) {         
    $sidebar_position = "full";
    $post_content_classes[] = $post_layouts['content_col_classes'];
} else {
    $sidebar_position = $post_layouts['sidebar_position'];
    $post_content_classes[] = $post_layouts['content_col_classes'];
    $sidebar_classes[] = $post_layouts['sidebar_col_classes'];
}

if ( $sidebar_position == 'full' ) {
    $feature_image_status = Techt_Utility::theme_options(['blog_single_feature_image_status', 'normal']);
    if( $feature_image_status == 'wide' ) {
        $featured_image_width = 1140;
        $featured_image_height = 600;
    } elseif ( $feature_image_status == 'full') {
        $featured_image_width = 1200;
        $featured_image_height = 800;
    } else {
        $featured_image_width = 1920;
        $featured_image_height = 800;
    }
} elseif ( $sidebar_position == 'left' ||  $sidebar_position == 'right') {
    $featured_image_width = 870;
    $featured_image_height = 550;
}
$args = array(
    'page_type'         => "single",
    'sidebar_position'  => $sidebar_position,
    'content_class'     => '',
    'image_width'       => $featured_image_width,
    'image_height'      => $featured_image_height,
    'content_elements'  => $content_elements
);

$post_thumb = array('post-thumb');
if( Techt_Utility::theme_options('blog_single_sidebar_display') == 'full' || !is_active_sidebar( "sidebar-single" ) ) {
    if( Techt_Utility::theme_options('blog_single_feature_image_status') == 'wide' ) {
        $post_thumb[] = 'alignwide';
    } elseif( Techt_Utility::theme_options('blog_single_feature_image_status') == 'full' ) {
        $post_thumb[] = 'alignfull';
    }
} ?>

<!-- Hero Block
================================================== -->
<section class="<?php echo esc_attr( join(' ',$hero_classes) ); ?>" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <div class="pd-t-150 pd-b-150">
                    <?php if($is_title_in_hero){ ?>
                        <h1 class="techt-title" <?php techt_schema_markup('headline') ?>><?php have_posts() ? the_title() : ""; ?></h1>
                    <?php } ?>
                    <?php techt_enable_breadcrumb() === 'yes' ? \Techt_Core_Utility::techt_breadcrumbs() : ''; ?>
                </div>
            </div><!--  /.col-md-12 -->
        </div><!--  /.row -->
    </div><!--  /.container -->
</section><!--  /.hero-block -->
<!-- Blog Page Block
================================================== -->
<div id="main" class="<?php echo esc_attr( join(' ',$blog_main_classes) ); ?>"<?php techt_schema_markup('main') ?>>
    <div class="container-xl">
        <!-- Content Row -->
        <div class="row">
            <div class="<?php echo esc_attr( join(' ',$post_content_classes) ); ?>">
                <?php foreach ($section_elements as $index => $element ) { ?>
                    <?php if( 'blog_content' ==  $element ) { ?>             
                        <!-- Blog Items -->
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'template-parts/post/content','post', $args ); ?>
                        <?php endwhile; ?>
                    <?php } ?>

                    <?php if( 'related_posts' == $element ) { ?>    
                        <?php get_template_part( 'template-parts/post/related-post' ); ?>
                    <?php } ?>

                    <?php
                        if( 'comments' == $element  ) { 
                            // If comments are open or we have at least one comment, load up the comment template
                            if ( comments_open() || get_comments_number() ) :
                            comments_template();
                            endif;
                        }
                    ?>
                    
                    <?php if( 'post_pagination' == $element ) { ?>
                        <?php if ( get_previous_post() || get_next_post() ) : ?>
                            <div class="single-post-pagination post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php if ( get_previous_post() ) { ?>
                                        <div class="text-left">
                                            <div class="more-link-wrap previous-posts">
                                                <div class="post-thumb">
                                                    <a class="post-link" href="<?php echo esc_url( get_permalink(get_previous_post()->ID) ); ?>">
                                                    <?php 
                                                    $prevThumbnail = get_the_post_thumbnail( get_previous_post()->ID, 'thumbnail' );
                                                    echo wp_kses_post($prevThumbnail);
                                                    ?>
                                                    </a>
                                                </div><!--  /.post-thumb -->
                                                <div class="page-post-content">
                                                    <?php previous_post_link('%link', esc_html__('Older Post', 'petrona')); ?>
                                                    <h3><a href="<?php echo esc_url( get_permalink(get_previous_post()->ID) ); ?>"><?php echo get_the_title(get_previous_post()); ?></a></h3>
                                                </div><!--  /.post-content -->
                                            </div>
                                        </div><!--  /.text-left -->
                                        <?php } ?> 
                                    </div><!--  /.col-6 -->
                                    <div class="col-md-6">
                                        <?php if ( get_next_post() ) { ?>
                                        <div class="text-right">
                                            <div class="more-link-wrap next-posts">
                                                <div class="page-post-content">
                                                    <?php next_post_link('%link', esc_html__('Newer Post', 'petrona')); ?>
                                                    <h3><a href="<?php echo esc_url( get_permalink(get_next_post()->ID) ); ?>"><?php echo get_the_title(get_next_post()); ?></a></h3>
                                                </div><!--  /.post-content -->
                                                <div class="post-thumb">
                                                    <a class="post-link" href="<?php echo esc_url( get_permalink(get_next_post()->ID) ); ?>">
                                                    <?php 
                                                    $prevThumbnail = get_the_post_thumbnail( get_next_post()->ID, 'thumbnail' );
                                                    echo wp_kses_post($prevThumbnail);
                                                    ?>
                                                    </a>
                                                </div><!--  /.post-thumb -->
                                            </div>
                                        </div><!--  /.text-right -->
                                        <?php } ?> 
                                    </div><!--  /.col-6 -->
                                </div><!--  /.row -->
                            </div><!--  /.single-post-pagination -->
                        <?php endif; ?>
                    <?php } ?>
                <?php } ?>
            </div><!--  /.col-lg-8 -->

            <?php
            if( isset( $sidebar_position) && ( $sidebar_position !== 'full' && $sidebar_position !=='default' ) ) { ?>
                    <div class="<?php echo esc_attr( join(' ',$sidebar_classes) ); ?>"<?php techt_schema_markup('sidebar') ?>>
                        <?php get_sidebar(); ?>
                    </div><!-- /.col-lg-4 -->
                <?php
            } else {
                if( Techt_Utility::theme_options('blog_single_sidebar_display') !=='full' && is_active_sidebar( "sidebar-single" ) ) { ?>
                <div class="<?php echo esc_attr( join(' ', $sidebar_classes) ); ?>"<?php techt_schema_markup('sidebar') ?>>
                    <?php get_sidebar(); ?>
                </div><!-- /.col-lg-4 -->
                <?php }
            } ?>
        </div><!--  /.row -->
    </div><!--  /.container -->
</div><!--  /.blog-page-block -->