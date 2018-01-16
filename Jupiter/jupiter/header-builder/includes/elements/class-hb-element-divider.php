<?php
/**
 * Header Builder: HB_Element_Divider class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering "Divider" element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 *
 * @see HB_Element
 */
class HB_Element_Divider extends HB_Element {
	/**
	 * Generate markup and style for the 'Divider' element.
	 *
	 * @since 5.9.0
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
	 *           @type string $color
	 *           @type string $width
	 *           @type string $verticalPadding
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		$this->color = $this->get_option( 'color', '#eeeeee' );
		$this->width = $this->get_option( 'width', '50%' );
		$this->vertical_padding = $this->get_option( 'verticalPadding', '4px' );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		$markup = sprintf( '<hr class="%s" />', $this->class_name );
		$style = "
			.{$this->class_name} {
				border-color: {$this->color};
				width: {$this->width};
				margin-top: {$this->vertical_padding};
				margin-bottom: {$this->vertical_padding};
			}
		";

		return compact( 'markup', 'style' );
	}
}
