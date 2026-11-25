<?php

class Techt_Core {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Techt_Core_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TECHT_CORE_VERSION' ) ) {
			$this->version = TECHT_CORE_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'techt-core';
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Techt_Core_Loader. Orchestrates the hooks of the plugin.
	 * - Techt_Core_i18n. Defines internationalization functionality.
	 * - Techt_Core_Admin. Defines all hooks for the admin area.
	 * - Techt_Core_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once TECHT_MADULES_PATH . '/includes/class-techt-core-loader.php';		

		/**
		 * The Post like features
		 */
		require_once TECHT_MADULES_PATH . '/includes/post-like.php';	
		
		/**
		 * The login/register features
		 */
		require_once TECHT_MADULES_PATH . '/includes/login-register.php';

		require_once TECHT_MADULES_PATH . '/includes/class-techt-download-handler.php'; 

		/**
		 * The Image Resizer Scripts
		 */
		require_once TECHT_MADULES_PATH . '/includes/aq_resizer.php';		

		/**
		* Core Utility File
		*/
		require_once TECHT_MADULES_PATH . '/includes/class-techt-core-utility.php';		

		/**
		 * Common Functions
		*/
		require_once TECHT_MADULES_PATH . '/includes/techt-common.php';	

		/**
		 * Custom Post Type
		*/
		require_once TECHT_MADULES_PATH . '/includes/class-techt-custom-post.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once TECHT_MADULES_PATH . '/admin/class-techt-core-admin.php';		

		/**
		 * The class loading all meta box for page, portfolio, posts and templates.
		 */
		require_once TECHT_MADULES_PATH . '/admin/metaboxes/metaboxes.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once TECHT_MADULES_PATH . '/public/class-techt-core-public.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once TECHT_MADULES_PATH . '/public/elementor/class-techt-elementor.php';

        
        require_once TECHT_MADULES_PATH . '/includes/nav_menu_fields.php';

		$this->loader = new Techt_Core_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Techt_Core_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Techt_Core_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}



	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		
		$this->loader->run();
		
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Techt_Core_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
