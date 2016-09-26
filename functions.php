<?php
/**
 * Counter functions and definitions
 *
 * @package Counter
 */

/**
 * The current version of the theme.
 */
define( 'COUNTER_VERSION', '1.0.1' );

/**
 * Sets the content width in pixels.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function counter_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'counter_content_width', 936 );
}
add_action( 'after_setup_theme', 'counter_content_width', 0 );

if ( ! function_exists( 'counter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function counter_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'counter', get_template_directory() . '/languages' );

	/*
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for theme logo.
	 */
	add_theme_support( 'custom-logo', array(
		'width'       => 648,
		'height'      => 324,
		'flex-width'  => true,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add necessary image sizes.
	 */
	add_image_size( 'counter-thumbnail',        '612',  '9999', false );
	add_image_size( 'counter-thumbnail-grid',   '612',  '414',  true );
	add_image_size( 'counter-thumbnail-single', '936',  '9999', false );
	add_image_size( 'counter-panel-half',       '720',  '9999', false );
	add_image_size( 'counter-panel-full',       '1440', '9999', false );
	add_image_size( 'counter-panel-double',     '2880', '9999', false );

	/*
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary', 'counter' ),
	) );

	/*
	 * Switch default core markup to output valid HTML5 for listed components.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * This theme styles the visual editor to resemble theme styles.
	 */
	add_editor_style( array( 'assets/css/editor-style.css' ) );
}
endif;

add_action( 'after_setup_theme', 'counter_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function counter_widgets_init() {
	// Sidebar.
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'counter' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears on posts and pages', 'counter' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	// Five footer widgets.
	for ( $i = 1; $i <= 4; $i++ ) :

	register_sidebar( array(
		'name'          => __( 'Footer', 'counter' ) . ' ' . $i,
		'id'            => 'footer-' . $i,
		'description'   => __( 'Appears in the footer.', 'counter' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	endfor;
}
add_action( 'widgets_init', 'counter_widgets_init' );

if ( ! function_exists( 'counter_fonts_url' ) ) :
/**
 * Register Google fonts for Counter.
 *
 * @return string Google fonts URL for the theme.
 */
function counter_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Lato or Open Sans, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'counter' ) ) {
		$fonts[] = 'Open Sans:400,400i,700,700i';
	}

	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'counter' ) ) {
		$fonts[] = 'Lato:300,400,700,300italic,400italic,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 */
function counter_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'counter_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 */
function counter_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style(
		'counter-fonts',
		counter_fonts_url()
	);

	wp_enqueue_style(
		'counter-fontello',
		get_template_directory_uri() . '/assets/fonts/fontello/css/fontello.css'
	);

	wp_enqueue_style(
		'counter-style',
		get_stylesheet_uri()
	);

	wp_enqueue_script(
		'counter-navigation',
		get_template_directory_uri() . '/assets/js/src/navigation.js',
		array(),
		COUNTER_VERSION,
		true
	);

	wp_enqueue_script(
		'counter-sticky-navigation',
		get_template_directory_uri() . '/assets/js/src/sticky-nav.js',
		array(),
		COUNTER_VERSION,
		true
	);

	wp_enqueue_script(
		'counter-skip-link-focus-fix',
		get_template_directory_uri() . '/assets/js/src/skip-link-focus-fix.js',
		array(),
		COUNTER_VERSION,
		true
	);

	wp_enqueue_script(
		'counter-fitvids',
		get_template_directory_uri() . '/assets/js/src/jquery.fitvids.js',
		array( 'jquery' ),
		COUNTER_VERSION,
		true
	);

	wp_enqueue_script(
		'counter-custom',
		get_template_directory_uri() . '/assets/js/src/custom.js',
		array( 'jquery' ),
		COUNTER_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/*
	 * We have styles for Jetpack infinite scroll.
	 * Let's save one request and some bandwidth. Shall we?
	 */
	if ( wp_style_is( 'the-neverending-homepage', 'registered' ) ) {
		wp_deregister_style( 'the-neverending-homepage' );
	}

	/*
	 * Do the same thing with Contact Form 7.
	 */
	if ( wp_style_is( 'contact-form-7', 'registered' ) ) {
		wp_deregister_style( 'contact-form-7' );
	}
}
add_action( 'wp_enqueue_scripts', 'counter_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */

// Customizer section class needed to create custom section.
require_once( ABSPATH . WPINC . '/class-wp-customize-section.php' );
require get_template_directory() . '/inc/customizer-sanitization.php';
require get_template_directory() . '/inc/customizer-sections.php';
require get_template_directory() . '/inc/customizer-controls.php';
require get_template_directory() . '/inc/customizer-custom-css.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Widget options.
 */
require get_template_directory() . '/inc/widget-options.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Subtitles compatibility file.
 */
if ( class_exists( 'Subtitles' ) ) {
	require get_template_directory() . '/inc/subtitles.php';
}

/**
 * Theme Info Screen
 */
if ( is_admin() ) {
	require get_template_directory() . '/inc/theme-info-screen/theme-info-screen.php';
}
