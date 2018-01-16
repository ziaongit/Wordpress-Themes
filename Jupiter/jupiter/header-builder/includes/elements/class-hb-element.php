<?php
/**
 * Header Builder: HB_Element class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.4 Add a new construct parameter to load HB customize class instances, add $hb_customize
 *              as new parameter of element construct to load HB_Customize instance.
 */
class HB_Element {
	/**
	 * Array of element properties.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var array $options Array of element CSS properties and other settings.
	 */
	protected $options;

	/**
	 * Index of row containing this element in Header Builder.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var int $row_index Any whole number.
	 */
	protected $row_index;

	/**
	 * Index of column containing this element in Header Builder.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var int $column_index Any whole number.
	 */
	protected $column_index;

	/**
	 * Index of element within it's containing column in Header Builder.
	 *
	 * @since 5.9.0
	 * @access protected
	 * @var int $element_index Any whole number.
	 */
	protected $element_index;

	/**
	 * HB_Customize class instances in Header Builder.
	 *
	 * @since 5.9.4
	 * @access protected
	 * @var object $hb_customize Object list of HB_Customize instance.
	 */
	protected $hb_customize;

	/**
	 * Constructor.
	 *
	 * Sets options, all indices and CSS class name for all elements.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Add $hb_customize to load HB customize class instances.
	 * @since 5.9.5 Add public property that store device name.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
	 *
	 * @param array  $element {
	 *       Array data must at least contain element "type", list of CSS properies, etc.
	 *
	 *       @type string $type    Type of element.
	 *       @type array $options  Array of element CSS properties and other settings.
	 * }
	 * @param int    $row_index     0-indexed nth row.
	 * @param int    $column_index  0-indexed position of element inside row.
	 * @param int    $element_index 0-indexed position of element inside column.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		$options = array_safe_get( $element, 'options', array() );

		$this->options = $options;
		$this->row_index = $row_index;
		$this->column_index = $column_index;
		$this->element_index = $element_index;
		$this->type = str_replace( '_', '-', sanitize_key( array_safe_get( $element, 'type', 'element' ) ) );
		$this->class_name = $this->generate_indexed_class_name( $this->type );
		$this->id = array_safe_get( $element, 'id', '' );
		$this->device = array_safe_get( $element, 'device', 'desktop' );
		$this->workplace = array_safe_get( $element, 'workplace', 'normal' );
		$this->hb_customize = $hb_customize;
	}

	/**
	 * Safely get value from $option property.
	 *
	 * @since 5.9.0
	 * @since 5.9.6 Added data transform to make the front end compatible
	 *              with all the data structure changes needed for the cascade-
	 *              specificty problem. Add value checking because in this case
	 *              array_safe_get always return value as an array even the
	 *              actual value is empty/null and we can't use the default value.
	 *
	 * @param  string $key     Option to search.
	 * @param  string $default Default value if key is not found. Defaults to empty string.
	 * @return mixed The element property stored in $options.
	 */
	public function get_option( $key, $default = '' ) {
		$option = $this->hb_customize->transforms->unwrap( array_safe_get( $this->options, (string) $key, $default ) );

		return $option;
	}

	/**
	 * Create the element class using element "type" and element indices.
	 *
	 * @since 5.9.0
	 *
	 * @param string $base The base name to suffix with element indices. Defualts to "element".
	 */
	protected function generate_indexed_class_name( $base = 'element' ) {
		if ( ! is_string( $base ) ) {
			$base = 'element';
		}

		return sprintf( "$base-%s-%s-%s", $this->row_index, $this->column_index, $this->element_index );
	}
}
