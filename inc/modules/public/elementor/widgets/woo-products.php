<?php
/**
 * PowerPack WooCommerce Products.
 *
 * @package PowerPack
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Woo_Products.
 */
class Woo_Products extends Techt_Base {

	/**
	 * Products Query
	 *
	 * @var query
	 */
	private $query = null;

	/**
	 * Has Template content
	 *
	 * @var _has_template_content
	 */
	protected $_has_template_content = false;

    /**
	 * Holds add to cart button text for simple products.
	 *
	 * @since 2.9.7
	 */
	public static $add_to_cart_text;

	/**
	 * Holds add to cart button text for variable products.
	 *
	 * @since 2.9.7
	 */
	public static $select_options_text;

	/**
	 * Holds add to cart button text for grouped products.
	 *
	 * @since 2.9.7
	 */
	public static $view_products_text;

	/**
	 * Holds read more button text for simple and variable products.
	 *
	 * @since 2.9.7
	 */
	public static $read_more_text;

	/**
	 * Retrieve Woo Product Grid Widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'techt-woo-products';
	}

	/**
	 * Retrieve Woo Product Grid Widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Products', 'petrona' );
	}

	/**
	 * Retrieve Woo Product Grid Widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'techt-category' ];
	}

	/**
	 * Get Script Depends.
	 *
	 * @access public
	 *
	 * @return array scripts.
	 */
	public function get_script_depends() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			return [
				'imagesloaded',
				'swiper',
				'pp-woo-product',
				'flexslider'
			];
		}

		$settings = $this->get_settings_for_display();
		$scripts  = [];

		if ( 'yes' === $settings['quick_view_type'] ) {
			array_push( $scripts, 'imagesloaded', 'flexslider', 'pp-woo-product' );
		}

		if ( 'slider' === $settings['products_layout_type'] ) {
			array_push( $scripts, 'swiper', 'pp-woo-product' );
		}

		return $scripts;
	}

	/**
	 * Retrieve the list of styles the Woo - Products widget depended on.
	 *
	 * Used to set style dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends() {
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			return [ 'e-swiper', 'pp-swiper', 'pp-elementor-grid', 'pp-woocommerce' ];
		}

		$settings = $this->get_settings_for_display();
		$styles   = [ 'pp-woocommerce' ];

		if ( Icons_Manager::is_migration_allowed() ) {
			array_push( $styles, 'elementor-icons-fa-solid', 'elementor-icons-fa-brands' );
		}

		if ( 'slider' === $settings['products_layout_type'] ) {
			array_push( $styles, 'e-swiper', 'pp-swiper' );
		} elseif ( 'grid' === $settings['products_layout_type'] ) {
			array_push( $styles, 'pp-elementor-grid' );
		}

		return $styles;
	}

	public function has_widget_inner_wrapper(): bool {
		return ! parent::is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Register Get Query.
	 *
	 * @access protected
	 */
	public function get_query() {
		return $this->query;
	}

	/**
	 * Register Woo - Products widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.3
	 * @access protected
	 */
	protected function register_controls() {
		/* Content Tab */
		$this->register_content_layout_controls();
		$this->register_content_slider_controls();
		$this->register_content_query_controls();
		$this->register_content_content_controls();
		$this->register_content_product_badges_controls();
		$this->register_image_controls();
		$this->register_quick_view_controls();
		$this->register_add_to_wishlist_controls();
		$this->register_content_pagination_controls();

		/* Style Tab */
		$this->register_style_layout_controls();
		$this->register_style_content_controls();
		$this->register_style_product_badges_controls();
		$this->register_quick_view_style_controls();
		$this->register_lightbox_style_controls();

		$this->register_style_pagination_controls();
		$this->register_style_arrows_controls();
		$this->register_style_dots_controls();
	}

	/**
	 * Register Woo Products Layout Controls.
	 *
	 * @access protected
	 */
	protected function register_content_layout_controls() {

		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'petrona' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'products_layout_type',
			array(
				'label'     => esc_html__( 'Layout', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'grid',
				'options'   => array(
					'grid'   => esc_html__( 'Grid', 'petrona' ),
					'slider' => esc_html__( 'Carousel', 'petrona' ),
				),
				'condition' => array(
					'products_template_type' => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
				),
			)
		);

        $this->add_control(
			'products_template_type',
			array(
				'label'     => esc_html__( 'Template', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => array(
                    'default' => esc_html__( 'Default', 'petrona' ),
					'skin-1' => esc_html__( 'Skin 1', 'petrona' ),
					'skin-2' => esc_html__( 'Skin 2', 'petrona' ),
                    'skin-3' => esc_html__( 'Skin 3', 'petrona' ),
                    'skin-4' => esc_html__( 'Skin 4', 'petrona' ),
                    'skin-5' => esc_html__( 'Skin 5', 'petrona' ),
                ),
			)
		);

		$this->add_responsive_control(
			'products_columns',
			array(
				'label'              => esc_html__( 'Columns', 'petrona' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => '4',
				'tablet_default'     => '3',
				'mobile_default'     => '1',
				'options'            => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'prefix_class'   => 'elementor-grid%s-',
				'frontend_available' => true,
				'condition'          => array(
					'products_template_type'    => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type'      => 'grid',
				),
			)
		);

		$this->add_control(
			'products_per_page',
			array(
				'label'     => esc_html__( 'Products Per Page', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '8',
				'condition' => array(
					'products_template_type'    => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type'      => 'grid',
					'source!'                   => 'main',
				),
			)
		);

		$this->add_control(
			'slider_products_per_page',
			array(
				'label'     => esc_html__( 'Total Products', 'petrona' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '8',
				'condition' => array(
					'products_template_type'  => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type'    => 'slider',
				),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'          => esc_html__( 'Products to Show', 'petrona' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 4,
				'tablet_default' => 3,
				'mobile_default' => 1,
				'condition'      => array(
					'products_template_type'    => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type'      => 'slider',
				),
			)
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			array(
				'label'          => esc_html__( 'Products to Scroll', 'petrona' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'condition'      => array(
					'products_template_type'    => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type'      => 'slider',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Woo Products Filter Controls.
	 *
	 * @access protected
	 */
	protected function register_content_query_controls() {

		$this->start_controls_section(
			'section_query',
			array(
				'label' => esc_html__( 'Query', 'petrona' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'source',
			array(
				'label'   => esc_html__( 'Source', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => array(
					'all'         => esc_html__( 'All Products', 'petrona' ),
					'custom'      => esc_html__( 'Custom Query', 'petrona' ),
					'manual'      => esc_html__( 'Manual Selection', 'petrona' ),
					'main'        => esc_html__( 'Main Query', 'petrona' ),
					'related'     => esc_html__( 'Related Products', 'petrona' ),
					'upsells'     => esc_html__( 'Upsells', 'petrona' ),
					'cross_sells' => esc_html__( 'Cross-Sells', 'petrona' ),
				),
			)
		);

		$this->add_control(
			'upsells_notice',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: The Upsells Query is available when creating a Single Product template.', 'petrona' ),
				'content_classes' => 'pp-editor-info',
				'condition'       => array(
					'source' => 'upsells',
				),
			)
		);

		$this->add_control(
			'cross_sells_notice',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: The Cross-Sells Query is available when creating a Cart page.', 'petrona' ),
				'content_classes' => 'pp-editor-info',
				'condition'       => array(
					'source' => 'cross_sells',
				),
			)
		);

		$this->add_control(
			'category_filter_rule',
			array(
				'label'     => esc_html__( 'Category Filter Rule', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'IN',
				'options'   => array(
					'IN'     => esc_html__( 'Match Categories', 'petrona' ),
					'NOT IN' => esc_html__( 'Exclude Categories', 'petrona' ),
				),
				'condition' => array(
					'source' => 'custom',
				),
			)
		);
		$this->add_control(
			'category_filter',
			array(
				'label'       => esc_html__( 'Select Categories', 'petrona' ),
				'type'          => 'techt-query',
				'post_type'     => '',
				'options'       => [],
				'label_block'   => true,
				'multiple'      => true,
				'query_type'    => 'terms-slug',
				'object_type'   => 'product_cat',
				'include_type'  => true,
				'condition'   => array(
					'source' => 'custom',
				),
			)
		);
		$this->add_control(
			'tag_filter_rule',
			array(
				'label'     => esc_html__( 'Tag Filter Rule', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'IN',
				'options'   => array(
					'IN'     => esc_html__( 'Match Tags', 'petrona' ),
					'NOT IN' => esc_html__( 'Exclude Tags', 'petrona' ),
				),
				'condition' => array(
					'source' => 'custom',
				),
			)
		);
		$this->add_control(
			'tag_filter',
			array(
				'label'       => esc_html__( 'Select Tags', 'petrona' ),
				'type'          => 'techt-query',
				'post_type'     => '',
				'options'       => [],
				'label_block'   => true,
				'multiple'      => true,
				'query_type'    => 'terms-slug',
				'object_type'   => 'product_tag',
				'include_type'  => true,
				'condition'   => array(
					'source' => 'custom',
				),
			)
		);
		$this->add_control(
			'offset',
			array(
				'label'       => esc_html__( 'Offset', 'petrona' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'description' => esc_html__( 'Number of post to displace or pass over.', 'petrona' ),
				'condition'   => array(
					'source' => 'custom',
				),
			)
		);

		$this->add_control(
			'query_manual_ids',
			array(
				'label'     => esc_html__( 'Select Products', 'petrona' ),
				'type'      => 'techt-query-posts',
				'post_type' => 'product',
				'multiple'  => true,
				'condition' => array(
					'source' => 'manual',
				),
			)
		);

		/* Exclude */
		$this->add_control(
			'query_exclude',
			array(
				'label'     => esc_html__( 'Exclude', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'source!' => array( 'manual', 'main', 'related', 'upsells', 'cross_sells' ),
				),
			)
		);
		$this->add_control(
			'query_exclude_ids',
			array(
				'label'       => esc_html__( 'Select Products', 'petrona' ),
				'type'        => 'techt-query-posts',
				'post_type'   => 'product',
				'multiple'    => true,
				'description' => esc_html__( 'Select products to exclude from the query.', 'petrona' ),
				'condition'   => array(
					'source!' => array( 'manual', 'main', 'related', 'upsells', 'cross_sells' ),
				),
			)
		);
		$this->add_control(
			'query_exclude_current',
			array(
				'label'        => esc_html__( 'Exclude Current Product', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
				'description'  => esc_html__( 'Enable this option to remove current product from the query.', 'petrona' ),
				'condition'    => array(
					'source!' => array( 'manual', 'main', 'related', 'upsells', 'cross_sells' ),
				),
			)
		);

		/* Advanced Filter */
		$this->add_control(
			'query_advanced',
			array(
				'label'     => esc_html__( 'Advanced', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'source!' => array( 'main' ),
				),
			)
		);
		$this->add_control(
			'filter_by',
			array(
				'label'     => esc_html__( 'Filter By', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''             => esc_html__( 'None', 'petrona' ),
					'featured'     => esc_html__( 'Featured', 'petrona' ),
					'sale'         => esc_html__( 'Sale', 'petrona' ),
					'top_rated'    => esc_html__( 'Top Rated', 'petrona' ),
					'best_selling' => esc_html__( 'Best Selling', 'petrona' ),
				),
				'condition' => array(
					'source!' => array( 'main', 'related', 'upsells', 'cross_sells' ),
				),
			)
		);
		$this->add_control(
			'orderby',
			array(
				'label'     => esc_html__( 'Order by', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'date',
				'options'   => array(
					'date'       => esc_html__( 'Date', 'petrona' ),
					'title'      => esc_html__( 'Title', 'petrona' ),
					'price'      => esc_html__( 'Price', 'petrona' ),
					'popularity' => esc_html__( 'Popularity', 'petrona' ),
					'rating'     => esc_html__( 'Rating', 'petrona' ),
					'rand'       => esc_html__( 'Random', 'petrona' ),
					'menu_order' => esc_html__( 'Menu Order', 'petrona' ),
				),
				'condition' => array(
					'source!' => array( 'main' ),
				),
			)
		);
		$this->add_control(
			'order',
			array(
				'label'     => esc_html__( 'Order', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'desc',
				'options'   => array(
					'desc' => esc_html__( 'Descending', 'petrona' ),
					'asc'  => esc_html__( 'Ascending', 'petrona' ),
				),
				'condition' => array(
					'source!' => array( 'main' ),
				),
			)
		);

		$this->add_control(
			'query_id',
			array(
				'label'       => esc_html__( 'Query ID', 'petrona' ),
				'description' => esc_html__( 'Give your Query a custom unique id to allow server side filtering', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'separator'   => 'before',
				'ai'          => [
					'active' => false,
				],
			)
		);

		$this->add_control(
			'no_products_heading',
			array(
				'label'     => esc_html__( 'If No Products Found', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'no_products_message',
			array(
				'label'   => esc_html__( 'Display Message', 'petrona' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'No products were found matching your selection.', 'petrona' ),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Control Section.
	 *
	 * @access protected
	 */
	protected function register_content_content_controls() {

		$this->start_controls_section(
			'section_content_field',
			array(
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'show_category',
			array(
				'label'        => esc_html__( 'Category', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_title',
			array(
				'label'        => esc_html__( 'Title', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1'   => esc_html__( 'H1', 'petrona' ),
					'h2'   => esc_html__( 'H2', 'petrona' ),
					'h3'   => esc_html__( 'H3', 'petrona' ),
					'h4'   => esc_html__( 'H4', 'petrona' ),
					'h5'   => esc_html__( 'H5', 'petrona' ),
					'h6'   => esc_html__( 'H6', 'petrona' ),
					'div'  => esc_html__( 'div', 'petrona' ),
					'span' => esc_html__( 'span', 'petrona' ),
					'p'    => esc_html__( 'p', 'petrona' ),
				),
				'condition' => [
					'show_title' => 'yes',
				],
			)
		);

		$this->add_control(
			'link_title',
			array(
				'label'        => esc_html__( 'Link Title to Product', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'link_title_target',
			array(
				'label'        => esc_html__( 'Open Link in a New Tab?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'show_title' => 'yes',
					'link_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_ratings',
			array(
				'label'        => esc_html__( 'Ratings', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);
		$this->add_control(
			'show_price',
			array(
				'label'        => esc_html__( 'Price', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'show_short_desc',
			array(
				'label'        => esc_html__( 'Short Description', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'show_add_cart',
			array(
				'label'        => esc_html__( 'Add to Cart', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			)
		);

		$this->add_control(
			'change_add_to_cart_text',
			array(
				'label'        => esc_html__( 'Change Button Text', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'add_to_cart_simple_text',
			array(
				'label'       => esc_html__( 'Add to Cart Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'description' => '',
				'condition'   => array(
					'show_add_cart' => 'yes',
					'change_add_to_cart_text' => 'yes',
				),
			)
		);

		$this->add_control(
			'add_to_cart_variable_text',
			array(
				'label'       => esc_html__( 'Select Options Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'description' => '',
				'condition'   => array(
					'show_add_cart' => 'yes',
					'change_add_to_cart_text' => 'yes',
				),
			)
		);

		$this->add_control(
			'add_to_cart_group_text',
			array(
				'label'       => esc_html__( 'View Products Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'description' => '',
				'condition'   => array(
					'show_add_cart' => 'yes',
					'change_add_to_cart_text' => 'yes',
				),
			)
		);

		$this->add_control(
			'add_to_cart_read_more_text',
			array(
				'label'       => esc_html__( 'Read More Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => '',
				'description' => '',
				'condition'   => array(
					'show_add_cart' => 'yes',
					'change_add_to_cart_text' => 'yes',
				),
			)
		);

		$this->add_control(
			'out_of_stock_text',
			array(
				'label'     => esc_html__( 'Out of Stock Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Out of Stock', 'petrona' ),
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Content Style Section.
	 *
	 * @access protected
	 */
	protected function register_style_content_controls() {

		$this->start_controls_section(
			'section_design_content',
			array(
				'label' => esc_html__( 'Content', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'alignment',
			array(
				'label'        => esc_html__( 'Alignment', 'petrona' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => esc_html__( 'Justify', 'petrona' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'      => 'right',
				// 'prefix_class' => 'pp-woo%s--align-',
			)
		);

		$this->add_control(
			'product_content_bg_color',
			array(
				'label'     => esc_html__( 'Content Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .pp-woo-products-summary-wrap' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'product_content_padding',
			array(
				'label'      => esc_html__( 'Content Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woo-products-summary-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'product_category_style',
			array(
				'label'     => esc_html__( 'Category', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_category' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_category_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-product-category, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_meta' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_category' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_category_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-woo-product-category',
				'condition' => array(
					'show_category' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_category_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-product-category, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_category' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_title_style',
			array(
				'label'     => esc_html__( 'Title', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_title_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-loop-product__link, {{WRAPPER}} .pp-woocommerce .woocommerce-loop-product__title, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_title' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_title_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-loop-product__link:hover .woocommerce-loop-product__title, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_title:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_title_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-loop-product__link, {{WRAPPER}} .pp-woocommerce .woocommerce-loop-product__title, .pp-quick-view-{{ID}} .woocommerce div.product .product_title',
				'condition' => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_title_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .woocommerce-loop-product__title, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_title' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_rating_style',
			array(
				'label'     => esc_html__( 'Rating', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_ratings' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_rating_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .star-rating, {{WRAPPER}} .pp-woocommerce .star-rating::before, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .star-rating, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .star-rating:before' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_ratings' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_rating_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .star-rating, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .woocommerce-product-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_ratings' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_price_style',
			array(
				'label'     => esc_html__( 'Price', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_price' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_price_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce li.product .price, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .price' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_price' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_price_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce li.product .price, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .price',
				'condition' => array(
					'show_price' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_price_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce li.product .price, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_price' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_short_desc_style',
			array(
				'label'     => esc_html__( 'Short Description', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_short_desc' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_short_desc_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-description, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .woocommerce-product-details__short-description' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_short_desc' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_short_desc_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-woo-products-description',
				'condition' => array(
					'show_short_desc' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'product_short_desc_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-description, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .woocommerce-product-details__short-description p:last-child' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_short_desc' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_add_cart_style',
			array(
				'label'     => esc_html__( 'Add to Cart', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array( 'skin-1' ),
				),
			)
		);

		$this->add_control(
			'product_actions_style',
			array(
				'label'     => esc_html__( 'Product Actions', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'show_add_cart'            => 'yes',
					'products_template_type'   => array( 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
				),
			)
		);

		$this->add_control(
			'actions_overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woo-skin-skin-5 .woocommerce-loop-product__link:before' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type' => 'skin-5',
				),
			)
		);

		$this->add_responsive_control(
			'product_add_cart_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button,
					{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap,
					.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->start_controls_tabs( 'product_add_cart_tabs_style' );

		$this->start_controls_tab(
			'product_add_cart_normal',
			array(
				'label'     => esc_html__( 'Normal', 'petrona' ),
				'condition' => array(
					'show_add_cart' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_add_cart_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button,
                    {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap,
                    {{WRAPPER}} .pp-product-actions .pp-action-item,
                    .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pp-product-actions .pp-action-item svg' => 'fill: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_view_cart_color',
			array(
				'label'     => esc_html__( 'View Cart Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .added_to_cart,
					.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .added_to_cart' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'product_add_cart_background_color',
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'types'     => array( 'classic', 'gradient' ),
				'exclude'   => array( 'image' ),
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button,
                {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap,
                .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button',
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type'  => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'product_add_cart_border',
				'label'     => esc_html__( 'Border', 'petrona' ),
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button,
                {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap,
                .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button',
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'product_add_cart_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button,
                {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap,
                .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type'  => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'product_actions_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap,
                    .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array( 'skin-2', 'skin-5' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'product_add_cart_typography',
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_responsive_control(
			'product_add_cart_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array('default', 'skin-1'),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_add_cart_hover',
			array(
				'label'     => esc_html__( 'Hover', 'petrona' ),
				'condition' => array(
					'show_add_cart' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_add_cart_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button:hover,
                    {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap:hover,
                    {{WRAPPER}} .pp-product-actions .pp-action-item-wrap:hover .pp-action-item,
                    .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
				),
			)
		);

		$this->add_control(
			'product_view_cart_hover_color',
			array(
				'label'     => esc_html__( 'View Cart Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .added_to_cart:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'product_add_cart_background_hover_color',
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button:hover,
                {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap:hover,
                .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button:hover',
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type'         => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'product_add_cart_border_hover_color',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-woo-products-summary-wrap .button:hover,
                {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap:hover,
                .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array('default', 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'product_actions_background_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-action-item-wrap:hover,
                    .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .button:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'show_add_cart' => 'yes',
					'products_template_type' => array( 'skin-2', 'skin-5' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'out_of_stock_style_heading',
			array(
				'label'     => esc_html__( 'Out of Stock Text', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'out_of_stock_text_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-out-of-stock' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'out_of_stock_text_background_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-out-of-stock' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'out_of_stock_text_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .pp-woocommerce .pp-out-of-stock',
			)
		);

		$this->add_control(
			'out_of_stock_text_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'petrona' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max'  => 1,
						'min'  => 0,
						'step' => 0.01,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-out-of-stock' => 'opacity: {{SIZE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Pagination Controls.
	 *
	 * @access protected
	 */
	protected function register_content_pagination_controls() {

		$this->start_controls_section(
			'section_pagination_field',
			array(
				'label'     => esc_html__( 'Pagination', 'petrona' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'products_template_type' => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
				),
			)
		);

		$this->add_control(
			'pagination_type',
			array(
				'label'     => esc_html__( 'Type', 'petrona' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''              => esc_html__( 'None', 'petrona' ),
					'numbers'       => esc_html__( 'Numbers', 'petrona' ),
					'numbers_arrow' => esc_html__( 'Numbers + Pre/Next Arrow', 'petrona' ),
				),
				'condition' => array(
					'products_template_type' => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
				),
			)
		);

		$this->add_control(
			'pagination_prev_label',
			array(
				'label'     => esc_html__( 'Previous Label', 'petrona' ),
				'default'   => esc_html__('←', 'petrona' ),
				'condition' => array(
					'products_template_type'  => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type'      => 'numbers_arrow',
				),
			)
		);

		$this->add_control(
			'pagination_next_label',
			array(
				'label'     => esc_html__( 'Next Label', 'petrona' ),
				'default'   => esc_html__( '→', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'default','skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type'      => 'numbers_arrow',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Product Badge Controls.
	 *
	 * @access protected
	 */
	protected function register_content_product_badges_controls() {

		$this->start_controls_section(
			'section_content_product_badge',
			array(
				'label' => esc_html__( 'Product Badges', 'petrona' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'sale_badge_heading',
			array(
				'label' => esc_html__( 'Sale', 'petrona' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'sale_badge_position',
			array(
				'label'   => esc_html__( 'Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'None', 'petrona' ),
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
				),
				'default' => 'right',
			)
		);

		$this->add_control(
			'sale_badge_custom_text',
			array(
				'label'       => esc_html__( 'Custom Text', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'description' => esc_html__( 'Show Sale % Value ( [value] Autocalculated offer value will replace this ).', 'petrona' ),
				'ai'          => [
					'active' => false,
				],
				'condition'   => array(
					'sale_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'featured_badge_heading',
			array(
				'label'     => esc_html__( 'Featured', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'featured_badge_position',
			array(
				'label'   => esc_html__( 'Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'None', 'petrona' ),
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'featured_badge_custom_text',
			array(
				'label'     => esc_html__( 'Custom Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'featured_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'top_rating_badge_heading',
			array(
				'label'     => esc_html__( 'Top Rated', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'top_rating_badge_position',
			array(
				'label'   => esc_html__( 'Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'None', 'petrona' ),
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'top_rating_badge_custom_text',
			array(
				'label'     => esc_html__( 'Custom Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'top_rating_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'number_of_ratings',
			array(
				'label'       => esc_html__( 'Rating', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '4',
				'description' => esc_html__( 'Show badge according to count of total rating greater than rating.', 'petrona' ),
				'ai'          => [
					'active' => false,
				],
				'condition'   => array(
					'top_rating_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'best_selling_badge_heading',
			array(
				'label'     => esc_html__( 'Best Selling', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'best_selling_badge_position',
			array(
				'label'   => esc_html__( 'Position', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'None', 'petrona' ),
					'left'  => esc_html__( 'Left', 'petrona' ),
					'right' => esc_html__( 'Right', 'petrona' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'best_selling_badge_custom_text',
			array(
				'label'     => esc_html__( 'Custom Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array(
					'best_selling_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'number_of_sales',
			array(
				'label'       => esc_html__( 'Number of Sales', 'petrona' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '1',
				'description' => esc_html__( 'Minimum number of sales.', 'petrona' ),
				'ai'          => [
					'active' => false,
				],
				'condition'   => array(
					'best_selling_badge_position!' => '',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register style Product Badges Controls.
	 *
	 * @access protected
	 */
	protected function register_style_product_badges_controls() {

		$this->start_controls_section(
			'section_style_product_badges',
			array(
				'label' => esc_html__( 'Product Badges', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'product_badge_margin',
			array(
				'label'      => esc_html__( 'Margin', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'default'    => array(
					'top'    => '10',
					'bottom' => '10',
					'left'   => '10',
					'right'  => '10',
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-badge-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'sale_badge_style_heading',
			array(
				'label'     => esc_html__( 'Sale', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'sale_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'sale_badge_style',
			array(
				'label'        => esc_html__( 'Style', 'petrona' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'circle' => esc_html__( 'Circle', 'petrona' ),
					'square' => esc_html__( 'Square', 'petrona' ),
					'ribbon' => esc_html__( 'Ribbon', 'petrona' ),
					'custom' => esc_html__( 'Custom', 'petrona' ),
				),
				'default'      => 'custom',
				'condition'    => array(
					'sale_badge_position!' => '',
				),
				'prefix_class' => 'pp-sale-badge-',
			)
		);

		$this->add_control(
			'sale_badge_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-sale-badge' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'sale_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'sale_badge_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-sale-badge' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'sale_badge_position!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'sale_badge_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-sale-badge',
				'condition' => array(
					'sale_badge_position!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'sale_badge_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
					'em' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'em',
				),
				'condition'  => array(
					'sale_badge_position!' => '',
					'sale_badge_style'     => array( 'circle', 'square', 'custom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-sale-badge' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

				),
			)
		);

		$this->add_responsive_control(
			'sale_badge_radius',
			array(
				'label'      => esc_html__( 'Rounded Corners', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'default'    => array(
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
					'unit'   => 'px',
				),
				'condition'  => array(
					'sale_badge_position!' => '',
					'sale_badge_style'     => 'custom',

				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-sale-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'sale_badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-sale-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '2',
					'bottom'   => '2',
					'left'     => '10',
					'right'    => '10',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'condition'  => array(
					'sale_badge_position!' => '',
					'sale_badge_style'     => 'custom',
				),
			)
		);

		$this->add_control(
			'featured_badge_style_heading',
			array(
				'label'     => esc_html__( 'Featured', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'featured_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'featured_badge_style',
			array(
				'label'        => esc_html__( 'Style', 'petrona' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'circle' => esc_html__( 'Circle', 'petrona' ),
					'square' => esc_html__( 'Square', 'petrona' ),
					'ribbon' => esc_html__( 'Ribbon', 'petrona' ),
					'custom' => esc_html__( 'Custom', 'petrona' ),
				),
				'default'      => 'custom',
				'condition'    => array(
					'featured_badge_position!' => '',
				),
				'prefix_class' => 'pp-featured-badge-',
			)
		);

		$this->add_control(
			'featured_badge_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-featured-badge' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'featured_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'featured_badge_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-featured-badge' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'featured_badge_position!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'featured_badge_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-featured-badge',
				'condition' => array(
					'featured_badge_position!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'featured_badge_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
					'em' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'em',
				),
				'condition'  => array(
					'featured_badge_position!' => '',
					'featured_badge_style'     => array( 'circle', 'square', 'custom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-featured-badge' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

				),
			)
		);

		$this->add_responsive_control(
			'featured_badge_radius',
			array(
				'label'      => esc_html__( 'Rounded Corners', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'default'    => array(
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
					'unit'   => 'px',
				),
				'condition'  => array(
					'featured_badge_position!' => '',
					'featured_badge_style'     => 'custom',

				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-featured-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'featured_badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-featured-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '2',
					'bottom'   => '2',
					'left'     => '10',
					'right'    => '10',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'condition'  => array(
					'featured_badge_position!' => '',
					'featured_badge_style'     => 'custom',
				),
			)
		);

		$this->add_control(
			'top_rating_badge_style_heading',
			array(
				'label'     => esc_html__( 'Top Rated', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'top_rating_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'top_rating_badge_style',
			array(
				'label'        => esc_html__( 'Style', 'petrona' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'circle' => esc_html__( 'Circle', 'petrona' ),
					'square' => esc_html__( 'Square', 'petrona' ),
					'ribbon' => esc_html__( 'Ribbon', 'petrona' ),
					'custom' => esc_html__( 'Custom', 'petrona' ),
				),
				'default'      => 'custom',
				'condition'    => array(
					'top_rating_badge_position!' => '',
				),
				'prefix_class' => 'pp-top-rated-badge-',
			)
		);

		$this->add_control(
			'top_rating_badge_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-top-rated-badge' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'top_rating_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'top_rating_badge_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-top-rated-badge' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'top_rating_badge_position!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'top_rating_badge_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-top-rated-badge',
				'condition' => array(
					'top_rating_badge_position!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'top_rating_badge_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
					'em' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'em',
				),
				'condition'  => array(
					'top_rating_badge_position!' => '',
					'top_rating_badge_style'     => array( 'circle', 'square', 'custom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-top-rated-badge' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

				),
			)
		);

		$this->add_responsive_control(
			'top_rating_badge_radius',
			array(
				'label'      => esc_html__( 'Rounded Corners', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'default'    => array(
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
					'unit'   => 'px',
				),
				'condition'  => array(
					'top_rating_badge_position!' => '',
					'top_rating_badge_style'     => 'custom',

				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-top-rated-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'top_rating_badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-top-rated-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '2',
					'bottom'   => '2',
					'left'     => '10',
					'right'    => '10',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'condition'  => array(
					'top_rating_badge_position!' => '',
					'top_rating_badge_style'     => 'custom',
				),
			)
		);

		$this->add_control(
			'best_selling_badge_style_heading',
			array(
				'label'     => esc_html__( 'Best Selling', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'best_selling_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'best_selling_badge_style',
			array(
				'label'        => esc_html__( 'Style', 'petrona' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'circle' => esc_html__( 'Circle', 'petrona' ),
					'square' => esc_html__( 'Square', 'petrona' ),
					'ribbon' => esc_html__( 'Ribbon', 'petrona' ),
					'custom' => esc_html__( 'Custom', 'petrona' ),
				),
				'default'      => 'custom',
				'condition'    => array(
					'best_selling_badge_position!' => '',
				),
				'prefix_class' => 'pp-best-selling-badge-',
			)
		);

		$this->add_control(
			'best_selling_badge_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-best-selling-badge' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'best_selling_badge_position!' => '',
				),
			)
		);

		$this->add_control(
			'best_selling_badge_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-best-selling-badge' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'best_selling_badge_position!' => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'best_selling_badge_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-best-selling-badge',
				'condition' => array(
					'best_selling_badge_position!' => '',
				),
			)
		);

		$this->add_responsive_control(
			'best_selling_badge_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 200,
					),
					'em' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'default'    => array(
					'size' => 2,
					'unit' => 'em',
				),
				'condition'  => array(
					'best_selling_badge_position!' => '',
					'best_selling_badge_style'     => array( 'circle', 'square', 'custom' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-best-selling-badge' => 'min-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',

				),
			)
		);

		$this->add_responsive_control(
			'best_selling_badge_radius',
			array(
				'label'      => esc_html__( 'Rounded Corners', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'default'    => array(
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
					'unit'   => 'px',
				),
				'condition'  => array(
					'best_selling_badge_position!' => '',
					'best_selling_badge_style'     => 'custom',

				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-best-selling-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'best_selling_badge_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-best-selling-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'default'    => array(
					'top'      => '2',
					'bottom'   => '2',
					'left'     => '10',
					'right'    => '10',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'condition'  => array(
					'best_selling_badge_position!' => '',
					'best_selling_badge_style'     => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Image Controls.
	 *
	 * @access protected
	 */
	protected function register_image_controls() {
		$this->start_controls_section(
			'section_design_image',
			array(
				'label' => esc_html__( 'Image', 'petrona' ),
			)
		);

		$this->add_control(
			'link_image',
			array(
				'label'        => esc_html__( 'Link to Product', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'link_image_target',
			array(
				'label'        => esc_html__( 'Open Link in New Tab?', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'link_image' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'thumbnail',
				'label'   => esc_html__( 'Image Size', 'petrona' ),
				'default' => 'woocommerce_thumbnail',
			)
		);

		$this->add_control(
			'products_hover_style',
			array(
				'label'   => esc_html__( 'Image Hover Effect', 'petrona' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''     => esc_html__( 'None', 'petrona' ),
					'swap' => esc_html__( 'Swap Images', 'petrona' ),
					'zoom' => esc_html__( 'Zoom Image', 'petrona' ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Quick View Controls.
	 *
	 * @access protected
	 */
	protected function register_quick_view_controls() {

		$this->start_controls_section(
			'section_content_quick_view',
			array(
				'label' => esc_html__( 'Quick View', 'petrona' ),
			)
		);

		$this->add_control(
			'quick_view_type',
			array(
				'label'        => esc_html__( 'Quick View', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'quick_view_text',
			array(
				'label'     => esc_html__( 'Quick View Text', 'petrona' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Quick View', 'petrona' ),
				'condition' => array(
					'quick_view_type!' => '',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Add to Wishlist Controls.
	 *
	 * @access protected
	 */
	protected function register_add_to_wishlist_controls() {

		if ( class_exists( 'YITH_WCWL' ) ) {
			$this->start_controls_section(
				'section_content_add_to_wishlist',
				array(
					'label' => esc_html__( 'Add to Wishlist', 'petrona' ),
				)
			);

			$this->add_control(
				'show_add_to_wishlist',
				array(
					'label'        => esc_html__( 'Add to Wishlist', 'petrona' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Show', 'petrona' ),
					'label_off'    => esc_html__( 'Hide', 'petrona' ),
					'return_value' => 'yes',
					'default'      => '',
				)
			);

			$this->add_control(
				'add_to_wishlist_type',
				array(
					'label'     => esc_html__( 'Add to Wishlist Type', 'petrona' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'text',
					'options'   => array(
						'icon' => esc_html__( 'Heart Icon', 'petrona' ),
						'text' => esc_html__( 'Text', 'petrona' ),
					),
					'condition' => array(
						'products_template_type'                => array('default', 'skin-1', 'skin-4' ),
						'show_add_to_wishlist' => 'yes',
					),
				)
			);

			$this->end_controls_section();
		}
	}

	/**
	 * Register Quick View Style Controls.
	 *
	 * @access protected
	 */
	protected function register_quick_view_style_controls() {

		$this->start_controls_section(
			'section_content_quick_view_style',
			array(
				'label'     => esc_html__( 'Quick View', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'quick_view_type' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-quick-view-btn span, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pp-woocommerce .pp-quick-view-btn svg' => 'fill: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-1', 'skin-2', 'skin-5' ),
				),
			)
		);

		$this->add_control(
			'quick_view_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-quick-view-btn, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-1', 'skin-2', 'skin-5' ),
				),
			)
		);

		$this->add_responsive_control(
			'product_quick_view_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3' ),
				),
			)
		);

		$this->start_controls_tabs( 'product_quick_view_tabs_style' );

		$this->start_controls_tab(
			'product_quick_view_normal',
			array(
				'label'     => esc_html__( 'Normal', 'petrona' ),
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'product_quick_view_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap,
                    {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap span,
                    {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn svg' => 'fill: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'product_quick_view_background_color',
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn',
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_quick_view_hover',
			array(
				'label'     => esc_html__( 'Hover', 'petrona' ),
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'product_quick_view_hover_color',
			array(
				'label'     => esc_html__( 'Text Hover Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap:hover,
                    {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap:hover span,
                    {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'product_quick_view_background_hover_color',
				'label'     => esc_html__( 'Background Hover Color', 'petrona' ),
				'types'     => array( 'classic', 'gradient' ),
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap:hover, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn:hover',
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'quick_view_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .pp-woocommerce .pp-quick-view-btn, {{WRAPPER}} .pp-woocommerce .pp-product-actions .pp-quick-view-btn .pp-action-item-wrap',
				'condition' => array(
					'quick_view_type' => 'yes',
					'products_template_type'           => array( 'skin-1', 'skin-3', 'skin-4' ),
				),
			)
		);

		$this->add_control(
			'quick_view_advanced_styling',
			array(
				'label'        => esc_html__( 'Advanced Styling', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'petrona' ),
				'label_off'    => esc_html__( 'Hide', 'petrona' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'quick_view_type' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_title_heading',
			array(
				'label'     => esc_html__( 'Title', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_title_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_title' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_title_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .product_title:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'quick_view_product_title_typography',
				'selector'  => '.pp-quick-view-{{ID}} .woocommerce div.product .product_title',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_rating_style',
			array(
				'label'     => esc_html__( 'Rating', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_rating_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .star-rating, .pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .star-rating:before' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_price_style',
			array(
				'label'     => esc_html__( 'Price', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_price_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .price' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'quick_view_product_price_typography',
				'selector'  => '.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .price',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_short_desc_style',
			array(
				'label'     => esc_html__( 'Short Description', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_control(
			'quick_view_product_short_desc_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .woocommerce-product-details__short-description' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'quick_view_product_short_desc_typography',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content .woocommerce-product-details__short-description',
				'condition' => array(
					'quick_view_type' => 'yes',
					'quick_view_advanced_styling' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Carousel Controls.
	 *
	 * @access protected
	 */
	protected function register_content_slider_controls() {
		$this->start_controls_section(
			'section_carousel_options',
			array(
				'label'     => esc_html__( 'Carousel Settings', 'petrona' ),
				'type'      => Controls_Manager::SECTION,
				'condition' => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->add_control(
			'transition_speed',
			array(
				'label'       => esc_html__( 'Transition Speed', 'petrona' ),
				'description' => esc_html__( 'Duration of transition between slides (in ms)', 'petrona' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 400,
				'condition'   => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'              => esc_html__( 'Autoplay', 'petrona' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'petrona' ),
				'label_off'          => esc_html__( 'No', 'petrona' ),
				'return_value'       => 'yes',
				'separator'          => 'before',
				'frontend_available' => true,
				'condition'          => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'              => esc_html__( 'Autoplay Speed', 'petrona' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 2000,
				'min'                => 500,
				'max'                => 5000,
				'step'               => 1,
				'frontend_available' => true,
				'condition'          => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'autoplay'             => 'yes',
				),
			)
		);

		$this->add_control(
			'grab_cursor',
			array(
				'label'              => esc_html__( 'Grab Cursor', 'petrona' ),
				'description'        => esc_html__( 'Shows grab cursor when you hover over the slider', 'petrona' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => '',
				'label_on'           => esc_html__( 'Yes', 'petrona' ),
				'label_off'          => esc_html__( 'No', 'petrona' ),
				'return_value'       => 'yes',
				'separator'          => 'before',
				'frontend_available' => true,
				'condition'          => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);
		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'petrona' ),
				'label_off'    => esc_html__( 'No', 'petrona' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'frontend_available'    => true,
				'condition'    => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'autoplay'             => 'yes',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'petrona' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->add_control(
			'navigation_heading',
			array(
				'label'     => esc_html__( 'Navigation', 'petrona' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'              => esc_html__( 'Arrows', 'petrona' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'petrona' ),
				'label_off'          => esc_html__( 'No', 'petrona' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
				'condition'          => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->add_control(
			'carousel_pagination',
			array(
				'label'              => esc_html__( 'Dots', 'petrona' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'petrona' ),
				'label_off'          => esc_html__( 'No', 'petrona' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
				'condition'          => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab
	 */
	/**
	 * Register Layout Controls.
	 *
	 * @access protected
	 */
	protected function register_style_layout_controls() {
		$this->start_controls_section(
			'section_design_layout',
			array(
				'label' => esc_html__( 'Layout', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'       => esc_html__( 'Columns Gap', 'petrona' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', 'rem', 'custom' ),
				'default'     => array(
					'size' => 20,
				),
				'range'       => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'row_gap',
			array(
				'label'      => esc_html__( 'Rows Gap', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'default'    => array(
					'size' => 35,
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'products_template_type'                => array('default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_box',
			array(
				'label' => esc_html__( 'Box', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'product_border',
				'label'     => esc_html__( 'Border', 'petrona' ),
				'selector'  => '{{WRAPPER}} .pp-woo-product-wrapper',
			)
		);

		$this->add_responsive_control(
			'product_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woo-product-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'product_box_padding',
			array(
				'label'      => esc_html__( 'Box Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woo-product-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'box_tabs_style' );

		$this->start_controls_tab(
			'box_normal',
			array(
				'label'     => esc_html__( 'Normal', 'petrona' ),
			)
		);

		$this->add_control(
			'product_box_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-woo-product-wrapper' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'product_box_shadow',
				'selector' => '{{WRAPPER}} .pp-woo-product-wrapper',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'box_hover',
			array(
				'label'     => esc_html__( 'Hover', 'petrona' ),
			)
		);

		$this->add_control(
			'product_box_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} li.product:hover .pp-woo-product-wrapper' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'product_box_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} li.product:hover .pp-woo-product-wrapper' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'product_box_shadow_hover',
				'selector' => '{{WRAPPER}} li.product:hover .pp-woo-product-wrapper',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Lightbox Style Controls.
	 *
	 * @access protected
	 */
	protected function register_lightbox_style_controls() {
		$this->start_controls_section(
			'section_content_lightbox_style',
			array(
				'label' => esc_html__( 'Lightbox', 'petrona' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'lightbox_overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.pp-quick-view-{{ID}} .pp-quick-view-bg' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'lightbox_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-modal .pp-lightbox-content' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'lightbox_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'.pp-quick-view-{{ID}} .pp-lightbox-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'lightbox_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'separator'   => 'before',
				'selector'    => '.pp-quick-view-{{ID}} .pp-lightbox-content',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'lightbox_box_shadow',
				'separator' => 'before',
				'selector'  => '.pp-quick-view-{{ID}} .pp-lightbox-content',
			)
		);

		$this->add_control(
			'close_icon_size',
			array(
				'label'      => esc_html__( 'Close Icon Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-close, .pp-quick-view-{{ID}} #pp-quick-view-close:before, .pp-quick-view-{{ID}} #pp-quick-view-close:after' => 'width: {{SIZE}}{{UNIT}};',
					'.pp-quick-view-{{ID}} #pp-quick-view-close' => 'height: {{SIZE}}{{UNIT}};',
				),
				'separator'  => 'before',
			)
		);

		$this->add_control(
			'close_icon_thickness',
			array(
				'label'      => esc_html__( 'Close Icon Thickness', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 5,
					),
				),
				'selectors'  => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-close:before, .pp-quick-view-{{ID}} #pp-quick-view-close:after' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'close_icon_color',
			array(
				'label'     => esc_html__( 'Close Icon Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'.pp-quick-view-{{ID}} #pp-quick-view-close:before, .pp-quick-view-{{ID}} #pp-quick-view-close:after' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Pagination Controls.
	 *
	 * @access protected
	 */
	protected function register_style_pagination_controls() {

		$this->start_controls_section(
			'section_design_pagination',
			array(
				'label'     => esc_html__( 'Pagination', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_align',
			array(
				'label'        => esc_html__( 'Alignment', 'petrona' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'petrona' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'petrona' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'petrona' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'      => 'center',
				'prefix_class' => 'pp-woo-pagination%s-align-',
				'condition'    => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'pagination_typography',
				'selector'  => '{{WRAPPER}} nav.woocommerce-pagination ul li > .page-numbers',
				'global'                => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),

			)
		);

		$this->start_controls_tabs( 'pagination_tabs_style' );

		$this->start_controls_tab(
			'pagination_normal',
			array(
				'label'     => esc_html__( 'Normal', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li > .page-numbers' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li > .page-numbers' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers, {{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_border_width',
			array(
				'label'      => esc_html__( 'Border Width', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers' => 'border-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_hover',
			array(
				'label'     => esc_html__( 'Hover', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers:focus, {{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_background_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers:focus, {{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_border_hover_color',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers:focus, {{WRAPPER}} nav.woocommerce-pagination ul li .page-numbers:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_active',
			array(
				'label'     => esc_html__( 'Active', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_active_color',
			array(
				'label'     => esc_html__( 'Text Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_background_active_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->add_control(
			'pagination_border_active_color',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'grid',
					'pagination_type!'     => '',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Register Navigation Controls.
	 *
	 * @access protected
	 */
	public function register_style_arrows_controls() {
		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'     => esc_html__( 'Arrows', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'select_arrow',
			array(
				'label'                  => esc_html__( 'Choose Arrow', 'petrona' ),
				'type'                   => Controls_Manager::ICONS,
				'fa4compatibility'       => 'arrow',
				'label_block'            => false,
				'default'                => array(
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				),
				'skin'                   => 'inline',
				'exclude_inline_options' => 'svg',
				'recommended'            => array(
					'fa-regular' => array(
						'arrow-alt-circle-right',
						'caret-square-right',
						'hand-point-right',
					),
					'fa-solid'   => array(
						'angle-right',
						'angle-double-right',
						'chevron-right',
						'chevron-circle-right',
						'arrow-right',
						'long-arrow-alt-right',
						'caret-right',
						'caret-square-right',
						'arrow-circle-right',
						'arrow-alt-circle-right',
						'toggle-right',
						'hand-point-right',
					),
				),
				'condition'          => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_position',
			array(
				'label'        => esc_html__( 'Position', 'petrona' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'outside',
				'options'      => array(
					'inside'  => esc_html__( 'Inside', 'petrona' ),
					'outside' => esc_html__( 'Outside', 'petrona' ),
				),
				'prefix_class' => 'pp-woo-slider-arrow-',
				'condition'    => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'arrows_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'default'    => array( 'size' => '22' ),
				'range'      => array(
					'px' => array(
						'min'  => 15,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-slider-arrow' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'arrows_spacing',
			array(
				'label'      => esc_html__( 'Align Arrows', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .pp-woo-products-slider .elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pp-woo-products-slider .elementor-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			array(
				'label'     => esc_html__( 'Normal', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-slider-arrow' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-slider-arrow' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'arrows_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .pp-slider-arrow',
				'condition'   => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'arrows_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-slider-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			array(
				'label'     => esc_html__( 'Hover', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-slider-arrow:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-slider-arrow:hover' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .pp-slider-arrow:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'arrows_padding',
			array(
				'label'      => esc_html__( 'Padding', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'vw', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .pp-slider-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator'  => 'before',
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	public function register_style_dots_controls() {
		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'     => esc_html__( 'Dots', 'petrona' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_position',
			[
				'label'                 => esc_html__( 'Position', 'petrona' ),
				'type'                  => Controls_Manager::SELECT,
				'options'               => [
					'inside'     => esc_html__( 'Inside', 'petrona' ),
					'outside'    => esc_html__( 'Outside', 'petrona' ),
				],
				'default'               => 'outside',
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			]
		);

		$this->add_responsive_control(
			'dots_size',
			array(
				'label'      => esc_html__( 'Size', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 2,
						'max'  => 40,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'dots_top_spacing',
			array(
				'label'      => esc_html__( 'Top Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-container-wrap-dots-outside .swiper-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-container-wrap-dots-inside .swiper-pagination' => 'bottom: -{{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'dots_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'petrona' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 30,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 ); margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			array(
				'label'     => esc_html__( 'Normal', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_color',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'dots_border',
				'label'       => esc_html__( 'Border', 'petrona' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet',
				'condition'   => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'dots_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'petrona' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem', 'custom' ),
				'selectors'  => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dots_box_shadow',
				'selector'  => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet',
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			array(
				'label'     => esc_html__( 'Active', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_color_active',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_border_color_active',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dots_box_shadow_active',
				'selector'  => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet.swiper-pagination-bullet-active',
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			array(
				'label'     => esc_html__( 'Hover', 'petrona' ),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_control(
			'dots_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'petrona' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'products_template_type'                => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'carousel_pagination'  => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'dots_box_shadow_hover',
				'selector'  => '{{WRAPPER}} .swiper-container-wrap .swiper-pagination-bullet:hover',
				'condition' => array(
					'products_template_type' => array( 'default', 'skin-1', 'skin-2', 'skin-3', 'skin-4', 'skin-5' ),
					'products_layout_type' => 'slider',
					'arrows'               => 'yes',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Get query products based on settings.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access public
	 */
	public function query_posts( $settings ) {

		//$settings = $this->get_settings_for_display();
		$query_id = $settings['query_id'];

		if ( ! empty( $query_id ) ) {
			add_action( 'pre_get_posts', array( $this, 'pre_get_product_query_filter' ) );
		}

		if ( 'main' === $settings['source'] ) {

			$query_args = $GLOBALS['wp_query']->query_vars;

			$this->query = new \WP_Query( $query_args );

		} elseif ( 'related' === $settings['source'] ) {

			if ( is_product() ) {

				global $product;

				$product_id                  = $product->get_id();
				$product_visibility_term_ids = wc_get_product_visibility_term_ids();

				$query_args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'paged'          => 1,
					'post__not_in'   => array(),
				);

				if ( 'grid' === $settings['products_layout_type'] ) {

					if ( $settings['products_per_page'] > 0 ) {
						$query_args['posts_per_page'] = $settings['products_per_page'];
					}

					if ( '' !== $settings['pagination_type'] ) {

						$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';

						if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'pp-product-nonce' ) ) {

							if ( isset( $_POST['page_number'] ) && '' !== $_POST['page_number'] ) {
								$paged = $_POST['page_number'];
							}
						}

						$query_args['paged'] = $paged;
					}
				} else {

					if ( $settings['slider_products_per_page'] > 0 ) {
						$query_args['posts_per_page'] = $settings['slider_products_per_page'];
					}
				}

				// Get current post categories and pass to filter.
				$product_cat = array();

				$product_categories = wp_get_post_terms( $product_id, 'product_cat' );

				if ( ! empty( $product_categories ) ) {

					foreach ( $product_categories as $key => $category ) {

						$product_cat[] = $category->slug;
					}
				}

				if ( ! empty( $product_cat ) ) {

					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $product_cat,
						'operator' => 'IN',
					);
				}

				// Exclude current product.
				$query_args['post__not_in'][] = $product_id;

				if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {

					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['outofstock'],
						'operator' => 'NOT IN',
					);
				}

				if ( ! empty( $product_visibility_term_ids['exclude-from-catalog'] ) ) {

					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $product_visibility_term_ids['exclude-from-catalog'],
						'operator' => 'NOT IN',
					);
				}

				// Default ordering args.
				$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

				$query_args['orderby'] = $ordering_args['orderby'];
				$query_args['order']   = $ordering_args['order'];

				$query_args = apply_filters( 'ppe_woo_product_query_args', $query_args, $settings );

				$this->query = new \WP_Query( $query_args );

			} else {

				$query_args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'paged'          => 1,
					'post__in'       => array( 0 ),
				);

				// Default ordering args.
				$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

				$query_args['orderby'] = $ordering_args['orderby'];
				$query_args['order']   = $ordering_args['order'];

				$query_args = apply_filters( 'ppe_woo_product_query_args', $query_args, $settings );

				$this->query = new \WP_Query( $query_args );
			}
		} elseif ( 'upsells' === $settings['source'] ) {
			global $product;

			if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'pp-product-nonce' ) ) {
				if ( isset( $_POST['product_id'] ) && ! empty( $_POST['product_id'] ) ) {
					$product_id = $_POST['product_id'];
				}
				$product = new \WC_Product( $product_id );
			}

			if ( is_product() && ! empty( $product->get_id() ) ) {

				$product_id  = $product->get_id();
				$upsells     = $product->get_upsell_ids();

				if ( ! empty( $upsells ) ) {

					$meta_query = WC()->query->get_meta_query();

					$query_args = [
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'paged'          => 1,
						'post__in'       => $upsells,
						'post__not_in'   => [ $product_id ],
						'meta_query'     => $meta_query,
					];

					if ( 'grid' === $settings['products_layout_type'] ) {
						if ( $settings['products_per_page'] > 0 ) {
							$query_args['posts_per_page'] = $settings['products_per_page'];
						}

						if ( '' !== $settings['pagination_type'] ) {
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
							if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'pp-product-nonce' ) ) {
								if ( isset( $_POST['page_number'] ) && '' !== $_POST['page_number'] ) {
									$paged = $_POST['page_number'];
								}
							}
							$query_args['paged'] = $paged;
						}
					} else {
						if ( $settings['slider_products_per_page'] > 0 ) {
							$query_args['posts_per_page'] = $settings['slider_products_per_page'];
						}
					}
				} else {
					$query_args = array(
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'paged'          => 1,
						'post__in'       => array( 0 ),
					);
				}
			} else {
				$query_args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'paged'          => 1,
					'post__in'       => array( 0 ),
				);
			}
			// Default ordering args.
			$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

			$query_args['orderby'] = $ordering_args['orderby'];
			$query_args['order']   = $ordering_args['order'];

			$query_args = apply_filters( 'ppe_woo_product_query_args', $query_args, $settings );

			$this->query = new \WP_Query( $query_args );
		} elseif ( 'cross_sells' === $settings['source'] ) {
			$cart_data = WC()->cart;
			if ( ! WC()->cart->is_empty() ) {

				$upsell_ids = $cart_item_ids = [];

				// Loop through cart items
				foreach( $cart_data->get_cart() as $cart_item ) {
					// Merge all cart items upsells ids.
					$upsell_ids      = array_merge( $upsell_ids, $cart_item['data']->get_upsell_ids() );
					$cart_item_ids[] = $cart_item['product_id'];
				}

				// Remove cart item ids from upsells.
				$upsell_ids = array_diff( $upsell_ids, $cart_item_ids );
				$upsell_ids = array_unique( $upsell_ids ); // Remove duplicated Ids.

				if ( ! empty( $upsell_ids ) ) {

					$meta_query = WC()->query->get_meta_query();

					$query_args = [
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'paged'          => 1,
						'post__in'       => $upsell_ids,
						'post__not_in'   => $cart_item_ids,
						'meta_query'     => $meta_query,
					];

					if ( 'grid' === $settings['products_layout_type'] ) {
						if ( $settings['products_per_page'] > 0 ) {
							$query_args['posts_per_page'] = $settings['products_per_page'];
						}

						if ( '' !== $settings['pagination_type'] ) {
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
							if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'pp-product-nonce' ) ) {
								if ( isset( $_POST['page_number'] ) && '' !== $_POST['page_number'] ) {
									$paged = $_POST['page_number'];
								}
							}
							$query_args['paged'] = $paged;
						}
					} else {
						if ( $settings['slider_products_per_page'] > 0 ) {
							$query_args['posts_per_page'] = $settings['slider_products_per_page'];
						}
					}
				} else {
					$query_args = array(
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'posts_per_page' => -1,
						'paged'          => 1,
						'post__in'       => array( 0 ),
					);
				}
			} else {
				$query_args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'paged'          => 1,
					'post__in'       => array( 0 ),
				);
			}
			// Default ordering args.
			$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

			$query_args['orderby'] = $ordering_args['orderby'];
			$query_args['order']   = $ordering_args['order'];

			$query_args = apply_filters( 'ppe_woo_product_query_args', $query_args, $settings );

			$this->query = new \WP_Query( $query_args );
		} else {

			global $post;
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();

			$query_args = array(
				'post_type'      => 'product',
				'posts_per_page' => -1,
				'paged'          => 1,
				'post__not_in'   => array(),
			);

			if ( 'grid' === $settings['products_layout_type'] ) {

				if ( $settings['products_per_page'] > 0 ) {
					$query_args['posts_per_page'] = $settings['products_per_page'];
				}

				if ( '' !== $settings['pagination_type'] ) {

					$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

					if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'pp-product-nonce' ) ) {

						if ( isset( $_POST['page_number'] ) && '' !== $_POST['page_number'] ) {
							$paged = $_POST['page_number'];
						}
					}

					$query_args['paged'] = $paged;
				}
			} else {

				if ( $settings['slider_products_per_page'] > 0 ) {
					$query_args['posts_per_page'] = $settings['slider_products_per_page'];
				}
			}

			// Default ordering args.
			/* $ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

			$query_args['orderby'] = $ordering_args['orderby'];
			$query_args['order']   = $ordering_args['order']; */

			if ( 'price' === $settings['orderby'] || 'popularity' === $settings['orderby'] || 'rating' === $settings['orderby'] ) {
				if ( 'price' === $settings['orderby'] ) {
					$query_args['meta_key'] = '_price';
				} elseif ( 'popularity' === $settings['orderby'] ) {
					$query_args['meta_key'] = 'total_sales';
				} elseif ( 'rating' === $settings['orderby'] ) {
					$query_args['meta_key'] = '_wc_average_rating';
				}

				$query_args['orderby'] = 'meta_value_num';
				$query_args['order']   = $settings['order'];
			} else {
				$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

				$query_args['orderby'] = $ordering_args['orderby'];
				$query_args['order']   = $ordering_args['order'];
			}

			if ( 'sale' === $settings['filter_by'] ) {

				$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			} elseif ( 'featured' === $settings['filter_by'] ) {

				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
			} elseif ( 'top_rated' === $settings['filter_by'] ) {
				$query_args['meta_key']   = '_wc_average_rating';
				$query_args['orderby']    = 'meta_value_num';
				$query_args['meta_query'] = WC()->query->get_meta_query();
				$query_args['tax_query']  = WC()->query->get_tax_query();
			} elseif ( 'best_selling' === $settings['filter_by'] ) {
				$query_args['meta_key'] = 'total_sales';
				$query_args['order']    = 'DESC';
				$query_args['orderby']  = 'meta_value_num';
			}

			if ( 'custom' === $settings['source'] ) {

				if ( ! empty( $settings['category_filter'] ) ) {

					$cat_operator = $settings['category_filter_rule'];

					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $settings['category_filter'],
						'operator' => $cat_operator,
					);
				}

				if ( ! empty( $settings['tag_filter'] ) ) {

					$tag_operator = $settings['tag_filter_rule'];

					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_tag',
						'field'    => 'slug',
						'terms'    => $settings['tag_filter'],
						'operator' => $tag_operator,
					);
				}

				if ( 0 < $settings['offset'] ) {

					/**
					 * Offser break the pagination. Using WordPress's work around
					 *
					 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
					 */
					$query_args['offset_to_fix'] = $settings['offset'];
				}
			}

			if ( 'manual' === $settings['source'] ) {

				$manual_ids = $settings['query_manual_ids'];

				$query_args['post__in'] = $manual_ids;
			}

			if ( 'manual' !== $settings['source'] ) {

				if ( '' !== $settings['query_exclude_ids'] ) {

					$exclude_ids = $settings['query_exclude_ids'];

					$query_args['post__not_in'] = $exclude_ids;
				}

				if ( 'yes' === $settings['query_exclude_current'] ) {

					$query_args['post__not_in'][] = $post->ID;
				}
			}

			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {

				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				);
			}

			if ( ! empty( $product_visibility_term_ids['exclude-from-catalog'] ) ) {

				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['exclude-from-catalog'],
					'operator' => 'NOT IN',
				);
			}

			$query_args = apply_filters( 'ppe_woo_product_query_args', $query_args, $settings );

			$this->query = new \WP_Query( $query_args );
		}

		remove_action( 'pre_get_posts', array( $this, 'pre_get_product_query_filter' ) );
	}

	/**
	 * pre_get_product_query_filter
	 *
	 * @param  mixed $wp_query
	 */
	public function pre_get_product_query_filter( $wp_query ) {
		$settings = $this->get_settings_for_display();
		$query_id = $settings['query_id'];

		/**
		 * Query args.
		 *
		 * It allows developers to alter individual products widget queries.
		 *
		 * The dynamic portion of the hook name '$query_id', refers to the Query ID.
		 *
		 * @since 2.9.7
		 *
		 * @param \WP_Query     $wp_query
		 */
		do_action( "powerpack/products/query/{$query_id}", $wp_query, $this );
	}

	private static function get_network_icon_data( $network_name ) {
		$prefix = 'fa ';
		$library = '';

		if ( Icons_Manager::is_migration_allowed() ) {
			$prefix = 'fas ';
			$library = 'fa-solid';
		}

		return [
			'value' => $prefix . 'fa-' . $network_name,
			'library' => $library,
		];
	}

	/**
	 * Change pagination arguments based on settings.
	 *
	 * @since 1.3.3
	 * @access protected
	 * @param string $located location.
	 * @param string $template_name template name.
	 * @param array  $args arguments.
	 * @param string $template_path path.
	 * @param string $default_path default path.
	 * @return string template location
	 */
	public function woo_pagination_template( $located, $template_name, $args, $template_path, $default_path ) {

		if ( 'loop/pagination.php' === $template_name ) {
			$located = woocommerce_pagination();
		}

		return $located;
	}

	/**
	 * Change pagination arguments based on settings.
	 *
	 * @since 1.3.3
	 * @access protected
	 * @param array $args pagination args.
	 * @return array
	 */
	public function woo_pagination_options( $args ) {

		$settings = $this->get_settings_for_display();

		$pagination_arrow = false;

		if ( 'numbers_arrow' === $settings['pagination_type'] ) {
			$pagination_arrow = true;
		}

		$args['prev_next'] = $pagination_arrow;

		if ( '' !== $settings['pagination_prev_label'] ) {
			$args['prev_text'] = $settings['pagination_prev_label'];
		}

		if ( '' !== $settings['pagination_next_label'] ) {
			$args['next_text'] = $settings['pagination_next_label'];
		}

		return $args;
	}

	/**
	 * Get Wrapper Classes.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function set_slider_attr() {

		$settings = $this->get_settings_for_display();

		if ( 'slider' !== $settings['products_layout_type'] ) {
			return;
		}

		$desktop_show = ( isset( $settings['slides_to_show'] ) && '' !== $settings['slides_to_show'] ) ? absint( $settings['slides_to_show'] ) : 4;
		$tablet_show  = ( isset( $settings['slides_to_show_tablet'] ) && '' !== $settings['slides_to_show_tablet'] ) ? absint( $settings['slides_to_show_tablet'] ) : 3;
		$mobile_show  = ( isset( $settings['slides_to_show_mobile'] ) && '' !== $settings['slides_to_show_mobile'] ) ? absint( $settings['slides_to_show_mobile'] ) : 1;

		$desktop_scroll = ( isset( $settings['slides_to_scroll'] ) && $settings['slides_to_scroll'] ) ? absint( $settings['slides_to_scroll'] ) : 1;
		$tablet_scroll  = ( isset( $settings['slides_to_scroll_tablet'] ) && $settings['slides_to_scroll_tablet'] ) ? absint( $settings['slides_to_scroll_tablet'] ) : 1;
		$mobile_scroll  = ( isset( $settings['slides_to_scroll_mobile'] ) && $settings['slides_to_scroll_mobile'] ) ? absint( $settings['slides_to_scroll_mobile'] ) : 1;

		$desktop_space = ( isset( $settings['column_gap']['size'] ) && $settings['column_gap']['size'] ) ? absint( $settings['column_gap']['size'] ) : 10;
		$tablet_space  = ( isset( $settings['column_gap_tablet']['size'] ) && $settings['column_gap_tablet']['size'] ) ? absint( $settings['column_gap_tablet']['size'] ) : 10;
		$mobile_space  = ( isset( $settings['column_gap_mobile']['size'] ) && $settings['column_gap_mobile']['size'] ) ? absint( $settings['column_gap_mobile']['size'] ) : 10;

		$slider_options = [
			'direction'             => 'horizontal',
			'slidesPerView'         => $desktop_show,
			'slidesPerGroup'        => $desktop_scroll,
			'speed'                 => ( $settings['transition_speed'] ) ? absint( $settings['transition_speed'] ) : 600,
			'spaceBetween'          => ( $settings['column_gap']['size'] ) ? $settings['column_gap']['size'] : 10,
			'loop'                  => ( 'yes' === $settings['infinite'] ),
			'disableOnInteraction'  => ( 'yes' === $settings['pause_on_hover'] ),
			'autoHeight'            => true,
			'watchSlidesVisibility' => true,
			'observer'              => true,
			'observeParents'        => true,
		];

		if ( 'yes' === $settings['autoplay'] && ! empty( $settings['autoplay_speed'] ) ) {
			$autoplay_speed = $settings['autoplay_speed'];
		} else {
			$autoplay_speed = 999999;
		}

		$slider_options['autoplay'] = array(
			'delay' => $autoplay_speed,
		);

		if ( 'yes' === $settings['arrows'] ) {
			$slider_options['navigation'] = array(
				'nextEl' => '.swiper-button-next-' . esc_attr( $this->get_id() ),
				'prevEl' => '.swiper-button-prev-' . esc_attr( $this->get_id() ),
			);
		}

		if ( 'yes' === $settings['carousel_pagination'] ) {
			$slider_options['pagination'] = array(
				'el'        => '.swiper-pagination-' . esc_attr( $this->get_id() ),
				'clickable' => true,
			);
		}

		$elementor_bp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_bp_md = get_option( 'elementor_viewport_md' );
		$bp_desktop      = ! empty( $elementor_bp_lg ) ? $elementor_bp_lg : 1025;
		$bp_tablet       = ! empty( $elementor_bp_md ) ? $elementor_bp_md : 768;
		$bp_mobile       = 320;

		$slider_options['breakpoints'] = array(
			$bp_desktop => array(
				'slidesPerView'  => $desktop_show,
				'slidesPerGroup' => $desktop_scroll,
				'spaceBetween'   => $desktop_space,
			),
			$bp_tablet  => array(
				'slidesPerView'  => $tablet_show,
				'slidesPerGroup' => $tablet_scroll,
				'spaceBetween'   => $tablet_space,
			),
			$bp_mobile  => array(
				'slidesPerView'  => $mobile_show,
				'slidesPerGroup' => $mobile_scroll,
				'spaceBetween'   => $mobile_space,
			),
		);

		$this->add_render_attribute(
			'wrapper', [
				'data-woo_slider' => wp_json_encode( $slider_options ),
			]
		);
	}

	/**
	 * Render Query.
	 *
	 * @since 1.1.0
	 */
	public function render_query() {

		$settings = $this->get_settings_for_display();

		$this->query_posts( $settings );

		$this->query = $this->get_query();
	}

	/**
	 * Render loop required arguments.
	 *
	 * @since 1.1.0
	 */
	public function render_loop_args() {

		$query = $this->get_query();

		global $woocommerce_loop;

		$settings = $this->get_settings_for_display();

		if ( 'grid' === $settings['products_layout_type'] ) {
			$woocommerce_loop['columns'] = (int) $settings['products_columns'];

			if ( 'main' !== $settings['source'] ) {
				if ( 0 < $settings['products_per_page'] && '' !== $settings['pagination_type'] ) {
					/* Pagination */
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

					if ( isset( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], 'pp-product-nonce' ) ) {
						if ( isset( $_POST['page_number'] ) && '' !== $_POST['page_number'] ) {
							$paged = $_POST['page_number'];
						}
					}
					$woocommerce_loop['paged']        = $paged;
					$woocommerce_loop['total']        = $query->found_posts;
					$woocommerce_loop['post_count']   = $query->post_count;
					$woocommerce_loop['per_page']     = $settings['products_per_page'];
					$woocommerce_loop['total_pages']  = ceil( $query->found_posts / $settings['products_per_page'] );
					$woocommerce_loop['current_page'] = $paged;
				}
			}

			$this->add_render_attribute(
				'inner', [
					'class' => [
						' columns-' . $woocommerce_loop['columns'],
					],
				]
			);
		} else {
			$woocommerce_loop['columns'] = '';
			if ( 'yes' === ( $settings['arrows'] || $settings['carousel_pagination'] ) ) {

				$this->add_render_attribute(
					'inner', [
						'class' => [
							'pp-slick-dotted',
						],
					]
				);
			}
		}
	}

	/**
	 * Pagination Structure.
	 *
	 * @since 1.1.0
	 */
	public function render_pagination_structure() {

		$settings = $this->get_settings_for_display();

		if ( 'grid' === $settings['products_layout_type'] ) {
			if ( '' !== $settings['pagination_type'] ) {
				// add_filter( 'wc_get_template', [ $this, 'woo_pagination_template' ], 10, 5 );
				add_filter( 'woocommerce_pagination_args', [ $this, 'woo_pagination_options' ] );
				woocommerce_pagination();
				remove_filter( 'woocommerce_pagination_args', [ $this, 'woo_pagination_options' ] );
				// remove_filter( 'wc_get_template', [ $this, 'woo_pagination_template' ], 10, 5 );
			}
		}
	}

	/**
	 * Render wrapper start.
	 *
	 * @since 1.1.0
	 */
	public function render_wrapper_start() {
		global $product;

		$settings = $this->get_settings_for_display();

		$skin = $settings['products_template_type'];
		$page_id = 0;

		if ( null !== \Elementor\Plugin::$instance->documents->get_current() ) {
			$page_id = \Elementor\Plugin::$instance->documents->get_current()->get_main_id();
		}

		$product_id = ( is_product() ) ? ( $product->get_id() ) : 0;

		$this->add_render_attribute(
			'wrapper', [
				'class' => [
					'woocommerce',
					'pp-woocommerce',
					'pp-woo-products-' . $settings['products_layout_type'],
					'pp-woo-skin-' . $skin,
					'pp-woo--align-' . $skin == 'default' ? 'center' : $settings['alignment'],
					'pp-woo-query-' . $settings['source'],
				],
				'data-page'        => $page_id,
				'data-skin'        => $skin,
				'data-product-id' => $product_id,
			]
		);

		if ( 'slider' === $settings['products_layout_type'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'swiper-container-wrap' );

			if ( $settings['dots_position'] ) {
				$this->add_render_attribute( 'wrapper', 'class', 'swiper-container-wrap-dots-' . $settings['dots_position'] );
			}
		}

		$this->set_slider_attr();

		echo '<div ' . wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ) . '>';
	}

	/**
	 * Render wrapper end.
	 *
	 * @since 1.1.0
	 */
	public function render_wrapper_end() {
		echo '</div>';
	}

	/**
	 * Render inner container start.
	 *
	 * @since 1.1.0
	 */
	public function render_inner_start() {
		$settings = $this->get_settings_for_display();

		$products_columns        = isset( $settings['products_columns'] ) ? $settings['products_columns'] : '4';
		$products_columns_tablet = isset( $settings['products_columns_tablet'] ) ? $settings['products_columns_tablet'] : '3';
		$products_columns_mobile = isset( $settings['products_columns_mobile'] ) ? $settings['products_columns_mobile'] : '1';

		$this->add_render_attribute(
			'inner', [
				'class' => [
					'pp-woo-products-inner',
					'pp-woo-product__column-' . $products_columns,
					'pp-woo-product__column-tablet-' . $products_columns_tablet,
					'pp-woo-product__column-mobile-' . $products_columns_mobile,
				],
			]
		);

		if ( '' !== $settings['products_hover_style'] ) {
			$this->add_render_attribute(
				'inner', [
					'class' => [
						'pp-woo-product__hover-' . $settings['products_hover_style'],
					],
				]
			);
		}

		if ( 'slider' === $settings['products_layout_type'] ) {
			$swiper_class = 'swiper';

			$this->add_render_attribute(
				'inner', [
					'class' => [
						'pp-swiper-slider',
						$swiper_class
					],
				]
			);

			if ( is_rtl() ) {
				$this->add_render_attribute( 'inner', 'dir', 'rtl' );
			}
		}

		echo '<div ' . wp_kses_post( $this->get_render_attribute_string( 'inner' ) ) . '>';
	}

	/**
	 * Render inner container end.
	 *
	 * @since 1.1.0
	 */
	public function render_inner_end() {
		echo '</div>';
	}

	/**
	 * Render woo loop start.
	 *
	 * @since 1.1.0
	 */
	public function render_woo_loop_start() {
		ob_start();

		// wc_set_loop_prop( 'loop', 0 );

		wc_get_template( 'loop/loop-start.php' );

		$loop_start = apply_filters( 'woocommerce_product_loop_start', ob_get_clean() );

		// if ( $echo ) {
		// 	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		// 	echo $loop_start;
		// } else {
			echo $loop_start;
		// }
	}

	public function add_to_cart_button_text( $text, $product ) {
		if ( 'simple' === $product->get_type() ) {
			$text = $product->is_purchasable() && $product->is_in_stock() ? self::$add_to_cart_text : self::$read_more_text;
		}

		if ( 'variable' === $product->get_type() ) {
			$text = $product->is_purchasable() ? self::$select_options_text : self::$read_more_text;
		}

		if ( 'grouped' === $product->get_type() ) {
			$text = self::$view_products_text;
		}

		return $text;
	}

	/**
	 * Render woo loop.
	 *
	 * @since 1.1.0
	 */
	public function render_woo_loop() {
		$settings = $this->get_settings_for_display();

		$query = $this->get_query();

		if ( 'yes' === $settings['show_add_cart'] && 'yes' === $settings['change_add_to_cart_text'] ) {
			self::$add_to_cart_text = $settings['add_to_cart_simple_text'] ? $settings['add_to_cart_simple_text'] : esc_html__( 'Add to cart', 'petrona' );
			self::$select_options_text = $settings['add_to_cart_variable_text'] ? $settings['add_to_cart_variable_text'] : esc_html__( 'Select options', 'petrona' );
			self::$view_products_text = $settings['add_to_cart_group_text'] ? $settings['add_to_cart_group_text'] : esc_html__( 'View products', 'petrona' );
			self::$read_more_text = $settings['add_to_cart_read_more_text'] ? $settings['add_to_cart_read_more_text'] : esc_html__( 'Read more', 'petrona' );

			add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'add_to_cart_button_text' ], 10, 2 );
		}

		while ( $query->have_posts() ) :
			$query->the_post();
			$this->render_woo_loop_template();
		endwhile;

		if ( 'yes' === $settings['show_add_cart'] && 'yes' === $settings['change_add_to_cart_text'] ) {
			remove_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'add_to_cart_button_text' ], 10, 2 );
		}
	}

	/**
	 * Render woo default template.
	 *
	 * @since 1.1.0
	 */
	public function render_woo_loop_template() {

        $settings = $this->get_settings_for_display();

        $template = $settings['products_template_type'];

		if($template == 'default'){
			wc_get_template_part( 'content', 'product' );
		}else{
			include $this->get_widget_template( 'content-product-' . $template );
		}
		
	}
	/**
	 * Render woo loop end.
	 *
	 * @since 1.1.0
	 */
	public function render_woo_loop_end() {
		// include POWERPACK_ELEMENTS_PATH . 'modules/woocommerce/templates/loop/loop-end.php';
        woocommerce_product_loop_end();
	}

	/**
	 * Render reset loop.
	 *
	 * @since 1.1.0
	 */
	public function render_reset_loop() {

		wc_reset_loop();

		wp_reset_postdata();
	}

	/**
	 * Quick View.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function quick_view_modal() {

		$settings = $this->get_settings_for_display();

		$quick_view_type = $settings['quick_view_type'];

		if ( '' !== $quick_view_type ) {
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'flexslider' );

			$widget_id = $this->get_id();

            include $this->get_widget_template( 'quick-view-modal' );
		}
	}

	/**
	 * Get Best Selling Product for Badge.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function is_best_selling_product( $product_id ) {

		$settings = $this->get_settings_for_display();

		$number_of_sales = $settings['number_of_sales'];

		if ( empty( $number_of_sales ) ) {
			return false;
		}

		$total_sales = get_post_meta( $product_id, 'total_sales', true );

		if ( ! $total_sales || empty( $total_sales ) ) {
			return false;
		}

		return $total_sales >= $number_of_sales;
	}

	/**
	 * Get Top Rated Product for Badge.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function is_top_rated_product( $product_id ) {

		$settings = $this->get_settings_for_display();

		$rating = $settings['number_of_ratings'];

		if ( empty( $rating ) ) {
			return false;
		}

		$total_rating = get_post_meta( $product_id, '_wc_average_rating', true );

		if ( ! $total_rating || empty( $total_rating ) ) {
			return false;
		}

		return $total_rating >= $rating;
	}

	/**
	 * Get Best Selling Product for Badge 1.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function is_best_selling_product_1( $product_id ) {

		$settings = $this->get_settings_for_display();

		$number_of_sales = $settings['number_of_sales_1'];

		if ( empty( $number_of_sales ) ) {
			return false;
		}

		$total_sales = get_post_meta( $product_id, 'total_sales', true );

		if ( ! $total_sales || empty( $total_sales ) ) {
			return false;
		}

		return $total_sales >= $number_of_sales;
	}

	/**
	 * Get Top Rated Product for Badge 1.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function is_top_rated_product_1( $product_id ) {

		$settings = $this->get_settings_for_display();

		$rating = $settings['number_of_rating_1'];

		if ( empty( $rating ) ) {
			return false;
		}

		$total_rating = get_post_meta( $product_id, '_wc_average_rating', true );

		if ( ! $total_rating || empty( $total_rating ) ) {
			return false;
		}

		return $total_rating >= $rating;
	}

	/**
	 * Get Best Selling Product for Badge 1.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function is_best_selling_product_2( $product_id ) {

		$settings = $this->get_settings_for_display();

		$number_of_sales = $settings['number_of_sales_2'];

		if ( empty( $number_of_sales ) ) {
			return false;
		}

		$total_sales = get_post_meta( $product_id, 'total_sales', true );

		if ( ! $total_sales || empty( $total_sales ) ) {
			return false;
		}

		return $total_sales >= $number_of_sales;
	}

	/**
	 * Get Top Rated Product for Badge 1.
	 *
	 * @since 1.3.3
	 * @access public
	 */
	public function is_top_rated_product_2( $product_id ) {

		$settings = $this->get_settings_for_display();
        
		$rating = $settings['number_of_rating_2'];

		if ( empty( $rating ) ) {
			return false;
		}

		$total_rating = get_post_meta( $product_id, '_wc_average_rating', true );

		if ( ! $total_rating || empty( $total_rating ) ) {
			return false;
		}

		return $total_rating >= $rating;
	}

    /**
	 * Product Flip Image.
	 *
	 * @param  string $image_size  Size of image.
	 * @since 1.0
	 */
	public function woo_shop_product_flip_image( $image_size ) {

		global $product;

		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids ) {

			// $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );

			echo apply_filters( 'pp_woocommerce_product_flip_image', wp_get_attachment_image( reset( $attachment_ids ), $image_size, false, array( 'class' => 'pp-show-on-hover' ) ) );
		}
	}

    /**
	 * Short Description.
	 *
	 * @since 1.0
	 */
	public function woo_shop_short_desc() {
		if ( has_excerpt() ) {
			echo '<div class="pp-woo-products-description">';
				echo wp_kses_post( get_the_excerpt() );
			echo '</div>';
		}
	}

    /**
	 * Product Categories.
	 *
	 * @since 2.9.11
	 */
	public function woo_shop_product_categories() { ?>
		<span class="pp-woo-product-category">
			<?php
			global $product;

			$product_categories = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( get_the_ID(), ',', '', '' ) : $product->get_categories( ',', '', '' );

			$product_categories = wp_strip_all_tags( $product_categories );

			if ( $product_categories ) {
				$product_categories_arr = explode( ',', $product_categories );
				$product_categories_list = implode( ', ', $product_categories_arr );

				echo esc_html( $product_categories_list );
			}
			?>
		</span> 
		<?php
	}

    /**
	 * Parent Category.
	 *
	 * @since 1.1.0
	 */
	public function woo_shop_parent_category() {
		if ( apply_filters( 'pp_woo_shop_parent_category', true ) ) : ?>
			<span class="pp-woo-product-category">
				<?php
				global $product;

				$product_categories = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( get_the_ID(), ',', '', '' ) : $product->get_categories( ',', '', '' );

				$product_categories = wp_strip_all_tags( $product_categories );

				if ( $product_categories ) {
					list( $parent_cat ) = explode( ',', $product_categories );
					$product_cat = apply_filters( 'pp_woo_products_category', $parent_cat, $parent_cat );

					echo esc_html( $product_cat );
				}
				?>
			</span> 
			<?php
		endif;
	}

	/**
	 * Render product body output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.4.0
	 * @access protected
	 */
	public function render_ajax_product_body( $widget ) {
		ob_start();

		// self::$settings = $widget->get_settings();

		$this->render_query();

		$this->render_loop_args();
		$this->render_woo_loop_start();
			$this->render_woo_loop();
		$this->render_woo_loop_end();

		return ob_get_clean();
	}

	/**
	 * Render product pagination HTML via AJAX call.
	 *
	 * @param array|string $widget    Widget object.
	 *
	 * @since 2.4.0
	 * @access public
	 */
	public function render_ajax_pagination( $widget ) {
		ob_start();

		// self::$settings = $widget->get_settings();

		$this->render_query();

		$this->render_pagination_structure();

		return ob_get_clean();
	}

	protected static function render_product_icon( $network_name ) {
		$network_icon_data = self::get_network_icon_data( $network_name );

		if ( parent::is_feature_active( 'e_font_icon_svg' ) ) {
			$icon = Icons_Manager::render_font_icon( $network_icon_data );
		} else {
			$icon = sprintf( '<i class="%s" aria-hidden="true"></i>', $network_icon_data['value'] );
		}

		\Elementor\Utils::print_unescaped_internal_string( $icon );
	}

	/**
	 * Render team member carousel dots output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_dots() {

		$settings = $this->get_settings_for_display();

		if ( 'slider' !== $settings['products_layout_type'] ) {
			return;
		}

		if ( 'yes' === $settings['carousel_pagination'] ) {
			?>
			<!-- Add Pagination -->
			<div class="swiper-pagination swiper-pagination-<?php echo esc_attr( $this->get_id() ); ?>"></div>
			<?php
		}
	}

	/**
	 * Render team member carousel arrows output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_arrows() {
		
        $settings = $this->get_settings_for_display();

		if ( 'slider' !== $settings['products_layout_type'] ) {
			return;
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();

		if ( ! isset( $settings['arrow'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default.
			$settings['arrow'] = 'fa fa-angle-right';
		}

		$has_icon = ! empty( $settings['arrow'] );

		if ( ! $has_icon && ! empty( $settings['select_arrow']['value'] ) ) {
			$has_icon = true;
		}

		if ( ! empty( $settings['arrow'] ) ) {
			$this->add_render_attribute( 'arrow-icon', 'class', $settings['arrow'] );
			$this->add_render_attribute( 'arrow-icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['select_arrow'] );
		$is_new = ! isset( $settings['arrow'] ) && $migration_allowed;

		if ( 'yes' === $settings['arrows'] ) {
			if ( $has_icon ) {
				if ( $is_new || $migrated ) {
					$next_arrow = $settings['select_arrow'];
					$prev_arrow = str_replace( 'right', 'left', $settings['select_arrow'] );
				} else {
					$next_arrow = $settings['arrow'];
					$prev_arrow = str_replace( 'right', 'left', $settings['arrow'] );
				}
			} else {
				$next_arrow = 'fa fa-angle-right';
				$prev_arrow = 'fa fa-angle-left';
			}

			if ( ! empty( $settings['arrow'] ) || ( ! empty( $settings['select_arrow']['value'] ) && $is_new ) ) { ?>
				<div class="pp-slider-arrow elementor-swiper-button-prev swiper-button-prev-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $prev_arrow, [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i <?php $this->print_render_attribute_string( 'arrow-icon' ); ?>></i>
					<?php endif; ?>
				</div>
				<div class="pp-slider-arrow elementor-swiper-button-next swiper-button-next-<?php echo esc_attr( $this->get_id() ); ?>">
					<?php if ( $is_new || $migrated ) :
						Icons_Manager::render_icon( $next_arrow, [ 'aria-hidden' => 'true' ] );
					else : ?>
						<i <?php $this->print_render_attribute_string( 'arrow-icon' ); ?>></i>
					<?php endif; ?>
				</div>
			<?php }
		}
	}

	/**
	 * Get no products found message.
	 *
	 * Returns the no products found message HTML.
	 *
	 * @since 2.7.7
	 * @access public
	 */
	public function render_empty() {
		
        $settings = $this->get_settings_for_display();

		?>
		<div class="pp-wooproducts-empty">
			<p><?php echo wp_kses_post( $settings['no_products_message'] ); ?></p>
		</div>
		<?php
	}

	/**
	 * Render Content.
	 *
	 * @since 1.3.3
	 * @access protected
	 */
	public function render() {

		$settings = $this->get_settings_for_display();
        
		$this->render_query();

		$query = $this->get_query();

		if ( ! $query->have_posts() ) {
			$this->render_empty();
			return;
		}

		$this->render_loop_args();
		$this->render_wrapper_start();
			$this->render_inner_start();
				$this->render_woo_loop_start();
					$this->render_woo_loop();
				$this->render_woo_loop_end();
				$this->render_pagination_structure();
				$this->render_reset_loop();
			$this->render_inner_end();
			if ( 'slider' === $settings['products_layout_type'] ) {
				$this->render_dots();
				$this->render_arrows();
			}
		$this->render_wrapper_end();

		$this->quick_view_modal();

	}
}

Plugin::instance()->widgets_manager->register( new Woo_Products() );
