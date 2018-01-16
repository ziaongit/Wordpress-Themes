<?php
/**
 * Header Builder: HB_Attributes class.
 *
 * @package Header_Builder
 * @since 5.9.3
 */

/**
 * Generator of HTML attributes.
 *
 * @since 5.9.3
 */
class HB_Attributes {

	/**
	 * Get HTML attribute.
	 *
	 * @since 5.9.3
	 *
	 * @param  string $tag          Tag name.
	 * @param  string $value        Tag value.
	 * @param  string $return_empty Check if the $value equal with, return empty string.
	 * @return mixed                HTML attribute generated.
	 */
	public function get_attr( $tag = '', $value = 'auto', $return_empty = '' ) {
		if ( empty( $tag ) || empty( $value ) || $value === $return_empty ) {
			return '';
		}

		return $tag . '="' . esc_attr( $value ) . '"';
	}

	/**
	 * Get height or width attribute and style.
	 *
	 * @since 5.9.3
	 *
	 * @param  string $type Tag name.
	 * @param  string $size Tag value.
	 * @return array        Height or width attribute and style.
	 */
	public function get_height_width( $type = 'height', $size = 'auto' ) {
		$type_attr = $this->get_attr( $type, $size, 'auto' );
		$data = array(
			'attr'  => $type_attr,
			'style' => ( ! empty( $type_attr ) ) ? '' : $type . ': auto;',
		);

		return $data;
	}

}
