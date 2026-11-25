<?php
/**
 * Register Location for elementor pro.
 *
 * @package Petrona
 * @since 1.0
 */
function techt_register_elementor_locations( $elementor_theme_manager ) {
    $elementor_theme_manager->register_all_core_location();
}
// Add support for Elementor Pro locations
add_action( 'elementor/theme/register_locations', 'techt_register_elementor_locations' );

/**
 *  Petrona Return array of the number which represent the layout of the footer.
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_footer_widgets_layout_array' ) ) {
    function techt_footer_widgets_layout_array() {
        $layout = Techt_Utility::theme_options( array('footer_widgets_layout', '[3,6,9]' ) );
        $layout = json_decode( $layout );

        if ( is_array( $layout ) && ! empty( $layout ) ) {
            $spans = array( (int)$layout[0] );

            for ( $i = 0; $i < ( sizeof( $layout ) - 1 ); $i++ ) {
                $spans[] = $layout[$i+1] - $layout[$i];
            }

            $spans[] = 12 - $layout[$i];

            return $spans;
        } else if ( 1 === $layout ) { // single column
            return array( '12' );
        }

        // default: disable footer
        return array();
    }
}

/**
 *  Petrona Filter the dynamic sidebars and alter the BS col classes for the footer widgets
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_footer_widgets_params' ) ) {
    function techt_footer_widgets_params( $params ) {
        static $counter = 0;
        static $first_row = true;
        $footer_widgets_layout_array = techt_footer_widgets_layout_array();

        if ( $params[0]['id'] === 'footer-widgets' ) {
            // 'before_widget' contains %d, see inc/action_widgets_init.php
            $params[0]['before_widget'] = sprintf( $params[0]['before_widget'], $footer_widgets_layout_array[$counter] );

            // first widget in the any non-first row
            if ( false === $first_row && 0 === $counter ) {
                $params[0]['before_widget'] = '<div class="row">' . $params[0]['before_widget'];
            }

            $counter++;
        }

        end( $footer_widgets_layout_array );
        if ( $counter > key( $footer_widgets_layout_array ) ) {
            $counter = 0;
            $first_row = false;
        }

        return $params;
    }
    add_filter( 'dynamic_sidebar_params', 'techt_footer_widgets_params', 9, 1 );
}

/**
 *  Add Support For Elementor Header/Footer
 *
 * @package Petrona
 * @since 1.0
 */
if( Techt_Utility::theme_options('header_type') == 'custom_header' ){ 
    function techt_header_builder_style() {
        $techt_stheader_template = Techt_Utility::theme_options( 'header_templates' );
        $css_file = null;
        if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
            $css_file = new \Elementor\Core\Files\CSS\Post( $techt_stheader_template );
        } elseif ( class_exists( '\Elementor\Post_CSS_File' ) ) {
            $css_file = new \Elementor\Post_CSS_File( $techt_stheader_template );
        }
        if(! is_null($css_file) ){
            $css_file->enqueue();
        }
        
    }
    add_action('wp_enqueue_scripts', 'techt_header_builder_style');
}

/**
 * Return correct schema markup
 *
 * @since 1.0
 */
if ( ! function_exists( 'techt_get_schema_markup' ) ) {

    function techt_get_schema_markup( $location ) {

        // Return if disable
        if ( Techt_Utility::theme_options( 'schema_markup' ) !== true  ) {
            return null;
        }

        // Default
        $schema = $itemprop = $itemtype = '';

        // HTML
        if ( 'html' == $location ) {
            $schema = 'itemscope itemtype="http://schema.org/WebPage"';
        }

        // Header
        elseif ( 'header' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="http://schema.org/WPHeader"';
        }

        // Logo
        elseif ( 'logo' == $location ) {
            $schema = 'itemscope itemtype="http://schema.org/Brand"';
        }

        // Navigation
        elseif ( 'site_navigation' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"';
        }

        // Main
        elseif ( 'main' == $location ) {
            $itemtype = 'http://schema.org/WebPageElement';
            $itemprop = 'mainContentOfPage';
            if ( is_singular( 'post' ) ) {
                $itemprop = '';
                $itemtype = 'http://schema.org/Blog';
            } 

            $schema = 'itemscope itemprop="'. $itemprop .'" itemtype="'. $itemtype .'"';          
        }        
        
        // Creative Works
        elseif ( 'portfolio' == $location ) {
            $schema = 'itemtype="http://schema.org/CreativeWork"';
        }

        // Sidebar
        elseif ( 'sidebar' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="http://schema.org/WPSideBar"';
        }

        // Footer widgets
        elseif ( 'footer' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="http://schema.org/WPFooter"';
        }

        // Headings
        elseif ( 'headline' == $location ) {
            $schema = 'itemprop="headline"';
        }

        // Author name
        elseif ( 'name' == $location ) {
            $schema = 'itemprop="name"';
        }

        // Posts
        elseif ( 'entry_content' == $location ) {
            $schema = 'itemprop="text"';
        }

        // Publish date
        elseif ( 'publish_date' == $location ) {
            $schema = 'itemprop="datePublished"';
        }

        // Author name
        elseif ( 'author_name' == $location ) {
            $schema = 'itemprop="name"';
        }

        // Author link
        elseif ( 'author_link' == $location ) {
            $schema = 'itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person"';
        }

        // Item
        elseif ( 'item' == $location ) {
            $schema = 'itemprop="item"';
        }

        // Url
        elseif ( 'url' == $location ) {
            $schema = 'itemprop="url"';
        }

        // Position
        elseif ( 'position' == $location ) {
            $schema = 'itemprop="position"';
        }

        // Image
        elseif ( 'image' == $location ) {
            $schema = 'itemprop="image"';
        }

        return ' ' . apply_filters( 'techt_schema_markup', $schema );

    }

} 

/**
 * Outputs correct schema markup
 *
 * @since 1.0
 */
if ( ! function_exists( 'techt_schema_markup' ) ) {

    function techt_schema_markup( $location ) {
        echo techt_get_schema_markup( $location );
    }

}

if ( ! function_exists( 'techt_post_columns_functions' ) ) :
function techt_post_columns_functions( $post_meta, $theme_option, $sidebar_id  ) {
    $right = 'order-lg-first';
    $left = 'order-lg-last';
    if( Techt_Utility::meta_options('sidebar_status') == 'sticky' || Techt_Utility::theme_options('sidebar_status') == 'sticky' ) {
        $sidebar_sticky = 'sticky-content';
    } else {
        $sidebar_sticky = '';
    }
    if( Techt_Utility::meta_options($post_meta) ) {
        $sidebar_position = Techt_Utility::meta_options($post_meta);
        if ( $sidebar_position == 'full' ) {
            $post_columns_class = Techt_Utility::theme_options(['blog_single_content_width_status', 'wide']) == 'wide' ? 'col-lg-12 full-content' : 'col-lg-9 full-content';
            $sidebar_columns_class = '';
        } elseif ( $sidebar_position == 'left' ) {
            $post_columns_class = sprintf('col-lg-9 %s layout-content', $right);
            $sidebar_columns_class = sprintf('col-lg-3 %1$s layout-sidebar %2$s', $left, $sidebar_sticky);
        } else {
            $post_columns_class = sprintf('col-lg-9 %s layout-content', $left);
            $sidebar_columns_class = sprintf('col-lg-3 %1$s layout-sidebar %2$s', $right, $sidebar_sticky);
        }
    } else {
        if ( !is_active_sidebar( $sidebar_id ) ) { 
            $post_columns_class = Techt_Utility::theme_options(['blog_single_content_width_status', 'wide']) == 'wide' ? 'col-lg-12 full-content' : 'col-lg-9 full-content';
            $sidebar_columns_class = '';
            $sidebar_position = 'full';
        } else {                
            $sidebar_position = Techt_Utility::theme_options([$theme_option, 'left']);
            if ( $sidebar_position == 'full' ) {
                $post_columns_class = Techt_Utility::theme_options(['blog_single_content_width_status', 'wide']) == 'wide' ? 'col-lg-12 full-content' : 'col-lg-9 full-content';
                $sidebar_columns_class = '';
            } elseif ( $sidebar_position == 'left' ) {
                $post_columns_class = sprintf('col-lg-9 %s layout-content', $right);
                $sidebar_columns_class = sprintf('col-lg-3 %1$s layout-sidebar %2$s', $left, $sidebar_sticky);
            } else {
                $post_columns_class = sprintf('col-lg-9 %s layout-content', $left);
                $sidebar_columns_class = sprintf('col-lg-3 %1$s layout-sidebar %2$s', $right, $sidebar_sticky);
            }
        }
    }

    return array( 
        "sidebar_position"     => $sidebar_position,
        "content_col_classes"  => $post_columns_class, 
        "sidebar_col_classes"  => $sidebar_columns_class
    );
}
endif;


/**
 * Returns Blog Entries elements for the customizer
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_blog_entries_elements' ) ) {

    function techt_blog_entries_elements() {
        // Default elements
        $elements = apply_filters( 'techt_blog_entries_positions', array(
            'featured_image'    => esc_html__( 'Featured Image', 'petrona' ),
            'category'   => esc_html__( 'Categories', 'petrona' ),
            'title' => esc_html__( 'Title', 'petrona' ),
            'content'  => esc_html__( 'Content', 'petrona' ),
            'post_meta' => esc_html__( 'Post Meta', 'petrona' ),
        ) );

        // Return elements
        return $elements;
    }
}

if ( ! function_exists( 'techt_blog_single_entries_elements' ) ) {

    function techt_blog_single_entries_elements() {
        // Default elements
        $elements = apply_filters( 'techt_blog_single_entries_positions', array(
            'category'   => esc_html__( 'Categories', 'petrona' ),
            'title' => esc_html__( 'Title', 'petrona' ),
            'post_meta' => esc_html__( 'Meta', 'petrona' ),
            'featured_image'    => esc_html__( 'Featured Image', 'petrona' ),
            'content'  => esc_html__( 'Content', 'petrona' ),
            'tag' => esc_html__( 'Tags', 'petrona' ),
            'social_share' => esc_html__( 'Share', 'petrona' ),
        ) );

        // Return elements
        return $elements;
    }
}

if ( ! function_exists( 'techt_blog_single_sections_elements' ) ) {

    function techt_blog_single_sections_elements() {
        // Default elements
        $elements = apply_filters( 'techt_blog_single_sections_positions', array(
            'blog_content' => esc_html__( 'Content', 'petrona' ),
            'related_posts'   => esc_html_x( 'Related Posts', 'Customizer Single Blog Options', 'petrona' ),
            'comments'    => esc_html__( 'Comments', 'petrona' ),
            'post_pagination'  => esc_html__( 'Post Navigation', 'petrona' ),
        ) );

        // Return elements
        return $elements;
    }
}


/**
 * Returns blog entry elements positioning
 *
 * @since 1.0
 */
if ( ! function_exists( 'techt_blog_entries_positioning' ) ) {

    function techt_blog_entries_positioning() {
        
        $sections = array( 'featured_image', 'category', 'title', 'content', 'post_meta'  );

        // Get sections from Customizer
        $sections = Techt_Utility::theme_options( array('blog_enries_content', $sections) );

        // Turn into array if string
        if ( $sections && ! is_array( $sections ) ) {
            $sections = explode( ',', $sections );
        }

        // Apply filters for easy modification
        $sections = apply_filters( 'techt_blog_entries_positions', $sections );

        // Return sections
        return $sections;

    }
}

/**
 * Returns blog single elements positioning
 *
 * @since 1.0
 */
if ( ! function_exists( 'techt_single_blog_positioning' ) ) {

    function techt_single_blog_positioning() {
        // Default sections
        $sections = array( 'featured_image', 'category', 'title', 'post_meta', 'content', 'tag'  );

        // Get sections from Customizer
        $sections = Techt_Utility::theme_options( array('blog_single_enries_content', $sections) );

        // Turn into array if string
        if ( $sections && ! is_array( $sections ) ) {
            $sections = explode( ',', $sections );
        }

        // Apply filters for easy modification
        $sections = apply_filters( 'techt_blog_single_elements_positions', $sections );

        // Return sections
        return $sections;

    }

}
if ( ! function_exists( 'techt_single_blog_sections_positioning' ) ) {

    function techt_single_blog_sections_positioning() {
        // Default sections
        $sections = array( 'blog_content', 'related_posts', 'comments', 'post_pagination'  );

        // Get sections from Customizer
        $sections = Techt_Utility::theme_options( array('blog_single_sections_content', $sections) );

        // Turn into array if string
        if ( $sections && ! is_array( $sections ) ) {
            $sections = explode( ',', $sections );
        }

        // Apply filters for easy modification
        $sections = apply_filters( 'techt_blog_single_sections_elements', $sections );

        // Return sections
        return $sections;

    }

}

if ( ! function_exists( 'techt_theme_load_more_post' ) ) {
    function techt_theme_load_more_post() {
        ob_start(); ?>
            <div class="text-center posts-loadmore">
                <?php echo get_next_posts_link(esc_html__('Load More', 'petrona')); ?>
            </div>
        <?php return ob_get_clean();                               
    } // end techt_theme_load_more_post
}

function techt_theme_counter_inside_function() {
    static $counter = 0;
    ++$counter;
    return $counter;
}

/**
 * Preloader
 * @package Petrona
 */
if ( ! function_exists( 'techt_preloader' ) ) :
    function techt_preloader() {
        if (is_elementor_editor()){
            return;
        }
        if( Techt_Utility::theme_options('preloader') == true ) { ?>
            <?php if( Techt_Utility::theme_options('preloader_type') == 'custom_preloader' && Techt_Utility::theme_options('preloader_templates') !== 'default' ) { ?>
            <div class="preloader">
                <div class="preloader-inner">
                <?php
                    $get_custom_preloader = Techt_Utility::theme_options('preloader_templates');
                    $args = array( 'post_type' => 'petrona_templates', 'p' => $get_custom_preloader );
                    $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            the_content();
                        endwhile;
                    wp_reset_postdata();
                ?>
                </div>
            </div><!--  /.techt-custom-header -->
            <?php } else { ?>
            <!-- <div class="preloader"> -->
                <!-- <div class="preloader-inner"> -->
                    <!-- <svg xmlns:svg="http://www.w3.org/2000/svg" viewbox="0 0 100 100" id="preLoader" width="200px" height="200px"> -->
                        <!-- <path style="stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter" d="m 58.26475,43.628481 15.7247,-27.287018 -31.4936,0.02553 z" id="T1"/> -->
                        <!-- <path style="stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter" d="m 58.26475,43.628481 31.4936,-0.02553 -15.7689,-27.261492 z" id="T2"/> -->
                        <!-- <path style="stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter" d="M 58.26475,43.628481 74.03365,70.88997 89.75835,43.602954 Z" id="T3"/> -->
                        <!-- <path style="stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter" d="M 58.26475,43.628481 42.54006,70.915503 74.03365,70.889973 Z" id="T4"/> -->
                        <!-- <path style="stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter" d="m 58.26475,43.628481 -31.49359,0.02553 15.7689,27.261491 z" id="T5"/> -->
                        <!-- <path style="stroke-width:0.26458332px;stroke-linecap:butt;stroke-linejoin:miter" d="M 58.26475,43.628481 42.49585,16.366995 26.77116,43.654011 Z" id="T6"/> -->
                    <!-- </svg> -->
                <!-- </div> --><!-- /preloader-inner -->
            <!-- </div> --><!-- /preloader -->
            <div class="preloader">
                <div class="preloader-inner">
                    <div class="inner one"></div>
                    <div class="inner two"></div>
                    <div class="inner three"></div>
                    <div class="inner logo">
                        <?php
                            // $custom_logo_id = get_theme_mod( 'custom_logo' );
                            // $image = wp_get_attachment_image( $custom_logo_id , 'full' );
                            // echo $image;
                            $favicon_url = get_site_icon_url();
                            if(! empty($favicon_url)){
                                ?>
                                <img src="<?php echo $favicon_url; ?>">
                                <?php
                            }
                            // echo $image;
                        ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php }
    }
endif;

/**
 * Menu Type
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_menu_type' ) ) :
    function techt_menu_type() {
        $meta = Techt_Utility::meta_options('menu_type');
        if( $meta && 'default' !== $meta ) {
            return $meta;
        }
        if ( Techt_Utility::theme_options(array('header_menu_types', 'normal_menu')) == 'normal_menu' ) {
            $menu = 'normal';
        } else {
            $menu = 'hamburger';
        }

        return apply_filters( 'techt_header_menu_type', $menu );
    }
endif;

/**
 * Header Search Switch
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_search' ) ) :
    function techt_header_search() {
        $meta = Techt_Utility::meta_options('enable_search');
        if( $meta && 'default' !== $meta ) {
            return $meta;
        }
        if ( Techt_Utility::theme_options('enable_search') == true ) {
            $search_visibility = 'yes';
        } else {
            $search_visibility = 'no';
        }

        return apply_filters( 'techt_header_search', $search_visibility );
    }
endif;

/**
 * Header Off Canvas widget
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_off_canvus_widget' ) ) :
    function techt_header_off_canvus_widget() {
        $meta = Techt_Utility::meta_options('enable_offcanvus_widget');
        if( $meta && 'default' !== $meta && Techt_Utility::meta_options('menu_type') !== 'hamburger' ) {
            return $meta;
        }
        if (  Techt_Utility::theme_options('header_menu_types') !== 'hamburger_menus' && Techt_Utility::theme_options('enable_hamburger') == true ) {
            $widget_visivility = 'yes';
        } else {
            $widget_visivility = 'no';
        }

        return apply_filters( 'techt_header_off_canvus_widget', $widget_visivility );
    }
endif;

/**
 *  Header Cart Widget
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_shop_cart' ) ) :
    function techt_header_shop_cart() {
        $meta = Techt_Utility::meta_options('enable_shoping_cart');
        if( $meta && 'default' !== $meta ) {
            return $meta;
        }
        if ( Techt_Utility::theme_options('enable_shop_cart') == true ) {
            $cart_display = 'yes';
        } else {
            $cart_display = 'no';
        }

        return apply_filters( 'techt_header_shop_cart', $cart_display );
    }
endif;

/**
 * Header Transparent
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_transparent' ) ) :
    function techt_header_transparent() {
        $meta = Techt_Utility::meta_options('transparent_header');
        if( $meta ) {
            return $meta;
        }
        if ( Techt_Utility::theme_options('transparent_header') == true ) {
            $header_transparent = 'yes';
        } else {
            $header_transparent = 'no';
        }
        return apply_filters( 'techt_header_transparent', $header_transparent );
    }
endif;

/**
 * Header Width
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_width' ) ) :
    function techt_header_width() {
        $meta = Techt_Utility::meta_options('full_width_header');
        if( $meta && 'yes' == $meta ) {
            return $meta;
        }

        $theme_header = Techt_Utility::theme_options('header_full_width');
        if ( !class_exists('Techt_Core') || ( $theme_header && $theme_header == true ) ) {
            $header_width = 'yes';
        } else {
            $header_width = 'no';
        }

        return apply_filters( 'techt_header_width', $header_width );
    }
endif;

/**
 * Header Sticky
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_sticky' ) ) :
    function techt_header_sticky() {
        $meta = Techt_Utility::meta_options('enable_sticky_header');
        if( $meta ) {
            return $meta;
        }

        if ( Techt_Utility::theme_options('enable_sticky_headers') == true ) {
            $header_sticky = 'yes';
        } else {
            $header_sticky = 'no';
        }

        return apply_filters( 'techt_header_sticky', $header_sticky );
    }
endif;

/**
 * Breadcrumb
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_enable_breadcrumb' ) ) :
    function techt_enable_breadcrumb() {
        $meta = Techt_Utility::meta_options('enable_breadcrumb');
        if( $meta && 'default' !== $meta ) {
            return $meta;
        }

        if ( Techt_Utility::theme_options(array('enable_breadcrumb', true)) == true ) {
            $breadcrumb = 'yes';
        } else {
            $breadcrumb = 'no';
        }

        return apply_filters( 'techt_enable_breadcrumb', $breadcrumb );
    }
endif;

/**
 * Fixed footer Switch
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_fixed_footer' ) ) :
    function techt_fixed_footer() {
        $meta = Techt_Utility::meta_options('fixed_footer');
        if( $meta ) {
            return $meta;
        }
        if ( Techt_Utility::theme_options('fixed_footer') == true ) {
            $fixed_footer = 'yes';
        } else {
            $fixed_footer = 'no';
        }

        return apply_filters( 'techt_fixed_footer', $fixed_footer );
    }
endif;

/**
 * Header Template
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_header_template_id' ) ) :
    function techt_header_template_id() {

        $meta = Techt_Utility::meta_options('header_template');
        if( $meta ) {
            return $meta;
        }

        if ( Techt_Utility::theme_options('header_templates') !== '' ) {
            $get_custom_headers = Techt_Utility::theme_options('header_templates');
        } 

        return apply_filters( 'techt_header_template_id', $get_custom_headers );
    }
endif;

/**
 * Sticky Header Template
 * 
 * @package Petrona
 * @since 1.0
*/
if ( ! function_exists( 'techt_sticky_header_template_id' ) ) :
    function techt_sticky_header_template_id() {

        $meta = Techt_Utility::meta_options('header_sticky_template');
        if( $meta ) {
            return $meta;
        }

        if ( Techt_Utility::theme_options('header_sticky_templates') !== '' ) {
            $get_custom_sticky_headers = Techt_Utility::theme_options('header_sticky_templates');
        } 

        return apply_filters( 'techt_sticky_header_template_id', $get_custom_sticky_headers );
    }
endif;
/**
 * Footer Template
 *
 * @package Petrona
 * @since 1.0
 */
if ( ! function_exists( 'techt_footer_template_id' ) ) :
    function techt_footer_template_id() {

        $meta = Techt_Utility::meta_options('footer_template');
        if( $meta ) {
            return $meta;
        }

        if ( Techt_Utility::theme_options('footer_templates') !== '' ) {
            $get_custom_footers = Techt_Utility::theme_options('footer_templates');
        } 

        return apply_filters( 'techt_footer_template_id', $get_custom_footers );
    }
endif;

/**
 * Header Locations
 *
 * @package Petrona
 * @since 1.0
 */
function techt_header_locations() {
    Techt_Utility::template_part('header');
}

add_action('techt_header_template', 'techt_header_locations');

/**
 * Footer Locations
 *
 * @package Petrona
 * @since 1.0
 */
function techt_footer_locations() {
    Techt_Utility::template_part('footer');
}
add_action('techt_footer_template_locator', 'techt_footer_locations');

/**
 * Single Post Template
 *
 * @package Petrona
 * @since 1.0
 */
function techt_single_post_locations() {
    Techt_Utility::template_part('single');
}
add_action('techt_single_posts_template', 'techt_single_post_locations');

/**
 * Archive Template
 *
 * @package Petrona
 * @since 1.0
 */
function techt_archive_post_locations() {
    get_template_part( 'template-parts/blog-parts/blog-home' );
}
add_action('techt_archive_template', 'techt_archive_post_locations');


/**
 *  Register Theme Location
 *
 * @package Petrona
 * @since 1.0
 */
if( class_exists( 'ElementorPro\Plugin' ) ) {
    function techt_elementor_locations( $elementor_theme_manager ) {
        $elementor_theme_manager->register_location(
            'header',
            [
                'hook' => 'techt_header_template',
                'remove_hooks' => [ 'techt_header_locations' ],
            ]
        );
        $elementor_theme_manager->register_location(
            'footer',
            [
                'hook' => 'techt_footer_template_locator',
                'remove_hooks' => [ 'techt_footer_locations' ],
            ]
        );       
        $elementor_theme_manager->register_location(
            'single',
            [
                'hook' => 'techt_single_posts_template',
                'remove_hooks' => [ 'techt_single_post_locations' ],
            ]
        );        
        $elementor_theme_manager->register_location(
            'archive',
            [
                'hook' => 'techt_archive_template',
                'remove_hooks' => [ 'techt_archive_post_locations' ],
            ]
        );
    }

    add_action( 'elementor/theme/register_locations', 'techt_elementor_locations' );
}

/**
 *  Get Portfolio Details
 *
 * @package Petrona
 * @since 1.0
 */

function techt_get_portfolio_general_details() {
    $details = array(
        'status',
        'year',
        'location',
        'client',
    );
    $result = array();
    foreach ($details as $detail) {
        $meta = get_post_meta( get_the_ID(), 'petrona_portfolio_'.$detail, true);
        if($meta){
            $result[$detail] = $meta;
        }
    }
    return $result;
}

function is_elementor_editor() {
    if (class_exists('\\Elementor\\Plugin')) {
        $elementor = \Elementor\Plugin::instance();
        if ($elementor->editor->is_edit_mode() || $elementor->preview->is_preview_mode()) {
            return true;
        }
    }

    return false;
}
