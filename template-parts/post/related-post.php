<?php
/**
 * Single related posts
 *
 * @package Petrona WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query_based = Techt_Utility::theme_options( array('related_posts_query_type', 'category') );
$term_tax = $query_based  ? $query_based : 'category';

// Create an array of current term ID's
$terms = wp_get_post_terms( get_the_ID(), $term_tax );

if( !is_wp_error($terms) ) {
	$terms_ids = array();
	foreach( $terms as $term ) {
		$terms_ids[] = $term->term_id;
	}
} else {
	return false;
}

// Query args
$args = array(
	'posts_per_page' => Techt_Utility::theme_options( array('related_posts_number', 2) ),
	'orderby'        => 'rand',
	'post__not_in'   => array( get_the_ID() ),
	'no_found_rows'  => true,
);

// If category
if ( 'category' == $term_tax ) {
	$args['category__in'] = $terms_ids;
}

// If tags
if ( 'post_tag' == $term_tax ) {
	$args['tag__in'] = $terms_ids;
}

// Related query arguments
$techt_related_query = new WP_Query( $args );
if($techt_related_query->have_posts()){
    ?>
    <div class="related-post-content">
        <div class="title-content">
            <h3 class="post-section-title"><?php echo esc_html__('Related Posts', 'petrona'); ?></h3><!--  /.post-section-title -->
        </div><!--  /.title-content -->
        <div class="related-content row">
            <?php
            while ($techt_related_query->have_posts()) : $techt_related_query->the_post();  ?>
                <div class="col-md-6">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="grid-layout">
                        <?php foreach (techt_blog_entries_positioning() as $elements ) { ?>
                            <?php if ( has_post_thumbnail() && 'featured_image' == $elements ) {  ?>
                                <figure class="post-thumb" <?php techt_schema_markup('image') ?>>          
                                    <a class="post-link techt-shutter-effect" href="<?php the_permalink(); ?>">
                                        <?php Techt_Utility::featured_image(540, 405, true, false); ?>
                                        <figure class="icon">
                                            <i class="techt-icon-new-window"></i>
                                        </figure>
                                    </a> 
                                </figure><!-- /.post-thumb -->
                            <?php } ?>
                
                            <?php if( 'category' == $elements ) { ?>
                                <div class="post-category">
                                    <?php the_category(' '); ?>
                                </div><!--  /.post-category -->
                            <?php } ?>
                
                            <?php if( 'title' == $elements ) { 
                                /* translators: %s: Permalinks of Posts */
                                the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
                            } ?>
                            
                            <?php if( 'content' == $elements ) { ?>
                                <div class="entry-content" <?php techt_schema_markup('entry_content') ?>><?php echo Techt_Utility::postexcerpt( Techt_Utility::theme_options(array('excerpt_length', 25)) ); ?></div><!--  /.entry-content -->
                            <?php }
                
                            if( 'post_meta' == $elements ) {
                                get_template_part( 'template-parts/post/meta' );
                            }
                        } ?>
                        </div><!--  /.grid-layout -->
                    </article><!--  /.post -->
                </div><!--  /.col-lg-6 -->
            <?php endwhile; wp_reset_postdata(); ?>
        </div><!--  /.related-content -->
    </div><!--  /.related-post-content -->
    <?php
}

