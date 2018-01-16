<?php
/**
 * Header Builder: Main loader file
 *
 * @since 5.9.0
 * @package Header_Builder
 */

/**
 * Main class used for loading all Header Builder files.
 *
 * @since 5.9.0
 * @since 5.9.3 Refactor it as main class.
 * @since 5.9.4 Add parameters on HB_Grid declaration.
 * @since 5.9.5 Include make internal CSS inside hb_grid_style hook. Run HB_Grid after wp_loaded. Add
 *              new conditional statement to check if HB is activated from TO. Remove conditional
 *              statement to check HB is activated from HB admin page.
 * @since 5.9.8 Add conditional statements to call hb-grid only when HB is activated and called on
 *              frontend or preview only. Remove array type operand, check if the variable is array
 *              or not instead. Includes common.js.
 */
class HB_Main {

	/**
	 * Constructor.
	 *
	 * Call some functions to load Header Builder and load all necessary files.
	 *
	 * @since 5.9.3
	 * @since 5.9.5 Manage how to load the walkers for navigation. Join init_load and init_hooks.
	 * @since 5.9.8 Hook HB_Grid on 'wp'. Previously, it's called on 'wp_loaded'.
	 * @since 6.0.0 Load all the shortcode files on the frontend.
	 */
	public function __construct() {
		// Load the constants, helpers, etc.
		require_once dirname( __FILE__ ) . '/hb-config.php';
		require_once HB_INCLUDES_DIR . '/helpers/general.php';
		require_once HB_INCLUDES_DIR . '/helpers/array.php';
		require_once dirname( __FILE__ ) . '/class-hb-migration.php';

		// Load the nav walkers. Should be loaded here because the class will be used in admin panel too.
		require_once HB_INCLUDES_DIR . '/helpers/walkers/class-hb-walker-nav-responsive.php';
		require_once HB_INCLUDES_DIR . '/helpers/walkers/class-hb-walker-nav-burger.php';

		/**
		 * All files below only will be INCLUDED here. All customize classes will be EXECUTED inside
		 * class-hb-grid.php and instace HB_Grid only will be INITIATED on the frontend page and only
		 * when HB is active or on the preview page.
		 *
		 * @see HB_Main hb_grid().
		 */
		require_once HB_INCLUDES_DIR . '/customize/class-hb-css.php';
		require_once HB_INCLUDES_DIR . '/customize/class-hb-data-transforms.php';
		require_once HB_INCLUDES_DIR . '/customize/class-hb-attributes.php';
		require_once HB_INCLUDES_DIR . '/customize/class-hb-tags.php';
		require_once HB_INCLUDES_DIR . '/customize/class-hb-css-layout.php';
		require_once HB_INCLUDES_DIR . '/customize/class-hb-customize.php';
		require_once HB_INCLUDES_DIR . '/class-hb-post-type.php';
		require_once HB_INCLUDES_DIR . '/class-mkhb-hooks.php';
		require_once HB_INCLUDES_DIR . '/class-mkhb-render.php';
		require_once HB_INCLUDES_DIR . '/class-hb-grid.php';

		if ( is_admin() ) {
			require_once HB_ADMIN_DIR . '/class-hb-db.php';
			require_once HB_ADMIN_DIR . '/class-hb-model.php';
			require_once HB_ADMIN_DIR . '/class-hb-screen.php';
		}

		// Call hooks.
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'submenu_file', array( $this, 'return_query_tag' ) );
		add_filter( 'template_include', array( $this, 'preview_template' ), 99 );
		add_filter( 'query_vars', array( $this, 'query_vars_filter' ) );
		add_filter( 'get_header_style', array( $this, 'header_style' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_action( 'mk_enqueue_styles', array( $this, 'enqueue_styles' ) );
		add_action( 'mk_enqueue_styles_minified', array( $this, 'enqueue_styles' ) );
		add_action( 'wp', array( $this, 'hb_grid' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Load shortcode files on the frontend only.
		if ( ! is_admin() ) {
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-row.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-column.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-logo.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-shopping-icon.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-textbox.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-search.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-navigation.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-icon.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-social.php';
			require_once HB_INCLUDES_DIR . '/shortcodes/mkhb-button.php';
		}
	}

	/**
	 * Add's "Header Builder" to Jupiter WordPress menu.
	 *
	 * @since 5.9.3
	 */
	public function admin_menu() {
		add_submenu_page( THEME_NAME, __( 'Header Builder', 'mk_framework' ), __( 'Header Builder <span class="mk-beta-badge">Beta</span>', 'mk_framework' ), 'edit_theme_options', 'header-builder', '__return_null' );
	}

	/**
	 * Add the current page URL as the "return" parameter to our "Jupiter" > Header Builder" submenu.
	 *
	 * @since 5.9.3
	 */
	public function return_query_tag() {
		global $submenu;

		if ( array_key_exists( 'Jupiter', $submenu ) ) {
			return;
		}

		$current_url        = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$header_builder_url = add_query_arg( 'return', rawurlencode( $current_url ), 'admin.php?page=header-builder' );

		if ( ! array_key_exists( 'Jupiter', $submenu ) ) {
			return;
		}

		// The following position needs update if the header builder submenu location changes.
		foreach ( $submenu['Jupiter'] as $submenu_key => $submenu_array ) {
			if ( 'header-builder' === $submenu_array[2] ) {
				break;
			}
		}

		// @todo WordPress not allowed to override global $submenu. Need to find better way.
		$submenu['Jupiter'][ $submenu_key ][2] = $header_builder_url; // WPCS: override ok.
	}

	/**
	 * Render the "Preview" template when the URL loaded is "?header-builder=preview"
	 *
	 * @since 5.9.3
	 *
	 * @param string $template The path of the template to include.
	 */
	public function preview_template( $template ) {
		if ( 'navigation-preview' === get_query_var( 'header-builder' ) ) {
			return HB_INCLUDES_DIR . '/templates/navigation-preview.php';
		}

		return  $template;
	}

	/**
	 * Add header-builder to query vars. This is used for the preview functionality.
	 *
	 * @since 5.9.3
	 *
	 * @param array $public_query_vars The array of whitelisted query variables.
	 */
	public function query_vars_filter( $public_query_vars ) {
		$public_query_vars[] = 'header-builder';
		$public_query_vars[] = 'header-builder-id';
		return $public_query_vars;
	}

	/**
	 * Override default header style from theme-options.
	 *
	 * @since 5.9.3
	 * @since 5.9.5 Add conditional statement to check if HB is activated from TO. Remove conditional
	 *              statement to check HB is activated from HB admin page.
	 *
	 * @param string $style The Theme Options style to override.
	 */
	public function header_style( $style ) {
		// Is HB active from Theme Options.
		if ( hb_is_to_active() ) {
			return 'custom';
		}

		// Is user open HB in preview mode.
		$is_previewing = in_array( get_query_var( 'header-builder' ), array(
			'preview',
			'navigaiton-preview',
		), true );

		if ( $is_previewing ) {
			return 'custom';
		}

		return $style;
	}

	/**
	 * Add new class 'hb-jupiter' to body.
	 *
	 * @since 5.9.5
	 * @since 5.9.8 Add conditional statement to add hb-jupiter class only if HB is active or
	 *              user open Preview page.
	 *
	 * @param  string $classes Current body class list.
	 * @return array  $classes Latest body class list with additional hb-jupiter class.
	 */
	public function body_class( $classes ) {
		// Is user open HB in preview mode.
		if ( hb_is_to_active() || 'preview' === get_query_var( 'header-builder' ) ) {
			$classes[] = 'hb-jupiter';
		}

		return $classes;
	}

	/**
	 * Load our styles when mk_enqueue_styles() is called.
	 *
	 * @since 5.9.3
	 * @since 5.9.4 Add parameters on HB_Grid declaration.
	 * @since 5.9.5 Include make internal CSS inside hb_grid_style hook.
	 * @since 5.9.8 Include common.js as common HB Javscript file.
	 * @since 6.0.0 Include element shortcodes styles and scripts.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'hb-grid', HB_ASSETS_URI . 'css/grid.css', false, false, 'all' );
		wp_enqueue_style( 'hb-render', HB_ASSETS_URI . 'css/mkhb-render.css', array(), '6.0.0' );
		wp_enqueue_script( 'hb-common', HB_ASSETS_URI . 'js/common.js', array( 'jquery' ), '6.0.0', true );
		wp_enqueue_script( 'hb-render', HB_ASSETS_URI . 'js/render.js', array( 'jquery' ), '6.0.0', true );

		// Enqueue HB shortcodes default style.
		global $post;
		if ( ! empty( $post->post_content ) ) {
			if ( has_shortcode( $post->post_content, 'mkhb_row' ) ) {
				wp_enqueue_style( 'mkhb-row', HB_ASSETS_URI . 'css/mkhb-row.css', array(), '6.0.0' );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_col' ) ) {
				wp_enqueue_style( 'mkhb-column', HB_ASSETS_URI . 'css/mkhb-column.css', array(), '6.0.0' );
				wp_enqueue_script( 'mkhb-column', HB_ASSETS_URI . 'js/mkhb-column.js', array( 'jquery' ), '6.0.0', true );
			}

			if ( has_shortcode( $post->post_content, 'hb_logo' ) ) {
				wp_enqueue_style( 'mkhb-logo', HB_ASSETS_URI . 'css/mkhb-logo.css', array(), '6.0.0' );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_textbox' ) ) {
				wp_enqueue_style( 'mkhb-textbox', HB_ASSETS_URI . 'css/mkhb-textbox.css', array(), '6.0.0' );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_button' ) ) {
				wp_enqueue_style( 'mkhb-button', HB_ASSETS_URI . 'css/mkhb-button.css', array(), '6.0.0' );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_search' ) ) {
				wp_enqueue_style( 'mkhb-search', HB_ASSETS_URI . 'css/mkhb-search.css', array(), '6.0.0' );
				wp_enqueue_script( 'mkhb-search', HB_ASSETS_URI . 'js/mkhb-search.js', array( 'jquery' ), '6.0.0', true );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_navigation' ) ) {
				wp_enqueue_style( 'mkhb-navigation', HB_ASSETS_URI . 'css/mkhb-navigation.css', array(), '6.0.0' );
				wp_enqueue_script( 'mkhb-navigation-burger', HB_ASSETS_URI . 'js/navigation/mkhb-navigation-burger.js', array( 'jquery' ), '6.0.0', true );
				wp_enqueue_script( 'mkhb-navigation-responsive', HB_ASSETS_URI . 'js/navigation/mkhb-navigation-responsive.js', array( 'jquery' ), '6.0.0', true );
				wp_enqueue_script( 'mkhb-navigation-script', HB_ASSETS_URI . 'js/navigation/mkhb-navigation-script.js', array( 'jquery' ), '6.0.0', true );
				wp_enqueue_script( 'mkhb-navigation', HB_ASSETS_URI . 'js/navigation/mkhb-navigation.js', array( 'jquery' ), '6.0.0', true );
			}

			// Load Icons Styles.
			$this->enqueue_styles_icons();
		} // End if().

		do_action( 'hb_grid_style' );
	}

	/**
	 * Load Icons styles when mk_enqueue_styles() is called.
	 *
	 * @since 6.0.0
	 */
	private function enqueue_styles_icons() {
		global $post;
		if ( ! empty( $post->post_content ) ) {
			if ( has_shortcode( $post->post_content, 'mkhb_social_media' ) ) {
				wp_enqueue_style( 'mkhb-social', HB_ASSETS_URI . 'css/mkhb-social.css', array(), '6.0.0' );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_shopping_icon' ) ) {
				wp_enqueue_style( 'mkhb-shop-cart', HB_ASSETS_URI . 'css/mkhb-shop-cart.css', array(), '6.0.0' );
				wp_enqueue_script( 'mkhb-shop-cart', HB_ASSETS_URI . 'js/mkhb-shop-cart.js', array( 'jquery' ), '6.0.0', true );
			}

			if ( has_shortcode( $post->post_content, 'mkhb_icon' ) ) {
				wp_enqueue_style( 'mkhb-icon', HB_ASSETS_URI . 'css/mkhb-icon.css', array(), '6.0.0' );
			}
		}
	}

	/**
	 * Create global JS variable on admin init.
	 *
	 * @since 5.9.5
	 */
	public function admin_enqueue_scripts() {
		?>
		<script type="text/javascript">
			window.headerBuilderEnabledInThemeOptions = <?php echo (int) hb_is_to_active(); ?>;
		</script>
		<?php
	}

	/**
	 * Load and run HB_Grid in Front End on wp_loaded action. Front-End: init -> widgets_init -> wp_loaded.
	 *
	 * @since 5.9.5
	 * @since 5.9.8 Add conditional statement to add hb-jupiter class only if HB is active and it's
	 *              frontend page or user open Preview page.
	 * @since 6.0.0 Run additonal hooks for HB Shopping Icon. Add HB_Render initialize to render all
	 *              shortcodes based on the devices and workspaces.
	 */
	public function hb_grid() {
		if ( ! is_admin() && ( hb_is_to_active() || 'preview' === get_query_var( 'header-builder' ) ) ) {
			new MKHB_Render();
		}

	}

}

new HB_Main();
