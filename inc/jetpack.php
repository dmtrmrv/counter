<?php
/**
 * Jetpack Compatibility File
 *
 * @package Counter
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function counter_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'posts_per_page' => get_option( 'posts_per_page', 9 ),
		'footer_widgets' => array( 'sidebar-2', 'sidebar-3', 'sidebar-4', 'sidebar-5' ),
		'container'      => 'primary',
		'wrapper'        => false,
		'render'         => 'counter_infinite_scroll_render',
		'footer'         => false,
	) );
}
if ( ! is_customize_preview() ) {
	add_action( 'after_setup_theme', 'counter_jetpack_setup' );
}

/**
 * Loads necessary template part during the infinite scroll.
 */
function counter_infinite_scroll_render() {
	while ( have_posts() ) : the_post();
		if ( counter_is_blog() ) {
			get_template_part( 'template-parts/content' );
		} elseif ( is_search() ) {
			get_template_part( 'template-parts/content', 'search' );
		} else {
			get_template_part( 'template-parts/content' );
		}
	endwhile;
}
