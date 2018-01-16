<?php
/**
 * WooCommerce hooks actions and filters.
 *
 * @package Jupiter
 * @subpackage MK_Customizer
 * @since 5.9.4
 */

// Remove default shop page title.
add_filter( 'woocommerce_show_page_title', '__return_false' );

// Filter for shop archive page products per page.
add_filter( 'loop_shop_per_page', function( $per_page ) {

	if ( is_shop() || is_product_category() || is_product_tag() ) {

		$row_count = mk_cz_get_option( 'sh_pl_set_rows', 3 );
		$col_count = mk_cz_get_option( 'sh_pl_set_columns', 4 );

		if ( $row_count && $col_count && is_numeric( $row_count ) && is_numeric( $col_count ) ) {
			return $row_count * $col_count;
		}
	}

	return $per_page;

}, 10 );

// Filter for shop archive page products per row.
add_filter( 'loop_shop_columns', function( $columns ) {

	if ( is_shop() || is_product_category() || is_product_tag() ) {
		return mk_cz_get_option( 'sh_pl_set_columns', $columns );
	}

	return $columns;

}, 100 );

add_filter( 'body_class', function( $classes ) {
	return array_merge( $classes, array(
		'columns-' . mk_cz_get_option( 'sh_pl_set_columns', 4 ),
		'mk-sh-pl-hover-style-' . mk_cz_get_option( 'sh_pl_set_hover_style', 'none' ),
	) );
} );

// Filter the add to cart button text.
add_filter( 'woocommerce_product_add_to_cart_text', function( $text, $product ) {

	if ( ! $product->is_type( 'simple' ) || ! $product->is_in_stock() ) {
		return $text;
	}

	if ( is_shop() || is_product_category() || is_product_tag() ) {
		return mk_cz_get_option( 'sh_pl_sty_atc_btn_text', $text );
	}

	return $text;

}, 10, 2 );

// Add out of stock badge on product list.
add_action( 'woocommerce_shop_loop_item_title', function() {

	global $product;

	if ( ! $product->is_in_stock() ) {
		echo '<span class="mk-out-of-stock">' . esc_html( mk_cz_get_option( 'sh_pl_sty_oos_bdg_text', 'Out of Stock' ) ) . '</span>';
	}
} );

// Filter the price variation separator.
add_filter( 'woocommerce_get_price_html', function( $price, $product ) {
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		if ( $product->get_price() && $product->is_type( 'variable' ) && $product->is_on_sale() && strpos( $price, '&ndash;' ) !== false ) {
			$price = '<ins>' . $price . '</ins>';
		}
		return str_replace( '&ndash;', '<span class="mk-price-variation-seprator">&ndash;</span>', $price );
	}
	return $price;
}, 100, 2 );

// Filter star rating on product list.
add_filter( 'woocommerce_product_get_rating_html', function( $rating_html, $rating ) {

	if ( $rating > 0 ) {
		/* translators: %s: rating. */
		$rating_html = '<div class="star-rating" title="' . sprintf( esc_attr__( 'Rated %s out of 5', 'mk_framework' ), $rating ) . '">';
		$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"></span>';
		$rating_html .= '</div>';
	} else {
		$rating_html  = '';
	}

	return $rating_html;

}, 10, 2 );

// Start product container in product list.
add_filter( 'woocommerce_before_shop_loop_item', function() {
		echo '<div class="mk-product-warp">';
}, 0 );

// End product container in product list.
add_filter( 'woocommerce_after_shop_loop_item', function() {
	echo '</div>';
}, 999 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

add_filter( 'single_product_archive_thumbnail_size', function( $size ) {

	$columns = apply_filters( 'loop_shop_columns', 4 );
	$grid_width = mk_get_option( 'grid_width', 1140 );

	$width = round( $grid_width / $columns );
	$image_ratio = mk_cz_get_option( 'sh_pl_set_image_ratio', '1_by_1' );

	switch ( $image_ratio ) {
		case '16_by_9':
			$height = round( ($width * 9) / 16 );
			break;
		case '3_by_2':
			$height = round( ($width * 2) / 3 );
			break;
		case '4_by_3':
			$height = round( ($width * 3) / 4 );
			break;
		case '3_by_4':
			$height = round( ($width * 4) / 3 );
			break;
		case '2_by_3':
			$height = round( ($width * 3) / 2 );
			break;
		case '9_by_16':
			$height = round( ($width * 16) / 9 );
			break;

		default:
			$height = $width;
			break;
	}

	$size = array( $width, $height );

	return $size;
} );

add_action( 'woocommerce_before_shop_loop_item_title', function() {
	global $product;
	?>
	<div class="mk-product-thumbnail-warp">
	<?php
	woocommerce_template_loop_product_thumbnail();
	if ( has_post_thumbnail() && 'alternate' === mk_cz_get_option( 'sh_pl_set_hover_style' ) ) {
		$size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_thumbnail' );
		$hover_image_ids = $product->get_gallery_image_ids();
		if ( $hover_image_ids ) {
			$hover_image_id = $hover_image_ids[0];
			echo wp_get_attachment_image( $hover_image_id, $size, false, array(
				'class' => 'mk-product-thumbnail-hover',
			) );
		}
	}
	?>
	</div>
	<?php
}, 9 );

// Filter the sale badge for products list.
add_filter( 'woocommerce_sale_flash', function( $html, $post, $product ) {

	if ( ! $product->is_in_stock() || ! $product->is_on_sale() ) {
		return;
	}

	if ( is_shop() || is_product_category() || is_product_tag() ) {
		return '<span class="onsale">' . esc_html( mk_cz_get_option( 'sh_pl_sty_sal_bdg_text', 'sale' ) ) . '</span>';
	}

	return $html;

}, 10, 3 );

add_action( 'woocommerce_after_single_product_summary', function() {

	// Filter the sale badge related products.
	add_filter( 'woocommerce_sale_flash', function( $html, $post, $product ) {

		if ( ! $product->is_in_stock() || ! $product->is_on_sale() ) {
			return;
		}

		return '<span class="onsale">' . esc_html( mk_cz_get_option( 'sh_pl_sty_sal_bdg_text', 'sale' ) ) . '</span>';

	}, 11, 3 );

}, 0 );

// Configure sidebar.
add_action( 'wp', function() {
	if ( is_shop() ) {

		$shop_page_id = get_option( 'woocommerce_shop_page_id' );

		// If Shop Page is not set in WC settings, get the default Shop page.
		if ( ! is_numeric( $shop_page_id ) ) {
			$shop_page_id = wc_get_page_id( 'shop' );
		}

		// If no page found for Shop.
		if ( ! $shop_page_id ) {
			return;
		}

		update_post_meta(
			$shop_page_id,
			'_layout',
			mk_cz_get_option( 'sh_pl_set_sidebar', 'full' )
		);
	}
} );

