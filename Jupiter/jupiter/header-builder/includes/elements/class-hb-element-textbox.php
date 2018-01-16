<?php
/**
 * Header Builder: HB_Element_Textbox class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Textbox' element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.4 Implement some new properties, use $hb_customize property to load HB_Customize instance.
 *
 * @see HB_Element
 */
class HB_Element_Textbox extends HB_Element {
	/**
	 * Generate markup and style for the 'Textbox' element.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Add some new properties, add $hb_customize property on constructor.
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
	 *           @type string $textType       Text type. Default to 'plain'.
	 *           @type string $text           Content of the text. Default to ''.
	 *           @type string $textInput      Content of the text input (href). Default to ''.
	 *           @type string $target         Target URL, available only on type Plain.
	 *           @type string $alignment      Text element horizontal aligment. Default to 'left'.
	 *           @type string $cssDisplay     Text element vertical aligment. Default to 'top'.
	 *           @type string $fontFamily     Text font family. Default to (array) Open Sans.
	 *           @type string $textWeight     Text font weight. Default to 400.
	 *           @type string $textStyle      Text font style. Default to 'normal'.
	 *           @type string $textSize       Text font size. Default to 14.
	 *           @type string $textColor      Text font color.
	 *           @type string $lineHeight     Text area line height. Default to 20.
	 *           @type string $textHoverColor Text hover font color.
	 *           @type string $padding        The element padding layout.
	 *           @type string $margin         The element margin layout.
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		$this->text_type = $this->get_option( 'textType', 'plain' );
		$this->text = $this->get_option( 'text', '' );
		$this->text_input = $this->get_option( 'textInput', '' );
		$this->target = $this->get_option( 'target', '_blank' );
		$this->align = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'left' );
		$this->font_family = $this->get_option( 'fontFamily', array(
			'value' => 'Open+Sans',
			'type' => 'google',
			'label' => 'Open Sans',
		) );
		$this->text_weight = $this->get_option( 'textWeight', 400 );
		$this->text_style = $this->get_option( 'textStyle', 'normal' );
		$this->text_size = $this->get_option( 'textSize', 14 );
		$this->text_color = $this->get_option( 'textColor', array(
			'r' => 34,
			'g' => 34,
			'b' => 34,
			'a' => 1,
		) );
		$this->line_height = $this->get_option( 'lineHeight', 20 );
		$this->text_hover_color = $this->get_option( 'textHoverColor', array(
			'r' => 34,
			'g' => 34,
			'b' => 34,
			'a' => 1,
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

		add_filter( 'mk_google_fonts', array( $this, 'enqueue_fonts' ) );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Implement some new properties and apply new design.
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		// Textbox input_text.
		$prefix = array(
			'plain' => '',
			'phone' => 'tel:',
			'email' => 'mailto:',
		);

		$link = '';
		$target = '';
		$smooth_scroll = '';
		if ( ! empty( $this->text_input ) ) {
			// Textbox input type.
			$text_type = ( ! empty( $this->text_type ) ) ? $this->text_type : 'plain';

			// Textbox URL target.
			if ( 'plain' === $text_type && ! empty( $this->target ) ) {
				$target = $this->hb_customize->attributes->get_attr( 'target', $this->target );
			}

			// Textbox class for smooth scroll, only on #link.
			if ( null !== wp_parse_url( $this->text_input, PHP_URL_FRAGMENT ) ) {
				$smooth_scroll = 'js-smooth-scroll';
			}

			$url = $prefix[ $text_type ] . $this->text_input;
			$link = $this->hb_customize->attributes->get_attr( 'href', esc_url( $url ) );
		}

		// Textbox inline block.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		// Textbox font family.
		$font_family = '';
		if ( ! empty( $this->font_family['label'] ) ) {
			$font_family = 'font-family: ' . $this->font_family['label'] . ';';
		}

		// Textbox color.
		$color = $this->hb_customize->css->rgba( $this->text_color );
		$color_hover = $this->hb_customize->css->rgba( $this->text_hover_color );

		// Textbox margin and padding.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		/*
		 * Textbox text. According to http://www.json.org/, we cannot have the
		 * \n "character" in JSON data. We can only thus store new line
		 * characters as, well the \n "string", which makes it indistinguishable
		 * from any \n "string" directly entered by the user. For this reason,
		 * we need to encode our strings in base64 to circumvent this problem.
		 */
		$text = htmlentities( rawurldecode( base64_decode( strip_tags( $this->text ), true ) ), ENT_COMPAT, 'UTF-8' );

		$markup = sprintf( '
			<div id="%s" class="hb-textbox-el">
				<a %s class="hb-textbox-el__link %s" %s>%s</a>
			</div>',
			esc_attr( $this->id ),
			$link,
			$smooth_scroll,
			$target,
			// We do not support HTML in the text area except for the break tag.
			// Supporting HTML here implies we need to render the CSS attached
			// to any "class" attribute. This means both CSS included in
			// Jupiter, any any custom CSS you may have in Theme Options. A of
			// this writing that is out of scope.
			preg_replace( '/&lt;br\W*?\&gt;/i', '<br>', esc_html( $text ) )
		);

		$style = "
			#{$this->id} {
				text-align: {$this->align};
				margin: {$margin};
				padding: {$padding};
				line-height: 1;
				{$inline}
			}

			#{$this->id} .hb-textbox-el__link {
				font-size: {$this->text_size}px;
				font-weight: {$this->text_weight};
				font-style: {$this->text_style};
				color: {$color};
				line-height: {$this->line_height}px;
				{$font_family}
			}

			#{$this->id} .hb-textbox-el__link[href]:hover {
				color: {$color_hover};
			}
		";

		return compact( 'markup', 'style' );
	}

	/**
	 * Enqueue fonts for textbox.
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
