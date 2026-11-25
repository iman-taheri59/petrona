<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$hero_class = array('hero-block');
get_header_image() ? $hero_class[] = 'bg-image' : $hero_class[] = 'bg-soft-black';

$blog_main = array('blog-block');
$blog_main[] = 'blog-single-spacing';

if( techt_header_transparent() !== '' ) {
    $hero_class[] = techt_header_transparent();
    $blog_main[] = techt_header_transparent();
} 

$post_content_class = array();
$sidebar_content_class = array();
$post_content_class[] = 'shop-main-content';
$post_content_class[] = 'blog-block';
$sidebar_content_class = array();
$right = 'order-lg-first';
$left = 'order-lg-last';

if(  !is_active_sidebar( 'woo_sidebar' ) || Techt_Utility::theme_options('woo_sidebar_display') == 'full'  ) {
    $post_content_class[] = 'col-lg-12 full-content';
} elseif(  Techt_Utility::theme_options('woo_sidebar_display') == 'left' ) {
    $post_content_class[] = sprintf('col-lg-9 %s layout-content', $right);
    $sidebar_content_class[] = sprintf('col-lg-3 %1$s layout-sidebar', $left);
} else {
    $post_content_class[] = sprintf('col-lg-9 %s layout-content', $left);
    $sidebar_content_class[] = sprintf('col-lg-3 %1$s layout-sidebar', $right);
} ?>
<!-- Hero Block
================================================== -->
<section class="<?php echo esc_attr( join(' ',$hero_class) ); ?>" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>);">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pd-t-120 pd-b-120">
                	<?php
                		/**
						 * Hook: woocommerce_shop_loop_header.
						 *
						 * @since 8.6.0
						 *
						 * @hooked woocommerce_product_taxonomy_archive_header - 10
						 */
						do_action( 'woocommerce_shop_loop_header' );

						techt_enable_breadcrumb() === 'yes' ? \Techt_Core_Utility::techt_breadcrumbs() : '';
                	?>	
                </div>
            </div><!--  /.col-md-12 -->
        </div><!--  /.row -->
    </div><!--  /.container -->
</section><!--  /.hero-block -->
<?php
/**
* Hook: woocommerce_before_main_content.
*
* @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
* @hooked woocommerce_breadcrumb - 20
* @hooked WC_Structured_Data::generate_website_data() - 30
*/
do_action( 'woocommerce_before_main_content' ); ?>

<div id="main" class="<?php echo esc_attr( join(' ',$blog_main) ); ?>"<?php techt_schema_markup('main') ?>>
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( join(' ',$post_content_class) ); ?>">
				
				<?php
				if ( woocommerce_product_loop() ) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );

					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							/**
							 * Hook: woocommerce_shop_loop.
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				} ?>

			</div>
			<?php 
				if( Techt_Utility::theme_options('woo_sidebar_display') !=='full' || is_active_sidebar( "woo_sidebar" ) ) { ?>
				<div class="<?php echo esc_attr( join(' ',$sidebar_content_class) ); ?>"<?php techt_schema_markup('sidebar') ?>>
					<div class="sidebar-block">
				    <?php dynamic_sidebar( 'woo_sidebar' ); ?>
					</div><!--  /.sidebar-block -->
				</div><!-- /.col-lg-4 -->
				<?php }
			?>
		</div><!--  /.row -->
	</div><!--  /.container -->
</div>

<?php 
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' ); 
?>


<?php
get_footer( 'shop' );