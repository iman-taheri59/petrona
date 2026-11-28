<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Petrona
 * @since 1.0
 */
$page_type              = $args['page_type'];
$sidebar_position       = $args['sidebar_position'];
$content_class          = $args['content_class'];
$featured_image_width   = $args['image_width'];
$featured_image_height  = $args['image_height'];
$elements               = $args['content_elements'];

$thumb_classes = array('post-thumb');
if($page_type  == "single"){
    if( $sidebar_position == 'full' ) {
        if( Techt_Utility::theme_options('blog_single_feature_image_status') == 'wide' ) {
            $thumb_classes[] = 'alignwide';
        } elseif( Techt_Utility::theme_options('blog_single_feature_image_status') == 'full' ) {
            $thumb_classes[] = 'alignfull';
        }
    }
}
if( is_sticky() && !is_paged() && $page_type === 'archive' ) { ?>
    <div class="col-lg-12 big-items">    
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
            <div class="row align-items-center">
                <div class="col-md-12">
                    <?php foreach ($elements as $index => $element ) {  
                        if ( has_post_thumbnail() && 'featured_image' == $element) {  ?>
                            <div class="<?php echo esc_attr( join(' ',$thumb_classes) ); ?>" <?php techt_schema_markup('image') ?>>          
                                <a class="post-link" href="<?php the_permalink(); ?>">
                                    <?php
                                    if ( $sidebar_position == 'full' ) {
                                        Techt_Utility::featured_image(540, 320, true, false);
                                    } elseif ( $sidebar_position == 'left' ) {
                                        Techt_Utility::featured_image(800, 600, true, false);
                                    } else {
                                        Techt_Utility::featured_image(800, 600, true, false);
                                    }
                                    ?>            
                                </a> 
                            </div><!-- /.post-thumb -->
                        <?php }
                        if($index == 0){?>
                            <div class="post-content">
                        <?php }
                            if( 'category' == $element ) { ?>
                                <div class="post-category">
                                    <?php the_category(' '); ?>
                                </div><!--  /.post-category -->
                            <?php } ?>
        
                            <?php if( 'title' == $element ) { 
                                if($page_type === 'archive'){
                                     /* translators: %s: Permalinks of Posts */
                                    the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
                                }else{
                                    ?><h2 class="entry-title" <?php techt_schema_markup('headline') ?>><?php the_title(); ?></h2><?php
                                }
                               
                            } ?>
                            
                            <?php if( 'content' == $element ) {
                                if($page_type === 'archive'){ 
                                    ?>
                                        <div class="entry-content"<?php techt_schema_markup('entry_content') ?>>
                                            <?php echo Techt_Utility::postexcerpt( Techt_Utility::theme_options(array('excerpt_length', 25)) ); ?>
                                            <?php if( get_the_title() == '' ) {?>
                                                <a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>">
                                                    <?php esc_html_e('More', 'petrona'); ?>
                                                </a>
                                            <?php } ?>
                                        </div><!--  /.entry-content -->
                                    <?php
                                }else{
                                    ?>
                                    <div class="entry-content" <?php techt_schema_markup('entry_content') ?>>
                                        <?php 
                                            the_content(); 
                                            techt_wp_link_pages(); 
                                        ?>
                                    </div><!--  /.entry-content -->
                                <?php } ?>
                            <?php } ?>

                            <?php if( 'tag' == $element ) { ?>
                                <?php if( has_tag() ): ?>
                                <div class="blog-tag">
                                    <div class="tagcloud">
                                        <span><?php esc_html_e('Tags', 'petrona'); ?></span>
                                        <?php the_tags('', ' '); ?>
                                    </div><!--  /.tagcloud -->
                                </div><!--  /.blog-tag -->
                                <?php endif; ?>
                            <?php }

                            if( 'post_meta' == $element ) {
                                get_template_part( 'template-parts/post/meta' );
                            }
                            
                        if($index == (count($elements) - 1)){?>
                            </div><!-- /post-content -->
                        <?php }
                        
                    } ?>
                </div><!--  /.col-md-12 -->
            </div><!--  /.row -->
        </article>
    </div><!--  /.col-lg-12 -->
<?php } else { ?>
    <div class="<?php echo esc_attr( $content_class ); ?>">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php $post_link_class = 'post-link';
                  $post_link_icon ='';
            if($page_type == 'archive'){ 
                $post_link_class .= " techt-shutter-effect";
                $post_link_icon .= '<figure class="icon"><i class="techt-icon-new-window"></i></figure>';
                ?>
                <div class="grid-layout">
            <?php } else { ?>
                <div class="single-layout">
            <?php } ?>
            <?php foreach ($elements as $index => $element ) {  
                if ( has_post_thumbnail() && 'featured_image' == $element) {  ?>
                    <div class="<?php echo esc_attr( join(' ',$thumb_classes) ); ?>" <?php techt_schema_markup('image') ?>>          
                        <a class="<?php echo $post_link_class; ?>" href="<?php the_permalink(); ?>">
                            <?php
                                Techt_Utility::featured_image($featured_image_width, $featured_image_height, true, false);
                            echo $post_link_icon;
                            ?>            
                        </a>
                    </div><!-- /.post-thumb -->
                <?php }
                if($index == 0){?>
                    <div class="post-content">
                <?php }
                    if( 'category' == $element ) { ?>
                        <div class="post-category">
                            <?php the_category(' '); ?>
                        </div><!--  /.post-category -->
                    <?php } ?>

                    <?php if( 'title' == $element ) { 
                        if($page_type == 'archive'){
                             /* translators: %s: Permalinks of Posts */
                            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); 
                        }else{
                            ?><h1 class="entry-title" <?php techt_schema_markup('headline') ?>><?php the_title(); ?></h1><?php
                        }
                       
                    } ?>
                            
                    <?php if( 'content' == $element ) {
                        if($page_type == 'archive'){ 
                            ?>
                                <div class="entry-content"<?php techt_schema_markup('entry_content') ?>>
                                    <?php echo Techt_Utility::postexcerpt( Techt_Utility::theme_options(array('excerpt_length', 25)) ); ?>
                                    <?php if( get_the_title() == '' ) {?>
                                        <a class="more-link" href="<?php echo esc_url( get_permalink() ); ?>">
                                            <?php esc_html_e('More', 'petrona'); ?>
                                        </a>
                                    <?php } ?>
                                </div><!--  /.entry-content -->
                            <?php
                        }else{
                            ?>
                            <div class="entry-content" <?php techt_schema_markup('entry_content') ?>>
                                <?php 
                                    the_content(); 
                                    techt_wp_link_pages(); 
                                ?>
                            </div><!--  /.entry-content -->
                        <?php } ?>
                    <?php } ?>

                    <?php if( 'tag' == $element ) { ?>
                        <?php if( has_tag() ): ?>
                        <div class="blog-tag">
                            <div class="tagcloud">
                                <span><?php esc_html_e('Tags', 'petrona'); ?></span>
                                <?php the_tags('', ' '); ?>
                            </div><!--  /.tagcloud -->
                        </div><!--  /.blog-tag -->
                        <?php endif; ?>
                    <?php }

                    if( 'post_meta' == $element ) {
                        get_template_part( 'template-parts/post/meta' );
                    }

                    if( 'social_share' == $element ) { ?>
                        <div class="social-share">
							<span class="techt-share-title"><?php echo esc_html__('Share Content', 'petrona') ?></span>
							<?php techt_social_share_link() ?>
						</div>
                    <?php }

                if($index == (count($elements) - 1)){?>
                    </div><!-- /post-content -->
                <?php }
                
            } ?>
            </div><!--  /.grid-layout -->
        </article><!--  /.post -->
    </div><!--  /.col-lg-6 -->         
<?php }