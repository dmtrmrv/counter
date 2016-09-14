<?php
/**
 * Subtitles Compatibility File
 *
 * @package Counter
 */

/**
 * Adds a class to a post that has a subtitle.
 *
 * @param array $classes An array of post classes.
 * @param array $class   An array of additional classes added to the post.
 * @param int   $post_id The post ID.
 */
function counter_subtitles_post_classes( $classes, $class, $post_id ) {
	if ( get_the_subtitle( $post_id ) ) {
		$classes[] = 'has-subtitle';
	}
	return $classes;
}
add_filter( 'post_class', 'counter_subtitles_post_classes', 10, 3 );

/**
 * Display subtitles in all cases. Handle the rest with CSS.
 */
function counter_subtitles_mod_supported_views() {
	return true;
}
add_filter( 'subtitle_view_supported', 'counter_subtitles_mod_supported_views' );

// Remove default styling.
remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
