<?php
/**
 * MasterKey file.
 *
 * @copyright   Artbees LTD (c)
 * @link        http://artbees.net
 * @since       Version 5.x
 * @package     artbees
 */

$values = get_option( THEME_OPTIONS );

if ( ! empty( $values ) ) {
	$values['theme_export_options'] = base64_encode( serialize( get_option( THEME_OPTIONS ) ) );

	/**
	 * If for any reason the Typography migrator not working as expected,
	 * create the fonts in front-end. In this situation, Theme Options
	 * needs to be saved once.
	 *
	 * @since 5.9.4
	 */
	if ( empty( $values['fonts'] ) ) {

		$values['fonts'] = array();

		$values['fonts'][] = array(
			'type' => 'all',
			'fontFamily' => ! empty( $values['font_family'] ) ? $values['font_family'] : 'Arial, Helvetica, sans-serif',
			'elements' => array( 'body' ),
			'subset' => '',
			'currentField' => 'font-alert',
			'default' => 'true',
		);

		foreach ( array( 1, 2 ) as $number ) {
			if ( ! empty( $values[ 'special_fonts_list_' . $number ] ) || ! empty( $values[ 'special_elements_' . $number ] ) ) {
				$values['fonts'][] = array(
					'type' => ! empty( $values[ 'special_fonts_type_' . $number ] ) ? $values[ 'special_fonts_type_' . $number ] : 'all',
					'fontFamily' => str_replace( '+', ' ', $values[ 'special_fonts_list_' . $number ] ),
					'elements' => ! empty( $values[ 'special_elements_' . $number ] ) ? $values[ 'special_elements_' . $number ] : array(),
					'subset' => ! empty( $values[ 'google_font_subset_' . $number ] ) ? $values[ 'google_font_subset_' . $number ] : '',
					'currentField' => 'font-select-elements',
				);
			}
		}

		foreach ( array( 1, 2 ) as $number ) {
			if ( ! empty( $values[ 'typekit_font_family_' . $number ] ) || ! empty( $values[ 'typekit_elements_' . $number ] ) ) {
				$values['fonts'][] = array(
					'type' => 'typekit',
					'fontFamily' => ! empty( $values[ 'typekit_font_family_' . $number ] ) ? $values[ 'typekit_font_family_' . $number ] : '',
					'elements' => ! empty( $values[ 'typekit_elements_' . $number ] ) ? $values[ 'typekit_elements_' . $number ] : array(),
					'subset' => '',
					'currentField' => 'font-select-elements',
				);
			}
		}
	}// End if().
}// End if().

if ( ! empty( $values['theme_import_options'] ) ) {
	$values['theme_import_options'] = '';
}

$mk_image_sizes = mk_assoc_to_pairs( mk_get_image_sizes( true ) );
array_unshift( $mk_image_sizes, array( '', __( 'Select Option', 'mk_framework' ) ) );

$mk_font_weight = array(
	'' => __( 'Select Option', 'mk_framework' ),
	'100' => __( '100', 'mk_framework' ),
	'200' => __( '200 (light)', 'mk_framework' ),
	'300' => __( '300', 'mk_framework' ),
	'400' => __( '400 (normal)', 'mk_framework' ),
	'500' => __( '500 (medium)', 'mk_framework' ),
	'600' => __( '600 (semi-bold)', 'mk_framework' ),
	'700' => __( '700 (bold)', 'mk_framework' ),
	'bolder' => __( '800 (bolder)', 'mk_framework' ),
	'900' => __( '900', 'mk_framework' ),
);

$mk_safe_fonts = array(
	'HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, "Lucida Grande", sans-serif',
	'Arial, Helvetica, sans-serif',
	'Arial Black, Gadget, sans-serif',
	'Bookman Old Style, serif',
	'Courier, monospace',
	'Courier New, Courier, monospace',
	'Garamond, serif',
	'Georgia, serif',
	'Impact, Charcoal, sans-serif',
	'Lucida Console, Monaco, monospace',
	'Lucida Grande, Lucida Sans Unicode, sans-serif',
	'MS Sans Serif, Geneva, sans-serif',
	'MS Serif, New York, sans-serif',
	'Palatino Linotype, Book Antiqua, Palatino, serif',
	'Tahoma, Geneva, sans-serif',
	'Times New Roman, Times, serif',
	'Trebuchet MS, Helvetica, sans-serif',
	'Verdana, Geneva, sans-serif',
	'Comic Sans MS, cursive',
);

$mk_all_fonts = array_merge( $mk_safe_fonts, MK_Theme_Options::get_google_fonts() );

$social_array = array(
	'px' => array( 'Px', '' ),
	'aim' => array( 'Aim', '' ),
	'amazon' => array( 'Amazon', '' ),
	'apple' => array( 'Apple', 'mk-icon-apple' ),
	'bebo' => array( 'Bebo', '' ),
	'behance' => array( 'Behance', 'mk-icon-behance' ),
	'blogger' => array( 'Blogger', 'mk-moon-blogger' ),
	'delicious' => array( 'Delicious', 'mk-icon-delicious' ),
	'deviantart' => array( 'DeviantArt', 'mk-icon-deviantart' ),
	'digg' => array( 'Digg', 'mk-icon-digg' ),
	'dribbble' => array( 'Dribble', 'mk-icon-dribbble' ),
	'dropbox' => array( 'Dropbox', 'mk-icon-dropbox' ),
	'envato' => array( 'Envato', '' ),
	'facebook' => array( 'Facebook', 'mk-icon-facebook' ),
	'flickr' => array( 'Flickr', 'mk-icon-flickr' ),
	'github' => array( 'GitHub', 'mk-icon-github' ),
	'google' => array( 'Google', 'mk-icon-google' ),
	'googleplus' => array( 'Google+', 'mk-icon-google-plus' ),
	'lastfm' => array( 'LastFM', 'mk-icon-lastfm' ),
	'linkedin' => array( 'LinkedIn', 'mk-icon-linkedin' ),
	'instagram' => array( 'Instagram', 'mk-icon-instagram' ),
	'myspace' => array( 'MySpace', '' ),
	'path' => array( 'Path', 'mk-icon-meanpath' ),
	'pinterest' => array( 'Pinterest', 'mk-icon-pinterest' ),
	'reddit' => array( 'Reddit', 'mk-icon-reddit' ),
	'rss' => array( 'RSS', 'mk-icon-rss' ),
	'skype' => array( 'Skype', 'mk-icon-skype' ),
	'stumbleupon' => array( 'StumbleUpon', 'mk-icon-stumbleupon' ),
	'tumblr' => array( 'Tumblr', 'mk-icon-tumblr' ),
	'twitter' => array( 'Twitter', 'mk-icon-twitter' ),
	'vimeo' => array( 'Vimeo', 'mk-moon-vimeo' ),
	'wordpress' => array( 'WordPress', 'mk-icon-wordpress' ),
	'yahoo' => array( 'Yahoo!', 'mk-icon-yahoo' ),
	'yelp' => array( 'Yelp', 'mk-icon-yelp' ),
	'youtube' => array( 'YouTube', 'mk-icon-youtube' ),
	'xing' => array( 'Xing', 'mk-icon-xing' ),
	'imdb' => array( 'IMDB', '' ),
	'qzone' => array( 'QZone', '' ),
	'renren' => array( 'RenRen', 'mk-icon-renren' ),
	'vk' => array( 'VK', 'mk-icon-vk' ),
	'wechat' => array( 'WeChat', 'mk-icon-wechat' ),
	'weibo' => array( 'Weibo', 'mk-icon-weibo' ),
	'whatsapp' => array( 'WhatsApp', '' ),
	'soundcloud' => array( 'SoundCloud', 'mk-icon-soundcloud' ),
);

$social_networks = array_map(
	function( $network ) {
			// Only network name provided, bail.
		if ( is_string( $network ) ) {
			return $network;
		}

			// No icon supplied, bail.
		if ( is_array( $network ) && ! isset( $network[1] ) ) {
			return $network;
		}

			// Search the icon supplied in Icon Library, and replace icon name with SVG.
			$network[1] = Mk_SVG_Icons::get_svg_icon_by_class_name( false, $network[1] );
			return $network;
	}, $social_array
);

$options = array(
	'menu'   => array(
		'general' => array(
			'label'   => __( 'Global Settings', 'mk_framework' ),
			'default' => 'site_settings',
			'submenu' => array(
				'site_settings'    => __( 'Site Settings', 'mk_framework' ),
				'logo_title'       => __( 'Logo & Title', 'mk_framework' ),
				'preloader'        => __( 'Preloader', 'mk_framework' ),
				'quick_contact'    => __( 'Quick Contact', 'mk_framework' ),
				'api_integrations' => __( 'API Integrations', 'mk_framework' ),
			),
		),
		'main_content' => array(
			'label'   => __( 'Main Content', 'mk_framework' ),
			'default' => 'layout_backgrounds',
			'submenu' => array(
				'layout_backgrounds' => __( 'Layout & Backgrounds', 'mk_framework' ),
				'texts'              => __( 'Texts', 'mk_framework' ),
			),
		),
		'header' => array(
			'label'   => __( 'Header', 'mk_framework' ),
			'default' => 'header',
			'submenu' => array(
				'header'           => __( 'Header', 'mk_framework' ),
				'mobile_header'    => __( 'Mobile Header', 'mk_framework' ),
				'sticky_header'    => __( 'Sticky Header', 'mk_framework' ),
				'side_dashboard'   => __( 'Side Dashboard', 'mk_framework' ),
				'full_screen_menu' => __( 'Full Screen Menu', 'mk_framework' ),
			),
		),
		'header_toolbar' => array(
			'label'   => __( 'Header Toolbar', 'mk_framework' ),
			'default' => 'header_toolbar',
			'submenu' => array(
				'header_toolbar' => __( 'Header Toolbar', 'mk_framework' ),
			),
		),
		'page_title' => array(
			'label'   => __( 'Page Title', 'mk_framework' ),
			'default' => 'page_title',
			'submenu' => array(
				'page_title'  => __( 'Page Title', 'mk_framework' ),
				'breadcrumbs' => __( 'Breadcrumbs', 'mk_framework' ),
			),
		),
		'elements' => array(
			'label'   => __( 'Typography', 'mk_framework' ),
			'default' => 'typography',
			'submenu' => array(
				'typography' => __( 'Typography', 'mk_framework' ),
			),
		),
		'footer' => array(
			'label'   => __( 'Footer', 'mk_framework' ),
			'default' => 'footer',
			'submenu' => array(
				'footer'     => __( 'Footer', 'mk_framework' ),
				'sub_footer' => __( 'Sub Footer', 'mk_framework' ),
			),
		),
		'sidebar' => array(
			'label'   => __( 'Sidebar', 'mk_framework' ),
			'default' => 'sidebar',
			'submenu' => array(
				'sidebar' => __( 'Sidebar', 'mk_framework' ),
			),
		),
		'search' => array(
			'label'   => __( 'Search', 'mk_framework' ),
			'default' => 'search',
			'submenu' => array(
				'search' => __( 'Search', 'mk_framework' ),
			),
		),
		'blog' => array(
			'label'   => __( 'Blog', 'mk_framework' ),
			'default' => 'blog_single_post',
			'submenu' => array(
				'blog_single_post' => __( 'Blog Single Post', 'mk_framework' ),
				'blog_meta'        => __( 'Blog Meta', 'mk_framework' ),
				'blog_archive'     => __( 'Blog Archive', 'mk_framework' ),
				'news'             => __( 'News', 'mk_framework' ),
			),
		),
		'portfolio' => array(
			'label'   => __( 'Portfolio', 'mk_framework' ),
			'default' => 'portfolio_single_post',
			'submenu' => array(
				'portfolio_single_post' => __( 'Portfolio Single Post', 'mk_framework' ),
				'portfolio_archive'     => __( 'Portfolio Archive', 'mk_framework' ),
			),
		),
		'shop' => array(
			'label'   => __( 'Shop', 'mk_framework' ),
			'default' => 'general_ecommerce',
			'submenu' => array(
				'general_ecommerce'                  => __( 'General', 'mk_framework' ),
				'ecommerce_single_product' => __( 'E-commerce Single Product', 'mk_framework' ),
			),
		),
		'advanced' => array(
			'label'   => __( 'Advanced', 'mk_framework' ),
			'default' => 'speed_optimizations',
			'submenu' => array(
				'speed_optimizations'  => __( 'Speed Optimizations', 'mk_framework' ),
				'post_types'           => __( 'Post Types', 'mk_framework' ),
				'custom_css'           => __( 'Custom CSS', 'mk_framework' ),
				'custom_js'            => __( 'Custom JS', 'mk_framework' ),
				'export_theme_options' => __( 'Export Theme Options', 'mk_framework' ),
				'import_theme_options' => __( 'Import Theme Options', 'mk_framework' ),
			),
		),
	),
	'schema' => array(
		'site_settings' => array(
			'label' => 'Site Settings',
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'type'      => 'mk-color',
							'label' => __( 'Theme Accent Color', 'mk_framework' ),
							'help' => __( 'Select the primary theme color. It affects some of the elements.', 'mk_framework' ),
							'model' => 'skin_color',
							'default' => '#f97352',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Smooth Scroll', 'mk_framework' ),
							'help' => __( 'Enable an easing scrolling effect for default browser scrolling? It affects the default mouse scrolling in whole website.', 'mk_framework' ),
							'model' => 'smoothscroll',
							'default' => 'true',
							'type'      => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Comments on Pages', 'mk_framework' ),
							'help' => __( 'Display comments section on website pages?', 'mk_framework' ),
							'model' => 'pages_comments',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Go to Top', 'mk_framework' ),
							'help' => __( 'Display Go to top button?', 'mk_framework' ),
							'model' => 'go_to_top',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => 'Images Settings',
					'fields' => array(
						array(
							'label' => __( 'Retina Images', 'mk_framework' ),
							'help' => __( 'Enable automatic generation of high quility images? The images are used for retina devices.', 'mk_framework' ),
							'model' => 'retina_images',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Responsive Images', 'mk_framework' ),
							'help' => __( 'Enable automatic generation of responsive and adaptive images? It generates different image sizes for various devices automatically.', 'mk_framework' ),
							'model' => 'responsive_images',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Image Resize Quality', 'mk_framework' ),
							'help' => __( 'Define the quality for built-in image cropping.', 'mk_framework' ),
							'model' => 'image_resize_quality',
							'default' => '100',
							'min' => '10',
							'max' => '100',
							'step' => '1',
							'unit' => '%',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'logo_title' => array(
			'label' => 'Logo & Title',
			'sections' => array(
				array(
					'label' => 'Logo',
					'fields' => array(
						array(
							'type'  => 'mk-range',
							'label' => 'Logo Margin',
							'help' => __( 'Adjust bottom spacing of logo in full screen navigation.', 'mk_framework' ),
							'model' => 'fullscreen_nav_logo_margin',
							'min' => '0',
							'max' => '250',
							'step' => '1',
							'unit' => 'px',
							'default' => '125',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Default & Dark Logo',
							'help' => __( 'Upload a default logo. Only for transparent header and dark header skin.', 'mk_framework' ),
							'model' => 'logo',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Light Logo',
							'help' => __( 'Upload a light logo. Only for transparent header and light header skin.', 'mk_framework' ),
							'model' => 'light_header_logo',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Sticky Header Logo',
							'help' => __( 'Upload a logo for sticky header.', 'mk_framework' ),
							'model' => 'sticky_header_logo',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Mobile Logo',
							'help' => __( 'Upload a logo for small devices. It is helpful when the default logo is big.', 'mk_framework' ),
							'model' => 'responsive_logo',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Sub Footer Logo',
							'help' => __( 'Upload a logo for sub footer section. The image should not exceed 150x60 pixels.', 'mk_framework' ),
							'model' => 'footer_logo',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => 'Favicon',
					'fields' => array(
						array(
							'type'  => 'mk-upload',
							'label' => 'Custom Favicon',
							'help' => sprintf(
								wp_kses(
									__( 'Upload a custom favicon. You may use <a href="%s">Generate Favicon</a> website.' , 'mk_framework' ), array(
										'a' => array(
											'href' => array(),
										),
									)
								), 'http://favicon.cc'
							),
							'model' => 'custom_favicon',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => 'Touch Device Icons',
					'fields' => array(
						array(
							'type'  => 'mk-upload',
							'label' => 'Apple IPhone Icon',
							'help' => __( 'Upload an icon for Apple iPhone (57x57 pixels).', 'mk_framework' ),
							'model' => 'iphone_icon',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Apple IPhone Retina Icon',
							'help' => __( 'Upload an icon for Apple iPhone Retina Version (114x114 pixels).', 'mk_framework' ),
							'model' => 'iphone_icon_retina',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Apple IPad Icon Upload',
							'help' => __( 'Upload an icon for Apple iPhone (72x72 pixels).', 'mk_framework' ),
							'model' => 'ipad_icon',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-upload',
							'label' => 'Apple IPad Retina Icon Upload',
							'help' => __( 'Upload an icon for Apple iPad Retina Version (144x144 pixels).', 'mk_framework' ),
							'model' => 'ipad_icon_retina',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'preloader' => array(
			'label' => 'Preloader',
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Preloader', 'mk_framework' ),
							'help' => __( 'Display the preloader by default for all pages? It can be adjusted per page/post metaboxes for a specific page.', 'mk_framework' ),
							'model' => 'preloader',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Retina Preloader', 'mk_framework' ),
							'help' => __( 'Enable retina ready preloader? Make sure to upload your logo 2x larger.', 'mk_framework' ),
							'model' => 'retina_preloader',
							'default' => 'false',
							'type' => 'mk-toggle',
							'condition' => array(
								'model' => 'preloader',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Preloader Logo', 'mk_framework' ),
							'help' => __( 'Upload preloader logo.', 'mk_framework' ),
							'model' => 'preloader_logo',
							'default' => '',
							'type' => 'mk-upload',
							'condition' => array(
								'model' => 'preloader',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Preloader Color', 'mk_framework' ),
							'help' => __( 'Select color for preloader. Leave it blank to use the default theme accent color.', 'mk_framework' ),
							'model' => 'preloader_icon_color',
							'default' => '#7c7c7c',
							'type' => 'mk-color',
							'condition' => array(
								'model' => 'preloader',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Background Color', 'mk_framework' ),
							'help' => '',
							'model' => 'preloader_bg_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'condition' => array(
								'model' => 'preloader',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Section Preloader Background Color', 'mk_framework' ),
							'help' => __( 'Select background color for Page Section and Edge Slider shortcodes when loading images.', 'mk_framework' ),
							'model' => 'section_preloader_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'condition' => array(
								'model' => 'preloader',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-visual-selector',
							'label' => 'Animation',
							'model' => 'preloader_animation',
							'default' => 'ball_pulse',
							'condition' => array(
								'model' => 'preloader',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12',
							'options' => array(
								'ball_pulse' => '<div class="visual_preloader" ><div class="ball-pulse"><div></div><div></div><div></div></div></div>',
								'ball_clip_rotate_pulse' => '<div class="visual_preloader"><div class="ball-clip-rotate-pulse"><div></div><div></div></div></div>',
								'square_spin' => '<div class="visual_preloader"><div class="square-spin"><div></div></div></div>',
								'cube_transition' => '<div class="visual_preloader"><div class="cube-transition"><div></div><div></div></div></div>',
								'ball_scale' => '<div class="visual_preloader"><div class="ball-scale"><div></div></div></div>',
								'line_scale' => '<div class="visual_preloader"><div class="line-scale"><div></div><div></div><div></div><div></div><div></div></div></div>',
								'ball_scale_multiple' => '<div class="visual_preloader"><div class="ball-scale-multiple"><div></div><div></div><div></div></div></div>',
								'ball_pulse_sync' => '<div class="visual_preloader"><div class="ball-pulse-sync"><div></div><div></div><div></div></div></div>',
								'transparent_circle' => '<div class="visual_preloader"><div class="transparent-circle"></div></div>',
								'ball_spin_fade_loader' => '<div class="visual_preloader"><div class="ball-spin-fade-loader"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>',
							),
						),
					),
				),
			),
		),
		'quick_contact' => array(
			'label' => __( 'Quick Contact', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Quick Contact', 'mk_framework' ),
							'help' => __( 'Display quick contact form?', 'mk_framework' ),
							'model' => 'disable_quick_contact',
							'default' => 'true',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Show On Blog & News / Single Post', 'mk_framework' ),
							'help' => __( 'Display quick contact form on blog and portfolio single posts?', 'mk_framework' ),
							'model' => 'quick_contact_on_single',
							'default' => 'true',
							'condition' => array(
								'model' => 'disable_quick_contact',
								'value' => 'true',
							),
							'default' => 'true',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Captcha', 'mk_framework' ),
							'help' => __( 'Display Captcha in quick contact form to keep the spam away.', 'mk_framework' ),
							'model' => 'captcha_quick_contact',
							'default' => 'true',
							'condition' => array(
								'model' => 'disable_quick_contact',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Email', 'mk_framework' ),
							'help' => __( "Enter an email for sending this form's inqueries. Admin's email will be used as default email.", 'mk_framework' ),
							'model' => 'quick_contact_email',
							'default' => get_bloginfo( 'admin_email' ),
							'condition' => array(
								'model' => 'disable_quick_contact',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Title', 'mk_framework' ),
							'help'  => __( 'Quick Contact Title' , 'mk_framework' ),
							'model' => 'quick_contact_title',
							'default' => 'Contact Us',
							'condition' => array(
								'model' => 'disable_quick_contact',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-textarea',
							'label' => __( 'Description', 'mk_framework' ),
							'model' => 'quick_contact_desc',
							'default' => 'We\'re not around right now. But you can send us an email and we\'ll get back to you, asap.',
							'condition' => array(
								'model' => 'disable_quick_contact',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'api_integrations' => array(
			'label' => __( 'API Integrations', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => __( 'Twitter Settings', 'mk_framework' ),
					'fields' => array(
						array(
							'type'  => 'mk-input',
							'label' => __( 'Consumer Key', 'mk_framework' ),
							'model' => 'twitter_consumer_key',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Consumer Secret', 'mk_framework' ),
							'model' => 'twitter_consumer_secret',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Access Token', 'mk_framework' ),
							'model' => 'twitter_access_token',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Access Token Secret', 'mk_framework' ),
							'model' => 'twitter_access_token_secret',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
					'help' => sprintf(
						wp_kses(
							__(
								'<ol style="%1$s"><li>Go to "<a target="%2$s" href="%3$s">%4$s</a>," login with your twitter account and click "Create a new application".</li><li>Fill out the required fields, accept the rules of the road, and then click on the "Create your Twitter application" button. You will not need a callback URL for this app, so feel free to leave it blank.</li><li>Once the app has been created, click the "Create my access token" button.</li><li>You are done! You will need the following data later on:</ol>' , 'mk_framework'
							),
							array(
								'a' => array(
									'href' => array(),
									'target' => array(),
								),
								'ol' => array(
									'style' => array(),
								),
								'li' => array(),
							),
							'https'
						),
						'list-style-type:decimal !important;',
						'_blank',
						'https://dev.twitter.com/apps',
						'https://dev.twitter.com/apps'
					),
				),
				array(
					'label' => __( 'MailChimp Settings', 'mk_framework' ),
					'fields' => array(
						array(
							'type'  => 'mk-input',
							'label' => __( 'MailChimp API Key', 'mk_framework' ),
							'help' => sprintf(
								wp_kses(
									__( 'Enter a <a href="%s">MailChimp API Key</a>.' , 'mk_framework' ), array(
										'a' => array(
											'href' => array(),
										),
									)
								), 'http://kb.mailchimp.com/integrations/api-integrations/about-api-keys'
							),
							'model' => 'mailchimp_api_key',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Mailchimp List ID', 'mk_framework' ),
							'help' => sprintf(
								wp_kses(
									__( 'Add your MailChimp List ID here. For more information, please read <a href="%s">Find Your List ID</a> article.' , 'mk_framework' ), array(
										'a' => array(
											'href' => array(),
										),
									)
								), 'http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id'
							),
							'model' => 'mailchimp_list_id',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Mailchimp Opt-In Email', 'mk_framework' ),
							'help' => __( 'Subscribers must receive a <strong>Please Confirm Subscription</strong> email?', 'mk_framework' ),
							'model' => 'mailchimp_optin',
							'default' => 'false',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Other Integrations', 'mk_framework' ),
					'fields' => array(
						array(
							'type'  => 'mk-input',
							'label' => __( 'Google Maps API Key', 'mk_framework' ),
							'help' => sprintf( __( 'Enter an <a target="_blank" href="%1$s">API key</a> for Google Maps.<br>1. Go to the <a target="_blank" href="%2$s">Google Developers Console</a>. <br>2. Create or select a project. <br>3. Click Continue to enable the API and any related services.<br>4. On the Credentials page, get a Browser key (and set the API Credentials).', 'mk_framework' ), 'https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true', 'https://console.developers.google.com/flows/enableapi?apiid=maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true' ),
							'model' => 'google_maps_api_key',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Google Analytics ID', 'mk_framework' ),
							'help' => __( 'Enter your Google Analytics ID here to track your site with Google Analytics. Jupiter does not support Event Tracking. To use this feature, a 3rd-party plugin is required.', 'mk_framework' ),
							'model' => 'analytics',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-input',
							'label' => __( 'Typekit Kit ID', 'mk_framework' ),
							'help' => sprintf(
								wp_kses(
									__( 'Enter a <a href="%s"> Typekit Kit ID</a> for using Typkit fonts.' , 'mk_framework' ), array(
										'a' => array(
											'href' => array(),
										),
									)
								), 'https://themes.artbees.net/docs/integrating-typekit/'
							),
							'model' => 'typekit_id',
							'default' => '',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'layout_backgrounds' => array(
			'label' => __( 'Layout & Backgrounds', 'mk_framework' ),
			'styleClasses' => 'mk-overflow',
			'sections' => array(
				array(
					'label' => __( 'Layout', 'mk_framework' ),
					'fields' => array(
						array(
							'type'  => 'mk-select-box',
							'label' => __( 'Choose Between Boxed And Full Width Layout', 'mk_framework' ),
							'help' => __( 'Choose between a full or a boxed layout to set how your website\'s layout will look like.', 'mk_framework' ),
							'model' => 'background_selector_orientation',
							'default' => 'full_width_layout',
							'options' => array(
								'boxed_layout' => __( 'Boxed', 'mk_framework' ),
								'full_width_layout' => __( 'Full Width', 'mk_framework' ),
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Main Grid Width', 'mk_framework' ),
							'help' => __( 'Define the main content max-width. Default value is 1140 pixels.', 'mk_framework' ),
							'model' => 'grid_width',
							'default' => '1140',
							'min' => '960',
							'max' => '2000',
							'step' => '1',
							'unit' => 'px',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Content Width (In Percent)', 'mk_framework' ),
							'help' => __( 'Define the width of the content. Consider that it is in percent, let\'s say if you set it 60%, sidebar will occupy 40% of the main conent space.', 'mk_framework' ),
							'model' => 'content_width',
							'default' => '73',
							'min' => '50',
							'max' => '80',
							'step' => '1',
							'unit' => '%',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Main Content Responsive State', 'mk_framework' ),
							'help' => __( 'Define when responsive state of content will be triggered. Different elements in your website such as sidebars will stack on window sizes smaller than the one you choose here.', 'mk_framework' ),
							'model' => 'content_responsive',
							'default' => '960',
							'min' => '800',
							'max' => '1140',
							'step' => '1',
							'unit' => 'px',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Main Navigation Threshold Width', 'mk_framework' ),
							'help' => __( 'Define when Main Navigation should viewed as Responsive Navigation. Default is 1140 pixels but if your Navigation items fits in header in smaller widths you can change this value. For example, if you wish to view your website in iPad and see Main Navigtion as you see in desktop, then you should change this value to any size below 1020 pixels.', 'mk_framework' ),
							'model' => 'responsive_nav_width',
							'default' => '1140',
							'min' => '600',
							'max' => '1380',
							'step' => '1',
							'unit' => 'px',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Stick Template', 'mk_framework' ),
							'help' => __( 'Enabling this option will remove padding after header and before footer for single pages.', 'mk_framework' ),
							'model' => 'stick_template_page',
							'default' => 'false',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => false,
					'id' => 'body-border-layout',
					'fields' => array(
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Body Border', 'mk_framework' ),
							'help' => __( 'When enabled, a border goes around entire browser window, stuck to the edge regardless of screen size. All edges stay in place as page scrolls.', 'mk_framework' ),
							'model' => 'body_border',
							'default' => 'false',
							'styleClasses' => 'col-sm-12 col-md-4',
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Border Thickness', 'mk_framework' ),
							'model' => 'body_border_thickness',
							'min' => '1',
							'max' => '70',
							'step' => '1',
							'unit' => 'px',
							'condition' => array(
								'model' => 'body_border',
								'value' => 'true',
							),
							'default' => '50',
							'styleClasses' => 'col-sm-12 col-md-4',
						),
						array(
							'label' => __( 'Border Color', 'mk_framework' ),
							'model' => 'body_border_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'rgba' => 'false',
							'condition' => array(
								'model' => 'body_border',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12 col-md-4 clear-none',
						),
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Body Border On Mobile Devices', 'mk_framework' ),
							'model' => 'body_border_on_mobile_devices',
							'default' => 'false',
							'condition' => array(
								'model' => 'body_border',
								'value' => 'true',
							),
							'styleClasses' => 'col-sm-12',
						),
					),
				),
				array(
					'label' => false,
					'id' => 'background-selector',
					'fields' => array(
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Expand Page Title Section To Header', 'mk_framework' ),
							'help' => __( 'Expand the page title section (background image, color) to header section?', 'mk_framework' ),
							'model' => 'page_title_expand_header',
							'default' => 'true',
							'styleClasses' => 'col-sm-12',
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Boxed Layout Outer Shadow Size', 'mk_framework' ),
							'help' => __( 'Adjust the outer shadow size for boxed layout.', 'mk_framework' ),
							'model' => 'boxed_layout_shadow_size',
							'default' => '0',
							'min' => '0',
							'max' => '60',
							'step' => '1',
							'unit' => 'px',
							'styleClasses' => 'col-sm-12 col-md-6 clear-none',
							'condition' => array(
								'model' => 'background_selector_orientation',
								'value' => 'boxed_layout',
							),
						),
						array(
							'type'  => 'mk-range',
							'label' => __( 'Boxed Layout Outer Shadow Intensity', 'mk_framework' ),
							'help' => __( 'Adjust the opacity of the outer shadow for boxed layout.', 'mk_framework' ),
							'model' => 'boxed_layout_shadow_intensity',
							'default' => '0',
							'min' => '0',
							'max' => '1',
							'step' => '0.01',
							'unit' => '%',
							'styleClasses' => 'col-sm-12 col-md-6 clear-none',
							'condition' => array(
								'model' => 'background_selector_orientation',
								'value' => 'boxed_layout',
							),
						),
						array(
							'label' => __( 'Background color & texture', 'mk_framework' ),
							'help' => __( 'Modify header, page title, body and footer background properties. Click on each section to customize it.', 'mk_framework' ),
							'model' => 'general_backgounds',
							'type' => 'mk-background-selector',
							'styleClasses' => 'col-sm-12',
						),
					),
				),
				array(
					'label' => false,
					'id' => 'background-selector-options',
					'condition' => array(
						'model' => 'general_backgounds',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'type' => 'mk-select-box',
							'label' => __( 'Background Image', 'mk_framework' ),
							'model' => 'bg_panel_image_style',
							'default' => 'no-image',
							'options' => array(
								'no-image' => __( 'No Image', 'mk_framework' ),
								'custom' => __( 'Custom', 'mk_framework' ),
							),
						),
						array(
							'type' => 'mk-upload',
							'model' => 'bg_panel_upload',
							'default' => '',
							'condition' => array(
								'model' => 'bg_panel_image_style',
								'value' => 'custom',
							),
						),
						array(
							'type' => 'mk-div',
							'styleClasses' => 'col-xs-12 mk-divider',
						),
						array(
							'type' => 'mk-select',
							'label' => __( 'Background Color', 'mk_framework' ),
							'model' => 'bg_panel_color_style',
							'default' => 'single',
							'options' => mk_assoc_to_pairs(
								array(
									'single' => __( 'Single Color', 'mk_framework' ),
									'gradient' => __( 'Gradient', 'mk_framework' ),
								)
							),
							'styleClasses' => '',
						),
						array(
							'type' => 'mk-color',
							'model' => 'bg_panel_color',
							'default' => '',
							'condition' => array(
								'model' => 'bg_panel_color_style',
								'value' => 'single',
							),
						),
						array(
							'type' => 'mk-color',
							'label' => __( 'From', 'mk_framework' ),
							'model' => 'bg_panel_color',
							'default' => '',
							'condition' => array(
								'model' => 'bg_panel_color_style',
								'value' => 'gradient',
							),
							'styleClasses' => 'col-xs-6',
						),
						array(
							'type' => 'mk-color',
							'label' => __( 'To', 'mk_framework' ),
							'model' => 'bg_panel_color_2',
							'default' => '',
							'condition' => array(
								'model' => 'bg_panel_color_style',
								'value' => 'gradient',
							),
							'styleClasses' => 'col-xs-6 clear-none',
						),
						array(
							'type' => 'mk-select',
							'label' => __( 'Style', 'mk_framework' ),
							'model' => 'grandient_color_style',
							'default' => 'linear',
							'options' => mk_assoc_to_pairs(
								array(
									'linear' => __( 'Linear', 'mk_framework' ),
									'radial' => __( 'Radial', 'mk_framework' ),
								)
							),
							'condition' => array(
								'model' => 'bg_panel_color_style',
								'value' => 'gradient',
							),
							'styleClasses' => 'col-xs-6 bg-panel-style',
						),
						array(
							'type' => 'mk-select',
							'label' => __( 'Angle', 'mk_framework' ),
							'model' => 'grandient_color_angle',
							'default' => 'vertical',
							'options' => mk_assoc_to_pairs(
								array(
									'vertical' => __( 'Vertical ↓', 'mk_framework' ),
									'horizontal' => __( 'Horizontal →', 'mk_framework' ),
									'diagonal_left_bottom' => __( 'Diagonal ↘', 'mk_framework' ),
									'diagonal_left_top' => __( 'Diagonal ↗', 'mk_framework' ),
								)
							),
							'condition' => array(
								array(
									'model' => 'bg_panel_color_style',
									'value' => 'gradient',
								),
								array(
									'model' => 'grandient_color_style',
									'value' => 'linear',
								),
							),
							'styleClasses' => 'col-xs-6 clear-none',
						),
						array(
							'type' => 'mk-div',
							'styleClasses' => 'col-xs-12 mk-divider',
						),
						array(
							'type' => 'mk-select-box',
							'label' => __( 'Background Repeat', 'mk_framework' ),
							'model' => 'bg_panel_repeat',
							'default' => '',
							'options' => array(
								'no-repeat' => '<svg xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 4 4"><defs><style>.cls-1 {fill: #fff;}</style></defs><rect class="cls-1" width="4" height="4" rx="2.5" ry="2.5"/></svg>',
								'repeat' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><defs><style>.cls-1 {fill: #222;}</style></defs><rect class="cls-1" x="6" y="6" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" x="6" y="12" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" x="6" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" x="12" y="6" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" x="12" y="12" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" x="12" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" y="6" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" y="12" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" width="4" height="4" rx="2.5" ry="2.5"/></svg>',
								'repeat-x' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="4" viewBox="0 0 16 4"><defs><style>.cls-1{fill: #222;}</style></defs><rect class="cls-1" x="6" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" x="12" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" width="4" height="4" rx="2.5" ry="2.5"/></svg>',
								'repeat-y' => '<svg xmlns="http://www.w3.org/2000/svg" width="4" height="16" viewBox="0 0 4 16"><defs><style>.cls-1 {fill: #222;}</style></defs><rect class="cls-1" y="6" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" y="12" width="4" height="4" rx="2.5" ry="2.5"/><rect class="cls-1" width="4" height="4" rx="2.5" ry="2.5"/></svg>',
							),
							'styleClasses' => 'col-xs-6 bg-panel-repeat',
						),
						array(
							'type' => 'mk-select-box',
							'label' => __( 'Background Attachment', 'mk_framework' ),
							'model' => 'bg_panel_attachment',
							'default' => '',
							'options' => array(
								'fixed' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="10px" height="12.5px" viewBox="0 0 10 12.5" style="enable-background:new 0 0 10 12.5;" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M9.5,4.5C9.5,2,7.5,0,5,0C2.5,0,0.5,2,0.5,4.5H0v8h10v-8H9.5z M5,2c1.4,0,2.5,1.1,2.5,2.5h-5C2.5,3.1,3.6,2,5,2z"/></svg>',
								'scroll' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.5px" height="12.5px" viewBox="0 0 16.5 12.5" style="enable-background:new 0 0 16.5 12.5;" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M9,4.5C9,2,7,0,4.5,0S0,2,0,4.5h2C2,3.1,3.1,2,4.5,2S7,3.1,7,4.5H6.5v8h10v-8H9z"/></svg>',
							),
							'styleClasses' => 'col-xs-6 bg-panel-attachment clear-none',
						),
						array(
							'type' => 'mk-div',
							'styleClasses' => 'col-xs-12 mk-divider',
						),
						array(
							'type' => 'mk-select-box',
							'label' => __( 'Background Position', 'mk_framework' ),
							'model' => 'bg_panel_position',
							'default' => '',
							'options' => array(
								'left top' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8;" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.7,6.3L4.1,2.7l1.8-1.8C6.2,0.6,6,0,5.5,0H0.8C0.4,0,0,0.4,0,0.8v4.7C0,6,0.6,6.2,0.9,5.9l1.8-1.8l3.6,3.6 C6.5,7.9,6.7,8,7,8s0.5-0.1,0.7-0.3C8.1,7.3,8.1,6.7,7.7,6.3z"/></svg>',
								'center top' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8;" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.8,3.6L4.6,0.2c-0.3-0.3-0.8-0.3-1.1,0L0.2,3.6c-0.3,0.3-0.1,0.9,0.4,0.9H3V7c0,0.6,0.4,1,1,1s1-0.4,1-1V4.4 h2.5C7.9,4.4,8.2,3.9,7.8,3.6z"/></svg>',
								'right top' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8; transform: rotate(90deg);" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.7,6.3L4.1,2.7l1.8-1.8C6.2,0.6,6,0,5.5,0H0.8C0.4,0,0,0.4,0,0.8v4.7C0,6,0.6,6.2,0.9,5.9l1.8-1.8l3.6,3.6 C6.5,7.9,6.7,8,7,8s0.5-0.1,0.7-0.3C8.1,7.3,8.1,6.7,7.7,6.3z"/></svg>',
								'left center' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8; transform: rotate(-90deg);" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.8,3.6L4.6,0.2c-0.3-0.3-0.8-0.3-1.1,0L0.2,3.6c-0.3,0.3-0.1,0.9,0.4,0.9H3V7c0,0.6,0.4,1,1,1s1-0.4,1-1V4.4 h2.5C7.9,4.4,8.2,3.9,7.8,3.6z"/></svg>',
								'center center' => '<svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" viewBox="0 0 6 6"><defs><style>.cls-1 {fill: #222;}</style></defs><circle id="Ellipse_2_copy_5" data-name="Ellipse 2 copy 5" class="cls-1" cx="3" cy="3" r="3"/></svg>',
								'right center' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8; transform: rotate(90deg);" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.8,3.6L4.6,0.2c-0.3-0.3-0.8-0.3-1.1,0L0.2,3.6c-0.3,0.3-0.1,0.9,0.4,0.9H3V7c0,0.6,0.4,1,1,1s1-0.4,1-1V4.4 h2.5C7.9,4.4,8.2,3.9,7.8,3.6z"/></svg>',
								'left bottom' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8; transform: rotate(-90deg);" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.7,6.3L4.1,2.7l1.8-1.8C6.2,0.6,6,0,5.5,0H0.8C0.4,0,0,0.4,0,0.8v4.7C0,6,0.6,6.2,0.9,5.9l1.8-1.8l3.6,3.6 C6.5,7.9,6.7,8,7,8s0.5-0.1,0.7-0.3C8.1,7.3,8.1,6.7,7.7,6.3z"/></svg>',
								'center bottom' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8; transform: rotate(180deg);" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.8,3.6L4.6,0.2c-0.3-0.3-0.8-0.3-1.1,0L0.2,3.6c-0.3,0.3-0.1,0.9,0.4,0.9H3V7c0,0.6,0.4,1,1,1s1-0.4,1-1V4.4 h2.5C7.9,4.4,8.2,3.9,7.8,3.6z"/></svg>',
								'right bottom' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="8px" height="8px" viewBox="0 0 8 8" style="enable-background:new 0 0 8 8; transform: rotate(180deg);" xml:space="preserve"><style type="text/css">.cls-1{fill:#231F20;}</style><path class="cls-1" d="M7.7,6.3L4.1,2.7l1.8-1.8C6.2,0.6,6,0,5.5,0H0.8C0.4,0,0,0.4,0,0.8v4.7C0,6,0.6,6.2,0.9,5.9l1.8-1.8l3.6,3.6 C6.5,7.9,6.7,8,7,8s0.5-0.1,0.7-0.3C8.1,7.3,8.1,6.7,7.7,6.3z"/></svg>',
							),
							'styleClasses' => 'col-xs-6 bg-panel-position',
						),
						array(
							'type' => 'mk-toggle',
							'label' => __( 'Cover Background', 'mk_framework' ),
							'model' => 'bg_panel_size',
							'default' => 'false',
							'styleClasses' => 'col-xs-6 bg-panel-size clear-none',
						),
					),
				),
				array(
					'label' => false,
					'condition' => array(
						'model' => 'general_backgounds',
						'value' => true,
					),
					'fields' => array(
						array(
							'model' => 'body_color',
							'default' => '#fff',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_color_gradient',
							'default' => 'single',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_color_2',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_color_gradient_style',
							'default' => 'linear',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_color_gradient_angle',
							'default' => 'vertical',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_image',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_size',
							'default' => 'false',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_position',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_attachment',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_repeat',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'body_source',
							'default' => 'no-image',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_color',
							'default' => '#fff',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_color_gradient',
							'default' => 'single',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_color_2',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_color_gradient_style',
							'default' => 'linear',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_color_gradient_angle',
							'default' => 'vertical',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_image',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_size',
							'default' => 'false',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_position',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_attachment',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_repeat',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'page_source',
							'default' => 'no-image',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_color',
							'default' => '#fff',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_color_gradient',
							'default' => 'single',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_color_2',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_color_gradient_style',
							'default' => 'linear',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_color_gradient_angle',
							'default' => 'vertical',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_image',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_size',
							'default' => 'false',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_position',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_attachment',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_repeat',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'header_source',
							'default' => 'no-image',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_color',
							'default' => '#f7f7f7',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_color_gradient',
							'default' => 'single',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_color_2',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_color_gradient_style',
							'default' => 'linear',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_color_gradient_angle',
							'default' => 'vertical',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_image',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_size',
							'default' => 'true',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_position',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_attachment',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_repeat',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'banner_source',
							'default' => 'no-image',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_color',
							'default' => '#3d4045',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_color_gradient',
							'default' => 'single',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_color_2',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_color_gradient_style',
							'default' => 'linear',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_color_gradient_angle',
							'default' => 'vertical',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_image',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_size',
							'default' => 'false',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_position',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_attachment',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_repeat',
							'default' => '',
							'type' => 'mk-input',
						),
						array(
							'model' => 'footer_source',
							'default' => 'no-image',
							'type' => 'mk-input',
						),
					),
				),
			),
		),
		'texts' => array(
			'label' => __( 'Body', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'type' => 'mk-alert',
							'label' => __( 'Font Family', 'mk_framework' ),
							'help' => __( 'Choose a set of safe font family. These font families will be used as backup font (If the below none-safe fonts failed to load for any reason) and be applied to all site elements.', 'mk_framework' ),
							'alertMessage' => __( 'This option moved to new typography settings in <strong>Theme Options > Typography</strong>.', 'mk_framework' ),
							'alertType' => 'warning',
							'alertTypeColor' => 'cccccc',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Weight', 'mk_framework' ),
							'help' => __( 'Choose default body text weight.', 'mk_framework' ),
							'model' => 'body_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Size', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'body_font_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Line Height', 'mk_framework' ),
							'help' => __( 'Adjust the blog posts text line height. Set it to 0 to use the default body text line height from <strong>General Typography</strong>.', 'mk_framework' ),
							'model' => 'body_line_height',
							'min' => '1',
							'max' => '4',
							'step' => '0.01',
							'unit' => 'em',
							'default' => '1.66',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Color', 'mk_framework' ),
							'model' => 'body_text_color',
							'default' => '#777777',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Content Links Color', 'mk_framework' ),
							'model' => 'a_color',
							'default' => '#2e2e2e',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Content Links Hover Color', 'mk_framework' ),
							'model' => 'a_color_hover',
							'default' => '#f97352',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Content Strong Tag Color', 'mk_framework' ),
							'model' => 'strong_color',
							'default' => '#f97352',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Paragraph', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Text Size', 'mk_framework' ),
							'model' => 'p_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '16',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Line Height', 'mk_framework' ),
							'help' => __( 'Adjust default paragraph text line height.', 'mk_framework' ),
							'model' => 'p_line_height',
							'min' => '1',
							'max' => '4',
							'step' => '0.01',
							'unit' => 'em',
							'default' => '1.66',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Color', 'mk_framework' ),
							'model' => 'p_color',
							'default' => '#777777',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Headings', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'H1, H2, ..., H6 Line Height', 'mk_framework' ),
							'help' => __( 'Adjust default H1, H2, H3, H4, H5, H6 line height.', 'mk_framework' ),
							'model' => 'headings_line_height',
							'min' => '1',
							'max' => '4',
							'step' => '0.01',
							'unit' => 'em',
							'default' => '1.3',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array( // It's only an empty space for proper layout.
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H1 Text Weight', 'mk_framework' ),
							'model' => 'h1_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H1 Text Case', 'mk_framework' ),
							'model' => 'h1_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H1 Text Size', 'mk_framework' ),
							'model' => 'h1_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '36',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H1 Text Color', 'mk_framework' ),
							'model' => 'h1_color',
							'default' => '#404040',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H2 Text Weight', 'mk_framework' ),
							'model' => 'h2_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H2 Text Case', 'mk_framework' ),
							'model' => 'h2_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H2 Text Size', 'mk_framework' ),
							'model' => 'h2_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '30',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H2 Text Color', 'mk_framework' ),
							'model' => 'h2_color',
							'default' => '#404040',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H3 Text Weight', 'mk_framework' ),
							'model' => 'h3_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H3 Text Case', 'mk_framework' ),
							'model' => 'h3_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H3 Text Size', 'mk_framework' ),
							'model' => 'h3_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '24',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H3 Text Color', 'mk_framework' ),
							'model' => 'h3_color',
							'default' => '#404040',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H4 Text Weight', 'mk_framework' ),
							'model' => 'h4_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H4 Text Case', 'mk_framework' ),
							'model' => 'h4_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H4 Text Size', 'mk_framework' ),
							'model' => 'h4_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '18',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H4 Text Color', 'mk_framework' ),
							'model' => 'h4_color',
							'default' => '#404040',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H5 Text Weight', 'mk_framework' ),
							'model' => 'h5_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H5 Text Case', 'mk_framework' ),
							'model' => 'h5_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H5 Text Size', 'mk_framework' ),
							'model' => 'h5_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '16',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H5 Text Color', 'mk_framework' ),
							'model' => 'h5_color',
							'default' => '#404040',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H6 Text Weight', 'mk_framework' ),
							'model' => 'h6_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H6 Text Case', 'mk_framework' ),
							'model' => 'h6_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H6 Text Size', 'mk_framework' ),
							'model' => 'h6_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'H6 Text Color', 'mk_framework' ),
							'model' => 'h6_color',
							'default' => '#404040',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'header' => array(
			'label' => __( 'Header', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'styleClasses' => 'mk-overflow',
					'fields' => array(
						array(
							'type'  => 'mk-select-box',
							'label' => __( 'Create site\'s Header by', 'mk_framework' ),
							// translators: %s: HB admin page URL.
							'help' => sprintf( __( 'Choose between Header Builder or Pre-built Header to set how your website\'s header will look like. Activating Header Builder will set Jupiter to use <a href="%s">custom headers you create from scratch</a>, instead of pre-built headers already available to the theme.', 'mk_framework' ), admin_url( 'admin.php?page=header-builder' ) ),
							'model' => 'header_layout_builder',
							'default' => 'pre_built_header',
							'options' => array(
								'header_builder' => __( 'Header Builder', 'mk_framework' ),
								'pre_built_header' => __( 'Pre-built Header', 'mk_framework' ),
							),
							'styleClasses' => 'col-sm-12 col-md-6 mka-to-hb-activation',
						),
						array(
							'type'  => 'mk-header-switcher',
							'label' => __( 'Header Styles', 'mk_framework' ),
							'locked' => array(
								'model' => 'header_layout_builder',
								'value' => 'header_builder',
							),
							'help' => __( 'Choose a header style, adjust elements alignment and toggle off/on header toolbar.', 'mk_framework' ),
							'model' => 'theme_header_style',
							'default' => '1',
							'styleClasses' => 'col-sm-12',
						),

					),
				),
				array(
					'label' => __( 'Secondary Menu Settings', 'mk_framework' ),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'condition' => array(
						'relation' => 'OR',
						array(
							'model' => 'theme_header_style',
							'value' => '1',
						),
						array(
							'model' => 'theme_header_style',
							'value' => '2',
						),
						array(
							'model' => 'theme_header_style',
							'value' => '3',
						),
					),
					'fields' => array(
						array(
							'label' => __( 'Style', 'mk_framework' ),
							'help' => __( 'Side Dashboard Style is managed from Widgets and you should add your content into Side Dashboard widget area. However the Fullscreen Menu feeds from appearance > Menus. You need build a menu and assign it to fullscreen location. All nested menu items will not be displayed in Fullscreen navigation for header style 3. Be noted that you can not completely disable secondary navigation in header style 3!', 'mk_framework' ),
							'model' => 'secondary_menu',
							'default' => 'fullscreen',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'fullscreen' => __( 'Full Screen Navigation', 'mk_framework' ),
									'dashboard' => __( 'Side Dashboard', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Burger Icon Size', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'header_burger_size',
							'default' => 'small',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'small' => __( 'Small', 'mk_framework' ),
									'big' => __( 'Big', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Show Secondary Menu for Header Style 1 & 2', 'mk_framework' ),
							'help' => __( 'Display secondary menu for header style 1 and 2?', 'mk_framework' ),
							'model' => 'seondary_header_for_all',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Vertical Header Settings', 'mk_framework' ),
					'condition' => array(
						'model' => 'theme_header_style',
						'value' => '4',
					),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Navigation Animation', 'mk_framework' ),
							'help' => __( 'Animation to show sub menu items.', 'mk_framework' ),
							'model' => 'vertical_menu_anim',
							'default' => '1',
							'options' => mk_assoc_to_pairs(
								array(
									'1' => __( 'Style 1', 'mk_framework' ),
									'2' => __( 'Style 2', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Logo Align', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'vertical_header_logo_align',
							'default' => 'center',
							'options' => mk_assoc_to_pairs(
								array(
									'left' => __( 'Left', 'mk_framework' ),
									'center' => __( 'Center', 'mk_framework' ),
									'right' => __( 'Right', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Logo Top & Bottom padding', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'vertical_header_logo_padding',
							'default' => '10',
							'min' => '0',
							'max' => '400',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Align', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'vertical_header_align',
							'default' => 'left',
							'options' => mk_assoc_to_pairs(
								array(
									'left' => __( 'Left', 'mk_framework' ),
									'center' => __( 'Center', 'mk_framework' ),
									'right' => __( 'Right', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Copyright Text', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'rows' => 2,
							'model' => 'vertical_menu_copyright',
							'default' => 'Copyright All Rights Reserved &copy; 2017',
							'type' => 'mk-textarea',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => false,
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Boxed Header', 'mk_framework' ),
							'help' => __( 'Limit the width of header and header toolbar sections to value of main grid width at <strong>Global Setting > Main Grid Width</strong>?', 'mk_framework' ),
							'model' => 'header_grid',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Display Logo', 'mk_framework' ),
							'help' => __( 'Display logo in header section?', 'mk_framework' ),
							'model' => 'hide_header_logo',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Logo in the Middle', 'mk_framework' ),
							'help' => __( 'Center the logo in the middle of main navigation items for header style 1? Make sure to have even number of navigation items on left and right.', 'mk_framework' ),
							'model' => 'logo_in_middle',
							'default' => 'false',
							'type' => 'mk-toggle',
							'condition' => array(
								'model' => 'theme_header_style',
								'value' => '1',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Show Main Navigation', 'mk_framework' ),
							'help' => __( 'Display main navigation in header section ?', 'mk_framework' ),
							'model' => 'hide_header_nav',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Search Form in Header', 'mk_framework' ),
							'help' => __( 'Choose the header search form location and style.', 'mk_framework' ),
							'model' => 'header_search_location',
							'default' => 'fullscreen_search',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'disable' => __( 'No Thanks!', 'mk_framework' ),
									'toolbar' => __( 'Header Toolbar (toolbar must be enabled)', 'mk_framework' ),
									'header' => __( 'Header Main Area (only in header style 1)', 'mk_framework' ),
									'beside_nav' => __( 'Inside Main Navigation with Tooltip', 'mk_framework' ),
									'fullscreen_search' => __( 'Inside Main Navigation With Fullscreen layer', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Start Tour Text', 'mk_framework' ),
							'help' => __( 'Enter a label for start tour link. This link will be added to the header right section in header style 1. Leave it blank to remove the link.', 'mk_framework' ),
							'model' => 'header_start_tour_text',
							'default' => '',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Start Tour URL', 'mk_framework' ),
							'help' => __( 'Enter a URL (including http://) for start tour link.', 'mk_framework' ),
							'model' => 'header_start_tour_page',
							'default' => '',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Start Tour Link Font Size', 'mk_framework' ),
							'model' => 'start_tour_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Main Navigation for Logged In User', 'mk_framework' ),
							'help' => sprintf(
								__( 'Choose which menu location to be used in this page. If left blank, Primary Menu will be used. You should first %1\$screate menu%2\$s and then %3\$s assign to menu locations%4\$s', 'mk_framework' ),
								"<a target='_blank' href='" . admin_url( 'nav-menus.php' ) . "'>",
								'</a>',
								"<a target='_blank' href='" . admin_url( 'nav-menus.php' ) . "?action=locations'>",
								'</a>'
							),
							'model' => 'loggedin_menu',
							'default' => '',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'primary-menu' => __( 'Primary Navigation', 'mk_framework' ),
									'second-menu' => __( 'Second Navigation', 'mk_framework' ),
									'third-menu' => __( 'Third Navigation', 'mk_framework' ),
									'fourth-menu' => __( 'Fourth Navigation', 'mk_framework' ),
									'fifth-menu' => __( 'Fifth Navigation', 'mk_framework' ),
									'sixth-menu' => __( 'Sixth Navigation', 'mk_framework' ),
									'seventh-menu' => __( 'Seventh Navigation', 'mk_framework' ),
									'eighth-menu' => __( 'Eighth Navigation', 'mk_framework' ),
									'ninth-menu' => __( 'Ninth Navigation', 'mk_framework' ),
									'tenth-menu' => __( 'Tenth Navigation', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Header Height', 'mk_framework' ),
							'help' => __( 'Adjust the header section height.', 'mk_framework' ),
							'model' => 'header_height',
							'default' => '90',
							'min' => '50',
							'max' => '800',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Responsive Header Height', 'mk_framework' ),
							'help' => __( 'Adjust header section height in small devices. It affects on the devices smaller than the width value of <strong>Global Settings > Main Navigation Threshold Width</strong>.', 'mk_framework' ),
							'model' => 'res_header_height',
							'default' => '90',
							'min' => '50',
							'max' => '200',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Background Opacity', 'mk_framework' ),
							'help' => __( 'Adjust the background opacity of header section.', 'mk_framework' ),
							'model' => 'header_opacity',
							'min' => '0',
							'max' => '1',
							'step' => '0.1',
							'unit' => 'opacity',
							'default' => '1',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Bottom Border Thickness', 'mk_framework' ),
							'help' => __( 'Adjust the bottom border thinkness of header section.', 'mk_framework' ),
							'model' => 'header_btn_border_thickness',
							'min' => '0',
							'max' => '10',
							'step' => '1',
							'unit' => 'px',
							'default' => '1',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Bottom Border Color', 'mk_framework' ),
							'help' => __( 'Select color for bottom border of header section. In header style 2, it changes both top and bottom border.', 'mk_framework' ),
							'model' => 'header_border_color',
							'default' => '#ededed',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Start Tour Link Color', 'mk_framework' ),
							'model' => 'start_tour_color',
							'default' => '#333',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Header Burger Icon Color', 'mk_framework' ),
							'model' => 'header_burger_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Container Background Color', 'mk_framework' ),
							'help' => __( 'Select background color for main navigation items of header style 2.', 'mk_framework' ),
							'model' => 'main_nav_bg_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Menu', 'mk_framework' ),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Header Main Navigation Hover Style', 'mk_framework' ),
							'help' => __( 'Select hover style of main navigation items. Consider that hover style 5 does not work in header style 4.', 'mk_framework' ),
							'model' => 'main_nav_hover',
							'default' => '5',
							'options' => array(
								'1' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/header-hover-1.jpg">',
								'2' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/header-hover-2.jpg">',
								'3' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/header-hover-3.jpg">',
								'4' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/header-hover-4.jpg">',
								'5' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/header-hover-5.jpg">',
							),
							'type' => 'mk-visual-selector',
							'styleClasses' => 'col-sm-12',
						),
					),
				),
				array(
					'label' => __( 'Top Level Menu', 'mk_framework' ),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Top Level Text Weight', 'mk_framework' ),
							'model' => 'main_nav_top_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Text Case', 'mk_framework' ),
							'model' => 'main_menu_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Text Size', 'mk_framework' ),
							'model' => 'main_nav_top_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '13',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Text Letter Spacing', 'mk_framework' ),
							'model' => 'main_nav_top_letter_spacing',
							'min' => '0',
							'max' => '5',
							'step' => '1',
							'unit' => 'px',
							'default' => '0',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Text Gutter Space', 'mk_framework' ),
							'help' => __( 'Adjust left and right spacing of main menu items.', 'mk_framework' ),
							'model' => 'main_nav_item_space',
							'min' => '0',
							'max' => '100',
							'step' => '1',
							'unit' => 'px',
							'default' => '20',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Text Color', 'mk_framework' ),
							'model' => 'main_nav_top_text_color',
							'default' => '#444444',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Hover & Current Skin Color', 'mk_framework' ),
							'help' => __( 'Select color for the main menu hover & current menu item hover skin color. This color will be applied to the hover style you have chosen in above option (Header Main Navigation Hover Style).', 'mk_framework' ),
							'model' => 'main_nav_top_hover_skin',
							'default' => '#f97352',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Level Hover & Current Text Color (Hover Style 3 & 4 Only)', 'mk_framework' ),
							'help' => __( 'Select color for main navigation hover style 3 current item text color and style 4 current & hover text color.', 'mk_framework' ),
							'model' => 'main_nav_top_hover_txt_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Sub Level Menu', 'mk_framework' ),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Sub Level Text Weight', 'mk_framework' ),
							'model' => 'main_nav_sub_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Text Case', 'mk_framework' ),
							'model' => 'main_nav_sub_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Text Size', 'mk_framework' ),
							'model' => 'main_nav_sub_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '12',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Text Letter Spacing', 'mk_framework' ),
							'model' => 'main_nav_sub_letter_spacing',
							'min' => '0',
							'max' => '5',
							'step' => '1',
							'unit' => 'px',
							'default' => '1',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Text Color', 'mk_framework' ),
							'model' => 'main_nav_sub_text_color',
							'default' => '#b3b3b3',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Text Hover & Current Menu Item Color', 'mk_framework' ),
							'model' => 'main_nav_sub_text_color_hover',
							'default' => '#ffffff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Hover & Current Menu Item Background Color', 'mk_framework' ),
							'model' => 'main_nav_sub_hover_bg_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Box Border Top Color', 'mk_framework' ),
							'help' => __( 'Clear the color, if you want to hide the border.', 'mk_framework' ),
							'model' => 'main_nav_sub_border_top_color',
							'default' => '#f97352',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Background Color', 'mk_framework' ),
							'model' => 'main_nav_sub_bg_color',
							'default' => '#333333',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Icon Color', 'mk_framework' ),
							'model' => 'main_nav_sub_icon_color',
							'default' => '#e0e0e0',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Box Shadow', 'mk_framework' ),
							'help' => __( 'Display shadow for menu sub level boxes.', 'mk_framework' ),
							'model' => 'nav_sub_shadow',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Box Border Color', 'mk_framework' ),
							'model' => 'sub_level_box_border_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sub Level Box Width', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'main_nav_sub_width',
							'min' => '100',
							'max' => '500',
							'step' => '1',
							'unit' => 'px',
							'default' => '230',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Mega Menu title color ', 'mk_framework' ),
							'model' => 'main_nav_mega_title_color',
							'default' => '#ffffff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Mega Menu column Vertical Divders Color', 'mk_framework' ),
							'help' => __( 'Select mega menu vertical dividers color. Clear the color to hide the dividers.', 'mk_framework' ),
							'model' => 'mega_menu_divider_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Social Network', 'mk_framework' ),
					'locked' => array(
						'model' => 'header_layout_builder',
						'value' => 'header_builder',
					),
					'fields' => array(
						array(
							'label' => __( 'Header Social Networks Location', 'mk_framework' ),
							'help' => __( 'Select the location of the social network icons. Select Disable option to disable them.', 'mk_framework' ),
							'model' => 'header_social_location',
							'default' => '',
							'options' => mk_assoc_to_pairs(
								array(
								'' => __( 'Select Option', 'mk_framework' ),
								'toolbar' => __( 'Header Toolbar', 'mk_framework' ),
								'header' => __( 'Header Section', 'mk_framework' ),
								'disable' => __( 'Disable', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12',
						),
						// Start: temporary fix for list-control sharing 2 models on the same repeater field.
						// Declare them here to prevent PHP errors on TO reset.
						array(
							'type' => 'input',
							'inputType' => 'hidden',
							'default' => '',
							'model' => 'header_social_networks_site',
							'label' => '',
							'styleClasses' => 'hide',
						),
						array(
							'type' => 'input',
							'inputType' => 'hidden',
							'default' => '',
							'label' => '',
							'model' => 'header_social_networks_url',
							'styleClasses' => 'hide',
						), // End: temporary fix.
						array(
							'type'  => 'mk-list-control',
							'label' => __( 'Social network', 'mk_framework' ),
							'help' => __( 'Select your social website and enter the full URL to your profile on the site, then click on add new button. then hit save settings.', 'mk_framework' ),
							'model' => array(
								'select' => 'header_social_networks_site',
								'input' => 'header_social_networks_url',
							),
							'options' => $social_networks,
							'selectOptions' => array(
								'label' => 'Network Name',
								'noneSelectedText' => 'Select network',
							),
							'inputOptions' => array(
								'label' => 'URL',
								'placeholder' => '',
							),
							'repeaterOptions' => array(
								'label' => 'Add a New Network',
							),
							'default' => '',
							'condition' => array(
								'relation' => 'OR',
								array(
									'model' => 'header_social_location',
									'value' => 'header',
								),
								array(
									'model' => 'header_social_location',
									'value' => 'toolbar',
								),
							),
							'styleClasses' => 'col-sm-12',
						),
						array(
							'label' => __( 'Header Social Media Icons Style', 'mk_framework' ),
							'help' => __( 'Do not use Simple Rounded, Square Pointed & Square Rounded styles within Header Toolbar.', 'mk_framework' ),
							'model' => 'header_social_networks_style',
							'default' => 'circle',
							'options' => mk_assoc_to_pairs(
								array(
								'' => __( 'Select Option', 'mk_framework' ),
								'circle' => __( 'Circled', 'mk_framework' ),
								'rounded' => __( 'Rounded', 'mk_framework' ),
								'simple' => __( 'Simple', 'mk_framework' ),
								'simple-rounded' => __( 'Simple Rounded', 'mk_framework' ),
								'square-pointed' => __( 'Square Pointed', 'mk_framework' ),
								'square-rounded' => __( 'Square Rounded', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'condition' => array(
								'relation' => 'OR',
								array(
									'model' => 'header_social_location',
									'value' => 'header',
								),
								array(
									'model' => 'header_social_location',
									'value' => 'toolbar',
								),
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Social Media Icon Size', 'mk_framework' ),
							'help' => __( 'Icon size will be used for outline styles: Simple Rounded, Square Pointed & Square Rounded.', 'mk_framework' ),
							'type' => 'mk-select',
							'model' => 'header_icon_size',
							'default' => 'small',
							'options' => mk_assoc_to_pairs(
								array(
								'small' => 'Small',
								'medium' => 'Medium',
								'large' => 'Large',
								)
							),
							'condition' => array(
								   'model' => 'header_social_location',
								   'value' => 'header',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Icon Color', 'mk_framework' ),
							'model' => 'header_social_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Icon Hover Color', 'mk_framework' ),
							'model' => 'header_social_hover_color',
							'default' => '#ccc',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Background Color', 'mk_framework' ),
							'model' => 'header_social_bg_main_color',
							'default' => '#232323',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Background Hover Color', 'mk_framework' ),
							'model' => 'header_social_bg_color',
							'default' => '#232323',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Border Color', 'mk_framework' ),
							'model' => 'header_social_border_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'mobile_header' => array(
			'label' => __( 'Mobile Header', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Header Background Color', 'mk_framework' ),
							'model' => 'header_mobile_bg',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Navigation Background Color', 'mk_framework' ),
							'model' => 'responsive_nav_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Search Form Input Background Color', 'mk_framework' ),
							'model' => 'header_mobile_search_input_bg',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Search Form Input Text Color', 'mk_framework' ),
							'model' => 'header_mobile_search_input_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Menu Text', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Menu Text Color', 'mk_framework' ),
							'model' => 'responsive_nav_txt_color',
							'default' => '#444444',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'sticky_header' => array(
			'label' => __( 'Sticky Header', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Sticky header behavior', 'mk_framework' ),
							'help' => __( 'Define how you would like the header transforms from normal to sticky state. If <strong>Slide Down</strong> is selected, then you can choose the offset location where the sticky header will be revealed while scrolling down (Check option below).', 'mk_framework' ),
							'model' => 'header_sticky_style',
							'default' => 'fixed',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'false' => __( 'Disable Sticky Header', 'mk_framework' ),
									'fixed' => __( 'Fixed Sticky', 'mk_framework' ),
									'slide' => __( 'Slide Down', 'mk_framework' ),
									'lazy' => __( 'Lazy', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Offset', 'mk_framework' ),
							'help' => __( 'Define when the sticky state of header should trigger. This option does not apply to header style 2.', 'mk_framework' ),
							'model' => 'sticky_header_offset',
							'default' => 'header',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'header' => __( 'Header height', 'mk_framework' ),
									'25%' => __( '25% Of Viewport', 'mk_framework' ),
									'30%' => __( '30% Of Viewport', 'mk_framework' ),
									'40%' => __( '40% Of Viewport', 'mk_framework' ),
									'50%' => __( '50% Of Viewport', 'mk_framework' ),
									'60%' => __( '60% Of Viewport', 'mk_framework' ),
									'70%' => __( '70% Of Viewport', 'mk_framework' ),
									'80%' => __( '80% Of Viewport', 'mk_framework' ),
									'90%' => __( '90% Of Viewport', 'mk_framework' ),
									'100%' => __( '100% Of Viewport', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Height', 'mk_framework' ),
							'help' => __( 'Adjust sticky header section height.', 'mk_framework' ),
							'model' => 'header_scroll_height',
							'default' => '55',
							'min' => '20',
							'max' => '400',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Background Opacity', 'mk_framework' ),
							'help' => __( 'Adjust the background opacity of sticky header section. Sticky header will be fixed to the top of window after scrolling.', 'mk_framework' ),
							'model' => 'header_sticky_opacity',
							'min' => '0',
							'max' => '1',
							'step' => '0.1',
							'unit' => 'opacity',
							'default' => '1',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Bottom Border Color', 'mk_framework' ),
							'help' => __( 'Select color for bottom border of sticky header section. If left blank above option will used instead.', 'mk_framework' ),
							'model' => 'sticky_header_border_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'side_dashboard' => array(
			'label' => __( 'Side Dashboard', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Background Color', 'mk_framework' ),
							'model' => 'dash_bg_color',
							'default' => '#444',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'fields' => array(
						array(
							'label'    => __( 'Top Menu Text Weight', 'mk_framework' ),
							'model'      => 'dash_top_menu_text_weight',
							'default' => 600,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label'    => __( 'Top Menu Text Case', 'mk_framework' ),
							'model'      => 'dash_top_menu_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none'       => __( 'None',       'mk_framework' ),
									'uppercase'  => __( 'Uppercase',  'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase'  => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type'    => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label'    => __( 'Top Menu Text Size', 'mk_framework' ),
							'model'      => 'dash_top_menu_text_size',
							'min'     => '10',
							'max'     => '50',
							'step'    => '1',
							'unit'    => 'px',
							'default' => '13',
							'type'    => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Navigation Links Color', 'mk_framework' ),
							'model' => 'dash_nav_link_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Navigation Hover Color', 'mk_framework' ),
							'model' => 'dash_nav_link_hover_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Navigation Hover Background Color', 'mk_framework' ),
							'model' => 'dash_nav_bg_hover_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label'    => __( 'Sub Menu Items Text Weight', 'mk_framework' ),
							'model'      => 'dash_sub_menu_text_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label'    => __( 'Sub Menu Items Text Case', 'mk_framework' ),
							'model'      => 'dash_sub_menu_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none'       => __( 'None',       'mk_framework' ),
									'uppercase'  => __( 'Uppercase',  'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase'  => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type'    => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label'    => __( 'Sub Menu Texts Size', 'mk_framework' ),
							'model'      => 'dash_sub_menu_text_size',
							'min'     => '10',
							'max'     => '50',
							'step'    => '1',
							'unit'    => 'px',
							'default' => '12',
							'type'    => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Weight', 'mk_framework' ),
							'model' => 'dash_title_weight',
							'default' => 'bolder',
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Case', 'mk_framework' ),
							'model' => 'dash_title_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Size', 'mk_framework' ),
							'model' => 'dash_title_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Widget Title Color', 'mk_framework' ),
							'model' => 'dash_title_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),

						array(
							'label' => __( 'Text Weight', 'mk_framework' ),
							'model' => 'dash_text_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Size', 'mk_framework' ),
							'model' => 'dash_text_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '12',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Widget Text Color', 'mk_framework' ),
							'model' => 'dash_text_color',
							'default' => '#eee',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Widget Links Color', 'mk_framework' ),
							'model' => 'dash_links_color',
							'default' => '#fafafa',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Widget Links Hover Color', 'mk_framework' ),
							'model' => 'dash_links_hover_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'full_screen_menu' => array(
			'label' => __( 'Full Screen Menu', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Logo', 'mk_framework' ),
							'model' => 'fullscreen_nav_logo',
							'default' => 'dark',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'light' => __( 'Light', 'mk_framework' ),
									'dark' => __( 'Dark', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Mobile Logo', 'mk_framework' ),
							'model' => 'fullscreen_nav_mobile_logo',
							'default' => 'dark',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'dark' => __( 'Dark', 'mk_framework' ),
									'light' => __( 'Light', 'mk_framework' ),
									'custom' => __( 'Custom', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Custom logo for Full screen menu on mobile screens ', 'mk_framework' ),
							'help' => __( 'Upload a custom logo for full screen menu only when it is opened on Mobile devices (small screens). Notice that this responsive logo is different from site\'s general \'Mobile version logo\' which affect the site\'s header logo.', 'mk_framework' ),
							'model' => 'fullscreen_nav_mobile_logo_custom',
							'default' => '',
							'type' => 'mk-upload',
							'condition' => array(
								'model' => 'fullscreen_nav_mobile_logo',
								'value' => 'custom',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Background Color', 'mk_framework' ),
							'model' => 'fullscreen_nav_bg_color',
							'default' => '#444',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Close Button Color', 'mk_framework' ),
							'model' => 'fullscreen_close_btn_skin',
							'default' => 'light',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'light' => __( 'Light', 'mk_framework' ),
									'dark' => __( 'Dark', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Menu Text', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Text Weight', 'mk_framework' ),
							'model' => 'fullscreen_nav_menu_font_weight',
							'default' => 'bolder',
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Case', 'mk_framework' ),
							'model' => 'fullscreen_nav_menu_text_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Size', 'mk_framework' ),
							'model' => 'fullscreen_nav_menu_font_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '16',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Letter Spacing', 'mk_framework' ),
							'model' => 'fullscreen_nav_menu_letter_spacing',
							'min' => '0',
							'max' => '10',
							'step' => '1',
							'unit' => 'px',
							'default' => '0',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Item Gutter Spacing', 'mk_framework' ),
							'help' => __( 'Adjust top and bottom spacing of menu items in full screen navigation.', 'mk_framework' ),
							'model' => 'fullscreen_nav_menu_gutter',
							'min' => '0',
							'max' => '100',
							'step' => '1',
							'unit' => 'px',
							'default' => '25',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Color', 'mk_framework' ),
							'model' => 'fullscreen_nav_link_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Hover Color', 'mk_framework' ),
							'model' => 'fullscreen_nav_link_hov_color',
							'default' => '#444',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Hover Background Color', 'mk_framework' ),
							'model' => 'fullscreen_nav_link_hov_bg_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'header_toolbar' => array(
			'label' => __( 'Header Toolbar', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Date', 'mk_framework' ),
							'help' => __( 'Display today\'s date in header toolbar section. Make sure your hosting server date configurations works as expected otherwise you might need to fix in hosting settings.', 'mk_framework' ),
							'model' => 'enable_header_date',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Tagline', 'mk_framework' ),
							'help' => __( 'Enter your site slogan or an important message.', 'mk_framework' ),
							'model' => 'header_toolbar_tagline',
							'default' => '',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Login Form', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'header_toolbar_login',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Mailchimp Subscribe Form', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'header_toolbar_subscribe',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Email Address', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'header_toolbar_email',
							'default' => '',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Phone Number', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'header_toolbar_phone',
							'default' => '',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Toolbar Background Color', 'mk_framework' ),
							'model' => 'header_toolbar_bg',
							'default' => '#ffffff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Toolbar Mobile Background Color', 'mk_framework' ),
							'model' => 'header_mobile_toolbar_bg',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Border Bottom Color', 'mk_framework' ),
							'model' => 'header_toolbar_border_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Search Form Input Background Color', 'mk_framework' ),
							'model' => 'header_toolbar_search_input_bg',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Toolbar Text Color', 'mk_framework' ),
							'model' => 'header_toolbar_txt_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Toolbar Link Color', 'mk_framework' ),
							'model' => 'header_toolbar_link_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Search Form Input Text Color', 'mk_framework' ),
							'model' => 'header_toolbar_search_input_txt',
							'default' => '#c7c7c7',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Toolbar Mobile Text Color', 'mk_framework' ),
							'model' => 'header_mobile_toolbar_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Toolbar Mobile Link Color', 'mk_framework' ),
							'model' => 'header_mobile_toolbar_link_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Social Networks', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Icon Color', 'mk_framework' ),
							'model' => 'header_toolbar_social_network_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Toolbar Social Icon Color', 'mk_framework' ),
							'model' => 'header_mobile_toolbar_social_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'page_title' => array(
			'label' => __( 'Page Title', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Display Page Title', 'mk_framework' ),
							'help' => __( 'Display the page title?', 'mk_framework' ),
							'model' => 'page_title_global',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'condition' => array(
						'model' => 'page_title_global',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Border Bottom Color', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'banner_border_color',
							'default' => '#ededed',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'condition' => array(
						'model' => 'page_title_global',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Page Title Text Weight', 'mk_framework' ),
							'model' => 'page_introduce_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Title Text Case', 'mk_framework' ),
							'model' => 'page_title_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Title Text Size', 'mk_framework' ),
							'model' => 'page_introduce_title_size',
							'min' => '10',
							'max' => '120',
							'step' => '1',
							'unit' => 'px',
							'default' => '20',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Title Letter Spacing', 'mk_framework' ),
							'model' => 'page_introduce_title_letter_spacing',
							'min' => '0',
							'max' => '10',
							'step' => '1',
							'unit' => 'px',
							'default' => '2',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Title Text Color', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'page_title_color',
							'default' => '#4d4d4d',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Shadow for Title', 'mk_framework' ),
							'help' => __( 'If you enable this option 1px gray shadow will appear in page title.', 'mk_framework' ),
							'model' => 'page_title_shadow',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Page Subtitle', 'mk_framework' ),
					'condition' => array(
						'model' => 'page_title_global',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Page Subtitle Text Size', 'mk_framework' ),
							'model' => 'page_introduce_subtitle_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Subtitle Text Case', 'mk_framework' ),
							'model' => 'page_introduce_subtitle_transform',
							'default' => 'none',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Subtitle Text Color', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'page_subtitle_color',
							'default' => '#a3a3a3',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'breadcrumbs' => array(
			'label' => __( 'Breadcrumbs', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Display Breadcrumbs', 'mk_framework' ),
							'help' => __( 'You can disable breadcrumb navigation globally using this option, or you may need to disable it in a page locally.', 'mk_framework' ),
							'model' => 'disable_breadcrumb',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'condition' => array(
						'model' => 'disable_breadcrumb',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Text Skin', 'mk_framework' ),
							'model' => 'breadcrumb_skin',
							'default' => 'dark',
							'options' => array(
								'light' => __( 'For Light Background', 'mk_framework' ),
								'dark' => __( 'For Dark Background', 'mk_framework' ),
							),
							'type' => 'mk-select-box',
							'styleClasses' => 'col-md-12',
						),
					),
				),
			),
		),
		'typography' => array(
			'label' => __( 'Typography', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'type'          => 'mk-fonts',
							'model'         => 'fonts',
							'default'       => array(
								array(
									'type' => 'safe',
									'fontFamily' => 'Arial, Helvetica, sans-serif',
									'elements' => array( 'body' ),
									'subset' => '',
									'currentField' => 'font-alert',
									'default' => 'true',
								),
							),
							'alert' => __( 'Since this is your default/fallback font family, all elements - except the ones you assigned to other font families - will use this font family by default. It\'s best to use one of the <strong>safe fonts</strong> for this font set.', 'mk_framework' ),
							'fontFamilies' => array(
								'all' => $mk_all_fonts,
								'google' => MK_Theme_Options::get_google_fonts(),
								'typekit' => array(),
								'safe' => $mk_safe_fonts,
							),
							'fontTypes' => array(
								'all' => __( 'All', 'mk_framework' ),
								'google' => __( 'Google Fonts', 'mk_framework' ),
								'typekit' => __( 'Typekit', 'mk_framework' ),
								'safe' => __( 'Safe Fonts', 'mk_framework' ),
							),
							'subsets' => array(
								'' => __( 'Select Option', 'mk_framework' ),
								'latin' => 'latin',
								'latin-ext' => 'latin-ext',
								'cyrillic-ext' => 'cyrillic-ext',
								'greek-ext' => 'greek-ext',
								'greek' => 'greek',
								'vietnamese' => 'vietnamese',
								'cyrillic' => 'cyrillic',
							),
							'elements' => array(
								'body' => __( 'Body', 'mk_framework' ),
								'h1' => __( 'Heading 1', 'mk_framework' ),
								'h2' => __( 'Heading 2', 'mk_framework' ),
								'h3' => __( 'Heading 3', 'mk_framework' ),
								'h4' => __( 'Heading 4', 'mk_framework' ),
								'h5' => __( 'Heading 5', 'mk_framework' ),
								'h6' => __( 'Heading 6', 'mk_framework' ),
								'p:not(.form-row):not(.woocommerce-mini-cart__empty-message):not(.woocommerce-mini-cart__total):not(.woocommerce-mini-cart__buttons), .woocommerce-customer-details address' => __( 'Paragraphs', 'mk_framework' ),
								'a' => __( 'Links', 'mk_framework' ),
								'textarea,input,select,button' => __( 'Form Elements', 'mk_framework' ),
								'#mk-page-introduce' => __( 'Global Page Title', 'mk_framework' ),
								'.the-title' => __( 'Blog & Portfolio Titles', 'mk_framework' ),
								'.mk-edge-title, .edge-title' => __( 'Edge Slider Title', 'mk_framework' ),
								'.mk-edge-desc, .edge-desc' => __( 'Edge Slider Description', 'mk_framework' ),
								'.main-navigation-ul, .mk-vm-menuwrapper' => __( 'Main Navigation Links', 'mk_framework' ),
								'#mk-footer-navigation ul li a' => __( 'Footer Navigation', 'mk_framework' ),
								'.vm-header-copyright' => __( 'Vertical Header Copyright Text', 'mk_framework' ),
								'.mk-footer-copyright' => __( 'Footer Copyright', 'mk_framework' ),
								'.mk-content-box' => __( 'Content Box Shortcode', 'mk_framework' ),
								'.filter-portfolio a' => __( 'Portfolio Filter Links', 'mk_framework' ),
								'.mk-button' => __( 'Buttons Shortcode', 'mk_framework' ),
								'.mk-blockquote' => __( 'Blockquote Shortcode', 'mk_framework' ),
								'.mk-pricing-table .mk-offer-title, .mk-pricing-table .mk-pricing-plan, .mk-pricing-table .mk-pricing-price' => __( 'Pricing Table Headings', 'mk_framework' ),
								'.mk-tabs-tabs a' => __( 'Tabs Shortcode', 'mk_framework' ),
								'.mk-accordion-tab' => __( 'Accordion Shortcode', 'mk_framework' ),
								'.mk-toggle-title' => __( 'Toggle Shortcode', 'mk_framework' ),
								'.mk-dropcaps' => __( 'Dropcaps Shortcode', 'mk_framework' ),
								'.price' => __( 'Woocommerce Price Amount', 'mk_framework' ),
								'.mk-imagebox' => __( 'Image Box Shortcode', 'mk_framework' ),
								'.mk-event-countdown' => __( 'Event Countdown Shortcode', 'mk_framework' ),
								'.mk-fancy-title' => __( 'Fancy Title Shortcode', 'mk_framework' ),
								'.mk-button-gradient' => __( 'Gradient Buttons Shortcode', 'mk_framework' ),
								'.mk-iconBox-gradient' => __( 'Gradient Icon Box Shortcode', 'mk_framework' ),
								'.mk-custom-box' => __( 'Custom Box Shortcode', 'mk_framework' ),
								'.mk-ornamental-title' => __( 'Ornamental Title Shortcode', 'mk_framework' ),
								'.mk-subscribe' => __( 'Subscribe Shortcode', 'mk_framework' ),
								'.mk-timeline' => __( 'Timeline Shortcode', 'mk_framework' ),
								'.mk-blog-container .mk-blog-meta .the-title, .post .blog-single-title, .mk-blog-hero .content-holder .the-title, .blog-blockquote-content, .blog-twitter-content' => __( 'Blog Post Headings', 'mk_framework' ),
								'.mk-blog-container .mk-blog-meta .the-excerpt p, .mk-single-content p' => __( 'Blog Post Body', 'mk_framework' ),
								'.mk-employees .mk-employee-item .team-info-wrapper .team-member-name' => __( 'Employee Shortcode Title', 'mk_framework' ),
								'.mk-testimonial-quote' => __( 'Testimonial Shortcode Quote', 'mk_framework' ),
								'.mk-contact-form, .mk-contact-form input,.mk-contact-form button' => __( 'Contact Form Shortcode & Widget', 'mk_framework' ),
								'.mk-box-icon .icon-box-title' => __( 'Icon Box Shortcode Title', 'mk_framework' ),
							),
							'placeholder' => __( 'Type to select a font family', 'mk_framework' ),
							'styleClasses'  => 'col-sm-12',
						),
					),
				),
			),
		),
		'footer' => array(
			'label' => __( 'Footer', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Display Footer', 'mk_framework' ),
							'help' => __( 'Display footer section?', 'mk_framework' ),
							'model' => 'disable_footer',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Hide on Mobile', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'footer_disable_mobile',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
							'condition' => array(
								'model' => 'disable_footer',
								'value' => 'true',
							),
						),
						array(
							'label' => __( 'Boxed', 'mk_framework' ),
							'help' => __( 'Enable boxed footer? The footer content will be in main grid (the width is defined in theme general settings), otherwise it will be fullwdith screen wide.', 'mk_framework' ),
							'model' => 'boxed_footer',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
							'condition' => array(
								'model' => 'disable_footer',
								'value' => 'true',
							),
						),
						array(
							'label' => __( 'Footer Type', 'mk_framework' ),
							'help' => __( 'Choose a footer type. Fixed footer should not be used in boxed layout.', 'mk_framework' ),
							'model' => 'footer_type',
							'default' => '1',
							'options' => array(
								'1' => __( 'Regular', 'mk_framework' ),
								'2' => __( 'Fixed', 'mk_framework' ),
							),
							'type' => 'mk-select-box',
							'styleClasses' => 'col-sm-12 col-md-6',
							'condition' => array(
								'model' => 'disable_footer',
								'value' => 'true',
							),
						),
					),
				),
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'condition' => array(
						'model' => 'disable_footer',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Column Layout', 'mk_framework' ),
							'model' => 'footer_columns',
							'default' => '4',
							'options' => array(
								'1' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_1.png">',
								'2' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_2.png">',
								'3' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_3.png">',
								'4' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_4.png">',
								'5' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_5.png">',
								'6' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_6.png">',
								'half_sub_half' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_half_sub_half.png">',
								'half_sub_third' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_half_sub_third.png">',
								'third_sub_third' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_third_sub_third.png">',
								'third_sub_fourth' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_third_sub_fourth.png">',
								'sub_half_half' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_sub_half_half.png">',
								'sub_third_half' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_sub_third_half.png">',
								'sub_third_third' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_sub_third_third.png">',
								'sub_fourth_third' => '<img src="' . THEME_ADMIN_ASSETS_URI . '/images/column_sub_fourth_third.png">',
							),
							'type' => 'mk-visual-selector',
							'styleClasses' => 'col-sm-12',
						),
						array(
							'label' => __( 'Top Border Thickness', 'mk_framework' ),
							'model' => 'footer_top_thickness',
							'min' => '0',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '0',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Top Border Color', 'mk_framework' ),
							'model' => 'footer_top_border_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Column Gutter Space', 'mk_framework' ),
							'help' => __( 'Adjust spacing between columns.', 'mk_framework' ),
							'model' => 'footer_gutter',
							'default' => '2',
							'min' => '0',
							'max' => '15',
							'step' => '1',
							'unit' => '%',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Padding Bottom/Top', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'footer_wrapper_padding',
							'default' => '30',
							'min' => '0',
							'max' => '250',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Widget Margin Bottom', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'footer_widget_margin_bottom',
							'default' => '40',
							'min' => '0',
							'max' => '200',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'condition' => array(
						'model' => 'disable_footer',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Title Text Weight', 'mk_framework' ),
							'model' => 'footer_title_weight',
							'default' => 'bolder',
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Case', 'mk_framework' ),
							'model' => 'footer_title_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Size', 'mk_framework' ),
							'model' => 'footer_title_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Color', 'mk_framework' ),
							'model' => 'footer_title_color',
							'default' => '#fff',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Weight', 'mk_framework' ),
							'model' => 'footer_text_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Size', 'mk_framework' ),
							'model' => 'footer_text_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Color', 'mk_framework' ),
							'model' => 'footer_text_color',
							'default' => '#808080',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Footer Links Color', 'mk_framework' ),
							'model' => 'footer_links_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Footer Links Hover Color', 'mk_framework' ),
							'model' => 'footer_links_hover_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'sub_footer' => array(
			'label' => __( 'Sub Footer', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Display Sub Footer', 'mk_framework' ),
							'help' => __( 'Display a sub footer section at the bottom of footer?', 'mk_framework' ),
							'model' => 'disable_sub_footer',
							'default' => 'true',
							'styleClasses' => 'col-sm-12 col-md-6',
							'type' => 'mk-toggle',
						),
						array(
							'label' => __( 'Sub Footer Navigation', 'mk_framework' ),
							'help' => __( 'Display a custom navigation on the left section of sub footer?', 'mk_framework' ),
							'model' => 'enable_footer_nav',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
							'condition' => array(
								'model' => 'disable_sub_footer',
								'value' => 'true',
							),
						),
						array(
							'label' => __( 'Sub Footer Copyright Text', 'mk_framework' ),
							'help' => '',
							'model' => 'copyright',
							'default' => 'Copyright All Rights Reserved &copy; 2017',
							'type' => 'mk-textarea',
							'styleClasses' => 'col-sm-12 col-md-6',
							'condition' => array(
								'model' => 'disable_sub_footer',
								'value' => 'true',
							),
						),
					),
				),
				array(
					'label' => __( 'Container', 'mk_framework' ),
					'condition' => array(
						'model' => 'disable_sub_footer',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Background Color', 'mk_framework' ),
							'model' => 'sub_footer_bg_color',
							'default' => '#43474d',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'condition' => array(
						'model' => 'disable_sub_footer',
						'value' => 'true',
					),
					'fields' => array(
						array(
							'label' => __( 'Copyright Font Size', 'mk_framework' ),
							'model' => 'copyright_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '11',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Copyright Letter Spacing', 'mk_framework' ),
							'model' => 'copyright_letter_spacing',
							'min' => '0',
							'max' => '10',
							'step' => '1',
							'unit' => 'px',
							'default' => '1',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Copyright Text Color', 'mk_framework' ),
							'model' => 'sub_footer_nav_copy_color',
							'default' => '#8c8e91',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'sidebar' => array(
			'label' => __( 'Sidebar', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'type'  => 'mk-list-control',
							'label' => __( 'Current sidebars', 'mk_framework' ),
							'help' => __( 'Enter a name for new sidebar. It must be a valid name which starts with a letter, followed by letters, numbers, spaces, or underscores', 'mk_framework' ),
							'model' => array(
								'select' => '',
								'input' => 'sidebars',
							),
							'options' => array(),
							'selectOptions' => array(),
							'inputOptions' => array(
								'label' => 'Create New Sidebar',
								'placeholder' => '',
							),
							'repeaterOptions' => array(
								'label' => 'Add a New Sidebar',
							),
							'default' => '',
							'styleClasses' => 'col-sm-12',
						),
						array(
							'label' => __( 'Activate Sidebars For Custom Post Types', 'mk_framework' ),
							'help' => __( 'Select post types you would like assigning custom sidebars for their single page. You can use this option to choose a custom sidebar for your third party plugin post types.', 'mk_framework' ),
							'model' => 'custom_sidebars',
							'default' => '',
							'options' => MK_Theme_Options::get_post_types(),
							'type' => 'mk-select-multi',
							'styleClasses' => 'col-sm-12',
						),
					),
				),
				array(
					'label' => __( 'Text', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Title Text Weight', 'mk_framework' ),
							'model' => 'sidebar_title_weight',
							'default' => 'bolder',
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Case', 'mk_framework' ),
							'model' => 'sidebar_title_transform',
							'default' => 'uppercase',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Size', 'mk_framework' ),
							'model' => 'sidebar_title_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Title Text Color', 'mk_framework' ),
							'model' => 'sidebar_title_color',
							'default' => '#333333',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Weight', 'mk_framework' ),
							'model' => 'sidebar_text_weight',
							'default' => 400,
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Size', 'mk_framework' ),
							'model' => 'sidebar_text_size',
							'min' => '10',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '14',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Text Color', 'mk_framework' ),
							'model' => 'sidebar_text_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sidebar Links Color', 'mk_framework' ),
							'model' => 'sidebar_links_color',
							'default' => '#999999',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Sidebar Links Hover Color', 'mk_framework' ),
							'model' => 'sidebar_links_hover_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'search' => array(
			'label' => __( 'Search', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Layout', 'mk_framework' ),
							'help' => __( 'Select default layout of search page.', 'mk_framework' ),
							'model' => 'search_page_layout',
							'default' => 'right',
							'item_padding' => '20px 30px 0 0',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'left' => __( 'Left Sidebar', 'mk_framework' ),
									'right' => __( 'Right Sidebar', 'mk_framework' ),
									'full' => __( 'Full Layout', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Title', 'mk_framework' ),
							'help' => __( 'Enter the page title for search page.', 'mk_framework' ),
							'model' => 'search_page_title',
							'default' => 'Search',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Subtitle', 'mk_framework' ),
							'help' => __( 'Display page subtitle in search page?', 'mk_framework' ),
							'model' => 'search_disable_subtitle',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'blog_single_post' => array(
			'label' => __( 'Blog Single Post', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Single Layout', 'mk_framework' ),
							'help' => __( 'Select default layout for single blog posts. It can be adjusted per post from single posts edit screen.', 'mk_framework' ),
							'model' => 'single_layout',
							'default' => 'full',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'left' => __( 'Left Sidebar', 'mk_framework' ),
									'right' => __( 'Right Sidebar', 'mk_framework' ),
									'full' => __( 'Full Layout', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Post Style', 'mk_framework' ),
							'help' => __( 'Select the default style for single blog posts.', 'mk_framework' ),
							'model' => 'single_blog_style',
							'default' => 'compact',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'compact' => __( 'Traditional & Compact', 'mk_framework' ),
									'bold' => __( 'Clear & Bold', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Make Featured Image Full Height', 'mk_framework' ),
							'help' => __( 'Enable featured image full height for Clear & Bold single blog post style?', 'mk_framework' ),
							'model' => 'single_bold_hero_full_height',
							'default' => 'true',
							'type' => 'mk-toggle',
							'condition' => array(
								'model' => 'single_blog_style',
								'value' => 'bold',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Featured Image', 'mk_framework' ),
							'help' => __( 'Display featured image for single blog posts?', 'mk_framework' ),
							'model' => 'single_disable_featured_image',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Blog Featured Image Height', 'mk_framework' ),
							'help' => __( 'Adjust featured image height of Clear & Bold single blog post style. It affects when <strong>Make Featured Image Full Height</strong> is disabled.', 'mk_framework' ),
							'model' => 'bold_single_hero_height',
							'min' => '100',
							'max' => '2000',
							'step' => '1',
							'default' => '800',
							'unit' => 'px',
							'type' => 'mk-range',
							'condition' => array(
								'model' => 'single_blog_style',
								'value' => 'bold',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Featured Image Height', 'mk_framework' ),
							'help' => __( 'Adjust featured image height of Traditional & Compact single blog post style.', 'mk_framework' ),
							'model' => 'single_featured_image_height',
							'min' => '100',
							'max' => '1000',
							'step' => '1',
							'default' => '300',
							'unit' => 'px',
							'type' => 'mk-range',
							'condition' => array(
								'model' => 'single_blog_style',
								'value' => 'compact',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Image Cropping', 'mk_framework' ),
							'help' => __( 'Enable automatic image cropping for featured image of single blog posts?', 'mk_framework' ),
							'model' => 'blog_single_img_crop',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Post Title', 'mk_framework' ),
							'help' => __( 'Display page title in single blog posts?', 'mk_framework' ),
							'model' => 'blog_single_title',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Previous & Next Arrows', 'mk_framework' ),
							'help' => __( 'Display blog posts navigation in single blog posts? It guides a visitor to go through previous and next posts.', 'mk_framework' ),
							'model' => 'blog_prev_next',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Show Previous & Next for Same Categories?', 'mk_framework' ),
							'help' => __( 'Limit the blog posts navigation to same categories of current post.', 'mk_framework' ),
							'model' => 'blog_prev_next_same_category',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Recommended Posts', 'mk_framework' ),
							'help' => __( 'Display recommended posts in single blog posts?', 'mk_framework' ),
							'model' => 'enable_single_related_posts',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Comments on Blog Posts', 'mk_framework' ),
							'help' => __( 'Display comments in single blog posts?', 'mk_framework' ),
							'model' => 'blog_single_comments',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'About Author Box', 'mk_framework' ),
							'help' => __( 'Display post author information in single blog posts? Author information can be configured in profile settings?', 'mk_framework' ),
							'model' => 'enable_blog_author',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Social Share', 'mk_framework' ),
							'help' => __( 'Display social share icons in single blog posts and blog archive?', 'mk_framework' ),
							'model' => 'single_blog_social',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Heading Texts', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Heading Text Weight', 'mk_framework' ),
							'model' => 'blog_heading_weight',
							'default' => 600,
							'type' => 'mk-select',
							'options' => mk_assoc_to_pairs( $mk_font_weight ),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading Text Case', 'mk_framework' ),
							'model' => 'blog_heading_transform',
							'default' => '',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'none' => __( 'None', 'mk_framework' ),
									'uppercase' => __( 'Uppercase', 'mk_framework' ),
									'capitalize' => __( 'Capitalize', 'mk_framework' ),
									'lowercase' => __( 'Lower case', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading Text Size', 'mk_framework' ),
							'model' => 'blog_heading_size',
							'help' => __( 'If zero chosen the default body text size will be used.', 'mk_framework' ),
							'min' => '0',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '0',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading Color', 'mk_framework' ),
							'model' => 'blog_heading_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading 1 Color', 'mk_framework' ),
							'model' => 'blog_body_h1_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading 2 Color', 'mk_framework' ),
							'model' => 'blog_body_h2_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading 3 Color', 'mk_framework' ),
							'model' => 'blog_body_h3_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading 4 Color', 'mk_framework' ),
							'model' => 'blog_body_h4_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading 5 Color', 'mk_framework' ),
							'model' => 'blog_body_h5_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Heading 6 Color', 'mk_framework' ),
							'model' => 'blog_body_h6_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => __( 'Body Texts', 'mk_framework' ),
					'fields' => array(
						array(
							'label' => __( 'Body Text Weight', 'mk_framework' ),
							'model' => 'blog_body_weight',
							'default' => 400,
							'type' => 'mk-select',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'100' => __( '100', 'mk_framework' ),
									'200' => __( '200 (light)', 'mk_framework' ),
									'300' => __( '300', 'mk_framework' ),
									'400' => __( '400 (normal)', 'mk_framework' ),
									'500' => __( '500 (medium)', 'mk_framework' ),
									'600' => __( '600 (semi-bold)', 'mk_framework' ),
									'700' => __( '700 (bold)', 'mk_framework' ),
									'bolder' => __( '800 (bolder)', 'mk_framework' ),
									'900' => __( '900', 'mk_framework' ),
								)
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Body Text Size', 'mk_framework' ),
							'help' => __( 'Adjust the blog posts text size. Set it to 0 to use the default body text size from <strong>General Typography</strong>.', 'mk_framework' ),
							'model' => 'blog_body_font_size',
							'min' => '0',
							'max' => '50',
							'step' => '1',
							'unit' => 'px',
							'default' => '0',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Body Text Line Height', 'mk_framework' ),
							'help' => __( 'Adjust the blog posts text line height. Set it to 0 to use the default body text line height from <strong>General Typography</strong>.', 'mk_framework' ),
							'model' => 'blog_body_line_height',
							'min' => '0',
							'max' => '4',
							'step' => '0.01',
							'unit' => 'em',
							'default' => '0',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Body Text Color', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => 'blog_body_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Body Text Links Color', 'mk_framework' ),
							'model' => 'blog_body_a_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Body Text Links Hover Color', 'mk_framework' ),
							'model' => 'blog_body_a_color_hover',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Body Strong Tag Color', 'mk_framework' ),
							'model' => 'blog_body_strong_tag_color',
							'default' => '',
							'type' => 'mk-color',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'blog_meta' => array(
			'label' => __( 'Blog Meta', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Display Meta Options', 'mk_framework' ),
							'help' => __( 'Display post meta information (author, date, category, ...) in single blog posts?', 'mk_framework' ),
							'model' => 'single_meta_section',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Meta Tags', 'mk_framework' ),
							'help' => __( 'Display posts tags in single blog posts?', 'mk_framework' ),
							'model' => 'diable_single_tags',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'blog_archive' => array(
			'label' => __( 'Blog Archive', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Archive Layout', 'mk_framework' ),
							'help' => __( 'Select default layout for blog archive pages.', 'mk_framework' ),
							'model' => 'archive_page_layout',
							'default' => 'right',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'left' => __( 'Left Sidebar', 'mk_framework' ),
									'right' => __( 'Right Sidebar', 'mk_framework' ),
									'full' => __( 'Full Layout', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Blog Archive Style', 'mk_framework' ),
							'help' => __( 'Select default blog post style for blog archive pages.', 'mk_framework' ),
							'model' => 'archive_loop_style',
							'default' => 'modern',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'modern' => __( 'Modern', 'mk_framework' ),
									'classic' => __( 'Classic', 'mk_framework' ),
									'newspaper' => __( 'Newspaper', 'mk_framework' ),
									'spotlight' => __( 'Spotlight', 'mk_framework' ),
									'thumbnail' => __( 'Thumbnail', 'mk_framework' ),
									'magazine' => __( 'Magazine', 'mk_framework' ),
									'grid' => __( 'Grid', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Title', 'mk_framework' ),
							'help' => __( 'Enter the page title for blog archive pages.', 'mk_framework' ),
							'model' => 'archive_page_title',
							'default' => __( 'Archives', 'mk_framework' ),
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Page Subtitle', 'mk_framework' ),
							'help' => __( 'Display page subtitle in blog archive pages?', 'mk_framework' ),
							'model' => 'archive_disable_subtitle',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Featured Image Height', 'mk_framework' ),
							'help' => __( 'Adjust blog posts featured image in blog archive pages.', 'mk_framework' ),
							'model' => 'archive_blog_image_height',
							'min' => '100',
							'max' => '1000',
							'step' => '1',
							'default' => '350',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Blog Meta', 'mk_framework' ),
							'help' => __( 'isplay post meta information (author, date, category, ...) in blog archive posts?', 'mk_framework' ),
							'model' => 'archive_blog_meta',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Pagination Style', 'mk_framework' ),
							'help' => __( 'Select pagination style for blog archive pages.', 'mk_framework' ),
							'model' => 'archive_pagination_style',
							'default' => '1',
							'options' => mk_assoc_to_pairs(
								array(
									'1' => __( 'Pagination Nav', 'mk_framework' ),
									'2' => __( 'Load More Button', 'mk_framework' ),
									'3' => __( 'Load on Page Scroll', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'news' => array(
			'label' => __( 'News', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Featured Image', 'mk_framework' ),
							'help' => __( 'Display featured image for single news posts?', 'mk_framework' ),
							'model' => 'news_disable_featured_image',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Featured Image Height', 'mk_framework' ),
							'help' => __( 'Adjust news single posts featured image height.', 'mk_framework' ),
							'model' => 'news_featured_image_height',
							'min' => '100',
							'max' => '1000',
							'step' => '1',
							'default' => '340',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Slug', 'mk_framework' ),
							'help' => __( 'News Slug is the text that is displyed in the URL (e.g. www.domain.com/<strong>news-posts</strong>/morbi-et-diam-massa/). As shown in the example, it is set to \'news-posts\' by default but you can change it to anything to suite your preference. However you should not have the same slug in any page or other post slug and if so the pagination will return 404 error naturally due to the internal conflicts.', 'mk_framework' ),
							'model' => 'news_slug',
							'default' => 'news-posts',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'portfolio_single_post' => array(
			'label' => __( 'Portfolio Single Post', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Layout', 'mk_framework' ),
							'help' => __( 'Select default layout of single portfolio posts. It can be adjusted per post from single portfolio edit screen.', 'mk_framework' ),
							'model' => 'portfolio_single_layout',
							'default' => 'full',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'left' => __( 'Left Sidebar', 'mk_framework' ),
									'right' => __( 'Right Sidebar', 'mk_framework' ),
									'full' => __( 'Full Layout', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Single Featured Image Height', 'mk_framework' ),
							'help' => __( 'Adjust featured image height for single portfolio posts.', 'mk_framework' ),
							'model' => 'Portfolio_single_image_height',
							'min' => '100',
							'max' => '1000',
							'step' => '1',
							'default' => '500',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Category', 'mk_framework' ),
							'help' => __( 'Display portfolio post categories in single portfolio posts?', 'mk_framework' ),
							'model' => 'single_portfolio_cats',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Related Portfolio Posts', 'mk_framework' ),
							'help' => __( 'Display related projects in single portfolio posts?', 'mk_framework' ),
							'model' => 'enable_portfolio_similar_posts',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Previous & Next Arrows', 'mk_framework' ),
							'help' => __( 'Display portfolio posts navigation in single portfolio posts? It guides a visitor to go through previous and next posts.', 'mk_framework' ),
							'model' => 'portfolio_next_prev',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Previous & Next for Same Categories', 'mk_framework' ),
							'help' => __( 'Limit the portfolio posts navigation to same categories of current post.', 'mk_framework' ),
							'model' => 'portfolio_prev_next_same_category',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Comments on Portfolio Post', 'mk_framework' ),
							'help' => __( 'Display comments in single portfolio posts?', 'mk_framework' ),
							'model' => 'enable_portfolio_comment',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Social Share', 'mk_framework' ),
							'help' => __( 'Display social share icons in single portfolio posts?', 'mk_framework' ),
							'model' => 'single_portfolio_social',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Portfolio Slug', 'mk_framework' ),
							'help' => __( 'Portfolio Slug is the text that is displyed in the URL (e.g. www.domain.com/<strong>portfolio-posts</strong>/morbi-et-diam-massa/). As shown in the example, it is set to \'portfolio-posts\' by default but you can change it to anything to suite your preference. However you should not have the same slug in any page or other post slug and if so the pagination will return 404 error naturally due to the internal conflicts.', 'mk_framework' ),
							'model' => 'portfolio_slug',
							'default' => 'portfolio-posts',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Portfolio Category Slug', 'mk_framework' ),
							'help' => __( 'Portfolio Category Slug is the text that is displyed in the URL of your portfolio archive page. Default : portfolio_category', 'mk_framework' ),
							'model' => 'portfolio_cat_slug',
							'default' => 'portfolio_category',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'type'  => 'mk-toggle',
							'label' => __( 'Stick Template', 'mk_framework' ),
							'help' => __( 'Enabling this option will remove padding after header and before footer for single portfolio pages.', 'mk_framework' ),
							'model' => 'stick_template_portfolio',
							'default' => 'false',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'portfolio_archive' => array(
			'label' => __( 'Portfolio Archive', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Archive Layout', 'mk_framework' ),
							'help' => __( 'Select default layout for portfolio archive pages.', 'mk_framework' ),
							'model' => 'archive_portfolio_layout',
							'default' => 'right',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'left' => __( 'Left Sidebar', 'mk_framework' ),
									'right' => __( 'Right Sidebar', 'mk_framework' ),
									'full' => __( 'Full Layout', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Archive Style', 'mk_framework' ),
							'help' => __( 'Select default portfolio post style for portfolio archive pages.', 'mk_framework' ),
							'model' => 'archive_portfolio_style',
							'default' => 'classic',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'classic' => __( 'Classic', 'mk_framework' ),
									'grid' => __( 'Grid', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Featured Image Height', 'mk_framework' ),
							'help' => __( 'Adjust portfolio posts featured image in portfolio archive pages.', 'mk_framework' ),
							'model' => 'archive_portfolio_image_height',
							'min' => '100',
							'max' => '1000',
							'step' => '1',
							'default' => '400',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Columns', 'mk_framework' ),
							'help' => __( 'Adjust number of portfolio posts column for portfolio archive pages.', 'mk_framework' ),
							'model' => 'archive_portfolio_column',
							'min' => '1',
							'max' => '6',
							'step' => '1',
							'default' => '3',
							'unit' => 'column',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Pagination Style', 'mk_framework' ),
							'help' => __( 'Select pagination style for portfolio archive pages.', 'mk_framework' ),
							'model' => 'archive_portfolio_pagination_style',
							'default' => '1',
							'options' => mk_assoc_to_pairs(
								array(
									'1' => __( 'Pagination Nav', 'mk_framework' ),
									'2' => __( 'Load More Button', 'mk_framework' ),
									'3' => __( 'Load on Page Scroll', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'general_ecommerce' => array(
			'label' => __( 'General', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Shop Customizer', 'mk_framework' ),
							'help' => __( 'Enable shop customizer? It adds <strong>Shop</strong> section in <strong>Appearance > Customize</strong> to customize the product list, page and checkout pages.', 'mk_framework' ),
							'model' => 'shop_customizer',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Shop Loop Columns', 'mk_framework' ),
							'help' => __( 'Select number of products column for shop page.', 'mk_framework' ),
							'model' => 'shop_archive_columns',
							'default' => 'default',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'default' => __( 'Default (4 Columns full layout, 3 columns with sidebar)', 'mk_framework' ),
									'1' => __( '1', 'mk_framework' ),
									'2' => __( '2', 'mk_framework' ),
									'3' => __( '3', 'mk_framework' ),
									'4' => __( '4', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Shop Catalog Mode', 'mk_framework' ),
							'help' => __( 'Enable Catalog Mode for the shop? It switches the shop to an online catalogue.', 'mk_framework' ),
							'model' => 'woocommerce_catalog',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Product Category Loop Image Size', 'mk_framework' ),
							'help' => __( 'Select product posts image size for category pages. Define custom image sizes in <strong>Jupiter > Image Size</strong>.', 'mk_framework' ),
							'model' => 'woo_category_image_size',
							'default' => 'crop',
							'options' => $mk_image_sizes,
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Product Category Archive Loop Title', 'mk_framework' ),
							'help' => __( 'Enter product category page title.', 'mk_framework' ),
							'model' => 'woocommerce_category_page_title',
							'default' => 'Shop',
							'type' => 'mk-input',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Use Product Name as Page Title', 'mk_framework' ),
							'help' => __( 'Display product name as page title in single product page?', 'mk_framework' ),
							'model' => 'woocommerce_use_product_title',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Use Product Category / Tag Name as Page Title', 'mk_framework' ),
							'help' => __( 'Display product category/tag name as page title on product category/tag page?', 'mk_framework' ),
							'model' => 'woocommerce_use_category_title',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Use Product Category / Tag Name as Product Filter Title', 'mk_framework' ),
							'help' => __( 'Display product category/tag as filter label for products on product category/tag page?', 'mk_framework' ),
							'model' => 'woocommerce_use_category_filter_title',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Show Shopping Cart', 'mk_framework' ),
							'help' => __( 'Display header shopping cart icon?', 'mk_framework' ),
							'model' => 'shopping_cart',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Shopping Cart on Mobile Phone', 'mk_framework' ),
							'help' => __( 'Enable floating shopping cart link for small devices? The visibility is determined based on Main Navigation Threshold Width value.', 'mk_framework' ),
							'model' => 'add_cart_responsive',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
				array(
					'label' => 'Product Loop',
					'fields' => array(
						array(
							'label' => __( 'Product Loop Image Size', 'mk_framework' ),
							'help' => __( 'Select product posts image size. Define custom image sizes in <strong>Jupiter &gt; Image Sizes</strong>.', 'mk_framework' ),
							'model' => 'woo_loop_image_size',
							'default' => 'crop',
							'options' => $mk_image_sizes,
							'type' => 'mk-select',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Product Loop Image Height', 'mk_framework' ),
							'help' => __( 'Adjust product posts image height.', 'mk_framework' ),
							'model' => 'woo_loop_img_height',
							'default' => '300',
							'min' => '100',
							'max' => '1000',
							'step' => '1',
							'unit' => 'px',
							'type' => 'mk-range',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Excerpt For Product Loop', 'mk_framework' ),
							'help' => __( 'Enable excerpt in product posts?', 'mk_framework' ),
							'model' => 'woocommerce_loop_show_desc',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Product Loop Love Button', 'mk_framework' ),
							'help' => __( 'Enable love button in product posts?', 'mk_framework' ),
							'model' => 'woocommerce_loop_enable_love_button',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'ecommerce_single_product' => array(
			'label' => __( 'E-commerce Single Product', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Woocommerce Single Product Layout', 'mk_framework' ),
							'help' => __( 'Select default layout for single product pages.', 'mk_framework' ),
							'model' => 'woocommerce_single_layout',
							'default' => 'full',
							'options' => mk_assoc_to_pairs(
								array(
									'' => __( 'Select Option', 'mk_framework' ),
									'left' => __( 'Left Sidebar', 'mk_framework' ),
									'right' => __( 'Right Sidebar', 'mk_framework' ),
									'full' => __( 'Full Layout', 'mk_framework' ),
								)
							),
							'type' => 'mk-select',
							'selectOptions' => array(
								'noneSelectedText' => 'Select Option',
							),
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Single Product Page Title', 'mk_framework' ),
							'help' => __( 'Display page title in single product pages?', 'mk_framework' ),
							'model' => 'woocommerce_single_product_title',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Previous & Next Arrows', 'mk_framework' ),
							'help' => __( 'Display product posts navigation in single product pages? It guides a visitor to go through previous and next products.', 'mk_framework' ),
							'model' => 'woo_single_prev_next',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Show Previous & Next for Same Categories', 'mk_framework' ),
							'help' => __( 'Limit the product posts navigation to same categories of current product.', 'mk_framework' ),
							'model' => 'woo_prev_next_same_category',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Social Share', 'mk_framework' ),
							'help' => __( 'Display social network icons in single product pages?', 'mk_framework' ),
							'model' => 'woocommerce_single_social_network',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'speed_optimizations' => array(
			'label' => __( 'Speed Optimizations', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Minify Theme Javascript File', 'mk_framework' ),
							'help' => __( 'Load minified version of JS files? It increases your website speed.', 'mk_framework' ),
							'model' => 'minify-js',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Minify Theme Styles Files', 'mk_framework' ),
							'help' => __( 'Load minified version of CSS files? It increases your website speed.', 'mk_framework' ),
							'model' => 'minify-css',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Query String From Static Flies', 'mk_framework' ),
							'help' => __( 'Remove <strong>ver</strong> query string from JS and CSS files? For more information <a target="_blank" href="https://developers.google.com/speed/docs/best-practices/caching#LeverageProxyCaching">read here</a>. Disabling this option may cause issues with some hosting providers internal caching tools.', 'mk_framework' ),
							'model' => 'remove-js-css-ver',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Global Lazy Load', 'mk_framework' ),
							'help' => __( 'Turn on lazyload for all the supported shortcodes?.', 'mk_framework' ),
							'model' => 'global_lazyload',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'post_types' => array(
			'label' => __( 'Post Types', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Portfolio Post Type ', 'mk_framework' ),
							'help' => __( 'Enable Portfolio post type?', 'mk_framework' ),
							'model' => 'portfolio-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'News Post Type', 'mk_framework' ),
							'help' => __( 'Enable News post type?', 'mk_framework' ),
							'model' => 'news-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'FAQ Post Type', 'mk_framework' ),
							'help' => __( 'Enable FAQs post type?', 'mk_framework' ),
							'model' => 'faq-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Photo Album Post Type', 'mk_framework' ),
							'help' => __( 'Enable Photo Album post type?', 'mk_framework' ),
							'model' => 'photo_album-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Pricing Tables Post Type', 'mk_framework' ),
							'help' => __( 'Enable Pricing Tables post type?', 'mk_framework' ),
							'model' => 'pricing-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Clients Post Type', 'mk_framework' ),
							'help' => __( 'Enable Clients post type?', 'mk_framework' ),
							'model' => 'clients-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Employees Post Type', 'mk_framework' ),
							'help' => __( 'Enable Employees post type?', 'mk_framework' ),
							'model' => 'employees-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Testimonial Post Type', 'mk_framework' ),
							'help' => __( 'Enable Testimonial post type?', 'mk_framework' ),
							'model' => 'testimonial-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Animated Columns Post Type', 'mk_framework' ),
							'help' => __( 'Enable Animated Columns post type?', 'mk_framework' ),
							'model' => 'animated-columns-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Edge Slider Post Type', 'mk_framework' ),
							'help' => __( 'Enable Edge Slider post type?', 'mk_framework' ),
							'model' => 'edge-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Tab Slider Post Type', 'mk_framework' ),
							'help' => __( 'Enable Tab Slider post type?', 'mk_framework' ),
							'model' => 'tab_slider-post-type',
							'default' => 'true',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'FlexSlider Post Type', 'mk_framework' ),
							'help' => __( 'Enable FlexSlider post type?', 'mk_framework' ),
							'model' => 'slideshow-post-type',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
						array(
							'label' => __( 'Banner Builder Post Type', 'mk_framework' ),
							'help' => __( 'Enable Banner Slider post type?', 'mk_framework' ),
							'model' => 'banner_builder-post-type',
							'default' => 'false',
							'type' => 'mk-toggle',
							'styleClasses' => 'col-sm-12 col-md-6',
						),
					),
				),
			),
		),
		'custom_css' => array(
			'label' => __( 'Custom CSS', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Custom CSS', 'mk_framework' ),
							'help' => __( 'Enter custom CSS to modify/add Theme stylings. Use <kbd>Shift</kbd> + <kbd>Space</kbd> to use code-completion. Press <kbd>Esc</kbd> or <b>double-click</b> on the editor, or click anywhere outside the editor to exit code-completion.', 'mk_framework' ),
							'model' => 'custom_css',
							'default' => '',
							'rows' => 30,
							'type' => 'mk-textarea',
							'mode' => 'text/css',
							'styleClasses' => 'col-sm-12',
						),
					),
				),
			),
		),
		'custom_js' => array(
			'label' => __( 'Custom JS', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Custom JS', 'mk_framework' ),
							'help' => __( 'Enter custom JS to modify/add Theme JS functionalities. Use <kbd>Shift</kbd> + <kbd>Space</kbd> to use code-completion. Press <kbd>Esc</kbd> or <b>double-click</b> on the editor, or click anywhere outside the editor to exit code-completion.', 'mk_framework' ),
							'model' => 'custom_js',
							'default' => '',
							'rows' => 30,
							'type' => 'mk-textarea',
							'mode' => 'text/javascript',
							'styleClasses' => 'col-sm-12',
						),
					),
				),
			),
		),
		'export_theme_options' => array(
			'label' => __( 'Export Theme Options', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Export Theme Options', 'mk_framework' ),
							'model' => 'theme_export_options',
							'default' => '',
							'rows' => 30,
							'readonly' => 'readonly',
							'type' => 'mk-textarea',
							'placeholder' => __( 'Save the settings to see the export data.', 'mk_framework' ),
							'styleClasses' => 'col-sm-12',
						),
					),
				),
			),
		),
		'import_theme_options' => array(
			'label' => __( 'Import Theme Options', 'mk_framework' ),
			'sections' => array(
				array(
					'label' => false,
					'fields' => array(
						array(
							'label' => __( 'Import Theme Options', 'mk_framework' ),
							'help' => __( 'Paste the exported data here then click on Import button. Be patient, the process make take several minutes on some web hosts.', 'mk_framework' ),
							'model' => 'theme_import_options',
							'default' => '',
							'type' => 'mk-textarea',
							'rows' => 30,
							'placeholder' => __( 'Paste the export data then click on the following Import button.', 'mk_framework' ),
							'styleClasses' => 'col-sm-12',
						),
						array(
							'label' => __( '', 'mk_framework' ),
							'help' => __( '', 'mk_framework' ),
							'model' => '',
							'default' => '',
							'type' => 'mk-button-small',
							'styleClasses' => 'col-sm-12',
							'val' => 'Import',
							'id' => 'mka_to_import_theme_options',
							'name' => 'import_theme_options',
							'nonce' => wp_create_nonce( 'mk-ajax-theme-options' ),
						),
					),
				),
			),
		),
	),
	'values' => $values,
);

return $options;
