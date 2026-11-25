<?php

/**
 *  Techt Page Builder Shortcode
 *
 * @package Petrona
 * @since 1.0
 */
class Techt_Elementor_Widget
{

	private static $instance = null;

	/**
	 * @since 1.0
	 */
	public static function get_instance()
	{
		if (!self::$instance)
			self::$instance = new self;
		return self::$instance;
	}

	/**
	 * @since 1.0
	 */
	public function init()
	{

		// Check if Elementor installed and activated
		if (!did_action('elementor/loaded')) {
			add_action('admin_notices', array($this, 'admin_notice_missing_main_plugin'));
			return;
		}

		add_filter('elementor/controls/animations/additional_animations', array($this, 'add_animations'));

		add_action('elementor/frontend/after_register_styles', array($this, 'register_frontend_styles'), 10);

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'register_editor_styles' ) );

		add_action('elementor/widgets/widgets_registered', array($this, 'widgets_registered'));

		add_action( 'elementor/controls/controls_registered', array( $this, 'controls_registered' ), 10 );

		add_action('elementor/frontend/after_register_scripts', array($this, 'register_frontend_scripts'), 10);

		add_action('elementor/elements/categories_registered', array($this, 'elementor_widget_categories'));

		add_action('elementor/init', array($this, 'extension_registered'));
		add_action('elementor/init', array($this, 'init_module'));

		add_action( 'wp_ajax_get_posts_by_query', array( $this, 'get_posts_by_query' ) );
		add_action( 'wp_ajax_get_posts_title_by_id', array( $this, 'get_posts_title_by_id' ) );

		add_action( 'wp_ajax_nopriv_get_techt_template_content', array( $this, 'get_techt_template_content' ) );
		add_action( 'wp_ajax_get_techt_template_content', array( $this, 'get_techt_template_content' ) );

		if (!class_exists('ElementorPro\Plugin')) {
			add_action('elementor/editor/after_enqueue_styles', function () {
				echo '<style>#elementor-panel-get-pro-elements, #elementor-notice-bar { display: none !important;}</style>';
			});

			add_filter('elementor/editor/localize_settings', function ($settings) {
				if (!empty($settings['promotionWidgets'])) {
					$settings['promotionWidgets'] = [];
				}
				return $settings;
			}, 20);
		}

		// Add new font group to elementor
		add_filter(
			'elementor/fonts/groups',
			function ($font_groups) {

				$font_groups['FarsiFontForElementor'] =  'Persian Fonts';
				return $font_groups;
			}
		);

		/**
		 * add new font to custom Farsi Font's group
		 * Key / Value
		 * font name / font group
		 */
		add_filter(
			'elementor/fonts/additional_fonts',
			function ($additional_fonts) {
				$persian_fonts = techt_get_persian_fonts_array();
				foreach ($persian_fonts as $font) {
					$additional_fonts[$font] = 'FarsiFontForElementor';
				}
				return $additional_fonts;
			}
		);
		// add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_flaticon_css' ) );
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'add_new_icons_tab' ), 9999999, 1 );
		add_action('elementor/editor/before_enqueue_scripts',   array($this, 'editor_scripts'));
		add_action('wp_head', [$this, 'admin_scripts']);

		// Woo-Products Widget Pagination ajax
		add_action( 'wp_ajax_pp_get_products', array( $this, 'pp_get_products' ) );
		add_action( 'wp_ajax_nopriv_pp_get_products', array( $this, 'pp_get_products' ) );
	}

	/**
	* @since 1.0
	*/

	function add_animations(){
		
		$additional_animations= array(
			'Flipping Entrances' => [
				'flip' => 'Flip',
				'flipInX' =>  'Flip In X Axis',
				'flipOutX' =>  'Flip Out X Axis',
				'flipInY' =>  'Flip In Y Axis',
				'flipOutY' =>  'Flip Out Y Axis',
			],
			'Fading' => [
				'fadeIn' =>  'Fade In',
				'fadeInDown' =>  'Fade In Down',
				'fadeInDownBig' =>  'Intense Fade In Down', 
				'fadeInLeft' =>  'Fade In Left',
				'fadeInLeftBig' =>  'Intense Fade In Left', 
				'fadeInRight' =>  'Fade In Right',
				'fadeInRightBig' =>  'Intense Fade In Left', 
				'fadeInUp' =>  'Fade In Up',
				'fadeInUpBig' =>  'Intense Fade In Left',
				'fadeOut' =>  'Fade Out',
				'fadeOutDown' =>  'Fade Out Down',
				'fadeOutDownBig' =>  'Fade Out Down Big',
				'fadeOutLeft' =>  'Fade Out Left',
				'fadeOutLeftBig' =>  'Fade Out Left Big',
				'fadeOutRight' =>  'Fade Out Right',
				'fadeOutRightBig' =>  'Fade Out Right Big',
				'fadeOutUp'  =>  'Fade Out Up',
				'fadeOutUpBig' =>  'Fade Out Up Big',
			],
			'Light Speed' => [
				'lightSpeedInRight' =>  'Light Speed In Right',
				'lightSpeedInLeft'  =>  'Light Speed In Left',
				'lightSpeedOutRight' =>  'Light Speed Out Right',
				'lightSpeedOutLeft'  =>  'Light Speed Out Left',
			],

		);
		return $additional_animations;
	}

	/**
	 * @since 1.0
	 */
	public function admin_notice_missing_main_plugin()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			 '"%1$s" requires "%2$s" to be install or activated.',
			'<strong>' .  'Petrona Theme' . '</strong>',
			'<strong>' .  'Elementor' . '</strong>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * @since 1.0
	 */
	public function widgets_registered()
	{

		//Require all PHP files in the /elementor/widgets directory
		require plugin_dir_path(__FILE__) . '/class-techt-element-base.php';
		foreach (glob(plugin_dir_path(__FILE__) . "widgets/*.php") as $file) {
			require $file;
		}
	}

	/**
	 * Add new controls.
	 *
	 * @param  object $controls_manager Controls manager instance.
	 * @return void
	 */
	public function controls_registered( $controls_manager ) {

		foreach (glob(plugin_dir_path(__FILE__) . "/controls/groups/*.php") as $file) {
			require $file;
		}
		$class_name = 'Techt_Group_Control_Box_Style';

		$controls_manager->add_group_control( 'techt-box-style', new $class_name() );

		foreach (glob(plugin_dir_path(__FILE__) . "/controls/*.php") as $file) {
			require $file;
		}
		$class_name = 'Techt_Control_Query';
		$controls_manager->register( new $class_name() );

		$class_name = 'Techt_Query';
		$controls_manager->register( new $class_name() );
		
	}


	/**
	 * @since 1.0
	 */
	public function extension_registered()
	{
		//Require all PHP files in the /elementor/extension directory
		foreach (glob(plugin_dir_path(__FILE__) . "extensions/*.php") as $file) {
			require $file;
		}
	}

	/**
	* @since 1.0
	*/
	public function register_frontend_styles()
	{
		wp_register_style( 'techt-custom-animate', TECHT_MADULES_URL . '/public/assets/css/custom-animate.css' );
		wp_register_style( 'tec-slider', TECHT_MADULES_URL . '/public/assets/css/tec-slider.min.css' );
	}

	/**
	* @since 1.0
	*/
	public function register_editor_styles()
	{
		wp_register_style( 'techt-custom-animate', TECHT_MADULES_URL . '/public/assets/css/custom-animate.css' );
		wp_register_style( 'tec-slider', TECHT_MADULES_URL . '/public/assets/css/tec-slider.min.css' );
		wp_register_style( 'leaflet', TECHT_MADULES_URL . '/public/assets/css/leaflet.css' );
		wp_enqueue_style( 'techt-editor', TECHT_MADULES_URL . '/public/assets/css/techt-editor.css', array(), TECHT_CORE_VERSION );
	}

	/**
	* @since 1.0
	*/
	public function register_frontend_scripts()
	{
		wp_register_script('typed',  TECHT_MADULES_URL . '/public/assets/js/typed.min.js', array('jquery'), false, true);
		wp_register_script('morphext',  TECHT_MADULES_URL . '/public/assets/js/morphext.min.js', array('jquery'), false, true);
		wp_register_script('infinite-scroll',  TECHT_MADULES_URL . '/public/assets/js/infinite-scroll.pkgd.min.js', array('jquery'), false, true);
		wp_register_script('hoverIntent',  TECHT_MADULES_URL . '/public/assets/js/jquery.hoverIntent.min.js', array('jquery'), false, true);
		wp_register_script('techt-anime-js',  TECHT_MADULES_URL . '/public/assets/js/anime.min.js', array(), false, true);
		wp_register_script('tippy',  TECHT_MADULES_URL . '/public/assets/js/tippy.all.min.js', array(), false, true);
		wp_enqueue_script( 'syoTimer', TECHT_MADULES_URL . '/public/assets/js/syoTimer.min.js', array('jquery'), false, true);
		wp_register_script('touch-events',  TECHT_MADULES_URL . '/public/assets/js/touch-events.min.js', array(), false, true);
		wp_register_script('easing',  TECHT_MADULES_URL . '/public/assets/js/jquery.easing.min.js', array('jquery'), false, true);
		wp_register_script('tec-slider',  TECHT_MADULES_URL . '/public/assets/js/tec-slider.min.js', array('jquery'), false, true);
		wp_register_script('highcharts', TECHT_MADULES_URL . '/public/assets/js/highcharts.js', [], false, true);
		wp_register_script('highcharts-map', TECHT_MADULES_URL . '/public/assets/js/map.js', ['highcharts'], false, true);
		wp_register_script('highcharts-iran-map', TECHT_MADULES_URL . '/public/assets/js/ir-all.js', ['highcharts-map'], false, true);
		// wp_register_script('leaflet', TECHT_MADULES_URL . '/public/assets/js/leaflet.js', [], false, true);
		/**
		* @since 1.0
		*/
		// $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
		wp_enqueue_script('techt-frontend-widget-scripts',  TECHT_MADULES_URL . '/public/assets/js/front-end-widget.js', array('jquery'), false, true);
		
		$pp_woo_localize = apply_filters(
			'pp_woo_elements_js_localize',
			array(
				'ajax_url'          => admin_url( 'admin-ajax.php' ),
				'get_product_nonce' => wp_create_nonce( 'pp-product-nonce' ),
				'quick_view_nonce'  => wp_create_nonce( 'pp-qv-nonce' ),
				'add_cart_nonce'    => wp_create_nonce( 'pp-ac-nonce' ),
			)
		);
		wp_localize_script( 'techt-frontend-widget-scripts', 'pp_woo_products_script', $pp_woo_localize );
	}

	/**
	 * Enqueue plugin scripts only with elementor scripts
	 *
	 * @return void
	 */
	public function editor_scripts()
	{
		/**
		* @since 1.0
		*/
		$suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

		wp_enqueue_script(
			'techt-editor',
			TECHT_MADULES_URL . '/public/assets/js/editor-widget'.$suffix.'.js',
			array('jquery'),
			false,
			true
		);
	}

	/**
	* @since 1.0
	*/
	public function elementor_widget_categories($elements_manager)
	{

		$elements_manager->add_category(
			'techt-category',
			[
				'title' =>  esc_html__('Petrona Theme', 'petrona'),
				'icon' => 'eicon-clone',
			]
		);
	}
	public function init_module()
	{
		require TECHT_MADULES_PATH . '/public/elementor/class-techt-elementor-dynamic-tag.php';
		new Techt_Engine_Dynamic_Tags_Module();

		require TECHT_MADULES_PATH . '/public/elementor/class-techt-query.php';
	}

	public function admin_scripts()
	{
		echo '<script> var techt_ajax_url = "' . admin_url("admin-ajax.php") . '";
		var techt_nonce = "' . wp_create_nonce("techt-addons") . '";</script>';
	}

	public function enqueue_flaticon_css() {
		wp_enqueue_style(
			'flaticon',
			get_theme_file_uri( '/assets/css/flaticon.min.css' ),
			[],
			TECHT_CORE_VERSION
		);
	}

	/**
	 * Add custom icons to Elementor Icons tabs
	 *
	 * @param array $tabs Additional tabs for new icon interface.
	 * @return array $tabs
	 */
	public function add_new_icons_tab( $tabs = array() ) {

		$newicons = [];

		$newicons['flaticon'] = [
			'name'          => 'flaticon',
			'label'         => 'Flaticon',
			'url'           => get_theme_file_uri( '/assets/css/flaticon.min.css' ),
			'enqueue'       => [get_theme_file_uri( '/assets/css/flaticon.min.css' )],
			'prefix'        => 'flaticon-',
			'displayPrefix' => '',
			'labelIcon'     => 'fas fa-user',
			'ver'           => '1.0.0',
			'fetchJson'     => TECHT_MADULES_URL . '/public/assets/json/flaticon.json'
		];

		$newicons['petrona'] = [
			'name'          => 'petrona',
			'label'         => 'Petrona',
			'url'           => get_theme_file_uri( '/assets/css/techt-icons.min.css' ),
			'enqueue'       => [get_theme_file_uri( '/assets/css/techt-icons.min.css' )],
			'prefix'        => 'techt-icon-',
			'displayPrefix' => '',
			'labelIcon'     => 'fas fa-user',
			'ver'           => '1.0.0',
			'fetchJson'     => TECHT_MADULES_URL . '/public/assets/json/techt-icons.json'
		];

		return array_merge( $tabs, $newicons );
	}

	/**
	 * Get post title by ID
	 *
	 * @since 1.1.0
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
	 * @since 1.1.0
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

	/**
	 * Get Widget Setting data.
	 *
	 * @since 1.0
	 * @access public
	 * @param array  $elements Element array.
	 * @param string $form_id Element ID.
	 * @return Boolean True/False.
	 */
	public function find_element_recursive( $elements, $form_id ) {

		foreach ( $elements as $element ) {
			if ( $form_id === $element['id'] ) {
				return $element;
			}

			if ( ! empty( $element['elements'] ) ) {
				$element = $this->find_element_recursive( $element['elements'], $form_id );

				if ( $element ) {
					return $element;
				}
			}
		}

		return false;
	}

	/**
	 * Get Woo Data via AJAX call.
	 *
	 * @since 1.0
	 * @access public
	 */
	public function pp_get_products() {
		check_ajax_referer( 'pp-product-nonce', 'nonce' );

		$post_id   = $_POST['page_id'];
		$widget_id = $_POST['widget_id'];
		$style_id  = $_POST['skin'];

		$elementor = \Elementor\Plugin::$instance;
		$meta      = $elementor->documents->get( $post_id )->get_elements_data();

		$widget_data = $this->find_element_recursive( $meta, $widget_id );

		$data = array(
			'message'    => esc_html__( 'Saved', 'powerpack' ),
			'ID'         => '',
			'skin_id'    => '',
			'html'       => '',
			'pagination' => '',
		);

		if ( null !== $widget_data ) {
			$widget = $elementor->elements_manager->create_element_instance( $widget_data );
			// $skin = $widget->get_current_skin();
			$body = $widget->render_ajax_product_body( $widget );
			$pagination = $widget->render_ajax_pagination( $widget );

			$data['ID']         = $widget->get_id();
			$data['skin_id']    = $style_id;
			$data['html']       = $body;
			$data['pagination'] = $pagination;
		}

		wp_send_json_success( $data );
	}

	public function get_techt_template_content($request){
		// $args = $request->get_params();

		$template_id = ! empty( $_POST['id'] ) ? $_POST['id'] : false;

		$dev = filter_var( $_POST['dev'], FILTER_VALIDATE_BOOLEAN ) ? true : false;

		if ( ! $template_id ) {
			return false;
		}

		$is_cached_template = isset( $_POST['cachedTemplate'] ) ?  $_POST['cachedTemplate'] : true;

		$cached = apply_filters( 'techt/rest/endpoint/elementor-template/cached', $is_cached_template, $template_id );

		$transient_key = md5( sprintf( 'techt_elementor_template_data_%s', $template_id ) );

		$template_data = get_transient( $transient_key );

		if ( ! empty( $template_data ) && !$dev && 'true' === $cached ) {
			return rest_ensure_response( $template_data );
		}

		$plugin = \Elementor\Plugin::instance();

		$content = '';

		// $template_scripts = [];
		// $template_styles = [];

		// $fonts_link = $this->get_elementor_template_fonts_url( $template_id );

		// if ( $fonts_link ) {
		// 	$template_styles[ 'jet-blocks-google-fonts-css-' . $template_id ] = $fonts_link;
		// }

		$plugin->frontend->register_scripts();

		$content .= $plugin->frontend->get_builder_content_for_display( $template_id, true );

		// $this->get_elementor_template_scripts( $template_id );

		// $script_depends = array_unique( $this->depended_scripts );

		// foreach ( $script_depends as $script ) {
		// 	$template_scripts[ $script ] = $this->get_script_uri_by_handler( $script );
		// }

		$template_data = [
			'template_content' => $content,
			// 'template_scripts' => $template_scripts,
			// 'template_styles'  => $template_styles,
		];

		if ( $cached ) {
			set_transient( $transient_key, $template_data, 12 * HOUR_IN_SECONDS );
		}

		return wp_send_json_success( $template_data );
	}

}
if( !in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;
Techt_Elementor_Widget::get_instance()->init();