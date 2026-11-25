<?php
/**
* Walker class
*/
// add custom menu fields to menu
// add_filter( 'wp_setup_nav_menu_item', 'techt_add_custom_nav_fields' );

// function techt_add_custom_nav_fields( $menu_item ) {
// 	$menu_item->enable_mega_menu  	= get_post_meta( $menu_item->ID, '_enable_mega_menu', true );
// 	$menu_item->mega_menu_template  = get_post_meta( $menu_item->ID, '_mega_menu_template', true );
// 	$menu_item->mega_menu_width     = get_post_meta( $menu_item->ID, '_mega_menu_width', true );
// 	$menu_item->mega_menu_position  = get_post_meta( $menu_item->ID, 'mega_menu_position', true );
// 	$menu_item->badge               = get_post_meta( $menu_item->ID, '_badge', true );
// 	return $menu_item;
// }

class Techt_Nav_Walker extends Walker_Nav_Menu {

	
	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 1.0.0
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes     = array( 'techt-nav__sub' );
		$classes[]   = 'techt-nav-depth-' . $depth;
		$class_names = join( ' ', $classes );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= "{$n}{$indent}<div $class_names>{$n}";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 1.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$indent  = str_repeat( $t, $depth );
		$output .= "$indent</div>{$n}";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 1.0.0
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'techt-nav__item-' . $item->ID;
		$classes[] = 'techt-nav__item';
		if ( 0 < $depth ) {
			$classes[] = 'techt-nav-item-sub';
		}

		/**
        * Megamenu Options
        */
        $enable_mega_menu = '';
        $mega_menu_template = '';
		$mega_menu_template_id = '';
        $mega_menu_width = '';
        $mega_menu_position = '';
        $badge = '';
        $enable_mega_menu = get_post_meta( $item->ID, '_menu_item_enable_mega_menu', true );
		if ( 1 == $enable_mega_menu ) {
			$mega_menu_template = get_post_meta( $item->ID, '_menu_item_mega_menu_template', true );
			$mega_menu_width = get_post_meta( $item->ID, '_menu_item_mega_menu_width', true );
			$mega_menu_position = get_post_meta( $item->ID, '_menu_item_mega_menu_position', true );
			$badge = get_post_meta( $item->ID, '_menu_item_badge', true );
		
			global $post;
			$mega_menu_template_id = ( !empty($mega_menu_template) ) ? $mega_menu_template : '' ;
			if ( '' != $mega_menu_template_id) {
				if ( class_exists( 'Elementor\Plugin' ) ) {
					$mega_menu_template_id = ( !empty( $mega_menu_template ) ) ? $mega_menu_template : '' ;
					if ( '' != $mega_menu_template_id ) {
						$elementor = \Elementor\Plugin::instance();
						$mega_menu_content = $elementor->frontend->get_builder_content_for_display( $mega_menu_template_id );
					}
				}
			}
			
			// Load Width Class
			if ( $mega_menu_width == '2' ){
				$mega_menu_width_class = 'grid-item-2';
			} elseif ( $mega_menu_width == '3' ){
				$mega_menu_width_class = 'grid-item-3';
			} elseif ( $mega_menu_width == '4' ){
				$mega_menu_width_class = 'grid-item-4';
			} else {
				$mega_menu_width_class = 'grid-item-full';
			}

			// Load post types
			$post_type_class = 'rbt-post-type-' . get_post_type( get_the_ID() );

			
			// $classes[] = 'menu-item-' . $item->ID;


			// Mega menu class
			if ( '' != $mega_menu_template_id ) {
				$mega_parent_class = 'with-megamenu position-static menu-item-open';
				$classes[] = $mega_parent_class;
				$classes[] = $mega_menu_width_class;
				$classes[] = $mega_menu_position;
				$classes[] = $post_type_class;
			}
		}
		
		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 1.0
		 *
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param WP_Post  $item  Menu item data object.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		$class_names = join( ' ', array_filter( $classes ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$output .= $indent . '<div' . $class_names .'>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		$atts['class']  = 'menu-item-link menu-item-link-depth-' . $depth;

		if ( 0 === $depth ) {
			$atts['class'] .= ' menu-item-link-top';
		} else {
			$atts['class'] .= ' menu-item-link-sub';
		}

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 1.0
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'techt_nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';

		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$desc  = '';

		$show_desc = isset( $args->widget_settings['show_items_desc'] ) ? filter_var( $args->widget_settings['show_items_desc'], FILTER_VALIDATE_BOOLEAN ) : true;

		if ( ! empty( $item->description ) && $show_desc ) {
			$desc = sprintf(
				'<span class="techt-nav-item-desc %2$s">%1$s</span>',
				$item->description,
				( 0 === $depth ) ? 'top-level-desc'  : 'sub-level-desc'
			);
		}

		$title = sprintf( '<span class="techt-nav-link-text">%s%s</span>', $title, $desc );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 1.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';

		if ( (in_array( 'menu-item-has-children', $item->classes )) || ('' != $mega_menu_template_id && 1 == $enable_mega_menu) ) {
			$arrow_icon = isset( $args->widget_settings['dropdown_icon'] ) ? $args->widget_settings['dropdown_icon'] : 'fa fa-angle-down';

			if ( $arrow_icon ) {
				$title = $title . $this->get_dropdown_arrow_html( $arrow_icon );
			}
		}

		$item_output .= $args->link_before . $title . $args->link_after;

		if (!empty($badge)){
			$item_output .= '<span class="rbt-badge-card"> '. $badge .' </span>';
		}
		$item_output .= '</a>';
		// Mega menu
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			if (! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				if ( '' != $mega_menu_template_id && 1 == $enable_mega_menu ) {
					$item_output .= '<div class="rbt-megamenu '. $mega_menu_width_class .'"><div class="wrapper pd-0">'. $mega_menu_content .'</div></div>';
				}
			}
		}

		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 1.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Render Icon HTML
	 *
	 * @param  string $icon Icon slug to render.
	 * @return string
	 */
	public function get_dropdown_arrow_html( $icon = '' ) {

		$format = apply_filters(
			'techt-elements/nav-menu/dropdown-arrow-format',
			'<i class="techt-nav-arrow %s"></i>',
			$icon
		);

		return sprintf( $format, esc_attr( $icon ) );
	}

	public function get_indicator_html( $icon = '' ) {

		$format = apply_filters(
			'techt-elements/nav-menu/nav-indicator-format',
			'<div class="techt-nav-indicator %s"></div>',
			$icon
		);

		return sprintf( $format, esc_attr( $icon ) );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 1.0.0
	 *
	 * @see Walker::end_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$output .= "</div>{$n}";
	}

}
