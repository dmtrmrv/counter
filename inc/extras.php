<?php
/**
 * Custom functions independent of the theme templates
 *
 * @package Owner
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function owner_body_classes( $classes ) {

	// No Primary Menu Case.
	if ( ! has_nav_menu( 'primary' ) ) {
		$classes[] = 'no-primary-menu';
	}

	// Adds default blog layout class if default layout is chosen.
	if ( ( owner_is_blog() || is_archive() ) && 'default' == get_theme_mod( 'blog_layout', 'default' ) ) {
		$classes[] = 'owner-blog-default';
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

	// Adds a class when site title is displayed.
	if ( get_theme_mod( 'display_title' ) ) {
		$classes[] = 'is-site-title';
	}

	// Adds a class when site tagline is displayed.
	if ( get_theme_mod( 'display_tagline' ) ) {
		$classes[] = 'is-site-tagline';
	}

	// Adds class to all single pages regardless of template.
	if ( is_page() && ! is_page_template( 'templates/front.php' ) ) {
		$classes[] = 'single-page';
	}

	// Adds a class of front-page if front-page.php is used.
	if ( is_page_template( 'templates/front.php' ) ) {
		$classes[] = 'front-page';
	}

	// Adds a class with a number of active footer widget areas.
	if ( 2 <= owner_footer_widget_areas_count() ) {
		$classes[] = 'footer-columns';
		$classes[] = 'footer-columns-' . esc_attr( owner_footer_widget_areas_count() );
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
add_filter( 'body_class', 'owner_body_classes' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes An array of post classes.
 * @param array $class   An array of additional classes added to the post.
 * @param int   $post_id The post ID.
 */
function owner_post_classes( $classes, $class, $post_id ) {
	// Adds a class to a post that has no content.
	if ( ! get_post_field( 'post_content', $post_id ) ) {
		$classes[] = 'no-content';
	}
	return $classes;
}
add_filter( 'post_class', 'owner_post_classes', 10, 3 );

/**
 * Prints layout-specific class.
 */
function owner_blog_layout_class() {
	$layout = get_theme_mod( 'blog_layout' );
	if ( 'grid' == $layout ) {
		$classes[] = 'owner-post-grid';
		$classes[] = 'owner-grid';
	}

	if ( ! empty( $classes ) ) {
		echo esc_attr( join( ' ', $classes ) );
	}
}
/**
 * Detects blog index page.
 */
function owner_is_blog() {
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
 * Returns array of panel types.
 *
 * @return array Panel types for the fron page.
 */
function owner_get_panel_types() {
	return apply_filters( 'owner_panel_types', array(
		'center'    => __( 'Centered', 'owner' ),
		'fullwidth' => __( 'Fullwidth', 'owner' ),
		'left'      => __( 'Left', 'owner' ),
		'right'     => __( 'Right', 'owner' ),
	) );
}

/**
 * Outputs panel alignment classes.
 *
 * @param int $num The number of the panel.
 */
function owner_panel_alignment_class( $num ) {
	$class = '';

	// Title alignment.
	switch ( get_theme_mod( 'panel_title_alignment_' . $num ) ) {
		case 'center':
			$class .= 'panel-title-align-center ';
			break;

		case 'right':
			$class .= 'panel-title-align-right ';
			break;
	}

	// Text alignment.
	switch ( get_theme_mod( 'panel_text_alignment_' . $num ) ) {
		case 'center':
			$class .= 'panel-align-center';
			break;

		case 'right':
			$class .= 'panel-align-right';
			break;
	}

	return $class;
}

/**
 * Outputs inline background style for each panel.
 *
 * @param string $i Panel number.
 */
function owner_panel_background_image( $i = '' ) {
	// Return quickly if no panel number is set.
	if ( ! $i ) {
		return;
	}

	// Collect the data for the background.
	$id           = get_theme_mod( 'panel_bg_image_' . $i );
	$repeat       = get_theme_mod( 'panel_bg_repeat_' . $i );
	$position     = get_theme_mod( 'panel_bg_position_' . $i );
	$attachment   = get_theme_mod( 'panel_bg_attachment_' . $i );
	$size_type    = get_theme_mod( 'panel_bg_size_type_' . $i );
	$size_percent = get_theme_mod( 'panel_bg_size_' . $i );
	$opacity      = get_theme_mod( 'panel_bg_opacity_' . $i );

	// Try to get the image URL.
	$image = wp_get_attachment_image_url( $id, 'owner-panel-full' );

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
	$html .= $attachment ? sprintf( 'background-attachment: %s; ', $attachment ) : '';
	$html .= $size       ? sprintf( 'background-size: %s; ', $size ) : '';
	$html .= $opacity    ? sprintf( 'opacity: %s;', $opacity ) : '';

	echo 'style="' . esc_attr( $html ) . '"';
}

/**
 * Filters the_category() to output HTML5 valid rel tag.
 *
 * @param string $text markup containing list of categories.
 */
function owner_category_rel( $text ) {
	$search  = array( 'rel="category"', 'rel="category tag"' );
	$replace = 'rel="tag"';
	$text    = str_replace( $search, $replace, $text );
	return $text;
}
add_filter( 'the_category', 'owner_category_rel' );

/**
 * Convert HEX to RGB.
 *
 * @param  string $color The original color, in 3 or 6-digit hexadecimal form.
 * @return array         Array containing RGB (red, green, and blue) values
 *                       for the given HEX code, empty array otherwise.
 */
function owner_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) == 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) == 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Returns true if the front page template is used.
 */
function owner_is_front_page() {
	if ( is_page_template( 'templates/front.php' ) ) {
		return true;
	}
}

/**
 * Returns true if the front page template is not used.
 */
function owner_not_front_page() {
	if ( ! is_page_template( 'templates/front.php' ) ) {
		return true;
	}
}

/**
 * Calculates active footer widget areas.
 */
function owner_footer_widget_areas_count() {
	$num = 0;
	for ( $i = 1; $i <= 5; $i++ ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
			$num++;
		}
	}
	return $num;
}

/**
 * Better excerpt look.
 */
function owner_excerpt_more() {
	return ' ...';
}
add_filter( 'excerpt_more', 'owner_excerpt_more' );

/**
 * Replace Contact Form 7 spinner icon.
 */
function owner_wpcf7_ajax_loader() {
	return network_site_url( '/wp-admin/images/spinner-2x.gif' );
}
add_filter( 'wpcf7_ajax_loader', 'owner_wpcf7_ajax_loader' );

/**
 * Adds an admin notice if theme license is not active.
 */
if ( is_admin() && ! owner_is_active_license() ) {
	add_action( 'admin_notices', 'owner_license_admin_notice', 99 );
}

/**
 * Checks if theme license is active.
 */
function owner_is_active_license() {
	$status = get_option( 'owner_license_key_status' );
	if ( ! $status || 'valid' != $status ) {
		return false;
	}
	return true;
}

/**
 * Displays an admin notice about inactive license.
 */
function owner_license_admin_notice() {
	$class   = esc_attr( 'notice notice-warning is-dismissible tp-license-notification' );
	$message = sprintf( esc_html__( 'Thanks for choosing %s! Please %sactivate%s the license key to get access to theme updates and support.', 'owner' ), 'Owner', '<a href="' . esc_url( admin_url( 'themes.php?page=owner-getting-started' ) ) . '">', '</a>' );

	printf( '<div class="%s"><p>%s</p></div>', $class, $message ); // WPCS: XSS OK.
}

if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' == $pagenow ) {
	wp_redirect( admin_url( 'admin.php?page=owner-getting-started' ) );
	exit;
}
