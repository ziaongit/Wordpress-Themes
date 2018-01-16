<?php
/**
 * Header Builder: HB_Element_Social_Media class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Social Media' element to the front end.
 *
 * @since 5.9.0
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance, implement some new properties,
 *              use $hb_customize property to load HB_Customize instance.
 * @since 5.9.8 Fix some visual issues, such as: Missing icon, array formatting errors, enable to create
 *              box with circle form.
 *
 * @see HB_Element
 */
class HB_Element_Social_Media extends HB_Element {
	/**
	 * Generate markup and style for the 'Social Media' element.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Add some new properties, add $hb_customize property on constructor.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
	 * @since 5.9.8 Update cssDisplay default value to 'block'.
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
	 *           @type string $icons     Social networks list.
	 *           @type string $target         Target URL. Default to '_self'.
	 *           @type string $alignment      Text element horizontal aligment. Default to 'left'.
	 *           @type string $cssDisplay     Text element vertical aligment. Default to 'top'.
	 *           @type string $iconSize       Icon size. Default to 16.
	 *           @type string $iconColor      Icon color.
	 *           @type string $iconHoverColor Icon hover color.
	 *           @type string $border         Icon border color.
	 *           @type string $iconHoverBorderColor Icon hover border color.
	 *           @type string $iconBackgroundColor  Icon background color.
	 *           @type string $spaceBetweenIcons    Space between icons. Default to 10.
	 *           @type string $iconCornerRadius     Icon background border radius.
	 *           @type string $iconHoverBackgroundColor Icon background color.
	 *           @type string $padding        The element padding layout.
	 *           @type string $margin         The element margin layout.
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );
		$this->icons = $this->get_option( 'icons', array() );
		$this->target = $this->get_option( 'target', array(
			'value' => '_self',
		) );
		$this->align = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );
		$this->size = $this->get_option( 'iconSize', 16 );
		$this->color = $this->get_option( 'iconColor', array(
			'r' => 238,
			'g' => 238,
			'b' => 238,
			'a' => 1,
		) );
		$this->box_bg_color = $this->get_option( 'iconBackgroundColor', array(
			'r' => 238,
			'g' => 238,
			'b' => 238,
			'a' => 1,
		) );
		$this->space = $this->get_option( 'spaceBetweenIcons', 10 );
		$this->box_radius = $this->get_option( 'iconCornerRadius', 2 );
		$this->box_border = $this->get_option( 'border', array(
			'active' => 'top',
			'top' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
			'right' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
			'bottom' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
			'left' => array(
				'width' => 0,
				'color' => array(
					'r' => 255,
					'g' => 255,
					'b' => 255,
					'a' => 1,
				),
			),
		) );
		$this->hover_color = $this->get_option( 'iconHoverColor', array(
			'r' => 238,
			'g' => 238,
			'b' => 238,
			'a' => 1,
		) );
		$this->box_hover_bg_color = $this->get_option( 'iconHoverBackgroundColor', array(
			'r' => 153,
			'g' => 153,
			'b' => 153,
			'a' => 1,
		) );
		$this->box_hover_border_col = $this->get_option( 'iconHoverBorderColor', array(
			'r' => 255,
			'g' => 255,
			'b' => 255,
			'a' => 0,
		) );
		$this->padding = $this->get_option( 'padding', array(
			'top' => 5,
			'right' => 5,
			'bottom' => 5,
			'left' => 5,
		) );
		$this->margin = $this->get_option( 'margin', array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
		) );

		// Enqueue the search style and HB script.
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue image style and HB script.
	 *
	 * @since 5.9.4
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-social-media', HB_ASSETS_URI . 'css/hb-icon.css', array(), '5.9.8' );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.4 Implement some new properties.
	 * @since 5.9.8 Refactor the HTML structures and all variables name.
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		$markup = sprintf(
			'<div id="%s" class="hb-social-media-el"></div>',
			esc_attr( $this->id )
		);

		// Social Media layout.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		// Social Media display.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		$style = "
			#{$this->id} {
				text-align: {$this->align};
				margin: {$margin};
				{$inline}
			}
		";

		// Render icons.
		$icons = $this->render_icons( $this->icons, $this->size );

		// Render only the container, if the icons are empty.
		if ( empty( $icons ) ) {
			return compact( 'markup', 'style' );
		}

		// Social Media icon box layout.
		$borders = $this->box_border;
		$border_offset['height'] = $borders['top']['width'] + $borders['bottom']['width'];
		$border_offset['width']  = $borders['left']['width'] + $borders['right']['width'];
		$box_height = $this->size + $border_offset['height'] + $this->padding['top'] + $this->padding['bottom'];
		$box_width = $this->size + $border_offset['width'] + $this->padding['left'] + $this->padding['right'];

		// Social Media icon colors.
		$icon_color = $this->hb_customize->css->rgba( $this->color );
		$icon_hover_color = $this->hb_customize->css->rgba( $this->hover_color );
		$box_bg_color = $this->hb_customize->css->rgba( $this->box_bg_color );
		$box_hover_bg_color = $this->hb_customize->css->rgba( $this->box_hover_bg_color );
		$box_border = $this->hb_customize->css->border( $this->box_border );
		$box_hover_border_col = $this->hb_customize->css->rgba( $this->box_hover_border_col );

		// Social media margin and padding.
		$space = 'margin-right: ' . $this->space . 'px;';

		$markup = sprintf(
			'<div id="%s" class="hb-social-media-el">%s</div>',
			esc_attr( $this->id ),
			$icons
		);

		$style .= "
			#{$this->id} .hb-icon-el__link {
				color: {$icon_color};
				height: {$box_height}px;
				width: {$box_width}px;
				background: {$box_bg_color};
				padding: {$padding};
				border-radius: {$this->box_radius}px;
				{$box_border};
				{$space}
			}
			#{$this->id} .hb-icon-el {
				display: inline-block;
			}
			#{$this->id} .hb-icon-el:last-child .hb-icon-el__link {
				margin-right: 0px;
			}
			#{$this->id} .hb-icon-el__link--hoverable:hover {
				color: {$icon_hover_color};
				background: {$box_hover_bg_color};
				border-color: {$box_hover_border_col};
			}
		";

		return compact( 'markup', 'style' );
	}

	/**
	 * Render list of elements including target, icons, and the URL.
	 *
	 * @since 5.9.4
	 * @since 5.9.8 Change the access to private, add parameters to pass icon_names and icon_size.
	 *
	 * @param string $icon_names Icon names in array.
	 * @param string $icon_size  Icon size.
	 * @return string            Generated icons in HTML format.
	 */
	private function render_icons( $icon_names, $icon_size ) {

		// Render all social media icons.
		$icon_markup = '';
		if ( ! empty( $icon_names ) ) {
			/*
			 * Mk_SVG_Icons is a class from Jupiter package. HB - Social Media will use it to load the SVG
			 * icon based on the class name. Make sure this class is exist.
			 */
			if ( ! class_exists( 'Mk_SVG_Icons' ) ) {
				require_once THEME_HELPERS . '/svg-icons.php';
			}

			$mk_svg = new Mk_SVG_Icons();

			foreach ( $this->icons as $property ) {
				$icon = '';

				/*
				 * In the old data structures, the $property only have single value with string contain the
				 * class name. Right now, it's an array with 'link' and 'value' keys inside. So, we need to
				 * check it's exist and empty or not because $prop_link and $prop_value are required for the
				 * next step.
				 */
				$prop_value = ( ! empty( $property['value'] ) ) ? $property['value'] : '';

				// The correct class name is required. We can't call empty SVG icon here.
				$class_name = $this->get_icon_class( $prop_value );
				$icon = $mk_svg::get_svg_icon_by_class_name( false, $class_name, (int) $icon_size );

				// $icon should not be empty. Don't render the icon if it's empty.
				if ( empty( $icon ) ) {
					continue;
				}

				// Icon anchor URL attribute.
				$prop_link = '';
				$prop_target = '';
				$prop_hover_class = '';
				if ( ! empty( $property['link'] ) ) {
					$prop_link = 'href="' . esc_url( $property['link'] ) . '"';
					$prop_target = ( ! empty( $this->target['value'] ) ) ? 'target="' . esc_attr( $this->target['value'] ) . '"' : '';
					$prop_hover_class = 'hb-icon-el__link--hoverable';
				}

				$icon_markup .= sprintf(
					'<div class="hb-icon-el">
						<a class="hb-icon-el__link %s" %s %s>
							%s
						</a>
					</div>',
					esc_attr( $prop_hover_class ),
					$prop_target,
					$prop_link,
					$icon
				);
			} // End foreach().
		} // End if().

		return $icon_markup;
	}

	/**
	 * Return icon class name.
	 *
	 * @since 5.9.4
	 * @since 5.9.8 Change the access to private, add conditional logic to prevent empty key.
	 *
	 * @param string $key Icon name.
	 * @return string Icon class name.
	 */
	private function get_icon_class( $key ) {
		// If key is empty, return ''.
		if ( empty( $key ) ) {
			return '';
		}

		$icons = array(
			'px' => 'mk-jupiter-icon-px',
			'aim' => 'mk-jupiter-icon-aim',
			'amazon' => 'mk-jupiter-icon-amazon',
			'apple' => 'mk-icon-apple',
			'bebo' => 'mk-jupiter-icon-bebo',
			'behance' => 'mk-icon-behance',
			'blogger' => 'mk-moon-blogger',
			'delicious' => 'mk-icon-delicious',
			'deviantart' => 'mk-icon-deviantart',
			'digg' => 'mk-icon-digg',
			'dribbble' => 'mk-icon-dribbble',
			'dropbox' => 'mk-icon-dropbox',
			'envato' => 'mk-jupiter-icon-envato',
			'facebook' => 'mk-icon-facebook',
			'flickr' => 'mk-icon-flickr',
			'github' => 'mk-icon-github',
			'google' => 'mk-icon-google',
			'googleplus' => 'mk-icon-google-plus',
			'lastfm' => 'mk-icon-lastfm',
			'linkedin' => 'mk-icon-linkedin',
			'instagram' => 'mk-icon-instagram',
			'myspace' => 'mk-jupiter-icon-myspace',
			'path' => 'mk-icon-meanpath',
			'pinterest' => 'mk-icon-pinterest',
			'reddit' => 'mk-icon-reddit',
			'rss' => 'mk-icon-rss',
			'skype' => 'mk-icon-skype',
			'stumbleupon' => 'mk-icon-stumbleupon',
			'tumblr' => 'mk-icon-tumblr',
			'twitter' => 'mk-icon-twitter',
			'vimeo' => 'mk-moon-vimeo',
			'wordpress' => 'mk-icon-wordpress',
			'yahoo' => 'mk-icon-yahoo',
			'yelp' => 'mk-icon-yelp',
			'youtube' => 'mk-icon-youtube',
			'xing' => 'mk-icon-xing',
			'imdb' => 'mk-jupiter-icon-imdb',
			'qzone' => 'mk-jupiter-icon-qzone',
			'renren' => 'mk-icon-renren',
			'vk' => 'mk-icon-vk',
			'wechat' => 'mk-icon-wechat',
			'weibo' => 'mk-icon-weibo',
			'whatsapp' => 'mk-jupiter-icon-whatsapp',
			'soundcloud' => 'mk-icon-soundcloud',
			'creativemarket' => 'mk-jupiter-icon-creative-market',
			'ebay' => 'mk-jupiter-icon-ebay',
			'etsy' => 'mk-jupiter-icon-etsy',
			'slack' => 'mk-jupiter-icon-slack',
			'snapchat' => 'mk-jupiter-icon-snapchat',
			'spotify' => 'mk-jupiter-icon-spotify',
			'strava' => 'mk-jupiter-icon-strava',
			'telegram' => 'mk-jupiter-icon-telegram',
			'tripadvisor' => 'mk-jupiter-icon-tripadvisor',
			'zillow' => 'mk-jupiter-icon-zillow',
			'zomato' => 'mk-jupiter-icon-zomato',
		);

		// Make sure the $key is exist in icon class name list. The default is empty string.
		$icon_class_name = '';
		if ( array_key_exists( $key, $icons ) ) {
			$icon_class_name = $icons[ $key ];
		}

		return $icon_class_name;
	}
}
