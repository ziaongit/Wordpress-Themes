<?php
/**
 * Header Builder: HB_CSS_Layout class.
 *
 * @package Header_Builder
 * @since 5.9.3
 */

/**
 * Generator of CSS layout and position properties.
 *
 * @since 5.9.3
 */
class HB_CSS_Layout {

	/**
	 * Get inline block CSS styles.
	 *
	 * @since 5.9.3
	 *
	 * @param  boolean $display Element inline display. Default is false.
	 * @return string           Inline style CSS properties.
	 */
	public function inline_block( $display = 'block' ) {
		if ( 'inline' !== $display || empty( $display ) ) {
			return '';
		}

		return '
			display: inline-block;
			vertical-align: top;
		';
	}

	/**
	 * Generate margin and padding properties.
	 *
	 * @since 5.9.3
	 *
	 * @todo  Should be removed later because we have a better format to set margin and padding.
	 *
	 * @param  array $margin_param  Margin parameter values.
	 * @param  array $padding_param Padding parameter values.
	 * @return array                 Margin and Padding in array.
	 */
	public function margin_padding( $margin_param = array(), $padding_param = array() ) {
		// Set margin properties and values.
		$margin  = '';
		if ( ! empty( $margin_param ) ) {
			foreach ( $margin_param as $key => $value ) {
				$margin .= 'margin-' . $key . ': ' . $value . "px;\n";
			}
			unset( $key, $property, $value );
		}

		// Set padding properties and values.
		$padding = '';
		if ( ! empty( $padding_param ) ) {
			foreach ( $padding_param as $key => $value ) {
				$padding .= 'padding-' . $key . ': ' . $value . "px;\n";
			}
			unset( $key, $property, $value );
		}

		return compact( 'margin', 'padding' );
	}

	/**
	 * Set position properties value.
	 *
	 * @since 5.9.3
	 *
	 * @param  array $trbl Properties value.
	 * @return string      Combined property value.
	 */
	public function trbl( $trbl = array() ) {
		$trbl = wp_parse_args( $trbl, array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
		) );
		return sprintf( '%spx %spx %spx %spx', $trbl['top'], $trbl['right'], $trbl['bottom'], $trbl['left'] );
	}

	/**
	 * Generate CSS properties for flex align items (vertical alignment).
	 *
	 * @param  string $align Vertical alignment position value.
	 * @return string        CSS properties of flex align items.
	 */
	public function vertical_align( $align = 'top' ) {
		if ( empty( $align ) || 'top' === $align ) {
			return '';
		}

		$align_values = array(
			'top' => 'flex-start',
			'middle' => 'center',
			'bottom' => 'flex-end',
		);

		return "
			display: flex;
			align-items: {$align_values[ $align ]};
		";
	}

}
