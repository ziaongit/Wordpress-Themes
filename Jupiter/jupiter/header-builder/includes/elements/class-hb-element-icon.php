<?php
/**
 * Header Builder: HB_Element_Icon class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.8
 */

/**
 * Main class used for rendering 'Icon' element to the front end.
 *
 * @since 5.9.8
 *
 * @see HB_Element
 */
class HB_Element_Icon extends HB_Element {
	/**
	 * Declare all public variables on 'Icon' element.
	 *
	 * @since 5.9.8
	 *
	 * @see HB_Element
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
	 *           @type string $icon           Icon. Default to ''.
	 *           @type string $url            Anchor URL. Default to '';
	 *           @type string $target         Target URL. Default to '_blank'.
	 *           @type string $alignment      Icon element horizontal aligment. Default to 'left'.
	 *           @type string $cssDisplay     Icon element vertical aligment. Default to 'top'.
	 *           @type string $alt            Anchor alt. Default to 'Welcome on board'.
	 *           @type string $iconSize       Icon size. Default to 16.
	 *           @type string $iconColor      Icon color.
	 *           @type string $iconBoxBgColor Icon box background color.
	 *           @type string $iconBoxRadius  Icon box border radius.
	 *           @type string $iconBoxBorder  Icon box border.
	 *           @type string $iconHoverColor Icon hover color.
	 *           @type string $iconHoverBoxBgColor     Icon box hover background color.
	 *           @type string $iconHoverBoxBorderColor Icon box hover border color.
	 *           @type string $padding        Icon box padding layout.
	 *           @type string $margin         Icon box margin layout.
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		$this->icon = $this->get_option( 'iconType', array() );
		$this->url = $this->get_option( 'url', '#' );
		$this->target = $this->get_option( 'target', '_blank' );
		$this->align = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );
		$this->alt = $this->get_option( 'alt', '' );
		$this->size = $this->get_option( 'iconSize', 16 );
		$this->color = $this->get_option( 'iconColor', array(
			'r' => 136,
			'g' => 136,
			'b' => 136,
			'a' => 1,
		) );
		$this->box_bg_color = $this->get_option( 'iconBackgroundColor', array(
			'r' => 238,
			'g' => 238,
			'b' => 238,
			'a' => 0,
		) );
		$this->box_radius = $this->get_option( 'boxCornerRadius', 2 );
		$this->box_border = $this->get_option( 'boxBorder', array(
			'active' => 'top',
			'top' => array(
				'width' => 0,
				'color' => array(
					'r' => 129,
					'g' => 212,
					'b' => 250,
					'a' => 1,
				),
			),
			'right' => array(
				'width' => 0,
				'color' => array(
					'r' => 129,
					'g' => 212,
					'b' => 250,
					'a' => 1,
				),
			),
			'bottom' => array(
				'width' => 0,
				'color' => array(
					'r' => 129,
					'g' => 212,
					'b' => 250,
					'a' => 1,
				),
			),
			'left' => array(
				'width' => 0,
				'color' => array(
					'r' => 129,
					'g' => 212,
					'b' => 250,
					'a' => 1,
				),
			),
		) );
		$this->hover_color = $this->get_option( 'iconHoverColor', array(
			'r' => 34,
			'g' => 34,
			'b' => 34,
			'a' => 1,
		) );
		$this->box_hover_bg_color = $this->get_option( 'iconHoverBackgroundColor', array(
			'r' => 238,
			'g' => 238,
			'b' => 238,
			'a' => 0,
		) );
		$this->box_hover_border_col = $this->get_option( 'iconHoverBorderColor', array(
			'r' => 238,
			'g' => 238,
			'b' => 238,
			'a' => 0,
		) );
		$this->padding = $this->get_option( 'padding', array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
		) );
		$this->margin = $this->get_option( 'margin', array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
		) );

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.8
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		$markup = sprintf(
			'<div id="%s" class="hb-icon-el"></div>',
			esc_attr( $this->id )
		);

		// Icon display.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		$style = "
			#{$this->id} {
				text-align: {$this->align};
				{$inline}
			}
		";

		// Icon type and size.
		$icon = $this->get_icon_svg( $this->icon, $this->size );

		// Render only the container, if the icon is empty.
		if ( empty( $icon ) ) {
			return compact( 'markup', 'style' );
		}

		// Icon box layout.
		$borders = $this->box_border;
		$border_offset['height'] = $borders['top']['width'] + $borders['bottom']['width'];
		$border_offset['width']  = $borders['left']['width'] + $borders['right']['width'];
		$box_height = $this->size + $border_offset['height'] + $this->padding['top'] + $this->padding['bottom'];
		$box_width = $this->size + $border_offset['width'] + $this->padding['left'] + $this->padding['right'];

		// Icon colors.
		$icon_color = $this->hb_customize->css->rgba( $this->color );
		$icon_hover_color = $this->hb_customize->css->rgba( $this->hover_color );
		$box_bg_color = $this->hb_customize->css->rgba( $this->box_bg_color );
		$box_hover_bg_color = $this->hb_customize->css->rgba( $this->box_hover_bg_color );
		$box_border = $this->hb_customize->css->border( $this->box_border );
		$box_hover_border_col = $this->hb_customize->css->rgba( $this->box_hover_border_col );

		// Icon anchor URL attribute.
		$url_attr = ( ! empty( $this->url ) ) ? 'href="' . esc_url( $this->url ) . '"' : '';
		$target = ( ! empty( $this->url ) && ! empty( $this->target ) ) ? 'target="' . esc_attr( $this->target ) . '"' : '';

		// Icon layout.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		$markup = sprintf(
			'<div id="%s" class="hb-icon-el">
				<a class="hb-icon-el__link" %s %s alt="%s">
					%s
				</a>
			</div>',
			esc_attr( $this->id ),
			$target,
			$url_attr,
			esc_attr( $this->alt ),
			$icon
		);

		$style .= "
			#{$this->id} .hb-icon-el__link {
				color: {$icon_color};
				height: {$box_height}px;
				width: {$box_width}px;
				background: {$box_bg_color};
				padding: {$padding};
				margin: {$margin};
				border-radius: {$this->box_radius}px;
				{$box_border};
			}
		";

		// Enable hover effect only if the URL is not empty.
		if ( ! empty( $url_attr ) ) {
			$style .= "
				#{$this->id} .hb-icon-el__link:hover {
					color: {$icon_hover_color};
					background: {$box_hover_bg_color};
					border-color: {$box_hover_border_col};
				}
			";
		}

		return compact( 'markup', 'style' );
	}

	/**
	 * Enqueue fonts for icon.
	 *
	 * @since 5.9.8
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-icon', HB_ASSETS_URI . 'css/hb-icon.css', array(), '5.9.8' );
	}

	/**
	 * Return icon SVG.
	 *
	 * @since 5.9.8
	 *
	 * @param string $icon_name Icon name.
	 * @param string $icon_size Icon size.
	 * @return string           Icon SVG.
	 */
	private function get_icon_svg( $icon_name, $icon_size ) {
		// If the icon type is empty or not array, return null and don't render the element.
		if ( empty( $icon_name ) || ! is_array( $icon_name ) ) {
			return '';
		}

		$icon_class = ( ! empty( $icon_name['name'] ) ) ? $icon_name['name'] : '';

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
}
