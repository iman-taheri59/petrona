<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$hero_class = array('hero-block');
get_header_image() ? $hero_class[] = 'bg-image' : $hero_class[] = 'bg-soft-black';
if( techt_header_transparent() !== '' ) {
    $hero_class[] = techt_header_transparent();
} 
$single_main = array('shop-single-contents');
$single_main[] = 'blog-block-single';
$single_main[] = 'blog-single-spacing';
?>
<!-- Hero Block
================================================== -->
<section class="<?php echo esc_attr( join(' ',$hero_class) ); ?>" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pd-t-150 pd-b-150">
                	<?php
                		/**
                		 * woocommerce_before_main_content hook.
                		 *
                		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                		 * @hooked woocommerce_breadcrumb - 20
                		 */
                		// do_action( 'woocommerce_before_main_content' );
						// add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
						echo woocommerce_template_single_title();

						techt_enable_breadcrumb() === 'yes' ? \Techt_Core_Utility::techt_breadcrumbs() : '';
                	?>
                </div>
            </div><!--  /.col-md-12 -->
        </div><!--  /.row -->
    </div><!--  /.container -->
</section><!--  /.hero-block -->

<div id="main" class="<?php echo esc_attr( join(' ',$single_main) ); ?>"<?php techt_schema_markup('main') ?>>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">		
				<?php while ( have_posts() ) : ?>
					<?php the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>
				<?php
					/**
					 * woocommerce_after_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>
			</div><!--  /.col-lg-12 -->
		</div><!--  /.row -->
	</div><!--  /.container -->
</div>
<?php
get_footer( 'shop' );
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
