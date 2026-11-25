<?php 
/**
 *  Remove Unnecessary p and br tag from shortcode
 *
 * @package Petrona
 * @since 1.0
 */
if( !function_exists('techt_fix_shortcodes') ) :
    function techt_fix_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;   
    }
    add_filter('the_content', 'techt_fix_shortcodes');
endif;

/**
 * Social Post Share
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_social_share_link' ) ) :
function techt_social_share_link( $before_text = "" ) { ?>
    <div class="techt-entry-share">
        <?php if($before_text != ""): ?> 
        <span class="techt-share-title"><?php echo $before_text; ?></span>
        <?php endif; ?>
        <a class="techt-social-share-link" rel="nofollow" title="<?php esc_html_e(  'Share on Facebook', 'petrona' ); ?>" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class=" techt-icon-facebook-1"></i></a>
        <a class="techt-social-share-link" rel="nofollow" title="<?php esc_html_e(  'Share on Twitter', 'petrona' ); ?>" href="https://twitter.com/home?status=<?php the_permalink(); ?>" ><i class="techt-icon-x-twitter"></i></a>
        <a class="techt-social-share-link" rel="nofollow" title="<?php esc_html_e(  'Share on GooglePlus', 'petrona' ); ?>" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="techt-icon-google"></i></a>
        <a class="techt-social-share-link" rel="nofollow" title="<?php esc_html_e(  'Share on Linkedin', 'petrona' ); ?>" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>"><i class="techt-icon-linkedin-1"></i></a>
        <a class="techt-social-share-link" rel="nofollow" title="<?php esc_html_e(  'Share on Pinterest', 'petrona' ); ?>" href="http://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"><i class="techt-icon-pinterest-1"></i></a> 
        <!-- <a class="techt-social-share" rel="nofollow" title="<?php esc_html_e(  'Share on Pinterest', 'petrona' ); ?>" href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><i class="techt-icon-pinterest-1"></i></a>  -->
    </div><!-- /.entry-share --> 
    <?php
}
endif;

/**
 *  Remove Query String
 *
 * @package Petrona
 * @since 1.0
 */
function techt_remove_query_string_one( $src ){   
    $rqs = explode( '?ver', $src );
    return $rqs[0];
}
if ( !is_admin() ) { 
    add_filter( 'script_loader_src', 'techt_remove_query_string_one', 15, 1 );
    add_filter( 'style_loader_src', 'techt_remove_query_string_one', 15, 1 );
}

function techt_remove_query_string_two( $src ){
    $rqs = explode( '&ver', $src );
    return $rqs[0];
}
if ( !is_admin() ) { 
    add_filter( 'script_loader_src', 'techt_remove_query_string_two', 15, 1 );
    add_filter( 'style_loader_src', 'techt_remove_query_string_two', 15, 1 );
}

/**
 *  Get Post Views
 *
 * @package Petrona
 * @since 1.0
 */
function techt_get_post_views($postID){
    $count_key = 'techt_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

/**
 *  Set Post Views
 *
 * @package Petrona
 * @since 1.0
 */
function techt_set_post_views($postID) {
    $count_key = 'techt_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/**
 * Custom search function to allow us to
 * search custom post types as well as posts
 */
if ( ! function_exists( 'techt_search_filter' ) ) :
    function techt_custom_post_types( $query ) {
        $custom_post_type = get_query_var( 'post_type' );

        if ( is_archive() ) {
            if ( empty( $custom_post_type ) ) $query->set( 'post_type' , get_post_types() );
        }

        if ( is_search() ) {
            if ( empty( $custom_post_type ) ) {
                $query->set( 'post_type' , array(
                    'post', 'page', 'portfolio'
                    )
                );
            }
        }

        return $query;
    }
    //add_filter( 'pre_get_posts' , 'techt_custom_post_types' );
endif;

/**
 * Enable webp for enhanced performance
 */
if ( ! function_exists( 'techt_webp_upload_mimes' ) ) :
    function techt_webp_upload_mimes( $existing_mimes ) {
        $existing_mimes['webp'] = 'image/webp';
        return $existing_mimes;
    }
    add_filter( 'mime_types', 'techt_webp_upload_mimes' );
endif;

/**
 * Enable SVG Image Uploading
 */
if ( ! function_exists( 'techt_svg_mime_types' ) ) :
    function techt_svg_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter('upload_mimes', 'techt_svg_mime_types');
endif;


/**
 * Check elementor version
 *
 * @param string $version
 * @param string $operator
 * @since 1.0
 * @return bool
 */
function techt_is_elementor_version( $operator = '<', $version = '2.9.0' ) {
    return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 */
if ( ! function_exists( 'techt_remove_wp_block_library_css' ) ) :
    function techt_remove_wp_block_library_css(){
        if( get_post_meta( get_the_ID(), '_elementor_edit_mode') ) { 
            wp_dequeue_style( 'wp-block-library' );
            wp_dequeue_style( 'wp-block-library-theme' );
            wp_dequeue_style( 'wc-block-style' ); 
        } 
    } 
    add_action( 'wp_enqueue_scripts', 'techt_remove_wp_block_library_css', 100 );
endif;

/**
 * Fix WP Color error
 */
if( is_admin() ){
    add_action( 'wp_default_scripts', 'techt_default_custom_scripts' );
    function techt_default_custom_scripts( $scripts ){
        did_action( 'init' ) && $scripts->localize(
            'wp-color-picker',
            'wpColorPickerL10n',
            array(
                'clear'            => __( 'Clear' ),
                'clearAriaLabel'   => __( 'Clear color' ),
                'defaultString'    => __( 'Default' ),
                'defaultAriaLabel' => __( 'Select default color' ),
                'pick'             => __( 'Select Color' ),
                'defaultLabel'     => __( 'Color value' ),
            )
        );
    }
}