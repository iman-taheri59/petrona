<?php

class Techt_Core_Utility {

	public static function get_val_from_array( $mixed, $idx = 0 ) {
	    if ( is_array( $mixed ) ) {
	        if ( isset($mixed[$idx] ) ) 
	            return $mixed[$idx];
	        else
	            return "";
	    }
	    else {
	        return "";
	    }
	}

	/**
	 *  Get All Post Type
	 *
	 * @package Petrona
	 * @since 1.0
	 */
	public static function get_post_type() {

	    $post_types = get_post_types(array('public' => true), 'objects');

	    $options = ['' => ''];

	    foreach ($post_types as $post_type) {
	        $options[$post_type->name] = $post_type->label;
	    }

	    return apply_filters('post_type_options', $options);
	}

	/**
	 *  Action to handle searching taxonomy terms.
	 *
	 * @package Petrona
	 * @since 1.0
	 */
	public static function get_taxonomy() {

	    global $wpdb;

	    $results = array();

	    foreach ($wpdb->get_results("
	        SELECT terms.slug AS 'slug', terms.name AS 'label', termtaxonomy.taxonomy AS 'type'
	        FROM $wpdb->terms AS terms
	        JOIN $wpdb->term_taxonomy AS termtaxonomy ON terms.term_id = termtaxonomy.term_id
	        LIMIT 500
	    ") as $result) {
	        $results[$result->type . ':' . $result->slug] = $result->type . ':' . $result->label;
	    }

	    return apply_filters('taxonomy_options', $results);
	}

	/**
	 *  Query Arguments
	 *
	 * @package Petrona
	 * @since 1.0
	 */
	public static function query_args($settings) {
	    $query_args = [
	        'orderby' => $settings['orderby'],
	        'order' => $settings['order'],
	        'ignore_sticky_posts' => 1,
	        'post_status' => 'publish',
	    ];

	    if (!empty($settings['post_types'])) {
	        $query_args['post_type'] = $settings['post_types'];
	    }

	    if (!empty($settings['post_in'])) {
	        $query_args['post__in'] = explode(',', $settings['post_in']);
	        $query_args['post__in'] = array_map('intval', $query_args['post__in']);
	    } else {
	        if (!empty($settings['post_types'])) {
	            $query_args['post_type'] = $settings['post_types'];
	        }

	        if (!empty($settings['tax_query'])) {
	            $tax_queries = $settings['tax_query'];

	            $query_args['tax_query'] = array();
	            $query_args['tax_query']['relation'] = 'OR';
	            foreach ($tax_queries as $tq) {
	                list($tax, $term) = explode(':', $tq);
	                if (empty($tax) || empty($term))
	                    continue;
	                $query_args['tax_query'][] = array(
	                    'taxonomy' => $tax,
	                    'field' => 'slug',
	                    'terms' => $term
	                );
	            }
	        }
	    }

	    $query_args['posts_per_page'] = $settings['number'];

	    $query_args['paged'] = max(1, get_query_var('paged'), get_query_var('page'));

	    return apply_filters('posts_query_args', $query_args, $settings);
	}

	/**
	 *  Pagination
	 *
	 * @package Petrona
	 * @since 1.0
	 */
	public static function pagination( $query, $settings ) {
		$query = $query ? $query : null;
	    $big        = 999999999;
	    $translated = esc_html__( 'Page', 'petrona' );

	    if( get_query_var('paged') ) {
	        $paged = get_query_var('paged');
	    } elseif( get_query_var('page') ) {
	        $paged = get_query_var('page');
	    } else { 
	        $paged = 1; 
	    }

	    if( $settings['pagination_types'] == 'pagi_numbers' ) {
	        if( $query->max_num_pages > 1 ) {
	            echo '<div class="custom-pagination">';
	                echo paginate_links( array(
	                    'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	                    'format'                => '?paged=%#%',
	                    'current'               => max( 1, $paged ),
	                    'prev_text'       => esc_html__('&laquo;', 'petrona'),
	                    'next_text'       => esc_html__('&raquo;', 'petrona'),
	                    'total'                 => $query->max_num_pages,
	                    'type'                  => 'list',
	                    'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
	                ) );
	            echo '</div>';
	        }
	    } else {    
	        if( $query->max_num_pages > 1 ) {
	        	echo "<button class='btn btn-defult btn-more-works'>". $settings['more_work_btn_text'] ."</button>";
	            echo '<div id="pagination-block-techt" class="pagination-block">';
	                echo paginate_links( array(
	                    'base'                  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	                    'format'                => '?paged=%#%',
	                    'current'               => max( 1, $paged ),
	                    'prev_text'             => '<i class="fa fa-angle-left"></i>',
	                    'next_text'             => '<i class="fa fa-angle-right"></i>',
	                    'total'                 => $query->max_num_pages,
	                    'type'                  => 'list',
	                    'before_page_number'    => '<span class="screen-reader-text">' . $translated . '</span>'
	                ) );
	            echo '</div>';
	        }
	    }
	}

	/**
	 *  Category Post Count
	 *
	 * @package Petrona
	 * @since 1.0
	 */
	public static function category_post_count($id, $settings ) {
	    if( get_query_var('paged') ) {
	        $paged = get_query_var('paged');
	    } elseif( get_query_var('page') ) {
	        $paged = get_query_var('page');
	    } else { 
	        $paged = 1; 
	    }

	    $args = array(
	        'post_type'     => 'portfolio', //post type, I used 'product'
	        'posts_per_page' => $settings['number'],  //show all,
	        'ignore_sticky_posts' => true,
	        'paged' => $paged,
	        'tax_query' => array(
	            array(
	              'taxonomy' => 'portfolio-category',  //taxonomy name  here, I used 'product_cat'
	              'field' => 'slug',
	              'relation' => 'OR',
	              'terms' => array( $id )
	            )
	        )
	    );

	    if( !empty( $settings['post_in'] ) ) {    
	        $args['post__in'] = explode(',', $settings['post_in']);
	        $args['post__in'] = array_map('intval', $args['post__in']);
	    }

	    $query = new WP_Query( $args);

	    return (int) $query->post_count;
	}


	public static function techt_breadcrumbs() {
		/* === OPTIONS === */
		$text['home']     = esc_html__( 'Home', 'petrona' ); // text for the 'Home' link
		$text['category'] = esc_html__('Category %s', 'petrona'); // text for a category page
		$text['search']   = esc_html__('Search Results for "%s" ', 'petrona'); // text for a search results page
		$text['tag']      = esc_html__('Posts Tagged "%s"', 'petrona'); // text for a tag page
		$text['author']   = esc_html__('Articles Posted by %s', 'petrona'); // text for an author page
		$text['404']      = esc_html__('Error 404', 'petrona'); // text for the 404 page
		$text['page']     = esc_html__('Page %s', 'petrona'); // text 'Page N'
		$text['cpage']    = esc_html__('Comment Page %s', 'petrona'); // text 'Comment Page N'
		$wrap_before    = '<div class="techt-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">'; // the opening wrapper tag
		$wrap_after     = '</div><!-- .techt-breadcrumbs -->'; // the closing wrapper tag
		// $sep_icon = is_rtl() ? '<i class="separator-icon fa fa-angle-left"></i>' : '<i class="separator-icon fa fa-angle-right"></i>';
		$sep_icon 		= '<span class="separator-icon">|</span>';
		$sep            = '<span class="breadcrumbs__separator">' . $sep_icon . '</span>'; // separator between crumbs
		$before         = '<span class="breadcrumbs__current">'; // tag before the current crumb
		$after          = '</span>'; // tag after the current crumb
		$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_current   = 1; // 1 - show current page title, 0 - don't show
		$show_last_sep  = 0; // 1 - show last separator, when current page title is not displayed, 0 - don't show
		/* === END OF OPTIONS === */
		global $post;
		$home_url       = home_url('/');
		$link           = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
		$link          .= '<a class="breadcrumbs__link" href="%1$s" itemprop="item"><span itemprop="name">%2$s</span></a>';
		$link          .= '<meta itemprop="position" content="%3$s" />';
		$link          .= '</span>';
		$post_id        = ( $post ) ? $post->ID : '';
		$parent_id      = ( $post ) ? $post->post_parent : '';
		$home_link      = sprintf( $link, $home_url, $text['home'], 1 );
		if ( is_front_page() ) {
			if ( $show_on_home ) echo $wrap_before . $home_link . $wrap_after;
		} elseif( is_home() ){
			echo $wrap_before;
			echo $home_link;
			if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . get_the_title( get_option('page_for_posts', true)) . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			echo $wrap_after;
		} else {
			$position = 0;
			echo $wrap_before;
			if ( $show_home_link ) {
				$position += 1;
				echo $home_link;
			}
			if ( is_category() ) {
				$parents = get_ancestors( get_query_var('cat'), 'category' );
				foreach ( array_reverse( $parents ) as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				if ( get_query_var( 'paged' ) ) {
					$position += 1;
					$cat = get_query_var('cat');
					echo $sep . sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
					echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
				} else {
					if ( $show_current ) {
						if ( $position >= 1 ) echo $sep;
						echo $before . sprintf( $text['category'], single_cat_title( '', false ) ) . $after;
					} elseif ( $show_last_sep ) echo $sep;
				}
			} elseif ( is_search() ) {
				if ( $show_home_link && $show_current || ! $show_current && $show_last_sep ) echo $sep;
				if ( $show_current ) echo $before . sprintf( $text['search'], get_search_query() ) . $after;
			} elseif ( is_year() ) {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . get_the_time('Y') . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			} elseif ( is_month() ) {
				if ( $show_home_link ) echo $sep;
				$position += 1;
				echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position );
				if ( $show_current ) echo $sep . $before . get_the_time('F') . $after;
				elseif ( $show_last_sep ) echo $sep;
			} elseif ( is_day() ) {
				if ( $show_home_link ) echo $sep;
				$position += 1;
				echo sprintf( $link, get_year_link( get_the_time('Y') ), get_the_time('Y'), $position ) . $sep;
				$position += 1;
				echo sprintf( $link, get_month_link( get_the_time('Y'), get_the_time('m') ), get_the_time('F'), $position );
				if ( $show_current ) echo $sep . $before . get_the_time('d') . $after;
				elseif ( $show_last_sep ) echo $sep;
			} elseif ( is_single() && ! is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$position += 1;
					$post_type = get_post_type_object( get_post_type() );
					$title = $post_type->labels->name;
					if ($post_type->name == 'product'){
						if ( class_exists( 'WooCommerce' ) ){
							$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
						} 
					}
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $title, $position );
					
					$taxonomies = get_object_taxonomies( $post_type->name );
					$terms = get_the_terms($post_id, isset($taxonomies[0]));
					if($terms && ! is_wp_error($terms)) {
						$termID = $terms[0]->term_id;
						$parents = get_ancestors( $termID, $taxonomies[0] );
						$parents = array_reverse( $parents );
						$parents[] = $termID;
						foreach ( $parents as $term ) {
							$position += 1;
							if ( $position > 1 ) echo $sep;
							echo sprintf( $link, get_term_link( $term ), get_term($term)->name, $position );
						}
					}	
	
					if ( $show_current) echo $sep . $before . get_the_title() . $after;
					elseif ( $show_last_sep ) echo $sep;
				} else {
					$cat = get_the_category($post_id);
					$catID = $cat[0]->cat_ID;
					$parents = get_ancestors( $catID, 'category' );
					$parents = array_reverse( $parents );
					$parents[] = $catID;
					foreach ( $parents as $cat ) {
						$position += 1;
						if ( $position > 1 ) echo $sep;
						echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
					}
					if ( get_query_var( 'cpage' ) ) {
						$position += 1;
						echo $sep . sprintf( $link, get_permalink(), get_the_title(), $position );
						echo $sep . $before . sprintf( $text['cpage'], get_query_var( 'cpage' ) ) . $after;
					} else {
						$title = trim( get_the_title() );
						if ( $show_current && !empty( $title ) ) echo $sep . $before . get_the_title() . $after;
						elseif ( $show_last_sep ) echo $sep;
					}
				}
			} elseif ( is_post_type_archive() ) {
				$post_type = get_post_type_object( get_post_type() );
				$title = $post_type->label;
				if ($post_type->name == 'product'){
					if ( class_exists( 'WooCommerce' ) ){
						if(is_shop()){
							$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
						}
					} 
				}
				if ( get_query_var( 'paged' ) ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_post_type_archive_link( $post_type->name ), $title, $position );
					echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
				} else {
					if ( $show_home_link && $show_current ) echo $sep;
					if ( $show_current ) echo $before . $title . $after;
					elseif ( $show_home_link && $show_last_sep ) echo $sep;
				}
			} elseif ( is_attachment() ) {
				$parent = get_post( $parent_id );
				$cat = get_the_category( $parent->ID ); $catID = $cat[0]->cat_ID;
				$parents = get_ancestors( $catID, 'category' );
				$parents = array_reverse( $parents );
				$parents[] = $catID;
				foreach ( $parents as $cat ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_category_link( $cat ), get_cat_name( $cat ), $position );
				}
				$position += 1;
				echo $sep . sprintf( $link, get_permalink( $parent ), $parent->post_title, $position );
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} elseif ( is_page() && ! $parent_id ) {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . get_the_title() . $after;
				elseif ( $show_home_link && $show_last_sep ) echo $sep;
			} elseif ( is_page() && $parent_id ) {
				$parents = get_post_ancestors( get_the_ID() );
				foreach ( array_reverse( $parents ) as $pageID ) {
					$position += 1;
					if ( $position > 1 ) echo $sep;
					echo sprintf( $link, get_page_link( $pageID ), get_the_title( $pageID ), $position );
				}
				if ( $show_current ) echo $sep . $before . get_the_title() . $after;
				elseif ( $show_last_sep ) echo $sep;
			} elseif ( is_tag() ) {
				if ( get_query_var( 'paged' ) ) {
					$position += 1;
					$tagID = get_query_var( 'tag_id' );
					echo $sep . sprintf( $link, get_tag_link( $tagID ), single_tag_title( '', false ), $position );
					echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
				} else {
					if ( $show_home_link && $show_current ) echo $sep;
					if ( $show_current ) echo $before . sprintf( $text['tag'], single_tag_title( '', false ) ) . $after;
					elseif ( $show_home_link && $show_last_sep ) echo $sep;
				}
			} elseif ( is_author() ) {
				$author = get_userdata( get_query_var( 'author' ) );
				if ( get_query_var( 'paged' ) ) {
					$position += 1;
					echo $sep . sprintf( $link, get_author_posts_url( $author->ID ), sprintf( $text['author'], $author->display_name ), $position );
					echo $sep . $before . sprintf( $text['page'], get_query_var( 'paged' ) ) . $after;
				} else {
					if ( $show_home_link && $show_current ) echo $sep;
					if ( $show_current ) echo $before . sprintf( $text['author'], $author->display_name ) . $after;
					elseif ( $show_home_link && $show_last_sep ) echo $sep;
				}
			} elseif ( is_404() ) {
				if ( $show_home_link && $show_current ) echo $sep;
				if ( $show_current ) echo $before . $text['404'] . $after;
				elseif ( $show_last_sep ) echo $sep;
			} elseif ( has_post_format() && ! is_singular() ) {
				if ( $show_home_link && $show_current ) echo $sep;
				echo get_post_format_string( get_post_format() );
			}
			echo $wrap_after;
		}
	} 

	public static function prepare_data_prop_settings( &$settings, $field_map = [] ) {
	    $data = [];
	    foreach ( $field_map as $key => $data_key ) {
	        $setting_value = Techt_Core_Utility::get_setting_value( $settings, $key );
	        list( $data_field_key, $data_field_type ) = explode( '.', $data_key );
	        $validator = $data_field_type . 'val';

	        if ( is_callable( $validator ) ) {
	            $val = call_user_func( $validator, $setting_value );
	        } else {
	            $val = $setting_value;
	        }
	        $data[ $data_field_key ] = $val;
	    }
	    return wp_json_encode( $data );
	}

	public static function get_setting_value( &$settings, $keys ) {
	    if ( ! is_array( $keys ) ) {
	        $keys = explode( '.', $keys );
	    }
	    if ( is_array( $settings[ $keys[0] ] ) ) {
	        return Techt_Core_Utility::get_setting_value( $settings[ $keys[0] ], array_slice( $keys, 1 ) );
	    }
	    return $settings[ $keys[0] ];
	}

	/**
	 * Render icon html with backward compatibility
	 *
	 * @param array $settings
	 * @param string $new_icon_id 	 * @param string $new_icon_id
	 * @param array $attributes
	 */
	public static function render_icon( $settings = [], $new_icon_id = 'selected_icon', $attributes = [] ) {
	    $attributes['aria-hidden'] = 'true';

        if ( empty( $attributes['class'] ) ) {
            $attributes['class'] = $settings[ $new_icon_id ];
        } else {
            if ( is_array( $attributes['class'] ) ) {
                $attributes['class'][] = $settings[ $new_icon_id ];
            } else {
                $attributes['class'] .= ' ' . $settings[ $new_icon_id ];
            }
        }
        printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
	}

	public static function is_elementor_page($post_id)
	{
  		if ( Elementor\Plugin::instance()->documents->get($post_id)->is_built_with_elementor() ) {
    		return true;
  		}else{
			return false;
		}
	}	

}
