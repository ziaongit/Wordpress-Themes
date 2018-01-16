<?php
/**
 * Header Builder: HB_Element_Navigation class.
 *
 * All PHPMD warnings are suppressed because some of these codes only temporary solution. We have
 * separated branch to fix all these issues. Can't merge it yet because we have so many changes
 * and potentially make some conflicts.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.0
 */

/**
 * Main class used for rendering 'Navigation' element to the front end. Right now we have 2
 * different style for the navigation, Text and Burger style.
 *
 * @since 5.9.0
 * @since 5.9.1 Add new default value and create basic structure.
 * @since 5.9.2 Refactor full basic structure and enqueue assets.
 * @since 5.9.3 Add alignment and make inline properties.
 * @since 5.9.4 Simplify enqueue font family by using $hb_tags->enqueue_fonts() function, use
 *              $hb_customize property to load HB_Customize instance.
 * @since 5.9.5 Add new properties and implement burger menu style on navigation.
 *
 * @see HB_Element
 *
 * @SuppressWarnings(PHPMD)
 */
class HB_Element_Navigation extends HB_Element {

	/**
	 * Z-index of menus.
	 *
	 * @var integer
	 */
	static $tid = 0;

	/**
	 * Generate markup and style for the 'Navigation' element.
	 *
	 * NOTES:
	 * - All public variables started with $this->text_ only apply for Text navigation style.
	 * - All public variables started with $this->burger_ only apply for Burger navigation style.
	 * - All public variables started with $this->sub_ only apply for Sub Menu items.
	 * - Rest of the variables apply for Menu items.
	 *
	 * @since 5.9.0
	 * @since 5.9.1 Add new default values.
	 * @since 5.9.3 Update the default values.
	 * @since 5.9.4 Add $hb_customize property on constructor.
	 * @since 5.9.5 Declare public variables of new options by calling specific function.
	 * @since 5.9.7 Remove array type of the parameter to avoid fatal error.
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
	 *           @type string $navStyle
	 *           @type string $menu
	 *           @type string $padding
	 *           @type string $margin
	 *           @type string $textFontFamily
	 *           @type string $textWeight
	 *           @type string $textSize
	 *           @type string $gutterSpace
	 *           @type string $textColor
	 *           @type string $textBackgroundColor
	 *           @type string $width
	 *           @type string $spacing
	 *           @type string $animation
	 *           @type string $thickness
	 *           @type string $boxRadius
	 *           @type string $barColor
	 *           @type string $boxColor
	 *           @type string $barColorHover
	 *           @type string $boxColorHover
	 *           @type string $boxBorder
	 *           @type string $textHoverColor
	 *           @type string $textHoverBackgroundColor
	 *           @type string $subMenuTextHoverColor
	 *           @type string $subMenuTextHoverBackgroundColor
	 *           @type string $subMenuTextWeight
	 *           @type string $subMenuTextSize
	 *           @type string $subMenuTextColor
	 *           @type string $subMenuTextBackgroundColor
	 *           @type string $subMenuTitleColor
	 *           @type string $subMenuBorderColor
	 *           @type string $border
	 *           @type string $textHoverBorder
	 *           @type string $alignment
	 *           @type string $cssDisplay
	 *           @type string $textCornerRadius
	 *           @type string $hoverStyle
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );
		self::$tid++;

		// Property.
		$this->nav_style = $this->get_option( 'navStyle', 'text' );
		$this->menu = $this->get_option( 'menu', 'navigation-preview' );
		$this->align = $this->get_option( 'alignment', 'left' );
		$this->inline = $this->get_option( 'cssDisplay', 'block' );
		$this->text_hover_style = $this->get_option( 'hoverStyle', 1 );

		// Check nav_style to declare only specific variables.
		if ( 'text' === $this->nav_style ) {
			$this->declare_text_variables();
		} elseif ( 'burger' === $this->nav_style ) {
			$this->declare_burger_variables();
		}

		// Style - Menu.
		$this->font_weight = $this->get_option( 'textWeight', 400 );
		$this->font_size = $this->get_option( 'textSize', 13 );
		$this->font_color = $this->get_option(
			'textColor', array(
				'r' => 34,
				'g' => 34,
				'b' => 34,
				'a' => 1,
			)
		);
		$this->bg_color = $this->get_option(
			'textBackgroundColor', array(
				'r' => 255,
				'g' => 255,
				'b' => 255,
				'a' => 0,
			)
		);
		$this->gutter_space = $this->get_option( 'gutterSpace', 0 );

		// Style - Menu Hover.
		$this->hover_font_color = $this->get_option(
			'textHoverColor', array(
				'r' => 68,
				'g' => 68,
				'b' => 68,
				'a' => 1,
			)
		);
		$this->hover_bg_color = $this->get_option(
			'textHoverBackgroundColor', array(
				'r' => 179,
				'g' => 229,
				'b' => 252,
				'a' => 1,
			)
		);

		// Style - Sub Menu.
		$this->sub_font_weight = $this->get_option( 'subMenuTextWeight', 400 );
		$this->sub_font_size = $this->get_option( 'subMenuTextSize', 12 );
		$this->sub_font_color = $this->get_option(
			'subMenuTextColor', array(
				'r' => 85,
				'g' => 85,
				'b' => 85,
				'a' => 1,
			)
		);
		$this->sub_bg_color = $this->get_option(
			'subMenuTextBackgroundColor', array(
				'r' => 255,
				'g' => 255,
				'b' => 255,
				'a' => 1,
			)
		);

		// Style - Sub Menu Hover.
		$this->sub_hover_font_color = $this->get_option(
			'subMenuTextHoverColor', array(
				'r' => 68,
				'g' => 68,
				'b' => 68,
				'a' => 1,
			)
		);
		$this->sub_hover_bg_color = $this->get_option(
			'subMenuTextHoverBackgroundColor', array(
				'r' => 179,
				'g' => 229,
				'b' => 252,
				'a' => 1,
			)
		);

		// Layout.
		$this->padding = $this->get_option(
			'padding', array(
				'top' => 10,
				'right' => 20,
				'bottom' => 10,
				'left' => 20,
			)
		);
		$this->margin  = $this->get_option(
			'margin', array(
				'top' => 0,
				'right' => 0,
				'bottom' => 0,
				'left' => 0,
			)
		);

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		add_filter( 'mk_google_fonts', array( $this, 'enqueue_fonts' ) );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.0
	 * @since 5.9.1 Create basic structure.
	 * @since 5.9.2 Refactor full structure.
	 * @since 5.9.3 Add alignment and make inline properties.
	 * @since 5.9.5 Separate default and custom style. Implement new options.
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		// Layout.
		$menu_padding = $this->hb_customize->layout->trbl( $this->padding );
		// Margin won't be longer used as the space between menu items, but layout for navigation container.
		$menu_margin  = $this->hb_customize->layout->trbl( $this->margin );

		// Style - Menu.
		$menu_text_weight = $this->font_weight;
		$menu_text_size   = $this->font_size;
		$menu_text_color  = $this->hb_customize->css->rgba( $this->font_color );
		$menu_text_bg = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( array( $this->bg_color ) ) );

		// Style - Menu Hover.
		$menu_text_hover_font_color = $this->hb_customize->css->rgba( $this->hover_font_color );
		$menu_text_hover_bg = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( array( $this->hover_bg_color ) ) );

		// Style - Sub Menu.
		$sub_menu_text_color  = $this->hb_customize->css->rgba( $this->sub_font_color );
		$sub_menu_text_weight = $this->sub_font_weight;
		$sub_menu_text_bg = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( array( $this->sub_bg_color ) ) );
		$sub_menu_text_size   = $this->sub_font_size;

		// Style - Sub Menu Hover Settings.
		$sub_menu_text_hover_color = $this->hb_customize->css->rgba( $this->sub_hover_font_color );
		$sub_menu_text_hover_bg = $this->hb_customize->css->background( $this->hb_customize->transforms->background_layers( array( $this->sub_hover_bg_color ) ) );

		// Set z-index position. Fix: Dropdown overlapping of multiple navigations.
		$z_index = 301 - self::$tid;

		// Set inline block.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		// 1. custom_style storage variable declaration.
		$custom_style = '';

		/*
		 * CUSTOM STYLE.
		 *
		 * Check nav_style type to load specific styles. In here:
		 * - Load specific style based on Text or Burger.
		 * - If Text, load specific style based on the Hover type. Pass some values to be used there.
		 */
		$text_hover_style = '';
		if ( 'text' === $this->nav_style ) {
			// 2.a.1 custom_style store style based on the Text nav type.
			$custom_style .= $this->get_style_text();

			// 2.a.2 custom_style store style based on the Hover type.
			$properties = array(
				'menu_margin' => $menu_margin,
				'menu_text_bg_color' => $menu_text_bg,
				'menu_text_hover_font_color' => $menu_text_hover_font_color,
				'menu_text_hover_bg_color' => $menu_text_hover_bg,
			);
			$custom_style .= $this->get_style_text_hover( $this->text_hover_style, $properties );

			// Properties.
			$text_hover_style = 'hb-menu-hover-style-' . $this->text_hover_style;
		}

		if ( 'burger' === $this->nav_style ) {
			// 2.b.1 custom_style store style based on the Burger nav type.
			$properties = array(
				'menu_padding' => $menu_padding,
				'menu_margin' => $menu_margin,
				'inline' => $inline,
			);
			$custom_style .= $this->get_style_burger( $properties );

			if ( 'desktop' !== $this->device ) {
				// 2.b.2 custom_style store style based on Responsive state only. Not all, some of it.
				$custom_style .= $this->get_style_responsive();
			}
		}

		// 3. custom_style store style based on the Hover type.
		$custom_style .= $this->get_style_to();

		// MARKUP.
		$markup = sprintf(
			'
			<div id="%s" class="hb-nav-container %s hb-menu-nav-style-%s">
				%s
			</div>',
			esc_attr( $this->id ),
			esc_attr( $text_hover_style ),
			esc_attr( $this->nav_style ),
			$this->get_navigation_body()
		);

		/**
		 * STYLE.
		 *
		 * @todo Set "Responsive Navigation - Devices" as global CSS.
		 */
		$style = "
			/* COMMON STYLES */
			#{$this->id}.hb-nav-container {
				margin: {$menu_margin};
				z-index: {$z_index};
				text-align: {$this->align};
				{$inline}
			}

			/* Main menu */
			#{$this->id} .hb-navigation-ul > li.menu-item > a.menu-item-link {
				color: {$menu_text_color};
				padding: {$menu_padding};
				font-size: {$menu_text_size}px;
				font-weight: {$menu_text_weight};
				margin-right: {$this->gutter_space}px;
			}
			#{$this->id} .hb-navigation-ul > li.menu-item:last-of-type > a.menu-item-link {
			    margin-right: 0;
			}

			/* Sub menu */
			#{$this->id} .hb-navigation ul.sub-menu a.menu-item-link {
				color: {$sub_menu_text_color};
				font-size: {$sub_menu_text_size}px;
				font-weight: {$sub_menu_text_weight};
			}
			#{$this->id} .hb-navigation li.hb-no-mega-menu ul.sub-menu {
				{$sub_menu_text_bg}
			}

			#{$this->id} .hb-navigation ul.sub-menu a.menu-item-link:hover,
			#{$this->id} .hb-navigation-ul ul.sub-menu li.current-menu-item > a.menu-item-link,
			#{$this->id} .hb-navigation-ul ul.sub-menu li.current-menu-parent > a.menu-item-link {
				{$sub_menu_text_hover_bg}
				color: {$sub_menu_text_hover_color};
			}

			/* Responsive Navigation - Common */
			#{$this->id}-wrap .hb-navigation-resp__ul > li > a {
				font-weight: {$menu_text_weight};
				font-size: {$menu_text_size}px;
				color: {$menu_text_color};
				{$menu_text_bg}
			}
			#{$this->id}-wrap .hb-navigation-resp__ul > li:hover > a {
				color: {$menu_text_hover_font_color};
				{$menu_text_hover_bg}
			}
			#{$this->id}-wrap .hb-navigation-resp__ul > li > ul {
				{$sub_menu_text_bg}
			}
			#{$this->id}-wrap .hb-navigation-resp__ul > li > ul li a {
				font-weight: {$sub_menu_text_weight};
				font-size: {$sub_menu_text_size}px;
				color: {$sub_menu_text_color};
			}
			#{$this->id}-wrap .hb-navigation-resp__ul > li > ul li:hover > a {
				color: {$sub_menu_text_hover_color};
				{$sub_menu_text_hover_bg}
			}
		";

		// 4. custom_style merge with default style.
		$style .= $custom_style;

		return compact( 'markup', 'style' );
	}

	/**
	 * Declare public variables for Text style.
	 *
	 * @since 5.9.5
	 */
	public function declare_text_variables() {
		// Style - Text Menu.
		$this->text_font_family = $this->get_option(
			'textFontFamily', array(
				'value' => 'Open+Sans',
				'type' => 'google',
				'label' => 'Open Sans',
			)
		);
		$this->text_corner_radius = $this->get_option( 'textCornerRadius', 6 );
		$this->text_border = $this->get_option(
			'border', array(
				'top' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
				'right' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
				'bottom' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
				'left' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
			)
		);

		// Style - Text Menu Hover.
		$this->text_hover_border = $this->get_option(
			'textHoverBorder', array(
				'top' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
				'right' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
				'bottom' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
				'left' => array(
					'width' => 2,
					'color' => array(
						'r' => 129,
						'g' => 212,
						'b' => 250,
						'a' => 1,
					),
				),
			)
		);

		// (Disabled) Style - Sub Menu (Mega Menu).
		$this->text_sub_bg_title_color = $this->get_option(
			'subMenuTitleColor', array(
				'r' => 255,
				'g' => 255,
				'b' => 255,
				'a' => 0,
			)
		);
		$this->text_sub_bg_border_color = $this->get_option(
			'subMenuBorderColor', array(
				'r' => 255,
				'g' => 255,
				'b' => 255,
				'a' => 0,
			)
		);
	}

	/**
	 * Declare public variables for Burger style.
	 *
	 * @since 5.9.5
	 */
	public function declare_burger_variables() {
		// Style - Burger Menu.
		$this->burger_width = $this->get_option( 'barWidth', 15 );
		$this->burger_thickness = $this->get_option( 'barThickness', 2 );
		$this->burger_spacing = $this->get_option( 'barSpacing', 4 );
		$this->burger_bar_color  = $this->get_option(
			'barColor',  array(
				'r' => 255,
				'g' => 255,
				'b' => 255,
				'a' => 1,
			)
		);
		$this->burger_box_color  = $this->get_option(
			'boxColor',  array(
				'r' => 0,
				'g' => 0,
				'b' => 0,
				'a' => 1,
			)
		);
		$this->burger_box_radius = $this->get_option( 'boxCornerRadius', 0 );
		$this->burger_box_border = $this->get_option(
			'boxBorder', array(
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
			)
		);
		$this->burger_hover_bar_color = $this->get_option(
			'barHoverColor',  array(
				'r' => 102,
				'g' => 102,
				'b' => 102,
				'a' => 1,
			)
		);
		$this->burger_hover_box_color = $this->get_option(
			'boxHoverColor',  array(
				'r' => 221,
				'g' => 221,
				'b' => 221,
				'a' => 1,
			)
		);
		$this->burger_animation = $this->get_option( 'animation', 'none' );
	}

	/**
	 * Get custom style for Text navigation style.
	 *
	 * @since 5.9.5
	 *
	 * @return string Custom style from Text navigation.
	 */
	public function get_style_text() {
		$style = '';

		// Style - Menu.
		$menu_text_font_family = '';
		if ( ! empty( $this->text_font_family['label'] ) ) {
			$menu_text_font_family = 'font-family: ' . $this->text_font_family['label'] . ';';
		}

		$style = "
			#{$this->id}.hb-menu-nav-style-text {
				{$menu_text_font_family}
			}
		";

		return $style;

	}

	/**
	 * Get custom style for Burger navigation style.
	 *
	 * @since 5.9.5
	 *
	 * @param  array $properties Pass arguments for navigation.
	 * @return string            Custom style from Burger navigation.
	 */
	public function get_style_burger( $properties = array() ) {
		// Burger Menu margin and padding.
		$padding = ( ! empty( $properties['menu_padding'] ) ) ? $properties['menu_padding'] : 'auto';
		$margin  = ( ! empty( $properties['menu_margin'] ) ) ? $properties['menu_margin'] : 'auto';

		// Burger Menu color.
		$bar_color = $this->hb_customize->css->rgba( $this->burger_bar_color );
		$box_color = $this->hb_customize->css->rgba( $this->burger_box_color );
		$bar_color_hover = $this->hb_customize->css->rgba( $this->burger_hover_bar_color );
		$box_color_hover = $this->hb_customize->css->rgba( $this->burger_hover_box_color );

		// Burger Menu inline block.
		$inline = ( ! empty( $properties['inline'] ) ) ? $properties['inline'] : '';

		// Burger Menu border offset.
		$borders = $this->burger_box_border;
		$border_top = ( ! empty( $borders['top']['width'] ) ) ? $borders['top']['width'] : 0;
		$border_right = ( ! empty( $borders['right']['width'] ) ) ? $borders['right']['width'] : 0;
		$border_bottom = ( ! empty( $borders['bottom']['width'] ) ) ? $borders['bottom']['width'] : 0;
		$border_left = ( ! empty( $borders['left']['width'] ) ) ? $borders['left']['width'] : 0;
		$border_offset['height'] = $border_top + $border_bottom;
		$border_offset['width']  = $border_left + $border_right;

		// Burger Menu border.
		$border = $this->hb_customize->css->border( $borders );

		// Burger Menu spacing and height.
		$bar_width   = $this->burger_width;
		$bar_height  = $this->burger_thickness;
		$bar_spacing = $this->burger_spacing + $this->burger_thickness;
		$box_height  = $bar_height + $bar_spacing * 2 + $this->padding['top'] + $this->padding['bottom'] + $border_offset['height'];

		// If nav style is text, use 10px instead.
		$box_width = 'auto';
		if ( 'text' !== $this->nav_style ) {
			$box_width = $bar_width + $this->padding['right'] + $this->padding['left'] + $border_offset['width'];
			$box_width = $box_width . 'px';
		}

		// Burger Menu animation.
		$animation = ( ! empty( $this->burger_animation['value'] ) ) ? $this->burger_animation['value'] : '';

		// Default style.
		$style = "
			#{$this->id} .hb-navigation-resp {
				text-align: {$this->align};
				{$inline}
			}
			#{$this->id} .hb-navigation-resp__box {
				width: {$box_width};
				height: {$box_height}px;
				background: {$box_color};
				border-radius: {$this->burger_box_radius}px;
				padding: {$padding};
				{$border};
			}
			#{$this->id} .hb-navigation-resp__bar,
			#{$this->id} .hb-navigation-resp__bar:after,
			#{$this->id} .hb-navigation-resp__bar:before {
				width: {$bar_width}px;
				height: {$bar_height}px;
			}
			#{$this->id} .hb-navigation-resp__box:hover {
				background: {$box_color_hover};
			}
			#{$this->id} .hb-navigation-resp__box:hover .hb-navigation-resp__bar,
			#{$this->id} .hb-navigation-resp__box:hover .hb-navigation-resp__bar:after,
			#{$this->id} .hb-navigation-resp__box:hover .hb-navigation-resp__bar:before {
				background: {$bar_color_hover};
			}
			#{$this->id} .fullscreen-active .hb-navigation-resp__bar,
			#{$this->id} .fullscreen-active .hb-navigation-resp__box:hover .hb-navigation-resp__bar {
				background: rgba( 255, 255, 255, 0 );
			}
			#{$this->id} .hb-navigation-resp__bar,
			#{$this->id} .hb-navigation-resp__bar:before,
			#{$this->id} .hb-navigation-resp__bar:after {
				background: {$bar_color};
			}
		";

		// Animation style.
		$style_args = array(
			'bar_width' => $bar_width,
			'bar_height' => $bar_height,
			'bar_color' => $bar_color,
			'bar_color_hover' => $bar_color_hover,
			'bar_spacing' => $bar_spacing,
			'animation' => $animation,
		);
		$style .= $this->get_style_burger_animation( $style_args );

		return $style;

	}

	/**
	 * Get custom style from Theme Options.
	 *
	 * @since 5.9.5
	 *
	 * @return string Custom style from Theme Options.
	 */
	public function get_style_to() {
		// Some styles inherited from TO.
		global $mk_options;
		$resp_wrap_bg = ( ! empty( $mk_options['responsive_nav_color'] ) ) ? $mk_options['responsive_nav_color'] : '#ffffff';
		$resp_burger_icon_bg = ( ! empty( $mk_options['header_burger_color'] ) ) ? $mk_options['header_burger_color'] : '#444444';
		$resp_text_color = ( ! empty( $mk_options['responsive_nav_txt_color'] ) ) ? $mk_options['responsive_nav_txt_color'] : 'inherit';
		$resp_search_bg = ( ! empty( $mk_options['header_mobile_search_input_bg'] ) ) ? 'background-color: ' . $mk_options['header_mobile_search_input_bg'] . ' !important;' : '';
		$resp_search_color = ( ! empty( $mk_options['header_mobile_search_input_color'] ) ) ? 'color: ' . $mk_options['header_mobile_search_input_color'] . ' !important;' : '';
		$resp_search_fill = ( ! empty( $mk_options['header_mobile_search_input_color'] ) ) ? 'fill: ' . $mk_options['header_mobile_search_input_color'] . ' !important;' : '';

		/**
		 * Navigation style.
		 *
		 * @todo Some of the styles are similar with others element instance, need to make it as one file.
		 *       For example: .hb-navigation-resp__wrap
		 */
		$style = "
			/* Theme Options Styles */
			.hb-navigation-resp__wrap {
				background-color: {$resp_wrap_bg};
			}
			.hb-navigation-resp__menu > div {
				background-color: {$resp_burger_icon_bg};
			}
			.hb-navigation-resp__ul li ul li .megamenu-title:hover,
			.hb-navigation-resp__ul li ul li .megamenu-title,
			.hb-navigation-resp__ul li a, .hb-navigation-resp__ul li ul li a:hover,
			.hb-navigation-resp__ul .hb-navigation-resp__arrow {
		  		color:{$resp_text_color};
			}
			.hb-navigation-resp__searchform .text-input {
			    {$resp_search_bg}
				{$resp_search_color}
			}
			.hb-navigation-resp__searchform i svg {
				{$resp_search_fill}
			}
			.hb-navigation-resp__searchform span i,
			.hb-navigation-resp__searchform .text-input::-webkit-input-placeholder,
			.hb-navigation-resp__searchform .text-input:-ms-input-placeholder,
			.hb-navigation-resp__searchform .text-input:-moz-placeholder {
				{$resp_search_color}
			}
		";

		return $style;

	}

	/**
	 * Get custom style for specifici Hover style.
	 *
	 * @since 5.9.5
	 *
	 * @param  integer $hover_style The number of the hover style.
	 * @param  array   $properties  Pass arguments for navigation.
	 * @return string               Custom style from Text - Hover style navigation.
	 */
	public function get_style_text_hover( $hover_style = 1, $properties = array() ) {
		$style = '';

		// Layout.
		$menu_margin = ( ! empty( $properties['menu_margin'] ) ) ? $properties['menu_margin'] : 'auto';

		// Style - Menu.
		$menu_text_bg = ( ! empty( $properties['menu_text_bg_color'] ) ) ? $properties['menu_text_bg_color'] : '';

		// Style - Menu Hover.
		$menu_text_hover_font_color = ( ! empty( $properties['menu_text_hover_font_color'] ) ) ? $properties['menu_text_hover_font_color'] : '';
		$menu_text_hover_bg = ( ! empty( $properties['menu_text_hover_bg_color'] ) ) ? $properties['menu_text_hover_bg_color'] : '';

		// Check current hover style.
		if ( 1 === $hover_style ) {
			$style = "
				/* Hover Style 1 */
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.menu-item > a.menu-item-link {
					margin: auto;
				}
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.menu-item {
					margin-right: {$this->gutter_space}px;
				}
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.menu-item:last-of-type  {
					margin-right: 0;
				}
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul>li.menu-item:before {
					{$menu_text_bg}
				}
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.menu-item > a.menu-item-link:hover,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.menu-item:hover > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.current-menu-item > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.current-menu-ancestor > a.menu-item-link {
					color: {$menu_text_hover_font_color};
				}
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.dropdownOpen:before,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.active:before,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.open:before,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.menu-item:hover:before,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.current-menu-item:before,
				#{$this->id}.hb-menu-hover-style-1 .hb-navigation-ul > li.current-menu-ancestor:before {
					{$menu_text_hover_bg}
				}
			";
		} elseif ( 2 === $hover_style ) {
			$style = "
				/* Hover Style 2 */
				#{$this->id}.hb-menu-hover-style-2 .hb-navigation-ul>li.menu-item>a {
					{$menu_text_bg}
				}
				#{$this->id}.hb-menu-hover-style-2 .hb-navigation-ul > li.menu-item > a.menu-item-link:hover,
				#{$this->id}.hb-menu-hover-style-2 .hb-navigation-ul > li.menu-item:hover > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-2 .hb-navigation-ul > li.current-menu-item > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-2 .hb-navigation-ul > li.current-menu-ancestor > a.menu-item-link {
					color: {$menu_text_hover_font_color};
					{$menu_text_hover_bg}
				}
			";
		} elseif ( 3 === $hover_style ) {
			// Style - Menu Hover.
			$menu_text_corner_radius = $this->text_corner_radius;
			$menu_text_border = $this->hb_customize->css->border( $this->text_border );
			$menu_text_hover_border = $this->hb_customize->css->border( $this->text_hover_border );

			$style = "
				/* Hover Style 3 */
				#{$this->id}.hb-menu-hover-style-3 .hb-navigation-ul > li.menu-item > a {
					{$menu_text_border}
					{$menu_text_bg}
					border-radius: {$menu_text_corner_radius}px;
				}
				#{$this->id}.hb-menu-hover-style-3 .hb-navigation-ul > li.menu-item > a.menu-item-link:hover,
				#{$this->id}.hb-menu-hover-style-3 .hb-navigation-ul > li.menu-item:hover > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-3 .hb-navigation-ul > li.menu-item:hover > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-3 .hb-navigation-ul > li.current-menu-item > a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-3 .hb-navigation-ul > li.current-menu-ancestor > a.menu-item-link {
					color: {$menu_text_hover_font_color};
					{$menu_text_hover_bg};
					{$menu_text_hover_border};
				}
			";
		} elseif ( 4 === $hover_style ) {
			$style = "
				/* Hover Style 4 */
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.menu-item>a.menu-item-link:after {
					{$menu_text_bg}
				}
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.menu-item:hover>a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.current-menu-ancestor>a.menu-item-link,
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.current-menu-item>a.menu-item-link {
					color: {$menu_text_hover_font_color};
				}
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.menu-item:hover>a.menu-item-link::after,
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.current-menu-ancestor>a.menu-item-link:after,
				#{$this->id}.hb-menu-hover-style-4 .hb-navigation-ul>li.current-menu-item>a.menu-item-link:after {
					{$menu_text_hover_bg}
				}
			";
		} // End if().

		return $style;

	}

	/**
	 * Get custom style for specific Animation style.
	 *
	 * @since 5.9.5
	 *
	 * @param  array $style_args Style parameters for animation.
	 * @return string            CSS styles for specific animation.
	 */
	public function get_style_burger_animation( $style_args = array() ) {
		// Basic style for all animations.
		$style = "
			#{$this->id} .hb-navigation-resp__bar {
				transform: translateY({$style_args['bar_spacing']}px);
			}
			#{$this->id} .hb-navigation-resp__bar:before {
				bottom: {$style_args['bar_spacing']}px;
			}
			#{$this->id} .hb-navigation-resp__bar:after {
				top: {$style_args['bar_spacing']}px;
			}
			#{$this->id} .fullscreen-active .hb-navigation-resp__bar:after {
				top: 0;
			}
			#{$this->id} .fullscreen-active .hb-navigation-resp__bar:before {
				bottom: 0;
			}
		";

		// Additional styles for Morphing animation.
		if ( 'morphing' === $style_args['animation'] ) {
			$style .= "
				#{$this->id} .hb-navigation-resp__box--morphing .hb-navigation-resp__sub-bar,
				#{$this->id} .hb-navigation-resp__box--morphing .hb-navigation-resp__sub-bar:after,
				#{$this->id} .hb-navigation-resp__box--morphing .hb-navigation-resp__sub-bar:before {
					width: {$style_args['bar_width']}px;
					height: {$style_args['bar_height']}px;
				}
				#{$this->id} .hb-navigation-resp__box.hb-navigation-resp__box--morphing:hover .hb-navigation-resp__sub-bar:after,
				#{$this->id} .hb-navigation-resp__box.hb-navigation-resp__box--morphing:hover .hb-navigation-resp__sub-bar:before {
					background: {$style_args['bar_color_hover']};
				}
				#{$this->id} .hb-navigation-resp__sub-bar {
					transform: translateY({$this->burger_spacing}px);
				}
				#{$this->id} .hb-navigation-resp__sub-bar:before,
				#{$this->id} .hb-navigation-resp__sub-bar:after {
					background: {$style_args['bar_color']};
				}
				#{$this->id} .fullscreen-active .hb-navigation-resp__sub-bar:after {
					top: 0;
				}
				#{$this->id} .fullscreen-active .hb-navigation-resp__sub-bar:before {
					bottom: 0;
				}
				#{$this->id} .hb-navigation-resp__box--morphing .hb-navigation-resp__bar,
				#{$this->id} .hb-navigation-resp__box--morphing:hover .hb-navigation-resp__bar {
					background: rgba( 255, 255, 255, 0 );
				}
			";
		}

		return $style;

	}

	/**
	 * Get custom style for Responsive dropdown menu.
	 *
	 * @since 5.9.5
	 *
	 * @return string Custom style from Responsive state.
	 */
	public function get_style_responsive() {
		// Space top and bottom is used on the dropdown menu margin top and bottom.
		$menu_space_top = 15;
		$menu_space_bottom = 15;
		if ( 0 !== $this->gutter_space ) {
			$menu_space_top += ceil( $this->gutter_space / 2 );
			$menu_space_bottom += floor( $this->gutter_space / 2 );
		}

		// Set line height. The line-height is used to set the height of the item and down arrow.
		$line_height = 8 + $menu_space_bottom + $menu_space_top + $this->font_size;

		$style = "
			/* Responsive Navigation - Specific */
			#{$this->id}-wrap .hb-navigation-resp__arrow {
				line-height: {$line_height}px;
			}
			#{$this->id}-wrap .hb-navigation-resp__ul > li > a {
				padding-top: {$menu_space_top}px;
				padding-bottom: {$menu_space_bottom}px;
			}

			/* Responsive Navigation - Devices */
			@media (max-width: 767px) {
				#{$this->id}.hb-el-tablet {
					display: none !important;
				}
			}
			@media (min-width: 768px) and (max-width: 1024px) {
				#{$this->id}.hb-el-mobile {
					display: none !important;
				}
			}
			@media (min-width: 1025px) {
				#{$this->id}.hb-el-tablet,
				#{$this->id}.hb-el-mobile {
					display: none !important;
				}
			}
		";

		return $style;

	}

	/**
	 * Get navigation body is desktop or mobile/tablet version.
	 *
	 * @since 5.9.5
	 *
	 * @return string HTML markup of navigation body.
	 */
	public function get_navigation_body() {
		$this->nav_menu = $this->get_active_menu();

		$body = $this->nav_menu;

		$nav_menu = '';
		// Use Jupiter navigation fullscreen if Burger is selected on Desktop.
		if ( 'desktop' === $this->device && 'burger' === $this->nav_style ) {
			$nav_menu = $this->get_nav_fullscreen();
		}

		if ( 'burger' === $this->nav_style ) {
			$animation = ( ! empty( $this->burger_animation['value'] ) ) ? $this->burger_animation['value'] : 'none';

			// BURGER MENU MARKUP.
			$body = sprintf(
				'
				<div class="hb-navigation-resp" data-device="%s">
					<div class="hb-navigation-resp__container %s fullscreen-style">
						<div class="hb-navigation-resp__box %s">
							<div class="hb-navigation-resp__bar"></div>
							<div class="hb-navigation-resp__sub-bar"></div>
						</div>
					</div>
					%s
				</div>',
				esc_attr( $this->device ),
				esc_attr( 'hb-navigation-resp__container--' . $this->nav_style . '-' . $this->device ),
				esc_attr( 'hb-navigation-resp__box--' . $animation ),
				$nav_menu
			);
		} // End if().

		/**
		 * Set responsive navigation markup after HB container in hb_grid_extra hook.
		 *
		 * @since 5.9.5
		 *
		 * @see views/header/styles/header_custom.php
		 */
		if ( 'desktop' !== $this->device && 'burger' === $this->nav_style ) {
			add_action( 'hb_grid_extra', array( $this, 'set_resp_navigation' ) );
		}

		return $body;
	}

	/**
	 * Set responsive navigation markup for mobile and tablet. Both of Text and Burger style will
	 * use same responsive navigation.
	 *
	 * @since 5.9.5
	 */
	public function set_resp_navigation() {
		// Check if search form is enabled by Theme Options.
		$search_form = '';
		global $mk_options;
		if ( ! empty( $mk_options['header_search_location'] ) && 'disable' !== $mk_options['header_search_location'] ) {

			if ( ! class_exists( 'Mk_SVG_Icons' ) ) {
				require_once THEME_HELPERS . '/svg-icons.php';
			}

			// SEARCH FORM MARKUP.
			$search_form = sprintf(
				'
				<form class="hb-navigation-resp__searchform" method="get" action="%s">
	    			<input type="text" class="text-input" value="" name="s" id="s" placeholder="%s" />
	   				<i><input value="" type="submit" />%s</i>
				</form>',
				home_url( '/' ),
				__( 'Search..', 'mk_framework' ),
				Mk_SVG_Icons::get_svg_icon_by_class_name( false, 'mk-icon-search' )
			);
		}

		// RESPOSNIVE MARKUP.
		$resp_nav = sprintf(
			'
			<div id="%s-wrap" class="hb-navigation-resp__wrap hb-el-%s">
				%s %s
			</div>',
			esc_attr( $this->id ),
			esc_attr( $this->device ),
			$this->nav_menu,
			$search_form
		);

		echo wp_kses(
			$resp_nav, array(
				'div' => array(
					'id' => array(),
					'class' => array(),
				),
				'form' => array(
					'class' => array(),
					'method' => array(),
					'action' => array(),
				),
				'input' => array(
					'type' => array(),
					'class' => array(),
					'value' => array(),
					'name' => array(),
					'id' => array(),
					'placeholder' => array(),
				),
				'i' => array(),
				'svg' => array(
					'xmlns' => array(),
					'style' => array(),
					'viewbox' => array(),
				),
				'path' => array(
					'd' => array(),
					'transform' => array(),
				),
				'span' => array(
					'class' => array(),
				),
				'nav' => array(
					'class' => array(),
					'id' => array(),
				),
				'ul' => array(
					'id' => array(),
					'class' => array(),
				),
				'li' => array(
					'id' => array(),
					'class' => array(),
				),
				'a' => array(
					'href' => array(),
					'class' => array(),
				),
			)
		);
	}

	/**
	 * Get current active menu and add responsive stuff class.
	 *
	 * @since 5.9.5
	 *
	 * @return string HTML menu markup.
	 */
	public function get_active_menu() {
		// Text - Dekstop/Tablet/Mobile.
		$container_id = '';
		$container_class = 'hb-navigation hb-js-nav';
		$menu_class = 'hb-navigation-ul';
		$fallback_cb = 'mk_link_to_menu_editor';
		$sub_level_arrrow = '';
		$walker = new hb_main_menu();

		// Burger - Mobile/Tablet.
		if ( 'desktop' !== $this->device && 'burger' === $this->nav_style ) {
			$container_class = 'menu-main-navigation-container';
			$menu_class = 'hb-navigation-resp__ul';
			$walker = new HB_Walker_Nav_Responsive();

			// For demo or Preview menu only.
			$sub_level_arrrow = '<span class="hb-navigation-resp__arrow hb-navigation-resp__sub-closed"><svg style="height:16px;width: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 192l-96-96-160 160-160-160-96 96 256 255.999z"></path></svg></span>';
		}

		// Burger - Desktop.
		if ( 'desktop' === $this->device && 'burger' === $this->nav_style ) {
			$container_id = 'fullscreen-navigation';
			$container_class = 'fullscreen-menu';
			$menu_class = 'fullscreen-navigation-ul';
			$fallback_cb = '';
			$walker = new HB_Walker_Nav_Burger();

			// For demo ora Preview menu only.
			$sub_level_arrrow = '<span class="menu-sub-level-arrow"><svg class="mk-svg-icon" style="height:16px;width: 16px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 192l-96-96-160 160-160-160-96 96 256 255.999z"></path></svg></span>';
		}

		// Get menu and the items list.
		if ( 'navigation-preview' === $this->menu ) {
			$menu = sprintf(
				'
				<nav id="%s" class="%s">
					<ul class="%s dropdownJavascript">
						<li class="menu-item current-menu-item current_page_item hb-no-mega-menu">
							<a href="#" class="menu-item-link hb-js-smooth-scroll">Current Menu</a>
						</li>
						<li class="menu-item hb-has-mega-menu">
							<a href="#" class="menu-item-link hb-js-smooth-scroll">Menu</a>
						</li>
						<li class="menu-item menu-item-has-children hb-no-mega-menu">
							<a href="#" class="menu-item-link hb-js-smooth-scroll">Menu</a>
							%s
							<ul class="sub-menu">
								<li class="menu-item"><a href="#" class="menu-item-link hb-js-smooth-scroll">Menu</a></li>
								<li class="menu-item"><a href="#" class="menu-item-link hb-js-smooth-scroll">Menu</a></li>
							</ul>
						</li>
					</ul>
				</nav>',
				( ! empty( $container_id ) ) ? esc_attr( $container_id ) : 'hb-nav-preview',
				esc_attr( $container_class ),
				esc_attr( $menu_class ),
				$sub_level_arrrow
			);
		} else {
			if ( isset( $_GET['header-builder'] ) && 'preview' === $_GET['header-builder'] ) { // WPCS: XSS ok, CSRF ok.
				add_filter( 'wp_nav_menu', 'mkhb_active_current_menu_item' );
			}
			$menu = wp_nav_menu(
				array(
					'menu' => $this->menu,
					'container' => 'nav',
					'container_id' => $container_id,
					'container_class' => $container_class,
					'menu_class' => $menu_class,
					'echo' => false,
					'fallback_cb' => $fallback_cb,
					'walker' => $walker,
				)
			);
			remove_filter( 'wp_nav_menu', 'mkhb_active_current_menu_item' );
		} // End if().

		return $menu;
	}

	/**
	 * Get navigation content.
	 * We should keep some of Jupiter class to inheritance Jupiter theme options.
	 *
	 * @since 5.9.5
	 * @see views/header/master/fullscreen-nav.php Source of the HTML content.
	 *
	 * @return string Return fullscreen navigation HTML.
	 */
	public function get_nav_fullscreen() {
		// Get Logo Settings.
		$logo_settings = $this->get_logo_settings();

		$mobile_logo = $logo_settings['mobile_logo'];
		$logo = $logo_settings['logo'];

		$is_repsonive_logo = ! empty( $mobile_logo ) ? 'logo-is-responsive' : '';

		// Collect the navigation content.
		ob_start();
		?>

		<div class="hb-navigation-resp__nav mk-fullscreen-nav <?php echo esc_attr( $is_repsonive_logo ); ?>">
			<div class="mk-fullscreen-inner _ flex flex-center flex-items-center">
				<div class="mk-fullscreen-nav-wrapper">

					<?php if ( ! empty( $logo ) ) : ?>
					<img class="mk-fullscreen-nav-logo dark-logo" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $logo ); ?>" />
					<?php endif; ?>

					<?php if ( ! empty( $logo ) ) : ?>
					<img class="mk-fullscreen-nav-logo responsive-logo" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $mobile_logo ); ?>" />
					<?php endif; ?>

					<?php
						echo wp_kses(
							$this->get_active_menu(), array(
								'i' => array(),
								'svg' => array(
									'class' => array(),
									'xmlns' => array(),
									'style' => array(),
									'viewbox' => array(),
								),
								'path' => array(
									'd' => array(),
									'transform' => array(),
								),
								'span' => array(
									'class' => array(),
								),
								'nav' => array(
									'class' => array(),
									'id' => array(),
								),
								'ul' => array(
									'id' => array(),
									'class' => array(),
								),
								'li' => array(
									'id' => array(),
									'class' => array(),
								),
								'a' => array(
									'href' => array(),
									'class' => array(),
								),
							)
						);
					?>
				</div>
			</div>
		</div>

		<?php
		$nav_content = ob_get_clean();

		return $nav_content;
	}

	/**
	 * Get logo settings.

	 * @since 5.9.5
	 *
	 * @return array Logo and mobile settings.
	 */
	public function get_logo_settings() {
		// Get all theme options settings.
		global $mk_options;

		$params = $this->get_logo_params_setting();

		$settings['mobile_logo'] = ( 'dark' === $params['mob_logo_skin'] ) ? $mk_options['logo'] : $params['light_logo'];
		$settings['logo'] = ( 'dark' === $params['logo_skin'] ) ? $mk_options['logo'] : $params['light_logo'];

		// If Mobile Logo is a Custom Logo.
		if ( 'custom' === $params['mob_logo_skin'] ) {
			$settings['mobile_logo'] = ! empty( $mk_options['fullscreen_nav_mobile_logo_custom'] ) ? $mk_options['fullscreen_nav_mobile_logo_custom'] : $settings['mobile_logo'];
		}

		return $settings;
	}

	/**
	 * Get logo parameter settings.
	 *
	 * @since 5.9.5
	 *
	 * @return array Logo and mobile parameter settings.
	 */
	public function get_logo_params_setting() {
		// Get all theme options settings.
		global $mk_options;

		$params_setting['mob_logo_skin'] = ! empty( $mk_options['fullscreen_nav_mobile_logo'] ) ? $mk_options['fullscreen_nav_mobile_logo'] : 'dark';
		$params_setting['logo_skin']  = ! empty( $mk_options['fullscreen_nav_logo'] ) ? $mk_options['fullscreen_nav_logo'] : 'dark';
		$params_setting['light_logo'] = isset( $mk_options['light_header_logo'] ) ? $mk_options['light_header_logo'] : '';

		return $params_setting;
	}

	/**
	 * Enqueue fonts for navigation.
	 *
	 * @since 5.9.2
	 * @since 5.9.4 Simplify enqueue font family by using $hb_tags->enqueue_fonts() function.
	 * @since 5.9.5 Check if text_font_family is not empty before enqueue the font. Check what's the current
	 *              device and text style.
	 */
	public function enqueue_scripts() {
		if ( ! empty( $this->text_font_family ) ) {
			$this->hb_customize->tags->enqueue_fonts( 'navigation', $this->text_font_family, $this->font_weight );
		}
		wp_enqueue_style( 'hb-navigation', HB_ASSETS_URI . 'css/hb-navigation.css', array(), '5.9.5' );
		wp_enqueue_script( 'hb-navigation-scripts', HB_ASSETS_URI . 'js/hb-navigation-scripts.js', array( 'jquery' ), '5.9.2', true );
		wp_enqueue_script( 'hb-navigation', HB_ASSETS_URI . 'js/hb-navigation.js', array( 'jquery' ), '5.9.2', true );

		// Run specific library on specific cases.
		if ( 'burger' === $this->nav_style ) {
			if ( 'desktop' === $this->device ) {
				wp_enqueue_script( 'hb-burger-menu', HB_ASSETS_URI . 'js/hb-navigation-burger.js', array( 'jquery' ), '5.9.5', true );
			} elseif ( 'desktop' !== $this->device ) {
				wp_enqueue_script( 'hb-navigation-responsive', HB_ASSETS_URI . 'js/hb-navigation-responsive.js', array( 'jquery' ), '5.9.5', true );
			}
		}
	}

	/**
	 * Enqueue fonts for button.
	 *
	 * @since 5.9.4
	 *
	 * @param  array $google_fonts Google fonts list.
	 */
	public function enqueue_fonts( $google_fonts ) {
		// Check font type.
		$font_type = '';
		if ( ! empty( $this->font_family['type'] ) ) {
			$font_type = $this->font_family['type'];
		}

		// Check font label.
		$font_label = '';
		if ( ! empty( $this->font_family['label'] ) && 'google' === $font_type ) {
			$font_label = $this->font_family['label'] . ':100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900';

			if ( ! in_array( $font_label, $google_fonts, true ) ) {
				$google_fonts[] = $font_label;
			}
		}

		return $google_fonts;
	}

}
