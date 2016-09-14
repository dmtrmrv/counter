<?php
/**
 * Owner Theme Customizer
 *
 * @package Owner
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function owner_customize_register( $wp_customize ) {
	$color_scheme = owner_get_color_scheme();

	// Make site title and site description update instantly.
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Rearrange controls.
	// $wp_customize->get_section( 'colors' )->panel = 'appearance';
	$wp_customize->get_section( 'static_front_page' )->panel = 'frontpage';

	// Rename Static Front Page Section.
	$wp_customize->get_section( 'static_front_page' )->title = __( 'Choose Front Page', 'owner' );
	$wp_customize->get_section( 'static_front_page' )->description = false;

	// Appearance panel.
	// $wp_customize->add_panel( 'appearance' , array(
	// 	'title'    => __( 'Appearance', 'owner' ),
	// 	'priority' => 30,
	// ) );

	/**
	 * Site Identity.
	 */

	// Display Title.
	$wp_customize->add_setting( 'display_title', array(
		'default' => true,
		'sanitize_callback' => 'owner_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'display_title', array(
		'label'   => __( 'Display Title', 'owner' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	) );

	// Display Tagline.
	$wp_customize->add_setting( 'display_tagline', array(
		'default' => true,
		'sanitize_callback' => 'owner_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'display_tagline', array(
		'label'   => __( 'Display Tagline', 'owner' ),
		'section' => 'title_tagline',
		'type'    => 'checkbox',
	) );

	/**
	 * Colors.
	 */

	// Add color scheme setting and control.
	// $wp_customize->add_setting( 'color_scheme', array(
	// 	'default'           => 'default',
	// 	'sanitize_callback' => 'owner_sanitize_color_scheme',
	// 	'transport'         => 'postMessage',
	// ) );

	// $wp_customize->add_control( 'color_scheme', array(
	// 	'label'    => __( 'Color Scheme', 'owner' ),
	// 	'section'  => 'colors',
	// 	'type'     => 'select',
	// 	'choices'  => owner_get_color_scheme_choices(),
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
	// 			'label'   => __( 'Background', 'owner' ),
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
	// 			'label'   => __( 'Accent', 'owner' ),
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
	// 			'label'   => __( 'Headings', 'owner' ),
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
	// 			'label'   => __( 'Text', 'owner' ),
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
		'title'    => __( 'Static Front Page', 'owner' ),
		'priority' => 110,
	) );

	$wp_customize->add_section( new Owner_Frontpage_Visibility_Section( $wp_customize, 'frontpage_invisible', array(
		'title'           => __( 'Navigate to Front Page', 'owner' ),
		'panel'           => 'frontpage',
		'active_callback' => 'owner_not_front_page',
	) ) );

	$wp_customize -> add_control(
		new Owner_Message_Control(
			$wp_customize,
			'frontpage_invisible',
			array(
				'label'       => __( 'Navigate to Front Page', 'owner' ),
				'section'     => 'frontpage_invisible',
				'settings'    => array(),
				'description' => __( 'To edit the front page navigate to it in the preview screen.', 'owner' ),
			)
		)
	);

	for ( $i = 1; $i <= owner_get_panel_count(); $i++ ) :

	$wp_customize->add_section( 'panel_' . $i, array(
		'title'           => __( 'Panel ', 'owner' ) . $i,
		'panel'           => 'frontpage',
		'active_callback' => 'owner_is_front_page',
	) );

	// Page Dropdown.
	$wp_customize->add_setting( 'panel_content_' . $i, array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'panel_content_' . $i, array(
		'label'   => esc_html__( 'Content', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'dropdown-pages',
	) );

	// Divider.
	$wp_customize->add_control(
		new Owner_Divider_Control(
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
		'sanitize_callback' => 'owner_sanitize_panel_layout',
	) );

	$wp_customize->add_control( 'panel_layout_' . $i, array(
		'label'   => esc_html__( 'Layout', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => owner_get_panel_types(),
	) );

	// Title Display.
	$wp_customize->add_setting( 'panel_title_display_' . $i, array(
		'default'           => 1,
		'sanitize_callback' => 'owner_sanitize_checkbox',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'panel_title_display_' . $i, array(
		'label'   => esc_html__( 'Display Title?', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'checkbox',
	) );

	// Panel title alignment.
	$wp_customize->add_setting( 'panel_title_alignment_' . $i, array(
		'default'           => 'left',
		'sanitize_callback' => 'owner_sanitize_alignment',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'panel_title_alignment_' . $i, array(
		'label'   => esc_html__( 'Title Alignment', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'left'   => __( 'Left', 'owner' ),
			'center' => __( 'Center', 'owner' ),
			'right'  => __( 'Right', 'owner' ),
		),
	) );

	// Panel text alignment.
	$wp_customize->add_setting( 'panel_text_alignment_' . $i, array(
		'default'           => 'left',
		'sanitize_callback' => 'owner_sanitize_alignment',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'panel_text_alignment_' . $i, array(
		'label'   => esc_html__( 'Text Alignment', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'left'   => __( 'Left', 'owner' ),
			'center' => __( 'Center', 'owner' ),
			'right'  => __( 'Right', 'owner' ),
		),
	) );

	// Spacing.
	$wp_customize->add_setting( 'panel_spacing_' . $i, array(
		'default'           => 0,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'panel_spacing_' . $i, array(
		'label'   => __( 'Panel Spacing', 'owner' ),
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
	// 	new Owner_Divider_Control(
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
	// 			'label'   => __( 'Background Color', 'owner' ),
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
	// 			'label'   => __( 'Accent Color', 'owner' ),
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
	// 			'label'   => __( 'Headings Color', 'owner' ),
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
	// 			'label'   => __( 'Text Color', 'owner' ),
	// 			'section' => 'panel_' . $i,
	// 		)
	// 	)
	// );

	// Divider.
	$wp_customize->add_control(
		new Owner_Divider_Control(
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
				'label'   => __( 'Background Image', 'owner' ),
				'section' => 'panel_' . $i,
			)
		)
	);

	// Background repeat.
	$wp_customize->add_setting( 'panel_bg_repeat_' . $i, array(
		'default'           => 'no-repeat',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'owner_sanitize_background_repeat',
	) );

	$wp_customize->add_control( 'panel_bg_repeat_' . $i, array(
		'label'   => __( 'Background Repeat', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'no-repeat' => __( 'No Repeat', 'owner' ),
			'repeat'    => __( 'Tile', 'owner' ),
			'repeat-x'  => __( 'Tile Horizontally', 'owner' ),
			'repeat-y'  => __( 'Tile Vertically', 'owner' ),
		),
	) );

	// Background position.
	$wp_customize->add_setting( 'panel_bg_position_' . $i, array(
		'default'           => 'left top',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'owner_sanitize_background_position',
	) );

	$wp_customize->add_control( 'panel_bg_position_' . $i, array(
		'label'   => __( 'Background Position', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'left top'      => __( 'Left Top', 'owner' ),
			'left center'   => __( 'Left Center', 'owner' ),
			'left bottom'   => __( 'Left Bottom', 'owner' ),
			'center top'    => __( 'Center Top', 'owner' ),
			'center center' => __( 'Center Center', 'owner' ),
			'center bottom' => __( 'Center Bottom', 'owner' ),
			'right top'     => __( 'Right Top', 'owner' ),
			'right center'  => __( 'Right Center', 'owner' ),
			'right bottom'  => __( 'Right Bottom', 'owner' ),
		),
	) );

	// Background attachment.
	$wp_customize->add_setting( 'panel_bg_attachment_' . $i, array(
		'default'           => 'scroll',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'owner_sanitize_background_attachment',
	) );

	$wp_customize->add_control( 'panel_bg_attachment_' . $i, array(
		'label'   => __( 'Background Attachment', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'scroll' => __( 'Scroll', 'owner' ),
			'fixed'  => __( 'Fixed', 'owner' ),
		),
	) );

	// Background size type.
	$wp_customize->add_setting( 'panel_bg_size_type_' . $i, array(
		'default'           => 'auto',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'owner_sanitize_background_size_type',
	) );

	$wp_customize->add_control( 'panel_bg_size_type_' . $i, array(
		'label'   => __( 'Background Size', 'owner' ),
		'section' => 'panel_' . $i,
		'type'    => 'select',
		'choices' => array(
			'auto'    => __( 'Auto', 'owner' ),
			'cover'   => __( 'Cover', 'owner' ),
			'percent' => __( 'Percent', 'owner' ),
		),
	) );

	// Background size in percent.
	$wp_customize->add_setting( 'panel_bg_size_' . $i, array(
		'default'           => 1,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'panel_bg_size_' . $i, array(
		'label'   => __( 'Background Size %', 'owner' ),
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
		'sanitize_callback' => 'owner_sanitize_opacity_range',
	) );

	$wp_customize->add_control( 'panel_bg_opacity_' . $i, array(
		'label'   => __( 'Background Opacity', 'owner' ),
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
	// 	'title' => __( 'Blog Layout', 'owner' ),
	// 	'panel' => 'appearance',
	// ) );

	// Layout.
	// $wp_customize->add_setting( 'blog_layout', array(
	// 	'default'           => 'default',
	// 	'sanitize_callback' => 'owner_sanitize_blog_layout',
	// ) );

	// $wp_customize->add_control( 'blog_layout', array(
	// 	'label'   => __( 'Layout', 'owner' ),
	// 	'section' => 'blog_layout',
	// 	'type'    => 'select',
	// 	'choices' => array(
	// 		'default' => __( 'Default', 'owner' ),
	// 		'grid'    => __( 'Grid', 'owner' ),
	// 	),
	// ) );

	// Entry meta items.
	// $wp_customize->add_setting( 'entry_meta_items', array(
	// 	'default'           => array( 'cat-links', 'posted-on', 'byline', 'comments-link' ),
	// 	'sanitize_callback' => 'owner_sanitize_meta_items',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize -> add_control(
	// 	new Owner_Multicheck_Control(
	// 		$wp_customize,
	// 		'entry_meta_items',
	// 		array(
	// 			'label'   => __( 'Meta', 'owner' ),
	// 			'section' => 'blog_layout',
	// 			'type'    => 'multicheck',
	// 			'choices' => array(
	// 				'cat-links'     => __( 'Category', 'owner' ),
	// 				'posted-on'     => __( 'Date', 'owner' ),
	// 				'byline'        => __( 'Author', 'owner' ),
	// 				'comments-link' => __( 'Comments', 'owner' ),
	// 			),
	// 		)
	// 	)
	// );

	// Footer Text.
	// $wp_customize->add_section( 'footer' , array(
	// 	'title' => __( 'Footer', 'owner' ),
	// ) );
	//
	// $wp_customize->add_setting( 'footer_text', array(
	// 	'default' => '',
	// 	'sanitize_callback' => 'owner_sanitize_footer_text',
	// 	'transport'         => 'postMessage',
	// ) );
	//
	// $wp_customize->add_control( 'footer_text', array(
	// 	'label'       => __( 'Footer Text', 'owner' ),
	// 	'section'     => 'footer',
	// 	'type'        => 'textarea',
	// 	'description' => __( 'Use [year] shortcode to display current year.', 'owner' ),
	// 	'input_attrs' => array(
	// 		'placeholder' => 'Jeez!',
	// 	),
	// ) );
}
add_action( 'customize_register', 'owner_customize_register' );

/**
 * Binds js handlers to make theme customizer preview reload changes asynchronously.
 */
function owner_customize_preview_js() {
	// Default footer message passed to the preview screen to be displayed if
	// the user erases the textarea completely.
	$default_footer_msg = sprintf(
		esc_html__( '%1$s theme by %2$s', 'owner' ),
		'Owner',
		'<a href="' . esc_url( 'https://themepatio.com/' ) . '">ThemePatio</a>'
	);

	wp_enqueue_script(
		'owner_customizer',
		get_template_directory_uri() . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		OWNER_VERSION,
		true
	);

	wp_localize_script( 'owner_customizer', 'frontPagePanelCount', array( owner_get_panel_count() ) );
	wp_localize_script( 'owner_customizer', 'defaultFooterMsg', array( $default_footer_msg ) );
}
add_action( 'customize_preview_init', 'owner_customize_preview_js' );

/**
 * Enqueue custom scripts for customizer controls.
 */
function owner_customizer_scripts() {

	// Custom JavaScript for the Customizer controls.
	wp_register_script(
		'owner-customizer-controls',
		get_template_directory_uri() . '/assets/js/customizer-controls.js',
		array( 'jquery', 'customize-controls' ),
		OWNER_VERSION,
		true
	);
	wp_localize_script( 'owner-customizer-controls', 'pnlCountControls', array( owner_get_panel_count() ) );

	// Color controls.
	wp_register_script(
		'owner-customizer-controls-color',
		get_template_directory_uri() . '/assets/js/customizer-controls-color.js',
		array( 'jquery', 'customize-controls', 'iris', 'wp-util' ),
		OWNER_VERSION,
		true
	);
	wp_localize_script( 'owner-customizer-controls-color', 'colorScheme', owner_get_color_schemes() );
	wp_localize_script( 'owner-customizer-controls-color', 'pnlCountColor', array( owner_get_panel_count() ) );

	// Spacing controls.
	wp_register_script(
		'owner-customizer-controls-panel-spacings',
		get_template_directory_uri() . '/assets/js/customizer-controls-panel-spacings.js',
		array( 'jquery', 'customize-controls', 'iris', 'wp-util' ),
		OWNER_VERSION,
		true
	);
	wp_localize_script( 'owner-customizer-controls-panel-spacings', 'pnlCountSpacings', array( owner_get_panel_count() ) );

	wp_enqueue_script( 'owner-customizer-controls' );
	wp_enqueue_script( 'owner-customizer-controls-color' );
	wp_enqueue_script( 'owner-customizer-controls-panel-spacings' );

	// Custom CSS for the Customizer controls.
	wp_enqueue_style(
		'owner-customizer-styles',
		get_template_directory_uri() . '/assets/css/customizer.css'
	);
}
add_action( 'customize_controls_enqueue_scripts', 'owner_customizer_scripts' );
