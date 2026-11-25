<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Techt_Engine_Dynamic_Tags_Module extends Elementor\Modules\DynamicTags\Module {

	const PETRONA = 'petrona';

	public function get_tag_classes_names() {

		$common_tags = array(
			'Techt_Image_Tag',
			'Techt_Title_Tag',
			'Techt_Excerpt_Tag',
		);
		$portfolio_tags = array(
			'Techt_Portfolio_Status_Tag',
			'Techt_Portfolio_Year_Tag',
			'Techt_Portfolio_Location_Tag',
			'Techt_Portfolio_Client_Tag',
		);

		if(get_post_type() != 'portfolio'){
			return $common_tags;
		}else{
			return array_merge($common_tags, $portfolio_tags);
		}
	}

	public function get_groups() {
		return array(
			self::PETRONA => array(
				'title' => esc_html__( 'Petrona', 'petrona' ),
			),
		);
	}

	/**
	 * Register tags.
	 *
	 * Add all the available dynamic tags.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param Manager $dynamic_tags
	 */
	public function register_tags( $dynamic_tags ) {

		foreach ( $this->get_tag_classes_names() as $tag_class ) {

			$file     = str_replace( '_', '-', strtolower( $tag_class ) ) . '.php';
			$filepath = plugin_dir_path( __FILE__ ) . 'dynamic-tags/' . $file;

			if ( file_exists( $filepath ) ) {
				require $filepath;
			}

			if ( class_exists( $tag_class ) ) {
				$dynamic_tags->register_tag( $tag_class );
			}

		}

	}
}