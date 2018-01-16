<?php
/**
 * Header Builder: HB_Element_Burger_Menu class.
 *
 * @package Header_Builder
 * @subpackage Elements_Generator
 * @since 5.9.3
 * @deprecated 5.9.5
 */

/**
 * Main class used for rendering 'Burger Menu' element to the front end. This class no longer used.
 * All the functionalities have been moved to HB_Element_Navigation.
 *
 * @since 5.9.3 Introduced.
 * @since 5.9.4 Use $hb_customize property to load HB_Customize instance.
 *
 * @deprecated 5.9.5
 *
 * @see HB_Element
 */
class HB_Element_Burger_Menu extends HB_Element {
	/**
	 * Constructor.
	 *
	 * @since 5.9.3
	 * @since 5.9.4 Add $hb_customize property on constructor.
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
	 *           @type string $width
	 *           @type string $spacing
	 *           @type string $alignment
	 *           @type string $cssDisplay
	 *           @type string $animation
	 *           @type string $thickness
	 *           @type string $boxRadius
	 *           @type string $barColor
	 *           @type string $boxColor
	 *           @type string $barColorHover
	 *           @type string $boxColorHover
	 *           @type string $boxBorder
	 *           @type string $margin
	 *           @type string $padding
	 *     }
	 * }
	 * @param int    $row_index     Numeric index for the row.
	 * @param int    $column_index  Numeric index for the column.
	 * @param int    $element_index Numeric index for the element.
	 * @param object $hb_customize  HB_Costumize instance.
	 */
	public function __construct( $element, $row_index, $column_index, $element_index, $hb_customize ) {
		parent::__construct( $element, $row_index, $column_index, $element_index, $hb_customize );

		// Declare properties value.
		$this->width   = $this->get_option( 'barWidth', 15 );
		$this->spacing = $this->get_option( 'barSpacing', 4 );
		$this->align   = $this->get_option( 'alignment', 'left' );
		$this->inline  = $this->get_option( 'cssDisplay', 'block' );
		$this->animation  = $this->get_option( 'animation', 'none' );
		$this->thickness  = $this->get_option( 'barThickness', 2 );
		$this->box_radius = $this->get_option( 'boxCornerRadius', 0 );

		$this->bar_color  = $this->get_option( 'barColor',  array(
			'r' => 255,
			'g' => 255,
			'b' => 255,
			'a' => 1,
		) );
		$this->box_color  = $this->get_option( 'boxColor',  array(
			'r' => 0,
			'g' => 0,
			'b' => 0,
			'a' => 1,
		) );
		$this->bar_color_hover  = $this->get_option( 'barHoverColor',  array(
			'r' => 102,
			'g' => 102,
			'b' => 102,
			'a' => 1,
		) );
		$this->box_color_hover  = $this->get_option( 'boxHoverColor',  array(
			'r' => 221,
			'g' => 221,
			'b' => 221,
			'a' => 1,
		) );

		$this->box_border = $this->get_option( 'boxBorder', array(
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
		$this->padding = $this->get_option( 'padding', array(
			'top' => 8,
			'right' => 8,
			'bottom' => 8,
			'left' => 8,
		) );
		$this->margin  = $this->get_option( 'margin', array(
			'top' => 0,
			'right' => 0,
			'bottom' => 0,
			'left' => 0,
		) );

		// Enqueue the search style and HB script.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

	}

	/**
	 * Enqueue burger-menu style and HB script.
	 *
	 * @since 5.9.3
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'hb-burger-menu', HB_ASSETS_URI . 'css/hb-burger-menu.css', array(), '5.9.3' );
		wp_enqueue_script( 'hb-burger-menu', HB_ASSETS_URI . 'js/hb-burger-menu.js', array( 'jquery' ), '5.9.3', true );
	}

	/**
	 * Generate the element's markup and style for use on the front-end.
	 *
	 * @since 5.9.3
	 *
	 * @return array {
	 *      HTML and CSS for the element, based on all its given properties and settings.
	 *
	 *      @type string $markup Element HTML code.
	 *      @type string $style Element CSS code.
	 * }
	 */
	public function get_src() {
		// Burger Menu margin and padding.
		$padding = $this->hb_customize->layout->trbl( $this->padding );
		$margin  = $this->hb_customize->layout->trbl( $this->margin );

		// Burger Menu color.
		$bar_color = $this->hb_customize->css->rgba( $this->bar_color );
		$box_color = $this->hb_customize->css->rgba( $this->box_color );
		$bar_color_hover = $this->hb_customize->css->rgba( $this->bar_color_hover );
		$box_color_hover = $this->hb_customize->css->rgba( $this->box_color_hover );

		// Burger Menu inline block.
		$inline = $this->hb_customize->layout->inline_block( $this->inline );

		// Burger Menu border.
		$borders = $this->box_border;
		$border_offset['height'] = $borders['top']['width'] + $borders['bottom']['width'];
		$border_offset['width']  = $borders['left']['width'] + $borders['right']['width'];
		$border = $this->hb_customize->css->border( $borders );

		// Burger Menu spacing and height.
		$bar_width   = $this->width;
		$bar_height  = $this->thickness;
		$bar_spacing = $this->spacing + $this->thickness;
		$box_height  = $bar_height + $bar_spacing * 2 + $this->padding['top'] + $this->padding['bottom'] + $border_offset['height'];
		$box_width   = $bar_width + $this->padding['right'] + $this->padding['left'] + $border_offset['width'];

		// Burger Menu animation.
		$animation = ( ! empty( $this->animation['value'] ) ) ? $this->animation['value'] : '';

		$markup = sprintf( '
			<div id="%s" class="hb-burger-menu-el">
				<div class="hb-burger-menu-el__container fullscreen-style">
					<div class="hb-burger-menu-el__box %s">
						<div class="hb-burger-menu-el__bar"></div>
						<div class="hb-burger-menu-el__sub-bar"></div>
					</div>
				</div>
				%s
			</div>',
			esc_attr( $this->id ),
			esc_attr( 'hb-burger-menu-el__box--' . $animation ),
			$this->get_nav_fullscreen()
		);

		$style = "
			#{$this->id} {
				text-align: {$this->align};
				margin: {$margin};
				{$inline}
			}
			#{$this->id} .hb-burger-menu-el__box {
				width: {$box_width}px;
				height: {$box_height}px;
				background: {$box_color};
				padding: {$padding};
				border-radius: {$this->box_radius}px;
				{$border};
			}
			#{$this->id} .hb-burger-menu-el__bar,
			#{$this->id} .hb-burger-menu-el__bar:after,
			#{$this->id} .hb-burger-menu-el__bar:before {
				width: {$bar_width}px;
				height: {$bar_height}px;
			}
			#{$this->id} .hb-burger-menu-el__box:hover {
				background: {$box_color_hover};
			}
			#{$this->id} .hb-burger-menu-el__box:hover .hb-burger-menu-el__bar,
			#{$this->id} .hb-burger-menu-el__box:hover .hb-burger-menu-el__bar:after,
			#{$this->id} .hb-burger-menu-el__box:hover .hb-burger-menu-el__bar:before {
				background: {$bar_color_hover};
			}
			#{$this->id} .fullscreen-active .hb-burger-menu-el__bar,
			#{$this->id} .fullscreen-active .hb-burger-menu-el__box:hover .hb-burger-menu-el__bar {
				background: rgba( 255, 255, 255, 0 );
			}
			#{$this->id} .hb-burger-menu-el__bar,
			#{$this->id} .hb-burger-menu-el__bar:before,
			#{$this->id} .hb-burger-menu-el__bar:after {
				background: {$bar_color};
			}
		";

		$style_args = array(
			'bar_width' => $bar_width,
			'bar_height' => $bar_height,
			'bar_color' => $bar_color,
			'bar_color_hover' => $bar_color_hover,
			'bar_spacing' => $bar_spacing,
			'animation' => $animation,
		);
		$style .= $this->get_animation_style( $style_args );

		return compact( 'markup', 'style' );
	}

	/**
	 * Get navigation content.
	 * We should keep some of Jupiter class to inheritance Jupiter theme options.
	 *
	 * @since 5.9.3
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

		<div class="hb-burger-menu-el__nav mk-fullscreen-nav <?php echo esc_attr( $is_repsonive_logo ); ?>">
			<div class="mk-fullscreen-inner _ flex flex-center flex-items-center">
				<div class="mk-fullscreen-nav-wrapper">

					<img class="mk-fullscreen-nav-logo dark-logo" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $logo ); ?>" />
					<img class="mk-fullscreen-nav-logo responsive-logo" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" src="<?php echo esc_url( $mobile_logo ); ?>" />

					<?php
					if ( ! class_exists( 'header_icon_walker' ) ) {
						include_once locate_template( 'framework/custom-nav-walker/menu-with-icon.php' );
					}

					wp_nav_menu( array(
						'theme_location' => 'fullscreen-menu',
						'container' => 'nav',
						'container_id' => 'fullscreen-navigation',
						'container_class' => 'fullscreen-menu',
						'menu_class' => 'fullscreen-navigation-ul',
						'fallback_cb' => '',
						'walker' => new header_icon_walker(),
					) );
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

	 * @since 5.9.3
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
	 * @since 5.9.3
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
	 * Get animation styles.
	 *
	 * @since 5.9.3
	 *
	 * @param  array $style_args Style parameters for animation.
	 * @return string            CSS styles for specific animation.
	 */
	public function get_animation_style( $style_args = array() ) {
		// Basic style for all animations.
		$style = "
			#{$this->id} .hb-burger-menu-el__bar {
				transform: translateY({$style_args['bar_spacing']}px);
			}
			#{$this->id} .hb-burger-menu-el__bar:before {
				bottom: {$style_args['bar_spacing']}px;
			}
			#{$this->id} .hb-burger-menu-el__bar:after {
				top: {$style_args['bar_spacing']}px;
			}
			#{$this->id} .fullscreen-active .hb-burger-menu-el__bar:after {
				top: 0;
			}
			#{$this->id} .fullscreen-active .hb-burger-menu-el__bar:before {
				bottom: 0;
			}
		";

		// Additional styles for Morphing animation.
		if ( 'morphing' === $style_args['animation'] ) {
			$style .= "
				#{$this->id} .hb-burger-menu-el__box--morphing .hb-burger-menu-el__sub-bar,
				#{$this->id} .hb-burger-menu-el__box--morphing .hb-burger-menu-el__sub-bar:after,
				#{$this->id} .hb-burger-menu-el__box--morphing .hb-burger-menu-el__sub-bar:before {
					width: {$style_args['bar_width']}px;
					height: {$style_args['bar_height']}px;
				}
				#{$this->id} .hb-burger-menu-el__box.hb-burger-menu-el__box--morphing:hover .hb-burger-menu-el__sub-bar:after,
				#{$this->id} .hb-burger-menu-el__box.hb-burger-menu-el__box--morphing:hover .hb-burger-menu-el__sub-bar:before {
					background: {$style_args['bar_color_hover']};
				}
				#{$this->id} .hb-burger-menu-el__sub-bar {
					transform: translateY({$this->spacing}px);
				}
				#{$this->id} .hb-burger-menu-el__sub-bar:before,
				#{$this->id} .hb-burger-menu-el__sub-bar:after {
					background: {$style_args['bar_color']};
				}
				#{$this->id} .fullscreen-active .hb-burger-menu-el__sub-bar:after {
					top: 0;
				}
				#{$this->id} .fullscreen-active .hb-burger-menu-el__sub-bar:before {
					bottom: 0;
				}
				#{$this->id} .hb-burger-menu-el__box--morphing .hb-burger-menu-el__bar,
				#{$this->id} .hb-burger-menu-el__box--morphing:hover .hb-burger-menu-el__bar {
					background: rgba( 255, 255, 255, 0 );
				}
			";
		}

		return $style;

	}

}
