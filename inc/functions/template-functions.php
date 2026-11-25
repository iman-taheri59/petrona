<?php
/**
 *  Define All of Utility of the theme
 *
 * @since Petrona 1.0
 *
 * @return Utility
 *
 */
if(!class_exists('Techt_Utility')) {
    class Techt_Utility {
        /**
         *  Get theme options
         *
         * @since Petrona 1.0
         *
         * @return array petrona_options
         *
         */
        public static function theme_options() {
            $result = get_theme_mod('petrona_options');
            foreach (func_get_args() as $arg) {
                if(is_array($arg)) {
                    if (!empty($result[$arg[0]])) {
                        $result = $result[$arg[0]];
                    } else {  
                      $result = $arg[1];
                    }
                } else {
                    if (!empty($result[$arg])) {
                        $result = $result[$arg];
                    } else { 
                        $result = null;
                    }
                }
            }
            return $result;
        }

        /**
         *  Get Meta options
         *
         * @since Petrona 1.0
         *
         * @return array petrona_options
         *
         */
        public static function meta_options() {
            foreach (func_get_args() as $arg) {
                if (!empty($arg)) {
                    if(is_array($arg)){
                        $id = $arg[1];
                        $meta = $arg[0];
                    }else{
                        $id = get_the_ID();
                        $meta = $arg;
                    }
                    $result = get_post_meta( $id, 'petrona_'.$meta, true);
                } else { 
                    $result = null;
                }
            }
            return $result;
        }

        /**
         * Featured Image
         *
         * @return array petrona_options
         *
         */
        public static function featured_image($width = 900, $height = 600, $crop = false, $mobile = true) {
            $image_id = get_post_thumbnail_id( get_the_ID() );
            $type =  get_post_mime_type( $image_id );

            if( $type == 'image/gif' || !function_exists('techt_aq_resize') ) {
                $featured_image = wp_get_attachment_url( get_post_thumbnail_id() );
            } else {
                if ( wp_is_mobile() && $mobile == true ) {
                    $featured_image = techt_aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), 500, 275, $crop);
                }else{
                    $featured_image = techt_aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $width, $height, $crop);
                }
                
            }

            if( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ) {
                $image_alt = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
            } else {
                $image_alt = get_the_title();
            }
            $img_meta = wp_prepare_attachment_for_js( get_post_thumbnail_id() );

            if($img_meta['title'] !== "") {
                $imgtitle = 'title=" '. esc_attr( $img_meta['title'] ) .' "';
            } else {
                $imgtitle = '';
            }
            if( $featured_image == false ) {
                the_post_thumbnail( 'full', array( 'alt' => esc_attr( $image_alt ), 'title' => esc_attr( $img_meta['title'] ) ));
            } else { ?>
                <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" <?php echo wp_kses_post($imgtitle); ?> />
            <?php }
        }

         /**
         * Featured Image url
         *
         * @return array petrona_options
         *
         */
        public static function featured_image_url($width = 900, $height = 600, $crop = false, $mobile = true) {
            $image_id = get_post_thumbnail_id( get_the_ID() );
            $type =  get_post_mime_type( $image_id );

            if( $type == 'image/gif' || !function_exists('techt_aq_resize') ) {
                $featured_image = wp_get_attachment_url( get_post_thumbnail_id() );
            } else {
                if ( wp_is_mobile() && $mobile == true ) {
                    $featured_image = techt_aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), 500, 275, $crop);
                }else{
                    $featured_image = techt_aq_resize( wp_get_attachment_url( get_post_thumbnail_id() ), $width, $height, $crop);
                }
                
            }
         
            if( $featured_image == false ) {
                return get_the_post_thumbnail_url('full');
            } else {
                return esc_url($featured_image);
            }
        }

        /**
         *  Image Crop Size By Image ID
         *
         * @since 1.0
         */
        public static function image_crop_imgid($img_id = false, $width = null, $height = null, $crop = false, $mobile = true) {
            $url = wp_get_attachment_url( $img_id );
            if ( wp_is_mobile() && $mobile == true ) {
                if( function_exists('techt_aq_resize') ) {
                    $crop_image = techt_aq_resize( $url, 500, 275, false ); 
                } else {
                    $crop_images = wp_get_attachment_image_src($img_id);
                    $crop_image = $crop_images[0];
                }
                if( $crop_image == false ) {
                    return $url;
                } else { 
                    return $crop_image;
                }
            } else {
                if( function_exists('techt_aq_resize') ) {
                    $crop_image = techt_aq_resize( $url, $width, $height, $crop ); 
                } else {
                    $crop_images = wp_get_attachment_image_src($img_id, 'full', false);
                    $crop_image = $crop_images[0];
                } 
                if( $crop_image == false ) {
                    return $url;
                } else { 
                    return $crop_image;
                }
            }
        }

        /**
         *  Get Image By Post ID
         *
         * @since 1.0
         */
        public static function image_crop_postid($post_id = false, $width = null, $height = null, $crop = false, $mobile = true) {
            $url = get_the_post_thumbnail_url($post_id, 'full');
            if ( wp_is_mobile() && $mobile == true ) { 
                if( function_exists('techt_aq_resize') ) {
                    $crop_image = techt_aq_resize( $url, 500, 275, false ); 
                } else {
                    $crop_images = wp_get_attachment_image_src( $url );
                    $crop_image = $crop_images[0];
                }
                if( $crop_image == false ) {
                    return $url;
                } else { 
                    return $crop_image;
                }
            } else {
                if( function_exists('techt_aq_resize') ) {
                    $crop_image = techt_aq_resize( $url, $width, $height, $crop ); 
                } else {
                    $crop_images = wp_get_attachment_image_src( $url, 'full', false );
                    $crop_image = $crop_images[0];
                }
                if( $crop_image == false ) {
                    return $url;
                } else { 
                    return $crop_image;
                }
            }
        }

        /**
         * Get Image By URL
         *
         * @package EasyArt
         * @since 1.0
         */
        public static function image_crop_url($url = false, $width = null, $height = null, $crop = false, $mobile = true) {
            if ( wp_is_mobile() && $mobile == true ) {
                if( function_exists('techt_aq_resize') ) {
                    $crop_image = techt_aq_resize( $url, 500, 275, $crop ); 
                } else {
                    $crop_images = wp_get_attachment_image_src( $url );
                    $crop_image = $crop_images[0];
                }
            }else{
                if( function_exists('techt_aq_resize') ) {
                    $crop_image = techt_aq_resize( $url, $width, $height, $crop ); 
                } else {
                    $crop_images = wp_get_attachment_image_src( $url, 'full', true );
                    $crop_image = $crop_images[0];
                }
            }
            
            if( $crop_image == false ) {
                return $url;
            } else { 
                return $crop_image;
            }
        }

        /**
         * Return Page Title
         *
         * @package Petrona
         * @since 1.0
         */
        public static function page_title() {
            $page_ID = get_queried_object_id();
            return get_the_title($page_ID);
        }

        /**
         * Get excerpt
         *
         * @since 1.0
         */
        public static function postexcerpt( $length ) {
            global $post;
            $length = ! is_null($length) ? $length :  0; 

            // Check for custom excerpt
            if ( has_excerpt( $post->ID ) ) {
                if( $length > 0 ){
                    $output = wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length );
                }else{
                    $output = $post->post_excerpt;
                }
                
            }

            // No custom excerpt
            else {
                // Check for more tag and return content if it exists
                if ( strpos( $post->post_content, '<!--more-->' ) ) {
                    $output = apply_filters( 'the_content', get_the_content() );
                } elseif ( strpos( $post->post_content, '<!--nextpage-->' ) ) {
                    $output = apply_filters( 'the_content', get_the_content() );
                } else {
                    if( $length > 0 ){
                        $output = wp_trim_words( strip_shortcodes( $post->post_content ), $length );
                    }else{
                        $output = apply_filters( 'the_content', get_the_content() );
                    }
                }

            }
            return $output;
        }
        /**
         * Reading Time
         *
         * @since 1.0
         */
        public static function reading_time( $content = '', $wpm = 300 ) {
            $clean_content = strip_shortcodes( $content );
            $clean_content = strip_tags( $clean_content );
            $word_count = str_word_count( $clean_content );
            $time = ceil( $word_count / $wpm );
            return $time;
        }

        /**
         * Minify CSS
         *
         * @since 1.0
         */
        public static function minify_css( $css = '' ) {

            // Return if no CSS
            if ( ! $css ) return;

            // Normalize whitespace
            $css = preg_replace( '/\s+/', ' ', $css );

            // Remove ; before }
            $css = preg_replace( '/;(?=\s*})/', '', $css );

            // Remove space after , : ; { } */ >
            $css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );

            // Remove space before , ; { }
            $css = preg_replace( '/ (,|;|\{|})/', '$1', $css );

            // Strips leading 0 on decimal values (converts 0.5px into .5px)
            $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

            // Strips units if value is 0 (converts 0px to 0)
            $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

            // Trim
            $css = trim( $css );

            // Return minified CSS
            return $css;
        }

        /**
         * Exceprt Limit
         *
         * @since 1.0
         */
        public static function excerpt_limit($limit) {
            $excerpt = explode(' ', get_the_excerpt(), $limit);
            if ( count($excerpt) >= $limit ) {
                array_pop($excerpt);
                $excerpt = implode(" ",$excerpt).'...';
            } else {
                $excerpt = implode(" ",$excerpt);
            }
            $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
            return $excerpt;
        }

        /**
         * String to exceprt
         *
         * @since 1.0
         */
        public static function string_to_excerpt($text = "", $limit = null) {
            $excerpt = explode(' ', $text, $limit);
            if ( count($excerpt) >= $limit ) {
                array_pop($excerpt);
                $excerpt = implode(" ",$excerpt).'...';
            } else {
                $excerpt = implode(" ",$excerpt);
            }
            $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
            return $excerpt;
        }

        /**
         * Get Template Part
         *
         * @since 1.0
         */
        public static function template_part($part_name = "") {
            $part_style_url = (isset($_GET["{$part_name}_style"])) ? sanitize_text_field( wp_unslash( $_GET["{$part_name}_style"] ) ) : '';
            switch($part_style_url) { 
                case 'one': 
                case 'two': 
                    $part_style = $part_style_url; break;
                default: $part_style = "one"; break;
            }  
            return get_template_part( "template-parts/$part_name/$part_style" );
        }

    }
}
