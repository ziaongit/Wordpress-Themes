<?php
/**
 * Header Builder: HB_Customize class.
 *
 * @package Header_Builder
 * @since 5.9.4
 */

/**
 * Return all HB_ customize class instances as object.
 *
 * @since 5.9.4
 */
class HB_Customize {

	/**
	 * HB_Attributes instance.
	 *
	 * @since 5.9.4
	 * @var object $attributes HB_Attributes object instance.
	 */
	public $attributes;

	/**
	 * HB_CSS_Layout instance.
	 *
	 * @since 5.9.4
	 * @var object $layout HB_CSS_Layout object instance.
	 */
	public $layout;

	/**
	 * HB_CSS instance.
	 *
	 * @since 5.9.4
	 * @var object $css HB_CSS object instance.
	 */
	public $css;

	/**
	 * HB_Data_Transforms instance.
	 *
	 * @since 5.9.4
	 * @var object $transforms HB_Data_Transforms object instance.
	 */
	public $transforms;

	/**
	 * HB_Tags instance.
	 *
	 * @since 5.9.4
	 * @var object $tags HB_Tags object instance.
	 */
	public $tags;

	/**
	 * Create instance for each HB_ customize class.
	 *
	 * @since 5.9.4
	 */
	public function __construct() {
		$this->attributes = new HB_Attributes();
		$this->layout = new HB_CSS_Layout();
		$this->css = new HB_CSS();
		$this->transforms = new HB_Data_Transforms();
		$this->tags = new HB_Tags();
	}

}
