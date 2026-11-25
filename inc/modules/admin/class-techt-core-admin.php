<?php

class Techt_Core_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Techt_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Techt_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style('techt-select2', TECHT_MADULES_URL . '/admin/assets/css/select.css', false, $this->version, 'all');
		wp_enqueue_style($this->plugin_name, TECHT_MADULES_URL . '/admin/assets/css/metaboxes.css', array('wp-color-picker'), $this->version, 'all');
		if(! is_rtl()){
			wp_style_add_data( $this->plugin_name, 'ltr', 'replace' ); 
			wp_enqueue_style( $this->plugin_name, get_stylesheet_uri() );
		}
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Techt_Core_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Techt_Core_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('techt-select2', TECHT_MADULES_URL . '/admin/assets/js/select.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, TECHT_MADULES_URL . '/admin/assets/js/metaboxes.js', array('jquery', 'wp-color-picker'), $this->version, false);
		wp_enqueue_script('wp-color-picker-alpha', TECHT_MADULES_URL . '/admin/assets/js/wp-color-picker-alpha.min.js', array('jquery', 'wp-color-picker'), $this->version, false);
		wp_add_inline_script(
			'wp-color-picker-alpha',
			'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
		);
	}
}
