<?php

class Techt_Custom_post {
	private static $_instance = null;

	public static function instance() {
	    if ( is_null( self::$_instance ) ) {
	        self::$_instance = new self();
	    }
	    return self::$_instance;
	}

	public function __construct() {
		add_action('init', array($this, 'register_post_types' ));

	    add_filter('manage_edit-petrona_templates_columns', array($this, 'post_data_columns') );
	    add_action('manage_petrona_templates_posts_custom_column',  array($this, 'template_show_columns') );
	    add_filter('manage_edit-portfolio_columns', array( $this, 'portfolio_data_columns' ) );
	    add_action('manage_portfolio_posts_custom_column', array( $this, 'portfolio_show_columns') );

	    add_action( 'template_redirect', array( $this, 'block_template_frontend' ) );
	    add_filter( 'single_template', array( $this, 'load_canvas_template' ) );

	    add_action( 'init', array($this,'elementor_post_type_support') );

	    add_filter( 'single_template',   array( $this, 'portfolio_single_template' ) );
		add_filter( 'taxonomy_template',   array( $this, 'portfolio_category_template' ) );
		// This enables the orderby=menu_order for Posts
		add_filter( 'rest_post_collection_params', array($this, 'filter_add_rest_orderby_params'), 10, 1 );
		// And this for a custom post type called 'portfolio'
		add_filter( 'rest_portfolio_collection_params', array($this, 'filter_add_rest_orderby_params'), 10, 1 );
		add_action( 'pre_get_posts', array($this,'exclude_pages_from_search_results') );
		add_filter( 'pll_get_post_types', array($this,'add_cpt_to_pll'), 10, 2 );
		add_filter( 'pll_get_taxonomies' , array($this,'add_ctax_to_pll'), 10, 2 );
		add_filter( 'views_edit-petrona_templates',array($this, 'admin_print_template_tabs'));
		add_filter( 'get_edit_post_link', array($this,'change_template_edit_link'), 10, 3  );
		add_filter( 'parse_query', array($this,'sort_templates_by_meta_value') );
	}

	/**
 	* Add menu_order to the list of permitted orderby values
 	*/
	function filter_add_rest_orderby_params( $params ) {
		$params['orderby']['enum'][] = 'menu_order';
		return $params;
	}

	public function register_post_types(){
		// $this->megamenu_posts();
		$this->portfolio_posts();
		$this->template_posts();
	}

    // public function megamenu_posts(){
       
    //     $labels = array(
    //         'name'               => __('Mega Menus', 'petrona'),
    //         'singular_name'      => __('Mega Menu', 'petrona'),
    //         'add_new'            => __('Add New', 'petrona'),
    //         'add_new_item'       => __('Add New Mega Menu', 'petrona'),
    //         'edit_item'          => __('Edit Mega Menu', 'petrona'),
    //         'new_item'           => __('New Mega Menu', 'petrona'),
    //         'view_item'          => __('View Mega Menu', 'petrona'),
    //         'search_items'       => __('Search Mega Menus', 'petrona'),
    //         'not_found'          => __('No Mega Menus found', 'petrona'),
    //         'not_found_in_trash' => __('No Mega Menus found in Trash', 'petrona'),
    //         'parent_item_colon'     => ''
    //     );
    //     register_post_type("petrona_megamenu", array(
    //         'labels'             => $labels,
    //         'public'             => true,
    //         'publicly_queryable' => true,
    //         'show_ui'            => true,
    //         'capability'         => 'manage_options',
    //         'show_in_menu'       => true,
    //         'query_var'          => true,
    //         'show_in_rest'       => true, // To use Gutenberg editor. 
    //         'show_in_nav_menus'  => true,
    //         'has_archive'        => true,
    //         'rewrite'            => true,        
    //         'hierarchical'       => false, 
    //         'menu_position'      => 12,
    //         'menu_icon'          => 'dashicons-editor-kitchensink',
    //         'supports'           => array( 'title', 'thumbnail', 'editor', 'excerpt', 'page-attributes' ),       
    //         'rewrite'            => array('slug' => 'megamenu'),
    //     ));
        
    // }

	public function portfolio_posts() {

		$portfolio_rewrite_slug = Techt_Utility::theme_options(array('portfolio_rewrite_slug', 'projects'));
		$portfolio_cat_rewrite_slug = Techt_Utility::theme_options(array('portfolio_cat_rewrite_slug', 'project-category'));
		/* Portfolio Custom Post*/
		$portfolio_label = array(
		    'name' => esc_html_x('Projects', 'Post Type General Name', 'petrona'),
		    'singular_name' => esc_html_x('Project', 'Post Type Singular Name', 'petrona'),
		    'menu_name' => esc_html__('Projects', 'petrona'),
		    'parent_item_colon' => esc_html__('Parent Project:', 'petrona'),
		    'all_items' => esc_html__('All Projects', 'petrona'),
		    'view_item' => esc_html__('View Project', 'petrona'),
		    'add_new_item' => esc_html__('Add New Project', 'petrona'),
		    'add_new' => esc_html__('New Project', 'petrona'),
		    'edit_item' => esc_html__('Edit Project', 'petrona'),
		    'update_item' => esc_html__('Update Project', 'petrona'),
		    'search_items' => esc_html__('Search Projects', 'petrona'),
		    'not_found' => esc_html__('No Project found', 'petrona'),
		    'not_found_in_trash' => esc_html__('No Project found in Trash', 'petrona'),
		);

		$portfolio_args = array(
		    'label' => esc_html__('Project', 'petrona'),
		    'description' => esc_html__('Project', 'petrona'),
		    'labels' => $portfolio_label,
		    'supports' => array('title', 'thumbnail', 'editor', 'excerpt'),
		    'taxonomies' => array('portfolio-category'),
		    'hierarchical' => true,
		    'show_in_rest' => true,
		    'public' => true,
		    'show_ui' => true,
		    'show_in_menu' => true,
		    'show_in_nav_menus' => true,
		    'show_in_admin_bar' => true,
		    'menu_position' => 20,
		    'menu_icon' => 'dashicons-screenoptions',
		    'can_export' => true,
		    'has_archive' => true,
		    'exclude_from_search' => true,
		    'publicly_queryable' => true,
		    'capability_type' => 'page',
		    'rewrite' => array('slug' => $portfolio_rewrite_slug),
		);

		register_post_type('portfolio', $portfolio_args);
		flush_rewrite_rules(); 

		// Add new taxonomy, make it hierarchical (like categories) 
		$portfolio_cat_taxonomy_labels = array(
		    'name'              => esc_html__( 'Project Categories', 'petrona' ),
		    'singular_name'     => esc_html__( 'Project Category', 'petrona' ),
		    'search_items'      => esc_html__( 'Search Project Categories', 'petrona' ),
		    'all_items'         => esc_html__( 'All Project Categories', 'petrona' ),
		    'parent_item'       => esc_html__( 'Parent Project Category', 'petrona' ),
		    'parent_item_colon' => esc_html__( 'Parent Project Category:', 'petrona' ),
		    'edit_item'         => esc_html__( 'Edit Project Category', 'petrona' ),
		    'update_item'       => esc_html__( 'Update Project Category', 'petrona' ),
		    'add_new_item'      => esc_html__( 'Add New Project Category', 'petrona' ),
		    'new_item_name'     => esc_html__( 'New Project Category Name', 'petrona' ),
		    'menu_name'         => esc_html__( 'Project Category', 'petrona' ),
		);    

		// Now register the portfolio taxonomy
		register_taxonomy('portfolio-category', array('portfolio'), array(
		    'hierarchical' => true,
		    'labels' => $portfolio_cat_taxonomy_labels,
		    'query_var' => true,
		    'show_ui' => true,
		    'show_in_rest' => true,
		    'show_admin_column' => true,
		    'has_archive' => true,
		    'rewrite' => array( 'slug' => $portfolio_cat_rewrite_slug ),
		));

		
	}

	public function template_posts() {
		$labels = array(
		    'name'                  => esc_html_x( 'Petrona Templates', 'Post Type General Name', 'petrona' ),
		    'singular_name'         => esc_html_x( 'Petrona Template', 'Post Type Singular Name', 'petrona' ),
		    'add_new_item'          => esc_html__( 'Add New Template', 'petrona' ),
		    'add_new'               => esc_html__( 'Add New', 'petrona' ),
		    'new_item'              => esc_html__( 'Add New Template', 'petrona' ),
		    'all_items'             => esc_html__( 'All Templates', 'petrona' ),
		    'edit_item'             => esc_html__( 'Edit Template', 'petrona' ),
		    'view_item'             => esc_html__( 'View Template', 'petrona' ),
		    'search_items'          => esc_html__( 'Search Template', 'petrona' ),
		    'not_found'             => esc_html__( 'No Templates Found', 'petrona' ),
		    'not_found_in_trash'    => esc_html__( 'No Templates Found in Trash', 'petrona' ),
		);
		$args = array(
		    'labels'                => $labels,
		    'supports'              => array( 'title', 'elementor' ),
		    'hierarchical'          => false,
		    'show_in_nav_menus'     => false,
		    'show_ui'             	=> true,
		    'public'                => true,
		    'menu_position'         => 22,
		    'menu_icon'             => 'dashicons-feedback',
		    'can_export'            => true,
		    'capability_type'       => 'page',
		    'exclude_from_search'   => true,
		    'rewrite' => array( 'slug' => 'petrona_templates' ),
		);
		register_post_type( 'petrona_templates', $args );
	}

	public function post_data_columns($columns) {
	    $columns['template_type'] = esc_html__('Template Type', 'petrona');
	    return $columns;
	}   

	public function template_show_columns($name) {
	    global $post;
		$temp_type = '';
	    switch ($name) {
	        case 'template_type':
	        	$temp_type = get_post_meta($post->ID, 'petrona_template_types', true);
				switch ($temp_type) {
					case 'header':
						echo esc_html__('Header', 'petrona');
						break;
					case 'footer':
						echo esc_html__('Footer', 'petrona');
						break;
					case 'block':
						echo esc_html__('Block', 'petrona');
						break;
					case 'megamenu':
						echo esc_html__('Mega Menu', 'petrona');
						break;
					case 'preloader':
						echo esc_html__('Preloader', 'petrona');
						break;
					default: echo esc_html__( 'Select For Template', 'petrona' );
				}
				// echo $temp_type;
	    }
	}   

	public function portfolio_data_columns($columns) {
	    $columns['post_id'] = esc_html__('ID', 'petrona');
	    return $columns;
	}

	public function portfolio_show_columns($name) {
	    global $post;
	    switch ($name) {
	        case 'post_id':
	            printf( '<input type="text" value="%1$s" onfocus="this.select();"  readonly="readonly">', $post->ID );
	    }
	}

	/**
	 * Add tabs for template types to admin templates list (edit.php) 
	 *
	 * @since  1.0
	 */
	public function admin_print_template_tabs( $views ) {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		// $temp_type_taxoomy_slug = 'templates_type';
		$temp_post_type_slug = 'petrona_templates';
		$active_class = ' nav-tab-active';
		$current_type = '';
		$temp_types = array(
			'header'   		=> __( 'Header', 'petrona' ),
			'footer'  		=> __( 'Footer', 'petrona' ),
			'block'  		=> __( 'Block',  'petrona' ),
			'megamenu' 		=> __( 'Mega Menu',  'petrona' ),
			'preloader' 	=> __( 'Preloader',  'petrona' ),
		);
	
		if ( ! empty( $_REQUEST[ 'template_type' ] ) ) {
			$current_type = $_REQUEST[ 'template_type' ];
			$active_class = '';
		}
	
		$baseurl = add_query_arg( 'post_type', $temp_post_type_slug, admin_url( 'edit.php' ) );
		?>
		<div id="petrona-builders-tabs" class="nav-tab-wrapper">
			<a class="nav-tab<?php echo esc_attr( $active_class ); ?>" href="<?php echo esc_url( $baseurl ); ?>"><?php esc_html_e( 'All', 'petrona' ); ?></a>
	
		<?php
		foreach ( $temp_types as $type => $label ) :
			$active_class = '';
			if ( $current_type === $type ) {
				$active_class = ' nav-tab-active';
			}
			$temp_url = add_query_arg( 'template_type', $type, $baseurl );
			echo '<a class="nav-tab' . $active_class . '" href="' . esc_url( $temp_url ) . '">' . esc_html( $label ) . '</a>';
		endforeach;
		?>
		</div>
		<?php
		return $views;
	}

	/**
	* Group templates by template type in each tab at admin templates list (edit.php) 
	*
	* @since  1.0
	*/
	public function sort_templates_by_meta_value($query) {
		global $pagenow;
		if (is_admin() && $pagenow=='edit.php' &&
			isset($_GET['post_type']) && $_GET['post_type']=='petrona_templates' &&
			isset($_GET['template_type']) && $query->query['post_type'] == 'petrona_templates') {
			$query->query_vars['orderby'] = 'meta_value';
			$query->query_vars['meta_key'] = 'petrona_template_types';
			$query->query_vars['meta_value'] = $_GET['template_type'];
		}
	}

	/**
	* Add template type to template post edit link 
	*
	* @since  1.0
	*/
	public function change_template_edit_link($link, $post_id, $context){
		if(get_query_var('post_type') !== 'petrona_templates'){
			return $link;
		}
		$type = get_post_meta($post_id, 'petrona_template_types', true) ? get_post_meta($post_id, 'petrona_template_types', true) : '';
		
		$edit_link = add_query_arg( 'petrona_template_types', $type, $link );
		return $edit_link;
	}

	/**
	 * Don't display the elementor header footer templates on the frontend for non edit_posts capable users.
	 *
	 * @since  1.0
	 */
	public function block_template_frontend() {
		if ( is_singular( 'petrona_templates' ) && ! current_user_can( 'edit_posts' ) ) {
			wp_redirect( site_url(), 301 );
			die;
		}
	}

	/**
	 * Single template function which will choose our template
	 *
	 * @since  1.0
	 *
	 * @param  String $single_template Single template.
	 */
	function load_canvas_template( $single_template ) {
		global $post;

		if ( in_array( $post->post_type, array( 'petrona_templates' ) ) ) {
			if( version_compare( ELEMENTOR_VERSION, '1.9.9', '<' ) ) {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			} else{
				return ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
			}
		}
		return $single_template;
	}

	/**
	 *  Petrona Support Elementor Editor By Default
	 *
	 * @package Petrona
	 * @since 1.0
	 */
	public function elementor_post_type_support() {
	    //if exists, assign to $cpt_support var
		$cpt_support = get_option( 'elementor_cpt_support' );
		
		//check if option DOESN'T exist in db
		if( ! $cpt_support ) {
		    $cpt_support = [ 'page', 'post', 'portfolio' ]; //create array of our default supported post types
		    update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
		} else if( ! in_array( 'portfolio', $cpt_support ) ) {
		    $cpt_support[] = 'portfolio'; //append to array
		    update_option( 'elementor_cpt_support', $cpt_support ); //update database
		}

		update_option( 'elementor_disable_color_schemes', 'yes' ); 
		update_option( 'elementor_disable_typography_schemes', 'yes' ); 
		update_option( 'elementor_allow_svg', '1' ); 		
		//otherwise do nothing, portfolio already exists in elementor_cpt_support option
	}

	public function portfolio_single_template( $template ) {
		global $post;
		if (  $post->post_type == 'portfolio' ) {
	        if ( file_exists( untrailingslashit( TECHT_MADULES_PATH ) . '/public/templates/single-portfolio.php' ) ) {
	            return untrailingslashit( TECHT_MADULES_PATH ) . '/public/templates/single-portfolio.php';
	        }
	    }
		return $template;
	}	

	public function portfolio_category_template( $template ) {
		$term = get_queried_object();
		
		if (  $term->taxonomy == 'portfolio-category' ) {
	        if ( file_exists( untrailingslashit( TECHT_MADULES_PATH ) . '/public/templates/portfolio-cat.php' ) ) {
	            return untrailingslashit( TECHT_MADULES_PATH ) . '/public/templates/portfolio-cat.php';
	        }
	    }
		return $template;
	}
	
	/**
    * This function modifies the main WordPress query to remove 
    * petrona templates and pages from search results.
    *
    * @param object $query The main WordPress query.
    */
    public function exclude_pages_from_search_results( $query ) {
        if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
            $query->set( 'post_type', array( 'post', 'portfolio' ) );
        }
        return $query;
    }

	function add_cpt_to_pll( $post_types, $is_settings ) {
		$post_types['portfolio'] = 'portfolio';
		$post_types['petrona_templates'] = 'petrona_templates';
		return $post_types;
	}

	function add_ctax_to_pll($taxonomies, $is_settings ){
		$taxonomies['portfolio_category'] = 'portfolio-category';
		return $taxonomies;
	}
    
}
Techt_Custom_post::instance();