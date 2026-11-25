<?php

// Elementor Classes
use \Elementor\Control_Select2;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor query control.
 *
 * @since 1.0
 */
class Techt_Control_Query extends Control_Select2 {

	/**
	 * Get control type.
	 *
	 * Retrieve the control type, in this case `techt-query`.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'techt-query';
	}
}