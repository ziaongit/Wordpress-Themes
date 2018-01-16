<?php
/**
 * Header Builder: HB_Tags class.
 *
 * @package Header_Builder
 * @since 5.9.4
 */

/**
 * Generator of HTML tags.
 *
 * @since 5.9.4
 */
class HB_Tags {

	/**
	 * Enqueue selected font for specific elements.
	 *
	 * @since 5.9.4
	 *
	 * @param  string  $type        Element key name.
	 * @param  array   $font_family Element font family in array (value and label).
	 * @param  integer $text_weight Element text_weight.
	 * @return boolean              Return false if font family is empty.
	 */
	public function enqueue_fonts( $type = 'button', $font_family = array(), $text_weight = 400 ) {
		if ( empty( $font_family ) || ! is_array( $font_family ) ) {
			return false;
		}

		if ( 'google' === $font_family['type'] ) {
			// Set font label.
			$font_label = strtolower( str_replace( ' ', '_',  $font_family['label'] ) );

			// Set font family and weight.
			$font_arg = ! empty( $font_family['value'] ) ? $font_family['value'] : 'Open+Sans';
			$font_arg .= ( ! empty( $text_weight ) ) ? ':' . $text_weight : '';

			$query_args = array(
				'family' => $font_arg,
			);

			wp_enqueue_style( 'hb_' . $type . '_font_' . $font_label, add_query_arg( $query_args, '//fonts.googleapis.com/css' ), array(), null );
		}
	}

}
