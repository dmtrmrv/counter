<?php
/**
 * Counter functions and definitions
 *
 * @package Counter
 */

/**
 * The current version of the theme.
 */
define( 'COUNTER_VERSION', '1.3.0' );

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

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function counter_setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'counter', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for theme logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 648,
		'height'      => 324,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => true,
	) );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Add necessary image sizes.
	add_image_size( 'counter-thumbnail', 612, 0, false );
	add_image_size( 'counter-thumbnail-2x', 1224, 0, false );

	add_image_size( 'counter-thumbnail-full', 936, 0, false );
	add_image_size( 'counter-thumbnail-full-2x', 1872, 0, false );

	add_image_size( 'counter-panel', 1440, 0, false );
	add_image_size( 'counter-panel-2x', 2880, 0, false );
	add_image_size( 'counter-panel-half', 720, 0, false );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary', 'counter' ),
	) );

	// Switch default core markup to output valid HTML5 for listed components.
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add support for Jetpack responsive videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// This theme styles the visual editor to resemble theme styles.
	add_editor_style( array( 'assets/css/editor-style.css' ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		// Add pages.
		'posts' => array(
			'about',
			'blog',
			'contact',
			'hero' => array(
				'post_type' => 'page',
				'post_title' => esc_html_x( 'Coffee &amp; Pastry', 'Theme starter content', 'counter' ),
				'post_content' => join( '', array(
					'<p>' . esc_html_x( 'Come in and get a taste of our great coffee with pastries, baked daily with locally milled organic flours', 'Theme starter content', 'counter' ) . '</p>',
					'<p><a href="#" class="btn btn-default">' . esc_html_x( 'View the Menu', 'Theme starter content', 'counter' ) . '</a></p>',
				) ),
			),
			'menu' => array(
				'post_type' => 'page',
				'post_title' => esc_html_x( 'Menu', 'Theme starter content', 'counter' ),
				'post_content' => join( '', array(
					'<h5>' . esc_html_x( 'Americano 2.5', 'Theme starter content', 'counter' ) . '</h5><p>' . esc_html_x( 'Prepared by brewing espresso with added hot water. The strength varies with the number of shots of espresso and the amount of water.', 'Theme starter content', 'counter' ) . '</p>',
					'<h5>' . esc_html_x( 'Espresso 2.5', 'Theme starter content', 'counter' ) . '</h5><p>' . esc_html_x( 'Generally thicker than coffee brewed by other methods. Has a higher concentration of suspended and dissolved solids.', 'Theme starter content', 'counter' ) . '</p>',
					'<h5>' . esc_html_x( 'Cappucino 3.5', 'Theme starter content', 'counter' ) . '</h5><p>' . esc_html_x( 'Composed of espresso and hot milk, with the surface topped with foamed milk. Cream may be used instead of milk and is often topped with cinnamon.', 'Theme starter content', 'counter' ) . '</p>',
					'<h5>' . esc_html_x( 'Latte 4', 'Theme starter content', 'counter' ) . '</h5><p>' . esc_html_x( 'Made with espresso and steamed milk. The term as used in English is a shortened form of the Italian caff&egrave; latte, which means milk coffee.', 'Theme starter content', 'counter' ) . '</p>',
					'<p><a href="#">' . esc_html_x( 'View the full menu &rarr;', 'Theme starter content', 'counter' ) . '</a></p>',
				) ),
			),
			'coffee' => array(
				'post_type' => 'page',
				'post_title' => esc_html_x( 'Finest Coffee', 'Theme starter content', 'counter' ),
				'post_content' => join( '', array(
					'<p>' . esc_html_x( 'It\'s our pleasure to find beautiful coffees, hand-roast them in our vintage steel roaster, and offer them to you.', 'Theme starter content', 'counter' ) . '</p>',
					'<p><a href="#">' . esc_html_x( 'Learn more &rarr;', 'Theme starter content', 'counter' ) . '</a></p>',
				) ),
				'thumbnail' => '{{image-coffee}}',
			),
			'pastry' => array(
				'post_type' => 'page',
				'post_title' => esc_html_x( 'Delicious Pastries', 'Theme starter content', 'counter' ),
				'post_content' => join( '', array(
					'<p>' . esc_html_x( 'Our pastries are baked daily with locally milled organic flours. Muffins, cakes, and tarts vary with the seasons.', 'Theme starter content', 'counter' ) . '</p>',
					'<p><a href="#">' . esc_html_x( 'Learn more &rarr;', 'Theme starter content', 'counter' ) . '</a></p>',
				) ),
				'thumbnail' => '{{image-pastry}}',
			),
			'visit-us' => array(
				'post_type' => 'page',
				'post_title' => esc_html_x( 'Come Visit Us!', 'Theme starter content', 'counter' ),
				'post_content' => join( '', array(
					'<p>' . esc_html_x( 'Stop by our coffee shop, we\'ll be glad to see you from 7am to 7pm on weekdays and from 8am to 6pm on weekends.', 'Theme starter content', 'counter' ) . '</p>',
					'<p><a href="#" class="btn btn-default">' . esc_html_x( 'View on the map', 'Theme starter content', 'counter' ) . '</a></p>',
				) ),
			),
		),

		// Add attachments.
		'attachments' => array(
			'image-coffee-pastry' => array(
				'post_title' => esc_html_x( 'Coffee &amp; Pastry', 'Theme starter content', 'counter' ),
				'file' => 'assets/img/coffee-pastry.jpg',
			),
			'image-coffee' => array(
				'post_title' => esc_html_x( 'Coffee', 'Theme starter content', 'counter' ),
				'file' => 'assets/img/coffee.jpg',
			),
			'image-pastry' => array(
				'post_title' => esc_html_x( 'Pastry', 'Theme starter content', 'counter' ),
				'file' => 'assets/img/pastry.jpg',
			),
			'image-visit-us' => array(
				'post_title' => esc_html_x( 'Visit Us', 'Theme starter content', 'counter' ),
				'file' => 'assets/img/visit-us.jpg',
			),
		),

		// Add widgets.
		'widgets' => array(
			'sidebar-1' => array(
				'text_about',
				'cafe' => array(
					'text',
					array(
						'title' => esc_html_x( 'Cafe', 'Theme starter content', 'counter' ),
						'text' => '<p>' . esc_html_x( '123 Main Street', 'Theme starter content', 'counter' ) . '<br />' . esc_html_x( 'New York, NY 10001', 'Theme starter content', 'counter' ) . '</p>',
					),
				),
				'roastery' => array(
					'text',
					array(
						'title' => esc_html_x( 'Roastery', 'Theme starter content', 'counter' ),
						'text' => '<p>' . esc_html_x( '321 Second Street', 'Theme starter content', 'counter' ) . '<br />' . esc_html_x( 'Brooklyn, NY 11230', 'Theme starter content', 'counter' ) . '</p>',
					),
				),
			),
			'sidebar-2' => array(
				'cafe' => array(
					'text',
					array(
						'title' => esc_html_x( 'Cafe', 'Theme starter content', 'counter' ),
						'text' => '<p>' . esc_html_x( '123 Main Street', 'Theme starter content', 'counter' ) . '<br />' . esc_html_x( 'New York, NY 10001', 'Theme starter content', 'counter' ) . '</p>',
					),
				),
			),
			'sidebar-3' => array(
				'roastery' => array(
					'text',
					array(
						'title' => esc_html_x( 'Roastery', 'Theme starter content', 'counter' ),
						'text' => '<p>' . esc_html_x( '321 Second Street', 'Theme starter content', 'counter' ) . '<br />' . esc_html_x( 'Brooklyn, NY 11230', 'Theme starter content', 'counter' ) . '</p>',
					),
				),
			),
			'sidebar-4' => array(
				'hours' => array(
					'text',
					array(
						'title' => esc_html_x( 'Hours', 'Theme starter content', 'counter' ),
						'text' => '<p>' . esc_html_x( 'Mon&ndash;Fri: 7am&ndash;7pm', 'Theme starter content', 'counter' ) . '<br />' . esc_html_x( 'Sat&ndash;Sun: 8am&ndash;6pm', 'Theme starter content', 'counter' ) . '</p>',
					),
				),
			),
			'sidebar-5' => array(
				'contact' => array(
					'text',
					array(
						'title' => esc_html_x( 'Contact', 'Theme starter content', 'counter' ),
						'text' => '<p>' . esc_html_x( 'info@example.com', 'Theme starter content', 'counter' ) . '<br />' . esc_html_x( '(212) 123-4567', 'Theme starter content', 'counter' ) . '</p>',
					),
				),
			),
		),

		// Set the options.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{hero}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the theme mods.
		'theme_mods' => array(
			// Panlel 0.
			'panel_class_0' => 'tall dark align-center no-border',
			'panel_bg_image_0' => '{{image-coffee-pastry}}',
			'panel_bg_repeat_0' => 'no-repeat',
			'panel_bg_position_0' => 'center center',
			'panel_bg_attachment_0' => 'scroll',
			'panel_bg_attachment_0' => 'scroll',
			'panel_bg_size_type_0' => 'cover',

			// Panel 1.
			'panel_content_1' => '{{menu}}',
			'panel_class_1' => 'align-center no-border',

			// Panel 2.
			'panel_content_2' => '{{coffee}}',
			'panel_class_2' => 'split-left dark align-center no-border',

			// Panel 3.
			'panel_content_3' => '{{pastry}}',
			'panel_class_3' => 'split-right align-center no-border',

			// Panel 4.
			'panel_content_4' => '{{visit-us}}',
			'panel_class_4' => 'tall dark align-center',
			'panel_bg_image_4' => '{{image-visit-us}}',
			'panel_bg_repeat_4' => 'no-repeat',
			'panel_bg_position_4' => 'center center',
			'panel_bg_attachment_4' => 'scroll',
			'panel_bg_attachment_4' => 'scroll',
			'panel_bg_size_type_4' => 'cover',
		),

		// Set up menus.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'primary' => array(
				'name' => __( 'Primary', 'counter' ),
				'items' => array(
					'link_home',
					'page_menu' => array(
						'type' => 'post_type',
						'object' => 'page',
						'object_id' => '{{menu}}',
					),
					'page_blog',
					'page_about',
					'page_contact',
				),
			),
		),
	);

	/**
	 * Filters the array of starter content.
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'counter_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}

add_action( 'after_setup_theme', 'counter_setup' );

/**
 * Register widget area.
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

	// Footer widgets.
	for ( $i = 2; $i <= 5; $i++ ) :

	register_sidebar( array(
		'name'          => __( 'Footer', 'counter' ) . ' ' . ( $i - 1 ),
		'id'            => 'sidebar-' . $i,
		'description'   => __( 'Appears in the footer.', 'counter' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );

	endfor;
}
add_action( 'widgets_init', 'counter_widgets_init' );

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
		$fonts[] = 'Lato:400,700,400italic,700italic';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return apply_filters( 'counter_fonts_url', $fonts_url );
}

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
	wp_enqueue_style(
		'counter-fonts',
		counter_fonts_url()
	);

	wp_enqueue_style(
		'counter-font-awesome',
		get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.css'
	);

	wp_enqueue_style(
		'counter-style',
		get_stylesheet_uri()
	);

	wp_style_add_data( 'counter-style', 'rtl', 'replace' );

	wp_enqueue_script(
		'jquery-scrollto',
		get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ),
		array( 'jquery' ),
		'2.1.2',
		true
	);

	wp_enqueue_script(
		'counter-navigation',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array( 'jquery' ),
		COUNTER_VERSION,
		true
	);

	wp_enqueue_script(
		'counter-skip-link-focus-fix',
		get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js',
		array(),
		COUNTER_VERSION,
		true
	);

	wp_enqueue_script(
		'counter-custom',
		get_template_directory_uri() . '/assets/js/custom.js',
		array( 'jquery' ),
		COUNTER_VERSION,
		true
	);

	wp_localize_script( 'counter-navigation', 'counterScreenReaderText', array(
		'menu' => esc_html__( 'Menu', 'counter' ),
		'close' => esc_html__( 'Close', 'counter' ),
		'expand' => '<span class="screen-reader-text">' . esc_html__( 'Expand child menu', 'counter' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . esc_html__( 'Collapse child menu', 'counter' ) . '</span>',
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Deregister styles for Jetpack's Infinite Scroll.
	if ( wp_style_is( 'the-neverending-homepage', 'registered' ) ) {
		wp_deregister_style( 'the-neverending-homepage' );
	}

	// Deregister styles for Contact Form 7.
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
 * Customizer.
 */
require get_template_directory() . '/inc/class-counter-customize-control-message.php';
require get_template_directory() . '/inc/customizer-sanitization.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function counter_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template', 'counter_front_page_template' );

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
