<?php
/**
 * Counter Theme Customizer
 *
 * @package Counter
 */

/**
 * Add options to Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function counter_customize_register( $wp_customize ) {
	/**
	 * Site Identity.
	 */
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_text' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'counter_customize_partial_blogname',
	) );

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'counter_customize_partial_blogdescription',
	) );

	/**
	 * Colors.
	 */
	$wp_customize->add_control(
		new Counter_Message_Control(
			$wp_customize,
			'color_upgrade',
			array(
				'label'       => __( 'Custom Colors', 'counter' ),
				'section'     => 'colors',
				'settings'    => array(),
				'link_url'    => 'https://themepatio.com/themes/counter?utm_source=counter-lite&utm_medium=colors',
				'link_text'   => __( 'Learn More', 'counter' ),
				'description' => __( 'Upgrade Counter to set custom text, links, headings, and background color.', 'counter' ),
			)
		)
	);

	/*
	 * Theme Options.
	 */

	$wp_customize->add_panel( 'theme_options' , array(
		'title'    => __( 'Theme Options', 'counter' ),
		'priority' => 140,
	) );

	// Blog & Archive.
	$wp_customize->add_section( 'blog_layout', array(
		'title' => __( 'Blog Layout', 'counter' ),
		'panel' => 'theme_options',
	) );

	$wp_customize->add_control(
		new Counter_Message_Control(
			$wp_customize,
			'blog_layout_upgrade',
			array(
				'label'       => __( 'Blog Layout & Post Meta', 'counter' ),
				'section'     => 'blog_layout',
				'settings'    => array(),
				'link_url'    => 'https://themepatio.com/themes/counter?utm_source=counter-lite&utm_medium=blog-layout',
				'link_text'   => __( 'Learn More', 'counter' ),
				'description' => __( 'Upgrade Counter to set three-column grid blog layout and edit post meta.', 'counter' ),
			)
		)
	);

	/**
	 * Front Page.
	 */

	for ( $i = 0; $i <= counter_get_panel_count(); $i++ ) :

	$wp_customize->add_section( 'panel_' . $i, array(
		'title'           => 0 == $i ? __( 'Hero Panel', 'counter' ) : __( 'Panel ', 'counter' ) . $i,
		'panel'           => 'theme_options',
		'active_callback' => 'counter_is_front_page',
	) );

	// Page Dropdown. Don't need it for Hero panel.
	if ( 0 !== $i ) :

		$wp_customize->add_setting( 'panel_content_' . $i, array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'panel_content_' . $i, array(
			'label'   => esc_html__( 'Content', 'counter' ),
			'section' => 'panel_' . $i,
			'type'    => 'dropdown-pages',
		) );

	endif;

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
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
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

	$wp_customize->add_control(
		new Counter_Message_Control(
			$wp_customize,
			'panel_number_upgrade_' . $i,
			array(
				'section'     => 'panel_' . $i,
				'link_url'    => 'https://themepatio.com/themes/counter?utm_source=counter-lite&utm_medium=more-panels',
				'settings'    => array(),
				'link_text'   => __( 'Updgrade Counter', 'counter' ),
				'description' => __( 'Need more than four panels?', 'counter' ),
			)
		)
	);

	endfor;

	// Footer Text.
	$wp_customize->add_section( 'footer' , array(
		'title' => __( 'Footer', 'counter' ),
		'panel' => 'theme_options'
	) );

	$wp_customize->add_control(
		new Counter_Message_Control(
			$wp_customize,
			'footer_text_upgrade',
			array(
				'label'       => __( 'Custom Footer Text', 'counter' ),
				'section'     => 'footer',
				'link_url'    => 'https://themepatio.com/themes/counter?utm_source=counter-lite&utm_medium=footer-text',
				'settings'    => array(),
				'link_text'   => __( 'Learn More', 'counter' ),
				'description' => __( 'Upgrade Counter to set custom footer text.', 'counter' ),
			)
		)
	);
}
add_action( 'customize_register', 'counter_customize_register' );

/**
 * Binds js handlers to make theme customizer preview reload changes asynchronously.
 */
function counter_customize_preview_js() {
	wp_enqueue_script(
		'counter_customizer',
		get_template_directory_uri() . '/assets/js/customizer-preview.js',
		array( 'customize-preview' ),
		COUNTER_VERSION,
		true
	);
	wp_localize_script( 'counter_customizer', 'frontPagePanelCount', array( counter_get_panel_count() ) );
}
add_action( 'customize_preview_init', 'counter_customize_preview_js' );

/**
 * Enqueue custom scripts for customizer controls.
 */
function counter_customizer_scripts() {
	wp_enqueue_script(
		'counter-customizer-controls',
		get_template_directory_uri() . '/assets/js/customizer-controls.js',
		array( 'jquery', 'customize-controls' ),
		COUNTER_VERSION,
		true
	);
	wp_localize_script( 'counter-customizer-controls', 'frontPagePanelCount', array( counter_get_panel_count() ) );

	// Custom CSS for the Customizer controls.
	wp_enqueue_style(
		'counter-customizer-styles',
		get_template_directory_uri() . '/assets/css/customizer.css'
	);
}
add_action( 'customize_controls_enqueue_scripts', 'counter_customizer_scripts' );
