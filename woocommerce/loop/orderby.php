<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$id_suffix = wp_unique_id();

?>
<div class="woocommerce-ordering">
	<div class="techt-dropdown d-flex">
		<div class="orderby-dropdown-box">
			<!-- <svg aria-labelledby="sortDownIconTitle" color="#2329D6" fill="none" height="25px" stroke="#2329D6" stroke-linecap="square" stroke-linejoin="miter" stroke-width="1" viewBox="0 0 24 24" width="48px" xmlns="http://www.w3.org/2000/svg"><title id="sortDownIconTitle"/><path d="M11 9H17"/><path d="M11 5H19"/><path d="M11 13H15"/><path d="M10 17L7 20L4 17"/><path d="M7 5V19"/></svg> -->
			<svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><polyline points="144 168 184 208 224 168" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12"/><line stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="184" x2="184" y1="112" y2="208"/><line stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="48" x2="120" y1="128" y2="128"/><line stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="48" x2="184" y1="64" y2="64"/><line stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="48" x2="104" y1="192" y2="192"/></svg>
			<?php if ( $use_label ) : ?>
				<span><?php echo esc_html__( 'Sort by', 'woocommerce' ); ?></span>
			<?php else : ?>
				<span><?php echo esc_html__( 'Sorting:', 'petrona' ); ?></span>
			<?php endif; ?>
			<span><?php echo $catalog_orderby_options[$orderby] ?></span>
		</div>
		<div class="dropdown-content">
			<?php foreach ( $catalog_orderby_options as $id => $name ) : 
				$link = sprintf('?orderby=%1$s', $id);
				$active = $orderby == $id ? 'active' : '';
				?>
				<a href="<?php echo $link; ?>" class="list-item <?php echo $active; ?>"><?php echo $name; ?></a>
			<?php endforeach; ?>
		</div>
	</div>
</div>
