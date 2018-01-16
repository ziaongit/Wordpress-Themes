<?php
/**
 * Header Builder: HB_Element_Search class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Search' element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.1 Create basic structure of search element.
 * @since 5.9.3 Add alignment and make inline properties.
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 * @since 5.9.5 Replace 'hb_is_frontend_active' with 'hb_is_to_active' because now HB will be activated
 *              from TO.
 *
 * @see HB_Element
 */
class HB_Element_Search extends HB_Element {
	/**
	 * Generate markup and style for the 'Search' element.
	 *
	 * @since 5.9.0
	 * @since 5.9.1 Add default values.
	 * @since 5.9.3 Add and update default values.
	 * @since 5.9.4 Add $hb_customize property on constructor.
	 * @since 5.9.5 Replace 'hb_is_frontend_active' with 'hb_is_to_active' because now HB will be
	 *              activated from TO.
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
	 *           @type array   $margin
	 *           @type array   $padding
	 *           @type string  $alignment
	 *           @type string  $cssDisplay
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		// Declare properties value.
		$this->type    = $this->get_option( 'iconType', '1' );
		$this->size    = $this->get_option( 'iconSize', 16 );
		$this->margin  = $this->get_option( 'margin', array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		) );
		$this->padding = $this->get_option( 'padding',  array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		) );
		$this->color_icon = $this->get_option( 'iconColor', array(
			'r' => 119,
			'g' => 119,
			'b' => 119,
			'a' => 1,
		) );
		$this->color_icon_hover = $this->get_option( 'iconHoverColor', array(
			'r' => 119,
			'g' => 119,
			'b' => 119,
			'a' => 1,
		) );
		$this->align  = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );
		$this->active_on_front_end = hb_is_to_active();

		// Enqueue the search style and HB script.
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

	}

	/**
	 * Enqueue search style and HB script.
	 *
	 * @since 5.9.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-search', HB_ASSETS_URI . 'css/hb-search.css', array(), '5.9.1' );
		wp_enqueue_script( 'hb-search', HB_ASSETS_URI . 'js/hb-search.js', array( 'jquery' ), '5.9.1', true );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.1 Create basic structure.
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
		// Search initial values for search form.
		$preview_input  = '';
		$search_keyword = '';
		$nonce_name     = 'hb-search-nonce';
		$nonce_instance = wp_create_nonce( $nonce_name );

		// Check if the nonce is exist.
		if ( wp_verify_nonce( $nonce_instance, $nonce_name ) ) {
			// Preview param.
			$header_builder_get = ( ! empty( $_GET['header-builder'] ) ) ? sanitize_text_field( $_GET['header-builder'] ) : '';
			if ( ! $this->active_on_front_end || ! empty( $header_builder_get ) ) {
				$preview_input = '<input name="header-builder" type="hidden" value="preview" />';
			}

			// Search param.
			$search_keyword = ( ! empty( $_GET['s'] ) ) ? sanitize_text_field( $_GET['s'] ) : '';
		}

		$markup = sprintf(
			'<div id="%s" class="hb-search-el">
				<a class="hb-search-el__container hb-trigger__fullscreen--open" href="#">
					<i class="hb-search-el__icon-wrapper">
						%s
					</i>
				</a>
				<div class="hb-search-el__overlay">
					<a href="#" class="hb-search-el__overlay__close">
						<svg class="hb-search-el__icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M390.628 345.372l-45.256 45.256-89.372-89.373-89.373 89.372-45.255-45.255 89.373-89.372-89.372-89.373 45.254-45.254 89.373 89.372 89.372-89.373 45.256 45.255-89.373 89.373 89.373 89.372z"></path></svg>
					</a>
					<div class="hb-search-el__overlay__wrapper">
						<p>%s</p>
						<form method="get" id="hb-search-el__overlay__search-form" action="%s">
							<input type="text" value="%s" name="s" id="hb-search-el__overlay__search-input" />
							<input name="%s" type="hidden" value="%s" />
							%s
							<i class="hb-search-el__overlay__search-icon">
								<svg class="hb-search-el__icon-svg" style="height:25px;width:23.214285714286px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1664 1792"><path d="M1152 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"></path></svg>
							</i>
						</form>
					</div>
				</div>
			</div>',
			esc_attr( $this->id ),
			$this->get_svg_icon( $this->type, $this->size ),
			__( 'Start typing and press Enter to search', 'mk_framework' ),
			get_home_url(),
			esc_attr( $search_keyword ),
			esc_attr( $nonce_name ),
			esc_attr( $nonce_instance ),
			$preview_input
		);

		// Search margin and padding.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		// Search icon color.
		$color_icon = $this->hb_customize->css->rgba( $this->color_icon );
		$color_icon_hover = $this->hb_customize->css->rgba( $this->color_icon_hover );

		// Search inline block.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		$style = "
			#{$this->id} {
				text-align: {$this->align};
				padding: {$padding};
				margin: {$margin};
				{$inline}
			}
			#{$this->id} .hb-search-el__container {
				color: {$color_icon};
			}
			#{$this->id} .hb-search-el__container:hover {
				color: {$color_icon_hover};
			}
		";

		return compact( 'markup', 'style' );
	}

	/**
	 * Get SVG icon based on key and set the icon width and height size in pixel.
	 *
	 * @since 5.9.1
	 *
	 * @param  string  $key  SVG key.
	 * @param  integer $size SVG icon size, default is 16.
	 * @return string        SVG icon will be used.
	 */
	public function get_svg_icon( $key = '1', $size = 16 ) {
		if ( 0 === $size ) {
			$size = 16;
		}

		$icons = array(
			'1' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M160 0c88.366 0 160.001 71.635 160.001 160 0 32.62-9.771 62.954-26.532 88.251l.015-.022 35.18 35.18c17.436-9.611 33.847-11.408 42.221-3.035l135.764 135.764c12.497 12.498 2.366 42.891-22.627 67.885-24.994 24.992-55.386 35.123-67.882 22.627l-135.765-135.767c-8.375-8.373-6.576-24.783 3.033-42.221l-35.178-35.178.063-.045c-25.306 16.78-55.654 26.561-88.293 26.561-88.365 0-160-71.635-160-160s71.635-160 160-160zm-90.51 250.509c24.176 24.177 56.321 37.491 90.51 37.491 34.19 0 66.334-13.314 90.511-37.491 24.176-24.176 37.489-56.32 37.489-90.509s-13.313-66.333-37.489-90.51c-24.177-24.177-56.321-37.49-90.511-37.49-34.189 0-66.334 13.314-90.51 37.49-24.176 24.177-37.49 56.32-37.49 90.51s13.314 66.333 37.49 90.509zm186.51-90.509c0 14.397-3.175 28.051-8.854 40.309-7.261-66.992-60.462-120.193-127.454-127.455 12.257-5.68 25.912-8.854 40.308-8.854 53.021 0 96 42.979 96 96z"/></svg>',
			'2' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M496.131 435.698l-121.276-103.147c-12.537-11.283-25.945-16.463-36.776-15.963 28.628-33.534 45.921-77.039 45.921-124.588 0-106.039-85.961-192-192-192-106.038 0-192 85.961-192 192s85.961 192 192 192c47.549 0 91.054-17.293 124.588-45.922-.5 10.831 4.68 24.239 15.963 36.776l103.147 121.276c17.661 19.623 46.511 21.277 64.11 3.678s15.946-46.449-3.677-64.11zm-304.131-115.698c-70.692 0-128-57.308-128-128s57.308-128 128-128 128 57.308 128 128-57.307 128-128 128z"/></svg>',
			'3' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 512 512"><path d="M449.077 469.246l-114.54-168.305c65.459-51.835 83.963-145.677 39.835-219.126-47.927-79.774-151.813-105.672-231.579-57.755-79.765 47.933-105.662 151.816-57.739 231.583 43.213 71.942 131.962 100.047 207.479 69.717l95.143 180.783c2.95 5.611 9.802 7.523 15.229 4.273l42.784-25.72c5.437-3.263 6.964-10.214 3.388-15.45zm-160.296-202.214c-54.211 32.563-124.808 14.959-157.375-39.253-32.565-54.197-14.952-124.794 39.253-157.36 54.189-32.57 124.787-14.961 157.351 39.245 32.569 54.198 14.968 124.811-39.229 157.368z"/></svg>',
			'4' => '<svg xmlns="http://www.w3.org/2000/svg" height="' . esc_attr( $size ) . 'px" viewBox="0 0 1664 1792"><path d="M1152 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"/></svg>',
		);

		if ( ! empty( $key ) || ! empty( $icons[ $key ] ) ) {
			return $icons[ $key ];
		}

		return $icons['1'];

	}
}
