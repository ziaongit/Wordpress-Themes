<?php
if ( ! defined( 'THEME_FRAMEWORK' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Add support to WooCommerce plugin. overrides some of its core functionality
 *
 * @author      Bob Ulusoy
 * @copyright   Artbees LTD (c)
 * @link        http://artbees.net
 * @since       5.1.0
 * @since       5.9.4
 * @package     artbees
 */

// Do not proceed if WooCommerce plugin is not active.
if ( ! class_exists( 'woocommerce' ) ) {
	return false;
};

/**
 * Get Theme Options data.
 *
 * @since 5.9.4
 */
$mk_options = get_option( THEME_OPTIONS );

/**
 * Declares support to WooCommerce.
 *
 * @since 5.1.0
 */
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/**
* Overrides to theme containers for wrapper starting part.
*
* @since 5.1.0
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );

/**
* Overrides to theme containers for wrapper starting part.
*
* @since 5.1.0
*/
if ( ! function_exists( 'mk_woocommerce_output_content_wrapper_start' ) ) {

	function mk_woocommerce_output_content_wrapper_start() {

		global $mk_options;
		$padding = '';

		if ( is_singular( 'product' ) ) {
			$page_layout = $mk_options['woocommerce_single_layout'];

		} elseif ( global_get_post_id() ) {

			$page_layout = get_post_meta( global_get_post_id() , '_layout', true );
			$padding = get_post_meta( global_get_post_id() , '_padding', true );

		} elseif ( mk_is_woo_archive() ) {
			$page_layout = get_post_meta( mk_is_woo_archive() , '_layout', true );
		}

		if ( isset( $_REQUEST['layout'] ) && ! empty( $_REQUEST['layout'] ) ) {
			$page_layout = esc_html( $_REQUEST['layout'] );
		}

			$page_layout = (isset( $page_layout ) && ! empty( $page_layout )) ? $page_layout : 'full';

			$padding = ($padding == 'true') ? 'no-padding' : '';

		Mk_Static_Files::addAssets( 'mk_message_box' );
		Mk_Static_Files::addAssets( 'mk_swipe_slideshow' );
	?>
	<div id="theme-page" class="master-holder clearfix" <?php echo get_schema_markup( 'main' ); ?>>
		<div class="master-holder-bg-holder">
			<div id="theme-page-bg" class="master-holder-bg js-el"></div> 
		</div>
		<div class="mk-main-wrapper-holder">
			<div class="theme-page-wrapper <?php echo $page_layout; ?>-layout <?php echo $padding; ?>  mk-grid">
				<div class="theme-content <?php echo $padding; ?>">
	<?php
	}

	add_action( 'woocommerce_before_main_content', 'mk_woocommerce_output_content_wrapper_start', 10 );

}// End if().

/**
* Overrides to theme containers for wrapper ending part.
*
* @since 5.1.0
*/
if ( ! function_exists( 'mk_woocommerce_output_content_wrapper_end' ) ) {

	function mk_woocommerce_output_content_wrapper_end() {
		global $mk_options;

		if ( is_singular( 'product' ) ) {
			$page_layout = $mk_options['woocommerce_single_layout'];
		} elseif ( global_get_post_id() ) {
			$page_layout = get_post_meta( global_get_post_id() , '_layout', true );
		} elseif ( mk_is_woo_archive() ) {
			$page_layout = get_post_meta( mk_is_woo_archive() , '_layout', true );
		}

		if ( isset( $_REQUEST['layout'] ) && ! empty( $_REQUEST['layout'] ) ) {
			$page_layout = $_REQUEST['layout'];
		}

			$page_layout = (isset( $page_layout ) && ! empty( $page_layout )) ? $page_layout : 'full';
			?>

					</div>
			<?php
			if ( 'full' !== $page_layout ) {
				get_sidebar(); }
?>
				<div class="clearboth"></div>
				</div>
			</div>
		</div>

	<?php
	}

	add_action( 'woocommerce_after_main_content', 'mk_woocommerce_output_content_wrapper_end', 10 );
}

/**
* Add a custom title to WooCommerce pages.
*
* @since 5.1.0
*/
if ( ! function_exists( 'mk_woocommerce_before_shop_loop' ) ) {

	function mk_woocommerce_before_shop_loop() {
		global $mk_options;
		if ( 'true' === $mk_options['woocommerce_use_category_filter_title'] && ! is_shop() ) {
			$title = single_cat_title( '', false );
		} else {
			$title = __( 'ALL PRODUCTS', 'mk_framework' );
		}
		echo "<h4 class=\"mk-woocommerce-shop-loop__title\">{$title}</h4>";
	}

	add_action( 'woocommerce_before_shop_loop', 'mk_woocommerce_before_shop_loop', 10 );

}

if ( ! function_exists( 'mk_woocommerce_header_add_to_cart_fragment' ) ) {

	/**
	 * Change add to cart fragment.
	 *
	 * @since 5.1.0
	 * @param array $fragments Th3 fragment of cart.
	 */
	function mk_woocommerce_header_add_to_cart_fragment( $fragments ) {

		ob_start();
		?>
		<a class="mk-shoping-cart-link" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>">
			<?php Mk_SVG_Icons::get_svg_icon_by_class_name( true, 'mk-moon-cart-2', 16 ); ?>
			<span class="mk-header-cart-count"><?php echo esc_html( WC()->cart->cart_contents_count ); ?></span>
		</a>
		<?php
		$fragments['a.mk-shoping-cart-link'] = ob_get_clean();

		return $fragments;
	}
	add_filter( 'woocommerce_add_to_cart_fragments', 'mk_woocommerce_header_add_to_cart_fragment' );

}

/**
 * Show cart widget (mini cart) in Cart and Checkout pages.
 *
 * @since 5.4.0
 * @param  boolean $is_cart Whether cart is active or not.
 * @return boolean          return false.
 */
function mk_filter_woocommerce_widget_cart_is_hidden( $is_cart ) {
	$is_cart = false;
	return $is_cart;
};

add_filter( 'woocommerce_widget_cart_is_hidden', 'mk_filter_woocommerce_widget_cart_is_hidden', 10, 1 );

if ( ! function_exists( 'mk_add_to_cart_responsive' ) ) {

	/**
	 * Add responsive cart.
	 */
	function mk_add_to_cart_responsive() {
		global $mk_options;

		$show_cart = isset( $mk_options['add_cart_responsive'] ) ? $mk_options['add_cart_responsive'] : 'true';

		if ( 'false' === $show_cart ) {
			return false;
		}

		?>
		<div class="add-cart-responsive-state">
			<a class="mk-shoping-cart-link" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>">
				<?php Mk_SVG_Icons::get_svg_icon_by_class_name( true, 'mk-moon-cart-2', 16 ); ?>
				<span class="mk-header-cart-count"><?php echo esc_html( WC()->cart->cart_contents_count ); ?></span>
			</a>
		</div>
		<?php
	}

	add_action( 'add_to_cart_responsive', 'mk_add_to_cart_responsive', 20 );

}

// Reorder title and rating on product loop.
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'mk_woocommerce_shop_loop_rating', 'woocommerce_template_loop_rating', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_rating', 10 );

if ( ! function_exists( 'mk_woocommerce_product_archive_description' ) ) {
	/**
	 * Overrides the archive loop product description
	 */
	function mk_woocommerce_product_archive_description() {

		if ( is_post_type_archive( 'product' ) ) {
			$shop_page = get_post( wc_get_page_id( 'shop' ) );
			if ( $shop_page ) {
				$description = apply_filters( 'the_content', $shop_page->post_content );
				if ( $description ) {
					// @codingStandardsIgnoreLine
					echo $description;
				}
			}
		}

	}

	add_action( 'woocommerce_archive_description', 'mk_woocommerce_product_archive_description', 10 );
}

/**
* Return if Customise shop is enabled.
*
* @since 5.9.4
*/
if ( ! empty( $mk_options['shop_customizer'] ) && 'true' === $mk_options['shop_customizer'] ) {
	return;
};

require_once( THEME_DIR . '/woocommerce/hooks.php' );
