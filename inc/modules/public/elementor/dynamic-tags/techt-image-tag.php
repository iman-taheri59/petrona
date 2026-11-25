<?php
use Elementor\Controls_Manager;
Class Techt_Image_Tag extends \Elementor\Core\DynamicTags\Data_Tag {

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
		return 'techt-post-custom-image';
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
		return esc_html__( 'Featured Images', 'petrona' );
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
		return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
	}

	/**
	* Register Controls
	*
	* Registers the Dynamic tag controls
	*
	* @since 1.0.0
	* @access protected
	*
	* @return void
	*/
	protected function register_controls() {

		$this->add_control(
			'fallback_image',
			array(
				'label' => esc_html__( 'Fallback', 'petrona' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);
	}

	/**
	* Get The Value
	*
	* Registers the Dynamic tag controls
	*
	* @since 1.0.0
	* @access public
	*
	* @return void
	*/
	public function get_value( array $options = array() ) {

		$thumbnail_id = get_post_thumbnail_id();

		if ( $thumbnail_id ) {
			$image_data = [
				'id' => $thumbnail_id,
				'url' => wp_get_attachment_image_src( $thumbnail_id, 'full' )[0],
			];
		} else {
			$image_data = $this->get_settings( 'fallback_image' );
		}

		return $image_data;
	}
}