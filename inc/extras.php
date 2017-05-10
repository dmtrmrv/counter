<?php
/**
 * Custom functions independent of the theme templates
 *
 * @package Counter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function counter_body_classes( $classes ) {

	// No Primary Menu Case.
	if ( ! has_nav_menu( 'primary' ) ) {
		$classes[] = 'no-primary-menu';
	}

	// Adds default blog layout class if default layout is chosen.
	if ( ( counter_is_blog() || is_archive() ) && 'default' == get_theme_mod( 'blog_layout', 'default' ) ) {
		$classes[] = 'counter-blog-default';
	}

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = 'is-sidebar';
	}

	// Add class if the site title and tagline is hidden.
	if ( 0 == get_theme_mod( 'header_text', 1 ) ) {
		$classes[] = 'title-tagline-hidden';
	}

	// Adds class to all single pages regardless of template.
	if ( is_page() && ! is_front_page() ) {
		$classes[] = 'single-page';
	}

	if ( is_front_page() && ! is_home() ) {
		$classes[] = 'front-page';
	}

	// Adds a class with a number of active footer widget areas.
	if ( 2 <= counter_footer_widget_areas_count() ) {
		$classes[] = 'footer-columns';
		$classes[] = 'footer-columns-' . esc_attr( counter_footer_widget_areas_count() );
	}

	// Adds a class for default pagination. A.k.a if Jetpack infinite scroll is disabled.
	if ( ! class_exists( 'Jetpack' ) || class_exists( 'Jetpack' ) && ! Jetpack::is_module_active( 'infinite-scroll' ) ) :
		$classes[] = 'default-pagination';
	endif;

	// Adds classes to the first and the last pages during pagination.
	global $wp_query;
	if ( ! is_singular() ) {
		if ( ! $wp_query->get( 'paged' ) ) {
			$classes[] = 'paged-first';
		} elseif ( $wp_query->get( 'paged' ) == $wp_query->max_num_pages ) {
			$classes[] = 'paged-last';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'counter_body_classes' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes An array of post classes.
 * @param array $class   An array of additional classes added to the post.
 * @param int   $post_id The post ID.
 */
function counter_post_classes( $classes, $class, $post_id ) {
	// Adds a class to a post that has no content.
	if ( ! get_post_field( 'post_content', $post_id ) ) {
		$classes[] = 'no-content';
	}
	return $classes;
}
add_filter( 'post_class', 'counter_post_classes', 10, 3 );

/**
 * Prints layout-specific class.
 */
function counter_blog_layout_class() {
	$layout = get_theme_mod( 'blog_layout' );
	if ( 'grid' == $layout ) {
		$classes[] = 'counter-post-grid';
		$classes[] = 'counter-grid';
	}

	if ( ! empty( $classes ) ) {
		echo esc_attr( join( ' ', $classes ) );
	}
}
/**
 * Detects blog index page.
 */
function counter_is_blog() {
	if ( is_front_page() && is_home() ) {
		return true;
	} elseif ( is_front_page() ) {
		return false;
	} elseif ( is_home() ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Render the site title for the selective refresh partial.
 */
function counter_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function counter_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Returns filtered panel count.
 *
 * @return int Number of panels.
 */
function counter_get_panel_count() {
	return 4;
}

/**
 * Returns array of panel types.
 *
 * @return array Panel types for the fron page.
 */
function counter_get_panel_types() {
	return apply_filters( 'counter_panel_types', array(
		'center'    => __( 'Centered', 'counter' ),
		'fullwidth' => __( 'Fullwidth', 'counter' ),
		'left'      => __( 'Left', 'counter' ),
		'right'     => __( 'Right', 'counter' ),
	) );
}

/**
 * Outputs inline background style for each panel.
 *
 * @param string $i Panel number.
 */
function counter_panel_background( $i = 0 ) {
	// Collect the data for the background.
	$id           = get_theme_mod( 'panel_bg_image_' . $i );
	$repeat       = get_theme_mod( 'panel_bg_repeat_' . $i );
	$position     = get_theme_mod( 'panel_bg_position_' . $i );
	$size_type    = get_theme_mod( 'panel_bg_size_type_' . $i );
	$size_percent = get_theme_mod( 'panel_bg_size_' . $i );
	$opacity      = get_theme_mod( 'panel_bg_opacity_' . $i );

	// Get the image URL.
	$image = wp_get_attachment_image_url( $id, 'counter-panel-2x' );

	/*
	 * Return if no image or if opacity is set to zero. Note the strict
	 * comparison. If it hasn't been set yet the value will be equal to false.
	 * This	will prevent the background to display even if it is defined.
	 * Just stick with the strict comparison.
	 */
	if ( ! $image || 0 === $opacity ) {
		return;
	}

	if ( 'cover' == $size_type ) {
		$size = 'cover';
	} else if ( 'percent' == $size_type ) {
		$size = $size_percent ? $size_percent . '%' : '';
	} else {
		$size = '';
	}

	// Build the style string.
	$html = sprintf( 'background-image: url(%s); ', esc_url( $image ) );
	$html .= $repeat     ? sprintf( 'background-repeat: %s; ', $repeat ) : '';
	$html .= $position   ? sprintf( 'background-position: %s; ', $position ) : '';
	$html .= $size       ? sprintf( 'background-size: %s; ', $size ) : '';
	$html .= $opacity    ? sprintf( 'opacity: %s;', $opacity ) : '';

	echo 'style="' . esc_attr( $html ) . '"';
}

/**
 * Creates panel class string.
 *
 * @param int $num Number of the panel.
 */
function counter_panel_class( $num ) {
	// Check if we have a user-defined panel class.
	$class = get_theme_mod( 'panel_class_' . $num, '' );

	// Check background image id, and attachment.
	$bg_id         = get_theme_mod( 'panel_bg_image_' . $num );
	$bg_attachment = get_theme_mod( 'panel_bg_attachment_' . $num );

	if ( $bg_id && 'fixed' == $bg_attachment ) {
		$class .= ' panel-bg-fixed';
	}

	return $class;
}

/**
 * Filters the_category() to output HTML5 valid rel tag.
 *
 * @param string $text markup containing list of categories.
 */
function counter_category_rel( $text ) {
	$search  = array( 'rel="category"', 'rel="category tag"' );
	$replace = 'rel="tag"';
	$text    = str_replace( $search, $replace, $text );
	return $text;
}
add_filter( 'the_category', 'counter_category_rel' );

/**
 * Checks if current page is the front page and not the blog.
 *
 * @return boolean True if it is the front page.
 */
function counter_is_front_page() {
	if ( is_front_page() && ! is_home() ) {
		return true;
	}
}

/**
 * Returns true if the front page template is not used.
 */
function counter_not_front_page() {
	if ( ! is_front_page() ) {
		return true;
	}
}

/**
 * Calculates active footer widget areas.
 */
function counter_footer_widget_areas_count() {
	$num = 0;
	for ( $i = 2; $i <= 5 ; $i++ ) {
		if ( is_active_sidebar( 'sidebar-' . $i ) ) {
			$num++;
		}
	}
	return $num;
}

/**
 * Better excerpt.
 */
function counter_excerpt_more() {
	$html = sprintf( '... <a href="%s">', get_the_permalink() ); // WPCS: XSS OK.
	/* Translators: %s: the post title. */
	$html .= sprintf( __( 'Continue reading %s', 'counter' ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ); // WPCS: XSS OK.
	$html .= '</a>';

	return $html;
}
add_filter( 'excerpt_more', 'counter_excerpt_more' );
