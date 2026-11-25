<?php 
/**
 * WooCommerce Functions
 *
 * @package Petrona
 * @since 1.0
 */
if ( class_exists( 'WooCommerce' ) ) {

	// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

	// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');

	/* Declare WooCommerce support */
	add_action( 'after_setup_theme', 'techt_woocommerce_support' );
	function techt_woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}
   
	/* Gallery Support */
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/* Show Product Categories */
	add_action( 'woocommerce_shop_loop_item_title', 'techt_show_all_subcats', 5 );
 
	function techt_show_all_subcats() {
		global $product;
		$cats = get_the_terms( $product->get_id(), 'product_cat' );
		if ( empty( $cats ) ) return;
		// $html = '';
		$links = [];
		$html = '<div class="techt-woo-product-category">';
		foreach ($cats as $cat){
			$cat_url = get_term_link($cat);
			$cat_name = $cat->name;
			$html .= sprintf('<a class="cat-link" href="%1$s">%2$s</a>', $cat_url, $cat_name);
			// $links[] = $link;
		}
		
		// $html .= implode( ', ', $links );
		$html .= '</div>';
		echo $html;
		?>
		<!-- <span class="techt-woo-product-category"> -->
			<?php //echo join( ', ', $links ); ?>
		<!-- </span> -->
		<?php
	}

	/* Update Mini Cart Counter */
	add_filter( 'woocommerce_add_to_cart_fragments', 'wc_refresh_mini_cart_count');

	function wc_refresh_mini_cart_count($fragments){
		ob_start();
		$items_count = WC()->cart->get_cart_contents_count();
		?>
		<span class="techt-cart-counter"><?php echo $items_count; ?></span>
		<?php
		$fragments['.techt-cart-counter'] = ob_get_clean();
		return $fragments;
	}

	function custom_add_to_cart_message() {
		$return_to  = get_permalink(wc_get_page_id('shop'));
	
		if (get_option('woocommerce_cart_redirect_after_add')=='yes') {
			$message = sprintf('<a href="%s" class="button">%s</a> %s', get_permalink(wc_get_page_id('cart')), __('View Cart &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
		} else {
			$message = sprintf('<a href="%s" class="button">%s</a> %s', $return_to, __('Continue Shopping &rarr;', 'woocommerce'), __('Product successfully <h5>added</h5>to your cart.', 'woocommerce') );
		}
	
		return $message;
	}
	add_filter( 'wc_add_to_cart_message', 'custom_add_to_cart_message' );

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

	// remove title
	// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

	add_action( 'woocommerce_before_quantity_input_field', 'techt_display_quantity_minus' );
 
	function techt_display_quantity_minus() {
	   if ( ! is_product() ) return;
	   echo '<div class="btn-minus"><i class="icon"></i></div>';
	}
	
	add_action( 'woocommerce_after_quantity_input_field', 'techt_display_quantity_plus' );
	
	function techt_display_quantity_plus() {
	   if ( ! is_product() ) return;
	   echo '<div class="btn-plus"><i class="icon"></i></div>';
	}
	
	add_action( 'woocommerce_before_single_product', 'techt_add_cart_quantity_plus_minus' );
	
	function techt_add_cart_quantity_plus_minus() {
	   wc_enqueue_js( "
	      $('form.cart').on( 'click', 'div.btn-plus, div.btn-minus', function() {
	            var qty = $( this ).closest( 'form.cart' ).find( '.qty' );
	            var val   = parseFloat(qty.val());
	            var max = parseFloat(qty.attr( 'max' ));
	            var min = parseFloat(qty.attr( 'min' ));
	            var step = parseFloat(qty.attr( 'step' ));
	            if ( $( this ).is( '.btn-plus' ) ) {
	               if ( max && ( max <= val ) ) {
	                  qty.val( max );
	               } else {
	                  qty.val( val + step );
	               }
	            } else {
	               if ( min && ( min >= val ) ) {
	                  qty.val( min );
	               } else if ( val > 1 ) {
	                  qty.val( val - step );
	               }
	            }
	         });
	   " );
	}

	add_filter('woocommerce_sale_flash', 'on_sale_badge_saving_percentage', 20, 3);

	function on_sale_badge_saving_percentage($html, $post, $product){
		$text_prefix = __("Discount", 'petrona');
		$percentages = array();
		if($product->is_type('variable')) {
			$prices = $product->get_variation_prices();

			// loop through variation prices
			foreach( $prices['price'] as $key => $price ){
				$regular_price = (float) $prices['regular_price'][$key];
				$active_price = (float) $price;
				// only on sale variations
				if( $regular_price > $active_price ){
					// Calculate and set in the array the percentage for each variation on sale
					$percentages[] = ($regular_price - $active_price) / $regular_price * 100;
				}
			}
			$percentage = round( max($percentages), 0 ) . '%';
		} elseif ($product->is_type('grouped')){
			// Get all children products
			$children_products = array_filter( array_map('wc_get_product', $product->get_children() ), 'wc_products_array_filter_visible_grouped' );

			// loop through children products
			foreach( $children_products as $child_product ){
				if( $child_product->is_on_sale() ){
					$regular_price = (float) $child_product->get_regular_price();
					$active_price = (float) $child_product->get_sale_price();
					$percentages[] = 100 - ($active_price / $regular_price * 100); //Add Calculated percentage to the array 
				}
			}
			// We keep the highest value
			$percentage = round( max($percentages), 0 ) . '%';
		} else {
			$regular_price 	=  (float) $product->get_regular_price();
			$sale_pice 		= (float) $product->get_sale_price();

			if( $sale_pice != 0 || !empty($sale_pice) ){
				$percentage = round(100 - ($sale_pice / $regular_price * 100)) . '%';
			}
		}
		return sprintf('<span class="onsale">%s</span>', esc_html($text_prefix) . ' ' . $percentage);
	}

	add_action( 'wp_customize_add_to_cart_archive', function() {
		function wp_customize_add_to_cart_archive( $subject ) {
			if( ! is_admin() && is_archive() || is_tax() ) {
			$search = [
				'/>Add to cart</', // ... >< with the brackets, to be sure to target the right Home word
				// ... etc.
			];
			$replace = [
				'><i class="fas fa-play-circle"></i><', // ... Our replacement for Add to cart using a font awesome icon
				// ... etc.
			];
			$subject = preg_replace( $search, $replace, $subject );
			return $subject;
			};
		};
		ob_start( 'wp_customize_add_to_cart_archive' );
	} );

	/* Change WooCommerce loop title */
	function woocommerce_template_loop_product_title()
	{
		echo '<a class="product-title-link" href="' . get_the_permalink() . '"><h2 class="product-title woocommerce-loop-product__title">' . get_the_title() . '</h2></a>';
	}

	add_filter( 'woocommerce_add_to_cart_validation', 'filter_add_to_cart_validation', 10, 3 );
	function filter_add_to_cart_validation( $passed, $product_id, $quantity ) {
		$a = 0; // <===

		if( $a === 1 ){
			$passed = false; // Avoiding add to cart

			// (Optional) Display a custom eror notice
			wc_add_notice( __('Alert message: "add to cart avoided"', 'woocommerce' ), 'error' );
		}
		return $passed;
	}
}
