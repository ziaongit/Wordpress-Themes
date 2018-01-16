<?php
/**
 * Header Builder: HB_CSS class.
 *
 * @author Dominique Mariano <dom@artbees.net>
 *
 * @package Header_Builder
 * @since 5.9.1
 */

/**
 * Generator of CSS multiple backgrond properties.
 *
 * @since 5.9.1
 * @since 5.9.2 Add border function.
 * @since 5.9.3 Remove notation functions and split background function.
 */
class HB_CSS {

	/**
	 * Generate the RGBA color.
	 *
	 * @since 5.9.1
	 *
	 * @param  array $rgba The color properties values.
	 * @return string      Color in RGBA format.
	 */
	public function rgba( $rgba ) {
		if ( ! is_array( $rgba ) ) {
			return $rgba;
		}

		$red = array_safe_get( $rgba, 'r', 255 );
		$green = array_safe_get( $rgba, 'g', 255 );
		$blue = array_safe_get( $rgba, 'b', 255 );
		$alpha = array_safe_get( $rgba, 'a', 0 );

		return "rgba($red, $green, $blue, $alpha)";
	}

	/**
	 * Set border values.
	 *
	 * @since 5.9.2
	 *
	 * @param  array $borders Border values.
	 * @return string      Combined border value.
	 */
	public function border( $borders = array() ) {

		if ( empty( $borders ) || ! is_array( $borders ) ) {
			return 'border: 0';
		}

		$css = '';
		$positions = array( 'top', 'right', 'bottom', 'left' );
		foreach ( $borders as $position => $border ) {
			if ( ! in_array( $position, $positions, true ) ) {
				continue;
			}

			if ( ! array_key_exists( 'width', $border ) || ! array_key_exists( 'color', $border ) ) {
				continue;
			}

			$width = $border['width'];
			$unit  = 'px';    // This must be provided by data structure instead.
			$type  = 'solid'; // This must be provided by data structure instead.
			$color = $this->rgba( $border['color'] );

			$css .= sprintf( "border-%s: %s%s %s %s;\n", $position, $width, $unit, $type, $color );
		}

		return $css;
	}

	/**
	 * Return same value of the property.
	 *
	 * @since 5.9.1
	 *
	 * @param  mixed $value Property value.
	 * @return mixed        Property value in px.
	 */
	public function same( $value ) {
		return $value;
	}

	/**
	 * Generate CSS background properties.
	 *
	 * @since 5.9.2
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
	 *
	 * @param  array  $layers The number of background layer.
	 * @param  string $css    The default CSS background.
	 * @return string         Generated background CSS properties and values.
	 */
	public function background( $layers = array(), $css = '' ) {
		$css = '';
		$num_layers = count( $layers );
		$num_gradients = 0;

		if ( ! $num_layers ) {
			return $css;
		}

		// Start fromt the last, and from it search for the first occurence
		// of a solid color layer. The last position of solid color layer hides
		// everything before it. So...
		for ( $i = $num_layers - 1; $i >= 0; $i-- ) {
			$layer = $layers[ $i ];

			// Also count the gradient starting from the last position only.
			if ( 'gradient' === array_safe_get( $layer, 'type' ) ) {
				$num_gradients++;
			}

			if ( 'color' === array_safe_get( $layer, 'type' ) ) {
				$css .= sprintf( "background-color: %s;\n", $this->rgba( $layer['value'] ) );
				break;
			}
		}
		unset( $layer ); // We unset $layer but not $i.

		// Auto-prefixer.
		$auto_prefix = self::background_autoprefixer( $num_layers, $layers, $i, $css, $num_gradients );

		// The following values can receive CSS properties as a comma-separated list.
		$css .= $auto_prefix['css'];
		$repeats = array_safe_get( $auto_prefix['repeats'], 'value', array() );
		$positions = array_safe_get( $auto_prefix['positions'], 'value', array() );
		if ( ! empty( $auto_prefix['sizes'] ) ) {
			$css .= 'background-size: ' . implode( ', ', $auto_prefix['sizes'] ) . ";\n";
			$css .= 'background-repeat: ' . implode( ', ', $repeats ) . ";\n";
			$css .= 'background-position: ' . implode( ', ', $positions ) . ";\n";
			$css .= 'background-attachment: ' . implode( ', ', $auto_prefix['attachments'] ) . ";\n";
			$css .= 'background-origin: ' . implode( ', ', $auto_prefix['origins'] ) . ";\n";
			$css .= 'background-clip: ' . implode( ', ', $auto_prefix['clips'] ) . ';';
		}

		return $css;
	}

	/**
	 * Set auto prefix for background.
	 *
	 * @since 5.9.3
	 *
	 * @param  integer $num_layers    How many layers use.
	 * @param  array   $layers        Background layers details.
	 * @param  integer $init          The first number of layers.
	 * @param  string  $css           Current background CSS properties.
	 * @param  integer $num_gradients Number of gradients used as background.
	 * @return array                  Collection of background properties.
	 */
	public static function background_autoprefixer( $num_layers, $layers, $init, $css, $num_gradients ) {
		$css   = '';
		$sizes = array();
		$repeats = array();
		$positions = array();
		$attachments = array();
		$origins = array();
		$clips = array();

		// Auto-prefixer.
		foreach ( array( '-moz-', '-webkit-', '' ) as $prefix ) {
			$images = array();

			// Since the last position of solid color layer hides everything
			// before it, do not render all the layers that it hides.
			for ( $j = $init + 1;  $j < $num_layers;  $j++ ) {
				$layer = $layers[ $j ];
				switch ( $layer['type'] ) {
					case 'image':
						$images[] = self::image( array_safe_get( $layer, 'url', 'none' ) );
						break;
					case 'gradient':
						$images[] = self::gradient( $layer, $prefix );
						break;
					default:
						break;
				}
				$sizes[] = array_safe_get( $layer, 'size', 'auto' );
				$repeats[] = array_safe_get( $layer, 'repeat', 'repeat' );
				$positions[] = array_safe_get( $layer, 'position', '0% 0%' );
				$attachments[] = array_safe_get( $layer, 'attachment', 'scroll' );
				$origins[] = array_safe_get( $layer, 'origin', 'padding-box' );
				$clips[] = array_safe_get( $layer, 'clip', 'border-box' );
			}
			// We can specify images (including gradients) as comma-separated list.
			$bg_image = ( ! empty( $images ) ) ? implode( ', ', $images ) : 'none';
			$css .= 'background-image: ' . $bg_image . ";\n";

			if ( ! $num_gradients ) {
				break;
			}
		} // End foreach().

		return array(
			'css' => $css,
			'sizes' => $sizes,
			'repeats' => $repeats,
			'positions' => $positions,
			'attachments' => $attachments,
			'origins' => $origins,
			'clips' => $clips,
		);
	}

	/**
	 * Generate CSS background gradient type.
	 *
	 * @since 5.9.1
	 *
	 * @param  array  $layer  Background layer peroperties.
	 * @param  string $prefix Selected browser prefix.
	 * @return callable       Call another function to get radial/linear gradient CSS.
	 */
	public static function gradient( $layer, $prefix = '' ) {
		$color_stops = array_safe_get( $layer, 'color_stops', array() );

		if ( 'linear' === array_safe_get( $layer, 'function' ) ) {
			$direction = array_safe_get( $layer, 'direction', 0 );
			return self::linear_gradient( $direction, $color_stops, $prefix );
		}

		return self::radial_gradient( $color_stops, $prefix );
	}

	/**
	 * Generate CSS background image URL.
	 *
	 * @since 5.9.1
	 *
	 * @param  string $image Image URL. Default is none.
	 * @return string        Background image value. Default is none.
	 */
	public static function image( $image ) {
		return 'none' === $image ? 'none' : "url($image)";
	}

	/**
	 * Generate CSS background gradient radial.
	 *
	 * @since 5.9.1
	 *
	 * @param  array  $color_stops Start and end of gradient colors.
	 * @param  string $prefix      Selected browser prefix.
	 * @return string              Generate background gradient radial properties and values.
	 */
	public static function radial_gradient( $color_stops = array(), $prefix = '' ) {
		$shape = $prefix ? 'center, ellipse cover' : 'ellipse at center';

		$css = $prefix . "radial-gradient($shape";
		$it_self = new self();
		foreach ( $color_stops as $color_stop ) {
			$css .= sprintf( ', %s %s', $it_self->rgba( $color_stop['color'] ), $color_stop['stop'] );
		}
		$css .= ')';

		return $css;
	}

	/**
	 * Generate CSS background gradient linear.
	 *
	 * @since 5.9.1
	 *
	 * @param  integer $direction   The gradient direction in degree.
	 * @param  array   $color_stops Start and end of gradient colors.
	 * @param  string  $prefix      Selected browser prefix.
	 * @return string               Generate background gradient linear properties and values.
	 */
	public static function linear_gradient( $direction = 0, $color_stops = array(), $prefix = '' ) {
		$direction = $prefix ? self::angel_to_prefixed_equivalent( $direction ) : $direction;
		$direction .= 'deg';

		$css = $prefix . "linear-gradient($direction";
		$it_self = new self();
		foreach ( $color_stops as $color_stop ) {
			$css .= sprintf( ', %s %s', $it_self->rgba( $color_stop['color'] ), $color_stop['stop'] );
		}
		$css .= ')';

		return $css;
	}

	/**
	 * Get the angel prefixed equivalent.
	 *
	 * @since 5.9.1
	 *
	 * @param  integer $degree Current degree of direction.
	 * @return integer         Converted prefixed equivalent degree.
	 */
	public static function angel_to_prefixed_equivalent( $degree = 0 ) {
		return 90 - $degree;
	}

}
