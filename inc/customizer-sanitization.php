<?php
/**
 * Set of sanitization functions used by the customizer
 *
 * @package Counter
 */

/**
 * Sanitizes Checkbox.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_checkbox( $input ) {
	if ( $input ) {
		return 1;
	}
	return 0;
}

/**
 * Sanitizes Image Upload.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_image( $input ) {
	$filetype = wp_check_filetype( $input );
	if ( $filetype['ext'] && wp_ext2type( $filetype['ext'] ) === 'image' ) {
		return esc_url( $input );
	}
	return '';
}

/**
 * Sanitizes Panel Layout.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_panel_layout( $input ) {
	$choices = counter_get_panel_types();
	if ( array_key_exists( $input, $choices ) ) {
		return $input;
	}
	return 'center';
}

/**
 * Sanitizes Panel Size Type.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_size_type( $input ) {
	$choices = array(
		'cover',
		'percent',
	);
	if ( in_array( $input, $choices ) ) {
		return $input;
	}
	return 'auto';
}

/**
 * Sanitizes Opacity Range.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_opacity_range( $input ) {
	if ( $input && is_numeric( $input ) ) {
		if ( 1 <= $input ) {
			return 1;
		} else {
			return abs( number_format( $input, 2 ) );
		}
	}
	return 1;
}

/**
 * Sanitizes Panel Background Repeat.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_repeat( $input ) {
	$choices = array(
		'repeat',
		'repeat-x',
		'repeat-y',
	);
	if ( in_array( $input, $choices ) ) {
		return $input;
	}
	return 'no-repeat';
}

/**
 * Sanitizes Panel Background Position.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_position( $input ) {
	$choices = array(
		'left center',
		'left bottom',
		'center top',
		'center center',
		'center bottom',
		'right top',
		'right center',
		'right bottom',
	);
	if ( in_array( $input, $choices ) ) {
		return $input;
	}
	return 'left top';
}

/**
 * Sanitizes background attachment.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_background_attachment( $input ) {
	if ( 'fixed' == $input ) {
		return $input;
	}
	return 'scroll';
}

/**
 * Returns filtered panel count.
 *
 * @return int Number of panels.
 */
function counter_get_panel_count() {
	return apply_filters( 'counter_panel_count', 4 );
}

/**
 * Sanitizes Panel Layout.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_blog_layout( $input ) {
	if ( 'grid' == $input ) {
		return $input;
	}
	return 'default';
}

/**
 * Sanitizes Meta Items.
 *
 * @param string $input potentially dangerous data.
 */
function counter_sanitize_meta_items( $input ) {
	$choices = array(
		'cat-links',
		'posted-on',
		'byline',
		'comments-link',
	);

	$values = ! is_array( $input ) ? explode( ',', $input ) : $input;

	foreach ( $values as $k => $v ) {
		if ( ! in_array( $v, $choices ) ) {
			unset( $values[ $k ] );
		}
	}

	return $values;
}

/**
 * Sanitizes the name of the color scheme.
 *
 * @param string $value potentially dangerous data.
 */
function counter_sanitize_color_scheme( $value ) {
	$color_schemes = counter_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default';
	}

	return $value;
}
