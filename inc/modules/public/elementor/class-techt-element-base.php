<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

abstract class Techt_Base extends Widget_Base {

    public $_processed_item   = false;
    public $_context          = 'render';
	public $_new_icon_prefix  = 'selected_';
	public $_processed_index  = 0;
	private static $instance;
   
    /**
	 * Open standard wrapper
	 *
	 * @return void
	 */
	public function _open_wrap() {
		printf( '<div class="elementor-%s techt-element">', $this->get_name() );
	}

    /**
	 * Close standard wrapper
	 *
	 * @return void
	 */
	public function _close_wrap() {
		echo '</div>';
	}

	public function _swiper_container_class(){
		$swiper_class =  'swiper';
		return $swiper_class;
	}

	/**
	 * Check if Elementor experimental feature is active.
	 *
	 * @param string $feature Feature slug.
	 * @return boolean
	 * @since 1.0
	 */
	public static function is_feature_active( $feature = '' ) {
		$is_active = false;

		if ( '' !== $feature && \Elementor\Plugin::$instance->experiments->is_feature_active( $feature ) ) {
			$is_active = true;
		}

		return $is_active;
	}

    /**
	 * Print HTML markup if passed setting not empty.
	 *
	 * @param  string $setting Passed setting.
	 * @param  string $format  Required markup.
	 * @param  array  $args    Additional variables to pass into format string.
	 * @param  bool   $echo    Echo or return.
	 * @return string|void
	 */
	public function _html( $setting = null, $format = '%s' ) {

		call_user_func( array( $this, sprintf( '_%s_html', $this->_context ) ), $setting, $format );

	}

	/**
	 * Returns HTML markup if passed setting not empty.
	 *
	 * @param  string $setting Passed setting.
	 * @param  string $format  Required markup.
	 * @param  array  $args    Additional variables to pass into format string.
	 * @param  bool   $echo    Echo or return.
	 * @return string|void
	 */
	public function _get_html( $setting = null, $format = '%s' ) {

		ob_start();
		$this->_html( $setting, $format );
		return ob_get_clean();

	}

    /**
	 * Print HTML template
	 *
	 * @param  [type] $setting [description]
	 * @param  [type] $format  [description]
	 * @return [type]          [description]
	 */
	public function _render_html( $setting = null, $format = '%s' ) {

		if ( is_array( $setting ) ) {
			$key     = $setting[1];
			$setting = $setting[0];
		}

		$val = $this->get_settings_for_display( $setting );

		if ( ! is_array( $val ) && '0' === $val ) {
			printf( $format, $val );
		}

		if ( is_array( $val ) && empty( $val[ $key ] ) ) {
			return '';
		}

		if ( ! is_array( $val ) && empty( $val ) ) {
			return '';
		}

		if ( is_array( $val ) ) {
			printf( $format, $val[ $key ] );
		} else {
			printf( $format, $val );
		}

	}
   
    /**
	 * Include global template if any of passed settings is defined
	 *
	 * @param  [type] $name     [description]
	 * @param  [type] $settings [description]
	 * @return [type]           [description]
	 */
	public function _glob_inc_if( $name = null, $settings = array() ) {

		$template = $this->get_widget_template( $name );

		call_user_func( array( $this, sprintf( '_%s_inc_if', $this->_context ) ), $template, $settings );

	}

	/**
	 * Include render template if any of passed setting is not empty
	 *
	 * @param  [type] $file     [description]
	 * @param  [type] $settings [description]
	 * @return [type]           [description]
	 */
	public function _render_inc_if( $file = null, $settings = array() ) {

		foreach ( $settings as $setting ) {
			$val = $this->get_settings_for_display( $setting );

			if ( ! empty( $val ) ) {
				include $file;
				return;
			}

		}

	}

	/**
	 * Loop render item
	 *
	 * @param  string  $format     [description]
	 * @param  [type]  $key        [description]
	 * @param  boolean $nested_key [description]
	 * @return [type]              [description]
	 */
	public function _render_loop_item( $keys = array(), $format = '%s' ) {

		$item = $this->_processed_item;

		$key        = $keys[0];
		$nested_key = isset( $keys[1] ) ? $keys[1] : false;

		if ( empty( $item ) || ! isset( $item[ $key ] ) ) {
			return false;
		}

		if ( false === $nested_key || ! is_array( $item[ $key ] ) ) {
			$value = $item[ $key ];
		} else {
			$value = isset( $item[ $key ][ $nested_key ] ) ? $item[ $key ][ $nested_key ] : false;
		}

		if ( ! empty( $value ) ) {
			return sprintf( $format, $value );
		}else{
			return "";
		}

	}

	/**
	 * Get looped template
	 *
	 * @param  array  $templates [description]
	 * @param  string $setting   [description]
	 * @param  string $callback  Callback for preparing a loop array
	 * @return void
	 * @since 1.0
	 */
	public function get_looped_template( $name = null, $setting = null, $callback = null ) {

		$templates = array(
			'start' => $this->get_widget_template( $name . '-loop-start' ),
			'loop'  => $this->get_widget_template( $name . '-loop-item' ),
			'end'   => $this->get_widget_template( $name . '-loop-end' ),
		);

		$loop = $this->get_settings_for_display( $setting );
		$loop = apply_filters( 'techt-elements/widget/loop-items', $loop, $setting, $this );

		if ( empty( $loop ) ) {
			return;
		}

		if ( $callback && is_callable( $callback ) ) {
			$loop = call_user_func( $callback, $loop );
		}

		if ( ! empty( $templates['start'] ) ) {
			require $templates['start'];
		}

		foreach ( $loop as $item ) {

			$this->_processed_item = $item;

			if ( ! empty( $templates['loop'] ) ) {
				require $templates['loop'];
			}
			$this->_processed_index++;
		}

		$this->_processed_item = false;
		$this->_processed_index = 0;

		if ( ! empty( $templates['end'] ) ) {
			require $templates['end'];
		}

	}
   
    /**
	 * Get globaly affected template
	 *
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function get_widget_template( $name = null ) {

		$template = TECHT_WIDGET_TEMPLATES_PATH . str_replace("techt-","", $this->get_name()) . '/' . $name . '.php';
		return $template;
	}

	/**
	 * Add icon control
	 *
	 * @param string $id
	 * @param array  $args
	 * @param object $instance
	 */
	public function add_advanced_icon_control( $id, array $args = array(), $instance = null ) {

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {

			$_id = $id; // old control id
			$id  = $this->_new_icon_prefix . $id;

			$args['type'] = Controls_Manager::ICONS;
			$args['fa4compatibility'] = $_id;

			unset( $args['file'] );
			unset( $args['default'] );

			if ( isset( $args['fa5_default'] ) ) {
				$args['default'] = $args['fa5_default'];
			}
		} else {
			$args['type'] = Controls_Manager::ICON;
		}

		unset( $args['fa5_default'] );

		if ( null !== $instance ) {
			$instance->add_control( $id, $args );
		} else {
			$this->add_control( $id, $args );
		}
	}

	/**
	 * Print HTML icon markup
	 *
	 * @param  array $setting
	 * @param  string $format
	 * @param  string $icon_class
	 * @return void
	 */
	public function _icon( $setting = null, $format = '%s', $icon_class = '', $echo = true ) {
		call_user_func( array( $this, sprintf( '_%s_icon', $this->_context ) ), $setting, $format, $icon_class, $echo );
	}

	/**
	 * Returns HTML icon markup
	 *
	 * @param  array $setting
	 * @param  string $format
	 * @param  string $icon_class
	 * @return string
	 */
	public function _get_icon( $setting = null, $format = '%s', $icon_class = '', $echo = true ) {
		return $this->_render_icon( $setting, $format, $icon_class, $echo );
	}

	/**
	 * Print HTML icon template
	 *
	 * @param  array  $setting
	 * @param  string $format
	 * @param  string $icon_class
	 * @param  bool   $echo
	 *
	 * @return void|string
	 */
	public function _render_icon( $setting = null, $format = '%s', $icon_class = '', $echo = true ) {

		if ( false === $this->_processed_item ) {
			$settings = $this->get_settings_for_display();
		} else {
			$settings = $this->_processed_item;
		}

		$new_setting = $this->_new_icon_prefix . $setting;

		$migrated = isset( $settings['__fa4_migrated'][ $new_setting ] );
		$is_new   = empty( $settings[ $setting ] ) && class_exists( 'Elementor\Icons_Manager' );

		$icon_html = '';

		if ( $is_new || $migrated ) {

			$attr = array( 'aria-hidden' => 'true' );

			if ( ! empty( $icon_class ) ) {
				$attr['class'] = $icon_class;
			}

			if ( isset( $settings[ $new_setting ] ) ) {
				ob_start();
				Icons_Manager::render_icon( $settings[ $new_setting ], $attr );

				$icon_html = ob_get_clean();
			}

		} else if ( ! empty( $settings[ $setting ] ) ) {

			if ( empty( $icon_class ) ) {
				$icon_class = $settings[ $setting ]['value'];
			} else {
				$icon_class .= ' ' . $settings[ $setting ]['value'];
			}

			$icon_html = sprintf( '<i class="%s" aria-hidden="true"></i>', $icon_class );
		}

		if ( empty( $icon_html ) ) {
			return;
		}

		if ( ! $echo ) {
			return sprintf( $format, $icon_html );
		}

		printf( $format, $icon_html );
		
	}

	/**
	 * Add icon control
	 *
	 * @param string $id
	 * @param array  $args
	 * @param object $instance
	 */
	public function _add_advanced_icon_control( $id, array $args = array(), $instance = null ) {

		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '2.6.0', '>=' ) ) {

			$_id = $id; // old control id
			$id  = $this->_new_icon_prefix . $id;

			$args['type'] = Controls_Manager::ICONS;
			$args['fa4compatibility'] = $_id;

			unset( $args['file'] );
			unset( $args['default'] );

			if ( isset( $args['fa5_default'] ) ) {
				$args['default'] = $args['fa5_default'];
			}
		} else {
			$args['type'] = Controls_Manager::ICON;
		}

		unset( $args['fa5_default'] );

		if ( null !== $instance ) {
			$instance->add_control( $id, $args );
		} else {
			$this->add_control( $id, $args );
		}
	}
	// Get Techt Template 
	function get_techt_templates($type = null) {
		$temp_type ="";
		is_null($type) || $type == "" ? $temp_type = 'block' :  $temp_type = $type;
		 // Footer Templates Query
		 $template_args = array( 
            'post_type' => 'petrona_templates', 
            'posts_per_page' => -1,
            'meta_key' => 'petrona_template_types',
            'meta_value'  => $temp_type,
            // 'meta_compare' => '>=',
            'orderby'      => 'meta_value',
            'order'        => 'ASC',
            'meta_query'   => array(
                'relation' => 'OR',
                array(
                    'key'     => 'petrona_template_types',
                    'value'   => $temp_type,
                    'compare' => '==',
                    'type'    => 'page',
                ),
            ),
        );

        $get_templates = get_posts($template_args);
        $templates = array();
        if( $get_templates ) {
            foreach ($get_templates as $value) {
                $templates['default'] = esc_html__('Default', 'petrona');
                $templates[$value->ID] = $value->post_title;
            }
        } else {
            $templates['default'] = esc_html__('Default', 'petrona');
        }

		return $templates;
	}

	/*get techt template*/


	// Get Elementor Template 
	function techt_elementor_templates() {
    	$templates = \Elementor\Plugin::$instance->templates_manager->get_source( 'local' )->get_items();
    	$types     = [];

    	if ( empty( $templates ) ) {
    	    $options = [ '0' => esc_html__( 'You Haven’t Saved Templates Yet.', 'petrona' ) ];
    	} else {
    	    $options = [ '0' => esc_html__( 'Select Template', 'petrona' ) ];
		
    	    foreach ( $templates as $template ) {
    	        $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
    	        $types[ $template['template_id'] ] = $template['type'];
    	    }
    	}

    	return $options;
	}

	/*get template*/

	/*registration user role*/
	function ox_lr_user_role() {
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new \WP_Roles(); 
		}

		$roles     = isset( $wp_roles->roles ) ? $wp_roles->roles : array();
		$all_roles = array();

		foreach ( $roles as $role_key => $role ) {
			$all_roles[ $role_key ] = $role['name'];
		}

		return apply_filters( 'user_registration_user_default_roles', $all_roles );
	}
	/*registration user role*/

	function techt_get_term_options() {

	$args = [];
	$args['post_type'] = ['page'];
	$args['posts_per_page'] = -1;

	$query = get_posts($args);

	// Initate an empty array
	$output = [];

	 if ( $query ) {
		$output['']='Select Template';
	    foreach ( $query as $post ){        
	        $output[ $post->ID ] = $post->post_title;
	    }
	}

	    return $output;
	}

	function techt_get_border_style(){
    	return array(
    	    'solid' => esc_html__( 'Solid', 'petrona' ),
			'dashed' => esc_html__( 'Dashed', 'petrona' ),
			'dotted' => esc_html__( 'Dotted', 'petrona' ),
			'groove' => esc_html__( 'Groove', 'petrona' ),
			'inset' => esc_html__( 'Inset', 'petrona' ),
			'outset' => esc_html__( 'Outset', 'petrona' ),
			'ridge' => esc_html__( 'Ridge', 'petrona' ),
    	);
	}

	function get_available_title_html_tags(){
		return array(
			'h1'   => esc_html__( 'H1', 'petrona' ),
			'h2'   => esc_html__( 'H2', 'petrona' ),
			'h3'   => esc_html__( 'H3', 'petrona' ),
			'h4'   => esc_html__( 'H4', 'petrona' ),
			'h5'   => esc_html__( 'H5', 'petrona' ),
			'h6'   => esc_html__( 'H6', 'petrona' ),
			'div'  => esc_html__( 'div', 'petrona' ),
			'span' => esc_html__( 'span', 'petrona' ),
			'p'    => esc_html__( 'p', 'petrona' ),
		);
	}
	
	public function validate_html_tag( $tag ) {
		$allowed_tags = array(
			'article',
			'aside',
			'div',
			'footer',
			'h1',
			'h2',
			'h3',
			'h4',
			'h5',
			'h6',
			'header',
			'main',
			'nav',
			'p',
			'section',
			'span',
		);

		return in_array( strtolower( $tag ), $allowed_tags ) ? $tag : 'div';
	}

	public function verrtical_align_attr() {
		return array(
			'baseline'    => esc_html__( 'Baseline', 'petrona' ),
			'top'         => esc_html__( 'Top', 'petrona' ),
			'middle'      => esc_html__( 'Middle', 'petrona' ),
			'bottom'      => esc_html__( 'Bottom', 'petrona' ),
			'sub'         => esc_html__( 'Sub', 'petrona' ),
			'super'       => esc_html__( 'Super', 'petrona' ),
			'text-top'    => esc_html__( 'Text Top', 'petrona' ),
			'text-bottom' => esc_html__( 'Text Bottom', 'petrona' ),
		);
	}

	/**
	 * Get post title by ID
	 *
	 * @since 1.0
	 */
	public function get_posts_title_by_id() {

		$ids = isset( $_POST['id'] ) ? $_POST['id'] : array();

		$results = [];

		$query = new \WP_Query(
			[
				'post_type'      => 'any',
				'post__in'       => $ids,
				'posts_per_page' => -1,
			]
		);

		foreach ( $query->posts as $post ) {
			$results[ $post->ID ] = $post->post_title;
		}

		// return the results in json.
		wp_send_json( $results );
	}

	/**
	 * Get post by search
	 *
	 * @since 1.0
	 */
	public function get_posts_by_query() {

		$search_string = isset( $_POST['q'] ) ? sanitize_text_field( $_POST['q'] ) : '';
		$req_post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : 'all';

		$data   = array();
		$result = array();

		$args = array(
			'public'   => true,
			'_builtin' => false,
		);

		$output   = 'names'; // names or objects, note names is the default.
		$operator = 'and'; // also supports 'or'.

		if ( 'all' === $req_post_type ) {
			$post_types = get_post_types( $args, $output, $operator );

			$post_types['Posts'] = 'post';
			$post_types['Pages'] = 'page';
		} else {
			$post_types[ $req_post_type ] = $req_post_type;
		}

		foreach ( $post_types as $key => $post_type ) {

			$data = array();

			add_filter( 'posts_search', array( $this, 'search_only_titles' ), 10, 2 );

			$query_args = array(
				's'              => $search_string,
				'post_type'      => $post_type,
				'posts_per_page' => - 1,
			);

			$query_args = apply_filters( 'ppe_woo_products_query_control_args', $query_args, $query_args );

			$query = new \WP_Query( $query_args );

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$title  = get_the_title();
					$title .= ( 0 != $query->post->post_parent ) ? ' (' . get_the_title( $query->post->post_parent ) . ')' : '';
					$id     = get_the_id();
					$data[] = array(
						'id'   => $id,
						'text' => $title,
					);
				}
			}

			if ( is_array( $data ) && ! empty( $data ) ) {
				$result[] = array(
					'text'     => $key,
					'children' => $data,
				);
			}
		}

		$data = array();

		wp_reset_postdata();

		// return the result in json.
		wp_send_json( $result );
	}

	/**
	 * Return search results only by post title.
	 * This is only run from get_posts_by_query()
	 *
	 * @param  (string)   $search   Search SQL for WHERE clause.
	 * @param  (WP_Query) $wp_query The current WP_Query object.
	 *
	 * @return (string) The Modified Search SQL for WHERE clause.
	 */
	public function search_only_titles( $search, $wp_query ) {
		if ( ! empty( $search ) && ! empty( $wp_query->query_vars['search_terms'] ) ) {
			global $wpdb;

			$q = $wp_query->query_vars;
			$n = ! empty( $q['exact'] ) ? '' : '%';

			$search = array();

			foreach ( (array) $q['search_terms'] as $term ) {
				$search[] = $wpdb->prepare( "$wpdb->posts.post_title LIKE %s", $n . $wpdb->esc_like( $term ) . $n );
			}

			if ( ! is_user_logged_in() ) {
				$search[] = "$wpdb->posts.post_password = ''";
			}

			$search = ' AND ' . implode( ' AND ', $search );
		}

		return $search;
	}

	// /**
	//  *  Initiator
	//  */
	// public static function get_instance() {
	// 	if ( ! isset( self::$instance ) ) {
	// 		self::$instance = new self();
	// 	}
	// 	return self::$instance;
	// }

	/**
	 * Check if we currently in Elementor mode
	 *
	 * @return void
	 */
	public function in_elementor() {
		$result = false;
		if ( wp_doing_ajax() ) {
			$result = ( isset( $_REQUEST['action'] ) && 'elementor_ajax' === $_REQUEST['action'] );
		} elseif ( Plugin::instance()->editor->is_edit_mode()
			&& 'wp_enqueue_scripts' === current_filter() ) {
			$result = true;
		} elseif ( Plugin::instance()->preview->is_preview_mode() && 'wp_enqueue_scripts' === current_filter() ) {
			$result = true;
		}
		/**
		 * Allow to filter result before return
		 *
		 * @var bool $result
		 */
		return apply_filters( 'techt/in-elementor', $result );
	}

	/**
	 * Get item template content.
	 *
	 * @return string|void
	 */
	public function get_template_content( $template_id ) {

		if ( empty( $template_id ) ) {
			return;
		}

		// for multi-language plugins
		$template_id = apply_filters( 'petrona/widgets/template_id', $template_id, $this );
		$content     = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $template_id );
		$edit_link = add_query_arg(
			array(
				'elementor' => '',
			),
			get_permalink( $template_id )
		);

		if ( $this->in_elementor() ) {
			echo sprintf( '<div class="techt__edit-cover" data-template-edit-link="%s"><i class="eicon-edit"></i><span>%s</span></div>', $edit_link, esc_html__( 'Edit Template', 'petrona' ) );
		}


		// if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		// 	$edit_url = add_query_arg(
		// 		array(
		// 			'elementor' => '',
		// 		),
		// 		get_permalink( $template_id )
		// 	);
		// 	$edit_link = sprintf(
		// 		'<a class="techt-edit-template-link" href="%s" title="%s" target="_blank"><span class="dashicons dashicons-edit"></span></a>',
		// 		esc_url( $edit_url ),
		// 		esc_html__( 'Edit Template', 'luxin' )
		// 	);
		// 	$content .= $edit_link;
		// }

		return $content;
	}
	// public function techt_basic_style_controls($control_id = null, $control_name = null, $control_selector = null, $condition = [] ){
    //     $this->start_controls_section(
    //         'techt_' . $control_id . '_styling',
    //         [
    //             'label' => esc_html__($control_name, 'petrona'),
    //             'tab' => Controls_Manager::TAB_STYLE,
    //             'condition'	=> $condition,
    //         ]
    //     );
    //     $this->add_control(
    //         'techt_' . $control_id . '_color',
    //         [
    //             'label' => esc_html__('Color', 'petrona'),
    //             'type' => Controls_Manager::COLOR,
    //             'selectors' => [
    //                 '{{WRAPPER}} ' . $control_selector => 'color: {{VALUE}} !important;',
    //             ],
    //         ]
    //     );
    //     $this->add_control(
    //         'techt_' . $control_id . '_bg_color',
    //         [
    //             'label' => esc_html__('Background Color', 'petrona'),
    //             'type' => Controls_Manager::COLOR,
    //             'selectors' => [
    //                 '{{WRAPPER}} ' . $control_selector => 'background-color: {{VALUE}} !important;',
    //             ],
    //         ]
    //     );
    //     $this->add_group_control(
    //         Group_Control_Typography::get_type(),
    //         [
    //             'name' => 'techt_' . $control_id . '_typography',
    //             'label' => esc_html__('Typography', 'petrona'),
    //             'selector' => '{{WRAPPER}} ' . $control_selector,
    //         ]
    //     );
    //     $this->add_responsive_control(
    //         'techt_' . $control_id . '_padding',
    //         [
    //             'label' => esc_html__('Padding', 'petrona'),
    //             'type' => Controls_Manager::DIMENSIONS,
    //             'size_units' => ['px', '%', 'em'],
    //             'selectors' => [
    //                 '{{WRAPPER}} ' . $control_selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    //             ],
    //             'separator' => 'before',
    //         ]
    //     );
    //     $this->add_responsive_control(
    //         'techt_' . $control_id . '_margin',
    //         [
    //             'label' => esc_html__('Margin', 'petrona'),
    //             'type' => Controls_Manager::DIMENSIONS,
    //             'size_units' => ['px', '%', 'em'],
    //             'selectors' => [
    //                 '{{WRAPPER}} ' . $control_selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    //             ],
    //             'separator' => 'before',
    //         ]
    //     );
	// 	$this->add_group_control(
	// 		Group_Control_Border::get_type(),
	// 		array(
	// 			'name'        => 'techt_' . $control_id . '_border',
	// 			'label'       => esc_html__( 'Border', 'petrona' ),
	// 			'placeholder' => '1px',
	// 			'default'     => '1px',
	// 			'selector'    => '{{WRAPPER}} ' . $control_selector,
	// 		)
	// 	);

	// 	$this->add_responsive_control(
	// 		'techt_' . $control_id . '_border_radius',
	// 		array(
	// 			'label'      => __( 'Border Radius', 'petrona' ),
	// 			'type'       => Controls_Manager::DIMENSIONS,
	// 			'size_units' => array( 'px', '%' ),
	// 			'selectors'  => array(
	// 				'{{WRAPPER}} ' . $control_selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	// 			),
	// 		)
	// 	);
	// 	$this->add_responsive_control(
	// 		'techt_' . $control_id . '_align',
	// 		[
	// 			'label'   => esc_html__('Alignment', 'petrona'),
	// 			'type'    => Controls_Manager::CHOOSE,
	// 			'options' => [
	// 				'left' => [
	// 					'title' => esc_html__( 'Left', 'textdomain' ),
	// 					'icon' => 'eicon-text-align-left',
	// 				],
	// 				'center' => [
	// 					'title' => esc_html__( 'Center', 'textdomain' ),
	// 					'icon' => 'eicon-text-align-center',
	// 				],
	// 				'right' => [
	// 					'title' => esc_html__( 'Right', 'textdomain' ),
	// 					'icon' => 'eicon-text-align-right',
	// 				],
	// 			],
	// 			'selectors' => [
	// 				'{{WRAPPER}} ' . $control_selector => 'text-align: {{VALUE}};',
	// 			],
	// 		]
	// 	);
    //     $this->end_controls_section();
    // }

}