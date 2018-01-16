<?php
/**
 * Header Builder: Elements Generator, HB_Grid class.
 *
 * For use in front end integration with Jupiter.
 *
 * @author Mehdi Shojaei <mehdi@artbees.net>
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 * @since 5.9.4 Add parameters on HB_Grid declaration.
 * @since 5.9.5 Move HB_Grid declaration to HB_Main on wp_loaded hook.
 * @deprecated 6.0.0 No longer used because all the element will be rendered as shortcode.
 */

/**
 * Takes JSON saved in database and output HTML and CSS on the front end.
 *
 * @SuppressWarnings(PHPMD)
 *
 * Warnings: get_src will be refactor later.
 *
 * @since 5.9.0
 * @since 5.9.3 Add make inline and alignment property.
 * @since 5.9.4 Add new property on constructor parameter to load HB customize class instances.
 * @since 5.9.5 Allow to get source from all devices and add class device prefix. Use action to load
 *              HB style and markup.
 *
 * We won't declare Mk_Header_Builder to be a singleton, as we might eventually find ourselves
 * needing different instances of it.
 */
class HB_Grid {
	/**
	 * Stores array data from JSON retrieved from options table.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var array $model The 'model' stored in 'artbees_header_builder' option.
	 */
	protected $model;

	/**
	 * Stores markup for all available data in $model.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var string $header_markup HTML output.
	 */
	protected $header_markup;

	/**
	 * Stores styles for all available data in $model.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var string $header_style CSS output.
	 */
	protected $header_style;

	/**
	 * HB_ customize class instances store in $hb_customize.
	 *
	 * @since 5.9.4
	 * @access private
	 * @var array $hb_customize Array list of HB_ customize instances.
	 */
	private $hb_customize;

	/**
	 * Constructor.
	 *
	 * @since 5.9.0
	 *
	 * @since 5.9.4 Add $hb_customize as constructor parameter to load HB customize class instances.
	 * @since 5.9.5 Allow to get source from all devices. Add two actions to render HB style and markup.
	 *
	 * @param object $hb_customize HB_Costumize instances.
	 */
	public function __construct( $hb_customize ) {
		$option = $this->get_header_data();
		$option = json_decode( $option, true );
		$model = isset( $option['model'] ) ? $option['model'] : array();

		$this->model = $model;
		$this->hb_customize = $hb_customize;

		// Otherwise, throw an error if this file is missing.
		if ( ! class_exists( 'Mk_Header_Builder' ) ) {
			require_once( HB_INCLUDES_DIR . '/elements/class-hb-element.php' );
		}

		$output = $this->get_src( 'all' );

		$this->header_markup = $output['markup'];
		$this->header_style = $output['style'];

		add_action( 'hb_grid_style', array( &$this, 'render_style' ) );
		add_action( 'hb_grid_markup', array( &$this, 'render_markup' ) );
	}

	/**
	 * Output header builder markup on front-end.
	 *
	 * @since 5.9.0
	 */
	public function render_markup() {
		echo $this->markup(); // WPCS: XSS OK.
	}

	/**
	 * Output header builder styles on front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.5 Use wp_add_inline_style instead of echo.
	 */
	public function render_style() {
		// @todo Find a way to minimize the CSS style.
		wp_add_inline_style( 'hb-grid', $this->style() );
	}

	/**
	 * Return header builder styles on front-end.
	 *
	 * @since 5.9.0
	 */
	public function style() {
		return $this->header_style;
	}

	/**
	 * Return header builder markup on front-end.
	 *
	 * @since 5.9.0
	 */
	public function markup() {
		return $this->header_markup;
	}

	/**
	 * Output the header builder front end to Jupiter.
	 *
	 * @since 5.9.0
	 * @since 5.9.7 Add new container after hb-device to handle the position of fixed/sticky/overlap
	 *              header. Check if sticky header should be rendered or not.
	 *
	 * @see get_device_src()
	 *
	 * @param string|array $devices List of devices to render. Accetps string values of
	 *     'desktop', 'tablet', 'mobile' or an array containing any combination of these values.
	 *     When 'all' is provided, it will be the equivalent of array('desktop', 'tablet', 'mobile').
	 * @return array {
	 *     @type string $markup Stringified HTML.
	 *     @type string $style Stringified CSS.
	 * }
	 */
	public function get_src( $devices = 'all' ) {
		$markup = '';
		$style = '';
		$accepted_device_list = array( 'normal-desktop', 'normal-tablet', 'normal-mobile', 'sticky-desktop', 'sticky-tablet', 'sticky-mobile' );

		if ( 'all' === $devices ) {
			$devices = $accepted_device_list;
		}

		$devices = array_intersect( (array) $devices, $accepted_device_list );
		if ( empty( $devices ) ) {
			return compact( 'markup', 'style' );
		}

		foreach ( $devices as $device_val ) {
			// Extract device value.
			$device_target = explode( '-', $device_val );

			// Set device type (parent of device name) and device.
			$device_type = array_safe_get( $device_target, 0, '' );
			$device_name = array_safe_get( $device_target, 1, '' );

			// Check all conditions before render all elements on specific device.
			if ( false === $this->is_render_device( $device_type ) ) {
				continue;
			}

			$rendered = $this->get_device_src( $device_type, $device_name );

			// Add class and attributes if the header is sticky or fixed/overlapping.
			$header_class = $this->get_header_type_class( $device_name, $rendered['markup'], $device_type );
			$header_attr = $this->get_header_type_attr( $device_name, $device_type );

			$markup .= sprintf(
				'<div class="%s" %s><div class="%s">',
				esc_attr( "hb-device hb-$device_name $header_class" ),
				$header_attr,
				esc_attr( 'hb-device-container' )
			);
			$markup .= $rendered['markup'];
			$markup .= '</div></div>';

			$style .= $rendered['style'];
		}

		return compact( 'markup', 'style' );
	}

	/**
	 * Output the header builder front-end set for a specific device.
	 *
	 * @since 5.9.0
	 * @since 5.9.5 Pass new parameter to get_row_src() function.
	 * @since 5.9.8 Pass new parameter called device type to define current workplace. Accept
	 *              'normal' or 'sticky'. See $this->get_row_src().
	 *
	 * @see get_row_src()
	 *
	 * @param string $device_type Device type. Accepts 'normal', 'sticky'.
	 * @param string $device_name Device name. Accepts 'desktop', 'tablet', 'mobile'.
	 * @return array {
	 *     @type string $markup Stringified HTML.
	 *     @type string $style Stringified CSS.
	 * }
	 */
	public function get_device_src( $device_type, $device_name ) {
		$markup = '';
		$style = '';

		// Get model data based on 'type' and 'device' name. For example: normal => desktop.
		$device_parent = array_safe_get( $this->model, $device_type, array() );
		$device_model = array_safe_get( $device_parent, $device_name, array() );

		$current_device_model = array_safe_get( $device_model, 'present', array() );

		$rows = array_safe_get( $current_device_model, 'rows', array() );
		$options = array_safe_get( $current_device_model, 'options', array() );
		$fullwidth = array_safe_get( $options, 'fullWidth', false );

		// Ensure not empty rows allowed to be processed.
		if ( empty( $rows ) ) {
			return compact( 'markup', 'style' );
		}

		foreach ( $rows as $row_index => $row_model ) {
			$row_model = $this->hb_customize->transforms->unwrap( $row_model );

			$rendered = $this->get_row_src( $row_model, $row_index, $fullwidth, $device_name, $device_type );

			$markup .= $rendered['markup'];
			$style .= $rendered['style'];
		}

		$markup .= '';

		return compact( 'markup', 'style' );
	}

	/**
	 * Output the header builder front-end set for a specific row.
	 *
	 * @since 5.9.0

	 * @since 5.9.4 Add $hb_customize property on row constructor.
	 * @since 5.9.5 Add new parameter on get_row_src() function, pass new parameter to get_column_src()
	 *              function. Remove unused property on row element declaration.
	 * @since 5.9.7 Remove array type of the parameter. Force the data to pass an array cause the fatal
	 *              error. Prefer to check it first before extract it.
	 * @since 5.9.8 Add new parameter called device type to define current workplace. Accept
	 *              'normal' or 'sticky'. See $this->get_column_src().
	 *
	 * @see get_column_src()
	 *
	 * @param array  $row {
	 *     The data to transform into a single row of columns in the front-end.
	 *
	 *     @type string $type Type of element. Value of 'Row'.
	 *     @type string $caption Caption of element. Value of 'Row'.
	 *     @type string $category Category of element. Value of 'Row'.
	 *     @type string $id Unique ID for this element.
	 *     @type array $columns Array of columns, each containing an array of its own elements.
	 * }
	 * @param string $row_index Numeric index for the row.
	 * @param string $fullwidth Type of the row container width.
	 * @param string $device_name Type of devices.
	 * @param string $device_type Workplace used.
	 * @return array {
	 *     @type string $markup Stringified HTML.
	 *     @type string $style Stringified CSS.
	 * }
	 */
	public function get_row_src( $row, $row_index, $fullwidth, $device_name, $device_type ) {
		$style = '';
		$markup = '';

		if ( ! is_array( $row ) ) {
			return compact( 'markup', 'style' );
		}

		$columns = array_safe_get( $row, 'columns', array(
			array(
				'width' => 12,
			),
		) );

		if ( empty( $columns ) || ! is_numeric( $row_index ) ) {
			return compact( 'markup', 'style' );
		}

		// Gather the column content.
		$markup_content = '';
		$style_content = '';

		$columns = $this->hb_customize->transforms->unwrap( $columns );
		if ( is_array( $columns ) && ! empty( $columns['value'] ) ) {
			$columns = $columns['value'];
		}

		foreach ( $columns as $column_index => $column_model ) {
			$column_width = array_safe_get( $column_model, 'width', 0 );
			// Sometimes, column width content 0. Should be hidden.
			if ( 0 === $column_width ) {
				continue;
			}
			$rendered = $this->get_column_src( $column_model, $row_index, $column_index, $device_name, $device_type );

			$markup_content .= $rendered['markup'];
			$style_content  .= $rendered['style'];
		}

		// Construct dynamic class name from element type.
		$for_class = sanitize_key( array_safe_get( $row, 'type' ) );
		$for_file  = sanitize_key( array_safe_get( $row, 'type' ) );

		$class_name = 'HB_Element_' . ucwords( $for_class );
		$class_file = HB_INCLUDES_DIR . '/elements/class-hb-element-' . strtolower( $for_file ) . '.php';

		// Render row markup and style.
		$rendered = array();
		if ( ! class_exists( $class_name ) ) {
			if ( ! file_exists( $class_file ) ) {
				return compact( 'markup','style' );
			}

			include_once( $class_file );
		}

		$instance = new $class_name( $row, $row_index, $this->hb_customize );
		$rendered = $instance->get_src();

		// Set the markup and style values.
		$markup = sprintf(
			'<div id="%s" class="hb-row %s hb-equal-height-columns">
				<div class="%s">
				%s
				</div>
				<div class="clearfix"></div>
			</div>',
			array_safe_get( $row, 'id', '' ),
			esc_attr( 'hb-row-' . $row_index ),
			esc_attr( 'hb-container' . ( $fullwidth ? '-fluid' : '' ) ),
			$markup_content
		);
		$style  = $rendered['style'];

		// Then merge with current content and style of columns.
		$style .= $style_content;

		return compact( 'markup', 'style' );
	}

	/**
	 * Output the header builder front-end set for a specific column.
	 *
	 * @since 5.9.0
	 * @since 5.9.3 Build inline container for make inline and alignment property.
	 * @since 5.9.4 Add $hb_customize property on column constructor.
	 * @since 5.9.5 Add new parameter to get_column_src() function, add class prefix, escape grid
	 *              container. Remove unused property on column element declaration. Add device name to
	 *              element details.
	 * @since 5.9.6 Fetch cssDisplay and alignment to get correct value.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
	 * @since 5.9.8 Add new parameter called device type to define current workplace. Accept
	 *              'normal' or 'sticky'.
	 *
	 * @see get_element_src()
	 *
	 * @param array  $column {
	 *     The data to transform into a single column in the front-end.
	 *
	 *     @type string $type Type of element. Value of 'Row'.
	 * }
	 * @param string $row_index    Numeric index for the row.
	 * @param string $column_index Numeric index for the column.
	 * @param string $device_name  Type of devices.
	 * @param string $device_type  Workplace used.
	 * @return array {
	 *     @type string $markup Stringified HTML.
	 *     @type string $style Stringified CSS.
	 * }
	 */
	public function get_column_src( $column, $row_index, $column_index, $device_name = 'desktop', $device_type = 'normal' ) {
		$markup = '';
		$style = '';

		if ( ! is_array( $column ) ) {
			return compact( 'markup', 'style' );
		}

		$elements = array_safe_get( $column, 'elements', array() );

		if ( ! is_numeric( $row_index ) || ! is_numeric( $column_index ) ) {
			return compact( 'markup', 'style' );
		}

		// Variables declaration for inline container.
		$inline_container = false;
		$column_content = '';
		$inline_element = array(
			'left' => '',
			'center' => '',
			'right' => '',
		);
		$count_elements = count( $elements );

		foreach ( $elements as $element_index => $element_model ) {
			// Add device type (workplace) and name.
			$element_model['device'] = $device_name;
			$element_model['workplace'] = $device_type;

			// Reduce element numbers on each iteration.
			--$count_elements;
			$rendered = $this->get_element_src( $element_model, $row_index, $column_index, $element_index );

			$style .= $rendered['style'];

			// Default element display for empty rendered markup is inline.
			$element_display = 'inline';

			// MANDATORY: Check rendered markup is not empty.
			if ( '' !== $rendered['markup'] ) {
				// MANDATORY: Check display is exist or not.
				$element_display_raw = ! empty( $element_model['options']['cssDisplay'] ) ? $element_model['options']['cssDisplay'] : 'block';
				$element_display = $element_display_raw;
				if ( is_array( $element_display_raw ) ) {
					$element_display = array_safe_get( $element_display_raw, 'value', 'block' );
				}
			}

			// MANDATORY: If display is inline.
			if ( 'inline' === $element_display ) {
				$element_align_raw = ! empty( $element_model['options']['alignment'] ) ? $element_model['options']['alignment'] : array();
				$element_align = array_safe_get( $element_align_raw, 'value', 'left' );
				$element_align = ( 'initial' === $element_align ) ? 'left' : $element_align;

				// Save element with inline to $inline_element base on alignment.
				$inline_element[ $element_align ] .= $rendered['markup'];

				// Clear recent markup.
				$rendered['markup'] = '';
				$inline_container = true;
			}

			// MANDATORY: If inline container exist, place all the elements, and close container.
			if ( true === $inline_container && ( 'block' === $element_display || $count_elements <= 0 ) ) {
				// Inline container is exist, place all the elements, and close container.
				$column_content .= $this->set_inline_container( $inline_element );

				// Close container and set inline_container is false (closed).
				$inline_container = false;
				$inline_element   = array(
					'left' => '',
					'center' => '',
					'right' => '',
				);
			}

			$column_content .= $rendered['markup'];
		}// End foreach().

		// Check vertical alignment.
		$vertical_align = ( ! empty( $column['options']['verticalAlignment'] ) ) ? $column['options']['verticalAlignment'] : 'top';
		$vertical_align = $this->hb_customize->transforms->unwrap( $vertical_align );

		// Devices class name prefix.
		$prefix = array(
			'mobile' => 'xs',
			'tablet' => 'sm',
			'desktop' => 'md',
		);

		$prefix_class = ( ! empty( $prefix[ $device_name ] ) ) ? $prefix[ $device_name ] : 'md';

		$markup = sprintf( '
			<div class="hb-col-%s hb-col-align__%s" id="%s">
				<div class="hb-col-container">%s</div>
			</div>',
			esc_attr( $prefix_class . '-' . $column['width'] ),
			esc_attr( $vertical_align ),
			esc_attr( $column['id'] ),
			$column_content
		);

		$markup_content = '';
		$style_content = '';
		// Construct dynamic class name from element type.
		$for_class = sanitize_key( array_safe_get( $column, 'category' ) );
		$for_file  = sanitize_key( array_safe_get( $column, 'category' ) );

		$class_name = 'HB_Element_' . ucwords( $for_class );
		$class_file = HB_INCLUDES_DIR . '/elements/class-hb-element-' . strtolower( $for_file ) . '.php';

		// Render row markup and style.
		$rendered = array();
		if ( ! class_exists( $class_name ) ) {
			if ( ! file_exists( $class_file ) ) {
				return compact( 'markup','style' );
			}

			include_once( $class_file );
		}

		$instance = new $class_name( $column, $column_index, $this->hb_customize );
		$rendered = $instance->get_src();
		$style_content  .= $rendered['style'];

		// Then merge with current content and style of columns.
		$style .= $style_content;

		return compact( 'markup', 'style' );
	}

	/**
	 * Output the header builder front-end set for a specific element type.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Add $hb_customize property on elements constructor.
	 * @since 5.9.6 Add check_element_visibility() to ensure the elements will be displayed on correct
	 *              devices only.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
	 *
	 * @param array  $element {
	 *     The data to transform into a single column in the front-end.
	 *
	 *     @type string $type Type of element. Value of 'Row'.
	 *
	 * }
	 * @param string $row_index     Nth row to render (0 indexed).
	 * @param string $column_index  Nth column to render (0 indexed).
	 * @param string $element_index Nth column to render (0 indexed).
	 * @return array {
	 *     @type string $markup Stringified HTML.
	 *     @type string $style Stringified CSS.
	 * }
	 */
	public function get_element_src( $element, $row_index, $column_index, $element_index ) {
		$style = '';
		$markup = '';

		if ( ! is_array( $element ) ) {
			return compact( 'markup', 'style' );
		}

		// Check element visibility.
		$visibility = $this->check_element_visibility( $element );
		if ( false === $visibility ) {
			return compact( 'markup', 'style' );
		}

		if ( ! isset( $element['type'] ) ||
			! is_string( $element['type'] ) ||
			! is_numeric( $row_index ) ||
			! is_numeric( $column_index ) ||
			! is_numeric( $element_index ) ) {
			return compact( 'markup', 'style' );
		}

		// Construct dynamic class name from element type.
		$for_class = str_replace( '-', '_', sanitize_key( $element['type'] ) );
		$for_file = str_replace( '_', '-', sanitize_key( $element['type'] ) );

		$class_name = 'HB_Element_' . ucwords( $for_class, '_' );
		$class_file = HB_INCLUDES_DIR . '/elements/class-hb-element-' . strtolower( $for_file ) . '.php';

		if ( ! class_exists( $class_name ) ) {
			if ( ! file_exists( $class_file ) ) {
				return compact( 'markup','style' );
			}

			include_once( $class_file );
		}

		$element_instance = new $class_name( $element, $row_index, $column_index, $element_index, $this->hb_customize );

		return $element_instance->get_src();
	}

	/**
	 * Set inline container.
	 *
	 * @since 5.9.3
	 * @since 5.9.4 Check if the center container is not empty but both of the side are empty.
	 *
	 * @param array $inline_element Inline content.
	 */
	public function set_inline_container( $inline_element ) {
		// Default container.
		$left_container = '<div class="hb-inline-container__left">' . $inline_element['left'] . '</div>';
		$right_container = '<div class="hb-inline-container__right">' . $inline_element['right'] . '</div>';
		$center_container = '<div class="hb-inline-container__center">' . $inline_element['center'] . '</div>';

		// Remove center if it's empty. Also check both of left and right side.
		if ( empty( $inline_element['center'] ) ) {
			$center_container = '';

			if ( empty( $inline_element['left'] ) ) {
				$left_container = '';
			}

			if ( empty( $inline_element['right'] ) ) {
				$right_container = '';
			}
		}

		// Clear left and right when both of them are empty and center is not empty.
		if ( empty( $inline_element['left'] ) && empty( $inline_element['right'] ) ) {
			$left_container = '';
			$right_container = '';
		}

		$column_content = sprintf( '
			<div class="hb-inline-container">%s %s %s</div>',
			$left_container,
			$center_container,
			$right_container
		);

		return $column_content;
	}

	/**
	 * Check element visibility options.
	 *
	 * @since 5.9.6
	 *
	 * @param  array $element Element details or model.
	 * @return boolean        The status of current element visibility.
	 */
	public function check_element_visibility( $element ) {
		// Bail if no device information is present.
		$device = array_safe_get( $element, 'device', false );
		if ( ! $device ) {
			return false;
		}

		// Bail if the element does not have options to begin with.
		$options = array_safe_get( $element, 'options', false );
		if ( ! $options ) {
			return false;
		}

		// If an element has no visibility override, then it is always visible.
		$visibility = array_safe_get( $options, 'visibility', false );
		if ( ! $options ) {
			return true;
		}

		// Remove our specificity wrappers.
		$visibility = $this->hb_customize->transforms->unwrap( $visibility );

		if ( ! is_array( $visibility ) ) {
			return true;
		}

		// Check if element is supposed to be visible on device. Otherwise,
		// if device not present in visibility, assume it is not intended to
		// be overwritten by the visibility field, so return true.
		return (bool) array_safe_get( $visibility, $device, true );
	}

	/**
	 * Get header type class name based on the options. (Sticky or Fixed/Overlapping)
	 *
	 * @since 5.9.7
	 *
	 * @param  string $device_name Current device name.
	 * @param  string $markup      Device markup content.
	 * @param  string $data_type   Current data type for device, normal or sticky.
	 * @return string              Header type class name.
	 */
	private function get_header_type_class( $device_name, $markup, $data_type ) {
		$class_name = '';

		// Device category, only Laptop and Mobile.
		$device_category = array(
			'desktop' => 'laptop',
			'tablet' => 'mobile',
			'mobile' => 'mobile',
		);

		// Parameter data check.
		if ( ! is_string( $data_type ) ) {
			$data_type = '';
		}

		// Get overlapping status.
		$overlapping_status = $this->get_header_option( 'overlappingContent', false );

		// Get sticky status.
		$sticky_status = $this->get_header_option( 'stickyHeader', false );

		// Get fixed status. Only active if sticky is disabled.
		$fixed_status = false;
		if ( isset( $device_category[ $device_name ] ) && ! $sticky_status ) {
			$fixed_status = $this->get_header_option( $device_category[ $device_name ], false );
		}

		// 1. Overlapping class.
		if ( $overlapping_status && 'normal' === $data_type ) {
			$class_name .= 'hb-overlap ';
		}

		// 2. Sticky class.
		if ( $sticky_status && 'sticky' === $data_type ) {
			$class_name .= 'hb-sticky ';
			$sticky_effect = $this->get_header_option( 'stickyHeaderBehaviour', '' );
			if ( ! empty( $sticky_effect ) ) {
				$class_name .= 'hb-sticky--' . $sticky_effect . ' ';
			}
		}

		// 3. Fixed class.
		if ( $fixed_status ) {
			$class_name .= 'hb-fixed ';
			// Add class if is fixed and the content is not empty.
			if ( ! empty( $markup ) ) {
				$class_name .= 'hb-fixed--filled ';
			}
		}

		return $class_name;
	}

	/**
	 * Get header type attribute key and values name based on the options. (Sticky)
	 *
	 * @since 5.9.7
	 *
	 * @param  string $device_name Current device name.
	 * @param  string $data_type   Current data type for device, normal or sticky.
	 * @return string              Header type class name.
	 */
	private function get_header_type_attr( $device_name, $data_type ) {
		$attr = '';

		// Skip set header attribute here.
		$sticky_status = $this->get_header_option( 'stickyHeader', false );
		if ( 'sticky' !== $data_type || false === $sticky_status ) {
			return $attr;
		}

		// Get data offset.
		$sticky_offset = $this->get_header_option( 'stickyHeaderOffset', 0 );

		// Get data top.
		$sticky_top = 0;
		if ( is_admin_bar_showing() ) {
			$sticky_top = ( 'mobile' !== $device_name ) ? 32 : 46;
		}

		// Get data effect.
		$sticky_effect = $this->get_header_option( 'stickyHeaderBehaviour', '' );

		$attr = sprintf(
			'data-device="%s" data-offset="%s" data-top="%s" data-effect="%s"',
			esc_attr( $device_name ),
			esc_attr( $sticky_offset ),
			esc_attr( $sticky_top ),
			esc_attr( $sticky_effect )
		);

		return $attr;
	}

	/**
	 * Get HB global options value.
	 *
	 * @since 5.9.7
	 *
	 * @param  string $key     Option key that will be searched.
	 * @param  string $default Default option value if the option is not exist or empty.
	 * @return mixed           The value of current option. No empty value return, except it's
	 *                         the default value.
	 */
	private function get_header_option( $key, $default ) {
		$options = array_safe_get( $this->model, 'options', array() );

		if ( ! is_array( $options ) ) {
			return $default;
		}

		if ( ! isset( $options[ $key ] ) ) {
			return $default;
		}

		if ( empty( $options[ $key ] ) ) {
			return $default;
		}

		return $options[ $key ];
	}

	/**
	 * Check if the device should be rendered or not based on the list.
	 *
	 * @since 5.9.7
	 *
	 * @param  string $device_type Device type that will be checked.
	 * @return boolean             Render device status.
	 */
	private function is_render_device( $device_type ) {
		$status = true;

		// Don't render sticky Header if it's disabled.
		$sticky_status = $this->get_header_option( 'stickyHeader', false );
		if ( 'sticky' === $device_type && false === $sticky_status ) {
			return false;
		}

		return $status;
	}

	/**
	 * Get header option based on Global or Overriding header.
	 *
	 * @since 5.9.7
	 *
	 * @return array Header option data.
	 */
	private function get_header_data() {
		$header_id = null;
		$header_data = null;

		// A.1. For preview header.
		$hb_get = get_query_var( 'header-builder', 'nothing' );
		$hb_id_get = get_query_var( 'header-builder-id', 'nothing' );
		if ( 'preview' === $hb_get && 0 < $hb_id_get ) {
			$header_id = $hb_id_get;
		}

		// A.2. User current override header ID from current post.
		$post_id = global_get_post_id();
		$post_id_status = false;
		if ( $post_id && empty( $header_id ) ) {
			// Get correct header ID.
			$header_id = get_post_meta( $post_id, '_hb_override_template_id', true );
			$post_id_status = get_post_status( $header_id );
		}

		// A.3. Use global header if there is no overriding on header.
		if ( empty( $header_id ) && 'publish' !== $post_id_status ) {
			$header_id = get_option( 'mkhb_global_header', null );
		}

		// A.4. Use the latest post if there is no global header.
		if ( empty( $header_id ) ) {
			$latest_param = array(
				'post_type' => 'mkhb_header',
				'post_status' => 'publish',
				'numberposts' => 1,
				'order' => 'DESC',
				'orderby' => 'ID',
			);

			$latest_post = wp_get_recent_posts( $latest_param );

			// If the latest header is not empty, get the post ID.
			if ( ! empty( $latest_post[0] ) ) {
				$header_id = $latest_post[0]['ID'];
			}
		}

		// B. Meta All - Get post metas to get '_mkhb_content_all' data.
		$meta_all = get_post_meta( $header_id, '_mkhb_content_all', true );
		if ( ! empty( $meta_all ) && hb_is_json( $meta_all ) ) {
			$header_data = $meta_all;
		}

		return $header_data;
	}
}
