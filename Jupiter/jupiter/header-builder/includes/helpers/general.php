<?php
/**
 * General helper functions.
 *
 * @package Header_Builder
 * @subpackage Helpers
 * @since 5.9.1
 * @since 5.9.3 Add checking function for WooCommerce.
 * @since 5.9.5 Function 'hb_is_frontend_active' is deprecated.
 */

if ( ! function_exists( 'hb_is_frontend_active' ) ) :
	/**
	 * Check if HB front end is active outside the preview page.
	 *
	 * @since 5.9.1
	 * @since 5.9.5 Deprecated. But, we will keep this as a note.
	 *
	 * @return boolean True if active. Default is false.
	 */
	function hb_is_frontend_active() {
		$hb_options = json_decode( get_option( 'artbees_header_builder' ) );

		return isset( $hb_options->model ) && isset( $hb_options->model->activeOnFrontEnd ) && $hb_options->model->activeOnFrontEnd;
	}
endif;

if ( ! function_exists( 'hb_is_to_active' ) ) :
	/**
	 * Check if HB front end is activated from Theme Options.
	 *
	 * @since 5.9.5
	 *
	 * @return boolean True if active. Default is false.
	 */
	function hb_is_to_active() {
		global $mk_options;
		$is_active_to = ( ! empty( $mk_options['header_layout_builder'] ) ) ? $mk_options['header_layout_builder'] : 'pre_built_header';

		if ( 'header_builder' === $is_active_to ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'mkhb_active_current_menu_item' ) ) :
	/**
	 * Add current-menu-item class in preview navigation.
	 *
	 * @since 5.9.1
	 *
	 * @param  string $output Navigation HTML output.
	 * @return boolean        True if active. Default is false.
	 */
	function mkhb_active_current_menu_item( $output ) {
		$output = preg_replace( '/class="menu-item/', 'class="current-menu-item menu-item', $output, 1 );
		return $output;
	}
endif;

if ( ! function_exists( 'hb_woocommerce_is_active' ) ) :
	/**
	 * Check if WooCommerce is active or not by checking if WooCommerce is exist or not.
	 *
	 * @since 5.9.3
	 *
	 * @return boolean WooCommerce activation status.
	 */
	function hb_woocommerce_is_active() {
		if ( class_exists( 'WooCommerce' ) ) {
			return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'hb_is_json' ) ) :
	/**
	 * Check if the data is correct JSON format or not.
	 *
	 * @since 5.9.8
	 * @param mixed $data Data need to be check.
	 * @return boolean    True if the data is correct JSON.
	 */
	function hb_is_json( $data ) {
		json_decode( $data );
		return ( json_last_error() === JSON_ERROR_NONE );
	}
endif;

if ( ! function_exists( 'hb_is_shortcode_displayed' ) ) :
	/**
	 * Check if the shortcode is rendered in current device.
	 *
	 * @since 6.0.0
	 *
	 * @param  string $device    Current device used.
	 * @param  array  $visibilty Shortcode device visibility.
	 * @return boolean           True if displayed, false if not.
	 */
	function hb_is_shortcode_displayed( $device, $visibilty ) {
		if ( empty( $device ) || empty( $visibilty ) ) {
			return false;
		}

		if ( false !== strpos( $visibilty, $device ) ) {
			return true;
		}

		return false;
	}
endif;

if ( ! function_exists( 'hb_shortcode_display_class' ) ) :
	/**
	 * Get additional container class based on element display and alignment.
	 *
	 * @since 6.0.0
	 *
	 * @param  array $options All shortcode attributes.
	 * @return string         Additional class for display and alignment.
	 */
	function hb_shortcode_display_class( $options ) {
		$el_class = 'mkhb-block';
		if ( ! empty( $options['display'] ) ) {
			if ( 'inline' === $options['display'] ) {
				$el_class = 'mkhb-inline-left';
				if ( ! empty( $options['alignment'] ) ) {
					$el_class = 'mkhb-inline-' . $options['alignment'];
				}
			}
		}

		return $el_class;
	}
endif;

if ( ! function_exists( 'hb_shortcode_display_attr' ) ) :
	/**
	 * Get additional container attribute based on element display and alignment.
	 *
	 * @since 6.0.0
	 *
	 * @param  array $options All shortcode attributes.
	 * @return string         Additional attribute for display and alignment.
	 */
	function hb_shortcode_display_attr( $options ) {
		$data_align = 'left';
		$data_display = 'block';

		if ( ! empty( $options['alignment'] ) ) {
			$data_align = $options['alignment'];
		}

		if ( ! empty( $options['display'] ) ) {
			$data_display = $options['display'];
		}

		$data_attr = 'data-align="' . esc_attr( $data_align ) . '" data-display="' . esc_attr( $data_display ) . '"';

		return $data_attr;
	}
endif;

if ( ! function_exists( 'hb_enqueue_font' ) ) :
	/**
	 * Enqueue font family.
	 *
	 * @since 6.0.0
	 *
	 * @param  string  $element     Element type.
	 * @param  array   $font_family Font family will be used.
	 * @param  array   $font_type   Font type (Google, Typekit, Self).
	 * @param  integer $font_weight Font text weight.
	 */
	function hb_enqueue_font( $element, $font_family, $font_type, $font_weight = 400 ) {
		if ( 'google' === $font_type ) {
			// Set font label.
			$font_label = strtolower( str_replace( ' ', '_',  $font_family ) );
			$font_name = str_replace( ' ', '+',  $font_family );

			// Set font family and weight.
			$font_weight_label = '';
			$font_arg = ! empty( $font_name ) ? $font_name : 'Open+Sans';
			if ( ! empty( $font_weight ) ) {
				$font_arg .= ':' . $font_weight;
				$font_weight_label = '_' . $font_weight;
			}

			$query_args = array(
				'family' => $font_arg,
			);

			wp_register_style( 'hb_' . $element . '_font_' . $font_label . $font_weight_label, add_query_arg( $query_args, '//fonts.googleapis.com/css' ), array(), null );
			wp_enqueue_style( 'hb_' . $element . '_font_' . $font_label . $font_weight_label );
		}
	}
endif;

/**
 * Get HB header list.
 *
 * @since 6.0.0
 *
 * @return array Header builder list in array with key and title.
 */
function mkhb_get_header_list() {

	$options       = array();
	$fallback_id   = get_option( 'mkhb_global_header', 'nothing' );
	$fallback_post = get_post( $fallback_id );

	// Get data from DB.
	$posts = get_posts( array(
		'post_type'   => 'mkhb_header',
		'post_status' => 'publish',
		'numberposts' => -1,
		'orderby'     => 'title',
		'order'       => 'ASC',
		'exclude'     => $fallback_id,
	) );

	if ( null !== $fallback_post ) {
		array_unshift( $posts, $fallback_post );
	}

	// Set header options.
	if ( ! empty( $posts ) ) {
		foreach ( $posts as $header ) {
			$options[ $header->ID ] = $header->post_title;

			if ( absint( $header->ID ) === absint( $fallback_id ) ) {
				/* translators: %s: page title */
				$options[ $header->ID ] = sprintf( __( 'Global Header - %s', 'mk_framework' ), $header->post_title );
			}
		}
	}

	if ( empty( $options ) ) {
		$options = array(
			0 => __( 'No header found', 'mk_framework' ),
		);
	}

	return $options;
}

/**
 * Check HB is active or not for Post Admin area.
 *
 * @since 6.0.0
 *
 * @return boolean Return false if the process is already done.
 */
function mkhb_check_header_layout_builder() {
	$header_type = 'pre_built_header';
	$mk_options = get_option( THEME_OPTIONS );

	// If theme option is empty.
	if ( empty( $mk_options ) ) {
		return false;
	}

	// If header layout builder of theme options is not exist.
	if ( ! isset( $mk_options['header_layout_builder'] ) ) {
		return false;
	}

	$header_type = $mk_options['header_layout_builder'];

	// Get current post ID.
	$post_id_active = 0;
	if ( ! empty( $_GET['post'] ) ) { // WPCS: CSRF ok.
		$post_id_active = absint( $_GET['post'] );
	}

	// Get current meta of _header_layout_builder type.
	$header_type_meta = get_post_meta( $post_id_active, '_header_layout_builder', true );

	// If data already exist and equal, skip.
	if ( $header_type === $header_type_meta ) {
		return false;
	}

	update_post_meta( $post_id_active, '_header_layout_builder', $header_type );
}


/**
 * Check if current post/page override HB.
 *
 * @since 6.0.0
 *
 * @return boolean Return true if HB is overriden by post/page.
 */
function mkhb_is_override_by_styling() {
	$post_id = global_get_post_id();

	if ( ! empty( $post_id ) ) {
		$override = get_post_meta( $post_id, '_enable_local_backgrounds', true );
		$override = filter_var( $override, FILTER_VALIDATE_BOOLEAN );
		return $override;
	}

	return false;
}
