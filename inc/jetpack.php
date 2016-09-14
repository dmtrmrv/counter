<?php
/**
 * Jetpack Compatibility File
 *
 * @package Owner
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function owner_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'posts_per_page' => get_option( 'posts_per_page', 9 ),
		'footer_widgets' => array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' ),
		'container'      => 'primary',
		'wrapper'        => false,
		'render'         => 'owner_infinite_scroll_render',
		'footer'         => false,
	) );
}
if ( ! is_customize_preview() ) {
	add_action( 'after_setup_theme', 'owner_jetpack_setup' );
}

/**
 * Loads necessary template part during infinite scroll.
 */
function owner_infinite_scroll_render() {
	while ( have_posts() ) : the_post();
		if ( owner_is_blog() ) {
			get_template_part( 'template-parts/content', get_theme_mod( 'blog_layout' ) );
		} elseif ( is_search() ) {
			get_template_part( 'template-parts/content', 'search' );
		} else {
			get_template_part( 'template-parts/content' );
		}
	endwhile;
}
