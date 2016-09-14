<?php
/**
 * Counter Theme Customizer
 *
 * @package Counter
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function counter_customize_register( $wp_customize ) {
	$color_scheme = counter_get_color_scheme();

	// Make site title and site description update instantly.
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Rearrange controls.
	// $wp_customize->get_section( 'colors' )->panel = 'appearance';
	$wp_customize->get_section( 'static_front_page' )->panel = 'frontpage';

	// Rename Static Front Page Section.
	$wp_customize->get_section( 'static_front_page' )->title = __( 'Choose Front Page', 'counter' );
	$wp_customize->get_section( 'static_front_page' )->description = false;

	// Appearance panel.
	// $wp_customize->add_panel( 'appearance' , array(
	// 	'title'    => __( 'Appearance', 'counter' ),
	// 	'priority' => 30,
	// ) );

	/**
	 * Site Identity.
	 */

	// Display Title.
	$wp_customize->add_setting( 'display_title', array(
		'default' => true,
		'sanitize_callback' => 'counter_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'display_title', array(
		'label'   => __( 'Display Title', 'counter' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	) );

	// Display Tagline.
	$wp_customize->add_setting( 'display_tagline', array(
		'default' => true,
		'sanitize_callback' => 'counter_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'display_tagline', array(
		'label'   => __( 'Display Tagline', 'counter' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	) );

	/**
	 * Colors.
	 */

	// Add color scheme setting and control.
	// $wp_customize->add_setting( 'color_scheme', array(
	// 	'default'           => 'default',
	// 	'sanitize_callback' => 'counter_sanitize_color_scheme',
	// 	'transport'         => 'postMessage',
	// ) );

	// $wp_customize->add_control( 'color_scheme', array(
	// 	'label'    => __( 'Color Scheme', 'counter' ),
	// 	'section'  => 'colors',
	// 	'type'     => 'select',
	// 	'choices'  => counter_get_color_scheme_choices(),
	// 	'priority' => 0,
	// ) );

	// Background color.
	// $wp_customize->add_setting( 'color_bg', array(
	// 	'default'           => $color_scheme[0],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'color_bg',
	// 		array(
	// 			'label'   => __( 'Background', 'counter' ),
	// 			'section' => 'colors',
	// 			'priority' => 80,
	// 		)
	// 	)
	// );

	// Accent Color.
	// $wp_customize->add_setting( 'color_accent', array(
	// 	'default'           => $color_scheme[1],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'color_accent',
	// 		array(
	// 			'label'   => __( 'Accent', 'counter' ),
	// 			'section' => 'colors',
	// 			'priority' => 100,
	// 		)
	// 	)
	// );

	// Headings Color.
	// $wp_customize->add_setting( 'color_headings', array(
	// 	'default'           => $color_scheme[2],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );

	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'color_headings',
	// 		array(
	// 			'label'   => __( 'Headings', 'counter' ),
	// 			'section' => 'colors',
	// 			'priority' => 120,
	// 		)
	// 	)
	// );

	// Text Color.
	// $wp_customize->add_setting( 'color_text', array(
	// 	'default'           => $color_scheme[3],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'color_text',
	// 		array(
	// 			'label'   => __( 'Text', 'counter' ),
	// 			'section' => 'colors',
	// 			'priority' => 140,
	// 		)
	// 	)
	// );

	/**
	 * Front Page.
	 */

	// Panels Panel. Well, how else do you call it?
	$wp_customize->add_panel( 'frontpage' , array(
		'title'    => __( 'Static Front Page', 'counter' ),
		'priority' => 110,
	) );

	$wp_customize->add_section( new Counter_Frontpage_Visibility_Section( $wp_customize, 'frontpage_invisible', array(
		'title'           => __( 'Navigate to Front Page', 'counter' ),
		'panel'           => 'frontpage',
		'active_callback' => 'counter_not_front_page',
	) ) );

	$wp_customize -> add_control(
		new Counter_Message_Control(
			$wp_customize,
			'frontpage_invisible',
			array(
				'label'       => __( 'Navigate to Front Page', 'counter' ),
				'section'     => 'frontpage_invisible',
				'settings'    => array(),
				'description' => __( 'To edit the front page navigate to it in the preview screen.', 'counter' ),
			)
		)
	);

	for ( $i = 1; $i <= counter_get_panel_count(); $i++ ) :

	$wp_customize->add_section( 'panel_' . $i, array(
		'title'           => __( 'Panel ', 'counter' ) . $i,
		'panel'           => 'frontpage',
		'active_callback' => 'counter_is_front_page',
	) );

	// Page Dropdown.
	$wp_customize->add_setting( 'panel_content_' . $i, array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'panel_content_' . $i, array(
		'label'   => esc_html__( 'Content', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'dropdown-pages',
	) );

	// Divider.
	$wp_customize->add_control(
		new Counter_Divider_Control(
			$wp_customize,
			'panel_content_divider_' . $i,
			array(
				'section' => 'panel_' . $i,
				'settings' => array(),
			)
		)
	);

	// Layout.
	$wp_customize->add_setting( 'panel_layout_' . $i, array(
		'default'           => 'center',
		'sanitize_callback' => 'counter_sanitize_panel_layout',
	) );

	$wp_customize->add_control( 'panel_layout_' . $i, array(
		'label'   => esc_html__( 'Layout', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => counter_get_panel_types(),
	) );

	// Title Display.
	$wp_customize->add_setting( 'panel_title_display_' . $i, array(
		'default'           => 1,
		'sanitize_callback' => 'counter_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'panel_title_display_' . $i, array(
		'label'   => esc_html__( 'Display Title?', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'checkbox',
	) );

	// Panel title alignment.
	$wp_customize->add_setting( 'panel_title_alignment_' . $i, array(
		'default'           => 'left',
		'sanitize_callback' => 'counter_sanitize_alignment',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'panel_title_alignment_' . $i, array(
		'label'   => esc_html__( 'Title Alignment', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'left'   => __( 'Left', 'counter' ),
			'center' => __( 'Center', 'counter' ),
			'right'  => __( 'Right', 'counter' ),
		),
	) );

	// Panel text alignment.
	$wp_customize->add_setting( 'panel_text_alignment_' . $i, array(
		'default'           => 'left',
		'sanitize_callback' => 'counter_sanitize_alignment',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'panel_text_alignment_' . $i, array(
		'label'   => esc_html__( 'Text Alignment', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'left'   => __( 'Left', 'counter' ),
			'center' => __( 'Center', 'counter' ),
			'right'  => __( 'Right', 'counter' ),
		),
	) );

	// Spacing.
	$wp_customize->add_setting( 'panel_spacing_' . $i, array(
		'default'           => 0,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'panel_spacing_' . $i, array(
		'label'   => __( 'Panel Spacing', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'range',
		'input_attrs' => array(
			'min'  => 0,
			'max'  => 25,
			'step' => 1,
		),
	) );

	// Divider.
	// $wp_customize->add_control(
	// 	new Counter_Divider_Control(
	// 		$wp_customize,
	// 		'panel_layout_divider_' . $i,
	// 		array(
	// 			'section' => 'panel_' . $i,
	// 			'settings' => array(),
	// 		)
	// 	)
	// );

	// Background color.
	// $wp_customize->add_setting( 'panel_color_bg_' . $i, array(
	// 	'default'           => $color_scheme[5][ $i ][0],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'panel_color_bg_' . $i,
	// 		array(
	// 			'label'   => __( 'Background Color', 'counter' ),
	// 			'section' => 'panel_' . $i,
	// 		)
	// 	)
	// );

	// Accent color.
	// $wp_customize->add_setting( 'panel_color_accent_' . $i, array(
	// 	'default'           => $color_scheme[5][ $i ][1],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );

	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'panel_color_accent_' . $i,
	// 		array(
	// 			'label'   => __( 'Accent Color', 'counter' ),
	// 			'section' => 'panel_' . $i,
	// 		)
	// 	)
	// );

	// Headings color.
	// $wp_customize->add_setting( 'panel_color_headings_' . $i, array(
	// 	'default'           => $color_scheme[5][ $i ][2],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'panel_color_headings_' . $i,
	// 		array(
	// 			'label'   => __( 'Headings Color', 'counter' ),
	// 			'section' => 'panel_' . $i,
	// 		)
	// 	)
	// );

	// Text color.
	// $wp_customize->add_setting( 'panel_color_text_' . $i, array(
	// 	'default'           => $color_scheme[5][ $i ][3],
	// 	'sanitize_callback' => 'sanitize_hex_color',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control(
	// 	new WP_Customize_Color_Control(
	// 		$wp_customize,
	// 		'panel_color_text_' . $i,
	// 		array(
	// 			'label'   => __( 'Text Color', 'counter' ),
	// 			'section' => 'panel_' . $i,
	// 		)
	// 	)
	// );

	// Divider.
	$wp_customize->add_control(
		new Counter_Divider_Control(
			$wp_customize,
			'panel_colors_divider_' . $i,
			array(
				'section' => 'panel_' . $i,
				'settings' => array(),
			)
		)
	);

	// Background image.
	$wp_customize->add_setting( 'panel_bg_image_' . $i, array(
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'panel_bg_image_' . $i,
			array(
				'label'   => __( 'Background Image', 'counter' ),
				'section' => 'panel_' . $i,
			)
		)
	);

	// Background repeat.
	$wp_customize->add_setting( 'panel_bg_repeat_' . $i, array(
		'default'           => 'no-repeat',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'counter_sanitize_background_repeat',
	) );

	$wp_customize->add_control( 'panel_bg_repeat_' . $i, array(
		'label'   => __( 'Background Repeat', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'no-repeat' => __( 'No Repeat', 'counter' ),
			'repeat'    => __( 'Tile', 'counter' ),
			'repeat-x'  => __( 'Tile Horizontally', 'counter' ),
			'repeat-y'  => __( 'Tile Vertically', 'counter' ),
		),
	) );

	// Background position.
	$wp_customize->add_setting( 'panel_bg_position_' . $i, array(
		'default'           => 'left top',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'counter_sanitize_background_position',
	) );

	$wp_customize->add_control( 'panel_bg_position_' . $i, array(
		'label'   => __( 'Background Position', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'left top'      => __( 'Left Top', 'counter' ),
			'left center'   => __( 'Left Center', 'counter' ),
			'left bottom'   => __( 'Left Bottom', 'counter' ),
			'center top'    => __( 'Center Top', 'counter' ),
			'center center' => __( 'Center Center', 'counter' ),
			'center bottom' => __( 'Center Bottom', 'counter' ),
			'right top'     => __( 'Right Top', 'counter' ),
			'right center'  => __( 'Right Center', 'counter' ),
			'right bottom'  => __( 'Right Bottom', 'counter' ),
		),
	) );

	// Background attachment.
	$wp_customize->add_setting( 'panel_bg_attachment_' . $i, array(
		'default'           => 'scroll',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'counter_sanitize_background_attachment',
	) );

	$wp_customize->add_control( 'panel_bg_attachment_' . $i, array(
		'label'   => __( 'Background Attachment', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'scroll' => __( 'Scroll', 'counter' ),
			'fixed'  => __( 'Fixed', 'counter' ),
		),
	) );

	// Background size type.
	$wp_customize->add_setting( 'panel_bg_size_type_' . $i, array(
		'default'           => 'auto',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'counter_sanitize_background_size_type',
	) );

	$wp_customize->add_control( 'panel_bg_size_type_' . $i, array(
		'label'   => __( 'Background Size', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'auto'    => __( 'Auto', 'counter' ),
			'cover'   => __( 'Cover', 'counter' ),
			'percent' => __( 'Percent', 'counter' ),
		),
	) );

	// Background size in percent.
	$wp_customize->add_setting( 'panel_bg_size_' . $i, array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'panel_bg_size_' . $i, array(
		'label'   => __( 'Background Size %', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'range',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 100,
			'step'  => 1,
		),
	) );

	// Background opacity.
	$wp_customize->add_setting( 'panel_bg_opacity_' . $i, array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'counter_sanitize_opacity_range',
	) );

	$wp_customize->add_control( 'panel_bg_opacity_' . $i, array(
		'label'   => __( 'Background Opacity', 'counter' ),
		'section' => 'panel_' . $i,
		'type'    => 'range',
		'input_attrs' => array(
			'min'   => 0,
			'max'   => 1,
			'step'  => 0.02,
		),
	) );

	endfor;

	// Blog & Archive.
	// $wp_customize->add_section( 'blog_layout', array(
	// 	'title' => __( 'Blog Layout', 'counter' ),
	// 	'panel' => 'appearance',
	// ) );

	// Layout.
	// $wp_customize->add_setting( 'blog_layout', array(
	// 	'default'           => 'default',
	// 	'sanitize_callback' => 'counter_sanitize_blog_layout',
	// ) );

	// $wp_customize->add_control( 'blog_layout', array(
	// 	'label'   => __( 'Layout', 'counter' ),
	// 	'section' => 'blog_layout',
	// 	'type'    => 'select',
	// 	'choices' => array(
	// 		'default' => __( 'Default', 'counter' ),
	// 		'grid'    => __( 'Grid', 'counter' ),
	// 	),
	// ) );

	// Entry meta items.
	// $wp_customize->add_setting( 'entry_meta_items', array(
	// 	'default'           => array( 'cat-links', 'posted-on', 'byline', 'comments-link' ),
	// 	'sanitize_callback' => 'counter_sanitize_meta_items',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize -> add_control(
	// 	new Counter_Multicheck_Control(
	// 		$wp_customize,
	// 		'entry_meta_items',
	// 		array(
	// 			'label'   => __( 'Meta', 'counter' ),
	// 			'section' => 'blog_layout',
	// 			'type'    => 'multicheck',
	// 			'choices' => array(
	// 				'cat-links'     => __( 'Category', 'counter' ),
	// 				'posted-on'     => __( 'Date', 'counter' ),
	// 				'byline'        => __( 'Author', 'counter' ),
	// 				'comments-link' => __( 'Comments', 'counter' ),
	// 			),
	// 		)
	// 	)
	// );

	// Footer Text.
	// $wp_customize->add_section( 'footer' , array(
	// 	'title' => __( 'Footer', 'counter' ),
	// ) );
	//
	// $wp_customize->add_setting( 'footer_text', array(
	// 	'default' => '',
	// 	'sanitize_callback' => 'counter_sanitize_footer_text',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control( 'footer_text', array(
	// 	'label'       => __( 'Footer Text', 'counter' ),
	// 	'section'     => 'footer',
	// 	'type'        => 'textarea',
	// 	'description' => __( 'Use [year] shortcode to display current year.', 'counter' ),
	// 	'input_attrs' => array(
	// 		'placeholder' => 'Jeez!',
	// 	),
	// ) );
}
add_action( 'customize_register', 'counter_customize_register' );

/**
 * Binds js handlers to make theme customizer preview reload changes asynchronously.
 */
function counter_customize_preview_js() {
	// Default footer message passed to the preview screen to be displayed if
	// the user erases the textarea completely.
	$default_footer_msg = sprintf(
		esc_html__( '%1$s theme by %2$s', 'counter' ),
		'Counter',
		'<a href="' . esc_url( 'https://themepatio.com/' ) . '">ThemePatio</a>'
	);

	wp_enqueue_script(
		'counter_customizer',
		get_template_directory_uri() . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		COUNTER_VERSION,
		true
	);

	wp_localize_script( 'counter_customizer', 'frontPagePanelCount', array( counter_get_panel_count() ) );
	wp_localize_script( 'counter_customizer', 'defaultFooterMsg', array( $default_footer_msg ) );
}
add_action( 'customize_preview_init', 'counter_customize_preview_js' );

/**
 * Enqueue custom scripts for customizer controls.
 */
function counter_customizer_scripts() {

	// Custom JavaScript for the Customizer controls.
	wp_register_script(
		'counter-customizer-controls',
		get_template_directory_uri() . '/assets/js/customizer-controls.js',
		array( 'jquery', 'customize-controls' ),
		COUNTER_VERSION,
		true
	);
	wp_localize_script( 'counter-customizer-controls', 'pnlCountControls', array( counter_get_panel_count() ) );

	// Color controls.
	wp_register_script(
		'counter-customizer-controls-color',
		get_template_directory_uri() . '/assets/js/customizer-controls-color.js',
		array( 'jquery', 'customize-controls', 'iris', 'wp-util' ),
		COUNTER_VERSION,
		true
	);
	wp_localize_script( 'counter-customizer-controls-color', 'colorScheme', counter_get_color_schemes() );
	wp_localize_script( 'counter-customizer-controls-color', 'pnlCountColor', array( counter_get_panel_count() ) );

	// Spacing controls.
	wp_register_script(
		'counter-customizer-controls-panel-spacings',
		get_template_directory_uri() . '/assets/js/customizer-controls-panel-spacings.js',
		array( 'jquery', 'customize-controls', 'iris', 'wp-util' ),
		COUNTER_VERSION,
		true
	);
	wp_localize_script( 'counter-customizer-controls-panel-spacings', 'pnlCountSpacings', array( counter_get_panel_count() ) );

	wp_enqueue_script( 'counter-customizer-controls' );
	wp_enqueue_script( 'counter-customizer-controls-color' );
	wp_enqueue_script( 'counter-customizer-controls-panel-spacings' );

	// Custom CSS for the Customizer controls.
	wp_enqueue_style(
		'counter-customizer-styles',
		get_template_directory_uri() . '/assets/css/customizer.css'
	);
}
add_action( 'customize_controls_enqueue_scripts', 'counter_customizer_scripts' );
