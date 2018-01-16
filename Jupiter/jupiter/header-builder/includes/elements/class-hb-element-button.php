<?php
/**
 * Header Builder: HB_Element_Button class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Button' element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.4 Implement some new properties, use $hb_customize property to load HB_Customize instance.
 */
class HB_Element_Button extends HB_Element {
	/**
	 * Constructor for declaring public variables and add hook action.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Add some new properties and update the default values, add $hb_customize property
	 *              on constructor.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
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
	 *           @type string $width          CSS property in pixels. Defaults to 125.
	 *           @type string $text           The button text to display. Defaults to ''.
	 *           @type string $url            The button URL. Defaults to ''.
	 *           @type string $target         Specifies where to open the URL. Default to '_blank'.
	 *           @type string $alignment      The button alignment. Default to 'left'.
	 *           @type string $cssDisplay     The button display. Default to 'block'.
	 *           @type string $textFontFamily The button text font family. Default to (array) Open Sans.
	 *           @type string $textWeight     The button text font weight. Default to 400.
	 *           @type string $textSize       The button text font size. Deafult to 14.
	 *           @type string $textStyle      The button text font style. Default to 'normal'.
	 *           @type string $textColor      The button text font color.
	 *           @type string $textHoverColor The button text font hover color.
	 *           @type string $cornerRadius   The button border radius. Default to 0.
	 *           @type string $border         The button border width and color.
	 *           @type string $padding        The button padding.
	 *           @type string $margin         The button margin. Default to (array) 0.
	 *           @type string $backgroundColor      The button background color.
	 *           @type string $hoverBackgroundColor The button background hover color.
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );
		// Preview.
		$this->width = $this->get_option( 'width', 150 );
		$this->text = $this->get_option( 'text', 'Write anything...' );
		$this->url = $this->get_option( 'url', 'https://artbees.net' );
		$this->target = $this->get_option( 'target', '_blank' );
		$this->align = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );
		// Style.
		$this->font_family = $this->get_option( 'textFontFamily', array(
			'value' => 'Roboto',
			'type'  => 'google',
			'label' => 'Roboto',
		) );
		$this->text_weight = $this->get_option( 'textWeight', 700 );
		$this->text_size = $this->get_option( 'textSize', 14 );
		$this->text_style = $this->get_option( 'textStyle', 'normal' );
		$this->text_color = $this->get_option( 'textColor', array(
			'r' => 255,
			'g' => 255,
			'b' => 255,
			'a' => 1,
		) );
		$this->bg_color = $this->get_option( 'textBackgroundColor', array(
			'r' => 77,
			'g' => 208,
			'b' => 225,
			'a' => 1,
		) );
		$this->text_hover_color = $this->get_option( 'textHoverColor', array(
			'r' => 77,
			'g' => 208,
			'b' => 225,
			'a' => 1,
		) );
		$this->hover_bg_color = $this->get_option( 'textHoverBackgroundColor', array(
			'r' => 216,
			'g' => 241,
			'b' => 244,
			'a' => 1,
		) );
		$this->radius = $this->get_option( 'textCornerRadius', 0 );
		$this->border = $this->get_option( 'border', array(
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
		// Layout.
		$this->padding = $this->get_option( 'padding', array(
			'top'    => 15,
			'right'  => 20,
			'bottom' => 15,
			'left'   => 20,
		) );
		$this->margin  = $this->get_option( 'margin', array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		) );

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_filter( 'mk_google_fonts', array( $this, 'enqueue_fonts' ) );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Impelement new structure and some new properties.
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		// Button link.
		$link = '';
		if ( ! empty( $this->url ) ) {
			$link = $this->hb_customize->attributes->get_attr( 'href', esc_url( $this->url ) );
		}

		// Button inline block.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		// Button font family.
		$font_family = '';
		if ( ! empty( $this->font_family['label'] ) ) {
			$font_family = 'font-family: ' . $this->font_family['label'] . ';';
		}

		// Button color.
		$color = $this->hb_customize->css->rgba( $this->text_color );
		$color_hover = $this->hb_customize->css->rgba( $this->text_hover_color );

		// Button background.
		$background = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( array( $this->bg_color ) ) );
		$background_hover = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( array( $this->hover_bg_color ) ) );

		// Button border.
		$border = $this->hb_customize->css->border( $this->border );

		// Button margin and padding.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		$markup = sprintf( '
			<div id="%s" class="hb-button-el">
				<a %s class="hb-button-el__link" target="%s" role="button">%s</a>
			</div>',
			esc_attr( $this->id ),
			$link,
			esc_attr( $this->target ),
			esc_html( $this->text )
		);

		$style = "
			#{$this->id} {
				text-align: {$this->align};
				{$inline}
			}

			#{$this->id} .hb-button-el__link {
				width: {$this->width}px;
				font-size: {$this->text_size}px;
				font-weight: {$this->text_weight};
				font-style: {$this->text_style};
				color: {$color};
				{$border};
				margin: {$margin};
				padding: {$padding};
				border-radius: {$this->radius}px;
				{$background}
				{$font_family}
			}

			#{$this->id} .hb-button-el__link:hover {
				color: {$color_hover};
				{$background_hover}
			}
		";

		return compact( 'markup', 'style' );
	}

	/**
	 * Enqueue fonts for button.
	 *
	 * @since 5.9.4
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-button', HB_ASSETS_URI . 'css/hb-button.css', array(), '5.9.4' );
	}

	/**
	 * Enqueue fonts for button.
	 *
	 * @since 5.9.4
	 *
	 * @param  array $google_fonts Google fonts list.
	 */
	public function enqueue_fonts( $google_fonts ) {
		// Check font type.
		$font_type = '';
		if ( ! empty( $this->font_family['type'] ) ) {
			$font_type = $this->font_family['type'];
		}

		// Check font label.
		$font_label = '';
		if ( ! empty( $this->font_family['label'] ) && 'google' === $font_type ) {
			$font_label = $this->font_family['label'] . ':100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900';

			if ( ! in_array( $font_label, $google_fonts, true ) ) {
				$google_fonts[] = $font_label;
			}
		}

		return $google_fonts;
	}
}
