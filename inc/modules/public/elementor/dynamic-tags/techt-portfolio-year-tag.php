<?php
Class Techt_Portfolio_Year_Tag extends \Elementor\Core\DynamicTags\Tag {

	/**
	* Get Name
	*
	* Returns the Name of the tag
	*
	* @since 1.0.0
	* @access public
	*
	* @return string
	*/
	public function get_name() {
		return 'techt-portfolio-year';
	}

	/**
	* Get Title
	*
	* Returns the title of the Tag
	*
	* @since 1.0.0
	* @access public
	*
	* @return string
	*/
	public function get_title() {
		return esc_html__( 'Portfolio activation year', 'petrona' );
	}
   
	/**
	* Get Group
	*
	* Returns the Group of the tag
	*
	* @since 1.0.0
	* @access public
	*
	* @return string
	*/
	public function get_group() {
		return Techt_Engine_Dynamic_Tags_Module::PETRONA;
	}

	/**
	* Get Categories
	*
	* Returns an array of tag categories
	*
	* @since 1.0.0
	* @access public
	*
	* @return array
	*/
	public function get_categories() {
		return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
	}

	/**
	* Render
	*
	* Prints out the value of the Dynamic tag
	*
	* @since 1.0.0
	* @access public
	*
	* @return void
	*/
	public function render() {
        if(get_post_type() != 'portfolio'){
            return;
        }
		echo wp_kses_post( \Techt_Utility::meta_options('portfolio_year') );
	}
}