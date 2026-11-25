<?php
/**
 * PowerPack WooCommerce Products - Product Title.
 *
 * @package PowerPack
 */

use PowerpackElements\Classes\PP_Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post, $product;

$settings = $this->get_settings_for_display();

$title_tag = ( $settings['title_html_tag'] ) ? $this->validate_html_tag( $settings['title_html_tag'] ) : 'h2';

echo '<' . esc_html( $title_tag ) . ' class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</' . esc_html( $title_tag ) . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
