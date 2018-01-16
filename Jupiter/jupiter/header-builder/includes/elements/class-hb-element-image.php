<?php
/**
 * Header Builder: HB_Element_Image class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Image' element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.3 Update the default values, add alignment, and make inline properties
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 *
 * @see HB_Element
 */
class HB_Element_Image extends HB_Element {
	/**
	 * Generate markup and style for the 'Image' element.
	 *
	 * @since 5.9.0
	 * @since 5.9.3 Update the default values.
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
	 *           @type array $fileInfo {
	 *                 File information
	 *
	 *                 @type string $name
	 *                 @type string $type
	 *                 @type string $size
	 *                 @type string $content
	 *           }
	 *           @type string $url
	 *           @type string $width
	 *           @type string $height
	 *           @type string $alignment
	 *           @type string $cssDisplay
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		// Declare properties value.
		$this->width  = $this->get_option( 'width', 1 );
		$this->height = $this->get_option( 'height', 1 );
		$this->url    = $this->get_option( 'url', '' );
		$this->alignment  = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );
		$this->file_info = $this->get_option( 'fileInfo', array() );

		// Enqueue the search style and HB script.
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

	}

	/**
	 * Enqueue image style and HB script.
	 *
	 * @since 5.9.3
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-image', HB_ASSETS_URI . 'css/hb-image.css', array(), '0.0.1' );
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
		// Image image link.
		$link = '';
		if ( ! empty( $this->url ) ) {
			$link = $this->hb_customize->attributes->get_attr( 'href', esc_url( $this->url ) );
		}

		// Image width.
		$width = $this->hb_customize->attributes->get_height_width( 'width', $this->width );
		$width_attr  = $width['attr'];
		$width_style = $width['style'];

		// Image height.
		$height = $this->hb_customize->attributes->get_height_width( 'height', $this->height );
		$height_attr  = $height['attr'];
		$height_style = $height['style'];

		// Image inline block.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		$markup = sprintf( '
			<div id="%s" class="hb-image-el">
				<a %s class="hb-image-el__link">
					<img class="hb-image-el__image" src="%s" %s %s />
				</a>
			</div>',
			esc_attr( $this->id ),
			$link,
			esc_attr( array_key_exists( 'url', $this->file_info ) ? $this->file_info['url'] : '' ),
			$width_attr,
			$height_attr
		);

		$style = "
			#{$this->id} {
				text-align: {$this->alignment};
				{$inline}
			}
		";

		// Image default value if user didn't set any value of width/height.
		if ( ! empty( $width_style ) || ! empty( $height_style ) ) {
			$style .= "
				#{$this->id} .hb-image-el__image {
					{$height_style}
					{$width_style}
				}
			";
		}

		return compact( 'markup', 'style' );
	}
}
