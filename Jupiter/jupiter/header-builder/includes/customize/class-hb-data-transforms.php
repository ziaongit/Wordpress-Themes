<?php
/**
 * Header Builder: HB_Data_Transforms class.
 *
 * @package Header_Builder
 * @since 5.9.0
 */

/**
 * Generator of background layers. For transforming one array data to another.
 *
 * @SuppressWarnings(PHPMD)
 *
 * @since 5.9.2
 * @since 5.9.3 Add function background_properties.
 */
class HB_Data_Transforms {
	/**
	 * Set background values.
	 *
	 * @since 5.9.2
	 *
	 * @param  mix $background The number of background layer.
	 * @return string         Generated background CSS properties and values.
	 */
	public function background_layer( $background ) {
		$layer = array();

		// Duck-type to check if we have a "gradient" data.
		if ( array_key_exists( 'angle', $background ) && array_key_exists( 'type', $background ) && array_key_exists( 'color1', $background ) && array_key_exists( 'color2', $background ) ) {
			$layer = array(
				'type' => 'gradient',
				'direction' => $background['angle'],
				'function' => $background['type'],
				'color_stops' => array(
					array(
						'color' => $background['color1'],
						'stop' => '0%',
					),
					array(
						'color' => $background['color2'],
						'stop' => '100%',
					),
				),
			);
		} elseif ( array_key_exists( 'color', $background ) ) {
			$layer = array(
				'type' => 'color',
				'value' => $background['color'],
			);
		} elseif ( array_key_exists( 'r', $background ) && array_key_exists( 'g', $background ) && array_key_exists( 'b', $background ) && array_key_exists( 'a', $background ) ) {
			$layer = array(
				'type' => 'color',
				'value' => $background,
			);
		} elseif ( array_key_exists( 'image', $background ) && array_key_exists( 'attachment', $background ) && array_key_exists( 'repeat', $background ) && array_key_exists( 'position', $background ) ) {
			$layer = array(
				'type' => 'image',
				'url' => $background['image'],
				'size' => 'auto',
				'repeat' => $background['repeat'],
				'position' => $background['position'],
				'attachment' => $background['attachment'],
				'origins' => 'padding-box',
				'clips' => 'border-box',
			);
		}// End if().

		return $layer;
	}

	/**
	 * Set background layers CSS properties.
	 *
	 * @since 5.9.2
	 *
	 * @param  array   $layers       Layers contain backgrounds.
	 * @param  boolean $check_status Current background status.
	 * @return array                 Background layers properties.
	 */
	public function background_layers( $layers = array(), $check_status = false ) {
		$visible_layers = array();

		foreach ( $layers as $layer ) {
			if ( empty( $layer ) ) {
				continue;
			}

			if ( isset( $layer['status'] ) || ! $check_status ) {
				$visible_layers[] = $this->background_layer( $layer );
			}
		}

		return $visible_layers;
	}

	/**
	 * Get background property of element.
	 *
	 * @since 5.9.3
	 *
	 * @param  array $data List of background layer from backend.
	 * @return array       Element background properties.
	 */
	public function background_properties( $data ) {
		if ( ! is_array( $data ) || empty( $data ) ) {
			return array();
		}

		// Always set as an array and check all values even you know the data structures.
		$bg_solid    = ( ! empty( $data['solid'] ) ) ? (array) $data['solid'] : array();
		$bg_gradient = ( ! empty( $data['gradient'] ) ) ? (array) $data['gradient'] : array();
		$bg_image    = ( ! empty( $data['image'] ) ) ? (array) $data['image'] : array();

		// Color first.
		$background = array();

		// Add the color to the layers if it is activated.
		if ( array_safe_get( $bg_solid, 'status', true, array( 'true', 1 ) ) ) {
			$background[] = array_safe_get( $bg_solid, 'color' );
		}

		// Add the gradient to the layers if it is activated.
		if ( array_safe_get( $bg_gradient, 'status', false, array( 'true', 1 ) ) ) {
			$background[] = $bg_gradient;
		}

		// Add the image to the layers if it is activated.
		if ( array_safe_get( $bg_image, 'status', false, array( 'true', 1 ) ) ) {
			$image = array_safe_get( $bg_image, 'content', 'none' );

			$background[] = array(
				'image' => $image,
				'attachment' => array_safe_get( $bg_image, 'attachment' ),
				'repeat' => array_safe_get( $bg_image, 'repeat' ),
				'position' => array_safe_get( $bg_image, 'position' ),
			);

			unset( $image );
		}

		return $background;
	}

	/**
	 * Unwrap data from the { ...data, specificty: {}} construct.
	 *
	 * @since 5.9.6
	 *
	 * @param  mixed|array $data Data to unwrap.
	 * @return mixed|array Data without the specificity key.
	 */
	public function unwrap( $data ) {
		// Bail if nothing to unwrap.
		if ( ! is_array( $data ) ) {
			return $data;
		}

		// Remove the specificity key, we don't need it.
		if ( array_key_exists( 'specificity', $data ) ) {
			unset( $data['specificity'] );
		}

		// If the only key available is a "value" key, we unwrap it.
		if ( 1 === count( $data ) && array_key_exists( 'value', $data ) ) {
			return $data['value'];
		}

		return $data;
	}
}
