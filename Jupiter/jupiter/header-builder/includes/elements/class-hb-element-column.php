<?php
/**
 * Header Builder: HB_Element_Column class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Column' element to the front end.
 *
 * @todo  Check output of background properties.
 *
 * @since 5.9.0
 * @since 5.9.3 Update default values, add background properties, and refactoring.
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 * @since 5.9.5 Remove unused parameter on constructor.
 *
 * @see HB_Element
 */
class HB_Element_Column extends HB_Element {
	/**
	 * Constructor.
	 *
	 * @since 5.9.0
	 * @since 5.9.3 Update default values.
	 * @since 5.9.4 Add $hb_customize property on constructor.
	 * @since 5.9.5 Remove unused $markup_content property.
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
	 *           Array of element CSS properties.
	 *
	 *           @type array $columnBackgroundImage
	 *           @type array $columnBackgroundSolidColor
	 *           @type array $columnBackgroundGradientColor
	 *           @type array $border
	 *           @type array $padding {
	 *                The padding of the column. Default is 0 for all.
	 *
	 *                @type string top
	 *                @type string right
	 *                @type string bottom
	 *                @type string left
	 *           }
	 *           @type array $margin  {
	 *                The margin of the column. Default is 0 for all.
	 *
	 *                @type string top
	 *                @type string right
	 *                @type string bottom
	 *                @type string left
	 *           }
	 *     }
	 * }
	 * @param int    $column_index Numeric index for the column.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $column_index, $hb_customize ) {
		parent::__construct( $element, $column_index, false, false, $hb_customize );

		// Declare properties value.
		$this->padding = $this->get_option( 'padding', array(
			'top' => 0,
			'right' => 15,
			'bottom' => 0,
			'left' => 15,
		) );
		$this->margin  = $this->get_option( 'margin', array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
		) );

		$this->background = $this->get_option( 'background', array(
			'image' => array(
				'content' => 'none',
			),
			'solid' => array(
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
				'status' => false,
			),
			'gradient' => array(
				'color1' => array(
					'r' => 0,
					'g' => 0,
					'b' => 0,
					'a' => 1,
				),
				'color2' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 0.25,
				),
				'type' => 'linear',
				'angle' => 20,
			),
		) );

		$this->column_border  = $this->get_option( 'border', array(
			'top' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
			'right' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
			'bottom' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
			'left' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
		) );
		$this->align = $this->get_option( 'align', 'initial' );
		$this->vertical_align = $this->get_option( 'verticalAlignment', 'top' );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.3 Add background property and refactor.
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		$style     = '';
		$markup    = '';

		// Column padding and margin.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		// Column margin for left and right.
		$margin_right = $this->margin['right'];
		$margin_left  = $this->margin['left'];

		// Column background.
		$bg_properties = $this->hb_customize->transforms->background_properties( $this->background );
		$background    = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( $bg_properties ) );

		// Column border.
		$border = $this->hb_customize->css->border( $this->column_border );

		// Column Offset.
		$column_offset = $margin_right + $margin_left;

		// Column Vertical Alignment.
		$vertical_align = $this->hb_customize->layout->vertical_align( $this->vertical_align );

		$style = "
		  	#{$this->id} {
				padding: {$padding};
				margin: {$margin};
				{$vertical_align}
				{$background}
				{$border}
			}
			#{$this->id}.hb-col-md-12 {
				width: calc(100% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-11 {
				width: calc(91.66666667% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-10 {
				width: calc(83.33333333% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-9 {
				width: calc(75% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-8 {
				width: calc(66.66666667% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-7 {
				width: calc(58.33333333% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-6 {
				width: calc(50% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-5 {
				width: calc(41.66666667% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-4 {
				width: calc(33.33333333% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-3 {
			 	width: calc(25% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-2 {
			 	width: calc(16.66666667% - {$column_offset}px);
			}
			#{$this->id}.hb-col-md-1 {
				width: calc(8.33333333% - {$column_offset}px);
			}
		";

		if ( ! empty( $vertical_align ) ) {
			$style .= "
				#{$this->id} .hb-col-container {
					width: 100%;
				}
			";
		}

		return compact( 'markup', 'style' );
	}

}
