<?php
/**
 * Header Builder: HB_Element_Row class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Row' element to the front end.
 *
 * @todo  Check output of background properties.
 *
 * @since 5.9.0
 * @since 5.9.3 Update default values, add alignment, and make inline properties.
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 * @since 5.9.5 Remove unused parameter on constructor.
 *
 * @see HB_Element
 */
class HB_Element_Row extends HB_Element {
	/**
	 * Constructor.
	 *
	 * @todo Should be improved if we not use base64 for image anymore.
	 * @todo Find away to avoid very long settings declaration.
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
	 *           @type array $padding {
	 *                The padding of the row. Default is 0 for all.
	 *
	 *                @type string top
	 *                @type string right
	 *                @type string bottom
	 *                @type string left
	 *           }
	 *           @type array $margin  {
	 *                The margin of the row. Default is 0 for all.
	 *
	 *                @type string top
	 *                @type string right
	 *                @type string bottom
	 *                @type string left
	 *           }
	 *           @type array $rowBackgroundImage
	 *           @type array $rowBackgroundSolidColor
	 *           @type array $rowBackgroundGradientColor
	 *           @type array $width
	 *           @type array $border
	 *     }
	 * }
	 * @param int    $row_index Numeric index for the row.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $hb_customize ) {
		parent::__construct( $element, $row_index, false, false, $hb_customize );

		// Declare properties value.
		$this->padding = $this->get_option( 'padding', array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
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
				'status' => true,
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

		$this->border  = $this->get_option( 'border', array(
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

		$this->width = $this->get_option( 'width', 'full' );
		$this->align = $this->get_option( 'align', 'initial' );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
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

		// Row margin and padding.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		// Row background.
		$bg_properties = $this->hb_customize->transforms->background_properties( $this->background );
		$background    = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( $bg_properties ) );

		// Row border.
		$border = $this->hb_customize->css->border( $this->border );

		// Row width.
		$width = '
			width: 100%;
			margin-right: auto;
			margin-left: auto;
		';

		if ( 'fixed' === $this->width ) {
			// Because we don't have any default value for fixed. We use mk_options grid_width.
			global $mk_options;
			$boxed_layout_width = ( ! empty( $mk_options['grid_width'] ) ) ? $mk_options['grid_width'] + 60 : 1140;

			$width .= 'max-width: ' . $boxed_layout_width . 'px;';
		}

		$style = "
			#{$this->id} {
				padding: {$padding};
				margin: {$margin};
				{$background}
				{$border}
			}

			#{$this->id} .hb-container {
				{$width}
			}
		";

		return compact( 'markup', 'style' );
	}

}
