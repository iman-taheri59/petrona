<?php
Class Techt_Title_Tag extends \Elementor\Core\DynamicTags\Tag {

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
		return 'techt-post-title';
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
		return esc_html__( 'Post Title', 'petrona' );
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
		echo wp_kses_post( get_the_title() );
	}
}