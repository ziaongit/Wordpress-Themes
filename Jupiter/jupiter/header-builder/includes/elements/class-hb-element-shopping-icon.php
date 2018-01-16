<?php
/**
 * Header Builder: HB_Element_Shopping_Icon class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 * @deprecated 6.0.0 No longer used because all the element will be rendered as shortcode.
 */

/**
 * Main class used for rendering 'Shopping Icon' element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.2 Create basic structure.
 * @since 5.9.3 Add aligntment and make inline properties.
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 *
 * @see HB_Element
 */
class HB_Element_Shopping_Icon extends HB_Element {
	/**
	 * Generate markup and style for the 'Shopping Icon' element.
	 *
	 * @since 5.9.0
	 * @since 5.9.2 Add new default values.
	 * @since 5.9.3 Update default values.
	 * @since 5.9.4 Add $hb_customize property on constructor.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
	 *
	 * @param array  $element {
	 *     The data to transform into HTML/CSS.
	 *
	 *     @type string $type
	 *     @type string $caption
	 *     @type string $id
	 *     @type string $category
	 *     @type array $options {
	 *           Array of element CSS properties and other settings.
	 *
	 *           @type string  $iconType
	 *           @type integer $iconSize
	 *           @type array   $iconColor
	 *           @type array   $iconHoverColor
	 *           @type array   $padding
	 *           @type array   $margin
	 *           @type string  $alignment
	 *           @type string  $cssDisplay
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		$this->type = $this->get_option( 'iconType', '1' );
		$this->size = $this->get_option( 'iconSize', 25 );
		$this->icon_color = $this->get_option( 'iconColor', array(
			'r' => 34,
			'g' => 34,
			'b' => 34,
			'a' => 1,
		) );
		$this->icon_hover_color = $this->get_option( 'iconHoverColor', array(
			'r' => 68,
			'g' => 68,
			'b' => 68,
			'a' => 1,
		) );
		$this->padding = $this->get_option( 'padding', array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		) );
		$this->margin  = $this->get_option( 'margin', array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		) );
		$this->align  = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );

		// Enqueue the search style and shopping cart script. Also override count value of Shopping Cart.
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_filter( 'woocommerce_add_to_cart_fragments', array( &$this, 'add_to_cart_fragments' ) );

		// Remove Jupiter default hook to render the shopping cart icon. Then add HB custom shop icon.
		remove_action( 'add_to_cart_responsive', 'mk_add_to_cart_responsive', 20 );
		add_action( 'add_to_cart_responsive', array( &$this, 'set_responsive_cart' ), 20 );
	}

	/**
	 * Enqueue search style and HB script.
	 *
	 * @since 5.9.2
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-shop-cart', HB_ASSETS_URI . 'css/hb-shop-cart.css', array(), '5.9.2' );
		wp_enqueue_script( 'hb-shop-cart', HB_ASSETS_URI . 'js/hb-shop-cart.js', array( 'jquery' ), '5.9.2', true );
	}

	/**
	 * Set count value on shopping cart.
	 *
	 * @since 5.9.2
	 *
	 * @param array $fragments WooCommerce shooping cart HTML fragments.
	 */
	public function add_to_cart_fragments( $fragments ) {
		// Desktop device.
		ob_start();
		$cart_link = sprintf(
			'<span class="hb-shop-cart-el__count">%s</span>',
			WC()->cart->cart_contents_count
		);
		echo wp_kses( $cart_link, array(
			'span' => array(
				'class' => array(),
			),
		) );
		$fragments['span.hb-shop-cart-el__count'] = ob_get_clean();

		// Tablet & Mobile devices.
		ob_start();
		$cart_link2 = sprintf(
			'<span class="hb-shop-cart-el-res__count">%s</span>',
			WC()->cart->cart_contents_count
		);
		echo wp_kses( $cart_link2, array(
			'span' => array(
				'class' => array(),
			),
		) );
		$fragments['span.hb-shop-cart-el-res__count'] = ob_get_clean();

		return $fragments;
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.2 Create basic structure.
	 * @since 5.9.3 Add alignment and make inline properties.
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		$markup  = '';
		$style   = '';

		// Render this cart only when WooCommerce is activated.
		if ( class_exists( 'WooCommerce' ) && ! empty( WC()->cart ) && 'desktop' === $this->device ) {
			// Collect the WooCommerce Cart widget.
			ob_start();
			the_widget( 'WC_Widget_Cart' );
			$cart_widget = ob_get_clean();

			$cart_url = WC()->cart->get_cart_url();
			$cart_icon = $this->get_svg_icon( $this->type, $this->size );
			$cart_count = WC()->cart->cart_contents_count;

			$markup = sprintf(
				'<div id="%s" class="hb-shop-cart-el-container">
					<div class="hb-shop-cart-el">
						<a class="hb-shop-cart-el__link" href="%s">
							%s
							<span class="hb-shop-cart-el__count">%s</span>
						</a>
						<div class="hb-shop-cart-el__box mk-shopping-cart-box">
							%s
							<div class="clearboth"></div>
						</div>
					</div>
				</div>',
				esc_attr( $this->id ),
				$cart_url,
				$cart_icon,
				$cart_count,
				$cart_widget
			);

			// Shopping Icon margin and padding.
			$padding = $this->hb_customize->layout->trbl( $this->padding );
			$margin  = $this->hb_customize->layout->trbl( $this->margin );

			// Shopping Icon icon color.
			$icon_color = $this->hb_customize->css->rgba( $this->icon_color );
			$icon_hover_color = $this->hb_customize->css->rgba( $this->icon_hover_color );

			// Shopping Icon inline block.
			$inline = $this->hb_customize->layout->inline_block( $this->inline );

			$style = "
				#{$this->id}.hb-shop-cart-el-container {
					text-align: {$this->align};
					{$inline}
				}
				#{$this->id} .hb-shop-cart-el {
					padding: {$padding};
					margin: {$margin};
				}
				#{$this->id} .hb-shop-cart-el__link {
					color: {$icon_color};
				}
				#{$this->id} .hb-shop-cart-el:hover .hb-shop-cart-el__link {
					color: {$icon_hover_color};
				}
			";

		} // End if().

		// Get custom style for responsive state.
		if ( 'desktop' !== $this->device ) {
			$style .= $this->get_style_resolution();
		}

		return compact( 'markup', 'style' );
	}

	/**
	 * Generate the responsive element's markup for mobile and tablet devices.
	 *
	 * @since 5.9.4
	 */
	public function set_responsive_cart() {
		// Render this cart only when WooCommerce is activated.
		if ( class_exists( 'WooCommerce' ) && ! empty( WC()->cart ) && 'desktop' !== $this->device ) {
			$cart_url = WC()->cart->get_cart_url();
			$cart_icon = $this->get_svg_icon( $this->type, 16 );
			$cart_count = WC()->cart->cart_contents_count;

			$markup = sprintf(
				'<div id="%s" class="hb-shop-cart-el-res hb-el-%s">
	                <a class="hb-shop-cart-el-res__link" href="%s">
			            %s <span class="hb-shop-cart-el-res__count">%s</span>
			        </a>
				</div>',
				esc_attr( $this->id ),
				esc_attr( $this->device ),
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
					'height' => array(),
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
		}// End if().
	}

	/**
	 * Get SVG icon based on key and set the icon width and height size in pixel.
	 *
	 * @since 5.9.2
	 *
	 * @param  string  $key  SVG key.
	 * @param  integer $size SVG icon size, default is 25.
	 * @return string        SVG icon will be used.
	 */
	public function get_svg_icon( $key = '1', $size = 25 ) {
		if ( 0 === $size ) {
			$size = 25;
		}

		$icons = array(
			'1' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M423.609 288c17.6 0 35.956-13.846 40.791-30.769l46.418-162.463c4.835-16.922-5.609-30.768-23.209-30.768h-327.609c0-35.346-28.654-64-64-64h-96v64h96v272c0 26.51 21.49 48 48 48h304c17.673 0 32-14.327 32-32s-14.327-32-32-32h-288v-32h263.609zm-263.609-160h289.403l-27.429 96h-261.974v-96zm32 344c0 22-18 40-40 40h-16c-22 0-40-18-40-40v-16c0-22 18-40 40-40h16c22 0 40 18 40 40v16zm288 0c0 22-18 40-40 40h-16c-22 0-40-18-40-40v-16c0-22 18-40 40-40h16c22 0 40 18 40 40v16z"></path></svg>',
			'2' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M423.609 288c17.6 0 35.956-13.846 40.791-30.769l46.418-162.463c4.835-16.922-5.609-30.768-23.209-30.768h-327.609c0-35.346-28.654-64-64-64h-96v64h96v272c0 26.51 21.49 48 48 48h304c17.673 0 32-14.327 32-32s-14.327-32-32-32h-288v-32h263.609zm-263.609-64v-4h263.117l-1.143 4h-261.974zm281.403-68l-2.286 8h-279.117v-8h281.403zm-281.403-8v-8h285.975l-2.285 8h-283.69zm276.832 24l-2.286 8h-274.546v-8h276.832zm-4.571 16l-2.286 8h-269.975v-8h272.261zm-4.573 16l-2.285 8h-265.403v-8h267.688zm21.715-76l-1.143 4h-288.26v-4h289.403zm-297.403 288c22 0 40 18 40 40v16c0 22-18 40-40 40h-16c-22 0-40-18-40-40v-16c0-22 18-40 40-40h16zm288 0c22 0 40 18 40 40v16c0 22-18 40-40 40h-16c-22 0-40-18-40-40v-16c0-22 18-40 40-40h16z"></path></svg>',
			'3' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M488.791 382.769c-16.992 4.854-34.705-4.985-39.56-21.978l-2.511-8.791h-298.471l-4.496 35.969c-2.002 16.014-15.615 28.031-31.753 28.031h-80c-17.673 0-32-14.327-32-32s14.327-32 32-32h51.751l28.496-227.969c2.002-16.013 15.615-28.031 31.753-28.031h272c14.287 0 26.844 9.472 30.769 23.209l64 224c4.855 16.993-4.985 34.705-21.978 39.56zm-51.214-62.769l-9.144-32h-272.184l-4 32h285.328zm-18.286-64l-9.143-32h-245.899l-4 32h259.042zm-247.042-96l-4 32h232.756l-9.143-32h-219.613zm-44.249-144a48 48 2700 1 0 96 0 48 48 2700 1 0-96 0zm192 0a48 48 2700 1 0 96 0 48 48 2700 1 0-96 0z" transform="scale(1 -1) translate(0 -480)"></path></svg>',
			'4' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M64 16a48 48 10980 1 0 96 0 48 48 10980 1 0-96 0zm320 0a48 48 10980 1 0 96 0 48 48 10980 1 0-96 0zm96 208v192h-416c0 35.346-28.653 64-64 64v-32c17.645 0 32-14.355 32-32l24.037-206.027c-14.647-11.729-24.037-29.75-24.037-49.973 0-35.347 28.654-64 64-64h384v32h-384c-17.673 0-32 14.327-32 32l.008.328 415.992 63.672z" transform="scale(1 -1) translate(0 -480)"></path></svg>',
			'5' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M488.791 382.769c-16.992 4.854-34.705-4.985-39.56-21.978l-2.511-8.791h-298.471l-4.496 35.969c-2.002 16.014-15.615 28.031-31.753 28.031h-80c-17.673 0-32-14.327-32-32s14.327-32 32-32h51.751l28.496-227.969c2.002-16.013 15.615-28.031 31.753-28.031h272c14.287 0 26.844 9.472 30.769 23.209l64 224c4.855 16.993-4.985 34.705-21.978 39.56zm-232.791-158.769v32h63.998v-32h-63.998zm63.998-32v-32h-63.998v32h63.998zm-63.998 96v32h63.998v-32h-63.998zm-103.751 32h71.751v-32h-67.751l-4 32zm8-64h63.751v-32h-59.751l-4 32zm8-64h55.751v-32h-51.751l-4 32zm223.613-32h-39.864v32h49.007l-9.143-32zm18.286 64h-58.15v32h67.293l-9.143-32zm18.286 64h-76.436v32h85.579l-9.143-32zm-300.434-272a48 48 2700 1 0 96 0 48 48 2700 1 0-96 0zm192 0a48 48 2700 1 0 96 0 48 48 2700 1 0-96 0z" transform="scale(1 -1) translate(0 -480)"></path></svg>',
			'6' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M416.265 306.366c14.002-14.002 78.637-108.456 81.388-112.472 11.495-16.814 12.492-38.904 2.598-57.646-9.686-18.363-27.635-29.322-47.998-29.322h-329.568v-47.088c0-1.088-.107-2.146-.322-3.17-1.617-15.802-14.845-28.218-31.069-28.218h-54.933c-17.312 0-31.39 14.083-31.39 31.39v15.695c0 17.313 14.079 31.39 31.39 31.39h54.933v219.668c0 34.617 28.164 62.781 62.781 62.781h290.361c8.668 0 15.695-7.028 15.695-15.695s-7.028-15.695-15.695-15.695h-290.361c-17.289 0-31.344-14.043-31.383-31.325h243.422c27.719 0 38.272-8.41 50.151-20.293zm35.988-168.049c12.27 0 18.24 8.798 20.233 12.577 3.487 6.602 5.111 16.707-.751 25.283-31.529 46.12-70.192 100.524-77.664 107.996-8.078 8.074-11.097 11.097-27.957 11.097h-243.429v-156.953h329.568zm-415.892-62.781v-15.695h54.933v15.695h-54.933zm149.067 313.843c-25.958 0-47.079 21.121-47.079 47.086s21.121 47.086 47.079 47.086c25.965 0 47.093-21.121 47.093-47.086s-21.129-47.086-47.093-47.086zm0 62.78c-8.653 0-15.688-7.039-15.688-15.695 0-8.652 7.035-15.695 15.688-15.695 8.66 0 15.702 7.043 15.702 15.695 0 8.657-7.043 15.695-15.702 15.695zm204.007-62.78c-25.958 0-47.079 21.121-47.079 47.086s21.121 47.086 47.079 47.086c25.964 0 47.093-21.121 47.093-47.086s-21.13-47.086-47.093-47.086zm0 62.78c-8.653 0-15.688-7.039-15.688-15.695 0-8.652 7.035-15.695 15.688-15.695 8.66 0 15.702 7.043 15.702 15.695 0 8.657-7.043 15.695-15.702 15.695z"></path></svg>',
			'7' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 1664 1792"><path d="M640 1536q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm896 0q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm128-1088v512q0 24-16 42.5t-41 21.5l-1044 122q1 7 4.5 21.5t6 26.5 2.5 22q0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-14 11-39.5t29.5-59.5 20.5-38l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t20 15.5 13 24.5 7.5 26.5 5.5 29.5 4.5 25.5h1201q26 0 45 19t19 45z"></path></svg>',
			'8' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M488.791 382.769c16.993-4.855 26.833-22.567 21.978-39.56l-64-224c-3.925-13.737-16.482-23.209-30.769-23.209h-272c-16.138 0-29.751 12.018-31.753 28.031l-28.496 227.969h-51.751c-17.673 0-32 14.327-32 32 0 17.673 14.327 32 32 32h80c16.138 0 29.751-12.017 31.753-28.031l28.496-227.969h219.613l57.369 200.791c4.855 16.993 22.568 26.832 39.56 21.978zm-360.791-366.769a48 48 2700 1 0 96 0 48 48 2700 1 0-96 0zm192 0a48 48 2700 1 0 96 0 48 48 2700 1 0-96 0z" transform="scale(1 -1) translate(0 -480)"></path></svg>',
		);

		if ( ! empty( $key ) || ! empty( $icons[ $key ] ) ) {
			return $icons[ $key ];
		}

		return $icons['1'];

	}

	/**
	 * Get custom style based on the resolution device. Most of it is used to adjust go-top and quick
	 * contact button.
	 *
	 * @since 5.9.5
	 *
	 * @return string All styles related to resolution device.
	 */
	public function get_style_resolution() {
		// Mobile treshold.
		$resolution = '(max-width: 767px)';

		// Tablet treshold.
		if ( 'tablet' === $this->device ) {
			$resolution = '(min-width: 768px) and (max-width: 1024px)';
		}

		$style = sprintf( '
			@media handheld, only screen and %s {
			    .hb-jupiter .mk-go-top.is-active {
			        bottom: 145px;
			    }
			    .hb-jupiter .mk-quick-contact-wrapper {
				    bottom: 87px;
				}
			}',
			$resolution
		);

		return $style;
	}

}
