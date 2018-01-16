<?php
/**
 * Add Button section of Checkout & Cart > Styles.
 * Prefixes: s -> shop, cc -> checkout-cart, s -> styles, button_style -> btn_s
 *
 * @package WordPress
 * @subpackage Jupiter
 * @since 5.9.4
 */

// Button dialog.
$wp_customize->add_section(
	new MK_Dialog(
		$wp_customize,
		'mk_s_cc_s_button_style',
		array(
			'mk_belong' => 'mk_s_cc_dialog',
			'mk_tab' => array(
				'id' => 'sh_cc_sty',
				'text' => __( 'Styles', 'mk_framework' ),
			),
			'title' => __( 'Button', 'mk_framework' ),
			'mk_reset' => 'sh_cc_sty_btn',
			'priority' => 100,
			'active_callback' => 'mk_cz_hide_section',
		)
	)
);

// Typography.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_typography]', array(
		'type' => 'option',
		'default' => array(
			'family' => 'inherit',
			'size' => 14,
			'weight' => 700,
			'style' => 'normal',
			'color' => '#ffffff',
		),
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Typography_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_typography]',
		array(
			'section' => 'mk_s_cc_s_button_style',
			'column'  => 'mk-col-12',
		)
	)
);

// Background Color.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_background_color]', array(
		'type' => 'option',
		'default'   => '#157cf2',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Color_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_background_color]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-2-alt',
			'icon'     => 'mk-background-color',
		)
	)
);

// Corner Radius.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_border_radius]', array(
		'type' => 'option',
		'default'   => 3,
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Input_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_border_radius]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-3-alt',
			'icon'     => 'mk-corner-radius',
			'unit'     => 'px',
			'input_type' => 'number',
			'input_attrs'   => array(
				'min' => '0',
			),
		)
	)
);

// Border.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_border]', array(
		'type' => 'option',
		'default'   => 0,
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Input_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_border]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-3-alt',
			'icon'     => 'mk-border',
			'unit'     => 'px',
			'input_type' => 'number',
			'input_attrs'   => array(
				'min' => '0',
			),
		)
	)
);

// Border Color.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_border_color]', array(
		'type' => 'option',
		'default'   => '#157cf2',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Color_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_border_color]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-2-alt mk-col-last',
			'icon'     => 'mk-border-color',
		)
	)
);

// Divider 1.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_divider_1]', array(
		'type' => 'option',
	)
);

$wp_customize->add_control(
	new MK_Divider_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_divider_1]',
		array(
			'section' => 'mk_s_cc_s_button_style',
		)
	)
);

// Hover Label.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_label]', array(
		'type' => 'option',
	)
);

$wp_customize->add_control(
	new MK_Label_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_label]',
		array(
			'section' => 'mk_s_cc_s_button_style',
			'label' => __( 'Hover Style', 'mk_framework' ),
			'icon' => 'mk-hover-style-arrow',
		)
	)
);

// Font Color Hover.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_color_hover]', array(
		'type' => 'option',
		'default'   => '#ffffff',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Color_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_color_hover]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-2-alt',
			'icon'     => 'mk-font-color',
		)
	)
);

// Background Color Hover.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_background_color_hover]', array(
		'type' => 'option',
		'default'   => '#4597f5',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Color_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_background_color_hover]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-2-alt',
			'icon'     => 'mk-background-color',
		)
	)
);

// Border Color Hover.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_border_color_hover]', array(
		'type' => 'option',
		'default'   => '#4597f5',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Color_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_border_color_hover]',
		array(
			'section'  => 'mk_s_cc_s_button_style',
			'column'   => 'mk-col-2-alt',
			'icon'     => 'mk-border-color',
		)
	)
);

// Divider 2.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_divider_2]', array(
		'type' => 'option',
	)
);

$wp_customize->add_control(
	new MK_Divider_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_divider_2]',
		array(
			'section' => 'mk_s_cc_s_button_style',
		)
	)
);

// Box Model.
$wp_customize->add_setting(
	'mk_cz[sh_cc_sty_btn_box_model]', array(
		'type' => 'option',
		'default' => array(
			'margin_top' => 0,
			'margin_right' => 0,
			'margin_bottom' => 0,
			'margin_left' => 0,
			'padding_top' => 16,
			'padding_right' => 35,
			'padding_bottom' => 16,
			'padding_left' => 35,
		),
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new MK_Box_Model_Control(
		$wp_customize,
		'mk_cz[sh_cc_sty_btn_box_model]',
		array(
			'section' => 'mk_s_cc_s_button_style',
			'column'  => 'mk-col-12',
		)
	)
);
