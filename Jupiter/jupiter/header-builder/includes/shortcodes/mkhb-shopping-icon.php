<?php
/**
 * Header Builder: mkhb_shopping_icon shortcode.
 *
 * @since 6.0.0
 * @package Header_Builder
 */

/**
 * HB Shopping Icon element shortcode.
 *
 * @since 6.0.0
 *
 * @param  array $atts All parameter will be used in the shortcode.
 * @return string      Rendered HTML.
 */
function mkhb_shopping_icon_shortcode( $atts ) {
	$options = shortcode_atts(
		array(
			'id' => 'mkhb-shopping-icon-1',
			'alignment' => '',
			'color' => '',
			'display' => '',
			'hover-color' => '',
			'margin' => '',
			'padding' => '',
			'size' => '16px',
			'icon' => '1',
			'device' => 'desktop',
			'visibility' => 'desktop, tablet, mobile',
		),
		$atts
	);

	// Check if shopping icon is should be displayed in current device or not.
	if ( ! hb_is_shortcode_displayed( $options['device'], $options['visibility'] ) ) {
		return '';
	}

	$markup = mkhb_shopping_icon_get_markup( $options );
	$style = mkhb_shopping_icon_get_style( $options );

	wp_register_style( 'mkhb', false, array() );
	wp_enqueue_style( 'mkhb' );
	wp_add_inline_style( 'mkhb', $style );

	// Collect Shopping Cart Hooks.
	$data = array(
		'id' => $options['id'],
		'device' => $options['device'],
		'icon' => $options['icon'],
	);

	$hooks = mkhb_hooks();
	$hooks::set_hook( 'shopping-icon', $data );

	return $markup;
}
add_shortcode( 'mkhb_shopping_icon', 'mkhb_shopping_icon_shortcode' );

/**
 * Generate the element's style for use on the front-end.
 *
 * @since 6.0.0
 *
 * @param  array $options All options will be used in the shortcode.
 * @return array {
 *      HTML and CSS for the element, based on all its given properties and settings.
 *
 *      @type string $style Element CSS code.
 * }
 */
function mkhb_shopping_icon_get_style( $options ) {
	$style = '';
	$shopping_icon_id = $options['id'];

	// Shopping Icon inline block and text-align.
	$style .= "#{$shopping_icon_id}.mkhb-shop-cart-el-container {";
	$display = '';
	$text_align = '';
	if ( ! empty( $options['display'] ) ) {
		if ( 'inline' === $options['display'] ) {
			$display .= 'display: inline-block; vertical-align: top;';
		}
	}
	if ( ! empty( $options['alignment'] ) ) {
		$text_align .= "text-align: {$options['alignment']};";
	}
	$style .= $display;
	$style .= $text_align;
	$style .= '}';

	// Shopping Icon margin and padding.
	$style .= "#{$shopping_icon_id} .mkhb-shop-cart-el {";

	// Shopping Icon Margin and Padding Style.
	$style .= mkhb_shopping_icon_layout( $options );

	$style .= '}';

	// Shopping Icon icon color.
	if ( ! empty( $options['color'] ) ) {
		$style .= "#{$shopping_icon_id} .mkhb-shop-cart-el__link {color: {$options['color']};}";
	}
	if ( ! empty( $options['hover-color'] ) ) {
		$style .= "#{$shopping_icon_id} .mkhb-shop-cart-el:hover .mkhb-shop-cart-el__link {color: {$options['hover-color']};}";
		$style .= "#{$shopping_icon_id} .mkhb-shop-cart-el:hover .mkhb-shop-cart-el__link svg path {fill: {$options['hover-color']};}";
	}

	// Shopping Icon Responsive.
	if ( 'desktop' !== $options['device'] ) {
		$style .= mkhb_shopping_icon_responsive_style( $options );
	}

	return $style;
}

/**
 * Generate internal style for HB Shopping Icon Layout.
 *
 * @since 6.0.0
 *
 * @param  array $options  All options will be used in the shortcode.
 * @return string          Shopping Icon internal CSS margin and padding.
 */
function mkhb_shopping_icon_layout( $options ) {
	$style = '';

	// Shopping Icon Padding.
	if ( ! empty( $options['padding'] ) ) {
		$style .= "padding: {$options['padding']};";
	}

	// Shopping Icon Margin.
	if ( ! empty( $options['margin'] ) ) {
		$style .= "margin: {$options['margin']};";
	}

	return $style;
}

/**
 * Get custom style based on the resolution device. Most of it is used to adjust go-top and quick
 * contact button.
 *
 * @since 6.0.0
 *
 * @param  array $options  All options will be used in the shortcode.
 * @return string          All styles related to resolution device.
 */
function mkhb_shopping_icon_responsive_style( $options ) {
	// Mobile treshold.
	$resolution = '(max-width: 767px)';

	// Tablet treshold.
	if ( 'tablet' === $options['device'] ) {
		$resolution = '(min-width: 768px) and (max-width: 1024px)';
	}

	$style = sprintf( '
		@media handheld, only screen and %s {
			.hb-jupiter .bottom-corner-btns .mk-go-top.is-active {
				bottom: 145px;
			}
			.hb-jupiter .bottom-corner-btns .mk-quick-contact-wrapper {
				bottom: 87px;
			}
		}',
		$resolution
	);

	return $style;
}

/**
 * Generate the element's markup for use on the front-end.
 *
 * @since 6.0.0
 *
 * @param  array $options All options will be used in the shortcode.
 * @return array {
 *      HTML and CSS for the element, based on all its given properties and settings.
 *
 *      @type string $markup Element HTML code.
 * }
 */
function mkhb_shopping_icon_get_markup( $options ) {
	$markup  = '';

	// Render this cart only when WooCommerce is activated.
	if ( class_exists( 'WooCommerce' ) && ! empty( WC()->cart ) && 'desktop' === $options['device'] ) {
		// Collect the WooCommerce Cart widget.
		ob_start();
		the_widget( 'WC_Widget_Cart' );
		$cart_widget = ob_get_clean();

		$cart_url = esc_url( wc_get_cart_url() );
		$cart_icon = mkhb_shopping_icon_get_svg_icon( $options['icon'], $options['size'] );
		$cart_count = WC()->cart->cart_contents_count;

		$shopping_icon_id = $options['id'];

		// Shopping Icon additional class.
		$shopping_icon_class = hb_shortcode_display_class( $options );

		// @todo Temporary Solution - Data Attribute for inline container.
		$data_attr = hb_shortcode_display_attr( $options );

		$markup = sprintf(
			'<div id="%s" class="mkhb-shop-cart-el-container %s" %s>
				<div class="mkhb-shop-cart-el">
					<a class="mkhb-shop-cart-el__link" href="%s">
						%s
						<span class="mkhb-shop-cart-el__count">%s</span>
					</a>
					<div class="mkhb-shop-cart-el__box mk-shopping-cart-box">
						%s
						<div class="clearboth"></div>
					</div>
				</div>
			</div>',
			esc_attr( $shopping_icon_id ),
			esc_attr( $shopping_icon_class ),
			$data_attr,
			$cart_url,
			$cart_icon,
			$cart_count,
			$cart_widget
		);
	} // End if().

	return $markup;
}

/**
 * Get SVG icon based on key and set the icon width and height size in pixel.
 *
 * @since 6.0.0
 *
 * @param string $icon_name Icon name.
 * @param string $icon_size Icon size.
 * @return string           Icon SVG.
 */
function mkhb_shopping_icon_get_svg_icon( $icon_name, $icon_size ) {
	// If the icon type is empty or not array, return null and don't render the element.
	if ( empty( $icon_name ) ) {
		return '';
	}

	$icon_class = mkhb_shopping_icon_list( $icon_name );

	/*
	 * Mk_SVG_Icons is a class from Jupiter package. HB - Icon will use it to load the SVG
	 * icon based on the class name. Make sure this class is exist.
	 */
	if ( ! class_exists( 'Mk_SVG_Icons' ) ) {
		require_once THEME_HELPERS . '/svg-icons.php';
	}

	$mk_svg = new Mk_SVG_Icons();
	$icon = $mk_svg::get_svg_icon_by_class_name( false, $icon_class, (int) $icon_size );

	return $icon;
}

/**
 * Return icon class name.
 *
 * @since 6.0.0
 *
 * @param  string $key Icon key number.
 * @return string      Icon class name.
 */
function mkhb_shopping_icon_list( $key ) {
	$icons = array(
		'1' => 'mk-moon-cart-2',
		'2' => 'mk-moon-cart-3',
		'3' => 'mk-moon-cart-7',
		'4' => 'mk-moon-cart',
		'5' => 'mk-moon-cart-6',
		'6' => 'mk-li-cart',
		'7' => 'mk-icon-shopping-cart',
		'8' => 'mk-moon-cart-4',
	);

	if ( ! empty( $key ) || ! empty( $icons[ $key ] ) ) {
		return $icons[ $key ];
	}

	return $icons['1'];
}

/**
 * Generate the responsive element's markup for mobile and tablet devices.
 *
 * @since 6.0.0
 *
 * @return boolean False if option is empty.
 */
function mkhb_shopping_icon_add_to_cart_responsive() {
	// Fetch hooks data.
	$instance = mkhb_hooks();
	$options = $instance::get_hook( 'shopping-icon', array() );

	// If shopping icon hook is empty, stop.
	if ( empty( $options ) ) {
		return false;
	}

	foreach ( $options as $option ) {
		// Render this cart only when WooCommerce is activated.
		if ( class_exists( 'WooCommerce' ) && ! empty( WC()->cart ) && 'desktop' !== $option['device'] ) {
			$cart_url = esc_url( wc_get_cart_url() );
			$cart_icon = mkhb_shopping_icon_get_svg_icon( $option['icon'], 16 );
			$cart_count = WC()->cart->cart_contents_count;

			$markup = sprintf(
				'<div id="%s" class="mkhb-shop-cart-el-res mkhb-el-%s">
	                <a class="mkhb-shop-cart-el-res__link" href="%s">
			            %s <span class="mkhb-shop-cart-el-res__count">%s</span>
			        </a>
				</div>',
				esc_attr( $option['id'] ),
				esc_attr( $option['device'] ),
				$cart_url,
				$cart_icon,
				$cart_count
			);

			echo wp_kses( $markup, array(
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'a' => array(
					'class' => array(),
					'href' => array(),
				),
				'svg' => array(
					'xmlns' => array(),
					'style' => array(),
					'viewbox' => array(),
				),
				'path' => array(
					'd' => array(),
					'transform' => array(),
				),
				'span' => array(
					'class' => array(),
				),
			) );
		} // End if().
	} // End foreach().
}

/**
 * Set count value on shopping cart.
 *
 * @since 6.0.0
 *
 * @param array $fragments WooCommerce shooping cart HTML fragments.
 */
function mkhb_shopping_icon_add_to_cart_fragments( $fragments ) {
	// Desktop device.
	ob_start();
	$cart_link = sprintf(
		'<span class="mkhb-shop-cart-el__count">%s</span>',
		WC()->cart->cart_contents_count
	);
	echo wp_kses( $cart_link, array(
		'span' => array(
			'class' => array(),
		),
	) );
	$fragments['span.mkhb-shop-cart-el__count'] = ob_get_clean();

	// Tablet & Mobile devices.
	ob_start();
	$cart_link2 = sprintf(
		'<span class="mkhb-shop-cart-el-res__count">%s</span>',
		WC()->cart->cart_contents_count
	);
	echo wp_kses( $cart_link2, array(
		'span' => array(
			'class' => array(),
		),
	) );
	$fragments['span.mkhb-shop-cart-el-res__count'] = ob_get_clean();

	return $fragments;
}
